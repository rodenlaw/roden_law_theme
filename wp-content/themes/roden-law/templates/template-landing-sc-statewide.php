<?php
/**
 * Template Name: Landing Page — SC Statewide
 *
 * Statewide South Carolina PPC landing page — does NOT use get_header() / get_footer().
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
    <title>South Carolina Car Accident Lawyers | Roden Law</title>
    <meta name="description" content="Injured in a car accident <?php echo esc_attr( $in_location ); ?>? Roden Law has recovered <?php echo esc_attr( $stats['recovered'] ); ?> for injury victims. Free case review. No fee unless we win. Call <?php echo esc_attr( $phone ); ?>.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&display=swap" as="style">
    <style>
        /* ===== RESET & BASE ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
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
            margin-bottom: 28px;
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

        /* ===== ACCIDENT TYPE GRID ===== */
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

        /* ===== FORM TABS ===== */
        .form-tabs {
            display: flex;
            margin-bottom: 20px;
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid #e2e8f0;
        }
        .form-tab {
            flex: 1;
            padding: 12px;
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
            background: var(--light-gray);
            color: var(--text-muted);
            border: none;
        }
        .form-tab.active {
            background: var(--navy);
            color: var(--white);
        }

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
        .full-fields { transition: max-height 0.3s ease, opacity 0.3s ease; overflow: hidden; }
        .full-fields.hidden { max-height: 0; opacity: 0; pointer-events: none; }
        .full-fields.visible { max-height: 500px; opacity: 1; }

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
            .trust-badge-icon { width: 40px; height: 40px; font-size: 9px; }
            .why-grid { grid-template-columns: 1fr; }
            .results-grid { grid-template-columns: 1fr; }
            .process-grid { grid-template-columns: 1fr; }
            .result-amount { font-size: 28px; }
            .offices-grid { grid-template-columns: 1fr; }
        }

        /* Dual mobile CTA: side-by-side at wider mobile, call-only at narrow */
        @media (max-width: 768px) and (min-width: 400px) {
            .mobile-cta-bar-inner { display: flex; }
            .mobile-cta-review { display: flex; }
        }
        @media (max-width: 399px) {
            .mobile-cta-bar-inner { display: flex; }
            .mobile-cta-review { display: none; }
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
                "name": "How much does it cost to hire Roden Law?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Nothing upfront. We work on a contingency fee basis, which means you pay zero out of pocket. Our fee comes from a percentage of your settlement or verdict — only if we win. If we don't recover money for you, you owe us nothing."
                }
            },
            {
                "@type": "Question",
                "name": "How long do I have to file a car accident claim in South Carolina?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "South Carolina has a <?php echo esc_html( $sc_law['statute_years'] ); ?>-year statute of limitations for personal injury claims from the date of the accident (<?php echo esc_html( $sc_law['statute_cite'] ); ?>). However, waiting can hurt your case — evidence disappears, witnesses forget details, and the insurance company may use delay against you. Contact an attorney as soon as possible."
                }
            },
            {
                "@type": "Question",
                "name": "What if I was partially at fault for the accident?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Under South Carolina's modified comparative fault rule, you can still recover compensation as long as you were less than 51% at fault. Your award is reduced by your percentage of fault. For example, if you were 20% at fault and damages total $100,000, you could recover $80,000. Insurance companies often try to inflate your fault percentage — our attorneys fight back."
                }
            },
            {
                "@type": "Question",
                "name": "What compensation can I receive after a car accident in South Carolina?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "You may be entitled to compensation for medical bills (past and future), lost wages and earning capacity, pain and suffering, property damage, and in some cases, punitive damages. The value depends on the severity of your injuries and the circumstances of the accident."
                }
            },
            {
                "@type": "Question",
                "name": "What if the other driver doesn't have insurance?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "South Carolina requires drivers to carry minimum liability coverage, but not all drivers comply. You may still be able to recover compensation through your own uninsured/underinsured motorist (UM/UIM) coverage. Our attorneys will investigate every avenue to ensure you get the compensation you deserve."
                }
            },
            {
                "@type": "Question",
                "name": "Should I talk to the other driver's insurance company?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "No. Insurance adjusters are trained to get you to say things that can reduce your claim. Before giving any recorded statement, talk to a Roden Law attorney first. We'll handle all communication with the insurance companies so you don't accidentally hurt your case."
                }
            }
        ]
    }
    </script>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'landing-page' ); ?>>
<a class="skip-link" href="#leadForm">Skip to Free Case Review</a>

