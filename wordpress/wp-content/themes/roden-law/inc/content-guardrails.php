<?php
/**
 * Content guardrails — enforce the page types the SEO plan forbids.
 *
 * SEO-PREEMPTION-PLAN-rodenlaw.md §2 says "No new location, neighborhood, road,
 * or permutation pages for the duration of this project, no exceptions", and
 * STEINBERG-MODEL-PLAN-rodenlaw.md §2 makes the sub-city ban permanent. Until now
 * nothing enforced either. Between them, batches (a), (b), (d) and the 66 dead
 * location pages removed 196 URLs of exactly these types, and every one of them
 * could be recreated by a single Publish click.
 *
 * This is the enforcement layer. It is deliberately in code rather than in a
 * document, because the documents already said it and the pages were created
 * anyway — eight of them are sitting in the CMS as drafts right now, three
 * duplicating their own parent office city.
 *
 * TWO RULES, WITH DIFFERENT LIFETIMES. That distinction is the whole design:
 *
 *   1. Sub-city pages are banned PERMANENTLY. A location post more than one level
 *      below a state hub is a neighbourhood, subdivision or district. Those cannot
 *      be edited into legitimacy — their existence is the problem. Not overridable
 *      by the freeze constant, because lifting a freeze should never quietly lift
 *      a permanent ban too.
 *
 *   2. New city-tier location pages are FROZEN, not banned. The plan allows them
 *      with "a partner-approved business case (new office or documented
 *      caseload)". That is a real future case, so it gets a documented switch
 *      rather than a hard block: define RODEN_LOCATION_FREEZE false in wp-config,
 *      publish, and set it back.
 *
 * A third check catches a bug rather than a policy breach: a location post whose
 * slug equals its parent's produces /locations/georgia/darien/darien/, a duplicate
 * of a guardrail-protected office hub. Three such drafts exist today.
 *
 * ---------------------------------------------------------------------------
 * SECOND POST TYPE, ADDED 2026-08-31: practice_area city permutations.
 *
 * The rules above only ever tested `'location' !== $data['post_type']`, so the
 * OTHER half of the doorway layer was never fenced. Phase 1 of the preemption
 * plan removed city x practice permutations under rules 5 and 7, and
 * KNOWLEDGE-BASE-PLAN-rodenlaw.md sec.10 flagged the hole: nothing stopped
 * /{practice}-lawyers/{city}-{st}/ being published again the next morning.
 *
 * A permutation is identified by its slug, not its depth: all 175 surviving
 * intersections end in one of the six office-city suffixes (charleston-sc,
 * north-charleston-sc, columbia-sc, myrtle-beach-sc, savannah-ga, darien-ga)
 * and none of the 230 sub-type pages does. Verified against content/meta.json
 * on 2026-08-31: 175 matches, zero false positives.
 *
 * The same two-lifetime split applies, for the same reason:
 *
 *   1. A permutation for a city with NO office is refused outright. That is
 *      Phase 1 rule 7's class -- the pages that were 301'd to the statewide
 *      practice page. Opening a seventh office is a code change to
 *      roden_office_city_slugs(), which is a reviewed act, not a checkbox.
 *
 *   2. A permutation for an office city is FROZEN behind RODEN_LOCATION_FREEZE,
 *      the same constant the location tier uses. Both gates answer one question
 *      -- "are we opening new geography?" -- so they lift together rather than
 *      making an editor discover a second constant halfway through.
 *
 * Nothing here touches already-published posts. It gates the transition to
 * 'publish', so the 43 surviving city-tier pages, the six office hubs and all
 * 175 intersections stay editable -- which Track A of the knowledge-base plan
 * depends on, because it rewrites those 175 in place.
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Is the location freeze in force?
 *
 * Default true. Lift it by defining RODEN_LOCATION_FREEZE false in wp-config.php
 * — deliberately not a wp-admin setting, so lifting it is a recorded act rather
 * than a checkbox someone clicks without reading this file.
 *
 * @return bool
 */
function roden_location_freeze_active() {
    $frozen = defined( 'RODEN_LOCATION_FREEZE' ) ? (bool) RODEN_LOCATION_FREEZE : true;

    /**
     * Filter the location-page freeze.
     *
     * @param bool $frozen Whether new city-tier location pages are frozen.
     */
    return (bool) apply_filters( 'roden_location_freeze_active', $frozen );
}

