# GSC 16-month benchmark — the freshness loop's before-picture

**Data:** `docs/gsc-2026-10-06/`, pulled 2026-10-06 from the Search Console API against the domain
property `sc-domain:rodenlaw.com`, web search, `dataState: final`. **16 months: 2025-05-24 → 2026-10-03**
(the API's full retained window; `final` data ends 10-03, `all` adds 10-04/05 and is marked where used).
Cohorts are frozen in `docs/gsc-2026-10-06/cohorts.json`. Re-run any checkpoint with
`bin/freshness-benchmark.py` (usage in its header).

This is the baseline every blog refinement since 2026-09-23 is measured against: the 89-post freshness
queue (79 refreshed and live), the group 1/2 follow-ups, and the firm-facts pass.

## Read this first: the measurement window is contaminated

**Google's September 2026 spam update began 2026-09-24**, one day after the first refresh batch went
live. It hit in two waves (09-25→27 and 09-30→10-01), it carries a two-week rollout estimate, and as of
10-05 the Search Status Dashboard still showed it active (expected done ~10-08). Every refreshed post's
post-refresh data so far sits inside that rollout. Google's own guidance is to compare the week *after*
an update completes with a week *before* it started. **No verdict on the refreshes is possible before
about 2026-10-20.**

So the baseline window used throughout is the **28 days before the update: 2026-08-27 → 2026-09-23**,
not "the 28 days before each refresh". The per-post CSV carries both.

## 1. The 16 months, site and blog

| Month | Site clicks | Site impr. | Site pos | Blog clicks | Blog impr. | Blog pos |
|---|---:|---:|---:|---:|---:|---:|
| 2025-06 | 3,236 | 1,069,302 | 28.3 | 2,774 | 542,328 | 26.4 |
| 2025-07 | 3,508 | 1,211,158 | 28.6 | 2,939 | 547,809 | 25.5 |
| **2025-08** | **3,920** | 1,380,712 | 33.9 | **3,261** | 818,375 | 35.9 |
| 2025-09 | 2,989 | 747,988 | 21.3 | 2,516 | 442,564 | 18.1 |
| 2025-10 | 2,450 | 515,207 | 13.4 | 1,998 | 317,866 | 11.4 |
| 2025-11 | 2,252 | 570,331 | 13.7 | 1,837 | 332,323 | 12.4 |
| 2025-12 | 1,952 | 526,951 | 16.9 | 1,436 | 292,243 | 14.7 |
| 2026-01 | 1,184 | 370,052 | 20.3 | 758 | 167,950 | 19.3 |
| 2026-02 | 1,049 | 336,438 | 16.4 | 587 | 156,024 | 16.5 |
| 2026-03 | 1,031 | 414,448 | 15.1 | 583 | 195,181 | 13.9 |
| 2026-04 | 1,671 | 693,038 | 13.7 | 1,025 | 375,752 | 11.4 |
| 2026-05 | 1,982 | 940,539 | 16.5 | 1,163 | 433,610 | 13.8 |
| 2026-06 | 1,463 | 636,094 | 17.9 | 834 | 271,480 | 14.2 |
| 2026-07 | 1,195 | 457,121 | 21.5 | 503 | 158,725 | 19.0 |
| 2026-08 | 1,132 | 455,316 | 22.0 | 501 | 158,371 | 22.8 |
| **2026-09** | **1,202** | 477,812 | 17.5 | **497** | 143,731 | 17.9 |

(2025-05 is a partial month from the 24th; 2026-10 is 3 days. Blog includes `/es/blog/`, which earned
9 clicks in 16 months.)

16-month totals: **32,981 clicks, 11.09M impressions** site-wide; **23,806 clicks** on the English blog.
The blog went from ~3,000 clicks a month in mid-2025 to ~500 a month from July 2026, a −83% drop. The two
step-downs line up with the December 2025 and May 2026 core updates (see `gsc-audit-90d-2026-09-23.md`
§1). July–September 2026 is the flat floor the refreshes start from: **~500 blog clicks a month,
~16–17 a day.**

## 2. Where the blog's clicks live: the refreshed 79 are three-quarters of it

| Group (live EN posts) | Posts | Clicks, 16 mo | Impr., 16 mo | Share of blog clicks |
|---|---:|---:|---:|---:|
| **Refreshed (freshness loop)** | 79 | **17,686** | 3,114,627 | **74%** |
| Control (never queued) | 279 | 4,777 | 1,763,526 | 20% |
| Retired, merged or redirected since | 280 paths | 1,352 | 598,661 | 6% |

The queue was built from the posts that lost the most in the 2026 core updates, so this is the population
the loop was meant to cover. It also means the control is **not like-for-like**. It is mostly long-tail
posts sitting at position ~35 (baseline), while the refreshed set sits at ~14.5. Read §4 with that in mind.

## 3. The baseline, by cohort (per day)

| Window | Refreshed 09-23→25 (42) | Refreshed 10-02→05 (37) | All refreshed (79) | Control (279) |
|---|---|---|---|---|
| Year-ago (2025-08-27→09-23) | 61.9 clk · 7,911 impr · pos 15.5 | 6.6 · 1,102 · 22.7 | **68.5 · 9,013 · 16.4** | 17.8 · 5,678 · 29.4 |
| 90 days (2026-06-25→09-22) | 5.2 · 2,196 · 15.2 | 6.1 · 1,313 · 16.6 | 11.3 · 3,509 · 15.7 | 4.0 · 1,448 · 31.7 |
| **Baseline 28d (2026-08-27→09-23)** | **4.8 · 2,002 · 14.5** | **5.8 · 1,164 · 14.6** | **10.6 · 3,166 · 14.5** | **4.5 · 1,464 · 34.6** |

**The number to beat: the 79 refreshed posts earned 10.6 clicks a day on 3,166 impressions at average
position 14.5 in the 28 days before the update.** A year earlier the same posts earned 68.5 a day.

Site-wide over the same baseline: 38.9 clicks/day, 16,028 impressions/day, position 18.8.

The full per-post table, with 16-month totals, peak month, year-ago 28d, 90d and 28d before each post's own
refresh date, plus post-refresh so far, is `docs/gsc-2026-10-06/refreshed_baseline.csv`. The top 15
queries per refreshed post (90 days before the first refresh, 1,140 rows) are in
`refreshed_query_baseline.csv`. Those are the queries to re-rank at each checkpoint.

Biggest baseline earners (90 days before refresh):

| Post | Refreshed | 16-mo clicks | Peak month | 90d clicks | 28d clicks · impr · pos |
|---|---|---:|---|---:|---|
| medical-malpractice-limits-south-carolina | 10-05 | 189 | 2026-04 (34) | 82 | 20 · 2,882 · 8.0 |
| myrtle-beach-dangerous-roads-intersections | 10-05 | 85 | 2026-07 (19) | 51 | 15 · 3,494 · 9.4 |
| insurance-company-ignoring-demand-letter | 09-23 | 882 | 2025-10 (126) | 50 | 21 · 1,201 · 14.9 |
| south-carolina-statute-of-limitations-personal-injury | 10-05 | 94 | 2026-07 (25) | 50 | 15 · 1,611 · 8.6 |
| average-personal-injury-settlement-amounts | 10-02 | 94 | 2026-06 (32) | 35 | 11 · 2,126 · 14.8 |
| liability-for-epilepsy-related-car-accidents | 09-24 | 978 | 2025-06 (175) | 32 | 19 · 1,061 · 6.9 |
| what-happens-if-i-resign-while-on-workers-compensation | 09-23 | 411 | 2025-09 (56) | 29 | 3 · 1,001 · 10.5 |
| gym-injury-liability | 10-02 | 378 | 2025-08 (57) | 25 | 12 · 1,186 · 10.1 |
| can-an-insurance-company-go-against-a-police-report | 09-23 | 2,071 | 2025-08 (304) | 18 | 5 · 1,970 · 7.9 |
| fault-vs-no-fault-car-insurance | 09-23 | 335 | 2025-11 (43) | 19 | 5 · 14,285 · 10.5 |

14 of the 79 had zero clicks in their pre-refresh 28 days.

## 4. Early read: inside the rollout, not a verdict

From 2026-09-26 to 10-01, cohort A had been refreshed and cohort B had not (B went live 10-02→05). Over
those days B is the fairest comparator, because it holds the same kind of post with no refresh yet.

| 2026-09-26→10-01 vs baseline | Impressions | Clicks | Avg pos |
|---|---:|---:|---|
| A, refreshed (42) | **−24%** | **−10%** | 14.5 → 13.3 |
| B, same kind of post, not yet refreshed (37) | **−32%** | **−23%** | 14.6 → 12.2 |
| Control, all (279) | +4% | 0% | 34.6 → 23.6 |
| Control, baseline pos ≤20 and ≥200 impr. (25) | +1% | −18% | 13.1 → 10.6 |

What this says, and what it doesn't:

1. **The spam update is hitting the evergreen-explainer population as a class.** Refreshed and
   unrefreshed queue posts both lost about a quarter to a third of their impressions. The long-tail
   control did not. The refreshes did not cause this, because B fell further without being touched.
2. **Refreshed posts are falling less than their unrefreshed twins** (−10% clicks vs −23%). The
   direction is right, but the gap is about 1 click a day on 6 days of data, inside a live rollout. Treat it as
   a hypothesis.
3. **Average position "improving" while impressions fall is a mix effect.** The posts are losing
   their deep-position impressions first. Don't read it as a ranking gain.
4. The week of 2026-09-29 → 10-05 (with 10-04/05 fresh data) shows the whole blog down from 10-01, including
   the control (−29% impressions). That is the 09-30 second wave.

One post explains a third of cohort A's impression loss: **compensatory-damages-vs-punitive-damages**
went from ~230 impressions/day at position ~7.5 to ~30/day at ~18. **The slide began 09-19→09-22, before
its 09-23 refresh.** It is on the watch list, but the refresh did not start it.

## 5. Checkpoints

| When | Pull through | Compare | Question |
|---|---|---|---|
| **~2026-10-20** | 10-17 | first full week after the update completes vs 09-17→23 | How hard did the update hit each cohort? Is the A–B gap still there? |
| **2026-11-03** | 10-31 | 2026-10-04→10-31 (28d) vs baseline 28d | First clean 28-day read for all 79, against the control |
| **2026-12-01** | 11-28 | 8 weeks post | Do re-ranked queries hold? Use `refreshed_query_baseline.csv` |
| **2027-01-05** | 01-02 | 90d post vs 90d baseline (06-25→09-22) | The verdict. Google puts core-update recovery at 3–6 months typically, so expect this to still be early. |

```bash
~/.venvs/google-ads/bin/python bin/freshness-benchmark.py --post 2026-10-04 2026-10-31 --pull \
  --cache /tmp/roden-post.csv --out /tmp/roden-perpost.csv
```

Two things will muddy every checkpoint:

- **Group 1/2 follow-ups and firm-facts edits (10-05/06)** touched refreshed *and* control pages
  (e.g. "typically advanced" on 14 pages). They are small wording changes, but note them if a control
  page jumps.
- **Seasonality.** The year-ago blog fell 21% from September to October 2025 (2,516 → 1,998). The control absorbs this;
  a naive before/after does not.

## Method notes

- URLs normalized to path (scheme, host, query and fragment stripped), so `www.`/`http` variants sum
  into one row. The domain property captures them; the URL-prefix property would not.
- Refreshed = queue URL (`data/local-seo/freshness-queue-2026-09-23.json`), live, with
  `_roden_last_reviewed` ≥ 2026-09-23 in `content/meta.json` as of commit `fc09d9b`. Control = live EN
  `/blog/` posts not in the queue (279, including 29 reviewed for other reasons in July–September).
  Retired, merged and redirected queue posts (10) are excluded from both. Post 4337 now carries 4624's
  merged content and inbound redirect, so its post-refresh numbers include 4624's traffic.
- Per-day rates throughout; windows differ in length.
- Files: `daily_final.csv`, `daily_all.csv` (site per day); `pages_16mo.csv`; `queries_16mo.csv.gz`
  (107,812 queries); `blog_page_date.csv.gz` (168,916 blog page×day rows, the input to the
  benchmark script); `blog_page_date_fresh.csv` (09-15→10-06, `all` state);
  `blog_page_query_pre90.csv`; `page_device_16mo.csv`; `site_page_date_tail.csv.gz` /
  `site_query_date_tail.csv.gz` (09-08→10-05, `all` state); `refreshed_baseline.csv`;
  `refreshed_query_baseline.csv`; `cohorts.json`.
- Spam-update dates: Google Search Status Dashboard via press coverage, 2026-10-05 (Search Engine
  Roundtable and the week-40 news roundups). Recheck the dashboard for the completion date before the 10-20 read.
