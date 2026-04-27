import Link from "next/link";

export interface Crumb {
  label: string;
  href?: string;
}

export function Breadcrumbs({ items }: { items: Crumb[] }) {
  if (items.length === 0) return null;

  return (
    <nav className="text-sm text-gray-500 py-3" aria-label="Breadcrumb">
      <span className="flex flex-wrap items-center gap-1">
        {items.map((crumb, i) => {
          const isLast = i === items.length - 1;
          return (
            <span key={i} className="flex items-center gap-1">
              {i > 0 && (
                <span className="text-gray-400" aria-hidden="true">&rsaquo;</span>
              )}
              {crumb.href && !isLast ? (
                <Link href={crumb.href} className="text-gray-500 hover:text-navy no-underline">
                  {crumb.label}
                </Link>
              ) : (
                <span className="text-gray-700">{crumb.label}</span>
              )}
            </span>
          );
        })}
      </span>
    </nav>
  );
}
