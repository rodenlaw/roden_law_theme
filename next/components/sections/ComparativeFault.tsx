interface ComparativeFaultProps {
  jurisdiction?: string;
}

export function ComparativeFault({ jurisdiction }: ComparativeFaultProps) {
  const showGa = jurisdiction !== "SC";
  const showSc = jurisdiction !== "GA";

  return (
    <section className="mb-10" data-ai-extractable="true">
      <h2 className="font-heading text-2xl font-bold text-navy mb-4">
        Comparative Fault Rules
      </h2>
      <div className="grid sm:grid-cols-2 gap-4">
        {showGa && (
          <div className="bg-light border-l-4 border-green rounded-lg p-5">
            <h3 className="font-heading text-base font-bold text-navy mb-2">Georgia</h3>
            <p className="text-sm text-gray-700">
              Modified comparative fault — you can recover damages if you are{" "}
              <strong>less than 50% at fault</strong> for the accident.
            </p>
            <p className="text-xs text-gray-500 mt-2">O.C.G.A. § 51-12-33</p>
          </div>
        )}
        {showSc && (
          <div className="bg-light border-l-4 border-orange rounded-lg p-5">
            <h3 className="font-heading text-base font-bold text-navy mb-2">South Carolina</h3>
            <p className="text-sm text-gray-700">
              Modified comparative fault — you can recover damages if you are{" "}
              <strong>less than 51% at fault</strong> for the accident.
            </p>
          </div>
        )}
      </div>
    </section>
  );
}
