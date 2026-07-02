<?php
/**
 * Seeder: dog-bite-lawyers × Columbia, SC intersection page (ENRICH)
 *
 * UPDATES the existing templated stub /dog-bite-lawyers/columbia-sc/ in place with rich,
 * practice-specific, hyperlocal body content + FAQPage meta + attorney attribution.
 * Part of P2 row-9 BATCH 5 enrichment (2026-06).
 *
 * The intersection template auto-generates the SC state-law box, "what to do" steps,
 * negligence/elements, compensation block, Key Takeaways, attorneys, case results, and
 * the FAQ accordion. post_content here ADDS only what the template lacks.
 *
 * Usage:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-dogbite-columbia.php
 * Safe to re-run: updates the existing page in place (does NOT create a new one).
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Enriching dog-bite-lawyers × Columbia, SC...' );

$pillar = get_page_by_path( 'dog-bite-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
	WP_CLI::error( 'Pillar "dog-bite-lawyers" not found. Seed the pillar first.' );
}
$pillar_id   = $pillar->ID;
$attorney_id = ( $p = get_page_by_path( 'graeham-c-gillin', OBJECT, 'attorney' ) ) ? $p->ID : 0;
WP_CLI::log( "Pillar ID: {$pillar_id} | Attorney ID: {$attorney_id}" );

$content = <<<'HTML'
<p><strong>Roden Law represents dog-bite and animal-attack victims across Columbia, South Carolina</strong> and the Midlands — Lexington, Irmo, West Columbia, Cayce, and Forest Acres. South Carolina is a <strong>strict-liability state</strong>: a dog owner is liable for a bite or attack even if the dog never showed aggression before. We handle every case on a <strong>contingency fee basis: you pay nothing unless we win</strong>. Roden Law has recovered <strong>more than $300 million</strong> for injured clients across Georgia and South Carolina and holds a <strong>4.9-star average from hundreds of client reviews</strong>. Call <a href="tel:+18032192816">(803) 219-2816</a> for a free, confidential case review.</p>

<h2>Why Choose Roden Law for a Columbia Dog Bite Claim</h2>
<p>Most dog-bite recoveries come from the owner's homeowner's or renter's insurance, and adjusters routinely argue the victim provoked the animal or was somewhere they should not have been. What separates Roden Law is direct attorney involvement and the investigation needed to defeat those defenses. Our office at 1545 Sumter Street, Suite B sits in the downtown corridor minutes from the Richland County Circuit Court.</p>
<ul>
<li><strong>No fee unless we win</strong> — free consultation and no out-of-pocket cost to pursue your claim.</li>
<li><strong>We find the coverage</strong> — homeowner's and renter's policies are the usual source of recovery, and we identify every policy that applies.</li>
<li><strong>Full-value focus</strong> — dog attacks often cause scarring, nerve damage, and facial injuries to children, and we account for all of it before any settlement.</li>
</ul>

<h2>Dog Attacks in the Columbia Area</h2>
<p>Serious animal attacks happen across the Midlands — at homes and rental properties, in apartment complexes, on sidewalks and neighborhood streets, and during visits to a neighbor's or friend's property. Children are frequent victims and often suffer facial injuries because of their height relative to the animal. Identifying the responsible owner and the correct homeowner's or renter's insurance policy is often the first and most important step in a Columbia dog-attack case.</p>

<h2>South Carolina Dog Bite Law You Should Know</h2>
<p>South Carolina is a <strong>strict-liability state under S.C. Code § 47-3-110</strong>. That means a dog owner (or the person having the dog in their care) is liable for a bite or attack <strong>regardless of whether the animal had ever shown viciousness before</strong> — there is <strong>no "one-bite" rule</strong> in South Carolina. The law covers both <strong>bites and other attacks</strong>. The main exceptions are where the victim <strong>provoked</strong> the animal or was <strong>trespassing or otherwise unlawfully on the property</strong>. The deadline to file is generally <strong>three years from the date of injury under S.C. Code § 15-3-530</strong>, and South Carolina places <strong>no cap on compensatory damages</strong> in ordinary injury cases. Learn more on our <a href="/practice-areas/dog-bite-lawyers/">South Carolina dog bite lawyers</a> page.</p>
HTML;

$existing = get_posts( array(
	'post_type'      => 'practice_area',
	'post_status'    => array( 'publish', 'draft' ),
	'post_parent'    => $pillar_id,
	'name'           => 'columbia-sc',
	'posts_per_page' => 1,
) );

$postarr = array(
	'post_type'    => 'practice_area',
	'post_status'  => 'publish',
	'post_title'   => 'Dog Bite Lawyers in Columbia, SC',
	'post_name'    => 'columbia-sc',
	'post_content' => $content,
	'post_parent'  => $pillar_id,
);

if ( $existing ) {
	$post_id       = $existing[0]->ID;
	$postarr['ID'] = $post_id;
	wp_update_post( $postarr );
	WP_CLI::log( "Updated existing post ID: {$post_id}" );
} else {
	$post_id = wp_insert_post( $postarr, true );
	if ( is_wp_error( $post_id ) ) {
		WP_CLI::error( 'Failed to create page: ' . $post_id->get_error_message() );
	}
	WP_CLI::log( "Created post ID: {$post_id}" );
}

update_post_meta( $post_id, '_roden_pa_office_key', 'columbia' );
update_post_meta( $post_id, '_roden_office_key', 'columbia' );
update_post_meta( $post_id, '_roden_jurisdiction', 'south-carolina' );
if ( $attorney_id ) {
	update_post_meta( $post_id, '_roden_author_attorney', $attorney_id );
}

$faqs = array(
	array(
		'question' => 'Who are the best dog bite lawyers in Columbia, SC?',
		'answer'   => 'Roden Law is a leading personal-injury firm serving Columbia and the Midlands, with a 4.9-star average from hundreds of client reviews and more than $300 million recovered for injured clients across Georgia and South Carolina. Our Columbia office at 1545 Sumter Street handles every case on a contingency fee basis — no fee unless we win. Call (803) 219-2816 for a free consultation.',
	),
	array(
		'question' => 'Is South Carolina a strict-liability state for dog bites?',
		'answer'   => 'Yes. Under S.C. Code § 47-3-110, South Carolina imposes strict liability on dog owners. The owner is liable for a bite or attack regardless of whether the dog had ever shown aggression before — there is no "one-bite" rule. The law covers both bites and other attacks.',
	),
	array(
		'question' => 'Do I have to prove the dog bit someone before?',
		'answer'   => 'No. Because South Carolina uses strict liability, you do not have to prove the owner knew the dog was dangerous or that it had bitten anyone previously. Liability generally applies to the first bite or attack, unless you provoked the animal or were unlawfully on the property.',
	),
	array(
		'question' => 'Who pays for a dog attack injury in South Carolina?',
		'answer'   => 'In most cases the dog owner\'s homeowner\'s or renter\'s insurance provides the recovery. Roden Law investigates ownership and identifies every applicable policy, which is often the most important step in a Columbia dog-attack case.',
	),
	array(
		'question' => 'What if the dog attack injured my child?',
		'answer'   => 'Children are frequent dog-attack victims and often suffer facial injuries and scarring. A parent can bring a claim on the child\'s behalf, and South Carolina places no cap on compensatory damages in ordinary injury cases, so future scar-revision surgery and other long-term needs can be pursued.',
	),
	array(
		'question' => 'How long do I have to file a dog bite claim in South Carolina?',
		'answer'   => 'The general deadline is three years from the date of injury under S.C. Code § 15-3-530. It is best to have your case reviewed as soon as possible so ownership, insurance, and evidence can be preserved.',
	),
);
update_post_meta( $post_id, '_roden_faqs', $faqs );

WP_CLI::success( "Enriched /dog-bite-lawyers/columbia-sc/ — post ID {$post_id}" );