<!-- ===== TOP BAR ===== -->
<div class="top-bar">
    <div class="top-bar-inner">
        <div class="top-bar-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            <?php echo esc_html( $stats['rating'] ); ?> STARS &mdash; <?php echo esc_html( $stats['cases'] ); ?> CASES HANDLED
        </div>
        <div class="top-bar-phone">
            <span>Free Case Review 24/7:</span>
            <a href="tel:<?php echo esc_attr( $tel ); ?>"><?php echo esc_html( $phone ); ?></a>
        </div>
    </div>
</div>

<main id="main-content">
<!-- ===== HERO ===== -->
<section class="hero">
    <div class="hero-bg-image"></div>
    <div class="hero-inner">
        <div class="hero-content">
            <div class="hero-eyebrow">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                Trusted South Carolina Trial Attorneys
            </div>
            <h1><?php echo esc_html( $city ); ?> <span class="gold">Car Accident Lawyers</span></h1>
            <p class="hero-sub">Don't let insurance companies shortchange you. Roden Law has recovered over <?php echo esc_html( $stats['recovered'] ); ?> for injury victims across South Carolina &mdash; and we don't charge a fee unless we win your case.</p>

            <!-- Hero Call CTA -->
            <a href="tel:<?php echo esc_attr( $tel ); ?>" class="hero-call-cta">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                Call Now: <?php echo esc_html( $phone ); ?>
            </a>
            <div class="hero-call-sub">Available 24/7 &mdash; Free Consultation</div>

            <!-- Attorney Photo Strip -->
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
                                <img src="<?php echo esc_url( wp_get_attachment_image_url( $headshot[0]->ID, 'thumbnail' ) ); ?>" alt="<?php echo esc_attr( $atty['name'] ); ?>">
                            <?php else : ?>
                                <?php echo esc_html( $atty['initials'] ); ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <span class="attorney-strip-caption">Your SC Legal Team</span>
            </div>

            <div class="accident-types">
                <a href="<?php echo esc_url( home_url( '/car-accident-lawyers/rear-end-collision/' ) ); ?>" class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><rect x="1" y="12" width="9" height="6" rx="1"/><rect x="14" y="12" width="9" height="6" rx="1"/><line x1="10" y1="15" x2="14" y2="15"/><circle cx="4" cy="18" r="1.5" fill="#e8a830" stroke="none"/><circle cx="20" cy="18" r="1.5" fill="#e8a830" stroke="none"/></svg>
                    <span class="accident-type-label">Rear-End Collision</span>
                </a>
                <a href="<?php echo esc_url( home_url( '/car-accident-lawyers/t-bone-accident/' ) ); ?>" class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><rect x="2" y="10" width="10" height="6" rx="1"/><rect x="14" y="4" width="6" height="10" rx="1" transform="rotate(0)"/><line x1="12" y1="13" x2="14" y2="13"/><path d="M11 12l3-3" stroke="#e8a830" stroke-width="1" opacity="0.5"/></svg>
                    <span class="accident-type-label">T-Bone / Side Impact</span>
                </a>
                <a href="<?php echo esc_url( home_url( '/car-accident-lawyers/hit-and-run-accident/' ) ); ?>" class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><rect x="2" y="12" width="9" height="5" rx="1"/><circle cx="5" cy="17" r="1.5" fill="#e8a830" stroke="none"/><path d="M11 14.5l2-2M13 14.5l2-2" opacity="0.6"/><path d="M16 9l2 2M20 9l-2 2M18 7v4" stroke-width="1.5"/></svg>
                    <span class="accident-type-label">Hit &amp; Run</span>
                </a>
                <a href="<?php echo esc_url( home_url( '/car-accident-lawyers/drunk-driver-accident/' ) ); ?>" class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><rect x="2" y="13" width="11" height="5" rx="1"/><circle cx="5" cy="18" r="1.5" fill="#e8a830" stroke="none"/><circle cx="10" cy="18" r="1.5" fill="#e8a830" stroke="none"/><path d="M15 11l1.5-5.5M18 11l-1.5-5.5M16.5 5.5h0" stroke-linecap="round"/><path d="M14 8h5" stroke-linecap="round"/></svg>
                    <span class="accident-type-label">Drunk Driver</span>
                </a>
                <a href="<?php echo esc_url( home_url( '/car-accident-lawyers/distracted-driver-accident/' ) ); ?>" class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><rect x="2" y="13" width="11" height="5" rx="1"/><circle cx="5" cy="18" r="1.5" fill="#e8a830" stroke="none"/><circle cx="10" cy="18" r="1.5" fill="#e8a830" stroke="none"/><rect x="15" y="5" width="6" height="10" rx="1"/><line x1="18" y1="8" x2="18" y2="12" stroke-linecap="round"/></svg>
                    <span class="accident-type-label">Distracted Driver</span>
                </a>
                <a href="<?php echo esc_url( home_url( '/car-accident-lawyers/rideshare-accident/' ) ); ?>" class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><rect x="3" y="12" width="12" height="6" rx="1"/><circle cx="6" cy="18" r="1.5" fill="#e8a830" stroke="none"/><circle cx="12" cy="18" r="1.5" fill="#e8a830" stroke="none"/><circle cx="20" cy="10" r="4"/><path d="M18.5 9.5l1.5 1 1.5-1" stroke-linecap="round"/></svg>
                    <span class="accident-type-label">Uber / Lyft</span>
                </a>
            </div>
        </div>

        <!-- FORM -->
        <div class="hero-form-card">
            <div class="form-urgency"><span class="pulse-dot"></span> SC has a 3-year filing deadline</div>
            <h2>Free Case Review</h2>
            <p class="form-subtitle">Find out what your case is worth &mdash; in minutes.</p>

            <!-- Form Tabs -->
            <div class="form-tabs">
                <button type="button" class="form-tab active" data-tab="full">Full Review</button>
                <button type="button" class="form-tab" data-tab="quick">Quick Callback</button>
            </div>

            <form id="leadForm" action="#" method="POST" novalidate>
                <?php wp_nonce_field( 'roden_sidebar_form', 'roden_form_nonce' ); ?>
                <input type="hidden" name="gclid" class="roden-gclid" value="">
                <div class="form-row">
                    <div class="form-group">
                        <label for="lp-fname" class="sr-only">First Name</label>
                        <input type="text" name="first_name" id="lp-fname" placeholder="First Name*" autocomplete="given-name" required>
                    </div>
                    <div class="form-group">
                        <label for="lp-lname" class="sr-only">Last Name</label>
                        <input type="text" name="last_name" id="lp-lname" placeholder="Last Name*" autocomplete="family-name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="lp-phone" class="sr-only">Phone Number</label>
                        <input type="tel" name="phone" id="lp-phone" placeholder="(555) 555-5555" autocomplete="tel" required>
                    </div>
                    <div class="form-group full-fields visible">
                        <label for="lp-email" class="sr-only">Email Address</label>
                        <input type="email" name="email" id="lp-email" placeholder="Email Address*" autocomplete="email" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" required>
                    </div>
                </div>
                <div class="full-fields visible">
                    <div class="form-group">
                        <label for="lp-message" class="sr-only">Describe what happened</label>
                        <textarea name="message" id="lp-message" placeholder="Please describe what happened" rows="4"></textarea>
                    </div>
                </div>
                <label class="form-consent" style="display:flex;align-items:flex-start;gap:10px;margin-bottom:12px;cursor:pointer;">
                    <input type="checkbox" name="consent" value="1" checked required style="width:18px;height:18px;min-width:18px;margin-top:2px;accent-color:#f5a623;cursor:pointer;">
                    <span style="font-size:12px;color:#64748b;line-height:1.5;">I hereby expressly consent to receive automated communications including calls, texts, emails, and/or prerecorded messages. By submitting this form, you agree to our <a href="<?php echo esc_url( home_url( '/terms-privacy-policy/' ) ); ?>" target="_blank" style="color:#f5a623;text-decoration:underline;">Terms &amp; Privacy Policy</a>.</span>
                </label>
                <button type="submit" class="form-submit">Get My Free Case Review &rarr;</button>
                <p style="text-align:center;font-size:12px;color:var(--text-muted);margin-top:8px;margin-bottom:0;">
                    <svg style="display:inline-block;vertical-align:middle;margin-right:4px;" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#2ecc71" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    Average response time: under 15 minutes
                </p>
                <p class="form-error" role="alert" aria-live="assertive" style="display:none;color:#ff6b6b;font-size:13px;text-align:center;margin-top:8px;"></p>
            </form>
            <div class="form-trust">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2ecc71" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                100% confidential. No obligation. No upfront fees &mdash; ever.
            </div>
            <div style="text-align:center;margin-top:16px;font-size:14px;color:var(--text-muted);">
                or call now: <a href="tel:<?php echo esc_attr( $tel ); ?>" style="color:var(--navy);font-family:'Montserrat',sans-serif;font-weight:800;font-size:16px;"><?php echo esc_html( $phone ); ?></a>
            </div>
            <div class="form-activity">
                <span class="activity-dot"></span>
                14 people requested a review today
            </div>
        </div>
    </div>
