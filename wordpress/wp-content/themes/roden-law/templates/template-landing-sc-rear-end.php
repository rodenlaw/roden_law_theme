<?php
/**
 * Template Name: Landing Page — SC Rear-End Collision
 *
 * Rear-end collision focused PPC landing page for South Carolina — does NOT use get_header() / get_footer().
 * Outputs its own <!DOCTYPE html>, <head>, and all CSS/JS inline for page speed.
 * Shows all 4 SC offices. Designed for Google Ads traffic with noindex/nofollow.
 *
 * Supports ?city= parameter for dynamic city insertion from Google Ads.
 * Default city: South Carolina. SC offices: Charleston, North Charleston, Columbia, Myrtle Beach.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$firm  = roden_firm_data();
$stats = $firm['trust_stats'];
$sc_law = $firm['jurisdiction']['SC'];
$phone = '844-RESULTS';
$tel   = '18447378587';

// SC office keys for statewide display.
$sc_office_keys = array( 'charleston', 'north-charleston', 'columbia', 'myrtle-beach' );
$sc_offices     = array();
foreach ( $sc_office_keys as $key ) {
    if ( isset( $firm['offices'][ $key ] ) ) {
        $sc_offices[ $key ] = $firm['offices'][ $key ];
    }
}

// Dynamic city from Google Ads ?city= parameter. Falls back to South Carolina default.
$default_city = 'South Carolina';
$city_raw     = isset( $_GET['city'] ) ? sanitize_text_field( wp_unslash( $_GET['city'] ) ) : '';
// Fall back to default if empty or if Google Ads macro wasn't replaced.
$city         = ( $city_raw && strpos( $city_raw, '{' ) === false ) ? $city_raw : $default_city;

// Use "in South Carolina" or "in [City]" depending on whether we have a specific city.
$in_location  = 'in ' . $city;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>South Carolina Rear-End Collision Lawyers | Roden Law</title>
    <meta name="description" content="Injured in a rear-end collision <?php echo esc_attr( $in_location ); ?>? Roden Law has recovered <?php echo esc_attr( $stats['recovered'] ); ?> for victims. Free case review. No fee unless we win. Call <?php echo esc_attr( $phone ); ?>.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.callrail.com">
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800;900&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* ===== RESET & BASE ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; overflow-x: hidden; }
        body { overflow-x: hidden; }
        /* Skip link (a11y) */
        .skip-link {
            position: absolute;
            top: -100px;
            left: 16px;
            background: var(--gold);
            color: var(--navy-deep);
            padding: 12px 24px;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 14px;
            z-index: 2000;
            transition: top 0.2s;
        }
        .skip-link:focus {
            top: 12px;
        }
        body {
            font-family: 'Open Sans', Arial, sans-serif;
            color: #1a2332;
            line-height: 1.6;
            background: #fff;
            -webkit-font-smoothing: antialiased;
        }
        img { max-width: 100%; display: block; }
        a { text-decoration: none; color: inherit; }

        /* ===== BRAND COLORS ===== */
        :root {
            --navy: #1a2a3a;
            --navy-deep: #0f1c2e;
            --gold: #e8a830;
            --gold-hover: #d49520;
            --gold-light: #fdf4e0;
            --teal-accent: #2a8a9a;
            --white: #ffffff;
            --light-gray: #f7f8fa;
            --text-dark: #1a2332;
            --text-muted: #5a6577;
            --green-trust: #2ecc71;
        }

        /* ===== STICKY MOBILE DUAL CTA BAR (TOP) ===== */
        .mobile-cta-bar {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: var(--gold);
            padding: 8px 16px;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .mobile-cta-bar-inner {
            display: flex;
            gap: 8px;
        }
        .mobile-cta-bar a {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--navy-deep);
            color: var(--white);
            text-align: center;
            padding: 12px;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 15px;
            letter-spacing: 0.5px;
        }
        .mobile-cta-call { flex: 1; }
        .mobile-cta-review {
            flex: 1;
            background: var(--gold-hover) !important;
            color: var(--navy-deep) !important;
        }

        /* ===== TOP BAR ===== */
        .top-bar {
            background: var(--navy-deep);
            padding: 10px 0;
            text-align: center;
        }
        .top-bar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-bar-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--gold);
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.5px;
        }
        .top-bar-badge svg {
            flex-shrink: 0;
        }
        .top-bar-phone {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .top-bar-phone span {
            color: #a0aec0;
            font-size: 13px;
        }
        .top-bar-phone a {
            color: var(--white);
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 18px;
            letter-spacing: 0.5px;
            padding: 8px 4px;
            min-height: 44px;
            display: inline-flex;
            align-items: center;
        }

        /* ===== HERO ===== */
        .hero {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-deep) 100%);
            position: relative;
            overflow: hidden;
        }
        .hero::after {
            content: '';
            position: absolute;
            top: 0; right: 0; bottom: 0;
            width: 45%;
            background: linear-gradient(90deg, var(--navy) 0%, rgba(26,42,58,0.3) 40%, rgba(26,42,58,0) 100%);
            z-index: 2;
            pointer-events: none;
        }
        .hero-bg-image {
            position: absolute;
            top: 0; right: 0; bottom: 0;
            width: 50%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 600"><defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop offset="0%25" stop-color="%231a2a3a"/><stop offset="100%25" stop-color="%230f1c2e"/></linearGradient></defs><rect fill="url(%23g)" width="800" height="600"/><g opacity="0.08"><circle cx="400" cy="300" r="200" fill="none" stroke="%23e8a830" stroke-width="1"/><circle cx="400" cy="300" r="150" fill="none" stroke="%23e8a830" stroke-width="0.5"/><path d="M200 400 Q400 200 600 400" fill="none" stroke="%23e8a830" stroke-width="1"/></g></svg>') center/cover no-repeat;
            opacity: 0.4;
        }
        .hero-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 24px 70px;
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 48px;
            align-items: center;
            position: relative;
            z-index: 3;
        }
        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(232,168,48,0.15);
            border: 1px solid rgba(232,168,48,0.3);
            padding: 8px 16px;
            border-radius: 50px;
            color: var(--gold);
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .hero h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: clamp(32px, 4.5vw, 52px);
            line-height: 1.1;
            color: var(--white);
            margin-bottom: 18px;
        }
        .hero h1 .gold { color: var(--gold); }
        .hero-sub {
            font-size: 18px;
            color: #d4dce8;
            line-height: 1.7;
            margin-bottom: 20px;
            max-width: 540px;
        }

        /* ===== HERO CALL CTA ===== */
        .hero-call-cta {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: var(--gold);
            color: var(--navy-deep);
            padding: 16px 32px;
            border-radius: 12px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 20px;
            transition: all 0.3s;
            margin-bottom: 8px;
        }
        .hero-call-cta:hover {
            background: var(--gold-hover);
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(232,168,48,0.3);
        }
        .hero-call-sub {
            font-size: 13px;
            color: var(--gold);
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }
        .hero-experience {
            color: rgba(255,255,255,0.85);
            font-family: 'Open Sans', sans-serif;
            font-size: clamp(13px, 2vw, 15px);
            font-weight: 500;
            letter-spacing: 0.02em;
            margin-bottom: 0;
        }
        .hero-experience span { color: var(--gold); font-weight: 700; }
        /* Hero text CTA */
        .hero-text-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border: 2px solid var(--gold);
            color: var(--gold);
            background: transparent;
            border-radius: 12px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 15px;
            min-height: 48px;
            transition: all 0.3s;
            margin-left: 12px;
        }
        .hero-text-cta:hover {
            background: var(--gold);
            color: var(--navy-deep);
            transform: translateY(-2px);
        }
        @media (max-width: 768px) {
            .hero-text-cta {
                margin-left: 0;
                margin-top: 8px;
            }
        }
        /* Mobile text CTA in sticky bar */
        .mobile-cta-text {
            flex: 1;
            background: transparent !important;
            color: var(--gold) !important;
            border: 2px solid var(--gold);
        }

        /* ===== ATTORNEY PHOTO STRIP ===== */
        .attorney-strip {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
        }
        .attorney-strip-photos {
            display: flex;
        }
        .attorney-strip-photos .atty-photo {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border: 3px solid var(--navy);
            background: var(--navy-deep);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 14px;
            overflow: hidden;
        }
        .attorney-strip-photos .atty-photo + .atty-photo {
            margin-left: -10px;
        }
        .attorney-strip-photos .atty-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .attorney-strip-caption {
            font-size: 14px;
            color: #c0cad8;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
        }

        /* ===== ACCIDENT TYPE GRID (REAR-END SPECIFIC INJURIES) ===== */
        .accident-types {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 0;
        }
        .accident-type-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 14px 8px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            text-align: center;
            transition: background 0.2s, border-color 0.2s;
            cursor: default;
        }
        .accident-type-item:hover {
            background: rgba(232,168,48,0.1);
            border-color: rgba(232,168,48,0.3);
        }
        .accident-type-item svg {
            flex-shrink: 0;
        }
        .accident-type-label {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-size: 11px;
            color: #c0cad8;
            line-height: 1.3;
            letter-spacing: 0.3px;
        }

        /* ===== ACCIDENT TYPE LINKS ===== */
        a.accident-type-item {
            text-decoration: none;
            color: inherit;
        }

        /* ===== HERO FORM ===== */
        .hero-form-card {
            background: var(--white);
            border-radius: 16px;
            padding: 36px 32px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
            position: relative;
        }
        .form-urgency {
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            background: #e74c3c;
            color: white;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 6px 20px;
            border-radius: 50px;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .pulse-dot {
            width: 8px;
            height: 8px;
            background: #fff;
            border-radius: 50%;
            animation: pulse-dot 1.5s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.4); }
        }

        /* ===== FORM TABS (disabled — quick callback removed for now) ===== */

        .hero-form-card h2 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 22px;
            color: var(--navy);
            text-align: center;
            margin-bottom: 4px;
        }
        .form-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 24px;
        }
        .form-group {
            margin-bottom: 14px;
        }
        /* Floating label field wrapper */
        .float-field {
            position: relative;
        }
        .float-field input,
        .float-field textarea {
            width: 100%;
            padding: 20px 16px 8px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-family: 'Open Sans', sans-serif;
            font-size: 15px;
            color: var(--text-dark);
            transition: border-color 0.2s;
            background: #f8fafc;
        }
        .float-field input::placeholder,
        .float-field textarea::placeholder {
            color: transparent;
        }
        .float-field label {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: #a0aec0;
            pointer-events: none;
            transition: all 0.2s ease;
            font-family: 'Open Sans', sans-serif;
        }
        .float-field textarea ~ label {
            top: 20px;
            transform: none;
        }
        .float-field input:focus,
        .float-field textarea:focus {
            outline: none;
            border-color: var(--gold);
            background: white;
        }
        .float-field input:focus + label,
        .float-field input:not(:placeholder-shown) + label {
            top: 6px;
            transform: none;
            font-size: 11px;
            color: var(--gold);
        }
        .float-field textarea:focus ~ label,
        .float-field textarea:not(:placeholder-shown) ~ label {
            top: 4px;
            font-size: 11px;
            color: var(--gold);
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-family: 'Open Sans', sans-serif;
            font-size: 15px;
            color: var(--text-dark);
            transition: border-color 0.2s;
            background: #f8fafc;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--gold);
            background: white;
        }
        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #a0aec0;
        }
        .form-consent a {
            display: inline;
            padding: 6px 2px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }
        .form-submit {
            width: 100%;
            padding: 18px;
            background: var(--gold);
            color: var(--navy-deep);
            border: none;
            border-radius: 10px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 16px;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 4px;
            text-transform: uppercase;
        }
        .form-submit:hover {
            background: var(--gold-hover);
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(232,168,48,0.4);
        }
        .form-trust {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 14px;
            font-size: 12px;
            color: var(--text-muted);
        }
        .form-trust svg { flex-shrink: 0; }
        .form-activity {
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .form-activity .activity-dot {
            width: 6px;
            height: 6px;
            background: var(--green-trust);
            border-radius: 50%;
            animation: pulse-dot 2s ease-in-out infinite;
        }
        /* full-fields toggle removed — all fields always visible */

        /* ===== SC LAW CALLOUT ===== */
        .sc-law-section {
            padding: 60px 0;
            background: var(--white);
        }
        .sc-law-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
        }
        .sc-law-card {
            background: var(--light-gray);
            border-radius: 16px;
            padding: 36px 32px;
            border-left: 4px solid var(--gold);
        }
        .sc-law-card h3 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 18px;
            color: var(--navy);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sc-law-card .law-value {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 28px;
            color: var(--gold);
            margin-bottom: 8px;
        }
        .sc-law-card p {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.7;
        }
        .sc-law-card .cite {
            font-size: 13px;
            color: #8899aa;
            font-style: italic;
            margin-top: 8px;
        }

        /* ===== STATS + NO-FEE BANNER ===== */
        .no-fee-banner {
            background: var(--navy-deep);
            padding: 18px 0;
        }
        .no-fee-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .no-fee-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 15px;
            color: var(--white);
            white-space: nowrap;
        }
        .no-fee-icon {
            width: 26px;
            height: 26px;
            background: rgba(232,168,48,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .no-fee-sep {
            color: rgba(255,255,255,0.2);
            font-size: 20px;
            font-weight: 300;
            user-select: none;
        }

        /* ===== SOCIAL PROOF BAR ===== */
        .proof-bar {
            background: var(--white);
            border-bottom: 1px solid #edf2f7;
            padding: 28px 0;
        }
        .proof-bar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 48px;
            flex-wrap: wrap;
        }
        .proof-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .proof-logo {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 11px;
            text-align: center;
            line-height: 1.1;
            color: var(--navy);
            background: var(--light-gray);
            border: 1px solid #e2e8f0;
        }
        .proof-text {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 600;
        }
        .proof-stars {
            color: var(--gold);
            font-size: 16px;
            letter-spacing: 2px;
        }

        /* ===== TRUST BADGE BAR ===== */
        .trust-badges {
            background: var(--white);
            border-bottom: 1px solid #edf2f7;
            padding: 28px 0;
        }
        .trust-badges-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
            flex-wrap: wrap;
        }
        .trust-badge {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .trust-badge-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 10px;
            text-align: center;
            line-height: 1.1;
        }
        .trust-badge-icon.google { background: #f1f3f4; color: #4285f4; }
        .trust-badge-icon.sl { background: #1a365d; color: #e8a830; }
        .trust-badge-icon.avvo { background: #2d3748; color: #fff; }
        .trust-badge-icon.bbb { background: #005288; color: #fff; }
        .trust-badge-icon.sc-bar { background: #1a2a3a; color: #e8a830; }
        .trust-badge-text {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.3;
        }
        .trust-badge-text strong {
            display: block;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: var(--navy);
            font-size: 14px;
        }
        .trust-badge-stars {
            color: var(--gold);
            font-size: 14px;
            letter-spacing: 1px;
        }

        /* ===== WHY SECTION ===== */
        .why-section {
            padding: 80px 0;
            background: var(--light-gray);
        }
        .section-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .section-eyebrow {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 8px;
        }
        .section-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: clamp(28px, 3.5vw, 40px);
            color: var(--navy);
            margin-bottom: 16px;
            line-height: 1.2;
        }
        .section-sub {
            font-size: 17px;
            color: var(--text-muted);
            max-width: 640px;
            margin-bottom: 48px;
            line-height: 1.7;
        }
        .why-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }
        .why-card {
            background: var(--white);
            border-radius: 16px;
            padding: 36px 28px;
            transition: all 0.3s;
            border: 1px solid #edf2f7;
        }
        .why-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.08);
        }
        .why-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--gold-light), #fef9ef);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        .why-card h3 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 18px;
            color: var(--navy);
            margin-bottom: 10px;
        }
        .why-card p {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.7;
        }

        /* ===== RESULTS ===== */
        .results-section {
            padding: 80px 0;
            background: var(--navy-deep);
            position: relative;
            overflow: hidden;
        }
        .results-section::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(232,168,48,0.06) 0%, transparent 70%);
            border-radius: 50%;
        }
        .results-section .section-eyebrow { color: var(--gold); }
        .results-section .section-title { color: var(--white); }
        .results-section .section-sub { color: #a0b0c0; }
        .results-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            position: relative;
            z-index: 1;
        }
        .result-card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 32px 28px;
            text-align: center;
            transition: all 0.3s;
        }
        .result-card:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-3px);
        }
        .result-type {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #8899aa;
            margin-bottom: 8px;
        }
        .result-amount {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 36px;
            color: var(--gold);
            line-height: 1.2;
            margin-bottom: 8px;
        }
        .result-desc {
            font-size: 14px;
            color: #a0aec0;
        }
        .results-disclaimer {
            text-align: center;
            color: #5a6577;
            font-size: 12px;
            margin-top: 32px;
            font-style: italic;
        }

        /* ===== PROCESS ===== */
        .process-section {
            padding: 80px 0;
            background: var(--white);
        }
        .process-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }
        .process-step {
            text-align: center;
            padding: 28px 20px;
            position: relative;
        }
        .process-step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 48px;
            right: -12px;
            width: 24px;
            height: 2px;
            background: var(--gold);
        }
        .step-number {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--gold), var(--gold-hover));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 22px;
            color: var(--navy-deep);
        }
        .process-step h3 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 16px;
            color: var(--navy);
            margin-bottom: 8px;
        }
        .process-step p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ===== CHECKLIST ===== */
        .checklist-section {
            padding: 80px 0;
            background: var(--light-gray);
        }
        .checklist-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            align-items: center;
        }
        .checklist-items {
            list-style: none;
            padding: 0;
        }
        .checklist-items li {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 18px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .checklist-items li:last-child {
            border-bottom: none;
        }
        .check-num {
            width: 36px;
            height: 36px;
            background: var(--gold);
            color: var(--navy-deep);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 14px;
            flex-shrink: 0;
        }
        .check-content h3 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 16px;
            color: var(--navy);
            margin-bottom: 4px;
        }
        .check-content p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ===== OFFICES SECTION ===== */
        .offices-section {
            padding: 80px 0;
            background: var(--white);
        }
        .offices-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 28px;
        }
        .office-card {
            background: var(--light-gray);
            border-radius: 16px;
            padding: 36px 28px;
            border: 1px solid #edf2f7;
            transition: all 0.3s;
        }
        .office-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.08);
        }
        .office-card-city {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 22px;
            color: var(--navy);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .office-card-city svg {
            flex-shrink: 0;
            color: var(--gold);
        }
        .office-card-detail {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 12px;
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.5;
        }
        .office-card-detail svg {
            flex-shrink: 0;
            margin-top: 3px;
        }
        .office-card-phone {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
            background: var(--gold);
            color: var(--navy-deep);
            padding: 12px 24px;
            border-radius: 10px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 15px;
            transition: all 0.3s;
        }
        .office-card-phone:hover {
            background: var(--gold-hover);
            transform: translateY(-1px);
        }
        .office-card-service {
            margin-top: 14px;
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.6;
            border-top: 1px solid #e2e8f0;
            padding-top: 14px;
        }
        .office-card-service strong {
            color: var(--navy);
        }

        /* ===== TESTIMONIALS ===== */
        .testimonials-section {
            padding: 80px 0;
            background: var(--light-gray);
        }
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }
        .testimonial-card {
            background: white;
            border-radius: 16px;
            padding: 32px 28px;
            border: 1px solid #edf2f7;
            position: relative;
        }
        .testimonial-stars {
            color: var(--gold);
            font-size: 18px;
            letter-spacing: 2px;
            margin-bottom: 14px;
        }
        .testimonial-text {
            font-size: 15px;
            color: var(--text-dark);
            line-height: 1.7;
            margin-bottom: 18px;
            font-style: italic;
        }
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .testimonial-avatar {
            width: 44px;
            height: 44px;
            background: var(--navy);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 16px;
        }
        .testimonial-name {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 14px;
            color: var(--navy);
        }
        .testimonial-location {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* ===== FAQ ===== */
        .faq-section {
            padding: 80px 0;
            background: var(--white);
        }
        .faq-layout {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 64px;
            align-items: start;
        }
        .faq-item {
            border-bottom: 1px solid #edf2f7;
            padding: 20px 0;
        }
        .faq-question {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 16px;
            color: var(--navy);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }
        .faq-question::after {
            content: '+';
            font-size: 22px;
            color: var(--gold);
            font-weight: 400;
            flex-shrink: 0;
            transition: transform 0.3s;
        }
        .faq-item.open .faq-question::after {
            content: '\2212';
        }
        .landing-page .faq-answer {
            display: block !important;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding: 0;
            border-top: none;
        }
        .landing-page .faq-item.open .faq-answer {
            max-height: 800px;
        }
        .landing-page .faq-answer p {
            padding-top: 12px;
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.7;
        }
        .landing-page .faq-question {
            width: auto;
            background: none !important;
            border: none;
            padding: 20px 0;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 16px;
            color: var(--navy);
        }
        .landing-page .faq-question[aria-expanded="true"] {
            background: none !important;
            color: var(--navy);
        }
        .landing-page .faq-item {
            border: none;
            border-bottom: 1px solid #edf2f7;
            border-radius: 0;
            overflow: visible;
        }

        /* ===== BOTTOM CTA ===== */
        .bottom-cta {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-deep) 100%);
            padding: 80px 0;
            text-align: center;
        }
        .bottom-cta h2 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: clamp(28px, 3.5vw, 42px);
            color: var(--white);
            margin-bottom: 14px;
            line-height: 1.2;
        }
        .bottom-cta p {
            font-size: 18px;
            color: #8899aa;
            margin-bottom: 32px;
            max-width: 560px;
            margin-left: auto;
            margin-right: auto;
        }
        .cta-phone {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: var(--gold);
            color: var(--navy-deep);
            padding: 18px 40px;
            border-radius: 12px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 22px;
            transition: all 0.3s;
            margin-bottom: 12px;
        }
        .cta-phone:hover {
            background: var(--gold-hover);
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(232,168,48,0.3);
        }
        .cta-or {
            color: #5a6577;
            font-size: 14px;
            margin: 16px 0;
        }
        .cta-form-link {
            color: var(--gold);
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 16px;
            border-bottom: 2px solid transparent;
            transition: border-color 0.2s;
        }
        .cta-form-link:hover {
            border-bottom-color: var(--gold);
        }

        /* ===== MID-PAGE CTA BAND ===== */
        .mid-page-cta {
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-deep) 100%);
            padding: 48px 24px;
            text-align: center;
        }
        .mid-page-cta h2 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: clamp(22px, 3vw, 30px);
            color: var(--white);
            margin-bottom: 24px;
            line-height: 1.3;
        }
        .mid-page-cta .cta-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .mid-page-cta .cta-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--gold);
            color: var(--navy-deep);
            padding: 14px 32px;
            border-radius: 10px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 16px;
            min-height: 48px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        .mid-page-cta .cta-btn-primary:hover {
            background: var(--gold-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(232,168,48,0.3);
        }
        .mid-page-cta .cta-btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: var(--gold);
            padding: 14px 32px;
            border-radius: 10px;
            border: 2px solid var(--gold);
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 16px;
            min-height: 48px;
            transition: all 0.3s;
            cursor: pointer;
        }
        .mid-page-cta .cta-btn-secondary:hover {
            background: rgba(232,168,48,0.1);
            transform: translateY(-2px);
        }
        .mid-page-cta .cta-subtext {
            color: rgba(255,255,255,0.6);
            font-size: 14px;
            margin-top: 18px;
        }
        @media (max-width: 600px) {
            .mid-page-cta .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            .mid-page-cta .cta-btn-primary,
            .mid-page-cta .cta-btn-secondary {
                width: 100%;
                max-width: 320px;
                justify-content: center;
            }
        }

        /* ===== DESKTOP STICKY CTA ===== */
        .desktop-sticky-cta {
            display: none;
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 999;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.3s, transform 0.3s;
        }
        .desktop-sticky-cta.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .desktop-sticky-cta a {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--gold);
            color: var(--navy-deep);
            padding: 16px 28px;
            border-radius: 60px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            transition: all 0.3s;
        }
        .desktop-sticky-cta a:hover {
            background: var(--gold-hover);
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(232,168,48,0.4);
        }

        /* ===== FOOTER ===== */
        .lp-footer {
            background: #0a1420;
            padding: 32px 0;
            text-align: center;
        }
        .lp-footer p {
            font-size: 12px;
            color: #4a5568;
            line-height: 1.8;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* ===== ACCESSIBILITY ===== */
        /* Screen-reader only utility */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0,0,0,0);
            white-space: nowrap;
            border: 0;
        }
        /* Focus styles for keyboard nav */
        a:focus-visible,
        button:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible,
        .faq-question:focus-visible {
            outline: 3px solid var(--gold);
            outline-offset: 2px;
            border-radius: 4px;
        }
        /* Scroll margin so anchored elements clear fixed mobile bar */
        #leadForm {
            scroll-margin-top: 72px;
        }
        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }

        /* ===== RESPONSIVE ===== */
        /* Desktop sticky CTA: show only on screens > 1024px */
        @media (min-width: 1025px) {
            .desktop-sticky-cta { display: block; }
        }

        @media (max-width: 1024px) {
            .hero-inner {
                grid-template-columns: 1fr;
                padding: 40px 24px 50px;
            }
            .hero-bg-image { display: none; }
            .hero::after { display: none; }
            .why-grid { grid-template-columns: repeat(2, 1fr); }
            .results-grid { grid-template-columns: repeat(2, 1fr); }
            .process-grid { grid-template-columns: repeat(2, 1fr); }
            .process-step::after { display: none; }
            .testimonial-grid { grid-template-columns: 1fr; }
            .faq-layout { grid-template-columns: 1fr; gap: 32px; }
            .sc-law-grid { grid-template-columns: 1fr; }
            .checklist-layout { grid-template-columns: 1fr; gap: 32px; }
            .trust-badges-inner { gap: 24px; }
        }

        @media (max-width: 768px) {
            .mobile-cta-bar { display: block; }
            body { padding-top: 56px; }
            .top-bar-badge { display: none; }
            .top-bar-inner { justify-content: center; }
            .hero-inner { padding: 32px 16px 40px; }
            .hero h1 { font-size: 28px; }
            .hero-sub { font-size: 16px; }
            .hero-call-cta { font-size: 16px; padding: 14px 24px; }
            .accident-types { grid-template-columns: repeat(2, 1fr); gap: 8px; }
            .accident-type-item { padding: 10px 6px; }
            .accident-type-label { font-size: 10px; }
            .hero-form-card { padding: 28px 20px; }
            .form-row { grid-template-columns: 1fr; }
            .no-fee-inner { gap: 8px; justify-content: center; }
            .no-fee-item { font-size: 13px; }
            .no-fee-sep { display: none; }
            .trust-badges-inner { gap: 16px; }
            .trust-badge { gap: 8px; }
            .trust-badge-text { font-size: 12px; }
            .trust-badge-icon { width: 40px; height: 40px; }
            .proof-bar-inner { gap: 24px; }
            .offices-grid { grid-template-columns: 1fr; }
            .bottom-cta h2 { font-size: 24px; }
            .bottom-cta .cta-phone { padding: 16px 32px; font-size: 18px; }
            .section-title { font-size: 24px; }
            .section-sub { font-size: 15px; }
            .why-grid { gap: 16px; }
            .why-card { padding: 24px 16px; }
            .results-grid { gap: 16px; }
            .result-card { padding: 20px 16px; }
            .result-amount { font-size: 28px; }
            .process-grid { grid-template-columns: 1fr; }
            .checklist-layout { gap: 28px; }
            .testimonial-grid { gap: 16px; }
            .faq-layout { gap: 24px; }
        }
    </style>
    <!-- FAQPage Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            {
                "@type": "Question",
                "name": "Is the rear driver always at fault in South Carolina?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "In South Carolina, the rear driver is presumed at fault in rear-end collisions because they have a duty to maintain a safe following distance. However, there are exceptions: if the front vehicle brake-checks the rear driver, has broken brake lights, or suddenly reverses, the front driver may share or bear full liability."
                }
            },
            {
                "@type": "Question",
                "name": "How much is my rear-end collision case worth?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Your case value depends on medical costs and ongoing care, lost wages, pain and suffering, future earning capacity, and the defendant's insurance limits. A 'minor' rear-end impact can still result in serious injuries like whiplash, herniated discs, and TBI. Our attorneys evaluate every case individually to pursue maximum compensation."
                }
            },
            {
                "@type": "Question",
                "name": "What if my symptoms appeared days after the rear-end collision?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Delayed onset is common for whiplash and traumatic brain injury (TBI). Symptoms may not appear for 24-48 hours after impact. Seek medical attention immediately and document your symptoms. Insurance companies often use delayed symptoms as an excuse to deny claims, but we use medical evidence to prove causation."
                }
            },
            {
                "@type": "Question",
                "name": "Can I recover compensation if the insurance company says it was a minor impact?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Yes. Insurance companies use low-speed or low-impact collisions as justification for lowball offers, but the impact speed does not determine injury severity. Biomechanical experts can prove serious injuries occurred even at low speeds."
                }
            },
            {
                "@type": "Question",
                "name": "How long do I have to file a rear-end collision claim in South Carolina?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "You have <?php echo esc_html( $sc_law['statute_years'] ); ?> years from the date of the rear-end collision to file a personal injury lawsuit in South Carolina (<?php echo esc_html( $sc_law['statute_cite'] ); ?>). However, waiting weakens your case — evidence disappears, witnesses forget details, and the insurance company delays your recovery. Contact an attorney as soon as possible."
                }
            },
            {
                "@type": "Question",
                "name": "What if I was partially at fault for being rear-ended?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "South Carolina uses modified comparative fault. You can recover damages even if you're partially at fault, as long as you're less than 51% responsible. Your award is reduced by your percentage of fault. Insurance companies often exaggerate your fault percentage to minimize payouts — our attorneys fight back aggressively."
                }
            }
        ]
    }
    </script>
    <?php wp_head(); ?>
