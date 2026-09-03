<?php
/**
 * Track C bounded test — reformat one page as a glossary entry and measure.
 *
 * HYPOTHESIS: a structured definition moves a definitional query from position
 * 3-5 to position 1-3. Brand excluded, the site earns 6.127% at 1-3 and 0.793%
 * at 3-5, so the move is worth ~8x. Nothing on this site has tested whether
 * format can cause it. Track A died of an untested assumption of the same
 * shape, which is why this is one page and not twenty-five.
 *
 * BASELINE (docs/gsc-2026-08-24, 13 months to 2026-08-24), for the 70-query
 * compensatory/punitive cluster:
 *
 *     impressions 127,662   clicks 284   CTR 0.222%
 *     impression-weighted position 9.09
 *
 * The test is falsifiable: if the weighted position has not improved a quarter
 * from now, the glossary build does not happen.
 *
 * WHAT THIS CHANGES. Two things, deliberately bundled — the decision at stake
 * is "does glossary format work", not "which half of it works":
 *
 *   1. A `.ai-definition-block` answering both terms in 53 words, ahead of the
 *      table of contents. The CSS for this block has shipped since the AI-SEO
 *      pass and NO published page uses it; the speakable spec already targets
 *      the selector. §9 rule 1 of the knowledge-base plan is "answer in the
 *      first 60 words", and this page opened with two paragraphs of narrative.
 *   2. `_roden_glossary_terms`, which roden_schema_defined_term_set() publishes
 *      as DefinedTermSet/DefinedTerm.
 *
 * WHAT THIS DELIBERATELY DOES NOT CHANGE. §9 rules 5 and 6 are not met and
 * cannot be met from here:
 *
 *   - `_roden_last_reviewed` stays unset. Setting it publishes `reviewedBy`,
 *     asserting that a named attorney checked this page on a date. No attorney
 *     has. inc/schema-helpers.php makes that argument itself and it is right.
 *   - The byline stays Eric Roden (3729), who is admitted in Georgia only. This
 *     is a two-state page stating South Carolina law; §9 rule 6 wants a
 *     GA-barred and an SC-barred co-byline, and Graeham Gillin (3732) is the
 *     only SC-admitted attorney on the site. Assigning that is the firm's call,
 *     not a script's — it is the open owner decision in plan §13.
 *
 * Run:  ssh $H "wp --path=... eval-file -" < bin/b1-glossary-format-test.php
 *       (append ` apply` to write; default is a dry run)
 */

$APPLY   = ( isset( $args[0] ) && 'apply' === $args[0] );
$POST_ID = 1663;

$block = '<div class="ai-definition-block">' . "\n"
	. '<h2>Compensatory vs. punitive damages</h2>' . "\n"
	. '<p class="definition-text"><strong>Compensatory damages</strong> repay what an injury cost you — medical bills, lost wages, and pain and suffering. <strong>Punitive damages</strong> are awarded on top, to punish extreme misconduct. Georgia caps punitive damages at $250,000 (O.C.G.A. § 51-12-5.1); South Carolina at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530).</p>' . "\n"
	. '<p class="definition-attribution">Roden Law — personal injury practice in Georgia and South Carolina.</p>' . "\n"
	. '</div>' . "\n\n";

// Definitions are the page's own, compressed. Every statutory claim in them was
// verified on 2026-09-03 against scstatehouse.gov and the O.C.G.A. subsections
// recorded in docs/sb68-propagation-audit-2026-08-25.md.
$terms = array(
	array(
		'term'       => 'Compensatory damages',
		'anchor'     => 'what-are-compensatory-damages',
		'definition' => 'Money that repays what an injury actually cost — medical bills, lost wages, and non-economic harm such as pain and suffering. Neither Georgia nor South Carolina caps compensatory damages in ordinary injury cases.',
	),
	array(
		'term'       => 'Punitive damages',
		'anchor'     => 'what-are-punitive-damages',
		'definition' => 'Money awarded on top of compensatory damages to punish extreme misconduct and deter it. Georgia caps punitive damages at $250,000 (O.C.G.A. § 51-12-5.1); South Carolina at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530).',
	),
	array(
		// No anchor: the page's h3s carry no ids, and a url pointing at a
		// fragment that does not exist is worse than no url.
		'term'       => 'Special damages',
		'definition' => 'The measurable financial losses an injury causes — medical expenses, lost income, lost earning capacity, and property damage — proved with bills, records, and expert projections. Also called economic damages.',
	),
	array(
		'term'       => 'General damages',
		'definition' => 'Losses that arrive with no invoice: physical pain, mental anguish, disfigurement, and loss of enjoyment of life. Proved through testimony and medical records rather than receipts. Also called non-economic damages.',
	),
);

$post = get_post( $POST_ID );
if ( ! $post ) {
	echo "MISSING post $POST_ID\n";
	return;
}

$content  = $post->post_content;
$existing = get_post_meta( $POST_ID, '_roden_glossary_terms', true );

$has_block = false !== strpos( $content, 'ai-definition-block' );
$word_count = str_word_count( wp_strip_all_tags(
	preg_replace( '#<p class="definition-attribution">.*?</p>#s', '', $block ) ) ) - 4; // less the h2

echo ( $APPLY ? 'APPLY' : 'DRYRUN' ) . " post $POST_ID — {$post->post_title}\n";
echo "  definition block present already : " . ( $has_block ? 'yes (will not re-insert)' : 'no' ) . "\n";
echo "  definition answer word count     : $word_count (§9 rule 1 budget: 60)\n";
echo "  glossary terms already set       : " . ( is_array( $existing ) ? count( $existing ) : 'no' ) . "\n";
echo "  terms to write                   : " . count( $terms ) . "\n";

// Anchors must resolve. Verify against the live content before publishing a url.
foreach ( $terms as $t ) {
	if ( empty( $t['anchor'] ) ) {
		continue;
	}
	$found = false !== strpos( $content, 'id="' . $t['anchor'] . '"' );
	echo '  anchor #' . str_pad( $t['anchor'], 32 ) . ( $found ? 'resolves' : 'MISSING — refusing' ) . "\n";
	if ( ! $found ) {
		return;
	}
}

if ( ! $APPLY ) {
	echo "\n--- block to insert, ahead of the table of contents ---\n$block";
	echo "--- current opening 220 chars ---\n" . substr( $content, 0, 220 ) . "\n";
	return;
}

if ( ! $has_block ) {
	$res = wp_update_post( array( 'ID' => $POST_ID, 'post_content' => $block . $content ), true );
	if ( is_wp_error( $res ) ) {
		echo "ERROR " . $res->get_error_message() . "\n";
		return;
	}
}
update_post_meta( $POST_ID, '_roden_glossary_terms', $terms );

// Verify by re-reading.
$after = get_post( $POST_ID );
$meta  = get_post_meta( $POST_ID, '_roden_glossary_terms', true );
printf(
	"\n--- verify ---\nblock_present=%s  block_is_first=%s  terms_stored=%s\n",
	( false !== strpos( $after->post_content, 'ai-definition-block' ) ) ? 'yes' : 'NO',
	( 0 === strpos( $after->post_content, '<div class="ai-definition-block">' ) ) ? 'yes' : 'NO',
	is_array( $meta ) ? count( $meta ) : 'NO'
);
