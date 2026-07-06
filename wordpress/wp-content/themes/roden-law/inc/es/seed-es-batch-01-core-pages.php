<?php
/**
 * ES Seeder — Batch 01: Core pages.
 * Creates (as drafts): /es/ root page, /es/practice-areas/ + /es/locations/
 * hub pages, /es/about/, /es/contact/, /es/gracias/.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-01-core-pages.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 01 — CORE PAGES ═══' );

/* 1. ES root page (/es/) ← EN front page. */
$front_id = (int) get_option( 'page_on_front' );
$es_root  = 0;
if ( $front_id ) {
    $es_root = roden_es_seed_translation( $front_id, array(
        'title'   => 'Abogados de Lesiones Personales en Georgia y Carolina del Sur',
        'slug'    => 'es',
        'excerpt' => 'Roden Law es un bufete de abogados de lesiones personales con 6 oficinas en Georgia y Carolina del Sur. Más de $300 millones recuperados. Consulta gratuita — sin honorarios a menos que ganemos.',
        'content' => <<<'HTML'
<h2>Luchamos por las víctimas de accidentes en Georgia y Carolina del Sur</h2>
<p>En Roden Law entendemos que un accidente puede cambiar su vida en un instante. Las facturas médicas se acumulan, no puede trabajar, y las aseguradoras le presionan para que acepte menos de lo que merece. Nuestros abogados de lesiones personales han recuperado <strong>más de $300 millones</strong> para nuestros clientes, y estamos listos para luchar por usted — en su idioma.</p>
<p><strong>No cobramos honorarios a menos que ganemos su caso.</strong> La consulta es gratuita y estamos disponibles las 24 horas: <a href="tel:+18447378587">1-844-RESULTS</a>.</p>

<h2>Áreas de práctica</h2>
<ul>
<li><a href="/es/practice-areas/car-accident-lawyers/">Abogados de accidentes de auto</a></li>
<li><a href="/es/practice-areas/truck-accident-lawyers/">Abogados de accidentes de camiones</a></li>
<li><a href="/es/practice-areas/workers-compensation-lawyers/">Abogados de compensación laboral</a></li>
<li><a href="/es/practice-areas/construction-accident-lawyers/">Abogados de accidentes de construcción</a></li>
<li><a href="/es/practice-areas/motorcycle-accident-lawyers/">Abogados de accidentes de motocicleta</a></li>
<li><a href="/es/practice-areas/wrongful-death-lawyers/">Abogados de muerte por negligencia</a></li>
<li><a href="/es/practice-areas/slip-and-fall-lawyers/">Abogados de accidentes por caídas</a></li>
<li><a href="/es/practice-areas/medical-malpractice-lawyers/">Abogados de negligencia médica</a></li>
<li><a href="/es/practice-areas/dog-bite-lawyers/">Abogados de mordeduras de perro</a></li>
<li><a href="/es/practice-areas/pedestrian-accident-lawyers/">Abogados de accidentes de peatones</a></li>
</ul>

<h2>6 oficinas para servirle</h2>
<p><strong>Georgia:</strong> <a href="/es/locations/georgia/savannah/">Savannah</a> · <a href="/es/locations/georgia/darien/">Darien</a><br>
<strong>Carolina del Sur:</strong> <a href="/es/locations/south-carolina/charleston/">Charleston</a> · <a href="/es/locations/south-carolina/north-charleston/">North Charleston</a> · <a href="/es/locations/south-carolina/columbia/">Columbia</a> · <a href="/es/locations/south-carolina/myrtle-beach/">Myrtle Beach</a></p>

<h2>¿Cuánto tiempo tengo para presentar mi demanda?</h2>
<p>En <strong>Georgia</strong>, generalmente tiene <strong>2 años</strong> desde la fecha del accidente (O.C.G.A. § 9-3-33). En <strong>Carolina del Sur</strong>, el plazo es de <strong>3 años</strong> (S.C. Code § 15-3-530). No espere — la evidencia desaparece y los plazos se vencen. <a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita en español.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de lesiones personales en Georgia y Carolina del Sur. Más de $300 millones recuperados. Hablamos español. Consulta gratuita: 1-844-RESULTS.',
        ),
    ) );
} else {
    WP_CLI::warning( 'No static front page set — skipping /es/ root.' );
}

if ( ! $es_root ) {
    WP_CLI::error( 'ES root page missing — cannot create child pages.' );
    return;
}

