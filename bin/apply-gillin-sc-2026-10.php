<?php
/**
 * Graeham C. Gillin's South Carolina answers on the October attorney review
 * (data/facts/reviews/2026-10-attorney/answers-gillin.json, submitted
 * 2026-10-26T21:31Z), applied where the wording is South Carolina only.
 * Owner, 2026-10-27: "yes on 1 and 2".
 *
 * Items: E9, E10 (SC cells, sentence, FAQ 3, KT), E26 (Gillin's wording), E31,
 * E35, E36, E37, F1, F2, F3, F17, F18, F20, G3, G4, G5, G7, G8, sc-held-shoulder
 * (1856, 4478); plus two x27 apostrophe corruptions in 1837's FAQs.
 * Held for Tyler Love (new wording states Georgia law; GA pack unsigned, D6):
 * E2, F19, G14 (+ Gillin's FAQ addition), G21, G29. Not here: the "yes"
 * answers on 3130(a) and the 3230 gloss, Q-3435, Q-6160 (wording not drafted).
 *
 * Every edit is an exact match, exactly once, checked against every surface
 * BEFORE any write; one write per surface (content, each meta key) via
 * wp_slash; read back from the table; sets _roden_content_modified per post.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/apply-gillin-sc-2026-10.php > docs/backups/gillin-sc-2026-10-27.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$edits = json_decode( <<<'EDITS'
[
 {
  "post": 1690,
  "field": "content",
  "from": "Similar to Georgia, if the employer has a substance abuse policy and the employee tests positive post-accident, a presumption may apply.",
  "to": "Unlike Georgia's, § 42-9-60 creates no presumption: the employer must prove that intoxication caused the injury.",
  "item": "E9"
 },
 {
  "post": 1690,
  "field": "content",
  "from": "<h3>Willful Violation of Safety Rules (S.C. Code § 42-9-60)</h3>\n<p>South Carolina specifically addresses safety rule violations. Under S.C. Code § 42-9-60, if an employee's injury is caused by their <strong>willful failure</strong> to use a safety device or obey a safety rule required by statute or <strong>deliberately adopted by the employer</strong>, the Workers' Compensation Commission <strong>may reduce</strong> (but not necessarily eliminate) the employee's compensation.</p>\n\n<p>Important: this requires a <strong>willful</strong> failure — not mere forgetfulness or negligence. The employer must prove:</p>\n<ul>\n<li>A specific safety rule existed and was communicated to the employee</li>\n<li>The employee knew about the rule</li>\n<li>The employee deliberately chose not to follow it</li>\n<li>The violation caused the injury</li>\n</ul>",
  "to": "<h3>No Safety-Rule Defense (S.C. Code § 42-9-60)</h3>\n<p>South Carolina's statute has no safety-rule defense. Section 42-9-60 bars compensation only for intoxication or a wilful intention to injure or kill oneself or another, and it does not reduce benefits for a safety-rule violation.</p>",
  "item": "E9"
 },
 {
  "post": 1690,
  "field": "content",
  "from": "<td>Reduction of benefits (S.C. Code § 42-9-60)</td>",
  "to": "<td>Denial only for a wilful intention to injure or kill oneself or another (S.C. Code § 42-9-60)</td>",
  "item": "E10"
 },
 {
  "post": 1690,
  "field": "content",
  "from": "<td>May reduce (not eliminate) benefits if willful</td>",
  "to": "<td>Not a defense (S.C. Code § 42-9-60)</td>",
  "item": "E10"
 },
 {
  "post": 1690,
  "field": "content",
  "from": "Only a willful violation of a specific employer safety rule may reduce benefits in South Carolina — and even then, it does not eliminate them.",
  "to": "South Carolina's act has no safety-rule defense (S.C. Code § 42-9-60).",
  "item": "E10"
 },
 {
  "post": 1690,
  "field": "faq:3:answer",
  "from": "Yes, but only for a <strong>willful</strong> violation. Under S.C. Code § 42-9-60, if you deliberately failed to use a safety device or obey a specific safety rule, the Workers' Compensation Commission may <strong>reduce</strong> (not eliminate) your compensation. The employer must prove the rule existed, you knew about it, you deliberately chose not to follow it, and the violation caused the injury. Simple forgetfulness or negligence is not enough.",
  "to": "No. S.C. Code § 42-9-60 bars compensation only when the injury was caused by intoxication or by a wilful intention to injure or kill yourself or another, and the employer bears the burden of proving it. The statute contains no reduction for a safety-rule violation.",
  "item": "E10"
 },
 {
  "post": 1690,
  "field": "_roden_key_takeaways",
  "from": "South Carolina may reduce benefits for willful safety rule violations but cannot eliminate them.",
  "to": "South Carolina's act has no safety-rule defense (S.C. Code § 42-9-60).",
  "item": "E10"
 },
 {
  "post": 1677,
  "field": "content",
  "from": "There is no automatic cutoff date.",
  "to": "Treatment can end one year after a settlement on the Commission's permanent-disability form is paid in full, or after a lapse of more than a year in authorized treatment, subject to statutory exceptions (S.C. Code § 42-15-60(B)).",
  "item": "E26"
 },
 {
  "post": 1674,
  "field": "content",
  "from": "<td>Employer panel (O.C.G.A. § 34-9-201)</td>\n<td>Employee choice</td>",
  "to": "<td>Employer panel (O.C.G.A. § 34-9-201)</td>\n<td>Employer may furnish the attending physician (S.C. Code § 42-15-60)</td>",
  "item": "E31"
 },
 {
  "post": 5145,
  "field": "content",
  "from": "South Carolina holds ER care to ordinary negligence, so the same facts can qualify more readily there.",
  "to": "South Carolina's rule is narrower: it protects only physicians, and only for a genuine emergency while the patient is unstable and in the emergency department or an obstetrical or surgical suite, where the physician is liable only if grossly negligent (S.C. Code § 15-32-230).",
  "item": "E35"
 },
 {
  "post": 5128,
  "field": "content",
  "from": "<td>Ordinary standard of care</td>",
  "to": "<td>Ordinary standard for the hospital; gross negligence for a physician in a genuine emergency while the patient is unstable (S.C. Code § 15-32-230)</td>",
  "item": "E36"
 },
 {
  "post": 5141,
  "field": "content",
  "from": "<td>Estándar de cuidado ordinario</td>",
  "to": "<td>Estándar ordinario para el hospital; negligencia grave para el médico en una emergencia genuina mientras el paciente está inestable (S.C. Code § 15-32-230)</td>",
  "item": "E37"
 },
 {
  "post": 1837,
  "field": "content",
  "from": "<td>Yes — anyone who has reason to believe a vulnerable adult is being abused must report</td>",
  "to": "<td>Yes — listed professionals, caregivers and facility staff must report when they have reason to believe; anyone else must report only with actual knowledge (S.C. Code § 43-35-25(A))</td>",
  "item": "F1"
 },
 {
  "post": 1837,
  "field": "content",
  "from": "South Carolina has a broader mandatory reporting requirement — <strong>anyone</strong> who has reason to believe a vulnerable adult is being abused or exploited must report it.",
  "to": "In South Carolina, doctors, nurses, caregivers, facility staff and the other professionals listed in S.C. Code § 43-35-25(A) must report when they have reason to believe a vulnerable adult has been abused, neglected or exploited, and any other person who has actual knowledge of it must report as well.",
  "item": "F2"
 },
 {
  "post": 1837,
  "field": "faq:3:answer",
  "from": "South Carolina has a broader mandatory reporting requirement — anyone who suspects abuse must report it.",
  "to": "Listed professionals and caregivers must report when they have reason to believe abuse occurred, and anyone with actual knowledge of it must report (S.C. Code § 43-35-25(A)).",
  "item": "F3"
 },
 {
  "post": 1837,
  "field": "faq:3:answer",
  "from": "South Carolinax27s",
  "to": "South Carolina's",
  "item": "mechanical: x27 apostrophe corruption"
 },
 {
  "post": 1837,
  "field": "faq:0:answer",
  "from": "residentx27s",
  "to": "resident's",
  "item": "mechanical: x27 apostrophe corruption"
 },
 {
  "post": 4639,
  "field": "_roden_key_takeaways",
  "from": "Bicyclists have the <strong>same rights and duties as motor vehicles</strong> and are entitled to a <strong>3-foot passing distance</strong>.",
  "to": "Bicyclists have the <strong>same rights and duties as drivers</strong> (S.C. Code § 56-5-3420), and a driver passing a cyclist must keep a <strong>safe operating distance</strong>; South Carolina sets no fixed number of feet (S.C. Code § 56-5-3435).",
  "item": "F17"
 },
 {
  "post": 4639,
  "field": "content",
  "from": "Drivers must give cyclists at least 3 feet of clearance when passing (recommended; enforcement varies).",
  "to": "Drivers must keep a safe operating distance when passing a cyclist; South Carolina law names no fixed distance (S.C. Code § 56-5-3435).",
  "item": "F18"
 },
 {
  "post": 1693,
  "field": "content",
  "from": "<td>Exempt unless employer meets the 4-employee threshold</td>",
  "to": "<td>Exempt unless the employer elects coverage (S.C. Code §§ 42-1-360(4), 42-1-380)</td>",
  "item": "F20"
 },
 {
  "post": 4207,
  "field": "content",
  "from": "<strong>South Carolina's Youth Athletic Concussion Prevention Act</strong> (<a href=\"https://www.scstatehouse.gov/code/t59c063.php\" target=\"_blank\" rel=\"noopener\">S.C. Code § 59-63-75</a>) imposes identical requirements — immediate removal and mandatory medical clearance before return.",
  "to": "<strong>South Carolina's student-athlete concussion law</strong> (<a href=\"https://www.scstatehouse.gov/code/t59c063.php\" target=\"_blank\" rel=\"noopener\">S.C. Code § 59-63-75</a>) is similar but not identical: an athlete suspected of a concussion must be removed from practice or competition, may return the same day only if an athletic trainer, physician, physician assistant or nurse practitioner finds no signs or symptoms on site, and otherwise needs written clearance from a physician.",
  "item": "G3"
 },
 {
  "post": 4205,
  "field": "content",
  "from": "<strong>South Carolina's Youth Athletic Concussion Prevention Act</strong> (<a href=\"https://www.scstatehouse.gov/code/t59c063.php\" target=\"_blank\" rel=\"noopener\">S.C. Code § 59-63-75</a>) imposes similar requirements, mandating annual concussion education, immediate removal from play when concussion is suspected, and written medical clearance before return to activity.",
  "to": "<strong>South Carolina's student-athlete concussion law</strong> (<a href=\"https://www.scstatehouse.gov/code/t59c063.php\" target=\"_blank\" rel=\"noopener\">S.C. Code § 59-63-75</a>) imposes similar requirements: an annual concussion information sheet for athletes and parents, removal from practice or competition when a concussion is suspected, and, unless an on-site evaluation by an athletic trainer, physician, physician assistant or nurse practitioner finds no signs or symptoms, written clearance from a physician before return to play.",
  "item": "G4"
 },
 {
  "post": 4162,
  "field": "content",
  "from": "S.C. Code § 56-5-1535 imposes enhanced penalties for speeding in highway work zones, including doubled fines and potential license suspension for repeat offenses.",
  "to": "S.C. Code § 56-5-1535 makes it an offense to endanger a highway worker by driving through a work zone outside the marked lanes or disobeying its traffic control devices while workers are present, with mandatory fines of $500 to $1,000, $1,000 to $2,000 if a worker is injured, and $2,000 to $5,000 for great bodily injury, plus license points.",
  "item": "G5"
 },
 {
  "post": 4352,
  "field": "content",
  "from": "<li><strong>Minimum operator age</strong> — no person under <strong>16 years old</strong> may operate a personal watercraft</li>\n<li><strong>Boater education</strong> — operators born after January 1, 1988 must complete an approved boater education course</li>",
  "to": "<li><strong>Who may operate</strong> — anyone born after July 1, 2007 must hold a South Carolina boating safety certificate (or a qualifying Coast Guard license, another state's certificate or a rental safety certificate), or be accompanied by someone 18 or older who qualifies, to operate a personal watercraft or a boat of 10 horsepower or more (S.C. Code § 50-21-95)</li>",
  "item": "G7"
 },
 {
  "post": 4111,
  "field": "content",
  "from": "South Carolina's occupational disease provision (<a href=\"https://www.scstatehouse.gov/code/t42c011.php\" target=\"_blank\" rel=\"noopener\">S.C. Code § 42-11-10 et seq.</a>) provides similar coverage, defining an occupational disease as one that is due to causes and conditions characteristic of and peculiar to the particular trade, occupation, or employment.",
  "to": "South Carolina defines an occupational disease as one arising out of and in the course of employment that is due to hazards in excess of those ordinarily incident to employment and peculiar to the occupation, and the worker must prove by a preponderance of the evidence that it arose directly and naturally from exposure in South Carolina to those hazards (<a href=\"https://www.scstatehouse.gov/code/t42c011.php\" target=\"_blank\" rel=\"noopener\">S.C. Code § 42-11-10(A)</a>).",
  "item": "G8"
 },
 {
  "post": 1856,
  "field": "content",
  "from": "Pedestrians walking along roads must use sidewalks when available, or walk on the left side facing traffic when no sidewalk is present.",
  "to": "Pedestrians walking along roads must use a sidewalk when one is available, otherwise the shoulder, and walk on the left side facing traffic only where there is neither.",
  "item": "sc-held-shoulder"
 },
 {
  "post": 4478,
  "field": "content",
  "from": "<li><strong>Walk on the left side of the road</strong> facing traffic when no sidewalk is available (S.C. Code § 56-5-3160)</li>",
  "to": "<li><strong>Use a sidewalk when one is available</strong>, otherwise the shoulder, and walk on the left side of the road facing traffic only where there is neither (S.C. Code § 56-5-3160)</li>",
  "item": "sc-held-shoulder"
 }
]
EDITS
, true );
if ( ! is_array( $edits ) ) { fwrite( STDERR, "ABORT: edit table did not parse\n" ); exit( 1 ); }

// Build working copies per post and surface.
$work = array(); $orig = array();
foreach ( $edits as $e ) {
	$p = $e['post'];
	if ( ! isset( $work[ $p ] ) ) {
		$post = get_post( $p );
		if ( ! $post || 'publish' !== $post->post_status ) { fwrite( STDERR, "ABORT: $p missing or not published\n" ); exit( 1 ); }
		$work[ $p ] = array( 'content' => $post->post_content );
		$orig[ $p ] = array( 'content' => $post->post_content );
	}
	$surface = 0 === strpos( $e['field'], 'faq:' ) ? '_roden_faqs' : $e['field'];
	if ( ! isset( $work[ $p ][ $surface ] ) ) {
		$v = get_post_meta( $p, $surface, true );
		if ( '' === $v || null === $v ) { fwrite( STDERR, "ABORT: $p has no $surface\n" ); exit( 1 ); }
		$work[ $p ][ $surface ] = $v; $orig[ $p ][ $surface ] = $v;
	}
}
$fail = 0; $log = array();
foreach ( $edits as $e ) {
	$p = $e['post'];
	if ( 0 === strpos( $e['field'], 'faq:' ) ) {
		list( , $i, $k ) = explode( ':', $e['field'] );
		$s = isset( $work[ $p ]['_roden_faqs'][ $i ][ $k ] ) ? $work[ $p ]['_roden_faqs'][ $i ][ $k ] : null;
	} else {
		$s = $work[ $p ][ $e['field'] ];
	}
	$n = is_string( $s ) ? substr_count( $s, $e['from'] ) : -1;
	if ( 1 !== $n ) { fwrite( STDERR, "MISMATCH {$e['item']} $p {$e['field']}: matched $n\n" ); $fail++; continue; }
	$s = str_replace( $e['from'], $e['to'], $s );
	if ( 0 === strpos( $e['field'], 'faq:' ) ) { $work[ $p ]['_roden_faqs'][ $i ][ $k ] = $s; } else { $work[ $p ][ $e['field'] ] = $s; }
	$log[] = array( 'item' => $e['item'], 'post' => $p, 'field' => $e['field'], 'from' => $e['from'], 'to' => $e['to'] );
	fwrite( STDERR, ( $apply ? 'fixing' : 'would fix' ) . " {$e['item']} $p {$e['field']}\n" );
}
if ( $fail ) { fwrite( STDERR, "ABORT: $fail mismatches, nothing written\n" ); exit( 1 ); }

$out = array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'edits' => $log, 'before' => $orig );
if ( $apply ) {
	global $wpdb; $now = gmdate( 'Y-m-d H:i:s' );
	foreach ( $work as $p => $surfaces ) {
		foreach ( $surfaces as $key => $val ) {
			if ( $val === $orig[ $p ][ $key ] ) continue;
			if ( 'content' === $key ) {
				$r = wp_update_post( wp_slash( array( 'ID' => $p, 'post_content' => $val ) ), true );
				if ( is_wp_error( $r ) ) { fwrite( STDERR, "FAILED write $p content: " . $r->get_error_message() . "\n" ); exit( 1 ); }
			} else {
				update_post_meta( $p, $key, wp_slash( $val ) );
			}
		}
		update_post_meta( $p, '_roden_content_modified', wp_slash( $now ) );
		clean_post_cache( $p ); wp_cache_delete( $p, 'post_meta' );
		foreach ( $surfaces as $key => $val ) {
			if ( 'content' === $key ) {
				$back = $wpdb->get_var( $wpdb->prepare( "SELECT post_content FROM {$wpdb->posts} WHERE ID = %d", $p ) );
			} else {
				$raw  = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = %s", $p, $key ) );
				$back = maybe_unserialize( $raw );
			}
			if ( $back !== $val ) { fwrite( STDERR, "FAILED read-back $p $key\n" ); exit( 1 ); }
		}
		fwrite( STDERR, "read-back OK $p\n" );
	}
}
echo wp_json_encode( $out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
