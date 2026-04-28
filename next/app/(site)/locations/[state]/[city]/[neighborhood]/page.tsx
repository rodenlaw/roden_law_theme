import { notFound } from "next/navigation";
import type { Metadata } from "next";
import Link from "next/link";
import { getNeighborhoodBySlug, getAllNeighborhoodParams } from "@/lib/queries/location";
import { getFirmData, type OfficeKey } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";
import { FaqAccordion } from "@/components/sections/FaqAccordion";
import { BottomCta } from "@/components/sections/BottomCta";
import { PortableText } from "@/components/shared/PortableText";

interface Props {
  params: Promise<{ state: string; city: string; neighborhood: string }>;
}

export async function generateStaticParams() {
  return getAllNeighborhoodParams();
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { city, neighborhood } = await params;
  const loc = await getNeighborhoodBySlug(neighborhood, city);
  if (!loc) return {};
  return {
    title: loc.title,
    description: loc.seoMetaDescription || `Personal injury lawyer serving ${loc.title}. Free consultation. No fees unless we win.`,
  };
}

export default async function NeighborhoodPage({ params }: Props) {
  const { state, city, neighborhood } = await params;
  const loc = await getNeighborhoodBySlug(neighborhood, city);
  if (!loc) notFound();

  const firm = getFirmData();
  const officeKey = (loc.parentOfficeKey || loc.parentLocation?.officeKey) as OfficeKey | undefined;
  const office = officeKey ? firm.offices[officeKey] : null;

  if (!office) notFound();

  const jurisdiction = firm.jurisdiction[office.state as "GA" | "SC"];

  return (
    <>
      {/* Hero */}
      <section className="bg-navy text-white py-12 lg:py-16">
        <div className="mx-auto max-w-[1200px] px-6">
          <Breadcrumbs
            items={[
              { label: "Home", href: "/" },
              { label: "Locations", href: "/locations/" },
              { label: office.stateFull, href: `/locations/${office.stateSlug}/` },
              { label: office.marketName, href: `/locations/${state}/${city}/` },
              { label: loc.title },
            ]}
          />
          <div className="grid lg:grid-cols-[1fr_340px] gap-10 mt-4">
            <div>
              <span className={`inline-block text-[10px] uppercase tracking-widest mb-2 ${office.state === "GA" ? "text-green" : "text-orange"}`}>
                Serving {loc.title} from our {office.marketName} office
              </span>
              <h1 className="font-heading text-3xl md:text-4xl font-black mb-4">
                Personal Injury Lawyer Serving {loc.title}, {office.stateFull}
              </h1>
              <p className="text-lg text-gray-300 mb-6 max-w-2xl">
                Roden Law&apos;s {office.marketName} office serves injury victims throughout {loc.title} and the surrounding area. No fees unless we win.
              </p>

              {/* Trust Stats */}
              <div className="grid grid-cols-3 gap-4 mb-6 max-w-md">
                <div className="text-center">
                  <span className="block text-2xl font-black text-orange">{firm.trustStats.recovered}</span>
                  <span className="text-xs text-gray-400">Recovered</span>
                </div>
                <div className="text-center">
                  <span className="block text-2xl font-black text-orange">{firm.trustStats.rating}&#9733;</span>
                  <span className="text-xs text-gray-400">Rating</span>
                </div>
                <div className="text-center">
                  <span className="block text-2xl font-black text-orange">{firm.trustStats.cases}</span>
                  <span className="text-xs text-gray-400">Cases</span>
                </div>
              </div>

              <a
                href={`tel:${office.phoneRaw}`}
                className="inline-block bg-orange text-navy font-extrabold px-8 py-3.5 rounded-md hover:bg-orange-dark transition-colors no-underline"
              >
                Call {office.phone}
              </a>
            </div>
            <div className="hidden lg:block">
              <ContactForm />
            </div>
          </div>
        </div>
      </section>

      {/* Content */}
      <div className="mx-auto max-w-[1200px] px-6 py-12">
        <div className="grid lg:grid-cols-[1fr_340px] gap-10">
          <div className="min-w-0">
            {/* About Section */}
            <section className="mb-10">
              <h2 className="font-heading text-2xl font-bold text-navy mb-2">
                About {loc.title}
              </h2>
              {loc.population && (
                <p className="text-sm text-gray-500 mb-4">Population: {loc.population}</p>
              )}
              {loc.body ? (
                <PortableText value={loc.body} />
              ) : (
                <p className="text-gray-700">
                  Roden Law&apos;s {office.marketName} office serves injury victims in {loc.title} and
                  the surrounding {office.stateFull} communities. If you&apos;ve been injured in{" "}
                  {loc.title}, contact us for a free case review.
                </p>
              )}
            </section>

            {/* Dangerous Roads */}
            {loc.roads && (
              <section className="mb-10" data-ai-extractable="true">
                <h2 className="font-heading text-2xl font-bold text-navy mb-4">
                  Dangerous Roads &amp; Accident Hotspots
                </h2>
                <div className="bg-light rounded-lg p-5 text-sm text-gray-700 whitespace-pre-line">
                  {loc.roads}
                </div>
              </section>
            )}

            {/* Hospitals */}
            {loc.hospitals && (
              <section className="mb-10">
                <h2 className="font-heading text-2xl font-bold text-navy mb-4">
                  Nearby Hospitals &amp; Emergency Rooms
                </h2>
                <div className="bg-light rounded-lg p-5 text-sm text-gray-700 whitespace-pre-line">
                  {loc.hospitals}
                </div>
              </section>
            )}

            {/* Landmarks */}
            {loc.landmarks && (
              <section className="mb-10">
                <h2 className="font-heading text-2xl font-bold text-navy mb-4">
                  Local Landmarks &amp; Points of Interest
                </h2>
                <div className="bg-light rounded-lg p-5 text-sm text-gray-700 whitespace-pre-line">
                  {loc.landmarks}
                </div>
              </section>
            )}

            {/* Court Info */}
            {loc.court && (
              <section className="mb-10">
                <h2 className="font-heading text-xl font-bold text-navy mb-3">
                  Local Court
                </h2>
                <p className="text-gray-700">{loc.court}</p>
              </section>
            )}

            {/* State Law */}
            {jurisdiction && (
              <section className="mb-10 bg-light rounded-lg p-6" data-ai-extractable="true">
                <h2 className="font-heading text-xl font-bold text-navy mb-4">
                  {office.stateFull} Filing Rules
                </h2>
                <div className="grid sm:grid-cols-2 gap-6">
                  <div>
                    <span className="text-xs uppercase tracking-widest text-gray-500">Statute of Limitations</span>
                    <p className="text-navy font-bold text-lg">{jurisdiction.statuteYears} years</p>
                    <p className="text-sm text-gray-600">{jurisdiction.statuteCite}</p>
                  </div>
                  <div>
                    <span className="text-xs uppercase tracking-widest text-gray-500">Comparative Fault</span>
                    <p className="text-navy font-bold text-sm">{jurisdiction.compFaultRule}</p>
                  </div>
                </div>
              </section>
            )}

            {/* Sub-Neighborhoods */}
            {loc.subNeighborhoods && loc.subNeighborhoods.length > 0 && (
              <section className="mb-10">
                <h2 className="font-heading text-2xl font-bold text-navy mb-4">
                  Areas Within {loc.title}
                </h2>
                <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
                  {loc.subNeighborhoods.map((n: { title: string; slug: string }) => (
                    <Link
                      key={n.slug}
                      href={`/locations/${state}/${city}/${n.slug}/`}
                      className="block bg-light rounded-lg px-4 py-3 text-sm font-semibold text-navy hover:bg-orange/10 hover:text-orange-text border border-border transition-colors no-underline"
                    >
                      {n.title}
                    </Link>
                  ))}
                </div>
              </section>
            )}

            {/* FAQs */}
            {loc.faqs && loc.faqs.length > 0 && <FaqAccordion faqs={loc.faqs} />}

            <BottomCta
              heading={`Contact Our ${office.marketName} Office Today`}
              phone={office.phone}
              phoneRaw={office.phoneRaw}
            />
          </div>

          <aside className="hidden lg:block">
            <div className="sticky top-[88px] space-y-6">
              <ContactForm />
              {/* NAP Card */}
              <div className="bg-light rounded-lg p-4">
                <h4 className="font-heading text-sm font-bold text-navy mb-2">{office.name}</h4>
                <address className="not-italic text-sm text-gray-600 mb-2">
                  {office.street}<br />
                  {office.city}, {office.state} {office.zip}
                </address>
                <a href={`tel:${office.phoneRaw}`} className="block text-sm font-bold text-orange hover:text-orange-dark no-underline mb-2">
                  {office.phone}
                </a>
                <a href={office.mapUrl} target="_blank" rel="noopener noreferrer nofollow" className="text-xs text-navy hover:text-orange-text no-underline">
                  Get Directions &rarr;
                </a>
              </div>
              {/* Back to City */}
              <div className="bg-light rounded-lg p-4">
                <h4 className="font-heading text-sm font-bold text-navy mb-2">Back to Office</h4>
                <Link href={`/locations/${state}/${city}/`} className="text-sm text-navy hover:text-orange-text no-underline">
                  &larr; {office.marketName}, {office.state}
                </Link>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </>
  );
}
