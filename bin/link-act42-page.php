<?php
/**
 * Point the South Carolina alcohol-liability pages at the Act 42 resource.
 *
 * WHY THIS IS A SCRIPT AND NOT A FROZEN PATCH
 * -------------------------------------------
 * The target page is seeded as a DRAFT for attorney review. Twenty-two pages
 * cannot link to it until it is published, or every one of those links points at
 * a page the public cannot see. So this cannot be applied in the same pass that
 * created the page, and a patch file written today would be stale by the time it
 * could run.
 *
 * Instead this finds its own insertion point at run time: the paragraph on each
 * page that already discusses dram-shop or over-serving liability. That is where
 * a reader's next question actually is, and it survives ordinary editing of the
 * pages in a way a byte-exact anchor would not.
 *
 * THE FIRST GUARD IS THE POINT. It refuses to run while the target is a draft.
 *
 * SCOPE — TEN PAGES, NOT TWENTY-TWO.
 *
 * The Act 42 audit found 22 South Carolina and two-state pages touching alcohol
 * liability. Linking all 22 was the original plan and it is wrong. Twelve of them
 * mention over-serving once or twice, as one bullet in a list of possible
 * defendants; a pointer to a statute-change page from there is noise, and
 * indiscriminate internal linking is the habit this whole recovery has been
 * unwinding.
 *
 * The cut is objective, not a matter of taste. A page qualifies if EITHER:
 *   - a heading on the page names dram-shop or alcohol-service liability, or
 *   - the topic appears six or more times across body, FAQs and takeaways.
 *
 * Qualifying, with the evidence:
 *   4787  16 mentions  h: "Punitive Damages and Dram-Shop Liability"
 *   4360  22 mentions  h: "Dram Shop Liability: Holding Bars and Restaurants Accountable"
 *   4083  10 mentions  h: "Punitive Damages and Dram Shop Liability"
 *   4177   9 mentions  h: "Dram Shop and Social Host Liability"
 *   4189   7 mentions  h: "Dram Shop Liability"
 *   4729  13 mentions
 *   4764  10 mentions
 *   4048   8 mentions
 *   4076   8 mentions
 *   4344   6 mentions
 *
 * Excluded, with their counts, so the decision is reviewable rather than silent:
 *   4707(5) 4711(4) 4723(4) 4717(2) 4099(2) 4144(3) 1724(3) 4342(3) 4355(3)
 *   4215(1) 4221(1) 1686(1)
 *
 * Five Georgia-only pages are absent for a different and harder reason: they
 * discuss Georgia's own dram-shop statute, Act 42 is South Carolina law, and
 * adding it to them would be a new error rather than a fix. Do not widen this
 * list in either direction without redoing the count.
 *
 * NOTHING HERE IS A CORRECTION. The audit found no page that Act 42 makes false.
 * These pages are accurate and incomplete; this adds the missing pointer.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/link-act42-page.php   # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/link-act42-page.php
 *
 * Writes post_content directly so post_modified is not stamped, and sets
 * `_roden_last_refreshed` — the same reasoning as bin/apply-stat-remediation.php.
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );

const ACT42_SLUG = 'south-carolina-liquor-liability-2026';
const ACT42_PATH = '/resources/south-carolina-liquor-liability-2026/';

/** See the SCOPE note above. Ten pages, chosen by an objective test. */
$TARGETS = array(
	4787, 4360, 4083, 4177, 4189,   // a heading names the topic
	4729, 4764, 4048, 4076, 4344,   // six or more mentions
);

/* ---- Guard 1: the target must be published ---- */
$target = get_page_by_path( ACT42_SLUG, OBJECT, 'resource' );
if ( ! $target ) {
	fprintf( $err, "ABORT: %s does not exist.\n", ACT42_PATH );
	exit( 1 );
}
if ( 'publish' !== $target->post_status ) {
	fprintf( $err, "ABORT: %s is '%s', not published.\n", ACT42_PATH, $target->post_status );
	fprintf( $err, "       Linking pages to an unpublished page is the defect this guard exists to prevent.\n" );
	fprintf( $err, "       Publish post %d after attorney review, then re-run.\n", $target->ID );
	exit( 1 );
}
fprintf( $err, "target: %s (post %d, published)\n\n", ACT42_PATH, $target->ID );

$SENTENCE = 'South Carolina changed these rules for claims arising after 1 January 2026. '
	. 'The 2025 Act narrowed the alcohol exception in S.C. Code &sect; 15-38-15 and created &sect; 61-2-147, '
	. 'under which an establishment can be jointly and severally liable for fifty percent of a plaintiff&#8217;s '
	. 'actual damages where a verdict is returned against both it and a driver charged with DUI &mdash; '
	. '<a href="' . ACT42_PATH . '">what South Carolina&#8217;s 2026 liquor liability law changed</a>.';

global $wpdb;
$today = current_time( 'Y-m-d' );
fprintf( $err, "%s — %d page(s)\n\n", $apply ? 'APPLY' : 'DRY RUN', count( $TARGETS ) );

