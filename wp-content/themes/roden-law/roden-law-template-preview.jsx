import { useState } from "react";

const NAVY = "#1B3A6B";
const ORANGE = "#E85C1F";
const LIGHT = "#F8F6F2";
const GREEN = "#27AE60";

// ─── Shared Components ─────────────────────────────────────────────────────

function NavBar() {
  return (
    <nav style={{
      background: "#fff",
      borderBottom: `3px solid ${ORANGE}`,
      display: "flex", alignItems: "center", justifyContent: "space-between",
      padding: "0 32px", height: 64, position: "sticky", top: 0, zIndex: 50,
      boxShadow: "0 2px 16px rgba(0,0,0,0.08)"
    }}>
      <div style={{ display: "flex", alignItems: "center", gap: 8 }}>
        <div style={{
          width: 36, height: 36, background: NAVY, borderRadius: 4,
          display: "flex", alignItems: "center", justifyContent: "center",
          color: "#fff", fontWeight: 900, fontSize: 14, fontFamily: "serif"
        }}>R</div>
        <div>
          <div style={{ fontWeight: 800, fontSize: 16, color: NAVY, letterSpacing: "-0.3px", fontFamily: "Georgia, serif" }}>RODEN LAW</div>
          <div style={{ fontSize: 9, color: "#888", letterSpacing: "1.5px", textTransform: "uppercase" }}>Personal Injury Attorneys</div>
        </div>
      </div>
      <div style={{ display: "flex", gap: 24, fontSize: 13, fontWeight: 600, color: NAVY }}>
        {["Practice Areas","Locations","Attorneys","Results","About"].map(l => (
          <span key={l} style={{ cursor: "pointer", padding: "4px 0", borderBottom: l==="Practice Areas" ? `2px solid ${ORANGE}` : "2px solid transparent" }}>{l}</span>
        ))}
      </div>
      <a href="#" style={{
        background: ORANGE, color: "#fff", padding: "10px 22px", borderRadius: 4,
        fontSize: 13, fontWeight: 700, textDecoration: "none", letterSpacing: "0.3px"
      }}>1-844-RESULTS</a>
    </nav>
  );
}

function FooterBar() {
  const offices = [
    { city: "Savannah, GA", phone: "(912) 303-5850" },
    { city: "Darien, GA",   phone: "(912) 303-5850" },
    { city: "Charleston, SC", phone: "(843) 790-8999" },
    { city: "Columbia, SC", phone: "(803) 219-2816" },
    { city: "Myrtle Beach, SC", phone: "(843) 612-1980" },
  ];
  return (
    <footer style={{ background: NAVY, color: "#fff", padding: "48px 32px 24px" }}>
      <div style={{ display: "grid", gridTemplateColumns: "2fr 1fr 1fr 1fr", gap: 32, maxWidth: 960, margin: "0 auto" }}>
        <div>
          <div style={{ fontFamily: "Georgia, serif", fontSize: 20, fontWeight: 700, marginBottom: 12 }}>Roden Law</div>
          <p style={{ fontSize: 13, color: "#aab4c8", lineHeight: 1.7 }}>$250M+ recovered for injury victims across Georgia and South Carolina. No fees unless we win.</p>
          <div style={{ display: "flex", gap: 12, marginTop: 16 }}>
            {["f","in","x","▶"].map(s => (
              <div key={s} style={{ width: 32, height: 32, background: "rgba(255,255,255,0.1)", borderRadius: 4, display: "flex", alignItems: "center", justifyContent: "center", fontSize: 12, cursor: "pointer" }}>{s}</div>
            ))}
          </div>
        </div>
        <div>
          <div style={{ fontWeight: 700, fontSize: 12, letterSpacing: "1px", textTransform: "uppercase", color: ORANGE, marginBottom: 12 }}>Practice Areas</div>
          {["Car Accident","Truck Accident","Slip & Fall","Medical Malpractice","Wrongful Death"].map(p => (
            <div key={p} style={{ fontSize: 12, color: "#aab4c8", marginBottom: 6, cursor: "pointer" }}>→ {p}</div>
          ))}
        </div>
        <div>
          <div style={{ fontWeight: 700, fontSize: 12, letterSpacing: "1px", textTransform: "uppercase", color: ORANGE, marginBottom: 12 }}>Our Offices</div>
          {offices.map(o => (
            <div key={o.city} style={{ marginBottom: 8 }}>
              <div style={{ fontSize: 12, color: "#fff", fontWeight: 600 }}>{o.city}</div>
              <div style={{ fontSize: 11, color: "#aab4c8" }}>{o.phone}</div>
            </div>
          ))}
        </div>
        <div>
          <div style={{ fontWeight: 700, fontSize: 12, letterSpacing: "1px", textTransform: "uppercase", color: ORANGE, marginBottom: 12 }}>Free Review</div>
          <div style={{ background: "rgba(255,255,255,0.07)", border: "1px solid rgba(255,255,255,0.12)", borderRadius: 8, padding: 16 }}>
            <input placeholder="Name" style={{ width: "100%", background: "transparent", border: "1px solid rgba(255,255,255,0.2)", borderRadius: 4, color: "#fff", padding: "8px 10px", fontSize: 12, marginBottom: 8, boxSizing: "border-box" }} />
            <input placeholder="Phone" style={{ width: "100%", background: "transparent", border: "1px solid rgba(255,255,255,0.2)", borderRadius: 4, color: "#fff", padding: "8px 10px", fontSize: 12, marginBottom: 8, boxSizing: "border-box" }} />
            <button style={{ width: "100%", background: ORANGE, color: "#fff", border: "none", padding: "10px", borderRadius: 4, fontWeight: 700, fontSize: 12, cursor: "pointer" }}>Get Free Review</button>
          </div>
        </div>
      </div>
      <div style={{ borderTop: "1px solid rgba(255,255,255,0.1)", marginTop: 32, paddingTop: 16, maxWidth: 960, margin: "32px auto 0", fontSize: 11, color: "#7a8aa0", textAlign: "center" }}>
        © 2026 Roden Love LLC. All Rights Reserved | Licensed in Georgia & South Carolina
      </div>
    </footer>
  );
}

function SchemaBadge({ label }) {
  return (
    <span style={{
      display: "inline-flex", alignItems: "center", gap: 4,
      background: "#e8f5e9", border: "1px solid #a5d6a7",
      color: "#2e7d32", fontSize: 10, padding: "2px 7px", borderRadius: 999,
      fontWeight: 600, letterSpacing: "0.3px"
    }}>
      <span style={{ fontSize: 9 }}>✓ schema</span> {label}
    </span>
  );
}

function ContactForm({ localPhone }) {
  return (
    <div style={{ background: NAVY, borderRadius: 12, padding: 24, color: "#fff" }}>
      <div style={{ fontWeight: 800, fontSize: 16, marginBottom: 4, fontFamily: "Georgia, serif" }}>Free Case Review</div>
      <div style={{ fontSize: 12, color: "#aab4c8", marginBottom: 20 }}>No fees unless we win • Available 24/7</div>
      {["Full Name","Phone Number","Email","ZIP Code"].map(f => (
        <input key={f} placeholder={f} style={{
          width: "100%", background: "rgba(255,255,255,0.1)", border: "1px solid rgba(255,255,255,0.2)",
          borderRadius: 6, color: "#fff", padding: "11px 14px", fontSize: 13, marginBottom: 10,
          boxSizing: "border-box"
        }} />
      ))}
      <textarea placeholder="Briefly describe what happened..." rows={3} style={{
        width: "100%", background: "rgba(255,255,255,0.1)", border: "1px solid rgba(255,255,255,0.2)",
        borderRadius: 6, color: "#fff", padding: "11px 14px", fontSize: 13, marginBottom: 12,
        boxSizing: "border-box", resize: "none"
      }} />
      <button style={{ width: "100%", background: ORANGE, color: "#fff", border: "none", padding: "14px", borderRadius: 6, fontWeight: 700, fontSize: 14, cursor: "pointer", marginBottom: 8 }}>
        Submit Free Review
      </button>
      <div style={{ textAlign: "center", fontSize: 11, color: "#aab4c8" }}>
        — or call {localPhone || "1-844-RESULTS"} —
      </div>
    </div>
  );
}

function Stars({ n = 4.9, small }) {
  return (
    <div style={{ display: "flex", alignItems: "center", gap: 4 }}>
      {[1,2,3,4,5].map(i => (
        <span key={i} style={{ color: "#f59e0b", fontSize: small ? 12 : 16 }}>★</span>
      ))}
      <span style={{ fontSize: small ? 11 : 13, color: "#888", marginLeft: 4 }}>{n} ({small ? "500+" : "500+ reviews"})</span>
    </div>
  );
}

// ─── HOMEPAGE ──────────────────────────────────────────────────────────────

