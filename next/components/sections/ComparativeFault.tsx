interface ComparativeFaultProps {
  jurisdiction?: string;
}

export function ComparativeFault({ jurisdiction }: ComparativeFaultProps) {
  const showGa = jurisdiction !== "SC";
  const showSc = jurisdiction !== "GA";

  return (
    <section className="mb-10" data-ai-extractable="true">
      <h2 className="font-heading text-[clamp(28px,3.5vw,40px)] leading-[1.1] mb-4">
        Comparative Fault Rules
      </h2>
      <div className="grid sm:grid-cols-2 gap-4">
        {showGa && (
          <div className="bg-paper border border-rule rounded-[20px] p-6">
            <span className="inline-block w-2.5 h-2.5 rounded-full bg-honey-deep mb-3" aria-hidden="true" />
            <h3 className="font-heading text-[21px] text-ink mb-2">Georgia</h3>
            <p className="text-sm text-slate leading-[1.6]">
              Modified comparative fault — you can recover damages if you are{" "}
              <strong className="text-ink">less than 50% at fault</strong> for the accident.
            </p>
            <p className="text-xs text-slate mt-2">O.C.G.A. § 51-12-33</p>
          </div>
        )}
        {showSc && (
          <div className="bg-paper border border-rule rounded-[20px] p-6">
            <span className="inline-block w-2.5 h-2.5 rounded-full bg-terra mb-3" aria-hidden="true" />
            <h3 className="font-heading text-[21px] text-ink mb-2">South Carolina</h3>
            <p className="text-sm text-slate leading-[1.6]">
              Modified comparative fault — you can recover damages if you are{" "}
              <strong className="text-ink">less than 51% at fault</strong> for the accident.
            </p>
          </div>
        )}
      </div>
    </section>
  );
}
