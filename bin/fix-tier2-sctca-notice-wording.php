<?php
/**
 * Tier-2 §2.2 — the South Carolina Tort Claims Act described as imposing
 * "shorter notice deadlines" across the site.
 *
 * Tier 1 fixed the pages that said something FALSE about the Act. This fixes the
 * larger population that describes the right urgency by the wrong mechanism:
 * 64 instances in 29 distinct phrasings — "imposes shorter notice deadlines",
 * "have shorter notice requirements", "a much shorter notice deadline",
 * "carries shorter notice deadlines", "a 2-year notice requirement", and so on.
 *
 * THE ACT IMPOSES NO NOTICE REQUIREMENT AT ALL. It shortens the LIMITATION
 * period to two years (§ 15-78-110). Filing a verified claim is OPTIONAL
 * (§ 15-78-90(b): suit lies "whether or not the claim is filed"), must be filed
 * within one year if used (§ 15-78-80), and EXTENDS the deadline to three years.
 * The practical advice on these pages — act fast, confirm your deadline — is
 * sound. Only the mechanism is wrong.
 *
 * WHY THIS IS SENTENCE-SCOPED AND NOT A BLANKET SWAP. "Notice requirement" is
 * correct English on this site in another context entirely: Georgia's ante litem
 * notice is a genuine, mandatory pre-suit notice. A site-wide replacement of
 * "notice requirements" would corrupt every Georgia ante litem passage — the
 * exact passages Tier-1 batch 1 just corrected. So this splits each surface into
 * sentences, and rewrites ONLY inside a sentence that mentions the South
 * Carolina Act (or a § 15-78 section) and does NOT mention Georgia ante litem or
 * the Federal Tort Claims Act. The FTCA genuinely does require an administrative
 * claim, and one page on this site correctly says so.
 *
 * Splitting uses PREG_SPLIT_DELIM_CAPTURE so the delimiters are preserved and
 * reassembly is byte-lossless where no swap fired — verified by comparing the
 * rebuilt string to the original before any write.
 *
 * ALSO: SEVEN pages cite § 15-78-80 as the source of the deadline or a notice
 * requirement. § 15-78-80 is the OPTIONAL verified claim; the deadline is
 * § 15-78-110. Pages that cite § 15-78-80 merely as a handle for the Act, or for
 * damage caps and procedural requirements, are left alone — that is not wrong.
 *
 * str_replace within sentences; no preg_replace on content. post_modified not
 * stamped. _roden_last_refreshed set.
 *
 *   ssh rodenlawprod "wp --path=$P eval-file -"       < bin/fix-tier2-sctca-notice-wording.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply" < bin/fix-tier2-sctca-notice-wording.php
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

global $wpdb;
$apply = isset( $args[0] ) && 'apply' === $args[0];
$out   = fopen( 'php://stdout', 'w' );
$today = '2026-08-26';

/**
 * Longest first: "a much shorter notice deadline" must be consumed before
 * "shorter notice deadline" could match part of it.
 */
$swaps = array(
	/*
	 * Whole-clause repairs first. These exist because the dry run produced
	 * broken English without them — "have specific a two-year filing deadline",
	 * "there are an earlier, two-year filing deadline", and a swap firing inside
	 * the hyphenated compound "written-notice requirement". A phrase table that
	 * is only correct on average is not correct.
	 *
	 * The § 15-78-50 line is not a wording problem at all: § 15-78-50 is the
	 * Act's RIGHT OF ACTION provision, and it imposes no notice requirement of
	 * any length. That is a false statement of law with the wrong section
	 * attached — Tier 1 by any measure — and the audit missed it because the
	 * page says "written-notice requirement" rather than "notice deadlines".
	 * Repointed to § 15-78-110, which is the two-year filing deadline.
	 */
	'have additional notice requirements under the Tort Claims Act'                                    => 'must be filed within two years under the Tort Claims Act',
	'imposes shorter notice deadlines and damages caps'                                                => 'shortens the filing deadline to two years and caps damages',
	'imposes shorter notice deadlines and damage caps'                                                 => 'shortens the filing deadline to two years and caps damages',
	'shorter notice deadlines under the South Carolina Tort Claims Act apply'                          => 'a shorter, two-year filing deadline under the South Carolina Tort Claims Act applies',
	'§ 15-78-50 imposes a 2-year written-notice requirement'                                          => '§ 15-78-110 imposes a 2-year filing deadline',
	'have specific notice requirements and shortened filing deadlines under the South Carolina Tort Claims Act' => 'must be filed within two years under the South Carolina Tort Claims Act',
	'have shorter notice deadlines and a 2-year limit under the SC Tort Claims Act'                    => 'must be filed within two years under the SC Tort Claims Act',
	'shorter notice deadlines and a 2-year limit apply under the South Carolina Tort Claims Act'       => 'a two-year filing deadline applies under the South Carolina Tort Claims Act',
	'and there are earlier notice requirements'                                                        => 'and the filing deadline is two years',
	'with earlier notice requirements'                                                                 => 'with a two-year filing deadline',
	'imposes much shorter notice deadlines'  => 'shortens the filing deadline to two years',
	'a much shorter notice deadline'         => 'a much shorter, two-year filing deadline',
	'including specific notice requirements' => 'including a two-year filing deadline',
	'imposes additional notice requirements' => 'shortens the filing deadline to two years',
	'with additional notice requirements'    => 'with a two-year filing deadline',
	'imposes shorter notice requirements'    => 'shortens the filing deadline to two years',
	'carries shorter notice deadlines'       => 'carries a shorter, two-year filing deadline',
	'carry shorter notice requirements'      => 'carry a shorter, two-year filing deadline',
	'imposes shorter notice deadlines'       => 'shortens the filing deadline to two years',
	'impose shorter notice deadlines'        => 'shorten the filing deadline to two years',
	'carry shorter notice deadlines'         => 'carry a shorter, two-year filing deadline',
	'have shorter notice requirements'       => 'have a shorter, two-year filing deadline',
	'to specific notice requirements'        => 'to a two-year filing deadline',
	'a two-year notice requirement'          => 'a two-year filing deadline',
	'a 2-year notice requirement'            => 'a 2-year filing deadline',
	'earlier notice requirements'            => 'an earlier, two-year filing deadline',
	'shorter notice requirements'            => 'a shorter, two-year filing deadline',
	'Shorter notice deadlines'               => 'A shorter, two-year filing deadline',
	'shorter notice deadlines'               => 'a shorter, two-year filing deadline',
	'a shorter notice period'                => 'a shorter, two-year filing deadline',
	'tighter notice deadline'                => 'tighter, two-year filing deadline',
	'governmental notice deadline'           => 'governmental filing deadline',
	'imposes notice requirements'            => 'shortens the filing deadline to two years',
	'with notice requirements'               => 'with a two-year filing deadline',
	'these notice requirements'              => 'these deadlines',
	'and notice provisions'                  => 'and a two-year filing deadline',
	'notice requirements'                    => 'a two-year filing deadline',
	'notice requirement'                     => 'two-year filing deadline',
);

