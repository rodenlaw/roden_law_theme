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

  return (
    <>
      {/* Hero */}
      <section className="bg-navy text-white py-12">
        <div className="mx-auto max-w-[1200px] px-6">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Blog", href: "/blog/" }, { label: post.title }]} />
          <h1 className="font-heading text-3xl md:text-4xl font-black mt-4 mb-4">{post.title}</h1>

          {/* Meta Bar */}
          <div className="flex flex-wrap items-center gap-4 text-sm text-gray-400">
            {author && (
              <div className="flex items-center gap-2">
                {author.headshot && (
                  <img
                    src={urlForImage(author.headshot)?.width(40).height(40).url() ?? ""}
                    alt={author.name}
                    className="w-8 h-8 rounded-full object-cover"
                  />
                )}
                <div>
                  <Link href={`/attorneys/${author.slug}/`} className="text-white font-semibold text-sm hover:text-orange no-underline">
                    {author.name}
                  </Link>
                  {author.jobTitle && <span className="block text-xs text-gray-500">{author.jobTitle}</span>}
                </div>
              </div>
            )}
            {post.publishedAt && (
              <span>{new Date(post.publishedAt).toLocaleDateString("en-US", { month: "long", day: "numeric", year: "numeric" })}</span>
            )}
            <span>{minutes} min read</span>
          </div>
        </div>
      </section>

      {/* Content + Sidebar */}
      <div className="mx-auto max-w-[1200px] px-6 py-12">
        <div className="grid lg:grid-cols-[1fr_340px] gap-10">
          <article className="min-w-0">
            {/* Key Takeaways */}
            {post.keyTakeaways && (
              <section className="bg-light border border-border rounded-lg p-6 mb-8">
                <h2 className="font-heading text-lg font-bold text-navy mb-2">Key Takeaways</h2>
                <p className="text-gray-700 text-sm leading-relaxed">{post.keyTakeaways}</p>
              </section>
            )}

            {/* Featured Image */}
            {featuredUrl && (
              <figure className="mb-8">
                <Image
                  src={featuredUrl}
                  alt={post.title}
                  width={800}
                  height={450}
                  className="w-full h-auto rounded-lg"
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
            <div className="sticky top-[88px] space-y-6">
              {/* CTA */}
              <div className="bg-light rounded-lg p-5">
                <h3 className="font-heading text-base font-bold text-navy mb-2">Injured? Talk to a Lawyer.</h3>
                <p className="text-sm text-gray-600 mb-3">Free consultation. No fees unless we win.</p>
                <a href={`tel:${firm.phoneE164}`} className="block w-full text-center bg-orange text-navy font-extrabold py-2.5 rounded-md text-sm hover:bg-orange-dark transition-colors no-underline mb-2">
                  {firm.phone}
                </a>
                <Link href="/contact/" className="block w-full text-center border border-border text-navy font-semibold py-2.5 rounded-md text-sm hover:bg-gray-50 transition-colors no-underline">
                  Free Case Review
                </Link>
              </div>

              {/* Recent Posts */}
              {recentPosts && recentPosts.length > 0 && (
                <div className="bg-light rounded-lg p-5">
                  <h3 className="font-heading text-sm font-bold text-navy mb-3">Recent Posts</h3>
                  <ul className="space-y-2 list-none m-0 p-0">
                    {recentPosts.map((rp: any) => (
                      <li key={rp.slug}>
                        <Link href={`/blog/${rp.slug}/`} className="block text-sm text-navy hover:text-orange-text no-underline">
                          {rp.title}
                        </Link>
                        {rp.publishedAt && (
                          <span className="text-xs text-gray-500">
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
