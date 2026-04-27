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
      <div className="bg-light rounded-lg p-4">
        <h4 className="font-heading text-sm font-bold text-navy mb-2">Filing Deadlines</h4>
        <div className="space-y-2">
          {showGa && (
            <div className="flex items-center gap-2">
              <span className="inline-block bg-green text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase">GA</span>
              <span className="text-xs text-gray-700">{solGa}</span>
            </div>
          )}
          {showSc && (
            <div className="flex items-center gap-2">
              <span className="inline-block bg-orange text-navy text-[10px] font-bold px-2 py-0.5 rounded uppercase">SC</span>
              <span className="text-xs text-gray-700">{solSc}</span>
            </div>
          )}
        </div>
      </div>
    );
  }

  return (
    <section className="mb-10" id="pa-deadlines" data-ai-extractable="true">
      <h2 className="font-heading text-2xl font-bold text-navy mb-4">
        Statute of Limitations
      </h2>
      <div className="grid sm:grid-cols-2 gap-4">
        {showGa && (
          <div className="bg-light border border-border rounded-lg p-5">
            <span className="inline-block bg-green text-white text-xs font-bold px-2.5 py-1 rounded uppercase mb-3">Georgia</span>
            <p className="text-3xl font-black text-navy mb-1">2 years</p>
            <p className="text-sm text-gray-600">O.C.G.A. § 9-3-33</p>
          </div>
        )}
        {showSc && (
          <div className="bg-light border border-border rounded-lg p-5">
            <span className="inline-block bg-orange text-navy text-xs font-bold px-2.5 py-1 rounded uppercase mb-3">South Carolina</span>
            <p className="text-3xl font-black text-navy mb-1">3 years</p>
            <p className="text-sm text-gray-600">S.C. Code § 15-3-530</p>
          </div>
        )}
      </div>
    </section>
  );
}
