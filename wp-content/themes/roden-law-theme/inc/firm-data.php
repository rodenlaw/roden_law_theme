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
    $data = array(
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
                'court_address'=> '133 Montgomery St., Savannah, GA 31401',
                'slug'         => 'savannah-ga',
                'state_slug'   => 'georgia',
                'service_area' => 'Savannah, Pooler, Richmond Hill, Hinesville, Statesboro, Brunswick, and surrounding Southeast Georgia communities.',
                'attorneys'    => array( 'eric-roden', 'tyler-love' ),
                'nearby_communities' => array(
                    'Pooler', 'Richmond Hill', 'Hinesville', 'Garden City',
                    'Port Wentworth', 'Tybee Island', 'Bloomingdale',
                    'Georgetown', 'Thunderbolt', 'Wilmington Island',
                ),
                'directions'   => 'Our Savannah office is located on Commercial Drive, just off Abercorn Street near Oglethorpe Mall. From I-16 East, take Exit 164A onto I-516 E/DeRenne Ave, then turn south on Abercorn St. From I-95, take Exit 94 onto GA-204 E (Abercorn St) toward Savannah. Free client parking is available in our building lot.',
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
                'court_address'=> '310 Northway, Darien, GA 31305',
                'slug'         => 'darien-ga',
                'state_slug'   => 'georgia',
                'service_area' => 'Darien, Brunswick, St. Simons Island, Jekyll Island, Waycross, and surrounding Southeast Georgia coastal communities.',
                'attorneys'    => array( 'joshua-dorminy' ),
                'nearby_communities' => array(
                    'Brunswick', 'St. Simons Island', 'Jekyll Island', 'Waycross',
                    'Jesup', 'Townsend', 'Meridian', 'Eulonia',
                    'South Newport', 'Crescent',
                ),
                'directions'   => 'Our Darien office is on North Way, conveniently located near the I-95/US-17 interchange in McIntosh County. From I-95, take Exit 49 (GA-251) toward Darien and head east on North Way. From Brunswick, take US-17 North approximately 16 miles. The office is easily accessible from the Golden Isles and surrounding coastal communities.',
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
                'court_address'=> '100 Broad St., Charleston, SC 29401',
                'slug'         => 'charleston-sc',
                'state_slug'   => 'south-carolina',
                'service_area' => 'Charleston, North Charleston, Summerville, Mount Pleasant, Goose Creek, and surrounding Lowcountry communities.',
                'attorneys'    => array( 'graeham-gillin', 'kiley-reidy', 'zach-stohr' ),
                'nearby_communities' => array(
                    'North Charleston', 'Mount Pleasant', 'Summerville', 'Goose Creek',
                    'James Island', 'West Ashley', 'Daniel Island', 'Isle of Palms',
                    'Folly Beach', 'Hanahan',
                ),
                'directions'   => 'Our Charleston office is in the heart of downtown on King Street, Suite 200, near the intersection of King and Calhoun streets. From I-26 East, take Exit 221B onto Meeting Street heading south, then turn right on Calhoun and left on King. From Mount Pleasant, cross the Ravenel Bridge and follow US-17 S to the Meeting Street exit. Street and garage parking available nearby.',
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
                'court_address'=> '1701 Main St., Columbia, SC 29201',
                'slug'         => 'columbia-sc',
                'state_slug'   => 'south-carolina',
                'service_area' => 'Columbia, Lexington, Irmo, West Columbia, Cayce, Forest Acres, and surrounding Midlands South Carolina communities.',
                'attorneys'    => array( 'graeham-gillin', 'kiley-reidy' ),
                'nearby_communities' => array(
                    'Lexington', 'Irmo', 'West Columbia', 'Cayce',
                    'Forest Acres', 'Blythewood', 'Elgin', 'Chapin',
                    'Dentsville', 'Hopkins',
                ),
                'directions'   => 'Our Columbia office is on Sumter Street in the downtown corridor, near the University of South Carolina campus. From I-26, take Exit 111B onto Elmwood Ave, then turn south on Sumter St. From I-77, take Exit 16A onto I-277 and follow signs to Sumter Street. From I-20, take Exit 74 onto Broad River Rd toward downtown. Street metered parking and nearby garage parking are available.',
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
                'court_address'=> '1301 2nd Ave., Conway, SC 29526',
                'slug'         => 'myrtle-beach-sc',
                'state_slug'   => 'south-carolina',
                'service_area' => 'Myrtle Beach, Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and surrounding Grand Strand communities.',
                'attorneys'    => array( 'graeham-gillin', 'ivy-montano' ),
                'nearby_communities' => array(
                    'Myrtle Beach', 'Conway', 'Surfside Beach', 'Pawleys Island',
                    'Garden City', 'Litchfield Beach', 'North Myrtle Beach',
                    'Little River', 'Loris', 'Georgetown',
                ),
                'directions'   => 'Our Murrells Inlet office is on Bellamy Avenue, Suite C-B, just off US-17 Business in the heart of the Grand Strand. From Myrtle Beach, take US-17 S (Kings Highway) approximately 12 miles south. From Georgetown, take US-17 N about 20 miles. From Conway, take US-501 to US-17 S. The office is near Brookgreen Gardens and Huntington Beach State Park.',
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

    /* ------------------------------------------------------------------
       Convenience aliases — keep templates working without mass rename
       ------------------------------------------------------------------ */

    // Top-level aliases (from vanity_phone + trust_stats)
    $data['phone']         = $data['vanity_phone'];
    $data['phone_e164']    = $data['phone_raw'];
    $data['recovered']     = $data['trust_stats']['recovered'];
    $data['rating']        = $data['trust_stats']['rating'];
    $data['reviews']       = $data['trust_stats']['reviews'];
    $data['cases_handled'] = $data['trust_stats']['cases'];
    $data['experience']    = $data['trust_stats']['experience'] . ' years';

    // Per-office aliases
    foreach ( $data['offices'] as $key => &$office ) {
        $office['address']     = $office['street'];
        $office['phone_e164']  = $office['phone_raw'];
        $office['lat']         = $office['latitude'];
        $office['lng']         = $office['longitude'];
        $office['map_url']     = 'https://www.google.com/maps/dir/?api=1&destination='
                                 . $office['latitude'] . ',' . $office['longitude'];

        // Jurisdiction-derived fields
        $state_key = $office['state']; // 'GA' or 'SC'
        if ( isset( $data['jurisdiction'][ $state_key ] ) ) {
            $j = $data['jurisdiction'][ $state_key ];
            $office['sol']   = $j['statute_years'] . ' years (' . $j['statute_cite'] . ')';
            $office['fault'] = $j['comp_fault_rule'];
        }
    }
    unset( $office ); // break reference

    return $data;
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
