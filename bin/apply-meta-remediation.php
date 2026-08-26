<?php
/**
 * Apply corrections to post meta on published pages — FAQ entries or plain
 * string fields.
 *
 * WHY THIS EXISTS SEPARATELY FROM apply-stat-remediation.php.
 *
 * That script patches `post_content`. It cannot see FAQ answers, because those
 * live in post meta — and on 2026-08-25 that gap let a corrected claim survive
 * on a page that had just been fixed. The body of /steps-after-work-injury/ was
 * corrected, the DB sweep of post_content came back clean, and the false
 * deadline was still on the live page: it was also in `_roden_faqs`, which the
 * sweep never looked at.
 *
 * FAQ answers are worse than body copy to get wrong, because inc/ renders them
 * into FAQPage structured data. A false statement there is not just published,
 * it is handed to search engines as a machine-readable answer.
 *
 * THE RULE THIS ENCODES: when a claim is corrected in a body, sweep the meta for
 * the same claim CLASS — not for the same string. The FAQ almost always words it
 * differently, which is exactly why a string sweep misses it.
 *
 * WHY IT IS NO LONGER FAQ-ONLY. Renamed from apply-faq-remediation.php one day
 * after it was written, on finding a THIRD surface. Sweeping the FAQ meta for
 * previously-removed statistics reported zero survivals — and the live pages
 * still showed them. They were in `_roden_key_takeaways`, the box rendered
 * above the article, which is post meta, is not in post_content, and was not in
 * content/meta.json's export whitelist. The sweep read the field, got nothing
 * back because it was never exported, and reported a clean pass.
 *
 * A sweep that cannot see a field does not report "unknown". It reports zero.
 * Check that a field is actually present in whatever you are sweeping before
 * believing a null result.
 *
 * Patch format (JSON), one entry per field to change. Omit `key` for FAQs:
 *
 *   { "batch": "...",
 *     "edits": [ { "ID": 1698, "slug": "...", "index": 1,
 *                  "before": "<exact current answer>",
 *                  "after":  "<replacement>",
 *                  "kind": "reversed-requirement",
 *                  "note": "why it was wrong" },
 *                { "ID": 4654, "slug": "...", "key": "_roden_key_takeaways",
 *                  "before": "<exact current value>",
 *                  "after":  "<replacement>",
 *                  "kind": "unverifiable-statistic",
 *                  "note": "..." } ] }
 *
 * For `_roden_faqs`, `index` is advisory — the match is made on the exact
 * `before` text, so a reordered array cannot cause the wrong answer to be
 * overwritten. For a plain string field the whole value must match exactly. If
 * the text has changed since the patch was written, the run aborts rather than
 * clobbering someone else's edit.
 *
 *   ssh $H "wp --path=$P eval-file - <patch.json>"        # dry run
 *   ssh $H "wp --path=$P eval-file - <patch.json> apply"  # apply
 *
 * Sets `_roden_last_refreshed` and leaves `post_modified` alone, for the reasons
 * documented in apply-stat-remediation.php.
 */

$path  = isset( $args[0] ) ? (string) $args[0] : '';
$apply = isset( $args[1] ) && 'apply' === $args[1];
$err   = fopen( 'php://stderr', 'w' );

if ( '' === $path || ! file_exists( $path ) ) {
    fprintf( $err, "Usage: eval-file - <patch.json> [apply]\n" );
    exit( 1 );
}
$patch = json_decode( (string) file_get_contents( $path ), true );
if ( ! is_array( $patch ) || empty( $patch['edits'] ) ) {
    fprintf( $err, "ABORT: %s is not a readable FAQ patch.\n", $path );
    exit( 1 );
}

fprintf( $err, "%s — %d edit(s), %s\n\n", $apply ? 'APPLY' : 'DRY RUN',
    count( $patch['edits'] ), $patch['batch'] );

global $wpdb;

