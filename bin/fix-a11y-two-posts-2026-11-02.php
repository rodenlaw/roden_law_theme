<?php
/**
 * Two body-markup accessibility fixes from site-health (report 2026-10-26).
 * The owner approved them 2026-11-02. They are minor markup edits: no wording
 * changes and no claims touched.
 *
 *   ssh $H "wp --path=/home/wpe-user/sites/rodenlawprod eval-file -"       < bin/fix-a11y-two-posts-2026-11-02.php
 *   ssh $H "wp --path=/home/wpe-user/sites/rodenlawprod eval-file - apply" < bin/fix-a11y-two-posts-2026-11-02.php
 *
 * 1851 /blog/much-worth-ga-worker-compared-states/  TABLE_NO_TH
 *   The body-part table's first row is plain <td>. That row becomes a <thead>
 *   of <th scope="col">, and each row's first cell becomes <th scope="row">.
 *   Cell text is unchanged.
 *
 * 1784 /blog/workers-compensation-faqs/  WEAK_ALT
 *   walking-assistant-blog.jpg has alt="Walker ". It becomes a description
 *   of the photo.
 *
 * Each edit must match exactly once, or the script skips that post. Writes go
 * through wp_slash() (see CLAUDE.md, Gotchas). Afterwards, run
 * bin/check-unslashed-post-writes.php and flush both caches.
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
echo $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (pass 'apply' to write) ===\n\n";

$backups = array();

function roden_a11y_write( $id, $before, $after, $apply, &$backups ) {
	if ( $before === $after ) {
		echo "    no change\n";
		return;
	}
	if ( ! $apply ) {
		return;
	}
	$backups[ $id ] = $before;
	$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $after ) ), true );
	if ( is_wp_error( $r ) ) {
		echo '    ERROR: ' . $r->get_error_message() . "\n";
		return;
	}
	clean_post_cache( $id );
	$now = get_post_field( 'post_content', $id, 'raw' );
	echo '    verify: ' . ( $now === $after ? 'ok' : 'MISMATCH' ) . "\n";
}

/* ---- 1851: table headers ---- */
$id   = 1851;
$p    = get_post( $id );
echo "[$id] " . ( $p ? $p->post_name : 'MISSING' ) . "\n";
if ( $p && 'much-worth-ga-worker-compared-states' === $p->post_name ) {
	$c = $p->post_content;
	$n = preg_match_all( '#<table\b[^>]*>.*?</table>#s', $c, $tables );
	$hits = array();
	foreach ( $tables[0] as $t ) {
		if ( false !== strpos( $t, 'Body Part' ) && false === stripos( $t, '<th' ) ) {
			$hits[] = $t;
		}
	}
	if ( 1 !== count( $hits ) ) {
		echo '    SKIP: expected 1 header-less "Body Part" table, found ' . count( $hits ) . " (of $n tables)\n";
	} else {
		$old = $hits[0];
		$new = $old;
		// First row -> thead with column headers.
		$new = preg_replace_callback(
			'#<tbody>(\s*)(<tr\b[^>]*>)(.*?)(</tr>)#s',
			function ( $m ) {
				$cells = preg_replace( '#<td\b([^>]*)>(.*?)</td>#s', '<th scope="col"$1>$2</th>', $m[3] );
				return '<thead>' . $m[1] . $m[2] . $cells . $m[4] . $m[1] . '</thead>' . $m[1] . '<tbody>';
			},
			$new,
			1,
			$cnt
		);
		// Body rows: first cell -> row header.
		$new = preg_replace_callback(
			'#(<tbody>)(.*?)(</tbody>)#s',
			function ( $m ) {
				$rows = preg_replace( '#(<tr\b[^>]*>\s*)<td\b([^>]*)>(.*?)</td>#s', '$1<th scope="row"$2>$3</th>', $m[2] );
				return $m[1] . $rows . $m[3];
			},
			$new,
			1
		);
		if ( 1 !== $cnt || ! preg_match( '#<th scope="col"[^>]*>\s*Body Part\s*</th>#', $new ) ) {
			echo "    SKIP: header row did not transform as expected\n";
		} else {
			$text = function ( $s ) { return preg_replace( '/\s+/', ' ', trim( wp_strip_all_tags( $s ) ) ); };
			if ( $text( $old ) !== $text( $new ) ) {
				echo "    SKIP: cell text would change\n";
			} else {
				echo "    - " . str_replace( "\n", ' ', substr( $old, 0, 220 ) ) . "...\n";
				echo "    + " . str_replace( "\n", ' ', substr( $new, 0, 260 ) ) . "...\n";
				echo '    th cells: ' . substr_count( $new, '<th ' ) . "\n";
				roden_a11y_write( $id, $c, str_replace( $old, $new, $c ), $apply, $backups );
			}
		}
	}
} else {
	echo "    SKIP: post missing or slug mismatch\n";
}

/* ---- 1784: alt text ---- */
$id  = 1784;
$p   = get_post( $id );
echo "\n[$id] " . ( $p ? $p->post_name : 'MISSING' ) . "\n";
if ( $p && 'workers-compensation-faqs' === $p->post_name ) {
	$c   = $p->post_content;
	$pat = '#(<img\b[^>]*walking-assistant-blog\.jpg[^>]*\balt=")Walker\s*(")#';
	$n   = preg_match_all( $pat, $c );
	if ( 1 !== $n ) {
		echo "    SKIP: expected 1 match for the walker image alt, found $n\n";
	} else {
		$alt   = 'Patient using a walker, steadied by a caregiver';
		$after = preg_replace( $pat, '${1}' . esc_attr( $alt ) . '${2}', $c, 1 );
		echo "    - alt=\"Walker \"\n    + alt=\"" . esc_attr( $alt ) . "\"\n";
		roden_a11y_write( $id, $c, $after, $apply, $backups );
	}
} else {
	echo "    SKIP: post missing or slug mismatch\n";
}

if ( $apply ) {
	echo "\nBACKUP-JSON: " . wp_json_encode( $backups ) . "\nDone. Now: check-unslashed-post-writes.php, wp cache flush, wp page-cache flush.\n";
} else {
	echo "\nDry run. Re-run with 'apply' to write.\n";
}
