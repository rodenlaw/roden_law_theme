<?php
/**
 * Tier-1 batch 3 — closes the remainder of the 2026-08-26 audit's Tier 1.
 *
 * §1.2  TWO pages said South Carolina has no statutory cap on punitive damages.
 *       § 15-32-530 caps them at the greater of 3x compensatory or $500,000
 *       (4x/$2,000,000 for financial-gain or felony-level conduct; uncapped on
 *       intent, felony conviction, or substance impairment). About fifteen other
 *       pages state this correctly — the site was contradicting itself.
 *
 * §1.3  ONE page twice claimed the punitive cap lifts at "a BAC of 0.15% or
 *       higher". No numeric BAC threshold exists anywhere in § 15-32-530. The
 *       test is qualitative: under the influence "to the degree that the
 *       defendant's judgment is substantially impaired" (§ 15-32-530(C)(3)).
 *       0.15% is real South Carolina law — in the CRIMINAL DUI statutes
 *       (§ 56-5-2930 et seq.) — imported into a civil damages rule where it does
 *       not belong. The same page correctly cites 0.08% for the criminal
 *       offence, which is left exactly as it is.
 *
 * §1.5  THREE pages applied the SIX-month municipal ante litem deadline to
 *       COUNTY claims. Counties are TWELVE months under § 36-11-1. This one
 *       fails safe — it understates the time available — but it is wrong, and
 *       two instances sit in FAQPage structured data.
 *
 * §1.7  Georgia's workers' comp weekly maximum appeared as $383 (2016), $550
 *       ("the current maximum"), and $800. NO REPLACEMENT FIGURE IS WRITTEN.
 *       The rate is adjusted periodically and the current one is not confirmed
 *       against the State Board; public sources disagree ($800/$850/$875).
 *       Publishing a fourth number would repeat the mistake. The stale figures
 *       are replaced with the mechanism — two-thirds of average weekly wage up
 *       to a statutory maximum that depends on date of injury — which is true
 *       whatever the current cap turns out to be, and the durations (400 / 350
 *       weeks) are kept because those are statutory and unchanged.
 *
 * Also closes two stragglers found while verifying batch 2:
 *   - maybank-highway kept a second, differently-worded "mandatory pre-suit
 *     notice" that batch 2's FROM string did not cover.
 *   - when-is-the-right-time cited § 15-78-80 (the OPTIONAL verified claim) as
 *     the source of South Carolina's notice/deadline rule. The deadline is
 *     § 15-78-110. Correct number, wrong section — the audit's signature error.
 *
 * str_replace only. post_modified not stamped. _roden_last_refreshed set.
 *
 *   ssh rodenlawprod "wp --path=$P eval-file -"       < bin/fix-tier1-batch3-remainder.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply" < bin/fix-tier1-batch3-remainder.php
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

$edits = array(

/* ── §1.2  SC punitive cap ────────────────────────────────────────────────── */
array( 'id' => 1669, 'surface' => 'content', 'expect' => 1,
 'from' => 'South Carolina does not impose a statutory cap on punitive damages, though awards must be reasonable and proportional to the compensatory damages',
 'to'   => 'South Carolina caps punitive damages at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530), and awards must also be reasonable and proportional to the compensatory damages' ),
array( 'id' => 1669, 'surface' => 'content', 'expect' => 1,
 'from' => '<tr><td>Punitive Damages Cap</td><td>$250,000 general cap (O.C.G.A. § 51-12-5.1)</td><td>No statutory cap</td></tr>',
 'to'   => '<tr><td>Punitive Damages Cap</td><td>$250,000 general cap (O.C.G.A. § 51-12-5.1)</td><td>Greater of 3x compensatory or $500,000 (S.C. Code § 15-32-530)</td></tr>' ),
array( 'id' => 3440, 'surface' => 'faq:4:answer', 'expect' => 1,
 'from' => 'South Carolina has no statutory cap on punitive damages, but courts require that awards be reasonable and proportional to the harm caused',
 'to'   => 'South Carolina caps punitive damages at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530), and courts additionally require that awards be reasonable and proportional to the harm caused' ),

/* ── §1.3  fabricated BAC threshold ───────────────────────────────────────── */
array( 'id' => 4360, 'surface' => 'content', 'expect' => 1,
 'from' => "the cap does not apply if the defendant's conduct was motivated by an unreasonable financial motive or if the defendant had a BAC of 0.15% or higher — a threshold commonly exceeded in summer DUI crashes.",
 'to'   => "the cap does not apply if the defendant's conduct was motivated by an unreasonable financial motive, or if the defendant was under the influence of alcohol or drugs to a degree that substantially impaired his judgment — which is the standard in S.C. Code § 15-32-530(C), not a fixed blood-alcohol number." ),
