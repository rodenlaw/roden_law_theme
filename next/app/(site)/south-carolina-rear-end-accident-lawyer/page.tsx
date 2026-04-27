import type { Metadata } from "next";
import { LandingHero } from "@/components/sections/LandingHero";
import { ElementsOfNegligence } from "@/components/sections/ElementsOfNegligence";
import { CompensationTypes } from "@/components/sections/CompensationTypes";
import { InlineCta } from "@/components/sections/InlineCta";
import { BottomCta } from "@/components/sections/BottomCta";

export const metadata: Metadata = {
  title: "SC Rear-End Accident Lawyer | Roden Law",
  description: "Rear-ended in South Carolina? Roden Law has recovered $250M+ for injury victims. Free case review. No fees unless we win.",
  robots: { index: false, follow: false },
};

export default function SCRearEndLandingPage() {
  return (
    <>
      <LandingHero
        title="South Carolina Rear-End Accident Lawyer"
        subtitle="Rear-ended in South Carolina? You may be entitled to compensation for medical bills, lost wages, and pain and suffering. Free case review — no fees unless we win."
        stateBadge="South Carolina"
      />
      <div className="mx-auto max-w-[1200px] px-6 py-12 space-y-4">
        <ElementsOfNegligence />
        <CompensationTypes stateFull="South Carolina" />
        <InlineCta />
        <BottomCta />
      </div>
    </>
  );
}
