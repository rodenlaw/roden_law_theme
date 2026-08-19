<?php
/**
 * Correct an unsupported "most dangerous cities" claim on the Summerville
 * truck-accident resource (post 4665).
 *
 * The page asserted, in three places, that Summerville "has been ranked among
 * the top 20 most dangerous cities nationally for car accidents" — and then
 * explained the ranking causally: "The primary driver of this dangerous ranking
 * is Summerville's position along the I-26 corridor."
 *
 * The underlying source is real but says something else entirely. Insurify, a
 * car-insurance broker, analysed ~2.5 million insurance applications and ranked
 * cities by the share of LOCAL DRIVERS who self-reported a prior at-fault
 * accident on their record. Summerville placed 16th at 17.5%. That measures
 * where accident-prone drivers LIVE — a Summerville resident who crashes in
 * Charleston counts toward Summerville — not how dangerous the town's roads are,
 * and not how many crashes occur there. It is 2020 data from a commercial
 * marketing study, not a traffic-safety authority.
 *
 * So the page did three things wrong: it restated the metric as something it is
 * not, it attributed the ranking to I-26 freight traffic (which the study never
 * measured), and it repeated the invented causation in an FAQ, where it feeds
 * FAQPage schema and is therefore machine-readable and quotable by AI engines.
 *
 * This replaces all three with the framing the page already supports on its own
 * evidence — the I-26 port-freight corridor and Dorchester County's growth —
 * and drops the ranking entirely rather than restating it accurately, because a
 * 2020 survey of where at-fault drivers live has no bearing on truck crashes.
 *
 * Same failure class as the "only Level I trauma center" claim that reached 55
 * pages on the Georgia side: a plausible-sounding statistic, repeated
 * confidently, that does not survive being traced to its source.
 *
 * Also corrects the comparative-fault wording in the key takeaway from the
 * "less than 51% at fault" shorthand to the actual standard.
 *
 * NOT changed, and NOT verified by this script — flagged for review:
 *   - "South Carolina recorded 3,167 large truck crashes in 2024"
 *   - "Five roads account for approximately half of all serious-injury crashes"
 * Both pre-date this fix. Neither was traced to a primary source.
 *
 * Run from the repo over stdin — never added to the theme:
 *   ssh rodenlawprod "wp --path=$P eval-file -"       < bin/fix-summerville-ranking-claim.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply" < bin/fix-summerville-ranking-claim.php
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

$apply   = isset( $args[0] ) && 'apply' === $args[0];
$post_id = 4665;

$post = get_post( $post_id );
if ( ! $post || 'resource' !== $post->post_type ) {
	printf( "ABORT  #%d is not a resource post\n", $post_id );
	exit( 1 );
}
printf( "post #%d  %s  (%s)\n\n", $post->ID, $post->post_title, $post->post_status );

$changes = array();

/* ── 1. Body ────────────────────────────────────────────────────────────── */

// Matched against the exact stored markup — the claim is wrapped in <strong>
// tags, so a plain-text match silently fails and leaves the page unchanged.
$body_old = '<p><strong>Summerville</strong> has been ranked among the <strong>top 20 most dangerous cities nationally for car accidents</strong> ' . "\xE2\x80\x94" . ' a startling designation for a community that still markets itself as the "Flower Town in the Pines." The primary driver of this dangerous ranking is Summerville\'s position along the <strong>I-26 corridor</strong>, the major freight artery connecting the Port of Charleston with Columbia, the Upstate, and the national highway network.</p>';
$body_new = '<p><strong>Summerville</strong> sits astride the <strong>I-26 corridor</strong>, the major freight artery connecting the Port of Charleston with Columbia, the Upstate, and the national highway network ' . "\xE2\x80\x94" . ' and it has grown faster over the past decade than almost anywhere else in South Carolina. A town that still markets itself as the "Flower Town in the Pines" now absorbs port container traffic on a road network laid out for a fraction of the volume it carries.</p>';

$content = $post->post_content;
if ( false !== strpos( $content, $body_old ) ) {
	$content   = str_replace( $body_old, $body_new, $content );
	$changes[] = 'body';
} else {
	printf( "WARN   body paragraph not matched " . "\xE2\x80\x94" . " leaving post_content untouched\n" );
}
$body_new_plain = wp_strip_all_tags( $body_new );