</head>

<body <?php body_class( 'landing-page' ); ?>>
<a href="#leadForm" class="skip-link">Jump to form</a>

<div class="mobile-cta-bar">
    <div class="mobile-cta-bar-inner">
        <a href="tel:<?php echo esc_attr( $tel ); ?>" class="mobile-cta-call" title="Call Roden Law">
            Call Now
        </a>
        <a href="#leadForm" class="mobile-cta-review">
            Free Review
        </a>
    </div>
</div>

<div class="top-bar">
    <div class="top-bar-inner">
        <div class="top-bar-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>
            <?php echo esc_html( $stats['rating'] ); ?> STARS &mdash; <?php echo esc_html( $stats['cases'] ); ?> CASES HANDLED
        </div>
        <div class="top-bar-phone">
            <span>Call 24/7</span>
            <a href="tel:<?php echo esc_attr( $tel ); ?>"><?php echo esc_html( $phone ); ?></a>
        </div>
    </div>
</div>

<section class="hero">
    <div class="hero-bg-image"></div>
    <div class="hero-inner">
        <div class="hero-content">
            <div class="hero-eyebrow">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/></svg>
                Trusted South Carolina Rear-End Accident Attorneys
            </div>

            <h1><?php echo esc_html( $city ); ?> <span class="gold">Rear-End Collision Lawyers</span></h1>

            <p class="hero-sub">Rear-ended and injured? Insurance companies count on you accepting their lowball offers for "minor" impact collisions. Roden Law has recovered over <?php echo esc_html( $stats['recovered'] ); ?> for rear-end victims &mdash; and we don't charge a fee unless we win your case.</p>

            <div class="hero-cta-row">
                <a href="tel:<?php echo esc_attr( $tel ); ?>" class="hero-call-cta">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    Call Now: <?php echo esc_html( $phone ); ?>
                </a>
                <a href="sms:<?php echo esc_attr( $tel ); ?>" class="hero-text-cta" aria-label="Send a text message to Roden Law">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Text Us
                </a>
            </div>

            <div class="hero-call-sub">Available 24/7 &mdash; Free Consultation</div>
            <p class="hero-experience">Serving South Carolina since <span>2013</span> &middot; <?php echo esc_html( $stats['recovered'] ); ?>+ recovered</p>

            <div class="attorney-strip">
                <div class="attorney-strip-photos">
                    <?php
                    // SC attorneys: Gillin, Reidy, Stohr, Montano.
                    $sc_attorneys = array(
                        array( 'initials' => 'GG', 'name' => 'Graeham Gillin' ),
                        array( 'initials' => 'KR', 'name' => 'Kiley Reidy' ),
                        array( 'initials' => 'ZS', 'name' => 'Zach Stohr' ),
                        array( 'initials' => 'IM', 'name' => 'Ivy Montano' ),
                    );
                    foreach ( $sc_attorneys as $atty ) :
                        // Check for an attorney headshot attachment.
                        $atty_slug = sanitize_title( $atty['name'] );
                        $headshot  = get_posts( array(
                            'post_type'   => 'attachment',
                            'post_status' => 'inherit',
                            'name'        => $atty_slug,
                            'numberposts' => 1,
                        ) );
                    ?>
                        <div class="atty-photo" title="<?php echo esc_attr( $atty['name'] ); ?>">
                            <?php if ( ! empty( $headshot ) ) : ?>
                                <img src="<?php echo esc_url( wp_get_attachment_image_url( $headshot[0]->ID, 'thumbnail' ) ); ?>" alt="<?php echo esc_attr( $atty['name'] ); ?>" fetchpriority="high">
                            <?php else : ?>
                                <?php echo esc_html( $atty['initials'] ); ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <span class="attorney-strip-caption">Your SC Legal Team</span>
            </div>

            <div class="accident-types">
                <div class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><path d="M12 2c-5.5 0-10 4.5-10 10s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2m0 3c3.3 0 6 2.7 6 6s-2.7 6-6 6-6-2.7-6-6 2.7-6 6-6"/><path d="M12 8v4l3 2" stroke="#e8a830" stroke-width="1.5"/></svg>
                    <span class="accident-type-label">Whiplash</span>
                </div>
                <div class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2z" stroke="none" fill="#e8a830"/><circle cx="12" cy="20" r="1" fill="#e8a830"/></svg>
                    <span class="accident-type-label">Herniated Disc</span>
                </div>
                <div class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm1-13h-2v6h2zm0 8h-2v2h2z" stroke="none" fill="#e8a830"/></svg>
                    <span class="accident-type-label">Concussion/TBI</span>
                </div>
                <div class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><path d="M14 12h-4M12 10v4M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                    <span class="accident-type-label">Back &amp; Spine</span>
                </div>
                <div class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm1-13h-2v2h2zm0 4h-2v4h2z" stroke="none" fill="#e8a830"/></svg>
                    <span class="accident-type-label">TMJ Disorder</span>
                </div>
                <div class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-2-7l2 2 4-4" stroke="#e8a830" fill="none" stroke-width="1.5"/></svg>
                    <span class="accident-type-label">Soft Tissue</span>
                </div>
            </div>
        </div>

        <div class="hero-form-card">
            <div class="form-urgency"><span class="pulse-dot"></span> SC has a 3-year filing deadline</div>

            <h2>Get My Free Rear-End Case Review</h2>
            <p class="form-subtitle">2 minutes or less</p>

            <!-- Quick Callback tabs removed for now — can re-enable later -->

            <form id="leadForm" action="#" method="POST" novalidate aria-label="Free case review request form">
                <?php wp_nonce_field( 'roden_sidebar_form', 'roden_form_nonce' ); ?>

                <input type="hidden" name="gclid" class="roden-gclid" value="">
                <div class="form-row">
                    <div class="form-group float-field">
                        <input type="text" name="first_name" id="lp-fname" placeholder=" " autocomplete="given-name" required>
                        <label for="lp-fname">First Name*</label>
                    </div>
                    <div class="form-group float-field">
                        <input type="text" name="last_name" id="lp-lname" placeholder=" " autocomplete="family-name" required>
                        <label for="lp-lname">Last Name*</label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group float-field">
                        <input type="tel" name="phone" id="lp-phone" placeholder=" " autocomplete="tel" required>
                        <label for="lp-phone">Phone Number*</label>
                    </div>
                    <div class="form-group float-field">
                        <input type="email" name="email" id="lp-email" placeholder=" " autocomplete="email" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" required>
                        <label for="lp-email">Email Address*</label>
                    </div>
                </div>
                <div>
                    <div class="form-group float-field">
                        <textarea name="message" id="lp-message" placeholder=" " rows="4"></textarea>
                        <label for="lp-message">Describe what happened</label>
                    </div>
                </div>
                <label class="form-consent" style="display:flex;align-items:flex-start;gap:10px;margin-bottom:12px;cursor:pointer;">
                    <input type="checkbox" name="consent" value="1" checked required style="width:18px;height:18px;min-width:18px;margin-top:2px;accent-color:#f5a623;cursor:pointer;">
                    <span style="font-size:12px;color:#64748b;line-height:1.5;">I hereby expressly consent to receive automated communications including calls, texts, emails, and/or prerecorded messages. By submitting this form, you agree to our <a href="<?php echo esc_url( home_url( '/terms-privacy-policy/' ) ); ?>" target="_blank" rel="noopener noreferrer" style="color:#f5a623;text-decoration:underline;">Terms &amp; Privacy Policy</a>.</span>
                </label>
                <button type="submit" class="form-submit">Get My Free Case Review &rarr;</button>
                <p style="text-align:center;font-size:12px;color:var(--text-muted);margin-top:8px;margin-bottom:0;">
                    <svg style="display:inline-block;vertical-align:middle;margin-right:4px;" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#2ecc71" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    Average response time: under 15 minutes
                </p>
                <p class="form-error" role="alert" aria-live="assertive" style="display:none;color:#ff6b6b;font-size:13px;text-align:center;margin-top:8px;"></p>

            </form>

            <div class="form-trust">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" stroke="none"/></svg>
                Confidential &amp; secure
                or call now: <a href="tel:<?php echo esc_attr( $tel ); ?>" style="color:var(--navy);font-family:'Montserrat',sans-serif;font-weight:800;font-size:16px;"><?php echo esc_html( $phone ); ?></a>
            </div>

            <div class="form-activity">
                <span class="activity-dot"></span>
                Someone from our team usually responds within 1 hour
            </div>

        </div>
    </div>
