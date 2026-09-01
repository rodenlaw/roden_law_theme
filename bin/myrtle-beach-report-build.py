#!/usr/bin/env python3
"""
Render the Grand Strand Fatal Crash Report body and seed payload FROM the stats
file, so no number in the prose can drift from the analysis that produced it.

    python3 bin/myrtle-beach-report-build.py \
        --stats research/myrtle-beach-report-stats.json \
        --csv   research/horry-county-fatal-crashes-2020-2024.csv \
        --out   research/guides/

Every figure below is interpolated. If a number in the published page is wrong,
either the analysis is wrong or this file is — there is no third place for a
number to come from, which is the point.
"""
import argparse, json, os

MONTHS = ["", "January", "February", "March", "April", "May", "June",
          "July", "August", "September", "October", "November", "December"]


def build(st):
    h, sc, gt = st["horry"], st["south_carolina"], st["georgetown"]
    se, pd_ = st["seasonality"], st["pedestrian"]
    by_month = {int(k): v for k, v in se["horry_by_month"].items()}
    ranked = sorted(by_month.items(), key=lambda kv: -kv[1])
    top3 = ranked[:3]
    counties = st["sc_counties_top"]
    rank = next((i + 1 for i, c in enumerate(counties) if "HORRY" in c["county"].upper()), None)
    leader = counties[0]
    not_int = st["intersection"].get("Not an Intersection", 0)
    not_int_pct = round(100 * not_int / h["crashes"], 1)
    roads = st["roads"]
    us17 = sum(r["crashes"] for r in roads if r["road"].startswith("US-17"))
    us501 = sum(r["crashes"] for r in roads if r["road"].startswith("US-501"))
    hour = {int(k): v for k, v in st["hour"].items()}
    peak_h = max(hour, key=lambda k: hour[k])
    ped_ratio = round(pd_["horry_pct"] / pd_["sc_pct"], 2) if pd_["sc_pct"] else 0
    yrs = st["by_year"]

    rows = "\n".join(
        f"<tr><td>{y}</td><td>{v['horry_crashes']}</td><td>{v['horry_deaths']}</td>"
        f"<td>{v['sc_crashes']}</td></tr>" for y, v in yrs.items())
    mrows = "\n".join(
        f"<tr><td>{MONTHS[m]}</td><td>{by_month[m]}</td></tr>"
        for m in sorted(by_month, key=lambda k: -by_month[k])[:6])

    html = f"""<p><strong>Between 2020 and 2024, {h['crashes']} fatal crashes killed {h['deaths']} people in Horry County, South Carolina</strong> — the county containing Myrtle Beach, North Myrtle Beach, Conway and Surfside Beach. That is {h['share_of_sc_crashes_pct']}% of every fatal crash in the state, and the {"second" if rank == 2 else str(rank) + "th"}-highest county total in South Carolina, behind {leader['county'].split(' (')[0].title()} County ({leader['crashes']}).</p>

<p>This report is a census, not a survey. It counts every crash on a public road in Horry County in which someone died within 30 days, as recorded by the federal Fatality Analysis Reporting System. The analysis script and the crash-level dataset are published below so that any figure here can be checked or contradicted.</p>

<h2>The finding: summer is not the deadliest season on the Grand Strand</h2>
<p>The common explanation for Myrtle Beach road danger is the summer visitor influx. The fatal-crash record does not support it.</p>
<p><strong>{se['horry_summer_pct']}% of Horry County's fatal crashes occurred in June, July and August</strong> — {se['horry_summer_crashes']} of {h['crashes']}. That is below the {se['expected_pct_if_flat']}% a flat distribution across the year would produce, and below South Carolina's own summer share of {se['sc_summer_pct']}%. Summer is, if anything, slightly safer than average on the Grand Strand.</p>
<p>The worst months are {MONTHS[top3[0][0]]} ({top3[0][1]}), {MONTHS[top3[1][0]]} ({top3[1][1]}) and {MONTHS[top3[2][0]]} ({top3[2][1]}).</p>
<table class="comparison-table">
<thead><tr><th>Month</th><th>Fatal crashes, 2020–2024</th></tr></thead>
<tbody>
{mrows}
</tbody>
</table>
<p>This does not mean summer traffic is harmless. It means the fatal-crash burden is spread across the year rather than concentrated in the tourist season, and that a claim of a summer peak needs a source that measures something other than deaths.</p>

<h2>What is genuinely unusual: people outside vehicles</h2>
<p>The distinctive feature of Horry County's fatal crashes is not when they happen but who dies in them.</p>
<p><strong>{pd_['horry_pct']}% of Horry County fatal crashes involved a pedestrian or other non-occupant, against {pd_['sc_pct']}% statewide</strong> — {ped_ratio}× the South Carolina rate. On a coastal strip where people walk between motels, restaurants and the beach across multi-lane arterials, that is the number that separates this county from the rest of the state.</p>
<p>It pairs with when these crashes happen: the single worst hour is {peak_h}:00, and the evening hours dominate. A pedestrian-heavy fatal-crash profile after dark is a different problem from a tourist-traffic-volume problem, and it points at different fixes.</p>

<h2>Five years, and no clear trend</h2>
<table class="comparison-table">
<thead><tr><th>Year</th><th>Horry fatal crashes</th><th>Horry deaths</th><th>South Carolina crashes</th></tr></thead>
<tbody>
{rows}
</tbody>
</table>
<p>Horry County's totals rose to {max(v['horry_crashes'] for v in yrs.values())} in {max(yrs, key=lambda y: yrs[y]['horry_crashes'])} and fell back since. Five annual points are not a trend, and the most recent year is the least settled.</p>

<h2>Where on the road</h2>
<p>Two federal routes carry most of the crashes where a route was recorded: <strong>US-17 ({us17}) and US-501 ({us501})</strong>. US-17 is the Grand Strand's spine — the Kings Highway and bypass corridor that every beach community sits on.</p>
<p>Most fatal crashes are not at junctions at all. <strong>{not_int} of {h['crashes']} ({not_int_pct}%) happened away from any intersection</strong>, which is worth stating plainly because "most dangerous intersections" lists are the usual way this subject is covered. Fatal crashes on the Grand Strand are predominantly a mid-block and open-road problem. The split between urban and rural settings is {st['land_use'].get('Urban', 0)} urban to {st['land_use'].get('Rural', 0)} rural.</p>
<p>For context, neighbouring Georgetown County — Pawleys Island and Murrells Inlet — recorded {gt['crashes']} fatal crashes and {gt['deaths']} deaths over the same five years.</p>

<h2>What this report does not show</h2>
<ul>
<li><strong>It counts deaths, not crashes in general.</strong> FARS records only crashes in which someone died. A junction producing hundreds of injury crashes and no fatalities is invisible here. Nothing in this report ranks intersections by overall crash frequency, and it should not be cited as if it did.</li>
<li><strong>It has no exposure denominator.</strong> Horry County's resident population is not its road population — the summer visitor load is precisely what people mean by Grand Strand traffic, and no public dataset measures it by segment. "More fatal crashes" is therefore not "more dangerous per mile driven", and no per-capita rate is computed here because the resident denominator would systematically mislead.</li>
<li><strong>It cannot separate visitors from residents.</strong> FARS records where a crash happened, not where anyone lived.</li>
<li><strong>2024 is provisional.</strong> FARS is republished as cases complete, so the most recent year may be revised.</li>
</ul>

<h2>Methodology</h2>
<p>Source: NHTSA Fatality Analysis Reporting System, national annual files {st['years'][0]}–{st['years'][-1]}. Horry County is FARS <code>STATE 45, COUNTY 51</code>; Georgetown is <code>COUNTY 43</code>. Summer is months 6–8. "Pedestrian or other non-occupant" is <code>PEDS &gt; 0</code>, which counts persons not in a motor vehicle and is reported with that wording rather than as "pedestrian" alone, because the field is slightly broader.</p>
<p>The analysis is machine-generated from published federal data by a script committed alongside this report; run it against the same files and it reproduces these numbers exactly, or the report is wrong and should be corrected.</p>

<h2>The data</h2>
<p>The crash-level dataset behind every figure above is published as a CSV: one row per fatal crash, with year, county, city, month, hour, deaths, non-occupants, roadway, land use, intersection type and coordinates.</p>
"""
    # Must fit the 160-char meta-description budget WITHOUT truncating mid-word:
    # this string becomes both post_excerpt and the Article schema description.
    excerpt = (f"{h['crashes']} fatal crashes killed {h['deaths']} people in Horry County, "
               f"{st['years'][0]}–{st['years'][-1]}. Summer is not the deadliest season, and "
               f"{pd_['horry_pct']}% involved a pedestrian.")
    if len(excerpt) > 160:
        excerpt = excerpt[:157].rsplit(" ", 1)[0] + "…"
    return html, excerpt


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--stats", required=True)
    ap.add_argument("--csv", required=True)
    ap.add_argument("--out", required=True)
    a = ap.parse_args()
    st = json.load(open(a.stats))
    html, excerpt = build(st)
    os.makedirs(a.out, exist_ok=True)
    open(os.path.join(a.out, "myrtle-beach-fatal-crashes.html"), "w").write(html)
    payload = {
        "slug": "myrtle-beach-fatal-crashes",
        "title": "Grand Strand Fatal Crash Report: Horry County, 2020–2024",
        "content": html,
        "excerpt": excerpt,
        "author_slug": "graeham-c-gillin",
        "csv_name": "horry-county-fatal-crashes-2020-2024.csv",
        "csv_body": open(a.csv).read(),
    }
    p = os.path.join(a.out, "payload-myrtle-beach-fatal-crashes.json")
    json.dump(payload, open(p, "w"), indent=1)
    print(f"wrote {p}  ({len(html.split())} words)")
    print("excerpt:", excerpt)


if __name__ == "__main__":
    main()
