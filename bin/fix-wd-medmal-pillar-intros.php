<?php
/**
 * Correct the wrongful-death (3609) and medical-malpractice (3608) pillar intros,
 * which render with state tokens on every office practice page of those
 * practices — first the Charleston rebuilds (wave 1, #10 and #11). Read against
 * scstatehouse.gov and the SC pack on 2026-09-28:
 *
 * Medical malpractice (SC branch and shared text):
 * - Caps given as "$350,000 per defendant / $1.05 million aggregate": those are
 *   the base figures; the 2026 caps are $596,001 per provider or institution and
 *   $1,788,002 aggregate, with exceptions for gross negligence and reckless
 *   conduct (SC 15-32-220).
 * - The expert affidavit was cited to § 15-79-125; it is § 15-36-100, filed with
 *   the Notice of Intent under § 15-79-125, which also sets the 90-to-120-day
 *   mediation (pending authorities, internal-ai-scripts #69).
 * - "Punitive damages are available for gross negligence": not the standard;
 *   now only the clear-and-convincing burden (SC 15-33-135).
 * - "uncapped in both states": two-state text; SC's cap leaves economic damages
 *   alone (SC 15-32-220(D)).
 * - "{office_court}'s jurisdictional area" filler removed.
 *
 * Wrongful death (SC branch and shared text):
 * - "Both Georgia and South Carolina permit …": two-state text on single-state
 *   pages.
 * - "within 3 years of death": when the three years start is for Gillin; now
 *   "generally within three years" (SC 15-3-530).
 * - "pecuniary loss … mental anguish and loss of companionship … under § 15-51-40":
 *   the section lists no such elements; now its actual terms (pending SC 15-51-40).
 * - "Survival claims … recover pre-death pain, suffering, and funeral and medical
 *   expenses" under § 15-5-90: the section lists no damages; now what it says.
 *
 * Georgia branches are left as they were (for the GA reviewer), except that
 * two-state sentences outside the branches are made state-neutral.
 *
 *   Dry run: ssh $H "wp --path=$P eval-file -" < bin/fix-wd-medmal-pillar-intros.php > docs/backups/wd-medmal-pillar-intros-2026-09-28.json
 *   Apply:   ssh $H "wp --path=$P eval-file - apply" < bin/fix-wd-medmal-pillar-intros.php > docs/backups/wd-medmal-pillar-intros-2026-09-28.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$err   = fopen( 'php://stderr', 'w' );

$fix = array(
	3608 => array(
		'_roden_pillar_negligence_intro' => array(
			'old' => "Medical malpractice replaces \"ordinary care\" with the **standard of care** of a reasonably prudent practitioner in the same specialty. {{GA}}**Georgia requires a contemporaneous expert affidavit** with the complaint setting forth at least one negligent act under O.C.G.A. § 9-11-9.1 — failure is grounds for dismissal. The statute of limitations is 2 years from injury with a 5-year statute of repose (O.C.G.A. § 9-3-71). {{/GA}}{{SC}}**South Carolina requires a Notice of Intent to File Suit and an expert affidavit** under S.C. Code § 15-79-125, plus a mandatory pre-suit mediation period before suit can proceed. The statute of limitations is 3 years from discovery with a 6-year repose (S.C. Code § 15-3-545). {{/SC}}In {market_name}, claims commonly arise out of {office_court}'s jurisdictional area.",
			'new' => "Medical malpractice replaces \"ordinary care\" with the **standard of care** of a reasonably prudent practitioner in the same specialty. {{GA}}**Georgia requires a contemporaneous expert affidavit** with the complaint setting forth at least one negligent act under O.C.G.A. § 9-11-9.1 — failure is grounds for dismissal. The statute of limitations is 2 years from injury with a 5-year statute of repose (O.C.G.A. § 9-3-71). {{/GA}}{{SC}}**South Carolina requires a Notice of Intent to File Suit**, filed together with a qualified expert's affidavit, before a malpractice suit can be filed (S.C. Code §§ 15-79-125, 15-36-100). The parties must then mediate, generally within 90 to 120 days. The deadline is generally three years from the treatment or from when the injury was or should have been discovered, but no more than six years from the treatment (S.C. Code § 15-3-545). {{/SC}}",
		),
		'_roden_pillar_compensation_intro' => array(
			'old' => "{{GA}}**Georgia has no statutory cap on noneconomic damages** in medical malpractice cases since *Atlanta Oculoplastic Surgery, P.C. v. Nestlehutt*, 286 Ga. 731 (2010), which struck down O.C.G.A. § 51-13-1 as a violation of the right to jury trial. {{/GA}}{{SC}}**South Carolina caps noneconomic damages at $350,000 per defendant / $1.05 million aggregate** under S.C. Code § 15-32-220, adjusted annually for inflation. {{/SC}}Economic damages — past and future medicals, lost wages, lost earning capacity, attendant care — are uncapped in both states. Punitive damages are available for gross negligence with separate statutory caps.",
			'new' => "{{GA}}**Georgia has no statutory cap on noneconomic damages** in medical malpractice cases since *Atlanta Oculoplastic Surgery, P.C. v. Nestlehutt*, 286 Ga. 731 (2010), which struck down O.C.G.A. § 51-13-1 as a violation of the right to jury trial. {{/GA}}{{SC}}**South Carolina caps noneconomic damages** in medical malpractice cases. The caps are adjusted each year; for 2026 they are $596,001 per health care provider or institution and $1,788,002 in total per claimant, and they do not apply in cases of gross negligence or reckless conduct (S.C. Code § 15-32-220). Economic damages — past and future medical costs, lost wages, lost earning capacity, attendant care — are not limited by the cap. Punitive damages must be proved by clear and convincing evidence (S.C. Code § 15-33-135).{{/SC}}",
		),
	),
	3609 => array(
		'_roden_pillar_negligence_intro' => array(
			'old' => "Both Georgia and South Carolina permit a **wrongful-death action** plus a separate **survival action** for the decedent's pre-death pain, suffering, and medical expenses. {{GA}}In **Georgia**, the surviving spouse holds the wrongful-death claim, with children sharing under O.C.G.A. § 51-4-2, and the action must be filed within 2 years of death (O.C.G.A. § 9-3-33). {{/GA}}{{SC}}In **South Carolina**, the **personal representative** brings the action for the benefit of statutory beneficiaries (S.C. Code § 15-51-10 to -60), and it must be filed within 3 years of death (S.C. Code § 15-3-530). {{/SC}}The underlying tort — auto crash, medical negligence, defective product — must be independently provable.",
			'new' => "A death caused by someone else's negligence can support a **wrongful-death action** for the family and a separate **survival action** for the claim the person had before death. {{GA}}In **Georgia**, the surviving spouse holds the wrongful-death claim, with children sharing under O.C.G.A. § 51-4-2, and the action must be filed within 2 years of death (O.C.G.A. § 9-3-33). {{/GA}}{{SC}}In **South Carolina**, the estate's **personal representative** (executor or administrator) brings the wrongful-death action for the spouse and children, or if there are none, the parents, or if none, the heirs (S.C. Code §§ 15-51-10, 15-51-20). It generally must be filed within three years (S.C. Code § 15-3-530). {{/SC}}The underlying negligence — a crash, medical negligence, a defective product — must still be proved.",
		),
		'_roden_pillar_compensation_intro' => array(
			'old' => "{{GA}}**Georgia's \"full value of the life of the decedent\" measure (O.C.G.A. § 51-4-1(1)) is among the broadest wrongful-death recoveries in the United States** — it captures both the economic *and* intangible value of the life as the decedent would have lived it, with **no offset for the decedent's living expenses**. Survival claims under O.C.G.A. § 9-2-41 recover pre-death pain, suffering, and funeral and medical expenses.{{/GA}}{{SC}}South Carolina's measure is more conventional: pecuniary loss to beneficiaries plus mental anguish and loss of companionship, society, and consortium under S.C. Code § 15-51-40. Survival claims under S.C. Code § 15-5-90 recover pre-death pain, suffering, and funeral and medical expenses.{{/SC}}",
			'new' => "{{GA}}**Georgia's \"full value of the life of the decedent\" measure (O.C.G.A. § 51-4-1(1)) is among the broadest wrongful-death recoveries in the United States** — it captures both the economic *and* intangible value of the life as the decedent would have lived it, with **no offset for the decedent's living expenses**. Survival claims under O.C.G.A. § 9-2-41 recover pre-death pain, suffering, and funeral and medical expenses.{{/GA}}{{SC}}In South Carolina, the jury awards damages in proportion to the loss the death caused each family member, and may add punitive damages when the conduct was reckless, wilful or malicious. The recovery is divided as it would be under the intestacy rules (S.C. Code § 15-51-40). Separately, the person's own claim for their injuries survives their death and can be brought by the estate (S.C. Code § 15-5-90).{{/SC}}",
		),
	),
);

$backup = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'before' => array() );
foreach ( $fix as $id => $fields ) {
	foreach ( $fields as $k => $f ) {
		$cur = (string) get_post_meta( $id, $k, true );
		$backup['before'][ $id ][ $k ] = $cur;
		if ( $cur === $f['new'] ) { fprintf( $err, "  %d %s already corrected\n", $id, $k ); continue; }
		if ( $cur !== $f['old'] ) { fprintf( $err, "ABORT: %d %s is not the text read on 2026-09-28.\n", $id, $k ); exit( 1 ); }
		fprintf( $err, "  %d %s: would replace (%d -> %d chars)\n", $id, $k, strlen( $cur ), strlen( $f['new'] ) );
	}
}
echo wp_json_encode( $backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
if ( ! $apply ) { exit( 0 ); }
global $wpdb; $ok = true;
foreach ( $fix as $id => $fields ) {
	foreach ( $fields as $k => $f ) {
		update_post_meta( $id, $k, wp_slash( $f['new'] ) );
		$back = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = %s", $id, $k ) );
		$ok   = $ok && $back === $f['new'];
		fprintf( $err, "  %d %s: %s\n", $id, $k, $back === $f['new'] ? 'written, read back exact' : 'MISMATCH' );
	}
	clean_post_cache( $id );
}
exit( $ok ? 0 : 1 );
