import { notFound } from "next/navigation";
import type { Metadata } from "next";
import { getPillarBySlug, getAllPillarSlugs } from "@/lib/queries/practiceArea";
import { getFirmData, type OfficeKey } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";
import { InlineCta } from "@/components/sections/InlineCta";
import { FaqAccordion } from "@/components/sections/FaqAccordion";
import { AuthorAttribution } from "@/components/sections/AuthorAttribution";
import { LocationMatrix } from "@/components/sections/LocationMatrix";
import { StatuteOfLimitations } from "@/components/sections/StatuteOfLimitations";
import { ComparativeFault } from "@/components/sections/ComparativeFault";
import { ElementsOfNegligence } from "@/components/sections/ElementsOfNegligence";
import { CompensationTypes } from "@/components/sections/CompensationTypes";
import { SubtypesGrid } from "@/components/sections/SubtypesGrid";
import { BottomCta } from "@/components/sections/BottomCta";
import { PortableText } from "@/components/shared/PortableText";
import { JsonLd } from "@/components/shared/JsonLd";
import { legalServiceSchema, faqPageSchema, breadcrumbSchema } from "@/lib/schema";
import { urlForImage } from "@/sanity/lib/image";

interface Props {
  params: Promise<{ slug: string }>;
}

export async function generateStaticParams() {
  const slugs = await getAllPillarSlugs();
  return slugs.map((slug) => ({ slug }));
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { slug } = await params;
  const pa = await getPillarBySlug(slug);
  if (!pa) return {};
  return {
    title: pa.title,
    description: pa.seoMetaDescription || pa.heroIntro?.slice(0, 160),
  };
}

