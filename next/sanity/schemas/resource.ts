import { defineField, defineType } from "sanity";

export default defineType({
  name: "resource",
  title: "Resource",
  type: "document",
  fields: [
    defineField({ name: "title", title: "Title", type: "string", validation: (r) => r.required() }),
    defineField({ name: "slug", title: "Slug", type: "slug", options: { source: "title" }, validation: (r) => r.required() }),
    defineField({ name: "authorAttorney", title: "Author Attorney", type: "reference", to: [{ type: "attorney" }] }),
    defineField({
      name: "jurisdiction",
      title: "Jurisdiction",
      type: "string",
      options: { list: ["both", "GA", "SC"] },
      initialValue: "both",
    }),
    defineField({ name: "keyTakeaways", title: "Key Takeaways", type: "text", description: "Summary paragraph for AI citation" }),
    defineField({ name: "body", title: "Body Content", type: "array", of: [{ type: "block" }, { type: "image" }] }),
    defineField({ name: "faqs", title: "FAQs", type: "array", of: [{ type: "faq" }] }),
    defineField({ name: "seoMetaDescription", title: "Meta Description", type: "string", validation: (r) => r.max(160) }),
    defineField({ name: "language", title: "Language", type: "string", options: { list: ["en", "es"] }, initialValue: "en" }),
    defineField({ name: "translationOf", title: "Translation Of", type: "reference", to: [{ type: "resource" }] }),
  ],
});
