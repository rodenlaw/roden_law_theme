<?php
/**
 * Template Name: Landing Page — GA Car Accident
 *
 * Georgia car accident PPC landing page — does NOT use get_header() / get_footer().
 * Outputs its own <!DOCTYPE html>, <head>, and all CSS/JS inline for page speed.
 * Designed for Google Ads traffic with noindex/nofollow for PPC isolation.
 *
 * Supports ?city= parameter for dynamic city insertion from Google Ads.
 * Default city: Savannah. Georgia offices: Savannah, Darien.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$firm  = roden_firm_data();
$stats = $firm['trust_stats'];
$ga_law = $firm['jurisdiction']['GA'];
$phone = '1-844-RESULTS';
$tel   = '18447378587';

// Dynamic city from Google Ads ?city= parameter. Falls back to Georgia default.
$default_city = 'Georgia';
$city_raw     = isset( $_GET['city'] ) ? sanitize_text_field( wp_unslash( $_GET['city'] ) ) : '';
// Fall back to default if empty or if Google Ads macro wasn't replaced.
$city         = ( $city_raw && strpos( $city_raw, '{' ) === false ) ? $city_raw : $default_city;

// Use "in Georgia" or "in [City]" depending on whether we have a specific city.
$in_location  = 'in ' . $city;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo esc_html( $city ); ?> Car Accident Lawyer | Roden Law</title>
    <meta name="description" content="Injured in a car accident <?php echo esc_attr( $in_location ); ?>? Roden Law has recovered <?php echo esc_attr( $stats['recovered'] ); ?> for injury victims. Free case review. No fee unless we win. Call <?php echo esc_attr( $phone ); ?>.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
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

        /* ===== STICKY MOBILE CALL BAR (TOP) ===== */
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
            margin-bottom: 28px;
            max-width: 540px;
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

        /* ===== GA LAW CALLOUT ===== */
        .ga-law-section {
            padding: 60px 0;
            background: var(--white);
        }
        .ga-law-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
        }
        .ga-law-card {
            background: var(--light-gray);
            border-radius: 16px;
            padding: 36px 32px;
            border-left: 4px solid var(--gold);
        }
        .ga-law-card h3 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 18px;
            color: var(--navy);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .ga-law-card .law-value {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 28px;
            color: var(--gold);
            margin-bottom: 8px;
        }
        .ga-law-card p {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.7;
        }
        .ga-law-card .cite {
            font-size: 13px;
            color: #8899aa;
            font-style: italic;
            margin-top: 8px;
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

        /* ===== OFFICES ===== */
        .offices-section {
            padding: 60px 0;
            background: var(--light-gray);
        }
        .offices-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
        }
        .office-card {
            background: var(--white);
            border-radius: 16px;
            padding: 32px 28px;
            border: 1px solid #edf2f7;
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }
        .office-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, var(--gold-light), #fef9ef);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .office-card h3 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 17px;
            color: var(--navy);
            margin-bottom: 4px;
        }
        .office-card .office-addr {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 8px;
        }
        .office-card .office-phone a {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 15px;
            color: var(--gold);
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
            .ga-law-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .mobile-cta-bar { display: block; }
            body { padding-top: 56px; }
            .top-bar-badge { display: none; }
            .top-bar-inner { justify-content: center; }
            .hero-inner { padding: 32px 16px 40px; }
            .hero h1 { font-size: 28px; }
            .hero-sub { font-size: 16px; }
            .accident-types { grid-template-columns: repeat(2, 1fr); gap: 8px; }
            .accident-type-item { padding: 10px 6px; }
            .accident-type-label { font-size: 10px; }
            .hero-form-card { padding: 28px 20px; }
            .form-row { grid-template-columns: 1fr; }
            .no-fee-inner { gap: 8px; justify-content: center; }
            .no-fee-item { font-size: 13px; }
            .no-fee-sep { display: none; }
            .proof-bar-inner { gap: 24px; }
            .why-grid { grid-template-columns: 1fr; }
            .results-grid { grid-template-columns: 1fr; }
            .process-grid { grid-template-columns: 1fr; }
            .result-amount { font-size: 28px; }
            .offices-grid { grid-template-columns: 1fr; }
        }
    </style>
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
                Trusted Georgia Trial Attorneys
            </div>
            <h1><?php echo esc_html( $city ); ?> <span class="gold">Car Accident Lawyer</span></h1>
            <p class="hero-sub">Don't let insurance companies shortchange you. Roden Law has recovered over <?php echo esc_html( $stats['recovered'] ); ?> for injury victims across Georgia &mdash; and we don't charge a fee unless we win your case.</p>
            <div class="accident-types">
                <div class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><rect x="1" y="12" width="9" height="6" rx="1"/><rect x="14" y="12" width="9" height="6" rx="1"/><line x1="10" y1="15" x2="14" y2="15"/><circle cx="4" cy="18" r="1.5" fill="#e8a830" stroke="none"/><circle cx="20" cy="18" r="1.5" fill="#e8a830" stroke="none"/></svg>
                    <span class="accident-type-label">Rear-End Collision</span>
                </div>
                <div class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><rect x="2" y="10" width="10" height="6" rx="1"/><rect x="14" y="4" width="6" height="10" rx="1" transform="rotate(0)"/><line x1="12" y1="13" x2="14" y2="13"/><path d="M11 12l3-3" stroke="#e8a830" stroke-width="1" opacity="0.5"/></svg>
                    <span class="accident-type-label">T-Bone / Side Impact</span>
                </div>
                <div class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><rect x="2" y="12" width="9" height="5" rx="1"/><circle cx="5" cy="17" r="1.5" fill="#e8a830" stroke="none"/><path d="M11 14.5l2-2M13 14.5l2-2" opacity="0.6"/><path d="M16 9l2 2M20 9l-2 2M18 7v4" stroke-width="1.5"/></svg>
                    <span class="accident-type-label">Hit &amp; Run</span>
                </div>
                <div class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><rect x="2" y="13" width="11" height="5" rx="1"/><circle cx="5" cy="18" r="1.5" fill="#e8a830" stroke="none"/><circle cx="10" cy="18" r="1.5" fill="#e8a830" stroke="none"/><path d="M15 11l1.5-5.5M18 11l-1.5-5.5M16.5 5.5h0" stroke-linecap="round"/><path d="M14 8h5" stroke-linecap="round"/></svg>
                    <span class="accident-type-label">Drunk Driver</span>
                </div>
                <div class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><rect x="2" y="13" width="11" height="5" rx="1"/><circle cx="5" cy="18" r="1.5" fill="#e8a830" stroke="none"/><circle cx="10" cy="18" r="1.5" fill="#e8a830" stroke="none"/><rect x="15" y="5" width="6" height="10" rx="1"/><line x1="18" y1="8" x2="18" y2="12" stroke-linecap="round"/></svg>
                    <span class="accident-type-label">Distracted Driver</span>
                </div>
                <div class="accident-type-item">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="1.5"><rect x="3" y="12" width="12" height="6" rx="1"/><circle cx="6" cy="18" r="1.5" fill="#e8a830" stroke="none"/><circle cx="12" cy="18" r="1.5" fill="#e8a830" stroke="none"/><circle cx="20" cy="10" r="4"/><path d="M18.5 9.5l1.5 1 1.5-1" stroke-linecap="round"/></svg>
                    <span class="accident-type-label">Uber / Lyft</span>
                </div>
            </div>
        </div>

        <!-- FORM -->
        <div class="hero-form-card">
            <div class="form-urgency">&#9201; Georgia has a 2-year filing deadline</div>
            <h2>Free Case Review</h2>
            <p class="form-subtitle">Find out what your case is worth &mdash; in minutes.</p>
            <form id="leadForm" action="#" method="POST" novalidate>
                <?php wp_nonce_field( 'roden_sidebar_form', 'roden_form_nonce' ); ?>
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
                    <div class="form-group">
                        <label for="lp-email" class="sr-only">Email Address</label>
                        <input type="email" name="email" id="lp-email" placeholder="Email Address*" autocomplete="email" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lp-message" class="sr-only">Describe what happened</label>
                    <textarea name="message" id="lp-message" placeholder="Please describe what happened" rows="4"></textarea>
                </div>
                <label class="form-consent" style="display:flex;align-items:flex-start;gap:10px;margin-bottom:12px;cursor:pointer;">
                    <input type="checkbox" name="consent" value="1" checked required style="width:18px;height:18px;min-width:18px;margin-top:2px;accent-color:#f5a623;cursor:pointer;">
                    <span style="font-size:12px;color:#64748b;line-height:1.5;">I hereby expressly consent to receive automated communications including calls, texts, emails, and/or prerecorded messages. By submitting this form, you agree to our <a href="<?php echo esc_url( home_url( '/terms-privacy-policy/' ) ); ?>" target="_blank" style="color:#f5a623;text-decoration:underline;">Terms &amp; Privacy Policy</a>.</span>
                </label>
                <button type="submit" class="form-submit">Get My Free Case Review &rarr;</button>
                <p class="form-error" role="alert" aria-live="assertive" style="display:none;color:#ff6b6b;font-size:13px;text-align:center;margin-top:8px;"></p>
            </form>
            <div class="form-trust">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2ecc71" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                100% confidential. No obligation. No upfront fees &mdash; ever.
            </div>
            <div style="text-align:center;margin-top:16px;font-size:14px;color:var(--text-muted);">
                or call now: <a href="tel:<?php echo esc_attr( $tel ); ?>" style="color:var(--navy);font-family:'Montserrat',sans-serif;font-weight:800;font-size:16px;"><?php echo esc_html( $phone ); ?></a>
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

