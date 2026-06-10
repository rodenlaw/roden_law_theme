import type { Metadata } from "next";
import { getFirmData } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { BottomCta } from "@/components/sections/BottomCta";

export const metadata: Metadata = {
  title: "About Roden Law",
  description: "Personal injury attorneys fighting for maximum compensation across Georgia and South Carolina since 2013. $250M+ recovered.",
};

export default function AboutPage() {
  const firm = getFirmData();

  return (
    <>
      {/* ── Hero ─────────────────────────────────────────── */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-16">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "About" }]} />
          <div className="max-w-[760px] mt-4">
            <p className="porch-eyebrow mb-4">Our Firm</p>
            <h1 className="font-heading font-normal text-ink text-[clamp(40px,6vw,72px)] leading-[1.02] tracking-[-0.02em] mb-6">
              About <span className="porch-em">Roden Law.</span>
            </h1>
            <p className="text-[18px] leading-[1.55] text-ink-2 max-w-[56ch]">
              Personal injury attorneys fighting for maximum compensation across Georgia and South Carolina since 2013.
            </p>
          </div>
        </div>
      </section>

      {/* ── Founder Story ────────────────────────────────── */}
      <section className="bg-cream">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[100px]">
          <div className="grid md:grid-cols-2 gap-12 lg:gap-16 items-start">
            <div>
              <h2 className="font-heading text-[clamp(28px,3.5vw,42px)] leading-[1.1] mb-6">Our <span className="porch-em">story.</span></h2>
              <p className="text-slate leading-[1.65] mb-5">
                Roden Law was founded in 2013 by Eric L. Roden and Tyler M. Love with a singular mission: fighting for injury victims. We built our firm on the principle that every person harmed by another&apos;s negligence deserves aggressive, personal representation — not the assembly-line treatment you get at larger firms.
              </p>
              <p className="text-slate leading-[1.65] mb-6">
                We understand that serious injuries create emotional, physical, and financial hardship. That&apos;s why our attorneys personally handle every case — you&apos;ll always speak directly with a lawyer who knows your story and is invested in your outcome.
              </p>
              <blockquote className="border-l-[3px] border-terra bg-paper px-6 py-5 rounded-r-[16px] my-6">
                <p className="font-heading text-[19px] leading-[1.5] text-ink italic mb-3">
                  &ldquo;I started Roden Law because I saw too many injury victims get lowballed by insurance companies. Our team fights for every dollar you deserve — and we don&apos;t get paid unless you do.&rdquo;
                </p>
                <cite className="font-mono text-[11px] tracking-[0.06em] uppercase text-slate not-italic">— Eric Roden, Founding Partner</cite>
              </blockquote>
            </div>
            <div className="bg-paper border border-rule rounded-[20px] p-8 lg:p-10">
              <h3 className="font-heading text-[24px] mb-6">Our commitment</h3>
              <ul className="space-y-4 text-ink-2 list-none m-0 p-0">
                <li className="flex gap-4 items-baseline"><span className="font-mono text-terra font-bold text-sm shrink-0">01</span> Personal attention on every case</li>
                <li className="flex gap-4 items-baseline"><span className="font-mono text-terra font-bold text-sm shrink-0">02</span> No fees unless we win</li>
                <li className="flex gap-4 items-baseline"><span className="font-mono text-terra font-bold text-sm shrink-0">03</span> Licensed in Georgia &amp; South Carolina</li>
                <li className="flex gap-4 items-baseline"><span className="font-mono text-terra font-bold text-sm shrink-0">04</span> {firm.trustStats.recovered} recovered for clients</li>
                <li className="flex gap-4 items-baseline"><span className="font-mono text-terra font-bold text-sm shrink-0">05</span> {firm.trustStats.reviews} five-star reviews</li>
                <li className="flex gap-4 items-baseline"><span className="font-mono text-terra font-bold text-sm shrink-0">06</span> 6 office locations</li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      {/* ── Stats ────────────────────────────────────────── */}
      <section className="bg-ink text-cream">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-16">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div><span className="block font-heading text-[40px] font-medium text-cream leading-none">{firm.trustStats.recovered}</span><span className="font-mono text-[10px] tracking-[0.1em] uppercase text-cream/60 mt-2.5 block">Recovered</span></div>
            <div><span className="block font-heading text-[40px] font-medium text-cream leading-none">{firm.trustStats.cases}</span><span className="font-mono text-[10px] tracking-[0.1em] uppercase text-cream/60 mt-2.5 block">Cases Handled</span></div>
            <div><span className="block font-heading text-[40px] font-medium text-cream leading-none">{firm.trustStats.rating}&#9733;</span><span className="font-mono text-[10px] tracking-[0.1em] uppercase text-cream/60 mt-2.5 block">Client Rating</span></div>
            <div><span className="block font-heading text-[40px] font-medium text-cream leading-none">{firm.experience}</span><span className="font-mono text-[10px] tracking-[0.1em] uppercase text-cream/60 mt-2.5 block">Combined Experience</span></div>
          </div>
        </div>
      </section>

      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[100px]">
        <BottomCta heading="Schedule a Free Consultation" />
      </div>
    </>
  );
}
