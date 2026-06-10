import { notFound } from "next/navigation";
import type { Metadata } from "next";
import Image from "next/image";
import { getAttorneyBySlug, getAllAttorneySlugs } from "@/lib/queries/attorney";
import { getFirmData, type OfficeKey } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";
import { BottomCta } from "@/components/sections/BottomCta";
import { PorchPlaceholder } from "@/components/porch/PorchPlaceholder";
import { PortableText } from "@/components/shared/PortableText";
import { JsonLd } from "@/components/shared/JsonLd";
import { personSchema, breadcrumbSchema } from "@/lib/schema";
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

  const schemas = [
    personSchema({ ...atty, barAdmissions: barItems }, imgUrl ?? undefined),
    breadcrumbSchema([
      { name: "Home", url: "/" },
      { name: "Attorneys", url: "/attorneys/" },
      { name: atty.name, url: `/attorneys/${slug}/` },
    ]),
  ];

  return (
    <>
      <JsonLd data={schemas} />

      {/* ── Hero ─────────────────────────────────────────── */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-16">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Attorneys", href: "/attorneys/" }, { label: atty.name }]} />
          <div className="grid lg:grid-cols-[.9fr_1.1fr] gap-12 lg:gap-16 items-start mt-4">
            {/* Portrait */}
            <div className="relative max-w-[420px] w-full mx-auto lg:mx-0">
              <span className="absolute -top-3 left-6 z-20 inline-flex items-center gap-2 bg-paper border border-rule rounded-full px-4 py-2 text-[11px] font-extrabold tracking-[0.1em] uppercase text-ink shadow-[0_8px_24px_rgba(31,45,68,0.10)]">
                <span className="w-2 h-2 rounded-full bg-terra" aria-hidden="true" />
                Currently accepting cases
              </span>
              <div className="porch-frame relative aspect-[4/5]">
                {imgUrl ? (
                  <Image src={imgUrl} alt={atty.name} fill className="object-cover" sizes="(max-width: 1024px) 100vw, 420px" priority />
                ) : (
                  <PorchPlaceholder label={`${atty.name} · portrait · 4:5`} variant="dark" className="absolute inset-0" />
                )}
              </div>
              {office && (
                <div className="absolute bottom-5 left-5 right-5 z-20 bg-ink/85 text-cream px-5 py-3.5 rounded-[14px] text-[13px] leading-[1.45] backdrop-blur-sm">
                  <b className="text-honey">{atty.jobTitle || "Attorney"}</b><br />
                  {office.marketName}, {office.state}
                </div>
              )}
            </div>

            {/* Intro */}
            <div>
              <p className="porch-eyebrow mb-4">Our Team{atty.jobTitle ? ` · ${atty.jobTitle}` : ""}</p>
              <h1 className="font-heading font-normal text-ink text-[clamp(40px,6vw,72px)] leading-[1.0] tracking-[-0.025em] mb-5">
                {atty.name}
              </h1>
              {atty.jobTitle && <p className="text-[17px] text-slate mb-5">{atty.jobTitle}{office ? ` · ${office.marketName}, ${office.state}` : ""}</p>}

              {barItems.length > 0 && (
                <div className="mb-6">
                  <h3 className="font-mono text-[10px] uppercase tracking-[0.14em] text-slate mb-2">Bar Admissions</h3>
                  <p className="text-sm text-ink-2 leading-[1.6]">{barItems.join(" · ")}</p>
                </div>
              )}

              <div className="flex flex-wrap items-center gap-3">
                <a href={`tel:${office?.phoneRaw ?? firm.phoneE164}`} className="inline-block bg-terra text-paper font-bold px-7 py-3.5 rounded-full hover:bg-terra-deep transition-colors no-underline">
                  ☎ {office?.phone ?? firm.phone}
                </a>
                {atty.sameAs && atty.sameAs.length > 0 && atty.sameAs.map((url: string) => (
                  <a key={url} href={url} target="_blank" rel="noopener noreferrer nofollow" className="inline-block border border-ink/20 text-ink font-semibold px-5 py-3 rounded-full text-sm hover:border-terra hover:text-terra transition-colors no-underline">
                    {url.includes("avvo") ? "Avvo" : url.includes("linkedin") ? "LinkedIn" : url.includes("martindale") ? "Martindale" : "Profile"}
                  </a>
                ))}
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* ── Content + Sidebar ────────────────────────────── */}
      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[72px]">
        <div className="grid lg:grid-cols-[1fr_340px] gap-12 lg:gap-[64px]">
          <div className="min-w-0">
            {/* Bio */}
            {atty.body && (
              <section className="mb-12">
                <h2 className="font-heading text-[clamp(26px,3vw,36px)] leading-[1.1] mb-6">
                  About <span className="porch-em">{atty.name.split(" ")[0]}.</span>
                </h2>
                <PortableText value={atty.body} />
              </section>
            )}

            {/* Credentials */}
            {((atty.education && atty.education.length > 0) || (atty.awards && atty.awards.length > 0)) && (
              <section className="mb-12">
                <p className="porch-eyebrow mb-3">Credentials</p>
                <h2 className="font-heading text-[clamp(26px,3vw,36px)] leading-[1.1] mb-7">
                  Where he&apos;s <span className="porch-em">trained &amp; recognized.</span>
                </h2>
                <div className="grid sm:grid-cols-2 gap-5">
                  {atty.education && atty.education.length > 0 && (
                    <div className="bg-paper border border-rule rounded-[20px] p-7">
                      <h3 className="font-heading text-[20px] text-ink mb-4">Education</h3>
                      <ul className="space-y-3 list-none m-0 p-0">
                        {atty.education.map((edu: { degree: string; institution: string }, i: number) => (
                          <li key={i} className="border-b border-rule last:border-0 pb-3 last:pb-0 text-sm">
                            <b className="text-ink font-semibold block">{edu.degree}</b>
                            <span className="text-slate">{edu.institution}</span>
                          </li>
                        ))}
                      </ul>
                    </div>
                  )}
                  {atty.awards && atty.awards.length > 0 && (
                    <div className="bg-paper border border-rule rounded-[20px] p-7">
                      <h3 className="font-heading text-[20px] text-ink mb-4">Awards &amp; Recognition</h3>
                      <ul className="space-y-3 list-none m-0 p-0">
                        {atty.awards.map((aw: { name: string; year?: string }, i: number) => (
                          <li key={i} className="border-b border-rule last:border-0 pb-3 last:pb-0 text-sm flex justify-between gap-3">
                            <b className="text-ink font-semibold">{aw.name}</b>
                            {aw.year && <span className="font-mono text-[11px] text-slate shrink-0">{aw.year}</span>}
                          </li>
                        ))}
                      </ul>
                    </div>
                  )}
                </div>
              </section>
            )}

            <BottomCta />
          </div>

          <aside className="hidden lg:block">
            <div className="sticky top-[88px] space-y-5">
              <ContactForm />
              {office && (
                <div className="bg-paper border border-rule rounded-[18px] p-6">
                  <h4 className="font-mono text-[10px] tracking-[0.16em] uppercase text-terra font-bold mb-3">{office.name}</h4>
                  <address className="not-italic text-sm text-slate mb-3 leading-[1.5]">
                    {office.street}<br />{office.city}, {office.state} {office.zip}
                  </address>
                  <a href={`tel:${office.phoneRaw}`} className="text-sm font-bold text-terra hover:text-terra-deep no-underline">{office.phone}</a>
                </div>
              )}
            </div>
          </aside>
        </div>
      </div>
    </>
  );
}
