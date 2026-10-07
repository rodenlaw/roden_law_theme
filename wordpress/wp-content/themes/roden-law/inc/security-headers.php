<?php
/**
 * Security Headers — the response headers the monthly site audit found missing.
 *
 * Sent on every front-end response via `send_headers` (wp-admin and wp-login
 * already send X-Frame-Options from core). WP Engine's page cache stores these
 * with the page, so flush both cache layers after deploying a change here.
 *
 *   Strict-Transport-Security  HTTPS only. Starts at one week, no
 *                              includeSubDomains, no preload: other subdomains
 *                              (mail, vendors) have not been checked for HTTPS,
 *                              and preload is very hard to undo. Raise max-age
 *                              to 31536000 once a week passes cleanly.
 *   X-Frame-Options +          Other sites may not put rodenlaw.com in a frame
 *   CSP frame-ancestors        (clickjacking). Same-origin framing (the
 *                              Customizer preview) still works. This CSP sets
 *                              ONLY frame-ancestors, so it restricts no scripts,
 *                              styles or embeds. A full CSP needs an inventory
 *                              of what GTM loads and should start Report-Only.
 *   X-Content-Type-Options     No MIME sniffing.
 *   Referrer-Policy            The browser default, made explicit: full URL on
 *                              same-origin requests, origin only cross-site, so
 *                              analytics and ad attribution see what they did before.
 *   Permissions-Policy         Features the site never uses. Geolocation is
 *                              left alone so the Google Maps embeds keep working.
 *
 * Not set here: `X-Powered-By: WP Engine` is added at WP Engine's edge after
 * PHP, so removing it is a WP Engine support request, not theme code.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

/**
 * Header name => value. Filterable so a header can be tuned or dropped without
 * editing this file: add_filter( 'roden_security_headers', fn( $h ) => ... ).
 *
 * @return array<string,string>
 */
function roden_security_headers() {
	$headers = array(
		'X-Frame-Options'         => 'SAMEORIGIN',
		'Content-Security-Policy' => "frame-ancestors 'self'",
		'X-Content-Type-Options'  => 'nosniff',
		'Referrer-Policy'         => 'strict-origin-when-cross-origin',
		'Permissions-Policy'      => 'camera=(), microphone=(), payment=(), usb=()',
	);
	if ( is_ssl() ) {
		$headers['Strict-Transport-Security'] = 'max-age=604800';
	}
	return apply_filters( 'roden_security_headers', $headers );
}

add_action( 'send_headers', function () {
	if ( headers_sent() ) {
		return;
	}
	foreach ( roden_security_headers() as $name => $value ) {
		header( $name . ': ' . $value );
	}
} );
