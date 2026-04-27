import { getFirmData } from "@/lib/firm-data";

export default function HomePage() {
  const firm = getFirmData();

  return (
    <div>
      <section className="bg-navy text-white py-20">
        <div className="mx-auto max-w-[1200px] px-6 text-center">
          <h1 className="font-heading text-4xl font-black md:text-5xl lg:text-6xl mb-4">
            Georgia &amp; South Carolina Personal Injury Lawyers
          </h1>
          <p className="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
            {firm.recovered} recovered for injured clients. No fees unless we win.
          </p>
          <a
            href={`tel:${firm.phoneE164}`}
            className="inline-block bg-orange text-navy font-extrabold px-8 py-4 rounded-md text-lg hover:bg-orange-dark transition-colors"
          >
            {firm.phone}
          </a>
        </div>
      </section>
    </div>
  );
}
