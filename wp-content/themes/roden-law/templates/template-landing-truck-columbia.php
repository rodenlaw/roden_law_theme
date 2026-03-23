<?php
/**
 * Template Name: Truck Accident Landing Page — Columbia
 *
 * Standalone PPC landing page template for truck accident campaigns.
 * Does NOT use get_header() / get_footer().
 * Outputs its own <!DOCTYPE html>, <head>, and all CSS/JS inline for page speed.
 * Designed for Google Ads traffic with noindex/nofollow for PPC isolation.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

$firm  = roden_firm_data();
$stats = $firm['trust_stats'];
$phone = $firm['vanity_phone'];
$tel   = $firm['phone_raw'];

// Dynamic city from Google Ads ?city= parameter. Falls back to page default.
$default_city = 'Columbia';
$city_raw     = isset( $_GET['city'] ) ? sanitize_text_field( wp_unslash( $_GET['city'] ) ) : '';
$city         = $city_raw ?: $default_city;
$city_is_custom = ! empty( $city_raw );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>
    <meta name="description" content="Injured in a truck accident in <?php echo esc_attr( $city ); ?>? Roden Law has recovered <?php echo esc_attr( $stats['recovered'] ); ?> for injury victims. Free case review. No fee unless we win. Call <?php echo esc_attr( $phone ); ?>.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* ===== RESET & BASE ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
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

        /* ===== STICKY MOBILE CTA BAR ===== */
        .mobile-cta-bar {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: var(--navy-deep);
            padding: 10px 16px;
            z-index: 1000;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.3);
        }
        .mobile-cta-bar a {
            display: block;
            background: var(--gold);
            color: var(--navy-deep);
            text-align: center;
            padding: 14px;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 16px;
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
            color: #c0cad8;
            line-height: 1.7;
            margin-bottom: 28px;
            max-width: 540px;
        }
        .hero-stats {
            display: flex;
            gap: 32px;
            margin-bottom: 0;
        }
        .hero-stat {
            text-align: left;
        }
        .hero-stat-number {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 28px;
            color: var(--gold);
            line-height: 1.2;
        }
        .hero-stat-label {
            font-size: 12px;
            color: #8899aa;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
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

        /* ===== NO-FEE BANNER ===== */
        .no-fee-banner {
            background: var(--gold);
            padding: 16px 0;
        }
        .no-fee-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 48px;
            flex-wrap: wrap;
        }
        .no-fee-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 15px;
            color: var(--navy-deep);
        }
        .no-fee-icon {
            width: 28px;
            height: 28px;
            background: var(--navy-deep);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
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

        /* ===== TRUCK NUANCES SECTION ===== */
        .nuances-section {
            padding: 80px 0;
            background: var(--white);
        }
        .nuances-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 36px;
            margin-top: 48px;
        }
        .nuance-card {
            background: var(--light-gray);
            border-radius: 16px;
            padding: 32px 28px;
            border-left: 4px solid var(--gold);
            transition: all 0.3s;
        }
        .nuance-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.06);
        }
        .nuance-card h3 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 17px;
            color: var(--navy);
            margin-bottom: 10px;
        }
        .nuance-card p {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.7;
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
        .results-section .section-sub { color: #8899aa; }
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
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .faq-item.open .faq-answer {
            max-height: 400px;
        }
        .faq-answer p {
            padding-top: 12px;
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.7;
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
            .nuances-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .mobile-cta-bar { display: block; }
            body { padding-bottom: 70px; }
            .top-bar-badge { display: none; }
            .top-bar-inner { justify-content: center; }
            .hero-inner { padding: 32px 16px 40px; }
            .hero h1 { font-size: 28px; }
            .hero-sub { font-size: 16px; }
            .hero-stats { gap: 20px; flex-wrap: wrap; }
            .hero-stat-number { font-size: 22px; }
            .hero-form-card { padding: 28px 20px; }
            .form-row { grid-template-columns: 1fr; }
            .no-fee-inner { gap: 20px; flex-direction: column; }
            .proof-bar-inner { gap: 24px; }
            .why-grid { grid-template-columns: 1fr; }
            .results-grid { grid-template-columns: 1fr; }
            .process-grid { grid-template-columns: 1fr; }
            .result-amount { font-size: 28px; }
        }
    </style>
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'landing-page landing-page-truck' ); ?>>

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

<!-- ===== HERO ===== -->
<section class="hero">
    <div class="hero-bg-image"></div>
    <div class="hero-inner">
        <div class="hero-content">
            <div class="hero-eyebrow">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <?php echo esc_html( $city ); ?> Truck Accident Attorneys
            </div>
            <h1>Hurt in a <?php echo esc_html( $city ); ?><br><span class="gold">Truck Accident?</span><br>You Deserve a Team That Fights Back.</h1>
            <?php if ( $city_is_custom ) : ?>
            <p class="hero-sub">Truck accidents cause catastrophic injuries &mdash; and trucking companies have armies of lawyers working to limit what they pay you. Roden Law&rsquo;s Columbia office has recovered over <?php echo esc_html( $stats['recovered'] ); ?> for injury victims across <?php echo esc_html( $city ); ?> and the Midlands, and we know how to take on the trucking industry.</p>
            <?php else : ?>
            <p class="hero-sub">Columbia&rsquo;s position at the intersection of I-20, I-26, and I-77 means heavy commercial truck traffic &mdash; and devastating accidents. Trucking companies deploy armies of lawyers to limit what they pay you. Roden Law&rsquo;s Columbia office has recovered over <?php echo esc_html( $stats['recovered'] ); ?> for injury victims across the Midlands, and we know how to take on the trucking industry.</p>
            <?php endif; ?>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-number"><?php echo esc_html( $stats['recovered'] ); ?></div>
                    <div class="hero-stat-label">Recovered</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number"><?php echo esc_html( $stats['cases'] ); ?></div>
                    <div class="hero-stat-label">Cases Won</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number"><?php echo esc_html( $stats['rating'] ); ?>&#9733;</div>
                    <div class="hero-stat-label">Client Rating</div>
                </div>
            </div>
        </div>

        <!-- FORM -->
        <div class="hero-form-card">
            <div class="form-urgency">&#9888; Evidence disappears fast after truck wrecks</div>
            <h2>Free Truck Accident Case Review</h2>
            <p class="form-subtitle">Find out what your case is worth &mdash; in minutes.</p>
            <form id="leadForm" action="#" method="POST" novalidate>
                <?php wp_nonce_field( 'roden_sidebar_form', 'roden_form_nonce' ); ?>
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" name="first_name" placeholder="First Name*" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="last_name" placeholder="Last Name*" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="tel" name="phone" id="lp-phone" placeholder="(555) 555-5555" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" id="lp-email" placeholder="Email Address*" pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}" required>
                    </div>
                </div>
                <div class="form-group">
                    <textarea name="message" placeholder="Please describe what happened (location, injuries, truck company if known)" rows="8"></textarea>
                </div>
                <label class="form-consent" style="display:flex;align-items:flex-start;gap:10px;margin-bottom:12px;cursor:pointer;">
                    <input type="checkbox" name="consent" value="1" checked required style="width:18px;height:18px;min-width:18px;margin-top:2px;accent-color:#f5a623;cursor:pointer;">
                    <span style="font-size:11px;color:#94a3b8;line-height:1.5;">I hereby expressly consent to receive automated communications including calls, texts, emails, and/or prerecorded messages. By submitting this form, you agree to our <a href="<?php echo esc_url( home_url( '/terms-privacy-policy/' ) ); ?>" target="_blank" style="color:#f5a623;text-decoration:underline;">Terms &amp; Privacy Policy</a>.</span>
                </label>
                <button type="submit" class="form-submit">Get My Free Case Review &rarr;</button>
                <p class="form-error" style="display:none;color:#ff6b6b;font-size:13px;text-align:center;margin-top:8px;"></p>
            </form>
            <div class="form-trust">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2ecc71" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                100% confidential. No obligation. No upfront fees &mdash; ever.
            </div>
        </div>
    </div>
