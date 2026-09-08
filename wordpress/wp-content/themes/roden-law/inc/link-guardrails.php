<?php
/**
 * Link guardrails — normalise internal link shapes that are always wrong.
 *
 * SEPARATE FROM content-guardrails.php ON PURPOSE. That file gates which PAGE
 * TYPES may be published and demotes an offending post to draft. This one never
 * blocks anything: it repairs a link target that has exactly one correct form,
 * silently, on save. Blocking a publish over a href typo would be the wrong
 * trade for an editor, and a draft-demotion notice would not tell them which
 * link was at fault.
 *
 * THE HABIT THIS CLOSES. A site-wide link audit on 2026-09-04 resolved all 802
 * internal link targets against production and found 23 dead. Eighty-two of the
 * 156 resulting rewrites -- more than half -- were practice-area pillars linked
 * WITHOUT the /practice-areas/ prefix:
 *
 *     href="/brain-injury-lawyers/"              404
 *     href="/practice-areas/brain-injury-lawyers/"   correct
 *
 * Eleven distinct pillars, across pages written by different hands at different
 * times. Fixing the 82 links did nothing to stop the eighty-third.
 *
 * WHY A BLIND REWRITE IS SAFE HERE, AND ONLY HERE. Three facts, each verified
 * against production on 2026-09-08 before this file was written:
 *
 *   1. All 24 pillars live at /practice-areas/{slug}/. None is published at the
 *      bare root.
 *   2. No bare root /{slug}/ serves a page. Twenty-one are hard 404s; three --
 *      wrongful-death, product-liability and workers-compensation -- already 301
 *      to the prefixed form. Rewriting the link is right in both cases: it fixes
 *      the 404s and removes a redirect hop from the other three.
 *   3. The path must be EXACTLY the bare root. /car-accident-lawyers/ is wrong,
 *      but /car-accident-lawyers/rideshare-uber-accident/ (a sub-type) and
 *      /car-accident-lawyers/charleston-sc/ (a city permutation) are correct and
 *      must not be touched. 318 published children depend on that distinction.
 *
 * A prefix-match rewrite would have destroyed all 318. The trailing-slash-then-
 * end-of-value anchor is the whole safety argument.
 *
 * SCOPE. post_content only. FAQ answers and key takeaways carry links too, but
 * they are meta saved on a different path; bin/fix-dead-internal-links.php
 * sweeps those and is the right tool for a periodic pass. A filter that tried to
 * cover both would have to guess at meta shapes that differ per post.
 */

/**
 * The 24 practice-area pillar slugs, resolved from the database.
 *
 * Not a hard-coded list: a twenty-fifth pillar should be protected the day it is
 * published, without anyone remembering this file exists. Cached per request
 * because wp_insert_post_data can fire several times in one save.
 *
 * @return string[] Pillar slugs, e.g. 'brain-injury-lawyers'.
 */
function roden_pillar_slugs() {
	static $slugs = null;
	if ( null !== $slugs ) {
		return $slugs;
	}

	$slugs = array();

	$pillars = get_posts( array(
		'post_type'        => 'practice_area',
		'post_status'      => 'publish',
		'numberposts'      => -1,
		'post_parent'      => 0,
		'fields'           => 'ids',
		'suppress_filters' => true,
	) );

	foreach ( $pillars as $id ) {
		$path = wp_make_link_relative( get_permalink( $id ) );

		// Only /practice-areas/{slug}/ — two segments, first is the archive base.
		$seg = array_values( array_filter( explode( '/', trim( (string) $path, '/' ) ) ) );
		if ( 2 === count( $seg ) && 'practice-areas' === $seg[0] ) {
			$slugs[] = $seg[1];
		}
	}

	return $slugs;
}

/**
 * Rewrite bare pillar roots to their /practice-areas/ form.
 *
 * Matches the complete href VALUE, not a path prefix — see the file header for
 * why that is the entire safety argument. Handles the root-relative form and
 * both absolute forms, and the JSON-escaped variant so the same function can be
 * reused by a meta sweeper.
 *
 * @param string $html Markup that may contain links.
 * @return string Markup with bare pillar roots corrected.
 */
function roden_normalize_pillar_links( $html ) {
	if ( ! is_string( $html ) || '' === $html || false === strpos( $html, '-lawyers/' ) ) {
		return $html;
	}

	foreach ( roden_pillar_slugs() as $slug ) {
		$bare = '/' . $slug . '/';
		$good = '/practice-areas/' . $slug . '/';

		$forms = array(
			'href="' . $bare . '"'                          => 'href="' . $good . '"',
			"href='" . $bare . "'"                          => "href='" . $good . "'",
			'href="https://rodenlaw.com' . $bare . '"'      => 'href="https://rodenlaw.com' . $good . '"',
			'href="http://rodenlaw.com' . $bare . '"'       => 'href="http://rodenlaw.com' . $good . '"',
			'href=\\"' . $bare . '\\"'                      => 'href=\\"' . $good . '\\"',
			'href=\\"https://rodenlaw.com' . $bare . '\\"'  => 'href=\\"https://rodenlaw.com' . $good . '\\"',
		);

		$html = strtr( $html, $forms );
	}

	return $html;
}

/**
 * Normalise pillar links in post_content as the post is saved.
 *
 * Runs for every post type: the habit is not confined to one. Revisions and
 * autosaves are skipped so the repair lands on the row that gets published
 * rather than on a snapshot of it.
 *
 * @param array $data Sanitised post data about to be written.
 * @return array
 */
function roden_guard_pillar_links( $data ) {
	if ( empty( $data['post_content'] ) ) {
		return $data;
	}
	if ( ! empty( $data['post_type'] ) && in_array( $data['post_type'], array( 'revision', 'attachment' ), true ) ) {
		return $data;
	}

	$data['post_content'] = roden_normalize_pillar_links( $data['post_content'] );

	return $data;
}
add_filter( 'wp_insert_post_data', 'roden_guard_pillar_links', 20 );
