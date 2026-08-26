<?php
/**
 * Tier-1 batch 2 of the 2026-08-26 legal accuracy audit: §1.6, the South
 * Carolina Tort Claims Act, described backwards on 18 pages.
 *
 * WHAT THE SITE SAID: the Act "imposes shorter notice deadlines", "requires
 * written notice", "mandatory pre-suit notice" — and on three pages, that those
 * notice provisions must be met "well in advance of the three-year deadline".
 *
 * WHAT THE ACT ACTUALLY DOES (verified against scstatehouse.gov):
 *   § 15-78-110  suit is barred unless commenced within TWO years of the loss —
 *                or THREE years if a verified claim was first filed.
 *   § 15-78-80   that verified claim is OPTIONAL, and if used must be filed
 *                within ONE year of the loss.
 *   § 15-78-90(b) a claimant may sue "whether or not the claim is filed".
 *
 * So the Act shortens the LIMITATION period; it imposes no pre-suit notice at
 * all, and the optional filing LENGTHENS the deadline rather than shortening it.
 * The site had the mechanism inverted. A reader told notice deadlines are
 * shorter may believe a claim is already lost when two full years remain — or,
 * worse, rely on "three years" and lose it at two.
 *
 * THE FIX ALREADY EXISTED ON THE SITE. Of 42 pages touching the Act, exactly one
 * stated it correctly and completely — /blog/green-grove-mark-clark-expressway-
 * uninsured-motorist-lawyer-north-charleston/: "a suit against a government
 * entity must be filed within two years of the loss, or three years if a
 * verified claim was filed with the agency." Every replacement below is built on
 * that sentence rather than invented.
 *
 * ONE BONUS FIX. /blog/georgia-statute-of-limitations/ cited § 15-78-80 as the
 * source of the two-year deadline. § 15-78-80 is the OPTIONAL verified claim;
 * the deadline is § 15-78-110. Correct number, wrong section — the exact failure
 * mode this audit kept finding.
 *
 * SOME STRINGS APPEAR TWICE ON PURPOSE. Several FAQ answers are duplicated
 * inside a <script type="application/ld+json"> block in the same post_content,
 * so the visible copy and the schema copy must both change or the page and its
 * structured data will disagree. Each edit therefore declares how many matches
 * it expects, and any edit whose count does not match exactly is SKIPPED and the
 * whole run aborts before writing.
 *
 * str_replace only, never preg_replace. post_modified is not stamped.
 * _roden_last_refreshed is set; _roden_last_reviewed is never written by a script.
 *
 *   ssh rodenlawprod "wp --path=$P eval-file -"       < bin/fix-tier1-batch2-sctca.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply" < bin/fix-tier1-batch2-sctca.php
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

/* 4339 — rivers-avenue-pedestrian-deaths-north-charleston */
array( 'id' => 4339, 'surface' => 'content', 'expect' => 1,
 'from' => 'including specific notice provisions that must be met well in advance of the three-year deadline',
 'to'   => 'and a shorter filing deadline — two years under the South Carolina Tort Claims Act (S.C. Code § 15-78-110) rather than the usual three, unless a verified claim is filed with the agency within one year, which extends it back to three' ),
array( 'id' => 4339, 'surface' => 'faq:5:answer', 'expect' => 1,
 'from' => 'Claims against government entities under the Tort Claims Act have additional notice requirements that must be met earlier.',
 'to'   => 'Claims against government entities run on a shorter clock — two years under the Tort Claims Act (S.C. Code § 15-78-110), or three if a verified claim is filed with the agency within one year.' ),

/* 4346 — car-accidents-ladson-i-26-exit-203-danger-zone */
array( 'id' => 4346, 'surface' => 'content', 'expect' => 1,
 'from' => 'the Tort Claims Act has specific notice requirements that must be met well before the three-year deadline',
 'to'   => 'the Tort Claims Act shortens the filing deadline to two years (S.C. Code § 15-78-110) rather than three, unless a verified claim is filed with the agency within one year' ),
array( 'id' => 4346, 'surface' => 'faq:2:answer', 'expect' => 1,
 'from' => 'Claims involving government liability for road defects have additional notice requirements under the Tort Claims Act that must be met earlier.',
 'to'   => 'Claims involving government liability for road defects must be filed within two years under the Tort Claims Act (S.C. Code § 15-78-110) — a year less than the usual deadline.' ),

