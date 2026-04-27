import { defineField, defineType } from "sanity";

export default defineType({
  name: "caseResult",
  title: "Case Result",
  type: "document",
  fields: [
    defineField({ name: "title", title: "Title", type: "string", validation: (r) => r.required() }),
    defineField({ name: "slug", title: "Slug", type: "slug", options: { source: "title" }, validation: (r) => r.required() }),
    defineField({ name: "amount", title: "Amount", type: "string", description: "Display format, e.g. $3,000,000" }),
    defineField({
      name: "resultType",
      title: "Result Type",
      type: "string",
      options: { list: ["settlement", "verdict", "recovery"] },
    }),
    defineField({ name: "accidentType", title: "Accident Type", type: "string" }),
    defineField({ name: "injuryType", title: "Injury Type", type: "string" }),
    defineField({ name: "initialOffer", title: "Initial Offer", type: "string" }),
    defineField({ name: "description", title: "Description", type: "text" }),
    defineField({ name: "leadAttorney", title: "Lead Attorney", type: "reference", to: [{ type: "attorney" }] }),
    defineField({
      name: "practiceCategories",
      title: "Practice Categories",
      type: "array",
      of: [{ type: "reference", to: [{ type: "practiceCategory" }] }],
    }),
    defineField({ name: "body", title: "Body Content", type: "array", of: [{ type: "block" }] }),
    defineField({ name: "language", title: "Language", type: "string", options: { list: ["en", "es"] }, initialValue: "en" }),
    defineField({ name: "translationOf", title: "Translation Of", type: "reference", to: [{ type: "caseResult" }] }),
  ],
  preview: {
    select: { title: "title", amount: "amount", type: "resultType" },
    prepare({ title, amount, type }) {
      return { title, subtitle: [amount, type].filter(Boolean).join(" · ") };
    },
  },
});
