<?php
/**
 * One-shot: de-duplicate the "What to Do After…" headings on the three SC
 * car-accident city pages.
 *
 * Those pages render two near-identical consecutive H2s: the post body's own
 * "What to Do After a Car Accident in {City}" and the template's
 * "…in {City}, {ST}" from roden_what_to_do_steps(). Two headings competing to
 * answer one question splits the extraction signal.
 *
 * The body version is the one worth keeping — it names the local police
 * agencies, the local trauma centre and the local office number, where the
 * template's list is the same generic six steps on every car-accident page.
 * But the template block also feeds the HowTo JSON-LD, so it stays. Retitling
 * the body heading resolves the collision without dropping either.
 *
 * Run from the repo over stdin — never added to the theme:
 *   ssh $H "wp --path=$P eval-file -" < bin/retitle-what-to-do-duplicates.php
 */

$map = array(
	3624 => array( 'Charleston', 'Your Charleston Crash Checklist' ),
	3625 => array( 'Columbia', 'Your Columbia Crash Checklist' ),
	3626 => array( 'Myrtle Beach', 'Your Myrtle Beach Crash Checklist' ),
);

foreach ( $map as $id => $pair ) {
	list( $city, $new_heading ) = $pair;

	$post = get_post( $id );
	if ( ! $post ) {
		printf( "%d  SKIP  post not found\n", $id );
		continue;
	}

	$old = sprintf( '<h2>What to Do After a Car Accident in %s</h2>', $city );
	$new = sprintf( '<h2>%s</h2>', $new_heading );

	if ( false !== strpos( $post->post_content, $new ) ) {
		printf( "%d  SKIP  already applied (%s)\n", $id, $post->post_title );
		continue;
	}

	$n = substr_count( $post->post_content, $old );
	if ( 1 !== $n ) {
		printf( "%d  SKIP  expected 1 match for old heading, found %d\n", $id, $n );
		continue;
	}

	$updated = str_replace( $old, $new, $post->post_content );

	$res = wp_update_post(
		array(
			'ID'           => $id,
			'post_content' => $updated,
		),
		true
	);

	if ( is_wp_error( $res ) ) {
		printf( "%d  ERROR %s\n", $id, $res->get_error_message() );
		continue;
	}

	$check = get_post( $id );
	printf(
		"%d  OK    %s\n           old heading still present: %s | new heading present: %s\n",
		$id,
		$post->post_title,
		false !== strpos( $check->post_content, $old ) ? 'YES (BAD)' : 'no',
		false !== strpos( $check->post_content, $new ) ? 'yes' : 'NO (BAD)'
	);
}
