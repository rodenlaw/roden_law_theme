<?php
/**
 * Spanish (ES) Seeder Library — shared helpers for the inc/es/seed-es-batch-*.php
 * family. No multilingual plugin: uses the bespoke locale layer in inc/i18n.php.
 *
 * Run batches via WP-CLI include-driver (WP Engine kills large eval-files):
 *   echo "include get_template_directory() . '/inc/es/seed-es-batch-01-core-pages.php';" | wp eval-file -
 *
 * All posts are created as DRAFTS. Publish after review, by ID:
 *   wp post list --post_status=draft --meta_key=_roden_locale --meta_value=es --format=ids
 *   wp post update <ids…> --post_status=publish && wp rewrite flush
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Language-neutral meta keys copied verbatim from the EN post. Everything
 * content-ish is intentionally NOT copied — untranslated sections must simply
 * not render rather than leak English onto /es/ pages.
 */
function roden_es_seed_neutral_meta_keys() {
    return array(
        '_roden_office_key',
        '_roden_pa_office_key',
        '_roden_jurisdiction',
        '_roden_author_attorney',
        '_roden_map_embed',
    );
}

/**
 * Create (or skip) the Spanish translation of an EN post.
 *
 * @param int   $en_id EN post ID.
 * @param array $data  {
 *     @type string $title     Required. Spanish title.
 *     @type string $content   Spanish body HTML.
 *     @type string $excerpt   Spanish excerpt.
 *     @type string $slug      Override slug. Default: 'es-' + EN slug for CPTs,
 *                             EN slug for pages/children (parent differs).
 *     @type int    $parent    ES parent post ID (pages / child CPTs). Default 0.
 *     @type array  $meta      Translated meta values, set verbatim
 *                             (e.g. _roden_meta_description, _roden_hero_intro,
 *                             _roden_why_hire, _roden_faqs, _roden_sol_ga…).
 * }
 * @return int|false ES post ID, or false on failure/skip.
 */
function roden_es_seed_translation( $en_id, array $data ) {
    $en_post = get_post( $en_id );
    if ( ! $en_post ) {
        WP_CLI::warning( "EN post {$en_id} not found — skipping." );
        return false;
    }

    // Idempotent: skip when a linked ES translation already exists.
    $existing = (int) get_post_meta( $en_post->ID, '_roden_translation_es', true );
    if ( $existing && get_post( $existing ) ) {
        WP_CLI::log( "  SKIP «{$en_post->post_title}» — ES exists (ID {$existing})" );
        return $existing;
    }

    if ( empty( $data['title'] ) ) {
        WP_CLI::warning( "  No Spanish title supplied for «{$en_post->post_title}» — skipping." );
        return false;
    }

    $is_page = ( 'page' === $en_post->post_type );
    $slug    = $data['slug'] ?? ( $is_page || ! empty( $data['parent'] )
        ? $en_post->post_name
        : 'es-' . $en_post->post_name );

    // Slug collision guard: drafts keep an explicit post_name verbatim, but WP
    // re-runs wp_unique_post_slug() at PUBLISH time and would silently suffix
    // a colliding slug (es → es-2), breaking the /es/ URL mirror. Catch the
    // collision now instead. (Same type + same parent = collision.)
    $collision = get_posts( array(
        'post_type'   => $en_post->post_type,
        'name'        => $slug,
        'post_parent' => (int) ( $data['parent'] ?? 0 ),
        'post_status' => array( 'publish', 'draft', 'pending', 'future', 'private' ),
        'numberposts' => 1,
        'fields'      => 'ids',
    ) );
    if ( $collision ) {
        WP_CLI::warning( "  ABORTED «{$data['title']}»: slug '{$slug}' already used by post {$collision[0]} (same type/parent). Free it and re-run." );
        return false;
    }

    $es_id = wp_insert_post( array(
        'post_title'   => $data['title'],
        'post_name'    => $slug,
        'post_content' => $data['content'] ?? '',
        'post_excerpt' => $data['excerpt'] ?? '',
        'post_status'  => 'draft',
        'post_type'    => $en_post->post_type,
        'post_parent'  => (int) ( $data['parent'] ?? 0 ),
        'menu_order'   => $en_post->menu_order,
    ), true );

    if ( is_wp_error( $es_id ) ) {
        WP_CLI::warning( '  FAILED: ' . $es_id->get_error_message() );
        return false;
    }

    // Locale + translation linkage (both directions).
    update_post_meta( $es_id, '_roden_locale', 'es' );
    update_post_meta( $es_id, '_roden_translation_of', $en_post->ID );
    update_post_meta( $en_post->ID, '_roden_translation_es', $es_id );

    // Neutral meta copied from EN.
    foreach ( roden_es_seed_neutral_meta_keys() as $key ) {
        $val = get_post_meta( $en_post->ID, $key, true );
        if ( '' !== $val && null !== $val ) {
            update_post_meta( $es_id, $key, $val );
        }
    }

    // Translated meta set verbatim.
    foreach ( ( $data['meta'] ?? array() ) as $key => $val ) {
        update_post_meta( $es_id, $key, $val );
    }

    // Statute-of-limitations fields: auto-derive from EN unless supplied.
    // Only the time words are translated — the statute citation stays EXACT
    // (e.g. "2 years (O.C.G.A. § 9-3-33)" → "2 años (O.C.G.A. § 9-3-33)").
    foreach ( array( '_roden_sol_ga', '_roden_sol_sc' ) as $sol_key ) {
        if ( isset( $data['meta'][ $sol_key ] ) ) {
            continue;
        }
        $sol_en = get_post_meta( $en_post->ID, $sol_key, true );
        if ( $sol_en ) {
            $sol_es = str_replace(
                array( ' years', ' year', ' days', ' day', ' from the date of injury', ' from the date of death' ),
                array( ' años', ' año', ' días', ' día', ' desde la fecha de la lesión', ' desde la fecha del fallecimiento' ),
                $sol_en
            );
            update_post_meta( $es_id, $sol_key, $sol_es );
        }
    }

    // Featured image + taxonomies mirror the EN post.
    $thumb = get_post_thumbnail_id( $en_post->ID );
    if ( $thumb ) {
        set_post_thumbnail( $es_id, $thumb );
    }
    foreach ( array( 'practice_category', 'location_served' ) as $tax ) {
        if ( taxonomy_exists( $tax ) ) {
            $terms = wp_get_object_terms( $en_post->ID, $tax, array( 'fields' => 'ids' ) );
            if ( ! is_wp_error( $terms ) && $terms ) {
                wp_set_object_terms( $es_id, $terms, $tax );
            }
        }
    }

    WP_CLI::success( "  Created ES draft «{$data['title']}» (ID {$es_id}, slug {$slug})" );
    return $es_id;
}

