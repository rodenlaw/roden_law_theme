import { revalidatePath } from "next/cache";
import { NextResponse } from "next/server";

export async function POST(request: Request) {
  const secret = request.headers.get("x-sanity-webhook-secret");
  if (secret !== process.env.SANITY_WEBHOOK_SECRET) {
    return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  }

  try {
    const body = await request.json();
    const type = body?._type;

    // Revalidate based on document type
    switch (type) {
      case "practiceArea":
        revalidatePath("/practice-areas/[slug]", "page");
        revalidatePath("/[pillarSlug]/[childSlug]", "page");
        break;
      case "location":
        revalidatePath("/locations/[state]/[city]", "page");
        revalidatePath("/locations/[state]/[city]/[neighborhood]", "page");
        break;
      case "attorney":
        revalidatePath("/attorneys", "page");
        revalidatePath("/attorneys/[slug]", "page");
        break;
      case "caseResult":
        revalidatePath("/case-results", "page");
        break;
      case "testimonial":
        revalidatePath("/testimonials", "page");
        break;
      case "resource":
        revalidatePath("/resources/[slug]", "page");
        break;
      case "blogPost":
        revalidatePath("/blog", "page");
        revalidatePath("/blog/[slug]", "page");
        break;
      default:
        revalidatePath("/", "layout");
    }

    return NextResponse.json({ revalidated: true, type });
  } catch {
    return NextResponse.json({ error: "Revalidation failed" }, { status: 500 });
  }
}
