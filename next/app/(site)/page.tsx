import Link from "next/link";
import Image from "next/image";
import { getFirmData } from "@/lib/firm-data";
import { getCaseResults } from "@/lib/queries/shared";
import { getAllAttorneys } from "@/lib/queries/attorney";
import { urlForImage } from "@/sanity/lib/image";
import { ContactForm } from "@/components/shared/ContactForm";
import { ReviewsBlock } from "@/components/sections/ReviewsBlock";
import { StickyMobileCta } from "@/components/sections/StickyMobileCta";
import { PorchPlaceholder } from "@/components/porch/PorchPlaceholder";
import { JsonLd } from "@/components/shared/JsonLd";
import { homepageSchema } from "@/lib/schema";

export const revalidate = 3600;

const FEATURED_PAS = [
  { name: "Car Accidents", slug: "car-accident-lawyers", copy: "Rear-end, intersection, DUI, and hit-and-run crashes across GA & SC." },
  { name: "Truck Accidents", slug: "truck-accident-lawyers", copy: "Commercial trucks, FMCSA violations, and the evidence that disappears fast." },
  { name: "Motorcycle Accidents", slug: "motorcycle-accident-lawyers", copy: "Rider-bias, helmet-defense rebuttals, and serious-injury claims." },
  { name: "Wrongful Death", slug: "wrongful-death-lawyers", copy: "Holding negligent parties accountable when a family loses a loved one." },
  { name: "Slip & Fall", slug: "slip-and-fall-lawyers", copy: "Premises liability against stores, landlords, and property owners." },
  { name: "Workers' Comp", slug: "workers-compensation-lawyers", copy: "On-the-job injuries, denied claims, and the benefits you're owed." },
  { name: "Pedestrian Accidents", slug: "pedestrian-accident-lawyers", copy: "Crosswalk and right-of-way crashes that leave lasting injuries." },
  { name: "Medical Malpractice", slug: "medical-malpractice-lawyers", copy: "Misdiagnosis, surgical errors, and negligent care." },
];

const STEPS = [
  { n: "01", h: "Tell us what happened", p: "Call any office or fill out the form. We'll listen, ask the right questions, and tell you straight whether you have a case." },
  { n: "02", h: "We build the case", p: "Our attorneys investigate, gather records, line up experts, and handle every call from the insurance company." },
  { n: "03", h: "You get paid", p: "We negotiate hard for the most we can recover. No fee until we win — and our fee comes out of the recovery." },
];

const PERKS = [
  { icon: "☎", b: "Call 844-RESULTS", s: "Senior attorney on the line, 24/7" },
  { icon: "✉", b: "intake@rodenlaw.com", s: "Written reply within the hour" },
  { icon: "📍", b: "Six offices, GA & SC", s: "Savannah · Darien · Charleston · Columbia · Myrtle Beach · N. Charleston" },
];