<!-- ===== GEORGIA LAW CALLOUT ===== -->
<section class="ga-law-section">
    <div class="section-inner">
        <div class="section-eyebrow">Georgia Law</div>
        <h2 class="section-title">Critical Deadlines &amp; Rules for Georgia Car Accidents</h2>
        <p class="section-sub">Understanding Georgia's personal injury laws can make or break your case. Here's what every accident victim needs to know.</p>

        <div class="ga-law-grid">
            <div class="ga-law-card">
                <h3>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    Statute of Limitations
                </h3>
                <div class="law-value"><?php echo esc_html( $ga_law['statute_years'] ); ?> Years</div>
                <p>In Georgia, you have just <?php echo esc_html( $ga_law['statute_years'] ); ?> years from the date of your car accident to file a personal injury lawsuit. Miss this deadline and you lose your right to compensation &mdash; permanently.</p>
                <p class="cite"><?php echo esc_html( $ga_law['statute_cite'] ); ?></p>
            </div>
            <div class="ga-law-card">
                <h3>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Comparative Fault Rule
                </h3>
                <div class="law-value">&lt; 50% at Fault</div>
                <p>Georgia follows a modified comparative fault rule. You can recover damages as long as you are less than 50% responsible for the accident. Your compensation is reduced by your percentage of fault.</p>
                <p class="cite"><?php echo esc_html( $ga_law['comp_fault_cite'] ); ?></p>
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
                <p>Unlike the big national firms, you work directly with experienced Georgia attorneys who know local courts, judges, and opposing counsel.</p>
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
        <h2 class="section-title">Real Results for Real People</h2>
        <p class="section-sub">Our track record speaks for itself. Here are just a few of the recoveries we've secured for car accident victims <?php echo esc_html( $in_location ); ?>.</p>

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

