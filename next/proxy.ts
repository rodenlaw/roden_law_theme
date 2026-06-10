import { NextResponse } from "next/server";
import type { NextRequest } from "next/server";
import { resolveLegacyRedirect } from "@/lib/legacy-redirects";

/**
 * Next.js 16 Proxy (formerly Middleware). Issues 301 redirects for legacy
 * WordPress URLs so the cutover doesn't drop SEO equity or 404 old inbound
 * links. Logic lives in lib/legacy-redirects.ts (ported from the WP theme's
 * inc/legacy-redirects.php). WordPress system-path redirects (/wp-admin, etc.)
 * are handled separately in vercel.json at the platform edge.
 */
export function proxy(request: NextRequest) {
  const { pathname, search } = request.nextUrl;
  const dest = resolveLegacyRedirect(pathname);
  if (dest && dest !== pathname) {
    const url = new URL(dest, request.url);
    url.search = search; // preserve tracking/query params
    return NextResponse.redirect(url, 301);
  }
  return NextResponse.next();
}

export const config = {
  // Run on page paths only — skip Next internals, API/Studio, and any file
  // with an extension (static assets).
  matcher: ["/((?!_next/|api/|studio|.*\\.).*)"],
};