/**
 * Depth of a location post below the /locations/ root.
 *
 * 1 = state hub (georgia), 2 = office/city tier (savannah), 3+ = below city.
 * Counted from post_parent rather than the permalink, because a draft has no
 * usable permalink — which is exactly when this needs to work.
 *
 * @param WP_Post $post Location post.
 * @return int
 */
function roden_location_tier( $post ) {
    $tier = 1;
    $seen = array( (int) $post->ID => true );
    $pid  = (int) $post->post_parent;

    while ( $pid && ! isset( $seen[ $pid ] ) ) {
        $seen[ $pid ] = true;
        $parent = get_post( $pid );
        if ( ! $parent instanceof WP_Post ) {
            break;
        }
        $tier++;
        $pid = (int) $parent->post_parent;
    }

    return $tier;
}

/**
 * Refuse to publish a location page the plan forbids.
 *
 * Hooked to wp_insert_post_data so it can demote the status before the row is
 * written — returning early from a save action would leave the post published.
 * The post is kept as a draft rather than discarded: the copy may be wanted later
 * under a business case, and silently deleting an editor's work is its own bug.
 *
 * @param array $data    Sanitised post data about to be written.
 * @param array $postarr Raw post data.
 * @return array
 */
function roden_guard_location_publish( $data, $postarr ) {
    if ( empty( $data['post_type'] ) || 'location' !== $data['post_type'] ) {
        return $data;
    }
    if ( empty( $data['post_status'] ) || 'publish' !== $data['post_status'] ) {
        return $data;
    }

    $id = isset( $postarr['ID'] ) ? (int) $postarr['ID'] : 0;

    // Already published: an edit to a surviving page, not a new one. Leave it.
    if ( $id && 'publish' === get_post_status( $id ) ) {
        return $data;
    }

    $probe = (object) array(
        'ID'          => $id,
        'post_parent' => isset( $data['post_parent'] ) ? (int) $data['post_parent'] : 0,
    );
    $tier = roden_location_tier( $probe );

    $reason = '';
    $parent = $probe->post_parent ? get_post( $probe->post_parent ) : null;

    /*
     * Order matters. The duplicate-slug case is a BUG, not a policy breach, so it
     * is checked before either policy rule — otherwise the freeze would swallow it
     * and report "frozen" for a page that is also broken, and the real problem
     * would only surface later when someone lifted the freeze.
     */
    if ( $parent instanceof WP_Post && ! empty( $data['post_name'] ) && $parent->post_name === $data['post_name'] ) {
        $reason = __( 'This page has the same slug as its parent, which would publish a duplicate of an office-city hub at a nested URL. Rename it or reparent it. Kept as a draft.', 'roden-law' );
    } elseif ( $tier >= 3 ) {
        $reason = sprintf(
            /* translators: %d: nesting depth below the /locations/ root. */
            __( 'Sub-city location pages are banned permanently (this one is %d levels deep). Neighbourhoods, subdivisions and districts are the page type the SEO recovery removed 88 of; they cannot be edited into legitimacy. Kept as a draft.', 'roden-law' ),
            $tier
        );
    } elseif ( roden_location_freeze_active() ) {
        $reason = __( 'New location pages are frozen for the duration of the SEO recovery. The plan allows one with a partner-approved business case — a new office or documented caseload. To publish it, define RODEN_LOCATION_FREEZE false in wp-config.php, publish, and set it back. Kept as a draft.', 'roden-law' );
    }

    if ( '' === $reason ) {
        return $data;
    }

    $data['post_status'] = 'draft';
    set_transient( 'roden_guard_notice_' . get_current_user_id(), $reason, 60 );

    return $data;
}
add_filter( 'wp_insert_post_data', 'roden_guard_location_publish', 10, 2 );

/**
 * The six office-city slugs a practice_area permutation may legitimately use.
 *
 * Deliberately a function rather than a constant so opening a seventh office is
 * a diff someone reviews. Every one of the 175 surviving intersections uses one
 * of these; no sub-type page does.
 *
 * @return string[] Lower-case slugs.
 */
