import { notFound } from "next/navigation";
import type { Metadata } from "next";
import Image from "next/image";
import Link from "next/link";
import { getBlogPostBySlug, getAllBlogSlugs, getRecentPosts } from "@/lib/queries/blog";
import { getFirmData } from "@/lib/firm-data";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { ContactForm } from "@/components/shared/ContactForm";
import { InlineCta } from "@/components/sections/InlineCta";
import { FaqAccordion } from "@/components/sections/FaqAccordion";
import { AuthorAttribution } from "@/components/sections/AuthorAttribution";
import { PortableText } from "@/components/shared/PortableText";
import { JsonLd } from "@/components/shared/JsonLd";
import { blogPostingSchema, faqPageSchema, breadcrumbSchema } from "@/lib/schema";
import { urlForImage } from "@/sanity/lib/image";

interface Props {
  params: Promise<{ slug: string }>;
}

export async function generateStaticParams() {
  const slugs = await getAllBlogSlugs();
  return slugs.map((slug) => ({ slug }));
}

export async function generateMetadata({ params }: Props): Promise<Metadata> {
  const { slug } = await params;
  const post = await getBlogPostBySlug(slug);
  if (!post) return {};
  return {
    title: post.title,
    description: post.seoMetaDescription || post.excerpt?.slice(0, 160),
  };
}

function readingTime(body: any[]): number {
  if (!body) return 3;
  const text = body
    .filter((b: any) => b._type === "block")
    .map((b: any) => b.children?.map((c: any) => c.text).join("") ?? "")
    .join(" ");
  return Math.max(1, Math.round(text.split(/\s+/).length / 225));
}

