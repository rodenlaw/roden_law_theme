import { defineField, defineType } from "sanity";

export default defineType({
  name: "testimonial",
  title: "Testimonial",
  type: "document",
  fields: [
    defineField({ name: "clientName", title: "Client Name", type: "string", validation: (r) => r.required() }),
    defineField({ name: "slug", title: "Slug", type: "slug", options: { source: "clientName" }, validation: (r) => r.required() }),
    defineField({
      name: "excerpt",
      title: "Excerpt (homepage card)",
      type: "text",
      rows: 3,
      description: "1–3 sentence quote shown on the homepage and listings. Keep under ~280 chars.",
      validation: (r) => r.max(400),
    }),
    defineField({ name: "reviewBody", title: "Full Review", type: "array", of: [{ type: "block" }] }),
    defineField({ name: "rating", title: "Rating", type: "number", initialValue: 5, validation: (r) => r.min(1).max(5) }),
    defineField({
      name: "city",
      title: "Client City",
      type: "string",
      description: "e.g. \"Charleston, SC\" — attribution shown on the card.",
    }),
    defineField({
      name: "caseType",
      title: "Case Type",
      type: "string",
      description: "e.g. \"Truck Accident\", \"Motorcycle Accident\". Surfaced on the card and used for filtering.",
    }),
    defineField({
      name: "source",
      title: "Review Source",
      type: "string",
      options: {
        list: [
          { title: "Google", value: "google" },
          { title: "Avvo", value: "avvo" },
          { title: "Facebook", value: "facebook" },
          { title: "BBB", value: "bbb" },
          { title: "Direct (client letter / email)", value: "direct" },
        ],
        layout: "radio",
      },
      initialValue: "google",
      validation: (r) => r.required(),
    }),
    defineField({
      name: "sourceUrl",
      title: "Source URL",
      type: "url",
      description: "Link to the original review (Google review permalink, Avvo profile, etc.). Required for verifiable attribution.",
    }),
    defineField({
      name: "dateOf",
      title: "Review Date",
      type: "date",
      description: "When the review was posted. Used in Review JSON-LD schema.",
    }),
    defineField({
      name: "featured",
      title: "Feature on homepage",
      type: "boolean",
      initialValue: false,
      description: "Show in the homepage reviews block. Aim for 4–6 featured reviews spanning case types and cities.",
    }),
    defineField({ name: "language", title: "Language", type: "string", options: { list: ["en", "es"] }, initialValue: "en" }),
    defineField({ name: "translationOf", title: "Translation Of", type: "reference", to: [{ type: "testimonial" }] }),
  ],
  preview: {
    select: { title: "clientName", rating: "rating", city: "city", caseType: "caseType", featured: "featured" },
    prepare({ title, rating, city, caseType, featured }) {
      const stars = "★".repeat(rating ?? 5);
      const meta = [caseType, city].filter(Boolean).join(" · ");
      return {
        title: `${featured ? "★ " : ""}${title}`,
        subtitle: `${stars}${meta ? "  " + meta : ""}`,
      };
    },
  },
});
