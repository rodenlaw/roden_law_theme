import type { Metadata } from "next";
import { LandingHero } from "@/components/sections/LandingHero";
import { ElementsOfNegligence } from "@/components/sections/ElementsOfNegligence";
import { CompensationTypes } from "@/components/sections/CompensationTypes";
import { InlineCta } from "@/components/sections/InlineCta";
import { BottomCta } from "@/components/sections/BottomCta";

export const metadata: Metadata = {
  title: "Georgia Car Accident Lawyer | Roden Law",
  description: "Injured in a car accident in Georgia? Roden Law has recovered $250M+ for injury victims. Free case review. No fees unless we win.",
  robots: { index: false, follow: false },
};

export default function GACarAccidentLandingPage() {
  return (
    <>
      <LandingHero
        title="Georgia Car Accident Lawyer"
        subtitle="Injured in a car accident in Georgia? Our attorneys have recovered $250M+ for injury victims. Free case review — no fees unless we win."
        stateBadge="Georgia"
      />
      <div className="mx-auto max-w-[1200px] px-6 py-12 space-y-4">
        <ElementsOfNegligence />
        <CompensationTypes stateFull="Georgia" />
        <InlineCta />
        <BottomCta />
      </div>
    </>
  );
}
