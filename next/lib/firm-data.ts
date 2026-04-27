/**
 * Central Firm Data Configuration
 *
 * Single source of truth for all firm data. Every component, schema output,
 * and helper function pulls from getFirmData(). Port of inc/firm-data.php.
 */

// ---------------------------------------------------------------------------
// Types
// ---------------------------------------------------------------------------

export type StateAbbrev = "GA" | "SC";

export interface Office {
  name: string;
  marketName: string;
  street: string;
  city: string;
  state: StateAbbrev;
  stateFull: string;
  zip: string;
  phone: string;
  phoneRaw: string;
  latitude: number;
  longitude: number;
  timezone: string;
  court: string;
  courtAddress: string;
  slug: string;
  stateSlug: string;
  serviceArea: string;
  attorneys: string[];
  nearbyCommunities: string[];
  directions: string;
  reviewCount: number;
  reviewRating: string;
  mapEmbed?: string;
  // Convenience aliases (computed)
  address: string;
  phoneE164: string;
  lat: number;
  lng: number;
  mapUrl: string;
  sol: string;
  fault: string;
}

export type OfficeKey =
  | "savannah"
  | "darien"
  | "charleston"
  | "north-charleston"
  | "columbia"
  | "myrtle-beach";

export interface Attorney {
  name: string;
  title: string;
  barAdmissions: string[];
  office: OfficeKey;
  focus?: string;
}

export interface TrustStats {
  recovered: string;
  rating: string;
  reviews: string;
  reviewCount: number;
  cases: string;
  experience: string;
  offices: string;
}

export interface Jurisdiction {
  stateFull: string;
  statuteYears: number;
  statuteCite: string;
  compFaultRule: string;
  compFaultCite: string;
}

export interface FirmData {
  name: string;
  legalEntity: string;
  vanityPhone: string;
  phoneRaw: string;
  url: string;
  description: string;
  licensedIn: string[];
  founded: string;
  offices: Record<OfficeKey, Office>;
  attorneys: Record<string, Attorney>;
  trustStats: TrustStats;
  social: Record<string, string>;
  jurisdiction: Record<StateAbbrev, Jurisdiction>;
  practiceAreas: string[];
  // Convenience aliases
  phone: string;
  phoneE164: string;
  recovered: string;
  rating: string;
  reviews: string;
  casesHandled: string;
  experience: string;
}

// ---------------------------------------------------------------------------
// Data
// ---------------------------------------------------------------------------

const SITE_URL = process.env.NEXT_PUBLIC_SITE_URL || "https://www.rodenlaw.com";

const jurisdiction: Record<StateAbbrev, Jurisdiction> = {
  GA: {
    stateFull: "Georgia",
    statuteYears: 2,
    statuteCite: "O.C.G.A. § 9-3-33",
    compFaultRule: "Modified — recover if less than 50% at fault",
    compFaultCite: "O.C.G.A. § 51-12-33",
  },
  SC: {
    stateFull: "South Carolina",
    statuteYears: 3,
    statuteCite: "S.C. Code § 15-3-530",
    compFaultRule: "Modified — recover if less than 51% at fault",
    compFaultCite: "",
  },
};

function buildOffice(
  raw: Omit<Office, "address" | "phoneE164" | "lat" | "lng" | "mapUrl" | "sol" | "fault" | "marketName"> & { marketName?: string },
): Office {
  const stateKey = raw.state;
  const j = jurisdiction[stateKey];
  return {
    ...raw,
    marketName: raw.marketName ?? raw.city,
    address: raw.street,
    phoneE164: raw.phoneRaw,
    lat: raw.latitude,
    lng: raw.longitude,
    mapUrl: `https://www.google.com/maps/dir/?api=1&destination=${raw.latitude},${raw.longitude}`,
    sol: `${j.statuteYears} years (${j.statuteCite})`,
    fault: j.compFaultRule,
  };
}

