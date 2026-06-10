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
    <section className="bg-ink text-cream rounded-[24px] p-10 text-center my-10" id="pa-contact">
      <h2 className="font-heading text-[clamp(28px,3.5vw,40px)] leading-[1.15] text-cream mb-3">
        {heading || "Contact Our Team Today"}
      </h2>
      <p className="text-cream/70 mb-8 max-w-lg mx-auto leading-[1.6]">
        Don&apos;t wait to get the help you deserve. Contact us now for a free,
        no-obligation case review. No fees unless we win.
      </p>
      <div className="flex flex-col sm:flex-row items-center justify-center gap-3">
        <a
          href={`tel:${telPhone}`}
          className="inline-block bg-terra text-paper font-bold px-8 py-4 rounded-full hover:bg-terra-deep transition-colors no-underline"
        >
          {displayPhone}
        </a>
        <Link
          href="/contact/"
          className="inline-block border-[1.5px] border-cream/40 text-cream font-bold px-8 py-4 rounded-full hover:bg-cream/10 transition-colors no-underline"
        >
          Free Case Review
        </Link>
      </div>
    </section>
  );
}
