import { client } from "@/sanity/lib/client";

export async function getCaseResults(count = 8) {
  return client.fetch(
    `*[_type == "caseResult" && language == "en"] | order(amount desc)[0...$count]{
      _id,
      title,
      "slug": slug.current,
      amount,
      resultType,
      description,
      "leadAttorney": leadAttorney->{ name, "slug": slug.current, jobTitle, headshot }
    }`,
    { count },
  );
}

export async function getCaseResultBySlug(slug: string) {
  return client.fetch(
    `*[_type == "caseResult" && slug.current == $slug && language == "en"][0]{
      _id,
      title,
      "slug": slug.current,
      amount,
      resultType,
      accidentType,
      injuryType,
      initialOffer,
      description,
      body,
      "leadAttorney": leadAttorney->{ name, "slug": slug.current, jobTitle, headshot }
    }`,
    { slug },
  );
}

export async function getAllCaseResultSlugs() {
  return client.fetch<string[]>(
    `*[_type == "caseResult" && language == "en" && defined(slug.current)].slug.current`,
  );
}

export async function getTestimonials() {
  return client.fetch(
    `*[_type == "testimonial" && language == "en"] | order(featured desc, coalesce(dateOf, _createdAt) desc) {
      _id,
      clientName,
      "slug": slug.current,
      reviewBody,
      excerpt,
      rating,
      city,
      caseType,
      source,
      sourceUrl,
      dateOf
    }`,
  );
}

export interface FeaturedTestimonial {
  _id: string;
  clientName: string;
  slug: string;
  excerpt: string | null;
  rating: number;
  city: string | null;
  caseType: string | null;
  source: string;
  sourceUrl: string | null;
  dateOf: string | null;
}

export async function getFeaturedTestimonials(count = 6): Promise<FeaturedTestimonial[]> {
  return client.fetch(
    `*[_type == "testimonial" && language == "en" && featured == true && defined(excerpt)] | order(dateOf desc)[0...$count]{
      _id,
      clientName,
      "slug": slug.current,
      excerpt,
      rating,
      city,
      caseType,
      source,
      sourceUrl,
      dateOf
    }`,
    { count },
  );
}

export async function getResourceBySlug(slug: string) {
  return client.fetch(
    `*[_type == "resource" && slug.current == $slug && language == "en"][0]{
      _id,
      title,
      "slug": slug.current,
      jurisdiction,
      keyTakeaways,
      keyTakeawaysRich,
      body,
      faqs,
      seoMetaDescription,
      "authorAttorney": authorAttorney->{
        name, "slug": slug.current, jobTitle, barAdmissions, headshot
      }
    }`,
    { slug },
  );
}

export async function getAllResourceSlugs() {
  return client.fetch<string[]>(
    `*[_type == "resource" && language == "en"].slug.current`,
  );
}

// ── Class actions / mass torts ──────────────────────────────────────────────
export interface ClassActionListItem {
  _id: string;
  slug: string;
  title: string;
  shortLabel: string | null;
  summary: string | null;
  jurisdiction: string | null;
}

export async function getAllClassActions(): Promise<ClassActionListItem[]> {
  return client.fetch(
    `*[_type == "classAction" && language == "en"] | order(coalesce(displayOrder, 100) asc, title asc){
      _id,
      "slug": slug.current,
      title,
      shortLabel,
      summary,
      jurisdiction
    }`,
  );
}

export async function getClassActionBySlug(slug: string) {
  return client.fetch(
    `*[_type == "classAction" && slug.current == $slug && language == "en"][0]{
      _id,
      title,
      shortLabel,
      "slug": slug.current,
      jurisdiction,
      summary,
      keyTakeaways,
      body,
      faqs,
      seoMetaDescription
    }`,
    { slug },
  );
}

export async function getAllClassActionSlugs() {
  return client.fetch<string[]>(
    `*[_type == "classAction" && language == "en"].slug.current`,
  );
}

export interface ResourceListItem {
  _id: string;
  slug: string;
  title: string;
  summary: string | null;
  jurisdiction: string | null;
  author: { name: string; jobTitle: string | null } | null;
}

export async function getAllResources(): Promise<ResourceListItem[]> {
  return client.fetch(
    `*[_type == "resource" && language == "en"] | order(title asc){
      _id,
      "slug": slug.current,
      title,
      "summary": coalesce(seoMetaDescription, keyTakeaways),
      jurisdiction,
      "author": authorAttorney->{ name, jobTitle }
    }`,
  );
}