</section>

<!-- ===== NO-FEE BANNER ===== -->
<div class="no-fee-banner">
    <div class="no-fee-inner">
        <div class="no-fee-item">
            <div class="no-fee-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            No Upfront Cost
        </div>
        <div class="no-fee-item">
            <div class="no-fee-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Free Case Evaluation
        </div>
        <div class="no-fee-item">
            <div class="no-fee-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            You Pay Nothing Unless We Win
        </div>
        <div class="no-fee-item">
            <div class="no-fee-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            Available 24/7
        </div>
    </div>
</div>

<!-- ===== WHY TRUCK ACCIDENTS ARE DIFFERENT ===== -->
<section class="nuances-section">
    <div class="section-inner">
        <div class="section-eyebrow">Why Truck Crashes Are Different</div>
        <h2 class="section-title">Truck Accident Cases Require a Different Legal Approach</h2>
        <p class="section-sub">Truck accident claims are far more complex than ordinary car accident cases. Multiple parties, federal regulations, and corporate defense teams create challenges that demand experienced trial attorneys.</p>

        <div class="nuances-grid">
            <div class="nuance-card">
                <h3>Multiple Liable Parties</h3>
                <p>Unlike car accidents, truck crashes can involve the driver, the trucking company, the cargo loader, the maintenance contractor, and even the truck or parts manufacturer. We investigate every party to maximize your recovery.</p>
            </div>
            <div class="nuance-card">
                <h3>Federal Motor Carrier Regulations</h3>
                <p>Commercial trucks are governed by strict FMCSA regulations covering hours of service, weight limits, driver qualifications, and vehicle maintenance. Violations of these federal rules are powerful evidence of negligence in your case.</p>
            </div>
            <div class="nuance-card">
                <h3>Severe &amp; Catastrophic Injuries</h3>
                <p>A fully loaded 18-wheeler can weigh 80,000 pounds &mdash; up to 20 times more than a passenger car. The physics of these collisions result in traumatic brain injuries, spinal cord damage, amputations, and fatalities at far higher rates.</p>
            </div>
            <div class="nuance-card">
                <h3>Rapid Evidence Destruction</h3>
                <p>Trucking companies routinely scrub electronic logging device (ELD) data, black box recordings, dashcam footage, and driver drug test results within days of a crash. Our team moves immediately to preserve this critical evidence.</p>
            </div>
            <div class="nuance-card">
                <h3>Corporate Defense Teams</h3>
                <p>Within hours of a serious crash, trucking companies dispatch rapid response teams &mdash; investigators, defense lawyers, and adjusters &mdash; all working to minimize the company's liability before you even hire an attorney.</p>
            </div>
            <div class="nuance-card">
                <h3>Higher Value Claims</h3>
                <p>Truck accident injuries are typically far more severe, resulting in larger medical bills, longer recovery periods, permanent disabilities, and greater lost earning capacity. These cases demand attorneys experienced in valuing catastrophic injury claims.</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== WHY CHOOSE RODEN LAW ===== -->
