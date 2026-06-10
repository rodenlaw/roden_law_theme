import { notFound } from "next/navigation";
import type { Metadata } from "next";
import Link from "next/link";
import { client } from "@/sanity/lib/client";
import { getFirmData, type OfficeKey } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { BottomCta } from "@/components/sections/BottomCta";
import { JsonLd } from "@/components/shared/JsonLd";
import { breadcrumbSchema } from "@/lib/schema";

export const revalidate = 3600;

const STATES: Record<string, string> = { georgia: "Georgia", "south-carolina": "South Carolina" };

interface Props {
  params: Promise<{ state: string }>;
}

export function generateStaticParams() {
  return Object.keys(STATES).map((state) => ({ state }));
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { state } = await params;
  const name = STATES[state];
  if (!name) return {};
  return {
    title: `${name} Personal Injury Lawyers — Office Locations`,
    description: `Roden Law's ${name} personal injury offices. Free consultation, no fees unless we win.`,
  };
}

export default async function StateLandingPage({ params }: Props) {
  const { state } = await params;
  const stateName = STATES[state];
  if (!stateName) notFound();

  const firm = getFirmData();
  const offices = await client.fetch<{ title: string; slug: string; officeKey: string }[]>(
    `*[_type == "location" && officeKey != "" && !isNeighborhood && language == "en"]{
      title, "slug": slug.current, officeKey
    }`,
  );
  const inState = offices.filter((o) => {
    const office = firm.offices[o.officeKey as OfficeKey];
    return office?.stateSlug === state;
  });
  if (!inState.length) notFound();

  return (
    <>
      <JsonLd
        data={breadcrumbSchema([
          { name: "Home", url: "/" },
          { name: "Locations", url: "/locations/" },
          { name: stateName, url: `/locations/${state}/` },
        ])}
      />
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-16">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Locations", href: "/locations/" }, { label: stateName }]} />
          <p className="porch-eyebrow mt-4 mb-4">Locations</p>
          <h1 className="font-heading font-normal text-ink text-[clamp(40px,6vw,72px)] leading-[1.02] tracking-[-0.02em] mb-5">
            {stateName} <span className="porch-em">personal injury lawyers.</span>
          </h1>
          <p className="text-[18px] leading-[1.55] text-ink-2 max-w-[56ch]">
            Roden Law serves injury victims across {stateName} with {inState.length}{" "}
            {inState.length === 1 ? "office" : "offices"}. Over <b className="font-bold text-ink">{firm.trustStats.recovered}</b> recovered — no fees unless we win.
          </p>
        </div>
      </section>

      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[72px]">
        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
          {inState.map((o) => {
            const office = firm.offices[o.officeKey as OfficeKey];
            return (
              <Link
                key={o.slug}
                href={`/locations/${state}/${o.slug}/`}
                className="group block bg-paper rounded-[20px] p-6 border border-rule hover:-translate-y-[3px] hover:shadow-[0_12px_32px_rgba(31,45,68,0.10)] transition-all no-underline"
              >
                <h2 className="font-heading text-[22px] text-ink mb-2 group-hover:text-terra transition-colors">{office?.marketName || o.title}</h2>
                {office && (
                  <address className="not-italic text-sm text-slate leading-[1.5]">
                    {office.street}<br />
                    {office.city}, {office.state} {office.zip}
                  </address>
                )}
                {office && <span className="block text-sm font-bold text-terra mt-3">☎ {office.phone}</span>}
              </Link>
            );
          })}
        </div>
      </div>

      <BottomCta />
    </>
  );
}
