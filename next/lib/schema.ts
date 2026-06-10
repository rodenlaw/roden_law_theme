/**
 * JSON-LD schema builders — parity with the WordPress theme's
 * inc/schema-helpers.php (which emitted 11 types natively).
 *
 * Pure functions: each returns a plain object ready to pass to <JsonLd data={…} />.
 * Firm/office/website data comes from firm-data.ts; content-specific builders
 * (LegalService, Person, FAQPage, BlogPosting, Article) take already-fetched
 * Sanity data plus pre-resolved absolute image URLs (so this module stays free
 * of Sanity/image deps and is unit-testable).
 *
 * Types emitted across the site:
 *   Organization (LegalService) · LocalBusiness ×6 · WebSite · AggregateRating
 *   · BreadcrumbList · FAQPage · Person · LegalService · BlogPosting · Article
 *
 * NOTE: `logo` is intentionally omitted until a real logo asset exists in
 * public/ — pointing schema at a 404 is worse than omitting it. Add LOGO_URL
 * and wire it into organizationSchema() before cutover.
 */

import { getFirmData, type Office } from "@/lib/firm-data";

type Json = Record<string, unknown>;

const firm = getFirmData();
const SITE = firm.url.replace(/\/$/, "");

export const ORG_ID = `${SITE}/#organization`;
export const WEBSITE_ID = `${SITE}/#website`;

/** Reference to the firm Organization node (use as provider/publisher/worksFor). */
export function orgRef(): Json {
  return { "@id": ORG_ID };
}

/** Absolute canonical URL with NO trailing slash (matches trailingSlash:false).
 *  Handles "/x/", "/x/#frag", and "/". */
