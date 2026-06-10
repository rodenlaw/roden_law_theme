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
      {/* ── Hero ─────────────────────────────────────────── */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-16">
          <Breadcrumbs
            items={[
              { label: "Home", href: "/" },
              { label: "Locations", href: "/locations/" },
              { label: office.stateFull, href: `/locations/${office.stateSlug}/` },
              { label: office.marketName, href: `/locations/${state}/${city}/` },
              { label: loc.title },
            ]}
          />
          <div className="grid lg:grid-cols-[1fr_340px] gap-10 lg:gap-16 items-start mt-4">
            <div>
              <p className="porch-eyebrow mb-4">
                Serving {loc.title} from our {office.marketName} office
              </p>
              <h1 className="font-heading font-normal text-ink text-[clamp(34px,5vw,60px)] leading-[1.04] tracking-[-0.02em] mb-6">
                Personal injury lawyer serving <span className="porch-em">{loc.title}, {office.stateFull}.</span>
              </h1>
              <p className="text-[18px] leading-[1.55] text-ink-2 max-w-[52ch] mb-8">
                Roden Law&apos;s {office.marketName} office serves injury victims throughout {loc.title} and the surrounding area. No fees unless we win.
              </p>

              {/* Trust Stats */}
              <div className="flex flex-wrap gap-8 mb-8">
                {[
                  { n: firm.trustStats.recovered, l: "Recovered" },
                  { n: `${firm.trustStats.rating}★`, l: "Rating" },
                  { n: firm.trustStats.cases, l: "Cases" },
                ].map((s) => (
                  <div key={s.l}>
                    <div className="font-heading text-[32px] font-medium leading-none text-ink">{s.n}</div>
                    <div className="text-[11px] font-bold tracking-[0.1em] uppercase text-slate mt-1.5">{s.l}</div>
                  </div>
                ))}
              </div>

              <a
                href={`tel:${office.phoneRaw}`}
                className="inline-flex items-center gap-2 bg-terra text-paper font-bold px-7 py-3.5 rounded-full hover:bg-terra-deep transition-colors no-underline"
              >
                ☎ Call {office.phone}
              </a>
            </div>
            <div className="hidden lg:block">
              <ContactForm />
            </div>
          </div>
        </div>
      </section>

      {/* ── Content ──────────────────────────────────────── */}
      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[72px]">
        <div className="grid lg:grid-cols-[1fr_340px] gap-12 lg:gap-[64px]">
          <div className="min-w-0">
            {/* About Section */}
            <section className="mb-12">
              <h2 className="font-heading text-[clamp(26px,3vw,36px)] leading-[1.1] mb-2">
                About <span className="porch-em">{loc.title}.</span>
              </h2>
              {loc.population && (
                <p className="font-mono text-[12px] tracking-[0.06em] text-slate mb-4">Population: {loc.population}</p>
              )}
              {loc.body ? (
                <PortableText value={loc.body} />
              ) : (
                <p className="text-ink-2 leading-[1.6]">
                  Roden Law&apos;s {office.marketName} office serves injury victims in {loc.title} and
                  the surrounding {office.stateFull} communities. If you&apos;ve been injured in{" "}
                  {loc.title}, contact us for a free case review.
                </p>
              )}
            </section>

            {/* Dangerous Roads */}
            {loc.roads && (
              <section className="mb-12" data-ai-extractable="true">
                <h2 className="font-heading text-[28px] mb-4">
                  Dangerous Roads &amp; Accident Hotspots
                </h2>
                <div className="bg-paper border border-rule rounded-[18px] p-6 text-sm text-ink-2 leading-[1.6] whitespace-pre-line">
                  {loc.roads}
                </div>
              </section>
            )}

            {/* Hospitals */}
            {loc.hospitals && (
              <section className="mb-12">
                <h2 className="font-heading text-[28px] mb-4">
                  Nearby Hospitals &amp; Emergency Rooms
                </h2>
                <div className="bg-paper border border-rule rounded-[18px] p-6 text-sm text-ink-2 leading-[1.6] whitespace-pre-line">
                  {loc.hospitals}
                </div>
              </section>
            )}

            {/* Landmarks */}
            {loc.landmarks && (
              <section className="mb-12">
                <h2 className="font-heading text-[28px] mb-4">
                  Local Landmarks &amp; Points of Interest
                </h2>
                <div className="bg-paper border border-rule rounded-[18px] p-6 text-sm text-ink-2 leading-[1.6] whitespace-pre-line">
                  {loc.landmarks}
                </div>
              </section>
            )}

            {/* Court Info */}
            {loc.court && (
              <section className="mb-12">
                <h2 className="font-heading text-[26px] mb-3">
                  Local Court
                </h2>
                <p className="text-ink-2 leading-[1.6]">{loc.court}</p>
              </section>
            )}

            {/* State Law */}
            {jurisdiction && (
              <section className="mb-12 bg-paper border border-rule rounded-[20px] p-8" data-ai-extractable="true">
                <h2 className="font-heading text-[26px] mb-5">
                  {office.stateFull} Filing Rules
                </h2>
                <div className="grid sm:grid-cols-2 gap-6">
                  <div>
                    <span className="font-mono text-[11px] tracking-[0.12em] uppercase text-slate">Statute of Limitations</span>
                    <p className="font-heading text-ink text-xl mt-1">{jurisdiction.statuteYears} years</p>
                    <p className="text-sm text-slate">{jurisdiction.statuteCite}</p>
                  </div>
                  <div>
                    <span className="font-mono text-[11px] tracking-[0.12em] uppercase text-slate">Comparative Fault</span>
                    <p className="text-ink font-semibold text-sm mt-1">{jurisdiction.compFaultRule}</p>
                  </div>
                </div>
              </section>
            )}

            {/* Sub-Neighborhoods */}
            {loc.subNeighborhoods && loc.subNeighborhoods.length > 0 && (
              <section className="mb-12">
                <h2 className="font-heading text-[clamp(24px,3vw,32px)] leading-[1.1] mb-6">
                  Areas within <span className="porch-em">{loc.title}.</span>
                </h2>
                <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
                  {loc.subNeighborhoods.map((n: { title: string; slug: string }) => (
                    <Link
                      key={n.slug}
                      href={`/locations/${state}/${city}/${n.slug}/`}
                      className="block bg-paper rounded-[14px] px-4 py-3.5 text-sm font-semibold text-ink border border-rule hover:border-terra hover:text-terra hover:-translate-y-[2px] hover:shadow-[0_8px_20px_rgba(31,45,68,0.08)] transition-all no-underline"
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
            <div className="sticky top-[88px] space-y-5">
              <ContactForm />
              {/* NAP Card */}
              <div className="bg-paper border border-rule rounded-[18px] p-5">
                <h4 className="font-mono text-[10px] tracking-[0.16em] uppercase text-terra font-bold mb-3">{office.name}</h4>
                <address className="not-italic text-sm text-slate mb-3 leading-[1.5]">
                  {office.street}<br />
                  {office.city}, {office.state} {office.zip}
                </address>
                <a href={`tel:${office.phoneRaw}`} className="block text-sm font-bold text-terra hover:text-terra-deep no-underline mb-2">
                  {office.phone}
                </a>
                <a href={office.mapUrl} target="_blank" rel="noopener noreferrer nofollow" className="text-xs font-semibold text-ink hover:text-terra no-underline">
                  Get Directions &rarr;
                </a>
              </div>
              {/* Back to City */}
              <div className="bg-paper border border-rule rounded-[18px] p-5">
                <h4 className="font-mono text-[10px] tracking-[0.16em] uppercase text-terra font-bold mb-3">Back to Office</h4>
                <Link href={`/locations/${state}/${city}/`} className="text-sm font-semibold text-ink hover:text-terra no-underline">
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
