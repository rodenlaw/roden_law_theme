<?php
/**
 * One-time script: Import uploaded images and set as featured images.
 * Run via: wp eval-file wp-content/themes/roden-law/inc/set-featured-images.php
 * Then delete this file.
 */

$upload_dir = wp_upload_dir();
$base_path  = $upload_dir['basedir'];

// Map: filename (without extension) => [ post_id, alt_text ]
$images = array(
    'can-a-police-report-help-prove-liability' => array( 1731, 'Can a Police Report Help Prove Liability After an Accident?' ),
    'can-insurance-companies-go-against-police-report' => array( 1679, 'Can an Insurance Company Go Against a Police Report in Georgia or South Carolina?' ),
    'can-someone-sue-me-for-a-car-accident' => array( 1675, 'Can Someone Sue Me For A Car Accident?' ),
    'car-accident-checklist' => array( 1671, 'Car Accident Checklist - 8 Steps to Take after your Wreck' ),
    'car-accident-claims-why-you-need-an-attorney' => array( 1688, 'Car Accident Claims: Why You Need an Attorney for Maximum Compensation' ),
    'concussion-signs-after-car-accident' => array( 1835, 'Concussion Signs to Watch Out for After a Car Accident' ),
    'determining-fault-after-georgia-car-accident' => array( 1836, 'Determining Fault After a Georgia Car Accident' ),
    'do-traffic-tickets-play-role-in-claim' => array( 1740, 'Do Traffic Tickets Play a Role in a Car Accident Claim?' ),
    'does-daylight-saving-time-increase-car-accidents' => array( 1791, 'Does Daylight Saving Time Increase Car Accidents?' ),
    'filing-a-car-accident-claim-as-passenger' => array( 1804, 'Filing a Car Accident Claim as a Passenger' ),
    'filing-claim-against-deceased-driver' => array( 1649, 'Filing a Claim Against a Deceased At-Fault Driver: What to Know' ),
    'filing-claim-for-teen-driver-accident' => array( 1733, 'Filing a Claim for an Accident Caused by a Teen Driver' ),
    'how-dashcam-footage-can-help' => array( 1779, 'How Dashcam Footage Can Help Prove Fault for a Car Accident' ),
    'how-social-media-can-hurt-accident-claim' => array( 1776, 'How Using Social Media Can Hurt an Accident Claim' ),
    'how-to-avoid-blind-spot-accident' => array( 1831, 'How to Avoid a Blind Spot Accident' ),
    'liability-for-accident-during-heavy-rainfall' => array( 1716, 'Determining Liability for Accidents During Heavy Rainfall' ),
    'liability-in-rear-end-accident' => array( 1780, 'Liability in a Rear-End Car Accident' ),
    'types-of-major-injuries-from-minor-accidents' => array( 1763, "Types of Major Injuries From 'Minor' Car Accidents" ),
    'what-evidence-is-useful-in-car-accident-claim' => array( 1807, 'What Evidence is Useful in a Car Accident Claim?' ),
    'what-georgia-law-requires-after-accident' => array( 1766, 'What Georgia Law Requires Drivers to do After an Accident' ),
    'what-if-at-fault-driver-offers-cash' => array( 2709, 'What if an At-Fault Driver Offers Cash After a Savannah Car Crash?' ),
    'what-is-difference-fault-no-fault-state' => array( 1749, 'What is the Difference Between a Fault and No-Fault State for Car Crash Claims?' ),
    'what-makes-car-accident-witness-credible' => array( 1758, 'What Makes a Car Accident Witness Credible?' ),
    'who-may-be-liable-lane-change-accident' => array( 1734, 'Who May Be Liable for a Lane-Change Accident?' ),
    'why-fault-complicated-multi-vehicle-crash' => array( 1773, 'Why Fault Can be Complicated in a Multi-Vehicle Crash' ),
);

$success = 0;
$skipped = 0;
$errors  = 0;

foreach ( $images as $filename => $data ) {
    list( $post_id, $alt_text ) = $data;

    // Check if post already has a featured image
    $existing = get_post_meta( $post_id, '_thumbnail_id', true );
    if ( $existing ) {
        echo "SKIP: Post {$post_id} already has featured image.\n";
        $skipped++;
        continue;
    }

    // Find the uploaded file
    $file_path = $base_path . '/' . $filename . '.png';
    if ( ! file_exists( $file_path ) ) {
        echo "ERROR: File not found: {$file_path}\n";
        $errors++;
        continue;
    }

    // Prepare attachment
    $filetype = wp_check_filetype( $file_path );
    $attachment = array(
        'post_mime_type' => $filetype['type'],
        'post_title'     => $alt_text,
        'post_content'   => '',
        'post_status'    => 'inherit',
    );

    // Insert attachment
    $attach_id = wp_insert_attachment( $attachment, $file_path, $post_id );
    if ( is_wp_error( $attach_id ) ) {
        echo "ERROR: Could not insert attachment for {$filename}: " . $attach_id->get_error_message() . "\n";
        $errors++;
        continue;
    }

    // Generate metadata
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
    wp_update_attachment_metadata( $attach_id, $attach_data );

    // Set alt text
    update_post_meta( $attach_id, '_wp_attachment_image_alt', $alt_text );

    // Set as featured image
    set_post_thumbnail( $post_id, $attach_id );

    echo "OK: Post {$post_id} => attachment {$attach_id} ({$filename})\n";
    $success++;
}

echo "\nDone. Success: {$success}, Skipped: {$skipped}, Errors: {$errors}\n";
