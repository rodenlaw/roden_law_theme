import type { Metadata } from "next";
import Link from "next/link";
import Image from "next/image";
import { getAllAttorneys } from "@/lib/queries/attorney";
import { getFirmData, type OfficeKey } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { BottomCta } from "@/components/sections/BottomCta";
import { PorchPlaceholder } from "@/components/porch/PorchPlaceholder";
import { urlForImage } from "@/sanity/lib/image";

export const revalidate = 3600; // Revalidate every hour

export const metadata: Metadata = {
  title: "Our Attorneys",
  description: "Meet the experienced personal injury attorneys at Roden Law. Licensed in Georgia and South Carolina.",
};

export default async function AttorneysArchivePage() {
  const firm = getFirmData();
  const attorneys = await getAllAttorneys();

  return (
    <>
      {/* ── Hero ─────────────────────────────────────────── */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-16">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Attorneys" }]} />
          <div className="max-w-[760px] mt-4">
            <p className="porch-eyebrow mb-4">The Team</p>
            <h1 className="font-heading font-normal text-ink text-[clamp(40px,6vw,72px)] leading-[1.02] tracking-[-0.02em] mb-6">
              Our <span className="porch-em">attorneys.</span>
            </h1>
            <p className="text-[18px] leading-[1.55] text-ink-2 max-w-[56ch]">
              Meet the experienced personal injury attorneys at Roden Law. Licensed in Georgia and South Carolina, our team has recovered <b className="font-bold text-ink">{firm.trustStats.recovered}</b> for injured clients across 6 office locations.
            </p>
          </div>
        </div>
      </section>

      {/* ── Attorney grid ────────────────────────────────── */}
      <section className="bg-cream">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[100px]">
          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {(attorneys ?? []).map((atty: any) => {
              const office = atty.officeKey ? firm.offices[atty.officeKey as OfficeKey] : null;
              const imgUrl = atty.headshot ? urlForImage(atty.headshot)?.width(400).height(533).url() : null;
              return (
                <Link key={atty.slug} href={`/attorneys/${atty.slug}/`} className="group block bg-paper border border-rule rounded-[20px] overflow-hidden hover:border-terra hover:-translate-y-[3px] hover:shadow-[0_16px_40px_rgba(31,45,68,0.10)] transition-all no-underline">
                  {imgUrl ? (
                    <Image src={imgUrl} alt={atty.name} width={400} height={533} className="w-full h-auto object-cover" />
                  ) : (
                    <PorchPlaceholder label={`${atty.name} · 3:4`} variant="warm" className="aspect-[3/4]" />
                  )}
                  <div className="p-5">
                    <h3 className="font-heading text-[19px] text-ink leading-[1.2] group-hover:text-terra transition-colors">{atty.name}</h3>
                    {atty.jobTitle && <p className="text-sm text-slate mt-1">{atty.jobTitle}</p>}
                    {office && <p className="font-mono text-[10px] tracking-[0.1em] uppercase text-slate mt-2">{office.marketName}, {office.state}</p>}
                  </div>
                </Link>
              );
            })}
          </div>
        </div>
      </section>

      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px]">
        <BottomCta heading="Schedule a Free Consultation" />
      </div>
    </>
  );
}
