<?php
/**
 * Bicycle pillar (4087) opener + internal links, 2026-11-10.
 *
 * Evidence (data/gsc/latest.json, 2026-10-10 → 2026-11-06):
 *   /practice-areas/bicycle-accident-lawyers/  24,208 impr, 0 clicks, pos 21.0
 *   (prev 28 days 7,727 impr, pos 28; weekly pulls 25.3 → 25.4 → 24.5 → 22.2 → 21.0).
 *   The rise is the retired city pages redirecting here (inc/legacy-redirects.php).
 *   Queries are unmodified head terms ("bicycle accident attorney" 11,739 impr).
 *
 * What changes (all minor edits under the page ledger; no new legal claim):
 *   A. 4087 _roden_hero_intro: the marketing lede becomes a two-sentence answer.
 *      It renders in the hero AND in the "What Is a Bicycle Accident Case?"
 *      definition block above the author attribution (Graeham C. Gillin).
 *      Every claim is already on the page: the deadlines are in key takeaways
 *      (§ 9-3-33, § 15-3-530, both verified in docs/statute-verification-tracker.md);
 *      UM/UIM is in _roden_pillar_compensation_intro.
 *   B. 4087: five outbound links wrapped around existing words (two add a few words).
 *   C. Nine bicycle-topic pages get a link into the pillar. 1859 also drops a false
 *      "Macon injury attorneys" (Roden has no Macon office).
 *
 *   D. § 56-5-3435 cited for cyclists' rights (it covers safe passing distance only;
 *      data/facts/remediation-2026-11-10-4087-sc-rights.md). Deletions, no new cite:
 *      4087 SC bullet clause; 4087 whyHire paragraph 2, last SC sentence only
 *      (owner, 2026-11-10; the GA sentences stay); 4178 SC bullet reworded per the
 *      remediation file.
 *
 * Not touched: the § 40-6-294 line and the helmet "comparative fault" FAQ on 4087
 * (held for attorney review), and the NHTSA figure (facts pack).
 *
 * Each edit is an exact-string replace that must match exactly once; anything else
 * is reported and skipped. Idempotent: an edit whose result is already present is OK.
 * The prior value of every field written is saved to wp-content/uploads/roden-backups/
 * before the write. wp_slash() on every write — see CLAUDE.md.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/apply-bicycle-pillar-links-2026-11-10.php
 *   ssh $H "wp --path=$P eval-file - apply" < bin/apply-bicycle-pillar-links-2026-11-10.php
 * then: wp cache flush && wp page-cache flush; re-export content/meta.json;
 * run bin/check-unslashed-post-writes.php through eval-file.
 */
if ( ! defined( 'ABSPATH' ) ) { fwrite( STDERR, "Run through wp eval-file.\n" ); exit( 1 ); }
$mode = isset( $args[0] ) ? $args[0] : 'dry-run';

$P = '/practice-areas/bicycle-accident-lawyers/';
$a = function ( $href, $text ) { return '<a href="' . $href . '">' . $text . '</a>'; };

$hero_old_prefix = 'Cyclists are among the most vulnerable road users';
$hero_new        = 'If a driver hit you while you were riding, you can claim against that driver\'s insurer, and your own auto policy\'s uninsured-motorist coverage may pay as well. You have two years to sue in Georgia (O.C.G.A. § 9-3-33) and three in South Carolina (S.C. Code § 15-3-530).';

