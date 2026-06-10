import type { Metadata } from "next";
import { getFirmData } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";

export const metadata: Metadata = {
  title: "Contact Roden Law",
  description: "Contact Roden Law for a free case review. 6 offices across Georgia and South Carolina. No fees unless we win.",
};

export default function ContactPage() {
  const firm = getFirmData();

  return (
    <>
      {/* ── Hero ─────────────────────────────────────────── */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-16">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Contact" }]} />
          <div className="max-w-[760px] mt-4">
            <p className="porch-eyebrow mb-4">Get In Touch</p>
            <h1 className="font-heading font-normal text-ink text-[clamp(40px,6vw,72px)] leading-[1.02] tracking-[-0.02em] mb-6">
              Contact <span className="porch-em">Roden Law.</span>
            </h1>
            <p className="text-[18px] leading-[1.55] text-ink-2">Injured? Get your free case review today. No fees unless we win.</p>
          </div>
        </div>
      </section>

      {/* ── Form + Info ──────────────────────────────────── */}
      <section className="bg-cream">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[100px]">
          <div className="grid md:grid-cols-2 gap-10 lg:gap-16">
            {/* Form */}
            <ContactForm />

            {/* Info */}
            <div>
              <div className="bg-ink text-cream rounded-[20px] p-8 mb-6 text-center">
                <span className="block font-mono text-[10px] tracking-[0.16em] uppercase text-honey mb-2">Call Us 24/7</span>
                <a href={`tel:${firm.phoneRaw}`} className="block font-heading text-[34px] font-medium text-cream hover:text-honey no-underline mb-1.5">
                  {firm.vanityPhone}
                </a>
                <span className="text-sm text-cream/65">Free Consultation &bull; No Fees Unless We Win</span>
              </div>

              <h2 className="font-heading text-[26px] leading-[1.15] mb-3">Schedule a free <span className="porch-em">consultation.</span></h2>
              <p className="text-slate leading-[1.6] mb-6">
                The moments following a personal injury can be overwhelming and uncertain. Our accomplished attorneys can guide you through the complex aftermath of an accident and help you obtain the justice you need to move on with your life.
              </p>

              <div className="grid grid-cols-3 gap-4 text-center bg-paper border border-rule rounded-[20px] p-6">
                <div><span className="block font-heading text-[26px] font-medium text-ink leading-none">{firm.trustStats.recovered}</span><span className="font-mono text-[10px] tracking-[0.08em] uppercase text-slate mt-1.5 block">Recovered</span></div>
                <div><span className="block font-heading text-[26px] font-medium text-ink leading-none">{firm.trustStats.rating}&#9733;</span><span className="font-mono text-[10px] tracking-[0.08em] uppercase text-slate mt-1.5 block">Rating</span></div>
                <div><span className="block font-heading text-[26px] font-medium text-ink leading-none">{firm.trustStats.cases}</span><span className="font-mono text-[10px] tracking-[0.08em] uppercase text-slate mt-1.5 block">Cases</span></div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* ── Office Grid ──────────────────────────────────── */}
      <section className="bg-paper border-t border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[100px]">
          <div className="text-center max-w-[640px] mx-auto mb-12">
            <p className="porch-eyebrow mb-4">Visit Us</p>
            <h2 className="font-heading text-[clamp(28px,3.5vw,42px)] leading-[1.1]">Our <span className="porch-em">offices.</span></h2>
          </div>
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            {Object.values(firm.offices).map((office) => (
              <div key={office.slug} className="bg-cream rounded-[20px] p-6 border border-rule hover:-translate-y-[3px] hover:shadow-[0_16px_40px_rgba(31,45,68,0.10)] transition-all">
                <h3 className="font-heading text-[19px] text-ink mb-2.5">{office.marketName}, {office.state}</h3>
                <address className="not-italic text-sm text-slate mb-3 leading-[1.5]">
                  {office.street}<br />{office.city}, {office.state} {office.zip}
                </address>
                <a href={`tel:${office.phoneRaw}`} className="block text-sm font-bold text-terra hover:text-terra-deep no-underline mb-2">{office.phone}</a>
                <a href={office.mapUrl} target="_blank" rel="noopener noreferrer nofollow" className="text-xs font-semibold text-ink hover:text-terra no-underline">Get Directions &rarr;</a>
              </div>
            ))}
          </div>
        </div>
      </section>
    </>
  );
}
