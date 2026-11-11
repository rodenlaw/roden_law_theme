<?php
/**
 * South Carolina comparative fault: "less than 51%" / "51% or more" / "51% bar"
 * -> the house wording "50% or less" / "more than 50%" (Nelson v. Concrete
 * Supply Co., 303 S.C. 243 (1991), signed SC authority). Spanish: "del 50% o
 * menos" / "de más del 50%". Database follow-up to theme PR #342 (merged
 * 2026-11-11). Owner-approved 2026-11-11 ("do the 203 database pages"),
 * including the retitles of 4811, 4930 and 5352, the "51% bar" FAQ questions
 * (4811[1], 4814[11], 4930[1], 4937[28]) and the comparison-table rows on
 * 5352, 4930 and 1707. Slugs/URLs do not change (checked on read-back).
 *
 * Only South Carolina's rule changes. Georgia's "less than 50%" / "50% or more"
 * (O.C.G.A. § 51-12-33) is untouched; where a sentence compares the states,
 * both sides now read right (GA barred at 50% or more; SC barred above 50%).
 * True illustrations stay ("if you are 51% at fault, you recover $0"), as does
 * 6313's GHSA statistic ("51% of motorcyclists killed"). No new legal claim and
 * no § 15-38-15 cite for the SC rule.
 *
 * The six pillar-intro fields that carried {comp_fault_threshold} ("{X} or more
 * at fault", which would print "51% or more" for SC) move to {comp_fault_bar}
 * (#342). They have not rendered since #254; once applied, firm-data.php's
 * comp_fault_bar_pct pin can be deleted.
 *
 * Surfaces: post_title, post_excerpt, post_content, _roden_faqs (question and
 * answer; feeds FAQPage JSON-LD), _roden_key_takeaways, _roden_meta_description,
 * _roden_see_also link text, _roden_pillar_*_intro.
 *
 * Mechanics: the table below was generated from a read-only prod scan
 * (2026-11-11) and reviewed. Every anchor must match exactly once (or be
 * already applied) on every surface before anything is written; any miss
 * aborts the whole run. str_replace only. Backups of every changed field go to
 * uploads/roden-backups/<batch>/ before the first write; writes use wp_slash;
 * each post is read back from the tables (and its slug compared).
 * _roden_content_modified is stamped where visible text changed (not for
 * see-also-only or pillar-intro-only posts).
 *
 *   H=rodenlawprod@rodenlawprod.ssh.wpengine.net; P=/home/wpe-user/sites/rodenlawprod
 *   ssh $H "wp --path=$P eval-file -"       < bin/apply-sc-comp-fault-50-wording-2026-11-11.php   # dry run
 *   ssh $H "wp --path=$P eval-file - apply" < bin/apply-sc-comp-fault-50-wording-2026-11-11.php
 * then: wp cache flush && wp page-cache flush; php bin/check-unslashed-post-writes.php
 * (static) and piped to wp eval-file (live JSON-LD); re-export content/meta.json.
 */
