<?php
/**
 * Apply the "apply"-class edits from data/facts/linked-pages-batch-2026-09-28.json:
 * the consolidated linked-page findings from the 2026-09-26..28 legal sweeps.
 * Owner, 2026-09-28: "let's work through all the linked pages now".
 *
 * The edits are embedded (base64 JSON) by bin/build-linked-pages-batch.py, because
 * this script is piped to `wp eval-file -` and cannot read the repo. Each edit is
 * an exact substring that must occur exactly once in its field; any miss aborts
 * the whole run before anything is written. Fields: content, excerpt, title,
 * takeaways, faqN. Content/excerpt/title: direct column write (post_modified
 * untouched). Meta: update_post_meta( wp_slash() ). Every write is read back.
 *
 *   ssh $H "wp --path=$P eval-file -"       < bin/apply-linked-pages-batch.php > docs/backups/linked-pages-batch-2026-09-28.json
 *   ssh $H "wp --path=$P eval-file - apply" < bin/apply-linked-pages-batch.php > docs/backups/linked-pages-batch-2026-09-28.json
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

$apply = isset( $args[0] ) && 'apply' === $args[0];
global $wpdb;

$edits = json_decode( base64_decode( '__EDITS__' ), true );
if ( ! is_array( $edits ) || ! $edits ) {
	fwrite( STDERR, "ABORT: no edits embedded.\n" );
	exit( 1 );
}

$by = array();
foreach ( $edits as $e ) {
	$by[ (int) $e['post_id'] ][] = $e;
}

// Pass 1: compute every change; abort on any mismatch before writing anything.
$plan = array();
foreach ( $by as $id => $list ) {
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT post_status, post_title, post_content, post_excerpt FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	if ( ! $row || 'publish' !== $row->post_status ) {
		fwrite( STDERR, "ABORT: {$id} is not published.\n" );
		exit( 1 );
	}
	$cur = array(
		'title'     => (string) $row->post_title,
		'content'   => (string) $row->post_content,
		'excerpt'   => (string) $row->post_excerpt,
		'takeaways' => (string) get_post_meta( $id, '_roden_key_takeaways', true ),
		'faqs'      => get_post_meta( $id, '_roden_faqs', true ),
	);
	$new = $cur;
	foreach ( $list as $e ) {
		$field = $e['field'];
		if ( 0 === strpos( $field, 'faq' ) ) {
			$i    = (int) substr( $field, 3 );
			$text = ( is_array( $new['faqs'] ) && isset( $new['faqs'][ $i ]['answer'] ) ) ? $new['faqs'][ $i ]['answer'] : '';
		} elseif ( isset( $new[ $field ] ) && 'faqs' !== $field ) {
			$text = $new[ $field ];
		} else {
			fwrite( STDERR, "ABORT: {$e['id']}: unknown field {$field}\n" );
			exit( 1 );
		}
		$n = substr_count( $text, $e['from'] );
		if ( 1 !== $n ) {
			fwrite( STDERR, "ABORT: {$e['id']} ({$id} {$field}): found {$n} times: " . substr( $e['from'], 0, 80 ) . "\n" );
			exit( 1 );
		}
		$text = str_replace( $e['from'], $e['to'], $text );
		if ( 0 === strpos( $field, 'faq' ) ) {
			$new['faqs'][ $i ]['answer'] = $text;
		} else {
			$new[ $field ] = $text;
		}
	}
	$plan[ $id ] = array( 'cur' => $cur, 'new' => $new, 'n' => count( $list ) );
}

$backup = array( 'generated' => gmdate( 'c' ), 'batch' => 'linked-pages-batch-2026-09-28', 'mode' => $apply ? 'apply' : 'dry-run', 'posts' => array() );
foreach ( $plan as $id => $p ) {
	$backup['posts'][] = array( 'ID' => $id, 'before' => $p['cur'], 'after' => $p['new'] );
	fwrite( STDERR, sprintf( "  %s %-5d %-80s (%d edits)\n", $apply ? 'fixed' : 'would fix', $id, wp_make_link_relative( get_permalink( $id ) ), $p['n'] ) );
	if ( ! $apply ) {
		continue;
	}
	$cur = $p['cur'];
	$new = $p['new'];
	$cols = array();
	foreach ( array( 'title' => 'post_title', 'content' => 'post_content', 'excerpt' => 'post_excerpt' ) as $k => $col ) {
		if ( $new[ $k ] !== $cur[ $k ] ) {
			$cols[ $col ] = $new[ $k ];
		}
	}
	if ( $cols ) {
		$wpdb->update( $wpdb->posts, $cols, array( 'ID' => $id ), array_fill( 0, count( $cols ), '%s' ), array( '%d' ) );
	}
	if ( $new['takeaways'] !== $cur['takeaways'] ) {
		update_post_meta( $id, '_roden_key_takeaways', wp_slash( $new['takeaways'] ) );
	}
	if ( $new['faqs'] !== $cur['faqs'] ) {
		update_post_meta( $id, '_roden_faqs', wp_slash( $new['faqs'] ) );
	}
	clean_post_cache( $id );
	wp_cache_delete( $id, 'post_meta' );
	$back = $wpdb->get_row( $wpdb->prepare( "SELECT post_title, post_content, post_excerpt FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	if ( $back->post_title !== $new['title'] || $back->post_content !== $new['content'] || $back->post_excerpt !== $new['excerpt']
		|| (string) get_post_meta( $id, '_roden_key_takeaways', true ) !== $new['takeaways']
		|| get_post_meta( $id, '_roden_faqs', true ) !== $new['faqs'] ) {
		fwrite( STDERR, "FAILED: read-back mismatch on {$id}\n" );
		exit( 1 );
	}
}

echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
fwrite( STDERR, sprintf( "\n%s: %d edits across %d posts\n", $apply ? 'Fixed' : 'Would fix', count( $edits ), count( $plan ) ) );
