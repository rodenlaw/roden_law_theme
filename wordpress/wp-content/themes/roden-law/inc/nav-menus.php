<?php
/**
 * Navigation Menus
 *
 * Extracted from functions.php — registers theme nav menu locations.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'roden_register_nav_menus' );
function roden_register_nav_menus() {
    register_nav_menus( array(
        'primary' => __( 'Primary Navigation', 'roden-law' ),
        'footer'  => __( 'Footer Navigation', 'roden-law' ),
        'mobile'  => __( 'Mobile Navigation', 'roden-law' ),
    ) );
}

/**
 * Inject "Georgia" + "South Carolina" state-landing links into the Locations
 * sub-menu and re-parent each office under the appropriate state.
 *
 * Applies to menus assigned to the primary, mobile, or footer theme location.
 *
 * Resulting hierarchy:
 *
 *   Locations
 *   ├── Georgia                       → /locations/georgia/
 *   │   ├── Savannah, GA              → /locations/georgia/savannah/
 *   │   └── Darien, GA                → /locations/georgia/darien/
 *   └── South Carolina                → /locations/south-carolina/
 *       ├── Charleston, SC
 *       ├── North Charleston, SC
 *       ├── Columbia, SC
 *       └── Myrtle Beach, SC
 *
 * The state items live in memory only — no DB writes. Idempotent: bails if
 * a state-landing child is already present.
 *
 * The visual treatment of the third-level sub-menus (inline rendering, bold
 * state header, indented offices) is handled in style.css under the
 * .menu-item-state-landing class set on the synthetic items.
 */
add_filter( 'wp_get_nav_menu_items', 'roden_inject_state_landings_in_locations_submenu', 10, 3 );
function roden_inject_state_landings_in_locations_submenu( $items, $menu, $args ) {
    if ( empty( $items ) ) {
        return $items;
    }

    // Scope: only menus assigned to primary, mobile, or footer theme locations.
    $menu_locations = get_nav_menu_locations();
    $allowed_menu_ids = array_filter( array(
        $menu_locations['primary'] ?? 0,
        $menu_locations['mobile']  ?? 0,
        $menu_locations['footer']  ?? 0,
    ) );
    if ( ! in_array( (int) $menu->term_id, array_map( 'intval', $allowed_menu_ids ), true ) ) {
        return $items;
    }

    // Find a top-level Locations item — any item whose URL ends in /locations/
    // with no menu_item_parent. Tolerant of WP returning either ID or a string.
    $locations_parent_id = null;
    foreach ( $items as $item ) {
        $is_top_level = empty( $item->menu_item_parent ) || '0' === (string) $item->menu_item_parent;
        if ( ! $is_top_level ) {
            continue;
        }
        $url = isset( $item->url ) ? trailingslashit( $item->url ) : '';
        $path = wp_parse_url( $url, PHP_URL_PATH );
        if ( '/locations/' === $path ) {
            $locations_parent_id = (int) $item->ID;
            break;
        }
    }
    if ( ! $locations_parent_id ) {
        return $items;
    }

    $synth_id_ga = 9999991;
    $synth_id_sc = 9999992;

    // Idempotency: bail if a state-landing child is already present.
    foreach ( $items as $item ) {
        if ( (int) $item->menu_item_parent !== $locations_parent_id ) {
            continue;
        }
        $path = wp_parse_url( trailingslashit( $item->url ?? '' ), PHP_URL_PATH );
        if ( '/locations/georgia/' === $path || '/locations/south-carolina/' === $path ) {
            return $items;
        }
    }

    // Build synthetic menu items. IDs use a high range to avoid colliding with
    // real DB-backed items. type='custom' is the standard for hand-crafted links.
    //
    // menu_order MUST be unique across all items: WP's nav-menu walker uses it
    // as an array key (`$sorted[ $item->menu_order ] = $item`), so duplicates
    // collapse into a single slot. Mirroring the synthetic ID into menu_order
    // guarantees uniqueness; PHP arrays preserve insertion order, so inserting
    // these items immediately after the Locations parent renders them at the
    // top of its sub-menu.
    $build_item = function ( $id, $title, $url, $parent_id ) {
        return (object) array(
            'ID'                => $id,
            'db_id'             => $id,
            'menu_item_parent'  => (string) $parent_id,
            'object_id'         => (string) $id,
            'object'            => 'custom',
            'type'              => 'custom',
            'type_label'        => 'Custom Link',
            'url'               => $url,
            'title'             => $title,
            'target'            => '',
            'attr_title'        => '',
            'description'       => '',
            'classes'           => array( 'menu-item', 'menu-item-state-landing' ),
            'xfn'               => '',
            'menu_order'        => $id,
            'post_type'         => 'nav_menu_item',
            'post_status'       => 'publish',
        );
    };

    $ga = $build_item( $synth_id_ga, __( 'Georgia', 'roden-law' ), home_url( '/locations/georgia/' ), $locations_parent_id );
    $sc = $build_item( $synth_id_sc, __( 'South Carolina', 'roden-law' ), home_url( '/locations/south-carolina/' ), $locations_parent_id );

    // Re-parent each existing direct child of Locations under the appropriate
    // state synthetic item. The walker will then render offices nested inside
    // their state's sub-menu (third-level UL), which CSS renders inline.
    foreach ( $items as $item ) {
        if ( (int) $item->menu_item_parent !== $locations_parent_id ) {
            continue;
        }
        $path = wp_parse_url( trailingslashit( $item->url ?? '' ), PHP_URL_PATH );
        if ( null === $path ) {
            continue;
        }
        if ( 0 === strpos( $path, '/locations/georgia/' ) ) {
            $item->menu_item_parent = (string) $synth_id_ga;
        } elseif ( 0 === strpos( $path, '/locations/south-carolina/' ) ) {
            $item->menu_item_parent = (string) $synth_id_sc;
        }
    }

    // Insert the two state items immediately after the Locations parent so the
    // walker treats them as the first children in source order.
    $insert_at = null;
    foreach ( $items as $idx => $item ) {
        if ( (int) $item->ID === $locations_parent_id ) {
            $insert_at = $idx + 1;
            break;
        }
    }
    if ( null === $insert_at ) {
        return array_merge( $items, array( $ga, $sc ) );
    }
    array_splice( $items, $insert_at, 0, array( $ga, $sc ) );
    return $items;
}

