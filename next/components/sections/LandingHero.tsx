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
    <section className="porch-glow">
      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-16 pb-20 lg:pb-24">
        <div className="grid lg:grid-cols-[1fr_380px] gap-10 lg:gap-16 items-center">
          <div>
            {stateBadge && (
              <p className="porch-eyebrow mb-5">{stateBadge}</p>
            )}
            <h1 className="font-heading font-normal text-ink text-[clamp(40px,5.5vw,68px)] leading-[1.05] tracking-[-0.02em] mb-6">
              {title}
            </h1>
            <p className="text-[19px] leading-[1.55] text-ink-2 mb-8 max-w-xl">{subtitle}</p>
            <div className="flex flex-wrap gap-9 px-8 py-6 bg-paper border border-rule rounded-[24px] shadow-[0_10px_30px_rgba(31,45,68,0.06)] mb-8 max-w-md">
              <div>
                <span className="block font-heading text-[32px] font-medium leading-none text-ink">{firm.trustStats.recovered}</span>
                <span className="text-xs font-bold tracking-[0.1em] uppercase text-slate mt-1.5 block">Recovered</span>
              </div>
              <div>
                <span className="block font-heading text-[32px] font-medium leading-none text-ink">{firm.trustStats.rating}&#9733;</span>
                <span className="text-xs font-bold tracking-[0.1em] uppercase text-slate mt-1.5 block">Rating</span>
              </div>
              <div>
                <span className="block font-heading text-[32px] font-medium leading-none text-ink">{firm.trustStats.cases}</span>
                <span className="text-xs font-bold tracking-[0.1em] uppercase text-slate mt-1.5 block">Cases</span>
              </div>
            </div>
            <a
              href={`tel:${firm.phoneE164}`}
              className="inline-flex items-center gap-2 bg-terra text-paper font-bold px-7 py-4 rounded-full hover:bg-terra-deep transition-colors no-underline text-lg"
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
