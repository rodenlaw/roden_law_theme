<?php
/**
 * Retire the 129 zero-click office-city intersections and the 60 zero-click
 * sub-municipal blog posts. Evidence: docs/gsc-evidence-2026-09-18.md.
 * Owner-approved 2026-09-18.
 *
 * Paths and targets come from roden_zero_click_intersection_urls() and
 * roden_zero_click_blog_urls() in inc/legacy-redirects.php, so the redirect map
 * and the removal set cannot drift. The ID => [type, path] pairing IS declared
 * here, because get_post( $id ) is the only way to be certain which row is about
 * to be trashed. Two post types this time, so the type is checked per entry.
 *
 * ORDER MATTERS. The 301s must be LIVE before this runs, or these URLs 404 in
 * the gap. Posts are TRASHED, not deleted: wp post untrash <ID> restores any.
 *
 *   Dry run (default) — reports inbound links; nothing is changed:
 *     ssh $H "wp --path=$P eval-file -" < bin/remove-zero-click-pages.php \
 *       > docs/backups/zero-click-pages-$(date +%Y-%m-%d).json
 *
 *   Apply — refuses while any published post outside the batch still links here:
 *     ssh $H "wp --path=$P eval-file - apply" < bin/remove-zero-click-pages.php \
 *       > docs/backups/zero-click-pages-$(date +%Y-%m-%d).json
 */

$apply = isset( $args[0] ) && 'apply' === $args[0];