</section>

<section class="sc-law-section">
    <div class="section-inner">
        <div class="section-eyebrow">South Carolina Law</div>

        <h2 class="section-title">Rear-End Collision Laws in South Carolina</h2>

        <div class="sc-law-grid">
            <div class="sc-law-card">
                <h3>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.3-1.54c-.3-.36-.77-.36-1.07 0-.3.36-.3.95 0 1.31l1.84 2.2c.3.36.77.36 1.07 0 .3-.36.75-1.85 2.75-3.54.36-.3.36-.77.06-1.07-.3-.3-.75-.36-1.06-.06z"/></svg>
                    Statute of Limitations
                </h3>
                <div class="law-value"><?php echo esc_html( $sc_law['statute_years'] ); ?> Years</div>
                <p>In South Carolina, you have <?php echo esc_html( $sc_law['statute_years'] ); ?> years from the date of your rear-end collision to file a personal injury lawsuit. Miss this deadline and you lose your right to compensation &mdash; permanently.</p>
                <p class="cite"><?php echo esc_html( $sc_law['statute_cite'] ); ?></p>
            </div>

            <div class="sc-law-card">
                <h3>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm1-13h-2v6h2zm0 8h-2v2h2z"/></svg>
                    Comparative Negligence
                </h3>
                <div class="law-value">&lt; 51% at Fault</div>
                <p>South Carolina follows a comparative negligence rule. You can recover damages even if you're partially at fault for the rear-end collision &mdash; as long as you're less than 51% responsible. The rear driver is typically presumed at fault in rear-end collisions unless extraordinary circumstances apply.</p>
                <p class="cite">S.C. Code § 15-38-10</p>
            </div>
        </div>
    </div>
