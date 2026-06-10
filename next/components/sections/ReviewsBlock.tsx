import Link from "next/link";
import { getFeaturedTestimonials, type FeaturedTestimonial } from "@/lib/queries/shared";
import { getFirmData } from "@/lib/firm-data";
import { JsonLd } from "@/components/shared/JsonLd";

const SOURCE_LABEL: Record<string, string> = {
  google: "Google",
  avvo: "Avvo",
  facebook: "Facebook",
  bbb: "BBB",
  direct: "Verified Client",
};

function formatDate(iso: string | null): string | null {
  if (!iso) return null;
  const d = new Date(iso);
  if (Number.isNaN(d.getTime())) return null;
  return d.toLocaleDateString("en-US", { month: "short", year: "numeric" });
}

function ReviewCard({ review }: { review: FeaturedTestimonial }) {
  const stars = "★".repeat(review.rating ?? 5);
  const sourceLabel = SOURCE_LABEL[review.source] ?? "Verified Client";
  const date = formatDate(review.dateOf);

  return (
    <article className="bg-paper rounded-[20px] p-7 border border-rule h-full flex flex-col">
      <div className="text-honey text-lg mb-3 tracking-widest" aria-label={`${review.rating ?? 5} star rating`}>
        {stars}
      </div>
      <blockquote className="text-[15px] text-ink-2 leading-relaxed mb-5 flex-1 border-0 bg-transparent p-0 not-italic">
        &ldquo;{review.excerpt}&rdquo;
      </blockquote>
      <footer className="border-t border-rule pt-4 text-xs text-slate">
        <p className="font-heading text-ink text-base not-italic">{review.clientName}</p>
        <p className="mt-0.5">
          {[review.caseType, review.city].filter(Boolean).join(" · ")}
        </p>
        <p className="mt-1 flex items-center gap-1.5 text-slate">
          <span>{date ? `${date} · ` : ""}via {sourceLabel}</span>
          {review.sourceUrl && (
            <a
              href={review.sourceUrl}
              target="_blank"
              rel="noopener noreferrer nofollow"
              className="underline hover:text-terra"
            >
              View on Google
            </a>
          )}
        </p>
      </footer>
    </article>
  );
}

function buildReviewSchema(reviews: FeaturedTestimonial[]) {
  const firm = getFirmData();
  const itemReviewed = {
    "@type": "LegalService",
    name: firm.name,
    url: firm.url,
  };
  return reviews
    .filter((r) => r.excerpt)
    .map((r) => ({
      "@context": "https://schema.org",
      "@type": "Review",
      reviewRating: {
        "@type": "Rating",
        ratingValue: r.rating ?? 5,
        bestRating: 5,
      },
      author: { "@type": "Person", name: r.clientName },
      reviewBody: r.excerpt,
      datePublished: r.dateOf || undefined,
      itemReviewed,
    }));
}

export async function ReviewsBlock() {
  const reviews = await getFeaturedTestimonials(6);
  const firm = getFirmData();

  if (!reviews || reviews.length === 0) {
    return (
      <section className="bg-cream py-[100px]" id="testimonials">
        <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px] text-center">
          <div className="text-honey text-3xl mb-3 tracking-widest" aria-label="5 star rating">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <h2 className="font-heading text-[clamp(32px,4vw,52px)] leading-[1.05] mb-3">
            {firm.trustStats.reviews} <span className="porch-em">five-star</span> reviews.
          </h2>
          <p className="text-slate mb-7 text-[17px]">We measure success the same way our clients do: did we get them what they needed to move forward?</p>
          <Link href="/testimonials/" className="inline-flex items-center gap-2 text-sm font-semibold text-terra hover:text-terra-deep no-underline">
            Read client testimonials <span aria-hidden="true">&rarr;</span>
          </Link>
        </div>
      </section>
    );
  }

  const schemaItems = buildReviewSchema(reviews);
  const totalReviewCount = Object.values(firm.offices).reduce((sum, o) => sum + (o.reviewCount ?? 0), 0);

  return (
    <section className="bg-cream py-[100px]" id="testimonials">
      <div className="mx-auto max-w-[1200px] px-6 lg:px-[88px]">
        <div className="mb-14">
          <p className="porch-eyebrow mb-2">Client Reviews</p>
          <h2 className="font-heading text-[clamp(32px,4vw,52px)] leading-[1.05]">
            {firm.trustStats.reviews} <span className="porch-em">five-star</span> reviews.
          </h2>
          <p className="text-slate mt-3 text-[17px]">
            <strong className="text-ink">{firm.trustStats.rating}★</strong> average across {totalReviewCount}+ Google reviews from our {firm.trustStats.offices} offices.
          </p>
        </div>

        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {reviews.map((r) => (
            <ReviewCard key={r._id} review={r} />
          ))}
        </div>

        <div className="text-center mt-10">
          <Link
            href="/testimonials/"
            className="inline-flex items-center gap-2 text-sm font-semibold text-terra hover:text-terra-deep no-underline"
          >
            Read more client testimonials <span aria-hidden="true">&rarr;</span>
          </Link>
        </div>
      </div>

      {schemaItems.length > 0 && <JsonLd data={schemaItems} />}
    </section>
  );
}
