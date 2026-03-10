<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Check Permalink Manager plugin data for post 4230
$custom_uri = get_post_meta( 4230, 'custom_uri', true );
WP_CLI::log( "custom_uri meta: " . var_export( $custom_uri, true ) );

$pm_uris = get_option( 'permalink-manager-uris' );
if ( is_array( $pm_uris ) && isset( $pm_uris[4230] ) ) {
    WP_CLI::log( "PM URI for 4230: " . $pm_uris[4230] );
} else {
    WP_CLI::log( "No PM URI for 4230" );
}

// Check PM redirects
$pm_redirects = get_option( 'permalink-manager-redirects' );
if ( is_array( $pm_redirects ) && isset( $pm_redirects[4230] ) ) {
    WP_CLI::log( "PM Redirects for 4230: " . print_r( $pm_redirects[4230], true ) );
} else {
    WP_CLI::log( "No PM redirects for 4230" );
}

// Check all PM URIs containing "truck"
if ( is_array( $pm_uris ) ) {
    WP_CLI::log( '' );
    WP_CLI::log( 'All PM URIs with "truck":' );
    foreach ( $pm_uris as $id => $uri ) {
        if ( stripos( $uri, 'truck' ) !== false ) {
            WP_CLI::log( "  Post {$id}: {$uri}" );
        }
    }
}

// Fix: Update Permalink Manager URI to the new slug
if ( is_array( $pm_uris ) ) {
    $pm_uris[4230] = 'south-carolina-truck-accident-lawyer';
    update_option( 'permalink-manager-uris', $pm_uris );
    WP_CLI::success( "Updated PM URI for 4230 to: south-carolina-truck-accident-lawyer" );
}

// Remove any PM redirect for 4230 that points to old slug
if ( is_array( $pm_redirects ) && isset( $pm_redirects[4230] ) ) {
    unset( $pm_redirects[4230] );
    update_option( 'permalink-manager-redirects', $pm_redirects );
    WP_CLI::success( "Removed PM redirects for 4230" );
}

WP_CLI::success( 'Done.' );