</section>

<div class="no-fee-banner">
    <div class="no-fee-inner">
        <div class="no-fee-item">
            <div class="no-fee-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            </div>
            <?php echo esc_html( $stats['recovered'] ); ?>+ Recovered
        </div>
        <div class="no-fee-sep">|</div>
        <div class="no-fee-item">
            <div class="no-fee-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            </div>
            <?php echo esc_html( $stats['cases'] ); ?> Cases Won
        </div>
        <div class="no-fee-sep">|</div>
        <div class="no-fee-item">
            <div class="no-fee-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            </div>
            <?php echo esc_html( $stats['rating'] ); ?>&#9733; Rating
        </div>
        <div class="no-fee-sep">|</div>
        <div class="no-fee-item">
            <div class="no-fee-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5.04-6.71l-2.75 3.54-1.3-1.54c-.3-.36-.77-.36-1.07 0-.3.36-.3.95 0 1.31l1.84 2.2c.3.36.77.36 1.07 0 .3-.36.75-1.85 2.75-3.54.36-.3.36-.77.06-1.07-.3-.3-.75-.36-1.06-.06z"/></svg>
            </div>
            No Fee Unless We Win
        </div>
    </div>
</div>

<section class="trust-badges">
    <div class="trust-badges-inner">
        <div class="trust-badge">
            <div class="trust-badge-icon google">G</div>
            <div class="trust-badge-text">
                Google Reviews
                <span class="trust-badge-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span> <?php echo esc_html( $stats['rating'] ); ?>/5
            </div>
        </div>
        <div class="trust-badge">
            <div class="trust-badge-icon sl">SL</div>
            <div class="trust-badge-text">
                <strong>Superb Lawyer</strong>
                Top Rated Personal Injury
            </div>
        </div>
        <div class="trust-badge">
            <div class="trust-badge-icon avvo">A</div>
            <div class="trust-badge-text">
                <strong>AVVO Rating</strong>
                Highly Rated Lawyer
            </div>
        </div>
        <div class="trust-badge">
            <div class="trust-badge-icon bbb">BBB</div>
            <div class="trust-badge-text">
                <strong>Better Business Bureau</strong>
                A+ Accredited
            </div>
        </div>
        <div class="trust-badge">
            <div class="trust-badge-icon sc-bar">SC</div>
            <div class="trust-badge-text">
                <strong>SC Bar Association</strong>
                Licensed &amp; Disciplined
            </div>
        </div>
    </div>
