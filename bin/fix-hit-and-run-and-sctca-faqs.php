<?php
/**
 * Linked-page errors from the North Charleston car legal sweep, L1 and L8
 * (data/facts/remediation-2026-09-28-north-charleston-car.md). Owner, 2026-09-28:
 * "fix those FAQs and then do the last wave 1 pages". Every corrected sentence
 * rests on the signed SC pack; Georgia sentences are unchanged.
 *
 * - 4645 /blog/north-charleston-crime-rate-hit-and-run/: leaving the scene of an
 *   injury crash is a misdemeanor unless the injury is great bodily injury (felony,
 *   up to 10 years) or someone dies (felony, up to 25 years) (SC 56-5-1210). UM is
 *   required and UIM only offered (SC 38-77-150, SC 38-77-160); the post said
 *   "UM/UIM required" in one place and "offer UM" in another.
 * - 4059 government-vehicle FAQ 2 (and FAQPage): "against a single government
 *   entity" contradicted the corrected body; the caps apply however many
 *   entities are involved (SC 15-78-120). Body intro: notice deadlines scoped to
 *   Georgia and federal claims.
 * - 4054 commercial-vehicle FAQ 4 and 4061 bus FAQ 5: "notice" requirements
 *   stated for South Carolina, which has none; its Tort Claims Act sets a filing
 *   deadline (SC 15-78-110, SC 15-78-80).
 *
 * Content: direct column write (post_modified untouched). Meta:
 * update_post_meta( wp_slash() ). Exact-match once each; read back.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/fix-hit-and-run-and-sctca-faqs.php > docs/backups/hit-and-run-sctca-faqs-2026-09-28.json
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-hit-and-run-and-sctca-faqs.php > docs/backups/hit-and-run-sctca-faqs-2026-09-28.json
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

$apply = isset( $args[0] ) && 'apply' === $args[0];
global $wpdb;

// array( post ID, field, from, to ). Field: content | takeaways | faqN.
$edits = array(
	array( 4645, 'content',
		'Leaving the scene of an accident involving injury is a felony in South Carolina (S.C. Code § 56-5-1210), carrying up to 25 years in prison if the crash resulted in death.',
		'Leaving the scene of a crash that injures someone is a crime in South Carolina (S.C. Code § 56-5-1210): a misdemeanor for an injury, a felony carrying up to 10 years when the injury is great bodily injury, and a felony carrying up to 25 years when someone dies.' ),
	array( 4645, 'content',
		'<li>SC law requires insurers to offer UM coverage on every auto policy</li>',
		'<li>SC law requires UM coverage on every auto policy (S.C. Code § 38-77-150)</li>' ),
	array( 4645, 'takeaways',
		'South Carolina requires UM/UIM coverage on every auto policy.',
		'South Carolina requires uninsured motorist (UM) coverage on every auto policy (S.C. Code § 38-77-150); underinsured motorist (UIM) coverage must be offered but can be declined (S.C. Code § 38-77-160).' ),
	array( 4059, 'faq2',
		'South Carolina caps recovery at $300,000 per claimant and $600,000 per occurrence against a single government entity.',
		'South Carolina caps recovery at $300,000 per person and $600,000 per occurrence, however many government entities are involved (S.C. Code § 15-78-120).' ),
	array( 4059, 'content',
		'These cases demand strict compliance with notice deadlines and filing procedures — missing even one requirement can permanently bar your claim.',
		'These cases demand strict compliance with notice deadlines (in Georgia and federal claims) and filing deadlines — missing even one requirement can permanently bar your claim.' ),
	array( 4054, 'faq4',
		'You may file a claim against the government entity, but strict notice requirements and shorter filing deadlines apply. In Georgia, you must provide ante litem notice before suing. South Carolina has its own tort claims act with specific procedures.',
		'You may file a claim against the government entity, but special rules apply. In Georgia, you must provide ante litem notice before suing. South Carolina requires no notice, but its Tort Claims Act sets a two-year filing deadline, or three years if a verified claim is filed with the agency within one year (S.C. Code §§ 15-78-110, 15-78-80).' ),
	array( 4061, 'faq5',
		'If the bus was operated by a government entity, shorter notice deadlines may apply.',
		'If the bus was operated by a government entity, shorter deadlines apply: in Georgia, shorter notice deadlines may apply, and in South Carolina suit must be filed within two years, or three years if a verified claim is filed with the agency within one year (S.C. Code §§ 15-78-110, 15-78-80).' ),
);

$by = array();
foreach ( $edits as $e ) {
	$by[ $e[0] ][] = $e;
}
$backup = array( 'generated' => gmdate( 'c' ), 'batch' => 'hit-and-run-sctca-faqs', 'mode' => $apply ? 'apply' : 'dry-run', 'posts' => array() );
foreach ( $by as $id => $list ) {
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT post_status, post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	if ( ! $row || 'publish' !== $row->post_status ) {
		fwrite( STDERR, "ABORT: {$id} is not published.\n" );
		exit( 1 );
	}
	$cur = array( 'content' => (string) $row->post_content, 'takeaways' => (string) get_post_meta( $id, '_roden_key_takeaways', true ), 'faqs' => get_post_meta( $id, '_roden_faqs', true ) );
	$new = $cur;
	foreach ( $list as $e ) {
		list( , $field, $from, $to ) = $e;
		if ( 0 === strpos( $field, 'faq' ) ) {
			$i    = (int) substr( $field, 3 );
			$text = isset( $new['faqs'][ $i ]['answer'] ) ? $new['faqs'][ $i ]['answer'] : '';
		} else {
			$text = $new[ $field ];
		}
		if ( 1 !== substr_count( $text, $from ) ) {
			fwrite( STDERR, "ABORT: {$id} {$field} does not contain the sentence exactly once: " . substr( $from, 0, 60 ) . "\n" );
			exit( 1 );
		}
		$text = str_replace( $from, $to, $text );
		if ( 0 === strpos( $field, 'faq' ) ) {
			$new['faqs'][ $i ]['answer'] = $text;
		} else {
			$new[ $field ] = $text;
		}
	}
	$backup['posts'][] = array( 'ID' => $id, 'before' => $cur, 'after' => $new );
	fwrite( STDERR, sprintf( "  %s %d %s (%d edits)\n", $apply ? 'fixed' : 'would fix', $id, wp_make_link_relative( get_permalink( $id ) ), count( $list ) ) );
	if ( ! $apply ) {
		continue;
	}
	if ( $new['content'] !== $cur['content'] ) {
		$wpdb->update( $wpdb->posts, array( 'post_content' => $new['content'] ), array( 'ID' => $id ), array( '%s' ), array( '%d' ) );
	}
	if ( $new['takeaways'] !== $cur['takeaways'] ) {
		update_post_meta( $id, '_roden_key_takeaways', wp_slash( $new['takeaways'] ) );
	}
	if ( $new['faqs'] !== $cur['faqs'] ) {
		update_post_meta( $id, '_roden_faqs', wp_slash( $new['faqs'] ) );
	}
	clean_post_cache( $id );
	wp_cache_delete( $id, 'post_meta' );
	if ( (string) $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) ) !== $new['content']
		|| (string) get_post_meta( $id, '_roden_key_takeaways', true ) !== $new['takeaways']
		|| get_post_meta( $id, '_roden_faqs', true ) !== $new['faqs'] ) {
		fwrite( STDERR, "FAILED: read-back mismatch on {$id}\n" );
		exit( 1 );
	}
}
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fwrite( STDERR, sprintf( "\n%s: %d edits across %d posts\n", $apply ? 'Fixed' : 'Would fix', count( $edits ), count( $by ) ) );