/* ── 2. Key takeaways ───────────────────────────────────────────────────── */

$kt_old = get_post_meta( $post_id, '_roden_key_takeaways', true );
$kt_new = 'The I-26 corridor through Summerville carries heavy commercial truck traffic between the Port of Charleston and Columbia, and five roads account for approximately half of serious-injury crashes in the area: US-17A, Berlin G. Myers Parkway, Old Trolley Road, Dorchester Road, and Central Avenue. Rapid population growth has outpaced road infrastructure. South Carolina gives victims 3 years to file (S.C. Code &sect; 15-3-530), and recovery is barred only once a plaintiff&#8217;s own negligence is greater than the combined negligence of the defendants.';
if ( $kt_old && false !== stripos( $kt_old, 'most dangerous' ) ) {
	$changes[] = '_roden_key_takeaways';
}

/* ── 3. FAQ 0 ───────────────────────────────────────────────────────────── */

$faqs    = (array) get_post_meta( $post_id, '_roden_faqs', true );
$faq_idx = null;
foreach ( $faqs as $i => $f ) {
	if ( false !== stripos( $f['question'] . ' ' . $f['answer'], 'dangerous' ) ) {
		$faq_idx = $i;
		break;
	}
}
if ( null !== $faq_idx ) {
	$faqs[ $faq_idx ]['question'] = 'Why are there so many serious crashes in Summerville?';
	$faqs[ $faq_idx ]['answer']   = 'Summerville sits on the I-26 freight corridor between the Port of Charleston and inland destinations, and residential growth has outpaced the road network connecting neighborhoods to the interstate. Five roads — US-17A, Berlin G. Myers Parkway, Old Trolley Road, Dorchester Road, and Central Avenue — account for approximately half of all serious-injury crashes in the area.';
	$changes[] = '_roden_faqs[' . $faq_idx . ']';
}

/* ── Report / apply ─────────────────────────────────────────────────────── */

printf( "will change: %s\n\n", $changes ? implode( ', ', $changes ) : 'NOTHING' );
if ( ! $changes ) {
	printf( "Already applied, or the source text has moved. Nothing to do.\n" );
	exit( 0 );
}

if ( ! $apply ) {
	printf( "--- new body opening ---\n%s\n\n", wp_strip_all_tags( $body_new_plain ) );
	printf( "--- new key takeaways ---\n%s\n\n", html_entity_decode( wp_strip_all_tags( $kt_new ), ENT_QUOTES, 'UTF-8' ) );
	if ( null !== $faq_idx ) {
		printf( "--- new FAQ %d ---\nQ: %s\nA: %s\n\n", $faq_idx, $faqs[ $faq_idx ]['question'], $faqs[ $faq_idx ]['answer'] );
	}
	printf( "Dry run. Re-run with `apply` to write.\n" );
	exit( 0 );
}

$res = wp_update_post( array( 'ID' => $post_id, 'post_content' => $content ), true );
if ( is_wp_error( $res ) ) {
	printf( "ERROR  %s\n", $res->get_error_message() );
	exit( 1 );
}
update_post_meta( $post_id, '_roden_key_takeaways', $kt_new );
if ( null !== $faq_idx ) {
	update_post_meta( $post_id, '_roden_faqs', $faqs );
}

// Verify nothing survived.
$check   = get_post( $post_id );
$kt      = (string) get_post_meta( $post_id, '_roden_key_takeaways', true );
$faq_now = (array) get_post_meta( $post_id, '_roden_faqs', true );
$hay     = $check->post_content . ' ' . $kt;
foreach ( $faq_now as $f ) {
	$hay .= ' ' . $f['question'] . ' ' . $f['answer'];
}
$still = array();
foreach ( array( 'most dangerous', 'top 20', 'dangerous ranking' ) as $needle ) {
	if ( false !== stripos( $hay, $needle ) ) {
		$still[] = $needle;
	}
}
printf( "applied.\nremaining occurrences: %s\n", $still ? implode( ', ', $still ) : 'none' );
printf( "\nStill unverified on this page and NOT changed here — worth a separate look:\n" );
printf( "  - \"South Carolina recorded 3,167 large truck crashes in 2024\"\n" );
printf( "  - \"Five roads account for approximately half of all serious-injury crashes\"\n" );
printf( "\nNext: wp cache flush && wp page-cache flush.\n" );
