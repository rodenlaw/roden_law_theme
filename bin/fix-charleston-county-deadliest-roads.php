<?php
/**
 * Correct the "four deadliest roads in Charleston County" misreading wherever it
 * still lives — eight instances across four pages, in all four places a claim
 * can hide.
 *
 * The source is real and says something else. Live 5 News, July 2026, citing
 * SCDOT traffic data: "four of the county's five deadliest roads are in North
 * Charleston" — Rivers Avenue, Dorchester Road, Ashley Phosphate Road and
 * Remount Road. The pages turned that into a Charleston County top-four, which
 * claims a higher rank than the evidence supports: the four are not the county's
 * four deadliest, they are the four IN NORTH CHARLESTON among its five deadliest.
 *
 * This exact misreading was corrected on /resources/rivers-avenue-truck-accidents-
 * north-charleston/ on 2026-08-25 — in the BODY. Its own key takeaways and FAQ
 * still carried it three weeks later, which is the failure mode this repo keeps
 * rediscovering: fix one surface and the claim is still published three other
 * ways. _roden_faqs also renders into FAQPage structured data and post_excerpt
 * into the Article description, so a wrong one is published twice over.
 *
 *   #4664 resource  body                                (Ashley Phosphate)
 *   #4674 resource  body, excerpt, takeaways, FAQ[0]    (Dorchester Road)
 *   #4663 resource  takeaways, FAQ[0]                   (Rivers Avenue — body already correct)
 *   #4617 resource  FAQ[0]                              (Dangerous roads, North Charleston)
 *
 * Each replacement takes the wording already proven on #4663's body, and the
 * two body edits carry the citation link with it — an unsourced superlative
 * becoming a smaller, checkable, cited fact is the outcome these rounds aim for.
 *
 * NOT changed, deliberately:
 *   - #4674's H2 "One of Charleston County's Deadliest Corridors for Truck
 *     Accidents". Under the corrected reading it is true: the road IS among the
 *     county's five deadliest. "One of" claims no rank the source denies.
 *   - #4339 "one of the deadliest roads for pedestrians in all of South
 *     Carolina" and #4538 "the most dangerous road in the City of Savannah".
 *     Different claims against different sources; they need their own
 *     assessment, not this script's find-and-replace.
 *
 * Run from the repo over stdin — never added to the theme:
 *   ssh rodenlawprod "wp --path=$P eval-file -"       < bin/fix-charleston-county-deadliest-roads.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply" < bin/fix-charleston-county-deadliest-roads.php
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

$apply = isset( $args[0] ) && 'apply' === $args[0];

$cite_html = '(<a href="https://www.live5news.com/2026/07/31/last-chance-weigh-your-commute-helps-shape-north-charlestons-next-road-safety-projects/" rel="nofollow noopener">Live 5 News</a>, July 2026)';

$edits = array(

	// ---- #4664 Ashley Phosphate, body -------------------------------------
	array(
		'id'    => 4664,
		'field' => 'post_content',
		'from'  => 'Ashley Phosphate Road is one of the <strong>four deadliest roads in Charleston County</strong>, alongside Rivers Avenue, Dorchester Road, and Remount Road — all in North Charleston.',
		'to'    => 'South Carolina Department of Transportation traffic data places Ashley Phosphate Road among <strong>Charleston County\'s five deadliest roads</strong> — four of which run through North Charleston, alongside Rivers Avenue, Dorchester Road and Remount Road ' . $cite_html . '.',
	),

	// ---- #4674 Dorchester Road --------------------------------------------
	array(
		'id'    => 4674,
		'field' => 'post_content',
		'from'  => '<strong>Dorchester Road</strong> is one of the <strong>four deadliest roads in Charleston County</strong>, alongside Rivers Avenue, Ashley Phosphate Road, and Remount Road.',
		'to'    => '<strong>Dorchester Road</strong> is one of <strong>Charleston County\'s five deadliest roads</strong> in South Carolina Department of Transportation traffic data — four of which run through North Charleston, alongside Rivers Avenue, Ashley Phosphate Road and Remount Road ' . $cite_html . '.',
	),
	array(
		'id'    => 4674,
		'field' => 'post_excerpt',
		'from'  => 'Dorchester Road is one of the four deadliest roads in Charleston County.',
		'to'    => 'Dorchester Road is one of Charleston County\'s five deadliest roads in SCDOT traffic data, four of which run through North Charleston.',
	),
	array(
		'id'    => 4674,
		'field' => '_roden_key_takeaways',
		'from'  => 'Dorchester Road is one of the <strong>four deadliest roads in Charleston County</strong>, carrying',
		'to'    => 'Dorchester Road is one of <strong>Charleston County\'s five deadliest roads</strong> in SCDOT traffic data &mdash; four of which run through North Charleston &mdash; carrying',
	),
	array(
		'id'    => 4674,
		'field' => '_roden_faqs',
		'from'  => 'Dorchester Road is one of the four deadliest roads in Charleston County due to its mix',
		'to'    => 'Dorchester Road is one of Charleston County\'s five deadliest roads in South Carolina Department of Transportation traffic data, four of which run through North Charleston. Its danger comes from its mix',
	),

	// ---- #4663 Rivers Avenue (body was fixed 2026-08-25; meta was not) -----
	array(
		'id'    => 4663,
		'field' => '_roden_key_takeaways',
		'from'  => 'Rivers Avenue (US-52) is one of the <strong>four deadliest roads in Charleston County</strong> and North Charleston\'s primary commercial corridor.',
		'to'    => 'Rivers Avenue (US-52) is one of <strong>Charleston County\'s five deadliest roads</strong> in SCDOT traffic data &mdash; four of which run through North Charleston &mdash; and is the city\'s primary commercial corridor.',
	),
	array(
		'id'    => 4663,
		'field' => '_roden_faqs',
		'from'  => 'Rivers Avenue is one of the four deadliest roads in Charleston County, alongside Ashley Phosphate Road, Dorchester Road and Remount Road.',
		'to'    => 'Rivers Avenue is one of Charleston County\'s five deadliest roads in South Carolina Department of Transportation traffic data &mdash; four of which run through North Charleston, alongside Ashley Phosphate Road, Dorchester Road and Remount Road.',
	),

	// ---- #4617 Dangerous roads, North Charleston --------------------------
	array(
		'id'    => 4617,
		'field' => '_roden_faqs',
		'from'  => 'Ashley Phosphate is also one of the four deadliest roads in Charleston County, alongside Rivers Avenue, Dorchester Road and Remount Road.',
		'to'    => 'Ashley Phosphate is also one of Charleston County\'s five deadliest roads in South Carolina Department of Transportation traffic data &mdash; four of which run through North Charleston, alongside Rivers Avenue, Dorchester Road and Remount Road.',
	),
);

$backup = array();
$failed = false;

foreach ( $edits as $e ) {
	$id    = $e['id'];
	$field = $e['field'];
	$post  = get_post( $id );

	if ( ! $post ) {
		printf( "ABORT  #%d not found\n", $id );
		$failed = true;
		continue;
	}

	// Read the current value of whichever surface this edit targets.
	if ( 'post_content' === $field || 'post_excerpt' === $field ) {
		$value = $post->$field;
	} elseif ( '_roden_faqs' === $field ) {
		$faqs  = (array) get_post_meta( $id, '_roden_faqs', true );
		$value = null;
		$idx   = null;
		foreach ( $faqs as $i => $f ) {
			if ( isset( $f['answer'] ) && false !== strpos( $f['answer'], $e['from'] ) ) {
				$idx   = $i;
				$value = $f['answer'];
				break;
			}
		}
		if ( null === $idx ) {
			printf( "SKIP   #%d %s — no FAQ answer contains the string\n", $id, $field );
			continue;
		}
	} else {
		$value = (string) get_post_meta( $id, $field, true );
	}

	$hits = substr_count( $value, $e['from'] );
	if ( 1 !== $hits ) {
		printf( "SKIP   #%d %s — expected 1 occurrence, found %d\n", $id, $field, $hits );
		if ( 0 === $hits ) {
			continue;
		}
		$failed = true;
		continue;
	}

	$new = str_replace( $e['from'], $e['to'], $value );

	printf( "#%d %s%s\n", $id, $field, isset( $idx ) && null !== $idx ? " [FAQ $idx]" : '' );
	printf( "  from: %s\n", trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( $e['from'] ) ) ) );
	printf( "  to:   %s\n", trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( $e['to'] ) ) ) );

	$backup[] = array(
		'ID'    => $id,
		'slug'  => $post->post_name,
		'field' => $field . ( isset( $idx ) && null !== $idx ? "[$idx].answer" : '' ),
		'was'   => $value,
	);

	if ( ! $apply ) {
		unset( $idx );
		continue;
	}

	if ( 'post_content' === $field || 'post_excerpt' === $field ) {
		// wp_update_post() unslashes what it is handed — always wp_slash().
		$res = wp_update_post( wp_slash( array( 'ID' => $id, $field => $new ) ), true );
		if ( is_wp_error( $res ) ) {
			printf( "  ERROR %s\n", $res->get_error_message() );
			$failed = true;
			unset( $idx );
			continue;
		}
		$check = get_post( $id );
		$after = $check->$field;
	} elseif ( '_roden_faqs' === $field ) {
		$faqs[ $idx ]['answer'] = $new;
		// update_post_meta() unslashes too — slash the whole array so backslashes
		// anywhere else in it survive.
		update_post_meta( $id, '_roden_faqs', wp_slash( $faqs ) );
		$now   = (array) get_post_meta( $id, '_roden_faqs', true );
		$after = isset( $now[ $idx ]['answer'] ) ? $now[ $idx ]['answer'] : '';
	} else {
		update_post_meta( $id, $field, wp_slash( $new ) );
		$after = (string) get_post_meta( $id, $field, true );
	}

	if ( $after !== $new ) {
		printf( "  ERROR write did not round-trip\n" );
		$failed = true;
	} else {
		printf( "  OK    written\n" );
	}
	unset( $idx );
}

// Nothing of the claim class may survive anywhere.
echo "\n-- post-write sweep: 'four deadliest roads in Charleston' --\n";
global $wpdb;
$like  = '%' . $wpdb->esc_like( 'four deadliest roads in Charleston' ) . '%';
$left  = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status='publish' AND ( post_content LIKE %s OR post_excerpt LIKE %s )", $like, $like ) );
$left += (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_key IN ('_roden_faqs','_roden_key_takeaways','_roden_seo_title') AND meta_value LIKE %s", $like ) );
printf( "  surviving rows: %d%s\n", $left, ( $apply && $left ) ? '  <-- NOT CLEAN' : '' );
if ( $apply && $left ) {
	$failed = true;
}

echo "\n-- backup (save to docs/backups/) --\n";
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "\n";

printf( "\n%s  %d instance(s)%s\n", $apply ? 'APPLIED' : 'DRY RUN', count( $backup ), $apply ? '' : ' — re-run with: apply' );

if ( $failed ) {
	exit( 1 );
}
