<?php
/**
 * Points the "Savannah personal injury attorneys" anchors at the Savannah page.
 *
 * Nine anchors across nine blog posts read "Savannah personal injury attorneys"
 * and pointed at the STATEWIDE pillar, because no Savannah page existed. It does
 * now: bin/create-savannah-pi-page.php built it.
 *
 * SEQUENCE WORTH RECORDING. Before the redirect-hop pass these anchors pointed at
 * /savannah/personal-injury-lawyers/, which 301'd -- to a 404 until #112, then to
 * the pillar. The hop pass rewrote them to the pillar directly, which was correct
 * for the destination that existed at the time. Now that the real page exists,
 * they point at it. Three passes, each right for what was true when it ran.
 *
 * Only the pillar target is rewritten, and only where the anchor text names
 * Savannah -- the same href carries correct generic anchor text elsewhere on
 * these pages and must not move.
 *
 * Run:  ssh $H "wp --path=... eval-file -" < bin/point-savannah-anchors.php
 *       (append ` apply` to write; default is a dry run)
 */

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );
$TEXT  = 'Savannah personal injury attorneys';
$DEST  = '/personal-injury-lawyers/savannah-ga/';

if ( ! url_to_postid( home_url( $DEST ) ) ) { echo "DESTINATION DOES NOT RESOLVE: $DEST\n"; return; }
echo "destination resolves\n\n";

$backup = array(); $total = 0;

foreach ( get_posts( array(
	'post_type' => array( 'post', 'page', 'resource', 'practice_area' ),
	'post_status' => 'publish', 'numberposts' => -1, 'suppress_filters' => true,
) ) as $p ) {
	$c = $p->post_content;
	if ( false === strpos( $c, '>' . $TEXT . '</a>' ) ) { continue; }

	$new = $c; $n = 0;
	foreach ( array(
		'/practice-areas/personal-injury-lawyers/',
		'https://rodenlaw.com/practice-areas/personal-injury-lawyers/',
	) as $old ) {
		$pattern = '#<a href="' . preg_quote( $old, '#' ) . '"([^>]*)>' . preg_quote( $TEXT, '#' ) . '</a>#';
		$hits = preg_match_all( $pattern, $new );
		if ( ! $hits ) { continue; }
		$new = preg_replace( $pattern, '<a href="' . $DEST . '"$1>' . $TEXT . '</a>', $new );
		$n += $hits;
	}

	if ( ! $n ) { continue; }

	$backup[] = array( 'id' => $p->ID, 'surface' => 'post_content', 'before' => $c );
	$total   += $n;
	printf( "%s %-5d +%d  %s\n", $APPLY ? 'APPLY ' : 'DRYRUN', $p->ID, $n, wp_make_link_relative( get_permalink( $p ) ) );

	if ( ! $APPLY ) { continue; }
	$res = wp_update_post( wp_slash( array( 'ID' => $p->ID, 'post_content' => $new ) ), true );
	if ( is_wp_error( $res ) ) { echo "   ERROR " . $res->get_error_message() . "\n"; }
}

if ( $APPLY ) {
	$left = 0;
	foreach ( $backup as $b ) {
		$c = get_post_field( 'post_content', $b['id'] );
		if ( preg_match( '#<a href="[^"]*/practice-areas/personal-injury-lawyers/"[^>]*>' . preg_quote( $TEXT, '#' ) . '</a>#', $c ) ) { $left++; }
	}
	printf( "\n--- verify ---\nanchors still on the pillar: %d (expected 0)\n", $left );
}

echo "\n" . wp_json_encode( array( 'applied' => $APPLY, 'anchors' => $total, 'pages' => count( $backup ) ) ) . "\n";

if ( ! $APPLY ) {
	echo "\n--- backup payload ---\n";
	$j = wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
	echo ( false === $j ) ? 'ENCODE FAILED' : $j;
	echo "\n";
}
