<?php
/**
 * Export the load-bearing content meta to deterministic JSON.
 *
 * WHY THIS EXISTS
 * ---------------
 * The theme is version-controlled and drift-guarded. The database is not, and
 * that is where the damage keeps happening. Workers' comp pages carried the
 * TORT statute of limitations in _roden_sol_ga / _roden_sol_sc: found and fixed
 * on the English posts 2026-07-30, then found again on the Spanish twins on
 * 2026-07-31 — three weeks later, and only because someone happened to open a
 * Spanish page for an unrelated reason. A committed file showing
 * "2 años (O.C.G.A. § 9-3-33)" on a workers' comp page would have surfaced that
 * in a diff both times.
 *
 * This deliberately does NOT export post content. Bodies are ~8 MB of prose
 * across 474 posts; nobody reviews that diff, and a nightly `wp db export` is
 * the right protection for them. What is here is the small structured subset
 * that encodes legal and SEO facts.
 *
 * DETERMINISM MATTERS. CI diffs this against the committed copy, so the output
 * must be byte-identical between runs when nothing changed: keys sorted, posts
 * sorted, no timestamp, no post IDs as identity (they are unstable across
 * environments — permalink path is the key).
 *
 * Run:  ssh <prod> "wp --path=<site> eval-file -" < bin/export-content-meta.php
 * Or:   wp eval-file bin/export-content-meta.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}

/**
 * Post types whose meta carries legal or SEO weight.
 *
 * `post` and `page` were added 2026-08-25, after a false workers' compensation
 * filing deadline was found living in `_roden_faqs` on a blog post. The body of
 * that page had just been corrected and a sweep of post_content came back
 * clean; the claim survived because it was in the FAQ meta, and blog posts were
 * outside this export entirely.
 *
 * That is precisely the failure this file exists to catch — a legal fact
 * changing in the database, where nothing is versioned and nobody sees a diff —
 * and the guard was watching three post types while 195 FAQ-carrying pages
 * (162 posts, 33 pages) sat outside it. FAQ answers also render into FAQPage
 * structured data, so a wrong one is published twice over.
 *
 * Cost measured before making the change: 533 -> 1,064 entries, 2.03 -> 2.74 MB.
 */
$types = array( 'practice_area', 'location', 'resource', 'post', 'page' );

/**
 * Meta keys worth versioning.
 *
 * Excluded on purpose: anything derived at render time (the resolver computes
 * deadlines from firm-data.php, which IS versioned), anything that churns
 * without meaning, and free-text body-adjacent fields large enough to drown
 * the diff.
 */
$keys = array(
	'_roden_jurisdiction',
	'_roden_state_scope',
	'_roden_sol_ga',
	'_roden_sol_sc',
	'_roden_author_attorney',
	'_roden_last_reviewed',
	'_roden_meta_description',
	'_roden_accident_phrase',
	'_roden_pa_office_key',
	'_roden_locale',
	'_roden_translation_of',
	'_roden_translation_es',
	'_roden_subtype_hidden',
	'_roden_faqs',
	// Added 2026-08-25. `_roden_key_takeaways` renders as the summary box above
	// the article — the first thing a reader sees — and it is where nine
	// previously-removed statistics were still living after the bodies and the
	// FAQs had both been corrected.
	//
	// It nearly escaped a second time: a sweep of the exported file for those
	// figures reported ZERO, because the field was not in this list. A sweep
	// that cannot see a field does not say "unknown" — it says zero. The live
	// pages disagreed, which is the only reason it surfaced.
	//
	// It is prose and it is "body-adjacent", which is why it was excluded. But
	// it is short, it is edited rarely, and it makes factual claims in bold. It
	// belongs in the diff.
	'_roden_key_takeaways',

	// Glossary definitions, added 2026-09-03 with the Track C bounded test.
	// They are short, they are prose, and they make STATUTORY claims — the
	// punitive-damages entry names both the O.C.G.A. and S.C. Code caps. A
	// definition is exactly the shape of content that gets copied to another
	// page and goes stale there, and roden_schema_defined_term_set() publishes
	// it as DefinedTerm structured data, so a wrong one is published twice over.
	// Whitelisted on the same day the key was created, rather than three weeks
	// later by accident, which is how _roden_key_takeaways got here.
	'_roden_glossary_terms',
);