</section>

<section class="why-section">
    <div class="section-inner">
        <div class="section-eyebrow">Why Choose Roden Law</div>
        <h2 class="section-title">Why <?php echo esc_html( $city ); ?> Chooses Roden Law After a Rear-End Collision</h2>
        <p class="section-sub">We handle rear-end collision cases differently. We don't accept insurance company tactics that minimize your injuries or pressure you to settle quickly.</p>

        <div class="why-grid">
            <div class="why-card">
                <div class="why-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><path d="M9 12l2 2 4-4m6 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3>We Fight Lowball Tactics</h3>
                <p>Insurance companies dismiss rear-end collisions as "minor" impacts with "soft tissue" injuries. We prove the real damage using medical experts and biomechanical evidence.</p>
            </div>

            <div class="why-card">
                <div class="why-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><path d="M9 12l2 2 4-4m7.5-4.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM9 6.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                </div>
                <h3>Proving Hidden Injuries</h3>
                <p>Whiplash and other rear-end injuries often don't show symptoms for days or weeks. We document every medical detail and prove causation to maximize your settlement.</p>
            </div>

            <div class="why-card">
                <div class="why-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3>$250M+ in Recoveries</h3>
                <p>Our track record speaks for itself. We've recovered hundreds of millions for South Carolina accident victims, including dozens of rear-end collision cases.</p>
            </div>

            <div class="why-card">
                <div class="why-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                </div>
                <h3>Talk to a Lawyer, Not a Call Center</h3>
                <p>You won't navigate an automated menu. Your case is evaluated by an actual attorney who discusses your injuries, the accident, and your options.</p>
            </div>

            <div class="why-card">
                <div class="why-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><circle cx="12" cy="12" r="9"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h3>Fast Response Time</h3>
                <p>We move quickly to preserve evidence, gather police reports, collect medical records, and protect your rights before the trail goes cold.</p>
            </div>

            <div class="why-card">
                <div class="why-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><path d="M9 12l2 2 4-4m9 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3>Zero Fee Unless We Win</h3>
                <p>We work on contingency. You pay nothing until we recover compensation for your rear-end collision injuries. If we don't win, you owe us nothing.</p>
            </div>
        </div>
    </div>
