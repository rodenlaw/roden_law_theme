<?php
/**
 * Create Study #2's South Carolina report as a DRAFT `resource` page.
 *
 *   /resources/south-carolina-truck-crash-deaths-2020-2024/
 *   "Truck-Crash Deaths in South Carolina, 2020–2024: What the Federal Crash Data Shows"
 *
 * November plan entry 3 (content-plan/2026-11.md). Copied from
 * bin/seed-corridor-report.php (Study #1), with the payload embedded instead of
 * read from a file on the server: nothing outside the site directory persists on
 * WP Engine between SSH sessions, and scp/sftp are refused.
 *
 * BUILD, DON'T HAND-ROLL. bin/build-sc-truck-seed.py runs bin/truck-study-verify.py
 * (every number in the body against the stats and the CSV) and refuses to build on
 * any failure, then prepends RODEN_SEED_JSON to this file:
 *
 *   python3 bin/build-sc-truck-seed.py > /tmp/seed-sc-truck.php
 *   ssh $H "wp --path=$P eval-file -"       < /tmp/seed-sc-truck.php   # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < /tmp/seed-sc-truck.php   # write the draft
 *
 * WHAT IT WRITES (apply):
 *   - the post, as a DRAFT (an existing post keeps its status; nothing is ever
 *     published or demoted here; publishing is a separate deliberate act);
 *   - _roden_author_attorney = Graeham C. Gillin (resolved by slug, must be a
 *     published attorney), _roden_jurisdiction = sc, _roden_meta_title,
 *     _roden_meta_description, _roden_last_refreshed = today;
 *   - practice_category: appends the existing term (truck-accidents); never
 *     creates a term;
 *   - the crash-level CSV in the media library, attached to the post. Media
 *     library, not the theme: deploys force-push over the theme directory. The
 *     body's dataset href is rewritten to the real attachment URL, and
 *     _roden_dataset_url is set. Idempotent: a re-run overwrites the same file in
 *     place, so the published download URL never changes between editions.
 *
 * WHAT IT DOES NOT WRITE: _roden_last_reviewed or _roden_reviewed_by. Gillin
 * approved this text on the October review (sc-truck-report, 2026-10-26), but a
 * review is recorded through bin/record-attorney-reviews.php, which checks bar
 * admission against the page's jurisdiction and requires a source. The seeder
 * prints the entry to record. If the body changes before publication, that
 * approval no longer covers it.
 *
 * Every write goes through wp_slash(): wp_insert_post(), wp_update_post() and
 * update_post_meta() all unslash (CLAUDE.md, 2026-09-09).
 *
 * (Keep literal PHP open tags out of this file's comments: the builder prepends
 * the payload header and keeps PHP mode open.)
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}
if ( ! defined( 'RODEN_SEED_JSON' ) ) {
	fwrite( STDERR, "RODEN_SEED_JSON is not defined: build with bin/build-sc-truck-seed.py.\n" );
	exit( 1 );
}

$mode = isset( $args[0] ) ? $args[0] : 'dry-run';
if ( ! in_array( $mode, array( 'dry-run', 'apply' ), true ) ) {
	fwrite( STDERR, "Unknown mode '$mode'. Use dry-run | apply.\n" );
	exit( 1 );
}
$apply = 'apply' === $mode;

$p = json_decode( RODEN_SEED_JSON, true );
if ( ! is_array( $p ) ) {
	fwrite( STDERR, 'Payload is not valid JSON: ' . json_last_error_msg() . "\n" );
	exit( 1 );
}
foreach ( array( 'slug', 'title', 'content', 'excerpt', 'meta_title', 'meta_description', 'jurisdiction', 'author_slug', 'author_user', 'practice_category', 'csv_name', 'csv_body', 'csv_href_in_body', 'review_on_record' ) as $k ) {
	if ( empty( $p[ $k ] ) ) {
		fwrite( STDERR, "ABORT: payload missing '$k'.\n" );
		exit( 1 );
	}
}

echo ( $apply ? 'APPLY' : 'DRY RUN' ) . " — /resources/{$p['slug']}/\n";
echo "payload: built {$p['built_at']} from {$p['git_head']}; verifier: {$p['verifier']}\n";
echo "         body sha256 {$p['content_sha256']}, csv sha256 {$p['csv_sha256']}\n";

/* -- Guards (all run in dry run too) ------------------------------------------ */
$problems = array();

$atty = get_posts( array( 'post_type' => 'attorney', 'name' => $p['author_slug'], 'post_status' => 'publish', 'posts_per_page' => 1 ) );
$atty = $atty ? $atty[0] : null;
if ( ! $atty ) {
	$problems[] = "attorney '{$p['author_slug']}' not found or not published";
}

