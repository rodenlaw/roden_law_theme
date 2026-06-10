import type { Metadata } from "next";
import Link from "next/link";
import { getFirmData } from "@/lib/firm-data";
import { getAllClassActions, type ClassActionListItem } from "@/lib/queries/shared";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";
import { FaqAccordion } from "@/components/sections/FaqAccordion";
import { BottomCta } from "@/components/sections/BottomCta";
import { JsonLd } from "@/components/shared/JsonLd";
import { breadcrumbSchema, faqPageSchema } from "@/lib/schema";

export const revalidate = 3600;
export const metadata: Metadata = {
  title: "Class Action & Mass Tort Lawyers",
  description:
    "Roden Law represents victims of dangerous drugs, defective products, and toxic chemicals in mass tort and class action lawsuits across Georgia and South Carolina. No fees unless we win.",
};

const HUB_FAQS = [
  {
    question: "What is the difference between a mass tort and a class action lawsuit?",
    answer:
      "In a class action, one lawsuit is filed on behalf of an entire group, and any settlement is divided among all class members. In a mass tort, each plaintiff files their own individual claim, but the cases are consolidated for pretrial proceedings. Mass torts typically result in higher individual compensation because each person's unique injuries and damages are evaluated separately.",
  },
  {
    question: "How much does it cost to join a class action or mass tort lawsuit?",
    answer:
      "There is no upfront cost. Roden Law handles mass tort and class action cases on a contingency fee basis, which means you pay nothing unless we recover compensation for you. We cover all investigation, filing, and litigation costs, and our fees are a percentage of your recovery.",
  },
  {
    question: "How long do mass tort and class action cases take?",
    answer:
      "These cases can take anywhere from one to several years depending on the complexity of the litigation, the number of plaintiffs, and whether the case goes to trial or settles. Our attorneys keep clients informed throughout the process and work to resolve cases as efficiently as possible.",
  },
  {
    question: "How do I know if I qualify for a class action or mass tort lawsuit?",
    answer:
      "If you have been harmed by a dangerous drug, defective product, toxic chemical, or other corporate negligence, you may qualify. Contact us for a free, no-obligation case review. Our attorneys will evaluate your situation, review your medical records, and determine whether you have a viable claim.",
  },
  {
    question: "Can I still file a claim if I did not experience severe side effects?",
    answer:
      "Potentially, yes. Eligibility depends on the specific lawsuit and the criteria established for participation. Even if your injuries seem minor, they may still qualify for compensation. The best way to find out is to contact our attorneys for a free evaluation of your specific circumstances.",
  },
];

const PROCESS = [
  {
    n: "01",
    title: "Investigation & Case Review",
    body: "Our attorneys investigate the facts of your case, review medical records, and determine whether you have a viable claim. We identify the responsible parties and gather evidence of their negligence or wrongdoing.",
  },
  {
    n: "02",
    title: "Filing the Lawsuit",
    body: "Once we establish the merits of your case, we file the lawsuit on your behalf. In mass tort cases, your individual claim is filed alongside others; in class actions, representative plaintiffs are selected to lead the litigation.",
  },
  {
    n: "03",
    title: "Discovery & Litigation",
    body: "During discovery, both sides exchange evidence, depose witnesses, and retain expert consultants. This phase can reveal critical internal documents showing what corporations knew about the dangers of their products.",
  },
  {
    n: "04",
    title: "Resolution",
    body: "Cases may be resolved through a negotiated settlement, a bellwether trial verdict, or a global settlement fund. Our attorneys fight to maximize your compensation and will not settle for less than you deserve.",
  },
];

const ECONOMIC = [
  "Past and future medical expenses",
  "Lost wages or income",
  "Loss of earning capacity",
  "Cost of rehabilitation and physical therapy",
  "Assistive medical equipment",
  "Cost of long-term or lifelong care",
  "Out-of-pocket expenses related to injury",
];
const NON_ECONOMIC = [
  "Pain and suffering",
  "Mental and emotional distress",
  "Loss of companionship (spouse/family)",
  "Disability and disfigurement",
  "Loss of enjoyment of life",
  "Diminished quality of life",
];

