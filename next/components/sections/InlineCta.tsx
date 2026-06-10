import { getFirmData } from "@/lib/firm-data";

export function InlineCta() {
  const firm = getFirmData();

  return (
    <div className="flex flex-col sm:flex-row items-center justify-between gap-4 bg-paper rounded-[20px] px-7 py-6 my-8 border border-rule">
      <div>
        <strong className="block text-ink font-heading text-[19px] font-normal">
          Free Case Review &mdash; No Fees Unless We Win
        </strong>
        <span className="text-sm text-slate">
          Available 24/7 &middot; Georgia &amp; South Carolina
        </span>
      </div>
      <a
        href={`tel:${firm.phoneE164}`}
        className="inline-flex items-center px-7 py-4 bg-terra text-paper font-bold rounded-full hover:bg-terra-deep transition-colors no-underline text-sm shrink-0"
      >
        {firm.phone}
      </a>
    </div>
  );
}