export default async function BlogPostPage({ params }: Props) {
  const { slug } = await params;
  const post = await getBlogPostBySlug(slug);
  if (!post) notFound();

  const firm = getFirmData();
  const recentPosts = await getRecentPosts(slug, 5);
  const author = post.authorAttorney;
  const featuredUrl = post.featuredImage ? urlForImage(post.featuredImage)?.width(800).url() : null;
  const minutes = readingTime(post.body);

  const path = `/blog/${slug}/`;
  const schemas = [
    blogPostingSchema(post, path, featuredUrl ?? undefined),
    faqPageSchema(post.faqs),
    breadcrumbSchema([
      { name: "Home", url: "/" },
      { name: "Blog", url: "/blog/" },
      { name: post.title, url: path },
    ]),
  ].filter(Boolean) as Record<string, unknown>[];

  return (
    <>
      <JsonLd data={schemas} />

      {/* ── Masthead ─────────────────────────────────────── */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-12">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Field Notes", href: "/blog/" }, { label: post.title }]} />
          <div className="max-w-[920px] mx-auto mt-4">
            {/* Kicker */}
            <div className="flex flex-wrap items-center gap-3.5 mb-7 font-mono text-[11px] tracking-[0.14em] uppercase text-slate">
              {post.category && <span className="text-terra font-bold">{post.category.title}</span>}
              {post.category && post.publishedAt && <span className="w-1 h-1 rounded-full bg-slate" aria-hidden="true" />}
              {post.publishedAt && (
                <span>Published {new Date(post.publishedAt).toLocaleDateString("en-US", { month: "long", day: "numeric", year: "numeric" })}</span>
              )}
            </div>

            <h1 className="font-heading font-normal text-ink text-[clamp(34px,6vw,76px)] leading-[1.0] tracking-[-0.025em] mb-7 text-balance">
              {post.title}
            </h1>

            {post.excerpt && (
              <p className="font-heading text-[clamp(18px,2.4vw,23px)] leading-[1.5] text-ink-2 max-w-[58ch] mb-10">
                {post.excerpt}
              </p>
            )}

            {/* Byline strip */}
            <div className="flex flex-wrap items-center justify-between gap-6 pt-7 border-t border-rule">
              {author && (
                <div className="flex items-center gap-3.5">
                  {author.headshot ? (
                    <img
                      src={urlForImage(author.headshot)?.width(104).height(104).url() ?? ""}
                      alt={author.name}
                      className="w-[52px] h-[52px] rounded-full object-cover border border-rule"
                    />
                  ) : (
                    <span className="w-[52px] h-[52px] rounded-full bg-cream border border-rule shrink-0" aria-hidden="true" />
                  )}
                  <div>
                    <Link href={`/attorneys/${author.slug}/`} className="font-heading text-[19px] text-ink hover:text-terra no-underline">
                      {author.name}
                    </Link>
                    {author.jobTitle && <div className="text-xs text-slate mt-0.5">{author.jobTitle}</div>}
                  </div>
                </div>
              )}
              <div className="flex items-baseline gap-6 font-mono text-[11px] tracking-[0.1em] uppercase text-slate">
                <span><b className="text-ink not-italic font-bold normal-case tracking-normal text-[13px]">{minutes} min</b> read</span>
                <span><b className="text-ink not-italic font-bold normal-case tracking-normal text-[13px]">Reviewed</b> by an attorney</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* ── Content + Sidebar ────────────────────────────── */}
      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-[72px]">
        <div className="grid lg:grid-cols-[1fr_340px] gap-12 lg:gap-[64px]">
          <article className="min-w-0">
            {/* Key Takeaways */}
            {post.keyTakeaways && (
              <section className="relative bg-paper border border-rule rounded-[20px] px-8 py-7 mb-10">
                <span className="absolute -top-3 left-7 bg-ink text-cream px-3.5 py-1 rounded-full font-mono text-[10px] tracking-[0.18em] font-bold">
                  KEY TAKEAWAYS
                </span>
                <p className="font-heading text-[19px] leading-[1.55] text-ink m-0">{post.keyTakeaways}</p>
              </section>
            )}

            {/* Featured Image */}
            {featuredUrl && (
              <figure className="mb-10">
                <Image
                  src={featuredUrl}
                  alt={post.title}
                  width={800}
                  height={450}
                  className="w-full h-auto rounded-[24px] shadow-[0_20px_60px_rgba(31,45,68,0.12)]"
                  priority
                />
              </figure>
            )}

            {/* Body */}
            {post.body && <PortableText value={post.body} />}

            <InlineCta />

            {/* FAQs */}
            {post.faqs && post.faqs.length > 0 && <FaqAccordion faqs={post.faqs} />}

            {/* Author Attribution */}
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

          {/* Sidebar */}
          <aside className="hidden lg:block">
            <div className="sticky top-[88px] space-y-5">
              {/* CTA */}
              <div className="bg-ink text-cream rounded-[18px] p-6">
                <h3 className="font-mono text-[10px] tracking-[0.16em] uppercase text-honey font-bold mb-3.5">Free case review</h3>
                <h4 className="font-heading text-[22px] text-cream leading-[1.2] mb-2.5">Injured? Talk to a lawyer.</h4>
                <p className="text-sm text-cream/75 leading-[1.55] mb-5">Senior attorney reply within the hour, 24/7. No fees unless we recover money for you.</p>
                <a href={`tel:${firm.phoneE164}`} className="block w-full text-center bg-terra text-paper font-bold py-3.5 rounded-full text-sm hover:bg-terra-deep transition-colors no-underline mb-2.5">
                  Call {firm.phone}
                </a>
                <Link href="/contact/" className="block w-full text-center border border-cream/30 text-cream font-semibold py-3 rounded-full text-sm hover:bg-cream/10 transition-colors no-underline">
                  Free Case Review
                </Link>
              </div>

              {/* Recent Posts */}
              {recentPosts && recentPosts.length > 0 && (
                <div className="bg-paper border border-rule rounded-[18px] p-6">
                  <h3 className="font-mono text-[10px] tracking-[0.16em] uppercase text-terra font-bold mb-4">Recent posts</h3>
                  <ul className="space-y-3.5 list-none m-0 p-0">
                    {recentPosts.map((rp: any) => (
                      <li key={rp.slug} className="border-b border-rule last:border-0 pb-3.5 last:pb-0">
                        <Link href={`/blog/${rp.slug}/`} className="block font-heading text-[15px] leading-[1.35] text-ink hover:text-terra no-underline">
                          {rp.title}
                        </Link>
                        {rp.publishedAt && (
                          <span className="block font-mono text-[10px] tracking-[0.06em] text-slate mt-1.5">
                            {new Date(rp.publishedAt).toLocaleDateString("en-US", { month: "short", day: "numeric", year: "numeric" })}
                          </span>
                        )}
                      </li>
                    ))}
                  </ul>
                </div>
              )}
            </div>
          </aside>
        </div>
      </div>
    </>
  );
}
