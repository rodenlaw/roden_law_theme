<?php
/**
 * Question-intent CTR batch, 2026-11-10: SEO title + meta description on two posts.
 *
 * Evidence (Search Console API, sc-domain:rodenlaw.com, 2026-08-09 → 2026-11-06,
 * question-word query filter, non-brand):
 *   1749 /blog/fault-vs-no-fault-car-insurance/          251 question queries,
 *        9,607 impr, 13 clicks; the "is georgia a no fault state" family at pos ~5
 *        with 0–4 clicks. The <title> never said "Georgia".
 *   4537 /blog/myrtle-beach-dangerous-roads-intersections/  "why is myrtle beach so
 *        dangerous" 9,310 impr, 14 clicks, pos 8.8. The <title> did not answer it.
 *
 * Only _roden_meta_title (the <title>) and _roden_meta_description change.
 * post_title (the H1), body, excerpt, FAQs and key takeaways are untouched.
 * Every claim in the new copy is already on the page (key takeaways / excerpt).
 *
 * Both posts are moved to `excluded` in docs/gsc-2026-10-06/cohorts.json (owner,
 * 2026-11-10) so the freshness benchmark is not credited with a CTR change.
 *
 * Idempotent. update_post_meta() unslashes, so wp_slash() — see CLAUDE.md.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/apply-question-ctr-titles-2026-11-10.php
 *   ssh $H "wp --path=$P eval-file - apply" < bin/apply-question-ctr-titles-2026-11-10.php
 */
if ( ! defined( 'ABSPATH' ) ) { fwrite( STDERR, "Run through wp eval-file.\n" ); exit( 1 ); }
$mode = isset( $args[0] ) ? $args[0] : 'dry-run';

$batch = array(
	1749 => array(
		'slug'  => 'fault-vs-no-fault-car-insurance',
		'title' => 'Is Georgia a No-Fault State? GA & SC Fault Rules Explained',
		'desc'  => 'No. Georgia and South Carolina are both at-fault states: the at-fault driver pays. What that means for your claim, and how shared fault reduces recovery.',
	),
	4537 => array(
		'slug'  => 'myrtle-beach-dangerous-roads-intersections',
		'title' => 'Why Are Myrtle Beach Roads So Dangerous? What the Data Shows',
		'desc'  => 'Horry County ranked 4th of 46 SC counties for crashes and 3rd for fatal crashes in 2024. The roads and intersections behind it, and your rights after a wreck.',
	),
);

$fail = 0;
foreach ( $batch as $id => $b ) {
	$p = get_post( $id );
	if ( ! $p || $p->post_name !== $b['slug'] || 'publish' !== $p->post_status ) {
		echo "FAIL $id: post missing, slug mismatch or not published\n"; $fail++; continue;
	}
	foreach ( array( '_roden_meta_title' => $b['title'], '_roden_meta_description' => $b['desc'] ) as $key => $val ) {
		$cur = (string) get_post_meta( $id, $key, true );
		if ( $cur === $val ) { echo "OK   $id $key already set\n"; continue; }
		echo ( 'apply' === $mode ? 'SET  ' : 'WOULD' ) . " $id $key\n      was: " . ( '' === $cur ? '(empty)' : $cur ) . "\n      now: $val\n";
		if ( 'apply' === $mode ) {
			update_post_meta( $id, $key, wp_slash( $val ) );
			if ( (string) get_post_meta( $id, $key, true ) !== $val ) { echo "FAIL $id $key read-back mismatch\n"; $fail++; }
		}
	}
	if ( 'apply' === $mode ) { clean_post_cache( $id ); }
}
exit( $fail ? 1 : 0 );
