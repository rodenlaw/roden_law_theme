import type { Metadata } from "next";
import { getFirmData } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";
import { FaqAccordion } from "@/components/sections/FaqAccordion";
import { BottomCta } from "@/components/sections/BottomCta";

export const metadata: Metadata = {
  title: "Class Action Lawyers",
  description: "Roden Law handles class action lawsuits in Georgia and South Carolina. Free consultation. No fees unless we win.",
};

const CLASS_ACTION_FAQS = [
  { question: "What is a class action lawsuit?", answer: "A class action lawsuit is a legal action filed by one or more plaintiffs on behalf of a larger group of people who have been similarly harmed by the same defendant. This allows many individuals to combine their claims into a single case." },
  { question: "How do I join a class action?", answer: "In most cases, you will receive notice if you qualify for a class action. You can also contact our office to find out if there are any pending class actions that may apply to your situation." },
  { question: "What types of class actions does Roden Law handle?", answer: "We handle class actions involving defective products, consumer fraud, data breaches, employment violations, environmental contamination, and pharmaceutical/medical device injuries." },
  { question: "How much does it cost to join a class action?", answer: "There are no upfront costs to join a class action lawsuit. Attorneys' fees are typically paid from the settlement or verdict if the case is successful." },
];

export default function ClassActionPage() {
  const firm = getFirmData();

  return (
    <>
      <section className="bg-navy text-white py-12 lg:py-16">
        <div className="mx-auto max-w-[1200px] px-6">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Class Action Lawyers" }]} />
          <div className="grid lg:grid-cols-[1fr_340px] gap-10 mt-4">
            <div>
              <h1 className="font-heading text-3xl md:text-4xl lg:text-5xl font-black mb-4">
                Class Action Lawyers in Georgia &amp; South Carolina
              </h1>
              <p className="text-lg text-gray-300 mb-6 max-w-2xl">
                When corporations harm large groups of people, class action lawsuits hold them accountable. Roden Law fights for consumers, employees, and injury victims across Georgia and South Carolina.
              </p>
              <a href={`tel:${firm.phoneE164}`} className="inline-block bg-orange text-navy font-extrabold px-8 py-3.5 rounded-md hover:bg-orange-dark transition-colors no-underline">
                {firm.phone}
              </a>
            </div>
            <div className="hidden lg:block">
              <ContactForm />
            </div>
          </div>
        </div>
      </section>

      <div className="mx-auto max-w-[1200px] px-6 py-12">
        <div className="grid lg:grid-cols-[1fr_340px] gap-10">
          <div className="min-w-0">
            <section className="mb-10">
              <h2 className="font-heading text-2xl font-bold text-navy mb-4">Types of Class Actions We Handle</h2>
              <div className="grid sm:grid-cols-2 gap-4">
                {["Defective Products", "Consumer Fraud", "Data Breaches", "Employment Violations", "Environmental Contamination", "Pharmaceutical Injuries"].map((type) => (
                  <div key={type} className="bg-light rounded-lg px-4 py-3 text-sm font-semibold text-navy border border-border">
                    {type}
                  </div>
                ))}
              </div>
            </section>

            <FaqAccordion faqs={CLASS_ACTION_FAQS} />
            <BottomCta />
          </div>

          <aside className="hidden lg:block">
            <div className="sticky top-[88px]">
              <ContactForm />
            </div>
          </aside>
        </div>
      </div>
    </>
  );
}