$user = get_user_by( 'login', $p['author_user'] );
if ( ! $user ) {
	$problems[] = "WordPress user '{$p['author_user']}' not found (refusing to write post_author 0)";
}

$term = get_term_by( 'slug', $p['practice_category'], 'practice_category' );
if ( ! $term ) {
	$problems[] = "practice_category term '{$p['practice_category']}' does not exist (this script never creates one)";
}

if ( 1 !== substr_count( $p['content'], 'href="' . $p['csv_href_in_body'] . '"' ) ) {
	$problems[] = "body must carry the dataset href '{$p['csv_href_in_body']}' exactly once";
}
if ( preg_match( '/O\.C\.G\.A\.|S\.C\. Code|§/u', $p['content'] . $p['excerpt'] ) ) {
	$problems[] = 'body or excerpt cites a statute: research assets carry no legal claim';
}

// `resource` is not hierarchical, so a lookup by name is reliable (see seed-corridor-report.php).
$existing = get_posts( array( 'post_type' => 'resource', 'name' => $p['slug'], 'post_status' => array( 'publish', 'draft', 'pending', 'private' ), 'posts_per_page' => 1 ) );
$existing = $existing ? $existing[0] : null;

// The dataset: is it already in the media library, and to whom does it belong?
$att_found = get_posts( array(
	'post_type'      => 'attachment',
	'post_status'    => 'any',
	'posts_per_page' => -1,
	'meta_query'     => array( array( 'key' => '_wp_attached_file', 'value' => '/' . $p['csv_name'], 'compare' => 'LIKE' ) ),
) );
$att_reuse = null;
foreach ( $att_found as $a ) {
	if ( basename( (string) get_attached_file( $a->ID ) ) !== $p['csv_name'] ) {
		continue;
	}
	if ( $existing && (int) $a->post_parent === (int) $existing->ID ) {
		$att_reuse = $a;
	} else {
		$problems[] = "attachment {$a->ID} already holds {$p['csv_name']} but belongs to post {$a->post_parent}, not this page";
	}
}
if ( ! $att_reuse ) {
	$up   = wp_upload_dir();
	$dest = trailingslashit( $up['path'] ) . $p['csv_name'];
	if ( file_exists( $dest ) ) {
		$problems[] = "$dest already exists unattached: an upload would be renamed and the dataset link would no longer name the published CSV";
	}
}

echo 'byline:        ' . ( $atty ? "{$atty->ID} {$atty->post_title}" : '(missing)' ) . "\n";
echo 'post author:   ' . ( $user ? "{$user->ID} {$user->display_name}" : '(missing)' ) . "\n";
echo 'category:      ' . ( $term ? "{$term->slug} ({$term->term_id})" : '(missing)' ) . "\n";
echo 'post:          ' . ( $existing ? "UPDATE existing #{$existing->ID} ({$existing->post_status}); status kept" : 'CREATE as draft' ) . "\n";
echo 'title:         ' . $p['title'] . "\n";
echo 'content:       ' . strlen( $p['content'] ) . ' bytes, ' . str_word_count( wp_strip_all_tags( $p['content'] ) ) . ' words, '
	. substr_count( $p['content'], '[roden_chart ' ) . " charts\n";
echo 'meta title:    ' . $p['meta_title'] . ' (' . mb_strlen( $p['meta_title'] ) . ")\n";
echo 'meta desc:     ' . mb_strlen( $p['meta_description'] ) . " chars\n";
echo 'jurisdiction:  ' . $p['jurisdiction'] . "\n";
echo 'dataset:       ' . $p['csv_name'] . ', ' . strlen( $p['csv_body'] ) . ' bytes, '
	. ( $att_reuse ? "overwrite attachment {$att_reuse->ID} in place" : 'new upload' ) . "\n";
echo "review:        not written here (see the end of an apply run)\n";

if ( $problems ) {
	fwrite( STDERR, "ABORT, nothing written:\n  - " . implode( "\n  - ", $problems ) . "\n" );
	exit( 1 );
}
if ( ! $apply ) {
	echo "\nDRY RUN: nothing written. Re-run with: eval-file - apply\n";
	exit( 0 );
}