</section>

<div class="mid-page-cta">
    <div class="section-inner">
        <h2>Don't Accept a Lowball Settlement for Your Rear-End Collision</h2>
        <div class="cta-buttons">
            <button class="cta-btn-primary" onclick="window.location='#leadForm'">Free Case Review</button>
            <button class="cta-btn-secondary" onclick="window.location='tel:<?php echo esc_attr( $tel ); ?>'">Call <?php echo esc_html( $phone ); ?></button>
        </div>
        <p class="cta-subtext">Talk to an attorney today. Consultations are free and confidential.</p>
    </div>
</div>

<section class="results-section">
    <div class="section-inner">
        <div class="section-eyebrow">Real Results for Rear-End Collision Victims</div>
        <h2 class="section-title">Rear-End Collision Verdicts &amp; Settlements</h2>
        <p class="section-sub">These are examples of recent rear-end collision cases we've handled. Your case value will depend on your injuries, medical costs, lost wages, and the defendant's insurance limits.</p>

        <div class="results-grid">
            <div class="result-card">
                <div class="result-type">Verdict</div>
                <div class="result-amount">$1,850,000</div>
                <div class="result-desc">Rear-end collision with traumatic brain injury (TBI)</div>
            </div>
            <div class="result-card">
                <div class="result-type">Settlement</div>
                <div class="result-amount">$925,000</div>
                <div class="result-desc">Multi-car rear-end pileup on I-26</div>
            </div>
            <div class="result-card">
                <div class="result-type">Settlement</div>
                <div class="result-amount">$750,000</div>
                <div class="result-desc">Rear-end at stoplight with herniated discs</div>
            </div>
            <div class="result-card">
                <div class="result-type">Settlement</div>
                <div class="result-amount">$485,000</div>
                <div class="result-desc">Rear-end collision whiplash with chronic pain</div>
            </div>
            <div class="result-card">
                <div class="result-type">Settlement</div>
                <div class="result-amount">$375,000</div>
                <div class="result-desc">Low-speed rear-end with delayed symptoms</div>
            </div>
            <div class="result-card">
                <div class="result-type">Settlement</div>
                <div class="result-amount">$1,200,000</div>
                <div class="result-desc">Commercial vehicle rear-end collision</div>
            </div>
        </div>

        <p class="results-disclaimer">These results do not constitute a guarantee of any particular case outcome. Every case is unique and depends on the specific facts, injuries, and evidence.</p>
    </div>