// id => [ slug, field ('content' or a meta key), [ [ find, replace ], ... ] ]
$edits = array(
	array( 4087, 'bicycle-accident-lawyers', 'content', array(
		array( 'Our attorneys handle the full range of bicycle-vehicle collisions:</p>',
		       'Our attorneys handle the full range of bicycle-vehicle collisions, including crashes on ' . $a( '/practice-areas/e-bike-accident-lawyers/', 'e-bikes' ) . ':</p>' ),
		array( '<strong>Helmet laws:</strong> Georgia requires helmets for riders under 16 (',
		       '<strong>Helmet laws:</strong> ' . $a( '/resources/georgia-helmet-laws/', 'Georgia requires helmets for riders under 16' ) . ' (' ),
		array( '. South Carolina has no statewide bicycle helmet law. Not wearing a helmet',
		       '. ' . $a( '/resources/south-carolina-helmet-laws/', 'South Carolina has no statewide bicycle helmet law' ) . '. Not wearing a helmet' ),
		array( 'facial fractures and dental injuries, and wrongful death.</p>',
		       'facial fractures and dental injuries, and ' . $a( '/wrongful-death-lawyers/pedestrian-cyclist-fatality/', 'wrongful death' ) . '.</p>' ),
		array( 'against negligent drivers, their insurers, and any other liable parties',
		       'against negligent drivers, their insurers, ' . $a( '/blog/using-uninsured-underinsured-motorist-coverage-in-georgia/', 'your own uninsured-motorist coverage' ) . ', and any other liable parties' ),
		// D. § 56-5-3435 rights mis-cite: cut the clause (passing half stays).
		array( '</a> requires drivers to pass bicycles at a safe distance and grants cyclists all rights applicable to vehicle operators</li>',
		       '</a> requires drivers to pass bicycles at a safe distance</li>' ),
	) ),
	array( 4087, 'bicycle-accident-lawyers', '_roden_why_hire', array(
		array( 'Insurance companies routinely blame cyclists —',
		       'Insurance companies routinely ' . $a( '/resources/georgia-vs-south-carolina-comparative-negligence/', 'blame cyclists' ) . ' —' ),
		// D. Owner: cut only the last (SC) sentence of paragraph 2; the GA sentences stay.
		array( ' South Carolina law (<a href="https://www.scstatehouse.gov/code/t56c005.php" target="_blank" rel="noopener">S.C. Code § 56-5-3435</a>) similarly requires safe passing distance and grants cyclists full road rights.</p>',
		       '</p>' ),
	) ),
	array( 4171, 'dooring-accident', 'content', array(
		array( 'At Roden Law, our dooring accident attorneys represent cyclists',
		       'At Roden Law, our dooring accident attorneys, part of our ' . $a( $P, 'bicycle accident practice' ) . ', represent cyclists' ),
	) ),
	array( 4177, 'drunk-driver-bicycle-accident', 'content', array(
		array( 'At Roden Law, our bicycle accident attorneys represent cyclists',
		       'At Roden Law, our ' . $a( $P, 'bicycle accident attorneys' ) . ' represent cyclists' ),
	) ),
	array( 4178, 'bicycle-vs-truck-accident', 'content', array(
		array( '</a> and bicycle accident lawyers combine their expertise',
		       '</a> and ' . $a( $P, 'bicycle accident lawyers' ) . ' combine their expertise' ),
		// D. Same mis-cite; wording from data/facts/remediation-2026-11-10-4087-sc-rights.md.
		array( '</a> grants cyclists equal roadway rights and requires motorists, including truck drivers, to pass at a safe distance.</li>',
		       '</a> requires motorists, including truck drivers, to pass cyclists at a safe distance.</li>' ),
	) ),
	array( 1828, 'avoiding-bicycle-accidents', 'content', array(
		array( 'If you were injured or lost a loved one in a bicycle accident, our ',
		       'If you were injured or lost a loved one in a ' . $a( $P, 'bicycle accident' ) . ', our ' ),
	) ),
	array( 1859, 'safe-bike-riding-georgias-roadways', 'content', array(
		array( 'Roden Law team of <a href="https://rodenlaw.com/practice-areas/personal-injury-lawyers/">Macon injury attorneys</a>',
		       'Roden Law team of ' . $a( $P, 'bicycle accident lawyers' ) ),
	) ),
	array( 3462, 'charleston-delivery-truck-pedestrian-cyclist-accidents', 'content', array(
		array( 'Pedestrians and cyclists still have rights even when visibility is disputed.',
		       'Pedestrians and ' . $a( $P, 'cyclists still have rights' ) . ' even when visibility is disputed.' ),
	) ),
	array( 3499, 'a-cyclists-guide-after-a-ravenel-bridge-accident', 'content', array(
		array( 'consulting a <strong>Charleston bike accident lawyer</strong> if',
		       'consulting a ' . $a( $P, '<strong>Charleston bike accident lawyer</strong>' ) . ' if' ),
	) ),
	array( 4639, 'pedestrian-bicycle-safety-north-charleston', 'content', array(
		array( 'your legal rights as a pedestrian or cyclist in North Charleston,',
		       'your legal rights as a pedestrian or ' . $a( $P, 'cyclist' ) . ' in North Charleston,' ),
	) ),
	array( 4106, 'pedestrian-cyclist-fatality', 'content', array(
		array( 'the most dangerous states for pedestrians and cyclists.</p>',
		       'the most dangerous states for pedestrians and ' . $a( $P, 'cyclists' ) . '.</p>' ),
	) ),
);

