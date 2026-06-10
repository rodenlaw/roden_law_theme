import { notFound } from "next/navigation";
import type { Metadata } from "next";
import { getResourceBySlug, getAllResourceSlugs } from "@/lib/queries/shared";
import { getFirmData } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";
import { InlineCta } from "@/components/sections/InlineCta";
import { FaqAccordion } from "@/components/sections/FaqAccordion";
import { AuthorAttribution } from "@/components/sections/AuthorAttribution";
import { StatuteOfLimitations } from "@/components/sections/StatuteOfLimitations";
import { PortableText } from "@/components/shared/PortableText";
import { JsonLd } from "@/components/shared/JsonLd";
import { articleSchema, faqPageSchema, breadcrumbSchema } from "@/lib/schema";
import { urlForImage } from "@/sanity/lib/image";

interface Props {
  params: Promise<{ slug: string }>;
}

// React renders text literally; decode the few HTML entities from the WP export.
function decode(s: string): string {
  return s
    .replace(/&amp;/g, "&")
    .replace(/&#0?39;|&rsquo;|&#8217;/g, "’")
    .replace(/&quot;/g, '"')
    .replace(/&ldquo;|&#8220;/g, "“")
    .replace(/&rdquo;|&#8221;/g, "”")
    .replace(/&ndash;|&#8211;/g, "–")
    .replace(/&mdash;|&#8212;/g, "—")
    .replace(/&sect;/g, "§")
    .replace(/&deg;/g, "°")
    .replace(/&nbsp;/g, " ");
}

// keyTakeaways is a plain-text field but some WP exports carry inline markup;
// strip any tags + decode entities so it never renders raw <strong>/&sect;.
function cleanText(s?: string | null): string {
  if (!s) return "";
  return decode(s.replace(/<[^>]+>/g, "")).replace(/\s+/g, " ").trim();
}

// Minimal Portable Text renderer for the Key Takeaways box — preserves the
// bold/italic emphasis without pulling in the full prose PortableText styling.
function RichTakeaways({ blocks }: { blocks: PTBlock[] }) {
  return (
    <div className="font-heading text-[19px] leading-[1.55] text-ink space-y-3">
      {blocks.map((b, bi) => (
        <p key={b._key ?? bi} className="m-0">
          {(b.children ?? []).map((span, si) => {
            const marks = span.marks ?? [];
            if (marks.includes("strong")) return <strong key={si} className="font-bold text-ink">{span.text}</strong>;
            if (marks.includes("em")) return <em key={si}>{span.text}</em>;
            return <span key={si}>{span.text}</span>;
          })}
        </p>
      ))}
    </div>
  );
}
interface PTSpan { _key?: string; text: string; marks?: string[] }
interface PTBlock { _key?: string; children?: PTSpan[] }

export async function generateStaticParams() {
  const slugs = await getAllResourceSlugs();
  return slugs.map((slug) => ({ slug }));
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { slug } = await params;
  const res = await getResourceBySlug(slug);
  if (!res) return {};
  return {
    title: decode(res.title),
    description: res.seoMetaDescription || cleanText(res.keyTakeaways).slice(0, 160),
  };
}

export default async function ResourcePage({ params }: Props) {
  const { slug } = await params;
  const res = await getResourceBySlug(slug);
  if (!res) notFound();

  const firm = getFirmData();
  const author = res.authorAttorney;
  const title = decode(res.title);

  const path = `/resources/${slug}/`;
  const schemas = [
    articleSchema({ ...res, slug, title }, path),
    faqPageSchema(res.faqs),
    breadcrumbSchema([
      { name: "Home", url: "/" },
      { name: "Resources", url: "/resources/" },
      { name: title, url: path },
    ]),
  ].filter(Boolean) as Record<string, unknown>[];

  return (
    <>
      <JsonLd data={schemas} />

      {/* ── Masthead ─────────────────────────────────────── */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-12">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Resources", href: "/resources/" }, { label: title }]} />
          <div className="max-w-[920px] mx-auto mt-4">
            <p className="porch-eyebrow mb-7">Resource</p>
            <h1 className="font-heading font-normal text-ink text-[clamp(34px,6vw,76px)] leading-[1.0] tracking-[-0.025em] mb-7 text-balance">
              {title}
            </h1>
            {author && (
              <div className="flex items-center gap-3.5 pt-7 border-t border-rule">
                {author.headshot ? (
                  <img
                    src={urlForImage(author.headshot)?.width(104).height(104).url() ?? ""}
                    alt={author.name}
                    className="w-[52px] h-[52px] rounded-full object-cover border border-rule"
                  />
                ) : (
                  <span className="w-[52px] h-[52px] rounded-full bg-cream border border-rule shrink-0" aria-hidden="true" />
                )}
                <div>
                  <span className="block font-heading text-[19px] text-ink">{author.name}</span>
                  {author.jobTitle && <span className="block text-xs text-slate mt-0.5">{author.jobTitle}</span>}
                </div>
              </div>
            )}
          </div>
        </div>
      </section>

      {/* ── Content + Sidebar ────────────────────────────── */}
      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[72px]">
        <div className="grid lg:grid-cols-[1fr_340px] gap-12 lg:gap-[64px]">
          <article className="min-w-0">
            {/* Key Takeaways */}
            {(res.keyTakeawaysRich?.length || res.keyTakeaways) && (
              <section className="relative bg-paper border border-rule rounded-[20px] px-8 py-7 mb-10">
                <span className="absolute -top-3 left-7 bg-ink text-cream px-3.5 py-1 rounded-full font-mono text-[10px] tracking-[0.18em] font-bold">
                  KEY TAKEAWAYS
                </span>
                {res.keyTakeawaysRich?.length ? (
                  <RichTakeaways blocks={res.keyTakeawaysRich} />
                ) : (
                  <p className="font-heading text-[19px] leading-[1.55] text-ink m-0">{cleanText(res.keyTakeaways)}</p>
                )}
              </section>
            )}

            {/* Body */}
            {res.body && <PortableText value={res.body} />}

            <InlineCta />

            {/* FAQs */}
            {res.faqs && res.faqs.length > 0 && <FaqAccordion faqs={res.faqs} />}

            {/* Author */}
            {author && (
              <AuthorAttribution
                name={author.name}
                slug={author.slug}
                jobTitle={author.jobTitle}
                barAdmissions={author.barAdmissions}
                headshotUrl={author.headshot ? urlForImage(author.headshot)?.width(240).url() ?? undefined : undefined}
              />
            )}
          </article>

          <aside className="hidden lg:block">
            <div className="sticky top-[88px] space-y-6">
              <ContactForm />
              <StatuteOfLimitations
                solGa="2 years (O.C.G.A. § 9-3-33)"
                solSc="3 years (S.C. Code § 15-3-530)"
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
