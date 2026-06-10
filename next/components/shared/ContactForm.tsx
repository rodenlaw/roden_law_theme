"use client";

import { useState, useCallback, type FormEvent } from "react";

interface ContactFormState {
  firstName: string;
  lastName: string;
  phone: string;
  email: string;
  message: string;
  consent: boolean;
  honeypot: string;
}

const INITIAL_STATE: ContactFormState = {
  firstName: "",
  lastName: "",
  phone: "",
  email: "",
  message: "",
  consent: true,
  honeypot: "",
};

export function ContactForm({
  variant = "compact",
  ribbonLabel = "Free 24/7",
  heading = "Tell us what happened.",
  sub = "A senior attorney will respond within the hour.",
}: {
  variant?: "compact" | "wide";
  ribbonLabel?: string;
  heading?: string;
  sub?: string;
} = {}) {
  const [form, setForm] = useState(INITIAL_STATE);
  const [status, setStatus] = useState<"idle" | "submitting" | "success" | "error">("idle");
  const [errorMsg, setErrorMsg] = useState("");

  const handleChange = useCallback(
    (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
      const { name, value, type } = e.target;
      setForm((prev) => ({
        ...prev,
        [name]: type === "checkbox" ? (e.target as HTMLInputElement).checked : value,
      }));
    },
    [],
  );

  const handleSubmit = useCallback(
    async (e: FormEvent) => {
      e.preventDefault();
      setErrorMsg("");

      if (form.honeypot) return;
      if (!form.firstName || !form.email || !form.phone) {
        setErrorMsg("Please fill in all required fields.");
        return;
      }
      if (!form.consent) {
        setErrorMsg("Please agree to the terms to continue.");
        return;
      }

      setStatus("submitting");

      try {
        const res = await fetch("/api/contact", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            firstName: form.firstName,
            lastName: form.lastName,
            phone: form.phone,
            email: form.email,
            message: form.message,
          }),
        });

        if (!res.ok) throw new Error("Submission failed");

        setStatus("success");
        setForm(INITIAL_STATE);
      } catch {
        setStatus("error");
        setErrorMsg("Something went wrong. Please call us directly.");
      }
    },
    [form],
  );

  const pad = variant === "wide" ? "p-8 sm:p-12" : "p-8";
  const headingSize = variant === "wide" ? "text-3xl sm:text-4xl" : "text-2xl";

  if (status === "success") {
    return (
      <div role="status" aria-live="polite" className={`relative bg-paper border border-rule rounded-[24px] ${pad} text-center shadow-[0_12px_36px_rgba(31,45,68,0.10)]`}>
        <h3 className="font-heading text-2xl text-ink mb-2">Thank you.</h3>
        <p className="text-slate text-sm">
          We&apos;ve received your information and a senior attorney will be in touch shortly.
        </p>
      </div>
    );
  }

  return (
    <div className={`relative bg-paper border border-rule rounded-[24px] ${pad} shadow-[0_12px_36px_rgba(31,45,68,0.10)]`}>
      <span className="absolute -top-3.5 left-8 bg-terra text-paper text-[11px] font-bold uppercase tracking-[0.14em] px-3.5 py-1.5 rounded-full">
        {ribbonLabel}
      </span>
      <h3 className={`font-heading ${headingSize} text-ink mt-3 mb-2`}>{heading}</h3>
      <p className="text-sm text-slate mb-6">{sub}</p>

      <form onSubmit={handleSubmit} noValidate className="space-y-2.5">
        {/* Honeypot */}
        <div className="absolute -left-[9999px]" aria-hidden="true">
          <input type="text" name="honeypot" tabIndex={-1} autoComplete="off" value={form.honeypot} onChange={handleChange} />
        </div>

        {/* Name row */}
        <div className="grid grid-cols-2 gap-3">
          <div>
            <label htmlFor="rsf-first-name" className="sr-only">First Name</label>
            <input
              type="text" name="firstName" id="rsf-first-name"
              placeholder="First Name" autoComplete="given-name" required
              value={form.firstName} onChange={handleChange}
              className="w-full px-4 py-3.5 bg-cream-2 border border-transparent rounded-xl text-sm text-ink placeholder:text-slate focus:border-terra focus:bg-cream outline-none"
            />
          </div>
          <div>
            <label htmlFor="rsf-last-name" className="sr-only">Last Name</label>
            <input
              type="text" name="lastName" id="rsf-last-name"
              placeholder="Last Name" autoComplete="family-name" required
              value={form.lastName} onChange={handleChange}
              className="w-full px-4 py-3.5 bg-cream-2 border border-transparent rounded-xl text-sm text-ink placeholder:text-slate focus:border-terra focus:bg-cream outline-none"
            />
          </div>
        </div>

        <div>
          <label htmlFor="rsf-phone" className="sr-only">Phone Number</label>
          <input
            type="tel" name="phone" id="rsf-phone"
            placeholder="(555) 555-5555" autoComplete="tel" required
            value={form.phone} onChange={handleChange}
            className="w-full px-4 py-3.5 bg-cream-2 border border-transparent rounded-xl text-sm text-ink placeholder:text-slate focus:border-terra focus:bg-cream outline-none"
          />
        </div>

        <div>
          <label htmlFor="rsf-email" className="sr-only">Email Address</label>
          <input
            type="email" name="email" id="rsf-email"
            placeholder="Email" autoComplete="email" required
            value={form.email} onChange={handleChange}
            className="w-full px-4 py-3.5 bg-cream-2 border border-transparent rounded-xl text-sm text-ink placeholder:text-slate focus:border-terra focus:bg-cream outline-none"
          />
        </div>

        <div>
          <label htmlFor="rsf-message" className="sr-only">Describe what happened</label>
          <textarea
            name="message" id="rsf-message"
            placeholder="Please describe what happened" rows={6}
            value={form.message} onChange={handleChange}
            className="w-full px-4 py-3.5 bg-cream-2 border border-transparent rounded-xl text-sm text-ink placeholder:text-slate focus:border-terra focus:bg-cream outline-none resize-y"
          />
        </div>

        {/* Consent */}
        <label className="flex items-start gap-2 text-xs text-slate cursor-pointer pt-1">
          <input
            type="checkbox" name="consent"
            checked={form.consent}
            onChange={handleChange}
            required
            className="mt-0.5 shrink-0 accent-terra"
          />
          <span>
            I hereby expressly consent to receive automated communications including calls, texts,
            emails, and/or prerecorded messages. By submitting this form, you agree to our{" "}
            <a href="/terms-privacy-policy/" target="_blank" rel="noopener noreferrer" className="underline hover:text-terra">
              Terms &amp; Privacy Policy
            </a>.
          </span>
        </label>

        <button
          type="submit"
          disabled={status === "submitting"}
          className="w-full bg-terra text-paper font-bold py-4 rounded-[14px] hover:bg-terra-deep transition-colors disabled:opacity-60 text-[15px] mt-2"
        >
          {status === "submitting" ? "Submitting…" : "See if you qualify →"}
        </button>

        {errorMsg && (
          <p role="alert" className="text-terra-deep text-sm">{errorMsg}</p>
        )}
      </form>

      <p className="text-[11px] text-slate mt-3 text-center">
        By submitting, you consent to be contacted. No fees unless we win.
      </p>
    </div>
  );
}
