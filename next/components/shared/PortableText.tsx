import { PortableText as SanityPortableText, type PortableTextComponents } from "@portabletext/react";
import type { PortableTextBlock } from "@portabletext/types";
import Image from "next/image";
import { urlForImage } from "@/sanity/lib/image";

const components: PortableTextComponents = {
  types: {
    image: ({ value }) => {
      const url = urlForImage(value)?.width(800).url();
      if (!url) return null;
      return (
        <figure className="my-6">
          <Image
            src={url}
            alt={value.alt || ""}
            width={800}
            height={450}
            className="rounded-lg w-full h-auto"
          />
        </figure>
      );
    },
  },
  marks: {
    link: ({ children, value }) => {
      const href = value?.href || "#";
      const isExternal = href.startsWith("http");
      return (
        <a
          href={href}
          className="text-navy underline hover:text-orange-text"
          {...(isExternal ? { target: "_blank", rel: "noopener noreferrer" } : {})}
        >
          {children}
        </a>
      );
    },
  },
};

export function PortableText({ value }: { value: PortableTextBlock[] }) {
  if (!value) return null;
  return (
    <div className="prose prose-gray max-w-none">
      <SanityPortableText value={value} components={components} />
    </div>
  );
}
