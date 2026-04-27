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
import { urlForImage } from "@/sanity/lib/image";
import Link from "next/link";

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
      {/* Hero */}
      <section className="bg-navy text-white py-12 lg:py-16">
        <div className="mx-auto max-w-[1200px] px-6">
          <Breadcrumbs
            items={[
              { label: "Home", href: "/" },
              { label: "Practice Areas", href: "/practice-areas/" },
              { label: pa.parent?.title || "", href: `/practice-areas/${pillarSlug}/` },
              { label: pa.title },
            ]}
          />
          <div className="grid lg:grid-cols-[1fr_340px] gap-10 mt-4">
            <div>
              <span className={`inline-block text-xs uppercase tracking-widest mb-2 ${office.state === "GA" ? "text-green" : "text-orange"}`}>
                {office.stateFull}
              </span>
              <h1 className="font-heading text-3xl md:text-4xl font-black mb-4">{pa.title}</h1>
              <p className="text-lg text-gray-300 mb-6">
                {pa.heroIntro || `${pa.parent?.title} serving ${office.marketName}, ${office.stateFull} and surrounding communities.`}
              </p>
              {/* NAP Block */}
              <div className="bg-white/10 rounded-lg px-5 py-4 mb-6 max-w-md">
                <p className="text-white font-semibold text-sm mb-1">{office.name}</p>
                <p className="text-gray-400 text-sm">{office.street}, {office.city}, {office.state} {office.zip}</p>
                <a href={`tel:${office.phoneRaw}`} className="text-orange font-bold text-sm hover:text-orange-light no-underline">
                  {office.phone}
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
      <div className="mx-auto max-w-[1200px] px-6 py-12">
        <div className="grid lg:grid-cols-[1fr_340px] gap-10">
          <div className="min-w-0">
            <section className="mb-10">
              <h2 className="font-heading text-2xl font-bold text-navy mb-4">
                Why Hire a {pa.parent?.title?.replace(/ Lawyers?$/i, "")} Lawyer in {office.marketName}
              </h2>
              {whyHireContent && <PortableText value={whyHireContent} />}
            </section>

            <InlineCta />

            {/* State Law Box */}
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
            <div className="sticky top-[88px] space-y-6">
              <ContactForm />
              {pa.parent && (
                <div className="bg-light rounded-lg p-4">
                  <h4 className="font-heading text-sm font-bold text-navy mb-2">Back to Pillar</h4>
                  <Link href={`/practice-areas/${pillarSlug}/`} className="text-sm text-navy hover:text-orange-text no-underline">
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
      {/* Hero */}
      <section className="bg-navy text-white py-12 lg:py-16">
        <div className="mx-auto max-w-[1200px] px-6">
          <Breadcrumbs
            items={[
              { label: "Home", href: "/" },
              { label: "Practice Areas", href: "/practice-areas/" },
              { label: pa.parent?.title || "", href: `/practice-areas/${pillarSlug}/` },
              { label: pa.title },
            ]}
          />
          <div className="grid lg:grid-cols-[1fr_340px] gap-10 mt-4">
            <div>
              <span className="inline-block text-xs uppercase tracking-widest text-orange mb-2">
                {jurisdictionLabel}
              </span>
              <h1 className="font-heading text-3xl md:text-4xl font-black mb-4">{pa.title}</h1>
              {pa.heroIntro && (
                <p className="text-lg text-gray-300 mb-6 max-w-2xl">{pa.heroIntro}</p>
              )}
              <a
                href={`tel:${firm.phoneE164}`}
                className="inline-block bg-orange text-navy font-extrabold px-8 py-3.5 rounded-md hover:bg-orange-dark transition-colors no-underline"
              >
                {firm.phone}
              </a>
            </div>
            <div className="hidden lg:block">
              <ContactForm />
            </div>
          </div>
        </div>
      </section>

      {/* Main Content */}
      <div className="mx-auto max-w-[1200px] px-6 py-12">
        <div className="grid lg:grid-cols-[1fr_340px] gap-10">
          <div className="min-w-0">
            <section className="mb-10">
              <h2 className="font-heading text-2xl font-bold text-navy mb-4">
                Why You Need a Lawyer for {pa.title.replace(/ Lawyers?$/i, "")} Cases
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
              <section className="mb-10">
                <h2 className="font-heading text-2xl font-bold text-navy mb-4">
                  Related Case Types
                </h2>
                <div className="grid sm:grid-cols-2 gap-3">
                  {pa.siblings.map((sibling: { title: string; slug: string }) => (
                    <Link
                      key={sibling.slug}
                      href={`/${pillarSlug}/${sibling.slug}/`}
                      className="block bg-light rounded-lg px-4 py-3 text-sm font-semibold text-navy hover:bg-orange/10 hover:text-orange-text transition-colors no-underline"
                    >
                      {sibling.title}
                    </Link>
                  ))}
                </div>
              </section>
            )}

            {/* Intersection Links */}
            {pa.siblingIntersections && pa.siblingIntersections.length > 0 && (
              <section className="mb-10">
                <h2 className="font-heading text-2xl font-bold text-navy mb-4">
                  {pa.parent?.title} by Location
                </h2>
                <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
                  {pa.siblingIntersections.map((int: { title: string; slug: string; officeKey: string }) => {
                    const intOffice = int.officeKey ? firm.offices[int.officeKey as OfficeKey] : null;
                    return (
                      <Link
                        key={int.slug}
                        href={`/${pillarSlug}/${int.slug}/`}
                        className="block bg-light rounded-lg px-4 py-3 text-sm text-navy hover:bg-orange/10 hover:text-orange-text transition-colors no-underline"
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
            <div className="sticky top-[88px] space-y-6">
              <ContactForm />
              {pa.parent && (
                <div className="bg-light rounded-lg p-4">
                  <h4 className="font-heading text-sm font-bold text-navy mb-2">Back to Pillar</h4>
                  <Link href={`/practice-areas/${pillarSlug}/`} className="text-sm text-navy hover:text-orange-text no-underline">
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
