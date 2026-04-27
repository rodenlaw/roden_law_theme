import { client } from "@/sanity/lib/client";

const BLOG_CARD_FIELDS = `
  _id,
  title,
  "slug": slug.current,
  publishedAt,
  excerpt,
  featuredImage,
  "authorAttorney": authorAttorney->{
    name, "slug": slug.current, jobTitle, headshot
  },
  "category": category->{ title, "slug": slug.current }
`;

const BLOG_SINGLE_FIELDS = `
  _id,
  title,
  "slug": slug.current,
  publishedAt,
  excerpt,
  keyTakeaways,
  featuredImage,
  body,
  faqs,
  seoMetaDescription,
  "authorAttorney": authorAttorney->{
    name, "slug": slug.current, jobTitle, barAdmissions, headshot, body
  },
  "category": category->{ title, "slug": slug.current }
`;

export async function getBlogPosts(start = 0, limit = 12) {
  return client.fetch(
    `*[_type == "blogPost" && language == "en"] | order(publishedAt desc)[$start...$end]{
      ${BLOG_CARD_FIELDS}
    }`,
    { start, end: start + limit },
  );
}

export async function getBlogPostCount() {
  return client.fetch<number>(
    `count(*[_type == "blogPost" && language == "en"])`,
  );
}

export async function getBlogPostBySlug(slug: string) {
  return client.fetch(
    `*[_type == "blogPost" && slug.current == $slug && language == "en"][0]{
      ${BLOG_SINGLE_FIELDS}
    }`,
    { slug },
  );
}

export async function getAllBlogSlugs() {
  return client.fetch<string[]>(
    `*[_type == "blogPost" && language == "en"].slug.current`,
  );
}

export async function getRecentPosts(exclude?: string, limit = 5) {
  const filter = exclude
    ? `*[_type == "blogPost" && language == "en" && slug.current != $exclude]`
    : `*[_type == "blogPost" && language == "en"]`;
  return client.fetch(
    `${filter} | order(publishedAt desc)[0...$limit]{
      title, "slug": slug.current, publishedAt
    }`,
    { exclude: exclude ?? "", limit },
  );
}