$posts = get_posts( array(
	'post_type'        => $types,
	'post_status'      => array( 'publish', 'draft' ),
	'posts_per_page'   => -1,
	'orderby'          => 'ID',
	'order'            => 'ASC',
	'suppress_filters' => true,
) );

$out = array();

foreach ( $posts as $p ) {
	// Permalink path, not ID: IDs differ between environments and renumber on
	// restore, but the path is what the public actually depends on.
	$path = wp_make_link_relative( get_permalink( $p ) );
	if ( ! $path ) {
		$path = '/?p=' . $p->ID;
	}

	$meta = array();

	foreach ( $keys as $k ) {
		$v = get_post_meta( $p->ID, $k, true );

		if ( '' === $v || null === $v || array() === $v ) {
			continue;
		}

		if ( '_roden_faqs' === $k ) {
			// FAQs are where wrong legal answers hide — a claim that Georgia's
			// maximum weekly benefit is "set annually by the State Board" sat in
			// one of these until 2026-07-31. Export them in full so the text is
			// reviewable, normalised to question/answer pairs.
			if ( ! is_array( $v ) ) {
				continue;
			}
			$faqs = array();
			foreach ( $v as $faq ) {
				if ( ! is_array( $faq ) ) {
					continue;
				}
				$faqs[] = array(
					'question' => isset( $faq['question'] ) ? (string) $faq['question'] : '',
					'answer'   => isset( $faq['answer'] ) ? (string) $faq['answer'] : '',
				);
			}
			if ( $faqs ) {
				$meta[ $k ] = $faqs;
			}
			continue;
		}

		// _roden_translation_of / _es point at post IDs. Store the target's path
		// so the record survives a renumber and reads meaningfully in a diff.
		if ( '_roden_translation_of' === $k || '_roden_translation_es' === $k ) {
			$target = get_post( (int) $v );
			$meta[ $k ] = $target
				? wp_make_link_relative( get_permalink( $target ) )
				: '(missing post ' . (int) $v . ')';
			continue;
		}

		// Attorney attribution: the name is what a reviewer can check.
		if ( '_roden_author_attorney' === $k ) {
			$atty = get_post( (int) $v );
			$meta[ $k ] = $atty ? $atty->post_title : '(missing attorney ' . (int) $v . ')';
			continue;
		}

		$meta[ $k ] = is_scalar( $v ) ? (string) $v : $v;
	}

	if ( ! $meta ) {
		continue; // Nothing load-bearing on this post.
	}

	ksort( $meta );

	// `excerpt` is a posts-table column rather than meta, and it is here for the
	// same reason `_roden_key_takeaways` is: roden_schema_article() renders it as
	// the Article `description`, so a false claim in it is published as
	// structured data. Two pages kept a superlative there ("the most dangerous
	// intersection in South Carolina", on pages whose own bodies said it ranked
	// second) after their bodies, FAQs and takeaways had all been corrected. It
	// was the fourth surface found in one sweep, and the last one nothing
	// watched.
	$record = array(
		'type'    => $p->post_type,
		'status'  => $p->post_status,
		'title'   => $p->post_title,
		'excerpt' => $p->post_excerpt,
		'meta'    => $meta,
	);

	// Collision would mean two posts resolve to one URL — worth seeing, not
	// worth silently dropping one.
	if ( isset( $out[ $path ] ) ) {
		$path .= '#dup-' . $p->ID;
	}

	$out[ $path ] = $record;
}

ksort( $out );

// No generated-at timestamp: this file is diffed by CI and must be stable when
// nothing changed.
$doc = array(
	'_note'  => 'Generated by bin/export-content-meta.php. Do not hand-edit — regenerate.',
	'_types' => $types,
	'_count' => count( $out ),
	'posts'  => $out,
);

echo wp_json_encode(
	$doc,
	JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
) . "\n";