/* ID => [post_type, public path]. Source: wp post list on prod, 2026-09-18. */
$expect = array(
    3437 => array( 'post', '/blog/your-guide-to-documenting-a-james-island-parkway-car-accident/' ),
    3490 => array( 'post', '/blog/what-to-do-after-a-truck-accident-on-i-526-in-charleston/' ),
    3495 => array( 'post', '/blog/your-guide-to-rideshare-accidents-in-downtown-charleston/' ),
    3528 => array( 'post', '/blog/your-step-by-step-guide-after-a-downtown-columbia-truck-accident/' ),
    3626 => array( 'practice_area', '/car-accident-lawyers/myrtle-beach-sc/' ),
    3628 => array( 'practice_area', '/truck-accident-lawyers/darien-ga/' ),
    3629 => array( 'practice_area', '/truck-accident-lawyers/charleston-sc/' ),
    3631 => array( 'practice_area', '/truck-accident-lawyers/myrtle-beach-sc/' ),
    3633 => array( 'practice_area', '/slip-and-fall-lawyers/darien-ga/' ),
    3634 => array( 'practice_area', '/slip-and-fall-lawyers/charleston-sc/' ),
    3636 => array( 'practice_area', '/slip-and-fall-lawyers/myrtle-beach-sc/' ),
    3637 => array( 'practice_area', '/motorcycle-accident-lawyers/savannah-ga/' ),
    3638 => array( 'practice_area', '/motorcycle-accident-lawyers/darien-ga/' ),
    3639 => array( 'practice_area', '/motorcycle-accident-lawyers/charleston-sc/' ),
    3641 => array( 'practice_area', '/motorcycle-accident-lawyers/myrtle-beach-sc/' ),
    3647 => array( 'practice_area', '/wrongful-death-lawyers/savannah-ga/' ),
    3649 => array( 'practice_area', '/wrongful-death-lawyers/charleston-sc/' ),
    3653 => array( 'practice_area', '/workers-compensation-lawyers/darien-ga/' ),
    3655 => array( 'practice_area', '/workers-compensation-lawyers/columbia-sc/' ),
    3658 => array( 'practice_area', '/dog-bite-lawyers/darien-ga/' ),
    3662 => array( 'practice_area', '/brain-injury-lawyers/savannah-ga/' ),
    3663 => array( 'practice_area', '/brain-injury-lawyers/darien-ga/' ),
    3664 => array( 'practice_area', '/brain-injury-lawyers/charleston-sc/' ),
    3665 => array( 'practice_area', '/brain-injury-lawyers/columbia-sc/' ),
    3666 => array( 'practice_area', '/brain-injury-lawyers/myrtle-beach-sc/' ),
    3667 => array( 'practice_area', '/spinal-cord-injury-lawyers/savannah-ga/' ),
    3668 => array( 'practice_area', '/spinal-cord-injury-lawyers/darien-ga/' ),
    3669 => array( 'practice_area', '/spinal-cord-injury-lawyers/charleston-sc/' ),
    3670 => array( 'practice_area', '/spinal-cord-injury-lawyers/columbia-sc/' ),
    3674 => array( 'practice_area', '/maritime-injury-lawyers/charleston-sc/' ),
    3675 => array( 'practice_area', '/maritime-injury-lawyers/columbia-sc/' ),
    3677 => array( 'practice_area', '/product-liability-lawyers/savannah-ga/' ),
    3678 => array( 'practice_area', '/product-liability-lawyers/darien-ga/' ),
    3681 => array( 'practice_area', '/product-liability-lawyers/myrtle-beach-sc/' ),
    3682 => array( 'practice_area', '/boating-accident-lawyers/savannah-ga/' ),
    3683 => array( 'practice_area', '/boating-accident-lawyers/darien-ga/' ),
    3684 => array( 'practice_area', '/boating-accident-lawyers/charleston-sc/' ),
    3686 => array( 'practice_area', '/boating-accident-lawyers/myrtle-beach-sc/' ),
    3687 => array( 'practice_area', '/burn-injury-lawyers/savannah-ga/' ),
    3688 => array( 'practice_area', '/burn-injury-lawyers/darien-ga/' ),
    3691 => array( 'practice_area', '/burn-injury-lawyers/myrtle-beach-sc/' ),
    3692 => array( 'practice_area', '/construction-accident-lawyers/savannah-ga/' ),
    3693 => array( 'practice_area', '/construction-accident-lawyers/darien-ga/' ),
    3694 => array( 'practice_area', '/construction-accident-lawyers/charleston-sc/' ),
    3695 => array( 'practice_area', '/construction-accident-lawyers/columbia-sc/' ),
    3696 => array( 'practice_area', '/construction-accident-lawyers/myrtle-beach-sc/' ),
    3698 => array( 'practice_area', '/nursing-home-abuse-lawyers/darien-ga/' ),
    3699 => array( 'practice_area', '/nursing-home-abuse-lawyers/charleston-sc/' ),
    3700 => array( 'practice_area', '/nursing-home-abuse-lawyers/columbia-sc/' ),
    3704 => array( 'practice_area', '/premises-liability-lawyers/charleston-sc/' ),
    3705 => array( 'practice_area', '/premises-liability-lawyers/columbia-sc/' ),
    3707 => array( 'practice_area', '/pedestrian-accident-lawyers/savannah-ga/' ),
    3708 => array( 'practice_area', '/pedestrian-accident-lawyers/darien-ga/' ),
    3709 => array( 'practice_area', '/pedestrian-accident-lawyers/charleston-sc/' ),
    3711 => array( 'practice_area', '/pedestrian-accident-lawyers/myrtle-beach-sc/' ),
    4232 => array( 'practice_area', '/bicycle-accident-lawyers/savannah-ga/' ),
    4234 => array( 'practice_area', '/bicycle-accident-lawyers/charleston-sc/' ),
    4235 => array( 'practice_area', '/bicycle-accident-lawyers/columbia-sc/' ),
    4236 => array( 'practice_area', '/bicycle-accident-lawyers/myrtle-beach-sc/' ),
    4237 => array( 'practice_area', '/electric-scooter-accident-lawyers/savannah-ga/' ),
    4238 => array( 'practice_area', '/electric-scooter-accident-lawyers/darien-ga/' ),
    4239 => array( 'practice_area', '/electric-scooter-accident-lawyers/charleston-sc/' ),
    4240 => array( 'practice_area', '/electric-scooter-accident-lawyers/columbia-sc/' ),
    4242 => array( 'practice_area', '/atv-side-by-side-accident-lawyers/savannah-ga/' ),
    4243 => array( 'practice_area', '/atv-side-by-side-accident-lawyers/darien-ga/' ),
    4244 => array( 'practice_area', '/atv-side-by-side-accident-lawyers/charleston-sc/' ),
    4245 => array( 'practice_area', '/atv-side-by-side-accident-lawyers/columbia-sc/' ),
    4246 => array( 'practice_area', '/atv-side-by-side-accident-lawyers/myrtle-beach-sc/' ),
    4247 => array( 'practice_area', '/golf-cart-accident-lawyers/savannah-ga/' ),
    4248 => array( 'practice_area', '/golf-cart-accident-lawyers/darien-ga/' ),
    4249 => array( 'practice_area', '/golf-cart-accident-lawyers/charleston-sc/' ),
    4250 => array( 'practice_area', '/golf-cart-accident-lawyers/columbia-sc/' ),
    4365 => array( 'post', '/blog/goose-creek-car-accidents-military-traffic-us-52/' ),
    4540 => array( 'practice_area', '/car-accident-lawyers/north-charleston-sc/' ),
    4541 => array( 'practice_area', '/truck-accident-lawyers/north-charleston-sc/' ),
    4542 => array( 'practice_area', '/slip-and-fall-lawyers/north-charleston-sc/' ),
    4543 => array( 'practice_area', '/motorcycle-accident-lawyers/north-charleston-sc/' ),
    4544 => array( 'practice_area', '/medical-malpractice-lawyers/north-charleston-sc/' ),
    4545 => array( 'practice_area', '/wrongful-death-lawyers/north-charleston-sc/' ),
    4546 => array( 'practice_area', '/workers-compensation-lawyers/north-charleston-sc/' ),
    4547 => array( 'practice_area', '/dog-bite-lawyers/north-charleston-sc/' ),
    4548 => array( 'practice_area', '/brain-injury-lawyers/north-charleston-sc/' ),
    4549 => array( 'practice_area', '/spinal-cord-injury-lawyers/north-charleston-sc/' ),
    4550 => array( 'practice_area', '/maritime-injury-lawyers/north-charleston-sc/' ),
    4551 => array( 'practice_area', '/product-liability-lawyers/north-charleston-sc/' ),
    4552 => array( 'practice_area', '/boating-accident-lawyers/north-charleston-sc/' ),
    4553 => array( 'practice_area', '/burn-injury-lawyers/north-charleston-sc/' ),
    4554 => array( 'practice_area', '/construction-accident-lawyers/north-charleston-sc/' ),
    4555 => array( 'practice_area', '/nursing-home-abuse-lawyers/north-charleston-sc/' ),
    4556 => array( 'practice_area', '/premises-liability-lawyers/north-charleston-sc/' ),
    4557 => array( 'practice_area', '/pedestrian-accident-lawyers/north-charleston-sc/' ),
    4558 => array( 'practice_area', '/bicycle-accident-lawyers/north-charleston-sc/' ),
    4559 => array( 'practice_area', '/electric-scooter-accident-lawyers/north-charleston-sc/' ),
    4560 => array( 'practice_area', '/atv-side-by-side-accident-lawyers/north-charleston-sc/' ),
    4561 => array( 'practice_area', '/golf-cart-accident-lawyers/north-charleston-sc/' ),
    4740 => array( 'post', '/blog/islands-expressway-whitemarsh-island-motorcycle-accident-chatham-county/' ),
    4746 => array( 'post', '/blog/brunswick-i-95-truck-accident-lawyer/' ),
    4752 => array( 'post', '/blog/broad-river-road-pedestrian-accident-lawyer-harbison-columbia/' ),
    4762 => array( 'post', '/blog/best-car-accident-lawyer-ashley-river-road-greenwood-park-west-ashley/' ),
    4764 => array( 'post', '/blog/sunset-boulevard-west-columbia-drunk-driver-accident-lawyer/' ),
    4772 => array( 'post', '/blog/west-ashley-sam-rittenberg-boulevard-motorcycle-accident-lawyer/' ),
    4776 => array( 'post', '/blog/five-points-columbia-uber-accident-lawyer/' ),
    4778 => array( 'post', '/blog/bucksport-marina-waccamaw-intracoastal-boating-accident-lawyer/' ),
    4781 => array( 'post', '/blog/garden-city-dean-forest-road-truck-accident-lawyer/' ),
    4783 => array( 'post', '/blog/darien-i-95-truck-accident-lawyer/' ),
    4785 => array( 'post', '/blog/mark-clark-expressway-i-526-18-wheeler-accident-lawyer-north-charleston/' ),
    4787 => array( 'post', '/blog/park-circle-east-montague-drunk-driving-accident-lawyer-north-charleston/' ),
    4789 => array( 'post', '/blog/edmund-highway-lexington-county-car-accident-lawyer/' ),
    4791 => array( 'post', '/blog/socastee-holmestown-road-underinsured-motorist-lawyer/' ),
    4793 => array( 'practice_area', '/personal-injury-lawyers/columbia-sc/' ),
    4794 => array( 'post', '/blog/southover-mills-b-lane-motorcycle-accident-lawyer/' ),
    4800 => array( 'post', '/blog/summerville-i-26-18-wheeler-accident-lawyer-dorchester-county/' ),
    4902 => array( 'practice_area', '/es/car-accident-lawyers/charleston-sc/' ),
    4903 => array( 'practice_area', '/es/truck-accident-lawyers/charleston-sc/' ),
    4904 => array( 'practice_area', '/es/workers-compensation-lawyers/charleston-sc/' ),
    4905 => array( 'practice_area', '/es/construction-accident-lawyers/charleston-sc/' ),
    4907 => array( 'practice_area', '/es/truck-accident-lawyers/north-charleston-sc/' ),
    4908 => array( 'practice_area', '/es/workers-compensation-lawyers/north-charleston-sc/' ),
    4909 => array( 'practice_area', '/es/construction-accident-lawyers/north-charleston-sc/' ),
    4910 => array( 'practice_area', '/es/car-accident-lawyers/columbia-sc/' ),
    4911 => array( 'practice_area', '/es/truck-accident-lawyers/columbia-sc/' ),
    4913 => array( 'practice_area', '/es/construction-accident-lawyers/columbia-sc/' ),
    4914 => array( 'practice_area', '/es/car-accident-lawyers/savannah-ga/' ),
    4915 => array( 'practice_area', '/es/truck-accident-lawyers/savannah-ga/' ),
    4917 => array( 'practice_area', '/es/construction-accident-lawyers/savannah-ga/' ),
    4918 => array( 'practice_area', '/es/car-accident-lawyers/myrtle-beach-sc/' ),
    4919 => array( 'practice_area', '/es/truck-accident-lawyers/myrtle-beach-sc/' ),
    4920 => array( 'practice_area', '/es/workers-compensation-lawyers/myrtle-beach-sc/' ),
    4921 => array( 'practice_area', '/es/construction-accident-lawyers/myrtle-beach-sc/' ),
    4946 => array( 'post', '/es/blog/southover-mills-b-lane-motorcycle-accident-lawyer/' ),
    4950 => array( 'post', '/es/blog/mount-pleasant-mark-clark-expressway-i-526-motorcycle-accident-lawyer/' ),
    4952 => array( 'post', '/es/blog/summerville-i-26-18-wheeler-accident-lawyer-dorchester-county/' ),
    4954 => array( 'post', '/es/blog/st-andrews-road-widewater-18-wheeler-accident-lawyer-richland-county/' ),
    4956 => array( 'post', '/es/blog/litchfield-pawleys-island-golf-cart-accident-lawyer-georgetown-county/' ),
    4960 => array( 'post', '/es/blog/garden-city-ga-21-augusta-road-car-accident-lawyer/' ),
    4962 => array( 'post', '/blog/brunswick-ocean-highway-us-17-underinsured-motorist-lawyer-glynn-county/' ),
    4964 => array( 'post', '/es/blog/brunswick-ocean-highway-us-17-underinsured-motorist-lawyer-glynn-county/' ),
    4966 => array( 'post', '/blog/i-20-bush-river-road-motorcycle-accident-lawyer-columbia/' ),
    4968 => array( 'post', '/es/blog/i-20-bush-river-road-motorcycle-accident-lawyer-columbia/' ),
    4970 => array( 'post', '/blog/dick-pond-road-sc-544-truck-accident-lawyer-surfside-beach/' ),
    4972 => array( 'post', '/es/blog/dick-pond-road-sc-544-truck-accident-lawyer-surfside-beach/' ),
    4974 => array( 'post', '/blog/chicora-cherokee-carner-avenue-us-52-car-accident-attorney-north-charleston/' ),
    4976 => array( 'post', '/es/blog/chicora-cherokee-carner-avenue-us-52-car-accident-attorney-north-charleston/' ),
    4980 => array( 'post', '/es/blog/mount-pleasant-johnnie-dodds-us-17-uninsured-motorist-lawyer/' ),
    5004 => array( 'post', '/es/blog/east-bay-street-savannah-pedestrian-accident-lawyer/' ),
    5007 => array( 'post', '/blog/st-simons-island-kings-way-motorcycle-accident-lawyer/' ),
    5010 => array( 'post', '/es/blog/st-simons-island-kings-way-motorcycle-accident-lawyer/' ),
    5013 => array( 'post', '/blog/car-accident-attorney-near-me-west-ashley-citadel-mall/' ),
    5016 => array( 'post', '/es/blog/car-accident-attorney-near-me-west-ashley-citadel-mall/' ),
    5019 => array( 'post', '/blog/rivers-avenue-northwoods-bus-accident-lawyer-north-charleston/' ),
    5022 => array( 'post', '/es/blog/rivers-avenue-northwoods-bus-accident-lawyer-north-charleston/' ),
    5028 => array( 'post', '/es/blog/cayce-12th-street-uninsured-motorist-lawyer/' ),
    5031 => array( 'post', '/blog/murrells-inlet-jet-ski-accident-lawyer/' ),
    5034 => array( 'post', '/es/blog/murrells-inlet-jet-ski-accident-lawyer/' ),
    5041 => array( 'post', '/blog/green-grove-dorchester-road-atv-accident-lawyer-north-charleston/' ),
    5043 => array( 'post', '/es/blog/green-grove-dorchester-road-atv-accident-lawyer-north-charleston/' ),
    5051 => array( 'practice_area', '/personal-injury-lawyers/myrtle-beach-sc/' ),
    5163 => array( 'post', '/blog/n-lake-drive-dick-pond-road-sc-544-underinsured-motorist-lawyer/' ),
    5165 => array( 'post', '/es/blog/n-lake-drive-dick-pond-road-sc-544-underinsured-motorist-lawyer/' ),
    5168 => array( 'practice_area', '/es/workers-compensation-lawyers/darien-ga/' ),
    5182 => array( 'practice_area', '/es/motorcycle-accident-lawyers/savannah-ga/' ),
    5183 => array( 'practice_area', '/es/motorcycle-accident-lawyers/darien-ga/' ),
    5184 => array( 'practice_area', '/es/motorcycle-accident-lawyers/charleston-sc/' ),
    5185 => array( 'practice_area', '/es/motorcycle-accident-lawyers/north-charleston-sc/' ),
    5186 => array( 'practice_area', '/es/motorcycle-accident-lawyers/columbia-sc/' ),
    5187 => array( 'practice_area', '/es/motorcycle-accident-lawyers/myrtle-beach-sc/' ),
    5188 => array( 'practice_area', '/es/bicycle-accident-lawyers/savannah-ga/' ),
    5189 => array( 'practice_area', '/es/bicycle-accident-lawyers/darien-ga/' ),
    5190 => array( 'practice_area', '/es/bicycle-accident-lawyers/charleston-sc/' ),
    5191 => array( 'practice_area', '/es/bicycle-accident-lawyers/north-charleston-sc/' ),
    5192 => array( 'practice_area', '/es/bicycle-accident-lawyers/columbia-sc/' ),
    5193 => array( 'practice_area', '/es/bicycle-accident-lawyers/myrtle-beach-sc/' ),
    5194 => array( 'practice_area', '/es/pedestrian-accident-lawyers/savannah-ga/' ),
    5195 => array( 'practice_area', '/es/pedestrian-accident-lawyers/darien-ga/' ),
    5196 => array( 'practice_area', '/es/pedestrian-accident-lawyers/charleston-sc/' ),
    5197 => array( 'practice_area', '/es/pedestrian-accident-lawyers/north-charleston-sc/' ),
    5198 => array( 'practice_area', '/es/pedestrian-accident-lawyers/columbia-sc/' ),
    5199 => array( 'practice_area', '/es/pedestrian-accident-lawyers/myrtle-beach-sc/' ),
    5212 => array( 'post', '/blog/green-grove-mark-clark-expressway-uninsured-motorist-lawyer-north-charleston/' ),
    5214 => array( 'post', '/es/blog/green-grove-mark-clark-expressway-uninsured-motorist-lawyer-north-charleston/' ),
    5216 => array( 'post', '/blog/tenmile-i-26-best-car-accident-lawyer-north-charleston/' ),
    5218 => array( 'post', '/es/blog/tenmile-i-26-best-car-accident-lawyer-north-charleston/' ),
    5231 => array( 'post', '/blog/golf-colony-south-reindeer-road-underinsured-motorist-lawyer/' ),
    5233 => array( 'post', '/es/blog/golf-colony-south-reindeer-road-underinsured-motorist-lawyer/' ),
    5235 => array( 'post', '/blog/kemira-plant-drive-savannah-fatal-truck-accident-lawyer/' ),
    5238 => array( 'post', '/es/blog/kemira-plant-drive-savannah-fatal-truck-accident-lawyer/' ),
    5341 => array( 'post', '/blog/wando-gardens-faber-place-drive-best-car-accident-lawyer-north-charleston/' ),
    5343 => array( 'post', '/es/blog/wando-gardens-faber-place-drive-best-car-accident-lawyer-north-charleston/' ),
    6010 => array( 'practice_area', '/personal-injury-lawyers/savannah-ga/' ),
);

