import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  // Canonical URLs carry NO trailing slash — matches the CURRENT live WP site
  // (firecrawl 2026-06-05: all 1,214 indexed URLs are slash-less). sitemap.ts,
  // schema.ts, and the legacy-redirect destinations all emit slash-less URLs to
  // match; Next normalizes <Link> hrefs and 308s any /path/ → /path.
  trailingSlash: false,

  // Allow next/image to optimize Sanity-hosted assets (featured images,
  // headshots). Without this the image optimizer 400s and images appear broken.
  images: {
    remotePatterns: [
      { protocol: "https", hostname: "cdn.sanity.io", pathname: "/images/wz6c0wck/**" },
    ],
  },
};

export default nextConfig;
