#!/usr/bin/env python3
"""
Grand Strand Fatal Crash Report — the analysis behind
/resources/myrtle-beach-fatal-crashes/.

Committed for the same reason as bin/corridor-report-analysis.py: the report's
only real asset is that anyone can check it. Run this against the same FARS files
and you get the same numbers, or the report is wrong and should be corrected.

    python3 bin/myrtle-beach-report-analysis.py --fars-dir <dir> --out research/

WHY THIS STUDY EXISTS
    "why is myrtle beach so dangerous" earns 13,785 impressions at position 9.3,
    and the page currently answering it asserts an intersection ranking, a "65%
    more accidents than the second-most hazardous" figure and two raw crash
    counts, none of which name a checkable source. This replaces assertion with
    a census.

    THE QUESTION IS ANSWERED HONESTLY OR NOT AT ALL. If Horry County turns out
    not to be unusually dangerous, that is the finding and the report says so.
    A study written to confirm its title is marketing, and it would not survive
    the first person who checks it.

DATA
    NHTSA Fatality Analysis Reporting System (FARS), national annual files,
    2020-2024, from
    https://static.nhtsa.gov/nhtsa/downloads/FARS/<year>/National/FARS<year>NationalCSV.zip

    FARS is a census of crashes on US public roads in which someone died within
    30 days. It is FATAL CRASHES ONLY. It says nothing about injury or
    property-damage crashes, and every figure here must be described as fatal.
    An intersection that produces many injury crashes and no deaths is invisible
    here, which is exactly why this report cannot rank "most dangerous
    intersections" and does not try.

DEFINITIONS
    Grand Strand  FARS accident.COUNTY == 51 in STATE == 45 (Horry County, SC).
                  County codes here are the state FIPS county codes (odd-numbered:
                  Charleston 19, Horry 51, Georgetown 43), NOT a sequential index.
                  Georgetown was first coded 22 in this script, which is not a
                  South Carolina county code at all and returned zero rows
                  silently — the same failure class as the BOM bug below, caught
                  the same way, by an impossible number rather than an error.
                  Horry is the county containing Myrtle Beach, North Myrtle
                  Beach, Conway and Surfside Beach. Georgetown County (COUNTY 22)
                  is reported separately where noted; it contains Pawleys Island
                  and Murrells Inlet and is part of the Grand Strand
                  colloquially, but not of Horry.
    Season        MONTH 6-8 is summer. FARS gives crash month directly.
    Pedestrian-   accident.PEDS > 0. FARS counts persons not in a motor vehicle,
    involved      which includes pedestrians and, in this field, some other
                  non-occupants. Reported as "pedestrian or other non-occupant"
                  rather than "pedestrian" for that reason.

KNOWN LIMITS, stated because the report states them
    * Counts are crashes and deaths, not rates. Horry's resident population is
      not its road population: the Grand Strand's summer visitor load is the
      thing everyone means by "dangerous", and FARS carries no exposure
      denominator. Per-capita figures against resident population would
      systematically overstate the risk to a resident and are not computed.
    * 2024 is the most recent annual file and may be revised.
    * TWAY_ID is entered by the reporting officer; spelling variants are
      normalised here, but an unrecorded route is invisible either way.
    * County is where the crash occurred, not where anyone lived. Tourist and
      resident crashes are not separable in this data.
"""

import argparse, csv, json, os, re, sys
from collections import Counter, defaultdict

SC, HORRY, GEORGETOWN = "45", "51", "43"   # FARS county codes = state FIPS county codes
YEARS = ["2020", "2021", "2022", "2023", "2024"]


