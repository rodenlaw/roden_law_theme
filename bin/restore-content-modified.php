<?php
/**
 * Backfill `_roden_content_modified` — the date each page's title or visible
 * text last changed — 2026-10-15.
 *
 * `post_modified` moves on every database write. The href-only redirect and
 * internal-link rewrites of 2026-09-08/09 re-saved 274 published pages, and the
 * theme published that timestamp as the "Updated" byline, every `dateModified`
 * and `article:modified_time`: 2016–2019 posts claimed a September 2026 update
 * with nothing in them changed. The theme now reads roden_content_modified_ts()
 * (inc/template-tags.php) — reviewed / refreshed / this meta, else the publish
 * date, never post_modified. This script fills the meta from evidence.
 *
 * Evidence is the revision history, compared on TITLE + VISIBLE TEXT (tags
 * stripped, entities decoded, whitespace collapsed), so saves that only touched
 * hrefs, markup or the excerpt do not count as changes. Per published page:
 *
 *   text-changed       the current text first appears in a revision saved after
 *                      an earlier, different one → that revision's date.
 *   unrevisioned       the current text differs from the newest revision, so
 *                      the last write changed it without saving a revision →
 *                      post_modified.
 *   predates-history   the text matches every revision back to the oldest one
 *                      kept (history starts 2026-08-17) → it last changed before
 *                      then, on a date nothing records → LEFT UNSET; the page
 *                      falls back to its publish date.
 *   no-revisions       → post_modified if it is before the first BULK_DAYS
 *                      date, else LEFT UNSET (no evidence either way).
 *   already-set        meta present → untouched.
 *
 * Owner decision 2026-10-15: drop a date that cannot be supported rather than
 * keep a false one. The cost, accepted: a substantive change that left the
 * visible text alone — a corrected FAQ answer or Key Takeaways box lives in
 * post meta, which has no revisions — earns no date here. Set
 * `_roden_last_reviewed` on those pages; it outranks this meta.
 *
 * Why not "the revision before the bulk write": the first dry run did that and
 * put 125 pages on 2026-09-02 — the B1 excerpt sweep, 205 pages re-saved that
 * day. Same false signal, one week earlier.
 *
 *   ssh $H "wp --path=$P eval-file -" < bin/restore-content-modified.php \
 *     > docs/backups/content-modified-$(date +%Y-%m-%d).tsv          # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/restore-content-modified.php \
 *     > docs/backups/content-modified-$(date +%Y-%m-%d).tsv          # apply
 *
 * Writes post meta only; post_modified is left as the true record of the last
 * database write. The output TSV is the undo list: on apply, every row with a
 * value was a page that had no meta before.
 */

const BULK_DAYS = array( '2026-09-08', '2026-09-09' );
const TYPES     = array( 'post', 'resource', 'practice_area', 'location', 'page' );
const META_KEY  = '_roden_content_modified';

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — %s backfill\n\n", $apply ? 'APPLY' : 'DRY RUN', META_KEY );

$norm = static function ( $title, $content ) {
	$plain = html_entity_decode( wp_strip_all_tags( $title . ' ' . $content ), ENT_QUOTES );
	return trim( preg_replace( '/\s+/u', ' ', $plain ) );
};

global $wpdb;
$in    = "'" . implode( "','", array_map( 'esc_sql', TYPES ) ) . "'";
$posts = $wpdb->get_results( "SELECT ID, post_type, post_title, post_content, post_date_gmt, post_modified_gmt FROM {$wpdb->posts} WHERE post_status = 'publish' AND post_type IN ($in) ORDER BY ID" );
$first = min( BULK_DAYS );

$tally = array();
$days  = array();

echo "ID\ttype\tclass\tcontent_modified\tpost_modified\tpublished\tpermalink\n";
foreach ( $posts as $p ) {
	if ( '' !== (string) get_post_meta( $p->ID, META_KEY, true ) ) {
		$tally['already-set'] = ( $tally['already-set'] ?? 0 ) + 1;
		continue;
	}

	$cur  = $norm( $p->post_title, $p->post_content );
	$revs = $wpdb->get_results( $wpdb->prepare(
		"SELECT post_title, post_content, post_modified_gmt FROM {$wpdb->posts} WHERE post_parent = %d AND post_type = 'revision' ORDER BY post_modified_gmt DESC, ID DESC",
		$p->ID
	) );

	$value = '';
	if ( ! $revs ) {
		$class = 'no-revisions';
		if ( substr( $p->post_modified_gmt, 0, 10 ) < $first ) {
			$value = $p->post_modified_gmt;
		}
	} elseif ( $norm( $revs[0]->post_title, $revs[0]->post_content ) !== $cur ) {
		$class = 'unrevisioned';
		$value = $p->post_modified_gmt;
	} else {
		$class = 'predates-history';
		foreach ( $revs as $r ) {
			if ( $norm( $r->post_title, $r->post_content ) !== $cur ) {
				$class = 'text-changed';
				break;
			}
			$value = $r->post_modified_gmt;
		}
		if ( 'predates-history' === $class ) {
			$value = '';
		}
	}

	$tally[ $class ] = ( $tally[ $class ] ?? 0 ) + 1;
	if ( '' !== $value ) {
		$days[ substr( $value, 0, 10 ) ] = ( $days[ substr( $value, 0, 10 ) ] ?? 0 ) + 1;
	}

	echo implode( "\t", array( $p->ID, $p->post_type, $class, $value, $p->post_modified_gmt, $p->post_date_gmt, get_permalink( $p->ID ) ) ) . "\n";

	// update_post_meta() unslashes; a GMT datetime has no backslash, but the rule is the rule.
	if ( $apply && '' !== $value ) {
		update_post_meta( $p->ID, META_KEY, wp_slash( $value ) );
	}
}

fprintf( $err, "published pages: %d\n", count( $posts ) );
ksort( $tally );
foreach ( $tally as $k => $n ) {
	fprintf( $err, "  %-17s %d\n", $k, $n );
}

arsort( $days );
fprintf( $err, "\ndates written, most common first (a big cluster is a sweep, not an edit — check it):\n" );
foreach ( array_slice( $days, 0, 12, true ) as $d => $n ) {
	fprintf( $err, "  %s  %d%s\n", $d, $n, in_array( $d, BULK_DAYS, true ) ? '  (BULK_DAYS)' : '' );
}
fprintf( $err, "\n%s\n", $apply ? 'Applied.' : 'Dry run — nothing written. Re-run with `eval-file - apply`.' );
