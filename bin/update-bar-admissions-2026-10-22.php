<?php
/**
 * Set the visible bar admissions on two attorney profiles (owner: Brian, 2026-10-22).
 *
 *   ssh $H "wp --path=... eval-file -"       < bin/update-bar-admissions-2026-10-22.php
 *   ssh $H "wp --path=... eval-file - apply" < bin/update-bar-admissions-2026-10-22.php
 *
 * `_roden_bar_admissions` is a newline-separated list. It renders as the
 * profile's "Licensed:" line and "Bar Admissions" list, and is read by the
 * Person schema (hasCredential) and the auto meta description, which takes
 * each line's text before the first comma as a state. So one state name per
 * line: "Massachusetts Bar Association" had produced "Licensed in
 * Massachusetts Bar Association" in Nolan Alexander's description.
 *
 * Matches client.json and inc/firm-data.php (#234, #236).
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];
echo $apply ? "=== APPLY ===\n\n" : "=== DRY RUN (pass 'apply' to write) ===\n\n";

$set = array(
	'graeham-c-gillin' => array( 'South Carolina', 'North Carolina', 'Arizona', 'Texas', 'Montana', 'District of Columbia', 'New York', 'Colorado', 'Connecticut', 'Pennsylvania', 'Tennessee', 'Massachusetts', 'Washington' ),
	'nolan-alexander'  => array( 'South Carolina', 'Massachusetts' ),
);

$backups = array();
foreach ( $set as $slug => $states ) {
	$p = get_page_by_path( $slug, OBJECT, 'attorney' );
	if ( ! $p || 'publish' !== $p->post_status ) {
		echo "  SKIP $slug: not a published attorney\n";
		continue;
	}
	$before = (string) get_post_meta( $p->ID, '_roden_bar_admissions', true );
	$after  = implode( "\n", $states );
	printf( "  [%d] %s\n    - %s\n    + %s\n", $p->ID, $slug, str_replace( "\n", ' | ', $before ), str_replace( "\n", ' | ', $after ) );
	if ( $apply ) {
		$backups[ $p->ID ] = $before;
		update_post_meta( $p->ID, '_roden_bar_admissions', wp_slash( $after ) );
		clean_post_cache( $p->ID );
		$now = (string) get_post_meta( $p->ID, '_roden_bar_admissions', true );
		echo '    verify: ' . ( $now === $after ? 'ok' : 'MISMATCH' ) . "\n";
	}
}
if ( $apply ) {
	echo "\nBACKUP-JSON: " . wp_json_encode( $backups ) . "\nDone.\n";
} else {
	echo "\nDry run. Re-run with 'apply' to write.\n";
}
