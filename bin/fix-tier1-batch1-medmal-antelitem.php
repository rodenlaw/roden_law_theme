<?php
/**
 * Tier-1 batch 1 of the 2026-08-26 legal accuracy audit:
 * the two errors that cost a client money or a claim.
 *
 * §1.1 — THREE pages told South Carolina readers there is no cap on
 * medical-malpractice non-economic damages. S.C. Code § 15-32-220 imposes one:
 * a base of $350,000 against a single provider and $1,050,000 where more than
 * one is liable, adjusted annually for CPI and published in the State Register.
 * On two of the three the two states' cells were SWAPPED — Georgia's struck-down
 * cap was reported as South Carolina's live one and vice versa. One page cited a
 * "SC Supreme Court struck down caps in 2012" decision THAT DOES NOT EXIST; it is
 * a garbled import of Georgia's Atlanta Oculoplastic Surgery v. Nestlehutt (2010).
 *
 * §1.4 — SIX pages gave a Georgia MUNICIPAL ante litem deadline of 12 months.
 * O.C.G.A. § 36-33-5 gives SIX. This is the dangerous direction: the notice period
 * is itself a statute of limitations, so a reader who relies on it is barred.
 * Correct: city 6 months (§ 36-33-5) · county 12 months (§ 36-11-1) ·
 * State of Georgia 12 months (§ 50-21-26).
 *
 * NO CURRENT INDEXED FIGURE IS PUBLISHED. § 15-32-220 is CPI-adjusted and the
 * 2026 number is not yet confirmed against the Revenue and Fiscal Affairs Office.
 * Every replacement below states the statutory base, says plainly that it is
 * adjusted annually, and tells the reader the applicable limit is higher — which
 * is true whatever the current figure turns out to be. Writing an unconfirmed
 * number would swap one false precision for another.
 *
 * ONE BONUS FIX. Post 1692's deadline table said Georgia workers' comp runs
 * "1 year from last benefit or 2 years from injury". § 34-9-82 has the triggers
 * the other way round: one year from injury; one year from the last
 * employer-furnished remedial treatment; two years from the last payment of
 * weekly benefits. There is no two-years-from-injury rule. Corrected here rather
 * than left standing on a page being edited anyway.
 *
 * THREE DIFFERENT ENCODINGS OF "§" appear across these pages — a literal §,
 * &#167;, and &sect;. Every FROM string below was taken verbatim from the live
 * database, and each must match EXACTLY ONCE or that edit is skipped and
 * reported. Nothing is guessed at.
 *
 * str_replace only — never preg_replace. Several replacements contain "$350,000"
 * and "$1.05", and PHP reads "$3" and "$1" in a preg_replace replacement as
 * backreferences (the bug that wrote ",000 and 0,000" onto a live page 2026-08-03).
 *
 * post_modified is NOT stamped (direct $wpdb->update). _roden_last_refreshed IS
 * set: these pages were corrected, and no attorney has re-reviewed them, so the
 * visible "Updated" line is the honest signal and _roden_last_reviewed stays
 * untouched — it licenses schema lastReviewed/reviewedBy and must never be
 * written by a script.
 *
 *   ssh rodenlawprod "wp --path=$P eval-file -"       < bin/fix-tier1-batch1-medmal-antelitem.php
 *   ssh rodenlawprod "wp --path=$P eval-file - apply" < bin/fix-tier1-batch1-medmal-antelitem.php
 *
 * @package RodenLaw
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "This script must run under wp-cli (wp eval-file).\n" );
	exit( 1 );
}

global $wpdb;
$apply = isset( $args[0] ) && 'apply' === $args[0];
$out   = fopen( 'php://stdout', 'w' );
$today = '2026-08-26';

/**
 * Each edit: post ID, surface, exact FROM, exact TO, and the finding it closes.
 * surface is 'content' or 'faq:<index>:answer'.
 */