/* 2. Hub page /es/practice-areas/ (standalone — EN counterpart is an archive). */
if ( ! get_posts( array( 'post_type' => 'page', 'name' => 'practice-areas', 'post_parent' => $es_root, 'post_status' => array( 'publish', 'draft' ), 'numberposts' => 1 ) ) ) {
    $hub_id = wp_insert_post( array(
        'post_title'   => 'Áreas de Práctica',
        'post_name'    => 'practice-areas',
        'post_parent'  => $es_root,
        'post_type'    => 'page',
        'post_status'  => 'draft',
        'post_excerpt' => 'Todas las áreas de práctica de Roden Law en español: accidentes de auto, camiones, compensación laboral, y más.',
        'post_content' => <<<'HTML'
<p>Roden Law representa a víctimas de lesiones personales en todo Georgia y Carolina del Sur. Seleccione su tipo de caso para conocer sus derechos, los plazos legales y cómo podemos ayudarle. La consulta es gratuita y no cobramos honorarios a menos que ganemos.</p>
<ul>
<li><a href="/es/practice-areas/car-accident-lawyers/">Abogados de accidentes de auto</a></li>
<li><a href="/es/practice-areas/truck-accident-lawyers/">Abogados de accidentes de camiones</a></li>
<li><a href="/es/practice-areas/workers-compensation-lawyers/">Abogados de compensación laboral</a></li>
<li><a href="/es/practice-areas/construction-accident-lawyers/">Abogados de accidentes de construcción</a></li>
<li><a href="/es/practice-areas/motorcycle-accident-lawyers/">Abogados de accidentes de motocicleta</a></li>
<li><a href="/es/practice-areas/wrongful-death-lawyers/">Abogados de muerte por negligencia</a></li>
<li><a href="/es/practice-areas/slip-and-fall-lawyers/">Abogados de accidentes por caídas</a></li>
<li><a href="/es/practice-areas/medical-malpractice-lawyers/">Abogados de negligencia médica</a></li>
<li><a href="/es/practice-areas/dog-bite-lawyers/">Abogados de mordeduras de perro</a></li>
<li><a href="/es/practice-areas/pedestrian-accident-lawyers/">Abogados de accidentes de peatones</a></li>
</ul>
<p>¿No ve su tipo de caso? <a href="/es/contact/">Contáctenos</a> — manejamos todo tipo de casos de lesiones personales.</p>
HTML,
    ), true );
    if ( ! is_wp_error( $hub_id ) ) {
        update_post_meta( $hub_id, '_roden_locale', 'es' );
        update_post_meta( $hub_id, '_roden_meta_description', 'Áreas de práctica de Roden Law: accidentes de auto, camiones, compensación laboral, negligencia médica y más. Abogados que hablan español en Georgia y Carolina del Sur.' );
        WP_CLI::success( "  Created ES hub «Áreas de Práctica» (ID {$hub_id})" );
    }
} else {
    WP_CLI::log( '  SKIP — /es/practice-areas/ hub exists' );
}

/* 3. Hub page /es/locations/ (Oficinas). */
if ( ! get_posts( array( 'post_type' => 'page', 'name' => 'locations', 'post_parent' => $es_root, 'post_status' => array( 'publish', 'draft' ), 'numberposts' => 1 ) ) ) {
    $loc_hub = wp_insert_post( array(
        'post_title'   => 'Nuestras Oficinas',
        'post_name'    => 'locations',
        'post_parent'  => $es_root,
        'post_type'    => 'page',
        'post_status'  => 'draft',
        'post_excerpt' => '6 oficinas de Roden Law en Georgia y Carolina del Sur. Consulta gratuita en español.',
        'post_content' => <<<'HTML'
<p>Roden Law cuenta con 6 oficinas en Georgia y Carolina del Sur. Visítenos o llámenos — atendemos consultas en español las 24 horas.</p>
<h2>Georgia</h2>
<ul>
<li><a href="/es/locations/georgia/savannah/">Savannah</a> — 333 Commercial Dr., Savannah, GA 31406 — (912) 303-5850</li>
<li><a href="/es/locations/georgia/darien/">Darien</a> — 1108 North Way, Darien, GA 31305 — (912) 303-5850</li>
</ul>
<h2>Carolina del Sur</h2>
<ul>
<li><a href="/es/locations/south-carolina/charleston/">Charleston</a> — 127 King Street, Suite 200, Charleston, SC 29401 — (843) 790-8999</li>
<li><a href="/es/locations/south-carolina/north-charleston/">North Charleston</a> — 2703 Spruill Ave, North Charleston, SC 29405 — (843) 612-6561</li>
<li><a href="/es/locations/south-carolina/columbia/">Columbia</a> — 1545 Sumter St., Suite B, Columbia, SC 29201 — (803) 219-2816</li>
<li><a href="/es/locations/south-carolina/myrtle-beach/">Myrtle Beach</a> — 631 Bellamy Ave., Suite C-B, Murrells Inlet, SC 29576 — (843) 612-1980</li>
</ul>
HTML,
    ), true );
    if ( ! is_wp_error( $loc_hub ) ) {
        update_post_meta( $loc_hub, '_roden_locale', 'es' );
        update_post_meta( $loc_hub, '_roden_meta_description', 'Oficinas de Roden Law en Savannah, Darien, Charleston, North Charleston, Columbia y Myrtle Beach. Abogados de lesiones personales que hablan español.' );
        WP_CLI::success( "  Created ES hub «Nuestras Oficinas» (ID {$loc_hub})" );
    }
} else {
    WP_CLI::log( '  SKIP — /es/locations/ hub exists' );
}

