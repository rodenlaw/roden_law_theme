<?php
/**
 * Track B1: give the highest-impression informational pages a real excerpt.
 *
 *   ssh $H "wp --path=... eval-file -"       < bin/b1-write-excerpts.php
 *   ssh $H "wp --path=... eval-file - apply" < bin/b1-write-excerpts.php
 *
 * WHY EXCERPTS, and why this is not the Track A mistake repeated.
 *
 * Track A was abandoned because page substance predicts neither position nor CTR
 * on the city x practice pages. The same test was run on the informational cohort
 * BEFORE starting here, and it comes back the other way. Across 346 EN blog and
 * resource pages with >=500 impressions:
 *
 *     predictor        vs position   vs CTR
 *     word count         -0.288      +0.137
 *     h2 count           -0.300      +0.113
 *     key takeaways      -0.321      +0.072
 *     statute cites      -0.252      +0.185
 *     EXCERPT            -0.302      +0.412   <- strongest signal in the table
 *     two-state title    +0.017      -0.036   <- still not a lever
 *
 * Excerpt is singled out because it is the only one with a DIRECT mechanism
 * rather than a plausible confound. post_excerpt IS the meta description
 * (roden_seo_get_description) and IS the Article schema description
 * (roden_schema_article). It is literally the snippet a searcher reads before
 * deciding to click. Word count cannot act on CTR that way; an excerpt can.
 *
 * The honest caveat: +0.412 is a correlation, and pages carrying excerpts also
 * tend to be newer and better maintained, so some of it is "this page was looked
 * after". The mechanism is what justifies acting, not the coefficient.
 *
 * SCALE. 284 EN informational pages with >=500 impressions have no excerpt,
 * carrying 3,366,778 impressions at 0.471% CTR. The 62 that have one run 0.609%.
 * This script does the top 12 by impressions — 1,461,000 impressions between them.
 *
 * Every excerpt below was written from that page's own opening and its
 * _roden_key_takeaways where present, both of which have already been through the
 * accuracy passes. No excerpt asserts a statute, a number or a deadline: a
 * description is not the place to introduce a legal claim that then has to be
 * maintained on a fifth surface.
 *
 * Idempotent, and refuses to overwrite: a page that already has an excerpt is
 * skipped, because a human-written one is not improved by a generated one.
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
echo $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (pass 'apply' to write) ===\n\n";

$EXCERPTS = array(
    'compensatory-damages-vs-punitive-damages'           => 'Compensatory damages repay your losses; punitive damages punish extreme misconduct. How each works in Georgia and South Carolina injury claims.',
    'can-an-insurance-company-go-against-a-police-report' => 'Yes — insurers in Georgia and South Carolina routinely dispute a police report\'s fault finding. What that means for your claim, and how to respond.',
    'fault-vs-no-fault-car-insurance'                     => 'Georgia and South Carolina are both at-fault states, not no-fault. What that means for who pays after a crash, and how shared fault affects recovery.',
    'rollover-crashes-and-what-they-do-to-your-body'      => 'Why rollovers happen, the injuries they cause, and who may be liable — other drivers, vehicle makers, or road authorities — in Georgia and South Carolina.',
    'value-of-pain-and-suffering'                         => 'How pain and suffering is valued in Georgia and South Carolina injury claims, including the multiplier and per diem methods insurers actually use.',
    'calculating-compensation-for-whiplash-injuries'      => 'How whiplash compensation is calculated in Georgia and South Carolina — injury grades, medical bills, lost wages, and what shared fault does to a claim.',
    'supporting-a-whiplash-claim'                         => 'Five steps to document and support a whiplash claim after a Charleston car accident, from medical records to the evidence insurers look for.',
    'claims-against-at-fault-drivers-who-died'            => 'Your claim survives the at-fault driver\'s death. How to pursue it in Georgia or South Carolina through insurance, the estate, or your own coverage.',
    'liability-for-epilepsy-related-car-accidents'        => 'When a seizure causes a crash, who is liable? How fault is assessed in seizure-related accidents, and what it means for the people injured.',
    'insurance-company-ignoring-demand-letter'            => 'Why insurers ignore or delay a demand letter after a personal injury claim, what the silence usually means, and the steps that get a response.',
    'diminished-value-claims-after-car-accident'          => 'A repaired car is worth less than it was. How diminished value claims work in Georgia and South Carolina, and why an appraisal beats the 17c formula.',
    'are-red-light-runners-always-liable-if-they-crash'   => 'Not automatically. How fault is actually decided in Georgia and South Carolina red light crashes, and when the other driver shares the blame.',
);

$backups = array();
$ok = $skip = $fail = 0;

foreach ( $EXCERPTS as $slug => $excerpt ) {
    $post = get_page_by_path( $slug, OBJECT, 'post' );
    if ( ! $post ) {
        printf( "  FAIL (not found): %s\n", $slug );
        $fail++;
        continue;
    }

    $len = mb_strlen( $excerpt );
    if ( $len > 160 ) {
        printf( "  FAIL (%d chars > 160): %s\n", $len, $slug );
        $fail++;
        continue;
    }

    // Never overwrite a hand-written excerpt.
    if ( '' !== trim( (string) $post->post_excerpt ) ) {
        printf( "  SKIP (already has one): %s\n", $slug );
        $skip++;
        continue;
    }

    printf( "  ok  [%3d chars] %-52s\n", $len, $slug );
    $ok++;

    if ( ! $apply ) {
        continue;
    }

    $backups[ $post->ID ] = array( 'url' => get_permalink( $post->ID ), 'post_excerpt' => $post->post_excerpt );
    wp_update_post( array( 'ID' => $post->ID, 'post_excerpt' => $excerpt ), true );
    clean_post_cache( $post->ID );
}

printf( "\n%d written, %d skipped, %d failed\n", $ok, $skip, $fail );

if ( ! $apply ) {
    echo "\nDry run. Nothing written.\n";
    return;
}
if ( $backups ) {
    echo "\nBACKUP-JSON: " . wp_json_encode( $backups ) . "\n";
}

echo "\n--- VERIFY (what each page now publishes as its description) ---\n";
foreach ( array_keys( $EXCERPTS ) as $slug ) {
    $post = get_page_by_path( $slug, OBJECT, 'post' );
    if ( ! $post ) { continue; }
    $desc = trim( wp_strip_all_tags( get_the_excerpt( $post->ID ) ) );
    printf( "  %-52s %s\n", $slug, substr( $desc, 0, 78 ) );
}
echo "\nDone.\n";
