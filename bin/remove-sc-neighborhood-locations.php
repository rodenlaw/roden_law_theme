<?php
/**
 * Phase 1 batch (a) — retire the neighbourhood and subdivision location pages.
 *
 * SEO pre-emption plan rule 3: every location page below city level. 88 pages,
 * 19 at tier 3 (districts of an office city) and 69 at tier 4 (neighbourhoods
 * and subdivisions). This is the layer the audit named as the primary doorway
 * liability.
 *
 * Unlike batches (b) and (d) these were NOT orphans: 23 blog posts carried 53
 * contextual links into them. Run bin/relink-batch-a-locations.php first — it
 * repoints those at the parent city hub. The guard below refuses to trash any
 * page something still links to, so running out of order fails loudly.
 *
 * ORDER MATTERS. The 301s in inc/legacy-redirects.php must be LIVE before this
 * runs, or these URLs 404 in the gap. They are path-keyed so they fire whether
 * or not the post exists — deploy first, then run this.
 *
 * Posts are TRASHED, not force-deleted. Full JSON backup to STDOUT, status to
 * STDERR. The database is not in this repo and has no undo.
 *
 *   Dry run (default):
 *     ssh $H "wp --path=$P eval-file -" < bin/remove-sc-neighborhood-locations.php \
 *       > backup-batch-a.json
 *
 *   Apply:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/remove-sc-neighborhood-locations.php \
 *       > backup-batch-a.json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

/* ID => public path. One map, never two parallel arrays. */
$expect = array(
    3765 => '/locations/south-carolina/charleston/west-ashley/',
    3769 => '/locations/south-carolina/charleston/daniel-island/',
    3775 => '/locations/south-carolina/charleston/downtown-charleston/',
    3795 => '/locations/georgia/savannah/southside-savannah/',
    3796 => '/locations/georgia/savannah/midtown-savannah/',
    3801 => '/locations/georgia/savannah/downtown-savannah/',
    3809 => '/locations/georgia/savannah/westside-savannah/',
    3812 => '/locations/georgia/savannah/eastside-savannah/',
    3852 => '/locations/south-carolina/columbia/northeast-columbia/',
    4254 => '/locations/south-carolina/north-charleston/park-circle/',
    4255 => '/locations/south-carolina/north-charleston/olde-north-charleston/',
    4256 => '/locations/south-carolina/north-charleston/dorchester-terrace-waylyn/',
    4257 => '/locations/south-carolina/north-charleston/liberty-hill/',
    4258 => '/locations/south-carolina/north-charleston/ferndale/',
    4259 => '/locations/south-carolina/north-charleston/oak-terrace-preserve/',
    4260 => '/locations/south-carolina/north-charleston/charleston-heights/',
    4261 => '/locations/south-carolina/north-charleston/chicora-cherokee/',
    4262 => '/locations/south-carolina/north-charleston/wescott-plantation/',
    4263 => '/locations/south-carolina/north-charleston/northwoods/',
    4264 => '/locations/south-carolina/charleston/mount-pleasant/old-village/',
    4265 => '/locations/south-carolina/charleston/mount-pleasant/ion/',
    4266 => '/locations/south-carolina/charleston/mount-pleasant/park-west/',
    4267 => '/locations/south-carolina/charleston/mount-pleasant/belle-hall/',
    4268 => '/locations/south-carolina/charleston/mount-pleasant/carolina-park/',
    4269 => '/locations/south-carolina/charleston/mount-pleasant/dunes-west/',
    4270 => '/locations/south-carolina/charleston/mount-pleasant/shem-creek/',
    4271 => '/locations/south-carolina/charleston/mount-pleasant/snee-farm/',
    4272 => '/locations/south-carolina/charleston/mount-pleasant/rivertowne/',
    4274 => '/locations/south-carolina/charleston/downtown-charleston/south-of-broad/',
    4275 => '/locations/south-carolina/charleston/downtown-charleston/french-quarter/',
    4276 => '/locations/south-carolina/charleston/downtown-charleston/king-street-district/',
    4277 => '/locations/south-carolina/charleston/downtown-charleston/harleston-village/',
    4278 => '/locations/south-carolina/charleston/downtown-charleston/ansonborough/',
    4279 => '/locations/south-carolina/charleston/downtown-charleston/cannonborough-elliotborough/',
    4280 => '/locations/south-carolina/charleston/downtown-charleston/the-crosstown/',
    4281 => '/locations/south-carolina/charleston/downtown-charleston/wagener-terrace/',
    4282 => '/locations/south-carolina/north-charleston/goose-creek/crowfield-plantation/',
    4283 => '/locations/south-carolina/north-charleston/goose-creek/liberty-hall-plantation/',
    4284 => '/locations/south-carolina/north-charleston/goose-creek/carnes-crossroads/',
    4285 => '/locations/south-carolina/north-charleston/goose-creek/boulder-bluff/',
    4286 => '/locations/south-carolina/north-charleston/goose-creek/howe-hall/',
    4287 => '/locations/south-carolina/north-charleston/goose-creek/devon-forest/',
    4288 => '/locations/south-carolina/north-charleston/goose-creek/brickhope-plantation/',
    4289 => '/locations/south-carolina/north-charleston/goose-creek/westchester/',
    4290 => '/locations/south-carolina/charleston/west-ashley/avondale/',
    4291 => '/locations/south-carolina/charleston/west-ashley/citadel-mall-area/',
    4292 => '/locations/south-carolina/charleston/west-ashley/shadowmoss/',
    4293 => '/locations/south-carolina/charleston/west-ashley/west-ashley-park/',
    4294 => '/locations/south-carolina/charleston/west-ashley/byrnes-downs/',
    4295 => '/locations/south-carolina/charleston/west-ashley/ashley-river-road/',
    4296 => '/locations/south-carolina/charleston/west-ashley/south-windermere/',
    4297 => '/locations/south-carolina/charleston/west-ashley/grand-oaks-plantation/',
    4298 => '/locations/south-carolina/north-charleston/summerville/historic-district/',
    4299 => '/locations/south-carolina/north-charleston/summerville/cane-bay/',
    4300 => '/locations/south-carolina/north-charleston/summerville/nexton/',
    4301 => '/locations/south-carolina/north-charleston/summerville/knightsville/',
    4302 => '/locations/south-carolina/north-charleston/summerville/sangaree/',
    4303 => '/locations/south-carolina/north-charleston/summerville/summers-corner/',
    4304 => '/locations/south-carolina/north-charleston/summerville/wescott/',
    4305 => '/locations/south-carolina/north-charleston/summerville/pine-forest-inn/',
    4306 => '/locations/south-carolina/myrtle-beach/myrtle-beach/market-common/',
    4307 => '/locations/south-carolina/myrtle-beach/myrtle-beach/grande-dunes/',
    4308 => '/locations/south-carolina/myrtle-beach/myrtle-beach/golden-mile/',
    4309 => '/locations/south-carolina/myrtle-beach/conway/historic-district/',
    4310 => '/locations/south-carolina/myrtle-beach/north-myrtle-beach/barefoot-landing/',
    4311 => '/locations/south-carolina/myrtle-beach/carolina-forest/the-farm/',
    4312 => '/locations/south-carolina/myrtle-beach/socastee/socastee-village/',
    4313 => '/locations/south-carolina/myrtle-beach/surfside-beach/town-center/',
    4314 => '/locations/south-carolina/myrtle-beach/georgetown/historic-district/',
    4315 => '/locations/south-carolina/myrtle-beach/little-river/waterfront/',
    4316 => '/locations/south-carolina/myrtle-beach/murrells-inlet/marshwalk/',
    4317 => '/locations/south-carolina/myrtle-beach/garden-city-beach/pier-area/',
    4318 => '/locations/georgia/savannah/pooler/godley-station/',
    4319 => '/locations/georgia/savannah/pooler/west-pooler/',
    4320 => '/locations/georgia/savannah/southside-savannah/georgetown-savannah/',
    4321 => '/locations/georgia/savannah/southside-savannah/savannah-quarters/',
    4322 => '/locations/georgia/savannah/downtown-savannah/historic-district/',
    4323 => '/locations/georgia/savannah/downtown-savannah/river-street/',
    4324 => '/locations/georgia/savannah/midtown-savannah/ardsley-park-chatham-crescent/',
    4325 => '/locations/georgia/savannah/richmond-hill/city-center/',
    4326 => '/locations/georgia/savannah/hinesville/fort-stewart-area/',
    4327 => '/locations/georgia/savannah/rincon/town-center/',
    4328 => '/locations/georgia/savannah/wilmington-island/town-center/',
    4329 => '/locations/georgia/savannah/port-wentworth/town-center/',
    4330 => '/locations/georgia/savannah/statesboro/georgia-southern/',
    4331 => '/locations/georgia/savannah/effingham-county/south-effingham/',
    4334 => '/locations/georgia/savannah/effingham-county/marlow/',
    4335 => '/locations/georgia/savannah/effingham-county/egypt/',
);

