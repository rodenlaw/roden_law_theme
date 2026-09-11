<?php
/**
 * Drop the unsourced place-rankings from two Ashley Phosphate / I-26 headlines
 * (resource 4664, post 4337).
 *
 * Both statistics rounds stripped the supporting evidence out of these pages'
 * bodies and left the ranking standing in the headline — the worst of both
 * states, because the assertion survives with its evidence removed. Post 4624,
 * the third page on the same interchange, was corrected on 2026-08-25; these two
 * were not.
 *
 * What the evidence actually supports. A Post and Courier analysis of
 * preliminary SCDPS data, 2011-2015, recorded 629 crashes at Ashley Phosphate
 * Road and I-26 — the most of any intersection in Berkeley, Charleston or
 * Dorchester counties, but SECOND statewide behind I-20 at US-176, and none of
 * the 629 was fatal (181 people were injured). Both pages already say exactly
 * that in their own key takeaways and FAQs. Their titles said otherwise.
 *
 *   #4664  "South Carolina's Deadliest Truck Intersection"
 *          Wrong twice over: not first in the state on the only published
 *          figures, and not deadly at all by them. There is also no truck-
 *          specific ranking anywhere in the source — the 629 figure is
 *          all-vehicle — so the superlative is replaced with nothing rather
 *          than restated, and the title takes the house pattern its siblings
 *          use ("Aviation Avenue & I-26 Truck Accidents in North Charleston",
 *          "Dorchester Road Truck Accidents in North Charleston").
 *
 *   #4337  "Inside the Most Dangerous Intersection in the Charleston Area"
 *          A near-twin of 4624's slug, one corridor, the same claim. This page
 *          carries 22 clicks / 3,591 impressions (GSC, 2026-08-24) — the most
 *          of the three — so the rewrite keeps every term the queries use
 *          (ashley phosphate road, I-26, intersection, dangerous, Charleston)
 *          and drops only the rank assertion.
 *
 * Slugs are deliberately NOT touched. Changing them costs a 301 and an
 * exact-match URL during an active recovery; the title and body are what a
 * reader sees. Recorded for the later URL-hygiene pass, per RECOVERY-LOG.md.
 *
 * Titles feed <title>, og:title, twitter:title, the breadcrumb and the schema
 * headline, so one write to post_title corrects all five surfaces.
 *
 * Run from the repo over stdin — never added to the theme:
 *   ssh rodenlawprod "wp --path=$P eval-file -"       < bin/fix-ashley-ranking-titles.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply" < bin/fix-ashley-ranking-titles.php
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

$apply = isset( $args[0] ) && 'apply' === $args[0];

$changes = array(
	4664 => array(
		'type'     => 'resource',
		'requires' => 'Deadliest Truck Intersection',
		'to'       => 'Ashley Phosphate Road &amp; I-26 Truck Accidents in North Charleston',
	),
	4337 => array(
		'type'     => 'post',
		'requires' => 'Most Dangerous Intersection in the Charleston Area',
		'to'       => 'Ashley Phosphate Road and I-26: Why This Charleston-Area Intersection Is So Dangerous',
	),
);

$backup = array();
$failed = false;

foreach ( $changes as $post_id => $spec ) {
	$post = get_post( $post_id );

	if ( ! $post ) {
		printf( "ABORT  #%d not found\n", $post_id );
		$failed = true;
		continue;
	}
	if ( $spec['type'] !== $post->post_type ) {
		printf( "ABORT  #%d is a %s, expected %s\n", $post_id, $post->post_type, $spec['type'] );
		$failed = true;
		continue;
	}
	// Match on the ranking phrase, not the whole string: apostrophes and
	// ampersands in the stored title are not worth an exact-equality trap.
	if ( false === stripos( $post->post_title, $spec['requires'] ) ) {
		printf( "SKIP   #%d title no longer contains \"%s\" — already changed?\n", $post_id, $spec['requires'] );
		printf( "       current: %s\n", $post->post_title );
		continue;
	}

	$backup[] = array(
		'ID'         => $post_id,
		'post_type'  => $post->post_type,
		'slug'       => $post->post_name,
		'post_title' => $post->post_title,
	);

	printf( "#%d (%s, /%s/)\n", $post_id, $post->post_type, $post->post_name );
	printf( "  from: %s\n", $post->post_title );
	printf( "  to:   %s\n", $spec['to'] );

	if ( ! $apply ) {
		continue;
	}

	// wp_update_post() unslashes what it is handed — always wp_slash().
	$res = wp_update_post(
		wp_slash(
			array(
				'ID'         => $post_id,
				'post_title' => $spec['to'],
			)
		),
		true
	);
	if ( is_wp_error( $res ) ) {
		printf( "  ERROR %s\n", $res->get_error_message() );
		$failed = true;
		continue;
	}

	$now = get_post( $post_id );
	if ( $now->post_title !== $spec['to'] ) {
		printf( "  ERROR title did not take: %s\n", $now->post_title );
		$failed = true;
		continue;
	}
	if ( $now->post_name !== $backup[ count( $backup ) - 1 ]['slug'] ) {
		printf( "  ERROR slug moved to %s — it must not\n", $now->post_name );
		$failed = true;
		continue;
	}
	printf( "  OK    written, slug unchanged (%s)\n", $now->post_name );
}

/*
 * A retitle strands any copy that quoted the old headline — anchor text on an
 * English and a Spanish post repeated this exact ranking once before. Report
 * every other surviving instance across bodies, excerpts, takeaways and FAQs.
 */
echo "\n-- other surviving instances of these rankings (report only) --\n";

global $wpdb;
$needles = array( 'Deadliest Truck Intersection', 'Most Dangerous Intersection in the Charleston Area' );
$found   = 0;

foreach ( $needles as $needle ) {
	$like = '%' . $wpdb->esc_like( $needle ) . '%';

	$rows = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT ID, post_type, post_name, 'post_content' AS field FROM {$wpdb->posts}
			  WHERE post_status = 'publish' AND post_content LIKE %s
			 UNION ALL
			 SELECT ID, post_type, post_name, 'post_excerpt' AS field FROM {$wpdb->posts}
			  WHERE post_status = 'publish' AND post_excerpt LIKE %s",
			$like,
			$like
		)
	);
	foreach ( $rows as $r ) {
		printf( "  %s  #%d /%s/ (%s)\n", $needle, $r->ID, $r->post_name, $r->field );
		$found++;
	}

	$meta = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT post_id, meta_key FROM {$wpdb->postmeta}
			  WHERE meta_key IN ( '_roden_faqs', '_roden_key_takeaways', '_roden_seo_title' )
			    AND meta_value LIKE %s",
			$like
		)
	);
	foreach ( $meta as $m ) {
		printf( "  %s  #%d meta %s\n", $needle, $m->post_id, $m->meta_key );
		$found++;
	}
}

if ( ! $found ) {
	echo "  none\n";
}

echo "\n-- backup (save to docs/backups/) --\n";
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "\n";

printf( "\n%s  %d page(s)%s\n", $apply ? 'APPLIED' : 'DRY RUN', count( $backup ), $apply ? '' : ' — re-run with: apply' );

if ( $failed ) {
	exit( 1 );
}
