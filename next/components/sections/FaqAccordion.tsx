"use client";

import { useState, useCallback } from "react";

interface Faq {
  question: string;
  answer: string;
}

export function FaqAccordion({ faqs }: { faqs: Faq[] }) {
  const [openIndex, setOpenIndex] = useState<number | null>(null);

  const toggle = useCallback((i: number) => {
    setOpenIndex((prev) => (prev === i ? null : i));
  }, []);

  if (!faqs || faqs.length === 0) return null;

  return (
    <div className="my-12" id="faq" data-ai-extractable="true">
      <h2 className="font-heading text-2xl font-bold text-navy mb-6">
        Frequently Asked Questions
      </h2>
      <div>
        {faqs.map((faq, i) => {
          const isOpen = openIndex === i;
          return (
            <div key={i} className="border-b border-gray-200">
              <button
                className="w-full flex items-center justify-between py-4 px-0 text-left bg-transparent border-none cursor-pointer"
                aria-expanded={isOpen}
                aria-controls={`faq-answer-${i}`}
                onClick={() => toggle(i)}
              >
                <span className="font-heading font-bold text-navy text-base pr-4">
                  {faq.question}
                </span>
                <span className="text-orange text-xl shrink-0 transition-transform" aria-hidden="true">
                  {isOpen ? "\u2212" : "+"}
                </span>
              </button>
              {isOpen && (
                <div
                  id={`faq-answer-${i}`}
                  className="pb-4 text-gray-700 text-sm leading-relaxed"
                >
                  <p>{faq.answer}</p>
                </div>
              )}
            </div>
          );
        })}
      </div>
    </div>
  );
}
