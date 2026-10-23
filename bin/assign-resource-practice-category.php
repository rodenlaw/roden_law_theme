<?php
/**
 * Add the existing practice_category term to on-topic resources. APPEND ONLY:
 * no existing term is removed (south-carolina-law stays where it is).
 * Writes the practice_category taxonomy only: no post_content, no post meta.
 *
 *   M=docs/practice-category/resource-map-2026-10-23.json
 *   ssh $H "wp --path=/home/wpe-user/sites/rodenlawprod eval-file - b64:$(base64 < $M)"       < bin/assign-resource-practice-category.php
 *   ssh $H "wp --path=/home/wpe-user/sites/rodenlawprod eval-file - b64:$(base64 < $M) apply" < bin/assign-resource-practice-category.php
 *
 * Rollback: save the BACKUP-JSON line printed by 'apply' to a file B, then
 *   ssh $H "wp ... eval-file - b64:$(base64 < B) rollback"        < bin/assign-resource-practice-category.php   # dry run
 *   ssh $H "wp ... eval-file - b64:$(base64 < B) rollback apply"  < bin/assign-resource-practice-category.php
 * Rollback removes only the terms this script added, and only while the post
 * still carries exactly what the apply left on it.
 *
 * Map: { "map": [ { "post_id": 4839, "slug": "south-carolina-workers-comp-body-part-values",
 *                   "current": ["south-carolina-law"], "add": ["workers-compensation"],
 *                   "add_term_ids": [671] }, ... ] }
 *
 * WHY. Intersections and sub-types list resources in their pillar's
 * practice_category. Only car-accidents and truck-accidents were on any
 * published resource, so once the pillars get their terms
 * (bin/assign-pillar-practice-category.php) five intersections and 109
 * sub-types would show no guides, although on-topic guides exist. Owner
 * decision 2026-10-23: tag the resources first, then the pillars.
 * Simulation: data/site-health/remediation-2026-10-23.md.
 *
 * ORDER. 1) deploy the single-resource.php sidebar fix shipped with this
 * script, 2) this script, 3) the pillar script, 4) flush both caches. 'apply'
 * reads the live theme and refuses without the sidebar fix: without it an
 * SC-law guide that gains a term sorting before "South Carolina Law" switches
 * its sidebar to that topic.
 *
 * GUARDS
 *  - Published `resource` posts only; the slug must match the row.
 *  - Terms by ID only: each add_term_ids[i] must be an existing
 *    practice_category term whose slug is add[i]. Nothing is created.
 *  - The post's current terms must equal the row's "current" (sorted), or
 *    already include every added term ("same"). Anything else refuses: the
 *    post was retagged since the map was made.
 *  - append=true on practice_category only; no other taxonomy is touched.
 *  - BACKUP-JSON is printed before anything is written; every post is read
 *    back from a cleared term cache afterwards.
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}

$raw      = (string) ( $args[0] ?? '' );
$apply    = in_array( 'apply', $args, true );
$rollback = in_array( 'rollback', $args, true );
echo ( $rollback ? 'ROLLBACK ' : '' ) . ( $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (add 'apply' to write) ===\n\n" );
if ( 0 === strpos( $raw, 'b64:' ) ) {
	$raw = base64_decode( substr( $raw, 4 ) );
} elseif ( $raw && is_readable( $raw ) ) {
	$raw = file_get_contents( $raw );
}
$doc  = json_decode( $raw, true );
$rows = is_array( $doc ) && isset( $doc['map'] ) ? $doc['map'] : $doc;
if ( ! is_array( $rows ) || ! $rows ) {
	echo "No map: pass b64:<json> or a readable path.\n";
	return;
}

$tax = 'practice_category';

// The sidebar fix this depends on (see ORDER above), read from the live file.
$td      = get_template_directory();
$markers = array(
	'single-resource.php: sidebar keeps south-carolina-law'     => array( '/single-resource.php', "in_array( 'south-carolina-law', \$res_cat_terms, true )" ),
	'single-resource.php: sidebar falls back when topic is empty' => array( '/single-resource.php', "\$res_guide_args['cat_slug'] = '';" ),
);
$missing = array();
echo "Theme prerequisites:\n";
foreach ( $markers as $label => list( $file, $needle ) ) {
	$src = is_readable( $td . $file ) ? file_get_contents( $td . $file ) : '';
	$ok  = false !== strpos( $src, $needle );
	if ( ! $ok ) {
		$missing[] = $label;
	}
	printf( "  %s %s\n", $ok ? 'ok     ' : 'MISSING', $label );
}
echo "\n";

$slugs_of = function ( $id ) use ( $tax ) {
	clean_object_term_cache( $id, 'resource' );
	$t = wp_get_object_terms( $id, $tax, array( 'fields' => 'slugs', 'orderby' => 'slug' ) );
	return is_wp_error( $t ) ? null : $t;
};
$sorted = function ( $a ) {
	$a = array_values( array_map( 'strval', (array) $a ) );
	sort( $a );
	return $a;
};

$todo = array();
$seen = array();
foreach ( $rows as $r ) {
	$id   = absint( $r['post_id'] ?? 0 );
	$slug = (string) ( $r['slug'] ?? '' );
	$post = $id ? get_post( $id ) : null;
	$tag  = sprintf( '[%d] %s', $id, $slug );

	if ( isset( $seen[ $id ] ) ) {
		echo "  REFUSE $tag: listed twice\n";
		continue;
	}
	$seen[ $id ] = true;
	if ( ! $post || 'resource' !== $post->post_type || 'publish' !== $post->post_status ) {
		echo "  REFUSE $tag: not a published resource\n";
		continue;
	}
	if ( $slug !== $post->post_name ) {
		echo "  REFUSE $tag: post slug is '{$post->post_name}'\n";
		continue;
	}
	$have = $slugs_of( $id );
	if ( null === $have ) {
		echo "  REFUSE $tag: could not read current terms\n";
		continue;
	}

	if ( $rollback ) {
		// A BACKUP-JSON row: { post_id, slug, current: <after apply>, restore: <before apply> }.
		if ( ! isset( $r['current'], $r['restore'] ) || ! is_array( $r['current'] ) || ! is_array( $r['restore'] ) ) {
			echo "  REFUSE $tag: rollback rows need 'current' and 'restore' (use the BACKUP-JSON line)\n";
			continue;
		}
		$restore = $sorted( $r['restore'] );
		if ( $have === $restore ) {
			printf( "  same   %s: already %s\n", $tag, $have ? implode( ',', $have ) : '(none)' );
			continue;
		}
		if ( $have !== $sorted( $r['current'] ) ) {
			printf( "  REFUSE %s: carries %s, backup says %s (retagged since apply)\n", $tag, implode( ',', $have ) ?: '(none)', implode( ',', $sorted( $r['current'] ) ) );
			continue;
		}
		$extra = array_values( array_diff( $have, $restore ) );
		if ( array_diff( $restore, $have ) ) {
			printf( "  REFUSE %s: restore names a term the post does not carry; this script only removes\n", $tag );
			continue;
		}
		$ids = array();
		foreach ( $extra as $s ) {
			$o = get_term_by( 'slug', $s, $tax );
			if ( ! $o ) {
				printf( "  REFUSE %s: '%s' is not a %s term\n", $tag, $s, $tax );
				continue 2;
			}
			$ids[] = (int) $o->term_id;
		}
		$todo[ $id ] = array( 'tag' => $tag, 'before' => $have, 'remove' => $ids, 'want' => $restore );
		printf( "  remove %s: %s -> %s\n", $tag, implode( ',', $have ), $restore ? implode( ',', $restore ) : '(none)' );
		continue;
	}

	$add     = array_values( (array) ( $r['add'] ?? array() ) );
	$add_ids = array_values( array_map( 'intval', (array) ( $r['add_term_ids'] ?? array() ) ) );
	if ( ! $add || count( $add ) !== count( $add_ids ) ) {
		echo "  REFUSE $tag: 'add' and 'add_term_ids' must be non-empty and the same length\n";
		continue;
	}
	$terms = array();
	foreach ( $add_ids as $i => $tid ) {
		$o = $tid ? get_term( $tid, $tax ) : null;
		if ( ! $o || is_wp_error( $o ) || $o->slug !== (string) $add[ $i ] ) {
			printf( "  REFUSE %s: term id %d is not the existing %s term '%s' (this script creates none)\n", $tag, $tid, $tax, $add[ $i ] );
			continue 2;
		}
		$terms[] = $o;
	}
	$want = $sorted( array_merge( $have, wp_list_pluck( $terms, 'slug' ) ) );
	$want = array_values( array_unique( $want ) );
	if ( $want === $have ) {
		printf( "  same   %s: already %s\n", $tag, implode( ',', $have ) );
		continue;
	}
	if ( ! array_key_exists( 'current', $r ) || $have !== $sorted( $r['current'] ) ) {
		printf( "  REFUSE %s: carries %s, map expected %s (retagged since the map was made)\n", $tag, $have ? implode( ',', $have ) : '(none)', isset( $r['current'] ) ? ( implode( ',', $sorted( $r['current'] ) ) ?: '(none)' ) : '(no current in row)' );
		continue;
	}
	$todo[ $id ] = array( 'tag' => $tag, 'before' => $have, 'add' => wp_list_pluck( $terms, 'term_id' ), 'want' => $want );
	printf( "  add    %s: %s -> %s\n", $tag, $have ? implode( ',', $have ) : '(none)', implode( ',', $want ) );
}
printf( "\n%d to %s.\n", count( $todo ), $rollback ? 'roll back' : 'tag' );
if ( ! $todo || ! $apply ) {
	if ( $missing && ! $rollback ) {
		echo "\nNOTE: 'apply' will refuse until the theme prerequisites above are deployed.\n";
	}
	return;
}
if ( $missing && ! $rollback ) {
	echo "\nREFUSED: the live theme lacks the prerequisites marked MISSING. Deploy the theme changes first.\n";
	return;
}

// Term counts the change touches, before.
$term_ids = array();
foreach ( $todo as $t ) {
	foreach ( array_merge( $t['add'] ?? array(), $t['remove'] ?? array() ) as $tid ) {
		$o = get_term( $tid, $tax );
		if ( $o && ! is_wp_error( $o ) ) {
			$term_ids[ (int) $tid ] = $o->slug;
		}
	}
}
$counts = function () use ( $term_ids, $tax ) {
	$c = array();
	foreach ( $term_ids as $tid => $s ) {
		clean_term_cache( $tid, $tax );
		$o       = get_term( $tid, $tax );
		$c[ $s ] = $o && ! is_wp_error( $o ) ? (int) $o->count : null;
	}
	return $c;
};
$count_before = $counts();

if ( ! $rollback ) {
	$backup = array();
	foreach ( $todo as $id => $t ) {
		$backup[] = array( 'post_id' => $id, 'slug' => get_post_field( 'post_name', $id ), 'current' => $t['want'], 'restore' => $t['before'] );
	}
	echo "\nBACKUP-JSON (rollback map: pass it back with 'rollback'): " . wp_json_encode( array( 'map' => $backup ) ) . "\n";
}

$failed = 0;
foreach ( $todo as $id => $t ) {
	$res = $rollback
		? wp_remove_object_terms( $id, $t['remove'], $tax )
		: wp_set_object_terms( $id, $t['add'], $tax, true ); // append: existing terms stay.
	if ( is_wp_error( $res ) || false === $res ) {
		$failed++;
		printf( "  ERROR %s: %s\n", $t['tag'], is_wp_error( $res ) ? $res->get_error_message() : 'write returned false' );
	}
	clean_post_cache( $id );
}

echo "\n--- VERIFY ---\n";
$bad = 0;
foreach ( $todo as $id => $t ) {
	$now = $slugs_of( $id );
	$ok  = $now === $t['want'];
	$bad += $ok ? 0 : 1;
	printf( "  %s %s: %s -> %s\n", $ok ? 'ok   ' : 'WRONG', $t['tag'], $t['before'] ? implode( ',', $t['before'] ) : '(none)', $now ? implode( ',', $now ) : '(none)' );
}
echo "\nTerm counts (stored count; WordPress recounts published objects on write):\n";
$count_after = $counts();
foreach ( $count_before as $s => $n ) {
	printf( "  %-28s %s -> %s\n", $s, var_export( $n, true ), var_export( $count_after[ $s ], true ) );
}
printf( "\n%d of %d done%s.\nDone.\n", count( $todo ) - $bad, count( $todo ), $failed ? ", $failed write errors" : '' );