/* -- Apply --------------------------------------------------------------------- */
$postarr = array(
	'post_type'    => 'resource',
	'post_name'    => $p['slug'],
	'post_title'   => $p['title'],
	'post_content' => $p['content'],
	'post_excerpt' => $p['excerpt'],
	'post_status'  => $existing ? $existing->post_status : 'draft',
	'post_author'  => (int) $user->ID, // explicit: WP-CLI has no current user, so an omitted author becomes 0
);
if ( $existing ) {
	$postarr['ID'] = $existing->ID;
}
$id = wp_insert_post( wp_slash( $postarr ), true );
if ( is_wp_error( $id ) ) {
	fwrite( STDERR, 'ABORT: ' . $id->get_error_message() . "\n" );
	exit( 1 );
}
echo "post #$id written (" . get_post_status( $id ) . ")\n";

$meta = array(
	'_roden_author_attorney'  => (int) $atty->ID,
	'_roden_jurisdiction'     => $p['jurisdiction'],
	'_roden_meta_title'       => $p['meta_title'],
	'_roden_meta_description' => $p['meta_description'],
	'_roden_last_refreshed'   => current_time( 'Y-m-d' ),
);
foreach ( $meta as $k => $v ) {
	update_post_meta( $id, $k, wp_slash( $v ) );
}
$t = wp_set_object_terms( $id, (int) $term->term_id, 'practice_category', true );
if ( is_wp_error( $t ) ) {
	fwrite( STDERR, 'WARNING: practice_category not set: ' . $t->get_error_message() . "\n" );
}

/* Dataset: overwrite in place, or upload and attach. */
if ( $att_reuse ) {
	$file = get_attached_file( $att_reuse->ID );
	if ( false === file_put_contents( $file, $p['csv_body'] ) ) {
		fwrite( STDERR, "ABORT: could not overwrite $file\n" );
		exit( 1 );
	}
	$att_id = $att_reuse->ID;
} else {
	$upload = wp_upload_bits( $p['csv_name'], null, $p['csv_body'] );
	if ( ! empty( $upload['error'] ) ) {
		fwrite( STDERR, 'ABORT: dataset upload failed: ' . $upload['error'] . " (post #$id exists as a draft without its dataset)\n" );
		exit( 1 );
	}
	$att_id = wp_insert_attachment( wp_slash( array(
		'post_mime_type' => 'text/csv',
		'post_title'     => 'South Carolina truck-involved fatal crashes, 2020-2024 (NHTSA FARS)',
		'post_content'   => '',
		'post_status'    => 'inherit',
	) ), $upload['file'], $id, true );
	if ( is_wp_error( $att_id ) ) {
		fwrite( STDERR, 'ABORT: ' . $att_id->get_error_message() . "\n" );
		exit( 1 );
	}
}
$csv_url = wp_get_attachment_url( $att_id );
if ( basename( (string) wp_parse_url( $csv_url, PHP_URL_PATH ) ) !== $p['csv_name'] ) {
	fwrite( STDERR, "ABORT: the dataset URL $csv_url does not name {$p['csv_name']}; body left pointing at the placeholder\n" );
	exit( 1 );
}
$csv_rel = wp_make_link_relative( $csv_url );
update_post_meta( $id, '_roden_dataset_url', wp_slash( $csv_url ) );

// Point the body's dataset link at the real file (the month folder differs from the placeholder's).
$content = str_replace( 'href="' . $p['csv_href_in_body'] . '"', 'href="' . $csv_rel . '"', $p['content'] );
$res     = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $content ) ), true );
if ( is_wp_error( $res ) ) {
	fwrite( STDERR, 'ABORT: body href rewrite failed: ' . $res->get_error_message() . "\n" );
	exit( 1 );
}
$stored = get_post_field( 'post_content', $id );
if ( 1 !== substr_count( $stored, 'href="' . $csv_rel . '"' ) || $stored !== $content ) {
	fwrite( STDERR, "ABORT: stored body does not match what was written (slashing?)\n" );
	exit( 1 );
}
clean_post_cache( $id );

echo "dataset:       attachment $att_id, $csv_rel\n";
echo "body:          dataset link rewritten, stored body verified byte-for-byte\n";
echo "\nSeeded as " . get_post_status( $id ) . ". Not published, no review recorded.\n";
echo "Next:\n";
echo "  1. legal sweep on the draft (body, excerpt, meta description, the rendered SC law box and sidebar)\n";
echo "  2. record the review, if the body is unchanged since it was approved:\n";
echo '     [{"post_id": ' . $id . ', "reviewer": "' . $p['author_slug'] . '", "date": "' . $p['review_on_record']['date']
	. '", "jurisdiction": "' . $p['jurisdiction'] . '", "source": "' . $p['review_on_record']['source'] . '"}]' . "\n";
echo "     through bin/record-attorney-reviews.php\n";
echo "  3. publish deliberately; then wp cache flush && wp page-cache flush\n";