const offices: Record<OfficeKey, Office> = {
  savannah: buildOffice({
    name: "Roden Law — Savannah",
    street: "333 Commercial Dr.",
    city: "Savannah",
    state: "GA",
    stateFull: "Georgia",
    zip: "31406",
    phone: "(912) 303-5850",
    phoneRaw: "+19123035850",
    latitude: 32.0291,
    longitude: -81.049,
    timezone: "America/New_York",
    court: "Chatham County Superior Court",
    courtAddress: "133 Montgomery St., Savannah, GA 31401",
    slug: "savannah-ga",
    stateSlug: "georgia",
    serviceArea:
      "Savannah, Pooler, Richmond Hill, Hinesville, Statesboro, Brunswick, and surrounding Southeast Georgia communities.",
    attorneys: ["eric-roden", "tyler-love"],
    nearbyCommunities: [
      "Pooler", "Richmond Hill", "Hinesville", "Garden City",
      "Port Wentworth", "Tybee Island", "Bloomingdale",
      "Georgetown", "Thunderbolt", "Wilmington Island",
    ],
    directions:
      "Our Savannah office is located on Commercial Drive, just off Abercorn Street near Oglethorpe Mall. From I-16 East, take Exit 164A onto I-516 E/DeRenne Ave, then turn south on Abercorn St. From I-95, take Exit 94 onto GA-204 E (Abercorn St) toward Savannah. Free client parking is available in our building lot.",
    reviewCount: 58,
    reviewRating: "4.9",
  }),
  darien: buildOffice({
    name: "Roden Law — Darien",
    street: "1108 North Way",
    city: "Darien",
    state: "GA",
    stateFull: "Georgia",
    zip: "31305",
    phone: "(912) 303-5850",
    phoneRaw: "+19123035850",
    latitude: 31.3702,
    longitude: -81.434,
    timezone: "America/New_York",
    court: "McIntosh County Superior Court",
    courtAddress: "310 Northway, Darien, GA 31305",
    slug: "darien-ga",
    stateSlug: "georgia",
    serviceArea:
      "Darien, Brunswick, St. Simons Island, Jekyll Island, Waycross, and surrounding Southeast Georgia coastal communities.",
    attorneys: ["joshua-dorminy"],
    nearbyCommunities: [
      "Brunswick", "St. Simons Island", "Jekyll Island", "Waycross",
      "Jesup", "Townsend", "Meridian", "Eulonia",
      "South Newport", "Crescent",
    ],
    directions:
      "Our Darien office is on North Way, conveniently located near the I-95/US-17 interchange in McIntosh County. From I-95, take Exit 49 (GA-251) toward Darien and head east on North Way. From Brunswick, take US-17 North approximately 16 miles. The office is easily accessible from the Golden Isles and surrounding coastal communities.",
    reviewCount: 12,
    reviewRating: "4.9",
  }),
  charleston: buildOffice({
    name: "Roden Law — Charleston",
    street: "127 King Street, Suite 200",
    city: "Charleston",
    state: "SC",
    stateFull: "South Carolina",
    zip: "29401",
    phone: "(843) 790-8999",
    phoneRaw: "+18437908999",
    latitude: 32.7876,
    longitude: -79.9353,
    timezone: "America/New_York",
    court: "Charleston County Circuit Court",
    courtAddress: "100 Broad St., Charleston, SC 29401",
    slug: "charleston-sc",
    stateSlug: "south-carolina",
    serviceArea:
      "Charleston, Mount Pleasant, West Ashley, James Island, Johns Island, Daniel Island, and surrounding Lowcountry communities.",
    attorneys: ["graeham-gillin", "kiley-reidy", "zach-stohr"],
    nearbyCommunities: [
      "Mount Pleasant", "West Ashley", "James Island", "Johns Island",
      "Daniel Island", "Isle of Palms", "Folly Beach", "Sullivan's Island",
      "Kiawah Island", "Wadmalaw Island",
    ],
    directions:
      "Our Charleston office is in the heart of downtown on King Street, Suite 200, near the intersection of King and Calhoun streets. From I-26 East, take Exit 221B onto Meeting Street heading south, then turn right on Calhoun and left on King. From Mount Pleasant, cross the Ravenel Bridge and follow US-17 S to the Meeting Street exit. Street and garage parking available nearby.",
    mapEmbed:
      "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3354.570788089184!2d-79.9329881!3d32.7771216!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88fe7bd134041e93%3A0x2c255a08f0b45377!2sRoden%20Law!5e0!3m2!1sen!2sus!4v1773074802432!5m2!1sen!2sus",
    reviewCount: 80,
    reviewRating: "4.9",
  }),
  "north-charleston": buildOffice({
    name: "Roden Law — North Charleston",
    street: "2703 Spruill Ave",
    city: "North Charleston",
    state: "SC",
    stateFull: "South Carolina",
    zip: "29405",
    phone: "(843) 612-6561",
    phoneRaw: "+18436126561",
    latitude: 32.8546,
    longitude: -79.9748,
    timezone: "America/New_York",
    court: "Charleston County Circuit Court",
    courtAddress: "100 Broad St., Charleston, SC 29401",
    slug: "north-charleston-sc",
    stateSlug: "south-carolina",
    serviceArea:
      "North Charleston, Goose Creek, Summerville, Hanahan, Ladson, Moncks Corner, and surrounding tri-county communities.",
    attorneys: ["graeham-gillin", "kiley-reidy", "zach-stohr"],
    nearbyCommunities: [
      "Goose Creek", "Summerville", "Hanahan", "Ladson",
      "Moncks Corner", "Park Circle", "Dorchester",
      "Lincolnville", "Jedburg", "Sangaree",
      "St. Stephen", "Walterboro",
    ],
    directions:
      "Our North Charleston office is located on Spruill Avenue in the Park Circle area. From I-26, take Exit 213 onto E Montague Ave heading east, then turn left on Spruill Ave. From downtown Charleston, take I-26 W to Exit 213. Free client parking is available on site.",
    reviewCount: 15,
    reviewRating: "5.0",
  }),
  columbia: buildOffice({
    name: "Roden Law — Columbia",
    street: "1545 Sumter St., Suite B",
    city: "Columbia",
    state: "SC",
    stateFull: "South Carolina",
    zip: "29201",
    phone: "(803) 219-2816",
    phoneRaw: "+18032192816",
    latitude: 34.0007,
    longitude: -81.0348,
    timezone: "America/New_York",
    court: "Richland County Circuit Court",
    courtAddress: "1701 Main St., Columbia, SC 29201",
    slug: "columbia-sc",
    stateSlug: "south-carolina",
    serviceArea:
      "Columbia, Lexington, Irmo, West Columbia, Cayce, Forest Acres, and surrounding Midlands South Carolina communities.",
    attorneys: ["graeham-gillin", "kiley-reidy"],
    nearbyCommunities: [
      "Lexington", "Irmo", "West Columbia", "Cayce",
      "Forest Acres", "Blythewood", "Elgin", "Chapin",
      "Dentsville", "Hopkins",
    ],
    directions:
      "Our Columbia office is on Sumter Street in the downtown corridor, near the University of South Carolina campus. From I-26, take Exit 111B onto Elmwood Ave, then turn south on Sumter St. From I-77, take Exit 16A onto I-277 and follow signs to Sumter Street. From I-20, take Exit 74 onto Broad River Rd toward downtown. Street metered parking and nearby garage parking are available.",
    reviewCount: 18,
    reviewRating: "4.9",
  }),
  "myrtle-beach": buildOffice({
    name: "Roden Law — Myrtle Beach",
    marketName: "Myrtle Beach",
    street: "631 Bellamy Ave., Suite C-B",
    city: "Murrells Inlet",
    state: "SC",
    stateFull: "South Carolina",
    zip: "29576",
    phone: "(843) 612-1980",
    phoneRaw: "+18436121980",
    latitude: 33.551,
    longitude: -79.0465,
    timezone: "America/New_York",
    court: "Horry County Circuit Court",
    courtAddress: "1301 2nd Ave., Conway, SC 29526",
    slug: "myrtle-beach-sc",
    stateSlug: "south-carolina",
    serviceArea:
      "Myrtle Beach, Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and surrounding Grand Strand communities.",
    attorneys: ["graeham-gillin", "ivy-montano"],
    nearbyCommunities: [
      "Myrtle Beach", "Conway", "Surfside Beach", "Pawleys Island",
      "Garden City", "Litchfield Beach", "North Myrtle Beach",
      "Little River", "Loris", "Georgetown",
    ],
    directions:
      "Our Myrtle Beach area office is on Bellamy Avenue in Murrells Inlet, Suite C-B, just off US-17 Business in the heart of the Grand Strand. From Myrtle Beach, take US-17 S (Kings Highway) approximately 12 miles south. From Georgetown, take US-17 N about 20 miles. From Conway, take US-501 to US-17 S. The office is near Brookgreen Gardens and Huntington Beach State Park.",
    reviewCount: 22,
    reviewRating: "4.9",
  }),
};