$edits = array(

/* ── §1.1  SC medical-malpractice cap ─────────────────────────────────────── */

array( 'id' => 4349, 'ref' => '1.1', 'surface' => 'content',
 'from' => '<p>South Carolina does not impose a statutory cap on compensatory damages in medical malpractice cases. You can recover:</p>',
 'to'   => '<p>South Carolina does not cap economic damages in medical malpractice cases, but it does cap non-economic damages. S.C. Code § 15-32-220 sets a base limit of $350,000 against any single provider or institution, and $1.05 million where more than one is liable. That figure is adjusted every year for inflation and published in the State Register, so the limit that applies to your case is higher than the base — ask your lawyer for the current figure. Subject to that cap, you can recover:</p>' ),

array( 'id' => 4349, 'ref' => '1.1', 'surface' => 'content',
 'from' => "<td>Non-economic damages cap</td>\n<td>No statutory cap</td>\n<td>\$350,000 per provider (declared unconstitutional for some claims)</td>",
 'to'   => "<td>Non-economic damages cap</td>\n<td>\$350,000 per provider / \$1.05M aggregate, adjusted annually for inflation (S.C. Code § 15-32-220)</td>\n<td>None — the \$350,000 cap was struck down in Nestlehutt (2010)</td>" ),

array( 'id' => 4349, 'ref' => '1.1', 'surface' => 'faq:3:answer',
 'from' => 'South Carolina does not impose a statutory cap on compensatory damages (economic or non-economic) in medical malpractice cases.',
 'to'   => 'South Carolina does not cap economic damages in medical malpractice cases, but non-economic damages are capped by S.C. Code § 15-32-220 — a base of $350,000 against a single provider and $1.05 million where more than one is liable, adjusted annually for inflation, so the limit that applies today is higher than the base.' ),

array( 'id' => 4363, 'ref' => '1.1', 'surface' => 'content',
 'from' => "      <td>Damages Cap</td>\n      <td>No cap (SC Supreme Court struck down caps in 2012)</td>\n      <td>No cap on compensatory damages; \$350K cap on noneconomic damages (challenged)</td>",
 'to'   => "      <td>Damages Cap</td>\n      <td>Economic damages uncapped; non-economic capped at \$350,000 per provider / \$1.05M aggregate, adjusted annually for inflation (S.C. Code Section 15-32-220)</td>\n      <td>No cap — the \$350,000 non-economic cap was struck down in Atlanta Oculoplastic Surgery v. Nestlehutt (2010)</td>" ),

array( 'id' => 4363, 'ref' => '1.1', 'surface' => 'faq:4:answer',
 'from' => 'SC does not cap compensatory damages in medical malpractice cases.',
 'to'   => 'South Carolina does not cap economic damages, but non-economic damages are capped under S.C. Code Section 15-32-220 — a $350,000 base per provider, adjusted annually for inflation.' ),

array( 'id' => 3608, 'ref' => '1.1', 'surface' => 'faq:5:answer',
 'from' => 'South Carolina also does not cap non-economic damages in medical malpractice cases, though punitive damages are limited to the greater of $500,000 or three times compensatory damages (S.C. Code § 15-32-530).',
 'to'   => 'South Carolina does cap non-economic damages in medical malpractice cases: S.C. Code § 15-32-220 sets a base of $350,000 against a single provider and $1.05 million where more than one is liable, adjusted annually for inflation. Punitive damages are separately limited to the greater of $500,000 or three times compensatory damages (S.C. Code § 15-32-530).' ),

/* ── §1.4  Georgia ante litem ─────────────────────────────────────────────── */

array( 'id' => 1722, 'ref' => '1.4', 'surface' => 'content',
 'from' => 'If you are bringing a claim against a city or county government in Georgia, you must provide written <strong>ante litem notice</strong> within 12 months of the incident under <strong>O.C.G.A. &#167; 36-33-5</strong>.',
 'to'   => 'If you are bringing a claim against a Georgia city, you must provide written <strong>ante litem notice</strong> within <strong>six months</strong> of the incident under <strong>O.C.G.A. &#167; 36-33-5</strong>. A claim against a county must be presented within <strong>12 months</strong> under <strong>O.C.G.A. &#167; 36-11-1</strong>.' ),

array( 'id' => 1722, 'ref' => '1.4', 'surface' => 'content',
 'from' => '<td>Ante litem notice within 12 months (O.C.G.A. &#167; 36-33-5)</td>',
 'to'   => '<td>Ante litem notice — 6 months for a city (O.C.G.A. &#167; 36-33-5), 12 months for a county (&#167; 36-11-1) or the state (&#167; 50-21-26)</td>' ),

array( 'id' => 1722, 'ref' => '1.4', 'surface' => 'faq:3:answer',
 'from' => 'Government claims require ante litem notice under O.C.G.A. § 36-33-5.',
 'to'   => 'Government claims require ante litem notice — six months for a city under O.C.G.A. § 36-33-5, and 12 months for a county (§ 36-11-1) or the state (§ 50-21-26).' ),

array( 'id' => 1692, 'ref' => '1.4', 'surface' => 'content',
 'from' => 'Claims against government entities in Georgia require an ante-litem notice within 12 months (O.C.G.A. § 36-33-5) — significantly shorter than the standard statute of limitations.',
 'to'   => 'Claims against government entities in Georgia require ante-litem notice, and the deadline depends on the entity: six months for a city (O.C.G.A. § 36-33-5), 12 months for a county (§ 36-11-1), and 12 months for the state (§ 50-21-26) — all significantly shorter than the standard statute of limitations.' ),

array( 'id' => 1692, 'ref' => '1.4', 'surface' => 'content',
 'from' => "<td><strong>Claims Against Government</strong></td>\n<td>Ante-litem notice within 12 months</td>",
 'to'   => "<td><strong>Claims Against Government</strong></td>\n<td>Ante-litem notice — 6 months for a city, 12 months for a county or the state</td>" ),

array( 'id' => 1692, 'ref' => '1.7', 'surface' => 'content',
 'from' => '<td>1 year from last benefit or 2 years from injury (O.C.G.A. § 34-9-82)</td>',
 'to'   => '<td>1 year from injury; 1 year from the last employer-furnished treatment, or 2 years from the last weekly benefit payment (O.C.G.A. § 34-9-82)</td>' ),

array( 'id' => 1686, 'ref' => '1.4', 'surface' => 'content',
 'from' => '<td>Ante-litem notice within 12 months (O.C.G.A. § 36-33-5)</td>',
 'to'   => '<td>Ante-litem notice — 6 months for a city (O.C.G.A. § 36-33-5), 12 months for a county (§ 36-11-1) or the state (§ 50-21-26)</td>' ),

array( 'id' => 1716, 'ref' => '1.4', 'surface' => 'content',
 'from' => 'Claims against counties and municipalities follow separate rules under O.C.G.A. &sect; 36-33-1, which requires written ante litem notice within 12 months of the incident.',
 'to'   => 'Claims against counties and municipalities follow separate rules. A claim against a municipality requires written ante litem notice within six months under O.C.G.A. &sect; 36-33-5; a claim against a county must be presented within 12 months under O.C.G.A. &sect; 36-11-1.' ),

array( 'id' => 4589, 'ref' => '1.4', 'surface' => 'faq:1:answer',
 'from' => 'Government claims need ante litem notice within 12 months.',
 'to'   => 'Government claims need ante litem notice first — six months for a city (O.C.G.A. § 36-33-5), 12 months for a county (§ 36-11-1) or the state (§ 50-21-26).' ),

array( 'id' => 4106, 'ref' => '1.4+1.6', 'surface' => 'content',
 'from' => "Georgia's ante litem notice requirement typically requires notice within 12 months, and South Carolina's South Carolina Tort Claims Act imposes specific procedures.",
 'to'   => "Georgia's ante litem deadline depends on the defendant — six months for a city (O.C.G.A. § 36-33-5), 12 months for a county (§ 36-11-1) or the state (§ 50-21-26). South Carolina's Tort Claims Act shortens the filing deadline to two years (S.C. Code § 15-78-110); filing a verified claim within one year is optional and extends it to three." ),

);

