"use client";

import Link from "next/link";
import Image from "next/image";
import { useState } from "react";
import { getFirmData } from "@/lib/firm-data";
import { MobileMenu } from "./MobileMenu";

// Main practice areas surfaced in the header dropdown (mirrors the WP menu).
const PRACTICE_AREAS: { label: string; href: string }[] = [
  { label: "Boating Accident", href: "/practice-areas/boating-accident-lawyers/" },
  { label: "Brain Injury", href: "/practice-areas/brain-injury-lawyers/" },
  { label: "Burn Injury", href: "/practice-areas/burn-injury-lawyers/" },
  { label: "Car Accident", href: "/practice-areas/car-accident-lawyers/" },
  { label: "Construction Accident", href: "/practice-areas/construction-accident-lawyers/" },
  { label: "Dog Bite", href: "/practice-areas/dog-bite-lawyers/" },
  { label: "Maritime", href: "/practice-areas/maritime-injury-lawyers/" },
  { label: "Medical Malpractice", href: "/practice-areas/medical-malpractice-lawyers/" },
  { label: "Motorcycle Accident", href: "/practice-areas/motorcycle-accident-lawyers/" },
  { label: "Nursing Home Abuse", href: "/practice-areas/nursing-home-abuse-lawyers/" },
  { label: "Personal Injury", href: "/practice-areas/personal-injury-lawyers/" },
  { label: "Product Liability", href: "/practice-areas/product-liability-lawyers/" },
  { label: "Slip and Fall", href: "/practice-areas/slip-and-fall-lawyers/" },
  { label: "Spinal Cord Injury", href: "/practice-areas/spinal-cord-injury-lawyers/" },
  { label: "Truck Accident", href: "/practice-areas/truck-accident-lawyers/" },
  { label: "Workers' Compensation", href: "/practice-areas/workers-compensation-lawyers/" },
  { label: "Wrongful Death", href: "/practice-areas/wrongful-death-lawyers/" },
];

const NAV_ITEMS = [
  {
    label: "Practice Areas",
    href: "/practice-areas/",
    children: [{ label: "All Practice Areas", href: "/practice-areas/" }, ...PRACTICE_AREAS],
  },
  {
    label: "Locations",
    href: "/locations/",
    children: [] as { label: string; href: string }[], // populated from firm data
  },
  { label: "Results", href: "/case-results/" },
  { label: "Class Actions", href: "/class-action-lawyers/" },
  {
    label: "About Us",
    href: "/about/",
    children: [
      { label: "About Roden Law", href: "/about/" },
      { label: "Attorneys", href: "/attorneys/" },
      { label: "Testimonials", href: "/testimonials/" },
      { label: "Blog", href: "/blog/" },
      { label: "Resources", href: "/resources/" },
    ],
  },
  { label: "Contact", href: "/contact/" },
];

export function Header() {
  const firm = getFirmData();
  const [mobileOpen, setMobileOpen] = useState(false);

  // Populate locations submenu from firm data
  const navItems = NAV_ITEMS.map((item) => {
    if (item.label === "Locations") {
      return {
        ...item,
        children: Object.values(firm.offices).map((office) => ({
          label: `${office.marketName}, ${office.state}`,
          href: `/locations/${office.stateSlug}/${office.slug.replace(/-[a-z]{2}$/, "")}/`,
        })),
      };
    }
    return item;
  });

  return (
    <>
      {/* Top Bar */}
      <div className="bg-ink text-cream/70 text-xs">
        <div className="mx-auto max-w-[1200px] px-6 flex items-center justify-between py-2">
          <span>
            <span>Serving Georgia &amp; South Carolina</span>
            <span className="mx-2 opacity-40" aria-hidden="true">&mdash;</span>
            <span className="font-semibold text-honey">No Fees Unless We Win</span>
          </span>
          <div className="hidden sm:flex items-center gap-4">
            <a
              href={`tel:${firm.phoneE164}`}
              className="font-bold text-honey hover:text-honey/80"
            >
              {firm.vanityPhone}
            </a>
            <span>Free 24/7 Consultations</span>
          </div>
        </div>
      </div>

      {/* Site Header */}
      <header className="sticky top-0 z-50 bg-paper border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 flex items-center justify-between h-[76px]">
          {/* Logo */}
          <Link href="/" className="flex items-center shrink-0 no-underline" aria-label={firm.name}>
            <Image src="/roden-law-logo.png" alt={firm.name} width={158} height={40} priority className="h-9 w-auto" />
          </Link>

          {/* Desktop Nav */}
          <nav className="hidden lg:block" aria-label="Primary Menu">
            <ul className="flex gap-1 list-none m-0 p-0">
              {navItems.map((item) => (
                <li key={item.href} className="relative group">
                  <Link
                    href={item.href}
                    className="block px-3.5 py-2 text-[14px] font-semibold text-ink-2 hover:text-terra transition-colors no-underline"
                  >
                    {item.label}
                  </Link>
                  {item.children && item.children.length > 0 && (
                    <ul className="hidden group-hover:block absolute top-full left-0 bg-paper border border-rule rounded-2xl shadow-[0_12px_32px_rgba(31,45,68,0.14)] min-w-[230px] max-h-[min(72vh,560px)] overflow-y-auto py-2 z-50 list-none">
                      {item.children.map((child) => (
                        <li key={child.href}>
                          <Link
                            href={child.href}
                            className="block px-4 py-2 text-[13px] text-ink-2 hover:text-terra hover:bg-cream-2 no-underline"
                          >
                            {child.label}
                          </Link>
                        </li>
                      ))}
                    </ul>
                  )}
                </li>
              ))}
            </ul>
          </nav>

          {/* Desktop CTA */}
          <div className="hidden lg:flex items-center gap-4">
            <a
              href={`tel:${firm.phoneE164}`}
              className="inline-flex items-center gap-2 text-sm font-bold text-ink hover:text-terra no-underline"
            >
              <span className="w-2 h-2 rounded-full bg-green-600" aria-hidden="true" />
              {firm.vanityPhone}
            </a>
            <Link
              href="/contact/"
              className="inline-flex items-center gap-2 px-5 py-2.5 bg-terra text-paper font-bold text-sm rounded-full hover:bg-terra-deep transition-colors no-underline"
            >
              Free case review <span aria-hidden="true">&rarr;</span>
            </Link>
          </div>

          {/* Mobile Phone + Hamburger */}
          <div className="flex items-center gap-3 lg:hidden">
            <a
              href={`tel:${firm.phoneE164}`}
              className="flex items-center justify-center w-11 h-11 rounded-full bg-terra text-paper no-underline hover:bg-terra-deep transition-colors"
              aria-label="Call us now"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" /></svg>
            </a>
            <button
              className="flex flex-col items-center justify-center w-11 h-11 bg-transparent border-none cursor-pointer"
              onClick={() => setMobileOpen(true)}
              aria-label="Toggle Menu"
              aria-expanded={mobileOpen}
            >
              <span className="block w-6 h-0.5 bg-ink mb-1.5" aria-hidden="true" />
              <span className="block w-6 h-0.5 bg-ink mb-1.5" aria-hidden="true" />
              <span className="block w-6 h-0.5 bg-ink" aria-hidden="true" />
            </button>
          </div>
        </div>
      </header>

      {/* Mobile Menu Drawer */}
      <MobileMenu
        open={mobileOpen}
        onClose={() => setMobileOpen(false)}
        navItems={navItems}
        phone={firm.vanityPhone}
        phoneE164={firm.phoneE164}
      />
    </>
  );
}