</section>

<section class="process-section">
    <div class="section-inner">
        <div class="section-eyebrow">Our Process</div>
        <h2 class="section-title">How We Handle Your Rear-End Collision Case</h2>

        <div class="process-grid">
            <div class="process-step">
                <div class="step-number">1</div>
                <h3>Free Consultation</h3>
                <p>We evaluate your rear-end collision, injuries, and damages. No attorney fees or obligations.</p>
            </div>
            <div class="process-step">
                <div class="step-number">2</div>
                <h3>Investigation &amp; Evidence</h3>
                <p>We gather police reports, witness statements, medical records, and expert analysis to build a strong case.</p>
            </div>
            <div class="process-step">
                <div class="step-number">3</div>
                <h3>Negotiation &amp; Demand</h3>
                <p>We demand fair compensation from the insurance company. Most cases settle without trial.</p>
            </div>
            <div class="process-step">
                <div class="step-number">4</div>
                <h3>Trial or Settlement</h3>
                <p>If the insurance company won't settle fairly, we take your case to trial and fight for maximum damages.</p>
            </div>
        </div>
    </div>
</section>

<section class="checklist-section">
    <div class="section-inner">
        <div class="checklist-layout">
            <div>
                <div class="section-eyebrow">Action Items</div>
                <h2 class="section-title">5 Things You Must Do After a Rear-End Collision in South Carolina</h2>
            </div>

            <ul class="checklist-items">
                <li>
                    <div class="check-num">1</div>
                    <div class="check-content">
                        <h3>Document Damage to Both Vehicles</h3>
                        <p>Take photos and videos of the rear-end damage to your car and the front of the other vehicle. This proves the direction of impact and helps establish fault.</p>
                    </div>
                </li>
                <li>
                    <div class="check-num">2</div>
                    <div class="check-content">
                        <h3>Note Position, Speed &amp; Conditions</h3>
                        <p>Record where the collision happened (highway, city street, intersection), the weather, road conditions, and the speed of both vehicles. Jot down the other driver's info, insurance details, and vehicle info.</p>
                    </div>
                </li>
                <li>
                    <div class="check-num">3</div>
                    <div class="check-content">
                        <h3>Seek Medical Attention Immediately</h3>
                        <p>Go to the ER or urgent care even if you "feel fine." Whiplash, TBI, and other rear-end injuries often take hours or days to show symptoms. A medical record proves causation.</p>
                    </div>
                </li>
                <li>
                    <div class="check-num">4</div>
                    <div class="check-content">
                        <h3>Don't Accept Fault at the Scene</h3>
                        <p>Never apologize, admit guilt, or make statements about the accident to the other driver or police. You can be polite without accepting responsibility.</p>
                    </div>
                </li>
                <li>
                    <div class="check-num">5</div>
                    <div class="check-content">
                        <h3>Call Roden Law Immediately</h3>
                        <p>Contact us before speaking to the insurance company. Insurance adjusters will try to minimize your injuries or get you to settle for far less than your case is worth.</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>

<section class="offices-section">
    <div class="section-inner">
        <div class="section-eyebrow">Serving All of South Carolina</div>
        <h2 class="section-title">Our Rear-End Collision Law Offices</h2>

        <div class="offices-grid">
            <?php foreach ( $sc_offices as $office ) : ?>
                <div class="office-card">
                    <h3 class="office-card-city">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C7.58 2 4 5.58 4 10c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"/></svg>
                        <?php echo esc_html( $office['city'] ); ?>
                    </h3>
                    <div class="office-card-detail">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <?php echo esc_html( $office['address'] ); ?>
                    </div>
                    <div class="office-card-detail">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <?php echo esc_html( $office['phone'] ); ?>
                    </div>
                    <a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $office['phone'] ) ); ?>" class="office-card-phone">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
                        Call Office
                    </a>
                    <div class="office-card-service"><strong>Services:</strong> <?php echo esc_html( $office['service_area'] ?? 'Rear-End Collision, Personal Injury' ); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="testimonials-section">
    <div class="section-inner">
        <div class="section-eyebrow">Client Testimonials</div>
        <h2 class="section-title">What Rear-End Collision Victims Say About Roden Law</h2>

        <div class="testimonial-grid">
            <div class="testimonial-card">
                <div class="testimonial-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <p class="testimonial-text">"I was rear-ended on I-26 and thought it was a minor accident. Roden Law helped me get medical treatment and fought for $800,000 in compensation. Their team was professional and caring throughout the process."</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">JS</div>
                    <div>
                        <div class="testimonial-name">Jennifer S.</div>
                        <div class="testimonial-location">Charleston, SC</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <p class="testimonial-text">"Hit at a stoplight in Columbia by someone going 40 mph. Insurance offered $15k, but Roden Law got me $425,000. They explained every step and made me feel heard. Highly recommend!"</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">MR</div>
                    <div>
                        <div class="testimonial-name">Michael R.</div>
                        <div class="testimonial-location">Columbia, SC</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <p class="testimonial-text">"Involved in a chain-reaction rear-end on Highway 17. The other insurance company tried to deny my whiplash diagnosis, but Roden Law brought in doctors and got me a fair settlement. They fight for you."</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">KC</div>
                    <div>
                        <div class="testimonial-name">Karen C.</div>
                        <div class="testimonial-location">Myrtle Beach, SC</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="faq-section">
    <div class="section-inner">
        <div class="faq-layout">
            <div>
                <div class="section-eyebrow">FAQs</div>
                <h2 class="section-title">Rear-End Collision FAQs</h2>
            </div>

            <div class="faq-items">
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        Is the rear driver always at fault in South Carolina?
                        <span></span>
                    </button>
                    <div class="faq-answer">
                        <p>In South Carolina, the rear driver is presumed at fault in rear-end collisions because they have a duty to maintain a safe following distance. However, there are exceptions: if the front vehicle brake-checks the rear driver, has broken brake lights, or suddenly reverses, the front driver may share or bear full liability. We investigate these details thoroughly.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        How much is my rear-end collision case worth?
                        <span></span>
                    </button>
                    <div class="faq-answer">
                        <p>Your case value depends on: medical costs and ongoing care, lost wages, pain and suffering, future earning capacity, and the defendant's insurance limits. A "minor" rear-end impact can still result in serious injuries like whiplash, herniated discs, and TBI. We value cases by reviewing medical records, expert reports, and comparable settlements.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        What if my symptoms appeared days after the rear-end collision?
                        <span></span>
                    </button>
                    <div class="faq-answer">
                        <p>Delayed onset is common for whiplash and traumatic brain injury (TBI). Symptoms may not appear for 24-48 hours after impact. Seek medical attention immediately and document your symptoms. Insurance companies often use delayed symptoms as an excuse to deny claims, but we use medical evidence to prove causation.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        Can I recover compensation if the insurance company says it was a minor impact?
                        <span></span>
                    </button>
                    <div class="faq-answer">
                        <p>Yes. Insurance companies use low-speed or low-impact collisions as justification for lowball offers, but the impact speed does not determine injury severity. Biomechanical experts can prove serious injuries occurred even at low speeds. We fight against these tactics every day.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        How long do I have to file a rear-end collision claim in South Carolina?
                        <span></span>
                    </button>
                    <div class="faq-answer">
                        <p>You have 3 years from the date of the rear-end collision to file a personal injury lawsuit in South Carolina (S.C. Code § 15-3-530). However, waiting weakens your case. Evidence disappears, witnesses forget details, and the insurance company delays your recovery. Contact us immediately.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        What if I was partially at fault for being rear-ended?
                        <span></span>
                    </button>
                    <div class="faq-answer">
                        <p>South Carolina uses comparative negligence. You can recover damages even if you're partially at fault, as long as you're less than 51% responsible. Insurance companies exaggerate your fault percentage to minimize settlement offers. We aggressively defend against these claims and maximize your recovery.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bottom-cta">
    <div class="section-inner">
        <h2>Don't Let Insurance Companies Call Your Rear-End Collision "Minor." Get Your Free Case Review Now.</h2>
        <p>Rear-end collisions can cause serious, lifelong injuries. We fight for victims who deserve real compensation.</p>

        <a href="tel:<?php echo esc_attr( $tel ); ?>" class="cta-phone">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <?php echo esc_html( $phone ); ?>
        </a>

        <p class="cta-or">or</p>

        <a href="#leadForm" class="cta-form-link">
            Get Your Free Case Review Online →
        </a>
    </div>
