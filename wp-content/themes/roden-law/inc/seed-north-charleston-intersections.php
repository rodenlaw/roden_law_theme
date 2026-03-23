<?php
/**
 * Seeder: North Charleston intersection pages for all 22 practice areas.
 *
 * Creates intersection posts (practice_area CPT, child of pillar) for
 * north-charleston-sc across all 22 practice areas. Each intersection page
 * gets _roden_office_key = 'north-charleston' and SC jurisdiction data.
 *
 * Usage:
 *   cd sites/rodenlawdev1
 *   wp eval-file wp-content/themes/roden-law/inc/seed-north-charleston-intersections.php
 *
 * Safe to re-run: skips posts that already exist by slug under the correct parent.
 */

defined( 'ABSPATH' ) || exit;

WP_CLI::log( 'Starting North Charleston intersection page seeder...' );

// ── Helper: Get attorney post ID by slug ────────────────────────────────
if ( ! function_exists( 'roden_seed_get_attorney_id' ) ) {
    function roden_seed_get_attorney_id( $slug ) {
        $post = get_page_by_path( $slug, OBJECT, 'attorney' );
        return $post ? $post->ID : 0;
    }
}

$graeham_id = roden_seed_get_attorney_id( 'graeham-c-gillin' );
WP_CLI::log( "Attorney ID — Graeham Gillin: {$graeham_id}" );

// ── Practice area slugs → display names ─────────────────────────────────
$practice_areas = array(
    'personal-injury-lawyers'            => 'Personal Injury Lawyers',
    'car-accident-lawyers'               => 'Car Accident Lawyers',
    'truck-accident-lawyers'             => 'Truck Accident Lawyers',
    'slip-and-fall-lawyers'              => 'Slip and Fall Lawyers',
    'motorcycle-accident-lawyers'        => 'Motorcycle Accident Lawyers',
    'medical-malpractice-lawyers'        => 'Medical Malpractice Lawyers',
    'wrongful-death-lawyers'             => 'Wrongful Death Lawyers',
    'workers-compensation-lawyers'       => "Workers' Compensation Lawyers",
    'dog-bite-lawyers'                   => 'Dog Bite Lawyers',
    'brain-injury-lawyers'               => 'Brain Injury Lawyers',
    'spinal-cord-injury-lawyers'         => 'Spinal Cord Injury Lawyers',
    'maritime-injury-lawyers'            => 'Maritime Injury Lawyers',
    'product-liability-lawyers'          => 'Product Liability Lawyers',
    'boating-accident-lawyers'           => 'Boating Accident Lawyers',
    'burn-injury-lawyers'                => 'Burn Injury Lawyers',
    'construction-accident-lawyers'      => 'Construction Accident Lawyers',
    'nursing-home-abuse-lawyers'         => 'Nursing Home Abuse Lawyers',
    'premises-liability-lawyers'         => 'Premises Liability Lawyers',
    'pedestrian-accident-lawyers'        => 'Pedestrian Accident Lawyers',
    'bicycle-accident-lawyers'           => 'Bicycle Accident Lawyers',
    'electric-scooter-accident-lawyers'  => 'Electric Scooter Accident Lawyers',
    'atv-side-by-side-accident-lawyers'  => 'ATV & Side-by-Side Accident Lawyers',
    'golf-cart-accident-lawyers'         => 'Golf Cart Accident Lawyers',
);

$created = 0;
$skipped = 0;
$errors  = 0;

