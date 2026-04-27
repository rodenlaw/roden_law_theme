import { notFound } from "next/navigation";
import type { Metadata } from "next";
import Image from "next/image";
import { getAttorneyBySlug, getAllAttorneySlugs } from "@/lib/queries/attorney";
import { getFirmData, type OfficeKey } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";
import { BottomCta } from "@/components/sections/BottomCta";
import { PortableText } from "@/components/shared/PortableText";
import { urlForImage } from "@/sanity/lib/image";

interface Props {
  params: Promise<{ slug: string }>;
}

export async function generateStaticParams() {
  const slugs = await getAllAttorneySlugs();
  return slugs.map((slug) => ({ slug }));
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { slug } = await params;
  const atty = await getAttorneyBySlug(slug);
  if (!atty) return {};
  return {
    title: `${atty.name} — ${atty.jobTitle || "Attorney"}`,
    description: atty.seoMetaDescription || `${atty.name}, ${atty.jobTitle} at Roden Law. Personal injury attorney licensed in Georgia and South Carolina.`,
  };
}

export default async function AttorneyPage({ params }: Props) {
  const { slug } = await params;
  const atty = await getAttorneyBySlug(slug);
  if (!atty) notFound();

  const firm = getFirmData();
  const office = atty.officeKey ? firm.offices[atty.officeKey as OfficeKey] : null;
  const imgUrl = atty.headshot ? urlForImage(atty.headshot)?.width(600).height(800).url() : null;

  const barItems = atty.barAdmissions
    ? atty.barAdmissions.split("\n").map((s: string) => s.trim()).filter(Boolean)
    : [];

  return (
    <>
      <section className="bg-navy text-white py-12">
        <div className="mx-auto max-w-[1200px] px-6">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Attorneys", href: "/attorneys/" }, { label: atty.name }]} />
        </div>
      </section>

      <div className="mx-auto max-w-[1200px] px-6 py-12">
        <div className="grid lg:grid-cols-[1fr_340px] gap-10">
          <div className="min-w-0">
            {/* Header */}
            <div className="flex flex-col sm:flex-row gap-6 mb-8">
              {imgUrl && (
                <Image src={imgUrl} alt={atty.name} width={200} height={267} className="rounded-lg object-cover shrink-0" />
              )}
              <div>
                <h1 className="font-heading text-3xl font-black text-navy mb-1">{atty.name}</h1>
                {atty.jobTitle && <p className="text-lg text-gray-600 mb-2">{atty.jobTitle}</p>}
                {office && <p className="text-sm text-gray-500 mb-3">{office.marketName}, {office.state}</p>}

                {barItems.length > 0 && (
                  <div className="mb-3">
                    <h3 className="text-xs uppercase tracking-widest text-gray-500 mb-1">Bar Admissions</h3>
                    <p className="text-sm text-gray-700">{barItems.join(" | ")}</p>
                  </div>
                )}

                {atty.sameAs && atty.sameAs.length > 0 && (
                  <div className="flex gap-3">
                    {atty.sameAs.map((url: string) => (
                      <a key={url} href={url} target="_blank" rel="noopener noreferrer nofollow" className="text-sm text-navy hover:text-orange-text no-underline">
                        {url.includes("avvo") ? "Avvo" : url.includes("linkedin") ? "LinkedIn" : url.includes("martindale") ? "Martindale" : "Profile"}
                      </a>
                    ))}
                  </div>
                )}
              </div>
            </div>

            {/* Education */}
            {atty.education && atty.education.length > 0 && (
              <section className="mb-8">
                <h2 className="font-heading text-xl font-bold text-navy mb-3">Education</h2>
                <ul className="space-y-1 list-disc pl-5 text-sm text-gray-700">
                  {atty.education.map((edu: { degree: string; institution: string }, i: number) => (
                    <li key={i}>{edu.degree} — {edu.institution}</li>
                  ))}
                </ul>
              </section>
            )}

            {/* Awards */}
            {atty.awards && atty.awards.length > 0 && (
              <section className="mb-8">
                <h2 className="font-heading text-xl font-bold text-navy mb-3">Awards &amp; Recognition</h2>
                <ul className="space-y-1 list-disc pl-5 text-sm text-gray-700">
                  {atty.awards.map((aw: { name: string; year?: string }, i: number) => (
                    <li key={i}>{aw.name}{aw.year ? ` (${aw.year})` : ""}</li>
                  ))}
                </ul>
              </section>
            )}

            {/* Bio */}
            {atty.body && (
              <section className="mb-8">
                <h2 className="font-heading text-xl font-bold text-navy mb-3">About {atty.name}</h2>
                <PortableText value={atty.body} />
              </section>
            )}

            <BottomCta />
          </div>

          <aside className="hidden lg:block">
            <div className="sticky top-[88px] space-y-6">
              <ContactForm />
              {office && (
                <div className="bg-light rounded-lg p-4">
                  <h4 className="font-heading text-sm font-bold text-navy mb-2">{office.name}</h4>
                  <address className="not-italic text-sm text-gray-600 mb-2">
                    {office.street}<br />{office.city}, {office.state} {office.zip}
                  </address>
                  <a href={`tel:${office.phoneRaw}`} className="text-sm font-bold text-orange hover:text-orange-dark no-underline">{office.phone}</a>
                </div>
              )}
            </div>
          </aside>
        </div>
      </div>
    </>
  );
}