<section class="why-section">
    <div class="section-inner">
        <div class="section-eyebrow">Your Road to Results</div>
        <h2 class="section-title">Why Victims Choose Roden Law After a Truck Accident</h2>
        <p class="section-sub">Truck accident cases require a firm that understands FMCSA regulations, knows how to preserve evidence, and isn't intimidated by trucking company defense teams.</p>

        <div class="why-grid">
            <div class="why-card">
                <div class="why-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>We Take On Trucking Companies</h3>
                <p>Trucking corporations and their insurers fight hard to avoid paying fair compensation. Our attorneys have the resources and trial experience to go toe-to-toe with their defense teams and win.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <h3>Immediate Evidence Preservation</h3>
                <p>We issue spoliation letters within 24 hours to prevent trucking companies from destroying ELD data, black box recordings, driver logs, maintenance records, and dashcam footage.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3><?php echo esc_html( $stats['recovered'] ); ?> Recovered for Clients</h3>
                <p>Including a $27 million truck accident settlement. Our track record of results in complex commercial vehicle cases speaks for itself.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>FMCSA Regulatory Knowledge</h3>
                <p>We know the federal regulations that govern commercial trucking &mdash; hours of service, inspection requirements, weight limits, and hazmat protocols &mdash; and we use violations as evidence of negligence.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                </div>
                <h3>Zero Fee Unless We Win</h3>
                <p>Our contingency fee guarantee means you'll never pay a cent out of pocket. We invest our own resources into your case and only get paid when we recover compensation for you.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#e8a830" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <h3>24/7 Availability</h3>
                <p>Truck accidents don't wait for business hours. Reach us any time &mdash; day, night, or weekend &mdash; for a free consultation about your truck accident case.</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== RESULTS ===== -->
