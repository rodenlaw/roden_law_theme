<?php
/**
 * Add an inline link from the truck pillar to the settlement-process resource.
 *
 * WHY A META EDIT AND NOT post_content
 * ------------------------------------
 * The truck pillar's post_content is 412 bytes of boilerplate — the page is
 * rendered from meta by templates/template-practice-area.php. And that template
 * does not render _roden_see_also (only single-resource.php and
 * template-subtype.php do), so the usual "related pages" route stores inert
 * data on a practice_area.
 *
 * _roden_why_hire is the field that already carries this exact pattern: raw
 * HTML paragraphs, the last two of which are sibling-page pointers (to the
 * 18-wheeler sub-type and to the SC truck page). This appends a third in the
 * same shape rather than inventing a new mechanism.
 *
 * Deliberately NOT touching _roden_pillar_negligence_intro or
 * _roden_pillar_compensation_intro: those carry a templating layer
 * ({{GA}}/{{SC}} conditionals, {sol_cite} placeholders) that a plain string
 * append would be liable to corrupt.
 *
 * Appends with plain concatenation — no preg_replace. The paragraph contains no
 * dollar figures today, but a "$" in a preg_replace replacement has silently
 * eaten content on this site before, so the whole class is avoided.
 *
 * Idempotent: skips if the field already links to the target.
 *
 *   ssh <prod> "wp --path=<site> eval-file -" < bin/en-link-pillar-to-settlement-process.php
 *   ssh <prod> "wp --path=<site> eval-file - apply" < bin/...
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI.\n" );
	exit( 1 );
}
$mode = isset( $args[0] ) ? $args[0] : 'dry-run';

$pillar_id = 3605; // /practice-areas/truck-accident-lawyers/
$field     = '_roden_why_hire';
$target    = '/resources/truck-accident-settlement-process/';

$para = '<p>Not sure what happens next? Our guide to '
	. '<a href="' . $target . '">how to start a truck accident settlement</a> '
	. 'walks through the seven phases from the first call to disbursement, and lists '
	. 'exactly what to bring to your first meeting so nothing stalls the claim.</p>';

echo "mode: $mode\n" . str_repeat( '-', 58 ) . "\n";

$post = get_post( $pillar_id );
if ( ! $post || 'practice_area' !== $post->post_type ) {
	fwrite( STDERR, "FATAL: #$pillar_id is not a practice_area post.\n" );
	exit( 1 );
}
echo "pillar:  #$pillar_id {$post->post_title} ({$post->post_status})\n";

// The target must actually exist and be published before we link to it.
$tgt = get_posts( array(
	'post_type'   => 'resource',
	'name'        => 'truck-accident-settlement-process',
	'post_status' => 'publish',
	'numberposts' => 1,
) );
if ( ! $tgt ) {
	fwrite( STDERR, "FATAL: target resource is not published — refusing to link to a 404.\n" );
	exit( 1 );
}
echo "target:  #{$tgt[0]->ID} published\n";

$cur = (string) get_post_meta( $pillar_id, $field, true );
echo "field:   $field, " . strlen( $cur ) . " bytes, "
	. substr_count( $cur, '<p>' ) . " paragraphs, "
	. substr_count( $cur, '<a href' ) . " links\n";

if ( false !== strpos( $cur, $target ) ) {
	echo str_repeat( '-', 58 ) . "\nSKIP — already links to the target. Nothing to do.\n";
	exit( 0 );
}

$new = rtrim( $cur ) . "\n" . $para;
echo "result:  " . strlen( $new ) . " bytes, "
	. substr_count( $new, '<p>' ) . " paragraphs, "
	. substr_count( $new, '<a href' ) . " links\n";
echo "adding:  " . wp_strip_all_tags( $para ) . "\n";

if ( 'dry-run' === $mode ) {
	echo str_repeat( '-', 58 ) . "\nDRY RUN — nothing written. Re-run with: apply\n";
	exit( 0 );
}

update_post_meta( $pillar_id, $field, $new );

$check = (string) get_post_meta( $pillar_id, $field, true );
echo str_repeat( '-', 58 ) . "\n";
echo 'wrote ' . strlen( $check ) . " bytes\n";
echo 'contains target: ' . ( false !== strpos( $check, $target ) ? 'yes' : 'NO — FAILED' ) . "\n";
echo 'prior text intact: ' . ( 0 === strpos( $check, substr( $cur, 0, 120 ) ) ? 'yes' : 'NO — FAILED' ) . "\n";
