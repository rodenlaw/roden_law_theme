<?php
/**
 * Debug: Run a truncated version of the medical malpractice seeder.
 * wp eval-file wp-content/themes/roden-law/inc/debug-seeders.php
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

error_reporting( E_ALL );
ini_set( 'display_errors', '1' );

WP_CLI::log( 'Step 1: Starting...' );

$pillar = get_page_by_path( 'medical-malpractice-lawyers', OBJECT, 'practice_area' );
if ( ! $pillar ) {
    $pillar = get_page_by_path( 'medical-malpractice-lawyers', OBJECT, 'practice-area' );
}
$pillar_id   = $pillar->ID;
$pillar_type = $pillar->post_type;

WP_CLI::log( "Step 2: Pillar found: ID {$pillar_id}" );

$eric = get_page_by_path( 'eric-roden', OBJECT, 'attorney' );
$author_attorney_id = $eric ? $eric->ID : 0;

WP_CLI::log( "Step 3: Author ID {$author_attorney_id}" );

// Try creating just one post with minimal content
$test_slug = 'surgical-error-test-debug';
$existing = get_posts( array(
    'post_type'   => $pillar_type,
    'name'        => $test_slug,
    'post_parent' => $pillar_id,
    'post_status' => 'any',
    'numberposts' => 1,
) );

if ( ! empty( $existing ) ) {
    WP_CLI::log( "Step 4: Test post already exists (ID {$existing[0]->ID}). Trashing it for re-test." );
    wp_trash_post( $existing[0]->ID );
}

WP_CLI::log( 'Step 4: Inserting test post...' );

$content = '<h2>Surgical Error Accidents</h2>
<p>Surgical errors are among the most devastating forms of <a href="/practice-areas/medical-malpractice-lawyers/">medical malpractice</a>. Georgia law (O.C.G.A. &sect; 9-3-33) provides a 2-year statute of limitations.</p>

<h3>Common Types of Surgical Errors</h3>
<ul>
<li><strong>Wrong-site surgery:</strong> Operating on the wrong body part</li>
<li><strong>Retained instruments:</strong> Leaving sponges or tools inside the patient</li>
</ul>';

$post_id = wp_insert_post( array(
    'post_title'   => 'Surgical Error Lawyers',
    'post_name'    => $test_slug,
    'post_type'    => $pillar_type,
    'post_parent'  => $pillar_id,
    'post_status'  => 'publish',
    'post_content' => $content,
    'post_excerpt' => 'Test excerpt.',
    'menu_order'   => 0,
), true );

if ( is_wp_error( $post_id ) ) {
    WP_CLI::error( 'Insert failed: ' . $post_id->get_error_message() );
} else {
    WP_CLI::success( "Test post created: ID {$post_id}" );
    // Clean up
    wp_trash_post( $post_id );
    WP_CLI::log( 'Cleaned up test post.' );
}

WP_CLI::success( 'Debug complete.' );
