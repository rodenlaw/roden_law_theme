<?php
/**
 * Second half of the § 56-5-3435 correction.
 *
 * bin/fix-sc-three-foot-passing-law.php fixed every instance that CITED the
 * statute. It left seven that assert the same false three-foot rule with no
 * citation at all — an intro paragraph on each of the four South Carolina city
 * bicycle pages, two "unsafe passing … without the required three feet" bullets,
 * and one e-scooter page.
 *
 * The sweep had flagged these from the start, under its own "SC + 3 feet, no
 * citation" label. I fixed the cited ones and moved on. An uncited false
 * statement of law is not less false; it is only harder to grep.
 *
 * § 56-5-3435 requires a "safe operating distance" and names no number. Georgia
 * requires three feet expressly (O.C.G.A. § 40-6-56).
 *
 * Run:  ssh $H "wp --path=... eval-file -" < bin/fix-sc-three-foot-uncited.php
 *       (append ` apply` to write; default is a dry run)
 */

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

$intro_old = 'In South Carolina a cyclist has the <strong>same rights and duties on the road as the driver of a car</strong>, and motorists must give at least three feet when passing.';
$intro_new = 'In South Carolina a cyclist has the <strong>same rights and duties on the road as the driver of a car</strong>, and motorists must maintain a safe operating distance when passing (S.C. Code § 56-5-3435).';

$edits = array();
foreach ( array( 4234, 4235, 4236, 4558 ) as $id ) {
	$edits[] = array( $id, 'post_content', $intro_old, $intro_new );
}

$edits[] = array( 4234, 'post_content',
	'<li><strong>Unsafe passing</strong> — motorists squeezing past cyclists without the required three feet of clearance.</li>',
	'<li><strong>Unsafe passing</strong> — motorists squeezing past cyclists without the safe operating distance the law requires.</li>' );

$edits[] = array( 4558, 'post_content',
	'<li><strong>Unsafe passing on Rivers Avenue and other wide corridors</strong> — high-speed traffic squeezing past cyclists without the required three feet.</li>',
	'<li><strong>Unsafe passing on Rivers Avenue and other wide corridors</strong> — high-speed traffic squeezing past cyclists without a safe operating distance.</li>' );

$edits[] = array( 4224, 'post_content',
	'Motorists owe e-scooter riders a duty of care and must maintain a safe passing distance — at least three feet when overtaking, similar to the bicycle passing law.',
	'Motorists owe e-scooter riders a duty of care and must maintain a safe passing distance when overtaking, as with a bicycle. Georgia sets that distance at three feet (O.C.G.A. § 40-6-56); South Carolina requires a safe operating distance without naming a figure (S.C. Code § 56-5-3435).' );

$backup = array(); $ok = true; $seen = array();

foreach ( $edits as $n => $e ) {
	list( $id, $surface, $old, $new ) = $e;
	$hay  = get_post_field( 'post_content', $id );
	$hits = substr_count( $hay, $old );
	if ( 1 !== $hits ) { echo "REFUSE #$n $id — expected 1, found $hits\n"; $ok = false; continue; }
	if ( false !== strpos( $hay, $new ) ) { echo "SKIP #$n $id — already applied\n"; continue; }

	if ( ! isset( $seen[ $id ] ) ) { $backup[] = array( 'id' => $id, 'surface' => $surface, 'before' => $hay ); $seen[ $id ] = true; }
	echo ( $APPLY ? 'APPLY ' : 'DRYRUN' ) . " #$n  $id\n";
	if ( ! $APPLY ) { continue; }

	$res = wp_update_post( array( 'ID' => $id, 'post_content' => str_replace( $old, $new, $hay ) ), true );
	if ( is_wp_error( $res ) ) { echo "   ERROR " . $res->get_error_message() . "\n"; $ok = false; }
}

if ( $APPLY ) {
	$fail = 0;
	foreach ( $edits as $n => $e ) {
		list( $id, $surface, $old, $new ) = $e;
		$now = get_post_field( 'post_content', $id );
		if ( false !== strpos( $now, $old ) || false === strpos( $now, $new ) ) { printf( "FAIL #%d %d\n", $n, $id ); $fail++; $ok = false; }
	}
	echo ( 0 === $fail ) ? "\nall " . count( $edits ) . " edits verified\n" : "\n$fail FAILED\n";
}

echo "\n" . wp_json_encode( array( 'applied' => $APPLY, 'edits' => count( $edits ), 'ok' => $ok ) ) . "\n";

if ( ! $APPLY ) {
	echo "\n--- backup payload ---\n";
	$j = wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
	echo ( false === $j ) ? 'ENCODE FAILED' : $j;
	echo "\n";
}
