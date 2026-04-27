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
      <h2 className="font-heading text-2xl font-bold text-navy mb-4">
        {heading || "Types of Cases We Handle"}
      </h2>
      <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
        {subtypes.map((st) => (
          <Link
            key={st.slug}
            href={`/${pillarSlug}/${st.slug}/`}
            className="block bg-light rounded-lg px-4 py-3 text-sm font-semibold text-navy hover:bg-orange/10 hover:text-orange-text border border-border transition-colors no-underline"
          >
            {st.title}
          </Link>
        ))}
      </div>
    </section>
  );
}
