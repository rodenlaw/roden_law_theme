<?php
/**
 * Post 1851 /blog/much-worth-ga-worker-compared-states/: take the stale
 * benefit dollar figures off the page (owner, 2026-11-02, option 1).
 *
 *   ssh $H "wp --path=/home/wpe-user/sites/rodenlawprod eval-file -"       < bin/remove-stale-benefit-figures-1851.php
 *   ssh $H "wp --path=/home/wpe-user/sites/rodenlawprod eval-file - apply" < bin/remove-stale-benefit-figures-1851.php
 *
 * The amputation table's Georgia column is the schedule weeks times $525/week
 * (arm 225 x 525 = 118,125; hand 160 x 525 = 84,000; eye 150 x 525 = 78,750).
 * That was Georgia's maximum around 2015-16, and the page presented it as
 * current. The Alabama, Florida and California columns come from ProPublica's
 * 2015 investigation and cannot be verified against any pack.
 *
 * Claim class: dollar figures for state benefit levels presented as current.
 * Swept in all four places a claim can live:
 *   post_content          the table and its lead-in/follow-up sentences: replaced.
 *                         Alabama "$45,000" sentence: kept, dated to the 2015 source.
 *   _roden_faqs           FAQ 1 repeats the Alabama $45,000: dated the same way.
 *   _roden_key_takeaways  not set on this post.
 *   post_excerpt          no figures.
 * The replacement text adds no claim about Georgia law. § 34-9-263 is not in
 * the GA pack, and the D6 rule bars new claims resting on unsigned packs.
 * The current figures belong to the rebuild (option 2), after Love's sign-off.
 *
 * Every edit must match exactly once, or the script writes nothing. Writes go
 * through wp_slash(). Afterwards: check-unslashed-post-writes.php, both cache
 * flushes, and regenerate content/meta.json.
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
echo $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (pass 'apply' to write) ===\n\n";

$id = 1851;
$p  = get_post( $id );
if ( ! $p || 'much-worth-ga-worker-compared-states' !== $p->post_name ) {
	echo "ABORT: post $id missing or slug mismatch\n";
	return;
}

$ok      = true;
$content = $p->post_content;

/* 1. Lead-in paragraph + table + follow-up paragraph -> one dated paragraph. */
$pat = '#Georgia’s workers’ comp policies pay significantly more for the most serious and debilitating injuries, such as amputations, than many other states\. Here’s a brief chart comparing Georgia’s average maximums for amputated body parts to similar maximums elsewhere:\s*<table\b.*?</table>\s*As the above chart suggests, Georgia is doing relatively well in some areas of workers’ comp compared to other states, although it’s nowhere near the top of the rankings\. This <a href="https://projects\.propublica\.org/graphics/workers-compensation-benefits-by-limb">helpful tool</a> from ProPublica’s workers’ compensation investigation project reveals more information about different workers’ comp payments around the country; Georgia tends to fall in the middle\.#su';
$new = 'How Georgia compares for the most serious injuries, such as the loss of a limb, depends on dollar figures that change over time. ProPublica’s <a href="https://projects.propublica.org/graphics/workers-compensation-benefits-by-limb">interactive tool</a> from its 2015 investigation compares what each state paid at the time for the loss of a body part; Georgia fell in the middle. Those amounts are now years old, so what your own injury is worth should be worked out under current Georgia law, with an attorney.';
$n = preg_match_all( $pat, $content );
echo "[body] table block matches: $n\n";
if ( 1 === $n ) {
	$content = preg_replace( $pat, $new, $content, 1 );
} else {
	$ok = false;
}

/* 2. Alabama sentence in the body: date it to the source. */
$old_al = 'For instance, a worker who loses an arm on the job in Alabama – the state with the lowest workers’ comp benefits in the country – could expect $45,000 total compensation – it would be laughable it if weren’t so tragic.';
$new_al = 'For instance, ProPublica’s 2015 investigation found that a worker who lost an arm on the job in Alabama, then the state with the lowest workers’ comp benefits in the country, could expect about $45,000 in total compensation.';
$n = substr_count( $content, $old_al );
echo "[body] Alabama sentence matches: $n\n";
if ( 1 === $n ) {
	$content = str_replace( $old_al, $new_al, $content );
} else {
	$ok = false;
}

if ( false !== strpos( $content, '<table' ) || preg_match( '/\$(118,125|84,000|78,750|48,840|186,293|190,603)/', $content ) ) {
	echo "[body] a table or stale figure survives\n";
	$ok = false;
}

/* 3. FAQ 1 repeats the Alabama figure. */
$faqs = get_post_meta( $id, '_roden_faqs', true );
$q1   = "Which state pays the least in workers' compensation?";
$a1   = "Alabama has the lowest workers' comp benefits in the country. A worker who loses an arm on the job there could expect $45,000 in total compensation, which is a stark illustration of how far benefits vary by state.";
$a1n  = "In ProPublica's 2015 investigation, Alabama had the lowest workers' comp benefits in the country: a worker who lost an arm on the job there could expect about $45,000 in total compensation. The figures are years old, but they show how far benefits can vary from one state to the next.";
if ( ! is_array( $faqs ) || ! isset( $faqs[1] ) || $faqs[1]['question'] !== $q1 || $faqs[1]['answer'] !== $a1 ) {
	echo "[faq] FAQ 1 does not match the expected text\n";
	$ok = false;
} else {
	echo "[faq] FAQ 1 matches\n";
	$faqs_new                = $faqs;
	$faqs_new[1]['answer']   = $a1n;
}

if ( ! $ok ) {
	echo "\nABORT: nothing written.\n";
	return;
}

echo "\n  body: -" . ( strlen( $p->post_content ) - strlen( $content ) ) . " bytes\n";
echo "  + $new\n  + $new_al\n  faq1 + $a1n\n";

if ( ! $apply ) {
	echo "\nDry run. Re-run with 'apply' to write.\n";
	return;
}

$backup = array( 'post_content' => $p->post_content, '_roden_faqs' => $faqs );
$r = wp_update_post( wp_slash( array( 'ID' => $id, 'post_content' => $content ) ), true );
if ( is_wp_error( $r ) ) {
	echo 'ERROR: ' . $r->get_error_message() . "\n";
	return;
}
update_post_meta( $id, '_roden_faqs', wp_slash( $faqs_new ) );
clean_post_cache( $id );

$c_ok = get_post_field( 'post_content', $id, 'raw' ) === $content;
$f_ok = get_post_meta( $id, '_roden_faqs', true ) === $faqs_new;
echo "\nverify body: " . ( $c_ok ? 'ok' : 'MISMATCH' ) . "\nverify faq: " . ( $f_ok ? 'ok' : 'MISMATCH' ) . "\n";
echo "\nBACKUP-JSON: " . wp_json_encode( $backup ) . "\nDone.\n";