array( 'id' => 4360, 'surface' => 'content', 'expect' => 1,
 'from' => "but the cap may not apply if the driver's BAC was 0.15% or higher.",
 'to'   => "but the cap may not apply where the driver was under the influence to a degree that substantially impaired his judgment (S.C. Code § 15-32-530(C))." ),

/* ── §1.5  county given the municipal 6-month deadline ────────────────────── */
array( 'id' => 4059, 'surface' => 'content', 'expect' => 1,
 'from' => '<li><strong>County and municipal governments:</strong>',
 'to'   => '<li><strong>Municipal governments:</strong>' ),
array( 'id' => 4059, 'surface' => 'content', 'expect' => 1,
 'from' => 'requires written notice to the governing authority within 6 months of the incident before filing a lawsuit. This notice must describe the time, place, and extent of the injury.',
 'to'   => 'requires written notice to the governing authority within 6 months of the incident before filing a lawsuit. This notice must describe the time, place, and extent of the injury. A claim against a <strong>county</strong> runs on a different clock — it must be presented within 12 months under O.C.G.A. § 36-11-1.' ),
array( 'id' => 4059, 'surface' => 'faq:1:answer', 'expect' => 1,
 'from' => 'Under O.C.G.A. § 36-33-5, you must provide written notice to the county or municipal governing authority within 6 months of the accident before you can file a lawsuit.',
 'to'   => 'Under O.C.G.A. § 36-33-5, you must provide written notice to a municipal governing authority within 6 months of the accident before you can file a lawsuit. A claim against a county is different — it must be presented within 12 months under O.C.G.A. § 36-11-1.' ),
array( 'id' => 4226, 'surface' => 'content', 'expect' => 1,
 'from' => 'requires written notice to the city or county within six months of the injury before filing suit',
 'to'   => 'requires written notice to a city within six months of the injury before filing suit; a claim against a county must instead be presented within 12 months under O.C.G.A. § 36-11-1' ),
array( 'id' => 4740, 'surface' => 'content', 'expect' => 2,
 'from' => 'ante litem notice under O.C.G.A. § 36-33-5 must be served within just six months — far shorter than the headline rule.',
 'to'   => 'ante litem notice to a city under O.C.G.A. § 36-33-5 must be served within just six months, and a claim against Chatham County must be presented within 12 months under O.C.G.A. § 36-11-1 — both far shorter than the headline rule.' ),

/* ── §1.7  Georgia workers' comp maxima — figures removed, not replaced ───── */
array( 'id' => 1784, 'surface' => 'content', 'expect' => 1,
 'from' => 'The maximum weekly benefit amount is $383 for injuries that happened on or after July 1, 2016.',
 'to'   => "The maximum weekly benefit is set by statute and adjusted periodically by the State Board of Workers' Compensation, so the cap that applies depends on your date of injury — confirm the current figure before relying on it." ),
array( 'id' => 1851, 'surface' => 'content', 'expect' => 1,
 'from' => 'In Georgia, the current maximum weekly payment for temporary total disability is $550 per week for up to 400 weeks. For temporary partial disability, it’s up to $367 per week for up to 350 weeks.',
 'to'   => "In Georgia, temporary total disability pays two-thirds of your average weekly wage up to a statutory maximum, for up to 400 weeks; temporary partial disability pays up to a lower statutory maximum for up to 350 weeks. Both caps are set by the State Board of Workers' Compensation and turn on your date of injury, so confirm the current figures before relying on them." ),

/* ── stragglers found while verifying batch 2 ─────────────────────────────── */
array( 'id' => 4353, 'surface' => 'content', 'expect' => 1,
 'from' => 'navigate the South Carolina Tort Claims Act requirements, including mandatory pre-suit notice and damage caps',
 'to'   => 'navigate the South Carolina Tort Claims Act requirements, including its two-year filing deadline and damage caps' ),
array( 'id' => 1692, 'surface' => 'content', 'expect' => 1,
 'from' => 'In South Carolina, the South Carolina Tort Claims Act (S.C. Code § 15-78-80) imposes its own notice requirements and caps.',
 'to'   => 'In South Carolina, the South Carolina Tort Claims Act shortens the filing deadline to two years (S.C. Code § 15-78-110) and caps the damages recoverable; filing a verified claim within one year is optional and extends the deadline to three.' ),

);

fprintf( $out, "%s\n\n", $apply ? '=== APPLY ===' : '=== DRY RUN (pass "apply" to write) ===' );

