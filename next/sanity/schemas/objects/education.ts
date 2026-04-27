import { defineType } from "sanity";

export default defineType({
  name: "education",
  title: "Education",
  type: "object",
  fields: [
    { name: "degree", title: "Degree", type: "string", validation: (r) => r.required() },
    { name: "institution", title: "Institution", type: "string", validation: (r) => r.required() },
  ],
});
