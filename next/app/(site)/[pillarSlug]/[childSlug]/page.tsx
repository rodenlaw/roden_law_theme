import { notFound } from "next/navigation";
import type { Metadata } from "next";
import { getChildBySlug, getAllChildParams } from "@/lib/queries/practiceArea";
import { getFirmData, isOfficeCitySlug, officeKeyFromSlug, type OfficeKey } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";
import { InlineCta } from "@/components/sections/InlineCta";
import { FaqAccordion } from "@/components/sections/FaqAccordion";
import { AuthorAttribution } from "@/components/sections/AuthorAttribution";
import { StatuteOfLimitations } from "@/components/sections/StatuteOfLimitations";
import { ComparativeFault } from "@/components/sections/ComparativeFault";
import { ElementsOfNegligence } from "@/components/sections/ElementsOfNegligence";
import { CompensationTypes } from "@/components/sections/CompensationTypes";
import { LocationMatrix } from "@/components/sections/LocationMatrix";
import { BottomCta } from "@/components/sections/BottomCta";
import { PortableText } from "@/components/shared/PortableText";
import { JsonLd } from "@/components/shared/JsonLd";
import { legalServiceSchema, faqPageSchema, breadcrumbSchema } from "@/lib/schema";
import { urlForImage } from "@/sanity/lib/image";
import Link from "next/link";

function childSchema(pa: any, pillarSlug: string, childSlug: string) {
  const path = `/${pillarSlug}/${childSlug}/`;
  return [
    legalServiceSchema(pa, path),
    faqPageSchema(pa.faqs),
    breadcrumbSchema([
      { name: "Home", url: "/" },
      { name: "Practice Areas", url: "/practice-areas/" },
      ...(pa.parent?.title ? [{ name: pa.parent.title, url: `/practice-areas/${pillarSlug}/` }] : []),
      { name: pa.title, url: path },
    ]),
  ].filter(Boolean) as Record<string, unknown>[];
}

interface Props {
  params: Promise<{ pillarSlug: string; childSlug: string }>;
}

export async function generateStaticParams() {
  const params = await getAllChildParams();
  return params.map(({ pillarSlug, childSlug }) => ({ pillarSlug, childSlug }));
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { pillarSlug, childSlug } = await params;
  const pa = await getChildBySlug(pillarSlug, childSlug);
  if (!pa) return {};
  return {
    title: pa.title,
    description: pa.seoMetaDescription || pa.heroIntro?.slice(0, 160),
  };
}

export default async function ChildPracticeAreaPage({ params }: Props) {
  const { pillarSlug, childSlug } = await params;
  const pa = await getChildBySlug(pillarSlug, childSlug);
  if (!pa) notFound();

  const firm = getFirmData();
  const isIntersection = pa.pageType === "intersection" || isOfficeCitySlug(childSlug);
  const officeKey = pa.officeKey as OfficeKey | undefined;
  const office = officeKey ? firm.offices[officeKey] : null;

  // Author: own or parent fallback
  const author = pa.authorAttorney || pa.parent?.authorAttorney;

  // Why hire content: own or parent fallback
  const whyHireContent = pa.whyHire || pa.body || pa.parent?.whyHire;

  if (isIntersection && office) {
    return <IntersectionPage pa={pa} firm={firm} office={office} pillarSlug={pillarSlug} childSlug={childSlug} author={author} whyHireContent={whyHireContent} />;
  }

  return <SubtypePage pa={pa} firm={firm} pillarSlug={pillarSlug} author={author} whyHireContent={whyHireContent} />;
}

/* ================================================================
   INTERSECTION PAGE (PA × Location)
   ================================================================ */