<!-- ===== TESTIMONIALS — Google Reviews via Trustindex ===== -->
<section class="testimonials-section">
    <div class="section-inner">
        <div class="section-eyebrow" style="text-align:center;">Client Stories</div>
        <h2 class="section-title" style="text-align:center;">What Our Clients Say</h2>
        <p class="section-sub" style="text-align:center; margin: 0 auto 48px;">Hear from real Georgia families we've helped after car accidents.</p>

        <?php echo do_shortcode( '[trustindex data-widget-id="fe3ce9843b72815ccc26abe2c19"]' ); ?>
    </div>
</section>

<!-- ===== FAQ ===== -->
<section class="faq-section">
    <div class="section-inner">
        <div class="faq-layout">
            <div>
                <div class="section-eyebrow">FAQ</div>
                <h2 class="section-title">Questions About Your Georgia Car Accident Case?</h2>
                <p class="section-sub">Get answers to the most common questions we hear from car accident victims <?php echo esc_html( $in_location ); ?>.</p>
                <a href="#leadForm" class="cta-phone" style="font-size:16px; padding: 16px 32px; display: inline-flex;">Talk to a Lawyer Now &rarr;</a>
            </div>
            <div>
                <div class="faq-item open">
                    <div class="faq-question" tabindex="0" role="button">How much does it cost to hire Roden Law?</div>
                    <div class="faq-answer">
                        <p>Nothing upfront. We work on a contingency fee basis, which means you pay zero out of pocket. Our fee comes from a percentage of your settlement or verdict &mdash; only if we win. If we don't recover money for you, you owe us nothing.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" tabindex="0" role="button">How long do I have to file a car accident claim in Georgia?</div>
                    <div class="faq-answer">
                        <p>Georgia has a <?php echo esc_html( $ga_law['statute_years'] ); ?>-year statute of limitations for personal injury claims from the date of the accident (<?php echo esc_html( $ga_law['statute_cite'] ); ?>). This is shorter than many states, so acting quickly is critical. Evidence disappears, witnesses forget details, and the insurance company may use delay against you. Contact an attorney as soon as possible.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" tabindex="0" role="button">What if I was partially at fault for the accident?</div>
                    <div class="faq-answer">
                        <p>Under Georgia's modified comparative fault law (<?php echo esc_html( $ga_law['comp_fault_cite'] ); ?>), you can still recover compensation as long as you were less than 50% at fault. Your award is reduced by your percentage of fault. For example, if you were 20% at fault and damages total $100,000, you could recover $80,000. Insurance companies often try to inflate your fault percentage &mdash; our attorneys fight back.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" tabindex="0" role="button">What compensation can I receive after a car accident in Georgia?</div>
                    <div class="faq-answer">
                        <p>You may be entitled to compensation for medical bills (past and future), lost wages and earning capacity, pain and suffering, property damage, and in some cases, punitive damages. Georgia does not cap compensatory damages in most personal injury cases, so the value depends on the severity of your injuries and the circumstances of the accident.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" tabindex="0" role="button">What if the other driver doesn't have insurance?</div>
                    <div class="faq-answer">
                        <p>Georgia requires drivers to carry minimum liability coverage, but not all drivers comply. You may still be able to recover compensation through your own uninsured/underinsured motorist (UM/UIM) coverage. Our attorneys will investigate every avenue to ensure you get the compensation you deserve.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" tabindex="0" role="button">Should I talk to the other driver's insurance company?</div>
                    <div class="faq-answer">
                        <p>No. Insurance adjusters are trained to get you to say things that can reduce your claim. Before giving any recorded statement, talk to a Roden Law attorney first. We'll handle all communication with the insurance companies so you don't accidentally hurt your case.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== GEORGIA OFFICES ===== -->
