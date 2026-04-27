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

export function ContactForm() {
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

  if (status === "success") {
    return (
      <div className="bg-light border border-border rounded-lg p-6 text-center">
        <h3 className="font-heading text-xl font-bold text-navy mb-2">Thank You!</h3>
        <p className="text-gray-600 text-sm">
          We&apos;ve received your information and will be in touch within 24 hours.
        </p>
      </div>
    );
  }

  return (
    <div className="bg-light border border-border rounded-lg p-6">
      <h3 className="font-heading text-xl font-bold text-navy mb-1">Free Case Review</h3>
      <p className="text-sm text-gray-600 mb-4">
        No fees unless we win<br />500+ 5-star reviews
      </p>

      <form onSubmit={handleSubmit} noValidate className="space-y-3">
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
              className="w-full px-3 py-2.5 border border-gray-200 rounded text-sm focus:border-orange focus:ring-2 focus:ring-orange/40 outline-none"
            />
          </div>
          <div>
            <label htmlFor="rsf-last-name" className="sr-only">Last Name</label>
            <input
              type="text" name="lastName" id="rsf-last-name"
              placeholder="Last Name" autoComplete="family-name" required
              value={form.lastName} onChange={handleChange}
              className="w-full px-3 py-2.5 border border-gray-200 rounded text-sm focus:border-orange focus:ring-2 focus:ring-orange/40 outline-none"
            />
          </div>
        </div>

        <div>
          <label htmlFor="rsf-phone" className="sr-only">Phone Number</label>
          <input
            type="tel" name="phone" id="rsf-phone"
            placeholder="(555) 555-5555" autoComplete="tel" required
            value={form.phone} onChange={handleChange}
            className="w-full px-3 py-2.5 border border-gray-200 rounded text-sm focus:border-orange focus:ring-2 focus:ring-orange/40 outline-none"
          />
        </div>

        <div>
          <label htmlFor="rsf-email" className="sr-only">Email Address</label>
          <input
            type="email" name="email" id="rsf-email"
            placeholder="Email" autoComplete="email" required
            value={form.email} onChange={handleChange}
            className="w-full px-3 py-2.5 border border-gray-200 rounded text-sm focus:border-orange focus:ring-2 focus:ring-orange/40 outline-none"
          />
        </div>

        <div>
          <label htmlFor="rsf-message" className="sr-only">Describe what happened</label>
          <textarea
            name="message" id="rsf-message"
            placeholder="Please describe what happened" rows={6}
            value={form.message} onChange={handleChange}
            className="w-full px-3 py-2.5 border border-gray-200 rounded text-sm focus:border-orange focus:ring-2 focus:ring-orange/40 outline-none resize-y"
          />
        </div>

        {/* Consent */}
        <label className="flex items-start gap-2 text-xs text-gray-600 cursor-pointer">
          <input
            type="checkbox" name="consent"
            checked={form.consent}
            onChange={handleChange}
            required
            className="mt-0.5 shrink-0"
          />
          <span>
            I hereby expressly consent to receive automated communications including calls, texts,
            emails, and/or prerecorded messages. By submitting this form, you agree to our{" "}
            <a href="/terms-privacy-policy/" target="_blank" rel="noopener noreferrer" className="underline">
              Terms &amp; Privacy Policy
            </a>.
          </span>
        </label>

        <button
          type="submit"
          disabled={status === "submitting"}
          className="w-full bg-orange text-navy font-extrabold py-3 rounded-md hover:bg-orange-dark transition-colors disabled:opacity-60 text-sm"
        >
          {status === "submitting" ? "Submitting..." : "See If You Qualify"}
        </button>

        {errorMsg && (
          <p className="text-red-600 text-sm">{errorMsg}</p>
        )}
      </form>

      <p className="text-[11px] text-gray-500 mt-3">
        Results may vary depending on your particular facts and legal circumstances.
      </p>
    </div>
  );
}
