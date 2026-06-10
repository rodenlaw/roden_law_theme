/**
 * Front Porch labeled placeholder — stands in for photography we don't have yet
 * (founder portrait, office/skyline shots). Styled by .porch-placeholder in
 * globals.css. Swap for a real <Image> once assets are provided.
 */
export function PorchPlaceholder({
  label,
  variant = "default",
  className = "",
}: {
  label: string;
  variant?: "default" | "dark" | "warm";
  className?: string;
}) {
  const variantClass =
    variant === "dark"
      ? "porch-placeholder--dark"
      : variant === "warm"
        ? "porch-placeholder--warm"
        : "";
  // Reads as an intentional branded panel (monogram), not a wireframe showing a
  // dev label. The descriptive label is kept for screen readers / dev reference.
  return (
    <div className={`porch-placeholder ${variantClass} ${className}`} title={label}>
      <span className="porch-placeholder__mark" aria-hidden="true">R</span>
      <span className="sr-only">{label}</span>
    </div>
  );
}
