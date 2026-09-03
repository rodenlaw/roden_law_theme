<?php
/**
 * Corrects a false statement of South Carolina law: that S.C. Code § 56-5-3435
 * requires motorists to leave three feet when passing a cyclist.
 *
 * IT DOES NOT. The section reads, in full:
 *
 *   "A driver of a motor vehicle must at all times maintain a safe operating
 *    distance between the motor vehicle and a bicycle."
 *
 * Its own heading is "Driver to maintain safe operating distance between motor
 * vehicle and bicycle". There is no number in it. A 2019-2020 bill would have
 * defined "safe operating distance" as "not less than three feet"; it was not
 * enacted, and the definition is not in the current statute. South Carolina is
 * a safe-distance state, not a three-foot state.
 *
 * GEORGIA IS DIFFERENT, and that is the trap. O.C.G.A. § 40-6-56 does set three
 * feet expressly — change lanes if possible, otherwise reduce speed and "proceed
 * around the bicycle with at least three feet between such vehicle and the
 * bicycle at all times". Twelve pages carried Georgia's rule across the state
 * line, and one said so in terms: "same as Georgia."
 *
 * This is the first error found in this repo where the site invented a numeric
 * legal standard rather than misciting an existing one, and it is on the
 * bicycle pages a cyclist would actually read before calling.
 *
 * ALSO FIXED: /wrongful-death-lawyers/pedestrian-cyclist-fatality/ attributes
 * Georgia's passing duty to O.C.G.A. § 40-6-292, which governs how a bicycle is
 * RIDDEN — "shall not ride other than upon or astride a permanent and regular
 * seat" — and imposes no duty on motorists at all. The passing duty is
 * § 40-6-56.
 *
 * NOT changed: /practice-areas/bicycle-accident-lawyers/ already says South
 * Carolina "similarly requires a safe passing distance" without a number, which
 * is right. Its Georgia half understates § 40-6-56 as "generally interpreted as
 * at least 3 feet" when the statute says it outright — imprecise, not false,
 * and left alone.
 *
 * Statutes read 2026-09-03: § 56-5-3435 and the unenacted 2019-2020 bill via
 * the SC Code and Legislature; § 40-6-56 and § 40-6-292 via codes.findlaw.com.
 *
 * Run:  ssh $H "wp --path=... eval-file -" < bin/fix-sc-three-foot-passing-law.php
 *       (append ` apply` to write; default is a dry run)
 */

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

function roden_deep_replace( $v, $old, $new ) {
	if ( is_string( $v ) ) { return str_replace( $old, $new, $v ); }
	if ( is_array( $v ) ) { foreach ( $v as $k => $vv ) { $v[ $k ] = roden_deep_replace( $vv, $old, $new ); } }
	return $v;
}

// The four SC city bicycle pages share templated copy, so one pair covers all four.
$CITY = array( 4234, 4235, 4236, 4558 );

$body_old = 'South Carolina\'s <strong>safe-passing law (S.C. Code § 56-5-3435) requires motorists to leave at least three feet</strong> when passing a bicycle, and violating it is powerful evidence of negligence.';
$body_new = 'South Carolina\'s <strong>safe-passing law (S.C. Code § 56-5-3435) requires motorists to maintain a safe operating distance</strong> when passing a bicycle. The statute sets no fixed number of feet — unlike Georgia, which requires three (O.C.G.A. § 40-6-56) — and passing too closely for the speed and road is powerful evidence of negligence.';

// Only the FIRST sentence is shared across the four city pages; each follows it
// with city-specific copy (US-17, Rivers Avenue…). Replacing the whole answer
// refused on two of them, which is the single-occurrence guard doing its job.
$faq_old = 'South Carolina\'s safe-passing law, S.C. Code § 56-5-3435, requires a motorist to leave at least three feet of clearance when passing a bicycle.';
$faq_new = 'South Carolina\'s safe-passing law, S.C. Code § 56-5-3435, requires a motorist to maintain a safe operating distance when passing a bicycle. Unlike Georgia, which sets a three-foot minimum (O.C.G.A. § 40-6-56), the South Carolina statute names no fixed distance — what counts as safe depends on speed, road width and conditions.';

