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
    <section className="bg-paper border-y border-rule py-8">
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
                className={`rounded-[16px] p-3 text-center transition-colors ${
                  isCurrent
                    ? "bg-ink text-cream"
                    : "bg-cream border border-rule hover:border-terra"
                }`}
              >
                <span className={`inline-block font-mono text-[10px] uppercase tracking-[0.1em] mb-1 ${
                  isCurrent ? "text-honey" : office.state === "GA" ? "text-honey-deep" : "text-terra"
                }`}>
                  {office.state}
                </span>
                {isCurrent ? (
                  <p className="font-heading text-base">{office.marketName}</p>
                ) : (
                  <Link
                    href={href}
                    className="block font-heading text-base text-ink hover:text-terra no-underline"
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
