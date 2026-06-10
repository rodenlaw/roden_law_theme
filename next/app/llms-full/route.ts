import { generateLlmsTxt } from "@/lib/llms";

// 24h ISR, mirroring the WordPress transient cache.
export const revalidate = 86400;

export async function GET() {
  const body = await generateLlmsTxt(true);
  return new Response(body, {
    headers: {
      "Content-Type": "text/markdown; charset=utf-8",
      "X-Robots-Tag": "noindex",
    },
  });
}
