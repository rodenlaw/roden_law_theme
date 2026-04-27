import type { Metadata } from "next";
import { getFirmData } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { BottomCta } from "@/components/sections/BottomCta";

export const metadata: Metadata = {
  title: "About Roden Law",
  description: "Personal injury attorneys fighting for maximum compensation across Georgia and South Carolina since 2013. $250M+ recovered.",
};

export default function AboutPage() {
  const firm = getFirmData();

  return (
    <>
      <section className="bg-navy text-white py-12">
        <div className="mx-auto max-w-[1200px] px-6">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "About" }]} />
          <h1 className="font-heading text-3xl md:text-4xl font-black mt-4 mb-3">About Roden Law</h1>
          <p className="text-lg text-gray-300 max-w-2xl">
            Personal injury attorneys fighting for maximum compensation across Georgia and South Carolina since 2013.
          </p>
        </div>
      </section>

      {/* Founder Story */}
      <section className="mx-auto max-w-[1200px] px-6 py-12">
        <div className="grid md:grid-cols-2 gap-10 items-start">
          <div>
            <h2 className="font-heading text-2xl font-bold text-navy mb-4">Our Story</h2>
            <p className="text-gray-700 mb-4">
              Roden Law was founded in 2013 by Eric L. Roden and Tyler M. Love with a singular mission: fighting for injury victims. We built our firm on the principle that every person harmed by another&apos;s negligence deserves aggressive, personal representation — not the assembly-line treatment you get at larger firms.
            </p>
            <p className="text-gray-700 mb-4">
              We understand that serious injuries create emotional, physical, and financial hardship. That&apos;s why our attorneys personally handle every case — you&apos;ll always speak directly with a lawyer who knows your story and is invested in your outcome.
            </p>
            <blockquote className="border-l-4 border-orange bg-light px-6 py-4 rounded-r-lg my-6">
              <p className="text-gray-800 italic mb-2">
                &ldquo;I started Roden Law because I saw too many injury victims get lowballed by insurance companies. Our team fights for every dollar you deserve — and we don&apos;t get paid unless you do.&rdquo;
              </p>
              <cite className="text-sm text-gray-600 not-italic">— Eric Roden, Founding Partner</cite>
            </blockquote>
          </div>
          <div className="bg-light rounded-lg p-8">
            <h3 className="font-heading text-xl font-bold text-navy mb-4">Our Commitment</h3>
            <ul className="space-y-3 text-gray-700">
              <li className="flex gap-3"><span className="text-orange font-bold">01</span> Personal attention on every case</li>
              <li className="flex gap-3"><span className="text-orange font-bold">02</span> No fees unless we win</li>
              <li className="flex gap-3"><span className="text-orange font-bold">03</span> Licensed in Georgia &amp; South Carolina</li>
              <li className="flex gap-3"><span className="text-orange font-bold">04</span> {firm.trustStats.recovered} recovered for clients</li>
              <li className="flex gap-3"><span className="text-orange font-bold">05</span> {firm.trustStats.reviews} five-star reviews</li>
              <li className="flex gap-3"><span className="text-orange font-bold">06</span> 6 office locations</li>
            </ul>
          </div>
        </div>
      </section>

      {/* Stats */}
      <section className="bg-light py-10">
        <div className="mx-auto max-w-[1200px] px-6">
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div><span className="block text-3xl font-black text-navy">{firm.trustStats.recovered}</span><span className="text-sm text-gray-600">Recovered</span></div>
            <div><span className="block text-3xl font-black text-navy">{firm.trustStats.cases}</span><span className="text-sm text-gray-600">Cases Handled</span></div>
            <div><span className="block text-3xl font-black text-navy">{firm.trustStats.rating}&#9733;</span><span className="text-sm text-gray-600">Client Rating</span></div>
            <div><span className="block text-3xl font-black text-navy">{firm.experience}</span><span className="text-sm text-gray-600">Combined Experience</span></div>
          </div>
        </div>
      </section>

      <div className="mx-auto max-w-[1200px] px-6 py-12">
        <BottomCta heading="Schedule a Free Consultation" />
      </div>
    </>
  );
}
