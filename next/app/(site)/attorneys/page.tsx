import type { Metadata } from "next";
import Link from "next/link";
import Image from "next/image";
import { getAllAttorneys } from "@/lib/queries/attorney";
import { getFirmData, type OfficeKey } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { BottomCta } from "@/components/sections/BottomCta";
import { urlForImage } from "@/sanity/lib/image";

export const metadata: Metadata = {
  title: "Our Attorneys",
  description: "Meet the experienced personal injury attorneys at Roden Law. Licensed in Georgia and South Carolina.",
};

export default async function AttorneysArchivePage() {
  const firm = getFirmData();
  const attorneys = await getAllAttorneys();

  return (
    <>
      <section className="bg-navy text-white py-12">
        <div className="mx-auto max-w-[1200px] px-6">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Attorneys" }]} />
          <h1 className="font-heading text-3xl md:text-4xl font-black mt-4 mb-3">Our Attorneys</h1>
          <p className="text-lg text-gray-300 max-w-2xl">
            Meet the experienced personal injury attorneys at Roden Law. Licensed in Georgia and South Carolina, our team has recovered <strong>{firm.trustStats.recovered}</strong> for injured clients across 6 office locations.
          </p>
        </div>
      </section>

      <section className="mx-auto max-w-[1200px] px-6 py-12">
        <h2 className="font-heading text-2xl font-bold text-navy mb-6">Meet the Team</h2>
        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {(attorneys ?? []).map((atty: any) => {
            const office = atty.officeKey ? firm.offices[atty.officeKey as OfficeKey] : null;
            const imgUrl = atty.headshot ? urlForImage(atty.headshot)?.width(400).height(533).url() : null;
            return (
              <Link key={atty.slug} href={`/attorneys/${atty.slug}/`} className="group block bg-white border border-border rounded-lg overflow-hidden hover:shadow-md transition-shadow no-underline">
                {imgUrl && (
                  <Image src={imgUrl} alt={atty.name} width={400} height={533} className="w-full h-auto object-cover" />
                )}
                <div className="p-4">
                  <h3 className="font-heading font-bold text-navy text-base group-hover:text-orange-text">{atty.name}</h3>
                  {atty.jobTitle && <p className="text-sm text-gray-600">{atty.jobTitle}</p>}
                  {office && <p className="text-xs text-gray-500">{office.marketName}, {office.state}</p>}
                </div>
              </Link>
            );
          })}
        </div>
      </section>

      <div className="mx-auto max-w-[1200px] px-6">
        <BottomCta heading="Schedule a Free Consultation" />
      </div>
    </>
  );
}
