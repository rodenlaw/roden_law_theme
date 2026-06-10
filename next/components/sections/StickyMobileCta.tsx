"use client";

import { useEffect, useState } from "react";
import { getFirmData } from "@/lib/firm-data";

interface StickyMobileCtaProps {
  /** Element id to scroll to and to hide the bar against when in view. Defaults to free-case-review. */
  hideOnVisibleId?: string;
  /** Optional override for the right-hand button target. Defaults to #<hideOnVisibleId>. */
  formHref?: string;
}

export function StickyMobileCta({
  hideOnVisibleId = "free-case-review",
  formHref,
}: StickyMobileCtaProps) {
  const firm = getFirmData();
  const [hidden, setHidden] = useState(false);

  useEffect(() => {
    const target = document.getElementById(hideOnVisibleId);
    if (!target || typeof IntersectionObserver === "undefined") return;

    const observer = new IntersectionObserver(
      ([entry]) => setHidden(entry.isIntersecting),
      { threshold: 0.15 },
    );
    observer.observe(target);
    return () => observer.disconnect();
  }, [hideOnVisibleId]);

  const formTarget = formHref ?? `#${hideOnVisibleId}`;

  return (
    <div
      aria-hidden={hidden}
      className={`md:hidden fixed inset-x-0 bottom-0 z-40 print:hidden transition-transform duration-200 ${
        hidden ? "translate-y-full" : "translate-y-0"
      }`}
      style={{ paddingBottom: "env(safe-area-inset-bottom)" }}
    >
      <div className="bg-ink border-t border-ink shadow-lg">
        <div className="grid grid-cols-2 gap-2 p-2">
          <a
            href={`tel:${firm.phoneE164}`}
            className="flex items-center justify-center gap-2 bg-terra text-paper font-bold py-3 rounded-full text-sm no-underline"
          >
            <svg
              aria-hidden="true"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              strokeWidth="2.25"
              strokeLinecap="round"
              strokeLinejoin="round"
              className="w-4 h-4"
            >
              <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.37 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.33 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z" />
            </svg>
            <span>Call Now</span>
          </a>
          <a
            href={formTarget}
            className="flex items-center justify-center bg-paper text-ink font-bold py-3 rounded-full text-sm no-underline"
          >
            Free Case Review
          </a>
        </div>
      </div>
    </div>
  );
}
