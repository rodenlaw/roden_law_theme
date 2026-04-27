import type { Metadata } from "next";
import { getTestimonials } from "@/lib/queries/shared";
import { getFirmData } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { BottomCta } from "@/components/sections/BottomCta";
import { PortableText } from "@/components/shared/PortableText";

export const metadata: Metadata = {
  title: "Testimonials",
  description: "Read what our clients say about Roden Law. 500+ five-star reviews across Georgia and South Carolina.",
};

export default async function TestimonialsPage() {
  const firm = getFirmData();
  const testimonials = await getTestimonials();

  return (
    <>
      <section className="bg-navy text-white py-12">
        <div className="mx-auto max-w-[1200px] px-6">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Testimonials" }]} />
          <h1 className="font-heading text-3xl md:text-4xl font-black mt-4 mb-3">Client Testimonials</h1>
          <p className="text-lg text-gray-300 max-w-2xl">
            {firm.trustStats.reviews} five-star reviews from clients across Georgia and South Carolina.
          </p>
        </div>
      </section>

      <section className="mx-auto max-w-[1200px] px-6 py-12">
        {testimonials && testimonials.length > 0 ? (
          <div className="grid md:grid-cols-2 gap-6">
            {testimonials.map((t: any) => (
              <div key={t._id} className="bg-white border border-border rounded-lg p-6">
                <div className="flex items-center gap-1 mb-3">
                  {Array.from({ length: t.rating || 5 }).map((_, i) => (
                    <span key={i} className="text-orange text-lg">&#9733;</span>
                  ))}
                </div>
                {t.reviewBody && (
                  <div className="text-gray-700 text-sm leading-relaxed mb-3">
                    <PortableText value={t.reviewBody} />
                  </div>
                )}
                <p className="text-sm font-semibold text-navy">— {t.clientName}</p>
              </div>
            ))}
          </div>
        ) : (
          <p className="text-gray-600 text-center py-10">
            Testimonials coming soon. In the meantime, check our{" "}
            <a href="https://www.google.com/search?q=Roden+Law+reviews" target="_blank" rel="noopener noreferrer" className="text-navy underline">
              Google Reviews
            </a>.
          </p>
        )}
      </section>

      <div className="mx-auto max-w-[1200px] px-6">
        <BottomCta heading="Injured? Get Your Free Case Review Today." />
      </div>
    </>
  );
}
