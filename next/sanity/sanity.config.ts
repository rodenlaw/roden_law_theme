import { defineConfig } from "sanity";
import { structureTool } from "sanity/structure";
import { schemaTypes } from "./schemas";
import { projectId, dataset } from "./lib/client";

export default defineConfig({
  name: "roden-law",
  title: "Roden Law CMS",
  projectId,
  dataset,
  plugins: [structureTool()],
  schema: {
    types: schemaTypes,
  },
});