</section>

<!-- ===== SC LAW CALLOUT ===== -->
<section class="sc-law-section">
    <div class="section-inner">
        <div class="section-eyebrow">South Carolina Law</div>
        <h2 class="section-title">Critical Deadlines &amp; Rules for South Carolina Car Accidents</h2>
        <p class="section-sub">Understanding South Carolina's personal injury laws can make or break your case. Here's what every accident victim needs to know.</p>

        <div class="sc-law-grid">
            <div class="sc-law-card">
                <h3>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    Statute of Limitations
                </h3>
                <div class="law-value"><?php echo esc_html( $sc_law['statute_years'] ); ?> Years</div>
                <p>In South Carolina, you have <?php echo esc_html( $sc_law['statute_years'] ); ?> years from the date of your car accident to file a personal injury lawsuit. Miss this deadline and you lose your right to compensation &mdash; permanently.</p>
                <p class="cite"><?php echo esc_html( $sc_law['statute_cite'] ); ?></p>
            </div>
            <div class="sc-law-card">
                <h3>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Comparative Fault Rule
                </h3>
                <div class="law-value">&lt; 51% at Fault</div>
                <p>South Carolina follows a modified comparative fault rule. You can recover damages as long as you are less than 51% responsible for the accident. Your compensation is reduced by your percentage of fault.</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== STATS + NO-FEE BANNER ===== -->