function IntersectionPage({
  pa, firm, office, pillarSlug, childSlug, author, whyHireContent,
}: {
  pa: any; firm: ReturnType<typeof getFirmData>; office: any; pillarSlug: string; childSlug: string; author: any; whyHireContent: any;
}) {
  const jurisdiction = firm.jurisdiction[office.state as "GA" | "SC"];

  return (
    <>
      <JsonLd data={childSchema(pa, pillarSlug, childSlug)} />
      {/* Hero */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-16">
          <Breadcrumbs
            items={[
              { label: "Home", href: "/" },
              { label: "Practice Areas", href: "/practice-areas/" },
              { label: pa.parent?.title || "", href: `/practice-areas/${pillarSlug}/` },
              { label: pa.title },
            ]}
          />
          <div className="grid lg:grid-cols-[1fr_340px] gap-10 lg:gap-16 items-start mt-4">
            <div>
              <p className="porch-eyebrow mb-4">{office.stateFull}</p>
              <h1 className="font-heading font-normal text-ink text-[clamp(34px,5vw,60px)] leading-[1.04] tracking-[-0.02em] mb-6">{pa.title}</h1>
              <p className="text-[18px] leading-[1.55] text-ink-2 mb-8 max-w-[54ch]">
                {pa.heroIntro || `${pa.parent?.title} serving ${office.marketName}, ${office.stateFull} and surrounding communities.`}
              </p>
              {/* NAP Block */}
              <div className="bg-paper border border-rule rounded-[18px] px-6 py-5 max-w-md shadow-[0_8px_24px_rgba(31,45,68,0.06)]">
                <p className="font-heading text-[17px] text-ink mb-1">{office.name}</p>
                <p className="text-slate text-sm mb-1">{office.street}, {office.city}, {office.state} {office.zip}</p>
                <a href={`tel:${office.phoneRaw}`} className="text-terra font-bold text-sm hover:text-terra-deep no-underline">
                  ☎ {office.phone}
                </a>
              </div>
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
        pillarSlug={pillarSlug}
        intersections={pa.siblingIntersections}
        currentSlug={childSlug}
      />

      {/* Main Content */}
      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[72px]">
        <div className="grid lg:grid-cols-[1fr_340px] gap-12 lg:gap-[64px]">
          <div className="min-w-0">
            <section className="mb-12">
              <h2 className="font-heading text-[clamp(26px,3vw,36px)] leading-[1.1] mb-5">
                Why hire a {pa.parent?.title?.replace(/ Lawyers?$/i, "")} lawyer in <span className="porch-em">{office.marketName}.</span>
              </h2>
              {whyHireContent && <PortableText value={whyHireContent} />}
            </section>

            <InlineCta />

            {/* State Law Box */}
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

            <ElementsOfNegligence />
            <CompensationTypes stateFull={office.stateFull} />

            <InlineCta />

            {author && (
              <AuthorAttribution
                name={author.name}
                slug={author.slug}
                jobTitle={author.jobTitle}
                barAdmissions={author.barAdmissions}
                headshotUrl={author.headshot ? urlForImage(author.headshot)?.width(240).url() ?? undefined : undefined}
              />
            )}

            {pa.faqs && pa.faqs.length > 0 && <FaqAccordion faqs={pa.faqs} />}

            <BottomCta
              heading={`Contact Our ${office.marketName} Office Today`}
              phone={office.phone}
              phoneRaw={office.phoneRaw}
            />
          </div>

          <aside className="hidden lg:block">
            <div className="sticky top-[88px] space-y-5">
              <ContactForm />
              {pa.parent && (
                <div className="bg-paper border border-rule rounded-[18px] p-5">
                  <h4 className="font-mono text-[10px] tracking-[0.16em] uppercase text-terra font-bold mb-3">Back to Pillar</h4>
                  <Link href={`/practice-areas/${pillarSlug}/`} className="text-sm font-semibold text-ink hover:text-terra no-underline">
                    &larr; {pa.parent.title}
                  </Link>
                </div>
              )}
            </div>
          </aside>
        </div>
      </div>
    </>
  );
}

/* ================================================================
   SUB-TYPE PAGE
   ================================================================ */

function SubtypePage({
  pa, firm, pillarSlug, author, whyHireContent,
}: {
  pa: any; firm: ReturnType<typeof getFirmData>; pillarSlug: string; author: any; whyHireContent: any;
}) {
  const jurisdictionLabel =
    pa.jurisdiction === "GA" ? "Georgia" : pa.jurisdiction === "SC" ? "South Carolina" : "Georgia & South Carolina";

  return (
    <>
      <JsonLd data={childSchema(pa, pillarSlug, pa.slug)} />
      {/* Hero */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-16">
          <Breadcrumbs
            items={[
              { label: "Home", href: "/" },
              { label: "Practice Areas", href: "/practice-areas/" },
              { label: pa.parent?.title || "", href: `/practice-areas/${pillarSlug}/` },
              { label: pa.title },
            ]}
          />
          <div className="grid lg:grid-cols-[1fr_340px] gap-10 lg:gap-16 items-start mt-4">
            <div>
              <p className="porch-eyebrow mb-4">{jurisdictionLabel}</p>
              <h1 className="font-heading font-normal text-ink text-[clamp(34px,5vw,60px)] leading-[1.04] tracking-[-0.02em] mb-6">{pa.title}</h1>
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

      {/* Main Content */}
      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[72px]">
        <div className="grid lg:grid-cols-[1fr_340px] gap-12 lg:gap-[64px]">
          <div className="min-w-0">
            <section className="mb-12">
              <h2 className="font-heading text-[clamp(26px,3vw,36px)] leading-[1.1] mb-5">
                Why you need a lawyer for <span className="porch-em">{pa.title.replace(/ Lawyers?$/i, "")} cases.</span>
              </h2>
              {whyHireContent && <PortableText value={whyHireContent} />}
            </section>

            <InlineCta />

            <ElementsOfNegligence />
            <CompensationTypes />

            <StatuteOfLimitations
              solGa={pa.solGa}
              solSc={pa.solSc}
              jurisdiction={pa.jurisdiction}
            />

            <ComparativeFault jurisdiction={pa.jurisdiction} />

            <InlineCta />

            {/* Sibling Sub-Types */}
            {pa.siblings && pa.siblings.length > 0 && (
              <section className="mb-12">
                <h2 className="font-heading text-[28px] mb-5">
                  Related Case Types
                </h2>
                <div className="grid sm:grid-cols-2 gap-3">
                  {pa.siblings.map((sibling: { title: string; slug: string }) => (
                    <Link
                      key={sibling.slug}
                      href={`/${pillarSlug}/${sibling.slug}/`}
                      className="block bg-paper rounded-[14px] px-4 py-3.5 text-sm font-semibold text-ink border border-rule hover:border-terra hover:text-terra hover:-translate-y-[2px] hover:shadow-[0_8px_20px_rgba(31,45,68,0.08)] transition-all no-underline"
                    >
                      {sibling.title}
                    </Link>
                  ))}
                </div>
              </section>
            )}

            {/* Intersection Links */}
            {pa.siblingIntersections && pa.siblingIntersections.length > 0 && (
              <section className="mb-12">
                <h2 className="font-heading text-[28px] mb-5">
                  {pa.parent?.title} by Location
                </h2>
                <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
                  {pa.siblingIntersections.map((int: { title: string; slug: string; officeKey: string }) => {
                    const intOffice = int.officeKey ? firm.offices[int.officeKey as OfficeKey] : null;
                    return (
                      <Link
                        key={int.slug}
                        href={`/${pillarSlug}/${int.slug}/`}
                        className="block bg-paper rounded-[14px] px-4 py-3.5 text-sm font-semibold text-ink border border-rule hover:border-terra hover:text-terra hover:-translate-y-[2px] hover:shadow-[0_8px_20px_rgba(31,45,68,0.08)] transition-all no-underline"
                      >
                        {intOffice ? `${intOffice.marketName}, ${intOffice.state}` : int.title}
                      </Link>
                    );
                  })}
                </div>
              </section>
            )}

            {author && (
              <AuthorAttribution
                name={author.name}
                slug={author.slug}
                jobTitle={author.jobTitle}
                barAdmissions={author.barAdmissions}
                headshotUrl={author.headshot ? urlForImage(author.headshot)?.width(240).url() ?? undefined : undefined}
              />
            )}

            {pa.faqs && pa.faqs.length > 0 && <FaqAccordion faqs={pa.faqs} />}

            <BottomCta />
          </div>

          <aside className="hidden lg:block">
            <div className="sticky top-[88px] space-y-5">
              <ContactForm />
              {pa.parent && (
                <div className="bg-paper border border-rule rounded-[18px] p-5">
                  <h4 className="font-mono text-[10px] tracking-[0.16em] uppercase text-terra font-bold mb-3">Back to Pillar</h4>
                  <Link href={`/practice-areas/${pillarSlug}/`} className="text-sm font-semibold text-ink hover:text-terra no-underline">
                    &larr; {pa.parent.title}
                  </Link>
                </div>
              )}
            </div>
          </aside>
        </div>
      </div>
    </>
  );
}