$err = fopen( 'php://stderr', 'w' );
fprintf( $err, "%s — 129 intersections + 60 blog posts\n\n", $apply ? 'APPLY' : 'DRY RUN' );

foreach ( array( 'roden_zero_click_intersection_urls', 'roden_zero_click_blog_urls' ) as $fn ) {
    if ( ! function_exists( $fn ) ) {
        fprintf( $err, "ABORT: %s() is not defined — the redirect map has not deployed yet.\n", $fn );
        fprintf( $err, "       Merge and deploy the theme change first, or these URLs 404 in the gap.\n" );
        exit( 1 );
    }
}
$map = roden_zero_click_intersection_urls() + roden_zero_click_blog_urls();

/* The map and this script must describe exactly the same set. */
$paths       = array_map( function ( $e ) { return $e[1]; }, $expect );
$only_map    = array_diff( array_keys( $map ), $paths );
$only_script = array_diff( $paths, array_keys( $map ) );
if ( $only_map || $only_script ) {
    fprintf( $err, "ABORT: the redirect map and this script disagree.\n" );
    foreach ( $only_map as $p )    { fprintf( $err, "  in map, not here:    %s\n", $p ); }
    foreach ( $only_script as $p ) { fprintf( $err, "  here, not in map:    %s\n", $p ); }
    exit( 1 );
}

