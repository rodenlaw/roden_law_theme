<?php
/**
 * Two miscitations found by the second systematic pass through the statute
 * inventory. Correct rules, wrong authorities — the pattern every pass on this
 * site has produced.
 *
 * CLASS 1 — the 0.08 limit cited to the wrong DUI statute.
 *
 *   § 56-5-2930 is DUI: driving "while under the influence of alcohol to the
 *   extent that the person's faculties to drive a motor vehicle are materially
 *   and appreciably impaired". It contains NO 0.08 threshold.
 *
 *   § 56-5-2933 is DUAC: driving "while his alcohol concentration is eight
 *   one-hundredths of one percent or more". That is the per se offence, and it
 *   requires no proof of impairment at all.
 *
 * Six instances across five pages attach the 0.08 figure to § 56-5-2930. One of
 * them labels the row "DUI Per Se Standard", which is exactly the offence
 * § 56-5-2930 is not. This repo already knew the distinction: the Act 42 brief
 * (docs/briefs/2026-08-26-sc-act42-liquor-liability.md) lists the three DUI
 * sections separately and correctly.
 *
 * NOT changed: /blog/summer-dui-accidents-charleston-memorial-day-labor-day/
 * states § 56-5-2930's impairment standard verbatim in its body and is right.
 * Only its FAQ was wrong.
 *
 * CLASS 2 — Georgia's wrongful-death deadline cited to a definitions section.
 *
 *   § 51-4-1 defines two terms — "full value of the life of the decedent" and
 *   "homicide". It contains no limitation period. The two-year wrongful death
 *   deadline is O.C.G.A. § 9-3-33.
 *
 * One page, and it is Spanish-only: /es/practice-areas/wrongful-death-lawyers/.
 * Its English twin (post 3609) cites neither section, so this was introduced in
 * the Spanish copy rather than translated from an English error. The substance
 * — two years from the date of death — is correct; only the authority is wrong.
 *
 * This is post content, not a gettext string, so the CLAUDE.md warning about
 * editing translated strings and silently dropping the Spanish does not apply.
 *
 * Statutes read 2026-09-03: § 56-5-2930 and § 56-5-2933 via the SC Code and
 * corroborating sources; § 51-4-1 via codes.findlaw.com.
 *
 * Run:  ssh $H "wp --path=... eval-file -" < bin/fix-duac-and-wrongful-death-cites.php
 *       (append ` apply` to write; default is a dry run)
 */

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

function roden_deep_replace( $v, $old, $new ) {
	if ( is_string( $v ) ) {
		return str_replace( $old, $new, $v );
	}
	if ( is_array( $v ) ) {
		foreach ( $v as $k => $vv ) {
			$v[ $k ] = roden_deep_replace( $vv, $old, $new );
		}
	}
	return $v;
}

$A = '<a href="https://www.scstatehouse.gov/code/t56c005.php" target="_blank" rel="noopener">';

$edits = array(
	array( 1703, 'post_content',
		'South Carolina follows the same standard under S.C. Code § 56-5-2930.',
		'South Carolina\'s per se standard is the same, under S.C. Code § 56-5-2933; § 56-5-2930 covers driving while materially and appreciably impaired.' ),

	array( 1703, 'post_content',
		'<td>0.08% BAC (S.C. Code § 56-5-2930)</td>',
		'<td>0.08% BAC (S.C. Code § 56-5-2933)</td>' ),

	array( 4177, 'post_content',
		$A . 'S.C. Code § 56-5-2930</a> prohibits driving with a BAC of .08% or higher or while materially and appreciably impaired.',
		$A . 'S.C. Code § 56-5-2933</a> prohibits driving with a BAC of .08% or higher, and § 56-5-2930 prohibits driving while materially and appreciably impaired.' ),

	array( 4083, 'post_content',
		$A . 'S.C. Code § 56-5-2930</a> prohibits driving with a BAC of 0.08% or higher. Felony DUI resulting in great bodily injury carries up to 15 years. DUI resulting in death carries up to 25 years.',
		$A . 'S.C. Code § 56-5-2933</a> prohibits driving with a BAC of 0.08% or higher, and § 56-5-2930 prohibits driving while materially and appreciably impaired. Felony DUI resulting in great bodily injury carries up to 15 years. DUI resulting in death carries up to 25 years.' ),

	array( 4076, 'post_content',
		$A . 'S.C. Code § 56-5-2930</a> prohibits driving with a BAC of 0.08% or higher. Felony DUI resulting in great bodily injury carries up to 15 years in prison.',
		$A . 'S.C. Code § 56-5-2933</a> prohibits driving with a BAC of 0.08% or higher, and § 56-5-2930 prohibits driving while materially and appreciably impaired. Felony DUI resulting in great bodily injury carries up to 15 years in prison.' ),

	array( 4360, '_roden_faqs',
		'0.08 percent BAC for drivers 21+ (S.C. Code section 56-5-2930). Lower limits apply to commercial drivers and underage drivers.',
		'0.08 percent BAC for drivers 21+ (S.C. Code section 56-5-2933). Driving while materially and appreciably impaired is a separate offence under section 56-5-2930. Lower limits apply to commercial drivers and underage drivers.' ),

	array( 4882, 'post_content',
		'En Georgia, la familia generalmente tiene 2 años (O.C.G.A. § 51-4-1) desde la fecha del fallecimiento',
		'En Georgia, la familia generalmente tiene 2 años (O.C.G.A. § 9-3-33) desde la fecha del fallecimiento' ),

	// The SAME miscitation in this page's FAQ, which also renders as FAQPage
	// structured data. The first version of this script fixed the body and left
	// this — the four-surfaces rule in CLAUDE.md, missed twice in one day by
	// scripts written to respect it. Checking the other three surfaces is not a
	// step you do once per class; it is a step you do per page, per edit.
	array( 4882, '_roden_faqs',
		'En Georgia, generalmente 2 años (O.C.G.A. § 51-4-1) desde el fallecimiento',
		'En Georgia, generalmente 2 años (O.C.G.A. § 9-3-33) desde el fallecimiento' ),
);

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
	echo "   -  " . mb_substr( $old, 0, 130 ) . "\n";
	echo "   +  " . mb_substr( $new, 0, 130 ) . "\n";
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
	foreach ( $edits as $n => $e ) {
		list( $id, $surface, $old, $new ) = $e;
		$now = ( 'post_content' === $surface ) ? get_post_field( 'post_content', $id ) : get_post_meta( $id, $surface, true );
		$now = is_array( $now ) ? wp_json_encode( $now, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) : (string) $now;
		$gone = false === strpos( $now, $old ); $present = false !== strpos( $now, $new );
		printf( "%s #%d %d/%s  old_gone=%s new_present=%s\n", ( $gone && $present ) ? 'OK  ' : 'FAIL',
			$n, $id, $surface, $gone ? 'yes' : 'NO', $present ? 'yes' : 'NO' );
		if ( ! $gone || ! $present ) { $ok = false; }
	}
}

echo "\n" . wp_json_encode( array( 'applied' => $APPLY, 'edits' => count( $edits ), 'ok' => $ok ) ) . "\n";

if ( ! $APPLY ) {
	echo "\n--- backup payload ---\n";
	$j = wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
	echo ( false === $j ) ? 'ENCODE FAILED' : $j;
	echo "\n";
}
