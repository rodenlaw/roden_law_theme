import { defineType } from "sanity";

export default defineType({
  name: "faq",
  title: "FAQ",
  type: "object",
  fields: [
    { name: "question", title: "Question", type: "string", validation: (r) => r.required() },
    { name: "answer", title: "Answer", type: "text", validation: (r) => r.required() },
  ],
});
