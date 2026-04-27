import { defineType } from "sanity";

export default defineType({
  name: "award",
  title: "Award",
  type: "object",
  fields: [
    { name: "name", title: "Award Name", type: "string", validation: (r) => r.required() },
    { name: "year", title: "Year", type: "string" },
  ],
});
