<?php
/**
 * Publish the I-26/I-95 Corridor Report as a `resource` page.
 *
 * Steinberg plan §3 priority 1. The report is the first of the linkable research
 * assets that section describes, and the point of it is citability: it earns
 * editorial links only if a journalist can check it, so the analysis script, the
 * chart generator and the crash-level dataset all ship with the prose.
 *
 * Lives in /resources/ rather than a new /research/ route, by decision on
 * 2026-08-25. The `resource` CPT already carries templates, schema, FAQ, author
 * attribution and /es/ plumbing; a new route would need rewrite rules, a template,
 * new msgids, and a bump to the hardcoded flush constant in inc/rewrite-rules.php
 * that silently 404s new routes until someone remembers it.
 *
 * BYLINE. `_roden_author_attorney` holds one attorney, so Eric Roden (Georgia bar)
 * goes in the meta and Graeham C. Gillin (South Carolina bar) is credited in the
 * byline prose. Plan §4 asks for exactly that pairing on two-state content: "an
 * E-E-A-T no template can fake". `_roden_last_reviewed` is NOT set here — no
 * attorney has reviewed this text at seed time, and manufacturing that signal is
 * what inc/schema-helpers.php warns against. Set it after an actual review.
 *
 * ANALYST CREDIT is deliberately institutional rather than a personal name: the
 * analysis is machine-generated from published federal data, and the committed
 * script is the real credential. A fabricated human byline would be the same
 * class of error the 2026-08-25 statistics audit removed from 21 pages.
 *
 * The CSV is attached to the post via the media library so the download URL is
 * stable and survives theme deploys, which overwrite the theme directory.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file - <payload.json>" < bin/seed-corridor-report.php
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - <payload.json> apply" < bin/seed-corridor-report.php
 */

$path  = isset( $args[0] ) ? (string) $args[0] : '';
$apply = isset( $args[1] ) && 'apply' === $args[1];

$err = fopen( 'php://stderr', 'w' );
if ( '' === $path || ! file_exists( $path ) ) {
    fprintf( $err, "Usage: eval-file - <payload.json> [apply]\n" );
    exit( 1 );
}
$p = json_decode( (string) file_get_contents( $path ), true );
foreach ( array( 'slug', 'title', 'content', 'excerpt', 'csv_name', 'csv_body' ) as $k ) {
    if ( empty( $p[ $k ] ) ) {
        fprintf( $err, "ABORT: payload missing '%s'.\n", $k );
        exit( 1 );
    }
}

fprintf( $err, "%s — seed %s\n\n", $apply ? 'APPLY' : 'DRY RUN', $p['slug'] );

/* Resolve the byline attorney by slug rather than a hardcoded ID. */
$atty = get_posts( array( 'post_type' => 'attorney', 'name' => $p['author_slug'], 'post_status' => 'publish', 'posts_per_page' => 1 ) );
if ( ! $atty ) {
    fprintf( $err, "ABORT: attorney '%s' not found or not published.\n", $p['author_slug'] );
    exit( 1 );
}
$atty = $atty[0];
fprintf( $err, "  byline attorney: %d %s\n", $atty->ID, $atty->post_title );

/*
 * `resource` is NOT hierarchical, so get_posts( 'name' => ... ) is reliable here.
 * inc/legacy-redirects.php says so explicitly for the same reason. On
 * practice_area or location this lookup silently fails and a second run creates
 * duplicates — that happened on 2026-08-19 and produced 70 posts for 35 pages.
 */
$existing = get_posts( array( 'post_type' => 'resource', 'name' => $p['slug'], 'post_status' => array( 'publish', 'draft', 'pending' ), 'posts_per_page' => 1 ) );
if ( $existing ) {
    fprintf( $err, "  existing post %d (%s) — will UPDATE\n", $existing[0]->ID, $existing[0]->post_status );
} else {
    fprintf( $err, "  no existing post — will CREATE as draft\n" );
}

fprintf( $err, "  content: %d bytes, %d words\n", strlen( $p['content'] ), str_word_count( wp_strip_all_tags( $p['content'] ) ) );
fprintf( $err, "  dataset: %s, %d bytes\n", $p['csv_name'], strlen( $p['csv_body'] ) );

if ( ! $apply ) {
    fprintf( $err, "\nDry run only. Nothing written.\n" );
    exit( 0 );
}

/*
 * Resolve the post author. Institutional rather than a person, matching the
 * analyst credit: the analysis is machine-generated from published federal data.
 */