$batch = 'sc-comp-fault-50-wording-2026-11-11';
$expected_rows = 523;
$table_json = <<<'EDITS'
[
 {
  "id": 1647,
  "field": "_roden_faqs:5:answer",
  "find": "recovery if you are less than 51% at fault. Your compensation",
  "replace": "recovery if you are 50% or less at fault. Your compensation"
 },
 {
  "id": 1647,
  "field": "_roden_key_takeaways",
  "find": "§ 15-3-530) with fault under 51%. Prompt spoliation letters are",
  "replace": "§ 15-3-530) with fault of 50% or less. Prompt spoliation letters are"
 },
 {
  "id": 1647,
  "field": "content",
  "find": "damages if they are less than 51% at fault — providing",
  "replace": "damages if they are 50% or less at fault — providing"
 },
 {
  "id": 1649,
  "field": "content",
  "find": "recover if you are less than 51% at fault (Nelson v.",
  "replace": "recover if you are 50% or less at fault (Nelson v."
 },
 {
  "id": 1651,
  "field": "_roden_faqs:4:answer",
  "find": "nothing if you are 51% or more at fault (Nelson v.",
  "replace": "nothing if you are more than 50% at fault (Nelson v."
 },
 {
  "id": 1651,
  "field": "_roden_key_takeaways",
  "find": "(O.C.G.A. § 51-12-33) and 51% in South Carolina (Nelson",
  "replace": "(O.C.G.A. § 51-12-33) and above 50% in South Carolina (Nelson"
 },
 {
  "id": 1651,
  "field": "content",
  "find": " as you are <strong>less than 51% at fault</strong>. Your",
  "replace": " as you are <strong>50% or less at fault</strong>. Your"
 },
 {
  "id": 1651,
  "field": "content",
  "find": "your percentage of fault. At 51% or more, you recover nothing.</li>\n",
  "replace": "your percentage of fault. Above 50%, you recover nothing.</li>\n"
 },
 {
  "id": 1653,
  "field": "_roden_faqs:2:answer",
  "find": "recovery if you are less than 51% at fault (Nelson v.",
  "replace": "recovery if you are 50% or less at fault (Nelson v."
 },
 {
  "id": 1653,
  "field": "_roden_key_takeaways",
  "find": "South Carolina bars recovery at 51% or more (Nelson v. Concrete Supply",
  "replace": "South Carolina bars recovery above 50% (Nelson v. Concrete Supply"
 },
 {
  "id": 1653,
  "field": "content",
  "find": " if you are <strong>less than 51%</strong> at fault (<a href=\"https://law.justia.com/cases/south-carolina/supreme-court/1991/23303-2.html\">",
  "replace": " if you are <strong>50% or less</strong> at fault (<a href=\"https://law.justia.com/cases/south-carolina/supreme-court/1991/23303-2.html\">"
 },
 {
  "id": 1653,
  "field": "content",
  "find": "= no recovery</td>\n<td>51% or more at fault = no",
  "replace": "= no recovery</td>\n<td>More than 50% at fault = no"
 },
 {
  "id": 1654,
  "field": "_roden_key_takeaways",
  "find": "Carolina bars it only at 51 percent, so a driver",
  "replace": "Carolina bars it only above 50 percent, so a driver"
 },
 {
  "id": 1654,
  "field": "content",
  "find": "but bars recovery only at 51 percent (<em>Nelson v.",
  "replace": "but bars recovery only above 50 percent (<em>Nelson v."
 },
 {
  "id": 1657,
  "field": "_roden_key_takeaways",
  "find": "50% or less at fault (less than 51%). Injury lawsuit deadlines: 2",
  "replace": "50% or less at fault. Injury lawsuit deadlines: 2"
 },
 {
  "id": 1657,
  "field": "content",
  "find": "than 50% at fault</strong> (effectively less than 51%). Your damages are reduced",
  "replace": "than 50% at fault</strong>. Your damages are reduced"
 },
 {
  "id": 1661,
  "field": "_roden_faqs:3:answer",
  "find": "are not more than 51% at fault. In both",
  "replace": "are not more than 50% at fault. In both"
 },
 {
  "id": 1661,
  "field": "_roden_key_takeaways",
  "find": "if not more than 51% at fault. Filing deadlines",
  "replace": "if not more than 50% at fault. Filing deadlines"
 },
 {
  "id": 1661,
  "field": "content",
  "find": " <strong>not more than 51% at fault</strong>. Like",
  "replace": " <strong>not more than 50% at fault</strong>. Like"
 },
 {
  "id": 1663,
  "field": "_roden_faqs:4:answer",
  "find": "long as you are less than 51% at fault (Nelson v.",
  "replace": "long as you are 50% or less at fault (Nelson v."
 },
 {
  "id": 1663,
  "field": "content",
  "find": " as you are <strong>less than 51% at fault</strong>. Your",
  "replace": " as you are <strong>50% or less at fault</strong>. Your"
 },
 {
  "id": 1663,
  "field": "content",
  "find": "fault. If you are 51% or more at fault, you recover",
  "replace": "fault. If you are more than 50% at fault, you recover"
 },
 {
  "id": 1664,
  "field": "_roden_faqs:3:answer",
  "find": "recovery if you are less than 51% at fault. Scene photos,",
  "replace": "recovery if you are 50% or less at fault. Scene photos,"
 },
 {
  "id": 1664,
  "field": "content",
  "find": "damages if you are less than 51% at fault. The <strong>",
  "replace": "damages if you are 50% or less at fault. The <strong>"
 },
 {
  "id": 1664,
  "field": "content",
  "find": " 50%</td><td>Modified — less than 51%</td></tr>\n<tr><td>Helmet Requirement",
  "replace": " 50%</td><td>Modified — 50% or less</td></tr>\n<tr><td>Helmet Requirement"
 },
 {
  "id": 1665,
  "field": "_roden_faqs:1:answer",
  "find": "South Carolina bars recovery at 51% or more fault. Identifying all liable",
  "replace": "South Carolina bars recovery above 50% fault. Identifying all liable"
 },
 {
  "id": 1665,
  "field": "_roden_key_takeaways",
  "find": "15-3-530) and bars recovery at 51% fault. Multiple parties may",
  "replace": "15-3-530) and bars recovery above 50% fault. Multiple parties may"
 },
 {
  "id": 1665,
  "field": "content",
  "find": "meaning if you are 51% or more responsible, you are barred",
  "replace": "meaning if you are more than 50% responsible, you are barred"
 },
 {
  "id": 1666,
  "field": "content",
  "find": "</strong> system (barring recovery at 51% or more fault) in personal injury",
  "replace": "</strong> system (barring recovery above 50% fault) in personal injury"
 },
 {
  "id": 1667,
  "field": "_roden_key_takeaways",
  "find": "South Carolina bars recovery at 51% fault with a three-year",
  "replace": "South Carolina bars recovery above 50% fault with a three-year"
 },
 {
  "id": 1667,
  "field": "content",
  "find": " the plaintiff is <strong>less than 51%</strong> at fault — ",
  "replace": " the plaintiff is <strong>50% or less</strong> at fault — "
 },
 {
  "id": 1668,
  "field": "content",
  "find": " 50%</td><td>Modified — less than 51%</td></tr>\n</tbody>\n</table>\n\n<h2 id=\"proving-your-case\">",
  "replace": " 50%</td><td>Modified — 50% or less</td></tr>\n</tbody>\n</table>\n\n<h2 id=\"proving-your-case\">"
 },
 {
  "id": 1669,
  "field": "_roden_faqs:4:answer",
  "find": "recovery if you are less than 51% at fault. Your compensation",
  "replace": "recovery if you are 50% or less at fault. Your compensation"
 },
 {
  "id": 1669,
  "field": "_roden_key_takeaways",
  "find": "§ 15-3-530) with fault under 51%.",
  "replace": "§ 15-3-530) with fault of 50% or less."
 },
 {
  "id": 1669,
  "field": "content",
  "find": "long as you are less than 51% at fault. Like Georgia,",
  "replace": "long as you are 50% or less at fault. Like Georgia,"
 },
 {
  "id": 1669,
  "field": "content",
  "find": " fault</td><td>Modified — less than 51% at fault</td></tr>\n<tr>",
  "replace": " fault</td><td>Modified — 50% or less at fault</td></tr>\n<tr>"
 },
 {
  "id": 1670,
  "field": "_roden_faqs:4:answer",
  "find": "Carolina, the threshold is 51% — the injured party",
  "replace": "Carolina, the threshold is more than 50% — the injured party"
 },
 {
  "id": 1670,
  "field": "_roden_faqs:4:answer",
  "find": "barred if they are 51% or more at fault.",
  "replace": "barred if they are more than 50% at fault."
 },
 {
  "id": 1670,
  "field": "content",
  "find": " if they are <strong>less than 51% at fault</strong>. If they are 51% or more responsible, they are barred",
  "replace": " if they are <strong>50% or less at fault</strong>. If they are more than 50% responsible, they are barred"
 },
 {
  "id": 1671,
  "field": "_roden_faqs:3:answer",
  "find": "more than 50% at fault (less than 51%). In both states, your",
  "replace": "more than 50% at fault. In both states, your"
 },
 {
  "id": 1671,
  "field": "_roden_key_takeaways",
  "find": "15-3-530) with a bar at 51% fault. Never give a",
  "replace": "15-3-530) with a bar above 50% fault. Never give a"
 },
 {
  "id": 1671,
  "field": "content",
  "find": "more than 50% at fault (i.e., less than 51%). Your recovery is reduced",
  "replace": "more than 50% at fault. Your recovery is reduced"
 },
 {
  "id": 1672,
  "field": "content",
  "find": "more at fault</td>\n<td>51% or more at fault</td>\n</tr>\n",
  "replace": "more at fault</td>\n<td>More than 50% at fault</td>\n</tr>\n"
 },
 {
  "id": 1673,
  "field": "_roden_faqs:2:answer",
  "find": " as you are <strong>less than 51% at fault</strong>. If you are 51% or more responsible for the accident,",
  "replace": " as you are <strong>50% or less at fault</strong>. If you are more than 50% responsible for the accident,"
 },
 {
  "id": 1673,
  "field": "_roden_key_takeaways",
  "find": "South Carolina's threshold is 51%. Filing deadlines are strict",
  "replace": "South Carolina's threshold is more than 50%. Filing deadlines are strict"
 },
 {
  "id": 1673,
  "field": "content",
  "find": "(O.C.G.A. § 51-12-33)</td>\n<td>51% or more at fault</td>\n</tr>\n",
  "replace": "(O.C.G.A. § 51-12-33)</td>\n<td>More than 50% at fault</td>\n</tr>\n"
 },
 {
  "id": 1673,
  "field": "content",
  "find": "responsible in Georgia or less than 51% in South Carolina. Insurance",
  "replace": "responsible in Georgia or 50% or less in South Carolina. Insurance"
 },
 {
  "id": 1673,
  "field": "content",
  "find": "fault in Georgia (or 51% in South Carolina), you",
  "replace": "fault in Georgia (or more than 50% in South Carolina), you"
 },
 {
  "id": 1675,
  "field": "_roden_faqs:3:answer",
  "find": "Carolina, the threshold is 51%. If the other driver",
  "replace": "Carolina, the threshold is more than 50%. If the other driver"
 },
 {
  "id": 1675,
  "field": "_roden_faqs:5:answer",
  "find": "than 50% in Georgia, less than 51% in South Carolina. An",
  "replace": "than 50% in Georgia, 50% or less in South Carolina. An"
 },
 {
  "id": 1675,
  "field": "content",
  "find": "more at fault</td>\n<td>51% or more at fault</td>\n</tr>\n",
  "replace": "more at fault</td>\n<td>More than 50% at fault</td>\n</tr>\n"
 },
 {
  "id": 1675,
  "field": "content",
  "find": "fault in Georgia (or 51% in South Carolina), they",
  "replace": "fault in Georgia (or more than 50% in South Carolina), they"
 },
 {
  "id": 1675,
  "field": "content",
  "find": "than 50% in Georgia, less than 51% in South Carolina. An",
  "replace": "than 50% in Georgia, 50% or less in South Carolina. An"
 },
 {
  "id": 1679,
  "field": "_roden_faqs:3:answer",
  "find": "long as you are less than 51% at fault (Nelson v.",
  "replace": "long as you are 50% or less at fault (Nelson v."
 },
 {
  "id": 1679,
  "field": "content",
  "find": " as you are <strong>less than 51% at fault</strong>. Your",
  "replace": " as you are <strong>50% or less at fault</strong>. Your"
 },
 {
  "id": 1681,
  "field": "content",
  "find": "recover if you are less than 51% at fault</td>\n</tr>\n",
  "replace": "recover if you are 50% or less at fault</td>\n</tr>\n"
 },
 {
  "id": 1683,
  "field": "_roden_faqs:4:answer",
  "find": "Carolina, the threshold is 51%. In both states, your",
  "replace": "Carolina, the threshold is more than 50%. In both states, your"
 },
 {
  "id": 1683,
  "field": "_roden_key_takeaways",
  "find": "§ 15-3-530) with a less-than-51% fault threshold. Attorneys work",
  "replace": "§ 15-3-530) with a 50%-or-less fault threshold. Attorneys work"
 },
 {
  "id": 1683,
  "field": "content",
  "find": "(O.C.G.A. § 51-12-33)</td>\r\n<td>Less than 51% at fault to recover",
  "replace": "(O.C.G.A. § 51-12-33)</td>\r\n<td>50% or less at fault to recover"
 },
 {
  "id": 1686,
  "field": "content",
  "find": "only if you are less than 51% at fault. If you are found 51% or more at fault, you are",
  "replace": "only if you are 50% or less at fault. If you are found more than 50% at fault, you are"
 },
 {
  "id": 1692,
  "field": "content",
  "find": "Carolina, the threshold is 51%. Fault allocation is negotiable",
  "replace": "Carolina, the threshold is more than 50%. Fault allocation is negotiable"
 },
 {
  "id": 1695,
  "field": "content",
  "find": "South Carolina's threshold is 51%.</p>\n\n<h2 id=\"when-both\">When You Can",
  "replace": "South Carolina's threshold is more than 50%.</p>\n\n<h2 id=\"when-both\">When You Can"
 },
 {
  "id": 1695,
  "field": "content",
  "find": "South Carolina's threshold is 51%.</p>\n\n<h2 id=\"filing-deadlines\">Filing Deadlines in",
  "replace": "South Carolina's threshold is more than 50%.</p>\n\n<h2 id=\"filing-deadlines\">Filing Deadlines in"
 },
 {
  "id": 1698,
  "field": "content",
  "find": "barred if you are 51% or more at fault.</li>\n</ul>\n\n",
  "replace": "barred if you are more than 50% at fault.</li>\n</ul>\n\n"
 },
 {
  "id": 1702,
  "field": "content",
  "find": "(O.C.G.A. § 51-12-33)</td>\n<td>Less than 51% at fault to recover",
  "replace": "(O.C.G.A. § 51-12-33)</td>\n<td>50% or less at fault to recover"
 },
 {
  "id": 1703,
  "field": "_roden_faqs:1:answer",
  "find": "similar rule with a 51% threshold. The key question",
  "replace": "similar rule with a more-than-50% threshold. The key question"
 },
 {
  "id": 1703,
  "field": "_roden_faqs:4:answer",
  "find": "recovery if you are less than 51% at fault, which is",
  "replace": "recovery if you are 50% or less at fault, which is"
 },
 {
  "id": 1703,
  "field": "_roden_key_takeaways",
  "find": "Carolina sets the threshold at 51%. Both states follow evidentiary",
  "replace": "Carolina sets the threshold above 50%. Both states follow evidentiary"
 },
 {
  "id": 1703,
  "field": "content",
  "find": " as you are <strong>less than 51% at fault</strong>. Like",
  "replace": " as you are <strong>50% or less at fault</strong>. Like"
 },
 {
  "id": 1703,
  "field": "content",
  "find": "proportionally. If you are 51% or more at fault, you are",
  "replace": "proportionally. If you are more than 50% at fault, you are"
 },
 {
  "id": 1703,
  "field": "content",
  "find": "(O.C.G.A. § 51-12-33)</td>\n<td>Less than 51%</td>\n</tr>\n<tr>\n<td>Statute",
  "replace": "(O.C.G.A. § 51-12-33)</td>\n<td>50% or less</td>\n</tr>\n<tr>\n<td>Statute"
 },
 {
  "id": 1704,
  "field": "content",
  "find": "(O.C.G.A. § 51-12-33)</td>\n<td>Less than 51% (<em>Nelson v. Concrete",
  "replace": "(O.C.G.A. § 51-12-33)</td>\n<td>50% or less (<em>Nelson v. Concrete"
 },
 {
  "id": 1705,
  "field": "content",
  "find": "as the plaintiff is less than 51% at fault. With a",
  "replace": "as the plaintiff is 50% or less at fault. With a"
 },
 {
  "id": 1706,
  "field": "_roden_faqs:5:answer",
  "find": "Carolina, the threshold is 51% — you can recover",
  "replace": "Carolina, the threshold is more than 50% — you can recover"
 },
 {
  "id": 1706,
  "field": "_roden_faqs:5:answer",
  "find": "your fault does not equal or exceed 51%. Both states reduce your",
  "replace": "your fault does not exceed 50%. Both states reduce your"
 },
 {
  "id": 1706,
  "field": "_roden_key_takeaways",
  "find": "§ 15-3-530) with a 51% fault threshold. Self-employed and",
  "replace": "§ 15-3-530) with a more-than-50% fault threshold. Self-employed and"
 },
 {
  "id": 1706,
  "field": "content",
  "find": "Modified — barred if 51% or more at fault</td>\n</tr>\n",
  "replace": "Modified — barred if more than 50% at fault</td>\n</tr>\n"
 },
 {
  "id": 1706,
  "field": "content",
  "find": " you are found <strong>51% or more at fault</strong>. This",
  "replace": " you are found <strong>more than 50% at fault</strong>. This"
 },
 {
  "id": 1706,
  "field": "content",
  "find": "difference between a 50% and 51% bar can mean the",
  "replace": "difference between a 50% bar and a more-than-50% bar can mean the"
 },
 {
  "id": 1707,
  "field": "content",
  "find": " system with a <strong>51% bar</strong>. You can",
  "replace": " system with a <strong>more-than-50% bar</strong>. You can"
 },
 {
  "id": 1707,
  "field": "content",
  "find": "your fault does not equal or exceed 51% of the total. This",
  "replace": "your fault does not exceed 50% of the total. This"
 },
 {
  "id": 1707,
  "field": "content",
  "find": "51-12-33)</td>\n      <td>Modified — less than 51%</td>\n    </tr>\n    <tr>\n      <td>Statute",
  "replace": "51-12-33)</td>\n      <td>Modified — 50% or less</td>\n    </tr>\n    <tr>\n      <td>Statute"
 },
 {
  "id": 1707,
  "field": "content",
  "find": "South Carolina's more plaintiff-friendly 51% bar can be the",
  "replace": "South Carolina's more plaintiff-friendly more-than-50% bar can be the"
 },
 {
  "id": 1708,
  "field": "content",
  "find": "long as they are less than 51 percent at fault — slightly",
  "replace": "long as they are 50 percent or less at fault — slightly"
 },
 {
  "id": 1708,
  "field": "content",
  "find": "O.C.G.A. § 51-12-33</td>\n<td>Less than 51% at fault</td>\n</tr>\n",
  "replace": "O.C.G.A. § 51-12-33</td>\n<td>50% or less at fault</td>\n</tr>\n"
 },
 {
  "id": 1711,
  "field": "content",
  "find": "Modified — barred if 51% or more at fault</td>\n</tr>\n",
  "replace": "Modified — barred if more than 50% at fault</td>\n</tr>\n"
 },
 {
  "id": 1711,
  "field": "content",
  "find": "as your fault stays below 51%.</p>\n\n<h2 id=\"negotiating-liens\">How to Negotiate",
  "replace": "as your fault stays at or below 50%.</p>\n\n<h2 id=\"negotiating-liens\">How to Negotiate"
 },
 {
  "id": 1712,
  "field": "content",
  "find": "recovery if you are 51% or more at fault. As in",
  "replace": "recovery if you are more than 50% at fault. As in"
 },
 {
  "id": 1712,
  "field": "content",
  "find": "(O.C.G.A. &sect; 51-12-33)</td>\n<td>51% or more at fault = no",
  "replace": "(O.C.G.A. &sect; 51-12-33)</td>\n<td>More than 50% at fault = no"
 },
 {
  "id": 1713,
  "field": "content",
  "find": "if your fault was less than 51%. Eyewitness testimony directly affects",
  "replace": "if your fault was 50% or less. Eyewitness testimony directly affects"
 },
 {
  "id": 1713,
  "field": "content",
  "find": "— plaintiff recovers if less than 51% at fault</td>\n</tr>\n",
  "replace": "— plaintiff recovers if 50% or less at fault</td>\n</tr>\n"
 },
 {
  "id": 1714,
  "field": "content",
  "find": "long as you are less than 51% at fault. Similar to",
  "replace": "long as you are 50% or less at fault. Similar to"
 },
 {
  "id": 1714,
  "field": "content",
  "find": "(barred from recovery)</td>\r\n<td>51%+</td>\r\n<td>",
  "replace": "(barred from recovery)</td>\r\n<td>More than 50%</td>\r\n<td>"
 },
 {
  "id": 1715,
  "field": "content",
  "find": "\n<td>Modified — barred at 51% or more fault</td>\n</tr>\n<tr>\n",
  "replace": "\n<td>Modified — barred above 50% fault</td>\n</tr>\n<tr>\n"
 },
 {
  "id": 1715,
  "field": "content",
  "find": "threshold is slightly more forgiving at 51%. In either state, insurance",
  "replace": "threshold is slightly more forgiving: recovery is barred only above 50%. In either state, insurance"
 },
 {
  "id": 1716,
  "field": "_roden_faqs:3:answer",
  "find": "South Carolina's threshold is 51%. If both drivers failed",
  "replace": "South Carolina's threshold is more than 50%. If both drivers failed"
 },
 {
  "id": 1716,
  "field": "_roden_key_takeaways",
  "find": "§ 51-12-33), South Carolina at 51%. Government entities may share",
  "replace": "§ 51-12-33), South Carolina above 50%. Government entities may share"
 },
 {
  "id": 1716,
  "field": "content",
  "find": "Modified &mdash; recover if less than 51% at fault</td>\n</tr>\n",
  "replace": "Modified &mdash; recover if 50% or less at fault</td>\n</tr>\n"
 },
 {
  "id": 1716,
  "field": "content",
  "find": " as you are <strong>less than 51% at fault</strong>. This",
  "replace": " as you are <strong>50% or less at fault</strong>. This"
 },
 {
  "id": 1717,
  "field": "content",
  "find": "as their fault is less than 51%. If a claimant is found 51% or more at fault, they are",
  "replace": "as their fault is 50% or less. If a claimant is found more than 50% at fault, they are"
 },
 {
  "id": 1717,
  "field": "content",
  "find": "\n<td>Modified — barred at 51% or more</td>\n</tr>\n<tr>\n<td>Statute",
  "replace": "\n<td>Modified — barred above 50%</td>\n</tr>\n<tr>\n<td>Statute"
 },
 {
  "id": 1717,
  "field": "content",
  "find": "bar and South Carolina's 51% threshold mean fault percentages",
  "replace": "bar and South Carolina's more-than-50% threshold mean fault percentages"
 },
 {
  "id": 1718,
  "field": "content",
  "find": "your fault does not reach 51%. But the same mitigation",
  "replace": "your fault does not exceed 50%. But the same mitigation"
 },
 {
  "id": 1718,
  "field": "content",
  "find": "\n<td>Modified — barred at 51% fault</td>\n</tr>\n<tr>\n",
  "replace": "\n<td>Modified — barred above 50% fault</td>\n</tr>\n<tr>\n"
 },
 {
  "id": 1719,
  "field": "content",
  "find": "if you are found 51% or more at fault. A casual",
  "replace": "if you are found more than 50% at fault. A casual"
 },
 {
  "id": 1719,
  "field": "content",
  "find": "\n<td>Modified — barred at 51% fault</td>\n</tr>\n<tr>\n",
  "replace": "\n<td>Modified — barred above 50% fault</td>\n</tr>\n<tr>\n"
 },
 {
  "id": 1720,
  "field": "content",
  "find": "\n<td>Modified — barred at 51% or more fault</td>\n</tr>\n<tr>\n",
  "replace": "\n<td>Modified — barred above 50% fault</td>\n</tr>\n<tr>\n"
 },
 {
  "id": 1720,
  "field": "content",
  "find": "Carolina, the threshold is 51%. An experienced attorney can",
  "replace": "Carolina, the threshold is more than 50%. An experienced attorney can"
 },
 {
  "id": 1722,
  "field": "content",
  "find": " if you are <strong>51% or more</strong> at fault. This ",
  "replace": " if you are <strong>more than 50%</strong> at fault. This "
 },
 {
  "id": 1722,
  "field": "content",
  "find": "&#167; 51-12-33)</td>\n<td>Barred at 51% or more fault (<em>Nelson v.",
  "replace": "&#167; 51-12-33)</td>\n<td>Barred above 50% fault (<em>Nelson v."
 },
 {
  "id": 1723,
  "field": "content",
  "find": "long as you are less than <strong>51% at fault</strong>. As",
  "replace": "long as you are <strong>50% or less at fault</strong>. As"
 },
 {
  "id": 1723,
  "field": "content",
  "find": "(O.C.G.A. &#167; 51-12-33)</td>\n<td>Less than 51% at fault</td>\n</tr>\n",
  "replace": "(O.C.G.A. &#167; 51-12-33)</td>\n<td>50% or less at fault</td>\n</tr>\n"
 },
 {
  "id": 1724,
  "field": "content",
  "find": "if the plaintiff is less than 51% at fault.</p>\n\n<p>This",
  "replace": "if the plaintiff is 50% or less at fault.</p>\n\n<p>This"
 },
 {
  "id": 1724,
  "field": "content",
  "find": "\n<td>Plaintiff must be less than 51% at fault</td>\n</tr>\n",
  "replace": "\n<td>Plaintiff must be 50% or less at fault</td>\n</tr>\n"
 },
 {
  "id": 1740,
  "field": "_roden_faqs:1:answer",
  "find": "threshold (50% in GA, 51% in SC) bars recovery.",
  "replace": "threshold (50% in GA, more than 50% in SC) bars recovery."
 },
 {
  "id": 1740,
  "field": "content",
  "find": "long as you are less than 51% at fault. South Carolina",
  "replace": "long as you are 50% or less at fault. South Carolina"
 },
 {
  "id": 1740,
  "field": "content",
  "find": "threshold (50% in Georgia, 51% in South Carolina) bars",
  "replace": "threshold (50% in Georgia, more than 50% in South Carolina) bars"
 },
 {
  "id": 1745,
  "field": "content",
  "find": " if you are <strong>51% or more</strong> at fault — ",
  "replace": " if you are <strong>more than 50%</strong> at fault — "
 },
 {
  "id": 1746,
  "field": "content",
  "find": "compensation if you are less than 51% at fault. The <strong>",
  "replace": "compensation if you are 50% or less at fault. The <strong>"
 },
 {
  "id": 1749,
  "field": "_roden_faqs:3:answer",
  "find": "you recover nothing if 51% or more at fault. Your compensation",
  "replace": "you recover nothing if more than 50% at fault. Your compensation"
 },
 {
  "id": 1749,
  "field": "_roden_key_takeaways",
  "find": "51-12-33); South Carolina bars at 51% (Nelson v. Concrete Supply",
  "replace": "51-12-33); South Carolina bars above 50% (Nelson v. Concrete Supply"
 },
 {
  "id": 1749,
  "field": "content",
  "find": " the plaintiff is <strong>less than 51% at fault</strong> (<a href=\"https://law.justia.com/cases/south-carolina/supreme-court/1991/23303-2.html\" target=\"_blank\" rel=\"noopener\">",
  "replace": " the plaintiff is <strong>50% or less at fault</strong> (<a href=\"https://law.justia.com/cases/south-carolina/supreme-court/1991/23303-2.html\" target=\"_blank\" rel=\"noopener\">"
 },
 {
  "id": 1753,
  "field": "content",
  "find": "only if you are 51% or more at fault — slightly",
  "replace": "only if you are more than 50% at fault — slightly"
 },
 {
  "id": 1756,
  "field": "_roden_faqs:4:answer",
  "find": "long as you are less than 51% at fault (Nelson v.",
  "replace": "long as you are 50% or less at fault (Nelson v."
 },
 {
  "id": 1756,
  "field": "_roden_key_takeaways",
  "find": "51-12-33); South Carolina's is 51% (Nelson v. Concrete Supply",
  "replace": "51-12-33); South Carolina's is more than 50% (Nelson v. Concrete Supply"
 },
 {
  "id": 1756,
  "field": "content",
  "find": "long as you are less than <strong>51% at fault</strong>. This",
  "replace": "long as you are <strong>50% or less at fault</strong>. This"
 },
 {
  "id": 1757,
  "field": "content",
  "find": "long as you are less than <strong>51% at fault</strong>. This",
  "replace": "long as you are <strong>50% or less at fault</strong>. This"
 },
 {
  "id": 1758,
  "field": "content",
  "find": "recovery if you are less than 51% at fault. Witness testimony",
  "replace": "recovery if you are 50% or less at fault. Witness testimony"
 },
 {
  "id": 1758,
  "field": "content",
  "find": "50% to recover</td>\r\n<td>Less than 51% to recover</td>\r\n</tr>\r\n",
  "replace": "50% to recover</td>\r\n<td>50% or less to recover</td>\r\n</tr>\r\n"
 },
 {
  "id": 1761,
  "field": "content",
  "find": "</strong> system (barring recovery at 51% or more fault) applies to <a href=\"/practice-areas/personal-injury-lawyers/\">",
  "replace": "</strong> system (barring recovery above 50% fault) applies to <a href=\"/practice-areas/personal-injury-lawyers/\">"
 },
 {
  "id": 1767,
  "field": "_roden_faqs:0:answer",
  "find": "(O.C.G.A. § 51-12-33) and less than 51% in South Carolina (Nelson",
  "replace": "(O.C.G.A. § 51-12-33) and 50% or less in South Carolina (Nelson"
 },
 {
  "id": 1767,
  "field": "_roden_key_takeaways",
  "find": "51-12-33); South Carolina if less than 51% (Nelson v. Concrete Supply",
  "replace": "51-12-33); South Carolina if 50% or less (Nelson v. Concrete Supply"
 },
 {
  "id": 1767,
  "field": "content",
  "find": "51-12-33)</td>\r\n<td>Must be less than 51% at fault (<em>Nelson",
  "replace": "51-12-33)</td>\r\n<td>Must be 50% or less at fault (<em>Nelson"
 },
 {
  "id": 1767,
  "field": "content",
  "find": "the pedestrian's fault reaches or exceeds the state's threshold (50% in Georgia, 51% in South Carolina), recovery",
  "replace": "the pedestrian's fault reaches the state's bar (50% or more in Georgia, more than 50% in South Carolina), recovery"
 },
 {
  "id": 1767,
  "field": "content",
  "find": "share of fault is less than 51% (<em>Nelson v. Concrete",
  "replace": "share of fault is 50% or less (<em>Nelson v. Concrete"
 },
 {
  "id": 1769,
  "field": "content",
  "find": "damages if you are less than 51% at fault, providing slightly",
  "replace": "damages if you are 50% or less at fault, providing slightly"
 },
 {
  "id": 1772,
  "field": "_roden_key_takeaways",
  "find": "at 50% fault, SC at 51%. Neither state caps non-economic",
  "replace": "at 50% fault, SC above 50%. Neither state caps non-economic"
 },
 {
  "id": 1772,
  "field": "content",
  "find": "only if you are 51% or more at fault. The <strong>",
  "replace": "only if you are more than 50% at fault. The <strong>"
 },
 {
  "id": 1773,
  "field": "_roden_faqs:2:answer",
  "find": "recover if you were less than 51% at fault. Your compensation",
  "replace": "recover if you were 50% or less at fault. Your compensation"
 },
 {
  "id": 1773,
  "field": "_roden_key_takeaways",
  "find": "51-12-33) and South Carolina at 51%. Fault is determined through",
  "replace": "51-12-33) and South Carolina above 50%. Fault is determined through"
 },
 {
  "id": 1773,
  "field": "content",
  "find": "You can recover if less than 51% at fault</td></tr>\n<tr>",
  "replace": "You can recover if 50% or less at fault</td></tr>\n<tr>"
 },
 {
  "id": 1773,
  "field": "content",
  "find": "at fault in Georgia—or 51% or more in South Carolina—you cannot",
  "replace": "at fault in Georgia—or more than 50% in South Carolina—you cannot"
 },
 {
  "id": 1790,
  "field": "_roden_key_takeaways",
  "find": "50% fault, South Carolina at 51%).",
  "replace": "50% fault, South Carolina above 50%)."
 },
 {
  "id": 1790,
  "field": "content",
  "find": "(O.C.G.A. § 51-12-33)</td>\r\n<td>Less than 51% at fault</td>\r\n</tr>\r\n",
  "replace": "(O.C.G.A. § 51-12-33)</td>\r\n<td>50% or less at fault</td>\r\n</tr>\r\n"
 },
 {
  "id": 1790,
  "field": "content",
  "find": "Carolina, the threshold is 51%. When reconstruction evidence or",
  "replace": "Carolina, the threshold is more than 50%. When reconstruction evidence or"
 },
 {
  "id": 1796,
  "field": "_roden_faqs:5:answer",
  "find": "only if you were 51% or more at fault. Your compensation",
  "replace": "only if you were more than 50% at fault. Your compensation"
 },
 {
  "id": 1796,
  "field": "content",
  "find": "Modified — barred if 51% or more at fault</td></tr>\n<tr>",
  "replace": "Modified — barred if more than 50% at fault</td></tr>\n<tr>"
 },
 {
  "id": 1796,
  "field": "content",
  "find": "the injured person was 51% or more at fault. South Carolina",
  "replace": "the injured person was more than 50% at fault. South Carolina"
 },
 {
  "id": 1810,
  "field": "content",
  "find": "recovery if you are less than <strong>51% at fault</strong> — ",
  "replace": "recovery if you are <strong>50% or less at fault</strong> — "
 },
 {
  "id": 1811,
  "field": "_roden_key_takeaways",
  "find": "South Carolina's threshold is 51%. Pre-existing conditions are not",
  "replace": "South Carolina's threshold is more than 50%. Pre-existing conditions are not"
 },
 {
  "id": 1811,
  "field": "content",
  "find": "when the plaintiff is less than <strong>51% at fault</strong> (Nelson ",
  "replace": "when the plaintiff is <strong>50% or less at fault</strong> (Nelson "
 },
 {
  "id": 1811,
  "field": "content",
  "find": "threshold in South Carolina (51% vs. Georgia's 50%) provides additional protection for",
  "replace": "threshold in South Carolina (barred only above 50%, vs. at 50% in Georgia) provides additional protection for"
 },
 {
  "id": 1813,
  "field": "content",
  "find": "if your fault is less than 51%, with your award reduced",
  "replace": "if your fault is 50% or less, with your award reduced"
 },
 {
  "id": 1813,
  "field": "content",
  "find": "50%</td>\r\n<td>Modified — under 51%</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n",
  "replace": "50%</td>\r\n<td>Modified — 50% or less</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n"
 },
 {
  "id": 1816,
  "field": "_roden_faqs:3:answer",
  "find": "recovery if you are less than 51% at fault. In both",
  "replace": "recovery if you are 50% or less at fault. In both"
 },
 {
  "id": 1816,
  "field": "content",
  "find": "<td>Recovery barred if <strong>51% or more</strong> at fault</td>\n</tr>",
  "replace": "<td>Recovery barred if <strong>more than 50%</strong> at fault</td>\n</tr>"
 },
 {
  "id": 1823,
  "field": "_roden_key_takeaways",
  "find": "fault in GA and 51% in SC. Multiple parties",
  "replace": "fault in GA and above 50% in SC. Multiple parties"
 },
 {
  "id": 1823,
  "field": "content",
  "find": "damages if you are less than 51% at fault for the",
  "replace": "damages if you are 50% or less at fault for the"
 },
 {
  "id": 1831,
  "field": "_roden_faqs:4:answer",
  "find": "recover if you are less than 51% at fault. Your compensation",
  "replace": "recover if you are 50% or less at fault. Your compensation"
 },
 {
  "id": 1831,
  "field": "content",
  "find": "damages if you are less than 51% at fault. The <strong>",
  "replace": "damages if you are 50% or less at fault. The <strong>"
 },
 {
  "id": 1835,
  "field": "_roden_faqs:4:answer",
  "find": "recovery if you were less than 51% at fault. Your compensation",
  "replace": "recovery if you were 50% or less at fault. Your compensation"
 },
 {
  "id": 1835,
  "field": "content",
  "find": "— recovery barred if 51% or more at fault</td></tr>\n<tr>",
  "replace": "— recovery barred if more than 50% at fault</td></tr>\n<tr>"
 },
 {
  "id": 1835,
  "field": "content",
  "find": "long as you were less than 51% at fault. South Carolina",
  "replace": "long as you were 50% or less at fault. South Carolina"
 },
 {
  "id": 1838,
  "field": "_roden_faqs:0:answer",
  "find": "South Carolina follows a 51% bar rule under Nelson",
  "replace": "South Carolina follows a more-than-50% bar rule under Nelson"
 },
 {
  "id": 1838,
  "field": "_roden_faqs:0:answer",
  "find": "fault but are barred at 51% or more. In both states, your",
  "replace": "fault but are barred above 50%. In both states, your"
 },
 {
  "id": 1838,
  "field": "_roden_faqs:4:answer",
  "find": "Carolina, the bar is at 51% fault.",
  "replace": "Carolina, the bar is above 50% fault."
 },
 {
  "id": 1838,
  "field": "_roden_key_takeaways",
  "find": "Carolina sets the bar at 51% under Nelson v. Concrete",
  "replace": "Carolina sets the bar above 50% under Nelson v. Concrete"
 },
 {
  "id": 1838,
  "field": "content",
  "find": "<li><strong>Modified comparative negligence (51% bar):</strong> A plaintiff ",
  "replace": "<li><strong>Modified comparative negligence (more-than-50% bar):</strong> A plaintiff "
 },
 {
  "id": 1838,
  "field": "content",
  "find": "nothing. In South Carolina's 51% bar system, that same",
  "replace": "nothing. In South Carolina's more-than-50% bar system, that same"
 },
 {
  "id": 1838,
  "field": "content",
  "find": "negligence rule with a 51% bar</strong>, established in",
  "replace": "negligence rule with a more-than-50% bar</strong>, established in"
 },
 {
  "id": 1838,
  "field": "content",
  "find": "<li>If you are <strong>51% or more</strong> at fault, you ",
  "replace": "<li>If you are <strong>more than 50%</strong> at fault, you "
 },
 {
  "id": 1838,
  "field": "content",
  "find": "bar</td>\n<td>Modified — 51% bar</td>\n</tr>\n<tr>\n",
  "replace": "bar</td>\n<td>Modified — more-than-50% bar</td>\n</tr>\n<tr>\n"
 },
 {
  "id": 1838,
  "field": "content",
  "find": "fault or more</td>\n<td>51% fault or more</td>\n</tr>\n<tr>\n<td><strong>",
  "replace": "fault or more</td>\n<td>More than 50% fault</td>\n</tr>\n<tr>\n<td><strong>"
 },
 {
  "id": 1838,
  "field": "content",
  "find": "Carolina, the bar is at 51%.</p>\n\n<h3>Medical Malpractice</h3>\n",
  "replace": "Carolina, the bar is above 50%.</p>\n\n<h3>Medical Malpractice</h3>\n"
 },
 {
  "id": 1840,
  "field": "content",
  "find": "if the plaintiff is 51% or more at fault. As with",
  "replace": "if the plaintiff is more than 50% at fault. As with"
 },
 {
  "id": 1856,
  "field": "_roden_key_takeaways",
  "find": "51-12-33); South Carolina if less than 51% at fault. Filing deadlines",
  "replace": "51-12-33); South Carolina if 50% or less at fault. Filing deadlines"
 },
 {
  "id": 1856,
  "field": "content",
  "find": "than 50% at fault</strong> (effectively less than 51%). This means a pedestrian",
  "replace": "than 50% at fault</strong>. This means a pedestrian"
 },
 {
  "id": 1856,
  "field": "content",
  "find": " 50%</td><td>Modified — less than 51%</td></tr>\n<tr><td>Crosswalk Yield",
  "replace": " 50%</td><td>Modified — 50% or less</td></tr>\n<tr><td>Crosswalk Yield"
 },
 {
  "id": 2586,
  "field": "_roden_faqs:1:answer",
  "find": "long as you are less than 51% at fault (Nelson v.",
  "replace": "long as you are 50% or less at fault (Nelson v."
 },
 {
  "id": 2586,
  "field": "_roden_key_takeaways",
  "find": "§ 51-12-33), South Carolina at 51% or more (Nelson v. Concrete Supply",
  "replace": "§ 51-12-33), South Carolina above 50% (Nelson v. Concrete Supply"
 },
 {
  "id": 2586,
  "field": "content",
  "find": " as you are <strong>less than 51% at fault</strong>. Your",
  "replace": " as you are <strong>50% or less at fault</strong>. Your"
 },
 {
  "id": 2586,
  "field": "content",
  "find": "If you are found 51% or more at fault, you recover",
  "replace": "If you are found more than 50% at fault, you recover"
 },
 {
  "id": 2647,
  "field": "_roden_key_takeaways",
  "find": "South Carolina bars recovery at 51% or more fault (Nelson v. Concrete",
  "replace": "South Carolina bars recovery above 50% fault (Nelson v. Concrete"
 },
 {
  "id": 2647,
  "field": "content",
  "find": " as you are <strong>less than 51% at fault</strong>. Your",
  "replace": " as you are <strong>50% or less at fault</strong>. Your"
 },
 {
  "id": 3067,
  "field": "content",
  "find": "<li><a href=\"#percent\">How South Carolina’s 51 Percent Fault Rule Affects Brake-Checking",
  "replace": "<li><a href=\"#percent\">How South Carolina’s Modified Comparative Fault Rule Affects Brake-Checking"
 },
 {
  "id": 3067,
  "field": "content",
  "find": "\r\n<h2 id=\"percent\">How South Carolina’s 51 Percent Fault Rule Affects Brake-Checking",
  "replace": "\r\n<h2 id=\"percent\">How South Carolina’s Modified Comparative Fault Rule Affects Brake-Checking"
 },
 {
  "id": 3067,
  "field": "content",
  "find": "all. If you are 51 percent or greater at fault, you will",
  "replace": "all. If you are more than 50 percent at fault, you will"
 },
 {
  "id": 3082,
  "field": "content",
  "find": "can prove you were 51 percent or more responsible.\r\n\r\nInsurance companies frequently",
  "replace": "can prove you were more than 50 percent responsible.\r\n\r\nInsurance companies frequently"
 },
 {
  "id": 3239,
  "field": "_roden_faqs:3:answer",
  "find": "reduced by their share; at 51 percent or more they recover nothing (Nelson",
  "replace": "reduced by their share; above 50 percent they recover nothing (Nelson"
 },
 {
  "id": 3239,
  "field": "content",
  "find": "If you are found 51 percent or more at fault, you cannot",
  "replace": "If you are found more than 50 percent at fault, you cannot"
 },
 {
  "id": 3376,
  "field": "content",
  "find": "damages if you are less than 51 percent at fault.\r\n\r\nThe at-fault",
  "replace": "damages if you are 50 percent or less at fault.\r\n\r\nThe at-fault"
 },
 {
  "id": 3386,
  "field": "content",
  "find": "of fault and barred at 51% or more.\r\n<h2 id=\"claim\">Could Wearing Headphones/AirPods ",
  "replace": "of fault and barred above 50%.\r\n<h2 id=\"claim\">Could Wearing Headphones/AirPods "
 },
 {
  "id": 3440,
  "field": "_roden_faqs:2:answer",
  "find": "If you are found 51% or more at fault, you are",
  "replace": "If you are found more than 50% at fault, you are"
 },
 {
  "id": 3440,
  "field": "_roden_key_takeaways",
  "find": "if the victim is 51% or more at fault, and the",
  "replace": "if the victim is more than 50% at fault, and the"
 },
 {
  "id": 3440,
  "field": "content",
  "find": " Carolina imposes a <strong>51% bar</strong>: if you are found to be 51% or more at fault for the",
  "replace": " Carolina imposes a <strong>more-than-50% bar</strong>: if you are found to be more than 50% at fault for the"
 },
 {
  "id": 3440,
  "field": "content",
  "find": "arguments. Because South Carolina's 51% bar can eliminate your",
  "replace": "arguments. Because South Carolina's more-than-50% bar can eliminate your"
 },
 {
  "id": 3497,
  "field": "content",
  "find": "are determined to be 51% or more responsible, you cannot collect",
  "replace": "are determined to be more than 50% responsible, you cannot collect"
 },
 {
  "id": 3501,
  "field": "content",
  "find": "the fault is not 51% or more. For example, if a",
  "replace": "the fault is not more than 50%. For example, if a"
 },
 {
  "id": 3553,
  "field": "_roden_faqs:2:answer",
  "find": "long as you are less than 51% at fault for the",
  "replace": "long as you are 50% or less at fault for the"
 },
 {
  "id": 3553,
  "field": "_roden_key_takeaways",
  "find": "modified comparative fault rule (less than 51% at fault) govern how",
  "replace": "modified comparative fault rule (50% or less at fault) govern how"
 },
 {
  "id": 3553,
  "field": "content",
  "find": "compensation if you are less than <strong>51% at fault</strong> for ",
  "replace": "compensation if you are <strong>50% or less at fault</strong> for "
 },
 {
  "id": 3570,
  "field": "content",
  "find": "are found to be 51% or more at fault for the",
  "replace": "are found to be more than 50% at fault for the"
 },
 {
  "id": 3596,
  "field": "_roden_faqs:1:answer",
  "find": "damages as long as your fault is less than 51% — meaning you must be 50% or less at",
  "replace": "damages as long as you are 50% or less at"
 },
 {
  "id": 3596,
  "field": "_roden_faqs:1:answer",
  "find": " If you are 51% or more at fault, you cannot",
  "replace": " If you are more than 50% at fault, you cannot"
 },
 {
  "id": 3599,
  "field": "_roden_faqs:4:answer",
  "find": "at fault for your accident — in other words, your fault must be less than 51%. Your compensation is reduced",
  "replace": "at fault for your accident. Your compensation is reduced"
 },
 {
  "id": 3599,
  "field": "_roden_faqs:4:answer",
  "find": " If you are 51% or more at fault, you are",
  "replace": " If you are more than 50% at fault, you are"
 },
 {
  "id": 3600,
  "field": "_roden_faqs:4:answer",
  "find": "as your fault is less than 51%. Your award is reduced",
  "replace": "as your fault is 50% or less. Your award is reduced"
 },
 {
  "id": 3600,
  "field": "_roden_faqs:4:answer",
  "find": "But if you are 51% or more at fault, you are",
  "replace": "But if you are more than 50% at fault, you are"
 },
 {
  "id": 3601,
  "field": "_roden_faqs:4:answer",
  "find": "as your fault is less than 51%. Your award is reduced",
  "replace": "as your fault is 50% or less. Your award is reduced"
 },
 {
  "id": 3601,
  "field": "_roden_faqs:4:answer",
  "find": " If you are 51% or more at fault, you cannot",
  "replace": " If you are more than 50% at fault, you cannot"
 },
 {
  "id": 3604,
  "field": "_roden_pillar_negligence_intro",
  "find": "recovery if you are {comp_fault_threshold} or more at fault, so insurers in {market_name}",
  "replace": "recovery if you are {comp_fault_bar}, so insurers in {market_name}"
 },
 {
  "id": 3606,
  "field": "_roden_pillar_compensation_intro",
  "find": "comparative-fault analysis (recovery barred at {comp_fault_threshold} fault under {sol_cite}'s sister apportionment statute) frequently turns on the",
  "replace": "comparative-fault analysis (recovery barred if you are {comp_fault_bar}) frequently turns on the"
 },
 {
  "id": 3607,
  "field": "_roden_pillar_negligence_intro",
  "find": "Code § 56-5-3660. {{/SC}}{state_full}'s {comp_fault_threshold} comparative-fault bar applies, with {sol_years} years to",
  "replace": "Code § 56-5-3660. {{/SC}}{state_full}'s comparative-fault bar applies (no recovery if you are {comp_fault_bar}), with {sol_years} years to"
 },
 {
  "id": 3620,
  "field": "_roden_faqs:2:answer",
  "find": "in South Carolina is 51% (compared to Georgia's 50%), meaning you can recover",
  "replace": "in South Carolina is more than 50% (compared to 50% or more in Georgia), meaning you can recover"
 },
 {
  "id": 3620,
  "field": "_roden_pillar_compensation_intro",
  "find": "property owner's apportioned share below the {comp_fault_threshold} bar. Plaintiffs respond by emphasizing",
  "replace": "property owner's apportioned share down. Plaintiffs respond by emphasizing"
 },
 {
  "id": 3621,
  "field": "_roden_pillar_negligence_intro",
  "find": "clothing — and {state_full}'s {comp_fault_threshold} comparative bar routinely defeats marginal claims.",
  "replace": "clothing — and {state_full}'s comparative-fault bar (no recovery if the pedestrian is {comp_fault_bar}) routinely defeats marginal claims."
 },
 {
  "id": 4050,
  "field": "_roden_faqs:2:answer",
  "find": "recovery if you are less than 51% at fault. Your compensation",
  "replace": "recovery if you are 50% or less at fault. Your compensation"
 },
 {
  "id": 4050,
  "field": "content",
  "find": "recovery if you are less than 51% at fault. Our attorneys",
  "replace": "recovery if you are 50% or less at fault. Our attorneys"
 },
 {
  "id": 4070,
  "field": "content",
  "find": "is less than 50% (GA) or 51% (SC) at fault.</p>",
  "replace": "is less than 50% at fault (GA) or 50% or less at fault (SC).</p>"
 },
 {
  "id": 4073,
  "field": "_roden_faqs:4:answer",
  "find": "below 50% (GA) or 51% (SC).",
  "replace": "below 50% (GA) or 50% or less (SC)."
 },
 {
  "id": 4073,
  "field": "content",
  "find": "standard bars recovery only at 51% or more fault.</li>\n<li><strong>The ",
  "replace": "standard bars recovery only above 50% fault.</li>\n<li><strong>The "
 },
 {
  "id": 4086,
  "field": "_roden_faqs:2:answer",
  "find": "are less than 50% (GA) or 51% (SC) at fault. The driver's negligence remains",
  "replace": "are less than 50% at fault (GA) or 50% or less at fault (SC). The driver's negligence remains"
 },
 {
  "id": 4091,
  "field": "_roden_faqs:3:answer",
  "find": "recovery if you are less than 51% at fault. Your compensation",
  "replace": "recovery if you are 50% or less at fault. Your compensation"
 },
 {
  "id": 4106,
  "field": "_roden_faqs:2:answer",
  "find": "Carolina allows recovery if less than 51% at fault. Damages are",
  "replace": "Carolina allows recovery if 50% or less at fault. Damages are"
 },
 {
  "id": 4113,
  "field": "content",
  "find": "recovery if you are less than 51% at fault. Your compensation",
  "replace": "recovery if you are 50% or less at fault. Your compensation"
 },
 {
  "id": 4132,
  "field": "content",
  "find": "bar in Georgia and 51% in South Carolina.</p>\n\n",
  "replace": "bar in Georgia and a more-than-50% bar in South Carolina.</p>\n\n"
 },
 {
  "id": 4133,
  "field": "content",
  "find": "South Carolina's threshold is 51%. Punitive damages may be",
  "replace": "South Carolina's threshold is more than 50%. Punitive damages may be"
 },
 {
  "id": 4134,
  "field": "content",
  "find": "South Carolina's threshold is 51%.</p>\n\n<h2>Filing Deadlines</h2>\n",
  "replace": "South Carolina's threshold is more than 50%.</p>\n\n<h2>Filing Deadlines</h2>\n"
 },
 {
  "id": 4135,
  "field": "content",
  "find": "South Carolina's threshold is 51%.</p>\n\n<h2>Evidence Preservation in",
  "replace": "South Carolina's threshold is more than 50%.</p>\n\n<h2>Evidence Preservation in"
 },
 {
  "id": 4137,
  "field": "content",
  "find": "South Carolina's threshold is 51%.</p>\n\n<h2>Filing Deadlines</h2>\n",
  "replace": "South Carolina's threshold is more than 50%.</p>\n\n<h2>Filing Deadlines</h2>\n"
 },
 {
  "id": 4138,
  "field": "content",
  "find": "South Carolina's threshold is 51%.</p>\n\n<h2>Evidence Preservation After",
  "replace": "South Carolina's threshold is more than 50%.</p>\n\n<h2>Evidence Preservation After"
 },
 {
  "id": 4146,
  "field": "content",
  "find": "Carolina permits recovery if less than 51% at fault. Our attorneys",
  "replace": "Carolina permits recovery if 50% or less at fault. Our attorneys"
 },
 {
  "id": 4149,
  "field": "content",
  "find": "Carolina allows recovery if less than 51% at fault. Our attorneys",
  "replace": "Carolina allows recovery if 50% or less at fault. Our attorneys"
 },
 {
  "id": 4150,
  "field": "content",
  "find": "Carolina allows recovery if less than 51% at fault. Our attorneys",
  "replace": "Carolina allows recovery if 50% or less at fault. Our attorneys"
 },
 {
  "id": 4151,
  "field": "content",
  "find": "Carolina allows recovery if less than 51% at fault. Contact Roden",
  "replace": "Carolina allows recovery if 50% or less at fault. Contact Roden"
 },
 {
  "id": 4152,
  "field": "content",
  "find": "Carolina allows recovery if less than 51% at fault. Contact Roden",
  "replace": "Carolina allows recovery if 50% or less at fault. Contact Roden"
 },
 {
  "id": 4153,
  "field": "content",
  "find": "Carolina permits recovery if less than 51% at fault.</p>\n\n<h2>Compensation",
  "replace": "Carolina permits recovery if 50% or less at fault.</p>\n\n<h2>Compensation"
 },
 {
  "id": 4155,
  "field": "content",
  "find": "Carolina permits recovery if less than 51% at fault. Our attorneys",
  "replace": "Carolina permits recovery if 50% or less at fault. Our attorneys"
 },
 {
  "id": 4157,
  "field": "content",
  "find": "Carolina permits recovery if less than 51% at fault. Our attorneys",
  "replace": "Carolina permits recovery if 50% or less at fault. Our attorneys"
 },
 {
  "id": 4158,
  "field": "content",
  "find": "Carolina allows recovery if less than 51% at fault. Punitive damages",
  "replace": "Carolina allows recovery if 50% or less at fault. Punitive damages"
 },
 {
  "id": 4160,
  "field": "content",
  "find": "Carolina allows recovery if less than 51% at fault. Preserving the",
  "replace": "Carolina allows recovery if 50% or less at fault. Preserving the"
 },
 {
  "id": 4162,
  "field": "content",
  "find": "Carolina allows recovery if less than 51% at fault. Workers may",
  "replace": "Carolina allows recovery if 50% or less at fault. Workers may"
 },
 {
  "id": 4181,
  "field": "_roden_faqs:1:answer",
  "find": "recovery if you are less than 51% at fault. Even if",
  "replace": "recovery if you are 50% or less at fault. Even if"
 },
 {
  "id": 4184,
  "field": "_roden_faqs:0:answer",
  "find": "fault in Georgia or less than 51% in South Carolina.",
  "replace": "fault in Georgia or 50% or less in South Carolina."
 },
 {
  "id": 4184,
  "field": "content",
  "find": "if the plaintiff is 51% or more at fault.</p>\n<p>Our",
  "replace": "if the plaintiff is more than 50% at fault.</p>\n<p>Our"
 },
 {
  "id": 4186,
  "field": "content",
  "find": "the injured party is 51% or more at fault. Even if",
  "replace": "the injured party is more than 50% at fault. Even if"
 },
 {
  "id": 4200,
  "field": "content",
  "find": "recovery if you are less than 51% at fault. Both states",
  "replace": "recovery if you are 50% or less at fault. Both states"
 },
 {
  "id": 4202,
  "field": "content",
  "find": "if the victim is less than 51% at fault, with a",
  "replace": "if the victim is 50% or less at fault, with a"
 },
 {
  "id": 4210,
  "field": "content",
  "find": "South Carolina's threshold is 51%.</p>\n\n<h2>Filing Deadlines</h2>\n",
  "replace": "South Carolina's threshold is more than 50%.</p>\n\n<h2>Filing Deadlines</h2>\n"
 },
 {
  "id": 4213,
  "field": "content",
  "find": "South Carolina's threshold is 51%.</p>\n\n<h2>Filing Deadlines</h2>\n",
  "replace": "South Carolina's threshold is more than 50%.</p>\n\n<h2>Filing Deadlines</h2>\n"
 },
 {
  "id": 4214,
  "field": "content",
  "find": "South Carolina's threshold is 51%.</p>\n\n<h2>Filing Deadlines</h2>\n",
  "replace": "South Carolina's threshold is more than 50%.</p>\n\n<h2>Filing Deadlines</h2>\n"
 },
 {
  "id": 4215,
  "field": "content",
  "find": "South Carolina's threshold is 51%.</p>\n\n<h2>Concurrent Brain and",
  "replace": "South Carolina's threshold is more than 50%.</p>\n\n<h2>Concurrent Brain and"
 },
 {
  "id": 4219,
  "field": "content",
  "find": "fault standard with a 51% threshold.</p>\n\n<h2>Parking Garage",
  "replace": "fault standard with a more-than-50% threshold.</p>\n\n<h2>Parking Garage"
 },
 {
  "id": 4224,
  "field": "_roden_faqs:1:answer",
  "find": "recovery if you are less than 51% at fault. Your compensation",
  "replace": "recovery if you are 50% or less at fault. Your compensation"
 },
 {
  "id": 4224,
  "field": "content",
  "find": "only if you are 51% or more responsible. Insurance companies frequently",
  "replace": "only if you are more than 50% responsible. Insurance companies frequently"
 },
 {
  "id": 4229,
  "field": "content",
  "find": "§ 51-12-33</a>) and less than 51% in South Carolina.</p>\n\n",
  "replace": "§ 51-12-33</a>) and 50% or less in South Carolina.</p>\n\n"
 },
 {
  "id": 4337,
  "field": "content",
  "find": "damages if you were less than 51% at fault — your",
  "replace": "damages if you were 50% or less at fault — your"
 },
 {
  "id": 4341,
  "field": "content",
  "find": "Comparative fault threshold</td>\n<td>Less than 51% (Nelson v. Concrete Supply",
  "replace": "Comparative fault threshold</td>\n<td>50% or less (Nelson v. Concrete Supply"
 },
 {
  "id": 4342,
  "field": "_roden_faqs:3:answer",
  "find": "as your fault is less than 51 percent. Your recovery is reduced",
  "replace": "as your fault is 50 percent or less. Your recovery is reduced"
 },
 {
  "id": 4342,
  "field": "_roden_key_takeaways",
  "find": "fault rule bars recovery at 51% or more fault, and the three-year",
  "replace": "fault rule bars recovery above 50% fault, and the three-year"
 },
 {
  "id": 4342,
  "field": "content",
  "find": " your fault is <strong>less than 51%</strong>.</p>\n\n<p>Property owners",
  "replace": " your fault is <strong>50% or less</strong>.</p>\n\n<p>Property owners"
 },
 {
  "id": 4343,
  "field": "_roden_key_takeaways",
  "find": "the injured party is 51% or more at fault, and the",
  "replace": "the injured party is more than 50% at fault, and the"
 },
 {
  "id": 4343,
  "field": "content",
  "find": "your own fault is less than 51%. Common comparative fault arguments",
  "replace": "your own fault is 50% or less. Common comparative fault arguments"
 },
 {
  "id": 4344,
  "field": "_roden_faqs:3:answer",
  "find": "as your fault is less than 51 percent. Your compensation is reduced",
  "replace": "as your fault is 50 percent or less. Your compensation is reduced"
 },
 {
  "id": 4344,
  "field": "_roden_key_takeaways",
  "find": "comparative fault bars recovery at 51% or more.",
  "replace": "comparative fault bars recovery above 50%."
 },
 {
  "id": 4344,
  "field": "content",
  "find": "if your fault is less than 51%. Your recovery is reduced",
  "replace": "if your fault is 50% or less. Your recovery is reduced"
 },
 {
  "id": 4345,
  "field": "content",
  "find": "Comparative fault threshold</td>\n<td>Less than 51% (Nelson v. Concrete Supply",
  "replace": "Comparative fault threshold</td>\n<td>50% or less (Nelson v. Concrete Supply"
 },
 {
  "id": 4348,
  "field": "content",
  "find": "Comparative fault threshold</td>\n<td>Less than 51% (Nelson v. Concrete Supply",
  "replace": "Comparative fault threshold</td>\n<td>50% or less (Nelson v. Concrete Supply"
 },
 {
  "id": 4349,
  "field": "content",
  "find": "Comparative fault threshold</td>\n<td>Less than 51% (Nelson v. Concrete Supply",
  "replace": "Comparative fault threshold</td>\n<td>50% or less (Nelson v. Concrete Supply"
 },
 {
  "id": 4350,
  "field": "content",
  "find": "Comparative fault threshold</td>\n<td>Less than 51%</td>\n<td>Less than 50%",
  "replace": "Comparative fault threshold</td>\n<td>50% or less</td>\n<td>Less than 50%"
 },
 {
  "id": 4351,
  "field": "_roden_faqs:5:answer",
  "find": "if your fault is less than 51 percent (Nelson v. Concrete Supply",
  "replace": "if your fault is 50 percent or less (Nelson v. Concrete Supply"
 },
 {
  "id": 4351,
  "field": "_roden_key_takeaways",
  "find": "comparative fault bars recovery at 51% or more.",
  "replace": "comparative fault bars recovery above 50%."
 },
 {
  "id": 4351,
  "field": "content",
  "find": "if your fault is less than 51%. Your recovery is reduced",
  "replace": "if your fault is 50% or less. Your recovery is reduced"
 },
 {
  "id": 4352,
  "field": "_roden_key_takeaways",
  "find": "comparative fault bars recovery at 51% or more.",
  "replace": "comparative fault bars recovery above 50%."
 },
 {
  "id": 4352,
  "field": "content",
  "find": "if your fault is less than 51%. In Georgia, the threshold",
  "replace": "if your fault is 50% or less. In Georgia, the threshold"
 },
 {
  "id": 4355,
  "field": "_roden_key_takeaways",
  "find": "comparative fault barring recovery at 51% or more.",
  "replace": "comparative fault barring recovery above 50%."
 },
 {
  "id": 4355,
  "field": "content",
  "find": "But if they are 51% or more at fault, they recover",
  "replace": "But if they are more than 50% at fault, they recover"
 },
 {
  "id": 4356,
  "field": "content",
  "find": "recovery if you are 51% or more at fault.</p>\n\n<h3>Does",
  "replace": "recovery if you are more than 50% at fault.</p>\n\n<h3>Does"
 },
 {
  "id": 4357,
  "field": "_roden_faqs:1:answer",
  "find": "if your fault is less than 51 percent.",
  "replace": "if your fault is 50 percent or less."
 },
 {
  "id": 4357,
  "field": "_roden_key_takeaways",
  "find": "comparative fault bars recovery at 51% or more. Georgia claims must be",
  "replace": "comparative fault bars recovery above 50%. Georgia claims must be"
 },
 {
  "id": 4357,
  "field": "content",
  "find": "long as they are less than 51% at fault for the",
  "replace": "long as they are 50% or less at fault for the"
 },
 {
  "id": 4357,
  "field": "content",
  "find": "If they are found 51% or more at fault, they recover",
  "replace": "If they are found more than 50% at fault, they recover"
 },
 {
  "id": 4357,
  "field": "content",
  "find": "as your fault is less than 51% under South Carolina's comparative",
  "replace": "as your fault is 50% or less under South Carolina's comparative"
 },
 {
  "id": 4358,
  "field": "_roden_key_takeaways",
  "find": "comparative fault, barring recovery at 51% or more fault. Injured parties generally",
  "replace": "comparative fault, barring recovery above 50% fault. Injured parties generally"
 },
 {
  "id": 4358,
  "field": "content",
  "find": " of fault is <strong>less than 51%</strong>. If the injured",
  "replace": " of fault is <strong>50% or less</strong>. If the injured"
 },
 {
  "id": 4358,
  "field": "content",
  "find": "is found to be 51% or more at fault, they recover",
  "replace": "is found to be more than 50% at fault, they recover"
 },
 {
  "id": 4359,
  "field": "_roden_faqs:4:answer",
  "find": "if your fault is less than 51 percent.",
  "replace": "if your fault is 50 percent or less."
 },
 {
  "id": 4359,
  "field": "content",
  "find": " own fault is <strong>less than 51%</strong> of the total ",
  "replace": " own fault is <strong>50% or less</strong> of the total "
 },
 {
  "id": 4359,
  "field": "content",
  "find": "If you are found 51% or more at fault, you recover",
  "replace": "If you are found more than 50% at fault, you recover"
 },
 {
  "id": 4360,
  "field": "_roden_key_takeaways",
  "find": "Comparative fault bars recovery at 51% or more, with a three-year filing",
  "replace": "Comparative fault bars recovery above 50%, with a three-year filing"
 },
 {
  "id": 4360,
  "field": "content",
  "find": " of fault is <strong>less than 51%</strong>. Your award is",
  "replace": " of fault is <strong>50% or less</strong>. Your award is"
 },
 {
  "id": 4360,
  "field": "content",
  "find": "as your fault is less than 51%. Your award is reduced",
  "replace": "as your fault is 50% or less. Your award is reduced"
 },
 {
  "id": 4361,
  "field": "_roden_faqs:3:answer",
  "find": "if your fault is less than 51 percent.",
  "replace": "if your fault is 50 percent or less."
 },
 {
  "id": 4361,
  "field": "_roden_key_takeaways",
  "find": "Comparative fault bars recovery at 51% or more, and the general filing",
  "replace": "Comparative fault bars recovery above 50%, and the general filing"
 },
 {
  "id": 4361,
  "field": "content",
  "find": "But if they are 51% or more at fault, they recover",
  "replace": "But if they are more than 50% at fault, they recover"
 },
 {
  "id": 4362,
  "field": "_roden_faqs:3:answer",
  "find": "of fault and barred at 51 percent or more.",
  "replace": "of fault and barred above 50 percent."
 },
 {
  "id": 4362,
  "field": "content",
  "find": "— victim recovers if less than 51% at fault</td>\n<td>Modified",
  "replace": "— victim recovers if 50% or less at fault</td>\n<td>Modified"
 },
 {
  "id": 4362,
  "field": "content",
  "find": " of fault is <strong>less than 51 percent</strong>. If the victim is found to be 51 percent or more at fault, they are",
  "replace": " of fault is <strong>50 percent or less</strong>. If the victim is found to be more than 50 percent at fault, they are"
 },
 {
  "id": 4362,
  "field": "content",
  "find": "share of fault is less than 51 percent. Your total damages will",
  "replace": "share of fault is 50 percent or less. Your total damages will"
 },
 {
  "id": 4363,
  "field": "content",
  "find": "recovery barred if plaintiff 51% or more at fault</td>\n      <td>Modified",
  "replace": "recovery barred if plaintiff more than 50% at fault</td>\n      <td>Modified"
 },
 {
  "id": 4367,
  "field": "_roden_faqs:0:answer",
  "find": "if your fault is less than 51 percent. Your recovery is reduced",
  "replace": "if your fault is 50 percent or less. Your recovery is reduced"
 },
 {
  "id": 4367,
  "field": "_roden_faqs:1:answer",
  "find": "51-12-33). SC bars recovery at 51 percent or more. This one percent difference matters in close",
  "replace": "51-12-33). SC bars recovery above 50 percent. This difference matters in close"
 },
 {
  "id": 4367,
  "field": "_roden_faqs:5:answer",
  "find": "as your fault is less than 51 percent. In GA, you must",
  "replace": "as your fault is 50 percent or less. In GA, you must"
 },
 {
  "id": 4367,
  "field": "_roden_key_takeaways",
  "find": "and bars recovery entirely at 51% or more. Insurance companies aggressively inflate",
  "replace": "and bars recovery entirely above 50%. Insurance companies aggressively inflate"
 },
 {
  "id": 4367,
  "field": "content",
  "find": "Comparative Fault Works: The 51% Rule</a></li>\n    <li><a href=\"#dollar-calculations\">How",
  "replace": "Comparative Fault Works: The More-Than-50% Rule</a></li>\n    <li><a href=\"#dollar-calculations\">How"
 },
 {
  "id": 4367,
  "field": "content",
  "find": "share of fault is less than 51%. If you are found 51% or more at fault for the",
  "replace": "share of fault is 50% or less. If you are found more than 50% at fault for the"
 },
 {
  "id": 4367,
  "field": "content",
  "find": "the injured person's fault reaches 51% or more, they lose the right",
  "replace": "the injured person's fault exceeds 50%, they lose the right"
 },
 {
  "id": 4367,
  "field": "content",
  "find": "Comparative Fault Works: The 51% Rule</h2>\n\n<p>The mechanics",
  "replace": "Comparative Fault Works: The More-Than-50% Rule</h2>\n\n<p>The mechanics"
 },
 {
  "id": 4367,
  "field": "content",
  "find": " percentage.</li>\n  <li><strong>The 51% bar applies.</strong> If your assigned fault is 51% or greater, you receive nothing --",
  "replace": " percentage.</li>\n  <li><strong>The more-than-50% bar applies.</strong> If your assigned fault is more than 50%, you receive nothing --"
 },
 {
  "id": 4367,
  "field": "content",
  "find": "Recovery threshold</td>\n      <td>Barred at 51% or more fault</td>\n      <td>Barred at",
  "replace": "Recovery threshold</td>\n      <td>Barred above 50% fault</td>\n      <td>Barred at"
 },
 {
  "id": 4367,
  "field": "content",
  "find": "Once the plaintiff's fault reaches or exceeds a set threshold -- 51% in South Carolina, 50% in Georgia -- recovery",
  "replace": "Once the plaintiff's fault crosses a set threshold -- more than 50% in South Carolina, 50% or more in Georgia -- recovery"
 },
 {
  "id": 4367,
  "field": "content",
  "find": "pushing you past the 51% threshold eliminates their obligation",
  "replace": "pushing you past the 50% threshold eliminates their obligation"
 },
 {
  "id": 4367,
  "field": "content",
  "find": "-- and crossing the 51% threshold eliminates it entirely.",
  "replace": "-- and crossing the 50% threshold eliminates it entirely."
 },
 {
  "id": 4368,
  "field": "_roden_faqs:4:answer",
  "find": "if your fault is less than 51 percent.",
  "replace": "if your fault is 50 percent or less."
 },
 {
  "id": 4368,
  "field": "_roden_key_takeaways",
  "find": "fault rule bars recovery at 51% or more fault, and the filing",
  "replace": "fault rule bars recovery above 50% fault, and the filing"
 },
 {
  "id": 4368,
  "field": "content",
  "find": "(i.e., you must be less than 51% at fault). If you",
  "replace": "(i.e., you must be 50% or less at fault). If you"
 },
 {
  "id": 4368,
  "field": "content",
  "find": "If you are found 51% or more at fault, you recover",
  "replace": "If you are found more than 50% at fault, you recover"
 },
 {
  "id": 4369,
  "field": "_roden_key_takeaways",
  "find": "comparative fault, barring recovery at 51% or more fault, with a three-year",
  "replace": "comparative fault, barring recovery above 50% fault, with a three-year"
 },
 {
  "id": 4369,
  "field": "content",
  "find": "own fault does not reach 51 percent. If you are",
  "replace": "own fault does not exceed 50 percent. If you are"
 },
 {
  "id": 4369,
  "field": "content",
  "find": "If you are found 51 percent or more at fault, you recover",
  "replace": "If you are found more than 50 percent at fault, you recover"
 },
 {
  "id": 4478,
  "field": "_roden_faqs:1:answer",
  "find": "long as they are less than 51% at fault. Their damages",
  "replace": "long as they are 50% or less at fault. Their damages"
 },
 {
  "id": 4478,
  "field": "_roden_faqs:1:answer",
  "find": "their percentage of fault. At 51% or more fault, the pedestrian recovers",
  "replace": "their percentage of fault. Above 50% fault, the pedestrian recovers"
 },
 {
  "id": 4478,
  "field": "_roden_faqs:5:answer",
  "find": "while South Carolina's is 51%. Georgia's statute of limitations",
  "replace": "while South Carolina's is more than 50%. Georgia's statute of limitations"
 },
 {
  "id": 4478,
  "field": "_roden_key_takeaways",
  "find": "if the pedestrian is 51% or more at fault. Victims can",
  "replace": "if the pedestrian is more than 50% at fault. Victims can"
 },
 {
  "id": 4478,
  "field": "content",
  "find": " as they are <strong>less than 51% at fault</strong> for ",
  "replace": " as they are <strong>50% or less at fault</strong> for "
 },
 {
  "id": 4478,
  "field": "content",
  "find": "is found to be 51% or more at fault, they are",
  "replace": "is found to be more than 50% at fault, they are"
 },
 {
  "id": 4478,
  "field": "content",
  "find": "Note that South Carolina's 51% threshold is slightly more",
  "replace": "Note that South Carolina's more-than-50% threshold is slightly more"
 },
 {
  "id": 4534,
  "field": "_roden_faqs:2:answer",
  "find": "If you are found 51% or more at fault, you cannot",
  "replace": "If you are found more than 50% at fault, you cannot"
 },
 {
  "id": 4534,
  "field": "_roden_key_takeaways",
  "find": "fault rule bars recovery at 51% or more fault, and the three-year",
  "replace": "fault rule bars recovery above 50% fault, and the three-year"
 },
 {
  "id": 4534,
  "field": "content",
  "find": " found to be <strong>51% or more at fault</strong>, you",
  "replace": " found to be <strong>more than 50% at fault</strong>, you"
 },
 {
  "id": 4534,
  "field": "content",
  "find": "</td>\n    </tr>\n    <tr>\n      <td>51% or more</td>\n      <td>",
  "replace": "</td>\n    </tr>\n    <tr>\n      <td>More than 50%</td>\n      <td>"
 },
 {
  "id": 4537,
  "field": "_roden_faqs:5:answer",
  "find": "long as you are less than 51% at fault. Your compensation",
  "replace": "long as you are 50% or less at fault. Your compensation"
 },
 {
  "id": 4537,
  "field": "_roden_key_takeaways",
  "find": "and comparative fault rule (less than 51% at fault) protect victims,",
  "replace": "and comparative fault rule (50% or less at fault) protect victims,"
 },
 {
  "id": 4537,
  "field": "content",
  "find": "compensation if you are less than <strong>51% at fault</strong> for ",
  "replace": "compensation if you are <strong>50% or less at fault</strong> for "
 },
 {
  "id": 4581,
  "field": "content",
  "find": "§ 51-12-33</a>) or 51% or more in South Carolina (",
  "replace": "§ 51-12-33</a>) or more than 50% in South Carolina ("
 },
 {
  "id": 4583,
  "field": "_roden_faqs:2:answer",
  "find": "Carolina, the threshold is 51%.",
  "replace": "Carolina, the threshold is more than 50%."
 },
 {
  "id": 4583,
  "field": "_roden_key_takeaways",
  "find": "§ 51-12-33), South Carolina at 51%. Settlement ranges: whiplash ",
  "replace": "§ 51-12-33), South Carolina above 50%. Settlement ranges: whiplash "
 },
 {
  "id": 4583,
  "field": "content",
  "find": " as you are <strong>less than 51 percent at fault</strong>. Like",
  "replace": " as you are <strong>50 percent or less at fault</strong>. Like"
 },
 {
  "id": 4584,
  "field": "content",
  "find": " as you are <strong>less than 51% at fault</strong>. If you are 51% or more at fault, you recover",
  "replace": " as you are <strong>50% or less at fault</strong>. If you are more than 50% at fault, you recover"
 },
 {
  "id": 4584,
  "field": "content",
  "find": "bar and South Carolina's 51% bar is narrow but",
  "replace": "bar and South Carolina's more-than-50% bar is narrow but"
 },
 {
  "id": 4585,
  "field": "content",
  "find": "long as you were less than 51% at fault for the",
  "replace": "long as you were 50% or less at fault for the"
 },
 {
  "id": 4585,
  "field": "content",
  "find": "&sect; 51-12-33)</td>\n            <td>Barred at 51% or more fault</td>\n        </tr>\n        <tr>\n            ",
  "replace": "&sect; 51-12-33)</td>\n            <td>Barred above 50% fault</td>\n        </tr>\n        <tr>\n            "
 },
 {
  "id": 4586,
  "field": "content",
  "find": "their fault does not reach 51%. At 50% fault, you",
  "replace": "their fault does not exceed 50%. At 50% fault, you"
 },
 {
  "id": 4586,
  "field": "content",
  "find": "still recover (reduced proportionally). At 51% or higher, you are barred entirely.",
  "replace": "still recover (reduced proportionally). Above 50%, you are barred entirely."
 },
 {
  "id": 4586,
  "field": "content",
  "find": "(O.C.G.A. § 51-12-33)</td>\n<td>51% or more bars recovery</td>\n</tr>\n",
  "replace": "(O.C.G.A. § 51-12-33)</td>\n<td>More than 50% bars recovery</td>\n</tr>\n"
 },
 {
  "id": 4587,
  "field": "content",
  "find": "injured party is not 51% or more at fault. This is",
  "replace": "injured party is not more than 50% at fault. This is"
 },
 {
  "id": 4587,
  "field": "content",
  "find": "\n<td>Modified &mdash; barred at 51% fault</td>\n</tr>\n<tr>\n",
  "replace": "\n<td>Modified &mdash; barred above 50% fault</td>\n</tr>\n<tr>\n"
 },
 {
  "id": 4588,
  "field": "content",
  "find": "— plaintiff recovers if less than 51% at fault (Nelson v.",
  "replace": "— plaintiff recovers if 50% or less at fault (Nelson v."
 },
 {
  "id": 4589,
  "field": "content",
  "find": "as your fault is less than 51 percent, one additional percentage point of breathing room over Georgia's rule.</p>\n\n<h2 id=\"damages-you-can-recover\">What Damages Can",
  "replace": "as your fault is 50 percent or less.</p>\n\n<h2 id=\"damages-you-can-recover\">What Damages Can"
 },
 {
  "id": 4590,
  "field": "_roden_faqs:3:answer",
  "find": "Modified comparative fault with 51% bar: you recover if",
  "replace": "Modified comparative fault with more-than-50% bar: you recover if"
 },
 {
  "id": 4590,
  "field": "_roden_faqs:3:answer",
  "find": "reduced by your percentage; at 51% or more you recover nothing.",
  "replace": "reduced by your percentage; above 50% you recover nothing."
 },
 {
  "id": 4590,
  "field": "_roden_key_takeaways",
  "find": "38-77-150). Comparative fault bars at 51%. Min insurance 25/50/25. Punitive",
  "replace": "38-77-150). Comparative fault bars above 50%. Min insurance 25/50/25. Punitive"
 },
 {
  "id": 4590,
  "field": "content",
  "find": "Comparative Fault Threshold</td>\n<td>Less than 51% at fault to recover",
  "replace": "Comparative Fault Threshold</td>\n<td>50% or less at fault to recover"
 },
 {
  "id": 4590,
  "field": "content",
  "find": "share of fault is less than 51 percent. If you are found 51 percent or more at fault, you recover",
  "replace": "share of fault is 50 percent or less. If you are found more than 50 percent at fault, you recover"
 },
 {
  "id": 4617,
  "field": "content",
  "find": "long as you are less than 51% at fault for the",
  "replace": "long as you are 50% or less at fault for the"
 },
 {
  "id": 4632,
  "field": "content",
  "find": "</strong> Recovery allowed if less than 51% at fault</li>\n<li><strong>",
  "replace": "</strong> Recovery allowed if 50% or less at fault</li>\n<li><strong>"
 },
 {
  "id": 4638,
  "field": "content",
  "find": "recovery if you were less than 51% at fault — stores",
  "replace": "recovery if you were 50% or less at fault — stores"
 },
 {
  "id": 4639,
  "field": "_roden_faqs:1:answer",
  "find": "Yes, if you were less than 51 percent at fault. South Carolina",
  "replace": "Yes, if you were 50 percent or less at fault. South Carolina"
 },
 {
  "id": 4639,
  "field": "_roden_faqs:1:answer",
  "find": "share of fault stays below 51 percent. Your compensation is",
  "replace": "share of fault stays at or below 50 percent. Your compensation is"
 },
 {
  "id": 4639,
  "field": "_roden_key_takeaways",
  "find": "under comparative fault if less than <strong>51% at fault</strong>, with",
  "replace": "under comparative fault if <strong>50% or less at fault</strong>, with"
 },
 {
  "id": 4644,
  "field": "_roden_key_takeaways",
  "find": "can recover damages if less than <strong>51% at fault</strong>. The",
  "replace": "can recover damages if <strong>50% or less at fault</strong>. The"
 },
 {
  "id": 4678,
  "field": "_roden_key_takeaways",
  "find": ") with recovery if less than <strong>51% at fault</strong>.",
  "replace": ") with recovery if <strong>50% or less at fault</strong>."
 },
 {
  "id": 4678,
  "field": "content",
  "find": "recovery if you are less than 51% at fault. Your compensation",
  "replace": "recovery if you are 50% or less at fault. Your compensation"
 },
 {
  "id": 4686,
  "field": "_roden_key_takeaways",
  "find": "and allows recovery if less than <strong>51% at fault</strong>. Contact",
  "replace": "and allows recovery if <strong>50% or less at fault</strong>. Contact"
 },
 {
  "id": 4686,
  "field": "content",
  "find": " if you are <strong>less than 51% at fault</strong>. Your",
  "replace": " if you are <strong>50% or less at fault</strong>. Your"
 },
 {
  "id": 4687,
  "field": "_roden_key_takeaways",
  "find": "and allows recovery if less than <strong>51% at fault</strong>. Contact",
  "replace": "and allows recovery if <strong>50% or less at fault</strong>. Contact"
 },
 {
  "id": 4687,
  "field": "content",
  "find": " if you are <strong>less than 51% at fault</strong>. Your",
  "replace": " if you are <strong>50% or less at fault</strong>. Your"
 },
 {
  "id": 4688,
  "field": "_roden_faqs:4:answer",
  "find": "long as you are less than 51% at fault. Your compensation",
  "replace": "long as you are 50% or less at fault. Your compensation"
 },
 {
  "id": 4688,
  "field": "_roden_key_takeaways",
  "find": "and allows recovery if less than <strong>51% at fault</strong>. Contact",
  "replace": "and allows recovery if <strong>50% or less at fault</strong>. Contact"
 },
 {
  "id": 4688,
  "field": "content",
  "find": " if you are <strong>less than 51% at fault</strong>. Your",
  "replace": " if you are <strong>50% or less at fault</strong>. Your"
 },
 {
  "id": 4689,
  "field": "_roden_faqs:1:answer",
  "find": "and allows recovery if less than 51% at fault. For crashes",
  "replace": "and allows recovery if 50% or less at fault. For crashes"
 },
 {
  "id": 4689,
  "field": "content",
  "find": " &sect; 51-12-33</a>)</td><td>Less than <strong>51%</strong> at fault to ",
  "replace": " &sect; 51-12-33</a>)</td><td><strong>50% or less</strong> at fault to "
 },
 {
  "id": 4692,
  "field": "_roden_pillar_negligence_intro",
  "find": "recovery if you are {comp_fault_threshold} or more at fault, so insurers in {market_name}",
  "replace": "recovery if you are {comp_fault_bar}, so insurers in {market_name}"
 },
 {
  "id": 4806,
  "field": "_roden_faqs:2:answer",
  "find": "only if you are less than 51% at fault, and your",
  "replace": "only if you are 50% or less at fault, and your"
 },
 {
  "id": 4806,
  "field": "_roden_faqs:2:answer",
  "find": " At 51% or more fault, you recover nothing.",
  "replace": " Above 50% fault, you recover nothing."
 },
 {
  "id": 4806,
  "field": "content",
  "find": " as you are <strong>less than 51% at fault</strong>, but",
  "replace": " as you are <strong>50% or less at fault</strong>, but"
 },
 {
  "id": 4806,
  "field": "content",
  "find": " If you are 51% or more at fault, you recover",
  "replace": " If you are more than 50% at fault, you recover"
 },
 {
  "id": 4809,
  "field": "_roden_faqs:2:answer",
  "find": "only if you are less than 51% at fault, and your",
  "replace": "only if you are 50% or less at fault, and your"
 },
 {
  "id": 4809,
  "field": "_roden_faqs:2:answer",
  "find": " At 51% or more fault, you recover nothing.",
  "replace": " Above 50% fault, you recover nothing."
 },
 {
  "id": 4809,
  "field": "content",
  "find": " as you are <strong>less than 51% at fault</strong>, but",
  "replace": " as you are <strong>50% or less at fault</strong>, but"
 },
 {
  "id": 4809,
  "field": "content",
  "find": " If you are 51% or more at fault, you recover",
  "replace": " If you are more than 50% at fault, you recover"
 },
 {
  "id": 4810,
  "field": "_roden_see_also:0:text",
  "find": "Comparative Negligence — the 51% Bar",
  "replace": "Comparative Negligence — the More-Than-50% Bar"
 },
 {
  "id": 4811,
  "field": "_roden_faqs:0:answer",
  "find": "comparative negligence with a 51% bar, adopted in Nelson",
  "replace": "comparative negligence with a more-than-50% bar, adopted in Nelson"
 },
 {
  "id": 4811,
  "field": "_roden_faqs:0:answer",
  "find": "long as you are less than 51% at fault, but your",
  "replace": "long as you are 50% or less at fault, but your"
 },
 {
  "id": 4811,
  "field": "_roden_faqs:0:answer",
  "find": "your percentage of fault. At 51% or more fault, you recover nothing.",
  "replace": "your percentage of fault. Above 50% fault, you recover nothing."
 },
 {
  "id": 4811,
  "field": "_roden_faqs:1:answer",
  "find": "The 51% bar is the cutoff",
  "replace": "The more-than-50% bar is the cutoff"
 },
 {
  "id": 4811,
  "field": "_roden_faqs:1:answer",
  "find": "percentage. If you are 51% or more at fault, you are",
  "replace": "percentage. If you are more than 50% at fault, you are"
 },
 {
  "id": 4811,
  "field": "_roden_faqs:1:question",
  "find": "What is the 51% bar in South Carolina?",
  "replace": "What is the more-than-50% bar in South Carolina?"
 },
 {
  "id": 4811,
  "field": "_roden_faqs:2:answer",
  "find": "share of fault is less than 51%. Many injured people wrongly",
  "replace": "share of fault is 50% or less. Many injured people wrongly"
 },
 {
  "id": 4811,
  "field": "_roden_faqs:4:answer",
  "find": "As long as you stay below 51% at fault, you still",
  "replace": "As long as you are 50% or less at fault, you still"
 },
 {
  "id": 4811,
  "field": "_roden_key_takeaways",
  "find": "comparative negligence with a 51% bar. You can recover",
  "replace": "comparative negligence with a more-than-50% bar. You can recover"
 },
 {
  "id": 4811,
  "field": "_roden_key_takeaways",
  "find": "long as you are less than 51% at fault for your",
  "replace": "long as you are 50% or less at fault for your"
 },
 {
  "id": 4811,
  "field": "_roden_key_takeaways",
  "find": "fault. If you are 51% or more at fault, you recover",
  "replace": "fault. If you are more than 50% at fault, you recover"
 },
 {
  "id": 4811,
  "field": "_roden_meta_description",
  "find": "negligence state with a 51% bar: you can recover if you are less than 51% at fault, but your",
  "replace": "negligence state with a more-than-50% bar: you can recover if you are 50% or less at fault, but your"
 },
 {
  "id": 4811,
  "field": "content",
  "find": " state with a <strong>51% bar</strong>. In plain",
  "replace": " state with a <strong>more-than-50% bar</strong>. In plain"
 },
 {
  "id": 4811,
  "field": "content",
  "find": " as you are <strong>less than 51% at fault</strong> &mdash; that is, 50% or less &mdash; but whatever you",
  "replace": " as you are <strong>50% or less at fault</strong> &mdash; but whatever you"
 },
 {
  "id": 4811,
  "field": "content",
  "find": "If you are found 51% or more at fault, you recover",
  "replace": "If you are found more than 50% at fault, you recover"
 },
 {
  "id": 4811,
  "field": "content",
  "find": "attorney explains how the 51% bar works, walks through",
  "replace": "attorney explains how the more-than-50% bar works, walks through"
 },
 {
  "id": 4811,
  "field": "content",
  "find": "\n\n<h2>What is the 51% bar?</h2>\n<p>The \"51% bar\" is the cutoff",
  "replace": "\n\n<h2>What is the more-than-50% bar?</h2>\n<p>The \"more-than-50% bar\" is the cutoff"
 },
 {
  "id": 4811,
  "field": "content",
  "find": "<li>If you are <strong>51% or more at fault</strong>, you",
  "replace": "<li>If you are <strong>more than 50% at fault</strong>, you"
 },
 {
  "id": 4811,
  "field": "content",
  "find": "why South Carolina is called a \"51% bar\" state rather than a \"50% bar\" state: the line falls at 51%. A plaintiff who is",
  "replace": "why South Carolina is not a \"50% bar\" state: you are barred only if your fault is more than 50%. A plaintiff who is"
 },
 {
  "id": 4811,
  "field": "content",
  "find": "to show how the 51% bar plays out at",
  "replace": "to show how the more-than-50% bar plays out at"
 },
 {
  "id": 4811,
  "field": "content",
  "find": "</td><td>51% or more</td><td>",
  "replace": "</td><td>More than 50%</td><td>"
 },
 {
  "id": 4811,
  "field": "content",
  "find": "your fault is assessed at 51%, you lose everything &mdash;",
  "replace": "your fault is assessed above 50%, you lose everything &mdash;"
 },
 {
  "id": 4811,
  "field": "content",
  "find": "your share of fault stays below 51%. Many injured people wrongly",
  "replace": "your share of fault is 50% or less. Many injured people wrongly"
 },
 {
  "id": 4811,
  "field": "excerpt",
  "find": "negligence state with a 51% bar: you can recover if you are less than 51% at fault, but your",
  "replace": "negligence state with a more-than-50% bar: you can recover if you are 50% or less at fault, but your"
 },
 {
  "id": 4811,
  "field": "title",
  "find": "Comparative Negligence — the 51% Bar Explained",
  "replace": "Comparative Negligence — the More-Than-50% Bar Explained"
 },
 {
  "id": 4812,
  "field": "_roden_see_also:1:text",
  "find": "Comparative Negligence — the 51% Bar",
  "replace": "Comparative Negligence — the More-Than-50% Bar"
 },
 {
  "id": 4813,
  "field": "_roden_see_also:1:text",
  "find": "Comparative Negligence — the 51% Bar",
  "replace": "Comparative Negligence — the More-Than-50% Bar"
 },
 {
  "id": 4814,
  "field": "_roden_faqs:10:answer",
  "find": "entirely if you are 51% or more at fault. On a",
  "replace": "entirely if you are more than 50% at fault. On a"
 },
 {
  "id": 4814,
  "field": "_roden_faqs:11:answer",
  "find": "The 51% bar means you can",
  "replace": "The more-than-50% bar means you can"
 },
 {
  "id": 4814,
  "field": "_roden_faqs:11:answer",
  "find": "is 50% or less; at 51% or more, you are barred from",
  "replace": "is 50% or less; above 50%, you are barred from"
 },
 {
  "id": 4814,
  "field": "_roden_faqs:11:question",
  "find": "What is the 51% bar rule in South",
  "replace": "What is the more-than-50% bar rule in South"
 },
 {
  "id": 4814,
  "field": "_roden_faqs:12:answer",
  "find": "other 60%, you are under the 51% bar and can still recover.",
  "replace": "other 60%, you are not more than 50% at fault and can still recover."
 },
 {
  "id": 4814,
  "field": "_roden_faqs:15:answer",
  "find": "being pushed over the 51% line ends your claim",
  "replace": "being pushed over the 50% line ends your claim"
 },
 {
  "id": 4814,
  "field": "_roden_faqs:51:answer",
  "find": "3-year deadline and the 51% comparative-fault bar, but motorcycle",
  "replace": "3-year deadline and the more-than-50% comparative-fault bar, but motorcycle"
 },
 {
  "id": 4814,
  "field": "_roden_faqs:65:answer",
  "find": "of fault under the 51% bar. An attorney can",
  "replace": "of fault under the more-than-50% bar. An attorney can"
 },
 {
  "id": 4814,
  "field": "_roden_faqs:77:answer",
  "find": "Possibly. South Carolina's 51% comparative-fault rule applies to",
  "replace": "Possibly. South Carolina's modified comparative-fault rule applies to"
 },
 {
  "id": 4814,
  "field": "_roden_faqs:77:answer",
  "find": "If the deceased was 51% or more at fault, recovery is",
  "replace": "If the deceased was more than 50% at fault, recovery is"
 },
 {
  "id": 4814,
  "field": "_roden_faqs:9:answer",
  "find": "comparative negligence with a 51% bar. You can recover",
  "replace": "comparative negligence with a more-than-50% bar. You can recover"
 },
 {
  "id": 4814,
  "field": "_roden_faqs:9:answer",
  "find": " At 51% or more fault, you recover nothing.",
  "replace": " Above 50% fault, you recover nothing."
 },
 {
  "id": 4814,
  "field": "_roden_key_takeaways",
  "find": "long as you are less than 51% at fault. There is",
  "replace": "long as you are 50% or less at fault. There is"
 },
 {
  "id": 4814,
  "field": "_roden_see_also:1:text",
  "find": "Comparative Negligence — the 51% Bar",
  "replace": "Comparative Negligence — the More-Than-50% Bar"
 },
 {
  "id": 4815,
  "field": "_roden_faqs:3:answer",
  "find": "long as you were less than 51% at fault, though your",
  "replace": "long as you were 50% or less at fault, though your"
 },
 {
  "id": 4815,
  "field": "_roden_key_takeaways",
  "find": "long as you were less than 51% at fault. Motorcyclists face",
  "replace": "long as you were 50% or less at fault. Motorcyclists face"
 },
 {
  "id": 4815,
  "field": "content",
  "find": "long as you were less than 51% at fault, with your",
  "replace": "long as you were 50% or less at fault, with your"
 },
 {
  "id": 4819,
  "field": "_roden_faqs:1:answer",
  "find": "long as you were less than 51% at fault, though your",
  "replace": "long as you were 50% or less at fault, though your"
 },
 {
  "id": 4819,
  "field": "_roden_key_takeaways",
  "find": "long as you were less than 51% at fault. South Carolina",
  "replace": "long as you were 50% or less at fault. South Carolina"
 },
 {
  "id": 4819,
  "field": "content",
  "find": "long as you were less than 51% at fault, but your",
  "replace": "long as you were 50% or less at fault, but your"
 },
 {
  "id": 4820,
  "field": "_roden_faqs:3:answer",
  "find": "long as you were less than 51% at fault, though your",
  "replace": "long as you were 50% or less at fault, though your"
 },
 {
  "id": 4820,
  "field": "_roden_key_takeaways",
  "find": "long as you were less than 51% at fault. Truck cases",
  "replace": "long as you were 50% or less at fault. Truck cases"
 },
 {
  "id": 4820,
  "field": "content",
  "find": "long as you were less than 51% at fault, though your",
  "replace": "long as you were 50% or less at fault, though your"
 },
 {
  "id": 4846,
  "field": "_roden_faqs:2:answer",
  "find": "long as you were less than 51% at fault, but your",
  "replace": "long as you were 50% or less at fault, but your"
 },
 {
  "id": 4846,
  "field": "_roden_key_takeaways",
  "find": "long as you were less than 51% at fault, with your",
  "replace": "long as you were 50% or less at fault, with your"
 },
 {
  "id": 4846,
  "field": "content",
  "find": " as you were <strong>less than 51% at fault</strong>, with",
  "replace": " as you were <strong>50% or less at fault</strong>, with"
 },
 {
  "id": 4858,
  "field": "_roden_key_takeaways",
  "find": "of fault and barred at 51%. You generally have 3",
  "replace": "of fault and barred above 50%. You generally have 3"
 },
 {
  "id": 4858,
  "field": "content",
  "find": " as you are <strong>less than 51% at fault</strong>, but",
  "replace": " as you are <strong>50% or less at fault</strong>, but"
 },
 {
  "id": 4858,
  "field": "content",
  "find": " At 51% or more fault, you recover nothing.",
  "replace": " Above 50% fault, you recover nothing."
 },
 {
  "id": 4859,
  "field": "_roden_faqs:4:answer",
  "find": "barred if you are 51% or more at fault. Property owners",
  "replace": "barred if you are more than 50% at fault. Property owners"
 },
 {
  "id": 4859,
  "field": "_roden_key_takeaways",
  "find": "of fault and barred at 51%. If you fell on",
  "replace": "of fault and barred above 50%. If you fell on"
 },
 {
  "id": 4859,
  "field": "content",
  "find": " as you are <strong>less than 51% at fault</strong>, but",
  "replace": " as you are <strong>50% or less at fault</strong>, but"
 },
 {
  "id": 4859,
  "field": "content",
  "find": " at 51% or more, you recover nothing. Learn",
  "replace": " above 50%, you recover nothing. Learn"
 },
 {
  "id": 4860,
  "field": "_roden_key_takeaways",
  "find": "by your fault (barred at 51%), and Tort Claims Act",
  "replace": "by your fault (barred above 50%), and Tort Claims Act"
 },
 {
  "id": 4860,
  "field": "content",
  "find": " as you are <strong>less than 51% at fault</strong>, but",
  "replace": " as you are <strong>50% or less at fault</strong>, but"
 },
 {
  "id": 4860,
  "field": "content",
  "find": " at 51% or more, you recover nothing. Learn",
  "replace": " above 50%, you recover nothing. Learn"
 },
 {
  "id": 4861,
  "field": "content",
  "find": "if the deceased was 51% or more at fault. Learn how",
  "replace": "if the deceased was more than 50% at fault. Learn how"
 },
 {
  "id": 4870,
  "field": "_roden_faqs:6:answer",
  "find": "no sea mayor al 50%; es decir, su responsabilidad debe ser menor al 51%. El monto que reciba",
  "replace": "no sea mayor al 50%. El monto que reciba"
 },
 {
  "id": 4870,
  "field": "_roden_faqs:6:answer",
  "find": "Si su culpa es del 51% o más, queda impedido de recuperar",
  "replace": "Si su culpa es de más del 50%, queda impedido de recuperar"
 },
 {
  "id": 4871,
  "field": "_roden_faqs:6:answer",
  "find": "que su culpa sea menor al 51%. El monto se reduce",
  "replace": "que su culpa sea del 50% o menos. El monto se reduce"
 },
 {
  "id": 4871,
  "field": "_roden_faqs:6:answer",
  "find": "si su culpa es del 51% o más, queda totalmente impedido de",
  "replace": "si su culpa es de más del 50%, queda totalmente impedido de"
 },
 {
  "id": 4872,
  "field": "_roden_faqs:6:answer",
  "find": "que su culpa sea menor al 51%, y el monto se",
  "replace": "que su culpa sea del 50% o menos, y el monto se"
 },
 {
  "id": 4872,
  "field": "_roden_faqs:6:answer",
  "find": "Si su culpa es del 51% o más, no puede recuperar ninguna",
  "replace": "Si su culpa es de más del 50%, no puede recuperar ninguna"
 },
 {
  "id": 4893,
  "field": "_roden_faqs:5:answer",
  "find": "Carolina del Sur es del 51% (frente al 50% de Georgia), o sea que",
  "replace": "Carolina del Sur es de más del 50% (frente al 50% o más en Georgia), o sea que"
 },
 {
  "id": 4923,
  "field": "_roden_faqs:2:answer",
  "find": "recuperar compensación siempre que haya tenido menos del 51% de la culpa, pero su indemnización se",
  "replace": "recuperar compensación siempre que su culpa haya sido del 50% o menos, pero su indemnización se"
 },
 {
  "id": 4923,
  "field": "_roden_key_takeaways",
  "find": "recuperar compensación siempre que haya tenido menos del 51% de la culpa, con su indemnización reducida",
  "replace": "recuperar compensación siempre que su culpa haya sido del 50% o menos, con su indemnización reducida"
 },
 {
  "id": 4923,
  "field": "content",
  "find": "recuperar compensación siempre que haya tenido <strong>menos del 51% de la culpa</strong>, con su indemnización",
  "replace": "recuperar compensación siempre que su culpa haya sido <strong>del 50% o menos</strong>, con su indemnización"
 },
 {
  "id": 4924,
  "field": "_roden_faqs:3:answer",
  "find": "recuperar compensación siempre que haya tenido menos del 51% de la culpa, aunque su indemnización se",
  "replace": "recuperar compensación siempre que su culpa haya sido del 50% o menos, aunque su indemnización se"
 },
 {
  "id": 4924,
  "field": "_roden_key_takeaways",
  "find": "recuperar compensación siempre que haya tenido menos del 51% de la culpa. Los casos de camiones",
  "replace": "recuperar compensación siempre que su culpa haya sido del 50% o menos. Los casos de camiones"
 },
 {
  "id": 4924,
  "field": "content",
  "find": "recuperar compensación siempre que haya tenido menos del 51% de la culpa, aunque su indemnización se",
  "replace": "recuperar compensación siempre que su culpa haya sido del 50% o menos, aunque su indemnización se"
 },
 {
  "id": 4925,
  "field": "_roden_faqs:1:answer",
  "find": "recuperar compensación siempre que haya tenido menos del 51% de la culpa, aunque su indemnización se",
  "replace": "recuperar compensación siempre que su culpa haya sido del 50% o menos, aunque su indemnización se"
 },
 {
  "id": 4925,
  "field": "_roden_key_takeaways",
  "find": "recuperar compensación siempre que haya tenido menos del 51% de la culpa. La ley de lesiones",
  "replace": "recuperar compensación siempre que su culpa haya sido del 50% o menos. La ley de lesiones"
 },
 {
  "id": 4925,
  "field": "content",
  "find": "recuperar compensación siempre que haya tenido menos del 51% de la culpa, pero su indemnización se",
  "replace": "recuperar compensación siempre que su culpa haya sido del 50% o menos, pero su indemnización se"
 },
 {
  "id": 4927,
  "field": "_roden_faqs:3:answer",
  "find": "recuperar compensación siempre que haya tenido menos del 51% de la culpa, aunque su indemnización se",
  "replace": "recuperar compensación siempre que su culpa haya sido del 50% o menos, aunque su indemnización se"
 },
 {
  "id": 4927,
  "field": "_roden_key_takeaways",
  "find": "recuperar compensación siempre que haya tenido menos del 51% de la culpa. Los motociclistas enfrentan una",
  "replace": "recuperar compensación siempre que su culpa haya sido del 50% o menos. Los motociclistas enfrentan una"
 },
 {
  "id": 4927,
  "field": "content",
  "find": "recuperar compensación siempre que haya tenido menos del 51% de la culpa, con su indemnización reducida",
  "replace": "recuperar compensación siempre que su culpa haya sido del 50% o menos, con su indemnización reducida"
 },
 {
  "id": 4930,
  "field": "_roden_faqs:0:answer",
  "find": "comparativa modificada con barrera del 51%, adoptada en Nelson v.",
  "replace": "comparativa modificada con barrera de más del 50%, adoptada en Nelson v."
 },
 {
  "id": 4930,
  "field": "_roden_faqs:0:answer",
  "find": "mientras su culpa sea menor al 51%, pero su compensación se",
  "replace": "mientras su culpa sea del 50% o menos, pero su compensación se"
 },
 {
  "id": 4930,
  "field": "_roden_faqs:0:answer",
  "find": "porcentaje de culpa. Con 51% o más, no recupera nada.",
  "replace": "porcentaje de culpa. Con más del 50%, no recupera nada."
 },
 {
  "id": 4930,
  "field": "_roden_faqs:1:answer",
  "find": "por su porcentaje. Con 51% o más, queda bloqueado de recuperar",
  "replace": "por su porcentaje. Con más del 50%, queda bloqueado de recuperar"
 },
 {
  "id": 4930,
  "field": "_roden_faqs:1:question",
  "find": "¿Qué es la barrera del 51% en Carolina del Sur?",
  "replace": "¿Qué es la barrera de más del 50% en Carolina del Sur?"
 },
 {
  "id": 4930,
  "field": "_roden_faqs:2:answer",
  "find": "de la culpa sea menor al 51%. Muchas personas asumen erróneamente",
  "replace": "de la culpa sea del 50% o menos. Muchas personas asumen erróneamente"
 },
 {
  "id": 4930,
  "field": "_roden_faqs:4:answer",
  "find": "30%. Mientras su culpa se mantenga por debajo del 51%, usted sí recupera; el",
  "replace": "30%. Mientras su culpa no supere el 50%, usted sí recupera; el"
 },
 {
  "id": 4930,
  "field": "_roden_key_takeaways",
  "find": "modificada con una barrera del 51%. Usted puede recuperar compensación mientras tenga menos del 51% de la culpa por sus propias lesiones, pero su compensación se",
  "replace": "modificada con una barrera de más del 50%. Usted puede recuperar compensación mientras su culpa por sus propias lesiones sea del 50% o menos, pero su compensación se"
 },
 {
  "id": 4930,
  "field": "_roden_key_takeaways",
  "find": "porcentaje de culpa. Con 51% o más de culpa, no recupera",
  "replace": "porcentaje de culpa. Con más del 50% de culpa, no recupera"
 },
 {
  "id": 4930,
  "field": "_roden_meta_description",
  "find": "negligencia comparativa con barrera del 51%: recupera si su culpa es menor al 51%, reducido por su porcentaje.",
  "replace": "negligencia comparativa con barrera de más del 50%: recupera si su culpa es del 50% o menos, reducido por su porcentaje."
 },
 {
  "id": 4930,
  "field": "content",
  "find": " con una <strong>barrera del 51%</strong>. En términos simples:",
  "replace": " con una <strong>barrera de más del 50%</strong>. En términos simples:"
 },
 {
  "id": 4930,
  "field": "content",
  "find": " su culpa sea <strong>menor al 51%</strong> — es decir, 50% o menos — pero lo que",
  "replace": " su culpa sea <strong>del 50% o menos</strong> — pero lo que"
 },
 {
  "id": 4930,
  "field": "content",
  "find": ". Si le asignan 51% o más de la culpa, no",
  "replace": ". Si le asignan más del 50% de la culpa, no"
 },
 {
  "id": 4930,
  "field": "content",
  "find": "¿Qué es la barrera del 51%?</h2>\n<p>Es el corte",
  "replace": "¿Qué es la barrera de más del 50%?</h2>\n<p>Es el corte"
 },
 {
  "id": 4930,
  "field": "content",
  "find": " porcentaje.</li>\n<li>Con <strong>51% o más de culpa</strong>, queda",
  "replace": " porcentaje.</li>\n<li>Con <strong>más del 50% de culpa</strong>, queda"
 },
 {
  "id": 4930,
  "field": "content",
  "find": "</td><td>51% o más</td><td>",
  "replace": "</td><td>Más del 50%</td><td>"
 },
 {
  "id": 4930,
  "field": "content",
  "find": "recupera la mitad. Pero al 51%, lo pierde todo —",
  "replace": "recupera la mitad. Pero por encima del 50%, lo pierde todo —"
 },
 {
  "id": 4930,
  "field": "content",
  "find": "Sí, mientras su culpa quede por debajo del 51%. Muchas personas lesionadas asumen",
  "replace": "Sí, mientras su culpa no supere el 50%. Muchas personas lesionadas asumen"
 },
 {
  "id": 4930,
  "field": "excerpt",
  "find": "comparativa modificada con barrera del 51%: puede recuperar si su culpa es menor al 51%, pero su compensación se",
  "replace": "comparativa modificada con barrera de más del 50%: puede recuperar si su culpa es del 50% o menos, pero su compensación se"
 },
 {
  "id": 4930,
  "field": "title",
  "find": "del Sur: La Regla del 51% Explicada",
  "replace": "del Sur: La Regla de Más del 50% Explicada"
 },
 {
  "id": 4932,
  "field": "_roden_faqs:2:answer",
  "find": "si su culpa es menor al 51%, y su compensación se",
  "replace": "si su culpa es del 50% o menos, y su compensación se"
 },
 {
  "id": 4932,
  "field": "_roden_faqs:2:answer",
  "find": " Con 51% o más de culpa, no recupera",
  "replace": " Con más del 50% de culpa, no recupera"
 },
 {
  "id": 4932,
  "field": "content",
  "find": "culpa y la elimina al 51% o más — si su caso",
  "replace": "culpa y la elimina si su culpa es de más del 50% — si su caso"
 },
 {
  "id": 4937,
  "field": "_roden_faqs:27:answer",
  "find": "completo si usted tiene 51% o más de la responsabilidad. En",
  "replace": "completo si usted tiene más del 50% de la responsabilidad. En"
 },
 {
  "id": 4937,
  "field": "_roden_faqs:28:answer",
  "find": "La barrera del 51% significa que usted puede",
  "replace": "La barrera de más del 50% significa que usted puede"
 },
 {
  "id": 4937,
  "field": "_roden_faqs:28:answer",
  "find": "50% o menos; con 51% o más, queda impedido de recuperar",
  "replace": "50% o menos; con más del 50%, queda impedido de recuperar"
 },
 {
  "id": 4937,
  "field": "_roden_faqs:28:question",
  "find": "regla de la barrera del 51% en Carolina del Sur?",
  "replace": "regla de la barrera de más del 50% en Carolina del Sur?"
 },
 {
  "id": 4937,
  "field": "_roden_faqs:29:answer",
  "find": "comparten el otro 60%, usted queda por debajo de la barrera del 51% y todavía puede recuperar",
  "replace": "comparten el otro 60%, su culpa no supera el 50% y todavía puede recuperar"
 },
 {
  "id": 4937,
  "field": "_roden_faqs:32:answer",
  "find": "a su favor. Como cruzar la línea del 51% termina su reclamo por",
  "replace": "a su favor. Como superar el 50% de culpa termina su reclamo por"
 },
 {
  "id": 4937,
  "field": "_roden_faqs:4:answer",
  "find": "comparativa modificada con barrera del 51%. Puede recuperar mientras su",
  "replace": "comparativa modificada con barrera de más del 50%. Puede recuperar mientras su"
 },
 {
  "id": 4937,
  "field": "_roden_faqs:4:answer",
  "find": " Con 51% o más de culpa, no recupera",
  "replace": " Con más del 50% de culpa, no recupera"
 },
 {
  "id": 4937,
  "field": "_roden_faqs:59:answer",
  "find": "barrera de culpa comparativa del 51%. Lo que cambia es",
  "replace": "barrera de culpa comparativa de más del 50%. Lo que cambia es"
 },
 {
  "id": 4937,
  "field": "_roden_faqs:68:answer",
  "find": "culpa bajo la regla del 51%. Un abogado puede evaluar",
  "replace": "culpa bajo la regla de más del 50%. Un abogado puede evaluar"
 },
 {
  "id": 4937,
  "field": "_roden_faqs:79:answer",
  "find": "Es posible. La regla del 51% de negligencia comparativa también aplica a los",
  "replace": "Es posible. La regla de negligencia comparativa modificada también aplica a los"
 },
 {
  "id": 4937,
  "field": "_roden_faqs:79:answer",
  "find": "Si el fallecido tuvo 51% o más de la culpa, no",
  "replace": "Si el fallecido tuvo más del 50% de la culpa, no"
 },
 {
  "id": 4937,
  "field": "_roden_key_takeaways",
  "find": "mientras su culpa sea menor al 51%. No existe un acuerdo",
  "replace": "mientras su culpa sea del 50% o menos. No existe un acuerdo"
 },
 {
  "id": 4938,
  "field": "content",
  "find": "del Sur: La Regla del 51%</a> — cómo la ",
  "replace": "del Sur: La Regla de Más del 50%</a> — cómo la "
 },
 {
  "id": 5220,
  "field": "_roden_faqs:5:answer",
  "find": "recover if you are less than 51% at fault. Trucking insurers",
  "replace": "recover if you are 50% or less at fault. Trucking insurers"
 },
 {
  "id": 5220,
  "field": "content",
  "find": "Recover if you are less than 51% at fault</td></tr><tr><td>",
  "replace": "Recover if you are 50% or less at fault</td></tr><tr><td>"
 },
 {
  "id": 5220,
  "field": "content",
  "find": "</a>, <a href=\"/resources/south-carolina-comparative-negligence/\">South Carolina's 51% bar</a> and a ",
  "replace": "</a>, <a href=\"/resources/south-carolina-comparative-negligence/\">South Carolina's more-than-50% bar</a> and a "
 },
 {
  "id": 5352,
  "field": "_roden_key_takeaways",
  "find": "South Carolina bars it at 51% or more (Nelson v. Concrete Supply",
  "replace": "South Carolina bars it above 50% (Nelson v. Concrete Supply"
 },
 {
  "id": 5352,
  "field": "content",
  "find": "bar: 50% in Georgia, 51% in South Carolina</h2>\r\n",
  "replace": "bar: 50% in Georgia, more than 50% in South Carolina</h2>\r\n"
 },
 {
  "id": 5352,
  "field": "content",
  "find": "or more</strong></td>\r\n<td><strong>51% or more</strong></td>\r\n</tr>\r\n<tr>\r\n<td>",
  "replace": "or more</strong></td>\r\n<td><strong>More than 50%</strong></td>\r\n</tr>\r\n<tr>\r\n<td>"
 },
 {
  "id": 5352,
  "field": "content",
  "find": "</strong></td>\r\n</tr>\r\n<tr>\r\n<td>51%</td>\r\n<td>",
  "replace": "</strong></td>\r\n</tr>\r\n<tr>\r\n<td>More than 50%</td>\r\n<td>"
 },
 {
  "id": 5352,
  "field": "content",
  "find": "comparative negligence and the 51% bar</a> — the ",
  "replace": "comparative negligence and the more-than-50% bar</a> — the "
 },
 {
  "id": 5352,
  "field": "excerpt",
  "find": "South Carolina bars it at 51%. A driver found exactly",
  "replace": "South Carolina bars it only above 50%. A driver found exactly"
 },
 {
  "id": 5352,
  "field": "title",
  "find": "Georgia vs South Carolina: The 50% and 51% Bars",
  "replace": "Georgia vs South Carolina: Barred at 50% vs. More Than 50%"
 },
 {
  "id": 5353,
  "field": "content",
  "find": "</li>\r\n \t<li><a href=\"/resources/south-carolina-comparative-negligence/\">South Carolina's 51% comparative negligence bar</a></li>",
  "replace": "</li>\r\n \t<li><a href=\"/resources/south-carolina-comparative-negligence/\">South Carolina's more-than-50% comparative negligence bar</a></li>"
 },
 {
  "id": 5355,
  "field": "content",
  "find": "</li>\r\n \t<li><a href=\"/resources/south-carolina-comparative-negligence/\">South Carolina's 51% bar explained</a></li>\r\n \t<li>",
  "replace": "</li>\r\n \t<li><a href=\"/resources/south-carolina-comparative-negligence/\">South Carolina's more-than-50% bar explained</a></li>\r\n \t<li>"
 },
 {
  "id": 6313,
  "field": "_roden_faqs:1:answer",
  "find": "long as you are less than 51% at fault (Nelson v.",
  "replace": "long as you are 50% or less at fault (Nelson v."
 },
 {
  "id": 6313,
  "field": "_roden_key_takeaways",
  "find": " as you are <strong>less than 51%</strong> at fault (<em>",
  "replace": " as you are <strong>50% or less</strong> at fault (<em>"
 },
 {
  "id": 6313,
  "field": "content",
  "find": " as you are <strong>less than 51%</strong> at fault, under ",
  "replace": " as you are <strong>50% or less</strong> at fault, under "
 },
 {
  "id": 6314,
  "field": "_roden_faqs:3:answer",
  "find": "long as you are less than 51% at fault (Nelson v.",
  "replace": "long as you are 50% or less at fault (Nelson v."
 },
 {
  "id": 6314,
  "field": "_roden_key_takeaways",
  "find": "— and recover if less than 51% at fault (<em>Nelson",
  "replace": "— and recover if 50% or less at fault (<em>Nelson"
 },
 {
  "id": 6314,
  "field": "content",
  "find": "long as you are less than 51% at fault, under <em>",
  "replace": "long as you are 50% or less at fault, under <em>"
 },
 {
  "id": 6316,
  "field": "_roden_faqs:4:answer",
  "find": "recover if you are less than 51% at fault. Our South",
  "replace": "recover if you are 50% or less at fault. Our South"
 },
 {
  "id": 6316,
  "field": "_roden_key_takeaways",
  "find": "— and recover if less than 51% at fault (<em>Nelson",
  "replace": "— and recover if 50% or less at fault (<em>Nelson"
 },
 {
  "id": 6316,
  "field": "content",
  "find": "long as you are less than 51% at fault, under <em>",
  "replace": "long as you are 50% or less at fault, under <em>"
 }
]
EDITS;

