<?php
/**
 * Correct the workers' compensation pillar's two intro fields (post 3610), which
 * render with state tokens on every WC office practice page — first the
 * Charleston rebuild (wave 1, #5). SC branch only, from the signed SC pack:
 * § 42-1-540 (exclusive remedy) replaces the § 42-1-10 citation; § 42-9-10
 * (66 2/3%, state AWW cap, 500 weeks) replaces "tracks the statewide average
 * weekly wage" and the § 42-9-30 schedule citation (not in the pack). Shared
 * text: "medical (uncapped, related)" loses the unsupported "uncapped"; the
 * two-state 400/500-week comparison sentence and link come out (single-state
 * pages). The GA branches are unchanged.
 *
 *   Dry run: ssh $H "wp --path=$P eval-file -" < bin/fix-wc-pillar-intros.php > docs/backups/wc-pillar-intros-2026-09-26.json
 *   Apply:   ssh $H "wp --path=$P eval-file - apply" < bin/fix-wc-pillar-intros.php > docs/backups/wc-pillar-intros-2026-09-26.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );
$id    = 3610;
$fix   = array(
    '_roden_pillar_negligence_intro' => array( 'old' => "Workers' compensation is a **no-fault statutory scheme** that *replaces* common-law negligence: the injured worker need not prove fault, but in exchange gives up the right to sue the employer for tort damages (the \"exclusive remedy\" bar). To qualify, the injury must \"arise out of and in the course of\" employment. {{GA}}In Georgia, workers' compensation is governed by O.C.G.A. § 34-9-1 et seq. {{/GA}}{{SC}}In South Carolina, workers' compensation is governed by S.C. Code § 42-1-10 et seq. {{/SC}}**Third-party tort claims against non-employer tortfeasors remain available** (e.g., a defective machine manufacturer, a negligent driver who hits you at work, a property owner where you were injured) and can be pursued in parallel with the workers' comp claim.", 'prior' => array( "Workers' compensation is a **no-fault statutory scheme** that replaces common-law negligence: the injured worker need not prove fault, but in exchange gives up the right to sue the employer for tort damages (the \"exclusive remedy\" bar). To qualify, the injury must \"arise out of and in the course of\" employment. {{GA}}In Georgia, workers' compensation is governed by O.C.G.A. § 34-9-1 et seq. {{/GA}}{{SC}}In South Carolina, where employer and employee are under the Act, workers' compensation is the worker's exclusive remedy against the employer (S.C. Code § 42-1-540). {{/SC}}**Third-party tort claims against non-employer tortfeasors remain available** (e.g., a defective machine manufacturer, a negligent driver who hits you at work, a property owner where you were injured) and can be pursued in parallel with the workers' comp claim." ), 'new' => "Workers' compensation is a **no-fault statutory scheme** that replaces common-law negligence: the injured worker need not prove fault, but in exchange gives up the right to sue the employer for tort damages (the \"exclusive remedy\" bar). To qualify, the injury must \"arise out of and in the course of\" employment. {{GA}}In Georgia, workers' compensation is governed by O.C.G.A. § 34-9-1 et seq. {{/GA}}{{SC}}In South Carolina, where employer and employee are under the Act, workers' compensation is the worker's exclusive remedy against the employer (S.C. Code § 42-1-540). {{/SC}}**Third-party tort claims against someone other than your employer remain available** (e.g., a defective machine manufacturer, a negligent driver who hits you at work, a property owner where you were injured) and can be pursued in parallel with the workers' comp claim." ),
    '_roden_pillar_compensation_intro' => array( 'old' => "**There is no recovery for pain and suffering in workers' compensation** — only statutory benefits: medical (uncapped, related), temporary total disability (TTD) at 2/3 of average weekly wage subject to a state maximum, permanent partial disability per the body-part schedule, and (for fatalities) death benefits to surviving dependents. {{GA}}**Georgia's TTD maximum is set by statute and adjusted periodically** (O.C.G.A. § 34-9-261, § 34-9-265). {{/GA}}{{SC}}**South Carolina TTD tracks the statewide average weekly wage**, with permanent partial disability scheduled by body part under S.C. Code § 42-9-30. {{/SC}}Third-party tort recoveries fund the noneconomic damages workers' comp does not cover. The two states cap those benefits differently — 400 weeks in Georgia, 500 in South Carolina — and the routes past the cap work in opposite ways: <a href=\"/resources/georgia-vs-south-carolina-workers-compensation/\">the two systems compared side by side</a>.", 'prior' => array( "**There is no recovery for pain and suffering in workers' compensation** — only statutory benefits: medical care, temporary total disability (TTD) at 2/3 of average weekly wage subject to a state maximum, permanent partial disability per the body-part schedule, and (for fatalities) death benefits to surviving dependents. {{GA}}**Georgia's TTD maximum is set by statute and adjusted periodically** (O.C.G.A. § 34-9-261, § 34-9-265). {{/GA}}{{SC}}In South Carolina, total disability pays 66 2/3% of the average weekly wage, no more than the state average weekly wage, for up to 500 weeks (S.C. Code § 42-9-10). {{/SC}}Third-party tort recoveries fund the noneconomic damages workers' comp does not cover." ), 'new' => "**There is no recovery for pain and suffering in workers' compensation** — only statutory benefits: medical care, temporary total disability (TTD) at 2/3 of average weekly wage subject to a state maximum, permanent partial disability per the body-part schedule, and (for fatalities) death benefits to surviving dependents. {{GA}}**Georgia's TTD maximum is set by statute and adjusted periodically** (O.C.G.A. § 34-9-261, § 34-9-265). {{/GA}}{{SC}}In South Carolina, total disability pays 66 2/3% of the average weekly wage, no more than the state average weekly wage, for up to 500 weeks, or for life for a worker left paraplegic, quadriplegic or with physical brain damage (S.C. Code § 42-9-10). {{/SC}}Third-party tort recoveries fund the noneconomic damages workers' comp does not cover." ),
);
$backup = array( 'generated' => gmdate( 'c' ), 'post' => $id, 'mode' => $apply ? 'apply' : 'dry-run', 'before' => array() );
foreach ( $fix as $k => $f ) {
    $cur = (string) get_post_meta( $id, $k, true );
    $backup['before'][ $k ] = $cur;
    if ( $cur === $f['new'] ) { fprintf( $err, "  %s already corrected\n", $k ); continue; }
    if ( $cur !== $f['old'] && ! in_array( $cur, $f['prior'] ?? array(), true ) ) { fprintf( $err, "ABORT: %s is not the text the sweep read.\n", $k ); exit( 1 ); }
    fprintf( $err, "  %s: would replace (%d -> %d chars)\n", $k, strlen( $cur ), strlen( $f['new'] ) );
}
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
if ( ! $apply ) { exit( 0 ); }
global $wpdb; $ok = true;
foreach ( $fix as $k => $f ) {
    update_post_meta( $id, $k, wp_slash( $f['new'] ) );
    $back = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = %s", $id, $k ) );
    $ok   = $ok && $back === $f['new'];
    fprintf( $err, "  %s: %s\n", $k, $back === $f['new'] ? 'written, read back exact' : 'MISMATCH' );
}
clean_post_cache( $id );
exit( $ok ? 0 : 1 );
