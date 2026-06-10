import type { Metadata } from "next";
import Link from "next/link";
import { getCaseResults } from "@/lib/queries/shared";
import { getFirmData } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { BottomCta } from "@/components/sections/BottomCta";

export const revalidate = 3600;
export const metadata: Metadata = {
  title: "Case Results",
  description: "View Roden Law's case results. Over $250M recovered for injured clients across Georgia and South Carolina.",
};

export default async function CaseResultsPage() {
  const firm = getFirmData();
  const results = await getCaseResults(20);

  // Featured = first result (highest amount)
  const featured = results?.[0];
  const remaining = results?.slice(1) ?? [];

  return (
    <>
      {/* ── Hero ─────────────────────────────────────────── */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-16">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Case Results" }]} />
          <div className="max-w-[760px] mt-4">
            <p className="porch-eyebrow mb-4">Track Record</p>
            <h1 className="font-heading font-normal text-ink text-[clamp(40px,6vw,72px)] leading-[1.02] tracking-[-0.02em] mb-6">
              Our results speak <span className="porch-em">for themselves.</span>
            </h1>
            <p className="text-[18px] leading-[1.55] text-ink-2 max-w-[56ch]">
              Roden Law has recovered <b className="font-bold text-ink">{firm.trustStats.recovered}</b> for injured clients across Georgia and South Carolina.
            </p>
          </div>
        </div>
      </section>

      <section className="bg-cream">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[100px]">
          {/* Featured Result */}
          {featured && (
            <div className="bg-ink text-cream rounded-[24px] p-10 lg:p-14 text-center mb-12">
              <span className="porch-eyebrow text-honey">Featured Result</span>
              <p className="font-heading font-medium text-[clamp(48px,8vw,80px)] leading-none text-cream my-5">{featured.amount}</p>
              {featured.resultType && (
                <span className="inline-block bg-terra text-paper text-[11px] font-bold tracking-[0.1em] px-3.5 py-1.5 rounded-full uppercase mb-4">
                  {featured.resultType}
                </span>
              )}
              <h2 className="font-heading text-[24px] text-cream mb-3">{featured.title}</h2>
              {featured.description && <p className="text-cream/75 leading-[1.55] max-w-[52ch] mx-auto">{featured.description}</p>}
            </div>
          )}

          {/* Results Grid */}
          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {remaining.map((result: any) => (
              <div key={result._id} className="bg-paper border border-rule rounded-[20px] p-6 hover:-translate-y-[3px] hover:shadow-[0_16px_40px_rgba(31,45,68,0.10)] transition-all">
                {result.resultType && (
                  <span className="font-mono text-[10px] uppercase tracking-[0.12em] text-slate">{result.resultType}</span>
                )}
                <p className="font-heading text-[30px] font-medium text-ink my-1.5 leading-none">{result.amount}</p>
                <h3 className="font-heading text-[16px] text-ink mb-1.5 leading-[1.25]">{result.title}</h3>
                {result.description && <p className="text-xs text-slate leading-[1.5] line-clamp-2">{result.description}</p>}
              </div>
            ))}
          </div>

          <p className="text-xs text-slate mt-8 text-center max-w-xl mx-auto leading-[1.5]">
            Results shown are gross settlement/verdict amounts before attorney fees and cost deductions. Past results do not guarantee or suggest similar recovery in your case. Each case is unique.
          </p>
        </div>
      </section>

      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px]">
        <BottomCta heading="Think You Have a Case?" />
      </div>
    </>
  );
}
