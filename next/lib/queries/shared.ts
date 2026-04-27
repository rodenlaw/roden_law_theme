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

export async function getTestimonials() {
  return client.fetch(
    `*[_type == "testimonial" && language == "en"] | order(_createdAt desc) {
      _id,
      clientName,
      "slug": slug.current,
      reviewBody,
      rating
    }`,
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
