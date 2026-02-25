<?php
/**
 * Central Firm Data Configuration
 *
 * Single source of truth for all firm data. Every template, schema output,
 * and helper function pulls from roden_firm_data(). Includes offices,
 * attorneys, trust stats, social links, jurisdiction law data, and the
 * canonical list of 18 practice area pillar slugs.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return all firm data as a single associative array.
 *
 * @return array Firm data including offices, attorneys, stats, social, jurisdiction, and practice areas.
 */
function roden_firm_data() {
    return array(
        'name'         => 'Roden Law',
        'legal_entity' => 'Roden Love LLC',
        'vanity_phone' => '1-844-RESULTS',
        'phone_raw'    => '+18447378587',
        'url'          => 'https://rodenlaw.com',
        'description'  => 'Personal injury law firm serving Georgia and South Carolina with over $250 million recovered for injured clients.',
        'licensed_in'  => array( 'Georgia', 'South Carolina' ),
        'founded'      => '2015',

        /* ==================================================================
           OFFICES — 5 Locations
           ================================================================== */

        'offices' => array(
            'savannah' => array(
                'name'         => 'Roden Law — Savannah',
                'street'       => '333 Commercial Dr.',
                'city'         => 'Savannah',
                'state'        => 'GA',
                'state_full'   => 'Georgia',
                'zip'          => '31406',
                'phone'        => '(912) 303-5850',
                'phone_raw'    => '+19123035850',
                'latitude'     => 32.0291,
                'longitude'    => -81.0490,
                'timezone'     => 'America/New_York',
                'court'        => 'Chatham County Superior Court',
                'slug'         => 'savannah-ga',
                'state_slug'   => 'georgia',
                'service_area' => 'Savannah, Pooler, Richmond Hill, Hinesville, Statesboro, Brunswick, and surrounding Southeast Georgia communities.',
                'attorneys'    => array( 'eric-roden', 'tyler-love' ),
            ),
            'darien' => array(
                'name'         => 'Roden Law — Darien',
                'street'       => '1108 North Way',
                'city'         => 'Darien',
                'state'        => 'GA',
                'state_full'   => 'Georgia',
                'zip'          => '31305',
                'phone'        => '(912) 303-5850',
                'phone_raw'    => '+19123035850',
                'latitude'     => 31.3702,
                'longitude'    => -81.4340,
                'timezone'     => 'America/New_York',
                'court'        => 'McIntosh County Superior Court',
                'slug'         => 'darien-ga',
                'state_slug'   => 'georgia',
                'service_area' => 'Darien, Brunswick, St. Simons Island, Jekyll Island, Waycross, and surrounding Southeast Georgia coastal communities.',
                'attorneys'    => array( 'joshua-dorminy' ),
            ),
            'charleston' => array(
                'name'         => 'Roden Law — Charleston',
                'street'       => '127 King Street, Suite 200',
                'city'         => 'Charleston',
                'state'        => 'SC',
                'state_full'   => 'South Carolina',
                'zip'          => '29401',
                'phone'        => '(843) 790-8999',
                'phone_raw'    => '+18437908999',
                'latitude'     => 32.7876,
                'longitude'    => -79.9353,
                'timezone'     => 'America/New_York',
                'court'        => 'Charleston County Circuit Court',
                'slug'         => 'charleston-sc',
                'state_slug'   => 'south-carolina',
                'service_area' => 'Charleston, North Charleston, Summerville, Mount Pleasant, Goose Creek, and surrounding Lowcountry communities.',
                'attorneys'    => array( 'graeham-gillin', 'kiley-reidy', 'zach-stohr' ),
            ),
            'columbia' => array(
                'name'         => 'Roden Law — Columbia',
                'street'       => '1545 Sumter St., Suite B',
                'city'         => 'Columbia',
                'state'        => 'SC',
                'state_full'   => 'South Carolina',
                'zip'          => '29201',
                'phone'        => '(803) 219-2816',
                'phone_raw'    => '+18032192816',
                'latitude'     => 34.0007,
                'longitude'    => -81.0348,
                'timezone'     => 'America/New_York',
                'court'        => 'Richland County Circuit Court',
                'slug'         => 'columbia-sc',
                'state_slug'   => 'south-carolina',
                'service_area' => 'Columbia, Lexington, Irmo, West Columbia, Cayce, Forest Acres, and surrounding Midlands South Carolina communities.',
                'attorneys'    => array( 'graeham-gillin', 'kiley-reidy' ),
            ),
            'myrtle-beach' => array(
                'name'         => 'Roden Law — Myrtle Beach',
                'street'       => '631 Bellamy Ave., Suite C-B',
                'city'         => 'Murrells Inlet',
                'state'        => 'SC',
                'state_full'   => 'South Carolina',
                'zip'          => '29576',
                'phone'        => '(843) 612-1980',
                'phone_raw'    => '+18436121980',
                'latitude'     => 33.5510,
                'longitude'    => -79.0465,
                'timezone'     => 'America/New_York',
                'court'        => 'Horry County Circuit Court',
                'slug'         => 'myrtle-beach-sc',
                'state_slug'   => 'south-carolina',
                'service_area' => 'Myrtle Beach, Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and surrounding Grand Strand communities.',
                'attorneys'    => array( 'graeham-gillin', 'ivy-montano' ),
            ),
        ),

        /* ==================================================================
           ATTORNEYS — 7 Key Attorneys
           ================================================================== */

        'attorneys' => array(
            'eric-roden' => array(
                'name'           => 'Eric Roden',
                'title'          => 'Founding Partner, CEO',
                'bar_admissions' => array( 'Georgia', 'South Carolina' ),
                'office'         => 'savannah',
            ),
            'tyler-love' => array(
                'name'           => 'Tyler Love',
                'title'          => 'Founding Partner, CTO',
                'bar_admissions' => array( 'Georgia' ),
                'office'         => 'savannah',
            ),
            'joshua-dorminy' => array(
                'name'           => 'Joshua Dorminy',
                'title'          => 'Partner',
                'bar_admissions' => array( 'Georgia', 'South Carolina' ),
                'office'         => 'darien',
                'focus'          => 'Leads trucking litigation',
            ),
            'graeham-gillin' => array(
                'name'           => 'Graeham C. Gillin',
                'title'          => 'Partner, COO',
                'bar_admissions' => array( 'South Carolina' ),
                'office'         => 'charleston',
            ),
            'kiley-reidy' => array(
                'name'           => 'Kiley Reidy',
                'title'          => 'Associate',
                'bar_admissions' => array( 'South Carolina' ),
                'office'         => 'charleston',
            ),
            'zach-stohr' => array(
                'name'           => 'Zach Stohr',
                'title'          => 'Associate',
                'bar_admissions' => array( 'South Carolina' ),
                'office'         => 'charleston',
            ),
            'ivy-montano' => array(
                'name'           => 'Ivy S. Montano',
                'title'          => 'Associate',
                'bar_admissions' => array( 'South Carolina' ),
                'office'         => 'myrtle-beach',
            ),
        ),

        /* ==================================================================
           TRUST STATS
           ================================================================== */

        'trust_stats' => array(
            'recovered'  => '$250M+',
            'rating'     => '4.9',
            'reviews'    => '500+',
            'cases'      => '5,000+',
            'experience' => '62',
            'offices'    => '5',
        ),

        /* ==================================================================
           SOCIAL PROFILES
           ================================================================== */

        'social' => array(
            'facebook'  => 'https://www.facebook.com/RodenLaw',
            'instagram' => 'https://www.instagram.com/rodenlaw',
            'linkedin'  => 'https://www.linkedin.com/company/roden-law',
            'youtube'   => 'https://www.youtube.com/@rodenlaw',
            'twitter'   => 'https://x.com/rodenlaw',
        ),

        /* ==================================================================
           JURISDICTION LAW DATA
           ================================================================== */

        'jurisdiction' => array(
            'GA' => array(
                'state_full'       => 'Georgia',
                'statute_years'    => 2,
                'statute_cite'     => 'O.C.G.A. § 9-3-33',
                'comp_fault_rule'  => 'Modified — recover if less than 50% at fault',
                'comp_fault_cite'  => 'O.C.G.A. § 51-12-33',
            ),
            'SC' => array(
                'state_full'       => 'South Carolina',
                'statute_years'    => 3,
                'statute_cite'     => 'S.C. Code § 15-3-530',
                'comp_fault_rule'  => 'Modified — recover if less than 51% at fault',
                'comp_fault_cite'  => '',
            ),
        ),

        /* ==================================================================
           18 PRACTICE AREA PILLAR SLUGS
           ================================================================== */

        'practice_areas' => array(
            'car-accident-lawyers',
            'truck-accident-lawyers',
            'slip-and-fall-lawyers',
            'motorcycle-accident-lawyers',
            'medical-malpractice-lawyers',
            'wrongful-death-lawyers',
            'workers-compensation-lawyers',
            'dog-bite-lawyers',
            'brain-injury-lawyers',
            'spinal-cord-injury-lawyers',
            'maritime-injury-lawyers',
            'product-liability-lawyers',
            'boating-accident-lawyers',
            'burn-injury-lawyers',
            'construction-accident-lawyers',
            'nursing-home-abuse-lawyers',
            'premises-liability-lawyers',
            'pedestrian-accident-lawyers',
        ),
    );
}