foreach ( $practice_areas as $pa_slug => $pa_name ) {
    // Find the pillar post
    $pillar = get_page_by_path( $pa_slug, OBJECT, 'practice_area' );
    if ( ! $pillar ) {
        WP_CLI::warning( "Pillar not found: {$pa_slug} — skipping" );
        $errors++;
        continue;
    }
    $pillar_id = $pillar->ID;

    // Check if intersection already exists
    $existing = get_posts( array(
        'post_type'      => 'practice_area',
        'post_status'    => array( 'publish', 'draft' ),
        'post_parent'    => $pillar_id,
        'name'           => 'north-charleston-sc',
        'posts_per_page' => 1,
    ) );

    if ( ! empty( $existing ) ) {
        // Update office key in case it's wrong
        update_post_meta( $existing[0]->ID, '_roden_office_key', 'north-charleston' );
        WP_CLI::log( "  [SKIP] {$pa_slug}/north-charleston-sc (ID {$existing[0]->ID}) — already exists" );
        $skipped++;
        continue;
    }

    // Build intersection content
    $title = "{$pa_name} in North Charleston, SC";
    $content = roden_nc_intersection_content( $pa_name, $pa_slug );

    $post_id = wp_insert_post( array(
        'post_type'    => 'practice_area',
        'post_status'  => 'publish',
        'post_title'   => $title,
        'post_name'    => 'north-charleston-sc',
        'post_content' => $content,
        'post_parent'  => $pillar_id,
    ), true );

    if ( is_wp_error( $post_id ) ) {
        WP_CLI::warning( "  [ERROR] {$pa_slug}/north-charleston-sc — " . $post_id->get_error_message() );
        $errors++;
        continue;
    }

    // Set meta fields
    update_post_meta( $post_id, '_roden_office_key', 'north-charleston' );
    update_post_meta( $post_id, '_roden_jurisdiction', 'south-carolina' );
    update_post_meta( $post_id, '_roden_sol_sc', '3 years (S.C. Code § 15-3-530)' );
    update_post_meta( $post_id, '_roden_author_attorney', $graeham_id );

    // Set default FAQs
    $faqs = roden_nc_intersection_faqs( $pa_name );
    update_post_meta( $post_id, '_roden_faqs', $faqs );

    WP_CLI::log( "  [CREATED] {$pa_slug}/north-charleston-sc (ID {$post_id})" );
    $created++;
}

// Flush rewrite rules
flush_rewrite_rules();

WP_CLI::success( "Done. Created: {$created}, Skipped: {$skipped}, Errors: {$errors}" );

/* =========================================================================
   CONTENT GENERATORS
   ========================================================================= */

/**
 * Generate intersection page content for a practice area × North Charleston.
 */
