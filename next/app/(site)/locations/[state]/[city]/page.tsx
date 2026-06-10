import { notFound } from "next/navigation";
import type { Metadata } from "next";
import Link from "next/link";
import { getLocationBySlug, getAllLocationParams } from "@/lib/queries/location";
import { getFirmData, type OfficeKey } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";
import { FaqAccordion } from "@/components/sections/FaqAccordion";
import { BottomCta } from "@/components/sections/BottomCta";
import { PorchPlaceholder } from "@/components/porch/PorchPlaceholder";
import { PortableText } from "@/components/shared/PortableText";
import { JsonLd } from "@/components/shared/JsonLd";
import { officeLocalBusinessSchema, faqPageSchema, breadcrumbSchema } from "@/lib/schema";

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

  const path = `/locations/${state}/${city}/`;
  const schemas = [
    officeLocalBusinessSchema(officeKey as string, path),
    faqPageSchema(loc.faqs),
    breadcrumbSchema([
      { name: "Home", url: "/" },
      { name: "Locations", url: "/locations/" },
      { name: office.stateFull, url: `/locations/${office.stateSlug}/` },
      { name: office.marketName, url: path },
    ]),
  ].filter(Boolean) as Record<string, unknown>[];

  return (
    <>
      <JsonLd data={schemas} />

      {/* ── Hero ─────────────────────────────────────────── */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-16">
          <Breadcrumbs
            items={[
              { label: "Home", href: "/" },
              { label: "Locations", href: "/locations/" },
              { label: office.stateFull, href: `/locations/${office.stateSlug}/` },
              { label: office.marketName },
            ]}
          />
          <div className="grid lg:grid-cols-[1.05fr_.95fr] gap-12 lg:gap-16 items-center mt-4">
            <div>
              <p className="porch-eyebrow mb-4">Locations · {office.stateFull}</p>
              <h1 className="font-heading font-normal text-ink text-[clamp(40px,6vw,72px)] leading-[1.02] tracking-[-0.02em] mb-6">
                Personal Injury Lawyer<br />
                <span className="porch-em">in {office.marketName}, {office.state}.</span>
              </h1>
              <p className="text-[18px] leading-[1.55] text-ink-2 max-w-[52ch] mb-8">
                Roden Law&apos;s {office.marketName} personal injury attorneys have recovered{" "}
                <b className="font-bold text-ink">{firm.trustStats.recovered}</b> for injury victims across {office.serviceArea} No fees unless we win.
              </p>

              {/* NAP address card */}
              <div className="bg-paper border border-rule rounded-[20px] divide-y divide-rule shadow-[0_8px_24px_rgba(31,45,68,0.06)] max-w-[560px]">
                <div className="flex items-center gap-4 px-6 py-4">
                  <span className="text-honey-deep text-lg shrink-0" aria-hidden="true">◉</span>
                  <div className="grow">
                    <div className="font-mono text-[10px] tracking-[0.12em] uppercase text-slate mb-0.5">Address</div>
                    <div className="text-ink font-semibold text-sm">{office.street}<br />{office.city}, {office.state} {office.zip}</div>
                  </div>
                  <a href={office.mapUrl} target="_blank" rel="noopener noreferrer nofollow" className="text-terra text-sm font-semibold no-underline shrink-0 hover:text-terra-deep">Directions →</a>
                </div>
                <div className="flex items-center gap-4 px-6 py-4">
                  <span className="text-honey-deep text-lg shrink-0" aria-hidden="true">☎</span>
                  <div className="grow">
                    <div className="font-mono text-[10px] tracking-[0.12em] uppercase text-slate mb-0.5">Phone (24/7)</div>
                    <div className="text-ink font-semibold text-sm font-mono">{office.phone}</div>
                  </div>
                  <a href={`tel:${office.phoneRaw}`} className="text-terra text-sm font-semibold no-underline shrink-0 hover:text-terra-deep">Call now →</a>
                </div>
              </div>

              {/* Trust Stats */}
              <div className="flex flex-wrap gap-8 mt-8">
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
            </div>

            {/* Photo stack */}
            <div className="relative max-w-[440px] w-full mx-auto">
              <div className="absolute -top-3 left-6 z-20 bg-paper border border-rule rounded-full px-4 py-2 text-[11px] font-extrabold tracking-[0.1em] uppercase text-ink shadow-[0_8px_24px_rgba(31,45,68,0.10)]">
                {office.marketName} · {office.stateFull}
              </div>
              <div className="porch-frame relative aspect-[5/6]">
                <PorchPlaceholder label={`${office.marketName} · storefront · 5:6`} variant="warm" className="absolute inset-0" />
                <div className="absolute bottom-5 left-5 right-5 z-20 bg-ink/85 text-cream px-5 py-3.5 rounded-[14px] text-[13px] leading-[1.45] backdrop-blur-sm">
                  <b className="text-honey">{office.street}</b> — {office.city}, {office.state} {office.zip}
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* ── Map ──────────────────────────────────────────── */}
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
        <div className="bg-ink">
          <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div className="text-cream">
              <strong className="block font-heading text-[17px]">{office.name}</strong>
              <span className="text-sm text-cream/65">{office.street}, {office.city}, {office.state} {office.zip}</span>
            </div>
            <div className="flex gap-3">
              <a href={`tel:${office.phoneRaw}`} className="inline-block bg-terra text-paper font-bold px-5 py-2.5 rounded-full text-sm hover:bg-terra-deep transition-colors no-underline">
                {office.phone}
              </a>
              <a href={office.mapUrl} target="_blank" rel="noopener noreferrer nofollow" className="inline-block border border-cream/30 text-cream font-semibold px-5 py-2.5 rounded-full text-sm hover:bg-cream/10 transition-colors no-underline">
                Get Directions
              </a>
            </div>
          </div>
        </div>
      </section>

      {/* ── Content ──────────────────────────────────────── */}
      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[72px]">
        <div className="grid lg:grid-cols-[1fr_340px] gap-12 lg:gap-[64px]">
          <div className="min-w-0">
            {/* Body Content */}
            {loc.body && (
              <section className="mb-12">
                <PortableText value={loc.body} />
              </section>
            )}

            {/* State Law */}
            {jurisdiction && (
              <section className="mb-12 bg-paper border border-rule rounded-[20px] p-8" data-ai-extractable="true">
                <h2 className="font-heading text-[26px] mb-5">
                  {office.stateFull} Personal Injury Law
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

            {/* Neighborhoods */}
            {loc.neighborhoodChildren && loc.neighborhoodChildren.length > 0 && (
              <section className="mb-12">
                <h2 className="font-heading text-[clamp(26px,3vw,36px)] leading-[1.1] mb-6">
                  Areas served in the <span className="porch-em">{office.marketName} metro region.</span>
                </h2>
                <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
                  {loc.neighborhoodChildren.map((n: { title: string; slug: string }) => (
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
            </div>
          </aside>
        </div>
      </div>
    </>
  );
}