/** Cite corrections, applied only where 15-78-80 is offered AS the deadline. */
$cite_swaps = array(
	'Code § 15-78-80) with a 2-year notice requirement'          => 'Code § 15-78-110) with a 2-year filing deadline',
	'Code § 15-78-80), con un requisito de aviso de 2 años'      => 'Code § 15-78-110), con un plazo de presentación de 2 años',
	'Code Section 15-78-80), which imposes shorter notice requirements and damage caps' => 'Code Section 15-78-110), which shortens the filing deadline to two years and caps damages',
	'Code Section 15-78-80), which imposes notice requirements and damage caps'         => 'Code Section 15-78-110), which shortens the filing deadline to two years and caps damages',
);

/*
 * A first pass scoped on "South Carolina Tort Claims Act" missed two sentences
 * that name the Act without the state — "the Tort Claims Act imposes shorter
 * notice deadlines". Widened to the bare name, which is safe only because
 * EXCLUDE catches the two Acts that are NOT this one: the Federal Tort Claims
 * Act (which genuinely does require an administrative claim, correctly stated on
 * one page here) and the Georgia Tort Claims Act.
 */
$SC_ACT   = '/(South Carolina|SC)\s+Tort Claims Act|\bTort Claims Act\b|15-78-\d+/i';
/*
 * EXCLUDE earns its keep. Widening SC_ACT to the bare "Tort Claims Act" put
 * three correct sentences in range, and the dry run caught all three:
 *
 *   - § 15-79-125's 90-day pre-suit NOTICE OF INTENT is a real, mandatory
 *     South Carolina notice — for MEDICAL MALPRACTICE, not the Tort Claims Act.
 *     One page names both in the same sentence. Rewriting it would have turned a
 *     correct statement into a false one, which is the opposite of the job.
 *   - A sentence covering "Georgia's or South Carolina's Tort Claims Act
 *     procedures and notice requirements" is right about Georgia, whose ante
 *     litem notice genuinely is a notice requirement.
 *   - The Federal Tort Claims Act, which does require an administrative claim.
 */
$EXCLUDE  = '/ante ?-?litem|Federal Tort Claims Act|Georgia Tort Claims Act|Georgia\'s or South Carolina\'s|\\bFTCA\\b|36-33-5|36-11-1|50-21-26|15-79-125|pre-?suit notice|Notice of Intent/i';

$rows = $wpdb->get_results( "SELECT ID, post_name, post_content, post_excerpt FROM {$wpdb->posts} WHERE post_status = 'publish'" );

fprintf( $out, "%s\n\n", $apply ? '=== APPLY ===' : '=== DRY RUN (pass "apply" to write) ===' );

/**
 * Rewrite only inside sentences that are about the South Carolina Act.
 * Returns array( $new, $changes ).
 */