def read_accidents(fars_dir, year):
    """
    Yield accident rows for one FARS year.

    ENCODING IS NOT UNIFORM ACROSS YEARS AND THE FAILURE IS SILENT. The 2020
    national file is plain ASCII; 2021 onward are UTF-8 *with a BOM*. Read with
    latin-1 the BOM survives as three characters glued to the first header, so
    DictReader yields the key "\ufeffSTATE" (rendered "ï»¿STATE"), row["STATE"]
    is None, every state filter fails, and the year contributes ZERO rows without
    raising anything. Caught here only because a smoke run on three years
    reported 56 crashes instead of ~170.

    utf-8-sig strips the BOM when present and is a no-op when it is not.
    Column ORDER also changes between years, so nothing may depend on position.
    """
    for name in ("accident.csv", "ACCIDENT.CSV", "Accident.csv"):
        path = os.path.join(fars_dir, year, name)
        if os.path.exists(path):
            with open(path, newline="", encoding="utf-8-sig", errors="replace") as fh:
                reader = csv.DictReader(fh)
                if reader.fieldnames:
                    reader.fieldnames = [f.lstrip("\ufeff").strip() for f in reader.fieldnames]
                for row in reader:
                    yield row
            return
    print(f"  WARNING: no accident.csv for {year}", file=sys.stderr)


def norm_road(tway):
    """Normalise a TWAY_ID into a comparable route label."""
    t = (tway or "").strip().upper()
    t = re.sub(r"\s+", " ", t)
    # Strip directional and ramp suffixes so "US-17 NB" and "US-17" agree.
    t = re.sub(r"\b(NB|SB|EB|WB|NORTHBOUND|SOUTHBOUND|EASTBOUND|WESTBOUND)\b", "", t)
    t = re.sub(r"\b(RAMP|EXIT|CONNECTOR)\b.*$", "", t)
    t = re.sub(r"[^A-Z0-9 \-]", "", t).strip()
    return t or "(unrecorded)"