function roden_office_city_slugs() {
    $slugs = array(
        'charleston-sc',
        'north-charleston-sc',
        'columbia-sc',
        'myrtle-beach-sc',
        'savannah-ga',
        'darien-ga',
    );

    /**
     * Filter the office-city slug list.
     *
     * @param string[] $slugs Office-city slugs.
     */
    return (array) apply_filters( 'roden_office_city_slugs', $slugs );
}

/**
 * Is this practice_area slug a city permutation, and if so which city?
 *
 * Matches the trailing state suffix rather than a list of city names, so a new
 * non-office city (beaufort-sc, pooler-ga) is caught as a permutation and then
 * refused by the caller -- rather than sailing through because it is unknown.
 *
 * @param string $slug Post slug.
 * @return string City slug, or '' if this is not a permutation.
 */
function roden_practice_city_slug( $slug ) {
    $slug = strtolower( (string) $slug );

    return preg_match( '/-(ga|sc)$/', $slug ) ? $slug : '';
}

/**
 * Refuse to publish a city x practice permutation the plan forbids.
 *
 * Sibling of roden_guard_location_publish() rather than a branch inside it: the
 * two post types have different identifying logic (parent depth vs. slug suffix)
 * and merging them would obscure both. They share only the notice transient.
 *
 * @param array $data    Sanitised post data about to be written.
 * @param array $postarr Raw post data.
 * @return array
 */
function roden_guard_practice_permutation_publish( $data, $postarr ) {
    if ( empty( $data['post_type'] ) || 'practice_area' !== $data['post_type'] ) {
        return $data;
    }
    if ( empty( $data['post_status'] ) || 'publish' !== $data['post_status'] ) {
        return $data;
    }

    $id = isset( $postarr['ID'] ) ? (int) $postarr['ID'] : 0;

    /*
     * Already published: this is an edit to one of the 175 survivors, not a new
     * permutation. Track A rewrites every one of them in place, so this branch
     * is load-bearing rather than defensive.
     */
    if ( $id && 'publish' === get_post_status( $id ) ) {
        return $data;
    }

    $city = roden_practice_city_slug( isset( $data['post_name'] ) ? $data['post_name'] : '' );

    // Not a permutation -- a pillar or a sub-type. Sub-types are not fenced.
    if ( '' === $city ) {
        return $data;
    }

    if ( ! in_array( $city, roden_office_city_slugs(), true ) ) {
        $reason = sprintf(
            /* translators: %s: city slug, e.g. beaufort-sc. */
            __( 'City-and-practice pages are only defensible in the six office markets, and "%s" is not one of them. This is the page type Phase 1 rule 7 redirected to the statewide practice page. Point the content at the statewide page instead, or add the city to roden_office_city_slugs() if an office has opened. Kept as a draft.', 'roden-law' ),
            $city
        );
    } elseif ( roden_location_freeze_active() ) {
        $reason = sprintf(
            /* translators: %s: city slug, e.g. charleston-sc. */
            __( 'New city-and-practice permutations are frozen for the duration of the SEO recovery, including in office markets like "%s". The 175 that survived the cull stay editable; new ones do not get created. To publish anyway, define RODEN_LOCATION_FREEZE false in wp-config.php, publish, and set it back. Kept as a draft.', 'roden-law' ),
            $city
        );
    } else {
        return $data;
    }

    $data['post_status'] = 'draft';
    set_transient( 'roden_guard_notice_' . get_current_user_id(), $reason, 60 );

    return $data;
}
add_filter( 'wp_insert_post_data', 'roden_guard_practice_permutation_publish', 10, 2 );

/**
 * Surface the refusal in wp-admin.
 *
 * Without this the post simply stays a draft with no explanation, which reads as
 * a bug rather than a policy.
 */
function roden_guard_admin_notice() {
    $key    = 'roden_guard_notice_' . get_current_user_id();
    $reason = get_transient( $key );
    if ( ! $reason ) {
        return;
    }
    delete_transient( $key );
    printf(
        '<div class="notice notice-error"><p><strong>%s</strong> %s</p></div>',
        esc_html__( 'Not published —', 'roden-law' ),
        esc_html( $reason )
    );
}
add_action( 'admin_notices', 'roden_guard_admin_notice' );