/* 4353 — maybank-highway-car-accidents-johns-island */
array( 'id' => 4353, 'surface' => 'content', 'expect' => 1,
 'from' => 'substantially shorter notice requirements apply under the South Carolina Tort Claims Act, often as little as two years, with mandatory pre-suit notice',
 'to'   => 'a shorter filing deadline applies under the South Carolina Tort Claims Act — two years rather than three (S.C. Code § 15-78-110), unless a verified claim is filed with the agency within one year' ),
array( 'id' => 4353, 'surface' => 'content', 'expect' => 1,
 'from' => 'Claims against government entities may have shorter notice requirements under the Tort Claims Act.',
 'to'   => 'Claims against government entities must be filed within two years under the Tort Claims Act, not the usual three.' ),

/* 4370 — ben-sawyer-boulevard-bridge-accidents-sullivans-island */
array( 'id' => 4370, 'surface' => 'content', 'expect' => 1,
 'from' => "you must comply with the Tort Claims Act's two-year deadline and specific notice requirements.",
 'to'   => "the Tort Claims Act's two-year filing deadline applies instead of the usual three (S.C. Code § 15-78-110)." ),

/* 4364 — daniel-island-accidents-event-traffic-golf-carts */
array( 'id' => 4364, 'surface' => 'content', 'expect' => 1,
 'from' => 'require a Tort Claims Act notice and are subject to shorter deadlines and damage caps',
 'to'   => 'must be filed within two years under the South Carolina Tort Claims Act (S.C. Code § 15-78-110) — a year less than the usual deadline — and are subject to damage caps' ),
array( 'id' => 4364, 'surface' => 'content', 'expect' => 1,
 'from' => 'the South Carolina Tort Claims Act imposes additional notice requirements and shorter effective deadlines.',
 'to'   => 'the South Carolina Tort Claims Act shortens the filing deadline to two years (S.C. Code § 15-78-110).' ),

/* 1840 — georgia-statute-of-limitations */
array( 'id' => 1840, 'surface' => 'content', 'expect' => 1,
 'from' => '<td>Tort Claims Act notice required</td>',
 'to'   => '<td>2 years to file (S.C. Code § 15-78-110); 3 if a verified claim is filed within 1 year</td>' ),
array( 'id' => 1840, 'surface' => 'content', 'expect' => 1,
 'from' => '<p>Under the <strong>South Carolina Tort Claims Act (S.C. Code § 15-78-80)</strong>, claims against government entities must be filed within <strong>two years</strong> of the incident.',
 'to'   => '<p>Under the <strong>South Carolina Tort Claims Act</strong>, claims against government entities must be filed within <strong>two years</strong> of the incident (<strong>S.C. Code § 15-78-110</strong>). South Carolina requires no pre-suit notice: filing a verified claim with the agency within one year is optional, and doing so extends the deadline to three years (<strong>S.C. Code § 15-78-80</strong>).' ),
array( 'id' => 1840, 'surface' => 'takeaways', 'expect' => 1,
 'from' => "Government claims require earlier notice — six months in Georgia municipalities, two years under South Carolina's Tort Claims Act.",
 'to'   => "Government claims run on shorter clocks — ante litem notice within six months for a Georgia city, and a two-year filing deadline under South Carolina's Tort Claims Act." ),
array( 'id' => 1840, 'surface' => 'faq:5:answer', 'expect' => 1,
 'from' => 'South Carolina requires notice under the Tort Claims Act within two years under S.C. Code § 15-78-80.',
 'to'   => 'South Carolina requires no pre-suit notice, but the Tort Claims Act shortens the filing deadline to two years (S.C. Code § 15-78-110); filing a verified claim within one year is optional and extends it to three.' ),

/* 4354 — i-526-expansion-construction-zone-accidents-charleston */
array( 'id' => 4354, 'surface' => 'content', 'expect' => 1,
 'from' => 'requires filing a <strong>notice of claim within two years</strong> and imposes specific procedural requirements (S.C. Code Section 15-78-80)',
 'to'   => '<strong>two years</strong> to file suit (S.C. Code Section 15-78-110); filing a verified claim within one year is optional and extends that to three years (S.C. Code Section 15-78-80)' ),
array( 'id' => 4354, 'surface' => 'content', 'expect' => 1,
 'from' => 'you must file a notice of claim within two years under the South Carolina Tort Claims Act.',
 'to'   => 'you must file suit within two years under the South Carolina Tort Claims Act, not the usual three.' ),
array( 'id' => 4354, 'surface' => 'content', 'expect' => 1,
 'from' => 'meet the strict notice requirements and procedural rules for claims against SCDOT',
 'to'   => 'meet the two-year filing deadline and procedural rules for claims against SCDOT' ),