global $wpdb;
$found     = array();
$link_debt = array();
$retiring  = array_keys( $map );

foreach ( $expect as $id => $e ) {
    list( $type, $path ) = $e;
    $p = get_post( $id );

    if ( ! $p instanceof WP_Post ) {
        fprintf( $err, "ABORT: ID %d not found.\n", $id );
        exit( 1 );
    }
    if ( $type !== $p->post_type ) {
        fprintf( $err, "ABORT: ID %d is post_type '%s', expected '%s'.\n", $id, $p->post_type, $type );
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
    if ( in_array( $actual, array_values( $map ), true ) ) {
        fprintf( $err, "ABORT: %s is a redirect TARGET — that is a pillar.\n", $actual );
        exit( 1 );
    }

    /* Hierarchical guard: a practice_area with a published child would orphan it into a 404. */
    if ( is_post_type_hierarchical( $p->post_type ) ) {
        $kids = get_posts( array( 'post_type' => $p->post_type, 'post_parent' => $p->ID, 'post_status' => 'publish', 'fields' => 'ids', 'numberposts' => -1 ) );
        if ( $kids ) {
            fprintf( $err, "ABORT: %s still has %d published child page(s): %s\n", $actual, count( $kids ), implode( ', ', $kids ) );
            exit( 1 );
        }
    }

    /*
     * Inbound editorial links from published posts OUTSIDE this batch. Links from
     * pages the batch is itself retiring die with them. Reported on a dry run,
     * fatal on apply.
     */
    $like = '%' . $wpdb->esc_like( $actual ) . '%';
    $ids  = $wpdb->get_col( $wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_status='publish' AND post_type NOT IN ('revision') AND ID <> %d AND post_content LIKE %s",
        $id, $like
    ) );
    $ext = 0;
    foreach ( $ids as $lid ) {
        $lp = trailingslashit( (string) wp_parse_url( get_permalink( $lid ), PHP_URL_PATH ) );
        if ( in_array( $lp, $retiring, true ) ) {
            continue;
        }
        /*
         * The LIKE is a substring match, and an English path is a suffix of its
         * Spanish twin's: '/workers-compensation-lawyers/columbia-sc/' sits inside
         * '/es/workers-compensation-lawyers/columbia-sc/'. Only count a real href,
         * i.e. the path preceded by a quote or by the site's own host — the same
         * forms the relink script rewrites, so the two cannot disagree.
         */
        $c = (string) get_post_field( 'post_content', $lid );
        if ( false !== strpos( $c, '"' . $actual ) || false !== strpos( $c, "'" . $actual ) || false !== strpos( $c, untrailingslashit( home_url() ) . $actual ) ) {
            $ext++;
        }
    }
    if ( $ext > 0 ) {
        $link_debt[ $actual ] = $ext;
    }
    $found[] = $p;
}

