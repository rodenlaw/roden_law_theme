/**
 * Legacy URL → new URL resolver. A faithful port of the WordPress theme's
 * inc/legacy-redirects.php `roden_legacy_content_redirects()` sequence:
 *   1. exact static map (auto-generated → legacy-redirect-map.ts)
 *   2. the regex pattern rules, in the same order as the PHP
 *
 * Called from proxy.ts on every request. All redirects are permanent (301).
 * Destinations always carry a trailing slash to match the site convention
 * (trailingSlash: true in next.config), avoiding a second redirect hop.
 *
 * The PHP also had a final DB-checked single-segment catch-all (old
 * /%postname%/ → /blog/%postname%/). That required a per-request post lookup
 * and risked catching real top-level routes; it is intentionally omitted.
 * Known root-level blog slugs are covered explicitly by the static map, and
 * the validation script (scripts/validate-redirects.mjs) flags any CSV URL
 * still uncovered so they can be added to the map.
 */
import { STATIC_REDIRECTS } from "./legacy-redirect-map";
import { getPracticeAreaSlugs, getOfficeSlugs } from "./firm-data";

// Real single-segment routes that exist in app/(site) — never redirect these.
const RESERVED_TOP = new Set([
  "about", "contact", "testimonials", "case-results", "attorneys", "blog",
  "locations", "practice-areas", "class-action-lawyers", "resources",
  "georgia-car-accident-lawyer", "south-carolina-car-accident-lawyer",
  "south-carolina-rear-end-accident-lawyer", "truck-accident-lawyers-columbia-sc",
  "truck-accident-lawyers-near-me", "high-tide", "privacy-policy",
  "llms", "llms-full",
]);

const PILLAR_SLUGS = new Set(getPracticeAreaSlugs());
const OFFICE_SLUGS = new Set(getOfficeSlugs());

// Real /class-action-lawyers/[slug] sub-pages (Sanity classAction docs). These
// must resolve, NOT redirect to the hub. Any OTHER sub-path is a dead legacy
// URL and still 301s to the hub below.
const CLASS_ACTION_SLUGS = new Set([
  "afff-firefighting-foam-lawsuits", "camp-lejeune-lawsuits", "hair-relaxer-cancer-lawsuits",
  "invokana", "ivc-filter", "onglyza", "ozempic-lawsuits", "paraquat-lawsuit", "roundup",
  "stryker-hip-replacement", "talcum-powder", "troubled-teen-industry-abuse", "truvada", "uloric",
]);

// Old single-segment city landing pages → /locations/.
const CITY_LANDINGS = new Set([
  "savannah", "charleston", "brunswick", "columbia", "myrtle-beach",
  "darien", "north-charleston", "murrells-inlet",
]);

// Cities/labels that appeared as a 2-segment /practice-areas/[x]/ index.
const PA_INDEX_CITIES = new Set([
  "savannah", "charleston", "brunswick", "albany", "macon", "general",
]);

// Supplemental exact redirects for old URLs not in the generated WP map, plus
// overrides for WP service pages that were never migrated to a Next route
// (their old map destinations would 404 — point them at /contact/ instead).
const EXTRA_STATIC: Record<string, string> = {
  "/free-case-review/": "/contact/",
  "/free-consultation/": "/contact/",
  "/savannah-ppi-attorney/": "/contact/",
  "/free-consultation-with-charleston-personal-injury-lawyer/": "/contact/",
};

// Old practice-area slug → canonical pillar slug (from PHP $pa_slug_map).
const PA_SLUG_MAP: Record<string, string> = {
  "medical-malpractice-attorneys": "medical-malpractice-lawyers",
  "medical-malpractice-attorney": "medical-malpractice-lawyers",
  "maritime-lawyers": "maritime-injury-lawyers",
  "nursing-home-abuse-attorneys": "nursing-home-abuse-lawyers",
  "nursing-home-abuse-attorney": "nursing-home-abuse-lawyers",
  "nursing-home-abuse-lawyer": "nursing-home-abuse-lawyers",
  "slip-and-fall-attorneys": "slip-and-fall-lawyers",
  "slip-and-fall-attorney": "slip-and-fall-lawyers",
  "slip-and-fall-lawyer": "slip-and-fall-lawyers",
  "workers-compensation-attorney": "workers-compensation-lawyers",
  "workers-compensation-lawyer": "workers-compensation-lawyers",
  "personal-injury-lawyer": "personal-injury-lawyers",
  "car-accident-lawyer": "car-accident-lawyers",
  "truck-accident-lawyer": "truck-accident-lawyers",
  "burn-injury-lawyer": "burn-injury-lawyers",
  "brain-injury-lawyer": "brain-injury-lawyers",
  "wrongful-death-lawyer": "wrongful-death-lawyers",
  "boating-accident-lawyer": "boating-accident-lawyers",
  "spinal-cord-injury-lawyer": "spinal-cord-injury-lawyers",
  "motorcycle-accident-lawyer": "motorcycle-accident-lawyers",
  "construction-accident-lawyer": "construction-accident-lawyers",
  "dog-bite-lawyer": "dog-bite-lawyers",
  "product-liability-lawyer": "product-liability-lawyers",
  "coronavirus-business-claims": "car-accident-lawyers",
};