<div class="no-fee-banner">
    <div class="no-fee-inner">
        <div class="no-fee-item">
            <div class="no-fee-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2.5"><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>
            </div>
            <?php echo esc_html( $stats['recovered'] ); ?>+ Recovered
        </div>
        <span class="no-fee-sep">|</span>
        <div class="no-fee-item">
            <div class="no-fee-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <?php echo esc_html( $stats['cases'] ); ?> Cases Won
        </div>
        <span class="no-fee-sep">|</span>
        <div class="no-fee-item">
            <div class="no-fee-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
            <?php echo esc_html( $stats['rating'] ); ?>&#9733; Rating
        </div>
        <span class="no-fee-sep">|</span>
        <div class="no-fee-item">
            <div class="no-fee-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            No Fee Unless We Win
        </div>
    </div>
</div>

<!-- ===== TRUST BADGE BAR ===== -->
<section class="trust-badges">
    <div class="trust-badges-inner">
        <div class="trust-badge">
            <div class="trust-badge-icon google">
                <svg width="22" height="22" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
            </div>
            <div class="trust-badge-text">
                <strong>Google Reviews</strong>
                <span class="trust-badge-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</span> <?php echo esc_html( $stats['rating'] ); ?>/5
            </div>
        </div>
        <div class="trust-badge">
            <div class="trust-badge-icon sl">SL</div>
            <div class="trust-badge-text">
                <strong>Super Lawyers</strong>
                Rising Stars
            </div>
        </div>
        <div class="trust-badge">
            <div class="trust-badge-icon avvo">A</div>
            <div class="trust-badge-text">
                <strong>Avvo Rated</strong>
                Top Attorney
            </div>
        </div>
        <div class="trust-badge">
            <div class="trust-badge-icon sc-bar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div class="trust-badge-text">
                <strong>SC Bar Association</strong>
                Members in Good Standing
            </div>
        </div>
    </div>
</section>

<!-- ===== WHY CHOOSE RODEN LAW ===== -->
<section class="why-section">
    <div class="section-inner">
        <div class="section-eyebrow">Your Road to Results</div>
        <h2 class="section-title">Why <?php echo esc_html( $city ); ?> Chooses Roden Law After a Car Accident</h2>
        <p class="section-sub">When you're dealing with injuries, lost wages, and mounting medical bills, you need a legal team that fights as hard as you do.</p>

        <div class="why-grid">
            <div class="why-card">
                <div class="why-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>We Handle the Insurance Companies</h3>
                <p>Insurance adjusters are trained to minimize your payout. Our attorneys know their tactics and fight to make sure you receive every dollar you're owed.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <h3>Fast, Aggressive Representation</h3>
                <p>Time matters after an accident. We move quickly to preserve evidence, file your claim, and start building the strongest possible case from day one.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3><?php echo esc_html( $stats['recovered'] ); ?> Recovered for Clients</h3>
                <p>Results matter. Our track record of multi-million dollar verdicts and settlements shows we know how to maximize the value of your car accident claim.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>You Talk to a Lawyer, Not a Call Center</h3>
                <p>Unlike the big national firms, you work directly with experienced South Carolina attorneys who know local courts, judges, and opposing counsel.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                </div>
                <h3>Zero Fee Unless We Win</h3>
                <p>Our contingency fee guarantee means you'll never pay a cent out of pocket. We only get paid when we recover compensation for you &mdash; period.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <h3>24/7 Availability</h3>
                <p>Accidents don't wait for business hours. Reach us any time &mdash; day, night, or weekend &mdash; for a free consultation about your car accident case.</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== RESULTS ===== -->