const attorneys: Record<string, Attorney> = {
  "eric-roden": {
    name: "Eric Roden",
    title: "Founding Partner, CEO",
    barAdmissions: ["Georgia", "South Carolina"],
    office: "savannah",
  },
  "tyler-love": {
    name: "Tyler Love",
    title: "Founding Partner, CTO",
    barAdmissions: ["Georgia"],
    office: "savannah",
  },
  "joshua-dorminy": {
    name: "Joshua Dorminy",
    title: "Partner",
    barAdmissions: ["Georgia", "South Carolina"],
    office: "darien",
    focus: "Leads trucking litigation",
  },
  "graeham-gillin": {
    name: "Graeham C. Gillin",
    title: "Partner, COO",
    barAdmissions: ["South Carolina"],
    office: "charleston",
  },
  "kiley-reidy": {
    name: "Kiley Reidy",
    title: "Associate",
    barAdmissions: ["South Carolina"],
    office: "charleston",
  },
  "zach-stohr": {
    name: "Zach Stohr",
    title: "Associate",
    barAdmissions: ["South Carolina"],
    office: "charleston",
  },
  "ivy-montano": {
    name: "Ivy S. Montano",
    title: "Associate",
    barAdmissions: ["South Carolina"],
    office: "myrtle-beach",
  },
};