if ( ! defined( 'ABSPATH' ) ) { fwrite( STDERR, "Run through wp eval-file.\n" ); exit( 1 ); }
$apply = isset( $args[0] ) && 'apply' === $args[0];
$edits = json_decode( $table_json, true );
if ( ! is_array( $edits ) || count( $edits ) !== $expected_rows ) { echo "ABORT: edit table did not parse\n"; exit( 1 ); }

// Fields whose change is a visible-text change (stamps _roden_content_modified).
$visible = array( 'title', 'excerpt', 'content', '_roden_faqs', '_roden_key_takeaways', '_roden_meta_description' );
$core    = array( 'title' => 'post_title', 'excerpt' => 'post_excerpt', 'content' => 'post_content' );

// field spec: "title" | "excerpt" | "content" | "<meta_key>" | "<meta_key>:<index>:<subkey>"
$surface_of = function ( $field ) { $p = explode( ':', $field ); return $p[0]; };

$work = array(); $orig = array(); $slugs = array(); $fail = 0;
foreach ( $edits as $e ) {
	$id = (int) $e['id'];
	if ( ! isset( $work[ $id ] ) ) {
		$post = get_post( $id );
		if ( ! $post || 'publish' !== $post->post_status ) { echo "FAIL $id: missing or not published\n"; $fail++; continue; }
		$work[ $id ] = array(); $orig[ $id ] = array(); $slugs[ $id ] = $post->post_name;
	}
	$s = $surface_of( $e['field'] );
	if ( array_key_exists( $s, $work[ $id ] ) ) { continue; }
	if ( isset( $core[ $s ] ) ) {
		$v = get_post( $id )->{ $core[ $s ] };
	} else {
		if ( ! metadata_exists( 'post', $id, $s ) ) { echo "FAIL $id: no $s meta\n"; $fail++; continue; }
		$v = get_post_meta( $id, $s, true );
	}
	$work[ $id ][ $s ] = $v; $orig[ $id ][ $s ] = $v;
}
if ( $fail ) { echo "ABORT: $fail post/field failures, nothing written\n"; exit( 1 ); }