array( 'id' => 4354, 'surface' => 'faq:3:answer', 'expect' => 1,
 'from' => 'Government claims under the Tort Claims Act have additional notice requirements.',
 'to'   => 'Government claims under the Tort Claims Act must be filed within two years, not three.' ),

/* 4707 — i-526-mount-pleasant-wando-bridge-accident */
array( 'id' => 4707, 'surface' => 'content', 'expect' => 1,
 'from' => 'under the South Carolina Tort Claims Act require notice and filing within <strong>2 years</strong>',
 'to'   => 'under the South Carolina Tort Claims Act must be filed within <strong>2 years</strong>' ),
array( 'id' => 4707, 'surface' => 'content', 'expect' => 1,
 'from' => 'which requires written notice and filing within <strong>two years</strong>, and caps the damages you can recover.',
 'to'   => 'which requires filing within <strong>two years</strong>, and caps the damages you can recover.' ),
array( 'id' => 4707, 'surface' => 'content', 'expect' => 2,
 'from' => 'shortens that to two years and requires written notice.',
 'to'   => 'shortens that to two years.' ),

/* 4369 — personal-injury-claim-charleston-berkeley-dorchester-county */
array( 'id' => 4369, 'surface' => 'content', 'expect' => 1,
 'from' => 'Claims against government entities under the South Carolina Tort Claims Act require earlier notice.',
 'to'   => 'Claims against government entities must be filed within two years under the South Carolina Tort Claims Act, not three.' ),
array( 'id' => 4369, 'surface' => 'content', 'expect' => 1,
 'from' => 'claims against government entities may have shorter notice requirements under the South Carolina Tort Claims Act.',
 'to'   => 'claims against government entities must be filed within two years under the South Carolina Tort Claims Act.' ),
array( 'id' => 4369, 'surface' => 'faq:4:answer', 'expect' => 1,
 'from' => 'proceed under the SC Tort Claims Act with specific notice requirements and damage caps',
 'to'   => 'proceed under the SC Tort Claims Act with a two-year filing deadline and damage caps' ),

/* 4717 — pedestrian-accident-dorchester-road-school-zone-29418-north-charleston */
array( 'id' => 4717, 'surface' => 'content', 'expect' => 1,
 'from' => 'triggers a 2-year statutory deadline and a strict notice requirement',
 'to'   => 'triggers a 2-year filing deadline' ),
array( 'id' => 4717, 'surface' => 'content', 'expect' => 2,
 'from' => 'requires written notice and filing within two years.',
 'to'   => 'requires filing within two years.' ),
array( 'id' => 4717, 'surface' => 'content', 'expect' => 2,
 'from' => 'must be filed within two years — one year shorter than the standard SOL — and require timely written notice.',
 'to'   => 'must be filed within two years — one year shorter than the standard SOL.' ),

/* 4711 — sunset-boulevard-us-378-lexington-medical-center-accident */
// Only the visible copy carries this wording; the JSON-LD twin of this answer
// phrases it as "shortens that to two years and adds notice requirements",
// handled by the next edit. Verified by counting, not assumed — an expect of 2
// here is what aborted the first run.
array( 'id' => 4711, 'surface' => 'content', 'expect' => 1,
 'from' => 'requires written notice and filing within',
 'to'   => 'requires filing within' ),
array( 'id' => 4711, 'surface' => 'content', 'expect' => 2,
 'from' => 'shortens that to two years and adds notice requirements.',
 'to'   => 'shortens that to two years.' ),
array( 'id' => 4711, 'surface' => 'content', 'expect' => 2,
 'from' => 'applies — meaning a shortened deadline, a notice requirement, and potential damage caps.',
 'to'   => 'applies — meaning a two-year filing deadline instead of three, and potential damage caps.' ),

);

fprintf( $out, "%s\n\n", $apply ? '=== APPLY ===' : '=== DRY RUN (pass "apply" to write) ===' );

$backup = array(); $ok = 0; $skipped = 0;
$dirty_content = array(); $dirty_faqs = array(); $dirty_take = array(); $touched = array();