</section>

<footer class="lp-footer">
    <p>
        This is a landing page. Roden Law handles rear-end collision claims and personal injury cases across South Carolina.
        Free consultation. No fee unless we win. South Carolina (SC) licensed attorneys.
        <br>
        <strong>Not legal advice.</strong> This page is for informational purposes only and does not constitute legal advice or an attorney-client relationship.
        <br><br>
        &copy; <?php echo date('Y'); ?> Roden Law. All rights reserved. | <a href="<?php echo esc_url( home_url( '/terms-privacy-policy/' ) ); ?>">Terms &amp; Privacy</a>
    </p>
</footer>

<div class="desktop-sticky-cta">
    <a href="tel:<?php echo esc_attr( $tel ); ?>" title="Call Roden Law about your rear-end collision">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        Call Now
    </a>
</div>

<script>
    /* Quick Callback tab toggle removed — can re-enable later */

    /* Phone auto-format: (xxx) xxx-xxxx */
    var lpPhone = document.getElementById('lp-phone');
    if (lpPhone) {
        lpPhone.addEventListener('input', function() {
            var digits = this.value.replace(/\D/g, '').substring(0, 10);
            if (digits.length === 0) { this.value = ''; }
            else if (digits.length <= 3) { this.value = '(' + digits; }
            else if (digits.length <= 6) { this.value = '(' + digits.substring(0,3) + ') ' + digits.substring(3); }
            else { this.value = '(' + digits.substring(0,3) + ') ' + digits.substring(3,6) + '-' + digits.substring(6); }
        });
    }

    /* Email validation on blur */
    var lpEmail = document.getElementById('lp-email');
    if (lpEmail) {
        lpEmail.addEventListener('blur', function() {
            var v = this.value.trim();
            if (v && !/^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/.test(v)) {
                this.setCustomValidity('Please enter a valid email (e.g. name@example.com)');
            } else {
                this.setCustomValidity('');
            }
        });
        lpEmail.addEventListener('input', function() { this.setCustomValidity(''); });
    }

    /* Form submission → admin-ajax → GF entry */
    document.getElementById('leadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = this;
        var btn = form.querySelector('.form-submit');
        var errEl = form.querySelector('.form-error');

        /* Validate phone */
        var phoneDigits = (lpPhone ? lpPhone.value : '').replace(/\D/g, '');
        if (phoneDigits.length !== 10) {
            errEl.textContent = 'Please enter a valid 10-digit phone number.';
            errEl.style.display = 'block';
            if (lpPhone) lpPhone.focus();
            return;
        }
        /* Validate email */
        var emailVal = lpEmail ? lpEmail.value.trim() : '';
        if (!/^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/.test(emailVal)) {
            errEl.textContent = 'Please enter a valid email address.';
            errEl.style.display = 'block';
            if (lpEmail) lpEmail.focus();
            return;
        }
        btn.disabled = true;
        btn.textContent = 'Submitting\u2026';
        errEl.style.display = 'none';
        var fd = new FormData(form);
        fd.append('action', 'roden_sidebar_submit');
        fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
            method: 'POST',
            body: fd
        })
        .then(function(r){ return r.json(); })
        .then(function(data){
            if (data.success && data.data.redirect) {
                window.location.href = data.data.redirect;
            } else {
                errEl.textContent = data.data || 'Something went wrong. Please call <?php echo esc_html( $phone ); ?>.';
                errEl.style.display = 'block';
                btn.disabled = false;
                btn.textContent = 'Get My Free Case Review \u2192';
            }
        })
        .catch(function(){
            errEl.textContent = 'Network error. Please call <?php echo esc_html( $phone ); ?>.';
            errEl.style.display = 'block';
            btn.disabled = false;
            btn.textContent = 'Get My Free Case Review \u2192';
        });
    });

    /* FAQ Toggle with keyboard support */
    function toggleFaq(question) {
        var item = question.parentElement;
        var isOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item').forEach(function(i) {
            if (i !== item) {
                i.classList.remove('open');
                i.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
            }
        });
        item.classList.toggle('open');
        question.setAttribute('aria-expanded', String(!isOpen));
    }
    document.querySelectorAll('.faq-question').forEach(function(question) {
        question.setAttribute('aria-expanded', question.parentElement.classList.contains('open') ? 'true' : 'false');
        question.addEventListener('click', function() { toggleFaq(this); });
        question.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleFaq(this);
            }
        });
    });

    /* Smooth scroll for anchor links */
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    /* Desktop sticky CTA — show after scrolling past hero, hide at bottom CTA */
    var stickyCta = document.querySelector('.desktop-sticky-cta');
    if (stickyCta) {
        var heroSection = document.querySelector('.hero');
        var bottomCta = document.querySelector('.bottom-cta');
        window.addEventListener('scroll', function() {
            if (!heroSection) return;
            var heroBottom = heroSection.getBoundingClientRect().bottom;
            var bottomCtaTop = bottomCta ? bottomCta.getBoundingClientRect().top : Infinity;
            if (heroBottom < 0 && bottomCtaTop > window.innerHeight) {
                stickyCta.classList.add('visible');
            } else {
                stickyCta.classList.remove('visible');
            }
        }, { passive: true });
    }
</script>

<?php wp_footer(); ?>
<script type="text/javascript" src="//cdn.callrail.com/companies/481994887/9f5e5ebaf1d98d87a441/12/swap.js"></script>
</body>
</html>
