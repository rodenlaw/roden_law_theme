import { defineField, defineType } from "sanity";

export default defineType({
  name: "practiceArea",
  title: "Practice Area",
  type: "document",
  fields: [
    defineField({ name: "title", title: "Title", type: "string", validation: (r) => r.required() }),
    defineField({ name: "slug", title: "Slug", type: "slug", options: { source: "title" }, validation: (r) => r.required() }),
    defineField({
      name: "pageType",
      title: "Page Type",
      type: "string",
      options: { list: ["pillar", "intersection", "subtype"] },
      validation: (r) => r.required(),
    }),
    defineField({
      name: "parent",
      title: "Parent Practice Area",
      type: "reference",
      to: [{ type: "practiceArea" }],
      description: "Pillar parent for intersection/subtype pages",
    }),
    defineField({ name: "officeKey", title: "Office Key", type: "string", description: "For intersection pages — matches firm-data office key (e.g. savannah, charleston)" }),
    defineField({
      name: "jurisdiction",
      title: "Jurisdiction",
      type: "string",
      options: { list: ["both", "GA", "SC"] },
      initialValue: "both",
    }),
    defineField({ name: "solGa", title: "SOL Georgia", type: "string" }),
    defineField({ name: "solSc", title: "SOL South Carolina", type: "string" }),
    defineField({ name: "heroIntro", title: "Hero Intro", type: "text", rows: 3 }),
    defineField({ name: "whyHire", title: "Why Hire Us", type: "array", of: [{ type: "block" }] }),
    defineField({ name: "expertQuote", title: "Expert Quote", type: "text" }),
    defineField({ name: "commonCauses", title: "Common Causes", type: "array", of: [{ type: "string" }] }),
    defineField({
      name: "commonInjuries",
      title: "Common Injuries",
      type: "array",
      of: [{ type: "object", fields: [
        { name: "name", type: "string", title: "Injury Name" },
        { name: "description", type: "text", title: "Description" },
      ]}],
    }),
    defineField({ name: "faqs", title: "FAQs", type: "array", of: [{ type: "faq" }] }),
    defineField({
      name: "authorAttorney",
      title: "Author Attorney",
      type: "reference",
      to: [{ type: "attorney" }],
      description: "E-E-A-T attribution",
    }),
    defineField({ name: "body", title: "Body Content", type: "array", of: [{ type: "block" }, { type: "image" }] }),
    defineField({ name: "seoMetaDescription", title: "Meta Description", type: "string", validation: (r) => r.max(160) }),
    defineField({
      name: "practiceCategories",
      title: "Practice Categories",
      type: "array",
      of: [{ type: "reference", to: [{ type: "practiceCategory" }] }],
    }),
    defineField({
      name: "locationsServed",
      title: "Locations Served",
      type: "array",
      of: [{ type: "reference", to: [{ type: "locationServed" }] }],
    }),
    defineField({
      name: "language",
      title: "Language",
      type: "string",
      options: { list: ["en", "es"] },
      initialValue: "en",
    }),
    defineField({
      name: "translationOf",
      title: "Translation Of",
      type: "reference",
      to: [{ type: "practiceArea" }],
      description: "English original this is a translation of",
    }),
  ],
  preview: {
    select: { title: "title", pageType: "pageType", language: "language" },
    prepare({ title, pageType, language }) {
      return {
        title,
        subtitle: `${pageType ?? "pillar"} · ${language ?? "en"}`,
      };
    },
  },
});
