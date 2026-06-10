import Link from "next/link";
import { getFirmData } from "@/lib/firm-data";

export default function NotFound() {
  const firm = getFirmData();

  return (
    <div className="porch-glow min-h-[60vh] flex items-center justify-center">
      <div className="text-center px-6 py-20 max-w-lg">
        <p className="font-heading font-medium text-[clamp(72px,16vw,140px)] leading-none text-ink mb-2">404</p>
        <h1 className="font-heading text-[28px] text-ink mb-4">
          Page <span className="porch-em">not found.</span>
        </h1>
        <p className="text-slate leading-[1.6] mb-8">
          The page you&apos;re looking for doesn&apos;t exist or has been moved. If you were injured and need help, contact us directly.
        </p>
        <div className="flex flex-col sm:flex-row items-center justify-center gap-3">
          <Link href="/" className="inline-block bg-terra text-paper font-bold px-7 py-3.5 rounded-full hover:bg-terra-deep transition-colors no-underline">
            Go Home
          </Link>
          <a href={`tel:${firm.phoneE164}`} className="inline-block border border-ink/25 text-ink font-semibold px-7 py-3.5 rounded-full hover:border-terra hover:text-terra transition-colors no-underline">
            Call {firm.phone}
          </a>
        </div>
        <div className="mt-10 font-mono text-[11px] tracking-[0.06em] text-slate">
          <p className="uppercase tracking-[0.14em] mb-3">Looking for something specific?</p>
          <ul className="flex flex-wrap justify-center gap-5 list-none m-0 p-0">
            <li><Link href="/practice-areas/" className="text-ink hover:text-terra no-underline">Practice Areas</Link></li>
            <li><Link href="/attorneys/" className="text-ink hover:text-terra no-underline">Attorneys</Link></li>
            <li><Link href="/contact/" className="text-ink hover:text-terra no-underline">Contact</Link></li>
            <li><Link href="/blog/" className="text-ink hover:text-terra no-underline">Blog</Link></li>
          </ul>
        </div>
      </div>
    </div>
  );
}
