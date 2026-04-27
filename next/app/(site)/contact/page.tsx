import type { Metadata } from "next";
import { getFirmData } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";

export const metadata: Metadata = {
  title: "Contact Roden Law",
  description: "Contact Roden Law for a free case review. 6 offices across Georgia and South Carolina. No fees unless we win.",
};

export default function ContactPage() {
  const firm = getFirmData();

  return (
    <>
      <section className="bg-navy text-white py-12">
        <div className="mx-auto max-w-[1200px] px-6">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Contact" }]} />
          <h1 className="font-heading text-3xl md:text-4xl font-black mt-4 mb-3">Contact Roden Law</h1>
          <p className="text-lg text-gray-300">Injured? Get your free case review today. No fees unless we win.</p>
        </div>
      </section>

      <section className="mx-auto max-w-[1200px] px-6 py-12">
        <div className="grid md:grid-cols-2 gap-10">
          {/* Form */}
          <ContactForm />

          {/* Info */}
          <div>
            <div className="bg-navy text-white rounded-lg p-6 mb-6 text-center">
              <span className="block text-sm text-gray-400 mb-1">Call Us 24/7</span>
              <a href={`tel:${firm.phoneRaw}`} className="block text-3xl font-black text-orange hover:text-orange-light no-underline mb-1">
                {firm.vanityPhone}
              </a>
              <span className="text-sm text-gray-400">Free Consultation &bull; No Fees Unless We Win</span>
            </div>

            <h2 className="font-heading text-xl font-bold text-navy mb-3">Schedule a Free Consultation</h2>
            <p className="text-gray-700 mb-4">
              The moments following a personal injury can be overwhelming and uncertain. Our accomplished attorneys can guide you through the complex aftermath of an accident and help you obtain the justice you need to move on with your life.
            </p>

            <div className="grid grid-cols-3 gap-4 text-center bg-light rounded-lg p-4">
              <div><span className="block text-xl font-black text-navy">{firm.trustStats.recovered}</span><span className="text-xs text-gray-600">Recovered</span></div>
              <div><span className="block text-xl font-black text-navy">{firm.trustStats.rating}&#9733;</span><span className="text-xs text-gray-600">Rating</span></div>
              <div><span className="block text-xl font-black text-navy">{firm.trustStats.cases}</span><span className="text-xs text-gray-600">Cases</span></div>
            </div>
          </div>
        </div>
      </section>

      {/* Office Grid */}
      <section className="bg-light py-12">
        <div className="mx-auto max-w-[1200px] px-6">
          <h2 className="font-heading text-2xl font-bold text-navy mb-6 text-center">Our Offices</h2>
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            {Object.values(firm.offices).map((office) => (
              <div key={office.slug} className="bg-white rounded-lg p-5 border border-border">
                <h3 className="font-heading text-base font-bold text-navy mb-2">{office.marketName}, {office.state}</h3>
                <address className="not-italic text-sm text-gray-600 mb-2">
                  {office.street}<br />{office.city}, {office.state} {office.zip}
                </address>
                <a href={`tel:${office.phoneRaw}`} className="block text-sm font-bold text-orange hover:text-orange-dark no-underline mb-2">{office.phone}</a>
                <a href={office.mapUrl} target="_blank" rel="noopener noreferrer nofollow" className="text-xs text-navy hover:text-orange-text no-underline">Get Directions &rarr;</a>
              </div>
            ))}
          </div>
        </div>
      </section>
    </>
  );
}
