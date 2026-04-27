const ECONOMIC = [
  "Medical expenses (past and future)",
  "Lost wages and earning capacity",
  "Property damage",
  "Rehabilitation costs",
  "Home modification expenses",
  "Out-of-pocket expenses",
];

const NON_ECONOMIC = [
  "Pain and suffering",
  "Emotional distress",
  "Loss of enjoyment of life",
  "Loss of consortium",
  "Disfigurement and scarring",
  "Mental anguish",
];

interface CompensationTypesProps {
  stateFull?: string;
}

export function CompensationTypes({ stateFull }: CompensationTypesProps) {
  return (
    <section className="mb-10" id="pa-compensation" data-ai-extractable="true">
      <h2 className="font-heading text-2xl font-bold text-navy mb-4">
        Compensation Available{stateFull ? ` in ${stateFull}` : ""}
      </h2>
      <div className="grid sm:grid-cols-2 gap-6">
        <div>
          <h3 className="font-heading text-base font-bold text-navy mb-3">Economic Damages</h3>
          <ul className="space-y-1.5 list-disc pl-5 text-sm text-gray-700">
            {ECONOMIC.map((item) => <li key={item}>{item}</li>)}
          </ul>
        </div>
        <div>
          <h3 className="font-heading text-base font-bold text-navy mb-3">Non-Economic Damages</h3>
          <ul className="space-y-1.5 list-disc pl-5 text-sm text-gray-700">
            {NON_ECONOMIC.map((item) => <li key={item}>{item}</li>)}
          </ul>
        </div>
      </div>
      <p className="text-xs text-gray-500 mt-4">
        The actual compensation available depends on the specific facts of your case.
        Contact us for a free case evaluation.
      </p>
    </section>
  );
}