export default async function PillarPracticeAreaPage({ params }: Props) {
  const { slug } = await params;
  const pa = await getPillarBySlug(slug);
  if (!pa) notFound();

  const firm = getFirmData();
  const jurisdictionLabel =
    pa.jurisdiction === "GA" ? "Georgia" : pa.jurisdiction === "SC" ? "South Carolina" : "Georgia & South Carolina";

  const path = `/practice-areas/${slug}/`;
  const schemas = [
    legalServiceSchema(pa, path),
    faqPageSchema(pa.faqs),
    breadcrumbSchema([
      { name: "Home", url: "/" },
      { name: "Practice Areas", url: "/practice-areas/" },
      { name: pa.title, url: path },
    ]),
  ].filter(Boolean) as Record<string, unknown>[];

  return (
    <>
      <JsonLd data={schemas} />
      {/* Hero */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-16">
          <Breadcrumbs
            items={[
              { label: "Home", href: "/" },
              { label: "Practice Areas", href: "/practice-areas/" },
              { label: pa.title },
            ]}
          />
          <div className="grid lg:grid-cols-[1fr_340px] gap-10 lg:gap-16 items-start mt-4">
            <div>
              <p className="porch-eyebrow mb-4">{jurisdictionLabel}</p>
              <h1 className="font-heading font-normal text-ink text-[clamp(38px,6vw,68px)] leading-[1.02] tracking-[-0.02em] mb-6">
                {pa.title}
              </h1>
              {pa.heroIntro && (
                <p className="text-[18px] leading-[1.55] text-ink-2 mb-8 max-w-[54ch]">{pa.heroIntro}</p>
              )}
              <a
                href={`tel:${firm.phoneE164}`}
                className="inline-flex items-center gap-2 bg-terra text-paper font-bold px-7 py-3.5 rounded-full hover:bg-terra-deep transition-colors no-underline"
              >
                ☎ {firm.phone}
              </a>
            </div>
            <div className="hidden lg:block">
              <ContactForm />
            </div>
          </div>
        </div>
      </section>

      {/* Location Matrix */}
      <LocationMatrix
        offices={firm.offices}
        pillarSlug={slug}
        intersections={pa.childIntersections}
      />

      {/* Main Content + Sidebar */}
      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[72px]">
        <div className="grid lg:grid-cols-[1fr_340px] gap-12 lg:gap-[64px]">
          {/* Main Content */}
          <div className="min-w-0">
            {/* Why Hire Section */}
            <section id="pa-overview" className="mb-12">
              <h2 className="font-heading text-[clamp(26px,3vw,36px)] leading-[1.1] mb-5">
                Why hire a <span className="porch-em">{pa.title.replace(/ Lawyers?$/i, "")} lawyer.</span>
              </h2>
              {pa.whyHire ? (
                <PortableText value={pa.whyHire} />
              ) : pa.body ? (
                <PortableText value={pa.body} />
              ) : null}
            </section>

            <InlineCta />

            {/* Sub-Types Grid */}
            {pa.childSubtypes && pa.childSubtypes.length > 0 && (
              <SubtypesGrid
                subtypes={pa.childSubtypes}
                pillarSlug={slug}
                heading={`Types of ${pa.title.replace(/ Lawyers?$/i, "")} Cases We Handle`}
              />
            )}

            {/* Statute of Limitations */}
            <StatuteOfLimitations
              solGa={pa.solGa}
              solSc={pa.solSc}
              jurisdiction={pa.jurisdiction}
            />

            {/* Elements of Negligence */}
            <ElementsOfNegligence />

            {/* Compensation Types */}
            <CompensationTypes />

            {/* Comparative Fault */}
            <ComparativeFault jurisdiction={pa.jurisdiction} />

            <InlineCta />

            {/* Common Causes */}
            {pa.commonCauses && pa.commonCauses.length > 0 && (
              <section className="mb-12" data-ai-extractable="true">
                <h2 className="font-heading text-[28px] mb-5">
                  Common Causes
                </h2>
                <ul className="grid md:grid-cols-2 gap-x-8 gap-y-1.5 list-disc pl-5 text-ink-2 marker:text-honey">
                  {pa.commonCauses.map((cause: string, i: number) => (
                    <li key={i}>{cause}</li>
                  ))}
                </ul>
              </section>
            )}

            {/* Common Injuries */}
            {pa.commonInjuries && pa.commonInjuries.length > 0 && (
              <section className="mb-12" data-ai-extractable="true">
                <h2 className="font-heading text-[28px] mb-5">
                  Common Injuries
                </h2>
                <div className="space-y-4">
                  {pa.commonInjuries.map((injury: { name: string; description?: string }, i: number) => (
                    <div key={i} className="bg-paper border border-rule rounded-[16px] p-5">
                      <h3 className="font-heading text-[18px] text-ink">
                        {injury.name}
                      </h3>
                      {injury.description && (
                        <p className="text-sm text-slate mt-1.5 leading-[1.55]">{injury.description}</p>
                      )}
                    </div>
                  ))}
                </div>
              </section>
            )}

            {/* Author Attribution */}
            {pa.authorAttorney && (
              <AuthorAttribution
                name={pa.authorAttorney.name}
                slug={pa.authorAttorney.slug}
                jobTitle={pa.authorAttorney.jobTitle}
                barAdmissions={pa.authorAttorney.barAdmissions}
                headshotUrl={pa.authorAttorney.headshot ? urlForImage(pa.authorAttorney.headshot)?.width(240).url() ?? undefined : undefined}
              />
            )}

            {/* FAQs */}
            {pa.faqs && pa.faqs.length > 0 && <FaqAccordion faqs={pa.faqs} />}

            <InlineCta />

            {/* Bottom CTA */}
            <BottomCta />
          </div>

          {/* Sidebar */}
          <aside className="hidden lg:block">
            <div className="sticky top-[88px] space-y-6">
              <ContactForm />
              <StatuteOfLimitations
                solGa={pa.solGa || "2 years (O.C.G.A. § 9-3-33)"}
                solSc={pa.solSc || "3 years (S.C. Code § 15-3-530)"}
                jurisdiction={pa.jurisdiction}
                compact
              />
            </div>
          </aside>
        </div>
      </div>
    </>
  );
}
