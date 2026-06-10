import type { Metadata } from "next";
import Link from "next/link";
import { getAllResources, type ResourceListItem } from "@/lib/queries/shared";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { JsonLd } from "@/components/shared/JsonLd";
import { breadcrumbSchema } from "@/lib/schema";

export const revalidate = 3600;
export const metadata: Metadata = {
  title: "Resources",
  description:
    "Local injury-law guides from Roden Law — truck corridors, dangerous roads, and accident rights across Georgia and South Carolina, written by our attorneys.",
};

const JURISDICTION_LABEL: Record<string, string> = {
  both: "GA & SC",
  GA: "Georgia",
  SC: "South Carolina",
};

// React renders text literally, so decode the handful of HTML entities that
// rode in from the WordPress export.
function decode(s: string): string {
  return s
    .replace(/&amp;/g, "&")
    .replace(/&#0?39;|&rsquo;|&#8217;/g, "’")
    .replace(/&quot;/g, '"')
    .replace(/&ndash;/g, "–")
    .replace(/&mdash;/g, "—");
}

export default async function ResourcesPage() {
  const resources = await getAllResources();

  const schemas = [
    breadcrumbSchema([
      { name: "Home", url: "/" },
      { name: "Resources", url: "/resources/" },
    ]),
    {
      "@context": "https://schema.org",
      "@type": "CollectionPage",
      name: "Resources",
      url: "https://rodenlaw.com/resources/",
      hasPart: resources.map((r) => ({
        "@type": "Article",
        headline: decode(r.title),
        url: `https://rodenlaw.com/resources/${r.slug}/`,
      })),
    },
  ].filter(Boolean) as Record<string, unknown>[];

  return (
    <>
      <JsonLd data={schemas} />

      {/* ── Masthead ─────────────────────────────────────── */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-14">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Resources" }]} />
          <div className="max-w-[820px] mt-4">
            <p className="porch-eyebrow mb-4">Roden Law Resource Library</p>
            <h1 className="font-heading font-normal text-ink text-[clamp(44px,7vw,92px)] leading-[1.0] tracking-[-0.02em] mb-6">
              Local injury <span className="porch-em">resources.</span>
            </h1>
            <p className="font-heading text-[clamp(18px,2.2vw,22px)] leading-[1.45] text-ink-2 max-w-[60ch]">
              Plain-English guides to the roads, corridors, and intersections where crashes actually
              happen across <b className="font-semibold text-ink">Georgia and South Carolina</b> — plus
              what to do, and what your claim is worth, when one happens to you.
            </p>
          </div>
        </div>
      </section>

      {/* ── Resource grid ────────────────────────────────── */}
      <section className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-14">
        <div className="flex items-end justify-between mb-9">
          <h2 className="font-heading text-[clamp(28px,4vw,42px)] leading-[1.05] tracking-[-0.02em]">
            Browse the <span className="porch-em">library.</span>
          </h2>
          <div className="font-mono text-[12px] tracking-[0.1em] uppercase text-slate hidden sm:block">
            <b className="text-ink font-bold">{resources.length}</b> guides
          </div>
        </div>

        {resources.length > 0 ? (
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-x-7 gap-y-9">
            {resources.map((r: ResourceListItem) => (
              <Link
                key={r._id}
                href={`/resources/${r.slug}/`}
                className="group flex flex-col bg-paper border border-rule rounded-[20px] p-7 no-underline hover:-translate-y-[3px] hover:shadow-[0_16px_40px_rgba(31,45,68,0.10)] transition-all"
              >
                {r.jurisdiction && (
                  <span className="self-start mb-4 bg-cream text-ink px-3 py-1.5 rounded-full text-[10px] font-extrabold tracking-[0.12em] uppercase border border-rule">
                    {JURISDICTION_LABEL[r.jurisdiction] ?? r.jurisdiction}
                  </span>
                )}
                <h3 className="font-heading font-medium text-[23px] leading-[1.18] tracking-[-0.01em] mb-3 text-ink group-hover:text-terra transition-colors">
                  {decode(r.title)}
                </h3>
                {r.summary && (
                  <p className="text-sm leading-[1.55] text-slate mb-5 line-clamp-3">{decode(r.summary)}</p>
                )}
                <div className="mt-auto flex items-center gap-2.5 pt-4 border-t border-rule text-xs">
                  {r.author ? (
                    <>
                      <span className="w-6 h-6 rounded-full bg-cream border border-rule shrink-0" aria-hidden="true" />
                      <span className="font-bold text-ink">{r.author.name}</span>
                    </>
                  ) : (
                    <span className="text-slate">Roden Law</span>
                  )}
                  <span className="ml-auto text-terra font-bold inline-flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                    Read &rarr;
                  </span>
                </div>
              </Link>
            ))}
          </div>
        ) : (
          <p className="text-slate text-center py-16">Resources coming soon. Check back shortly.</p>
        )}
      </section>
    </>
  );
}