function HomepageTemplate() {
  const stats = [
    { num: "$250M+", label: "Recovered for Clients" },
    { num: "4.9★",   label: "Client Rating" },
    { num: "5,000+", label: "Cases Handled" },
    { num: "62 Yrs", label: "Combined Experience" },
  ];
  const practiceAreas = [
    "Car Accident","Truck Accident","Slip & Fall","Motorcycle Accident",
    "Medical Malpractice","Wrongful Death","Workers' Comp","Dog Bite",
    "Brain Injury","Spinal Cord Injury","Maritime","Product Liability",
    "Boating Accident","Burn Injury","Construction Accident","Nursing Home Abuse",
  ];
  const offices = [
    { city: "Savannah", state: "GA", address: "333 Commercial Dr.", phone: "(912) 303-5850" },
    { city: "Darien",   state: "GA", address: "1108 North Way",     phone: "(912) 303-5850" },
    { city: "Charleston",state:"SC", address: "127 King St., Ste 200", phone: "(843) 790-8999" },
    { city: "Columbia", state: "SC", address: "1545 Sumter St., Ste B", phone: "(803) 219-2816" },
    { city: "Myrtle Beach",state:"SC",address:"631 Bellamy Ave., Ste C-B",phone:"(843) 612-1980" },
  ];
  const results = [
    { type:"Truck Accident",   amount:"$27,000,000", label:"Settlement" },
    { type:"Product Liability",amount:"$10,860,000", label:"Verdict" },
    { type:"Premises Liability",amount:"$9,800,000", label:"Recovery" },
    { type:"Auto Accident",    amount:"$3,000,000",  label:"Settlement" },
  ];

  return (
    <div style={{ fontFamily: "'Merriweather Sans', Georgia, sans-serif", background: "#fff" }}>

      {/* HERO */}
      <section style={{
        background: `linear-gradient(135deg, ${NAVY} 0%, #0f2347 60%, #1a3a6b 100%)`,
        padding: "80px 32px",
        position: "relative", overflow: "hidden"
      }}>
        <div style={{
          position: "absolute", top: 0, right: 0, width: "45%", height: "100%",
          background: "linear-gradient(to left, rgba(232,92,31,0.15), transparent)"
        }} />
        <div style={{ display: "grid", gridTemplateColumns: "1fr 380px", gap: 48, maxWidth: 960, margin: "0 auto", alignItems: "center" }}>
          <div>
            <div style={{ display: "flex", gap: 8, marginBottom: 20 }}>
              <SchemaBadge label="Organization" />
              <SchemaBadge label="LegalService" />
              <SchemaBadge label="Speakable" />
            </div>
            <h1 style={{
              color: "#fff", fontSize: 40, fontWeight: 900, lineHeight: 1.15,
              fontFamily: "Georgia, serif", marginBottom: 20
            }}>
              Georgia & South Carolina<br />
              <span style={{ color: ORANGE }}>Personal Injury Lawyers</span><br />
              Who Fight for Maximum Compensation
            </h1>
            <p style={{ color: "#aab4c8", fontSize: 16, lineHeight: 1.7, marginBottom: 28, maxWidth: 540 }}>
              Roden Law has recovered <strong style={{ color: "#fff" }}>$250M+</strong> for injury victims across Savannah, Charleston, Columbia, Myrtle Beach, and Darien. No fees unless we win. Free case review 24/7.
            </p>
            <div style={{ display: "grid", gridTemplateColumns: "repeat(4, 1fr)", gap: 16, marginBottom: 32 }}>
              {stats.map(s => (
                <div key={s.num} style={{ textAlign: "center", borderLeft: `3px solid ${ORANGE}`, paddingLeft: 12 }}>
                  <div style={{ color: ORANGE, fontWeight: 900, fontSize: 22, fontFamily: "Georgia, serif" }}>{s.num}</div>
                  <div style={{ color: "#aab4c8", fontSize: 11, marginTop: 2 }}>{s.label}</div>
                </div>
              ))}
            </div>
            <div style={{ display: "flex", gap: 12 }}>
              <button style={{ background: ORANGE, color: "#fff", border: "none", padding: "16px 32px", borderRadius: 6, fontWeight: 700, fontSize: 15, cursor: "pointer" }}>
                📞 Call 1-844-RESULTS
              </button>
              <button style={{ background: "transparent", color: "#fff", border: "2px solid rgba(255,255,255,0.3)", padding: "16px 28px", borderRadius: 6, fontWeight: 600, fontSize: 15, cursor: "pointer" }}>
                Free Case Review
              </button>
            </div>
          </div>
          <ContactForm />
        </div>
      </section>

      {/* TRUST BAR */}
      <div style={{ background: NAVY, padding: "16px 32px", borderBottom: `3px solid ${ORANGE}` }}>
        <div style={{ display: "flex", gap: 40, maxWidth: 960, margin: "0 auto", alignItems: "center", justifyContent: "center" }}>
          {["State Bar of Georgia","American Association for Justice","Georgia Trial Lawyers","American Bar Association"].map(b => (
            <div key={b} style={{ display: "flex", alignItems: "center", gap: 8 }}>
              <div style={{ width: 32, height: 32, background: "rgba(255,255,255,0.15)", borderRadius: "50%", display: "flex", alignItems: "center", justifyContent: "center", fontSize: 14 }}>⚖</div>
              <div style={{ fontSize: 11, color: "#aab4c8", fontWeight: 600 }}>{b}</div>
            </div>
          ))}
        </div>
      </div>

      {/* PRACTICE AREAS */}
      <section style={{ padding: "64px 32px", background: LIGHT }}>
        <div style={{ maxWidth: 960, margin: "0 auto" }}>
          <div style={{ textAlign: "center", marginBottom: 40 }}>
            <h2 style={{ fontSize: 30, fontWeight: 800, color: NAVY, fontFamily: "Georgia, serif" }}>Personal Injury Practice Areas</h2>
            <p style={{ color: "#666", fontSize: 15, marginTop: 8 }}>We handle all types of personal injury cases throughout Georgia and South Carolina.</p>
          </div>
          <div style={{ display: "grid", gridTemplateColumns: "repeat(4, 1fr)", gap: 12 }}>
            {practiceAreas.map(pa => (
              <div key={pa} style={{
                background: "#fff", border: `1px solid #e0e0e0`, borderRadius: 8, padding: "16px 14px",
                cursor: "pointer", transition: "all 0.2s",
                borderTop: `3px solid ${ORANGE}`,
                display: "flex", alignItems: "center", gap: 10
              }}>
                <span style={{ fontSize: 18 }}>⚖</span>
                <span style={{ fontSize: 13, fontWeight: 600, color: NAVY }}>{pa}</span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* LOCATIONS */}
      <section style={{ padding: "64px 32px" }}>
        <div style={{ maxWidth: 960, margin: "0 auto" }}>
          <div style={{ textAlign: "center", marginBottom: 40 }}>
            <h2 style={{ fontSize: 30, fontWeight: 800, color: NAVY, fontFamily: "Georgia, serif" }}>Our Offices in Georgia & South Carolina</h2>
            <div style={{ display: "flex", gap: 8, justifyContent: "center", marginTop: 12 }}>
              <SchemaBadge label="LocalBusiness ×5" />
              <SchemaBadge label="PostalAddress" />
              <SchemaBadge label="GeoCoordinates" />
            </div>
          </div>
          <div style={{ display: "grid", gridTemplateColumns: "repeat(5, 1fr)", gap: 16 }}>
            {offices.map(o => (
              <div key={o.city} style={{
                border: `1px solid #e0e0e0`, borderRadius: 10, padding: "20px 16px",
                borderTop: `4px solid ${NAVY}`, background: "#fff",
                display: "flex", flexDirection: "column", gap: 6
              }}>
                <div style={{ display: "flex", justifyContent: "space-between", alignItems: "flex-start" }}>
                  <div style={{ fontSize: 11, fontWeight: 700, color: "#fff", background: o.state === "GA" ? NAVY : ORANGE, padding: "2px 8px", borderRadius: 3 }}>{o.state}</div>
                </div>
                <div style={{ fontWeight: 800, fontSize: 15, color: NAVY, fontFamily: "Georgia, serif" }}>{o.city}</div>
                <div style={{ fontSize: 12, color: "#666" }}>{o.address}</div>
                <div style={{ fontSize: 12, color: ORANGE, fontWeight: 700 }}>{o.phone}</div>
                <div style={{ marginTop: 8, fontSize: 12, color: NAVY, fontWeight: 600, cursor: "pointer" }}>View Office →</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CASE RESULTS */}
      <section style={{ background: NAVY, padding: "64px 32px" }}>
        <div style={{ maxWidth: 960, margin: "0 auto" }}>
          <h2 style={{ color: "#fff", fontSize: 30, fontFamily: "Georgia, serif", textAlign: "center", marginBottom: 8 }}>Our Results Speak for Themselves</h2>
          <div style={{ display: "flex", justifyContent: "center", gap: 8, marginBottom: 40 }}>
            <SchemaBadge label="ItemList" />
          </div>
          <div style={{ display: "grid", gridTemplateColumns: "repeat(4, 1fr)", gap: 16 }}>
            {results.map(r => (
              <div key={r.amount} style={{ background: "rgba(255,255,255,0.07)", border: "1px solid rgba(255,255,255,0.12)", borderRadius: 10, padding: 24, borderTop: `3px solid ${ORANGE}` }}>
                <div style={{ fontSize: 11, color: ORANGE, fontWeight: 700, letterSpacing: "1px", textTransform: "uppercase", marginBottom: 8 }}>{r.label}</div>
                <div style={{ fontSize: 28, fontWeight: 900, color: "#fff", fontFamily: "Georgia, serif" }}>{r.amount}</div>
                <div style={{ fontSize: 13, color: "#aab4c8", marginTop: 8 }}>{r.type}</div>
              </div>
            ))}
          </div>
        </div>
      </section>

    </div>
  );
}


// ─── PRACTICE AREA ─────────────────────────────────────────────────────────

function ContentSection({ title, children, badge }) {
  return (
    <div style={{ marginBottom: 36 }}>
      <h2 style={{ color: NAVY, fontSize: 19, fontWeight: 800, marginBottom: 14, paddingBottom: 10, borderBottom: `2px solid #f0f0f0`, display: "flex", alignItems: "center", gap: 10, fontFamily: "Georgia, serif" }}>
        {title} {badge && <SchemaBadge label={badge} />}
      </h2>
      {children}
    </div>
  );
}

function BulletList({ items, cols = 1 }) {
  return (
    <div style={{ display: "grid", gridTemplateColumns: cols === 2 ? "1fr 1fr" : "1fr", gap: "2px 24px", marginBottom: 12 }}>
      {items.map(item => (
        <div key={item} style={{ display: "flex", gap: 8, alignItems: "flex-start", padding: "6px 0", fontSize: 13, color: "#444", lineHeight: 1.55, borderBottom: "1px solid #f5f5f5" }}>
          <span style={{ color: ORANGE, flexShrink: 0, marginTop: 1, fontWeight: 700 }}>→</span>
          {item}
        </div>
      ))}
    </div>
  );
}

function InlineCtaBanner() {
  return (
    <div style={{ background: `linear-gradient(135deg, ${NAVY}, #0f2347)`, borderRadius: 10, padding: "18px 22px", display: "flex", alignItems: "center", justifyContent: "space-between", margin: "24px 0" }}>
      <div>
        <div style={{ color: "#fff", fontWeight: 700, fontSize: 14 }}>Free Case Evaluation — No Fees Unless We Win</div>
        <div style={{ color: "#aab4c8", fontSize: 11, marginTop: 2 }}>Available 24/7 · Georgia & South Carolina</div>
      </div>
      <button style={{ background: ORANGE, color: "#fff", border: "none", padding: "11px 22px", borderRadius: 6, fontWeight: 700, fontSize: 13, cursor: "pointer", whiteSpace: "nowrap", flexShrink: 0 }}>
        📞 1-844-RESULTS
      </button>
    </div>
  );
}

const PRACTICE_PAGES = {
  "car-accident": {
    title: "Car Accident Lawyer",
    slug: "car-accident-lawyers",
    intro: "A serious car accident can have life-changing effects on a victim and his or her loved ones, including expensive medical bills, long-term medical care, and lost wages. If you or someone you love has been injured in a car accident caused by another's negligence, you may have a case that entitles you to compensation. At Roden Law, our accomplished car accident lawyers have helped numerous victims secure millions in compensation. We do not charge upfront legal fees — we only get paid if you do.",
    whySection: "In 2024, approximately 38,000 people were killed in car accidents in the U.S., while an additional 4.6 million people suffered accident-related injuries. Insurance companies employ large teams of adjusters whose primary goal is to minimize your payout. An experienced Roden Law car accident attorney levels the playing field by building your case, gathering evidence, and handling all communications with the at-fault party's insurer.",
    subTypes: ["Drunk Driver Accidents", "Rideshare / Uber Accidents", "Rear-End Collisions", "Hit & Run Accidents", "Distracted Driving Accidents", "Wrong-Way Driver Accidents", "Commercial Vehicle Accidents", "Multi-Vehicle Pileups"],
    causes: ["Driving under the influence of drugs or alcohol", "Reckless driving and road rage", "Distracted driving (texting, handheld devices)", "Speeding and tailgating", "Failing to yield or signal a turn", "Running red lights or stop signs", "Drowsy driving", "Unsafe lane changes and improper turns"],
    injuries: ["Head injuries and traumatic brain injuries (TBI)", "Spinal cord damage and paralysis", "Burn injuries", "Broken and fractured bones", "Internal bleeding and organ damage", "Soft tissue damage and whiplash", "Neck and back injuries", "Cuts, lacerations, and scarring"],
    economicDamages: ["Past and future medical expenses", "Lost wages or income", "Loss of earning capacity", "Property damage and vehicle repair/replacement", "Cost of rehabilitation and physical therapy", "Assistive medical equipment", "Cost of long-term or lifelong care"],
    nonEconomicDamages: ["Pain and suffering", "Mental and emotional distress", "Loss of companionship (spouse/family)", "Disability and disfigurement", "Loss of enjoyment of life", "Humiliation or loss of reputation"],
    results: [
      { amount: "$3,000,000", label: "Settlement", desc: "For the surviving spouse of a man who died in an auto accident." },
      { amount: "$2,500,000", label: "Settlement", desc: "Commercial vehicle rollover — operator suffered catastrophic injuries." },
      { amount: "$1,700,000", label: "Settlement", desc: "Client suffered brain injury while riding in a medical transport vehicle." },
    ],
    faqs: [
      { q: "How long do I have to file a car accident claim in Georgia?", a: "In Georgia, you have 2 years from the date of the accident to file a personal injury claim (O.C.G.A. § 9-3-33). In South Carolina, the deadline is 3 years (S.C. Code § 15-3-530). Missing this deadline almost certainly means losing your right to compensation entirely." },
      { q: "What if I was partially at fault for the accident?", a: "Georgia uses a modified comparative fault rule — you can recover damages as long as you are less than 50% at fault. South Carolina's threshold is 51%. In both states, your compensation is reduced proportionally to your share of fault. Example: if you're 30% at fault on a $100,000 claim, you recover $70,000." },
      { q: "Can I recover if the other driver had no insurance?", a: "Yes. You may be able to recover through your own uninsured/underinsured motorist (UM/UIM) coverage. Our attorneys will identify all available insurance sources — including umbrella policies, employer liability coverage, and third-party at-fault parties — and pursue every avenue of compensation." },
      { q: "How much does it cost to hire Roden Law?", a: "Nothing upfront. We work on a contingency fee basis — we only get paid if we win compensation for you. If there is no recovery, there is no fee. This means we are fully motivated to maximize your settlement." },
      { q: "What should I do immediately after a car accident?", a: "Call 911, seek medical attention even if you feel fine, document the scene with photos, gather witness contact information, and do not give a recorded statement to the other party's insurer. Contact Roden Law as soon as possible — early evidence is critical." },
    ],
    solGA: "2 years (O.C.G.A. § 9-3-33)",
    solSC: "3 years (S.C. Code § 15-3-530)",
    author: { name: "Eric Roden", title: "Founding Partner, CEO — Licensed in Georgia & South Carolina", bio: "Eric Roden co-founded Roden Law with a mission to give injury victims the same quality of legal representation previously reserved for corporate defendants. He brings unique insight from his prior defense-side experience, which he applies directly to maximizing client outcomes." },
  },
  "truck-accident": {
    title: "Truck Accident Lawyer",
    slug: "truck-accident-lawyers",
    intro: "Because of a semi-truck's massive size and destructive potential, the owners and drivers of commercial trucks are required to follow very specific safety protocols, rules, and FMCSA regulations. If you or someone you love has suffered an injury in a truck accident, Roden Law's truck accident attorneys have the skills and resources to bring a claim against all parties at fault. We work on a contingency fee basis — no upfront fees, no risk.",
    whySection: "Trucking companies have large teams of defense lawyers specifically employed to fight truck accident claims. They know how to discredit injury claims, minimize payouts, and distance the company from liability. Our truck accident attorneys know their tactics — we are familiar with the commercial trucking industry and the insurance companies that represent it, and we will work to ensure your compensation is secured.",
    subTypes: ["18-Wheeler / Semi-Truck Accidents", "Fatigued Trucker Accidents", "Overloaded / Improperly Loaded Cargo", "Brake Failure Accidents", "Underride and Override Accidents", "Commercial Van & Delivery Truck Accidents", "Hazardous Materials Accidents", "Jackknife Accidents"],
    causes: ["Driver fatigue — violation of FMCSA hours-of-service rules", "Distracted driving (texting, handheld devices)", "Driving under the influence of drugs or alcohol", "Speeding, tailgating, and aggressive driving", "Poor decisions: wide turns, failure to check blind spots", "Inadequate CDL training or disqualified driver", "Brake failure, tire blowouts, and steering failure", "Negligent maintenance by the trucking company", "Overloaded or improperly secured cargo"],
    liableparties: ["Truck driver", "Trucking company or motor carrier", "Vehicle manufacturer (defective parts)", "Truck driver's employer", "Owner of the vehicle (if leased)", "Cargo loader, shipper, or freight broker"],
    injuries: ["Spinal cord injuries and paralysis", "Traumatic brain injuries (TBI)", "Crush injuries and amputations", "Severe burn injuries", "Internal organ damage", "Multiple broken bones and fractures", "Wrongful death"],
    economicDamages: ["Past and future medical expenses", "Lost wages and loss of earning capacity", "Rehabilitation and assistive equipment", "Home and vehicle modification costs", "Property damage", "Cost of long-term or lifelong care"],
    nonEconomicDamages: ["Pain and suffering", "Emotional distress and PTSD", "Loss of companionship", "Loss of enjoyment of life", "Disfigurement and permanent disability"],
    results: [
      { amount: "$27,000,000", label: "Settlement", desc: "Client paralyzed in collision with a commercial semi-truck." },
      { amount: "$3,500,000", label: "Settlement", desc: "Wrongful death — family of victim killed by fatigued long-haul trucker." },
      { amount: "$2,100,000", label: "Settlement", desc: "Traumatic brain injury caused by an underride collision on I-26." },
    ],
    faqs: [
      { q: "Who can be held liable in a truck accident?", a: "Multiple parties can be simultaneously liable — the truck driver, the trucking company, the vehicle manufacturer, the cargo loader, and even the freight broker. Our attorneys conduct a full investigation to identify every liable party, maximizing your total recovery." },
      { q: "What is the FMCSA and why does it matter for my case?", a: "The Federal Motor Carrier Safety Administration (FMCSA) sets mandatory safety rules for commercial trucking — including hours-of-service limits, drug and alcohol testing requirements, vehicle inspection standards, and CDL qualifications. Violations of FMCSA regulations are powerful evidence of negligence and are a cornerstone of most truck accident claims." },
      { q: "What evidence should I preserve after a truck accident?", a: "The most critical evidence includes the truck's black box (EDR/ECM), driver logbooks, maintenance records, dash cam footage, and toxicology reports. This data can be legally overwritten or destroyed within days — contact us immediately so we can issue spoliation/preservation letters to the trucking company before evidence disappears." },
      { q: "How long does a truck accident case take?", a: "It varies significantly. Cases with clear liability and documented injuries may settle in 6–18 months. Complex cases involving catastrophic injuries, multiple defendants, or disputed liability can take 2–4 years. We move as efficiently as possible while ensuring you receive the full and fair compensation you deserve." },
    ],
    solGA: "2 years (O.C.G.A. § 9-3-33)",
    solSC: "3 years (S.C. Code § 15-3-530)",
    author: { name: "Joshua Dorminy", title: "Partner — Licensed in Georgia & South Carolina", bio: "Joshua Dorminy leads Roden Law's commercial trucking litigation practice. He has handled complex multi-defendant trucking cases involving FMCSA violations, black box data, and catastrophic injury claims throughout Georgia and South Carolina." },
  },
};

function PracticeAreaTemplate() {
  const [activePA, setActivePA] = useState("car-accident");
  const [openFaq, setOpenFaq] = useState(null);

  const page = PRACTICE_PAGES[activePA];
  const locations = [
    { city: "Savannah", state: "GA" }, { city: "Charleston", state: "SC" },
    { city: "Columbia", state: "SC" }, { city: "Myrtle Beach", state: "SC" },
    { city: "Darien", state: "GA" },
  ];

  return (
    <div style={{ fontFamily: "Georgia, serif", background: "#fff" }}>

      {/* PAGE SWITCHER */}
      <div style={{ background: "#f0f2f5", borderBottom: "1px solid #dde1e8", padding: "0 32px" }}>
        <div style={{ maxWidth: 960, margin: "0 auto", display: "flex", alignItems: "center" }}>
          <span style={{ fontSize: 11, fontWeight: 700, color: "#888", letterSpacing: "0.8px", textTransform: "uppercase", paddingRight: 20, borderRight: "1px solid #dde1e8", marginRight: 4, whiteSpace: "nowrap" }}>
            Preview Page:
          </span>
          {Object.entries(PRACTICE_PAGES).map(([key, val]) => (
            <button key={key} onClick={() => { setActivePA(key); setOpenFaq(null); }} style={{
              background: "none", border: "none", cursor: "pointer",
              padding: "12px 18px", fontSize: 13, fontWeight: 600,
              color: activePA === key ? NAVY : "#666",
              borderBottom: activePA === key ? `3px solid ${ORANGE}` : "3px solid transparent",
            }}>
              {val.title}
            </button>
          ))}
        </div>
      </div>

      {/* HERO */}
      <section style={{ background: `linear-gradient(135deg, ${NAVY} 0%, #152d5a 100%)`, padding: "52px 32px 44px" }}>
        <div style={{ maxWidth: 960, margin: "0 auto" }}>
          <nav style={{ fontSize: 12, color: "#aab4c8", marginBottom: 16 }}>
            Home › Practice Areas › <span style={{ color: ORANGE }}>{page.title}</span>
          </nav>
          <div style={{ display: "grid", gridTemplateColumns: "1fr 355px", gap: 40, alignItems: "start" }}>
            <div>
              <div style={{ display: "flex", gap: 8, flexWrap: "wrap", marginBottom: 14 }}>
                <SchemaBadge label="LegalService" />
                <SchemaBadge label="FAQPage" />
                <SchemaBadge label="Speakable" />
                <SchemaBadge label="BreadcrumbList" />
              </div>
              <h1 style={{ color: "#fff", fontSize: 34, fontWeight: 900, lineHeight: 1.15, marginBottom: 12, fontFamily: "Georgia, serif" }}>
                {page.title}
              </h1>
              <p style={{ fontSize: 12, color: "#aab4c8", marginBottom: 12, letterSpacing: "0.5px" }}>
                ⚖ SERVING: <strong style={{ color: "#fff" }}>Georgia & South Carolina</strong>
              </p>
              <p style={{ color: "#bfcbde", fontSize: 14, lineHeight: 1.8, marginBottom: 22 }}>
                {page.intro}
              </p>
              <div style={{ display: "grid", gridTemplateColumns: "repeat(3, 1fr)", gap: 16, marginBottom: 22, padding: "16px 0", borderTop: "1px solid rgba(255,255,255,0.1)", borderBottom: "1px solid rgba(255,255,255,0.1)" }}>
                {[{n:"$250M+",l:"Recovered"},{n:"4.9★",l:"Client Rating"},{n:"5,000+",l:"Cases Won"}].map(s => (
                  <div key={s.n} style={{ borderLeft: `3px solid ${ORANGE}`, paddingLeft: 12 }}>
                    <div style={{ color: ORANGE, fontWeight: 900, fontSize: 20, fontFamily: "Georgia, serif" }}>{s.n}</div>
                    <div style={{ color: "#aab4c8", fontSize: 11, marginTop: 2 }}>{s.l}</div>
                  </div>
                ))}
              </div>
              <div style={{ display: "flex", gap: 10 }}>
                <button style={{ background: ORANGE, color: "#fff", border: "none", padding: "13px 26px", borderRadius: 6, fontWeight: 700, fontSize: 14, cursor: "pointer" }}>
                  📞 Call 1-844-RESULTS
                </button>
                <button style={{ background: "transparent", color: "#fff", border: "2px solid rgba(255,255,255,0.25)", padding: "13px 20px", borderRadius: 6, fontWeight: 600, fontSize: 14, cursor: "pointer" }}>
                  Free Case Review
                </button>
              </div>
            </div>
            <ContactForm />
          </div>
        </div>
      </section>

      {/* LOCATION MATRIX */}
      <section style={{ background: LIGHT, padding: "28px 32px", borderBottom: `1px solid #e0e0e0` }}>
        <div style={{ maxWidth: 960, margin: "0 auto" }}>
          <div style={{ display: "flex", alignItems: "center", justifyContent: "space-between", marginBottom: 14 }}>
            <h2 style={{ color: NAVY, fontSize: 17, fontWeight: 800 }}>Our {page.title} Offices — Click to See Intersection Pages</h2>
          </div>
          <div style={{ display: "grid", gridTemplateColumns: "repeat(5, 1fr)", gap: 10 }}>
            {locations.map(loc => (
              <div key={loc.city} style={{ background: "#fff", border: `1px solid #ddd`, borderRadius: 8, padding: "13px 10px", textAlign: "center", cursor: "pointer", borderTop: `3px solid ${ORANGE}` }}>
                <div style={{ fontSize: 10, fontWeight: 700, background: loc.state === "GA" ? NAVY : ORANGE, color: "#fff", display: "inline-block", padding: "2px 7px", borderRadius: 2, marginBottom: 6 }}>{loc.state}</div>
                <div style={{ fontSize: 13, fontWeight: 700, color: NAVY }}>{loc.city}</div>
                <div style={{ fontSize: 9, color: "#999", marginTop: 4 }}>/{page.slug}/{loc.city.toLowerCase().replace(" ","-")}-{loc.state.toLowerCase()}/</div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* MAIN + SIDEBAR */}
      <div style={{ display: "grid", gridTemplateColumns: "1fr 286px", maxWidth: 960, margin: "0 auto" }}>
        <div style={{ padding: "40px 36px 40px 32px", borderRight: "1px solid #ebebeb" }}>

          <ContentSection title={`Why Hire a ${page.title}?`}>
            <p style={{ color: "#555", fontSize: 14, lineHeight: 1.85, marginBottom: 14 }}>{page.whySection}</p>
            <p style={{ color: "#555", fontSize: 14, lineHeight: 1.85 }}>
              At Roden Law, our personal injury attorneys have helped numerous victims secure millions in compensation across Georgia and South Carolina. We provide all potential clients with a free, no-obligation review of their claim and do not charge upfront legal fees.
            </p>
            <InlineCtaBanner />
          </ContentSection>

          <ContentSection title={`Types of ${page.title} Cases We Handle`}>
            <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: 10, marginBottom: 8 }}>
              {page.subTypes.map(st => (
                <div key={st} style={{ border: `1px solid #e0e0e0`, borderLeft: `4px solid ${ORANGE}`, borderRadius: 6, padding: "12px 14px", cursor: "pointer", display: "flex", alignItems: "center", justifyContent: "space-between" }}>
                  <span style={{ fontSize: 12, fontWeight: 600, color: NAVY }}>{st}</span>
                  <span style={{ color: ORANGE, fontSize: 11 }}>→</span>
                </div>
              ))}
            </div>
          </ContentSection>

          <ContentSection title="Meeting the Statute of Limitations">
            <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: 14, marginBottom: 16 }}>
              <div style={{ background: "#EEF2F8", border: `1px solid ${NAVY}30`, borderLeft: `4px solid ${NAVY}`, borderRadius: 8, padding: 16 }}>
                <div style={{ fontWeight: 700, color: NAVY, fontSize: 12, marginBottom: 6 }}>🍑 Georgia Filing Deadline</div>
                <div style={{ fontSize: 26, fontWeight: 900, color: NAVY, fontFamily: "Georgia, serif" }}>2 Years</div>
                <div style={{ fontSize: 11, color: "#666", marginTop: 4 }}>{page.solGA}</div>
              </div>
              <div style={{ background: "#FEF4EE", border: `1px solid ${ORANGE}30`, borderLeft: `4px solid ${ORANGE}`, borderRadius: 8, padding: 16 }}>
                <div style={{ fontWeight: 700, color: ORANGE, fontSize: 12, marginBottom: 6 }}>🌙 South Carolina Filing Deadline</div>
                <div style={{ fontSize: 26, fontWeight: 900, color: ORANGE, fontFamily: "Georgia, serif" }}>3 Years</div>
                <div style={{ fontSize: 11, color: "#666", marginTop: 4 }}>{page.solSC}</div>
              </div>
            </div>
            <p style={{ color: "#555", fontSize: 14, lineHeight: 1.8 }}>
              If you fail to file within the statute of limitations, your claim will be dismissed and you will permanently lose the right to pursue compensation. You should not hesitate to consult with a skilled attorney to ensure your claim is filed on time.
            </p>
          </ContentSection>

          <ContentSection title="Do I Have a Case?">
            <p style={{ color: "#555", fontSize: 14, lineHeight: 1.8, marginBottom: 18 }}>
              Before our attorneys can take legal action, we must prove the four elements of negligence existed in your accident:
            </p>
            {[
              { num: "01", title: "Duty of Care", body: "The other party owed you a duty of care and was obligated to act in a manner that ensured your safety and the safety of others on the road." },
              { num: "02", title: "Breach of Duty", body: "The other party breached that duty by failing to act as a reasonably safe and prudent person would have in the same situation — deviating from the standard of care required." },
              { num: "03", title: "Causation", body: "The at-fault party's conduct and the resulting accident directly caused your injuries. We gather evidence to prove that but for their negligence, you would not have been harmed." },
              { num: "04", title: "Damages", body: "You suffered actual, quantifiable damages — medical expenses, lost income, pain and suffering, and other verifiable losses — as a direct result of the at-fault party's breach." },
            ].map(el => (
              <div key={el.num} style={{ display: "flex", gap: 14, marginBottom: 12, padding: "14px 16px", background: "#fafafa", border: "1px solid #ebebeb", borderRadius: 8 }}>
                <div style={{ flexShrink: 0, width: 36, height: 36, background: NAVY, borderRadius: "50%", display: "flex", alignItems: "center", justifyContent: "center", color: "#fff", fontWeight: 900, fontSize: 12, fontFamily: "Georgia, serif" }}>{el.num}</div>
                <div>
                  <div style={{ fontWeight: 700, color: NAVY, fontSize: 14, marginBottom: 4 }}>{el.title}</div>
                  <div style={{ fontSize: 13, color: "#555", lineHeight: 1.7 }}>{el.body}</div>
                </div>
              </div>
            ))}
          </ContentSection>

          <ContentSection title="Compensation You May Be Entitled To">
            <p style={{ color: "#555", fontSize: 14, lineHeight: 1.8, marginBottom: 18 }}>
              After an accident, victims often face mounting financial pressure on top of painful injuries. There are two types of damages our attorneys may be able to help you recover:
            </p>
            <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: 14 }}>
              <div style={{ background: LIGHT, border: "1px solid #e0e0e0", borderRadius: 8, padding: 16 }}>
                <div style={{ fontWeight: 800, color: NAVY, fontSize: 13, marginBottom: 10, display: "flex", alignItems: "center", gap: 8 }}>
                  <span style={{ background: NAVY, color: "#fff", padding: "2px 7px", borderRadius: 3, fontSize: 9, fontWeight: 700 }}>ECONOMIC</span>
                  Financial / Compensatory Damages
                </div>
                <BulletList items={page.economicDamages} />
              </div>
              <div style={{ background: LIGHT, border: "1px solid #e0e0e0", borderRadius: 8, padding: 16 }}>
                <div style={{ fontWeight: 800, color: NAVY, fontSize: 13, marginBottom: 10, display: "flex", alignItems: "center", gap: 8 }}>
                  <span style={{ background: ORANGE, color: "#fff", padding: "2px 7px", borderRadius: 3, fontSize: 9, fontWeight: 700 }}>NON-ECONOMIC</span>
                  Pain, Suffering & Loss
                </div>
                <BulletList items={page.nonEconomicDamages} />
              </div>
            </div>
            <p style={{ color: "#777", fontSize: 12, marginTop: 12, lineHeight: 1.6 }}>
              Non-economic damages can only be pursued through a personal injury lawsuit, not a standard insurance claim. Our attorneys will evaluate your case to determine which types of compensation apply.
            </p>
          </ContentSection>

          <ContentSection title="Comparative Fault — What If I'm Partially At Fault?">
            <div style={{ background: "#FFF8F5", border: `1px solid ${ORANGE}25`, borderLeft: `4px solid ${ORANGE}`, borderRadius: 8, padding: "16px 18px", marginBottom: 16 }}>
              <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: 16 }}>
                <div>
                  <div style={{ fontWeight: 700, color: NAVY, fontSize: 12, marginBottom: 4 }}>🍑 Georgia — Modified Comparative Fault</div>
                  <div style={{ fontSize: 13, color: "#444", lineHeight: 1.65 }}>You can recover if <strong>less than 50% at fault</strong> (O.C.G.A. § 51-12-33). Your award is reduced by your fault percentage.</div>
                </div>
                <div>
                  <div style={{ fontWeight: 700, color: NAVY, fontSize: 12, marginBottom: 4 }}>🌙 South Carolina — Modified Comparative Fault</div>
                  <div style={{ fontSize: 13, color: "#444", lineHeight: 1.65 }}>You can recover if <strong>less than 51% at fault</strong>. Your award is reduced by your fault percentage.</div>
                </div>
              </div>
            </div>
            <p style={{ color: "#555", fontSize: 14, lineHeight: 1.8 }}>
              If it is found that your actions contributed to the accident, the value of your claim may be reduced by the percentage you are assigned. For example, if you filed a $100,000 lawsuit and a court finds you are 30% at fault, your award would be reduced to $70,000. Our attorneys will work to minimize any fault assigned to you.
            </p>
          </ContentSection>

          <ContentSection title="Common Causes">
            <BulletList items={page.causes} cols={2} />
            <InlineCtaBanner />
          </ContentSection>

          <ContentSection title="Common Injuries">
            <BulletList items={page.injuries} cols={2} />
          </ContentSection>

          {page.liableparties && (
            <ContentSection title="Parties That Can Be Held Liable">
              <p style={{ color: "#555", fontSize: 14, lineHeight: 1.8, marginBottom: 12 }}>
                One of the most complex aspects of a truck accident case is determining which party is liable. Because there are often several parties involved in a commercial trucking operation, a skilled attorney may be able to help you pursue compensation from multiple sources:
              </p>
              <BulletList items={page.liableparties} cols={2} />
            </ContentSection>
          )}

          <ContentSection title="Recent Case Results">
            <div style={{ display: "grid", gridTemplateColumns: "repeat(3, 1fr)", gap: 12, marginBottom: 10 }}>
              {page.results.map(r => (
                <div key={r.amount} style={{ background: NAVY, borderRadius: 8, padding: 18, borderTop: `3px solid ${ORANGE}` }}>
                  <div style={{ fontSize: 9, color: ORANGE, fontWeight: 700, letterSpacing: "1px", textTransform: "uppercase", marginBottom: 5 }}>{r.label}</div>
                  <div style={{ fontSize: 22, fontWeight: 900, color: "#fff", fontFamily: "Georgia, serif" }}>{r.amount}</div>
                  <div style={{ fontSize: 11, color: "#aab4c8", marginTop: 8, lineHeight: 1.5 }}>{r.desc}</div>
                </div>
              ))}
            </div>
            <p style={{ fontSize: 11, color: "#999", fontStyle: "italic" }}>Results shown are gross settlement amounts before attorney fees and costs. Past results do not guarantee similar outcomes. Each case is unique.</p>
          </ContentSection>

          {/* Attorney attribution — E-E-A-T */}
          <ContentSection title="About the Author" badge="Person schema">
            <div style={{ display: "flex", gap: 16, background: LIGHT, border: "1px solid #e0e0e0", borderRadius: 10, padding: 20 }}>
              <div style={{ width: 60, height: 60, background: `${NAVY}20`, borderRadius: "50%", flexShrink: 0, display: "flex", alignItems: "center", justifyContent: "center", fontSize: 22 }}>👤</div>
              <div>
                <div style={{ fontWeight: 800, color: NAVY, fontSize: 14 }}>{page.author.name}</div>
                <div style={{ fontSize: 11, color: ORANGE, fontWeight: 600, marginBottom: 8 }}>{page.author.title}</div>
                <p style={{ fontSize: 13, color: "#555", lineHeight: 1.75, margin: 0 }}>{page.author.bio}</p>
              </div>
            </div>
          </ContentSection>

          <ContentSection title="Frequently Asked Questions" badge="FAQPage">
            {page.faqs.map((faq, i) => (
              <div key={i} style={{ border: `1px solid #e0e0e0`, borderRadius: 8, marginBottom: 8, overflow: "hidden" }}>
                <button onClick={() => setOpenFaq(openFaq === i ? null : i)} style={{
                  width: "100%", textAlign: "left",
                  background: openFaq === i ? NAVY : "#fafafa",
                  color: openFaq === i ? "#fff" : NAVY,
                  border: "none", padding: "14px 18px",
                  fontWeight: 700, fontSize: 13, cursor: "pointer",
                  display: "flex", justifyContent: "space-between", alignItems: "center",
                  fontFamily: "Georgia, serif", lineHeight: 1.4,
                }}>
                  <span style={{ flex: 1 }}>{faq.q}</span>
                  <span style={{ fontSize: 20, marginLeft: 12, flexShrink: 0 }}>{openFaq === i ? "−" : "+"}</span>
                </button>
                {openFaq === i && (
                  <div style={{ padding: "14px 18px", background: "#fff", fontSize: 13, color: "#555", lineHeight: 1.8, borderTop: "1px solid #eee" }}>
                    {faq.a}
                  </div>
                )}
              </div>
            ))}
          </ContentSection>

          {/* Bottom CTA */}
          <div style={{ background: `linear-gradient(135deg, ${NAVY}, #0f2347)`, borderRadius: 12, padding: "28px 24px", textAlign: "center" }}>
            <h2 style={{ color: "#fff", fontSize: 21, fontWeight: 800, fontFamily: "Georgia, serif", marginBottom: 10 }}>
              Contact Our {page.title}s Today
            </h2>
            <p style={{ color: "#aab4c8", fontSize: 14, lineHeight: 1.7, maxWidth: 500, margin: "0 auto 20px" }}>
              If you were injured and believe another party is at fault, contact us for a free, no-obligation review. We dedicate our skills and resources to recovering the maximum compensation you deserve — at no upfront cost.
            </p>
            <div style={{ display: "flex", gap: 12, justifyContent: "center" }}>
              <button style={{ background: ORANGE, color: "#fff", border: "none", padding: "14px 28px", borderRadius: 6, fontWeight: 700, fontSize: 14, cursor: "pointer" }}>📞 Call 1-844-RESULTS</button>
              <button style={{ background: "transparent", color: "#fff", border: "2px solid rgba(255,255,255,0.3)", padding: "14px 22px", borderRadius: 6, fontWeight: 600, fontSize: 14, cursor: "pointer" }}>Free Case Evaluation</button>
            </div>
          </div>

        </div>

        {/* SIDEBAR */}
        <div style={{ padding: "40px 18px", background: LIGHT }}>
          <div style={{ position: "sticky", top: 80, display: "flex", flexDirection: "column", gap: 14 }}>
            <ContactForm />

            <div style={{ background: "#fff", border: "1px solid #e0e0e0", borderRadius: 10, padding: 16 }}>
              <div style={{ fontWeight: 800, color: NAVY, marginBottom: 12, fontSize: 12, textTransform: "uppercase", letterSpacing: "0.5px" }}>⏱ Filing Deadlines</div>
              <div style={{ display: "flex", gap: 8, marginBottom: 8 }}>
                <div style={{ flex: 1, textAlign: "center", background: NAVY, color: "#fff", borderRadius: 6, padding: "10px 6px" }}>
                  <div style={{ fontSize: 20, fontWeight: 900 }}>2 yr</div>
                  <div style={{ fontSize: 9, color: "#aab4c8", marginTop: 2 }}>Georgia</div>
                </div>
                <div style={{ flex: 1, textAlign: "center", background: ORANGE, color: "#fff", borderRadius: 6, padding: "10px 6px" }}>
                  <div style={{ fontSize: 20, fontWeight: 900 }}>3 yr</div>
                  <div style={{ fontSize: 9, color: "rgba(255,255,255,0.8)", marginTop: 2 }}>South Carolina</div>
                </div>
              </div>
              <div style={{ fontSize: 11, color: "#888", textAlign: "center", lineHeight: 1.5 }}>Missing the deadline forfeits your right to recover.</div>
            </div>

            <div style={{ background: "#fff", border: "1px solid #e0e0e0", borderRadius: 10, padding: 16 }}>
              <div style={{ fontWeight: 700, color: NAVY, marginBottom: 12, fontSize: 13 }}>Related Practice Areas</div>
              {["Truck Accident", "Motorcycle Accident", "Wrongful Death", "Slip & Fall", "Brain Injury", "Spinal Cord Injury", "Workers' Comp"].map(pa => (
                <div key={pa} style={{ fontSize: 13, color: NAVY, padding: "7px 0", borderBottom: "1px solid #f0f0f0", cursor: "pointer", display: "flex", alignItems: "center", gap: 6 }}>
                  <span style={{ color: ORANGE }}>→</span> {pa}
                </div>
              ))}
            </div>

            <div style={{ background: NAVY, borderRadius: 10, padding: 16 }}>
              <div style={{ fontWeight: 700, color: "#fff", marginBottom: 10, fontSize: 13 }}>Why Roden Law?</div>
              {["$250M+ Recovered for Clients", "4.9★ Average Client Rating", "5,000+ Cases Successfully Handled", "No Fee Unless We Win", "Free 24/7 Consultations", "Licensed in GA & SC"].map(t => (
                <div key={t} style={{ fontSize: 12, color: "#aab4c8", padding: "6px 0", borderBottom: "1px solid rgba(255,255,255,0.08)", display: "flex", gap: 8, alignItems: "center" }}>
                  <span style={{ color: GREEN, flexShrink: 0 }}>✓</span> {t}
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

// ─── BLOG ───────────────────────────────────────────────────────────────────

const BLOG_POSTS = [
  { id: 1, featured: true, title: "Average Car Accident Settlement in SC [2026]", excerpt: "How much is a car accident case worth in South Carolina? Settlement amounts vary widely based on injury severity, liability, and insurance coverage limits. Here's what our attorneys see in real cases across the state.", category: "Personal Injury", date: "February 19, 2026", author: "Graeham C. Gillin", authorTitle: "Partner, COO", readTime: "8 min", tag: "SC Law", img: null },
  { id: 2, title: "Compensatory vs. Punitive Damages in South Carolina", excerpt: "Understanding the difference between compensatory and punitive damages is critical for SC injury victims. Learn when each type applies and how they can significantly affect your total recovery.", category: "Personal Injury", date: "February 19, 2026", author: "Kiley Reidy", authorTitle: "Associate", readTime: "6 min", tag: "Damages", img: null },
  { id: 3, title: "Charleston's Crash Hotspots to Avoid in 2025", excerpt: "Dense traffic at the I-26/I-526 interchange, King Street, and Calhoun Street continue to generate the most accident reports in the Charleston metro. Here's what you need to know.", category: "Charleston", date: "December 16, 2025", author: "Zach Stohr", authorTitle: "Associate", readTime: "5 min", tag: "Charleston", img: "highway" },
  { id: 4, title: "Amazon & FedEx Delivery Crashes: Why the Corporate Policy Differs from the Driver's", excerpt: "When a delivery driver hits your car, who's really liable — the driver or the corporation? The answer depends on driver classification, active delivery status, and which insurance policy applies.", category: "Commercial Vehicles", date: "December 16, 2025", author: "Eric Roden", authorTitle: "Founding Partner, CEO", readTime: "7 min", tag: "Delivery Vehicles", img: "delivery" },
  { id: 5, title: "Why Federal Rules Matter in Your Port of Charleston Truck Accident", excerpt: "Commercial trucks operating near the Port of Charleston fall under strict FMCSA regulations. A regulatory violation can be the cornerstone of your injury claim against the trucking company.", category: "Truck Accidents", date: "December 14, 2025", author: "Joshua Dorminy", authorTitle: "Partner", readTime: "6 min", tag: "FMCSA", img: "truck" },
  { id: 6, title: "Myrtle Beach Golf Cart Laws: Complete Guide to Local Regulations", excerpt: "Golf carts are everywhere in the Grand Strand — but riding one on public streets comes with strict rules. Violations can directly affect who is liable when an accident occurs.", category: "Personal Injury", date: "December 12, 2025", author: "Graeham C. Gillin", authorTitle: "Partner, COO", readTime: "5 min", tag: "Myrtle Beach", img: null },
  { id: 7, title: "Accidents Near MUSC and Calhoun Street", excerpt: "The stretch of Calhoun Street running past MUSC is one of Charleston's most dangerous for pedestrians and cyclists. Know your rights and what to do if you were injured there.", category: "Car Accident", date: "December 4, 2025", author: "Kiley Reidy", authorTitle: "Associate", readTime: "4 min", tag: "Charleston", img: "street" },
  { id: 8, title: "The Lower King Street Pedestrian Safety Guide", excerpt: "Lower King Street sees some of Charleston's heaviest foot traffic — and some of its most dangerous pedestrian accidents. Here's what to do if you were struck by a vehicle.", category: "Charleston", date: "December 3, 2025", author: "Zach Stohr", authorTitle: "Associate", readTime: "5 min", tag: "Pedestrian", img: null },
  { id: 9, title: "How to Get Your Charleston Police & SC Highway Patrol Accident Report", excerpt: "Your accident report is one of the most important pieces of evidence in a personal injury claim. Here is the exact step-by-step process for obtaining yours in South Carolina.", category: "Car Accident", date: "December 15, 2025", author: "Ivy S. Montano", authorTitle: "Associate", readTime: "4 min", tag: "Resources", img: null },
];

const BLOG_CATS = ["All", "Car Accident", "Truck Accidents", "Personal Injury", "Commercial Vehicles", "Charleston"];

function PostCard({ post, featured }) {
  const imgMap = { highway: ["#1a2a3a","#2c6fad"], delivery: ["#1a2e1a","#2e7d32"], truck: ["#1a1a2e","#d04a1f"], street: ["#2d1b00","#b07d20"] };
  const [c1, c2] = imgMap[post.img] || [NAVY, "#2d5a9e"];
  return (
    <div style={{ background: "#fff", border: "1px solid #e0e0e0", borderRadius: 10, overflow: "hidden", display: "flex", flexDirection: featured ? "row" : "column", boxShadow: featured ? "0 4px 20px rgba(0,0,0,0.07)" : "none" }}>
      <div style={{ background: `linear-gradient(135deg, ${c1}, ${c2})`, flexShrink: 0, width: featured ? 300 : "100%", minHeight: featured ? 260 : 140, display: "flex", alignItems: "center", justifyContent: "center", position: "relative", overflow: "hidden" }}>
        <div style={{ position: "absolute", inset: 0, backgroundImage: "radial-gradient(ellipse at 30% 70%, rgba(255,255,255,0.05) 0%, transparent 60%)" }} />
        <div style={{ fontSize: featured ? 52 : 32, opacity: 0.3 }}>
          {post.img === "highway" ? "🛣" : post.img === "delivery" ? "🚚" : post.img === "truck" ? "🚛" : post.img === "street" ? "🏙" : "⚖"}
        </div>
        <div style={{ position: "absolute", top: 10, left: 10 }}>
          <span style={{ background: featured ? ORANGE : "rgba(255,255,255,0.15)", color: "#fff", fontSize: 9, fontWeight: 700, padding: "2px 8px", borderRadius: 2, letterSpacing: "0.5px" }}>
            {featured ? "⭐ FEATURED" : post.tag}
          </span>
        </div>
      </div>
      <div style={{ padding: featured ? "24px 24px" : "16px", display: "flex", flexDirection: "column", flex: 1 }}>
        <div style={{ display: "flex", gap: 8, alignItems: "center", marginBottom: 8, flexWrap: "wrap" }}>
          <span style={{ fontSize: 9, fontWeight: 700, color: ORANGE, textTransform: "uppercase", letterSpacing: "0.5px" }}>{post.category}</span>
          <span style={{ color: "#ddd" }}>•</span>
          <span style={{ fontSize: 10, color: "#999" }}>{post.date}</span>
          <span style={{ color: "#ddd" }}>•</span>
          <span style={{ fontSize: 10, color: "#999" }}>{post.readTime} read</span>
        </div>
        <h3 style={{ color: NAVY, fontSize: featured ? 19 : 14, fontWeight: 800, lineHeight: 1.35, marginBottom: 10, fontFamily: "Georgia, serif", cursor: "pointer" }}>{post.title}</h3>
        <p style={{ color: "#666", fontSize: 13, lineHeight: 1.75, flex: 1, marginBottom: 14 }}>
          {featured ? post.excerpt : post.excerpt.substring(0, 110) + "..."}
        </p>
        <div style={{ display: "flex", alignItems: "center", justifyContent: "space-between" }}>
          <div style={{ display: "flex", alignItems: "center", gap: 8 }}>
            <div style={{ width: 26, height: 26, background: `${NAVY}18`, borderRadius: "50%", display: "flex", alignItems: "center", justifyContent: "center", fontSize: 12 }}>👤</div>
            <div>
              <div style={{ fontSize: 11, fontWeight: 700, color: NAVY }}>{post.author}</div>
              <div style={{ fontSize: 9, color: "#888" }}>{post.authorTitle}</div>
            </div>
          </div>
          <span style={{ fontSize: 12, fontWeight: 700, color: ORANGE, cursor: "pointer" }}>Read More →</span>
        </div>
      </div>
    </div>
  );
}

function BlogTemplate() {
  const [activeCategory, setActiveCategory] = useState("All");
  const [search, setSearch] = useState("");

  const filtered = BLOG_POSTS.filter(p => {
    const catMatch = activeCategory === "All" || p.category === activeCategory || p.tag === activeCategory;
    const searchMatch = !search || p.title.toLowerCase().includes(search.toLowerCase());
    return catMatch && searchMatch;
  });

  const featured = filtered.find(p => p.featured) || filtered[0];
  const rest = filtered.filter(p => p.id !== featured?.id);

  return (
    <div style={{ fontFamily: "Georgia, serif", background: "#fff" }}>

      {/* HERO */}
      <section style={{ background: `linear-gradient(135deg, ${NAVY} 0%, #152d5a 100%)`, padding: "48px 32px 40px" }}>
        <div style={{ maxWidth: 960, margin: "0 auto" }}>
          <nav style={{ fontSize: 12, color: "#aab4c8", marginBottom: 14 }}>
            Home › <span style={{ color: ORANGE }}>Blog</span>
          </nav>
          <h1 style={{ color: "#fff", fontSize: 34, fontWeight: 900, fontFamily: "Georgia, serif", marginBottom: 10 }}>Roden Law Blog</h1>
          <p style={{ color: "#aab4c8", fontSize: 14, marginBottom: 24, maxWidth: 560 }}>
            Legal insights, accident news, and injury law resources for Georgia and South Carolina residents — written by licensed personal injury attorneys.
          </p>
          <div style={{ display: "flex", gap: 0, maxWidth: 440 }}>
            <input value={search} onChange={e => setSearch(e.target.value)} placeholder="Search articles (e.g. 'truck accident')" style={{ flex: 1, background: "rgba(255,255,255,0.12)", border: "1px solid rgba(255,255,255,0.2)", borderRight: "none", borderRadius: "6px 0 0 6px", color: "#fff", padding: "11px 14px", fontSize: 13, outline: "none" }} />
            <button style={{ background: ORANGE, color: "#fff", border: "none", padding: "11px 18px", borderRadius: "0 6px 6px 0", fontWeight: 700, fontSize: 13, cursor: "pointer" }}>Search</button>
          </div>
        </div>
      </section>

      {/* CATEGORY FILTER */}
      <div style={{ background: LIGHT, borderBottom: "1px solid #e0e0e0", padding: "0 32px" }}>
        <div style={{ maxWidth: 960, margin: "0 auto", display: "flex", overflowX: "auto" }}>
          {BLOG_CATS.map(cat => {
            const count = cat === "All" ? BLOG_POSTS.length : BLOG_POSTS.filter(p => p.category === cat || p.tag === cat).length;
            return (
              <button key={cat} onClick={() => setActiveCategory(cat)} style={{
                background: "none", border: "none", cursor: "pointer",
                padding: "12px 16px", fontSize: 13, fontWeight: 600, whiteSpace: "nowrap",
                color: activeCategory === cat ? NAVY : "#777",
                borderBottom: activeCategory === cat ? `3px solid ${ORANGE}` : "3px solid transparent",
              }}>
                {cat} <span style={{ fontSize: 10, color: "#aaa" }}>({count})</span>
              </button>
            );
          })}
        </div>
      </div>

      {/* MAIN + SIDEBAR */}
      <div style={{ maxWidth: 960, margin: "0 auto", padding: "36px 32px", display: "grid", gridTemplateColumns: "1fr 260px", gap: 28 }}>

        <div>
          {featured && <div style={{ marginBottom: 24 }}><PostCard post={featured} featured /></div>}

          {rest.length > 0 && (
            <>
              <div style={{ display: "flex", alignItems: "center", gap: 12, marginBottom: 16 }}>
                <h2 style={{ color: NAVY, fontSize: 17, fontWeight: 800 }}>Latest Articles</h2>
                <div style={{ flex: 1, height: 1, background: "#e0e0e0" }} />
                <span style={{ fontSize: 11, color: "#aaa" }}>{rest.length} article{rest.length !== 1 ? "s" : ""}</span>
              </div>
              <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: 14 }}>
                {rest.map(post => <PostCard key={post.id} post={post} />)}
              </div>
            </>
          )}

          {filtered.length === 0 && (
            <div style={{ textAlign: "center", padding: "48px 0", color: "#888" }}>
              <div style={{ fontSize: 36, marginBottom: 10 }}>🔍</div>
              <div style={{ fontSize: 15, fontWeight: 600, color: NAVY }}>No articles found</div>
              <div style={{ fontSize: 13, marginTop: 6 }}>Try a different search term or category.</div>
            </div>
          )}

          {/* Pagination */}
          <div style={{ display: "flex", justifyContent: "center", gap: 6, marginTop: 28, paddingTop: 20, borderTop: "1px solid #e0e0e0" }}>
            {[1,2,3,"…",29].map((p, i) => (
              <button key={i} style={{ width: 34, height: 34, border: p === 1 ? "none" : "1px solid #ddd", borderRadius: 5, background: p === 1 ? NAVY : "#fff", color: p === 1 ? "#fff" : "#666", fontWeight: p === 1 ? 700 : 400, fontSize: 13, cursor: "pointer" }}>{p}</button>
            ))}
            <button style={{ padding: "0 14px", height: 34, border: "1px solid #ddd", borderRadius: 5, background: "#fff", color: NAVY, fontWeight: 700, fontSize: 13, cursor: "pointer" }}>Next →</button>
          </div>
        </div>

        {/* SIDEBAR */}
        <div>
          <div style={{ position: "sticky", top: 80, display: "flex", flexDirection: "column", gap: 16 }}>

            <div style={{ background: NAVY, borderRadius: 10, padding: 18, color: "#fff" }}>
              <div style={{ fontWeight: 800, fontSize: 15, marginBottom: 6, fontFamily: "Georgia, serif" }}>Injured? Talk to a Lawyer.</div>
              <div style={{ fontSize: 12, color: "#aab4c8", marginBottom: 12 }}>Free consultation. No fees unless we win.</div>
              <button style={{ width: "100%", background: ORANGE, color: "#fff", border: "none", padding: "11px", borderRadius: 5, fontWeight: 700, fontSize: 13, cursor: "pointer", marginBottom: 8 }}>📞 1-844-RESULTS</button>
              <button style={{ width: "100%", background: "transparent", border: "1px solid rgba(255,255,255,0.25)", color: "#fff", padding: "9px", borderRadius: 5, fontWeight: 600, fontSize: 12, cursor: "pointer" }}>Free Case Evaluation</button>
            </div>

            <div style={{ background: "#fff", border: "1px solid #e0e0e0", borderRadius: 10, padding: 16 }}>
              <div style={{ fontWeight: 800, color: NAVY, marginBottom: 12, fontSize: 13 }}>Categories</div>
              {BLOG_CATS.filter(c => c !== "All").map(cat => {
                const count = BLOG_POSTS.filter(p => p.category === cat || p.tag === cat).length;
                return (
                  <div key={cat} onClick={() => setActiveCategory(cat)} style={{ display: "flex", justifyContent: "space-between", alignItems: "center", padding: "8px 0", borderBottom: "1px solid #f0f0f0", cursor: "pointer" }}>
                    <span style={{ fontSize: 13, color: activeCategory === cat ? ORANGE : NAVY, fontWeight: activeCategory === cat ? 700 : 400 }}>→ {cat}</span>
                    <span style={{ fontSize: 10, background: LIGHT, color: "#888", padding: "2px 6px", borderRadius: 10 }}>{count}</span>
                  </div>
                );
              })}
            </div>

            <div style={{ background: "#fff", border: "1px solid #e0e0e0", borderRadius: 10, padding: 16 }}>
              <div style={{ fontWeight: 800, color: NAVY, marginBottom: 12, fontSize: 13 }}>Recent Posts</div>
              {BLOG_POSTS.slice(0, 5).map(p => (
                <div key={p.id} style={{ padding: "9px 0", borderBottom: "1px solid #f5f5f5", cursor: "pointer" }}>
                  <div style={{ fontSize: 12, fontWeight: 700, color: NAVY, lineHeight: 1.4, marginBottom: 2 }}>{p.title}</div>
                  <div style={{ fontSize: 10, color: "#aaa" }}>{p.date}</div>
                </div>
              ))}
            </div>

            <div style={{ background: LIGHT, border: "1px solid #e0e0e0", borderRadius: 10, padding: 16 }}>
              <div style={{ fontWeight: 800, color: NAVY, marginBottom: 10, fontSize: 13 }}>Practice Areas</div>
              {["Car Accident","Truck Accident","Slip & Fall","Medical Malpractice","Wrongful Death","Workers' Comp"].map(pa => (
                <div key={pa} style={{ fontSize: 13, color: NAVY, padding: "7px 0", borderBottom: "1px solid #e8e8e8", cursor: "pointer" }}>→ {pa}</div>
              ))}
            </div>

          </div>
        </div>
      </div>
    </div>
  );
}


// ─── LOCATION PAGE ──────────────────────────────────────────────────────────

const OFFICES = [
  {
    key: "charleston",
    name: "Roden Law — Charleston",
    address: "127 King Street, Suite 200",
    city: "Charleston", state: "SC", zip: "29401",
    phone: "(843) 790-8999",
    stateSlug: "south-carolina",
    serviceArea: "Charleston, North Charleston, Summerville, Mount Pleasant, Goose Creek, and surrounding Lowcountry communities.",
    court: "Charleston County Circuit Court",
    attorneys: [
      { name: "Graeham C. Gillin", title: "Partner, COO", bar: "SC" },
      { name: "Kiley Reidy",       title: "Associate",    bar: "SC" },
      { name: "Zach Stohr",        title: "Associate",    bar: "SC" },
    ],
    mapQ: "127+King+Street+Charleston+SC+29401",
    law: {
      sol: "3 years (S.C. Code § 15-3-530)",
      fault: "Modified comparative — recovery if less than 51% at fault",
    },
  },
  {
    key: "savannah",
    name: "Roden Law — Savannah",
    address: "333 Commercial Dr.",
    city: "Savannah", state: "GA", zip: "31406",
    phone: "(912) 303-5850",
    stateSlug: "georgia",
    serviceArea: "Savannah, Pooler, Richmond Hill, Hinesville, Statesboro, Brunswick, and surrounding Southeast Georgia communities.",
    court: "Chatham County Superior Court",
    attorneys: [
      { name: "Eric Roden",     title: "Founding Partner, CEO", bar: "GA" },
      { name: "Tyler Love",     title: "Founding Partner, CTO", bar: "GA" },
      { name: "Joshua Dorminy", title: "Partner",               bar: "GA" },
    ],
    mapQ: "333+Commercial+Drive+Savannah+GA+31406",
    law: {
      sol: "2 years (O.C.G.A. § 9-3-33)",
      fault: "Modified comparative — recovery if less than 50% at fault",
    },
  },
  {
    key: "columbia",
    name: "Roden Law — Columbia",
    address: "1545 Sumter St., Suite B",
    city: "Columbia", state: "SC", zip: "29201",
    phone: "(803) 219-2816",
    stateSlug: "south-carolina",
    serviceArea: "Columbia, Lexington, Irmo, West Columbia, Cayce, Forest Acres, and surrounding Midlands South Carolina communities.",
    court: "Richland County Circuit Court",
    attorneys: [
      { name: "Graeham C. Gillin", title: "Partner, COO", bar: "SC" },
      { name: "Kiley Reidy",       title: "Associate",    bar: "SC" },
    ],
    mapQ: "1545+Sumter+Street+Columbia+SC+29201",
    law: {
      sol: "3 years (S.C. Code § 15-3-530)",
      fault: "Modified comparative — recovery if less than 51% at fault",
    },
  },
  {
    key: "myrtle-beach",
    name: "Roden Law — Myrtle Beach",
    address: "631 Bellamy Ave., Suite C-B",
    city: "Murrells Inlet", state: "SC", zip: "29576",
    phone: "(843) 612-1980",
    stateSlug: "south-carolina",
    serviceArea: "Myrtle Beach, Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and surrounding Grand Strand communities.",
    court: "Horry County Circuit Court",
    attorneys: [
      { name: "Graeham C. Gillin", title: "Partner, COO", bar: "SC" },
    ],
    mapQ: "631+Bellamy+Ave+Murrells+Inlet+SC+29576",
    law: {
      sol: "3 years (S.C. Code § 15-3-530)",
      fault: "Modified comparative — recovery if less than 51% at fault",
    },
  },
  {
    key: "darien",
    name: "Roden Law — Darien",
    address: "1108 North Way",
    city: "Darien", state: "GA", zip: "31305",
    phone: "(912) 303-5850",
    stateSlug: "georgia",
    serviceArea: "Darien, Brunswick, St. Simons Island, Jekyll Island, Waycross, and surrounding Southeast Georgia coastal communities.",
    court: "McIntosh County Superior Court",
    attorneys: [
      { name: "Eric Roden",     title: "Founding Partner, CEO", bar: "GA" },
      { name: "Tyler Love",     title: "Founding Partner, CTO", bar: "GA" },
    ],
    mapQ: "1108+North+Way+Darien+GA+31305",
    law: {
      sol: "2 years (O.C.G.A. § 9-3-33)",
      fault: "Modified comparative — recovery if less than 50% at fault",
    },
  },
];

function LocationTemplate() {
  const [activeKey, setActiveKey] = useState("charleston");
  const office = OFFICES.find(o => o.key === activeKey);
  const practiceAreas = ["Car Accident","Truck Accident","Slip & Fall","Medical Malpractice","Motorcycle Accident","Wrongful Death","Workers' Comp","Dog Bite"];
  const mapSrc = `https://maps.google.com/maps?q=${office.mapQ}&output=embed&z=15`;

  return (
    <div style={{ fontFamily: "Georgia, serif", background: "#fff" }}>

      {/* OFFICE SWITCHER */}
      <div style={{ background: "#f0f2f5", borderBottom: "1px solid #dde1e8", padding: "0 32px" }}>
        <div style={{ maxWidth: 960, margin: "0 auto", display: "flex", alignItems: "center", gap: 0, overflowX: "auto" }}>
          <span style={{ fontSize: 11, fontWeight: 700, color: "#888", letterSpacing: "0.8px", textTransform: "uppercase", whiteSpace: "nowrap", paddingRight: 20, borderRight: "1px solid #dde1e8", marginRight: 4 }}>
            Preview Office:
          </span>
          {OFFICES.map(o => (
            <button
              key={o.key}
              onClick={() => setActiveKey(o.key)}
              style={{
                background: "none", border: "none", cursor: "pointer", whiteSpace: "nowrap",
                padding: "12px 18px", fontSize: 13, fontWeight: 600,
                color: activeKey === o.key ? NAVY : "#666",
                borderBottom: activeKey === o.key ? `3px solid ${ORANGE}` : "3px solid transparent",
                transition: "all 0.15s",
              }}
            >
              {o.city}, {o.state}
              {(o.key === "darien" || o.key === "columbia") && (
                <span style={{ marginLeft: 6, fontSize: 9, background: GREEN, color: "#fff", padding: "1px 5px", borderRadius: 2, fontWeight: 700, verticalAlign: "middle" }}>NEW</span>
              )}
            </button>
          ))}
        </div>
      </div>

      {/* HERO */}
      <section style={{ background: `linear-gradient(135deg, ${NAVY} 0%, #152d5a 100%)`, padding: "48px 32px" }}>
        <div style={{ maxWidth: 960, margin: "0 auto" }}>
          <nav style={{ fontSize: 12, color: "#aab4c8", marginBottom: 16 }}>
            Home › Locations › {office.state === "SC" ? "South Carolina" : "Georgia"} › <span style={{ color: ORANGE }}>{office.city}</span>
          </nav>
          <div style={{ display: "grid", gridTemplateColumns: "1fr 400px", gap: 40, alignItems: "start" }}>

            {/* LEFT — NAP + info */}
            <div>
              <div style={{ display: "flex", gap: 8, flexWrap: "wrap", marginBottom: 14 }}>
                <SchemaBadge label="LocalBusiness" />
                <SchemaBadge label="LegalService" />
                <SchemaBadge label="PostalAddress" />
                <SchemaBadge label="GeoCoordinates" />
              </div>
              <div style={{ display: "inline-block", background: office.state === "SC" ? ORANGE : NAVY, border: office.state === "GA" ? "1px solid rgba(255,255,255,0.3)" : "none", color: "#fff", fontSize: 11, fontWeight: 700, padding: "3px 11px", borderRadius: 3, letterSpacing: "1px", marginBottom: 14 }}>
                {office.state === "SC" ? "SOUTH CAROLINA" : "GEORGIA"}
              </div>
              <h1 style={{ color: "#fff", fontSize: 32, fontWeight: 900, lineHeight: 1.2, marginBottom: 14 }}>
                Personal Injury Lawyer<br />in {office.city}, {office.state}
              </h1>
              <p style={{ color: "#aab4c8", fontSize: 14, lineHeight: 1.7, marginBottom: 20 }}>
                Roden Law's {office.city} personal injury attorneys serve {office.serviceArea}
              </p>

              {/* NAP block */}
              <div style={{ background: "rgba(255,255,255,0.09)", border: "1px solid rgba(255,255,255,0.15)", borderRadius: 10, padding: "18px 20px", marginBottom: 20 }}>
                <div style={{ fontWeight: 700, color: "#fff", fontSize: 14, marginBottom: 10 }}>📍 {office.name}</div>
                <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: 12 }}>
                  <div>
                    <div style={{ fontSize: 11, color: "#7a8aa0", textTransform: "uppercase", letterSpacing: "0.5px", marginBottom: 3 }}>Address</div>
                    <div style={{ fontSize: 13, color: "#d0d8e8" }}>{office.address}</div>
                    <div style={{ fontSize: 13, color: "#d0d8e8" }}>{office.city}, {office.state} {office.zip}</div>
                  </div>
                  <div>
                    <div style={{ fontSize: 11, color: "#7a8aa0", textTransform: "uppercase", letterSpacing: "0.5px", marginBottom: 3 }}>Phone</div>
                    <a href={`tel:${office.phone}`} style={{ fontSize: 16, color: ORANGE, fontWeight: 700, textDecoration: "none" }}>{office.phone}</a>
                    <div style={{ fontSize: 11, color: "#7a8aa0", marginTop: 4 }}>Available 24/7</div>
                  </div>
                </div>
                <div style={{ marginTop: 14, display: "flex", gap: 10 }}>
                  <a href="#" style={{ background: ORANGE, color: "#fff", padding: "10px 20px", borderRadius: 5, fontWeight: 700, fontSize: 13, textDecoration: "none" }}>
                    📞 Call Now
                  </a>
                  <a href={`https://maps.google.com/?q=${office.mapQ}`} target="_blank" rel="noopener noreferrer" style={{ background: "rgba(255,255,255,0.12)", color: "#fff", padding: "10px 20px", borderRadius: 5, fontWeight: 600, fontSize: 13, textDecoration: "none", border: "1px solid rgba(255,255,255,0.2)" }}>
                    🗺 Get Directions
                  </a>
                </div>
              </div>
            </div>

            {/* RIGHT — Google Maps embed */}
            <div style={{ display: "flex", flexDirection: "column", gap: 16 }}>
              <div style={{ borderRadius: 12, overflow: "hidden", boxShadow: "0 8px 32px rgba(0,0,0,0.4)", border: "2px solid rgba(255,255,255,0.15)" }}>
                <iframe
                  key={office.key}
                  title={`Map — ${office.name}`}
                  src={mapSrc}
                  width="100%"
                  height="280"
                  style={{ display: "block", border: 0 }}
                  allowFullScreen
                  loading="lazy"
                  referrerPolicy="no-referrer-when-downgrade"
                />
              </div>
              <ContactForm localPhone={office.phone} />
            </div>

          </div>
        </div>
      </section>

      {/* PRACTICE AREAS AT THIS LOCATION */}
      <section style={{ background: LIGHT, padding: "36px 32px" }}>
        <div style={{ maxWidth: 960, margin: "0 auto" }}>
          <h2 style={{ color: NAVY, fontSize: 20, fontWeight: 800, marginBottom: 16 }}>
            Personal Injury Cases We Handle in {office.city}
          </h2>
          <div style={{ display: "grid", gridTemplateColumns: "repeat(4, 1fr)", gap: 10 }}>
            {practiceAreas.map(pa => (
              <div key={pa} style={{ background: "#fff", border: `1px solid #e0e0e0`, borderTop: `3px solid ${NAVY}`, borderRadius: 8, padding: "13px 12px", display: "flex", alignItems: "center", gap: 8, cursor: "pointer" }}>
                <span style={{ fontSize: 15 }}>⚖</span>
                <span style={{ fontSize: 12, fontWeight: 600, color: NAVY }}>{pa}</span>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* MAIN + SIDEBAR */}
      <div style={{ display: "grid", gridTemplateColumns: "1fr 300px", maxWidth: 960, margin: "0 auto" }}>
        <div style={{ padding: "44px 40px 44px 32px", borderRight: "1px solid #e8e8e8" }}>

          <h2 style={{ color: NAVY, fontSize: 22, fontWeight: 800, marginBottom: 14 }}>About Our {office.city} Office</h2>
          <p style={{ color: "#555", fontSize: 14, lineHeight: 1.8, marginBottom: 24 }}>
            Our {office.city} office serves injury victims throughout the region, handling all personal injury matters under {office.state === "GA" ? "Georgia" : "South Carolina"} law with deep knowledge of local courts including the {office.court}.
          </p>

          {/* State law box — auto-switches GA vs SC */}
          <div style={{ background: `linear-gradient(135deg, ${NAVY}0d, ${NAVY}05)`, border: `1px solid ${NAVY}25`, borderLeft: `4px solid ${NAVY}`, borderRadius: 8, padding: 22, marginBottom: 28 }}>
            <h3 style={{ color: NAVY, fontSize: 15, fontWeight: 800, marginBottom: 14 }}>
              ⚖ {office.state === "GA" ? "Georgia" : "South Carolina"} Personal Injury Law
            </h3>
            <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: 16 }}>
              <div>
                <div style={{ fontWeight: 700, color: NAVY, fontSize: 12, marginBottom: 5, textTransform: "uppercase", letterSpacing: "0.5px" }}>Statute of Limitations</div>
                <div style={{ fontSize: 13, color: "#444", lineHeight: 1.6 }}>
                  <strong style={{ color: ORANGE }}>{office.law.sol.split(" ")[0]}</strong> {office.law.sol.split(" ").slice(1).join(" ")}
                </div>
              </div>
              <div>
                <div style={{ fontWeight: 700, color: NAVY, fontSize: 12, marginBottom: 5, textTransform: "uppercase", letterSpacing: "0.5px" }}>Comparative Fault</div>
                <div style={{ fontSize: 13, color: "#444", lineHeight: 1.6 }}>{office.law.fault}</div>
              </div>
            </div>
          </div>

          {/* Attorneys */}
          <h2 style={{ color: NAVY, fontSize: 20, fontWeight: 800, marginBottom: 14 }}>
            Your {office.city} Attorneys
            <span style={{ marginLeft: 10 }}><SchemaBadge label="Person" /></span>
          </h2>
          <div style={{ display: "grid", gridTemplateColumns: `repeat(${Math.min(office.attorneys.length, 3)}, 1fr)`, gap: 14, marginBottom: 32 }}>
            {office.attorneys.map(a => (
              <div key={a.name} style={{ border: `1px solid #e0e0e0`, borderRadius: 10, padding: 18, textAlign: "center" }}>
                <div style={{ width: 60, height: 60, background: `${NAVY}18`, borderRadius: "50%", margin: "0 auto 10px", display: "flex", alignItems: "center", justifyContent: "center", fontSize: 22 }}>👤</div>
                <div style={{ fontWeight: 700, color: NAVY, fontSize: 13 }}>{a.name}</div>
                <div style={{ fontSize: 11, color: "#888", marginTop: 3 }}>{a.title}</div>
                <div style={{ fontSize: 11, color: ORANGE, fontWeight: 600, marginTop: 3 }}>Licensed: {a.bar}</div>
                <button style={{ marginTop: 10, background: "transparent", border: `1px solid ${NAVY}`, color: NAVY, padding: "5px 12px", borderRadius: 4, fontSize: 11, cursor: "pointer" }}>View Profile</button>
              </div>
            ))}
          </div>

          {/* Case results */}
          <h2 style={{ color: NAVY, fontSize: 20, fontWeight: 800, marginBottom: 14 }}>Recent Results</h2>
          <div style={{ display: "grid", gridTemplateColumns: "repeat(3, 1fr)", gap: 12 }}>
            {[{a:"$3,000,000",t:"Auto Accident",l:"Settlement"},{a:"$2,500,000",t:"Truck Accident",l:"Settlement"},{a:"$1,700,000",t:"Brain Injury",l:"Settlement"}].map(r => (
              <div key={r.a} style={{ background: NAVY, borderRadius: 8, padding: 18, borderTop: `3px solid ${ORANGE}` }}>
                <div style={{ fontSize: 9, color: ORANGE, fontWeight: 700, letterSpacing: "1px", textTransform: "uppercase", marginBottom: 5 }}>{r.l}</div>
                <div style={{ fontSize: 20, fontWeight: 900, color: "#fff" }}>{r.a}</div>
                <div style={{ fontSize: 11, color: "#aab4c8", marginTop: 6 }}>{r.t}</div>
              </div>
            ))}
          </div>

        </div>

        {/* SIDEBAR */}
        <div style={{ padding: "44px 22px", background: LIGHT }}>
          <div style={{ position: "sticky", top: 80 }}>
            {/* NAP card */}
            <div style={{ background: "#fff", border: `2px solid ${NAVY}`, borderRadius: 10, padding: 18, marginBottom: 14 }}>
              <div style={{ fontWeight: 800, color: NAVY, marginBottom: 2, fontSize: 14 }}>{office.name}</div>
              <div style={{ fontSize: 12, color: "#666", marginBottom: 1 }}>{office.address}</div>
              <div style={{ fontSize: 12, color: "#666", marginBottom: 12 }}>{office.city}, {office.state} {office.zip}</div>
              <a href={`tel:${office.phone}`} style={{ display: "block", color: ORANGE, fontWeight: 700, fontSize: 15, textDecoration: "none", marginBottom: 10 }}>{office.phone}</a>
              <a href={`https://maps.google.com/?q=${office.mapQ}`} target="_blank" rel="noopener noreferrer" style={{ display: "block", width: "100%", boxSizing: "border-box", textAlign: "center", background: NAVY, color: "#fff", border: "none", padding: "9px", borderRadius: 5, fontSize: 12, fontWeight: 600, textDecoration: "none" }}>
                🗺 View on Google Maps
              </a>
            </div>
            {/* Other offices */}
            <div style={{ background: "#fff", border: "1px solid #e0e0e0", borderRadius: 10, padding: 18 }}>
              <div style={{ fontWeight: 700, color: NAVY, marginBottom: 12, fontSize: 13 }}>Our Other Offices</div>
              {OFFICES.filter(o => o.key !== activeKey).map(o => (
                <div key={o.key} onClick={() => setActiveKey(o.key)} style={{ fontSize: 13, color: NAVY, padding: "8px 0", borderBottom: "1px solid #f0f0f0", cursor: "pointer", display: "flex", justifyContent: "space-between", alignItems: "center" }}>
                  <span>→ {o.city}, {o.state}</span>
                  {(o.key === "darien" || o.key === "columbia") && (
                    <span style={{ fontSize: 9, background: GREEN, color: "#fff", padding: "1px 5px", borderRadius: 2, fontWeight: 700 }}>NEW</span>
                  )}
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}



// ─── ATTORNEY PAGE ──────────────────────────────────────────────────────────

function AttorneyTemplate() {
  const atty = {
    name: "Eric Roden",
    title: "Founding Partner, CEO",
    office: "Savannah, GA",
    phone: "(912) 303-5850",
    bar: ["GA", "SC"],
  };
  const credentials = [
    { type: "Education", items: ["J.D., University of Georgia School of Law", "B.S., University of Georgia"] },
    { type: "Bar Admissions", items: ["State Bar of Georgia", "State Bar of South Carolina", "U.S. District Court, Southern District of Georgia"] },
    { type: "Awards", items: ["Super Lawyers Rising Star", "Million Dollar Advocates Forum", "Georgia Trial Lawyers Association Member"] },
  ];
  const teamMembers = ["Tyler Love","Joshua Dorminy","Graeham C. Gillin","Ivy S. Montano"];

  return (
    <div style={{ fontFamily: "Georgia, serif", background: "#fff" }}>

      {/* HERO */}
      <section style={{ background: `linear-gradient(135deg, ${NAVY} 0%, #152d5a 100%)`, padding: "56px 32px 48px" }}>
        <div style={{ maxWidth: 960, margin: "0 auto" }}>
          <nav style={{ fontSize: 12, color: "#aab4c8", marginBottom: 20 }}>
            Home › Attorneys › <span style={{ color: ORANGE }}>Eric Roden</span>
          </nav>
          <div style={{ display: "grid", gridTemplateColumns: "280px 1fr", gap: 48, alignItems: "start" }}>

            {/* Photo */}
            <div>
              <div style={{
                width: 260, height: 320, background: "linear-gradient(160deg, #1a4080, #0f2347)",
                borderRadius: 12, display: "flex", flexDirection: "column", alignItems: "center",
                justifyContent: "center", fontSize: 80, color: "rgba(255,255,255,0.2)",
                border: "1px solid rgba(255,255,255,0.1)", position: "relative", overflow: "hidden"
              }}>
                <span style={{ fontSize: 90 }}>👤</span>
                <div style={{ position: "absolute", bottom: 0, left: 0, right: 0, height: "40%", background: "linear-gradient(to top, rgba(27,58,107,0.9), transparent)" }} />
              </div>
              <div style={{ display: "flex", gap: 8, marginTop: 12 }}>
                <button style={{ flex: 1, background: "rgba(255,255,255,0.1)", border: "1px solid rgba(255,255,255,0.2)", color: "#fff", padding: "8px", borderRadius: 6, fontSize: 12, cursor: "pointer" }}>Avvo Profile</button>
                <button style={{ flex: 1, background: "rgba(255,255,255,0.1)", border: "1px solid rgba(255,255,255,0.2)", color: "#fff", padding: "8px", borderRadius: 6, fontSize: 12, cursor: "pointer" }}>LinkedIn</button>
              </div>
            </div>

            {/* Bio info */}
            <div>
              <div style={{ display: "flex", gap: 8, marginBottom: 16 }}>
                <SchemaBadge label="Person" />
                <SchemaBadge label="Attorney" />
                <SchemaBadge label="EducationalOccupationalCredential" />
              </div>
              <h1 style={{ color: "#fff", fontSize: 38, fontWeight: 900, lineHeight: 1.2, marginBottom: 8 }}>
                {atty.name}
              </h1>
              <div style={{ color: ORANGE, fontWeight: 700, fontSize: 16, marginBottom: 12 }}>{atty.title}</div>
              <div style={{ color: "#aab4c8", fontSize: 13, marginBottom: 8 }}>📍 {atty.office} — {atty.phone}</div>
              <div style={{ display: "flex", gap: 8, marginBottom: 20 }}>
                {atty.bar.map(b => (
                  <span key={b} style={{ background: "rgba(255,255,255,0.15)", color: "#fff", padding: "4px 12px", borderRadius: 3, fontSize: 12, fontWeight: 700 }}>Licensed: {b}</span>
                ))}
              </div>
              <div style={{ background: "rgba(255,255,255,0.06)", border: "1px solid rgba(255,255,255,0.12)", borderRadius: 8, padding: 20, marginBottom: 24 }}>
                <p style={{ color: "#d0d8e8", fontSize: 14, lineHeight: 1.8, margin: 0 }}>
                  Eric Roden founded Roden Law with a mission to give injury victims the same quality of legal representation previously reserved for corporate defendants. With over a decade of personal injury litigation experience in Georgia and South Carolina, Eric has recovered tens of millions of dollars for his clients.
                </p>
              </div>
              <div style={{ display: "flex", gap: 12 }}>
                <button style={{ background: ORANGE, color: "#fff", border: "none", padding: "14px 28px", borderRadius: 6, fontWeight: 700, fontSize: 14, cursor: "pointer" }}>📞 {atty.phone}</button>
                <button style={{ background: "transparent", color: "#fff", border: "2px solid rgba(255,255,255,0.3)", padding: "14px 24px", borderRadius: 6, fontWeight: 600, fontSize: 14, cursor: "pointer" }}>Free Consultation</button>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* CREDENTIALS + SIDEBAR */}
      <div style={{ display: "grid", gridTemplateColumns: "1fr 300px", maxWidth: 960, margin: "0 auto" }}>
        <div style={{ padding: "48px 40px 48px 32px", borderRight: "1px solid #e8e8e8" }}>
          <h2 style={{ color: NAVY, fontSize: 22, fontWeight: 800, marginBottom: 24 }}>About Eric Roden</h2>
          <p style={{ color: "#555", fontSize: 14, lineHeight: 1.8, marginBottom: 24 }}>
            Eric founded Roden Law after working as a defense-side attorney, giving him unique insight into how insurance companies evaluate and defend personal injury claims. He applies that knowledge directly to maximizing his clients' outcomes.
          </p>
          <p style={{ color: "#555", fontSize: 14, lineHeight: 1.8, marginBottom: 32 }}>
            Under Eric's leadership, Roden Law has grown from a solo practice to a multi-state firm with 5 offices and a team of experienced trial attorneys. He remains actively involved in major litigation across Georgia and South Carolina.
          </p>

          {/* Credentials */}
          {credentials.map(section => (
            <div key={section.type} style={{ marginBottom: 28 }}>
              <h3 style={{ color: NAVY, fontSize: 16, fontWeight: 800, marginBottom: 12, paddingBottom: 8, borderBottom: `2px solid ${ORANGE}`, display: "inline-block" }}>
                {section.type}
              </h3>
              <ul style={{ listStyle: "none", padding: 0, margin: 0 }}>
                {section.items.map(item => (
                  <li key={item} style={{ display: "flex", alignItems: "flex-start", gap: 10, marginBottom: 8, fontSize: 14, color: "#444" }}>
                    <span style={{ color: ORANGE, marginTop: 2, flexShrink: 0 }}>✓</span>
                    {item}
                  </li>
                ))}
              </ul>
            </div>
          ))}

          {/* Case Results */}
          <h2 style={{ color: NAVY, fontSize: 20, fontWeight: 800, marginBottom: 16 }}>Notable Results</h2>
          <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: 12, marginBottom: 32 }}>
            {[{a:"$27,000,000",t:"Trucking — Paralysis",l:"Settlement"},{a:"$3,000,000",t:"Auto — Wrongful Death",l:"Settlement"},{a:"$2,500,000",t:"Commercial Vehicle",l:"Settlement"},{a:"$1,700,000",t:"Brain Injury",l:"Settlement"}].map(r => (
              <div key={r.a} style={{ background: NAVY, borderRadius: 8, padding: 20, borderTop: `3px solid ${ORANGE}` }}>
                <div style={{ fontSize: 9, color: ORANGE, fontWeight: 700, letterSpacing: "1px", textTransform: "uppercase", marginBottom: 6 }}>{r.l}</div>
                <div style={{ fontSize: 22, fontWeight: 900, color: "#fff" }}>{r.a}</div>
                <div style={{ fontSize: 11, color: "#aab4c8", marginTop: 6 }}>{r.t}</div>
              </div>
            ))}
          </div>

          {/* Team */}
          <h2 style={{ color: NAVY, fontSize: 20, fontWeight: 800, marginBottom: 16 }}>Meet the Team</h2>
          <div style={{ display: "grid", gridTemplateColumns: "repeat(4, 1fr)", gap: 12 }}>
            {teamMembers.map(m => (
              <div key={m} style={{ textAlign: "center", border: `1px solid #e0e0e0`, borderRadius: 8, padding: 16, cursor: "pointer" }}>
                <div style={{ width: 48, height: 48, background: `${NAVY}15`, borderRadius: "50%", margin: "0 auto 8px", display: "flex", alignItems: "center", justifyContent: "center", fontSize: 20 }}>👤</div>
                <div style={{ fontSize: 12, fontWeight: 700, color: NAVY }}>{m}</div>
              </div>
            ))}
          </div>
        </div>

        {/* SIDEBAR */}
        <div style={{ padding: "48px 24px", background: LIGHT }}>
          <div style={{ position: "sticky", top: 80 }}>
            <div style={{ background: NAVY, borderRadius: 10, padding: 24, color: "#fff", marginBottom: 16 }}>
              <div style={{ fontWeight: 800, fontSize: 16, marginBottom: 4 }}>Schedule a Consultation</div>
              <div style={{ fontSize: 12, color: "#aab4c8", marginBottom: 16 }}>Speak directly with Eric Roden. Free & confidential.</div>
              <button style={{ width: "100%", background: ORANGE, color: "#fff", border: "none", padding: "12px", borderRadius: 6, fontWeight: 700, fontSize: 14, cursor: "pointer", marginBottom: 8 }}>{atty.phone}</button>
              <button style={{ width: "100%", background: "transparent", color: "#fff", border: "1px solid rgba(255,255,255,0.3)", padding: "10px", borderRadius: 6, fontWeight: 600, fontSize: 13, cursor: "pointer" }}>Case Review Form</button>
            </div>
            <div style={{ background: "#fff", border: "1px solid #e0e0e0", borderRadius: 10, padding: 20 }}>
              <div style={{ fontWeight: 700, color: NAVY, marginBottom: 12, fontSize: 14 }}>Jurisdiction</div>
              <p style={{ fontSize: 13, color: "#555", lineHeight: 1.6 }}>Eric Roden is licensed to practice in <strong>Georgia</strong> and <strong>South Carolina</strong>.</p>
              <div style={{ display: "flex", gap: 8, marginTop: 12 }}>
                {["GA","SC"].map(s => (
                  <div key={s} style={{ flex: 1, textAlign: "center", background: NAVY, color: "#fff", padding: "8px", borderRadius: 4, fontWeight: 700, fontSize: 14 }}>{s}</div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

// ─── APP ────────────────────────────────────────────────────────────────────

export default function App() {
  const tabs = [
    { id: "homepage",      label: "🏠 Homepage",       component: HomepageTemplate },
    { id: "practice-area", label: "⚖ Practice Area",  component: PracticeAreaTemplate },
    { id: "location",      label: "📍 Location Page",  component: LocationTemplate },
    { id: "attorney",      label: "👤 Attorney Bio",   component: AttorneyTemplate },
    { id: "blog",          label: "✍ Blog",            component: BlogTemplate },
  ];
  const [active, setActive] = useState("homepage");
  const ActiveTemplate = tabs.find(t => t.id === active).component;

  return (
    <div style={{ fontFamily: "system-ui, sans-serif", minHeight: "100vh", background: "#f0f0f0" }}>

      {/* Template Switcher */}
      <div style={{
        position: "sticky", top: 0, zIndex: 100,
        background: "#1a1a1a", borderBottom: "2px solid #333",
        padding: "0 24px", display: "flex", alignItems: "center", gap: 0
      }}>
        <div style={{ color: "#888", fontSize: 11, fontWeight: 700, letterSpacing: "1px", textTransform: "uppercase", paddingRight: 24, borderRight: "1px solid #333", marginRight: 16 }}>
          Template Preview
        </div>
        {tabs.map(tab => (
          <button key={tab.id} onClick={() => setActive(tab.id)} style={{
            background: "none", border: "none",
            color: active === tab.id ? "#fff" : "#888",
            padding: "14px 20px", fontSize: 13, fontWeight: 600, cursor: "pointer",
            borderBottom: active === tab.id ? `3px solid ${ORANGE}` : "3px solid transparent",
            transition: "all 0.2s"
          }}>
            {tab.label}
          </button>
        ))}
        <div style={{ marginLeft: "auto", display: "flex", gap: 8, alignItems: "center" }}>
          <div style={{ width: 8, height: 8, borderRadius: "50%", background: "#4ade80" }} />
          <span style={{ color: "#4ade80", fontSize: 11, fontWeight: 700 }}>PREVIEW MODE</span>
          <div style={{ marginLeft: 12, background: "#333", borderRadius: 4, padding: "4px 10px", fontSize: 11, color: "#aaa" }}>rodenlaw.com</div>
        </div>
      </div>

      {/* Schema Legend */}
      <div style={{ background: "#1e2a3a", padding: "10px 24px", display: "flex", alignItems: "center", gap: 16 }}>
        <span style={{ fontSize: 11, color: "#7a8aa0", fontWeight: 600, textTransform: "uppercase", letterSpacing: "0.5px" }}>Schema badges:</span>
        <SchemaBadge label="Organization" />
        <SchemaBadge label="LegalService" />
        <SchemaBadge label="LocalBusiness" />
        <SchemaBadge label="FAQPage" />
        <SchemaBadge label="Person" />
        <span style={{ fontSize: 11, color: "#7a8aa0", marginLeft: 8 }}>= new structured data added by the template system</span>
      </div>

      {/* Live Template Preview */}
      <div style={{ boxShadow: "0 4px 40px rgba(0,0,0,0.2)", margin: "0", background: "#fff" }}>
        <NavBar />
        <ActiveTemplate />
        <FooterBar />
      </div>
    </div>
  );
}
