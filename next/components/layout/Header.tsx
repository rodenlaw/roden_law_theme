"use client";

import Link from "next/link";
import { useState } from "react";
import { getFirmData } from "@/lib/firm-data";
import { MobileMenu } from "./MobileMenu";

const NAV_ITEMS = [
  { label: "Practice Areas", href: "/practice-areas/" },
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
      <div className="bg-navy-dark text-gray-400 text-xs border-b border-white/10">
        <div className="mx-auto max-w-[1200px] px-6 flex items-center justify-between py-2">
          <span>
            <span>Serving Georgia &amp; South Carolina</span>
            <span className="mx-2 opacity-50" aria-hidden="true">&mdash;</span>
            <span>No Fees Unless We Win</span>
          </span>
          <div className="hidden sm:flex items-center gap-4">
            <a
              href={`tel:${firm.phoneE164}`}
              className="text-orange font-bold hover:text-orange-light"
            >
              {firm.vanityPhone}
            </a>
            <span>Free 24/7 Consultations</span>
          </div>
        </div>
      </div>

      {/* Site Header */}
      <header className="sticky top-0 z-50 bg-white border-b-3 border-orange shadow-sm">
        <div className="mx-auto max-w-[1200px] px-6 flex items-center justify-between h-[72px]">
          {/* Logo */}
          <Link href="/" className="flex items-center gap-2.5 shrink-0 no-underline">
            <span className="w-9 h-9 bg-navy rounded flex items-center justify-center text-white font-black text-base font-heading">
              R
            </span>
            <span className="block">
              <span className="block font-heading font-extrabold text-lg text-navy leading-tight tracking-tight">
                {firm.name}
              </span>
              <span className="block text-[9px] text-gray-500 uppercase tracking-[1.5px]">
                Personal Injury Attorneys
              </span>
            </span>
          </Link>

          {/* Desktop Nav */}
          <nav className="hidden lg:block" aria-label="Primary Menu">
            <ul className="flex gap-1.5 list-none m-0 p-0">
              {navItems.map((item) => (
                <li key={item.href} className="relative group">
                  <Link
                    href={item.href}
                    className="block px-3.5 py-2 text-[13px] font-semibold text-navy border-b-2 border-transparent hover:text-orange-text hover:border-orange transition-all no-underline"
                  >
                    {item.label}
                  </Link>
                  {item.children && item.children.length > 0 && (
                    <ul className="hidden group-hover:block absolute top-full left-0 bg-white border border-gray-200 rounded-lg shadow-lg min-w-[220px] py-2 z-50 list-none">
                      {item.children.map((child) => (
                        <li key={child.href}>
                          <Link
                            href={child.href}
                            className="block px-4 py-2 text-[13px] text-navy hover:text-orange-text hover:bg-gray-50 no-underline"
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
          <div className="hidden lg:block">
            <a
              href={`tel:${firm.phoneE164}`}
              className="inline-flex items-center px-6 py-2.5 bg-orange text-navy font-extrabold text-sm rounded-md hover:bg-orange-dark transition-colors no-underline"
            >
              {firm.vanityPhone}
            </a>
          </div>

          {/* Mobile Phone + Hamburger */}
          <div className="flex items-center gap-3 lg:hidden">
            <a
              href={`tel:${firm.phoneE164}`}
              className="flex items-center justify-center w-10 h-10 rounded-full bg-orange text-white no-underline hover:bg-orange-dark transition-colors"
              aria-label="Call us now"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" /></svg>
            </a>
            <button
              className="p-2 bg-transparent border-none cursor-pointer"
              onClick={() => setMobileOpen(true)}
              aria-label="Toggle Menu"
              aria-expanded={mobileOpen}
            >
              <span className="block w-6 h-0.5 bg-navy mb-1.5" aria-hidden="true" />
              <span className="block w-6 h-0.5 bg-navy mb-1.5" aria-hidden="true" />
              <span className="block w-6 h-0.5 bg-navy" aria-hidden="true" />
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
