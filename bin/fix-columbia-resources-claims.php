<?php
/**
 * Columbia car legal sweep follow-ups L2, L3 and L6 (punitive)
 * (data/facts/remediation-2026-09-28-columbia-car.md). Owner, 2026-09-28: "let's
 * fix these last 4 items before moving on". Every legal sentence rests on the
 * signed SC pack.
 *
 * - L2: § 15-78-80 cited as the SCTCA / its damage caps (4687, 4680, 4679,
 *   4678). The caps are § 15-78-120 and the deadline § 15-78-110; § 15-78-80 is
 *   the optional verified claim.
 * - L3: Carolina Crossroads (4687) "$2.08 billion" -> $2.69 billion, the project
 *   site's figure (scdotcarolinacrossroads.com, read 2026-09-28; 14 miles,
 *   134,000+ vehicles a day and mid-2030s confirmed there); the unsourced
 *   "busiest interchange system in South Carolina" cut. The "I-26/I-20/I-77
 *   interchange" anchors (4687, 4654, 4655), which point at the rewritten 4656,
 *   now describe the interchanges as they are.
 * - Follow-up sweep (same day): 4655 put the I-20/I-77 interchange "south of
 *   Columbia" (it is northeast of downtown); 4687 called the whole corridor
 *   Malfunction Junction (it is the I-20/I-26 interchange inside it).
 * - L6: /blog/guide-after-a-car-accident-in-columbia-sc/ (3518) gave "extreme
 *   negligence or recklessness" as the punitive standard. The conduct standard
 *   has no pack authority, so the sentence now states only the burden
 *   (SC 15-33-135).
 *
 * Content/excerpt: direct column write (post_modified untouched). Meta:
 * update_post_meta( wp_slash() ). Each replacement must match exactly the
 * expected number of times; every write is read back.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/fix-columbia-resources-claims.php > docs/backups/columbia-resources-claims-2026-09-28.json
 *   ssh $H "wp --path=$P eval-file - apply" < bin/fix-columbia-resources-claims.php > docs/backups/columbia-resources-claims-2026-09-28.json
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

$apply = isset( $args[0] ) && 'apply' === $args[0];
global $wpdb;

$tca_table_from = 'SC Tort Claims Act, S.C. Code &sect; 15-78-80</a>)';
$tca_table_to   = 'SC Tort Claims Act, S.C. Code &sect;&sect; 15-78-110, 15-78-120</a>)';
$hub            = '<a href="/resources/columbia-i-26-i-20-i-77-interchange-truck-accidents/">';

// array( post ID, field, from, to, expected count ). Field: content | excerpt | takeaways | faqN.
$edits = array(
	// 4687 Carolina Crossroads.
	array( 4687, 'content', 'A $2.08 Billion Fix', 'A $2.69 Billion Fix', 1 ),
	array( 4687, 'content', '$2.08 billion SCDOT initiative', '$2.69 billion SCDOT initiative', 1 ),
	array( 4687, 'content', ', making it the busiest interchange system in South Carolina.', '.', 1 ),
	array( 4687, 'content', 'The ' . $hub . 'I-26/I-20/I-77 interchange area</a> remains one of the most complex navigation challenges for commercial truckers in the Midlands.', 'The ' . $hub . 'interchanges where I-20, I-26 and I-77 meet</a> add their own merges and lane choices for commercial truckers.', 1 ),
	array( 4687, 'content', 'SC Tort Claims Act (S.C. Code &sect; 15-78-80)</a>, which imposes damage caps and procedural requirements. Filing deadlines for government claims may be shorter than the standard statute of limitations.', 'SC Tort Claims Act</a>. Suit must be filed within two years, or three years if a verified claim is filed with the agency within one year (S.C. Code &sect;&sect; 15-78-110, 15-78-80), and recovery is capped at $300,000 per person and $600,000 per occurrence (S.C. Code &sect; 15-78-120).', 1 ),
	array( 4687, 'content', $tca_table_from, $tca_table_to, 1 ),
	array( 4687, 'content', '>I-26/I-20/I-77 Interchange Truck Accidents</a>', '>Columbia Interstate Interchange Truck Accidents</a>', 1 ),
	array( 4687, 'excerpt', 'The $2.08 billion Carolina Crossroads project', 'The $2.69 billion Carolina Crossroads project', 1 ),
	array( 4687, 'takeaways', '$2.08 billion SCDOT initiative', '$2.69 billion SCDOT initiative', 1 ),
	array( 4687, 'faq0', 'Carolina Crossroads is a $2.08 billion SCDOT project', 'Carolina Crossroads is a $2.69 billion SCDOT project', 1 ),
	array( 4687, 'faq4', 'subject to the SC Tort Claims Act (S.C. Code Section 15-78-80), which imposes damage caps and specific procedural requirements.', 'subject to the South Carolina Tort Claims Act: suit must be filed within two years, or three years if a verified claim is filed with the agency within one year (S.C. Code §§ 15-78-110, 15-78-80), and recovery is capped at $300,000 per person and $600,000 per occurrence (S.C. Code § 15-78-120).', 1 ),
	// 4687: the 14-mile corridor contains Malfunction Junction; it is not it (follow-up sweep, recommended).
	array( 4687, 'content', 'in Columbia &mdash; the interchange complex long known as <strong>&ldquo;Malfunction Junction.&rdquo;</strong>', 'in Columbia, which includes the I-20/I-26 interchange long known as <strong>&ldquo;Malfunction Junction.&rdquo;</strong>', 1 ),
	array( 4687, 'takeaways', 'in Columbia &mdash; known as <strong>&ldquo;Malfunction Junction&rdquo;</strong> &mdash; carrying', 'in Columbia, including the I-20/I-26 interchange known as <strong>&ldquo;Malfunction Junction&rdquo;</strong>, and carrying', 1 ),
	array( 4687, 'faq0', 'corridor in Columbia, long known as Malfunction Junction.', 'corridor in Columbia, including the I-20/I-26 interchange long known as Malfunction Junction.', 1 ),
	// Liability tables.
	array( 4680, 'content', $tca_table_from, $tca_table_to, 1 ),
	array( 4679, 'content', $tca_table_from, $tca_table_to, 1 ),
	array( 4678, 'content', $tca_table_from, $tca_table_to, 1 ),
	// Anchors to the rewritten interchange resource.
	array( 4654, 'content', 'The ' . $hub . 'I-26/I-20/I-77 interchange complex</a> is a crash hotspot directly attributable to this convergence.', 'Much of that merging happens at the ' . $hub . 'interchanges where I-20, I-26 and I-77 meet</a>.', 1 ),
	array( 4655, 'content', 'This is part of the larger ' . $hub . 'I-26/I-20/I-77 interchange complex</a> — one of the most dangerous in South Carolina.', 'It is one of the ' . $hub . 'interchanges where I-20, I-26 and I-77 meet</a>.', 1 ),
	// 4655: the I-20/I-77 interchange is northeast of downtown, not south (follow-up sweep R1).
	array( 4655, 'content', 'is adjacent to I-77 south of Columbia, generating', 'is adjacent to I-77 on the east side of Columbia, generating', 1 ),
	array( 4655, 'content', '<li>The I-77/I-20 interchange south of Columbia is one of the <strong>most congested truck junctions</strong> in the Midlands</li>', '<li>The I-77/I-20 interchange northeast of downtown Columbia carries truck traffic between Charlotte and I-20</li>', 1 ),
	array( 4655, 'content', '<h3>I-77/I-20 Interchange (South Columbia)</h3>', '<h3>I-77/I-20 Interchange (Northeast Columbia)</h3>', 1 ),
	array( 4655, 'content', 'The interchange where I-77 meets I-20 south of Columbia is a critical convergence point', 'The interchange where I-77 meets I-20 northeast of downtown Columbia is a critical convergence point', 1 ),
	array( 4655, 'content', 'from the I-20 interchange south of Columbia to Rock Hill', 'from the I-20 interchange northeast of downtown Columbia to Rock Hill', 1 ),
	// 3518 punitive standard.
	array( 3518, 'content', '<td>Awarded in rare cases to punish the at-fault party for extreme negligence or recklessness.</td>', '<td>Awarded only in rare cases, and must be proved by clear and convincing evidence (S.C. Code § 15-33-135).</td>', 1 ),
);

$by = array();
foreach ( $edits as $e ) {
	$by[ $e[0] ][] = $e;
}

$backup = array( 'generated' => gmdate( 'c' ), 'batch' => 'columbia-resources-claims', 'mode' => $apply ? 'apply' : 'dry-run', 'posts' => array() );
foreach ( $by as $id => $list ) {
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT post_status, post_content, post_excerpt FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	if ( ! $row || 'publish' !== $row->post_status ) {
		fwrite( STDERR, "ABORT: {$id} is not published.\n" );
		exit( 1 );
	}
	$cur = array(
		'content'   => (string) $row->post_content,
		'excerpt'   => (string) $row->post_excerpt,
		'takeaways' => (string) get_post_meta( $id, '_roden_key_takeaways', true ),
		'faqs'      => get_post_meta( $id, '_roden_faqs', true ),
	);
	$new = $cur;
	foreach ( $list as $e ) {
		list( , $field, $from, $to, $want ) = $e;
		if ( 0 === strpos( $field, 'faq' ) ) {
			$i    = (int) substr( $field, 3 );
			$text = isset( $new['faqs'][ $i ]['answer'] ) ? $new['faqs'][ $i ]['answer'] : '';
		} else {
			$text = $new[ $field ];
		}
		$n = substr_count( $text, $from );
		if ( $n !== $want ) {
			fwrite( STDERR, "ABORT: {$id} {$field}: found {$n}, expected {$want}: " . substr( $from, 0, 70 ) . "\n" );
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
	$wpdb->update( $wpdb->posts, array( 'post_content' => $new['content'], 'post_excerpt' => $new['excerpt'] ), array( 'ID' => $id ), array( '%s', '%s' ), array( '%d' ) );
	if ( $new['takeaways'] !== $cur['takeaways'] ) {
		update_post_meta( $id, '_roden_key_takeaways', wp_slash( $new['takeaways'] ) );
	}
	if ( $new['faqs'] !== $cur['faqs'] ) {
		update_post_meta( $id, '_roden_faqs', wp_slash( $new['faqs'] ) );
	}
	clean_post_cache( $id );
	wp_cache_delete( $id, 'post_meta' );
	$back = $wpdb->get_row( $wpdb->prepare( "SELECT post_content, post_excerpt FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	if ( $back->post_content !== $new['content'] || $back->post_excerpt !== $new['excerpt']
		|| (string) get_post_meta( $id, '_roden_key_takeaways', true ) !== $new['takeaways']
		|| get_post_meta( $id, '_roden_faqs', true ) !== $new['faqs'] ) {
		fwrite( STDERR, "FAILED: read-back mismatch on {$id}\n" );
		exit( 1 );
	}
}

echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fwrite( STDERR, sprintf( "\n%s: %d edits across %d posts\n", $apply ? 'Fixed' : 'Would fix', count( $edits ), count( $by ) ) );
