import { defineField, defineType } from "sanity";

export default defineType({
  name: "attorney",
  title: "Attorney",
  type: "document",
  fields: [
    defineField({ name: "name", title: "Name", type: "string", validation: (r) => r.required() }),
    defineField({ name: "slug", title: "Slug", type: "slug", options: { source: "name" }, validation: (r) => r.required() }),
    defineField({ name: "jobTitle", title: "Job Title", type: "string" }),
    defineField({ name: "officeKey", title: "Primary Office", type: "string" }),
    defineField({ name: "barAdmissions", title: "Bar Admissions", type: "text", description: "State bar memberships" }),
    defineField({ name: "education", title: "Education", type: "array", of: [{ type: "education" }] }),
    defineField({ name: "awards", title: "Awards", type: "array", of: [{ type: "award" }] }),
    defineField({ name: "sameAs", title: "Profile URLs", type: "array", of: [{ type: "url" }], description: "Avvo, LinkedIn, Martindale, etc." }),
    defineField({ name: "headshot", title: "Headshot", type: "image", options: { hotspot: true } }),
    defineField({ name: "body", title: "Bio", type: "array", of: [{ type: "block" }] }),
    defineField({ name: "seoMetaDescription", title: "Meta Description", type: "string", validation: (r) => r.max(160) }),
    defineField({ name: "language", title: "Language", type: "string", options: { list: ["en", "es"] }, initialValue: "en" }),
    defineField({ name: "translationOf", title: "Translation Of", type: "reference", to: [{ type: "attorney" }] }),
  ],
  preview: {
    select: { title: "name", subtitle: "jobTitle", media: "headshot" },
  },
});