function roden_nc_intersection_content( $pa_name, $pa_slug ) {
    $pa_name_lower = strtolower( $pa_name );
    $pa_name_lower = str_replace( "workers' compensation lawyers", "workers' compensation claims", $pa_name_lower );
    $pa_name_lower = str_replace( ' lawyers', ' cases', $pa_name_lower );

    return <<<HTML
<p>If you need a {$pa_name_lower} attorney in North Charleston, South Carolina, Roden Law is here to help. Our North Charleston office at 2703 Spruill Ave in the Park Circle area serves injury victims throughout North Charleston, Goose Creek, Summerville, Hanahan, Ladson, Moncks Corner, and the surrounding tri-county communities.</p>

<h2>{$pa_name} Serving North Charleston &amp; the Tri-County Area</h2>
<p>North Charleston is the third-largest city in South Carolina, with major traffic corridors including I-26, I-526, Rivers Avenue, Ashley Phosphate Road, and Dorchester Road. These high-volume roads — combined with the Charleston International Airport, Joint Base Charleston, and the North Charleston Coliseum — generate heavy traffic and elevated accident risks for residents and commuters.</p>
<p>Roden Law's North Charleston office provides convenient access for clients in the I-26 corridor communities. Whether your injury occurred on Ashley Phosphate Road, at the I-26 interchange, in a Goose Creek neighborhood, or on a Summerville construction site, our attorneys handle {$pa_name_lower} throughout Berkeley, Charleston, and Dorchester counties.</p>

<h2>Why Choose Roden Law in North Charleston?</h2>
<ul>
<li><strong>\$250M+ Recovered</strong> for injured clients across Georgia and South Carolina</li>
<li><strong>Local Office in Park Circle</strong> — 2703 Spruill Ave, North Charleston, SC 29405</li>
<li><strong>No Upfront Costs</strong> — contingency fee basis; you pay nothing unless we win</li>
<li><strong>Experienced Trial Attorneys</strong> — our team practices in Charleston County Circuit Court and Berkeley County Circuit Court</li>
<li><strong>Free Consultation</strong> — call <a href="tel:+18436126561">(843) 612-6561</a> for a no-obligation case review</li>
</ul>

<h2>South Carolina Personal Injury Law</h2>
<h3>Statute of Limitations</h3>
<p>Under <strong>S.C. Code § 15-3-530</strong>, you have <strong>3 years from the date of injury</strong> to file a personal injury lawsuit in South Carolina. Missing this deadline typically bars your claim permanently.</p>

<h3>Modified Comparative Fault</h3>
<p>South Carolina follows a modified comparative fault rule. You can recover compensation as long as you are <strong>less than 51% at fault</strong> for the accident. Your recovery is reduced by your percentage of fault.</p>

<h2>Areas We Serve from Our North Charleston Office</h2>
<p>Our North Charleston office at 2703 Spruill Ave serves clients throughout the tri-county area:</p>
<ul>
<li><strong>North Charleston</strong> — Park Circle, Olde North Charleston, Northwoods, Charleston Heights, Dorchester Terrace, Liberty Hill, Wescott Plantation</li>
<li><strong>Goose Creek</strong> — Crowfield Plantation, Carnes Crossroads, Liberty Hall, Boulder Bluff, Howe Hall</li>
<li><strong>Summerville</strong> — Cane Bay Plantation, Nexton, Knightsville, Sangaree, Historic Downtown</li>
<li><strong>Hanahan</strong> — Otranto, Yeamans Hall area</li>
<li><strong>Ladson</strong> — I-26 corridor communities</li>
<li><strong>Moncks Corner</strong> — Berkeley County seat</li>
</ul>

<h2>Contact Our North Charleston Office</h2>
<p>Injured in North Charleston or the surrounding tri-county area? Contact Roden Law for a free case review. Call <a href="tel:+18436126561">(843) 612-6561</a> or visit our Park Circle office at 2703 Spruill Ave, North Charleston, SC 29405.</p>
<p>There are no fees unless we win your case. We are available 24/7 for emergencies.</p>
HTML;
}

/**
 * Generate default FAQs for North Charleston intersection pages.
 */
function roden_nc_intersection_faqs( $pa_name ) {
    return array(
        array(
            'question' => "How much does it cost to hire Roden Law for a {$pa_name} case in North Charleston?",
            'answer'   => 'Nothing upfront. Roden Law works on a contingency fee basis — you pay no attorney fees unless we recover compensation for you. Your initial consultation is always free.',
        ),
        array(
            'question' => 'Where is Roden Law\'s North Charleston office located?',
            'answer'   => 'Our North Charleston office is at 2703 Spruill Ave in the Park Circle area, near the intersection of Spruill Avenue and East Montague Avenue. From I-26, take Exit 213 onto E Montague Ave heading east, then turn left on Spruill Ave. Free client parking is available.',
        ),
        array(
            'question' => "How long do I have to file a {$pa_name} case in South Carolina?",
            'answer'   => 'Under South Carolina law (S.C. Code § 15-3-530), you generally have 3 years from the date of injury to file a personal injury lawsuit. Some exceptions may apply, so consulting an attorney promptly is important to protect your rights.',
        ),
        array(
            'question' => 'What areas does the North Charleston office serve?',
            'answer'   => 'Our North Charleston office serves clients throughout the tri-county area including North Charleston, Goose Creek, Summerville, Hanahan, Ladson, Moncks Corner, and surrounding Berkeley, Charleston, and Dorchester County communities.',
        ),
        array(
            'question' => "Can I still recover compensation if I was partially at fault for my accident?",
            'answer'   => 'Yes. South Carolina follows a modified comparative fault rule, meaning you can recover damages as long as you are less than 51% at fault. Your compensation is reduced by your percentage of fault.',
        ),
    );
}