<section class="results-section">
    <div class="section-inner">
        <div class="section-eyebrow">Proven Results</div>
        <h2 class="section-title">Real Results for South Carolina Clients</h2>
        <p class="section-sub">Our track record speaks for itself. Here are just a few of the recoveries we've secured for car accident victims across South Carolina.</p>

        <div class="results-grid">
            <div class="result-card">
                <div class="result-type">Auto Accident</div>
                <div class="result-amount">$3,000,000</div>
                <div class="result-desc">Settlement &mdash; Multi-vehicle collision</div>
            </div>
            <div class="result-card">
                <div class="result-type">Truck Accident</div>
                <div class="result-amount">$27,000,000</div>
                <div class="result-desc">Settlement &mdash; Commercial truck crash</div>
            </div>
            <div class="result-card">
                <div class="result-type">Car Accident</div>
                <div class="result-amount">$1,850,000</div>
                <div class="result-desc">Verdict &mdash; Rear-end collision with TBI</div>
            </div>
            <div class="result-card">
                <div class="result-type">Hit and Run</div>
                <div class="result-amount">$975,000</div>
                <div class="result-desc">Settlement &mdash; Uninsured motorist claim</div>
            </div>
            <div class="result-card">
                <div class="result-type">Intersection Crash</div>
                <div class="result-amount">$2,100,000</div>
                <div class="result-desc">Settlement &mdash; T-bone collision injuries</div>
            </div>
            <div class="result-card">
                <div class="result-type">Rideshare Accident</div>
                <div class="result-amount">$650,000</div>
                <div class="result-desc">Settlement &mdash; Uber passenger injuries</div>
            </div>
        </div>
        <p class="results-disclaimer">*Results may vary depending on your particular facts and legal circumstances. Past results do not guarantee future outcomes.</p>
    </div>
</section>

<!-- ===== MID-PAGE CTA: After Results ===== -->
<section class="mid-page-cta">
    <div class="section-inner">
        <h2>Injured in a Car Accident? Get Your Free Case Review Now.</h2>
        <div class="cta-buttons">
            <a href="#leadForm" class="cta-btn-primary" aria-label="Scroll to free case review form">Get My Free Case Review &rarr;</a>
            <a href="tel:<?php echo esc_attr( $tel ); ?>" class="cta-btn-secondary" aria-label="Call Roden Law at <?php echo esc_attr( $phone ); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                Call Now: <?php echo esc_html( $phone ); ?>
            </a>
        </div>
        <p class="cta-subtext">Available 24/7 &middot; No upfront fees &middot; 100% confidential</p>
    </div>
</section>

<!-- ===== PROCESS ===== -->
<section class="process-section">
    <div class="section-inner">
        <div class="section-eyebrow" style="text-align:center;">How It Works</div>
        <h2 class="section-title" style="text-align:center;">Getting Started Is Simple</h2>
        <p class="section-sub" style="text-align:center; margin: 0 auto 48px;">From your free case review to getting paid, we handle the heavy lifting so you can focus on healing.</p>

        <div class="process-grid">
            <div class="process-step">
                <div class="step-number">1</div>
                <h3>Free Case Review</h3>
                <p>Call us or fill out the form above. We'll review your accident details and explain your options &mdash; no cost, no pressure.</p>
            </div>
            <div class="process-step">
                <div class="step-number">2</div>
                <h3>We Investigate</h3>
                <p>Our team gathers evidence, obtains police reports, interviews witnesses, and builds a rock-solid case on your behalf.</p>
            </div>
            <div class="process-step">
                <div class="step-number">3</div>
                <h3>We Fight for You</h3>
                <p>We negotiate aggressively with insurance companies. If they won't offer a fair settlement, we're prepared to go to trial.</p>
            </div>
            <div class="process-step">
                <div class="step-number">4</div>
                <h3>You Get Paid</h3>
                <p>Once your case is resolved, you receive your compensation. Remember &mdash; you owe us nothing unless we win.</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== WHAT TO DO AFTER AN ACCIDENT ===== -->
<section class="checklist-section">
    <div class="section-inner">
        <div class="checklist-layout">
            <div>
                <div class="section-eyebrow">After a South Carolina Car Accident</div>
                <h2 class="section-title">5 Things You Must Do After a South Carolina Car Accident</h2>
                <p class="section-sub">The steps you take immediately after a car accident in South Carolina can make or break your case. Follow this checklist to protect your rights.</p>
            </div>
            <div>
                <ol class="checklist-items">
                    <li>
                        <span class="check-num">1</span>
                        <div class="check-content">
                            <h3>Call 911 &amp; Report the Accident</h3>
                            <p>South Carolina law requires reporting accidents with injuries or significant property damage. A police report is critical evidence for your claim.</p>
                        </div>
                    </li>
                    <li>
                        <span class="check-num">2</span>
                        <div class="check-content">
                            <h3>Document Everything at the Scene</h3>
                            <p>Photograph vehicle damage, road conditions, traffic signs, and any visible injuries. Get names and contact info from all witnesses.</p>
                        </div>
                    </li>
                    <li>
                        <span class="check-num">3</span>
                        <div class="check-content">
                            <h3>Seek Medical Attention Immediately</h3>
                            <p>Even if you feel fine, some injuries take days to appear. Delayed treatment can hurt your claim &mdash; insurance companies will argue you weren't really hurt.</p>
                        </div>
                    </li>
                    <li>
                        <span class="check-num">4</span>
                        <div class="check-content">
                            <h3>Don't Talk to the Other Driver's Insurance</h3>
                            <p>Anything you say can be used to reduce your settlement. Politely decline and let your attorney handle all communication.</p>
                        </div>
                    </li>
                    <li>
                        <span class="check-num">5</span>
                        <div class="check-content">
                            <h3>Call Roden Law for a Free Case Review</h3>
                            <p>The sooner you have an attorney protecting your interests, the stronger your case. We'll handle the insurance companies so you can focus on healing.</p>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- ===== MID-PAGE CTA: After Checklist ===== -->
