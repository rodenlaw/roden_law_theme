<?php
/**
 * Corrects a false statement of South Carolina law: that the state has no
 * statutory cap on punitive damages.
 *
 * S.C. Code § 15-32-530(A) caps punitive damages at the greater of three times
 * compensatory damages or $500,000. Subsection (B) lets the court raise that to
 * four times compensatory or $2,000,000 for conduct motivated by unreasonable
 * financial gain, or that could constitute a felony. Subsection (C) removes the
 * cap entirely in three cases only: intent to harm the claimant, a felony
 * conviction arising from the same conduct, or acting under the influence of
 * alcohol or drugs to a degree that substantially impaired judgment.
 * Read against scstatehouse.gov/code/t15c032.php on 2026-09-03.
 *
 * The false sentence is boilerplate: "South Carolina has no statutory cap but
 * requires clear and convincing evidence" appears verbatim on three pages, in
 * three different surfaces — a takeaway, a body, and an FAQ answer. The site's
 * own /golf-cart-accident-lawyers/golf-cart-dui/ states the rule correctly, so
 * the replacement wording follows that page rather than inventing a new form.
 *
 * Everything else the sweep flagged was correct and is untouched: South Carolina
 * genuinely caps neither economic nor (outside medical malpractice) non-economic
 * compensatory damages, and the § 15-32-530(C) exceptions are stated accurately
 * wherever they appear.
 *
 * Run:  ssh $H "wp --path=... eval-file -" < bin/fix-sc-punitive-cap-claim.php
 *       (append ` apply` to write; default is a dry run)
 */

$APPLY = ( isset( $args[0] ) && 'apply' === $args[0] );

/** Replace inside every string leaf of a nested array, leaving structure intact. */
function roden_deep_replace( $v, $old, $new ) {
	if ( is_string( $v ) ) {
		return str_replace( $old, $new, $v );
	}
	if ( is_array( $v ) ) {
		foreach ( $v as $k => $vv ) {
			$v[ $k ] = roden_deep_replace( $vv, $old, $new );
		}
	}
	return $v;
}

// id => surface => [ old, new ]. Exact substrings, asserted to appear once.
$edits = array(
	1663 => array(
		'_roden_key_takeaways' => array(
			'South Carolina has no statutory cap but requires clear and convincing evidence.',
			'South Carolina caps them at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530) on clear and convincing evidence, a cap lifted where the defendant was intoxicated.',
		),
	),
	4154 => array(
		'post_content' => array(
			'South Carolina has no statutory cap but requires clear and convincing evidence.',
			'South Carolina caps punitive damages at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530), on clear and convincing evidence.',
		),
	),
	4144 => array(
		// Stored as a JSON string that escapes the section sign. Keep that
		// convention: a raw § would be valid JSON but would make the field
		// inconsistent with every other citation in it.
		'_roden_faqs' => array(
			'South Carolina has no statutory cap but requires clear and convincing evidence of reckless conduct.',
			'South Carolina caps punitive damages at the greater of three times compensatory damages or $500,000 (S.C. Code § 15-32-530), on clear and convincing evidence; that cap is removed where the operator was under the influence.',
		),
	),
	1681 => array(
		// A comparison-table cell that contradicted itself: it asserted no cap
		// and then stated the cap.
		'post_content' => array(
			'<td>Generally no statutory cap; greater of $500K or 3x compensatory</td>',
			'<td>Greater of 3x compensatory damages or $500,000 (S.C. Code § 15-32-530)</td>',
		),
	),
);

$backup = array();
$ok = true;

foreach ( $edits as $id => $surfaces ) {
	$post = get_post( $id );
	if ( ! $post ) {
		echo "MISSING post $id\n";
		$ok = false;
		continue;
	}

	foreach ( $surfaces as $surface => $pair ) {
		list( $old, $new ) = $pair;

		if ( 'post_content' === $surface ) {
			$current = $post->post_content;
		} elseif ( 'post_excerpt' === $surface ) {
			$current = $post->post_excerpt;
		} else {
			$current = get_post_meta( $id, $surface, true );
		}

		// _roden_faqs is a JSON string on some posts and a real array on others.
		// Casting the array to a string yields "Array", the match fails, and the
		// surface silently reports nothing to fix.
		$is_array = is_array( $current );
		$haystack = $is_array
			? json_encode( $current, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
			: (string) $current;

		$hits = substr_count( $haystack, $old );
		if ( 1 !== $hits ) {
			echo "REFUSE $id/$surface — expected 1 occurrence, found $hits (" . ( $is_array ? 'array' : 'string' ) . ")\n";
			$ok = false;
			continue;
		}
		if ( false !== strpos( $haystack, $new ) ) {
			echo "SKIP $id/$surface — replacement already present\n";
			continue;
		}

		if ( $is_array ) {
			$updated = roden_deep_replace( $current, $old, $new );
			$check   = json_encode( $updated, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
			if ( false !== strpos( $check, $old ) || false === strpos( $check, $new ) ) {
				echo "REFUSE $id/$surface — array replacement did not take\n";
				$ok = false;
				continue;
			}
			$current = $haystack; // what the backup records
		} else {
			$updated = str_replace( $old, $new, $haystack );
			$current = $haystack;
		}
		$backup[] = array( 'id' => $id, 'surface' => $surface, 'before' => $current );

		echo ( $APPLY ? 'APPLY  ' : 'DRYRUN ' ) . "$id/$surface\n";
		echo "   -  $old\n";
		echo "   +  $new\n";

		if ( ! $APPLY ) {
			continue;
		}

		if ( 'post_content' === $surface || 'post_excerpt' === $surface ) {
			$res = wp_update_post( array( 'ID' => $id, $surface => $updated ), true );
			if ( is_wp_error( $res ) ) {
				echo "   ERROR " . $res->get_error_message() . "\n";
				$ok = false;
			}
		} else {
			update_post_meta( $id, $surface, $updated );
		}
	}
}

if ( $APPLY ) {
	// Verify by re-reading, never by trusting the write.
	echo "\n--- verify ---\n";
	foreach ( $edits as $id => $surfaces ) {
		foreach ( $surfaces as $surface => $pair ) {
			$post = get_post( $id );
			if ( 'post_content' === $surface ) {
				$now = $post->post_content;
			} elseif ( 'post_excerpt' === $surface ) {
				$now = $post->post_excerpt;
			} else {
				$now = get_post_meta( $id, $surface, true );
				$now = is_array( $now )
					? json_encode( $now, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
					: (string) $now;
			}
			$gone    = false === strpos( $now, $pair[0] );
			$present = false !== strpos( $now, $pair[1] );
			printf( "%s %d/%s  old_gone=%s new_present=%s\n",
				( $gone && $present ) ? 'OK  ' : 'FAIL', $id, $surface,
				$gone ? 'yes' : 'NO', $present ? 'yes' : 'NO' );
			if ( ! $gone || ! $present ) {
				$ok = false;
			}
		}
	}
}

echo "\n" . json_encode( array( 'applied' => $APPLY, 'edits' => count( $backup ), 'ok' => $ok ) ) . "\n";

if ( ! $APPLY ) {
	echo "\n--- backup payload (save before applying) ---\n";
	$j = json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
	echo ( false === $j ) ? ( 'ENCODE FAILED: ' . json_last_error_msg() ) : $j;
	echo "\n";
}
