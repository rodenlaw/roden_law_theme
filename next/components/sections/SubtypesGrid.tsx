import Link from "next/link";

interface SubtypesGridProps {
  subtypes: { title: string; slug: string }[];
  pillarSlug: string;
  heading?: string;
}

export function SubtypesGrid({ subtypes, pillarSlug, heading }: SubtypesGridProps) {
  if (!subtypes || subtypes.length === 0) return null;

  return (
    <section className="mb-10" id="pa-case-types">
      <h2 className="font-heading text-[clamp(28px,3.5vw,40px)] leading-[1.1] mb-4">
        {heading || "Types of Cases We Handle"}
      </h2>
      <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
        {subtypes.map((st) => (
          <Link
            key={st.slug}
            href={`/${pillarSlug}/${st.slug}/`}
            className="block bg-paper rounded-[20px] px-5 py-4 text-sm font-semibold text-ink border border-rule hover:-translate-y-[3px] hover:shadow-[0_12px_32px_rgba(31,45,68,0.10)] hover:text-terra transition-all no-underline"
          >
            {st.title}
          </Link>
        ))}
      </div>
    </section>
  );
}