function abs(path: string): string {
  return `${SITE}${path}`.replace(/\/(?=#|$)/, "");
}

/** Defensible firm-wide aggregate rating: summed from per-office Google review
 *  counts in firm-data (NOT the unsourced "500+" headline figure). */
function aggregateRating(): Json {
  const officeList = Object.values(firm.offices);
  const ratingCount = officeList.reduce((sum, o) => sum + (o.reviewCount || 0), 0);
  return {
    "@type": "AggregateRating",
    ratingValue: firm.trustStats.rating,
    reviewCount: ratingCount,
    bestRating: "5",
    worstRating: "1",
  };
}

function areaServed(): Json[] {
  return firm.licensedIn.map((state) => ({ "@type": "State", name: state }));
}

function postalAddress(office: Office): Json {
  return {
    "@type": "PostalAddress",
    streetAddress: office.street,
    addressLocality: office.city,
    addressRegion: office.state,
    postalCode: office.zip,
    addressCountry: "US",
  };
}

/** Organization / LegalService — the firm entity. Homepage + as provider ref. */
export function organizationSchema(): Json {
  return {
    "@context": "https://schema.org",
    "@type": ["Organization", "LegalService"],
    "@id": ORG_ID,
    name: firm.name,
    legalName: firm.legalEntity,
    url: `${SITE}/`,
    telephone: firm.phoneE164,
    description: firm.description,
    foundingDate: firm.founded,
    areaServed: areaServed(),
    sameAs: Object.values(firm.social),
    aggregateRating: aggregateRating(),
    contactPoint: {
      "@type": "ContactPoint",
      telephone: firm.phoneE164,
      contactType: "customer service",
      areaServed: firm.licensedIn,
      availableLanguage: ["English", "Spanish"],
    },
  };
}

function officeNode(officeKey: string, office: Office, path?: string): Json {
  const node: Json = {
    "@context": "https://schema.org",
    "@type": ["LegalService", "Attorney"],
    "@id": `${SITE}/#office-${officeKey}`,
    name: office.name,
    parentOrganization: orgRef(),
    telephone: office.phoneE164,
    address: postalAddress(office),
    geo: { "@type": "GeoCoordinates", latitude: office.latitude, longitude: office.longitude },
    areaServed: office.serviceArea,
    priceRange: "Free Consultation — Contingency Fee",
    aggregateRating: {
      "@type": "AggregateRating",
      ratingValue: office.reviewRating,
      reviewCount: office.reviewCount,
      bestRating: "5",
      worstRating: "1",
    },
  };
  // Only attach url when the caller knows the real office-page path (the
  // location slug lives in Sanity, not firm-data, so we never guess it).
  if (path) node.url = abs(path);
  return node;
}

/** One LocalBusiness (Attorney) node per physical office, keyed by stable @id.
 *  No url — the homepage can't know each office's Sanity location slug. */
export function officeLocalBusinessSchemas(): Json[] {
  return Object.entries(firm.offices).map(([key, office]) => officeNode(key, office));
}

/** Full LocalBusiness for a single office page, including the real url/path. */
export function officeLocalBusinessSchema(officeKey: string, path: string): Json | null {
  const office = firm.offices[officeKey as keyof typeof firm.offices];
  if (!office) return null;
  return officeNode(officeKey, office, path);
}

/** WebSite node. No SearchAction — the site has no search route to point at. */
export function webSiteSchema(): Json {
  return {
    "@context": "https://schema.org",
    "@type": "WebSite",
    "@id": WEBSITE_ID,
    url: `${SITE}/`,
    name: firm.name,
    publisher: orgRef(),
    inLanguage: "en-US",
  };
}

/** Convenience bundle for the homepage. */
export function homepageSchema(): Json[] {
  return [organizationSchema(), ...officeLocalBusinessSchemas(), webSiteSchema()];
}

export interface Crumb {
  name: string;
  /** Absolute or site-relative path; relative is resolved against SITE. */
  url: string;
}

export function breadcrumbSchema(crumbs: Crumb[]): Json {
  return {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    itemListElement: crumbs.map((c, i) => ({
      "@type": "ListItem",
      position: i + 1,
      name: c.name,
      item: c.url.startsWith("http") ? c.url : abs(c.url.startsWith("/") ? c.url : `/${c.url}`),
    })),
  };
}

export interface FaqItem {
  question?: string;
  answer?: string;
}

/** Returns null when there are no usable FAQs (so callers can skip emitting). */
export function faqPageSchema(faqs?: FaqItem[] | null): Json | null {
  const items = (faqs || []).filter((f) => f?.question && f?.answer);
  if (!items.length) return null;
  return {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    mainEntity: items.map((f) => ({
      "@type": "Question",
      name: f.question,
      acceptedAnswer: { "@type": "Answer", text: f.answer },
    })),
  };
}

export interface AttorneyLike {
  name: string;
  slug: string;
  jobTitle?: string;
  barAdmissions?: string[];
  education?: { degree?: string; institution?: string }[];
  awards?: { name?: string; year?: string }[];
  sameAs?: string[];
}

export function personSchema(attorney: AttorneyLike, headshotUrl?: string): Json {
  const schema: Json = {
    "@context": "https://schema.org",
    "@type": ["Person", "Attorney"],
    "@id": abs(`/attorneys/${attorney.slug}/#person`),
    name: attorney.name,
    url: abs(`/attorneys/${attorney.slug}/`),
    jobTitle: attorney.jobTitle,
    worksFor: orgRef(),
  };
  if (headshotUrl) schema.image = headshotUrl;
  if (attorney.sameAs?.length) schema.sameAs = attorney.sameAs;
  if (attorney.barAdmissions?.length) {
    schema.knowsAbout = attorney.barAdmissions.map((b) => `Licensed to practice law in ${b}`);
  }
  if (attorney.education?.length) {
    schema.alumniOf = attorney.education
      .filter((e) => e.institution)
      .map((e) => ({ "@type": "EducationalOrganization", name: e.institution }));
  }
  if (attorney.awards?.length) {
    schema.award = attorney.awards.filter((a) => a.name).map((a) => a.name);
  }
  return schema;
}

export interface PracticeAreaLike {
  title: string;
  slug: string;
  seoMetaDescription?: string;
  heroIntro?: string;
}

/** LegalService for a practice-area page. `path` is the page's URL path. */
export function legalServiceSchema(pa: PracticeAreaLike, path: string): Json {
  return {
    "@context": "https://schema.org",
    "@type": "LegalService",
    name: pa.title,
    url: abs(path),
    description: pa.seoMetaDescription || pa.heroIntro || `${pa.title} — Roden Law.`,
    provider: orgRef(),
    areaServed: areaServed(),
    serviceType: pa.title,
  };
}

export interface ArticleLike {
  title: string;
  slug: string;
  excerpt?: string;
  seoMetaDescription?: string;
  publishedAt?: string;
  _updatedAt?: string;
  authorAttorney?: { name?: string; slug?: string } | null;
}

/** BlogPosting for /blog/[slug]. `imageUrl` is the resolved featured-image URL. */
export function blogPostingSchema(post: ArticleLike, path: string, imageUrl?: string): Json {
  return articleLike("BlogPosting", post, path, imageUrl);
}

/** Article for /resources/[slug] (WP emitted HowTo; Article is the safe,
 *  non-fabricated equivalent until structured steps exist in the data). */
export function articleSchema(post: ArticleLike, path: string, imageUrl?: string): Json {
  return articleLike("Article", post, path, imageUrl);
}

function articleLike(type: string, post: ArticleLike, path: string, imageUrl?: string): Json {
  const author = post.authorAttorney?.name
    ? {
        "@type": "Person",
        name: post.authorAttorney.name,
        ...(post.authorAttorney.slug ? { url: abs(`/attorneys/${post.authorAttorney.slug}/`) } : {}),
      }
    : orgRef();
  const schema: Json = {
    "@context": "https://schema.org",
    "@type": type,
    headline: post.title,
    description: post.seoMetaDescription || post.excerpt || post.title,
    url: abs(path),
    mainEntityOfPage: abs(path),
    author,
    publisher: orgRef(),
  };
  if (post.publishedAt) schema.datePublished = post.publishedAt;
  if (post._updatedAt) schema.dateModified = post._updatedAt;
  if (imageUrl) schema.image = imageUrl;
  return schema;
}