/* City-tier pages that must never be touched by a rule-3 batch. */
$office_cities = array( 'savannah', 'darien', 'charleston', 'north-charleston', 'columbia', 'myrtle-beach' );

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — Phase 1 batch (a)\n\n", $apply ? 'APPLY' : 'DRY RUN' );

global $wpdb;
$found = array();

foreach ( $expect as $id => $path ) {
    $p = get_post( $id );

    if ( ! $p instanceof WP_Post ) {
        fprintf( $err, "ABORT: ID %d not found.\n", $id );
        exit( 1 );
    }
    if ( 'location' !== $p->post_type ) {
        fprintf( $err, "ABORT: ID %d is post_type '%s', expected 'location'.\n", $id, $p->post_type );
        exit( 1 );
    }
    if ( 'publish' !== $p->post_status ) {
        fprintf( $err, "ABORT: ID %d is '%s', not published — already actioned?\n", $id, $p->post_status );
        exit( 1 );
    }

    $actual = trailingslashit( (string) wp_parse_url( get_permalink( $p ), PHP_URL_PATH ) );
    if ( $actual !== trailingslashit( $path ) ) {
        fprintf( $err, "ABORT: ID %d is at %s, expected %s.\n", $id, $actual, $path );
        exit( 1 );
    }

    /*
     * Guard: must be BELOW city level. Segments after 'locations' are
     * state/city/suburb/neighbourhood, so a rule-3 page has at least 3.
     * This is what stops the batch ever reaching a city hub.
     */
    $segs = array_values( array_filter( explode( '/', trim( $actual, '/' ) ), 'strlen' ) );
    if ( 'locations' !== $segs[0] || count( $segs ) - 1 < 3 ) {
        fprintf( $err, "ABORT: %s is not below city level.\n", $actual );
        exit( 1 );
    }
    if ( in_array( $segs[ count( $segs ) - 1 ], $office_cities, true ) ) {
        fprintf( $err, "ABORT: %s ends in an office-city slug.\n", $actual );
        exit( 1 );
    }

    /* Guard: refuse if anything still links here. */
    $like = '%' . $wpdb->esc_like( $actual ) . '%';
    $refs = (int) $wpdb->get_var( $wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status='publish' AND ID <> %d AND post_content LIKE %s",
        $id, $like
    ) );
    if ( $refs > 0 ) {
        fprintf( $err, "ABORT: %d published posts still link to %s — run bin/relink-batch-a-locations.php first.\n", $refs, $actual );
        exit( 1 );
    }

    $found[] = $p;
}