$would = 0; $done = 0; $per_post = array(); $per_field = array();
foreach ( $edits as $e ) {
	$id = (int) $e['id']; $parts = explode( ':', $e['field'] ); $s = $parts[0];
	if ( 3 === count( $parts ) ) {
		$i = (int) $parts[1]; $k = $parts[2];
		$cur = ( is_array( $work[ $id ][ $s ] ) && isset( $work[ $id ][ $s ][ $i ][ $k ] ) ) ? $work[ $id ][ $s ][ $i ][ $k ] : null;
	} else {
		$cur = $work[ $id ][ $s ];
	}
	if ( ! is_string( $cur ) ) { echo "FAIL $id {$e['field']}: not a string\n"; $fail++; continue; }
	$n = substr_count( $cur, $e['find'] );
	if ( 0 === $n && substr_count( $cur, $e['replace'] ) >= 1 ) { echo "OK    $id {$e['field']} already applied\n"; $done++; continue; }
	if ( 1 !== $n ) { echo "FAIL  $id {$e['field']}: anchor matched $n times\n      " . $e['find'] . "\n"; $fail++; continue; }
	$new = str_replace( $e['find'], $e['replace'], $cur );
	if ( 3 === count( $parts ) ) { $work[ $id ][ $s ][ $i ][ $k ] = $new; } else { $work[ $id ][ $s ] = $new; }
	$would++; $per_post[ $id ] = true; $per_field[ $id . ' ' . $e['field'] ] = true;
	echo ( $apply ? 'EDIT  ' : 'WOULD ' ) . "$id {$e['field']}\n      - " . $e['find'] . "\n      + " . $e['replace'] . "\n";
}
if ( $fail ) { echo "ABORT: $fail anchor failure(s), nothing written\n"; exit( 1 ); }

