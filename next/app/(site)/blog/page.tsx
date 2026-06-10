import type { Metadata } from "next";
import Link from "next/link";
import Image from "next/image";
import { getBlogPosts } from "@/lib/queries/blog";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { PorchPlaceholder } from "@/components/porch/PorchPlaceholder";
import { urlForImage } from "@/sanity/lib/image";

export const revalidate = 3600;
export const metadata: Metadata = {
  title: "Blog",
  description: "Legal insights, accident news, and injury law resources for Georgia and South Carolina residents — written by licensed personal injury attorneys.",
};

export default async function BlogListingPage() {
  const posts = await getBlogPosts(0, 24);
  const featured = posts && posts.length > 0 ? posts[0] : null;
  const rest = posts && posts.length > 1 ? posts.slice(1) : [];

  const fmtDate = (d: string) =>
    new Date(d).toLocaleDateString("en-US", { month: "short", day: "numeric", year: "numeric" });

  return (
    <>
      {/* ── Masthead ─────────────────────────────────────── */}
      <section className="porch-glow border-b border-rule">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-8 pb-14">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Field Notes" }]} />
          <div className="grid lg:grid-cols-[1fr_360px] gap-12 lg:gap-[72px] items-end border-b border-rule pb-10 mt-4">
            <div>
              <p className="porch-eyebrow mb-4">The Roden Law Journal</p>
              <h1 className="font-heading font-normal text-ink text-[clamp(48px,8vw,104px)] leading-[0.98] tracking-[-0.02em] mb-5">
                Field <span className="porch-em">notes.</span>
              </h1>
              <p className="font-heading text-[clamp(18px,2.2vw,22px)] leading-[1.45] text-ink-2 max-w-[56ch]">
                Plain-English writing from our attorneys on the{" "}
                <b className="font-semibold text-ink">questions clients actually ask</b> — about insurance
                offers, accident scenes, deadlines, and what&apos;s worth fighting for. No SEO filler. No legalese.
              </p>
            </div>
            <div className="bg-paper border border-rule rounded-[18px] px-7 py-6 shadow-[0_8px_24px_rgba(31,45,68,0.06)]">
              <h4 className="font-mono text-[10px] tracking-[0.18em] uppercase text-terra font-bold mb-4">Latest insights</h4>
              <div className="font-heading italic text-[34px] text-ink leading-none mb-5">From the desk</div>
              <dl className="grid grid-cols-[80px_1fr] gap-y-2.5 gap-x-3 text-[12px] m-0">
                <dt className="text-slate uppercase tracking-[0.1em]">Authors</dt>
                <dd className="m-0 text-ink font-bold">Roden Law attorneys</dd>
                <dt className="text-slate uppercase tracking-[0.1em]">Topics</dt>
                <dd className="m-0 text-ink font-bold">Injury, claims &amp; <span className="text-honey-deep italic">recovery</span></dd>
                <dt className="text-slate uppercase tracking-[0.1em]">Focus</dt>
                <dd className="m-0 text-ink font-bold">Georgia &amp; the Carolinas</dd>
              </dl>
            </div>
          </div>
        </div>
      </section>

      {posts && posts.length > 0 ? (
        <>
          {/* ── Featured story ───────────────────────────── */}
          {featured && (
            <section className="mx-auto max-w-[1200px] px-6 lg:px-[88px] pt-14 pb-4">
              <Link
                href={`/blog/${featured.slug}/`}
                className="group grid lg:grid-cols-[1.15fr_1fr] gap-0 bg-paper border border-rule rounded-[28px] overflow-hidden no-underline hover:shadow-[0_16px_44px_rgba(31,45,68,0.10)] transition-shadow"
              >
                <div className="relative min-h-[320px] lg:min-h-[480px] bg-ink">
                  {featured.featuredImage ? (
                    <Image
                      src={urlForImage(featured.featuredImage)?.width(900).height(700).url() ?? ""}
                      alt={featured.title}
                      width={900}
                      height={700}
                      className="absolute inset-0 w-full h-full object-cover"
                      priority
                    />
                  ) : (
                    <PorchPlaceholder label={`${featured.title} · 16:10`} variant="dark" className="absolute inset-0" />
                  )}
                  <span className="absolute top-6 left-6 z-10 inline-flex items-center gap-2 bg-terra text-paper px-4 py-2 rounded-full text-[11px] font-extrabold tracking-[0.14em] uppercase">
                    <span className="w-1.5 h-1.5 rounded-full bg-paper" aria-hidden="true" /> Featured
                  </span>
                </div>
                <div className="p-9 lg:p-[56px] flex flex-col justify-center">
                  <div className="flex items-center gap-3.5 mb-5 font-mono text-[11px] tracking-[0.12em] uppercase text-slate">
                    {featured.category && <span className="text-terra font-bold">{featured.category.title}</span>}
                    {featured.category && featured.publishedAt && <span className="w-1 h-1 rounded-full bg-slate" aria-hidden="true" />}
                    {featured.publishedAt && <span>{fmtDate(featured.publishedAt)}</span>}
                  </div>
                  <h2 className="font-heading font-normal text-[clamp(30px,4vw,52px)] leading-[1.05] tracking-[-0.02em] mb-5 text-ink group-hover:text-terra transition-colors">
                    {featured.title}
                  </h2>
                  {featured.excerpt && (
                    <p className="text-[17px] leading-[1.6] text-ink-2 max-w-[48ch] mb-8">{featured.excerpt}</p>
                  )}
                  <div className="flex items-center gap-3.5 pt-5 border-t border-rule">
                    {featured.authorAttorney && (
                      <>
                        <span className="w-11 h-11 rounded-full bg-cream border border-rule shrink-0" aria-hidden="true" />
                        <div>
                          <div className="font-heading text-[17px] text-ink">{featured.authorAttorney.name}</div>
                          {featured.authorAttorney.jobTitle && (
                            <div className="text-xs text-slate mt-0.5">{featured.authorAttorney.jobTitle}</div>
                          )}
                        </div>
                      </>
                    )}
                    <span className="ml-auto text-terra font-bold text-sm inline-flex items-center gap-2 group-hover:translate-x-1 transition-transform">
                      Read the piece →
                    </span>
                  </div>
                </div>
              </Link>
            </section>
          )}

          {/* ── Archive grid ─────────────────────────────── */}
          <section className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-14">
            <div className="flex items-end justify-between mb-9">
              <h2 className="font-heading text-[clamp(30px,4vw,44px)] leading-[1.05] tracking-[-0.02em]">
                The <span className="porch-em">latest</span> from the desk.
              </h2>
              <div className="font-mono text-[12px] tracking-[0.1em] uppercase text-slate hidden sm:block">
                <b className="text-ink font-bold">{posts.length}</b> articles
              </div>
            </div>
            <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-x-7 gap-y-9">
              {rest.map((post: any) => {
                const imgUrl = post.featuredImage ? urlForImage(post.featuredImage)?.width(600).height(450).url() : null;
                return (
                  <Link key={post._id} href={`/blog/${post.slug}/`} className="group flex flex-col no-underline">
                    <div className="relative aspect-[4/3] rounded-[18px] overflow-hidden mb-5 bg-cream">
                      {imgUrl ? (
                        <Image src={imgUrl} alt={post.title} width={600} height={450} className="absolute inset-0 w-full h-full object-cover" />
                      ) : (
                        <PorchPlaceholder label={post.title} variant="warm" className="absolute inset-0" />
                      )}
                      {post.category && (
                        <span className="absolute top-3.5 left-3.5 z-10 bg-paper text-ink px-3 py-1.5 rounded-full text-[11px] font-extrabold tracking-[0.1em] uppercase border border-rule">
                          {post.category.title}
                        </span>
                      )}
                    </div>
                    <div className="flex items-center gap-2.5 mb-2.5 font-mono text-[10px] tracking-[0.12em] uppercase text-slate">
                      {post.category && <span className="text-terra font-bold">{post.category.title}</span>}
                      {post.category && post.publishedAt && <span className="w-[3px] h-[3px] rounded-full bg-slate" aria-hidden="true" />}
                      {post.publishedAt && <span>{fmtDate(post.publishedAt)}</span>}
                    </div>
                    <h3 className="font-heading font-medium text-[26px] leading-[1.15] tracking-[-0.01em] mb-2.5 group-hover:text-terra transition-colors">
                      {post.title}
                    </h3>
                    {post.excerpt && <p className="text-sm leading-[1.55] text-slate mb-4 line-clamp-2">{post.excerpt}</p>}
                    {post.authorAttorney && (
                      <div className="mt-auto flex items-center gap-2.5 pt-3.5 border-t border-rule text-xs text-ink-2">
                        <span className="w-6 h-6 rounded-full bg-cream border border-rule shrink-0" aria-hidden="true" />
                        <span className="font-bold text-ink">{post.authorAttorney.name}</span>
                      </div>
                    )}
                  </Link>
                );
              })}
            </div>
          </section>
        </>
      ) : (
        <section className="mx-auto max-w-[1200px] px-6 lg:px-[88px] py-20">
          <p className="text-slate text-center">No blog posts yet. Check back soon.</p>
        </section>
      )}
    </>
  );
}