function roden_sctca_rewrite( $text, $swaps, $SC_ACT, $EXCLUDE ) {
	$parts = preg_split( '/(?<=[.!?])(\s+)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE );
	$changes = array();
	foreach ( $parts as $i => $chunk ) {
		if ( '' === trim( $chunk ) ) { continue; }
		$plain = strip_tags( $chunk );
		if ( ! preg_match( $SC_ACT, $plain ) ) { continue; }
		if ( preg_match( $EXCLUDE, $plain ) ) { continue; }
		$before = $chunk;
		foreach ( $swaps as $from => $to ) {
			if ( false !== strpos( $chunk, $from ) ) {
				$chunk = str_replace( $from, $to, $chunk );
			}
		}
		if ( $chunk !== $before ) {
			$parts[ $i ] = $chunk;
			$changes[] = array( trim( strip_tags( $before ) ), trim( strip_tags( $chunk ) ) );
		}
	}
	return array( implode( '', $parts ), $changes );
}

$touched = array(); $total = 0; $lossless_fail = 0;

foreach ( $rows as $r ) {
	$id = (int) $r->ID;
	$surfaces = array(
		'content'   => $r->post_content,
		'excerpt'   => $r->post_excerpt,
		'takeaways' => get_post_meta( $id, '_roden_key_takeaways', true ),
	);
	$faqs = get_post_meta( $id, '_roden_faqs', true );
	if ( is_array( $faqs ) ) {
		foreach ( $faqs as $i => $x ) {
			if ( is_array( $x ) && isset( $x['answer'] ) ) { $surfaces[ "faq:$i:answer" ] = $x['answer']; }
		}
	}

	$page_changes = array(); $new = array();
	foreach ( $surfaces as $sn => $v ) {
		if ( ! is_string( $v ) || '' === $v ) { continue; }

		// Lossless-reassembly guard: rebuilding with no swaps must return the input byte-for-byte.
		list( $probe, ) = roden_sctca_rewrite( $v, array(), $SC_ACT, $EXCLUDE );
		if ( $probe !== $v ) { $lossless_fail++; fprintf( $out, "!! [%d] %s reassembly not lossless — skipped\n", $id, $sn ); continue; }

		$w = $v;
		foreach ( $cite_swaps as $from => $to ) { $w = str_replace( $from, $to, $w ); }
		list( $w, $ch ) = roden_sctca_rewrite( $w, $swaps, $SC_ACT, $EXCLUDE );
		if ( $w !== $v ) {
			$new[ $sn ] = $w;
			foreach ( $ch as $c ) { $page_changes[] = array( $sn, $c[0], $c[1] ); }
			if ( ! $ch ) { $page_changes[] = array( $sn, '(citation only)', '§ 15-78-80 → § 15-78-110' ); }
		}
	}
	if ( ! $new ) { continue; }

	$touched[ $id ] = $new;
	fprintf( $out, "\n[%d] %s\n", $id, $r->post_name );
	foreach ( $page_changes as $c ) {
		$total++;
		fprintf( $out, "   (%s)\n     - %s\n     + %s\n", $c[0], mb_substr( $c[1], 0, 150 ), mb_substr( $c[2], 0, 150 ) );
	}
}

fprintf( $out, "\nchanges: %d on %d pages    reassembly failures: %d\n", $total, count( $touched ), $lossless_fail );

if ( ! $apply ) { fprintf( $out, "\nDry run only.\n" ); exit( 0 ); }

$backup = array();
foreach ( array_keys( $touched ) as $id ) {
	$backup[] = array(
		'ID' => $id,
		'post_content'   => get_post_field( 'post_content', $id ),
		'post_excerpt'   => get_post_field( 'post_excerpt', $id ),
		'faqs'           => get_post_meta( $id, '_roden_faqs', true ),
		'takeaways'      => get_post_meta( $id, '_roden_key_takeaways', true ),
	);
}
$file = sprintf( '/tmp/roden-tier2-sctca-backup-%s.json', gmdate( 'Ymd-His' ) );
file_put_contents( $file, wp_json_encode( $backup, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
fprintf( $out, "\nbackup: %s\n\n", $file );

foreach ( $touched as $id => $new ) {
	$faqs = get_post_meta( $id, '_roden_faqs', true );
	$faq_dirty = false;
	foreach ( $new as $sn => $v ) {
		if ( 'content' === $sn ) {
			$wpdb->update( $wpdb->posts, array( 'post_content' => $v ), array( 'ID' => $id ), array( '%s' ), array( '%d' ) );
		} elseif ( 'excerpt' === $sn ) {
			$wpdb->update( $wpdb->posts, array( 'post_excerpt' => $v ), array( 'ID' => $id ), array( '%s' ), array( '%d' ) );
		} elseif ( 'takeaways' === $sn ) {
			update_post_meta( $id, '_roden_key_takeaways', $v );
		} else {
			list( , $i, ) = explode( ':', $sn );
			$faqs[ (int) $i ]['answer'] = $v;
			$faq_dirty = true;
		}
	}
	if ( $faq_dirty ) { update_post_meta( $id, '_roden_faqs', $faqs ); }
	update_post_meta( $id, '_roden_last_refreshed', $today );
	fprintf( $out, "[%d] written (%d surfaces)\n", $id, count( $new ) );
}
fprintf( $out, "\nDone. Flush both cache layers, then verify live.\n" );
