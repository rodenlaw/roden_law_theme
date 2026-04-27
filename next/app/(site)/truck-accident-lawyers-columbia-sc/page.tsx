import type { Metadata } from "next";
import { LandingHero } from "@/components/sections/LandingHero";
import { ElementsOfNegligence } from "@/components/sections/ElementsOfNegligence";
import { CompensationTypes } from "@/components/sections/CompensationTypes";
import { InlineCta } from "@/components/sections/InlineCta";
import { BottomCta } from "@/components/sections/BottomCta";

export const metadata: Metadata = {
  title: "Truck Accident Lawyers Columbia SC | Roden Law",
  description: "Truck accident in Columbia, South Carolina? Roden Law has recovered $250M+ for injury victims. Free case review. No fees unless we win.",
  robots: { index: false, follow: false },
};

export default function TruckColumbiaSCLandingPage() {
  return (
    <>
      <LandingHero
        title="Truck Accident Lawyers in Columbia, SC"
        subtitle="Injured in a truck accident in Columbia? Our attorneys specialize in commercial vehicle accidents throughout the Midlands. Free case review — no fees unless we win."
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
