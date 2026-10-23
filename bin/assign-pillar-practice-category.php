<?php
/**
 * Give the top-level practice-area pillars their practice_category term.
 * Writes the practice_category taxonomy only: no post_content, no post meta.
 *
 *   M=docs/practice-category/pillar-map-2026-10-23.json
 *   ssh $H "wp --path=/home/wpe-user/sites/rodenlawprod eval-file - b64:$(base64 < $M)"       < bin/assign-pillar-practice-category.php
 *   ssh $H "wp --path=/home/wpe-user/sites/rodenlawprod eval-file - b64:$(base64 < $M) apply" < bin/assign-pillar-practice-category.php
 *
 * Map: { "map": [ { "post_id": 3604, "slug": "car-accident-lawyers", "term": "car-accidents" }, ... ] }
 * (a bare array of rows is accepted too).
 *
 * WHY. Intersection and sub-type pages read their resource list's topic from
 * the parent pillar's practice_category term. None of the main pillars had one,
 * so intersections listed local but off-topic guides (the Charleston workers'
 * comp page listed the Charleston County court PI-claim guide) and 97 sub-types
 * showed no resources block at all (site-health 2026-10-23, #250). Owner
 * decision 2026-10-23: assign the existing terms. Simulation and expected
 * effect per template: data/site-health/remediation-2026-10-23.md.
 *
 * ORDER. Apply only after the theme changes shipped with this script are live
 * (roden_case_results_grid() practice_category fallback, the pillar template's
 * blog/guides queries, the sub-type jurisdiction filter). Without them a pillar
 * term replaces real case results with the hardcoded fallback cards and removes
 * the pillar's blog block. 'apply' checks for them in the live theme and
 * refuses if they are missing.
 *
 * GUARDS
 *  - Existing terms only. A term is passed by ID, so wp_set_object_terms()
 *    cannot create one from a slug; an unknown slug refuses the row.
 *  - Top-level, published practice_area posts only, and the slug must match
 *    the row (a renumbered or renamed post fails closed).
 *  - A post that already has a different practice_category term (or several)
 *    is refused unless the row names exactly what it replaces:
 *    { ..., "term": "x", "from": "y" } goes through only while the post
 *    carries exactly 'y'. "term": null with a matching "from" clears it (this
 *    is how a BACKUP-JSON line is turned back into a rollback map).
 *  - append=false on practice_category only; no other taxonomy is touched.
 *  - Prior terms are printed as BACKUP-JSON before anything is written, and
 *    every post is read back from a cleared term cache afterwards.
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}

$raw   = (string) ( $args[0] ?? '' );
$apply = in_array( 'apply', $args, true );
echo $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (add 'apply' to write) ===\n\n";
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

// The theme changes this depends on (see ORDER above), read from the live files.
$td      = get_template_directory();
$markers = array(
	'inc/template-tags.php: case-result grid drops an unmatched practice_category' => array( '/inc/template-tags.php', "'practice_category' !== \$clause['taxonomy']" ),
	'templates/template-practice-area.php: blog block ignores practice_category'    => array( '/templates/template-practice-area.php', 'Blog posts are not in the practice_category taxonomy' ),
	'templates/template-practice-area.php: guides box falls back when empty'         => array( '/templates/template-practice-area.php', '$resource_unfiltered' ),
	'templates/template-subtype.php: sub-type list keeps to the page state'          => array( '/templates/template-subtype.php', "'jurisdiction_of' => \$post_id" ),
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
	clean_object_term_cache( $id, 'practice_area' );
	$t = wp_get_object_terms( $id, $tax, array( 'fields' => 'slugs', 'orderby' => 'slug' ) );
	return is_wp_error( $t ) ? null : $t;
};

$todo = array();
$seen = array();
foreach ( $rows as $r ) {
	$id   = absint( $r['post_id'] ?? 0 );
	$slug = (string) ( $r['slug'] ?? '' );
	$want = array_key_exists( 'term', $r ) && null === $r['term'] ? null : (string) ( $r['term'] ?? '' );
	$post = $id ? get_post( $id ) : null;
	$tag  = sprintf( '[%d] %s', $id, $slug );

	if ( isset( $seen[ $id ] ) ) {
		echo "  REFUSE $tag: listed twice\n";
		continue;
	}
	$seen[ $id ] = true;
	if ( ! $post || 'practice_area' !== $post->post_type || 'publish' !== $post->post_status || $post->post_parent ) {
		echo "  REFUSE $tag: not a published top-level practice_area\n";
		continue;
	}
	if ( $slug !== $post->post_name ) {
		echo "  REFUSE $tag: post slug is '{$post->post_name}'\n";
		continue;
	}
	if ( '' === $want ) {
		echo "  REFUSE $tag: no term (use \"term\": null with \"from\" to clear one)\n";
		continue;
	}
	$term = null;
	if ( null !== $want ) {
		$term = get_term_by( 'slug', $want, $tax );
		if ( ! $term ) {
			echo "  REFUSE $tag: '$want' is not an existing $tax term (this script creates none)\n";
			continue;
		}
	}
	$have = $slugs_of( $id );
	if ( null === $have ) {
		echo "  REFUSE $tag: could not read current terms\n";
		continue;
	}
	$want_list = $term ? array( $term->slug ) : array();
	if ( $have === $want_list ) {
		printf( "  same   %s: already %s\n", $tag, $have ? implode( ',', $have ) : '(none)' );
		continue;
	}
	$from = isset( $r['from'] ) ? (string) $r['from'] : null;
	if ( ! $have && null !== $from ) {
		printf( "  REFUSE %s: map's from '%s' does not match (the post has no term)\n", $tag, $from );
		continue;
	}
	if ( $have ) {
		if ( null === $from || array( $from ) !== $have ) {
			printf( "  REFUSE %s: carries %s, map says %s%s\n", $tag, implode( ',', $have ), $term ? $term->slug : '(none)',
				null === $from ? ' (add "from" to replace it deliberately)' : " (map's from '$from' does not match)" );
			continue;
		}
	} elseif ( null === $term ) {
		printf( "  REFUSE %s: nothing to clear\n", $tag );
		continue;
	}
	$todo[ $id ] = array( 'tag' => $tag, 'before' => $have, 'term' => $term );
	printf( "  set    %s: %s -> %s\n", $tag, $have ? implode( ',', $have ) : '(none)', $term ? $term->slug : '(none)' );
}
printf( "\n%d to set.\n", count( $todo ) );
if ( ! $todo || ! $apply ) {
	if ( $missing ) {
		echo "\nNOTE: 'apply' will refuse until the theme prerequisites above are deployed.\n";
	}
	return;
}
if ( $missing ) {
	echo "\nREFUSED: the live theme lacks the prerequisites marked MISSING. Deploy the theme changes first.\n";
	return;
}

// Term counts the change touches, before.
$term_ids = array();
foreach ( $todo as $t ) {
	if ( $t['term'] ) {
		$term_ids[ $t['term']->term_id ] = $t['term']->slug;
	}
	foreach ( $t['before'] as $s ) {
		$o = get_term_by( 'slug', $s, $tax );
		if ( $o ) {
			$term_ids[ $o->term_id ] = $o->slug;
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

$backup = array();
foreach ( $todo as $id => $t ) {
	$backup[] = array( 'post_id' => $id, 'slug' => get_post_field( 'post_name', $id ), 'term' => $t['before'] ? $t['before'][0] : null, 'from' => $t['term'] ? $t['term']->slug : null, 'all_prior' => $t['before'] );
}
echo "\nBACKUP-JSON (a rollback map for this script): " . wp_json_encode( array( 'map' => $backup ) ) . "\n";

$failed = 0;
foreach ( $todo as $id => $t ) {
	$res = wp_set_object_terms( $id, $t['term'] ? array( (int) $t['term']->term_id ) : array(), $tax, false );
	if ( is_wp_error( $res ) ) {
		$failed++;
		printf( "  ERROR %s: %s\n", $t['tag'], $res->get_error_message() );
	}
	clean_post_cache( $id );
}

echo "\n--- VERIFY ---\n";
$bad = 0;
foreach ( $todo as $id => $t ) {
	$now  = $slugs_of( $id );
	$want = $t['term'] ? array( $t['term']->slug ) : array();
	$ok   = $now === $want;
	$bad += $ok ? 0 : 1;
	printf( "  %s %s: %s -> %s\n", $ok ? 'ok   ' : 'WRONG', $t['tag'], $t['before'] ? implode( ',', $t['before'] ) : '(none)', $now ? implode( ',', $now ) : '(none)' );
}
echo "\nTerm counts (stored count; WordPress recounts published objects on write):\n";
$count_after = $counts();
foreach ( $count_before as $s => $n ) {
	printf( "  %-28s %s -> %s\n", $s, var_export( $n, true ), var_export( $count_after[ $s ], true ) );
}
printf( "\n%d of %d set%s.\nDone.\n", count( $todo ) - $bad, count( $todo ), $failed ? ", $failed write errors" : '' );
