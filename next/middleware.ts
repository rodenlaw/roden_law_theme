import { NextResponse } from "next/server";
import type { NextRequest } from "next/server";

/**
 * Practice area pillar slugs that are valid first segments for the
 * [pillarSlug]/[childSlug] route. All other first-segment paths
 * (about, contact, blog, etc.) fall through to their own routes.
 */
const PRACTICE_AREA_SLUGS = new Set([
  "personal-injury-lawyers",
  "car-accident-lawyers",
  "truck-accident-lawyers",
  "slip-and-fall-lawyers",
  "motorcycle-accident-lawyers",
  "medical-malpractice-lawyers",
  "wrongful-death-lawyers",
  "workers-compensation-lawyers",
  "dog-bite-lawyers",
  "brain-injury-lawyers",
  "spinal-cord-injury-lawyers",
  "maritime-injury-lawyers",
  "product-liability-lawyers",
  "boating-accident-lawyers",
  "burn-injury-lawyers",
  "construction-accident-lawyers",
  "nursing-home-abuse-lawyers",
  "premises-liability-lawyers",
  "pedestrian-accident-lawyers",
  "bicycle-accident-lawyers",
  "electric-scooter-accident-lawyers",
  "atv-side-by-side-accident-lawyers",
  "golf-cart-accident-lawyers",
  "e-bike-accident-lawyers",
]);

export function middleware(request: NextRequest) {
  const { pathname } = request.nextUrl;

  // Only check two-segment paths like /car-accident-lawyers/savannah-ga/
  const segments = pathname.split("/").filter(Boolean);
  if (segments.length !== 2) return NextResponse.next();

  const [firstSegment] = segments;

  // If the first segment is NOT a known practice area slug, let it fall through
  // to other routes (about, contact, blog, locations, attorneys, etc.)
  if (!PRACTICE_AREA_SLUGS.has(firstSegment)) {
    return NextResponse.next();
  }

  // It's a valid PA slug — let the [pillarSlug]/[childSlug] route handle it
  return NextResponse.next();
}

export const config = {
  matcher: [
    // Match all paths except static files, api routes, and studio
    "/((?!api|_next/static|_next/image|studio|favicon.ico).*)",
  ],
};