<section class="offices-section">
    <div class="section-inner">
        <div class="section-eyebrow" style="text-align:center;">Our Georgia Offices</div>
        <h2 class="section-title" style="text-align:center;">Serving Accident Victims Across Georgia</h2>
        <p class="section-sub" style="text-align:center; margin: 0 auto 48px;">With two offices in Southeast Georgia, our attorneys are close to home and ready to fight for you.</p>

        <div class="offices-grid">
            <?php
            $ga_offices = array( 'savannah', 'darien' );
            foreach ( $ga_offices as $key ) :
                $office = $firm['offices'][ $key ];
            ?>
            <div class="office-card">
                <div class="office-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div>
                    <h3><?php echo esc_html( $office['name'] ); ?></h3>
                    <p class="office-addr">
                        <?php echo esc_html( $office['address'] ); ?><br>
                        <?php echo esc_html( $office['city'] . ', ' . $office['state'] . ' ' . $office['zip'] ); ?>
                    </p>
                    <div class="office-phone">
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9]/', '', $office['phone'] ) ); ?>"><?php echo esc_html( $office['phone'] ); ?></a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== BOTTOM CTA ===== -->
<section class="bottom-cta">
    <div class="section-inner">
        <h2>Don't Wait. Georgia's 2-Year Deadline<br>Won't Wait for You.</h2>
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

<!-- ===== MOBILE CALL BAR (TOP) ===== -->
<div class="mobile-cta-bar" role="complementary" aria-label="Call now">
    <a href="tel:<?php echo esc_attr( $tel ); ?>" aria-label="Call Roden Law at <?php echo esc_attr( $phone ); ?>">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        Call Now &mdash; <?php echo esc_html( $phone ); ?>
    </a>
</div>

<script>
    /* FAQ Toggle */
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
                errEl.textContent = data.data || 'Something went wrong. Please call 1-844-RESULTS.';
                errEl.style.display = 'block';
                btn.disabled = false;
                btn.textContent = 'Get My Free Case Review \u2192';
            }
        })
        .catch(function(){
            errEl.textContent = 'Network error. Please call 1-844-RESULTS.';
            errEl.style.display = 'block';
            btn.disabled = false;
            btn.textContent = 'Get My Free Case Review \u2192';
        });
    });
</script>

<?php wp_footer(); ?>
</body>
</html>
