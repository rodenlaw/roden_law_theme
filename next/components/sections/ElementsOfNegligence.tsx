const ELEMENTS = [
  {
    num: 1,
    title: "Duty of Care",
    body: "The defendant owed you a legal duty of care. For example, all drivers have a duty to operate their vehicles safely and follow traffic laws.",
  },
  {
    num: 2,
    title: "Breach of Duty",
    body: "The defendant breached that duty through negligent, reckless, or intentional conduct — such as running a red light, texting while driving, or failing to maintain safe premises.",
  },
  {
    num: 3,
    title: "Causation",
    body: "The defendant's breach directly caused your injuries. There must be a clear link between their negligent action (or inaction) and the harm you suffered.",
  },
  {
    num: 4,
    title: "Damages",
    body: "You suffered actual, measurable damages as a result — including medical bills, lost wages, pain and suffering, and other losses.",
  },
];

export function ElementsOfNegligence() {
  return (
    <section className="mb-10" data-ai-extractable="true">
      <h2 className="font-heading text-2xl font-bold text-navy mb-4">
        Do I Have a Case? The 4 Elements of Negligence
      </h2>
      <div className="grid sm:grid-cols-2 gap-4">
        {ELEMENTS.map((el) => (
          <div key={el.num} className="bg-light rounded-lg p-5 border border-border">
            <span className="inline-flex items-center justify-center w-8 h-8 bg-navy text-white font-bold text-sm rounded-full mb-3">
              {el.num}
            </span>
            <h3 className="font-heading text-base font-bold text-navy mb-2">{el.title}</h3>
            <p className="text-sm text-gray-700">{el.body}</p>
          </div>
        ))}
      </div>
    </section>
  );
}
