import imageUrlBuilder from "@sanity/image-url";
import { client } from "./client";

const builder = imageUrlBuilder(client);

export function urlForImage(source: { asset?: { _ref?: string } }) {
  if (!source?.asset?._ref) return null;
  return builder.image(source);
}
