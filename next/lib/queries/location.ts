import { client } from "@/sanity/lib/client";
import { getFirmData, type OfficeKey } from "@/lib/firm-data";

const LOCATION_FIELDS = `
  _id,
  title,
  "slug": slug.current,
  isNeighborhood,
  officeKey,
  parentOfficeKey,
  population,
  court,
  latitude,
  longitude,
  roads,
  hospitals,
  landmarks,
  serviceArea,
  mapEmbed,
  localContent,
  faqs,
  body,
  seoMetaDescription,
  "parentLocation": parentLocation->{
    _id,
    title,
    "slug": slug.current,
    officeKey
  }
`;

/**
 * Derive state slug from an office key using firm data.
 */
function stateSlugFromOfficeKey(key: string): string {
  const firm = getFirmData();
  const office = key ? firm.offices[key as OfficeKey] : null;
  return office?.stateSlug || "georgia";
}

export async function getLocationBySlug(stateSlug: string, citySlug: string) {
  return client.fetch(
    `*[_type == "location" && slug.current == $citySlug && language == "en"
      && (officeKey != "" || !isNeighborhood)][0]{
      ${LOCATION_FIELDS},
      "neighborhoodChildren": *[_type == "location" && parentLocation._ref == ^._id && isNeighborhood && language == "en"] | order(title asc) {
        title, "slug": slug.current
      }
    }`,
    { citySlug },
  );
}

export async function getNeighborhoodBySlug(neighborhoodSlug: string, parentCitySlug: string) {
  return client.fetch(
    `*[_type == "location" && slug.current == $neighborhoodSlug && isNeighborhood && language == "en"
      && parentLocation->slug.current == $parentCitySlug][0]{
      ${LOCATION_FIELDS},
      "subNeighborhoods": *[_type == "location" && parentLocation._ref == ^._id && language == "en"] | order(title asc) {
        title, "slug": slug.current
      }
    }`,
    { neighborhoodSlug, parentCitySlug },
  );
}

export async function getAllLocationParams() {
  // Only return locations that have an officeKey (actual office pages, not state landing pages)
  const locations = await client.fetch<{ slug: string; officeKey: string }[]>(
    `*[_type == "location" && officeKey != "" && !isNeighborhood && language == "en"]{
      "slug": slug.current,
      officeKey
    }`,
  );

  return locations.map((loc) => ({
    state: stateSlugFromOfficeKey(loc.officeKey),
    city: loc.slug,
  }));
}

export async function getAllNeighborhoodParams() {
  const neighborhoods = await client.fetch<{
    slug: string;
    parentSlug: string;
    parentOfficeKey: string;
    officeKey: string;
  }[]>(
    `*[_type == "location" && isNeighborhood && language == "en"
      && parentLocation->slug.current != null]{
      "slug": slug.current,
      "parentSlug": parentLocation->slug.current,
      parentOfficeKey,
      "officeKey": parentLocation->officeKey
    }`,
  );

  return neighborhoods
    .filter((n) => n.parentSlug) // Must have a valid parent
    .map((n) => {
      const key = n.parentOfficeKey || n.officeKey || "";
      return {
        state: stateSlugFromOfficeKey(key),
        city: n.parentSlug,
        neighborhood: n.slug,
      };
    });
}