if ( $link_debt ) {
    fprintf( $err, "\n%d of %d URLs still have inbound links in published post bodies outside this batch:\n", count( $link_debt ), count( $expect ) );
    foreach ( $link_debt as $path => $n ) {
        fprintf( $err, "    %2d post(s) -> %s\n", $n, $path );
    }
    fprintf( $err, "\n  Run bin/relink-zero-click-pages.php first.\n\n" );
    if ( $apply ) {
        fprintf( $err, "ABORT: refusing to trash pages that are still linked.\n" );
        exit( 1 );
    }
} else {
    fprintf( $err, "  No inbound editorial links outside the batch. Nothing to relink.\n\n" );
}

/* ---- Backup before touching anything ---- */

$backup = array(
    'generated' => gmdate( 'c' ),
    'batch'     => 'zero-click-pages',
    'mode'      => $apply ? 'apply' : 'dry-run',
    'note'      => 'Restore with wp post untrash <ID>.',
    'evidence'  => 'docs/gsc-evidence-2026-09-18.md — 129 intersections: 0 clicks / 232,293 impressions; 60 posts: 0 clicks / 6,526 impressions; 16 months to 2026-09-15',
    'link_debt' => $link_debt,
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
        'redirects_to'  => $map[ trailingslashit( (string) wp_parse_url( get_permalink( $p ), PHP_URL_PATH ) ) ],
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
        fprintf( $err, "  would trash  %-5d %-14s %s\n", $p->ID, $p->post_type, $path );
        continue;
    }
    if ( wp_trash_post( $p->ID ) ) {
        $done++;
        fprintf( $err, "  trashed      %-5d %-14s %s\n", $p->ID, $p->post_type, $path );
    } else {
        fprintf( $err, "  FAILED       %-5d %s\n", $p->ID, $path );
    }
}

fprintf( $err, "\n%s: %d of %d\n", $apply ? 'Trashed' : 'Would trash', $apply ? $done : count( $found ), count( $found ) );
if ( $apply ) {
    fprintf( $err, "Backup captured on STDOUT. Restore any post with: wp post untrash <ID>\n" );
    fprintf( $err, "Next: flush both caches, verify 189/189 single-hop (flat AND nested), regenerate content/meta.json.\n" );
}
