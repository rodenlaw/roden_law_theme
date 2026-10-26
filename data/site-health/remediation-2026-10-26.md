# UI/UX review remediation, 2026-10-26

Input: a one-off UI/UX review of 6 pages (/, /practice-areas/car-accident-lawyers/,
/locations/georgia/savannah/, /car-accident-lawyers/savannah-ga/, /contact/, /es/) at
375x812 and 1440x900, with axe-core. Sections P2–P4 were approved by the owner for PRs.
P0 (consent checkbox state and wording) and P1 (chat widget) are out of scope by owner
decision.

Verification throughout: live production HTML with each branch's CSS/JS substituted via
Playwright route interception (real rendering). Where PHP markup changed, an HTML
transform mirrors it; that transform was checked against the patched PHP functions run in
PHP CLI (simulated markup). Prod drift check before work: 85/85 theme files matched
origin/main.

| Class | Status | PR | Where |
|---|---|---|---|
| P2 mobile inputs 14px (iOS focus zoom) | fixed (unmerged) | #280 | `theme.css` form fields, 16px at all widths |
| P2 placeholder-only / screen-reader-only labels | fixed (unmerged) | #280 | `roden_contact_form_sidebar()` |
| P2 duplicate ids when the form renders twice | fixed (unmerged) | #280 | same function, ids suffixed from the 2nd render |
| Found: 2nd form had no submit handler; native GET put name/phone/email in the URL, no lead sent | fixed (unmerged) | #280 | `roden_sidebar_form_js()` |
| P2 header call icon 40px | fixed (unmerged) | #280 | `.mobile-phone-cta`, hamburger min 44 |
| P2 consent checkbox hit area | fixed (unmerged); checked/required untouched | #280 | `.rsf-consent` padding |
| P2 lead forms in the 7 `template-landing-*.php` Ads pages | **deferred** | — | own inline forms; paid-traffic pages, need a per-template review |
| P3 gold text on white; white on gold fills | fixed (unmerged) | #281 | text-gold token, gold-fill rules |
| P3 `#B8860B` 3.25:1 | fixed (unmerged) | #281 | `--color-orange-text` / `--orange-text` -> `#8A6508` |
| P3 11px grey disclaimers on navy, footer | fixed (unmerged) | #281 | `--text-light`; opacity dimming removed |
| P3 hero intro grey on navy | fixed (unmerged); **was already AA** (5.7–6.6:1 measured), now 8.8–9.8:1 | #281 | `.hero-subtitle`, `.hero-description` |
| P3 in-prose links | fixed (unmerged) | #281 | `.pa-why-hire__body`, `.pa-canonical-link` |
| P3 `.results-track` not focusable | fixed (unmerged) | #281 | `front-page.php`, `theme.js` |
| P3 duplicate Language landmark | fixed (unmerged) | #281 | `roden_language_switcher()` |
| P3 emoji as icons | fixed (unmerged) | #281 | `roden_icon()`, 10 templates |
| P3 chat widget contrast | out of scope (P1) | — | vendor widget |
| P3 axe `region` (top bar, sticky CTA, chat) | not in the review; deferred | — | header/footer markup |
| P4 body prose under 16px | fixed (unmerged); desktop too | #282 | prose component rules |
| P4 practice/location overflow at 375px | fixed (unmerged); 14/30 sampled pages -> 0/30 | #282 | 6 grid/table/flex generators |
| P4 city hero has no call button | **disputed** | — | hero already has a `tel:` "Call Now" button (48px, y=947 mobile, higher than the practice and location heroes); above-the-fold placement is an owner layout decision |
| Not a finding: numbers differ by device | not touched | — | call-tracking pools |

Merge order: #280 (1.4.45), #281 (1.4.46), #282 (1.4.47). Each later PR conflicts with
main only on the `Version:` line of `style.css`; keep the higher number. Flush both caches
after each deploy.
