import { client } from "@/sanity/lib/client";

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

export async function getLocationBySlug(stateSlug: string, citySlug: string) {
  // Try to find by matching slug and parent state slug
  return client.fetch(
    `*[_type == "location" && slug.current == $citySlug && !isNeighborhood && language == "en"][0]{
      ${LOCATION_FIELDS},
      "neighborhoodChildren": *[_type == "location" && parentLocation._ref == ^._id && isNeighborhood && language == "en"] | order(title asc) {
        title, "slug": slug.current
      }
    }`,
    { citySlug },
  );
}

export async function getNeighborhoodBySlug(neighborhoodSlug: string) {
  return client.fetch(
    `*[_type == "location" && slug.current == $neighborhoodSlug && isNeighborhood && language == "en"][0]{
      ${LOCATION_FIELDS},
      "subNeighborhoods": *[_type == "location" && parentLocation._ref == ^._id && language == "en"] | order(title asc) {
        title, "slug": slug.current
      }
    }`,
    { neighborhoodSlug },
  );
}

export async function getAllLocationParams() {
  return client.fetch<{ state: string; city: string }[]>(
    `*[_type == "location" && !isNeighborhood && language == "en"]{
      "city": slug.current,
      "state": select(
        officeKey in ["savannah", "darien"] => "georgia",
        "south-carolina"
      )
    }`,
  );
}

export async function getAllNeighborhoodParams() {
  return client.fetch<{ state: string; city: string; neighborhood: string }[]>(
    `*[_type == "location" && isNeighborhood && language == "en"]{
      "neighborhood": slug.current,
      "city": parentLocation->slug.current,
      "state": select(
        parentOfficeKey in ["savannah", "darien"] => "georgia",
        "south-carolina"
      )
    }`,
  );
}