/* ---- Resolve and verify every edit before writing any of them ---- */
$ready = array();
foreach ( $patch['edits'] as $e ) {
    $id   = (int) $e['ID'];
    $post = get_post( $id );

    if ( ! $post instanceof WP_Post ) {
        fprintf( $err, "ABORT: post %d not found.\n", $id );
        exit( 1 );
    }
    if ( 'publish' !== $post->post_status ) {
        fprintf( $err, "ABORT: post %d is '%s' — this patch was built against the live page.\n", $id, $post->post_status );
        exit( 1 );
    }

    $key = isset( $e['key'] ) ? (string) $e['key'] : '_roden_faqs';

    if ( '_roden_faqs' === $key ) {
        $faqs = get_post_meta( $id, '_roden_faqs', true );
        if ( ! is_array( $faqs ) ) {
            fprintf( $err, "ABORT: post %d has no _roden_faqs array.\n", $id );
            exit( 1 );
        }

        $hit = null;
        foreach ( $faqs as $i => $q ) {
            if ( isset( $q['answer'] ) && $q['answer'] === $e['before'] ) { $hit = $i; break; }
        }
        if ( null === $hit ) {
            foreach ( $faqs as $q ) {
                if ( isset( $q['answer'] ) && $q['answer'] === $e['after'] ) {
                    fprintf( $err, "  skip  %-5d %s (already applied)\n", $id, $e['slug'] );
                    continue 2;
                }
            }
            fprintf( $err, "ABORT: post %d (%s) — no FAQ answer matches the expected text.\n", $id, $e['slug'] );
            fprintf( $err, "       It has been edited since the patch was written. Regenerate it.\n" );
            exit( 1 );
        }

        $ready[] = array( 'id' => $id, 'key' => $key, 'faqs' => $faqs, 'index' => $hit, 'edit' => $e );
        continue;
    }

    // post_excerpt is a posts-table column, not meta, but it belongs here: it is
    // prose, it is not post_content, and roden_schema_article() renders it as
    // the Article `description`. Two pages kept a false superlative there after
    // their bodies, FAQs and takeaways had all been corrected.
    if ( 'post_excerpt' === $key ) {
        $cur = (string) $post->post_excerpt;
        if ( $cur === $e['after'] ) {
            fprintf( $err, "  skip  %-5d %s (already applied)\n", $id, $e['slug'] );
            continue;
        }
        if ( $cur !== $e['before'] ) {
            fprintf( $err, "ABORT: post %d (%s) post_excerpt does not match the expected text.\n", $id, $e['slug'] );
            exit( 1 );
        }
        $ready[] = array( 'id' => $id, 'key' => $key, 'index' => null, 'edit' => $e );
        continue;
    }

    // Plain string meta field.
    $cur = get_post_meta( $id, $key, true );
    if ( ! is_string( $cur ) ) {
        fprintf( $err, "ABORT: post %d meta %s is not a string.\n", $id, $key );
        exit( 1 );
    }
    if ( $cur === $e['after'] ) {
        fprintf( $err, "  skip  %-5d %s (already applied)\n", $id, $e['slug'] );
        continue;
    }
    if ( $cur !== $e['before'] ) {
        fprintf( $err, "ABORT: post %d (%s) meta %s does not match the expected text.\n", $id, $e['slug'], $key );
        fprintf( $err, "       It has been edited since the patch was written. Regenerate it.\n" );
        exit( 1 );
    }

    $ready[] = array( 'id' => $id, 'key' => $key, 'index' => null, 'edit' => $e );
}

if ( ! $ready ) { fprintf( $err, "\nNothing to do.\n" ); exit( 0 ); }

/* ---- Act ---- */
$today = current_time( 'Y-m-d' );
$done  = 0;
foreach ( $ready as $r ) {
    $e     = $r['edit'];
    $isfaq = '_roden_faqs' === $r['key'];
    fprintf( $err, "  %-5s %-5d %-42s  %-22s  [%s]\n",
        $apply ? 'edit' : 'would', $r['id'], substr( $e['slug'], 0, 42 ),
        $isfaq ? sprintf( 'FAQ #%d', $r['index'] ) : $r['key'], $e['kind'] );
    fprintf( $err, "          %s\n", $e['note'] );

    if ( ! $apply ) { continue; }

    if ( $isfaq ) {
        $faqs = $r['faqs'];
        $faqs[ $r['index'] ]['answer'] = $e['after'];
        update_post_meta( $r['id'], '_roden_faqs', $faqs );
    } elseif ( 'post_excerpt' === $r['key'] ) {
        // Direct column update, not wp_update_post(): the same reasoning as every
        // content edit in this project — post_modified must not be stamped.
        $wpdb->update( $wpdb->posts, array( 'post_excerpt' => $e['after'] ),
            array( 'ID' => $r['id'] ), array( '%s' ), array( '%d' ) );
    } else {
        update_post_meta( $r['id'], $r['key'], $e['after'] );
    }
    update_post_meta( $r['id'], '_roden_last_refreshed', $today );
    clean_post_cache( $r['id'] );

    if ( $isfaq ) {
        $back = get_post_meta( $r['id'], '_roden_faqs', true );
        $ok   = is_array( $back ) && isset( $back[ $r['index'] ]['answer'] )
                && $back[ $r['index'] ]['answer'] === $e['after'];
    } elseif ( 'post_excerpt' === $r['key'] ) {
        $ok = $wpdb->get_var( $wpdb->prepare(
            "SELECT post_excerpt FROM {$wpdb->posts} WHERE ID = %d", $r['id'] ) ) === $e['after'];
    } else {
        $ok = get_post_meta( $r['id'], $r['key'], true ) === $e['after'];
    }
    if ( ! $ok ) {
        fprintf( $err, "        FAILED read-back on %d — stopping.\n", $r['id'] );
        exit( 1 );
    }
    $done++;
}

fprintf( $err, "\n%s: %d meta field(s)\n", $apply ? 'Edited' : 'Would edit', $apply ? $done : count( $ready ) );
if ( $apply ) {
    fprintf( $err, "_roden_last_refreshed set to %s. post_modified untouched.\n", $today );
    fprintf( $err, "Next: flush both caches, then check the RENDERED page — FAQ meta also feeds FAQPage schema.\n" );
}
