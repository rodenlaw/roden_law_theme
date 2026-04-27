import type { MetadataRoute } from "next";
import { client } from "@/sanity/lib/client";
import { getFirmData } from "@/lib/firm-data";

const SITE_URL = process.env.NEXT_PUBLIC_SITE_URL || "https://www.rodenlaw.com";

export default async function sitemap(): Promise<MetadataRoute.Sitemap> {
  const firm = getFirmData();
  const now = new Date().toISOString();

  // Static pages
  const staticPages: MetadataRoute.Sitemap = [
    { url: SITE_URL, lastModified: now, changeFrequency: "weekly", priority: 1.0 },
    { url: `${SITE_URL}/practice-areas/`, lastModified: now, changeFrequency: "weekly", priority: 0.9 },
    { url: `${SITE_URL}/locations/`, lastModified: now, changeFrequency: "monthly", priority: 0.8 },
    { url: `${SITE_URL}/attorneys/`, lastModified: now, changeFrequency: "monthly", priority: 0.7 },
    { url: `${SITE_URL}/case-results/`, lastModified: now, changeFrequency: "monthly", priority: 0.7 },
    { url: `${SITE_URL}/testimonials/`, lastModified: now, changeFrequency: "monthly", priority: 0.6 },
    { url: `${SITE_URL}/blog/`, lastModified: now, changeFrequency: "daily", priority: 0.7 },
    { url: `${SITE_URL}/about/`, lastModified: now, changeFrequency: "monthly", priority: 0.6 },
    { url: `${SITE_URL}/contact/`, lastModified: now, changeFrequency: "monthly", priority: 0.7 },
    { url: `${SITE_URL}/class-action-lawyers/`, lastModified: now, changeFrequency: "monthly", priority: 0.6 },
  ];

  // Practice areas (pillar, intersection, subtype)
  const practiceAreas = await client.fetch<{ slug: string; parentSlug: string | null; pageType: string; modified: string }[]>(
    `*[_type == "practiceArea" && language == "en"]{
      "slug": slug.current,
      "parentSlug": parent->slug.current,
      pageType,
      "modified": _updatedAt
    }`,
  );

  const paPages: MetadataRoute.Sitemap = practiceAreas.map((pa) => {
    const url = pa.pageType === "pillar"
      ? `${SITE_URL}/practice-areas/${pa.slug}/`
      : `${SITE_URL}/${pa.parentSlug}/${pa.slug}/`;
    return {
      url,
      lastModified: pa.modified,
      changeFrequency: "weekly" as const,
      priority: pa.pageType === "pillar" ? 0.9 : 0.7,
    };
  });

  // Locations
  const locations = await client.fetch<{ slug: string; officeKey: string; parentOfficeKey: string; isNeighborhood: boolean; parentSlug: string | null; modified: string }[]>(
    `*[_type == "location" && language == "en"]{
      "slug": slug.current,
      officeKey,
      parentOfficeKey,
      isNeighborhood,
      "parentSlug": parentLocation->slug.current,
      "modified": _updatedAt
    }`,
  );

  const locationPages: MetadataRoute.Sitemap = locations.map((loc) => {
    const key = loc.officeKey || loc.parentOfficeKey;
    const office = key ? firm.offices[key as keyof typeof firm.offices] : null;
    const stateSlug = office?.stateSlug || "georgia";
    const url = loc.isNeighborhood
      ? `${SITE_URL}/locations/${stateSlug}/${loc.parentSlug}/${loc.slug}/`
      : `${SITE_URL}/locations/${stateSlug}/${loc.slug}/`;
    return {
      url,
      lastModified: loc.modified,
      changeFrequency: "monthly" as const,
      priority: loc.isNeighborhood ? 0.5 : 0.8,
    };
  });

  // Attorneys
  const attorneys = await client.fetch<{ slug: string; modified: string }[]>(
    `*[_type == "attorney" && language == "en"]{"slug": slug.current, "modified": _updatedAt}`,
  );

  const attorneyPages: MetadataRoute.Sitemap = attorneys.map((a) => ({
    url: `${SITE_URL}/attorneys/${a.slug}/`,
    lastModified: a.modified,
    changeFrequency: "monthly" as const,
    priority: 0.7,
  }));

  // Blog posts
  const posts = await client.fetch<{ slug: string; modified: string }[]>(
    `*[_type == "blogPost" && language == "en"]{"slug": slug.current, "modified": _updatedAt}`,
  );

  const blogPages: MetadataRoute.Sitemap = posts.map((p) => ({
    url: `${SITE_URL}/blog/${p.slug}/`,
    lastModified: p.modified,
    changeFrequency: "weekly" as const,
    priority: 0.6,
  }));

  // Resources
  const resources = await client.fetch<{ slug: string; modified: string }[]>(
    `*[_type == "resource" && language == "en"]{"slug": slug.current, "modified": _updatedAt}`,
  );

  const resourcePages: MetadataRoute.Sitemap = resources.map((r) => ({
    url: `${SITE_URL}/resources/${r.slug}/`,
    lastModified: r.modified,
    changeFrequency: "monthly" as const,
    priority: 0.6,
  }));

  return [...staticPages, ...paPages, ...locationPages, ...attorneyPages, ...blogPages, ...resourcePages];
}