/**
 * Find an EN location post by its _roden_office_key.
 *
 * @param string $office_key Office key (savannah, charleston, …).
 * @return WP_Post|null
 */
function roden_es_seed_find_location( $office_key ) {
    $q = new WP_Query( array(
        'post_type'      => 'location',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'meta_query'     => array(
            array( 'key' => '_roden_office_key', 'value' => $office_key ),
            array(
                'relation' => 'OR',
                array( 'key' => '_roden_locale', 'compare' => 'NOT EXISTS' ),
                array( 'key' => '_roden_locale', 'value' => 'es', 'compare' => '!=' ),
            ),
        ),
    ) );
    $post = $q->have_posts() ? $q->posts[0] : null;
    wp_reset_postdata();

    // Fallback: find by slug. North Charleston exists as a firm-data office
    // but its EN location post was built as a neighborhood page (no
    // _roden_office_key meta) — match it by post_name instead.
    if ( ! $post ) {
        $by_slug = get_posts( array(
            'post_type'   => 'location',
            'name'        => $office_key,
            'post_status' => 'publish',
            'numberposts' => 1,
        ) );
        if ( $by_slug && 'es' !== get_post_meta( $by_slug[0]->ID, '_roden_locale', true ) ) {
            $post = $by_slug[0];
        }
    }

    return $post;
}

/**
 * Find an EN practice_area pillar by slug.
 *
 * @param string $slug Pillar slug (car-accident-lawyers, …).
 * @return WP_Post|null
 */
function roden_es_seed_find_pillar( $slug ) {
    $type = post_type_exists( 'practice_area' ) ? 'practice_area' : 'practice-area';
    return get_page_by_path( $slug, OBJECT, $type );
}

/**
 * Find an EN intersection page: child of the EN pillar whose slug is the
 * office city-state slug (e.g. car-accident-lawyers + charleston-sc).
 *
 * @param string $pillar_slug EN pillar slug.
 * @param string $office_slug Office city-state slug (charleston-sc, …).
 * @return WP_Post|null
 */
function roden_es_seed_find_intersection( $pillar_slug, $office_slug ) {
    $en_pillar = roden_es_seed_find_pillar( $pillar_slug );
    if ( ! $en_pillar ) {
        return null;
    }
    $q = get_posts( array(
        'post_type'   => $en_pillar->post_type,
        'name'        => $office_slug,
        'post_parent' => $en_pillar->ID,
        'post_status' => 'publish',
        'numberposts' => 1,
    ) );
    return $q ? $q[0] : null;
}

/**
 * ES pillar post ID for a given EN pillar slug (via the translation link).
 * ES intersections are parented to this.
 *
 * @param string $pillar_slug EN pillar slug.
 * @return int ES pillar ID, or 0 if the pillar has no ES translation yet.
 */
function roden_es_seed_es_pillar_id( $pillar_slug ) {
    $en = roden_es_seed_find_pillar( $pillar_slug );
    return $en ? (int) get_post_meta( $en->ID, '_roden_translation_es', true ) : 0;
}

/**
 * Find (or report missing) the ES root page ('es'), parent of all ES pages.
 *
 * @return int Page ID or 0.
 */
function roden_es_seed_root_page_id() {
    $page = get_page_by_path( 'es' );
    if ( ! $page ) {
        // Drafts are not returned by get_page_by_path — query directly.
        $q = get_posts( array(
            'post_type'   => 'page',
            'name'        => 'es',
            'post_status' => array( 'publish', 'draft' ),
            'post_parent' => 0,
            'numberposts' => 1,
        ) );
        $page = $q ? $q[0] : null;
    }
    return $page ? (int) $page->ID : 0;
}
