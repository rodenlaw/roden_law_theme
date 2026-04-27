import Link from "next/link";
import type { Office, OfficeKey } from "@/lib/firm-data";

interface LocationMatrixProps {
  offices: Record<OfficeKey, Office>;
  pillarSlug: string;
  intersections?: { title: string; slug: string; officeKey: string }[];
  currentSlug?: string;
}

export function LocationMatrix({ offices, pillarSlug, intersections, currentSlug }: LocationMatrixProps) {
  const intersectionMap = new Map(
    (intersections ?? []).map((int) => [int.officeKey, int.slug]),
  );

  return (
    <section className="bg-light py-8">
      <div className="mx-auto max-w-[1200px] px-6">
        <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
          {Object.entries(offices).map(([key, office]) => {
            const intSlug = intersectionMap.get(key);
            const href = intSlug
              ? `/${pillarSlug}/${intSlug}/`
              : `/locations/${office.stateSlug}/${office.slug.replace(/-[a-z]{2}$/, "")}/`;
            const isCurrent = currentSlug === office.slug || currentSlug === intSlug;

            return (
              <div
                key={key}
                className={`rounded-lg p-3 text-center transition-colors ${
                  isCurrent
                    ? "bg-navy text-white"
                    : "bg-white border border-border hover:border-orange"
                }`}
              >
                <span className={`inline-block text-[10px] uppercase tracking-widest mb-1 ${
                  office.state === "GA" ? "text-green" : "text-orange"
                }`}>
                  {office.state}
                </span>
                {isCurrent ? (
                  <p className="font-heading font-bold text-sm">{office.marketName}</p>
                ) : (
                  <Link
                    href={href}
                    className="block font-heading font-bold text-sm text-navy hover:text-orange-text no-underline"
                  >
                    {office.marketName}
                  </Link>
                )}
              </div>
            );
          })}
        </div>
      </div>
    </section>
  );
}
