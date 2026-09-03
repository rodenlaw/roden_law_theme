<?php
/**
 * Corrects the criminal penalties stated for hit-and-run in both states.
 *
 * Found by the first systematic pass through bin/inventory-statute-citations.php
 * — verifying the highest-exposure statutes the site cites rather than waiting
 * for an error to surface by accident.
 *
 * S.C. Code § 56-5-1210, read against scstatehouse.gov/code/t56c005.php on
 * 2026-09-03, has three tiers:
 *
 *   injury                30 days – 1 year,   $100 – $5,000
 *   great bodily injury   30 days – 10 years, $5,000 – $10,000
 *   death                 1 year – 25 years,  $10,000 – $25,000
 *
 * O.C.G.A. § 40-6-270, read against codes.findlaw.com on the same day:
 *
 *   serious injury OR death   felony, 1 – 5 years
 *   other injury / property   misdemeanor, up to 12 months
 *
 * Most of the site states these correctly — "up to 10 years for injury and up to
 * 25 years for fatality" appears verbatim on four pages and is right. Two pages
 * are wrong:
 *
 *   1698  a comparison table putting SC's DEATH maximum (25 years) in the
 *         INJURY row, and giving Georgia a 3-15 year range for death that
 *         § 40-6-270 does not contain. Its FAQ repeats the first error.
 *   4051  a FAQ asserting Georgia penalties "increase to 3 to 15 years" on
 *         death. They do not. § 40-6-270 is 1-5 years for serious injury and
 *         for death alike. The 3-to-15-year sentence is homicide by vehicle in
 *         the first degree, O.C.G.A. § 40-6-393 — a different offence, and the
 *         likely source of the error.
 *
 * Both pages also called hit-and-run with any injury a felony in Georgia. It is
 * a felony for SERIOUS injury; lesser injury is a misdemeanor. Tightened in the
 * same edit rather than left, because the sentences were being rewritten anyway.
 *
 * NOT changed: /blog/what-to-do-after-car-accident-south-carolina/ says "up to
 * 25 years in prison if someone dies", which is correct, and the four pages
 * stating the 10/25 split correctly.
 *
 * Run:  ssh $H "wp --path=... eval-file -" < bin/fix-hit-and-run-penalties.php
 *       (append ` apply` to write; default is a dry run)
 */

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

/** Replace inside every string leaf of a nested array, leaving structure intact. */
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

$edits = array(
	array( 1698, 'post_content',
		'<td>Felony: up to 25 years if serious injury (S.C. Code § 56-5-1210)</td>',
		'<td>Felony: 30 days to 10 years for great bodily injury (S.C. Code § 56-5-1210)</td>' ),

	array( 1698, 'post_content',
		'<td>Felony: 3-15 years (O.C.G.A. § 40-6-270)</td>',
		'<td>Felony: 1-5 years (O.C.G.A. § 40-6-270)</td>' ),

	array( 1698, '_roden_faqs',
		'Yes. Hit and run involving injury is a <strong>felony</strong> in both states. In Georgia, penalties include 1-5 years imprisonment (O.C.G.A. § 40-6-270). In South Carolina, penalties can reach up to 25 years for serious injury or death (S.C. Code § 56-5-1210).',
		'Yes, where the injury is serious. In Georgia, leaving the scene of a crash causing serious injury or death is a <strong>felony</strong> carrying 1-5 years (O.C.G.A. § 40-6-270); lesser injuries are a misdemeanor. In South Carolina the penalty is up to 10 years for great bodily injury, and up to 25 years where the crash causes death (S.C. Code § 56-5-1210).' ),

	array( 4051, '_roden_faqs',
		'Under O.C.G.A. § 40-6-270, leaving the scene of an accident with injuries is a felony in Georgia, punishable by 1 to 5 years in prison. If the accident results in death, penalties increase to 3 to 15 years.',
		'Under O.C.G.A. § 40-6-270, leaving the scene of an accident causing serious injury or death is a felony in Georgia, punishable by 1 to 5 years in prison — the same range in both cases. Leaving a crash involving lesser injury or property damage is a misdemeanor. The 3-to-15-year sentence sometimes quoted is homicide by vehicle in the first degree (O.C.G.A. § 40-6-393), a separate offence.' ),
);

