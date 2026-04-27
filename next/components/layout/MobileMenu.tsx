"use client";

import Link from "next/link";
import { useEffect, useRef } from "react";

interface NavItem {
  label: string;
  href: string;
  children?: { label: string; href: string }[];
}

interface MobileMenuProps {
  open: boolean;
  onClose: () => void;
  navItems: NavItem[];
  phone: string;
  phoneE164: string;
}

export function MobileMenu({ open, onClose, navItems, phone, phoneE164 }: MobileMenuProps) {
  const drawerRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    if (open) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "";
    }
    return () => { document.body.style.overflow = ""; };
  }, [open]);

  useEffect(() => {
    function handleEscape(e: KeyboardEvent) {
      if (e.key === "Escape") onClose();
    }
    if (open) {
      document.addEventListener("keydown", handleEscape);
      return () => document.removeEventListener("keydown", handleEscape);
    }
  }, [open, onClose]);

  if (!open) return null;

  return (
    <div className="fixed inset-0 z-[200]" role="dialog" aria-modal="true">
      {/* Overlay */}
      <div className="absolute inset-0 bg-black/50" onClick={onClose} />

      {/* Drawer */}
      <div
        ref={drawerRef}
        className="absolute top-0 right-0 w-[300px] h-full bg-white overflow-y-auto"
      >
        {/* Drawer Header */}
        <div className="flex items-center justify-between px-5 py-4 border-b-2 border-orange">
          <span className="font-heading font-extrabold text-navy">Menu</span>
          <button
            onClick={onClose}
            className="p-2 text-navy bg-transparent border-none cursor-pointer text-xl leading-none"
            aria-label="Close menu"
          >
            &times;
          </button>
        </div>

        {/* Nav Links */}
        <nav className="p-5">
          <ul className="list-none m-0 p-0 space-y-1">
            {navItems.map((item) => (
              <li key={item.href}>
                <Link
                  href={item.href}
                  onClick={onClose}
                  className="block py-2.5 px-3 text-[15px] font-semibold text-navy hover:text-orange-text hover:bg-gray-50 rounded no-underline"
                >
                  {item.label}
                </Link>
                {item.children && item.children.length > 0 && (
                  <ul className="list-none m-0 p-0 pl-4">
                    {item.children.map((child) => (
                      <li key={child.href}>
                        <Link
                          href={child.href}
                          onClick={onClose}
                          className="block py-2 px-3 text-sm text-gray-600 hover:text-orange-text no-underline"
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

        {/* Phone CTA */}
        <div className="px-5 pb-5">
          <a
            href={`tel:${phoneE164}`}
            className="block w-full text-center bg-orange text-navy font-extrabold py-3.5 rounded-md hover:bg-orange-dark transition-colors no-underline"
          >
            {phone}
          </a>
          <p className="text-center text-xs text-gray-500 mt-2">Free 24/7 Consultations</p>
        </div>
      </div>
    </div>
  );
}
