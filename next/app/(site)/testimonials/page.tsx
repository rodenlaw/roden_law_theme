import type { Metadata } from "next";
import { getTestimonials } from "@/lib/queries/shared";
import { getFirmData } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { BottomCta } from "@/components/sections/BottomCta";
import { PortableText } from "@/components/shared/PortableText";

function formatReviewDate(iso?: string | null): string | null {
  if (!iso) return null;
  const d = new Date(iso);
  if (Number.isNaN(d.getTime())) return null;
  return d.toLocaleDateString("en-US", { month: "short", year: "numeric" });
}

export const revalidate = 3600;
export const metadata: Metadata = {
  title: "Testimonials",
  description: "Read what our clients say about Roden Law. 500+ five-star reviews across Georgia and South Carolina.",
};

export default async function TestimonialsPage() {
  const firm = getFirmData();
  const testimonials = await getTestimonials();

  return (
    <>
      {/* ── Hero ─────────────────────────────────────────── */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-16">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Testimonials" }]} />
          <div className="max-w-[760px] mt-4">
            <p className="porch-eyebrow mb-4">In Their Words</p>
            <h1 className="font-heading font-normal text-ink text-[clamp(40px,6vw,72px)] leading-[1.02] tracking-[-0.02em] mb-6">
              Client <span className="porch-em">testimonials.</span>
            </h1>
            <p className="text-[18px] leading-[1.55] text-ink-2 max-w-[56ch]">
              {firm.trustStats.reviews} five-star reviews from clients across Georgia and South Carolina.
            </p>
          </div>
        </div>
      </section>

      {/* ── Testimonial grid ─────────────────────────────── */}
      <section className="bg-cream">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[100px]">
          {testimonials && testimonials.length > 0 ? (
            <div className="grid md:grid-cols-2 gap-6">
              {testimonials.map((t: any) => (
                <div key={t._id} className="bg-paper border border-rule rounded-[20px] p-8 hover:-translate-y-[3px] hover:shadow-[0_16px_40px_rgba(31,45,68,0.10)] transition-all flex flex-col">
                  <div className="flex items-center gap-1 mb-4">
                    {Array.from({ length: t.rating || 5 }).map((_, i) => (
                      <span key={i} className="text-honey-deep text-lg">&#9733;</span>
                    ))}
                  </div>
                  {t.reviewBody ? (
                    <div className="font-heading text-[18px] leading-[1.55] text-ink mb-5 flex-1">
                      <PortableText value={t.reviewBody} />
                    </div>
                  ) : t.excerpt ? (
                    <p className="font-heading text-[18px] leading-[1.55] text-ink mb-5 flex-1">&ldquo;{t.excerpt}&rdquo;</p>
                  ) : null}
                  <footer className="border-t border-rule pt-4 mt-auto">
                    <p className="font-mono text-[11px] tracking-[0.1em] uppercase text-slate">&mdash; {t.clientName}</p>
                    {(t.caseType || t.city) && (
                      <p className="text-xs text-slate mt-1">{[t.caseType, t.city].filter(Boolean).join(" · ")}</p>
                    )}
                    <p className="text-xs text-slate mt-1 flex items-center gap-1.5">
                      <span>{formatReviewDate(t.dateOf) ? `${formatReviewDate(t.dateOf)} · ` : ""}via {t.source === "google" ? "Google" : "Verified Client"}</span>
                      {t.sourceUrl && (
                        <a href={t.sourceUrl} target="_blank" rel="noopener noreferrer nofollow" className="underline hover:text-terra">
                          View on Google
                        </a>
                      )}
                    </p>
                  </footer>
                </div>
              ))}
            </div>
          ) : (
            <p className="text-slate text-center py-10">
              Testimonials coming soon. In the meantime, check our{" "}
              <a href="https://www.google.com/search?q=Roden+Law+reviews" target="_blank" rel="noopener noreferrer" className="text-terra font-semibold hover:text-terra-deep no-underline">
                Google Reviews
              </a>.
            </p>
          )}
        </div>
      </section>

      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px]">
        <BottomCta heading="Injured? Get Your Free Case Review Today." />
      </div>
    </>
  );
}