/**
 * Inject "Resources" link into the primary/mobile nav.
 *
 * Appends after the last </li> in the menu (end of top-level items).
 * If "Blog" is found, inserts after it. Otherwise appends to the end
 * of the menu before the Contact item.
 */
add_filter( 'wp_nav_menu_items', 'roden_inject_resources_nav_link', 10, 2 );
function roden_inject_resources_nav_link( $items, $args ) {
    if ( 'primary' !== $args->theme_location && 'mobile' !== $args->theme_location ) {
        return $items;
    }

    // Don't add if already present.
    if ( false !== strpos( $items, '/resources/' ) ) {
        return $items;
    }

    $resources_link = '<li class="menu-item"><a href="' . esc_url( home_url( '/resources/' ) ) . '">Resources</a></li>';

    // Try to insert after a Blog link (any format).
    $blog_pattern = '/(<li[^>]*>\\s*<a[^>]*>[^<]*Blog[^<]*<\/a>\\s*<\/li>)/i';
    if ( preg_match( $blog_pattern, $items ) ) {
        $items = preg_replace( $blog_pattern, '$1' . "\n" . $resources_link, $items, 1 );
        return $items;
    }

    // Fallback: insert before the Contact menu item.
    $contact_pattern = '/(<li[^>]*>\\s*<a[^>]*>[^<]*Contact[^<]*<\/a>)/i';
    if ( preg_match( $contact_pattern, $items ) ) {
        $items = preg_replace( $contact_pattern, $resources_link . "\n" . '$1', $items, 1 );
        return $items;
    }

    // Last resort: append to end.
    $items .= "\n" . $resources_link;

    return $items;
}
