<?php
/**
 * Troubled-teen page (post 4574): Gillin's SC ruling on packet Q1/Q2
 * (sc-signoff-packet-2026-10-21.md), option B. Roden co-counsels these cases
 * and other firms handle them, so the page says so, and the firm-level
 * "decades" and "history of proven results" claims come off this page.
 * "Experienced" stays. Costs language is unchanged (not ruled on yet).
 *
 * Owner, 2026-10-26: "he picked B, apply it".
 *
 * Exact-match guards: each needle once, in its surface only, or abort before
 * writing. post_content via wp_update_post( wp_slash() ) (leaves a revision);
 * _roden_faqs[5] via update_post_meta( wp_slash() ); read back both.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/apply-troubled-teen-cocounsel-wording.php   # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/apply-troubled-teen-cocounsel-wording.php   # write
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$id    = 4574;
$index = 5;
$line  = 'Roden Law works with co-counsel firms that focus on institutional abuse cases nationwide. Our firm stays involved as co-counsel on your case.';

$body = array(
	'At Roden Law, we have been fighting for injured victims for decades. We have a knowledgeable team of experienced and compassionate attorneys who are prepared to manage your case with the tenacity it deserves.'
		=> 'At Roden Law, we fight for injured victims. We have a knowledgeable team of experienced and compassionate attorneys. ' . $line,
	'Our firm has decades of experience advocating for the injured and a history of proven results.'
		=> 'Our firm is committed to advocating for the injured.',
);
$faq_from = 'Yes. Roden Law is licensed in Georgia and South Carolina and has decades of experience advocating for injured and abused victims.';
$faq_to   = 'Yes. Roden Law is licensed in Georgia and South Carolina and advocates for injured and abused victims. ' . $line;

$p = get_post( $id );
if ( ! $p || 'troubled-teen-industry-abuse' !== $p->post_name || 'publish' !== $p->post_status ) {
	fwrite( STDERR, "ABORT: $id is not the published troubled-teen page\n" );
	exit( 1 );
}
$content = $p->post_content;
foreach ( $body as $from => $to ) {
	$n = substr_count( $content, $from );
	if ( 1 !== $n ) {
		fwrite( STDERR, "ABORT: body needle found $n times: $from\n" );
		exit( 1 );
	}
	$content = str_replace( $from, $to, $content );
}

$faqs = get_post_meta( $id, '_roden_faqs', true );
if ( ! is_array( $faqs ) || ! isset( $faqs[ $index ]['answer'] ) ) {
	fwrite( STDERR, "ABORT: $id has no _roden_faqs[$index]\n" );
	exit( 1 );
}
$hits = array();
foreach ( $faqs as $i => $f ) {
	$n = substr_count( (string) $f['answer'], $faq_from );
	if ( $n ) {
		$hits[ $i ] = $n;
	}
}
if ( array( $index => 1 ) !== $hits ) {
	fwrite( STDERR, 'ABORT: FAQ needle matched ' . wp_json_encode( $hits ) . " (expected once at $index)\n" );
	exit( 1 );
}
$after = $faqs;
$after[ $index ]['answer'] = str_replace( $faq_from, $faq_to, $after[ $index ]['answer'] );

foreach ( array( 'decades', 'proven results' ) as $gone ) {
	$left = substr_count( strtolower( $content . wp_json_encode( $after ) ), $gone );
	if ( $left ) {
		fwrite( STDERR, "ABORT: '$gone' still appears $left times after the edit\n" );
		exit( 1 );
	}
}

echo "$id: content " . strlen( $p->post_content ) . ' -> ' . strlen( $content ) . " bytes\n";
echo "  faq[$index] - " . $faqs[ $index ]['answer'] . "\n  faq[$index] + " . $after[ $index ]['answer'] . "\n";
if ( ! $apply ) {
	echo "DRY RUN\n";
	exit( 0 );
}

$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $content ) ), true );
if ( is_wp_error( $r ) ) {
	fwrite( STDERR, 'FAIL: ' . $r->get_error_message() . "\n" );
	exit( 1 );
}
update_post_meta( $id, '_roden_faqs', wp_slash( $after ) );
update_post_meta( $id, '_roden_content_modified', wp_slash( gmdate( 'Y-m-d H:i:s' ) ) );
wp_cache_delete( $id, 'post_meta' );
clean_post_cache( $id );
$ok = get_post( $id )->post_content === $content && get_post_meta( $id, '_roden_faqs', true ) === $after;
echo ( $ok ? 'OK' : 'MISMATCH' ) . ": read-back\n";
exit( $ok ? 0 : 1 );
