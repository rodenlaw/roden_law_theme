import { defineField, defineType } from "sanity";

export default defineType({
  name: "blogPost",
  title: "Blog Post",
  type: "document",
  fields: [
    defineField({ name: "title", title: "Title", type: "string", validation: (r) => r.required() }),
    defineField({ name: "slug", title: "Slug", type: "slug", options: { source: "title" }, validation: (r) => r.required() }),
    defineField({ name: "authorAttorney", title: "Author Attorney", type: "reference", to: [{ type: "attorney" }] }),
    defineField({ name: "publishedAt", title: "Published At", type: "datetime" }),
    defineField({ name: "featuredImage", title: "Featured Image", type: "image", options: { hotspot: true } }),
    defineField({ name: "excerpt", title: "Excerpt", type: "text", rows: 3 }),
    defineField({ name: "keyTakeaways", title: "Key Takeaways", type: "text", description: "Summary paragraph for AI citation" }),
    defineField({ name: "body", title: "Body Content", type: "array", of: [{ type: "block" }, { type: "image" }] }),
    defineField({ name: "faqs", title: "FAQs", type: "array", of: [{ type: "faq" }] }),
    defineField({
      name: "category",
      title: "Category",
      type: "reference",
      to: [{ type: "practiceCategory" }],
    }),
    defineField({ name: "seoMetaDescription", title: "Meta Description", type: "string", validation: (r) => r.max(160) }),
    defineField({ name: "language", title: "Language", type: "string", options: { list: ["en", "es"] }, initialValue: "en" }),
    defineField({ name: "translationOf", title: "Translation Of", type: "reference", to: [{ type: "blogPost" }] }),
  ],
  orderings: [
    { title: "Published Date, New", name: "publishedAtDesc", by: [{ field: "publishedAt", direction: "desc" }] },
  ],
  preview: {
    select: { title: "title", date: "publishedAt", media: "featuredImage" },
    prepare({ title, date }) {
      return { title, subtitle: date ? new Date(date).toLocaleDateString() : "Draft" };
    },
  },
});
