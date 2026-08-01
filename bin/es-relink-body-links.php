<?php
/**
 * Rewrite in-body links inside Spanish posts to their Spanish counterparts.
 *
 * WHY THIS EXISTS
 * ---------------
 * The theme's related-content modules were made locale-aware on 2026-08-01
 * (see inc/i18n.php, roden_locale_meta_query). That fixed every link the
 * TEMPLATES emit. It does not touch links inside post_content, which the
 * Spanish writer agent authored pointing at English URLs — 236 of them across
 * 28 ES blog posts at first measurement.
 *
 * A Spanish reader following one of those lands on an English page. The link
 * equity leaves the silo, and the hreflang cluster gets muddier.
 *
 * WHAT IT DOES
 * ------------
 * For every post with _roden_locale=es, finds internal links whose path is not
 * under /es/, resolves the target post, and — only when that post has a
 * PUBLISHED Spanish twin (_roden_translation_es) — rewrites the href to the
 * twin's canonical URL. Targets with no Spanish twin are left exactly as they
 * are: an English page is a worse link than a Spanish one, but a 404 is worse
 * than both.
 *
 * RE-RUN IT AFTER PUBLISHING NEW SPANISH PAGES. It is idempotent, and each new
 * twin makes more of the remaining links resolvable. ~16 instances become
 * fixable once the Phase B pages (personal-injury pillar, motorcycle/bicycle/
 * pedestrian × city) are live.
 *
 * USAGE
 *   Dry run (default — prints every change it would make, writes nothing):
 *     ssh <prod> "wp --path=<site> eval-file -" < bin/es-relink-body-links.php
 *
 *   Back up the bodies it would touch (capture this locally before applying):
 *     ssh <prod> "wp --path=<site> eval-file - backup" < bin/es-relink-body-links.php > backup.json
 *
 *   Apply:
 *     ssh <prod> "wp --path=<site> eval-file - apply" < bin/es-relink-body-links.php
 *
 * The database is not in this repo and there is no undo. Take the backup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must run through WP-CLI (wp eval-file).\n" );
	exit( 1 );
}

$mode = isset( $args[0] ) ? $args[0] : 'dry-run';
if ( ! in_array( $mode, array( 'dry-run', 'backup', 'apply' ), true ) ) {
	fwrite( STDERR, "Unknown mode '$mode'. Use dry-run | backup | apply.\n" );
	exit( 1 );
}

/**
 * Paths with no post behind them, or whose post is a legacy redirect stub.
 *
 * /charleston/ and /savannah/ are legacy pages that 301 to the ENGLISH
 * /practice-areas/ hub, so from a Spanish body they were doubly wrong. Point
 * them at that city's Spanish office page instead.
 */
$explicit = array(
	'/'                => '/es/',
	'/contact/'        => '/es/contact/',
	'/about/'          => '/es/about/',
	'/blog/'           => '/es/blog/',
	'/locations/'      => '/es/locations/',
	'/practice-areas/' => '/es/practice-areas/',
	'/resources/'      => '/es/resources/',
	'/charleston/'     => '/es/locations/south-carolina/charleston/',
	'/savannah/'       => '/es/locations/georgia/savannah/',
);

$posts = get_posts( array(
	'post_type'      => array( 'practice_area', 'location', 'resource', 'post', 'page' ),
	'post_status'    => array( 'publish', 'draft' ),
	'posts_per_page' => -1,
	'orderby'        => 'ID',
	'order'          => 'ASC',
	'meta_query'     => array( array( 'key' => '_roden_locale', 'value' => 'es' ) ),
) );

/** Resolve an English path to its published Spanish counterpart, or ''. */
$resolve = function ( $path ) use ( $explicit ) {
	static $cache = array();
	$path = '/' . trim( $path, '/' );
	$path = ( '/' === $path ) ? '/' : $path . '/';
	if ( array_key_exists( $path, $cache ) ) {
		return $cache[ $path ];
	}
	if ( isset( $explicit[ $path ] ) ) {
		return $cache[ $path ] = $explicit[ $path ];
	}
	$id = url_to_postid( home_url( $path ) );
	if ( ! $id ) {
		return $cache[ $path ] = '';
	}
	$es_id = (int) get_post_meta( $id, '_roden_translation_es', true );
	if ( ! $es_id || 'publish' !== get_post_status( $es_id ) ) {
		return $cache[ $path ] = '';
	}
	return $cache[ $path ] = wp_make_link_relative( roden_get_canonical_url( $es_id ) );
};

$backup      = array();
$changed     = 0;
$links_fixed = 0;
$left        = 0;

foreach ( $posts as $p ) {
	$before      = $p->post_content;
	$fixed_start = $links_fixed;

	$after = preg_replace_callback(
		'#href=(["\'])([^"\']+)\1#i',
		function ( $m ) use ( $resolve, &$links_fixed, &$left ) {
			$quote = $m[1];
			$href  = $m[2];

			// Split off query/fragment so they survive the rewrite.
			$suffix = '';
			$core   = $href;
			if ( false !== ( $pos = strcspn( $href, '?#' ) ) && $pos < strlen( $href ) ) {
				$core   = substr( $href, 0, $pos );
				$suffix = substr( $href, $pos );
			}

			if ( preg_match( '#^https?://(?:www\.)?rodenlaw\.com(/.*)?$#i', $core, $x ) ) {
				$path = isset( $x[1] ) && '' !== $x[1] ? $x[1] : '/';
			} elseif ( preg_match( '#^/(?!/)#', $core ) ) {
				$path = $core;
			} else {
				return $m[0]; // external, mailto:, tel:, anchor-only
			}

			if ( preg_match( '#^/es(/|$)#', $path ) ) {
				return $m[0]; // already in locale
			}
			if ( preg_match( '#^/(wp-content|wp-admin|wp-json|feed)#', $path ) ) {
				return $m[0];
			}

			$es = $resolve( $path );
			if ( '' === $es ) {
				$left++;
				return $m[0]; // no Spanish twin — leave the English link
			}

			$links_fixed++;
			return 'href=' . $quote . $es . $suffix . $quote;
		},
		$before
	);

	if ( $after === $before ) {
		continue;
	}

	$changed++;
	$backup[ $p->ID ] = array(
		'url'     => wp_make_link_relative( get_permalink( $p ) ),
		'content' => $before,
	);

	if ( 'apply' === $mode ) {
		$res = wp_update_post( array( 'ID' => $p->ID, 'post_content' => $after ), true );
		if ( is_wp_error( $res ) ) {
			fwrite( STDERR, sprintf( "FAILED %d: %s\n", $p->ID, $res->get_error_message() ) );
			exit( 1 );
		}
	}

	if ( 'backup' !== $mode ) {
		printf( "%-64s %d link(s)\n", substr( wp_make_link_relative( get_permalink( $p ) ), 0, 64 ), $links_fixed - $fixed_start );
	}
}

if ( 'backup' === $mode ) {
	echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
	exit( 0 );
}

printf(
	"\nmode=%s  posts scanned=%d  posts %s=%d  links rewritten=%d  links left English (no twin)=%d\n",
	$mode,
	count( $posts ),
	( 'apply' === $mode ? 'updated' : 'would change' ),
	$changed,
	$links_fixed,
	$left
);
if ( 'dry-run' === $mode ) {
	echo "Nothing was written. Re-run with 'backup' to capture bodies, then 'apply'.\n";
}
