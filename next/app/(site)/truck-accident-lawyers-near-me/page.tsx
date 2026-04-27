import type { Metadata } from "next";
import { LandingHero } from "@/components/sections/LandingHero";
import { ElementsOfNegligence } from "@/components/sections/ElementsOfNegligence";
import { CompensationTypes } from "@/components/sections/CompensationTypes";
import { InlineCta } from "@/components/sections/InlineCta";
import { BottomCta } from "@/components/sections/BottomCta";

export const metadata: Metadata = {
  title: "Truck Accident Lawyers Near Me | Roden Law",
  description: "Injured in a truck accident? Roden Law has recovered $250M+ for injury victims across Georgia and South Carolina. Free case review.",
  robots: { index: false, follow: false },
};

export default function TruckAccidentLandingPage() {
  return (
    <>
      <LandingHero
        title="Truck Accident Lawyers Near You"
        subtitle="Injured in a truck accident? Our attorneys specialize in commercial vehicle accidents and have recovered $250M+ for injury victims. Free case review — no fees unless we win."
      />
      <div className="mx-auto max-w-[1200px] px-6 py-12 space-y-4">
        <ElementsOfNegligence />
        <CompensationTypes />
        <InlineCta />
        <BottomCta />
      </div>
    </>
  );
}
