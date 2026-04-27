import { notFound } from "next/navigation";
import type { Metadata } from "next";
import Link from "next/link";
import { getLocationBySlug, getAllLocationParams } from "@/lib/queries/location";
import { getFirmData, type OfficeKey } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";
import { FaqAccordion } from "@/components/sections/FaqAccordion";
import { BottomCta } from "@/components/sections/BottomCta";
import { PortableText } from "@/components/shared/PortableText";

interface Props {
  params: Promise<{ state: string; city: string }>;
}

export async function generateStaticParams() {
  return getAllLocationParams();
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { city } = await params;
  const loc = await getLocationBySlug("", city);
  if (!loc) return {};
  return {
    title: loc.title,
    description: loc.seoMetaDescription || `Personal injury lawyers serving ${loc.title}. Free consultation. No fees unless we win.`,
  };
}

export default async function CityLocationPage({ params }: Props) {
  const { state, city } = await params;
  const loc = await getLocationBySlug(state, city);
  if (!loc) notFound();

  const firm = getFirmData();
  const officeKey = loc.officeKey as OfficeKey | undefined;
  const office = officeKey ? firm.offices[officeKey] : null;

  if (!office) notFound();

  const jurisdiction = firm.jurisdiction[office.state as "GA" | "SC"];
  const mapEmbed = loc.mapEmbed || office.mapEmbed || `https://maps.google.com/maps?q=${encodeURIComponent(`${office.street}, ${office.city}, ${office.state} ${office.zip}`)}&output=embed&z=15`;

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
              { label: office.marketName },
            ]}
          />
          <div className="grid lg:grid-cols-[1fr_340px] gap-10 mt-4">
            <div>
              <span className={`inline-block text-xs uppercase tracking-widest mb-2 ${office.state === "GA" ? "text-green" : "text-orange"}`}>
                {office.stateFull}
              </span>
              <h1 className="font-heading text-3xl md:text-4xl lg:text-5xl font-black mb-4">
                Personal Injury Lawyer<br />
                <span className="text-orange">in {office.marketName}, {office.state}</span>
              </h1>
              <p className="text-lg text-gray-300 mb-6 max-w-2xl">
                Roden Law&apos;s {office.marketName} personal injury attorneys have recovered <strong>{firm.trustStats.recovered}</strong> for injury victims across {office.serviceArea} No fees unless we win.
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

      {/* Map */}
      <section>
        <iframe
          title={`Location map for Roden Law — ${office.marketName}`}
          src={mapEmbed}
          width="100%"
          height="400"
          style={{ border: 0, display: "block" }}
          allowFullScreen
          loading="lazy"
          referrerPolicy="no-referrer-when-downgrade"
        />
        <div className="bg-navy-dark">
          <div className="mx-auto max-w-[1200px] px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div className="text-white">
              <strong className="block">{office.name}</strong>
              <span className="text-sm text-gray-400">{office.street}, {office.city}, {office.state} {office.zip}</span>
            </div>
            <div className="flex gap-3">
              <a href={`tel:${office.phoneRaw}`} className="inline-block bg-orange text-navy font-bold px-5 py-2.5 rounded-md text-sm no-underline">
                {office.phone}
              </a>
              <a href={office.mapUrl} target="_blank" rel="noopener noreferrer nofollow" className="inline-block border border-white/30 text-white font-semibold px-5 py-2.5 rounded-md text-sm hover:bg-white/10 no-underline">
                Get Directions
              </a>
            </div>
          </div>
        </div>
      </section>

      {/* Content */}
      <div className="mx-auto max-w-[1200px] px-6 py-12">
        <div className="grid lg:grid-cols-[1fr_340px] gap-10">
          <div className="min-w-0">
            {/* Body Content */}
            {loc.body && (
              <section className="mb-10">
                <PortableText value={loc.body} />
              </section>
            )}

            {/* State Law */}
            {jurisdiction && (
              <section className="mb-10 bg-light rounded-lg p-6" data-ai-extractable="true">
                <h2 className="font-heading text-xl font-bold text-navy mb-4">
                  {office.stateFull} Personal Injury Law
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

            {/* Neighborhoods */}
            {loc.neighborhoodChildren && loc.neighborhoodChildren.length > 0 && (
              <section className="mb-10">
                <h2 className="font-heading text-2xl font-bold text-navy mb-4">
                  Areas Served in the {office.marketName} Metro Region
                </h2>
                <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
                  {loc.neighborhoodChildren.map((n: { title: string; slug: string }) => (
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
            </div>
          </aside>
        </div>
      </div>
    </>
  );
}