$edits = array();
foreach ( $CITY as $id ) {
	$edits[] = array( $id, 'post_content', $body_old, $body_new );
	$edits[] = array( $id, '_roden_faqs',  $faq_old,  $faq_new );
}

// Spanish twins.
$es_faq_a_old = 'La ley de rebase seguro de Carolina del Sur, S.C. Code § 56-5-3435, exige que el conductor deje al menos tres pies de espacio al rebasar una bicicleta.';
$es_faq_a_new = 'La ley de rebase seguro de Carolina del Sur, S.C. Code § 56-5-3435, exige que el conductor mantenga una distancia segura al rebasar una bicicleta. A diferencia de Georgia, que fija un mínimo de tres pies (O.C.G.A. § 40-6-56), la ley de Carolina del Sur no señala una distancia fija.';

$es_faq_b_old = 'La ley de rebase seguro de Carolina del Sur, S.C. Code § 56-5-3435, exige al conductor dejar al menos tres pies de espacio al pasar junto a una bicicleta.';
$es_faq_b_new = 'La ley de rebase seguro de Carolina del Sur, S.C. Code § 56-5-3435, exige al conductor mantener una distancia segura al pasar junto a una bicicleta. A diferencia de Georgia, que fija un mínimo de tres pies (O.C.G.A. § 40-6-56), la ley de Carolina del Sur no señala una distancia fija.';

$edits[] = array( 5190, '_roden_faqs', $es_faq_a_old, $es_faq_a_new );
foreach ( array( 5191, 5192, 5193 ) as $id ) {
	$edits[] = array( $id, '_roden_faqs', $es_faq_b_old, $es_faq_b_new );
}

$kt_a_old = 'y quien lo rebasa debe dejarle al menos tres pies de espacio (S.C. Code § 56-5-3435)';
$kt_a_new = 'y quien lo rebasa debe mantener una distancia segura (S.C. Code § 56-5-3435), sin un mínimo fijo de pies';
$kt_b_old = 'y quien lo rebasa debe dejarle al menos tres pies (S.C. Code § 56-5-3435)';
$kt_b_new = 'y quien lo rebasa debe mantener una distancia segura (S.C. Code § 56-5-3435), sin un mínimo fijo de pies';

foreach ( array( 5190, 5192 ) as $id ) { $edits[] = array( $id, '_roden_key_takeaways', $kt_a_old, $kt_a_new ); }
foreach ( array( 5191, 5193 ) as $id ) { $edits[] = array( $id, '_roden_key_takeaways', $kt_b_old, $kt_b_new ); }

// The hit-and-run blog post, both surfaces.
$edits[] = array( 1698, 'post_content',
	'<li><strong>Three-foot passing law (S.C. Code § 56-5-3435):</strong> Drivers must give cyclists at least 3 feet when passing — same as Georgia.</li>',
	'<li><strong>Safe-passing law (S.C. Code § 56-5-3435):</strong> Drivers must maintain a safe operating distance when passing a cyclist. South Carolina sets no fixed number of feet; Georgia does, at three (O.C.G.A. § 40-6-56).</li>' );

$edits[] = array( 1698, '_roden_faqs',
	'Yes. Both Georgia (O.C.G.A. § 40-6-56) and South Carolina (S.C. Code § 56-5-3435) require drivers to maintain at least <strong>3 feet of clearance</strong> when passing a cyclist. If the hit-and-run driver violated this law, it supports your negligence claim once they are identified.',
	'Georgia sets a three-foot minimum (O.C.G.A. § 40-6-56). South Carolina requires only a <strong>safe operating distance</strong> (S.C. Code § 56-5-3435) and names no fixed number of feet. If the driver passed unsafely for the speed and road, that supports your negligence claim once they are identified.' );

