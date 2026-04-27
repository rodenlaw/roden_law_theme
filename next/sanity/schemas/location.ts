import { defineField, defineType } from "sanity";

export default defineType({
  name: "location",
  title: "Location",
  type: "document",
  fields: [
    defineField({ name: "title", title: "Title", type: "string", validation: (r) => r.required() }),
    defineField({ name: "slug", title: "Slug", type: "slug", options: { source: "title" }, validation: (r) => r.required() }),
    defineField({ name: "isNeighborhood", title: "Is Neighborhood", type: "boolean", initialValue: false }),
    defineField({
      name: "parentLocation",
      title: "Parent Location",
      type: "reference",
      to: [{ type: "location" }],
      description: "City parent for neighborhood pages",
    }),
    defineField({ name: "officeKey", title: "Office Key", type: "string" }),
    defineField({ name: "parentOfficeKey", title: "Parent Office Key", type: "string", description: "For neighborhoods — which office market this belongs to" }),
    defineField({ name: "population", title: "Population", type: "string" }),
    defineField({ name: "court", title: "Court", type: "string" }),
    defineField({ name: "latitude", title: "Latitude", type: "number" }),
    defineField({ name: "longitude", title: "Longitude", type: "number" }),
    defineField({ name: "roads", title: "Roads / Hazards", type: "text" }),
    defineField({ name: "hospitals", title: "Hospitals", type: "text" }),
    defineField({ name: "landmarks", title: "Landmarks", type: "text" }),
    defineField({ name: "serviceArea", title: "Service Area", type: "text" }),
    defineField({ name: "mapEmbed", title: "Map Embed URL", type: "url" }),
    defineField({ name: "localContent", title: "Local Content", type: "array", of: [{ type: "block" }] }),
    defineField({ name: "faqs", title: "FAQs", type: "array", of: [{ type: "faq" }] }),
    defineField({ name: "body", title: "Body Content", type: "array", of: [{ type: "block" }, { type: "image" }] }),
    defineField({ name: "seoMetaDescription", title: "Meta Description", type: "string", validation: (r) => r.max(160) }),
    defineField({ name: "language", title: "Language", type: "string", options: { list: ["en", "es"] }, initialValue: "en" }),
    defineField({ name: "translationOf", title: "Translation Of", type: "reference", to: [{ type: "location" }] }),
  ],
  preview: {
    select: { title: "title", isNeighborhood: "isNeighborhood" },
    prepare({ title, isNeighborhood }) {
      return { title, subtitle: isNeighborhood ? "Neighborhood" : "Office" };
    },
  },
});
