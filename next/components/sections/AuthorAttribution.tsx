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
    <div className="my-10 border-t border-border pt-8">
      <h3 className="font-heading text-lg font-bold text-navy mb-4">About the Author</h3>
      <div className="flex flex-col sm:flex-row gap-5">
        {headshotUrl && (
          <Link href={`/attorneys/${slug}/`} className="shrink-0">
            <Image
              src={headshotUrl}
              alt={name}
              width={120}
              height={160}
              className="rounded-lg object-cover"
            />
          </Link>
        )}
        <div>
          <h4 className="font-heading font-bold text-navy mb-1">
            <Link href={`/attorneys/${slug}/`} className="text-navy hover:text-orange-text no-underline">
              {name}
            </Link>
          </h4>
          {jobTitle && (
            <span className="block text-sm text-gray-600 mb-1">{jobTitle}</span>
          )}
          {barAdmissions && (
            <span className="block text-xs text-gray-500 mb-2">{barAdmissions}</span>
          )}
          {excerpt && (
            <p className="text-sm text-gray-700 leading-relaxed mb-2">{excerpt}</p>
          )}
          <Link
            href={`/attorneys/${slug}/`}
            className="text-sm font-semibold text-navy hover:text-orange-text no-underline"
          >
            View Full Profile &rarr;
          </Link>
        </div>
      </div>
    </div>
  );
}