// The wrongful-death page: an invented SC "Three-Foot Law", and Georgia's duty
// attributed to the section that governs how a bicycle is ridden.
$edits[] = array( 4106, 'post_content',
	'Georgia\'s bicycle safety law (O.C.G.A. § 40-6-292) requires drivers to maintain a safe passing distance of at least 3 feet when overtaking a cyclist.',
	'Georgia\'s safe-passing law (O.C.G.A. § 40-6-56) requires a driver overtaking a cyclist to change lanes where possible, and otherwise to pass with at least three feet of clearance.' );

$edits[] = array( 4106, 'post_content',
	'South Carolina\'s "Three-Foot Law" requires motorists to provide at least 3 feet of clearance when passing a cyclist.',
	'South Carolina has no three-foot rule: S.C. Code § 56-5-3435 requires only that a driver maintain a safe operating distance from a bicycle at all times.' );

$backup = array(); $ok = true; $seen = array();

foreach ( $edits as $n => $e ) {
	list( $id, $surface, $old, $new ) = $e;
	if ( ! get_post( $id ) ) { echo "MISSING post $id\n"; $ok = false; continue; }

	$current  = ( 'post_content' === $surface ) ? get_post_field( 'post_content', $id ) : get_post_meta( $id, $surface, true );
	$is_array = is_array( $current );
	$hay      = $is_array ? wp_json_encode( $current, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) : (string) $current;

	$hits = substr_count( $hay, $old );
	if ( 1 !== $hits ) { echo "REFUSE #$n $id/$surface — expected 1, found $hits\n"; $ok = false; continue; }
	if ( false !== strpos( $hay, $new ) ) { echo "SKIP #$n $id/$surface — already applied\n"; continue; }

	$key = $id . '/' . $surface;
	if ( ! isset( $seen[ $key ] ) ) { $backup[] = array( 'id' => $id, 'surface' => $surface, 'before' => $hay ); $seen[ $key ] = true; }

	echo ( $APPLY ? 'APPLY ' : 'DRYRUN' ) . " #$n  $id/$surface\n";
	if ( ! $APPLY ) { continue; }

	if ( 'post_content' === $surface ) {
		$res = wp_update_post( array( 'ID' => $id, 'post_content' => str_replace( $old, $new, $hay ) ), true );
		if ( is_wp_error( $res ) ) { echo "   ERROR " . $res->get_error_message() . "\n"; $ok = false; }
	} else {
		$upd   = $is_array ? roden_deep_replace( $current, $old, $new ) : str_replace( $old, $new, $hay );
		$check = is_array( $upd ) ? wp_json_encode( $upd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) : $upd;
		if ( false !== strpos( $check, $old ) || false === strpos( $check, $new ) ) {
			echo "   ERROR replacement did not take\n"; $ok = false; continue;
		}
		update_post_meta( $id, $surface, $upd );
	}
}

if ( $APPLY ) {
	echo "\n--- verify ---\n";
	$fail = 0;
	foreach ( $edits as $n => $e ) {
		list( $id, $surface, $old, $new ) = $e;
		$now = ( 'post_content' === $surface ) ? get_post_field( 'post_content', $id ) : get_post_meta( $id, $surface, true );
		$now = is_array( $now ) ? wp_json_encode( $now, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) : (string) $now;
		if ( false !== strpos( $now, $old ) || false === strpos( $now, $new ) ) {
			printf( "FAIL #%d %d/%s\n", $n, $id, $surface ); $fail++; $ok = false;
		}
	}
	echo ( 0 === $fail ) ? "all " . count( $edits ) . " edits verified\n" : "$fail FAILED\n";
}

echo "\n" . wp_json_encode( array( 'applied' => $APPLY, 'edits' => count( $edits ), 'surfaces' => count( $seen ), 'ok' => $ok ) ) . "\n";

if ( ! $APPLY ) {
	echo "\n--- backup payload ---\n";
	$j = wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
	echo ( false === $j ) ? 'ENCODE FAILED' : $j;
	echo "\n";
}