// Retitled posts must keep their slug; print it so the reviewer sees it.
foreach ( $work as $id => $surfaces ) {
	if ( isset( $surfaces['title'] ) && $surfaces['title'] !== $orig[ $id ]['title'] ) {
		echo "RETITLE $id " . get_permalink( $id ) . "\n      - " . $orig[ $id ]['title'] . "\n      + " . $surfaces['title'] . "\n";
	}
}
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

global $wpdb; $now = gmdate( 'Y-m-d H:i:s' );
foreach ( $work as $id => $surfaces ) {
	$postarr = array( 'ID' => $id ); $stamp = false;
	foreach ( $surfaces as $s => $val ) {
		if ( $val === $orig[ $id ][ $s ] ) { continue; }
		if ( in_array( $s, $visible, true ) ) { $stamp = true; }
		if ( isset( $core[ $s ] ) ) { $postarr[ $core[ $s ] ] = $val; }
	}
	if ( count( $postarr ) > 1 ) {
		$r = wp_update_post( wp_slash( $postarr ), true );
		if ( is_wp_error( $r ) ) { echo "FAILED write $id: " . $r->get_error_message() . "\n"; exit( 1 ); }
	}
	foreach ( $surfaces as $s => $val ) {
		if ( $val === $orig[ $id ][ $s ] || isset( $core[ $s ] ) ) { continue; }
		update_post_meta( $id, $s, wp_slash( $val ) );
	}
	if ( $stamp ) { update_post_meta( $id, '_roden_content_modified', wp_slash( $now ) ); }
	clean_post_cache( $id ); wp_cache_delete( $id, 'post_meta' );
	// Read back from the tables, not the cache.
	$row = $wpdb->get_row( $wpdb->prepare( "SELECT post_title, post_excerpt, post_content, post_name FROM {$wpdb->posts} WHERE ID = %d", $id ) );
	if ( $row->post_name !== $slugs[ $id ] ) { echo "FAILED slug changed on $id\n"; exit( 1 ); }
	foreach ( $surfaces as $s => $val ) {
		if ( isset( $core[ $s ] ) ) {
			$back = $row->{ $core[ $s ] };
		} else {
			$back = maybe_unserialize( $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = %s", $id, $s ) ) );
		}
		if ( $back !== $val ) { echo "FAILED read-back $id $s\n"; exit( 1 ); }
	}
	echo "read-back OK $id\n";
}
echo "DONE apply clean. Next: wp cache flush && wp page-cache flush; php bin/check-unslashed-post-writes.php | wp eval-file -; re-export content/meta.json\n";
exit( 0 );
