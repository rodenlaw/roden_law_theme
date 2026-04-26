<?php
/**
 * Seeder: AI Visibility — Awards + sameAs data for attorneys.
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-ai-visibility.php
 *
 * Safe to re-run — updates existing values.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ── Eric Roden (ID 3729) ──────────────────────────────────────────────────

// Awards
$eric_awards = array(
    array( 'award' => 'Super Lawyers Rising Stars', 'year' => '2020' ),
    array( 'award' => 'Super Lawyers Rising Stars', 'year' => '2021' ),
);
update_post_meta( 3729, '_roden_awards', $eric_awards );

// sameAs — LinkedIn + Super Lawyers profile
update_post_meta( 3729, '_roden_linkedin_url', 'https://www.linkedin.com/in/eric-roden-a6083655/' );
update_post_meta( 3729, '_roden_same_as', array(
    'https://profiles.superlawyers.com/georgia/savannah/lawyer/eric-roden/568cc6f9-9f5b-4879-b65f-8aaf92a8aa02.html',
    'https://www.justia.com/lawyers/eric-roden-savannah',
) );

echo "Eric Roden (3729): awards + sameAs updated.\n";

// ── Tyler Love (ID 3730) ─────────────────────────────────────────────────

update_post_meta( 3730, '_roden_linkedin_url', 'https://www.linkedin.com/in/tyler-love-21893163/' );
update_post_meta( 3730, '_roden_same_as', array(
    'https://www.avvo.com/attorneys/31405-ga-tyler-love-4235389.html',
) );

echo "Tyler Love (3730): sameAs updated.\n";

// ── Joshua Dorminy (ID 3731) ─────────────────────────────────────────────

update_post_meta( 3731, '_roden_linkedin_url', 'https://www.linkedin.com/in/joshua-dorminy-8a78a168/' );
update_post_meta( 3731, '_roden_same_as', array(
    'https://www.avvo.com/attorneys/31401-ga-joshua-dorminy-4880593.html',
) );

echo "Joshua Dorminy (3731): sameAs updated.\n";

// ── Graeham C. Gillin (ID 3732) ──────────────────────────────────────────

update_post_meta( 3732, '_roden_linkedin_url', 'https://www.linkedin.com/in/graeham-gillin-2b32b9126/' );
update_post_meta( 3732, '_roden_same_as', array(
    'https://www.avvo.com/attorneys/29401-sc-graeham-gillin-4920375.html',
) );

echo "Graeham C. Gillin (3732): sameAs updated.\n";

echo "\nDone. Verify schema output on attorney pages.\n";