if ( count( $found ) !== count( $expect ) ) {
    fprintf( $err, "ABORT: resolved %d of %d.\n", count( $found ), count( $expect ) );
    exit( 1 );
}

/* ---- Backup before touching anything ---- */

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'phase1-a-neighborhood-locations',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'Restore with wp_untrash_post( ID ), or recreate from post + meta below.',
    'posts'     => array(),
);
foreach ( $found as $p ) {
    $backup['posts'][] = array(
        'ID'            => (int) $p->ID,
        'post_title'    => $p->post_title,
        'post_name'     => $p->post_name,
        'post_type'     => $p->post_type,
        'post_status'   => $p->post_status,
        'post_parent'   => (int) $p->post_parent,
        'post_date_gmt' => $p->post_date_gmt,
        'permalink'     => get_permalink( $p ),
        'post_content'  => $p->post_content,
        'post_excerpt'  => $p->post_excerpt,
        'meta'          => get_post_meta( $p->ID ),
    );
}
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

/* ---- Act ---- */

$done = 0;
foreach ( $found as $p ) {
    $path = (string) wp_parse_url( get_permalink( $p ), PHP_URL_PATH );
    if ( ! $apply ) {
        fprintf( $err, "  would trash  %-5d %s\n", $p->ID, $path );
        continue;
    }
    if ( wp_trash_post( $p->ID ) ) {
        $done++;
        fprintf( $err, "  trashed      %-5d %s\n", $p->ID, $path );
    } else {
        fprintf( $err, "  FAILED       %-5d %s\n", $p->ID, $path );
    }
}

fprintf( $err, "\n%s: %d of %d\n", $apply ? 'Trashed' : 'Would trash', $apply ? $done : count( $found ), count( $found ) );