foreach ( $edits as $e ) {
	$id = (int) $e['id'];
	$expect = isset( $e['expect'] ) ? (int) $e['expect'] : 1;

	if ( ! isset( $backup[ $id ] ) ) {
		$row = $wpdb->get_row( $wpdb->prepare( "SELECT ID, post_name, post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
		if ( ! $row ) { fprintf( $out, "!! post %d not found\n", $id ); $skipped++; continue; }
		$backup[ $id ] = array(
			'ID' => $id, 'post_name' => $row->post_name, 'post_content' => $row->post_content,
			'faqs' => get_post_meta( $id, '_roden_faqs', true ),
			'takeaways' => get_post_meta( $id, '_roden_key_takeaways', true ),
		);
	}

	if ( 'content' === $e['surface'] || 'takeaways' === $e['surface'] ) {
		$is_take = ( 'takeaways' === $e['surface'] );
		$store   = $is_take ? $dirty_take : $dirty_content;
		$cur     = isset( $store[ $id ] ) ? $store[ $id ] : $backup[ $id ][ $is_take ? 'takeaways' : 'post_content' ];
		$n = substr_count( (string) $cur, $e['from'] );
		if ( $n !== $expect ) {
			fprintf( $out, "!! SKIP [%d] %s — matched %d, expected %d\n     %s…\n", $id, $e['surface'], $n, $expect, substr( $e['from'], 0, 84 ) );
			$skipped++; continue;
		}
		$new = str_replace( $e['from'], $e['to'], (string) $cur );
		if ( $is_take ) { $dirty_take[ $id ] = $new; } else { $dirty_content[ $id ] = $new; }
		$touched[ $id ] = true; $ok++;
		fprintf( $out, "OK   [%d] %s x%d\n     - %s…\n     + %s…\n", $id, $e['surface'], $n,
			substr( $e['from'], 0, 88 ), substr( $e['to'], 0, 88 ) );
		continue;
	}

	list( , $idx, ) = explode( ':', $e['surface'] );
	$idx  = (int) $idx;
	$faqs = isset( $dirty_faqs[ $id ] ) ? $dirty_faqs[ $id ] : $backup[ $id ]['faqs'];
	if ( ! is_array( $faqs ) || ! isset( $faqs[ $idx ]['answer'] ) ) {
		fprintf( $out, "!! SKIP [%d] faq[%d] missing\n", $id, $idx ); $skipped++; continue;
	}
	$n = substr_count( $faqs[ $idx ]['answer'], $e['from'] );
	if ( $n !== $expect ) {
		fprintf( $out, "!! SKIP [%d] faq[%d] — matched %d, expected %d\n", $id, $idx, $n, $expect );
		$skipped++; continue;
	}
	$faqs[ $idx ]['answer'] = str_replace( $e['from'], $e['to'], $faqs[ $idx ]['answer'] );
	$dirty_faqs[ $id ] = $faqs; $touched[ $id ] = true; $ok++;
	fprintf( $out, "OK   [%d] faq[%d]\n     - %s…\n     + %s…\n", $id, $idx, substr( $e['from'], 0, 88 ), substr( $e['to'], 0, 88 ) );
}

fprintf( $out, "\nedits: %d ok, %d skipped, %d posts\n", $ok, $skipped, count( $touched ) );

if ( $skipped > 0 ) {
	fprintf( $out, "\nABORTING — %d edit(s) did not match as expected. Nothing written.\n", $skipped );
	exit( 1 );
}
if ( ! $apply ) { fprintf( $out, "\nDry run only.\n" ); exit( 0 ); }

$file = sprintf( '/tmp/roden-tier1-batch2-backup-%s.json', gmdate( 'Ymd-His' ) );
file_put_contents( $file, wp_json_encode( array_values( $backup ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
fprintf( $out, "\nbackup: %s\n\n", $file );

foreach ( array_keys( $touched ) as $id ) {
	if ( isset( $dirty_content[ $id ] ) ) {
		$wpdb->update( $wpdb->posts, array( 'post_content' => $dirty_content[ $id ] ), array( 'ID' => $id ), array( '%s' ), array( '%d' ) );
	}
	if ( isset( $dirty_faqs[ $id ] ) )  { update_post_meta( $id, '_roden_faqs', $dirty_faqs[ $id ] ); }
	if ( isset( $dirty_take[ $id ] ) )  { update_post_meta( $id, '_roden_key_takeaways', $dirty_take[ $id ] ); }
	update_post_meta( $id, '_roden_last_refreshed', $today );

	$c  = $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	$f  = get_post_meta( $id, '_roden_faqs', true );
	$tk = (string) get_post_meta( $id, '_roden_key_takeaways', true );
	$blob = $c . ( is_array( $f ) ? wp_json_encode( $f ) : '' ) . $tk;
	$stale = 0;
	foreach ( $edits as $e ) { if ( (int) $e['id'] === $id ) { $stale += substr_count( $blob, $e['from'] ); } }
	fprintf( $out, "[%d] written · stale: %d %s\n", $id, $stale, $stale ? '!!' : 'OK' );
}
fprintf( $out, "\nDone. Flush both cache layers, then verify live.\n" );
