import { notFound } from "next/navigation";
import type { Metadata } from "next";
import Link from "next/link";
import { getCaseResultBySlug, getAllCaseResultSlugs, getCaseResults } from "@/lib/queries/shared";
import { getFirmData } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";
import { BottomCta } from "@/components/sections/BottomCta";
import { PortableText } from "@/components/shared/PortableText";
import { JsonLd } from "@/components/shared/JsonLd";
import { breadcrumbSchema } from "@/lib/schema";

export const revalidate = 3600;

interface Props {
  params: Promise<{ slug: string }>;
}

export async function generateStaticParams() {
  const slugs = await getAllCaseResultSlugs();
  return slugs.map((slug) => ({ slug }));
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { slug } = await params;
  const cr = await getCaseResultBySlug(slug);
  if (!cr) return {};
  const amount = cr.amount ? `${cr.amount} ` : "";
  return {
    title: `${amount}${cr.resultType || "Case Result"} — ${cr.title}`,
    description:
      cr.description?.slice(0, 160) ||
      `${amount}${cr.resultType || "result"} recovered by Roden Law for an injured client in Georgia or South Carolina.`,
  };
}

export default async function CaseResultPage({ params }: Props) {
  const { slug } = await params;
  const cr = await getCaseResultBySlug(slug);
  if (!cr) notFound();

  const firm = getFirmData();
  const related = ((await getCaseResults(7)) ?? []).filter((r: { slug: string }) => r.slug !== slug).slice(0, 6);

  const schemas = [
    breadcrumbSchema([
      { name: "Home", url: "/" },
      { name: "Case Results", url: "/case-results/" },
      { name: cr.title, url: `/case-results/${slug}/` },
    ]),
  ];

  return (
    <>
      <JsonLd data={schemas} />
      {/* ── Hero ─────────────────────────────────────────── */}
      <section className="bg-ink text-cream">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-16">
          <Breadcrumbs
            items={[
              { label: "Home", href: "/" },
              { label: "Case Results", href: "/case-results/" },
              { label: cr.title },
            ]}
          />
          <div className="mt-6">
            {cr.resultType && (
              <span className="porch-eyebrow text-honey">{cr.resultType}</span>
            )}
            {cr.amount && <p className="font-heading font-medium text-[clamp(48px,8vw,80px)] leading-none text-cream my-3">{cr.amount}</p>}
            <h1 className="font-heading text-[clamp(22px,3vw,34px)] text-cream leading-[1.15]">{cr.title}</h1>
          </div>
        </div>
      </section>

      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[72px]">
        <div className="grid lg:grid-cols-[1fr_340px] gap-12 lg:gap-[64px]">
          <article className="min-w-0">
            {/* Case facts */}
            {(cr.accidentType || cr.injuryType || cr.initialOffer) && (
              <section className="mb-10 grid sm:grid-cols-3 gap-4">
                {cr.accidentType && (
                  <div className="bg-paper rounded-[16px] p-5 border border-rule">
                    <span className="block font-mono text-[10px] uppercase tracking-[0.12em] text-slate">Accident Type</span>
                    <p className="text-ink font-semibold text-sm mt-1.5">{cr.accidentType}</p>
                  </div>
                )}
                {cr.injuryType && (
                  <div className="bg-paper rounded-[16px] p-5 border border-rule">
                    <span className="block font-mono text-[10px] uppercase tracking-[0.12em] text-slate">Injury</span>
                    <p className="text-ink font-semibold text-sm mt-1.5">{cr.injuryType}</p>
                  </div>
                )}
                {cr.initialOffer && (
                  <div className="bg-paper rounded-[16px] p-5 border border-rule">
                    <span className="block font-mono text-[10px] uppercase tracking-[0.12em] text-slate">Initial Offer</span>
                    <p className="text-ink font-semibold text-sm mt-1.5">{cr.initialOffer}</p>
                  </div>
                )}
              </section>
            )}

            {cr.description && <p className="font-heading text-[20px] leading-[1.5] text-ink-2 mb-7">{cr.description}</p>}
            {cr.body && <PortableText value={cr.body} />}

            {cr.leadAttorney?.name && (
              <p className="mt-7 text-sm text-slate">
                Handled by{" "}
                <Link href={`/attorneys/${cr.leadAttorney.slug}/`} className="text-terra font-semibold hover:text-terra-deep no-underline">
                  {cr.leadAttorney.name}
                </Link>
                {cr.leadAttorney.jobTitle ? `, ${cr.leadAttorney.jobTitle}` : ""}.
              </p>
            )}

            {/* Related results */}
            {related.length > 0 && (
              <section className="mt-12">
                <h2 className="font-heading text-[clamp(24px,3vw,32px)] leading-[1.1] mb-6">More <span className="porch-em">results.</span></h2>
                <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                  {related.map((r: { _id: string; slug: string; title: string; amount?: string; resultType?: string }) => (
                    <Link
                      key={r._id}
                      href={`/case-results/${r.slug}/`}
                      className="block bg-paper border border-rule rounded-[20px] p-6 hover:border-terra hover:-translate-y-[3px] hover:shadow-[0_16px_40px_rgba(31,45,68,0.10)] transition-all no-underline"
                    >
                      {r.resultType && <span className="font-mono text-[10px] uppercase tracking-[0.12em] text-slate">{r.resultType}</span>}
                      <p className="font-heading text-[26px] font-medium text-ink my-1.5 leading-none">{r.amount}</p>
                      <h3 className="font-heading text-[15px] text-ink leading-[1.25]">{r.title}</h3>
                    </Link>
                  ))}
                </div>
              </section>
            )}

            {/* Disclaimer */}
            <p className="mt-12 text-xs text-slate border-t border-rule pt-5 leading-[1.55]">
              Prior results do not guarantee a similar outcome. Each case is different and must be evaluated on its own
              facts. The amounts shown reflect gross recovery before fees and expenses.
            </p>

            <BottomCta />
          </article>

          <aside className="hidden lg:block">
            <div className="sticky top-[88px] space-y-5">
              <ContactForm />
              <div className="bg-paper rounded-[18px] p-6 border border-rule">
                <h4 className="font-mono text-[10px] tracking-[0.16em] uppercase text-terra font-bold mb-3">Free Case Review</h4>
                <p className="text-sm text-slate mb-3 leading-[1.5]">No fees unless we win.</p>
                <a href={`tel:${firm.phoneE164}`} className="block text-sm font-bold text-terra hover:text-terra-deep no-underline">
                  {firm.phone}
                </a>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </>
  );
}
