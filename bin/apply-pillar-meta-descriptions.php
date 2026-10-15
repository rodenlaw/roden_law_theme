<?php
/**
 * Pillar meta descriptions — 2026-10-15.
 *
 * 16 of the 24 English practice-area pillars have no `_roden_meta_description`
 * and no excerpt, so three surfaces fall back to templates:
 *
 *   <meta name="description">  "Car Accident Lawyers serving Georgia & South
 *                              Carolina. Over $300M+ recovered. Free
 *                              consultation…" (roden_seo_auto_desc_practice_area)
 *   LegalService description   first 30 words of post_content
 *   /llms.txt, /llms-full.txt  "Roden Law's X Lawyers represent injury victims
 *                              … With over $300 million recovered…"
 *
 * All three read `_roden_meta_description` first (llms.txt since this same
 * change), so one value per pillar fixes all three. The field is in the
 * content-meta export — regenerate content/meta.json after applying.
 *
 * The descriptions state SCOPE only: the kinds of case and who is typically
 * liable, drawn from each pillar's own `_roden_common_causes` and
 * `_roden_common_injuries`. No statute, deadline, statistic or outcome claim, so
 * nothing here can go stale or wrong the way a filing deadline can. Each is ≤160
 * characters (the length every surface truncates to).
 *
 * Guards: resolves each path to a published, top-level practice_area or aborts;
 * refuses to overwrite a pillar that already has a description (motorcycle and
 * workers' comp do, and are left alone).
 *
 *   ssh $H "wp --path=$P eval-file -" < bin/apply-pillar-meta-descriptions.php       # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/apply-pillar-meta-descriptions.php # apply
 *
 * Apply also rebuilds the static /llms.txt files: a meta write fires no
 * save_post, which is the only other thing that regenerates them.
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );

$descriptions = array(
	'/practice-areas/boating-accident-lawyers/'      => 'Boating and personal watercraft injury claims in Georgia and South Carolina — distracted or impaired operators, reckless speed, and untrained drivers.',
	'/practice-areas/brain-injury-lawyers/'          => 'Traumatic brain injury claims in Georgia and South Carolina, from concussions to severe TBI caused by vehicle crashes, falls, and workplace accidents.',
	'/practice-areas/burn-injury-lawyers/'           => 'Burn injury claims in Georgia and South Carolina from house and apartment fires, workplace explosions, defective products, and chemical exposure.',
	'/practice-areas/car-accident-lawyers/'          => 'Car accident injury claims in Georgia and South Carolina — distracted, drunk, and speeding drivers, uninsured motorists, and disputes over who was at fault.',
	'/practice-areas/construction-accident-lawyers/' => 'Construction injury claims in Georgia and South Carolina: falls from scaffolds and roofs, falling objects, electrocution, trench collapses, and crane failures.',
	'/practice-areas/dog-bite-lawyers/'              => 'Dog bite and animal attack claims in Georgia and South Carolina, including owner and landlord liability and claims against homeowner\'s insurance.',
	'/practice-areas/maritime-injury-lawyers/'       => 'Injury claims for seamen, longshoremen, and dock and port workers in Georgia and South Carolina — deck falls, vessel collisions, and crane and rigging failures.',
	'/practice-areas/medical-malpractice-lawyers/'   => 'Medical malpractice claims in Georgia and South Carolina: misdiagnosis and delayed diagnosis, surgical errors, medication errors, and missed tests.',
	'/practice-areas/nursing-home-abuse-lawyers/'    => 'Nursing home abuse and neglect claims in Georgia and South Carolina — bedsores, understaffing, poor supervision, and residents\' care plans not followed.',
	'/practice-areas/pedestrian-accident-lawyers/'   => 'Pedestrian accident claims in Georgia and South Carolina for people struck by drivers who failed to yield or were distracted, impaired, or speeding.',
	'/practice-areas/premises-liability-lawyers/'    => 'Premises liability claims in Georgia and South Carolina for injuries caused by unsafe property: slick floors, broken stairs and handrails, and poor lighting.',
	'/practice-areas/product-liability-lawyers/'     => 'Product liability claims in Georgia and South Carolina against manufacturers and sellers for design defects, manufacturing defects, and failure to warn.',
	'/practice-areas/slip-and-fall-lawyers/'         => 'Slip and fall injury claims in Georgia and South Carolina — wet floors, spills, broken sidewalks, and loose flooring in stores, restaurants, and parking lots.',
	'/practice-areas/spinal-cord-injury-lawyers/'    => 'Spinal cord injury claims in Georgia and South Carolina — paraplegia, quadriplegia, and incomplete injuries caused by crashes, falls, and diving accidents.',
	'/practice-areas/truck-accident-lawyers/'        => 'Truck accident claims in Georgia and South Carolina against drivers and commercial carriers — fatigue and hours-of-service violations, speeding, and impairment.',
	'/practice-areas/wrongful-death-lawyers/'        => 'Wrongful death claims for families in Georgia and South Carolina after fatal crashes, medical errors, workplace accidents, defective products, or neglect.',
);

fprintf( $err, "%s — %d pillar meta descriptions\n\n", $apply ? 'APPLY' : 'DRY RUN', count( $descriptions ) );

// Resolve and check everything before writing anything.
$plan = array();
foreach ( $descriptions as $path => $desc ) {
	if ( mb_strlen( $desc ) > 160 ) {
		fprintf( $err, "ABORT: %s is %d characters (max 160)\n", $path, mb_strlen( $desc ) );
		exit( 1 );
	}
	$id   = url_to_postid( home_url( $path ) );
	$post = $id ? get_post( $id ) : null;
	if ( ! $post || 'practice_area' !== $post->post_type || 'publish' !== $post->post_status || $post->post_parent ) {
		fprintf( $err, "ABORT: %s does not resolve to a published top-level practice_area (got %s)\n", $path, $id ?: 'nothing' );
		exit( 1 );
	}
	$existing = (string) get_post_meta( $id, '_roden_meta_description', true );
	if ( '' !== $existing ) {
		fprintf( $err, "ABORT: %s (%d) already has a description: %s\n", $path, $id, $existing );
		exit( 1 );
	}
	$plan[] = array( 'ID' => $id, 'path' => $path, 'before' => $existing, 'after' => $desc, 'chars' => mb_strlen( $desc ) );
}

foreach ( $plan as $row ) {
	fprintf( $err, "  %5d  %3d  %s\n", $row['ID'], $row['chars'], $row['path'] );
	if ( $apply ) {
		// update_post_meta() unslashes — the apostrophes here survive it, but the rule is the rule.
		update_post_meta( $row['ID'], '_roden_meta_description', wp_slash( $row['after'] ) );
		$back = (string) get_post_meta( $row['ID'], '_roden_meta_description', true );
		if ( $back !== $row['after'] ) {
			fprintf( $err, "READBACK MISMATCH on %d: %s\n", $row['ID'], $back );
			exit( 1 );
		}
	}
}

if ( $apply && function_exists( 'roden_llms_txt_flush_cache' ) ) {
	roden_llms_txt_flush_cache();
	fprintf( $err, "\nllms.txt transients flushed and static files rewritten.\n" );
}

echo wp_json_encode( $plan, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "\n";
fprintf( $err, "\n%s\n", $apply ? 'Applied; every value read back identical.' : 'Dry run — nothing written. Re-run with `eval-file - apply`.' );