def analyse(fars_dir):
    horry, gtown, sc_all = [], [], []
    for year in YEARS:
        for row in read_accidents(fars_dir, year):
            if row.get("STATE") != SC:
                continue
            row["_year"] = year
            sc_all.append(row)
            if row.get("COUNTY") == HORRY:
                horry.append(row)
            elif row.get("COUNTY") == GEORGETOWN:
                gtown.append(row)

    # A year contributing zero South Carolina crashes is impossible in FARS and
    # means a parse failure, not a safe year. Refuse to produce a report from it:
    # the whole class of bug here is one that returns plausible-looking numbers.
    per_year = Counter(r["_year"] for r in sc_all)
    missing = [y for y in YEARS if per_year.get(y, 0) == 0]
    if missing:
        raise SystemExit(
            "ABORT: no South Carolina crashes parsed for %s. FARS records "
            "hundreds per state per year, so this is a read failure (encoding, "
            "missing file, or renamed column), not a real zero. Fix before "
            "publishing any figure derived from this run." % ", ".join(missing)
        )

    # Same guard, one level down. Both counties record fatal crashes every year;
    # a zero means the county CODE is wrong, not that nobody died. This is not
    # hypothetical — GEORGETOWN was coded 22 here and silently returned nothing.
    for label, rows_ in (("Horry", horry), ("Georgetown", gtown)):
        if not rows_:
            raise SystemExit(
                "ABORT: zero crashes for %s across %s. Check the county code "
                "against COUNTYNAME in the raw file; FARS uses state FIPS county "
                "codes, not a sequential index." % (label, "-".join(YEARS))
            )

    def deaths(rows):
        return sum(int(r.get("FATALS") or 0) for r in rows)

    def summer(rows):
        return [r for r in rows if (r.get("MONTH") or "").strip() in ("6", "7", "8")]

    def peds(rows):
        return [r for r in rows if int(r.get("PEDS") or 0) > 0]

    stats = {
        "source": "NHTSA FARS national annual files 2020-2024",
        "scope": "Fatal crashes only, Horry County SC (Myrtle Beach / Grand Strand)",
        "years": YEARS,
        "horry": {"crashes": len(horry), "deaths": deaths(horry)},
        "georgetown": {"crashes": len(gtown), "deaths": deaths(gtown)},
        "south_carolina": {"crashes": len(sc_all), "deaths": deaths(sc_all)},
    }

    stats["horry"]["share_of_sc_crashes_pct"] = round(100 * len(horry) / len(sc_all), 1) if sc_all else 0

    # By year
    stats["by_year"] = {}
    for y in YEARS:
        hy = [r for r in horry if r["_year"] == y]
        sy = [r for r in sc_all if r["_year"] == y]
        stats["by_year"][y] = {
            "horry_crashes": len(hy), "horry_deaths": deaths(hy),
            "sc_crashes": len(sy), "sc_deaths": deaths(sy),
        }

    # Seasonality — the claim the existing page makes without data.
    h_sum, s_sum = summer(horry), summer(sc_all)
    stats["seasonality"] = {
        "horry_summer_crashes": len(h_sum),
        "horry_summer_pct": round(100 * len(h_sum) / len(horry), 1) if horry else 0,
        "sc_summer_pct": round(100 * len(s_sum) / len(sc_all), 1) if sc_all else 0,
        "expected_pct_if_flat": round(100 * 3 / 12, 1),
        "horry_by_month": {str(m): sum(1 for r in horry if (r.get("MONTH") or "").strip() == str(m)) for m in range(1, 13)},
        "sc_by_month": {str(m): sum(1 for r in sc_all if (r.get("MONTH") or "").strip() == str(m)) for m in range(1, 13)},
    }

    # Pedestrian / non-occupant involvement
    h_ped, s_ped = peds(horry), peds(sc_all)
    stats["pedestrian"] = {
        "horry_crashes": len(h_ped),
        "horry_pct": round(100 * len(h_ped) / len(horry), 1) if horry else 0,
        "sc_pct": round(100 * len(s_ped) / len(sc_all), 1) if sc_all else 0,
    }

    # Where: roads, and urban/rural split
    road_counts = Counter(norm_road(r.get("TWAY_ID")) for r in horry)
    stats["roads"] = [{"road": k, "crashes": v} for k, v in road_counts.most_common(12)]
    stats["land_use"] = dict(Counter((r.get("RUR_URBNAME") or "?").strip() for r in horry))
    stats["intersection"] = dict(Counter((r.get("TYP_INTNAME") or "?").strip() for r in horry).most_common(6))
    stats["hour"] = {str(h): sum(1 for r in horry if (r.get("HOUR") or "").strip() == str(h)) for h in range(24)}

    # Every SC county, so "is Horry unusual" is answerable rather than asserted.
    cc = Counter((r.get("COUNTYNAME") or "?").strip() for r in sc_all)
    stats["sc_counties_top"] = [{"county": k, "crashes": v} for k, v in cc.most_common(10)]

    return stats, horry


def write_csv(rows, path):
    cols = ["year", "county", "city", "month", "hour", "fatals", "peds",
            "roadway", "land_use", "intersection_type", "latitude", "longitude"]
    with open(path, "w", newline="") as fh:
        w = csv.writer(fh)
        w.writerow(cols)
        for r in rows:
            w.writerow([
                r["_year"], (r.get("COUNTYNAME") or "").strip(), (r.get("CITYNAME") or "").strip(),
                r.get("MONTH"), r.get("HOUR"), r.get("FATALS"), r.get("PEDS"),
                norm_road(r.get("TWAY_ID")), (r.get("RUR_URBNAME") or "").strip(),
                (r.get("TYP_INTNAME") or "").strip(), r.get("LATITUDE"), r.get("LONGITUD"),
            ])


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--fars-dir", required=True)
    ap.add_argument("--out", default="research/")
    a = ap.parse_args()
    stats, horry = analyse(a.fars_dir)
    os.makedirs(a.out, exist_ok=True)
    with open(os.path.join(a.out, "myrtle-beach-report-stats.json"), "w") as fh:
        json.dump(stats, fh, indent=1)
    write_csv(horry, os.path.join(a.out, "horry-county-fatal-crashes-2020-2024.csv"))
    print(json.dumps(stats, indent=1)[:4000])


if __name__ == "__main__":
    main()