$done = 0; $skipped = 0; $unmatched = array();
foreach ( $TARGETS as $id ) {
	$post = get_post( $id );
	if ( ! $post instanceof WP_Post || 'publish' !== $post->post_status ) {
		fprintf( $err, "  ABORT: post %d missing or unpublished.\n", $id );
		exit( 1 );
	}

	$content = $post->post_content;

	if ( false !== strpos( $content, ACT42_PATH ) ) {
		fprintf( $err, "  skip  %-5d %s (already links)\n", $id, $post->post_name );
		$skipped++;
		continue;
	}

	// Where to insert, and the three things that can go wrong.
	//
	// (1) NOT inside the paragraph. On several of these pages the topic lives in
	//     a <li>, and appending to a list item reads as part of that bullet.
	//     Close the block first, then add a paragraph. Correct in both shapes.
	//
	// (2) NOT the last keyword hit. It is usually in the closing call to action,
	//     where the pointer would land after "no fee unless we win your case".
	//     Hits in the final 15% are skipped.
	//
	// (3) NOT inside embedded JSON-LD. 90 published pages carry a
	//     <script type="application/ld+json"> block inside post_content, and
	//     three of the ten targets are among them. Inserting HTML there corrupts
	//     the structured data silently. Checked, not assumed.
	//
	// The block must also actually contain the keyword. A proximity window was
	// tried first and picked up an office-address paragraph that merely sat near
	// one; containment is the real requirement.

	$ld = array();
	if ( preg_match_all( '#<script[^>]*application/ld\+json[^>]*>.*?</script>#is', $content, $lm, PREG_OFFSET_CAPTURE ) ) {
		foreach ( $lm[0] as $blk ) {
			$ld[] = array( $blk[1], $blk[1] + strlen( $blk[0] ) );
		}
	}
	$in_ld = function ( $offset ) use ( $ld ) {
		foreach ( $ld as $r ) {
			if ( $offset >= $r[0] && $offset <= $r[1] ) { return true; }
		}
		return false;
	};

	if ( ! preg_match_all( '/(dram[ -]?shop|over-?serv|serving alcohol|visibly intoxicated)/i', $content, $m, PREG_OFFSET_CAPTURE ) ) {
		$unmatched[] = $id . ':' . $post->post_name . ':no-keyword';
		continue;
	}

	$len = strlen( $content );
	$at  = null;
	for ( $i = count( $m[0] ) - 1; $i >= 0; $i-- ) {
		$pos = $m[0][ $i ][1];
		if ( $pos > $len * 0.85 ) { continue; }
		if ( $in_ld( $pos ) ) { continue; }

		foreach ( array( 'p', 'ul', 'ol' ) as $t ) {
			$close = stripos( $content, "</$t>", $pos );
			if ( false === $close ) { continue; }
			$open = strripos( substr( $content, 0, $pos ), "<$t" );
			if ( false === $open ) { continue; }
			$block = substr( $content, $open, $close - $open );
			if ( ! preg_match( '/(dram[ -]?shop|over-?serv|serving alcohol|visibly intoxicated)/i', $block ) ) { continue; }
			if ( false !== stripos( $block, "</$t>" ) ) { continue; }
			$candidate = $close + strlen( "</$t>" );
			if ( $in_ld( $candidate ) ) { continue; }
			$at = $candidate;
			break 2;
		}
	}
	if ( null === $at ) {
		$unmatched[] = $id . ':' . $post->post_name . ':needs-manual-placement';
		continue;
	}

	$new = substr( $content, 0, $at ) . "\n\n<p>" . $SENTENCE . "</p>" . substr( $content, $at );

	fprintf( $err, "  %-5s %-5d %-46s  +%d chars\n", $apply ? 'edit' : 'would',
		$id, substr( $post->post_name, 0, 46 ), strlen( $new ) - strlen( $content ) );

	if ( ! $apply ) { continue; }

	$ok = $wpdb->update( $wpdb->posts, array( 'post_content' => $new ), array( 'ID' => $id ), array( '%s' ), array( '%d' ) );
	if ( false === $ok ) {
		fprintf( $err, "        FAILED db write on %d\n", $id );
		exit( 1 );
	}
	update_post_meta( $id, '_roden_last_refreshed', $today );
	clean_post_cache( $id );

	if ( false === strpos( get_post( $id )->post_content, ACT42_PATH ) ) {
		fprintf( $err, "        FAILED read-back on %d\n", $id );
		exit( 1 );
	}
	$done++;
}

fprintf( $err, "\n%s: %d page(s), %d already linked\n", $apply ? 'Linked' : 'Would link', $done, $skipped );
if ( $unmatched ) {
	// Reported, never silently dropped — a page with no alcohol-liability
	// paragraph may not belong on the target list at all.
	fprintf( $err, "NO INSERTION POINT FOUND (%d): %s\n", count( $unmatched ), implode( ', ', $unmatched ) );
	fprintf( $err, "  Place these by hand or drop them from \$TARGETS — do not loosen the pattern to catch them.\n" );
}
if ( $apply ) {
	fprintf( $err, "_roden_last_refreshed set to %s. post_modified untouched.\n", $today );
	fprintf( $err, "Next: flush both caches, then verify a rendered page.\n" );
}
