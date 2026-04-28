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
      <section className="bg-navy text-white py-12">
        <div className="mx-auto max-w-[1200px] px-6">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Case Results" }]} />
          <h1 className="font-heading text-3xl md:text-4xl font-black mt-4 mb-3">Our Results Speak for Themselves</h1>
          <p className="text-lg text-gray-300 max-w-2xl">
            Roden Law has recovered <strong>{firm.trustStats.recovered}</strong> for injured clients across Georgia and South Carolina.
          </p>
        </div>
      </section>

      {/* Featured Result */}
      {featured && (
        <section className="mx-auto max-w-[1200px] px-6 py-10">
          <div className="bg-light border border-border rounded-lg p-8 text-center">
            <span className="text-xs uppercase tracking-widest text-gray-500">Featured Result</span>
            <p className="text-5xl md:text-6xl font-black text-navy my-3">{featured.amount}</p>
            {featured.resultType && (
              <span className="inline-block bg-orange text-navy text-xs font-bold px-3 py-1 rounded uppercase mb-2">
                {featured.resultType}
              </span>
            )}
            <h2 className="font-heading text-xl font-bold text-navy mb-2">{featured.title}</h2>
            {featured.description && <p className="text-gray-600 max-w-lg mx-auto">{featured.description}</p>}
          </div>
        </section>
      )}

      {/* Results Grid */}
      <section className="mx-auto max-w-[1200px] px-6 pb-12">
        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
          {remaining.map((result: any) => (
            <div key={result._id} className="bg-white border border-border rounded-lg p-5">
              {result.resultType && (
                <span className="text-[10px] uppercase tracking-widest text-gray-500">{result.resultType}</span>
              )}
              <p className="text-2xl font-black text-navy my-1">{result.amount}</p>
              <h3 className="font-heading text-sm font-bold text-navy mb-1">{result.title}</h3>
              {result.description && <p className="text-xs text-gray-600 line-clamp-2">{result.description}</p>}
            </div>
          ))}
        </div>

        <p className="text-xs text-gray-500 mt-6 text-center max-w-xl mx-auto">
          Results shown are gross settlement/verdict amounts before attorney fees and cost deductions. Past results do not guarantee or suggest similar recovery in your case. Each case is unique.
        </p>
      </section>

      <div className="mx-auto max-w-[1200px] px-6">
        <BottomCta heading="Think You Have a Case?" />
      </div>
    </>
  );
}
