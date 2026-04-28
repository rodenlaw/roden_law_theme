import Link from "next/link";
import { getFirmData, type OfficeKey } from "@/lib/firm-data";
import { ContactForm } from "@/components/shared/ContactForm";
import { getCaseResults } from "@/lib/queries/shared";
import { BottomCta } from "@/components/sections/BottomCta";

export const revalidate = 3600;

const FEATURED_PAS = [
  { name: "Car Accident Lawyers", slug: "car-accident-lawyers", scenario: "Injured in a car accident?" },
  { name: "Truck Accident Lawyers", slug: "truck-accident-lawyers", scenario: "Hit by a commercial truck?" },
  { name: "Motorcycle Accident Lawyers", slug: "motorcycle-accident-lawyers", scenario: "Motorcycle crash injuries?" },
  { name: "Pedestrian Accident Lawyers", slug: "pedestrian-accident-lawyers", scenario: "Struck as a pedestrian?" },
];

export default async function HomePage() {
  const firm = getFirmData();
  const stats = firm.trustStats;
  const caseResults = await getCaseResults(12);

  return (
    <>
      {/* ============================================================
           HERO SECTION
           ============================================================ */}
      <section className="bg-navy text-white py-14 lg:py-20">
        <div className="mx-auto max-w-[1200px] px-6">
          <div className="grid lg:grid-cols-[1fr_380px] gap-10 items-start">
            {/* Hero Content */}
            <div>
              <h1 className="font-heading text-3xl md:text-4xl lg:text-5xl font-black leading-tight mb-5">
                Georgia &amp; South Carolina<br />
                <span className="text-orange">Personal Injury Lawyers</span><br />
                Who Fight for Maximum Compensation
              </h1>
              <p className="text-lg text-gray-300 mb-6 max-w-xl">
                Roden Law has recovered <strong>{stats.recovered}</strong> for injury victims across
                Savannah, Charleston, North Charleston, Columbia, Myrtle Beach, and Darien.
                No fees unless we win. Free case review 24/7.
              </p>

              {/* Trust Stats */}
              <div className="grid grid-cols-3 gap-4 mb-6 max-w-md">
                <div className="text-center">
                  <span className="block text-2xl font-black text-orange">{stats.recovered}</span>
                  <span className="text-xs text-gray-400">Recovered for Clients</span>
                </div>
                <div className="text-center">
                  <span className="block text-2xl font-black text-orange">{stats.rating}&#9733;</span>
                  <span className="text-xs text-gray-400">Client Rating</span>
                </div>
                <div className="text-center">
                  <span className="block text-2xl font-black text-orange">{stats.cases}</span>
                  <span className="text-xs text-gray-400">Cases Handled</span>
                </div>
              </div>

              <p className="text-sm text-green mb-6">&#10003; No Fees Unless We Win &bull; Free Consultation 24/7</p>

              <a
                href={`tel:${firm.phoneE164}`}
                className="inline-block bg-orange text-navy font-extrabold px-8 py-3.5 rounded-md text-lg hover:bg-orange-dark transition-colors no-underline"
              >
                Call {firm.vanityPhone}
              </a>
            </div>

            {/* Hero Form */}
            <div id="free-case-review">
              <ContactForm />
            </div>
          </div>
        </div>
      </section>

      {/* ============================================================
           BADGE BAR
           ============================================================ */}
      <div className="bg-light border-y border-border py-5">
        <div className="mx-auto max-w-[1200px] px-6">
          <div className="flex items-center justify-center gap-8 md:gap-12 flex-wrap text-xs text-gray-500 font-semibold uppercase tracking-widest">
            <span>State Bar of Georgia</span>
            <span>American Association for Justice</span>
            <span>Georgia Trial Lawyers</span>
            <span>American Bar Association</span>
          </div>
        </div>
      </div>

      {/* ============================================================
           HOW IT WORKS
           ============================================================ */}
      <section className="py-14" id="how-it-works">
        <div className="mx-auto max-w-[1200px] px-6">
          <div className="text-center mb-10">
            <h2 className="font-heading text-2xl md:text-3xl font-bold text-navy mb-2">How It Works</h2>
            <p className="text-gray-600">Getting started is simple — and completely free.</p>
          </div>
          <div className="grid md:grid-cols-3 gap-6">
            {[
              { num: "1", title: "Free Consultation", desc: "Tell us what happened. We'll review your case for free — no obligation." },
              { num: "2", title: "We Build Your Case", desc: "Our attorneys investigate, gather evidence, and handle all legal work." },
              { num: "3", title: "You Get Compensated", desc: "We negotiate maximum compensation. No fees unless we win." },
            ].map((step) => (
              <div key={step.num} className="text-center bg-light rounded-lg p-8 border border-border">
                <span className="inline-flex items-center justify-center w-12 h-12 bg-navy text-white font-black text-xl rounded-full mb-4">
                  {step.num}
                </span>
                <h3 className="font-heading text-lg font-bold text-navy mb-2">{step.title}</h3>
                <p className="text-sm text-gray-600">{step.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ============================================================
           PRACTICE AREAS GRID
           ============================================================ */}
      <section className="bg-light py-14" id="practice-areas">
        <div className="mx-auto max-w-[1200px] px-6">
          <div className="text-center mb-10">
            <h2 className="font-heading text-2xl md:text-3xl font-bold text-navy mb-2">Personal Injury Practice Areas</h2>
            <p className="text-gray-600">We handle all types of personal injury cases throughout Georgia and South Carolina.</p>
          </div>
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            {FEATURED_PAS.map((pa) => (
              <Link
                key={pa.slug}
                href={`/practice-areas/${pa.slug}/`}
                className="group flex items-center justify-between bg-white rounded-lg p-5 border border-border hover:border-orange hover:shadow-md transition-all no-underline"
              >
                <div>
                  <span className="block text-xs text-gray-500 mb-1">{pa.scenario}</span>
                  <h3 className="font-heading text-base font-bold text-navy group-hover:text-orange-text">{pa.name}</h3>
                </div>
                <span className="text-orange text-xl" aria-hidden="true">&rarr;</span>
              </Link>
            ))}
            <Link
              href="/practice-areas/"
              className="group flex items-center justify-between bg-white rounded-lg p-5 border border-border hover:border-orange hover:shadow-md transition-all no-underline"
            >
              <h3 className="font-heading text-base font-bold text-navy group-hover:text-orange-text">Other Personal Injury Types</h3>
              <span className="text-orange text-xl" aria-hidden="true">&rarr;</span>
            </Link>
          </div>
        </div>
      </section>

      {/* ============================================================
           LOCATIONS GRID — 6 OFFICES
           ============================================================ */}
      <section className="py-14" id="locations">
        <div className="mx-auto max-w-[1200px] px-6">
          <div className="text-center mb-10">
            <h2 className="font-heading text-2xl md:text-3xl font-bold text-navy mb-2">Our Offices in Georgia &amp; South Carolina</h2>
          </div>
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            {Object.entries(firm.offices).map(([key, office]) => (
              <div key={key} className="bg-white rounded-lg p-5 border border-border">
                <span className={`inline-block text-[10px] uppercase tracking-widest font-bold px-2 py-0.5 rounded mb-2 ${
                  office.state === "GA" ? "bg-green/10 text-green" : "bg-orange/10 text-orange-text"
                }`}>
                  {office.state}
                </span>
                <h3 className="font-heading text-base font-bold text-navy mb-1">{office.marketName}</h3>
                <address className="not-italic text-sm text-gray-600 mb-2">
                  {office.street}<br />
                  {office.city}, {office.state} {office.zip}
                </address>
                <a href={`tel:${office.phoneRaw}`} className="block text-sm font-bold text-orange hover:text-orange-dark no-underline mb-2">
                  {office.phone}
                </a>
                <Link
                  href={`/locations/${office.stateSlug}/${office.slug.replace(/-[a-z]{2}$/, "")}/`}
                  className="text-xs font-semibold text-navy hover:text-orange-text no-underline"
                >
                  View Office &rarr;
                </Link>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ============================================================
           WHY RODEN LAW — Founder Story
           ============================================================ */}
      <section className="bg-light py-14" id="why-roden-law">
        <div className="mx-auto max-w-[1200px] px-6">
          <div className="grid md:grid-cols-2 gap-10 items-center">
            <div>
              <h2 className="font-heading text-2xl md:text-3xl font-bold text-navy mb-4">Why Roden Law?</h2>
              <blockquote className="border-l-4 border-orange bg-white px-6 py-4 rounded-r-lg mb-6">
                <p className="text-gray-800 italic mb-2">
                  &ldquo;I started Roden Law because I saw too many injury victims get lowballed by insurance companies. Our team fights for every dollar you deserve — and we don&apos;t get paid unless you do.&rdquo;
                </p>
                <cite className="text-sm text-gray-600 not-italic">— Eric Roden, Founding Partner</cite>
              </blockquote>
            </div>
            <div className="space-y-4">
              {[
                { label: "$250M+ Recovered", desc: "Proven track record across Georgia and South Carolina" },
                { label: "No Upfront Costs", desc: "100% contingency. You pay nothing unless we win." },
                { label: "6 Office Locations", desc: "Local attorneys in Savannah, Charleston, North Charleston, Columbia, Myrtle Beach, and Darien" },
              ].map((v) => (
                <div key={v.label} className="bg-white rounded-lg p-4 border border-border">
                  <strong className="block text-navy font-heading text-sm">{v.label}</strong>
                  <span className="text-sm text-gray-600">{v.desc}</span>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* ============================================================
           CASE RESULTS
           ============================================================ */}
      <section className="bg-navy py-14" id="results">
        <div className="mx-auto max-w-[1200px] px-6">
          <div className="text-center mb-10">
            <h2 className="font-heading text-2xl md:text-3xl font-bold text-white mb-2">Our Results Speak for Themselves</h2>
          </div>
          <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            {(caseResults ?? []).slice(0, 8).map((result: any) => (
              <div key={result._id} className="bg-white/10 rounded-lg p-5 text-center">
                {result.resultType && (
                  <span className="text-[10px] uppercase tracking-widest text-gray-400">{result.resultType}</span>
                )}
                <p className="text-2xl font-black text-orange my-1">{result.amount}</p>
                <span className="text-xs text-gray-400">{result.title}</span>
              </div>
            ))}
          </div>
          <div className="text-center mt-6">
            <Link href="/case-results/" className="text-sm font-semibold text-orange hover:text-orange-light no-underline">
              View All Results &rarr;
            </Link>
          </div>
        </div>
      </section>

      {/* ============================================================
           TESTIMONIALS
           ============================================================ */}
      <section className="bg-light py-14" id="testimonials">
        <div className="mx-auto max-w-[1200px] px-6 text-center">
          <div className="text-orange text-3xl mb-2" aria-label="5 star rating">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <h2 className="font-heading text-2xl md:text-3xl font-bold text-navy mb-2">500+ Five-Star Reviews</h2>
          <p className="text-gray-600 mb-6">Our clients trust us to fight for maximum compensation.</p>
          <Link href="/testimonials/" className="text-sm font-semibold text-navy hover:text-orange-text no-underline">
            Read Client Testimonials &rarr;
          </Link>
        </div>
      </section>

      {/* ============================================================
           BOTTOM CTA
           ============================================================ */}
      <div className="mx-auto max-w-[1200px] px-6 py-4">
        <BottomCta heading="Injured? Get Your Free Case Review Today." />
      </div>
    </>
  );
}