<section class="mid-page-cta">
    <div class="section-inner">
        <h2>Done With the Checklist? Let Us Handle the Rest.</h2>
        <div class="cta-buttons">
            <a href="#leadForm" class="cta-btn-primary" aria-label="Scroll to free case review form">Get My Free Case Review &rarr;</a>
            <a href="tel:<?php echo esc_attr( $tel ); ?>" class="cta-btn-secondary" aria-label="Call Roden Law at <?php echo esc_attr( $phone ); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                Call Now: <?php echo esc_html( $phone ); ?>
            </a>
        </div>
        <p class="cta-subtext">Available 24/7 &middot; No upfront fees &middot; 100% confidential</p>
    </div>
</section>

<!-- ===== 4 OFFICES ACROSS SOUTH CAROLINA ===== -->
<section class="offices-section">
    <div class="section-inner">
        <div class="section-eyebrow" style="text-align:center;">Statewide Presence</div>
        <h2 class="section-title" style="text-align:center;">4 Offices Serving All of South Carolina</h2>
        <p class="section-sub" style="text-align:center; margin: 0 auto 48px;">No matter where your accident happened in South Carolina, a Roden Law office is nearby and ready to fight for you.</p>

        <div class="offices-grid">
            <?php foreach ( $sc_offices as $ofc_key => $ofc ) : ?>
                <div class="office-card">
                    <div class="office-card-city">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <?php echo esc_html( $ofc['city'] ); ?>, <?php echo esc_html( $ofc['state'] ); ?>
                    </div>
                    <div class="office-card-detail">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5a6577" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        <?php echo esc_html( $ofc['address'] ); ?>, <?php echo esc_html( $ofc['city'] ); ?>, <?php echo esc_html( $ofc['state'] ); ?> <?php echo esc_html( $ofc['zip'] ); ?>
                    </div>
                    <div class="office-card-detail">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#5a6577" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $ofc['phone'] ) ); ?>" style="color:var(--navy);font-weight:700;"><?php echo esc_html( $ofc['phone'] ); ?></a>
                    </div>
                    <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $ofc['phone'] ) ); ?>" class="office-card-phone">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        Call <?php echo esc_html( $ofc['city'] ); ?>
                    </a>
                    <div class="office-card-service">
                        <strong>Serving:</strong> <?php echo esc_html( $ofc['service_area'] ); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== TESTIMONIALS ===== -->
<section class="testimonials-section">
    <div class="section-inner">
        <div class="section-eyebrow" style="text-align:center;">Client Stories</div>
        <h2 class="section-title" style="text-align:center;">What Our South Carolina Clients Say</h2>
        <p class="section-sub" style="text-align:center; margin: 0 auto 48px;">Hear from real South Carolina families we've helped after car accidents.</p>

        <?php
        // Try Trustindex widget (active on production). If plugin isn't installed,
        // do_shortcode returns the raw shortcode string — fall back to hardcoded cards.
        $ti_shortcode = '[trustindex data-widget-id="fe3ce9843b72815ccc26abe2c19"]';
        $ti_output    = do_shortcode( $ti_shortcode );
        if ( $ti_output !== $ti_shortcode ) :
            echo $ti_output;
        else :
        ?>
        <div class="testimonial-grid">
            <div class="testimonial-card">
                <div class="testimonial-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <p class="testimonial-text">&ldquo;After my car accident on I-26 near Charleston, I didn't know what to do. Roden Law took over everything &mdash; dealt with the insurance company, got my medical bills covered, and won me a settlement I never expected. They truly care about their clients.&rdquo;</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">D</div>
                    <div>
                        <div class="testimonial-name">David M.</div>
                        <div class="testimonial-location">Charleston, SC</div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <p class="testimonial-text">&ldquo;I was rear-ended by a distracted driver on I-20 and was overwhelmed by the process. From the very first call, Roden Law made me feel like a priority. They answered every question, kept me updated, and got me a great result. Highly recommend.&rdquo;</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">A</div>
                    <div>
                        <div class="testimonial-name">Ashley W.</div>
                        <div class="testimonial-location">Columbia, SC</div>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <p class="testimonial-text">&ldquo;The insurance company offered me next to nothing after a serious wreck on Highway 17. Roden Law fought for me and got a settlement that actually covered my medical bills and lost wages. I couldn't have done it without them.&rdquo;</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">R</div>
                    <div>
                        <div class="testimonial-name">Robert L.</div>
                        <div class="testimonial-location">Myrtle Beach, SC</div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ===== FAQ ===== -->