$author_login = ! empty( $p['author_user'] ) ? $p['author_user'] : 'Roden Law';
$author_user  = get_user_by( 'login', $author_login );
if ( ! $author_user ) {
    fprintf( $err, "ABORT: WordPress user '%s' not found — refusing to seed with author 0.\n", $author_login );
    exit( 1 );
}
$author_id = (int) $author_user->ID;
fprintf( $err, "  post author: %d %s\n", $author_id, $author_user->display_name );

$postarr = array(
    'post_type'    => 'resource',
    'post_name'    => $p['slug'],
    'post_title'   => $p['title'],
    'post_content' => $p['content'],
    'post_excerpt' => $p['excerpt'],
    /*
     * Seeded as a DRAFT. This is a research publication carrying the firm's name
     * and two attorneys' credibility; it should be read by a human before it is
     * public. Publishing is a deliberate second act, not a side effect of seeding.
     */
    'post_status'  => $existing ? $existing[0]->post_status : 'draft',
    /*
     * Set the author explicitly. wp_insert_post() run through WP-CLI has no
     * current user, so an omitted post_author becomes 0 — and on an UPDATE it
     * silently resets an author that was already correct. Found by re-running
     * this seeder and watching a deliberate author revert to 0.
     *
     * Resolved by login rather than a hardcoded ID so this survives a database
     * that numbers its users differently.
     */
    'post_author'  => $author_id,
);
if ( $existing ) {
    $postarr['ID'] = $existing[0]->ID;
}
$id = wp_insert_post( $postarr, true );
if ( is_wp_error( $id ) ) {
    fprintf( $err, "ABORT: %s\n", $id->get_error_message() );
    exit( 1 );
}
fprintf( $err, "  post %d written (%s)\n", $id, get_post_status( $id ) );

update_post_meta( $id, '_roden_author_attorney', $atty->ID );
update_post_meta( $id, '_roden_last_refreshed', current_time( 'Y-m-d' ) );
update_post_meta( $id, '_roden_jurisdiction', 'both' );

/*
 * Attach the dataset. Media library, not the theme directory: deploys force-push
 * over the theme and would delete it.
 *
 * Idempotent by necessity. The first version called wp_upload_bits()
 * unconditionally, so re-running the seeder produced a second attachment at
 * "…-1.csv" and repointed the meta at it — leaving the original orphaned and the
 * published download URL silently changed. A seeder that cannot be run twice is
 * a seeder that will be run twice.
 */
$existing_att = get_posts( array(
    'post_type'      => 'attachment',
    'post_parent'    => $id,
    'post_status'    => 'any',
    'posts_per_page' => -1,
) );
$reused = false;
foreach ( $existing_att as $att_post ) {
    $file = get_attached_file( $att_post->ID );
    if ( $file && basename( $file ) === $p['csv_name'] ) {
        // Overwrite in place so the published URL never changes between editions.
        file_put_contents( $file, $p['csv_body'] );
        update_post_meta( $id, '_roden_dataset_url', wp_get_attachment_url( $att_post->ID ) );
        fprintf( $err, "  dataset updated in place: %s\n", wp_get_attachment_url( $att_post->ID ) );
        $reused = true;
        break;
    }
}
if ( $reused ) {
    fprintf( $err, "\nSeeded as %s. Review, then publish.\n", get_post_status( $id ) );
    fprintf( $err, "Do NOT set _roden_last_reviewed until an attorney has actually read it.\n" );
    exit( 0 );
}

$upload = wp_upload_bits( $p['csv_name'], null, $p['csv_body'] );
if ( ! empty( $upload['error'] ) ) {
    fprintf( $err, "  WARNING: dataset upload failed: %s\n", $upload['error'] );
} else {
    $att = wp_insert_attachment( array(
        'post_mime_type' => 'text/csv',
        'post_title'     => 'I-26 / I-95 corridor fatal crashes, 2020-2024 (FARS)',
        'post_content'   => '',
        'post_status'    => 'inherit',
    ), $upload['file'], $id );
    if ( ! is_wp_error( $att ) ) {
        update_post_meta( $id, '_roden_dataset_url', $upload['url'] );
        fprintf( $err, "  dataset attached: %s\n", $upload['url'] );
    }
}

fprintf( $err, "\nSeeded as %s. Review, then publish.\n", get_post_status( $id ) );
fprintf( $err, "Do NOT set _roden_last_reviewed until an attorney has actually read it.\n" );
