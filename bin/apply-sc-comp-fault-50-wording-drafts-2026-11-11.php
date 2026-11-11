<?php
/**
 * South Carolina comparative fault, UNPUBLISHED content: "less than 51%" /
 * "51% or more" / "51% bar" -> the house wording "50% or less" / "more than
 * 50%" (Nelson v. Concrete Supply Co., 303 S.C. 243 (1991), signed SC
 * authority). Spanish: "del 50% o menos" / "de más del 50%". Follow-up to the
 * published batch (bin/apply-sc-comp-fault-50-wording-2026-11-11.php, PR #345)
 * and theme PR #342. Owner-approved 2026-11-11 ("do all of 2").
 *
 * Scope: post_status draft / pending / private / future, every post type (no
 * publish, trash, auto-draft, revisions or attachments). Any row whose post is
 * not in one of those statuses fails the preflight and nothing is written.
 *
 * Same rules as the published batch. Only South Carolina's rule changes;
 * Georgia's "less than 50%" (O.C.G.A. § 51-12-33) is untouched, and where a
 * sentence compares the states both sides now read right. True worked examples
 * stay ("If they find you 51% at fault, you take home zero", "push a rider to
 * 51%", "pin 51% of the blame"), as do statistics (GA workers' comp denials, the
 * road-type share of 2024 truck-crash deaths) and "you recover 51% of your damages". No new
 * legal claim and no § 15-38-15 cite for the SC rule. No retitles: no
 * unpublished title carries the wording.
 *
 * Surfaces: post_content (including inline FAQ microdata), post_excerpt,
 * _roden_faqs answers (feed FAQPage JSON-LD), _roden_key_takeaways. The scan
 * also covered post_title, _roden_meta_description, _roden_see_also, pillar
 * token fields and every other meta key; none of them carries the wording on
 * an unpublished post.
 *
 * Mechanics: the table below was generated from a read-only prod scan
 * (2026-11-11) and reviewed. Every anchor must match exactly once (or be
 * already applied) on every surface, and every changed field must pass the save
 * path unchanged (simulated kses/sanitisers, the pillar-link filter,
 * sanitize_meta), before anything is written; any miss aborts the whole run.
 * str_replace only. Backups of every changed field go to
 * uploads/roden-backups/<batch>/ before the first write; writes use wp_slash
 * on wp_update_post and update_post_meta; each post is read back from the
 * tables, and its post_status, post_name and post_parent must be unchanged.
 * The script NEVER changes a status: post_status is passed explicitly
 * (unchanged) and pinned by a last-priority filter. The location-freeze guard
 * only fires on a transition to publish, so it does not fire here.
 * _roden_content_modified is NOT stamped (the theme stamps published posts
 * only; see roden_record_content_change()).
 *
 * WordPress side effect to expect: wp_update_post() resets post_date to "now"
 * on a draft that has never had a date set (post_date_gmt 0000-00-00), exactly
 * as an editor save does. post_modified changes on every written post.
 *
 *   H=rodenlawprod@rodenlawprod.ssh.wpengine.net; P=/home/wpe-user/sites/rodenlawprod
 *   ssh $H "wp --path=$P eval-file -"       < bin/apply-sc-comp-fault-50-wording-drafts-2026-11-11.php   # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/apply-sc-comp-fault-50-wording-drafts-2026-11-11.php
 * then: wp cache flush && wp page-cache flush; php bin/check-unslashed-post-writes.php
 * (static) and piped to wp eval-file (live JSON-LD).
 */