<section class="faq-section">
    <div class="section-inner">
        <div class="faq-layout">
            <div>
                <div class="section-eyebrow">FAQ</div>
                <h2 class="section-title">Questions About Your South Carolina Car Accident Case?</h2>
                <p class="section-sub">Get answers to the most common questions we hear from car accident victims across South Carolina.</p>
                <a href="#leadForm" class="cta-phone" style="font-size:16px; padding: 16px 32px; display: inline-flex;">Talk to a Lawyer Now &rarr;</a>
            </div>
            <div>
                <div class="faq-item open">
                    <div class="faq-question" tabindex="0" role="button" aria-expanded="true">How much does it cost to hire Roden Law?</div>
                    <div class="faq-answer">
                        <p>Nothing upfront. We work on a contingency fee basis, which means you pay zero out of pocket. Our fee comes from a percentage of your settlement or verdict &mdash; only if we win. If we don't recover money for you, you owe us nothing.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" tabindex="0" role="button" aria-expanded="false">How long do I have to file a car accident claim in South Carolina?</div>
                    <div class="faq-answer">
                        <p>South Carolina has a <?php echo esc_html( $sc_law['statute_years'] ); ?>-year statute of limitations for personal injury claims from the date of the accident (<?php echo esc_html( $sc_law['statute_cite'] ); ?>). However, waiting can hurt your case &mdash; evidence disappears, witnesses forget details, and the insurance company may use delay against you. Contact an attorney as soon as possible.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" tabindex="0" role="button" aria-expanded="false">What if I was partially at fault for the accident?</div>
                    <div class="faq-answer">
                        <p>Under South Carolina's modified comparative fault rule, you can still recover compensation as long as you were less than 51% at fault. Your award is reduced by your percentage of fault. For example, if you were 20% at fault and damages total $100,000, you could recover $80,000. Insurance companies often try to inflate your fault percentage &mdash; our attorneys fight back.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" tabindex="0" role="button" aria-expanded="false">What compensation can I receive after a car accident in South Carolina?</div>
                    <div class="faq-answer">
                        <p>You may be entitled to compensation for medical bills (past and future), lost wages and earning capacity, pain and suffering, property damage, and in some cases, punitive damages. The value depends on the severity of your injuries and the circumstances of the accident.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" tabindex="0" role="button" aria-expanded="false">What if the other driver doesn't have insurance?</div>
                    <div class="faq-answer">
                        <p>South Carolina requires drivers to carry minimum liability coverage, but not all drivers comply. You may still be able to recover compensation through your own uninsured/underinsured motorist (UM/UIM) coverage. Our attorneys will investigate every avenue to ensure you get the compensation you deserve.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" tabindex="0" role="button" aria-expanded="false">Should I talk to the other driver's insurance company?</div>
                    <div class="faq-answer">
                        <p>No. Insurance adjusters are trained to get you to say things that can reduce your claim. Before giving any recorded statement, talk to a Roden Law attorney first. We'll handle all communication with the insurance companies so you don't accidentally hurt your case.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== MID-PAGE CTA: After FAQ ===== -->
<section class="mid-page-cta">
    <div class="section-inner">
        <h2>Still Have Questions? Talk to a South Carolina Car Accident Lawyer.</h2>
        <div class="cta-buttons">
            <a href="#leadForm" class="cta-btn-primary" aria-label="Scroll to free case review form">Get My Free Case Review &rarr;</a>
            <a href="tel:<?php echo esc_attr( $tel ); ?>" class="cta-btn-secondary" aria-label="Call Roden Law at <?php echo esc_attr( $phone ); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                Call Now: <?php echo esc_html( $phone ); ?>
            </a>
        </div>
        <p class="cta-subtext">Available 24/7 &middot; No upfront fees &middot; 100% confidential</p>
    </div>
</section>

