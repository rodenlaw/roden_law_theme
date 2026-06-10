import Link from "next/link";
import { getFirmData } from "@/lib/firm-data";

const FOOTER_PRACTICE_AREAS = [
  { label: "Car Accidents", slug: "car-accident-lawyers" },
  { label: "Truck Accidents", slug: "truck-accident-lawyers" },
  { label: "Motorcycle Accidents", slug: "motorcycle-accident-lawyers" },
  { label: "Pedestrian Accidents", slug: "pedestrian-accident-lawyers" },
];

const SOCIAL_ICONS: Record<string, string> = {
  facebook: "f",
  linkedin: "in",
  twitter: "x",
  youtube: "\u25B6",
  instagram: "ig",
};

const SOCIAL_LABELS: Record<string, string> = {
  facebook: "Facebook",
  linkedin: "LinkedIn",
  twitter: "X / Twitter",
  youtube: "YouTube",
  instagram: "Instagram",
};

export function Footer() {
  const firm = getFirmData();
  const year = new Date().getFullYear();

  return (
    <>
      <footer className="bg-ink text-cream/75" role="contentinfo">
        <div className="mx-auto max-w-[1200px] px-6 py-16">
          {/* 4-Column Grid */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            {/* Column 1: Firm Info */}
            <div>
              <div className="flex items-center gap-2.5 mb-3">
                <span className="w-9 h-9 rounded-full bg-honey text-ink flex items-center justify-center font-heading text-lg" aria-hidden="true">R</span>
                <span className="font-heading text-xl text-cream">{firm.name}</span>
              </div>
              <p className="text-honey text-sm font-semibold mb-3">
                <span aria-hidden="true">{"★".repeat(5)}</span> {firm.trustStats.rating}/5 &middot; {firm.trustStats.reviews} reviews
              </p>
              <p className="text-cream/60 text-sm leading-relaxed mb-4">
                {firm.trustStats.recovered} recovered for injury victims across Georgia and South
                Carolina. No fees unless we win.
              </p>
              <div className="flex gap-3">
                {Object.entries(firm.social).map(([key, url]) => (
                  <a
                    key={key}
                    href={url}
                    aria-label={SOCIAL_LABELS[key] ?? key}
                    target="_blank"
                    rel="noopener noreferrer nofollow"
                    className="flex items-center justify-center w-8 h-8 bg-cream/10 rounded-full text-xs font-bold text-cream hover:bg-honey hover:text-ink transition-colors no-underline"
                  >
                    <span aria-hidden="true">{SOCIAL_ICONS[key] ?? key[0]}</span>
                  </a>
                ))}
              </div>
            </div>

            {/* Column 2: Practice Areas */}
            <div>
              <h4 className="text-honey font-mono text-xs font-bold uppercase tracking-[0.14em] mb-4">Practice Areas</h4>
              <ul className="list-none m-0 p-0 space-y-1.5">
                {FOOTER_PRACTICE_AREAS.map(({ label, slug }) => (
                  <li key={slug}>
                    <Link
                      href={`/practice-areas/${slug}/`}
                      className="text-cream/70 text-sm hover:text-cream no-underline"
                    >
                      {label}
                    </Link>
                  </li>
                ))}
                <li>
                  <Link href="/practice-areas/" className="text-cream/70 text-sm hover:text-cream no-underline">
                    Other Personal Injuries
                  </Link>
                </li>
                <li>
                  <Link href="/resources/" className="text-cream/70 text-sm hover:text-cream no-underline">
                    Resources
                  </Link>
                </li>
              </ul>
            </div>

            {/* Column 3: Offices */}
            <div>
              <h4 className="text-honey font-mono text-xs font-bold uppercase tracking-[0.14em] mb-4">Our Offices</h4>
              <div className="space-y-3">
                {Object.values(firm.offices).map((office) => (
                  <div key={office.slug}>
                    <h5 className="text-cream text-sm font-semibold mb-0.5">
                      {office.marketName}, {office.state}
                    </h5>
                    <address className="not-italic text-cream/60 text-xs leading-relaxed">
                      {office.street}
                      <br />
                      <a
                        href={`tel:${firm.phoneRaw}`}
                        className="text-cream/60 hover:text-honey no-underline"
                      >
                        {firm.vanityPhone}
                      </a>
                    </address>
                  </div>
                ))}
              </div>
            </div>

            {/* Column 4: CTA */}
            <div>
              <h4 className="text-honey font-mono text-xs font-bold uppercase tracking-[0.14em] mb-4">Free Case Review</h4>
              <p className="text-cream/60 text-sm mb-4">
                Injured? Find out what your case is worth. No fees unless we win.
              </p>
              <Link
                href="/contact/"
                className="inline-block w-full text-center bg-terra text-paper font-bold py-3 rounded-full hover:bg-terra-deep transition-colors no-underline text-sm"
              >
                Get Your Free Case Review
              </Link>
            </div>
          </div>

          {/* Disclaimers */}
          <div className="border-t border-cream/15 pt-6 space-y-3 text-[11px] text-cream/45 leading-relaxed">
            <p>
              <strong className="text-cream/60">Disclaimer:</strong> Attorney Eric Roden is
              responsible for the content of this website, and his primary office address is 333
              Commercial Drive, Savannah, GA 31406. South Carolina cases are principally handled out
              of the Charleston and North Charleston, South Carolina offices. South Carolina cases are
              primarily handled by attorney Graeham Gillin, and the primary office addresses are 127
              King Street, Charleston, SC 29401 and 2703 Spruill Ave, North Charleston, SC 29405.
              Georgia cases are principally handled out of the Savannah and Darien, Georgia offices.
            </p>
            <p>
              <strong className="text-cream/60">Case Results:</strong> Case &ldquo;value,&rdquo;
              &ldquo;results,&rdquo; and/or &ldquo;maximum compensation&rdquo; is determined from the
              total settlement amount. The settlement amounts shown are gross numbers before
              attorney&apos;s fees and cost deductions. Each case is unique, and the examples shown
              are just that, examples of past results. Past results do not guarantee or suggest
              recovery in your specific case.
            </p>
            <p>
              <strong className="text-cream/60">No Upfront Fees:</strong> Fees and costs apply only
              upon successful recovery. No fees or costs with no recovery.
            </p>
          </div>

          {/* Copyright */}
          <div className="border-t border-cream/15 mt-6 pt-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-cream/45">
            <span>
              &copy; {year} {firm.legalEntity}. All Rights Reserved |{" "}
              <Link href="/privacy-policy/" className="text-cream/45 hover:text-cream no-underline">
                Privacy Policy
              </Link>
            </span>
            <span>Licensed in Georgia &amp; South Carolina</span>
          </div>
        </div>
      </footer>

      {/* Back to Top — handled via CSS/JS later */}
    </>
  );
}
