import { getFirmData } from "@/lib/firm-data";

export function InlineCta() {
  const firm = getFirmData();

  return (
    <div className="flex flex-col sm:flex-row items-center justify-between gap-4 bg-light rounded-lg px-6 py-5 my-8 border border-border">
      <div>
        <strong className="block text-navy font-heading text-base">
          Free Case Review &mdash; No Fees Unless We Win
        </strong>
        <span className="text-sm text-gray-600">
          Available 24/7 &middot; Georgia &amp; South Carolina
        </span>
      </div>
      <a
        href={`tel:${firm.phoneE164}`}
        className="inline-flex items-center px-6 py-3 bg-orange text-navy font-extrabold rounded-md hover:bg-orange-dark transition-colors no-underline text-sm shrink-0"
      >
        {firm.phone}
      </a>
    </div>
  );
}