export default async function HomePage() {
  const firm = getFirmData();
  const stats = firm.trustStats;
  const caseResults = (await getCaseResults(4)) ?? [];
  const attorneys = ((await getAllAttorneys()) ?? []).slice(0, 4);

  return (
    <>
      <JsonLd data={homepageSchema()} />

      {/* ── Hero ─────────────────────────────────────────── */}
      <section className="porch-glow">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-16 pb-20 lg:pb-24">
          <div className="grid lg:grid-cols-[1.05fr_.95fr] gap-12 lg:gap-16 items-center">
            <div>
              <p className="porch-eyebrow mb-5">A Family-Run Firm · Coastal Georgia &amp; The Carolinas</p>
              <h1 className="font-heading font-normal text-ink text-[clamp(44px,6vw,80px)] leading-[1.05] tracking-[-0.02em] mb-8">
                When the worst happens,<br />
                <span className="porch-em">we pick up</span><br />
                <span className="porch-ho">the phone.</span>
              </h1>
              <p className="text-[19px] leading-[1.55] text-ink-2 max-w-[52ch] mb-9">
                For years, our attorneys have helped injured neighbors across Georgia and the Carolinas
                get back on their feet — recovering <b className="font-bold text-ink">more than {stats.recovered.replace("+", " million")}</b>{" "}
                for clients we treat like family.
              </p>
              <div className="flex flex-wrap items-center gap-3.5 mb-12">
                <Link href="#free-case-review" className="inline-flex items-center gap-3 px-7 py-4 rounded-full bg-terra text-paper font-bold hover:bg-terra-deep transition-colors no-underline">
                  Get your free case review <span aria-hidden="true">→</span>
                </Link>
                <a href={`tel:${firm.phoneE164}`} className="inline-flex items-center gap-2 px-7 py-4 rounded-full border-[1.5px] border-ink text-ink font-bold hover:bg-ink hover:text-cream transition-colors no-underline">
                  ☎ Call {firm.vanityPhone}
                </a>
              </div>
              <div className="flex flex-wrap gap-10 px-9 py-8 bg-paper border border-rule rounded-[24px] shadow-[0_10px_30px_rgba(31,45,68,0.06)] max-w-[620px]">
                {[
                  { n: stats.recovered, l: "Recovered for clients" },
                  { n: stats.cases, l: "Cases" },
                  { n: `${stats.rating}★`, l: `${stats.reviews} reviews` },
                ].map((s) => (
                  <div key={s.l}>
                    <div className="font-heading text-[38px] font-medium leading-none text-ink">{s.n}</div>
                    <div className="text-xs font-bold tracking-[0.1em] uppercase text-slate mt-2">{s.l}</div>
                  </div>
                ))}
              </div>
            </div>

            {/* Hero photo stack */}
            <div className="relative aspect-[4/5] w-full max-w-[460px] mx-auto">
              <div className="absolute top-7 left-2 lg:-left-7 z-20 flex items-center gap-3 bg-paper rounded-full px-5 py-3 shadow-[0_8px_24px_rgba(31,45,68,0.12)] text-[13px] font-bold">
                <span className="text-honey tracking-widest">★★★★★</span>
                <span>{stats.reviews} five-star reviews</span>
              </div>
              <div className="porch-frame absolute inset-0">
                <PorchPlaceholder label="Founder portrait · 4:5" variant="dark" />
                <div className="absolute bottom-6 left-6 right-6 z-20 bg-ink/85 text-cream px-5 py-4 rounded-[14px] text-[13px] leading-[1.45] backdrop-blur-sm">
                  <b className="text-honey">Eric Roden</b> — founding partner. &ldquo;Our job is to make sure you can focus on getting better.&rdquo;
                </div>
              </div>
              <div className="absolute right-2 lg:-right-6 bottom-8 z-20 flex items-center gap-3.5 bg-paper border border-rule rounded-[16px] px-5 py-4 shadow-[0_12px_32px_rgba(31,45,68,0.14)]">
                <div className="font-heading italic text-[38px] leading-none text-honey-deep">{firm.founded}</div>
                <div className="text-[11px] font-extrabold tracking-[0.12em] uppercase text-ink leading-[1.3]">
                  Serving the<br />coast<span className="block text-slate font-semibold tracking-[0.06em] normal-case">since {firm.founded}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* ── How it works ─────────────────────────────────── */}
      <section className="bg-paper border-t border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[88px]">
          <div className="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-14">
            <h2 className="font-heading text-[44px] leading-[1.05] max-w-[18ch]">How it works — <span className="porch-em">three simple steps.</span></h2>
            <p className="text-slate max-w-[36ch] text-base">From the first call to your final check, you&apos;ll work with one team that knows your name and your case.</p>
          </div>
          <div className="grid md:grid-cols-3 gap-6">
            {STEPS.map((s) => (
              <div key={s.n} className="bg-cream border border-rule rounded-[24px] p-9 min-h-[220px] flex flex-col">
                <span className="font-heading italic text-honey text-[72px] font-medium leading-none mb-7">{s.n}</span>
                <h3 className="font-heading text-[26px] mb-2.5">{s.h}</h3>
                <p className="text-slate text-sm leading-[1.6]">{s.p}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* ── Practice areas ───────────────────────────────── */}
      <section className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[120px]">
        <div className="grid md:grid-cols-2 gap-14 items-end mb-14">
          <div>
            <p className="porch-eyebrow mb-2">Practice Areas</p>
            <h2 className="font-heading text-[clamp(36px,4vw,56px)] leading-[1.04]">We help with most kinds of <span className="porch-em">personal injury.</span></h2>
          </div>
          <p className="text-slate max-w-[50ch] text-[17px] leading-[1.6]">Whatever happened, there&apos;s a chance we can help — or point you toward someone who can. Calls are always free.</p>
        </div>
        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
          {FEATURED_PAS.map((p, i) => (
            <Link
              key={p.slug}
              href={`/practice-areas/${p.slug}/`}
              className="group bg-paper border border-rule rounded-[20px] p-6 min-h-[220px] flex flex-col hover:-translate-y-[3px] hover:shadow-[0_12px_32px_rgba(31,45,68,0.10)] transition-all no-underline"
            >
              <div className="flex items-baseline justify-between pb-3 mb-5 border-b border-rule">
                <span className="font-heading italic text-[13px] text-honey-deep">Nº {String(i + 1).padStart(2, "0")}</span>
                <span className="w-1.5 h-1.5 rounded-full bg-honey" aria-hidden="true" />
              </div>
              <h3 className="font-heading text-[21px] leading-[1.15] tracking-[-0.01em] mb-2">{p.name}</h3>
              <p className="text-slate text-sm leading-[1.55] grow">{p.copy}</p>
              <span className="text-terra text-sm font-semibold mt-4 group-hover:translate-x-1 transition-transform inline-block">Learn more →</span>
            </Link>
          ))}
        </div>
      </section>

      {/* ── Founder ──────────────────────────────────────── */}
      <section className="bg-ink text-cream">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[100px]">
          <div className="grid lg:grid-cols-2 gap-14 items-center">
            <div className="relative aspect-[4/5] max-w-[460px] w-full mx-auto porch-frame">
              <PorchPlaceholder label="Founder · environmental · 4:5" variant="dark" />
              <div className="absolute inset-0 flex items-center justify-center z-20">
                <span className="w-[72px] h-[72px] rounded-full bg-paper/95 text-ink flex items-center justify-center shadow-lg" aria-hidden="true">
                  <svg viewBox="0 0 24 24" fill="currentColor" width="26" height="26"><path d="M6 4.5v15a1 1 0 0 0 1.55.83l11-7.5a1 1 0 0 0 0-1.66l-11-7.5A1 1 0 0 0 6 4.5z" /></svg>
                </span>
              </div>
              <div className="absolute bottom-5 left-5 right-5 z-20 bg-ink/80 backdrop-blur-sm rounded-[14px] px-5 py-3">
                <div className="font-semibold text-cream text-sm">Eric Roden <span className="text-honey text-[11px] font-bold tracking-widest ml-1">FOUNDING PARTNER</span></div>
                <div className="text-cream/60 text-xs mt-0.5">Admitted in Georgia, South Carolina &amp; Federal Courts</div>
              </div>
            </div>
            <div>
              <p className="porch-eyebrow mb-6">From the founder</p>
              <blockquote className="font-heading text-[clamp(24px,3vw,34px)] leading-[1.3] text-cream m-0 border-0 bg-transparent p-0">
                I started Roden Law because I saw too many injury victims get lowballed by insurance
                companies. Our team fights for every dollar you deserve — and we don&apos;t get paid unless you do.
              </blockquote>
              <div className="flex items-center gap-3 mt-7">
                <span className="w-11 h-11 rounded-full bg-honey text-ink font-heading italic flex items-center justify-center" aria-hidden="true">R</span>
                <div>
                  <div className="font-semibold text-cream">Eric Roden</div>
                  <div className="text-cream/60 text-sm">Founding Partner, Roden Law · Savannah, GA</div>
                </div>
              </div>
              <div className="grid sm:grid-cols-3 gap-6 mt-10 pt-8 border-t border-cream/15">
                <div><h4 className="font-heading text-honey text-lg mb-1">{stats.recovered} recovered</h4><p className="text-cream/60 text-sm">Across {stats.cases} cases in Georgia and the Carolinas.</p></div>
                <div><h4 className="font-heading text-honey text-lg mb-1">No upfront cost</h4><p className="text-cream/60 text-sm">You pay nothing unless we recover money for you.</p></div>
                <div><h4 className="font-heading text-honey text-lg mb-1">{stats.offices} local offices</h4><p className="text-cream/60 text-sm">Real attorneys in your county, not a call center.</p></div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* ── Results ──────────────────────────────────────── */}
      <section className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[120px]">
        <div className="grid md:grid-cols-2 gap-14 items-end mb-14">
          <div>
            <p className="porch-eyebrow mb-2">Recent Results</p>
            <h2 className="font-heading text-[clamp(36px,4vw,56px)] leading-[1.04]">Real cases. <span className="porch-em">Real recoveries.</span></h2>
          </div>
          <p className="text-slate max-w-[50ch] text-[17px] leading-[1.6]">A snapshot of recent outcomes. Every case is different, but the pattern is the same: we prepare like we&apos;re going to trial, and the carriers respond.</p>
        </div>
        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
          {caseResults.map((r: { _id: string; slug: string; amount?: string; resultType?: string; title: string }, i: number) => (
            <Link
              key={r._id}
              href={`/case-results/${r.slug}/`}
              className={`flex flex-col justify-between rounded-[20px] p-7 min-h-[230px] border no-underline transition-all hover:-translate-y-[3px] ${
                i === 0 ? "bg-ink border-ink text-cream" : "bg-paper border-rule"
              }`}
            >
              <div>
                {r.resultType && <div className={`text-[11px] uppercase tracking-[0.12em] font-bold mb-3 ${i === 0 ? "text-honey" : "text-terra"}`}>{r.resultType}</div>}
                <div className={`font-heading text-[40px] font-medium leading-none mb-3 ${i === 0 ? "text-honey" : "text-ink"}`}>{r.amount}</div>
                <div className={`text-sm leading-[1.5] ${i === 0 ? "text-cream/75" : "text-slate"}`}>{r.title}</div>
              </div>
              <div className={`flex items-center justify-between text-xs mt-4 pt-4 border-t ${i === 0 ? "border-cream/20 text-cream/60" : "border-rule text-slate"}`}>
                <span>Verified outcome</span><span className="font-semibold">View →</span>
              </div>
            </Link>
          ))}
        </div>
      </section>

      {/* ── Locations ────────────────────────────────────── */}
      <section className="bg-paper border-y border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[100px]">
          <div className="grid md:grid-cols-2 gap-14 items-end mb-14">
            <div>
              <p className="porch-eyebrow mb-2">Our Offices</p>
              <h2 className="font-heading text-[clamp(36px,4vw,56px)] leading-[1.04]">Six places to find us — <span className="porch-em">all close to home.</span></h2>
            </div>
            <p className="text-slate max-w-[50ch] text-[17px] leading-[1.6]">Drop in, give a call, or schedule a visit. Wherever you live in coastal Georgia or South Carolina, there&apos;s an attorney nearby.</p>
          </div>
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {Object.values(firm.offices).map((office) => (
              <Link
                key={office.slug}
                href={`/locations/${office.stateSlug}/${office.slug.replace(/-[a-z]{2}$/, "")}/`}
                className="group bg-cream border border-rule rounded-[24px] overflow-hidden no-underline hover:-translate-y-[3px] hover:shadow-[0_12px_32px_rgba(31,45,68,0.10)] transition-all"
              >
                <div className="h-40 relative">
                  <PorchPlaceholder label={`${office.marketName} · skyline`} variant="warm" />
                </div>
                <div className="p-6">
                  <span className="text-[11px] font-bold uppercase tracking-[0.12em] text-terra">{office.stateFull}</span>
                  <h3 className="font-heading text-[22px] mt-1 mb-2 group-hover:text-terra transition-colors">{office.marketName}</h3>
                  <div className="text-slate text-sm leading-[1.5]">{office.street}<br />{office.city}, {office.state} {office.zip}</div>
                  <div className="text-ink font-semibold text-sm mt-2">☎ {office.phone}</div>
                </div>
              </Link>
            ))}
          </div>
        </div>
      </section>

      {/* ── Attorneys ────────────────────────────────────── */}
      <section className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[120px]">
        <div className="grid md:grid-cols-2 gap-14 items-end mb-14">
          <div>
            <p className="porch-eyebrow mb-2">Meet the team</p>
            <h2 className="font-heading text-[clamp(36px,4vw,56px)] leading-[1.04]">Lawyers who&apos;ll <span className="porch-em">know your name.</span></h2>
          </div>
          <p className="text-slate max-w-[50ch] text-[17px] leading-[1.6]">You won&apos;t get bounced between case managers and junior associates. From your first call, you work with the attorneys representing you.</p>
        </div>
        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {attorneys.map((a: { _id: string; slug: string; name: string; jobTitle?: string; barAdmissions?: string; headshot?: { asset?: { _ref?: string } } }) => {
            const img = a.headshot ? urlForImage(a.headshot)?.width(420).height(520).url() : null;
            return (
              <Link key={a._id} href={`/attorneys/${a.slug}/`} className="group no-underline">
                <div className="relative aspect-[4/5] rounded-[20px] overflow-hidden border border-rule mb-4">
                  {a.jobTitle && <span className="absolute top-3 left-3 z-10 bg-paper/90 text-ink text-[10px] font-bold uppercase tracking-[0.1em] px-2.5 py-1 rounded-full">{a.jobTitle.split(",")[0]}</span>}
                  {img ? (
                    <Image src={img} alt={a.name} width={420} height={520} className="w-full h-full object-cover" />
                  ) : (
                    <PorchPlaceholder label={`${a.name.split(" ")[0]} · portrait`} variant="warm" />
                  )}
                </div>
                <h3 className="font-heading text-[20px] group-hover:text-terra transition-colors">{a.name}</h3>
                {a.jobTitle && <div className="text-slate text-sm">{a.jobTitle}</div>}
              </Link>
            );
          })}
        </div>
      </section>

      {/* ── Testimonials ─────────────────────────────────── */}
      <ReviewsBlock />

      {/* ── Final CTA + intake form ──────────────────────── */}
      <section id="free-case-review" className="bg-terra text-paper scroll-mt-20">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[100px]">
          <div className="grid lg:grid-cols-2 gap-14 items-center">
            <div>
              <p className="text-[12px] font-bold tracking-[0.18em] uppercase text-paper/80 mb-4">Free 24/7 · No fee unless we win</p>
              <h2 className="font-heading text-[clamp(32px,4vw,48px)] leading-[1.1] text-paper mb-5">
                You take care of <span className="italic">getting better.</span><br />
                We&apos;ll take care of <span className="italic">everything else.</span>
              </h2>
              <p className="text-paper/85 text-[17px] leading-[1.6] mb-8 max-w-[46ch]">
                Free 24/7 consultations across Georgia and South Carolina. A senior attorney will respond within the hour — and we don&apos;t get paid unless you do.
              </p>
              <ul className="space-y-4 list-none m-0 p-0">
                {PERKS.map((perk) => (
                  <li key={perk.b} className="flex items-start gap-4">
                    <span className="text-2xl shrink-0" aria-hidden="true">{perk.icon}</span>
                    <div>
                      <b className="block text-paper">{perk.b}</b>
                      <span className="text-paper/75 text-sm">{perk.s}</span>
                    </div>
                  </li>
                ))}
              </ul>
            </div>
            <ContactForm variant="wide" ribbonLabel="Free Case Review" heading="Tell us what happened." sub="A senior attorney will respond within the hour." />
          </div>
        </div>
      </section>

      <StickyMobileCta />
    </>
  );
}