$batch = 'sc-comp-fault-50-wording-drafts-2026-11-11';
$expected_rows = 422;
$table_json = <<<'EDITS'
[
 {
  "id": 1618,
  "field": "content",
  "find": "where you are assigned 51 percent or more liability, the state bars",
  "replace": "where you are assigned more than 50 percent liability, the state bars"
 },
 {
  "id": 3461,
  "field": "content",
  "find": "of the blame is 51% or more, <strong>you are legally ",
  "replace": "of the blame is more than 50%, <strong>you are legally "
 },
 {
  "id": 3461,
  "field": "content",
  "find": "recovering anything</strong>. This 51% bar is not just",
  "replace": "recovering anything</strong>. This more-than-50% bar is not just"
 },
 {
  "id": 3461,
  "field": "content",
  "find": "critical nature of the 51% threshold.</em></p>\n<p>This ",
  "replace": "critical nature of the more-than-50% threshold.</em></p>\n<p>This "
 },
 {
  "id": 3479,
  "field": "content",
  "find": "where you are assigned 51 percent or more liability, the state bars",
  "replace": "where you are assigned more than 50 percent liability, the state bars"
 },
 {
  "id": 3495,
  "field": "content",
  "find": "are found to be 51% or more at fault for the",
  "replace": "are found to be more than 50% at fault for the"
 },
 {
  "id": 3572,
  "field": "content",
  "find": "If you are assigned 51% or more of the blame, you",
  "replace": "If you are assigned more than 50% of the blame, you"
 },
 {
  "id": 3572,
  "field": "content",
  "find": "Brewer Law Firm, this 51% bar makes it essential",
  "replace": "Brewer Law Firm, this more-than-50% bar makes it essential"
 },
 {
  "id": 3572,
  "field": "content",
  "find": "claim against South Carolina's 51% fault rule. A <strong>Charleston ",
  "replace": "claim against South Carolina's comparative-fault rule. A <strong>Charleston "
 },
 {
  "id": 3626,
  "field": "content",
  "find": "not control.</p>\n<h3>The 51% Comparative-Fault Bar</h3>\n<p>South",
  "replace": "not control.</p>\n<h3>The More-Than-50% Comparative-Fault Bar</h3>\n<p>South"
 },
 {
  "id": 3626,
  "field": "content",
  "find": " as you are <strong>less than 51% responsible</strong>, with your",
  "replace": " as you are <strong>50% or less responsible</strong>, with your"
 },
 {
  "id": 3630,
  "field": "content",
  "find": "</strong>, and its <strong>51% modified comparative-fault</strong> rule lets",
  "replace": "</strong>, and its <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 3631,
  "field": "content",
  "find": "</strong>, and its <strong>51% modified comparative-fault</strong> rule lets",
  "replace": "</strong>, and its <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 3634,
  "field": "_roden_faqs:4:answer",
  "find": " fault. South Carolina uses 51% modified comparative fault, so",
  "replace": " fault. South Carolina uses modified comparative fault, so"
 },
 {
  "id": 3634,
  "field": "_roden_faqs:4:answer",
  "find": "eliminated unless your fault reaches 51%.",
  "replace": "eliminated unless your fault exceeds 50%."
 },
 {
  "id": 3634,
  "field": "content",
  "find": "3-Year Deadline and the 51% Bar</h3>\n<p>The statute",
  "replace": "3-Year Deadline and the More-Than-50% Bar</h3>\n<p>The statute"
 },
 {
  "id": 3634,
  "field": "content",
  "find": " and South Carolina's <strong>51% modified comparative fault</strong> rule",
  "replace": " and South Carolina's <strong>modified comparative fault</strong> rule"
 },
 {
  "id": 3635,
  "field": "_roden_faqs:3:answer",
  "find": " fault. South Carolina uses 51% modified comparative fault, so",
  "replace": " fault. South Carolina uses modified comparative fault, so"
 },
 {
  "id": 3635,
  "field": "_roden_faqs:3:answer",
  "find": "eliminated unless your fault reaches 51%. Insurers often exaggerate your",
  "replace": "eliminated unless your fault exceeds 50%. Insurers often exaggerate your"
 },
 {
  "id": 3635,
  "field": "content",
  "find": "3-Year Deadline and the 51% Bar</h3>\n<p>The statute",
  "replace": "3-Year Deadline and the More-Than-50% Bar</h3>\n<p>The statute"
 },
 {
  "id": 3635,
  "field": "content",
  "find": " and South Carolina's <strong>51% modified comparative fault</strong> rule",
  "replace": " and South Carolina's <strong>modified comparative fault</strong> rule"
 },
 {
  "id": 3636,
  "field": "_roden_faqs:4:answer",
  "find": " fault. South Carolina uses 51% modified comparative fault, so",
  "replace": " fault. South Carolina uses modified comparative fault, so"
 },
 {
  "id": 3636,
  "field": "_roden_faqs:4:answer",
  "find": "eliminated unless your fault reaches 51%.",
  "replace": "eliminated unless your fault exceeds 50%."
 },
 {
  "id": 3636,
  "field": "content",
  "find": "3-Year Deadline and the 51% Bar</h3>\n<p>The statute",
  "replace": "3-Year Deadline and the More-Than-50% Bar</h3>\n<p>The statute"
 },
 {
  "id": 3636,
  "field": "content",
  "find": " state. South Carolina's <strong>51% modified comparative fault</strong> rule",
  "replace": " state. South Carolina's <strong>modified comparative fault</strong> rule"
 },
 {
  "id": 3640,
  "field": "_roden_faqs:5:answer",
  "find": " fault. South Carolina uses 51% modified comparative fault, so",
  "replace": " fault. South Carolina uses modified comparative fault, so"
 },
 {
  "id": 3640,
  "field": "_roden_faqs:5:answer",
  "find": "not eliminated unless it reaches 51%. If the at-fault driver",
  "replace": "not eliminated unless it exceeds 50%. If the at-fault driver"
 },
 {
  "id": 3640,
  "field": "content",
  "find": "3-Year Deadline and the 51% Bar</h3>\n<p>The statute",
  "replace": "3-Year Deadline and the More-Than-50% Bar</h3>\n<p>The statute"
 },
 {
  "id": 3640,
  "field": "content",
  "find": " and South Carolina's <strong>51% modified comparative fault</strong> rule",
  "replace": " and South Carolina's <strong>modified comparative fault</strong> rule"
 },
 {
  "id": 3641,
  "field": "_roden_faqs:5:answer",
  "find": " fault. South Carolina uses 51% modified comparative fault, so",
  "replace": " fault. South Carolina uses modified comparative fault, so"
 },
 {
  "id": 3641,
  "field": "_roden_faqs:5:answer",
  "find": "not eliminated unless it reaches 51%. If the at-fault driver",
  "replace": "not eliminated unless it exceeds 50%. If the at-fault driver"
 },
 {
  "id": 3641,
  "field": "content",
  "find": "3-Year Deadline and the 51% Bar</h3>\n<p>The statute",
  "replace": "3-Year Deadline and the More-Than-50% Bar</h3>\n<p>The statute"
 },
 {
  "id": 3641,
  "field": "content",
  "find": " state. South Carolina's <strong>51% modified comparative fault</strong> rule",
  "replace": " state. South Carolina's <strong>modified comparative fault</strong> rule"
 },
 {
  "id": 3664,
  "field": "content",
  "find": "3 Years, and the 51% Fault Bar</h3>\n<p>The",
  "replace": "3 Years, and the More-Than-50% Fault Bar</h3>\n<p>The"
 },
 {
  "id": 3665,
  "field": "content",
  "find": "3 Years, and the 51% Fault Bar</h3>\n<p>The",
  "replace": "3 Years, and the More-Than-50% Fault Bar</h3>\n<p>The"
 },
 {
  "id": 3666,
  "field": "content",
  "find": "3 Years, and the 51% Fault Bar</h3>\n<p>The",
  "replace": "3 Years, and the More-Than-50% Fault Bar</h3>\n<p>The"
 },
 {
  "id": 3669,
  "field": "content",
  "find": " and South Carolina's <strong>51% modified comparative-fault</strong> rule lets",
  "replace": " and South Carolina's <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 3670,
  "field": "content",
  "find": " and South Carolina's <strong>51% modified comparative-fault</strong> rule lets",
  "replace": " and South Carolina's <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 3671,
  "field": "content",
  "find": " and South Carolina's <strong>51% modified comparative-fault</strong> rule lets",
  "replace": " and South Carolina's <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 3675,
  "field": "_roden_faqs:3:answer",
  "find": " South Carolina uses a 51% modified comparative-fault rule, so",
  "replace": " South Carolina uses a modified comparative-fault rule, so"
 },
 {
  "id": 3675,
  "field": "content",
  "find": "</strong>, South Carolina's <strong>51% modified comparative-fault</strong> rule lets",
  "replace": "</strong>, South Carolina's <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 3676,
  "field": "content",
  "find": "</strong>, South Carolina's <strong>51% modified comparative-fault</strong> rule lets",
  "replace": "</strong>, South Carolina's <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 3684,
  "field": "_roden_faqs:4:answer",
  "find": " South Carolina uses a 51% modified comparative-fault rule, so",
  "replace": " South Carolina uses a modified comparative-fault rule, so"
 },
 {
  "id": 3684,
  "field": "content",
  "find": "</strong>, South Carolina's <strong>51% modified comparative-fault</strong> rule lets",
  "replace": "</strong>, South Carolina's <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 3685,
  "field": "_roden_faqs:4:answer",
  "find": " South Carolina uses a 51% modified comparative-fault rule, so",
  "replace": " South Carolina uses a modified comparative-fault rule, so"
 },
 {
  "id": 3685,
  "field": "content",
  "find": "</strong>, South Carolina's <strong>51% modified comparative-fault</strong> rule lets",
  "replace": "</strong>, South Carolina's <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 3686,
  "field": "content",
  "find": "</strong>, South Carolina's <strong>51% modified comparative-fault</strong> rule lets",
  "replace": "</strong>, South Carolina's <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 3704,
  "field": "content",
  "find": "</strong>, and the <strong>51% comparative-fault</strong> rule applies. ",
  "replace": "</strong>, and the <strong>more-than-50% comparative-fault</strong> rule applies. "
 },
 {
  "id": 3705,
  "field": "content",
  "find": "</strong>, and the <strong>51% comparative-fault</strong> rule applies. ",
  "replace": "</strong>, and the <strong>more-than-50% comparative-fault</strong> rule applies. "
 },
 {
  "id": 3706,
  "field": "content",
  "find": "</strong>, and the <strong>51% comparative-fault</strong> rule applies. ",
  "replace": "</strong>, and the <strong>more-than-50% comparative-fault</strong> rule applies. "
 },
 {
  "id": 3709,
  "field": "_roden_faqs:2:answer",
  "find": " South Carolina uses a 51% modified comparative-fault rule, so",
  "replace": " South Carolina uses a modified comparative-fault rule, so"
 },
 {
  "id": 3709,
  "field": "content",
  "find": "recovery under South Carolina's 51% rule, and we make",
  "replace": "recovery under South Carolina's more-than-50% rule, and we make"
 },
 {
  "id": 3709,
  "field": "content",
  "find": " signal, South Carolina's <strong>51% modified comparative-fault</strong> rule lets",
  "replace": " signal, South Carolina's <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 3710,
  "field": "content",
  "find": "recovery under South Carolina's 51% rule.</li>\n<li><strong>Full-value ",
  "replace": "recovery under South Carolina's more-than-50% rule.</li>\n<li><strong>Full-value "
 },
 {
  "id": 3710,
  "field": "content",
  "find": " signal, South Carolina's <strong>51% modified comparative-fault</strong> rule lets",
  "replace": " signal, South Carolina's <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 3711,
  "field": "_roden_faqs:2:answer",
  "find": " South Carolina uses a 51% modified comparative-fault rule, so",
  "replace": " South Carolina uses a modified comparative-fault rule, so"
 },
 {
  "id": 3711,
  "field": "content",
  "find": "recovery under South Carolina's 51% rule.</li>\n<li><strong>Full-value ",
  "replace": "recovery under South Carolina's more-than-50% rule.</li>\n<li><strong>Full-value "
 },
 {
  "id": 3711,
  "field": "content",
  "find": " signal, South Carolina's <strong>51% modified comparative-fault</strong> rule lets",
  "replace": " signal, South Carolina's <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 4055,
  "field": "_roden_faqs:1:answer",
  "find": "Carolina allows recovery if less than 51% at fault. Your compensation",
  "replace": "Carolina allows recovery if 50% or less at fault. Your compensation"
 },
 {
  "id": 4055,
  "field": "content",
  "find": "if your fault is less than 51%. In pileup cases, fault",
  "replace": "if your fault is 50% or less. In pileup cases, fault"
 },
 {
  "id": 4062,
  "field": "content",
  "find": "only if you are 51% or more at fault.</p>\n\n<h2>Compensation",
  "replace": "only if you are more than 50% at fault.</p>\n\n<h2>Compensation"
 },
 {
  "id": 4071,
  "field": "content",
  "find": "standard barring recovery only at 51% or greater fault. Given the severity",
  "replace": "standard barring recovery only above 50% fault. Given the severity"
 },
 {
  "id": 4072,
  "field": "_roden_faqs:4:answer",
  "find": "(O.C.G.A. § 51-12-33) or less than 51% at fault in South",
  "replace": "(O.C.G.A. § 51-12-33) or 50% or less at fault in South"
 },
 {
  "id": 4072,
  "field": "content",
  "find": "are less than 50% (Georgia) or 51% (South Carolina) at fault.</p>",
  "replace": "are less than 50% at fault (Georgia) or 50% or less at fault (South Carolina).</p>"
 },
 {
  "id": 4079,
  "field": "_roden_faqs:2:answer",
  "find": "than 50% (GA) or 51% (SC).",
  "replace": "than 50% (GA) or 50% or less (SC)."
 },
 {
  "id": 4093,
  "field": "content",
  "find": "recovery if you are less than 51% at fault. Our attorneys",
  "replace": "recovery if you are 50% or less at fault. Our attorneys"
 },
 {
  "id": 4094,
  "field": "_roden_faqs:4:answer",
  "find": "recovery if you are less than 51% at fault.",
  "replace": "recovery if you are 50% or less at fault."
 },
 {
  "id": 4094,
  "field": "content",
  "find": "South Carolina's threshold is 51%.</p>\n\n<h2>Contact Roden Law",
  "replace": "South Carolina's threshold is more than 50%.</p>\n\n<h2>Contact Roden Law"
 },
 {
  "id": 4131,
  "field": "content",
  "find": "South Carolina's threshold is 51%.</p>\n\n<h2>Crashworthiness and Enhanced",
  "replace": "South Carolina's threshold is more than 50%.</p>\n\n<h2>Crashworthiness and Enhanced"
 },
 {
  "id": 4139,
  "field": "content",
  "find": "recovery if you are less than 51% at fault.</p>\n\n<h2>Pursuing",
  "replace": "recovery if you are 50% or less at fault.</p>\n\n<h2>Pursuing"
 },
 {
  "id": 4140,
  "field": "content",
  "find": "recovery if you are less than 51% responsible. Contact Roden Law",
  "replace": "recovery if you are 50% or less responsible. Contact Roden Law"
 },
 {
  "id": 4142,
  "field": "content",
  "find": "Carolina allows recovery if less than 51% at fault. In cases",
  "replace": "Carolina allows recovery if 50% or less at fault. In cases"
 },
 {
  "id": 4143,
  "field": "content",
  "find": "if your fault is less than 51%. Our attorneys fight to",
  "replace": "if your fault is 50% or less. Our attorneys fight to"
 },
 {
  "id": 4156,
  "field": "content",
  "find": "Carolina permits recovery if less than 51% at fault. In cases",
  "replace": "Carolina permits recovery if 50% or less at fault. In cases"
 },
 {
  "id": 4159,
  "field": "content",
  "find": "Carolina allows recovery if less than 51% at fault. Our attorneys",
  "replace": "Carolina allows recovery if 50% or less at fault. Our attorneys"
 },
 {
  "id": 4161,
  "field": "content",
  "find": "Carolina allows recovery if less than 51%. Contact Roden Law for",
  "replace": "Carolina allows recovery if 50% or less. Contact Roden Law for"
 },
 {
  "id": 4208,
  "field": "content",
  "find": "recovery when you are less than 51% at fault. Your compensation",
  "replace": "recovery when you are 50% or less at fault. Your compensation"
 },
 {
  "id": 4209,
  "field": "content",
  "find": "Carolina allows recovery if less than 51% at fault.</p>\n\n<h2>Filing",
  "replace": "Carolina allows recovery if 50% or less at fault.</p>\n\n<h2>Filing"
 },
 {
  "id": 4211,
  "field": "content",
  "find": "South Carolina's threshold is 51%.</p>\n\n<h2>Filing Deadlines</h2>\n",
  "replace": "South Carolina's threshold is more than 50%.</p>\n\n<h2>Filing Deadlines</h2>\n"
 },
 {
  "id": 4212,
  "field": "content",
  "find": "South Carolina's threshold is 51%.</p>\n\n<h2>Filing Deadlines</h2>\n",
  "replace": "South Carolina's threshold is more than 50%.</p>\n\n<h2>Filing Deadlines</h2>\n"
 },
 {
  "id": 4234,
  "field": "content",
  "find": " Carolina uses a <strong>51% modified comparative-fault</strong> rule and",
  "replace": " Carolina uses a <strong>modified comparative-fault</strong> rule and"
 },
 {
  "id": 4235,
  "field": "content",
  "find": " Carolina uses a <strong>51% modified comparative-fault</strong> rule and",
  "replace": " Carolina uses a <strong>modified comparative-fault</strong> rule and"
 },
 {
  "id": 4236,
  "field": "content",
  "find": " Carolina uses a <strong>51% modified comparative-fault</strong> rule and",
  "replace": " Carolina uses a <strong>modified comparative-fault</strong> rule and"
 },
 {
  "id": 4338,
  "field": "_roden_faqs:3:answer",
  "find": "as your fault is less than 51%. Your compensation is reduced",
  "replace": "as your fault is 50% or less. Your compensation is reduced"
 },
 {
  "id": 4338,
  "field": "_roden_key_takeaways",
  "find": "fault rule bars recovery at 51% or more fault, and the three-year",
  "replace": "fault rule bars recovery above 50% fault, and the three-year"
 },
 {
  "id": 4338,
  "field": "content",
  "find": "as your fault is less than 51%. Your recovery is reduced",
  "replace": "as your fault is 50% or less. Your recovery is reduced"
 },
 {
  "id": 4339,
  "field": "_roden_faqs:1:answer",
  "find": "as your fault is less than 51%. Even if you were",
  "replace": "as your fault is 50% or less. Even if you were"
 },
 {
  "id": 4339,
  "field": "_roden_key_takeaways",
  "find": "damages if they are less than 51% at fault. The three-year",
  "replace": "damages if they are 50% or less at fault. The three-year"
 },
 {
  "id": 4339,
  "field": "content",
  "find": "their own fault is less than 51%. Insurance companies in pedestrian",
  "replace": "their own fault is 50% or less. Insurance companies in pedestrian"
 },
 {
  "id": 4346,
  "field": "_roden_faqs:3:answer",
  "find": "if your fault is less than 51 percent. In multi-vehicle crashes common",
  "replace": "if your fault is 50 percent or less. In multi-vehicle crashes common"
 },
 {
  "id": 4346,
  "field": "_roden_key_takeaways",
  "find": "comparative fault bars recovery at 51% or more.",
  "replace": "comparative fault bars recovery above 50%."
 },
 {
  "id": 4346,
  "field": "content",
  "find": "if your fault is less than 51%. In multi-vehicle crashes —",
  "replace": "if your fault is 50% or less. In multi-vehicle crashes —"
 },
 {
  "id": 4347,
  "field": "_roden_key_takeaways",
  "find": "comparative fault barring recovery at 51% or more.",
  "replace": "comparative fault barring recovery above 50%."
 },
 {
  "id": 4347,
  "field": "content",
  "find": "if your fault is less than 51%. In Georgia, the threshold",
  "replace": "if your fault is 50% or less. In Georgia, the threshold"
 },
 {
  "id": 4353,
  "field": "_roden_faqs:4:answer",
  "find": "if your fault is less than 51 percent. Georgia requires less than",
  "replace": "if your fault is 50 percent or less. Georgia requires less than"
 },
 {
  "id": 4353,
  "field": "_roden_key_takeaways",
  "find": "comparative fault bars recovery at 51% or more.",
  "replace": "comparative fault bars recovery above 50%."
 },
 {
  "id": 4353,
  "field": "content",
  "find": " of fault is <strong>less than 51%</strong>. Your damages are",
  "replace": " of fault is <strong>50% or less</strong>. Your damages are"
 },
 {
  "id": 4353,
  "field": "content",
  "find": "as your fault is less than 51%. Your recovery is reduced",
  "replace": "as your fault is 50% or less. Your recovery is reduced"
 },
 {
  "id": 4354,
  "field": "_roden_faqs:4:answer",
  "find": "if your fault is less than 51 percent (Nelson v. Concrete Supply",
  "replace": "if your fault is 50 percent or less (Nelson v. Concrete Supply"
 },
 {
  "id": 4354,
  "field": "_roden_key_takeaways",
  "find": "comparative fault bars recovery at 51% or more. Georgia claims carry a",
  "replace": "comparative fault bars recovery above 50%. Georgia claims carry a"
 },
 {
  "id": 4354,
  "field": "content",
  "find": " your fault is <strong>less than 51%</strong> (Nelson v. Concrete ",
  "replace": " your fault is <strong>50% or less</strong> (Nelson v. Concrete "
 },
 {
  "id": 4354,
  "field": "content",
  "find": "your own fault is less than 51%.</p>\n\n<h3>How long do",
  "replace": "your own fault is 50% or less.</p>\n\n<h3>How long do"
 },
 {
  "id": 4364,
  "field": "_roden_faqs:4:answer",
  "find": "if your fault is less than 51 percent.",
  "replace": "if your fault is 50 percent or less."
 },
 {
  "id": 4364,
  "field": "_roden_key_takeaways",
  "find": "comparative fault bars recovery at 51% or more, with a three-year filing",
  "replace": "comparative fault bars recovery above 50%, with a three-year filing"
 },
 {
  "id": 4364,
  "field": "content",
  "find": "But if they are 51% or more at fault, they recover",
  "replace": "But if they are more than 50% at fault, they recover"
 },
 {
  "id": 4365,
  "field": "_roden_faqs:5:answer",
  "find": "if your fault is less than 51 percent.",
  "replace": "if your fault is 50 percent or less."
 },
 {
  "id": 4365,
  "field": "_roden_key_takeaways",
  "find": "South Carolina bars recovery at 51% comparative fault, with a",
  "replace": "South Carolina bars recovery above 50% comparative fault, with a"
 },
 {
  "id": 4365,
  "field": "content",
  "find": " of fault is <strong>less than 51%</strong>. Your compensation is",
  "replace": " of fault is <strong>50% or less</strong>. Your compensation is"
 },
 {
  "id": 4365,
  "field": "content",
  "find": "if you are found 51% or more at fault, you recover",
  "replace": "if you are found more than 50% at fault, you recover"
 },
 {
  "id": 4365,
  "field": "content",
  "find": "as your fault is less than 51% under South Carolina law",
  "replace": "as your fault is 50% or less under South Carolina law"
 },
 {
  "id": 4366,
  "field": "_roden_faqs:3:answer",
  "find": "if your fault is less than 51 percent.",
  "replace": "if your fault is 50 percent or less."
 },
 {
  "id": 4366,
  "field": "_roden_key_takeaways",
  "find": "comparative fault bars recovery at 51% or more fault, with a three-year",
  "replace": "comparative fault bars recovery above 50% fault, with a three-year"
 },
 {
  "id": 4366,
  "field": "content",
  "find": " your fault is <strong>less than 51%</strong>. If you are 51% or more at fault, you recover",
  "replace": " your fault is <strong>50% or less</strong>. If you are more than 50% at fault, you recover"
 },
 {
  "id": 4366,
  "field": "content",
  "find": "share of fault is less than 51%. Your award is reduced",
  "replace": "share of fault is 50% or less. Your award is reduced"
 },
 {
  "id": 4370,
  "field": "_roden_faqs:4:answer",
  "find": "if your fault is less than 51 percent.",
  "replace": "if your fault is 50 percent or less."
 },
 {
  "id": 4370,
  "field": "_roden_key_takeaways",
  "find": "fault rule bars recovery at 51% or more fault, and the filing",
  "replace": "fault rule bars recovery above 50% fault, and the filing"
 },
 {
  "id": 4370,
  "field": "content",
  "find": " of fault is <strong>less than 51%</strong>. Your recovery is",
  "replace": " of fault is <strong>50% or less</strong>. Your recovery is"
 },
 {
  "id": 4370,
  "field": "content",
  "find": "long as you are less than 51% at fault. Your award",
  "replace": "long as you are 50% or less at fault. Your award"
 },
 {
  "id": 4541,
  "field": "content",
  "find": "</strong>, and its <strong>51% modified comparative-fault</strong> rule lets",
  "replace": "</strong>, and its <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 4542,
  "field": "_roden_faqs:4:answer",
  "find": " fault. South Carolina uses 51% modified comparative fault, so",
  "replace": " fault. South Carolina uses modified comparative fault, so"
 },
 {
  "id": 4542,
  "field": "_roden_faqs:4:answer",
  "find": "eliminated unless your fault reaches 51%.",
  "replace": "eliminated unless your fault exceeds 50%."
 },
 {
  "id": 4542,
  "field": "content",
  "find": "3-Year Deadline and the 51% Bar</h3>\n<p>The statute",
  "replace": "3-Year Deadline and the More-Than-50% Bar</h3>\n<p>The statute"
 },
 {
  "id": 4542,
  "field": "content",
  "find": " and South Carolina's <strong>51% modified comparative fault</strong> rule",
  "replace": " and South Carolina's <strong>modified comparative fault</strong> rule"
 },
 {
  "id": 4543,
  "field": "_roden_faqs:5:answer",
  "find": " fault. South Carolina uses 51% modified comparative fault, so",
  "replace": " fault. South Carolina uses modified comparative fault, so"
 },
 {
  "id": 4543,
  "field": "_roden_faqs:5:answer",
  "find": "not eliminated unless it reaches 51%. If the at-fault driver",
  "replace": "not eliminated unless it exceeds 50%. If the at-fault driver"
 },
 {
  "id": 4543,
  "field": "content",
  "find": "3-Year Deadline and the 51% Bar</h3>\n<p>The statute",
  "replace": "3-Year Deadline and the More-Than-50% Bar</h3>\n<p>The statute"
 },
 {
  "id": 4543,
  "field": "content",
  "find": " and South Carolina's <strong>51% modified comparative fault</strong> rule",
  "replace": " and South Carolina's <strong>modified comparative fault</strong> rule"
 },
 {
  "id": 4548,
  "field": "content",
  "find": "3 Years, and the 51% Fault Bar</h3>\n<p>The",
  "replace": "3 Years, and the More-Than-50% Fault Bar</h3>\n<p>The"
 },
 {
  "id": 4549,
  "field": "content",
  "find": " and South Carolina's <strong>51% modified comparative-fault</strong> rule lets",
  "replace": " and South Carolina's <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 4552,
  "field": "_roden_faqs:4:answer",
  "find": " South Carolina uses a 51% modified comparative-fault rule, so",
  "replace": " South Carolina uses a modified comparative-fault rule, so"
 },
 {
  "id": 4552,
  "field": "content",
  "find": "</strong>, South Carolina's <strong>51% modified comparative-fault</strong> rule lets",
  "replace": "</strong>, South Carolina's <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 4556,
  "field": "content",
  "find": "</strong>, and the <strong>51% comparative-fault</strong> rule applies. ",
  "replace": "</strong>, and the <strong>more-than-50% comparative-fault</strong> rule applies. "
 },
 {
  "id": 4557,
  "field": "_roden_faqs:2:answer",
  "find": " South Carolina uses a 51% modified comparative-fault rule, so",
  "replace": " South Carolina uses a modified comparative-fault rule, so"
 },
 {
  "id": 4557,
  "field": "content",
  "find": "recovery under South Carolina's 51% rule.</li>\n<li><strong>Full-value ",
  "replace": "recovery under South Carolina's more-than-50% rule.</li>\n<li><strong>Full-value "
 },
 {
  "id": 4557,
  "field": "content",
  "find": " signal, South Carolina's <strong>51% modified comparative-fault</strong> rule lets",
  "replace": " signal, South Carolina's <strong>modified comparative-fault</strong> rule lets"
 },
 {
  "id": 4558,
  "field": "content",
  "find": " Carolina uses a <strong>51% modified comparative-fault</strong> rule and",
  "replace": " Carolina uses a <strong>modified comparative-fault</strong> rule and"
 },
 {
  "id": 4624,
  "field": "content",
  "find": "damages if you were less than 51% at fault — your",
  "replace": "damages if you were 50% or less at fault — your"
 },
 {
  "id": 4625,
  "field": "content",
  "find": "recovery if you are less than 51% at fault.</p>\n\n<h2>Free",
  "replace": "recovery if you are 50% or less at fault.</p>\n\n<h2>Free"
 },
 {
  "id": 4642,
  "field": "_roden_key_takeaways",
  "find": "rule if they are less than 51% at fault, with a",
  "replace": "rule if they are 50% or less at fault, with a"
 },
 {
  "id": 4642,
  "field": "content",
  "find": "long as you were less than 51% at fault. The <strong>",
  "replace": "long as you were 50% or less at fault. The <strong>"
 },
 {
  "id": 4654,
  "field": "_roden_faqs:4:answer",
  "find": "long as you are less than 51% at fault. Your compensation",
  "replace": "long as you are 50% or less at fault. Your compensation"
 },
 {
  "id": 4654,
  "field": "_roden_key_takeaways",
  "find": ") with recovery if less than <strong>51% at fault</strong>.",
  "replace": ") with recovery if <strong>50% or less at fault</strong>."
 },
 {
  "id": 4654,
  "field": "content",
  "find": "damages if you are less than 51% at fault — your",
  "replace": "damages if you are 50% or less at fault — your"
 },
 {
  "id": 4655,
  "field": "_roden_key_takeaways",
  "find": ") with recovery if less than <strong>51% at fault</strong>.",
  "replace": ") with recovery if <strong>50% or less at fault</strong>."
 },
 {
  "id": 4655,
  "field": "content",
  "find": "damages if you are less than 51% at fault — your",
  "replace": "damages if you are 50% or less at fault — your"
 },
 {
  "id": 4661,
  "field": "_roden_key_takeaways",
  "find": ") with recovery if less than <strong>51% at fault</strong>.",
  "replace": ") with recovery if <strong>50% or less at fault</strong>."
 },
 {
  "id": 4661,
  "field": "content",
  "find": "compensation if you are less than 51% at fault for the",
  "replace": "compensation if you are 50% or less at fault for the"
 },
 {
  "id": 4663,
  "field": "_roden_key_takeaways",
  "find": ") with recovery if less than <strong>51% at fault</strong>.",
  "replace": ") with recovery if <strong>50% or less at fault</strong>."
 },
 {
  "id": 4663,
  "field": "content",
  "find": "allowed if you are less than 51% at fault</li><li><strong>Punitive",
  "replace": "allowed if you are 50% or less at fault</li><li><strong>Punitive"
 },
 {
  "id": 4664,
  "field": "_roden_faqs:4:answer",
  "find": "recovery if you are less than 51% at fault.",
  "replace": "recovery if you are 50% or less at fault."
 },
 {
  "id": 4664,
  "field": "_roden_key_takeaways",
  "find": ") with recovery if less than <strong>51% at fault</strong>.",
  "replace": ") with recovery if <strong>50% or less at fault</strong>."
 },
 {
  "id": 4664,
  "field": "content",
  "find": "recovery if you are less than 51% at fault. Your compensation",
  "replace": "recovery if you are 50% or less at fault. Your compensation"
 },
 {
  "id": 4665,
  "field": "content",
  "find": "</strong> Recovery permitted if less than 51% at fault — damages",
  "replace": "</strong> Recovery permitted if 50% or less at fault — damages"
 },
 {
  "id": 4674,
  "field": "_roden_key_takeaways",
  "find": ") with recovery if less than <strong>51% at fault</strong>.",
  "replace": ") with recovery if <strong>50% or less at fault</strong>."
 },
 {
  "id": 4674,
  "field": "content",
  "find": "recovery if you are less than 51% at fault. Your compensation",
  "replace": "recovery if you are 50% or less at fault. Your compensation"
 },
 {
  "id": 4675,
  "field": "_roden_key_takeaways",
  "find": ") with recovery if less than <strong>51% at fault</strong>.",
  "replace": ") with recovery if <strong>50% or less at fault</strong>."
 },
 {
  "id": 4675,
  "field": "content",
  "find": "recovery if you are less than 51% at fault. Compensation is",
  "replace": "recovery if you are 50% or less at fault. Compensation is"
 },
 {
  "id": 4676,
  "field": "_roden_key_takeaways",
  "find": ") with recovery if less than <strong>51% at fault</strong>.",
  "replace": ") with recovery if <strong>50% or less at fault</strong>."
 },
 {
  "id": 4676,
  "field": "content",
  "find": "recovery if you are less than 51% at fault. Compensation is",
  "replace": "recovery if you are 50% or less at fault. Compensation is"
 },
 {
  "id": 4677,
  "field": "_roden_key_takeaways",
  "find": ") with recovery if less than <strong>51% at fault</strong>.",
  "replace": ") with recovery if <strong>50% or less at fault</strong>."
 },
 {
  "id": 4677,
  "field": "content",
  "find": "recovery if you are less than 51% at fault. Compensation is",
  "replace": "recovery if you are 50% or less at fault. Compensation is"
 },
 {
  "id": 4679,
  "field": "_roden_key_takeaways",
  "find": ") with recovery if less than <strong>51% at fault</strong>.",
  "replace": ") with recovery if <strong>50% or less at fault</strong>."
 },
 {
  "id": 4679,
  "field": "content",
  "find": "recovery if you are less than 51% at fault. Your compensation",
  "replace": "recovery if you are 50% or less at fault. Your compensation"
 },
 {
  "id": 4680,
  "field": "_roden_key_takeaways",
  "find": ") with recovery if less than <strong>51% at fault</strong>.",
  "replace": ") with recovery if <strong>50% or less at fault</strong>."
 },
 {
  "id": 4680,
  "field": "content",
  "find": "recovery if you are less than 51% at fault. Your compensation",
  "replace": "recovery if you are 50% or less at fault. Your compensation"
 },
 {
  "id": 4681,
  "field": "_roden_faqs:4:answer",
  "find": "recovery if you are less than 51% at fault.",
  "replace": "recovery if you are 50% or less at fault."
 },
 {
  "id": 4681,
  "field": "_roden_key_takeaways",
  "find": ") with recovery if less than <strong>51% at fault</strong>.",
  "replace": ") with recovery if <strong>50% or less at fault</strong>."
 },
 {
  "id": 4681,
  "field": "content",
  "find": "recovery if you are less than 51% at fault. Your compensation",
  "replace": "recovery if you are 50% or less at fault. Your compensation"
 },
 {
  "id": 4682,
  "field": "_roden_key_takeaways",
  "find": ") with recovery if less than <strong>51% at fault</strong>.",
  "replace": ") with recovery if <strong>50% or less at fault</strong>."
 },
 {
  "id": 4682,
  "field": "content",
  "find": "recovery if you are less than 51% at fault. Your compensation",
  "replace": "recovery if you are 50% or less at fault. Your compensation"
 },
 {
  "id": 4685,
  "field": "_roden_key_takeaways",
  "find": "and allows recovery if less than <strong>51% at fault</strong>. Claims",
  "replace": "and allows recovery if <strong>50% or less at fault</strong>. Claims"
 },
 {
  "id": 4685,
  "field": "content",
  "find": " if you are <strong>less than 51% at fault</strong>. Your",
  "replace": " if you are <strong>50% or less at fault</strong>. Your"
 },
 {
  "id": 4690,
  "field": "_roden_key_takeaways",
  "find": "and allows recovery if less than <strong>51% at fault</strong>. Contact",
  "replace": "and allows recovery if <strong>50% or less at fault</strong>. Contact"
 },
 {
  "id": 4690,
  "field": "content",
  "find": " if you are <strong>less than 51% at fault</strong>. Your",
  "replace": " if you are <strong>50% or less at fault</strong>. Your"
 },
 {
  "id": 4704,
  "field": "_roden_faqs:4:answer",
  "find": "reduced by your share. At 51% or more you recover nothing. A",
  "replace": "reduced by your share. Above 50% you recover nothing. A"
 },
 {
  "id": 4704,
  "field": "content",
  "find": "or less at fault; at 51%, nothing. A back-seat rideshare",
  "replace": "or less at fault; above 50%, nothing. A back-seat rideshare"
 },
 {
  "id": 4707,
  "field": "_roden_faqs:1:answer",
  "find": "comparative negligence with a 51% bar under Nelson v.",
  "replace": "comparative negligence with a more-than-50% bar under Nelson v."
 },
 {
  "id": 4707,
  "field": "_roden_faqs:1:answer",
  "find": " At 51% or more, you recover nothing.",
  "replace": " Above 50%, you recover nothing."
 },
 {
  "id": 4707,
  "field": "content",
  "find": "negligence state with a 51% bar (Nelson v. Concrete",
  "replace": "negligence state with a more-than-50% bar (Nelson v. Concrete"
 },
 {
  "id": 4707,
  "field": "content",
  "find": "Comparative fault — the 51% bar</h3>\nSouth Carolina ",
  "replace": "Comparative fault — the more-than-50% bar</h3>\nSouth Carolina "
 },
 {
  "id": 4711,
  "field": "_roden_faqs:2:answer",
  "find": "a jury finds you 51% or more at fault, however, you",
  "replace": "a jury finds you more than 50% at fault, however, you"
 },
 {
  "id": 4711,
  "field": "content",
  "find": "<strong>South Carolina is a 51% modified-comparative-fault state</strong> under ",
  "replace": "<strong>South Carolina is a modified-comparative-fault state</strong> under "
 },
 {
  "id": 4711,
  "field": "content",
  "find": "Modified comparative fault — 51% bar.</strong> South Carolina follows a 51% modified-comparative-negligence rule under <strong>",
  "replace": "Modified comparative fault — more-than-50% bar.</strong> South Carolina follows a modified-comparative-negligence rule under <strong>"
 },
 {
  "id": 4711,
  "field": "content",
  "find": "fault. If you are 51% or more at fault, you recover",
  "replace": "fault. If you are more than 50% at fault, you recover"
 },
 {
  "id": 4711,
  "field": "content",
  "find": "fault — see the 51% bar above.</li>\n \t<li><strong>",
  "replace": "fault — see the more-than-50% bar above.</li>\n \t<li><strong>"
 },
 {
  "id": 4713,
  "field": "_roden_faqs:4:answer",
  "find": "recovery under South Carolina's 51% comparative-fault bar in Nelson",
  "replace": "recovery under South Carolina's more-than-50% comparative-fault bar in Nelson"
 },
 {
  "id": 4713,
  "field": "content",
  "find": "comparative negligence with a 51% bar</strong> under <strong>Nelson",
  "replace": "comparative negligence with a more-than-50% bar</strong> under <strong>Nelson"
 },
 {
  "id": 4713,
  "field": "content",
  "find": "reduction?</td>\n<td>Yes — 51% bar (Nelson v. Concrete",
  "replace": "reduction?</td>\n<td>Yes — more-than-50% bar (Nelson v. Concrete"
 },
 {
  "id": 4717,
  "field": "_roden_faqs:1:answer",
  "find": "share of fault stays below 51%.",
  "replace": "share of fault stays at or below 50%."
 },
 {
  "id": 4717,
  "field": "content",
  "find": "comparative-fault state with a 51% bar</strong> (Nelson v. ",
  "replace": "comparative-fault state with a more-than-50% bar</strong> (Nelson v. "
 },
 {
  "id": 4717,
  "field": "content",
  "find": "your fault percentage above 51% to trigger the bar",
  "replace": "your fault percentage above 50% to trigger the bar"
 },
 {
  "id": 4723,
  "field": "_roden_faqs:4:answer",
  "find": "South Carolina uses a 51% modified comparative-negligence bar under",
  "replace": "South Carolina uses a more-than-50% modified comparative-negligence bar under"
 },
 {
  "id": 4723,
  "field": "_roden_faqs:4:answer",
  "find": "cyclist, or pedestrian found 51% or more at fault recovers nothing.",
  "replace": "cyclist, or pedestrian found more than 50% at fault recovers nothing."
 },
 {
  "id": 4723,
  "field": "content",
  "find": " Carolina uses a <strong>51% modified comparative-negligence bar</strong> ",
  "replace": " Carolina uses a <strong>more-than-50% modified comparative-negligence bar</strong> "
 },
 {
  "id": 4725,
  "field": "_roden_faqs:4:answer",
  "find": "Not unless you were 51% or more at fault. South Carolina",
  "replace": "Not unless you were more than 50% at fault. South Carolina"
 },
 {
  "id": 4725,
  "field": "_roden_faqs:4:answer",
  "find": "your share of fault. At 51% or more, recovery is barred. Insurance",
  "replace": "your share of fault. Above 50%, recovery is barred. Insurance"
 },
 {
  "id": 4725,
  "field": "content",
  "find": " Carolina uses a <strong>51% modified comparative negligence</strong> rule",
  "replace": " Carolina uses a <strong>modified comparative negligence</strong> rule"
 },
 {
  "id": 4725,
  "field": "content",
  "find": "* SC follows a 51% modified comparative-negligence rule. You ",
  "replace": "* SC follows a modified comparative-negligence rule. You "
 },
 {
  "id": 4725,
  "field": "content",
  "find": "proportionally; recovery is barred at 51% or more. See <a href=\"https://rodenlaw.com/blog/south-carolina-comparative-fault-partially-at-fault/\">South Carolina's 51% modified comparative negligence rule",
  "replace": "proportionally; recovery is barred above 50%. See <a href=\"https://rodenlaw.com/blog/south-carolina-comparative-fault-partially-at-fault/\">South Carolina's modified comparative negligence rule"
 },
 {
  "id": 4727,
  "field": "_roden_faqs:3:answer",
  "find": "South Carolina uses the 51% modified comparative-negligence rule from",
  "replace": "South Carolina uses the modified comparative-negligence rule from"
 },
 {
  "id": 4727,
  "field": "content",
  "find": "<li><strong>SC applies the 51% modified comparative-negligence bar</strong> ",
  "replace": "<li><strong>SC applies the more-than-50% modified comparative-negligence bar</strong> "
 },
 {
  "id": 4727,
  "field": "content",
  "find": " rule with a <strong>51% bar</strong> — <em>Nelson",
  "replace": " rule with a <strong>more-than-50% bar</strong> — <em>Nelson"
 },
 {
  "id": 4729,
  "field": "_roden_faqs:3:answer",
  "find": "comparative negligence with a 51% bar under Nelson v.",
  "replace": "comparative negligence with a more-than-50% bar under Nelson v."
 },
 {
  "id": 4729,
  "field": "_roden_faqs:3:answer",
  "find": "damages drop by 20%. At 51% or higher you recover nothing —",
  "replace": "damages drop by 20%. Above 50% you recover nothing —"
 },
 {
  "id": 4729,
  "field": "content",
  "find": "<li><strong>Fault rule:</strong> <strong>51% modified comparative negligence</strong> —",
  "replace": "<li><strong>Fault rule:</strong> <strong>modified comparative negligence</strong> —"
 },
 {
  "id": 4729,
  "field": "content",
  "find": "comparative negligence with a 51% bar</strong>, set in",
  "replace": "comparative negligence with a more-than-50% bar</strong>, set in"
 },
 {
  "id": 4729,
  "field": "content",
  "find": "reduced by your percentage; at 51%+ you take nothing. This",
  "replace": "reduced by your percentage; above 50% you take nothing. This"
 },
 {
  "id": 4729,
  "field": "content",
  "find": "push you across the 51% line. Read more on <a href=\"/blog/south-carolina-comparative-fault-partially-at-fault/\">South Carolina's 51% modified comparative-fault rule</a>.",
  "replace": "push you across the 50% line. Read more on <a href=\"/blog/south-carolina-comparative-fault-partially-at-fault/\">South Carolina's modified comparative-fault rule</a>."
 },
 {
  "id": 4731,
  "field": "content",
  "find": "Comparative negligence — the 51% bar</h3>\n<p>South Carolina",
  "replace": "Comparative negligence — the more-than-50% bar</h3>\n<p>South Carolina"
 },
 {
  "id": 4733,
  "field": "content",
  "find": "243 (1991) — fault under 51% still recovers, reduced by",
  "replace": "243 (1991) — fault of 50% or less still recovers, reduced by"
 },
 {
  "id": 4735,
  "field": "_roden_faqs:2:answer",
  "find": "by your fault percentage. At 51% or more, recovery is barred entirely",
  "replace": "by your fault percentage. Above 50%, recovery is barred entirely"
 },
 {
  "id": 4738,
  "field": "_roden_faqs:3:answer",
  "find": "reduced by your percentage. Cross 51% and recovery is barred.",
  "replace": "reduced by your percentage. Go above 50% and recovery is barred."
 },
 {
  "id": 4738,
  "field": "content",
  "find": "reduced by your percentage. Cross 51% and you recover nothing.",
  "replace": "reduced by your percentage. Go above 50% and you recover nothing."
 },
 {
  "id": 4748,
  "field": "_roden_faqs:2:answer",
  "find": "negligence rule with a 51% bar, set in Nelson",
  "replace": "negligence rule with a more-than-50% bar, set in Nelson"
 },
 {
  "id": 4748,
  "field": "content",
  "find": "</li>\n<li>South Carolina&#39;s <strong>51% modified comparative negligence</strong> rule",
  "replace": "</li>\n<li>South Carolina&#39;s <strong>modified comparative negligence</strong> rule"
 },
 {
  "id": 4748,
  "field": "content",
  "find": "reduced by your share (51% bar)</td>\n<td>Nelson v.",
  "replace": "reduced by your share (more-than-50% bar)</td>\n<td>Nelson v."
 },
 {
  "id": 4748,
  "field": "content",
  "find": "negligence rule with a 51% bar, established in Nelson",
  "replace": "negligence rule with a more-than-50% bar, established in Nelson"
 },
 {
  "id": 4750,
  "field": "_roden_faqs:2:answer",
  "find": "comparative negligence with a 51% bar under Nelson v.",
  "replace": "comparative negligence with a more-than-50% bar under Nelson v."
 },
 {
  "id": 4750,
  "field": "content",
  "find": "comparative negligence with a 51% bar</strong> (Nelson v. ",
  "replace": "comparative negligence with a more-than-50% bar</strong> (Nelson v. "
 },
 {
  "id": 4750,
  "field": "content",
  "find": "comparative negligence with a 51% bar, established in Nelson",
  "replace": "comparative negligence with a more-than-50% bar, established in Nelson"
 },
 {
  "id": 4752,
  "field": "_roden_faqs:1:answer",
  "find": "push them over the 51% bar, which is why",
  "replace": "push them over the more-than-50% bar, which is why"
 },
 {
  "id": 4752,
  "field": "content",
  "find": "</li>\n<li>Under SC&#39;s <strong>51% modified comparative negligence</strong> rule",
  "replace": "</li>\n<li>Under SC&#39;s <strong>modified comparative negligence</strong> rule"
 },
 {
  "id": 4752,
  "field": "content",
  "find": "comparative negligence with a 51% bar, established in <em>",
  "replace": "comparative negligence with a more-than-50% bar, established in <em>"
 },
 {
  "id": 4754,
  "field": "_roden_faqs:1:answer",
  "find": "comparative negligence with a 51% bar (Nelson v. Concrete",
  "replace": "comparative negligence with a more-than-50% bar (Nelson v. Concrete"
 },
 {
  "id": 4754,
  "field": "content",
  "find": "comparative negligence with a 51% bar</strong> — you ",
  "replace": "comparative negligence with a more-than-50% bar</strong> — you "
 },
 {
  "id": 4754,
  "field": "content",
  "find": "\n<td>Modified comparative negligence, 51% bar (Nelson v. Concrete",
  "replace": "\n<td>Modified comparative negligence, more-than-50% bar (Nelson v. Concrete"
 },
 {
  "id": 4760,
  "field": "_roden_faqs:3:answer",
  "find": "comparative negligence with a 51% bar, so your family",
  "replace": "comparative negligence with a more-than-50% bar, so your family"
 },
 {
  "id": 4760,
  "field": "content",
  "find": "comparative negligence with a 51% bar</strong> — your ",
  "replace": "comparative negligence with a more-than-50% bar</strong> — your "
 },
 {
  "id": 4760,
  "field": "content",
  "find": "comparative negligence with a 51% bar</strong>. Your family",
  "replace": "comparative negligence with a more-than-50% bar</strong>. Your family"
 },
 {
  "id": 4762,
  "field": "_roden_faqs:2:answer",
  "find": "comparative negligence with a 51% bar, and your award",
  "replace": "comparative negligence with a more-than-50% bar, and your award"
 },
 {
  "id": 4762,
  "field": "content",
  "find": " negligence with a <strong>51% bar</strong> — you ",
  "replace": " negligence with a <strong>more-than-50% bar</strong> — you "
 },
 {
  "id": 4762,
  "field": "content",
  "find": "comparative negligence with a 51% bar. You can still",
  "replace": "comparative negligence with a more-than-50% bar. You can still"
 },
 {
  "id": 4766,
  "field": "content",
  "find": "§ 15-38-15, and the 51% bar traces back to",
  "replace": "§ 15-38-15, and the more-than-50% bar traces back to"
 },
 {
  "id": 4772,
  "field": "_roden_faqs:2:answer",
  "find": "push you past the 51% bar, so an attorney",
  "replace": "push you past the more-than-50% bar, so an attorney"
 },
 {
  "id": 4772,
  "field": "content",
  "find": "crash.</p>\n<h3>2. The 51% comparative-fault bar</h3>\n<p>South",
  "replace": "crash.</p>\n<h3>2. The more-than-50% comparative-fault bar</h3>\n<p>South"
 },
 {
  "id": 4772,
  "field": "content",
  "find": " negligence with a <strong>51% bar</strong>: you can",
  "replace": " negligence with a <strong>more-than-50% bar</strong>: you can"
 },
 {
  "id": 4772,
  "field": "content",
  "find": "fault to cross the 51% line and zero out",
  "replace": "fault to cross the 50% line and zero out"
 },
 {
  "id": 4772,
  "field": "content",
  "find": "against you under the 51% rule.</li>\n</ul>\n<p>Avoiding",
  "replace": "against you under the more-than-50% rule.</li>\n</ul>\n<p>Avoiding"
 },
 {
  "id": 4772,
  "field": "excerpt",
  "find": "SC's 3-year deadline, the 51% fault bar, helmet law,",
  "replace": "SC's 3-year deadline, the more-than-50% fault bar, helmet law,"
 },
 {
  "id": 4774,
  "field": "_roden_faqs:2:answer",
  "find": "comparative negligence with a 51% bar (Nelson v. Concrete",
  "replace": "comparative negligence with a more-than-50% bar (Nelson v. Concrete"
 },
 {
  "id": 4774,
  "field": "content",
  "find": "</strong> (modified comparative negligence, 51% bar — <em>Nelson ",
  "replace": "</strong> (modified comparative negligence, more-than-50% bar — <em>Nelson "
 },
 {
  "id": 4774,
  "field": "content",
  "find": " negligence</td>\n<td>Modified, <strong>51% bar</strong> (<em>Nelson ",
  "replace": " negligence</td>\n<td>Modified, <strong>more-than-50% bar</strong> (<em>Nelson "
 },
 {
  "id": 4774,
  "field": "content",
  "find": "negligence rule with a 51% bar. As long as",
  "replace": "negligence rule with a more-than-50% bar. As long as"
 },
 {
  "id": 4776,
  "field": "_roden_faqs:4:answer",
  "find": "Likely yes. South Carolina's 51% comparative-fault rule lets you",
  "replace": "Likely yes. South Carolina's more-than-50% comparative-fault rule lets you"
 },
 {
  "id": 4776,
  "field": "content",
  "find": " Carolina follows a <strong>51% comparative-fault bar</strong> — ",
  "replace": " Carolina follows a <strong>more-than-50% comparative-fault bar</strong> — "
 },
 {
  "id": 4776,
  "field": "content",
  "find": " negligence with a <strong>51% bar</strong>: you can",
  "replace": " negligence with a <strong>more-than-50% bar</strong>: you can"
 },
 {
  "id": 4778,
  "field": "_roden_faqs:4:answer",
  "find": "comparative-negligence rule with a 51% bar (Nelson v. Concrete",
  "replace": "comparative-negligence rule with a more-than-50% bar (Nelson v. Concrete"
 },
 {
  "id": 4778,
  "field": "content",
  "find": "gap.</li>\n<li>South Carolina&#39;s 51% comparative-fault bar lets you",
  "replace": "gap.</li>\n<li>South Carolina&#39;s more-than-50% comparative-fault bar lets you"
 },
 {
  "id": 4778,
  "field": "content",
  "find": " rule with a <strong>51% bar</strong>. Under the",
  "replace": " rule with a <strong>more-than-50% bar</strong>. Under the"
 },
 {
  "id": 4785,
  "field": "_roden_faqs:2:answer",
  "find": "comparative negligence with a 51% bar under S.C. Code",
  "replace": "comparative negligence with a more-than-50% bar under S.C. Code"
 },
 {
  "id": 4785,
  "field": "content",
  "find": "comparative negligence with a 51% bar</strong> (S.C. Code ",
  "replace": "comparative negligence with a more-than-50% bar</strong> (S.C. Code "
 },
 {
  "id": 4785,
  "field": "content",
  "find": "comparative negligence with a 51% bar</strong> under S.C. ",
  "replace": "comparative negligence with a more-than-50% bar</strong> under S.C. "
 },
 {
  "id": 4787,
  "field": "_roden_faqs:2:answer",
  "find": "comparative negligence with a 51% bar under S.C. Code",
  "replace": "comparative negligence with a more-than-50% bar under S.C. Code"
 },
 {
  "id": 4787,
  "field": "content",
  "find": "comparative negligence with a 51% bar</strong> (S.C. Code ",
  "replace": "comparative negligence with a more-than-50% bar</strong> (S.C. Code "
 },
 {
  "id": 4787,
  "field": "content",
  "find": "comparative negligence with a 51% bar</strong> under S.C. ",
  "replace": "comparative negligence with a more-than-50% bar</strong> under S.C. "
 },
 {
  "id": 4789,
  "field": "_roden_faqs:1:answer",
  "find": "comparative negligence with a 51% bar (S.C. Code Ann.",
  "replace": "comparative negligence with a more-than-50% bar (S.C. Code Ann."
 },
 {
  "id": 4789,
  "field": "_roden_faqs:4:answer",
  "find": "adjusters, and fights the 51% fault arguments insurers use to",
  "replace": "adjusters, and fights the comparative-fault arguments insurers use to"
 },
 {
  "id": 4789,
  "field": "content",
  "find": "</strong> rule with a 51% bar — you can",
  "replace": "</strong> rule with a more-than-50% bar — you can"
 },
 {
  "id": 4789,
  "field": "content",
  "find": " negligence</strong> with a 51% bar (S.C. Code Ann.",
  "replace": " negligence</strong> with a more-than-50% bar (S.C. Code Ann."
 },
 {
  "id": 4789,
  "field": "content",
  "find": "found…</th>\n<th>Under SC&#39;s 51% bar</th>\n<th>What it",
  "replace": "found…</th>\n<th>Under SC&#39;s more-than-50% bar</th>\n<th>What it"
 },
 {
  "id": 4789,
  "field": "content",
  "find": "</td>\n</tr>\n<tr>\n<td>51% or more at fault</td>\n<td><strong>",
  "replace": "</td>\n</tr>\n<tr>\n<td>More than 50% at fault</td>\n<td><strong>"
 },
 {
  "id": 4789,
  "field": "content",
  "find": " guess.</strong> Under the 51% bar, an offhand &quot;I&#39;m",
  "replace": " guess.</strong> Under the more-than-50% bar, an offhand &quot;I&#39;m"
 },
 {
  "id": 4789,
  "field": "content",
  "find": "shift blame under the 51% bar. We handle drunk-driving",
  "replace": "shift blame under the more-than-50% bar. We handle drunk-driving"
 },
 {
  "id": 4791,
  "field": "content",
  "find": "comparative negligence with a 51% bar under S.C. Code",
  "replace": "comparative negligence with a more-than-50% bar under S.C. Code"
 },
 {
  "id": 4791,
  "field": "content",
  "find": " on <a href=\"/blog/south-carolina-comparative-fault-partially-at-fault/\">South Carolina&#39;s 51% comparative fault rule</a> ",
  "replace": " on <a href=\"/blog/south-carolina-comparative-fault-partially-at-fault/\">South Carolina&#39;s modified comparative fault rule</a> "
 },
 {
  "id": 4793,
  "field": "_roden_faqs:2:answer",
  "find": "long as you are less than 51% responsible, with your award",
  "replace": "long as you are 50% or less responsible, with your award"
 },
 {
  "id": 4793,
  "field": "content",
  "find": " as you are <strong>less than 51% responsible</strong>. Insurance adjusters",
  "replace": " as you are <strong>50% or less responsible</strong>. Insurance adjusters"
 },
 {
  "id": 4798,
  "field": "_roden_faqs:1:answer",
  "find": "comparative negligence with a 51% bar (Nelson v. Concrete",
  "replace": "comparative negligence with a more-than-50% bar (Nelson v. Concrete"
 },
 {
  "id": 4798,
  "field": "_roden_faqs:1:answer",
  "find": "your percentage of fault. At 51% or more, recovery is barred —",
  "replace": "your percentage of fault. Above 50%, recovery is barred —"
 },
 {
  "id": 4798,
  "field": "content",
  "find": "comparative negligence with a 51% bar; you can recover",
  "replace": "comparative negligence with a more-than-50% bar; you can recover"
 },
 {
  "id": 4798,
  "field": "content",
  "find": "comparative negligence with a 51% bar (Nelson v. Concrete",
  "replace": "comparative negligence with a more-than-50% bar (Nelson v. Concrete"
 },
 {
  "id": 4798,
  "field": "content",
  "find": "of fault — and at 51% or more, recovery is barred entirely.",
  "replace": "of fault — and above 50%, recovery is barred entirely."
 },
 {
  "id": 4798,
  "field": "content",
  "find": "less at fault; barred at 51%</td>\n<td>Insurers shift blame",
  "replace": "less at fault; barred above 50%</td>\n<td>Insurers shift blame"
 },
 {
  "id": 4798,
  "field": "content",
  "find": "riders to cross the 51% line</td>\n</tr>\n<tr>\n",
  "replace": "riders to cross the 50% line</td>\n</tr>\n<tr>\n"
 },
 {
  "id": 4800,
  "field": "_roden_faqs:2:answer",
  "find": "comparative negligence with a 51% bar, meaning you can",
  "replace": "comparative negligence with a more-than-50% bar, meaning you can"
 },
 {
  "id": 4800,
  "field": "_roden_faqs:2:answer",
  "find": "to push you past 51%, which is why having",
  "replace": "to push you past 50%, which is why having"
 },
 {
  "id": 4800,
  "field": "content",
  "find": "comparative negligence with a 51% bar; you recover only",
  "replace": "comparative negligence with a more-than-50% bar; you recover only"
 },
 {
  "id": 4800,
  "field": "content",
  "find": "negligence rule with a 51% bar: you can recover",
  "replace": "negligence rule with a more-than-50% bar: you can recover"
 },
 {
  "id": 4800,
  "field": "content",
  "find": "a plaintiff who is 51% or more at fault recovers nothing",
  "replace": "a plaintiff who is more than 50% at fault recovers nothing"
 },
 {
  "id": 4800,
  "field": "content",
  "find": "push them past that 51% line, which is one",
  "replace": "push them past that 50% line, which is one"
 },
 {
  "id": 4802,
  "field": "_roden_faqs:4:answer",
  "find": "comparative negligence with a 51% bar, so you can",
  "replace": "comparative negligence with a more-than-50% bar, so you can"
 },
 {
  "id": 4802,
  "field": "content",
  "find": "comparative negligence with a 51% bar. You can recover",
  "replace": "comparative negligence with a more-than-50% bar. You can recover"
 },
 {
  "id": 4802,
  "field": "content",
  "find": "your percentage of fault; at 51% or more, you recover nothing (Nelson",
  "replace": "your percentage of fault; above 50%, you recover nothing (Nelson"
 },
 {
  "id": 4804,
  "field": "_roden_faqs:2:answer",
  "find": "at fault. Under the 51% bar rule from Nelson",
  "replace": "at fault. Under the more-than-50% bar rule from Nelson"
 },
 {
  "id": 4804,
  "field": "content",
  "find": " Carolina uses the <strong>51% bar</strong> rule: you ",
  "replace": " Carolina uses the <strong>more-than-50% bar</strong> rule: you "
 },
 {
  "id": 4804,
  "field": "content",
  "find": "South Carolina follows the 51% bar rule from Nelson",
  "replace": "South Carolina follows the more-than-50% bar rule from Nelson"
 },
 {
  "id": 4804,
  "field": "content",
  "find": "\n<td>Comparative fault</td>\n<td>51% bar; recover if 50%",
  "replace": "\n<td>Comparative fault</td>\n<td>More-than-50% bar; recover if 50%"
 },
 {
  "id": 4827,
  "field": "_roden_faqs:1:answer",
  "find": "only if you were 51% or more at fault.",
  "replace": "only if you were more than 50% at fault."
 },
 {
  "id": 4827,
  "field": "content",
  "find": "recovery if you were 51% or more at fault, and your",
  "replace": "recovery if you were more than 50% at fault, and your"
 },
 {
  "id": 4828,
  "field": "_roden_faqs:1:answer",
  "find": "only if you were 51% or more at fault.",
  "replace": "only if you were more than 50% at fault."
 },
 {
  "id": 4828,
  "field": "content",
  "find": "recovery if you were 51% or more at fault, and your",
  "replace": "recovery if you were more than 50% at fault, and your"
 },
 {
  "id": 4829,
  "field": "_roden_faqs:1:answer",
  "find": "only if you were 51% or more at fault.",
  "replace": "only if you were more than 50% at fault."
 },
 {
  "id": 4829,
  "field": "content",
  "find": "recovery if you were 51% or more at fault, and your",
  "replace": "recovery if you were more than 50% at fault, and your"
 },
 {
  "id": 4902,
  "field": "_roden_key_takeaways",
  "find": "recuperar compensación siempre que haya sido menos del 51% culpable, incluso si compartió parte",
  "replace": "recuperar compensación siempre que su culpa haya sido del 50% o menos, incluso si compartió parte"
 },
 {
  "id": 4903,
  "field": "_roden_key_takeaways",
  "find": "puede recuperar compensación si fue menos del 51% culpable. Los casos vinculados al",
  "replace": "puede recuperar compensación si su culpa fue del 50% o menos. Los casos vinculados al"
 },
 {
  "id": 4905,
  "field": "_roden_key_takeaways",
  "find": "puede recuperar compensación si fue menos del 51% culpable; su reclamo de compensación",
  "replace": "puede recuperar compensación si su culpa fue del 50% o menos; su reclamo de compensación"
 },
 {
  "id": 4906,
  "field": "_roden_faqs:4:answer",
  "find": "cuando su responsabilidad sea menor al 51%. Su compensación se reduce",
  "replace": "cuando su responsabilidad sea del 50% o menos. Su compensación se reduce"
 },
 {
  "id": 4906,
  "field": "_roden_key_takeaways",
  "find": "recuperar compensación siempre que haya sido menos del 51% culpable. Los corredores de la",
  "replace": "recuperar compensación siempre que su culpa haya sido del 50% o menos. Los corredores de la"
 },
 {
  "id": 4907,
  "field": "_roden_key_takeaways",
  "find": "puede recuperar compensación si fue menos del 51% culpable. El corredor portuario de",
  "replace": "puede recuperar compensación si su culpa fue del 50% o menos. El corredor portuario de"
 },
 {
  "id": 4909,
  "field": "_roden_key_takeaways",
  "find": "puede recuperar compensación si fue menos del 51% culpable; su reclamo de compensación",
  "replace": "puede recuperar compensación si su culpa fue del 50% o menos; su reclamo de compensación"
 },
 {
  "id": 4910,
  "field": "_roden_key_takeaways",
  "find": "recuperar compensación siempre que haya sido menos del 51% culpable. Los choques en Malfunction",
  "replace": "recuperar compensación siempre que su culpa haya sido del 50% o menos. Los choques en Malfunction"
 },
 {
  "id": 4911,
  "field": "_roden_key_takeaways",
  "find": "puede recuperar compensación si fue menos del 51% culpable. Los choques de camiones",
  "replace": "puede recuperar compensación si su culpa fue del 50% o menos. Los choques de camiones"
 },
 {
  "id": 4913,
  "field": "_roden_key_takeaways",
  "find": "puede recuperar compensación si fue menos del 51% culpable; la compensación laboral corre",
  "replace": "puede recuperar compensación si su culpa fue del 50% o menos; la compensación laboral corre"
 },
 {
  "id": 4918,
  "field": "_roden_key_takeaways",
  "find": "recuperar compensación siempre que haya sido menos del 51% culpable. En el Grand Strand",
  "replace": "recuperar compensación siempre que su culpa haya sido del 50% o menos. En el Grand Strand"
 },
 {
  "id": 4919,
  "field": "_roden_key_takeaways",
  "find": "puede recuperar compensación si fue menos del 51% culpable. Los corredores de carga",
  "replace": "puede recuperar compensación si su culpa fue del 50% o menos. Los corredores de carga"
 },
 {
  "id": 4921,
  "field": "_roden_key_takeaways",
  "find": "puede recuperar compensación si fue menos del 51% culpable; la compensación laboral corre",
  "replace": "puede recuperar compensación si su culpa fue del 50% o menos; la compensación laboral corre"
 },
 {
  "id": 4950,
  "field": "_roden_faqs:1:answer",
  "find": "modificada con una barrera del 51% (Nelson v. Concrete Supply",
  "replace": "modificada con una barrera de más del 50% (Nelson v. Concrete Supply"
 },
 {
  "id": 4950,
  "field": "_roden_faqs:1:answer",
  "find": "porcentaje de responsabilidad. Con 51% o más, la recuperación queda bloqueada,",
  "replace": "porcentaje de responsabilidad. Con más del 50%, la recuperación queda bloqueada,"
 },
 {
  "id": 4950,
  "field": "content",
  "find": "modificada con una barrera del 51%: recupera con 50% o",
  "replace": "modificada con una barrera de más del 50%: recupera con 50% o"
 },
 {
  "id": 4950,
  "field": "content",
  "find": "modificada con una barrera del 51% (Nelson v. Concrete Supply",
  "replace": "modificada con una barrera de más del 50% (Nelson v. Concrete Supply"
 },
 {
  "id": 4950,
  "field": "content",
  "find": "de responsabilidad, y con 51% o más queda bloqueada. Las aseguradoras",
  "replace": "de responsabilidad, y con más del 50% queda bloqueada. Las aseguradoras"
 },
 {
  "id": 4950,
  "field": "content",
  "find": "menos de culpa; bloqueado en 51%</td>\n<td>Las aseguradoras trasladan",
  "replace": "menos de culpa; bloqueado por encima del 50%</td>\n<td>Las aseguradoras trasladan"
 },
 {
  "id": 4950,
  "field": "content",
  "find": "cruzar la línea del 51%</td>\n</tr>\n<tr>\n<td>Reducción",
  "replace": "cruzar la línea del 50%</td>\n</tr>\n<tr>\n<td>Reducción"
 },
 {
  "id": 4952,
  "field": "_roden_faqs:2:answer",
  "find": "modificada con una barrera del 51%, lo que significa que",
  "replace": "modificada con una barrera de más del 50%, lo que significa que"
 },
 {
  "id": 4952,
  "field": "_roden_faqs:2:answer",
  "find": "empujarlo más allá del 51%, por eso es tan",
  "replace": "empujarlo más allá del 50%, por eso es tan"
 },
 {
  "id": 4952,
  "field": "content",
  "find": "modificada con una barrera del 51%; usted recupera solo si",
  "replace": "modificada con una barrera de más del 50%; usted recupera solo si"
 },
 {
  "id": 4952,
  "field": "content",
  "find": "modificada con una barrera del 51%: usted puede recuperar daños",
  "replace": "modificada con una barrera de más del 50%: usted puede recuperar daños"
 },
 {
  "id": 4952,
  "field": "content",
  "find": "que un demandante con 51% o más de la culpa no",
  "replace": "que un demandante con más del 50% de la culpa no"
 },
 {
  "id": 4952,
  "field": "content",
  "find": "de la línea del 51%, una razón más para",
  "replace": "de la línea del 50%, una razón más para"
 },
 {
  "id": 4954,
  "field": "_roden_faqs:5:answer",
  "find": "modificada con una barrera del 51%, así que usted todavía",
  "replace": "modificada con una barrera de más del 50%, así que usted todavía"
 },
 {
  "id": 4954,
  "field": "content",
  "find": "modificada con una barrera del 51%. Usted puede recuperar siempre",
  "replace": "modificada con una barrera de más del 50%. Usted puede recuperar siempre"
 },
 {
  "id": 4954,
  "field": "content",
  "find": "porcentaje de culpa; con 51% o más, no recupera nada (Nelson",
  "replace": "porcentaje de culpa; con más del 50%, no recupera nada (Nelson"
 },
 {
  "id": 4956,
  "field": "_roden_faqs:2:answer",
  "find": "regla de la barra del 51% de Nelson v. Concrete",
  "replace": "regla de la barra de más del 50% de Nelson v. Concrete"
 },
 {
  "id": 4956,
  "field": "content",
  "find": " usa la <strong>barra del 51%</strong>: usted puede recuperar",
  "replace": " usa la <strong>barra de más del 50%</strong>: usted puede recuperar"
 },
 {
  "id": 4956,
  "field": "content",
  "find": "Sur sigue la barra del 51% de Nelson v. Concrete",
  "replace": "Sur sigue la barra de más del 50% de Nelson v. Concrete"
 },
 {
  "id": 4956,
  "field": "content",
  "find": "Culpa comparativa</td>\n<td>Barra del 51%; recupera si tiene 50%",
  "replace": "Culpa comparativa</td>\n<td>Barra de más del 50%; recupera si tiene 50%"
 },
 {
  "id": 4966,
  "field": "_roden_faqs:1:answer",
  "find": "payouts under South Carolina's 51% comparative fault rule. A",
  "replace": "payouts under South Carolina's modified comparative fault rule. A"
 },
 {
  "id": 4966,
  "field": "content",
  "find": " Carolina uses a <strong>51% bar</strong> on comparative ",
  "replace": " Carolina uses a <strong>more-than-50% bar</strong> on comparative "
 },
 {
  "id": 4966,
  "field": "content",
  "find": "comparative negligence with a 51% bar. You can recover",
  "replace": "comparative negligence with a more-than-50% bar. You can recover"
 },
 {
  "id": 4968,
  "field": "_roden_faqs:1:answer",
  "find": "pagos bajo la regla del 51 % de negligencia comparativa de Carolina del Sur.",
  "replace": "pagos bajo la regla de negligencia comparativa modificada de Carolina del Sur."
 },
 {
  "id": 4968,
  "field": "content",
  "find": " aplica una <strong>barra del 51 %</strong> en la ",
  "replace": " aplica una <strong>barra de más del 50 %</strong> en la "
 },
 {
  "id": 4968,
  "field": "content",
  "find": "modificada con una barra del 51 %. Usted puede recuperar",
  "replace": "modificada con una barra de más del 50 %. Usted puede recuperar"
 },
 {
  "id": 4970,
  "field": "_roden_faqs:3:answer",
  "find": "comparative negligence with a 51% bar under Nelson v.",
  "replace": "comparative negligence with a more-than-50% bar under Nelson v."
 },
 {
  "id": 4970,
  "field": "_roden_faqs:3:answer",
  "find": "injured drivers precisely because reaching 51% wipes out your recovery,",
  "replace": "injured drivers precisely because going above 50% wipes out your recovery,"
 },
 {
  "id": 4970,
  "field": "content",
  "find": "</li>\n<li>South Carolina&#39;s <strong>modified comparative negligence 51% bar</strong> lets you ",
  "replace": "</li>\n<li>South Carolina&#39;s <strong>more-than-50% modified comparative negligence bar</strong> lets you "
 },
 {
  "id": 4970,
  "field": "content",
  "find": " negligence with a <strong>51% bar</strong>, meaning you",
  "replace": " negligence with a <strong>more-than-50% bar</strong>, meaning you"
 },
 {
  "id": 4970,
  "field": "content",
  "find": "to recovery</td>\n<td>Barred at 51% or more at fault</td>\n<td><em>",
  "replace": "to recovery</td>\n<td>Barred if more than 50% at fault</td>\n<td><em>"
 },
 {
  "id": 4972,
  "field": "_roden_faqs:3:answer",
  "find": "modificada con una barra del 51% bajo Nelson v. Concrete",
  "replace": "modificada con una barra de más del 50% bajo Nelson v. Concrete"
 },
 {
  "id": 4972,
  "field": "_roden_faqs:3:answer",
  "find": "conductores lesionados precisamente porque llegar al 51% elimina su recuperación, así",
  "replace": "conductores lesionados precisamente porque superar el 50% elimina su recuperación, así"
 },
 {
  "id": 4972,
  "field": "content",
  "find": "comparativa modificada con barra del 51%</strong> de South Carolina ",
  "replace": "comparativa modificada con barra de más del 50%</strong> de South Carolina "
 },
 {
  "id": 4972,
  "field": "content",
  "find": " con una <strong>barra del 51%</strong>: puede recuperar mientras",
  "replace": " con una <strong>barra de más del 50%</strong>: puede recuperar mientras"
 },
 {
  "id": 4972,
  "field": "content",
  "find": "recuperación</td>\n<td>Bloqueado con 51% o más de culpa</td>\n<td><em>",
  "replace": "recuperación</td>\n<td>Bloqueado con más del 50% de culpa</td>\n<td><em>"
 },
 {
  "id": 4974,
  "field": "_roden_faqs:2:answer",
  "find": "comparative negligence with a 51% bar under Nelson v.",
  "replace": "comparative negligence with a more-than-50% bar under Nelson v."
 },
 {
  "id": 4974,
  "field": "content",
  "find": " Carolina uses a <strong>51% bar</strong>: you can",
  "replace": " Carolina uses a <strong>more-than-50% bar</strong>: you can"
 },
 {
  "id": 4974,
  "field": "content",
  "find": "comparative negligence with a 51% bar, established in <em>",
  "replace": "comparative negligence with a more-than-50% bar, established in <em>"
 },
 {
  "id": 4976,
  "field": "_roden_faqs:2:answer",
  "find": "modificada con una barra del 51% bajo Nelson v. Concrete",
  "replace": "modificada con una barra de más del 50% bajo Nelson v. Concrete"
 },
 {
  "id": 4976,
  "field": "content",
  "find": " usa una <strong>barra del 51%</strong>: usted puede recuperar",
  "replace": " usa una <strong>barra de más del 50%</strong>: usted puede recuperar"
 },
 {
  "id": 4976,
  "field": "content",
  "find": "modificada con una barra del 51%, establecida en <em>Nelson ",
  "replace": "modificada con una barra de más del 50%, establecida en <em>Nelson "
 },
 {
  "id": 4978,
  "field": "content",
  "find": "comparative negligence with a 51% bar, established in Nelson",
  "replace": "comparative negligence with a more-than-50% bar, established in Nelson"
 },
 {
  "id": 4978,
  "field": "content",
  "find": "walks through how the 51% bar plays out in",
  "replace": "walks through how the more-than-50% bar plays out in"
 },
 {
  "id": 4980,
  "field": "content",
  "find": "modificada con una barrera del 51%, establecida en Nelson v.",
  "replace": "modificada con una barrera de más del 50%, establecida en Nelson v."
 },
 {
  "id": 4980,
  "field": "content",
  "find": "se aplica la barrera del 51% en casos reales.</p>\n",
  "replace": "se aplica la barrera de más del 50% en casos reales.</p>\n"
 },
 {
  "id": 5013,
  "field": "_roden_faqs:4:answer",
  "find": "South Carolina follows a 51% bar rule under Nelson",
  "replace": "South Carolina follows a more-than-50% bar rule under Nelson"
 },
 {
  "id": 5013,
  "field": "content",
  "find": "South Carolina follows a 51% bar (Nelson v. Concrete",
  "replace": "South Carolina follows a more-than-50% bar (Nelson v. Concrete"
 },
 {
  "id": 5013,
  "field": "content",
  "find": "comparative negligence with a 51% bar, established in Nelson",
  "replace": "comparative negligence with a more-than-50% bar, established in Nelson"
 },
 {
  "id": 5016,
  "field": "_roden_faqs:4:answer",
  "find": "regla de la barrera del 51% bajo Nelson v. Concrete",
  "replace": "regla de la barrera de más del 50% bajo Nelson v. Concrete"
 },
 {
  "id": 5016,
  "field": "content",
  "find": "Sur aplica una barrera del 51% (Nelson v. Concrete Supply",
  "replace": "Sur aplica una barrera de más del 50% (Nelson v. Concrete Supply"
 },
 {
  "id": 5016,
  "field": "content",
  "find": "modificada con una barrera del 51%, establecida en Nelson v.",
  "replace": "modificada con una barrera de más del 50%, establecida en Nelson v."
 },
 {
  "id": 5019,
  "field": "_roden_faqs:4:answer",
  "find": "at fault. South Carolina's 51% bar (Nelson v. Concrete",
  "replace": "at fault. South Carolina's more-than-50% bar (Nelson v. Concrete"
 },
 {
  "id": 5019,
  "field": "_roden_faqs:4:answer",
  "find": "award; only crossing the 51% line eliminates recovery entirely.",
  "replace": "award; only crossing the 50% line eliminates recovery entirely."
 },
 {
  "id": 5019,
  "field": "content",
  "find": "</li>\n<li><strong>South Carolina&#39;s 51% bar</strong> lets you ",
  "replace": "</li>\n<li><strong>South Carolina&#39;s more-than-50% bar</strong> lets you "
 },
 {
  "id": 5019,
  "field": "content",
  "find": "</strong> standard — the 51% bar. You can recover",
  "replace": "</strong> standard — the more-than-50% bar. You can recover"
 },
 {
  "id": 5019,
  "field": "content",
  "find": " cross the 51% line, and you recover",
  "replace": " cross the 50% line, and you recover"
 },
 {
  "id": 5022,
  "field": "_roden_faqs:4:answer",
  "find": "la culpa. La barrera del 51% de Carolina del Sur",
  "replace": "la culpa. La barrera de más del 50% de Carolina del Sur"
 },
 {
  "id": 5022,
  "field": "_roden_faqs:4:answer",
  "find": "cruzar la línea del 51% elimina la recuperación.",
  "replace": "cruzar la línea del 50% elimina la recuperación."
 },
 {
  "id": 5022,
  "field": "content",
  "find": "</li>\n<li><strong>La barrera del 51% de Carolina del Sur",
  "replace": "</li>\n<li><strong>La barrera de más del 50% de Carolina del Sur"
 },
 {
  "id": 5022,
  "field": "content",
  "find": "</strong> — la barrera del 51%. Usted puede recuperar mientras",
  "replace": "</strong> — la barrera de más del 50%. Usted puede recuperar mientras"
 },
 {
  "id": 5022,
  "field": "content",
  "find": "cruce la línea del 51%, y no recupera nada.",
  "replace": "cruce la línea del 50%, y no recupera nada."
 },
 {
  "id": 5025,
  "field": "_roden_faqs:4:answer",
  "find": "unless you cross the 51% bar. Insurers often inflate",
  "replace": "unless you cross the more-than-50% bar. Insurers often inflate"
 },
 {
  "id": 5025,
  "field": "content",
  "find": "</strong> Under South Carolina&#39;s 51% rule you can still",
  "replace": "</strong> Under South Carolina&#39;s modified comparative fault rule you can still"
 },
 {
  "id": 5025,
  "field": "content",
  "find": "standard, often called the 51% bar. Under <em>Nelson ",
  "replace": "standard, often called the more-than-50% bar. Under <em>Nelson "
 },
 {
  "id": 5028,
  "field": "_roden_faqs:4:answer",
  "find": "que cruce la barrera del 51%. Las aseguradoras a menudo",
  "replace": "que cruce la barrera de más del 50%. Las aseguradoras a menudo"
 },
 {
  "id": 5028,
  "field": "content",
  "find": "</strong> Bajo la barrera del 51% de Carolina del Sur,",
  "replace": "</strong> Bajo la barrera de más del 50% de Carolina del Sur,"
 },
 {
  "id": 5028,
  "field": "content",
  "find": "modificada, la llamada barrera del 51%. Bajo Nelson v. Concrete",
  "replace": "modificada, la llamada barrera de más del 50%. Bajo Nelson v. Concrete"
 },
 {
  "id": 5031,
  "field": "content",
  "find": "both: under the state&#39;s 51% bar, you can recover",
  "replace": "both: under the state&#39;s more-than-50% bar, you can recover"
 },
 {
  "id": 5034,
  "field": "content",
  "find": "ambos: bajo la barrera del 51%, usted puede recuperar mientras",
  "replace": "ambos: bajo la barrera de más del 50%, usted puede recuperar mientras"
 },
 {
  "id": 5041,
  "field": "_roden_faqs:0:answer",
  "find": "your number past the 51% bar depends on crash",
  "replace": "your number past the more-than-50% bar depends on crash"
 },
 {
  "id": 5041,
  "field": "content",
  "find": "pays first, how the 51% comparative-fault bar gets argued,",
  "replace": "pays first, how the more-than-50% comparative-fault bar gets argued,"
 },
 {
  "id": 5041,
  "field": "content",
  "find": "the rider under the 51% bar. Handling that argument",
  "replace": "the rider under the more-than-50% bar. Handling that argument"
 },
 {
  "id": 5041,
  "field": "content",
  "find": "Comparative Negligence and the 51% Bar</h2>\n<p>South Carolina",
  "replace": "Comparative Negligence and the More-Than-50% Bar</h2>\n<p>South Carolina"
 },
 {
  "id": 5041,
  "field": "content",
  "find": "comparative negligence with a 51% bar: your damages are",
  "replace": "comparative negligence with a more-than-50% bar: your damages are"
 },
 {
  "id": 5043,
  "field": "_roden_faqs:0:answer",
  "find": "allá de la barrera del 51% depende de la mecánica",
  "replace": "allá de la barrera de más del 50% depende de la mecánica"
 },
 {
  "id": 5043,
  "field": "content",
  "find": "se argumenta la barrera del 51% de culpa comparativa y",
  "replace": "se argumenta la barrera de más del 50% de culpa comparativa y"
 },
 {
  "id": 5043,
  "field": "content",
  "find": "conductor bajo la barrera del 51%. Manejar ese argumento es",
  "replace": "conductor bajo la barrera de más del 50%. Manejar ese argumento es"
 },
 {
  "id": 5043,
  "field": "content",
  "find": "Modificada y la Barrera del 51%</h2>\n<p>Carolina del Sur",
  "replace": "Modificada y la Barrera de Más del 50%</h2>\n<p>Carolina del Sur"
 },
 {
  "id": 5043,
  "field": "content",
  "find": "modificada con una barrera del 51%: sus daños se reducen",
  "replace": "modificada con una barrera de más del 50%: sus daños se reducen"
 },
 {
  "id": 5049,
  "field": "content",
  "find": "comparative negligence under the 51% bar rule established in",
  "replace": "comparative negligence under the more-than-50% bar rule established in"
 },
 {
  "id": 5051,
  "field": "_roden_faqs:3:answer",
  "find": "long as you are less than 51% at fault, though your",
  "replace": "long as you are 50% or less at fault, though your"
 },
 {
  "id": 5051,
  "field": "content",
  "find": " as you are <strong>less than 51% at fault</strong>, with",
  "replace": " as you are <strong>50% or less at fault</strong>, with"
 },
 {
  "id": 5051,
  "field": "content",
  "find": " as you are <strong>less than 51% responsible</strong> for the ",
  "replace": " as you are <strong>50% or less responsible</strong> for the "
 },
 {
  "id": 5051,
  "field": "content",
  "find": "fault</td>\n<td>Recover if less than 51% at fault; award reduced",
  "replace": "fault</td>\n<td>Recover if 50% or less at fault; award reduced"
 },
 {
  "id": 5052,
  "field": "content",
  "find": "percentage of fault, and at 51% or greater you recover nothing (Nelson",
  "replace": "percentage of fault, and above 50% you recover nothing (Nelson"
 },
 {
  "id": 5119,
  "field": "content",
  "find": "la regla de barrera del 51% establecida en <em>Nelson ",
  "replace": "la regla de barrera de más del 50% establecida en <em>Nelson "
 },
 {
  "id": 5163,
  "field": "content",
  "find": "first.</p>\n<h2>How the 51% fault bar decides whether",
  "replace": "first.</p>\n<h2>How the more-than-50% fault bar decides whether"
 },
 {
  "id": 5165,
  "field": "content",
  "find": "\n<h2>Cómo la barrera del 51% de culpa decide si",
  "replace": "\n<h2>Cómo la barrera de más del 50% de culpa decide si"
 },
 {
  "id": 5184,
  "field": "_roden_faqs:5:answer",
  "find": "aplica la negligencia comparativa modificada del 51%: su recuperación se reduce",
  "replace": "aplica la negligencia comparativa modificada: su recuperación se reduce"
 },
 {
  "id": 5184,
  "field": "_roden_faqs:5:answer",
  "find": "elimina a menos que llegue al 51%. Además, si el conductor",
  "replace": "elimina a menos que supere el 50%. Además, si el conductor"
 },
 {
  "id": 5185,
  "field": "_roden_faqs:5:answer",
  "find": "aplica la culpa comparativa modificada del 51%: su recuperación se reduce",
  "replace": "aplica la culpa comparativa modificada: su recuperación se reduce"
 },
 {
  "id": 5185,
  "field": "_roden_faqs:5:answer",
  "find": "elimina a menos que llegue al 51%. Además, si el conductor",
  "replace": "elimina a menos que supere el 50%. Además, si el conductor"
 },
 {
  "id": 5186,
  "field": "_roden_faqs:5:answer",
  "find": "aplica la culpa comparativa modificada del 51%: su recuperación se reduce",
  "replace": "aplica la culpa comparativa modificada: su recuperación se reduce"
 },
 {
  "id": 5186,
  "field": "_roden_faqs:5:answer",
  "find": "desaparece a menos que llegue al 51%. Además, si el conductor",
  "replace": "desaparece a menos que supere el 50%. Además, si el conductor"
 },
 {
  "id": 5196,
  "field": "_roden_faqs:2:answer",
  "find": "regla de negligencia comparativa modificada del 51%: usted recupera mientras no",
  "replace": "regla de negligencia comparativa modificada: usted recupera mientras no"
 },
 {
  "id": 5197,
  "field": "_roden_faqs:2:answer",
  "find": " Sur aplica la regla del 51% de negligencia comparativa modificada:",
  "replace": " Sur aplica la regla de negligencia comparativa modificada:"
 },
 {
  "id": 5199,
  "field": "_roden_faqs:2:answer",
  "find": " Sur aplica la regla del 51% de negligencia comparativa modificada:",
  "replace": " Sur aplica la regla de negligencia comparativa modificada:"
 },
 {
  "id": 5212,
  "field": "content",
  "find": "or less at fault; at 51% recovery is barred (Nelson",
  "replace": "or less at fault; above 50% recovery is barred (Nelson"
 },
 {
  "id": 5212,
  "field": "content",
  "find": "picture.</p>\n<h2>Fault, the 51% Line, and Merging Onto",
  "replace": "picture.</p>\n<h2>Fault, the 50% Line, and Merging Onto"
 },
 {
  "id": 5212,
  "field": "content",
  "find": "proportion to that share; at 51% or more, recovery is barred entirely.",
  "replace": "proportion to that share; above 50%, recovery is barred entirely."
 },
 {
  "id": 5214,
  "field": "content",
  "find": "del 50% o menos; al 51% la recuperación queda prohibida",
  "replace": "del 50% o menos; por encima del 50% la recuperación queda prohibida"
 },
 {
  "id": 5214,
  "field": "content",
  "find": "culpa, la línea del 51% y la incorporación a",
  "replace": "culpa, la línea del 50% y la incorporación a"
 },
 {
  "id": 5214,
  "field": "content",
  "find": "proporción a esa parte; al 51% o más, la recuperación queda prohibida",
  "replace": "proporción a esa parte; por encima del 50%, la recuperación queda prohibida"
 },
 {
  "id": 5216,
  "field": "_roden_faqs:4:answer",
  "find": "and bars recovery entirely at 51%. Insurers routinely overstate a",
  "replace": "and bars recovery entirely above 50%. Insurers routinely overstate a"
 },
 {
  "id": 5216,
  "field": "content",
  "find": "any award reduced proportionally; at 51% you recover nothing. Expect",
  "replace": "any award reduced proportionally; above 50% you recover nothing. Expect"
 },
 {
  "id": 5218,
  "field": "_roden_faqs:5:answer",
  "find": "la elimina por completo al 51%. Las aseguradoras exageran de",
  "replace": "la elimina por completo por encima del 50%. Las aseguradoras exageran de"
 },
 {
  "id": 5218,
  "field": "content",
  "find": "indemnización baja en proporción; al 51% no recupera nada. Espere",
  "replace": "indemnización baja en proporción; por encima del 50% no recupera nada. Espere"
 },
 {
  "id": 5231,
  "field": "content",
  "find": "than the defendant&#39;s. That 51% cliff is why the",
  "replace": "than the defendant&#39;s. That more-than-50% cliff is why the"
 },
 {
  "id": 5233,
  "field": "content",
  "find": "del demandado. Ese acantilado del 51% explica por qué la",
  "replace": "del demandado. Ese acantilado de más del 50% explica por qué la"
 },
 {
  "id": 5339,
  "field": "content",
  "find": "</li>\n<li>Fault of <strong>51% or more bars recovery entirely</strong> ",
  "replace": "</li>\n<li>Fault of <strong>more than 50% bars recovery entirely</strong> "
 },
 {
  "id": 5339,
  "field": "content",
  "find": "comparative negligence with a 51% bar under <em>Nelson ",
  "replace": "comparative negligence with a more-than-50% bar under <em>Nelson "
 },
 {
  "id": 5341,
  "field": "_roden_faqs:4:answer",
  "find": "and bars recovery entirely at 51%. Insurers routinely overstate a",
  "replace": "and bars recovery entirely above 50%. Insurers routinely overstate a"
 },
 {
  "id": 5341,
  "field": "content",
  "find": "award reduced in proportion; at 51% you recover nothing. Expect",
  "replace": "award reduced in proportion; above 50% you recover nothing. Expect"
 },
 {
  "id": 5343,
  "field": "_roden_faqs:4:answer",
  "find": "culpa y la elimina al llegar al 51%. Las aseguradoras exageran de",
  "replace": "culpa y la elimina si supera el 50%. Las aseguradoras exageran de"
 },
 {
  "id": 5343,
  "field": "content",
  "find": "en esa proporción; con el 51% no recibe nada. Espere",
  "replace": "en esa proporción; con más del 50% no recibe nada. Espere"
 }
]
EDITS;

