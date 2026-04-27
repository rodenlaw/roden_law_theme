import { defineField, defineType } from "sanity";

export default defineType({
  name: "testimonial",
  title: "Testimonial",
  type: "document",
  fields: [
    defineField({ name: "clientName", title: "Client Name", type: "string", validation: (r) => r.required() }),
    defineField({ name: "slug", title: "Slug", type: "slug", options: { source: "clientName" }, validation: (r) => r.required() }),
    defineField({ name: "reviewBody", title: "Review", type: "array", of: [{ type: "block" }] }),
    defineField({ name: "rating", title: "Rating", type: "number", initialValue: 5, validation: (r) => r.min(1).max(5) }),
    defineField({ name: "language", title: "Language", type: "string", options: { list: ["en", "es"] }, initialValue: "en" }),
    defineField({ name: "translationOf", title: "Translation Of", type: "reference", to: [{ type: "testimonial" }] }),
  ],
  preview: {
    select: { title: "clientName", rating: "rating" },
    prepare({ title, rating }) {
      return { title, subtitle: `${"★".repeat(rating ?? 5)}` };
    },
  },
});