<section class="results-section">
    <div class="section-inner">
        <div class="section-eyebrow">Proven Results</div>
        <h2 class="section-title">Real Results in Truck Accident Cases</h2>
        <p class="section-sub">Our track record in commercial vehicle and truck accident cases demonstrates our ability to secure the compensation our clients deserve.</p>

        <div class="results-grid">
            <div class="result-card">
                <div class="result-type">Truck Accident</div>
                <div class="result-amount">$27,000,000</div>
                <div class="result-desc">Settlement &mdash; Commercial truck crash</div>
            </div>
            <div class="result-card">
                <div class="result-type">18-Wheeler Accident</div>
                <div class="result-amount">$4,500,000</div>
                <div class="result-desc">Settlement &mdash; Tractor-trailer rear-end collision</div>
            </div>
            <div class="result-card">
                <div class="result-type">Auto Accident</div>
                <div class="result-amount">$3,000,000</div>
                <div class="result-desc">Settlement &mdash; Multi-vehicle collision</div>
            </div>
            <div class="result-card">
                <div class="result-type">Truck Accident</div>
                <div class="result-amount">$2,100,000</div>
                <div class="result-desc">Settlement &mdash; Intersection collision with box truck</div>
            </div>
            <div class="result-card">
                <div class="result-type">Car Accident</div>
                <div class="result-amount">$1,850,000</div>
                <div class="result-desc">Verdict &mdash; Rear-end collision with TBI</div>
            </div>
            <div class="result-card">
                <div class="result-type">Wrongful Death</div>
                <div class="result-amount">$1,500,000</div>
                <div class="result-desc">Settlement &mdash; Fatal truck underride crash</div>
            </div>
            <div class="result-card">
                <div class="result-type">Hit and Run</div>
                <div class="result-amount">$975,000</div>
                <div class="result-desc">Settlement &mdash; Uninsured motorist claim</div>
            </div>
            <div class="result-card">
                <div class="result-type">Motorcycle Accident</div>
                <div class="result-amount">$1,200,000</div>
                <div class="result-desc">Settlement &mdash; Left-turn collision with TBI</div>
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
                <p>Call us or fill out the form above. We'll review your truck accident details, identify liable parties, and explain your legal options &mdash; no cost, no pressure.</p>
            </div>
            <div class="process-step">
                <div class="step-number">2</div>
                <h3>Preserve &amp; Investigate</h3>
                <p>We immediately issue evidence preservation letters and investigate the crash &mdash; obtaining trucking logs, ELD data, maintenance records, and black box data before it's destroyed.</p>
            </div>
            <div class="process-step">
                <div class="step-number">3</div>
                <h3>We Fight for You</h3>
                <p>We negotiate aggressively with the trucking company's insurers. If they refuse a fair settlement, we take them to trial &mdash; we've done it before and we'll do it again.</p>
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
        <p class="section-sub" style="text-align:center; margin: 0 auto 48px;">Hear from real families we've helped after devastating truck accidents.</p>

        <?php echo do_shortcode( '[trustindex data-widget-id="fe3ce9843b72815ccc26abe2c19"]' ); ?>
    </div>
</section>