if ( ! defined( 'ABSPATH' ) ) { fwrite( STDERR, "Run through wp eval-file.\n" ); exit( 1 ); }
$apply = isset( $args[0] ) && 'apply' === $args[0];
$edits = json_decode( $table_json, true );
if ( ! is_array( $edits ) || count( $edits ) !== $expected_rows ) { echo "ABORT: edit table did not parse\n"; exit( 1 ); }

// Unpublished only. Never publish, trash, auto-draft, inherit (revisions/attachments).
$allowed = array( 'draft', 'pending', 'private', 'future' );
$core    = array( 'title' => 'post_title', 'excerpt' => 'post_excerpt', 'content' => 'post_content' );

// field spec: "title" | "excerpt" | "content" | "<meta_key>" | "<meta_key>:<index>:<subkey>"
$surface_of = function ( $field ) { $p = explode( ':', $field ); return $p[0]; };

global $wpdb;
$work = array(); $orig = array(); $pin = array(); $fail = 0;
foreach ( $edits as $e ) {
	$id = (int) $e['id'];
	if ( ! isset( $work[ $id ] ) ) {
		// Read the row from the table, not the object cache.
		$row = $wpdb->get_row( $wpdb->prepare( "SELECT ID, post_type, post_status, post_name, post_parent, post_date_gmt FROM {$wpdb->posts} WHERE ID = %d", $id ) );
		if ( ! $row ) { echo "FAIL  $id: missing\n"; $fail++; $work[ $id ] = false; continue; }
		if ( ! in_array( $row->post_status, $allowed, true ) ) { echo "FAIL  $id: status {$row->post_status} is not draft/pending/private/future\n"; $fail++; $work[ $id ] = false; continue; }
		if ( 'future' === $row->post_status && strtotime( $row->post_date_gmt . ' UTC' ) <= time() ) {
			// wp_insert_post would publish a 'future' post whose date has passed.
			echo "FAIL  $id: future post dated in the past ({$row->post_date_gmt}); a save would publish it\n"; $fail++; $work[ $id ] = false; continue;
		}
		if ( in_array( $row->post_status, array( 'private', 'future' ), true ) && '' !== $row->post_name
			&& wp_unique_post_slug( $row->post_name, $id, $row->post_status, $row->post_type, (int) $row->post_parent ) !== $row->post_name ) {
			echo "FAIL  $id: a save would re-slug {$row->post_name}\n"; $fail++; $work[ $id ] = false; continue;
		}
		$work[ $id ] = array(); $orig[ $id ] = array();
		$pin[ $id ]  = array( 'post_status' => $row->post_status, 'post_name' => $row->post_name, 'post_parent' => (int) $row->post_parent, 'post_type' => $row->post_type );
	}
	if ( false === $work[ $id ] ) { continue; }
	$s = $surface_of( $e['field'] );
	if ( array_key_exists( $s, $work[ $id ] ) ) { continue; }
	if ( isset( $core[ $s ] ) ) {
		$v = $wpdb->get_var( $wpdb->prepare( "SELECT {$core[ $s ]} FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	} else {
		if ( ! metadata_exists( 'post', $id, $s ) ) { echo "FAIL  $id: no $s meta\n"; $fail++; continue; }
		$v = get_post_meta( $id, $s, true );
	}
	$work[ $id ][ $s ] = $v; $orig[ $id ][ $s ] = $v;
}
if ( $fail ) { echo "ABORT: $fail post/field failures, nothing written\n"; exit( 1 ); }

$would = 0; $done = 0; $per_post = array(); $per_field = array(); $by_surface = array(); $by_status = array();
foreach ( $edits as $e ) {
	$id = (int) $e['id']; $parts = explode( ':', $e['field'] ); $s = $parts[0];
	if ( 3 === count( $parts ) ) {
		$i = (int) $parts[1]; $k = $parts[2];
		$cur = ( is_array( $work[ $id ][ $s ] ) && isset( $work[ $id ][ $s ][ $i ][ $k ] ) ) ? $work[ $id ][ $s ][ $i ][ $k ] : null;
	} else {
		$cur = $work[ $id ][ $s ];
	}
	if ( ! is_string( $cur ) ) { echo "FAIL  $id {$e['field']}: not a string\n"; $fail++; continue; }
	$n = substr_count( $cur, $e['find'] );
	if ( 0 === $n && substr_count( $cur, $e['replace'] ) >= 1 ) { echo "OK    $id {$e['field']} already applied\n"; $done++; continue; }
	if ( 1 !== $n ) { echo "FAIL  $id {$e['field']}: anchor matched $n times\n      " . $e['find'] . "\n"; $fail++; continue; }
	$new = str_replace( $e['find'], $e['replace'], $cur );
	if ( 3 === count( $parts ) ) { $work[ $id ][ $s ][ $i ][ $k ] = $new; } else { $work[ $id ][ $s ] = $new; }
	$would++; $per_post[ $id ] = true;
	if ( ! isset( $per_field[ $id . ' ' . $e['field'] ] ) ) {
		$per_field[ $id . ' ' . $e['field'] ] = true;
		$label = ( '_roden_faqs' === $s ) ? '_roden_faqs:' . $parts[2] : $s;
		$by_surface[ $label ] = ( isset( $by_surface[ $label ] ) ? $by_surface[ $label ] : 0 ) + 1;
	}
	echo ( $apply ? 'EDIT  ' : 'WOULD ' ) . "$id [{$pin[ $id ]['post_status']}] {$e['field']}\n      - " . $e['find'] . "\n      + " . $e['replace'] . "\n";
}
if ( $fail ) { echo "ABORT: $fail anchor failure(s), nothing written\n"; exit( 1 ); }

// Every value must survive the save path unchanged: simulate the db-context
// sanitisers (kses etc.) and the theme's wp_insert_post_data content filter, and
// sanitize_meta for meta. A save filter that would alter a field aborts the run
// before anything is written, rather than failing read-back half way through.
foreach ( $work as $id => $surfaces ) {
	foreach ( $surfaces as $s => $val ) {
		if ( $val === $orig[ $id ][ $s ] ) { continue; }
		if ( isset( $core[ $s ] ) ) {
			$sim = wp_unslash( sanitize_post_field( $core[ $s ], wp_slash( $val ), $id, 'db' ) );
			if ( 'content' === $s && function_exists( 'roden_normalize_pillar_links' ) ) { $sim = roden_normalize_pillar_links( $sim ); }
		} else {
			$sim = sanitize_meta( $s, wp_unslash( wp_slash( $val ) ), 'post', $pin[ $id ]['post_type'] );
		}
		if ( $sim !== $val ) { echo "FAIL  $id $s: the save path would alter this field beyond the edit\n"; $fail++; }
	}
}
if ( $fail ) { echo "ABORT: $fail save-path failure(s), nothing written\n"; exit( 1 ); }

foreach ( array_keys( $per_post ) as $id ) {
	$st = $pin[ $id ]['post_status'];
	$by_status[ $st ] = ( isset( $by_status[ $st ] ) ? $by_status[ $st ] : 0 ) + 1;
}
// Retitled posts must keep their slug; print it so the reviewer sees it.
foreach ( $work as $id => $surfaces ) {
	if ( isset( $surfaces['title'] ) && $surfaces['title'] !== $orig[ $id ]['title'] ) {
		echo "RETITLE $id [{$pin[ $id ]['post_status']}]\n      - " . $orig[ $id ]['title'] . "\n      + " . $surfaces['title'] . "\n";
	}
}
ksort( $by_surface ); ksort( $by_status );
foreach ( $by_surface as $k => $v ) { echo "FIELDS $k: $v\n"; }
foreach ( $by_status as $k => $v ) { echo "POSTS status=$k: $v\n"; }
echo sprintf( "SUMMARY %s: %d replacements to make, %d already applied, %d fields, %d posts\n",
	$apply ? 'apply' : 'dry-run', $would, $done, count( $per_field ), count( $per_post ) );
if ( ! $apply ) { echo "DONE dry-run clean (nothing written)\n"; exit( 0 ); }

$dir = WP_CONTENT_DIR . '/uploads/roden-backups/' . $batch;
if ( ! is_dir( $dir ) && ! wp_mkdir_p( $dir ) ) { echo "ABORT: cannot create $dir\n"; exit( 1 ); }
// Back up every field that will change before any write.
foreach ( $work as $id => $surfaces ) {
	foreach ( $surfaces as $s => $val ) {
		if ( $val === $orig[ $id ][ $s ] ) { continue; }
		$f = "$dir/$id-" . ltrim( $s, '_' ) . '.json';
		if ( file_exists( $f ) ) { continue; } // keep the first (pre-change) backup on re-runs
		if ( false === file_put_contents( $f, wp_json_encode( $orig[ $id ][ $s ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) ) ) {
			echo "ABORT: backup failed $f\n"; exit( 1 );
		}
	}
}
echo "backups: $dir\n";

/*
 * Status and slug never change. post_status is passed explicitly (unchanged),
 * and a last-priority wp_insert_post_data filter pins post_status / post_name /
 * post_parent to the values read above for the post being written — belt and
 * braces against any filter that would move it. The theme's location-freeze and
 * permutation guards only act on a transition to publish, so they do not fire
 * here. _roden_content_modified is NOT stamped: roden_record_content_change()
 * only stamps published posts, and a draft gets its dates when it publishes.
 */
$writing = 0; $pinned = array();
$pin_filter = function ( $data, $postarr ) use ( &$writing, &$pin, &$pinned ) {
	$id = isset( $postarr['ID'] ) ? (int) $postarr['ID'] : 0;
	if ( ! $writing || $id !== $writing ) { return $data; }
	foreach ( array( 'post_status', 'post_name', 'post_parent' ) as $k ) {
		if ( (string) $data[ $k ] !== (string) $pin[ $id ][ $k ] ) { $pinned[] = "$id $k: " . $data[ $k ] . ' -> ' . $pin[ $id ][ $k ]; $data[ $k ] = $pin[ $id ][ $k ]; }
	}
	return $data;
};
add_filter( 'wp_insert_post_data', $pin_filter, PHP_INT_MAX, 2 );

foreach ( $work as $id => $surfaces ) {
	$postarr = array( 'ID' => $id, 'post_status' => $pin[ $id ]['post_status'] ); $core_changed = false;
	foreach ( $surfaces as $s => $val ) {
		if ( $val === $orig[ $id ][ $s ] ) { continue; }
		if ( isset( $core[ $s ] ) ) { $postarr[ $core[ $s ] ] = $val; $core_changed = true; }
	}
	if ( $core_changed ) {
		$writing = $id;
		$r = wp_update_post( wp_slash( $postarr ), true );
		$writing = 0;
		if ( is_wp_error( $r ) ) { echo "FAILED write $id: " . $r->get_error_message() . "\n"; exit( 1 ); }
	}
	foreach ( $surfaces as $s => $val ) {
		if ( $val === $orig[ $id ][ $s ] || isset( $core[ $s ] ) ) { continue; }
		update_post_meta( $id, $s, wp_slash( $val ) );
	}
	clean_post_cache( $id ); wp_cache_delete( $id, 'post_meta' );
	// Read back from the tables, not the cache.
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT post_title, post_excerpt, post_content, post_name, post_status, post_parent FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	if ( $row->post_status !== $pin[ $id ]['post_status'] ) { echo "FAILED status changed on $id: {$row->post_status}\n"; exit( 1 ); }
	if ( $row->post_name !== $pin[ $id ]['post_name'] ) { echo "FAILED slug changed on $id: {$row->post_name}\n"; exit( 1 ); }
	if ( (int) $row->post_parent !== $pin[ $id ]['post_parent'] ) { echo "FAILED parent changed on $id\n"; exit( 1 ); }
	foreach ( $surfaces as $s => $val ) {
		if ( isset( $core[ $s ] ) ) {
			$back = $row->{ $core[ $s ] };
		} else {
			$back = maybe_unserialize( $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = %s", $id, $s ) ) );
		}
		if ( $back !== $val ) { echo "FAILED read-back $id $s\n"; exit( 1 ); }
	}
	echo "read-back OK $id [{$row->post_status}]\n";
}
remove_filter( 'wp_insert_post_data', $pin_filter, PHP_INT_MAX );
if ( $pinned ) { echo "NOTE pinned (a filter tried to move these; held):\n  " . implode( "\n  ", $pinned ) . "\n"; }
echo "DONE apply clean. Next: wp cache flush && wp page-cache flush; php bin/check-unslashed-post-writes.php | wp eval-file -\n";
exit( 0 );