<!-- ===== BOTTOM CTA ===== -->
<section class="bottom-cta">
    <div class="section-inner">
        <h2>Don't Wait. South Carolina's 3-Year Deadline<br>Won't Wait for You.</h2>
        <p>Every day you wait could mean lost evidence and a weaker case. Get your free case review now.</p>
        <a href="tel:<?php echo esc_attr( $tel ); ?>" class="cta-phone">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <?php echo esc_html( $phone ); ?>
        </a>
        <div class="cta-or">or</div>
        <a href="#leadForm" class="cta-form-link">Fill Out the Free Case Review Form &uarr;</a>
    </div>
</section>

</main>
<!-- ===== FOOTER ===== -->
<footer class="lp-footer">
    <p>
        &copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( $firm['name'] ); ?>. All Rights Reserved. | Your Road to Results&trade;<br>
        Attorney advertising. Past results do not guarantee future outcomes. Each case is different and must be evaluated on its own merits. This website is not intended to create an attorney-client relationship. Contacting Roden Law does not create an attorney-client relationship.
    </p>
</footer>

<!-- ===== DESKTOP STICKY CTA ===== -->
<div class="desktop-sticky-cta" id="desktopStickyCta">
    <a href="#leadForm">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        Free Case Review
    </a>
</div>

<!-- ===== MOBILE DUAL CTA BAR (TOP) ===== -->
<div class="mobile-cta-bar" role="complementary" aria-label="Contact options">
    <div class="mobile-cta-bar-inner">
        <a href="tel:<?php echo esc_attr( $tel ); ?>" class="mobile-cta-call" aria-label="Call Roden Law at <?php echo esc_attr( $phone ); ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            Call Now
        </a>
        <a href="#leadForm" class="mobile-cta-review" aria-label="Get a free case review">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Free Review
        </a>
    </div>
</div>

<script>
    /* Form Tab Toggle — Full Review vs Quick Callback */
    (function() {
        var tabs = document.querySelectorAll('.form-tab');
        var fullFields = document.querySelectorAll('.full-fields');
        var emailInput = document.getElementById('lp-email');

        tabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                tabs.forEach(function(t) { t.classList.remove('active'); });
                this.classList.add('active');
                var mode = this.getAttribute('data-tab');

                if (mode === 'quick') {
                    fullFields.forEach(function(el) {
                        el.classList.remove('visible');
                        el.classList.add('hidden');
                    });
                    /* Remove required from hidden fields */
                    if (emailInput) emailInput.required = false;
                } else {
                    fullFields.forEach(function(el) {
                        el.classList.remove('hidden');
                        el.classList.add('visible');
                    });
                    if (emailInput) emailInput.required = true;
                }
            });
        });
    })();

    /* Auto-select Quick Callback tab when ?form=quick is in URL (for Google Ads) */
    (function() {
        if (new URLSearchParams(window.location.search).get('form') === 'quick') {
            var quickTab = document.querySelector('.form-tab[data-tab="quick"]');
            if (quickTab) quickTab.click();
        }
    })();

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

    /* Desktop sticky CTA — show after scrolling past hero, hide at bottom CTA */
    var stickyCta = document.getElementById('desktopStickyCta');
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

    /* Form submission → admin-ajax → GF entry */
    document.getElementById('leadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var form = this;
        var btn = form.querySelector('.form-submit');
        var errEl = form.querySelector('.form-error');
        var isQuick = document.querySelector('.form-tab[data-tab="quick"]').classList.contains('active');

        /* Validate phone */
        var phoneDigits = (lpPhone ? lpPhone.value : '').replace(/\D/g, '');
        if (phoneDigits.length !== 10) {
            errEl.textContent = 'Please enter a valid 10-digit phone number.';
            errEl.style.display = 'block';
            if (lpPhone) lpPhone.focus();
            return;
        }
        /* Validate email only in full mode */
        if (!isQuick) {
            var emailVal = lpEmail ? lpEmail.value.trim() : '';
            if (!/^[^\s@]+@[^\s@]+\.[a-zA-Z]{2,}$/.test(emailVal)) {
                errEl.textContent = 'Please enter a valid email address.';
                errEl.style.display = 'block';
                if (lpEmail) lpEmail.focus();
                return;
            }
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
                errEl.textContent = data.data || 'Something went wrong. Please call 844-RESULTS.';
                errEl.style.display = 'block';
                btn.disabled = false;
                btn.textContent = 'Get My Free Case Review \u2192';
            }
        })
        .catch(function(){
            errEl.textContent = 'Network error. Please call 844-RESULTS.';
            errEl.style.display = 'block';
            btn.disabled = false;
            btn.textContent = 'Get My Free Case Review \u2192';
        });
    });
</script>

<?php wp_footer(); ?>
<script type="text/javascript" src="//cdn.callrail.com/companies/481994887/9f5e5ebaf1d98d87a441/12/swap.js"></script>
</body>
</html>
