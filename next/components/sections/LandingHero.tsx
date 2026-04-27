import { getFirmData } from "@/lib/firm-data";
import { ContactForm } from "@/components/shared/ContactForm";

interface LandingHeroProps {
  title: string;
  subtitle: string;
  stateBadge?: string;
}

export function LandingHero({ title, subtitle, stateBadge }: LandingHeroProps) {
  const firm = getFirmData();

  return (
    <section className="bg-navy text-white py-14 lg:py-20">
      <div className="mx-auto max-w-[1200px] px-6">
        <div className="grid lg:grid-cols-[1fr_380px] gap-10">
          <div>
            {stateBadge && (
              <span className="inline-block text-xs uppercase tracking-widest text-orange mb-3">{stateBadge}</span>
            )}
            <h1 className="font-heading text-3xl md:text-4xl lg:text-5xl font-black mb-4 leading-tight">
              {title}
            </h1>
            <p className="text-lg text-gray-300 mb-6 max-w-xl">{subtitle}</p>
            <div className="grid grid-cols-3 gap-4 mb-6 max-w-md">
              <div className="text-center">
                <span className="block text-2xl font-black text-orange">{firm.trustStats.recovered}</span>
                <span className="text-xs text-gray-400">Recovered</span>
              </div>
              <div className="text-center">
                <span className="block text-2xl font-black text-orange">{firm.trustStats.rating}&#9733;</span>
                <span className="text-xs text-gray-400">Rating</span>
              </div>
              <div className="text-center">
                <span className="block text-2xl font-black text-orange">{firm.trustStats.cases}</span>
                <span className="text-xs text-gray-400">Cases</span>
              </div>
            </div>
            <a
              href={`tel:${firm.phoneE164}`}
              className="inline-block bg-orange text-navy font-extrabold px-8 py-3.5 rounded-md hover:bg-orange-dark transition-colors no-underline text-lg"
            >
              Call {firm.phone}
            </a>
          </div>
          <div>
            <ContactForm />
          </div>
        </div>
      </div>
    </section>
  );
}