$backup = array();
$ok     = true;
$seen   = array();

foreach ( $edits as $n => $e ) {
	list( $id, $surface, $old, $new ) = $e;

	if ( ! get_post( $id ) ) {
		echo "MISSING post $id\n";
		$ok = false;
		continue;
	}

	if ( 'post_content' === $surface ) {
		$current = get_post_field( 'post_content', $id );
	} else {
		$current = get_post_meta( $id, $surface, true );
	}

	$is_array = is_array( $current );
	$hay      = $is_array ? wp_json_encode( $current, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) : (string) $current;

	$hits = substr_count( $hay, $old );
	if ( 1 !== $hits ) {
		echo "REFUSE #$n $id/$surface — expected 1 occurrence, found $hits (" . ( $is_array ? 'array' : 'string' ) . ")\n";
		$ok = false;
		continue;
	}
	if ( false !== strpos( $hay, $new ) ) {
		echo "SKIP #$n $id/$surface — replacement already present\n";
		continue;
	}

	$key = $id . '/' . $surface;
	if ( ! isset( $seen[ $key ] ) ) {
		$backup[]      = array( 'id' => $id, 'surface' => $surface, 'before' => $hay );
		$seen[ $key ]  = true;
	}

	echo ( $APPLY ? 'APPLY ' : 'DRYRUN' ) . " #$n  $id/$surface\n";
	echo "   -  " . substr( $old, 0, 155 ) . "\n";
	echo "   +  " . substr( $new, 0, 155 ) . "\n";

	if ( ! $APPLY ) {
		continue;
	}

	if ( 'post_content' === $surface ) {
		$res = wp_update_post( array( 'ID' => $id, 'post_content' => str_replace( $old, $new, $hay ) ), true );
		if ( is_wp_error( $res ) ) {
			echo "   ERROR " . $res->get_error_message() . "\n";
			$ok = false;
		}
	} else {
		$updated = $is_array ? roden_deep_replace( $current, $old, $new ) : str_replace( $old, $new, $hay );
		$check   = is_array( $updated ) ? wp_json_encode( $updated, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) : $updated;
		if ( false !== strpos( $check, $old ) || false === strpos( $check, $new ) ) {
			echo "   ERROR replacement did not take\n";
			$ok = false;
			continue;
		}
		update_post_meta( $id, $surface, $updated );
	}
}

if ( $APPLY ) {
	echo "\n--- verify ---\n";
	foreach ( $edits as $n => $e ) {
		list( $id, $surface, $old, $new ) = $e;
		if ( 'post_content' === $surface ) {
			$now = get_post_field( 'post_content', $id );
		} else {
			$now = get_post_meta( $id, $surface, true );
			$now = is_array( $now ) ? wp_json_encode( $now, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) : (string) $now;
		}
		$gone    = false === strpos( $now, $old );
		$present = false !== strpos( $now, $new );
		printf( "%s #%d %d/%s  old_gone=%s new_present=%s\n",
			( $gone && $present ) ? 'OK  ' : 'FAIL', $n, $id, $surface,
			$gone ? 'yes' : 'NO', $present ? 'yes' : 'NO' );
		if ( ! $gone || ! $present ) {
			$ok = false;
		}
	}
}

echo "\n" . wp_json_encode( array( 'applied' => $APPLY, 'edits' => count( $edits ), 'ok' => $ok ) ) . "\n";

if ( ! $APPLY ) {
	echo "\n--- backup payload ---\n";
	$j = wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
	echo ( false === $j ) ? 'ENCODE FAILED' : $j;
	echo "\n";
}
