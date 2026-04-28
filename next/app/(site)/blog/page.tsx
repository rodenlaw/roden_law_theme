import type { Metadata } from "next";
import Link from "next/link";
import Image from "next/image";
import { getBlogPosts } from "@/lib/queries/blog";
import { Breadcrumbs } from "@/components/shared/Breadcrumbs";
import { urlForImage } from "@/sanity/lib/image";

export const revalidate = 3600;
export const metadata: Metadata = {
  title: "Blog",
  description: "Legal insights, accident news, and injury law resources for Georgia and South Carolina residents — written by licensed personal injury attorneys.",
};

export default async function BlogListingPage() {
  const posts = await getBlogPosts(0, 24);

  return (
    <>
      <section className="bg-navy text-white py-12">
        <div className="mx-auto max-w-[1200px] px-6">
          <Breadcrumbs items={[{ label: "Home", href: "/" }, { label: "Blog" }]} />
          <h1 className="font-heading text-3xl md:text-4xl font-black mt-4 mb-3">Roden Law Blog</h1>
          <p className="text-lg text-gray-300 max-w-2xl">
            Legal insights, accident news, and injury law resources for Georgia and South Carolina residents — written by licensed personal injury attorneys.
          </p>
        </div>
      </section>

      <section className="mx-auto max-w-[1200px] px-6 py-12">
        {posts && posts.length > 0 ? (
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {posts.map((post: any) => {
              const imgUrl = post.featuredImage ? urlForImage(post.featuredImage)?.width(600).height(400).url() : null;
              return (
                <Link
                  key={post._id}
                  href={`/blog/${post.slug}/`}
                  className="group block bg-white border border-border rounded-lg overflow-hidden hover:shadow-md transition-shadow no-underline"
                >
                  {imgUrl && (
                    <Image
                      src={imgUrl}
                      alt={post.title}
                      width={600}
                      height={400}
                      className="w-full h-48 object-cover"
                    />
                  )}
                  <div className="p-5">
                    {post.category && (
                      <span className="text-[10px] uppercase tracking-widest text-orange font-bold">
                        {post.category.title}
                      </span>
                    )}
                    <h2 className="font-heading text-base font-bold text-navy mt-1 mb-2 group-hover:text-orange-text line-clamp-2">
                      {post.title}
                    </h2>
                    {post.excerpt && (
                      <p className="text-sm text-gray-600 line-clamp-2 mb-3">{post.excerpt}</p>
                    )}
                    <div className="flex items-center gap-3 text-xs text-gray-500">
                      {post.authorAttorney && (
                        <span>{post.authorAttorney.name}</span>
                      )}
                      {post.publishedAt && (
                        <span>{new Date(post.publishedAt).toLocaleDateString("en-US", { month: "short", day: "numeric", year: "numeric" })}</span>
                      )}
                    </div>
                  </div>
                </Link>
              );
            })}
          </div>
        ) : (
          <p className="text-gray-600 text-center py-10">No blog posts yet. Check back soon.</p>
        )}
      </section>
    </>
  );
}
