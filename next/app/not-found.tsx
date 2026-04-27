import Link from "next/link";
import { getFirmData } from "@/lib/firm-data";

export default function NotFound() {
  const firm = getFirmData();

  return (
    <div className="min-h-[60vh] flex items-center justify-center">
      <div className="text-center px-6 py-16 max-w-lg">
        <h1 className="font-heading text-6xl font-black text-navy mb-4">404</h1>
        <h2 className="font-heading text-xl font-bold text-navy mb-4">Page Not Found</h2>
        <p className="text-gray-600 mb-8">
          The page you&apos;re looking for doesn&apos;t exist or has been moved. If you were injured and need help, contact us directly.
        </p>
        <div className="flex flex-col sm:flex-row items-center justify-center gap-3">
          <Link href="/" className="inline-block bg-orange text-navy font-extrabold px-6 py-3 rounded-md hover:bg-orange-dark transition-colors no-underline">
            Go Home
          </Link>
          <a href={`tel:${firm.phoneE164}`} className="inline-block border-2 border-navy text-navy font-bold px-6 py-2.5 rounded-md hover:bg-navy hover:text-white transition-colors no-underline">
            Call {firm.phone}
          </a>
        </div>
        <div className="mt-8 text-sm text-gray-500">
          <p>Looking for something specific?</p>
          <ul className="flex flex-wrap justify-center gap-4 mt-2">
            <li><Link href="/practice-areas/" className="text-navy hover:text-orange-text no-underline">Practice Areas</Link></li>
            <li><Link href="/attorneys/" className="text-navy hover:text-orange-text no-underline">Attorneys</Link></li>
            <li><Link href="/contact/" className="text-navy hover:text-orange-text no-underline">Contact</Link></li>
            <li><Link href="/blog/" className="text-navy hover:text-orange-text no-underline">Blog</Link></li>
          </ul>
        </div>
      </div>
    </div>
  );
}
