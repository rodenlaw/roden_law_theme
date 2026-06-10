import Link from "next/link";

export interface Crumb {
  label: string;
  href?: string;
}

export function Breadcrumbs({ items }: { items: Crumb[] }) {
  if (items.length === 0) return null;

  return (
    <nav className="font-mono text-[11px] uppercase tracking-[0.1em] py-3" aria-label="Breadcrumb">
      <span className="flex flex-wrap items-center gap-1.5">
        {items.map((crumb, i) => {
          const isLast = i === items.length - 1;
          return (
            <span key={i} className="flex items-center gap-1.5">
              {i > 0 && (
                <span className="text-rule" aria-hidden="true">&rsaquo;</span>
              )}
              {crumb.href && !isLast ? (
                <Link href={crumb.href} className="text-slate hover:text-terra no-underline">
                  {crumb.label}
                </Link>
              ) : (
                <span className="text-ink">{crumb.label}</span>
              )}
            </span>
          );
        })}
      </span>
    </nav>
  );
}
