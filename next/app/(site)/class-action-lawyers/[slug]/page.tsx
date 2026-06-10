import { notFound } from "next/navigation";
import Link from "next/link";
import type { Metadata } from "next";
import { getClassActionBySlug, getAllClassActionSlugs } from "@/lib/queries/shared";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";
import { InlineCta } from "@/components/sections/InlineCta";
import { FaqAccordion } from "@/components/sections/FaqAccordion";
import { StatuteOfLimitations } from "@/components/sections/StatuteOfLimitations";
import { PortableText } from "@/components/shared/PortableText";
import { JsonLd } from "@/components/shared/JsonLd";
import { articleSchema, faqPageSchema, breadcrumbSchema } from "@/lib/schema";

interface Props {
  params: Promise<{ slug: string }>;
}

export async function generateStaticParams() {
  const slugs = await getAllClassActionSlugs();
  return slugs.map((slug) => ({ slug }));
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { slug } = await params;
  const ca = await getClassActionBySlug(slug);
  if (!ca) return {};
  return {
    title: `${ca.title} Lawsuit Lawyers`,
    description: ca.seoMetaDescription || ca.summary?.slice(0, 160),
  };
}

export default async function ClassActionDetailPage({ params }: Props) {
  const { slug } = await params;
  const ca = await getClassActionBySlug(slug);
  if (!ca) notFound();

  const path = `/class-action-lawyers/${slug}/`;
  const schemas = [
    articleSchema({ ...ca, slug }, path),
    faqPageSchema(ca.faqs),
    breadcrumbSchema([
      { name: "Home", url: "/" },
      { name: "Class Action Lawyers", url: "/class-action-lawyers/" },
      { name: ca.title, url: path },
    ]),
  ].filter(Boolean) as Record<string, unknown>[];

  return (
    <>
      <JsonLd data={schemas} />

      {/* ── Masthead ─────────────────────────────────────── */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-12">
          <Breadcrumbs
            items={[
              { label: "Home", href: "/" },
              { label: "Class Actions", href: "/class-action-lawyers/" },
              { label: ca.shortLabel || ca.title },
            ]}
          />
          <div className="max-w-[920px] mt-4">
            <p className="porch-eyebrow mb-7">Mass Tort &amp; Class Action</p>
            <h1 className="font-heading font-normal text-ink text-[clamp(34px,6vw,72px)] leading-[1.02] tracking-[-0.025em] mb-6 text-balance">
              {ca.title}
            </h1>
            {ca.summary && <p className="text-[18px] leading-[1.55] text-ink-2 max-w-[60ch]">{ca.summary}</p>}
          </div>
        </div>
      </section>

      {/* ── Content + Sidebar ────────────────────────────── */}
      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[72px]">
        <div className="grid lg:grid-cols-[1fr_340px] gap-12 lg:gap-[64px]">
          <article className="min-w-0">
            {ca.keyTakeaways && (
              <section className="relative bg-paper border border-rule rounded-[20px] px-8 py-7 mb-10">
                <span className="absolute -top-3 left-7 bg-ink text-cream px-3.5 py-1 rounded-full font-mono text-[10px] tracking-[0.18em] font-bold">
                  KEY TAKEAWAYS
                </span>
                <p className="font-heading text-[19px] leading-[1.55] text-ink m-0">{ca.keyTakeaways}</p>
              </section>
            )}

            {ca.body && <PortableText value={ca.body} />}

            <InlineCta />

            {ca.faqs && ca.faqs.length > 0 && <FaqAccordion faqs={ca.faqs} />}

            <div className="mt-12 pt-8 border-t border-rule">
              <Link
                href="/class-action-lawyers/"
                className="text-terra font-semibold text-sm inline-flex items-center gap-2 no-underline hover:text-terra-deep"
              >
                <span aria-hidden="true">&larr;</span> All mass torts &amp; class actions
              </Link>
            </div>
          </article>

          <aside className="hidden lg:block">
            <div className="sticky top-[88px] space-y-6">
              <ContactForm />
              <StatuteOfLimitations
                solGa="Varies by case type"
                solSc="Varies by case type"
                jurisdiction="both"
                compact
              />
            </div>
          </aside>
        </div>
      </div>
    </>
  );
}
