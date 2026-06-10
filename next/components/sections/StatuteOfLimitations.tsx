interface StatuteOfLimitationsProps {
  solGa?: string;
  solSc?: string;
  jurisdiction?: string;
  compact?: boolean;
}

export function StatuteOfLimitations({ solGa, solSc, jurisdiction, compact }: StatuteOfLimitationsProps) {
  if (!solGa && !solSc) return null;

  const showGa = jurisdiction !== "SC" && solGa;
  const showSc = jurisdiction !== "GA" && solSc;

  if (!showGa && !showSc) return null;

  if (compact) {
    return (
      <div className="bg-paper border border-rule rounded-[20px] p-5">
        <h4 className="font-heading text-base text-ink mb-2">Filing Deadlines</h4>
        <div className="space-y-2">
          {showGa && (
            <div className="flex items-center gap-2">
              <span className="inline-block bg-honey-deep text-paper text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-[0.08em]">GA</span>
              <span className="text-xs text-slate">{solGa}</span>
            </div>
          )}
          {showSc && (
            <div className="flex items-center gap-2">
              <span className="inline-block bg-terra text-paper text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-[0.08em]">SC</span>
              <span className="text-xs text-slate">{solSc}</span>
            </div>
          )}
        </div>
      </div>
    );
  }

  return (
    <section className="mb-10" id="pa-deadlines" data-ai-extractable="true">
      <h2 className="font-heading text-[clamp(28px,3.5vw,40px)] leading-[1.1] mb-4">
        Statute of Limitations
      </h2>
      <div className="grid sm:grid-cols-2 gap-4">
        {showGa && (
          <div className="bg-paper border border-rule rounded-[20px] p-6">
            <span className="inline-block bg-honey-deep text-paper text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-[0.08em] mb-3">Georgia</span>
            <p className="font-heading text-[40px] font-medium leading-none text-ink mb-1">2 years</p>
            <p className="text-sm text-slate">O.C.G.A. § 9-3-33</p>
          </div>
        )}
        {showSc && (
          <div className="bg-paper border border-rule rounded-[20px] p-6">
            <span className="inline-block bg-terra text-paper text-xs font-bold px-2.5 py-1 rounded-full uppercase tracking-[0.08em] mb-3">South Carolina</span>
            <p className="font-heading text-[40px] font-medium leading-none text-ink mb-1">3 years</p>
            <p className="text-sm text-slate">S.C. Code § 15-3-530</p>
          </div>
        )}
      </div>
    </section>
  );
}
