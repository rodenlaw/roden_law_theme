import { notFound } from "next/navigation";
import type { Metadata } from "next";
import { getResourceBySlug, getAllResourceSlugs } from "@/lib/queries/shared";
import { getFirmData } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";
import { InlineCta } from "@/components/sections/InlineCta";
import { FaqAccordion } from "@/components/sections/FaqAccordion";
import { AuthorAttribution } from "@/components/sections/AuthorAttribution";
import { StatuteOfLimitations } from "@/components/sections/StatuteOfLimitations";
import { PortableText } from "@/components/shared/PortableText";
import { urlForImage } from "@/sanity/lib/image";

interface Props {
  params: Promise<{ slug: string }>;
}

export async function generateStaticParams() {
  const slugs = await getAllResourceSlugs();
  return slugs.map((slug) => ({ slug }));
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { slug } = await params;
  const res = await getResourceBySlug(slug);
  if (!res) return {};
  return {
    title: res.title,
    description: res.seoMetaDescription || res.keyTakeaways?.slice(0, 160),
  };
}

export default async function ResourcePage({ params }: Props) {
  const { slug } = await params;
  const res = await getResourceBySlug(slug);
  if (!res) notFound();

  const firm = getFirmData();
  const author = res.authorAttorney;

  return (
    <>
      <section className="bg-navy text-white py-12">
        <div className="mx-auto max-w-[1200px] px-6">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Resources", href: "/resources/" }, { label: res.title }]} />
          <h1 className="font-heading text-3xl md:text-4xl font-black mt-4 mb-3">{res.title}</h1>
          {author && (
            <div className="flex items-center gap-3 mt-4">
              {author.headshot && (
                <img
                  src={urlForImage(author.headshot)?.width(48).height(48).url() ?? ""}
                  alt={author.name}
                  className="w-10 h-10 rounded-full object-cover"
                />
              )}
              <div>
                <span className="block text-sm font-semibold">{author.name}</span>
                {author.jobTitle && <span className="block text-xs text-gray-400">{author.jobTitle}</span>}
              </div>
            </div>
          )}
        </div>
      </section>

      <div className="mx-auto max-w-[1200px] px-6 py-12">
        <div className="grid lg:grid-cols-[1fr_340px] gap-10">
          <article className="min-w-0">
            {/* Key Takeaways */}
            {res.keyTakeaways && (
              <section className="bg-light border border-border rounded-lg p-6 mb-8">
                <h2 className="font-heading text-lg font-bold text-navy mb-2">Key Takeaways</h2>
                <p className="text-gray-700 text-sm leading-relaxed">{res.keyTakeaways}</p>
              </section>
            )}

            {/* Body */}
            {res.body && <PortableText value={res.body} />}

            <InlineCta />

            {/* FAQs */}
            {res.faqs && res.faqs.length > 0 && <FaqAccordion faqs={res.faqs} />}

            {/* Author */}
            {author && (
              <AuthorAttribution
                name={author.name}
                slug={author.slug}
                jobTitle={author.jobTitle}
                barAdmissions={author.barAdmissions}
                headshotUrl={author.headshot ? urlForImage(author.headshot)?.width(240).url() ?? undefined : undefined}
              />
            )}
          </article>

          <aside className="hidden lg:block">
            <div className="sticky top-[88px] space-y-6">
              <ContactForm />
              <StatuteOfLimitations
                solGa="2 years (O.C.G.A. § 9-3-33)"
                solSc="3 years (S.C. Code § 15-3-530)"
                jurisdiction="both"
                compact
              />
            </div>
          </aside>
        </div>
      </div>
    </>
  );
}
