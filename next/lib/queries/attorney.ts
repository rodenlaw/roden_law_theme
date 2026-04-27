import { client } from "@/sanity/lib/client";

const ATTORNEY_FIELDS = `
  _id,
  name,
  "slug": slug.current,
  jobTitle,
  officeKey,
  barAdmissions,
  education,
  awards,
  sameAs,
  headshot,
  body,
  seoMetaDescription
`;

export async function getAttorneyBySlug(slug: string) {
  return client.fetch(
    `*[_type == "attorney" && slug.current == $slug && language == "en"][0]{${ATTORNEY_FIELDS}}`,
    { slug },
  );
}

export async function getAllAttorneys() {
  return client.fetch(
    `*[_type == "attorney" && language == "en"] | order(name asc) {${ATTORNEY_FIELDS}}`,
  );
}

export async function getAllAttorneySlugs() {
  return client.fetch<string[]>(
    `*[_type == "attorney" && language == "en"].slug.current`,
  );
}
