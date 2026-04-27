import { getFirmData } from "@/lib/firm-data";
import Link from "next/link";

interface BottomCtaProps {
  heading?: string;
  phone?: string;
  phoneRaw?: string;
}

export function BottomCta({ heading, phone, phoneRaw }: BottomCtaProps) {
  const firm = getFirmData();
  const displayPhone = phone || firm.phone;
  const telPhone = phoneRaw || firm.phoneE164;

  return (
    <section className="bg-navy text-white rounded-lg p-8 text-center my-10" id="pa-contact">
      <h2 className="font-heading text-2xl font-bold mb-3">
        {heading || "Contact Our Team Today"}
      </h2>
      <p className="text-gray-400 mb-6 max-w-lg mx-auto">
        Don&apos;t wait to get the help you deserve. Contact us now for a free,
        no-obligation case review. No fees unless we win.
      </p>
      <div className="flex flex-col sm:flex-row items-center justify-center gap-3">
        <a
          href={`tel:${telPhone}`}
          className="inline-block bg-orange text-navy font-extrabold px-8 py-3.5 rounded-md hover:bg-orange-dark transition-colors no-underline"
        >
          {displayPhone}
        </a>
        <Link
          href="/contact/"
          className="inline-block border-2 border-white/30 text-white font-bold px-8 py-3 rounded-md hover:bg-white/10 transition-colors no-underline"
        >
          Free Case Review
        </Link>
      </div>
    </section>
  );
}