// Old city segment → new office intersection slug (from PHP $city_dest).
const CITY_DEST: Record<string, string> = {
  savannah: "savannah-ga",
  charleston: "charleston-sc",
  brunswick: "darien-ga",
};

const normPa = (slug: string) => PA_SLUG_MAP[slug] ?? slug;
const withSlash = (p: string) => (p.endsWith("/") ? p : `${p}/`);

/**
 * @returns the final destination path (with trailing slash) to 301 to, or null
 *          if the path is not a legacy URL and should be served normally.
 *          Resolution is transitive: if a destination is itself a legacy URL
 *          (e.g. a WP map entry pointing at an old root-level blog slug), it is
 *          followed until stable so the browser only sees one 301 hop.
 */
export function resolveLegacyRedirect(pathname: string): string | null {
  let dest = resolveOnce(pathname);
  if (!dest) return null;
  const seen = new Set<string>([normalize(pathname)]);
  for (let i = 0; i < 6; i++) {
    const key = normalize(dest);
    if (seen.has(key)) break; // cycle guard
    seen.add(key);
    const next = resolveOnce(dest);
    if (!next || normalize(next) === key) break;
    dest = next;
  }
  // Canonical destinations carry NO trailing slash (matches live WP +
  // trailingSlash:false), so the 301 lands directly without a second hop.
  return normalize(dest);
}

function normalize(p: string): string {
  const x = p.startsWith("/") ? p : `/${p}`;
  return x === "/" ? "/" : x.replace(/\/+$/, "");
}