export default async function ClassActionHubPage() {
  const firm = getFirmData();
  const cases = await getAllClassActions();

  const schemas = [
    breadcrumbSchema([
      { name: "Home", url: "/" },
      { name: "Class Action Lawyers", url: "/class-action-lawyers/" },
    ]),
    faqPageSchema(HUB_FAQS),
  ].filter(Boolean) as Record<string, unknown>[];

  return (
    <>
      <JsonLd data={schemas} />

      {/* ── Hero ─────────────────────────────────────────── */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-14">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Class Action Lawyers" }]} />
          <div className="grid lg:grid-cols-[1fr_360px] gap-12 lg:gap-[72px] items-start mt-4">
            <div>
              <p className="porch-eyebrow mb-4">Mass Torts &amp; Class Actions</p>
              <h1 className="font-heading font-normal text-ink text-[clamp(38px,6vw,80px)] leading-[1.01] tracking-[-0.02em] mb-6">
                Class action <span className="porch-em">lawyers</span> for Georgia &amp; South Carolina.
              </h1>
              <p className="font-heading text-[clamp(18px,2.2vw,22px)] leading-[1.5] text-ink-2 max-w-[58ch] mb-8">
                Our mass tort and class action attorneys represent individuals and families harmed by
                dangerous drugs, defective products, toxic chemicals, and corporate negligence. If you
                or a loved one has been affected, we can help you pursue the compensation you deserve.
              </p>
              <div className="grid grid-cols-3 gap-4 max-w-[520px] mb-8">
                {[
                  { v: firm.trustStats.recovered, l: "Recovered for clients" },
                  { v: `${firm.trustStats.rating}★`, l: "Client rating" },
                  { v: firm.trustStats.cases, l: "Cases handled" },
                ].map((s) => (
                  <div key={s.l} className="bg-paper border border-rule rounded-[16px] px-4 py-4 text-center">
                    <div className="font-heading text-[clamp(22px,3vw,30px)] text-ink leading-none mb-1.5">{s.v}</div>
                    <div className="text-[11px] text-slate leading-tight">{s.l}</div>
                  </div>
                ))}
              </div>
              <a
                href={`tel:${firm.phoneE164}`}
                className="inline-flex items-center gap-2 bg-terra text-paper font-bold px-8 py-3.5 rounded-full hover:bg-terra-deep transition-colors no-underline"
              >
                Call {firm.phone}
              </a>
            </div>
            <div className="hidden lg:block">
              <ContactForm variant="compact" />
            </div>
          </div>
        </div>
      </section>

      {/* ── Cases we handle ──────────────────────────────── */}
      <section className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-16">
        <div className="mb-9">
          <p className="porch-eyebrow mb-2">Active Investigations</p>
          <h2 className="font-heading text-[clamp(28px,4vw,46px)] leading-[1.05] tracking-[-0.02em] mb-3">
            Mass torts &amp; class actions <span className="porch-em">we handle.</span>
          </h2>
          <p className="text-slate text-[17px] max-w-[64ch]">
            Our attorneys are actively investigating and pursuing claims in the following cases. Select
            any case type to learn more about your legal options.
          </p>
        </div>

        {cases.length > 0 ? (
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            {cases.map((c: ClassActionListItem) => (
              <Link
                key={c._id}
                href={`/class-action-lawyers/${c.slug}/`}
                className="group flex flex-col bg-paper border border-rule rounded-[18px] p-6 no-underline hover:-translate-y-[3px] hover:shadow-[0_16px_40px_rgba(31,45,68,0.10)] transition-all"
              >
                <h3 className="font-heading font-medium text-[21px] leading-[1.2] text-ink group-hover:text-terra transition-colors mb-2">
                  {c.shortLabel || c.title}
                </h3>
                {c.summary && <p className="text-sm leading-[1.55] text-slate line-clamp-3 mb-4">{c.summary}</p>}
                <span className="mt-auto text-terra font-bold text-sm inline-flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                  Learn more &rarr;
                </span>
              </Link>
            ))}
          </div>
        ) : (
          <p className="text-slate">Case types coming soon.</p>
        )}
      </section>

      {/* ── What are mass torts / class actions ──────────── */}
      <section className="bg-cream border-y border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-16">
          <h2 className="font-heading text-[clamp(28px,4vw,44px)] leading-[1.05] tracking-[-0.02em] mb-6">
            What are mass torts &amp; <span className="porch-em">class actions?</span>
          </h2>
          <p className="text-[17px] leading-[1.6] text-ink-2 max-w-[72ch] mb-8">
            Mass torts and class action lawsuits allow large groups of people who have been harmed by the
            same product, drug, or corporate conduct to seek justice collectively. While often used
            interchangeably, these legal actions have important differences:
          </p>
          <div className="grid md:grid-cols-2 gap-6 mb-8">
            <div className="bg-paper border border-rule rounded-[18px] p-7">
              <h3 className="font-heading text-[22px] text-ink mb-2.5">Mass Tort</h3>
              <p className="text-[15px] leading-[1.6] text-ink-2">
                Each plaintiff files an individual lawsuit, but the cases are consolidated for efficiency.
                Each person&apos;s injuries and damages are evaluated separately, which often results in
                higher individual compensation.
              </p>
            </div>
            <div className="bg-paper border border-rule rounded-[18px] p-7">
              <h3 className="font-heading text-[22px] text-ink mb-2.5">Class Action</h3>
              <p className="text-[15px] leading-[1.6] text-ink-2">
                A single lawsuit is filed on behalf of an entire group (the &ldquo;class&rdquo;). One or more
                representative plaintiffs stand in for the group, and any settlement or verdict is divided
                among all class members.
              </p>
            </div>
          </div>
          <p className="text-[17px] leading-[1.6] text-ink-2 max-w-[72ch]">
            Both types of litigation are powerful tools for holding corporations accountable when their
            products or actions cause widespread harm. At Roden Law, our attorneys have the experience and
            resources to take on large corporations and fight for the compensation our clients deserve.
          </p>
        </div>
      </section>

      {/* ── How it works ─────────────────────────────────── */}
      <section className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-16">
        <h2 className="font-heading text-[clamp(28px,4vw,44px)] leading-[1.05] tracking-[-0.02em] mb-9">
          How class action lawsuits <span className="porch-em">work.</span>
        </h2>
        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {PROCESS.map((step) => (
            <div key={step.n} className="border-t-2 border-rule pt-5">
              <div className="font-heading italic text-[44px] text-honey-deep leading-none mb-3">{step.n}</div>
              <h3 className="font-heading text-[20px] text-ink leading-[1.15] mb-2.5">{step.title}</h3>
              <p className="text-sm leading-[1.55] text-slate">{step.body}</p>
            </div>
          ))}
        </div>
      </section>

      {/* ── Compensation ─────────────────────────────────── */}
      <section className="bg-cream border-y border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-16">
          <h2 className="font-heading text-[clamp(28px,4vw,44px)] leading-[1.05] tracking-[-0.02em] mb-9">
            Types of compensation you can <span className="porch-em">recover.</span>
          </h2>
          <div className="grid md:grid-cols-2 gap-6">
            {[
              { t: "Economic Damages", items: ECONOMIC },
              { t: "Non-Economic Damages", items: NON_ECONOMIC },
            ].map((col) => (
              <div key={col.t} className="bg-paper border border-rule rounded-[18px] p-7">
                <h3 className="font-heading text-[22px] text-ink mb-4">{col.t}</h3>
                <ul className="space-y-2.5">
                  {col.items.map((it) => (
                    <li key={it} className="flex items-start gap-2.5 text-[15px] text-ink-2">
                      <span className="mt-2 w-1.5 h-1.5 rounded-full bg-terra shrink-0" aria-hidden="true" />
                      {it}
                    </li>
                  ))}
                </ul>
              </div>
            ))}
          </div>
          <p className="text-sm italic text-slate mt-6 max-w-[72ch]">
            Compensation amounts vary by case type and individual circumstances. Mass tort claims are
            evaluated individually, which often allows for higher recovery than class action settlements.
          </p>
        </div>
      </section>

      {/* ── FAQ + intake ─────────────────────────────────── */}
      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[72px]">
        <div className="grid lg:grid-cols-[1fr_340px] gap-12 lg:gap-[64px]">
          <div className="min-w-0">
            <h2 className="font-heading text-[clamp(26px,3.5vw,40px)] leading-[1.05] tracking-[-0.02em] mb-7">
              Frequently asked <span className="porch-em">questions.</span>
            </h2>
            <FaqAccordion faqs={HUB_FAQS} />
            <BottomCta heading="Harmed by a dangerous product or drug? Get your free case review." />
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
