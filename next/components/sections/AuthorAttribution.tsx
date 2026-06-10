import Image from "next/image";
import Link from "next/link";

interface AuthorAttribtionProps {
  name: string;
  slug: string;
  jobTitle?: string;
  barAdmissions?: string;
  excerpt?: string;
  headshotUrl?: string;
}

export function AuthorAttribution({
  name,
  slug,
  jobTitle,
  barAdmissions,
  excerpt,
  headshotUrl,
}: AuthorAttribtionProps) {
  return (
    <div className="my-10 border-t border-rule pt-8">
      <p className="porch-eyebrow mb-4">About the Author</p>
      <div className="flex flex-col sm:flex-row gap-5">
        {headshotUrl && (
          <Link href={`/attorneys/${slug}/`} className="shrink-0">
            <Image
              src={headshotUrl}
              alt={name}
              width={120}
              height={160}
              className="rounded-[20px] object-cover"
            />
          </Link>
        )}
        <div>
          <h4 className="font-heading text-[22px] text-ink mb-1">
            <Link href={`/attorneys/${slug}/`} className="text-ink hover:text-terra no-underline">
              {name}
            </Link>
          </h4>
          {jobTitle && (
            <span className="block text-sm text-slate mb-1">{jobTitle}</span>
          )}
          {barAdmissions && (
            <span className="block text-xs text-slate mb-2">{barAdmissions}</span>
          )}
          {excerpt && (
            <p className="text-sm text-slate leading-relaxed mb-2">{excerpt}</p>
          )}
          <Link
            href={`/attorneys/${slug}/`}
            className="text-sm font-semibold text-terra hover:text-terra-deep no-underline"
          >
            View Full Profile &rarr;
          </Link>
        </div>
      </div>
    </div>
  );
}