function resolveOnce(pathname: string): string | null {
  // Normalise: ensure a single leading slash, no trailing slash for matching.
  let p = pathname;
  if (!p.startsWith("/")) p = `/${p}`;
  const clean = p === "/" ? "/" : p.replace(/\/+$/, "");

  // 1) Exact static maps — try the slash-variants both ways.
  const exact =
    STATIC_REDIRECTS[clean] ?? STATIC_REDIRECTS[`${clean}/`] ?? STATIC_REDIRECTS[p] ??
    EXTRA_STATIC[clean] ?? EXTRA_STATIC[`${clean}/`];
  if (exact) return withSlash(exact);

  let m: RegExpMatchArray | null;

  // 2) /es/* → /
  if (/^\/es(\/.*)?$/.test(clean)) return "/";

  // /case-result/[slug] → /case-results/  (no per-result detail route in Next)
  if (/^\/case-result\/[^/]+$/.test(clean)) return "/case-results/";

  // /testimonial(s)/[slug] → /testimonials/  (no per-testimonial detail route)
  if (/^\/testimonials?\/[^/]+$/.test(clean)) return "/testimonials/";

  // /staff/[name] → /attorneys/
  if (/^\/staff\/[^/]+$/.test(clean)) return "/attorneys/";

  // /class-action/[slug] → /class-action-lawyers/[slug]/
  if ((m = clean.match(/^\/class-action\/([^/]+)$/))) return `/class-action-lawyers/${m[1]}/`;

  // /class-action-lawyers/[old-slug] → hub, but let the real sub-pages resolve.
  if ((m = clean.match(/^\/class-action-lawyers\/([^/]+)\/?$/)) && !CLASS_ACTION_SLUGS.has(m[1])) {
    return "/class-action-lawyers/";
  }

  // /category/[x] and /blog/(page|category)/… → /blog/  (old archives/pagination)
  if (/^\/category\/[^/]+/.test(clean)) return "/blog/";
  if (/^\/blog\/(page|category)\//.test(clean)) return "/blog/";

  // /practice-ares/… (misspelled legacy prefix) → /practice-areas/
  if (/^\/practice-ares\//.test(clean)) return "/practice-areas/";

  // /practice-areas/[pillar]/[subtype] (old nested subtype) → /[pillar]/[subtype]/
  if ((m = clean.match(/^\/practice-areas\/([^/]+)\/([^/]+)$/)) && PILLAR_SLUGS.has(m[1])) {
    return `/${m[1]}/${m[2]}/`;
  }

  // /[city]/[pa]/[subtype] → /[normPa]/[cityDest]/   (savannah|charleston|brunswick)
  if ((m = clean.match(/^\/(savannah|charleston|brunswick)\/([^/]+)\/([^/]+)$/))) {
    return `/${normPa(m[2])}/${CITY_DEST[m[1]]}/`;
  }
  // /[city]/[pa] → /[normPa]/[cityDest]/
  if ((m = clean.match(/^\/(savannah|charleston|brunswick)\/([^/]+)$/))) {
    return `/${normPa(m[2])}/${CITY_DEST[m[1]]}/`;
  }

  // /[albany|macon]/[pa] → /practice-areas/[normPa]/  (non-office cities)
  if ((m = clean.match(/^\/(albany|macon)\/([^/]+)$/))) {
    return `/practice-areas/${normPa(m[2])}/`;
  }
  // /[macon|albany]/practice-areas → /practice-areas/
  if (/^\/(macon|albany)\/practice-areas$/.test(clean)) return "/practice-areas/";

  // /practice-areas/[city]/[pa]/[subtype] → /[normPa]/[cityDest]/
  if ((m = clean.match(/^\/practice-areas\/(savannah|charleston|brunswick)\/([^/]+)\/([^/]+)$/))) {
    return `/${normPa(m[2])}/${CITY_DEST[m[1]]}/`;
  }
  // /practice-areas/[city]/[pa] → /[normPa]/[cityDest]/
  if ((m = clean.match(/^\/practice-areas\/(savannah|charleston|brunswick)\/([^/]+)$/))) {
    return `/${normPa(m[2])}/${CITY_DEST[m[1]]}/`;
  }
  // /practice-areas/[albany|macon]/[pa] → /practice-areas/[normPa]/
  if ((m = clean.match(/^\/practice-areas\/(albany|macon)\/([^/]+)$/))) {
    return `/practice-areas/${normPa(m[2])}/`;
  }

  // /practice-area/[slug] → /practice-areas/[normPa or slug+s]/  (old singular CPT)
  if ((m = clean.match(/^\/practice-area\/([^/]+)$/))) {
    let slug = normPa(m[1]);
    if (!slug.endsWith("s")) slug += "s";
    return `/practice-areas/${slug}/`;
  }

  // /practice-area-location/* → /practice-areas/
  if (/^\/practice-area-location\/[^/]+/.test(clean)) return "/practice-areas/";

  // /tag/[slug] → /blog/
  if (/^\/tag\/[^/]+$/.test(clean)) return "/blog/";

  // /who-we-are/attorney/[name] → /attorneys/[name]/
  if ((m = clean.match(/^\/who-we-are\/attorney\/([^/]+)$/))) return `/attorneys/${m[1]}/`;

  // /attorney/[slug] → /attorneys/
  if (/^\/attorney\/[^/]+$/.test(clean)) return "/attorneys/";

  // /blog/blog-[slug] → /blog/[slug]/
  if ((m = clean.match(/^\/blog\/blog-(.+)$/))) return `/blog/${m[1]}/`;

  // /blog-[slug] → /blog/[slug]/
  if ((m = clean.match(/^\/blog-(.+)$/))) return `/blog/${m[1]}/`;

  // /who-we-are/attorneys/[name] → /attorneys/[name]/  (plural variant)
  if ((m = clean.match(/^\/who-we-are\/attorneys\/([^/]+)$/))) return `/attorneys/${m[1]}/`;

  // /practice-areas/[city|general]/ (2-seg index) → /practice-areas/
  if ((m = clean.match(/^\/practice-areas\/([^/]+)$/)) && PA_INDEX_CITIES.has(m[1])) {
    return "/practice-areas/";
  }

  // /class-action-category/[x] → /class-action-lawyers/
  if (/^\/class-action-category\/[^/]+/.test(clean)) return "/class-action-lawyers/";

  // Over-deep neighborhood URLs (old nested structure, ≥4 segments under
  // /locations/) → the city office page.
  if ((m = clean.match(/^\/locations\/([^/]+)\/([^/]+)\/[^/]+\/.+$/))) {
    return `/locations/${m[1]}/${m[2]}/`;
  }

  // Single-segment catch-all (old /%postname%/ permalink era). Classify:
  //   reserved real page → no redirect; pillar slug → /practice-areas/[slug]/;
  //   known city → /locations/; otherwise treat as an old root-level blog post.
  if ((m = clean.match(/^\/([^/]+)$/))) {
    const seg = m[1];
    if (RESERVED_TOP.has(seg)) return null;
    if (PILLAR_SLUGS.has(seg)) return `/practice-areas/${seg}/`;
    if (CITY_LANDINGS.has(seg)) return "/locations/";
    if (!seg.startsWith("wp-")) return `/blog/${seg}/`;
  }

  return null;
}