/* 4. /es/about/ ← EN about. */
$about = get_page_by_path( 'about' );
if ( $about ) {
    roden_es_seed_translation( $about->ID, array(
        'title'   => 'Sobre Nosotros',
        'parent'  => $es_root,
        'excerpt' => 'Conozca a Roden Law: más de $300 millones recuperados, 62 años de experiencia combinada y 6 oficinas en Georgia y Carolina del Sur.',
        'content' => <<<'HTML'
<p>Roden Law es un bufete de abogados de lesiones personales fundado por Eric Roden y Tyler Love, con 6 oficinas en Georgia y Carolina del Sur. Nuestro equipo suma <strong>62 años de experiencia combinada</strong> y ha recuperado <strong>más de $300 millones</strong> para víctimas de accidentes.</p>
<h2>Por qué las familias hispanas confían en nosotros</h2>
<p>Sabemos que enfrentar el sistema legal en otro idioma es intimidante. Por eso ofrecemos consultas en español, mantenemos comunicación clara durante todo su caso, y peleamos para que las aseguradoras no se aprovechen de usted. Su estatus migratorio no le impide reclamar compensación por sus lesiones — y su consulta es siempre confidencial.</p>
<h2>Nuestro compromiso</h2>
<ul>
<li><strong>Sin honorarios a menos que ganemos.</strong> No paga nada por adelantado.</li>
<li><strong>Consulta gratuita, 24/7.</strong> Llame al 1-844-RESULTS cuando lo necesite.</li>
<li><strong>Resultados comprobados.</strong> Más de 5,000 casos manejados.</li>
</ul>
<p><a href="/es/contact/">Contáctenos hoy</a> para hablar con nuestro equipo.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Roden Law: abogados de lesiones personales con más de $300 millones recuperados y 6 oficinas en Georgia y Carolina del Sur. Hablamos español.',
        ),
    ) );
} else {
    WP_CLI::warning( 'EN /about/ page not found.' );
}

/* 5. /es/contact/ ← EN contact (template page-contact.php renders via gettext). */
$contact = get_page_by_path( 'contact' );
if ( $contact ) {
    roden_es_seed_translation( $contact->ID, array(
        'title'   => 'Contáctenos',
        'parent'  => $es_root,
        'excerpt' => 'Contacte a Roden Law para una consulta gratuita en español. Sin honorarios a menos que ganemos. Llame al 1-844-RESULTS.',
        'meta'    => array(
            '_roden_meta_description' => 'Contacte a los abogados de lesiones personales de Roden Law. Consulta gratuita en español, disponible 24/7. Oficinas en Georgia y Carolina del Sur.',
        ),
    ) );
} else {
    WP_CLI::warning( 'EN /contact/ page not found.' );
}

/* 6. /es/gracias/ ← EN thank-you (noindex; excluded from sitemap in functions.php). */
$thanks = get_page_by_path( 'thank-you' );
if ( $thanks ) {
    roden_es_seed_translation( $thanks->ID, array(
        'title'   => 'Gracias',
        'slug'    => 'gracias',
        'parent'  => $es_root,
        'content' => '<p><strong>¡Gracias por contactar a Roden Law!</strong></p><p>Hemos recibido su información y un miembro de nuestro equipo se comunicará con usted en breve. Si su asunto es urgente, llámenos ahora al <a href="tel:+18447378587">1-844-RESULTS</a> — atendemos las 24 horas, los 7 días de la semana.</p>',
        'meta'    => array(
            '_roden_meta_description' => 'Gracias por contactar a Roden Law. Nos comunicaremos con usted en breve.',
        ),
    ) );
} else {
    WP_CLI::warning( 'EN /thank-you/ page not found.' );
}

WP_CLI::log( '═══ BATCH 01 DONE ═══' );
