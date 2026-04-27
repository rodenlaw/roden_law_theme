import { client } from "@/sanity/lib/client";

const PRACTICE_AREA_FIELDS = `
  _id,
  title,
  "slug": slug.current,
  pageType,
  officeKey,
  jurisdiction,
  solGa,
  solSc,
  heroIntro,
  whyHire,
  expertQuote,
  commonCauses,
  commonInjuries,
  faqs,
  body,
  seoMetaDescription,
  "authorAttorney": authorAttorney->{
    name,
    "slug": slug.current,
    jobTitle,
    barAdmissions,
    headshot,
    body
  },
  "parent": parent->{
    _id,
    title,
    "slug": slug.current,
    whyHire,
    expertQuote,
    "authorAttorney": authorAttorney->{
      name,
      "slug": slug.current,
      jobTitle,
      barAdmissions,
      headshot,
      body
    }
  }
`;

export async function getPillarBySlug(slug: string) {
  return client.fetch(
    `*[_type == "practiceArea" && slug.current == $slug && pageType == "pillar" && language == "en"][0]{
      ${PRACTICE_AREA_FIELDS},
      "childSubtypes": *[_type == "practiceArea" && parent._ref == ^._id && pageType == "subtype" && language == "en"] | order(title asc) {
        title, "slug": slug.current
      },
      "childIntersections": *[_type == "practiceArea" && parent._ref == ^._id && pageType == "intersection" && language == "en"] | order(title asc) {
        title, "slug": slug.current, officeKey
      }
    }`,
    { slug },
  );
}

export async function getChildBySlug(pillarSlug: string, childSlug: string) {
  return client.fetch(
    `*[_type == "practiceArea" && slug.current == $childSlug && parent->slug.current == $pillarSlug && language == "en"][0]{
      ${PRACTICE_AREA_FIELDS},
      "siblings": *[_type == "practiceArea" && parent._ref == ^.parent._ref && _id != ^._id && pageType == "subtype" && language == "en"] | order(title asc) {
        title, "slug": slug.current
      },
      "siblingIntersections": *[_type == "practiceArea" && parent._ref == ^.parent._ref && _id != ^._id && pageType == "intersection" && language == "en"] | order(title asc) {
        title, "slug": slug.current, officeKey
      }
    }`,
    { pillarSlug, childSlug },
  );
}

export async function getAllPillarSlugs() {
  return client.fetch<string[]>(
    `*[_type == "practiceArea" && pageType == "pillar" && language == "en"].slug.current`,
  );
}

export async function getAllChildParams() {
  return client.fetch<{ pillarSlug: string; childSlug: string }[]>(
    `*[_type == "practiceArea" && pageType in ["intersection", "subtype"] && language == "en"]{
      "childSlug": slug.current,
      "pillarSlug": parent->slug.current
    }`,
  );
}
