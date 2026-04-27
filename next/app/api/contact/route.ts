import { NextResponse } from "next/server";

export async function POST(request: Request) {
  const body = await request.json();
  const { firstName, lastName, phone, email, message } = body;

  if (!firstName || !email || !phone) {
    return NextResponse.json({ error: "Missing required fields" }, { status: 400 });
  }

  // TODO: integrate Resend or SendGrid for email delivery
  // For now, log to console in development
  console.log("Contact form submission:", { firstName, lastName, phone, email, message });

  return NextResponse.json({ success: true });
}