$backup = array(); $ok = 0; $skipped = 0;
$dirty_content = array(); $dirty_faqs = array(); $touched = array();

foreach ( $edits as $e ) {
	$id = (int) $e['id'];
	$expect = isset( $e['expect'] ) ? (int) $e['expect'] : 1;
	if ( ! isset( $backup[ $id ] ) ) {
		$row = $wpdb->get_row( $wpdb->prepare( "SELECT ID, post_name, post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
		if ( ! $row ) { fprintf( $out, "!! post %d not found\n", $id ); $skipped++; continue; }
		$backup[ $id ] = array( 'ID' => $id, 'post_name' => $row->post_name,
			'post_content' => $row->post_content, 'faqs' => get_post_meta( $id, '_roden_faqs', true ) );
	}
	if ( 'content' === $e['surface'] ) {
		$cur = isset( $dirty_content[ $id ] ) ? $dirty_content[ $id ] : $backup[ $id ]['post_content'];
		$n = substr_count( $cur, $e['from'] );
		if ( $n !== $expect ) {
			fprintf( $out, "!! SKIP [%d] content — matched %d, expected %d\n     %s…\n", $id, $n, $expect, substr( $e['from'], 0, 84 ) );
			$skipped++; continue;
		}
		$dirty_content[ $id ] = str_replace( $e['from'], $e['to'], $cur );
		$touched[ $id ] = true; $ok++;
		fprintf( $out, "OK   [%d] content x%d\n     - %s…\n     + %s…\n", $id, $n, substr( $e['from'], 0, 86 ), substr( $e['to'], 0, 86 ) );
		continue;
	}
	list( , $idx, ) = explode( ':', $e['surface'] );
	$idx = (int) $idx;
	$faqs = isset( $dirty_faqs[ $id ] ) ? $dirty_faqs[ $id ] : $backup[ $id ]['faqs'];
	if ( ! is_array( $faqs ) || ! isset( $faqs[ $idx ]['answer'] ) ) {
		fprintf( $out, "!! SKIP [%d] faq[%d] missing\n", $id, $idx ); $skipped++; continue;
	}
	$n = substr_count( $faqs[ $idx ]['answer'], $e['from'] );
	if ( $n !== $expect ) { fprintf( $out, "!! SKIP [%d] faq[%d] — matched %d, expected %d\n", $id, $idx, $n, $expect ); $skipped++; continue; }
	$faqs[ $idx ]['answer'] = str_replace( $e['from'], $e['to'], $faqs[ $idx ]['answer'] );
	$dirty_faqs[ $id ] = $faqs; $touched[ $id ] = true; $ok++;
	fprintf( $out, "OK   [%d] faq[%d]\n     - %s…\n     + %s…\n", $id, $idx, substr( $e['from'], 0, 86 ), substr( $e['to'], 0, 86 ) );
}

fprintf( $out, "\nedits: %d ok, %d skipped, %d posts\n", $ok, $skipped, count( $touched ) );
if ( $skipped > 0 ) { fprintf( $out, "\nABORTING — nothing written.\n" ); exit( 1 ); }
if ( ! $apply ) { fprintf( $out, "\nDry run only.\n" ); exit( 0 ); }

$file = sprintf( '/tmp/roden-tier1-batch3-backup-%s.json', gmdate( 'Ymd-His' ) );
file_put_contents( $file, wp_json_encode( array_values( $backup ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
fprintf( $out, "\nbackup: %s\n\n", $file );

foreach ( array_keys( $touched ) as $id ) {
	if ( isset( $dirty_content[ $id ] ) ) {
		$wpdb->update( $wpdb->posts, array( 'post_content' => $dirty_content[ $id ] ), array( 'ID' => $id ), array( '%s' ), array( '%d' ) );
	}
	if ( isset( $dirty_faqs[ $id ] ) ) { update_post_meta( $id, '_roden_faqs', $dirty_faqs[ $id ] ); }
	update_post_meta( $id, '_roden_last_refreshed', $today );
	$c = $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	$f = get_post_meta( $id, '_roden_faqs', true );
	$blob = $c . ( is_array( $f ) ? wp_json_encode( $f ) : '' );
	$stale = 0;
	foreach ( $edits as $e ) { if ( (int) $e['id'] === $id ) { $stale += substr_count( $blob, $e['from'] ); } }
	fprintf( $out, "[%d] written · stale: %d %s\n", $id, $stale, $stale ? '!!' : 'OK' );
}
fprintf( $out, "\nDone. Flush both cache layers, then verify live.\n" );