const trustStats: TrustStats = {
  recovered: "$250M+",
  rating: "4.9",
  reviews: "500+",
  reviewCount: 500,
  cases: "5,000+",
  experience: "62",
  offices: "6",
};

const social: Record<string, string> = {
  facebook: "https://www.facebook.com/RodenLaw",
  instagram: "https://www.instagram.com/rodenlaw",
  linkedin: "https://www.linkedin.com/company/roden-law",
  youtube: "https://www.youtube.com/@rodenlaw",
  twitter: "https://x.com/rodenlaw",
};

const practiceAreas: string[] = [
  "personal-injury-lawyers",
  "car-accident-lawyers",
  "truck-accident-lawyers",
  "slip-and-fall-lawyers",
  "motorcycle-accident-lawyers",
  "medical-malpractice-lawyers",
  "wrongful-death-lawyers",
  "workers-compensation-lawyers",
  "dog-bite-lawyers",
  "brain-injury-lawyers",
  "spinal-cord-injury-lawyers",
  "maritime-injury-lawyers",
  "product-liability-lawyers",
  "boating-accident-lawyers",
  "burn-injury-lawyers",
  "construction-accident-lawyers",
  "nursing-home-abuse-lawyers",
  "premises-liability-lawyers",
  "pedestrian-accident-lawyers",
  "bicycle-accident-lawyers",
  "electric-scooter-accident-lawyers",
  "atv-side-by-side-accident-lawyers",
  "golf-cart-accident-lawyers",
  "e-bike-accident-lawyers",
];

// ---------------------------------------------------------------------------
// Public API
// ---------------------------------------------------------------------------

export function getFirmData(): FirmData {
  return {
    name: "Roden Law",
    legalEntity: "Roden Love LLC",
    vanityPhone: "844-RESULTS",
    phoneRaw: "+18447378587",
    url: SITE_URL,
    description:
      "Personal injury law firm serving Georgia and South Carolina with over $250 million recovered for injured clients.",
    licensedIn: ["Georgia", "South Carolina"],
    founded: "2013",
    offices,
    attorneys,
    trustStats,
    social,
    jurisdiction,
    practiceAreas,
    // Convenience aliases
    phone: "844-RESULTS",
    phoneE164: "+18447378587",
    recovered: trustStats.recovered,
    rating: trustStats.rating,
    reviews: trustStats.reviews,
    casesHandled: trustStats.cases,
    experience: `${trustStats.experience} years`,
  };
}

export function getOffice(key: OfficeKey): Office | null {
  return offices[key] ?? null;
}

export function officeKeyFromSlug(citySlug: string): OfficeKey | null {
  for (const [key, office] of Object.entries(offices)) {
    if (office.slug === citySlug) return key as OfficeKey;
  }
  return null;
}

export function getOfficeSlugs(): string[] {
  return Object.values(offices).map((o) => o.slug);
}

export function getJurisdiction(state: StateAbbrev): Jurisdiction {
  return jurisdiction[state];
}

export function getAllJurisdictions(): Record<StateAbbrev, Jurisdiction> {
  return jurisdiction;
}

export function getPracticeAreaSlugs(): string[] {
  return practiceAreas;
}

export function isOfficeCitySlug(slug: string): boolean {
  return Object.values(offices).some((o) => o.slug === slug);
}