/* ==========================================================================
   HELPER FUNCTIONS
   ========================================================================== */

/**
 * Get a single office's data by key.
 *
 * @param string $key Office key (e.g., 'savannah', 'charleston').
 * @return array|null Office data array, or null if key not found.
 */
function roden_get_office( $key ) {
    $firm = roden_firm_data();
    return $firm['offices'][ $key ] ?? null;
}

/**
 * Get the office key that matches a city slug (e.g., 'savannah-ga' => 'savannah').
 *
 * @param string $city_slug The city-state slug to look up.
 * @return string|null Office key, or null if no match.
 */
function roden_office_key_from_slug( $city_slug ) {
    $firm = roden_firm_data();
    foreach ( $firm['offices'] as $key => $office ) {
        if ( $office['slug'] === $city_slug ) {
            return $key;
        }
    }
    return null;
}

/**
 * Get all office city-state slugs.
 *
 * @return array Array of city-state slugs (e.g., 'savannah-ga', 'charleston-sc').
 */
function roden_get_office_slugs() {
    $firm  = roden_firm_data();
    $slugs = array();
    foreach ( $firm['offices'] as $office ) {
        $slugs[] = $office['slug'];
    }
    return $slugs;
}

/**
 * Get jurisdiction data (statute of limitations, comparative fault) for a post.
 * Auto-detects from _roden_jurisdiction or _roden_office_key meta.
 *
 * @param int|null $post_id Post ID (defaults to current post).
 * @return array|null Jurisdiction data array or null if not set.
 */
function roden_get_jurisdiction( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $firm  = roden_firm_data();
    $state = get_post_meta( $post_id, '_roden_jurisdiction', true );

    // Fall back to office key to determine state
    if ( ! $state ) {
        $office_key = get_post_meta( $post_id, '_roden_office_key', true );
        if ( $office_key && isset( $firm['offices'][ $office_key ] ) ) {
            $state = $firm['offices'][ $office_key ]['state'];
        }
    }

    if ( $state && isset( $firm['jurisdiction'][ $state ] ) ) {
        return $firm['jurisdiction'][ $state ];
    }

    return null;
}

/**
 * Get all jurisdiction data (both GA and SC).
 *
 * @return array Associative array keyed by state abbreviation.
 */
function roden_get_all_jurisdictions() {
    $firm = roden_firm_data();
    return $firm['jurisdiction'];
}

/**
 * Get the canonical list of 18 practice area pillar slugs.
 *
 * @return array Indexed array of slug strings.
 */
function roden_get_practice_area_slugs() {
    $firm = roden_firm_data();
    return $firm['practice_areas'];
}