$backup_dir = WP_CONTENT_DIR . '/uploads/roden-backups/bicycle-pillar-links-2026-11-10';
$fail = 0;

$backup = function ( $id, $field, $value ) use ( $backup_dir, $mode ) {
	if ( 'apply' !== $mode ) { return true; }
	if ( ! is_dir( $backup_dir ) && ! wp_mkdir_p( $backup_dir ) ) { return false; }
	$f = $backup_dir . "/$id-" . ltrim( $field, '_' ) . '.txt';
	if ( file_exists( $f ) ) { return true; } // keep the first (pre-change) copy on a re-run
	return false !== file_put_contents( $f, $value );
};

// A. Hero intro.
$cur = (string) get_post_meta( 4087, '_roden_hero_intro', true );
if ( $cur === $hero_new ) {
	echo "OK   4087 _roden_hero_intro already set\n";
} elseif ( 0 !== strpos( trim( wp_strip_all_tags( $cur ) ), $hero_old_prefix ) ) {
	echo "FAIL 4087 _roden_hero_intro: current value is not the expected lede, not touching it\n      was: $cur\n"; $fail++;
} else {
	echo ( 'apply' === $mode ? 'SET  ' : 'WOULD' ) . " 4087 _roden_hero_intro\n      was: $cur\n      now: $hero_new\n";
	if ( 'apply' === $mode ) {
		if ( ! $backup( 4087, '_roden_hero_intro', $cur ) ) { echo "FAIL backup 4087 hero\n"; $fail++; }
		else {
			update_post_meta( 4087, '_roden_hero_intro', wp_slash( $hero_new ) );
			if ( (string) get_post_meta( 4087, '_roden_hero_intro', true ) !== $hero_new ) { echo "FAIL 4087 hero read-back\n"; $fail++; }
		}
	}
}

// B + C. Link edits.
$touched = array();
foreach ( $edits as $e ) {
	list( $id, $slug, $field, $pairs ) = $e;
	$p = get_post( $id );
	if ( ! $p || $p->post_name !== $slug || 'publish' !== $p->post_status ) {
		echo "FAIL $id: missing, slug mismatch or not published\n"; $fail++; continue;
	}
	$orig = 'content' === $field ? $p->post_content : (string) get_post_meta( $id, $field, true );
	$new  = $orig;
	foreach ( $pairs as $pair ) {
		list( $find, $repl ) = $pair;
		$n = substr_count( $new, $find );
		// Already done: the old text is gone and (for links) the new text is there.
		// Checked old-first so a cut whose replacement is just '</p>' is not misread.
		if ( 0 === $n && false !== strpos( $new, $repl ) ) { echo "OK   $id $field already applied: " . wp_strip_all_tags( $repl ) . "\n"; continue; }
		if ( 1 !== $n ) { echo "FAIL $id $field: anchor found $n times, skipped: $find\n"; $fail++; continue; }
		$new = str_replace( $find, $repl, $new );
		echo ( 'apply' === $mode ? 'EDIT ' : 'WOULD' ) . " $id $field\n      -  $find\n      +  $repl\n";
	}
	if ( $new === $orig || 'apply' !== $mode ) { continue; }
	if ( ! $backup( $id, $field, $orig ) ) { echo "FAIL backup $id $field\n"; $fail++; continue; }
	if ( 'content' === $field ) {
		$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $new ) ), true );
		if ( is_wp_error( $r ) ) { echo "FAIL $id update: " . $r->get_error_message() . "\n"; $fail++; continue; }
		if ( get_post( $id )->post_content !== $new ) { echo "FAIL $id content read-back\n"; $fail++; }
	} else {
		update_post_meta( $id, $field, wp_slash( $new ) );
		if ( (string) get_post_meta( $id, $field, true ) !== $new ) { echo "FAIL $id $field read-back\n"; $fail++; }
	}
	$touched[ $id ] = true;
}
if ( 'apply' === $mode ) {
	clean_post_cache( 4087 );
	foreach ( array_keys( $touched ) as $id ) { clean_post_cache( $id ); }
	echo "backups: $backup_dir\n";
}
echo ( $fail ? "DONE with $fail failure(s)\n" : "DONE clean\n" );
exit( $fail ? 1 : 0 );