fprintf( $out, "%s\n\n", $apply ? '=== APPLY ===' : '=== DRY RUN (pass "apply" to write) ===' );

$backup = array();
$ok = 0; $skipped = 0;
$dirty_content = array();   // id => new content
$dirty_faqs    = array();   // id => faq array
$touched_ids   = array();

foreach ( $edits as $e ) {
	$id = (int) $e['id'];

	if ( ! isset( $backup[ $id ] ) ) {
		$row = $wpdb->get_row( $wpdb->prepare( "SELECT ID, post_name, post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
		if ( ! $row ) {
			fprintf( $out, "!! post %d not found\n", $id );
			$skipped++;
			continue;
		}
		$backup[ $id ] = array(
			'ID'           => $id,
			'post_name'    => $row->post_name,
			'post_content' => $row->post_content,
			'faqs'         => get_post_meta( $id, '_roden_faqs', true ),
		);
	}

	if ( 'content' === $e['surface'] ) {
		$cur = isset( $dirty_content[ $id ] ) ? $dirty_content[ $id ] : $backup[ $id ]['post_content'];
		$n   = substr_count( $cur, $e['from'] );
		if ( 1 !== $n ) {
			fprintf( $out, "!! SKIP  [%d] §%s content — FROM matched %d times, expected exactly 1\n     %s…\n",
				$id, $e['ref'], $n, substr( $e['from'], 0, 90 ) );
			$skipped++;
			continue;
		}
		$dirty_content[ $id ] = str_replace( $e['from'], $e['to'], $cur );
		$touched_ids[ $id ]   = true;
		$ok++;
		fprintf( $out, "OK   [%d] §%s content\n     - %s…\n     + %s…\n", $id, $e['ref'],
			substr( str_replace( "\n", ' ', $e['from'] ), 0, 96 ),
			substr( str_replace( "\n", ' ', $e['to'] ), 0, 96 ) );
		continue;
	}

	// faq:<i>:answer
	list( , $idx, ) = explode( ':', $e['surface'] );
	$idx  = (int) $idx;
	$faqs = isset( $dirty_faqs[ $id ] ) ? $dirty_faqs[ $id ] : $backup[ $id ]['faqs'];
	if ( ! is_array( $faqs ) || ! isset( $faqs[ $idx ]['answer'] ) ) {
		fprintf( $out, "!! SKIP  [%d] §%s faq[%d] — no such FAQ answer\n", $id, $e['ref'], $idx );
		$skipped++;
		continue;
	}
	$n = substr_count( $faqs[ $idx ]['answer'], $e['from'] );
	if ( 1 !== $n ) {
		fprintf( $out, "!! SKIP  [%d] §%s faq[%d] — FROM matched %d times, expected exactly 1\n", $id, $e['ref'], $idx, $n );
		$skipped++;
		continue;
	}
	$faqs[ $idx ]['answer'] = str_replace( $e['from'], $e['to'], $faqs[ $idx ]['answer'] );
	$dirty_faqs[ $id ]      = $faqs;
	$touched_ids[ $id ]     = true;
	$ok++;
	fprintf( $out, "OK   [%d] §%s faq[%d]\n     - %s…\n     + %s…\n", $id, $e['ref'], $idx,
		substr( $e['from'], 0, 96 ), substr( $e['to'], 0, 96 ) );
}

fprintf( $out, "\nedits applied: %d    skipped: %d    posts touched: %d\n", $ok, $skipped, count( $touched_ids ) );

if ( $skipped > 0 ) {
	fprintf( $out, "\nABORTING — %d edit(s) did not match exactly once. Nothing written.\n", $skipped );
	fprintf( $out, "Re-pull the live text and update the FROM strings; do not loosen the guard.\n" );
	exit( 1 );
}

if ( ! $apply ) {
	fprintf( $out, "\nDry run only. Pass \"apply\" to write.\n" );
	exit( 0 );
}

$file = sprintf( '/tmp/roden-tier1-batch1-backup-%s.json', gmdate( 'Ymd-His' ) );
file_put_contents( $file, wp_json_encode( array_values( $backup ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
fprintf( $out, "\nbackup written: %s\n\n", $file );

foreach ( array_keys( $touched_ids ) as $id ) {
	if ( isset( $dirty_content[ $id ] ) ) {
		$r = $wpdb->update( $wpdb->posts, array( 'post_content' => $dirty_content[ $id ] ),
			array( 'ID' => $id ), array( '%s' ), array( '%d' ) );
		if ( false === $r ) { fprintf( $out, "!! [%d] content UPDATE FAILED\n", $id ); continue; }
	}
	if ( isset( $dirty_faqs[ $id ] ) ) {
		update_post_meta( $id, '_roden_faqs', $dirty_faqs[ $id ] );
	}
	// Content corrected, no reviewer claimed.
	update_post_meta( $id, '_roden_last_refreshed', $today );

	// Read back from the DB, not from our own variables.
	$c  = $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	$f  = get_post_meta( $id, '_roden_faqs', true );
	$fb = is_array( $f ) ? wp_json_encode( $f ) : '';
	$stale = 0;
	foreach ( $edits as $e ) {
		if ( (int) $e['id'] !== $id ) { continue; }
		$stale += substr_count( $c, $e['from'] ) + substr_count( $fb, $e['from'] );
	}
	fprintf( $out, "[%d] written · stale FROM strings remaining: %d %s\n", $id, $stale, $stale ? '!!' : 'OK' );
}

fprintf( $out, "\nDone. Flush both cache layers, then verify live.\n" );