<!-- ===== FAQ ===== -->
<section class="faq-section">
    <div class="section-inner">
        <div class="faq-layout">
            <div>
                <div class="section-eyebrow">FAQ</div>
                <h2 class="section-title">Questions About Your Truck Accident Case?</h2>
                <p class="section-sub">Get answers to the most common questions we hear from truck accident victims.</p>
                <a href="#leadForm" class="cta-phone" style="font-size:16px; padding: 16px 32px; display: inline-flex;">Talk to a Lawyer Now &rarr;</a>
            </div>
            <div>
                <div class="faq-item open">
                    <div class="faq-question">How is a truck accident case different from a car accident case?</div>
                    <div class="faq-answer">
                        <p>Truck accident cases are significantly more complex. They involve federal FMCSA regulations, multiple potentially liable parties (the driver, trucking company, cargo loader, maintenance provider, and manufacturer), larger insurance policies, and corporate defense teams. The injuries tend to be far more severe given the massive size and weight difference, and critical evidence like ELD data and driver logs can be destroyed quickly if not preserved.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">How much does it cost to hire Roden Law for a truck accident?</div>
                    <div class="faq-answer">
                        <p>Nothing upfront. We work on a contingency fee basis, which means you pay zero out of pocket. Our fee comes from a percentage of your settlement or verdict &mdash; only if we win. If we don't recover money for you, you owe us nothing. Given the complexity and expense of truck accident litigation, this is especially important &mdash; we invest our own resources into building your case.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">How long do I have to file a truck accident claim?</div>
                    <div class="faq-answer">
                        <p>South Carolina has a 3-year statute of limitations for personal injury claims (S.C. Code &sect; 15-3-530). However, with truck accidents, time is especially critical because trucking companies may legally destroy driver logs, ELD data, and maintenance records after a set period. We recommend contacting an attorney within days &mdash; not months &mdash; of the crash.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Who can be held liable in a truck accident?</div>
                    <div class="faq-answer">
                        <p>Multiple parties can share liability: the truck driver (for fatigue, distraction, or impairment), the trucking company (for negligent hiring, pressure to violate hours-of-service rules, or inadequate training), the cargo loader (for improperly securing freight), the maintenance company (for failing to properly inspect or repair the truck), and the truck or parts manufacturer (for defective brakes, tires, or other components). Our team investigates all potential sources of recovery.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">What compensation can I receive after a truck accident?</div>
                    <div class="faq-answer">
                        <p>Truck accident victims may recover compensation for medical bills (past and future, including surgeries, rehabilitation, and long-term care), lost wages and diminished earning capacity, pain and suffering, emotional distress, loss of enjoyment of life, property damage, and in cases of egregious conduct like falsified driver logs, punitive damages. Because injuries are often catastrophic, these claims frequently reach into the millions.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">What should I do immediately after a truck accident?</div>
                    <div class="faq-answer">
                        <p>First, seek medical attention even if you feel okay &mdash; truck accident injuries like internal bleeding and traumatic brain injuries can have delayed symptoms. Call 911 to file a police report. If possible, photograph the scene, the truck, any DOT numbers or company names on the truck, and your injuries. Do not give a recorded statement to any insurance company. Contact a truck accident attorney as soon as possible &mdash; we need to send an evidence preservation letter before the trucking company destroys critical data.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">What are hours-of-service violations and why do they matter?</div>
                    <div class="faq-answer">
                        <p>Federal FMCSA regulations strictly limit how long a truck driver can operate without rest &mdash; generally 11 hours of driving within a 14-hour window, followed by 10 consecutive hours off duty. Hours-of-service violations are a leading cause of truck accidents because fatigued driving is as dangerous as drunk driving. If a driver or trucking company violated these rules, it is strong evidence of negligence and can significantly increase the value of your claim.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== BOTTOM CTA ===== -->
<section class="bottom-cta">
    <div class="section-inner">
        <h2>Don't Wait. Trucking Companies Are<br>Already Building Their Defense.</h2>
        <p>Every day you wait, critical evidence like black box data and driver logs can be destroyed. Get your free case review now.</p>
        <a href="tel:<?php echo esc_attr( $tel ); ?>" class="cta-phone">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <?php echo esc_html( $phone ); ?>
        </a>
        <div class="cta-or">or</div>
        <a href="#leadForm" class="cta-form-link">Fill Out the Free Case Review Form &uarr;</a>
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="lp-footer">
    <p>
        &copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( $firm['name'] ); ?>. All Rights Reserved. | Your Road to Results&trade;<br>
        Attorney advertising. Past results do not guarantee future outcomes. Each case is different and must be evaluated on its own merits. This website is not intended to create an attorney-client relationship. Contacting Roden Law does not create an attorney-client relationship.
    </p>
</footer>

<!-- ===== MOBILE CTA BAR ===== -->
<div class="mobile-cta-bar">
    <a href="tel:<?php echo esc_attr( $tel ); ?>">&#128222; Call Now &mdash; Free Case Review</a>
</div>

<script>
    /* FAQ Toggle */
    document.querySelectorAll('.faq-question').forEach(function(question) {
        question.addEventListener('click', function() {
            var item = this.parentElement;
            var allItems = document.querySelectorAll('.faq-item');
            allItems.forEach(function(i) {
                if (i !== item) i.classList.remove('open');
            });
            item.classList.toggle('open');
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
