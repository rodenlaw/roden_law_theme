<?php
/**
 * ES Seeder — Batch 21: update the /es/practice-areas/ hub with all 22 pillars.
 * Idempotent: overwrites the hub page content with the canonical full list.
 *
 * Run: echo "<?php include '.../es-seed-lib.php'; include '.../seed-es-batch-21-hub-update.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 21 — PRACTICE AREAS HUB UPDATE (22 pillars) ═══' );

$es_root = roden_es_seed_root_page_id();
if ( ! $es_root ) {
    WP_CLI::error( 'ES root page missing.' );
    return;
}

$hub = get_posts( array(
    'post_type'   => 'page',
    'name'        => 'practice-areas',
    'post_parent' => $es_root,
    'post_status' => array( 'publish', 'draft' ),
    'numberposts' => 1,
) );
if ( ! $hub ) {
    WP_CLI::error( '/es/practice-areas/ hub page not found — run batch 01 first.' );
    return;
}

$content = <<<'HTML'
<p>Roden Law representa a víctimas de lesiones personales en todo Georgia y Carolina del Sur. Seleccione su tipo de caso para conocer sus derechos, los plazos legales y cómo podemos ayudarle. La consulta es gratuita y no cobramos honorarios a menos que ganemos.</p>

<h2>Accidentes de tránsito</h2>
<ul>
<li><a href="/es/practice-areas/car-accident-lawyers/">Abogados de Accidentes de Auto</a></li>
<li><a href="/es/practice-areas/truck-accident-lawyers/">Abogados de Accidentes de Camiones</a></li>
<li><a href="/es/practice-areas/motorcycle-accident-lawyers/">Abogados de Accidentes de Motocicleta</a></li>
<li><a href="/es/practice-areas/pedestrian-accident-lawyers/">Abogados de Accidentes de Peatones</a></li>
<li><a href="/es/practice-areas/bicycle-accident-lawyers/">Abogados de Accidentes de Bicicleta</a></li>
<li><a href="/es/practice-areas/electric-scooter-accident-lawyers/">Abogados de Accidentes de Scooter Eléctrico</a></li>
<li><a href="/es/practice-areas/atv-side-by-side-accident-lawyers/">Abogados de Accidentes de ATV y Side-by-Side</a></li>
<li><a href="/es/practice-areas/golf-cart-accident-lawyers/">Abogados de Accidentes de Carritos de Golf</a></li>
</ul>

<h2>Lesiones en el trabajo</h2>
<ul>
<li><a href="/es/practice-areas/workers-compensation-lawyers/">Abogados de Compensación Laboral</a></li>
<li><a href="/es/practice-areas/construction-accident-lawyers/">Abogados de Accidentes de Construcción</a></li>
<li><a href="/es/practice-areas/maritime-injury-lawyers/">Abogados de Lesiones Marítimas</a></li>
</ul>

<h2>Lesiones graves y negligencia</h2>
<ul>
<li><a href="/es/practice-areas/medical-malpractice-lawyers/">Abogados de Negligencia Médica</a></li>
<li><a href="/es/practice-areas/wrongful-death-lawyers/">Abogados de Muerte por Negligencia</a></li>
<li><a href="/es/practice-areas/brain-injury-lawyers/">Abogados de Lesiones Cerebrales</a></li>
<li><a href="/es/practice-areas/spinal-cord-injury-lawyers/">Abogados de Lesiones de la Médula Espinal</a></li>
<li><a href="/es/practice-areas/burn-injury-lawyers/">Abogados de Quemaduras</a></li>
<li><a href="/es/practice-areas/nursing-home-abuse-lawyers/">Abogados de Abuso en Hogares de Ancianos</a></li>
</ul>

<h2>Responsabilidad de propiedades y productos</h2>
<ul>
<li><a href="/es/practice-areas/slip-and-fall-lawyers/">Abogados de Accidentes por Caídas</a></li>
<li><a href="/es/practice-areas/premises-liability-lawyers/">Abogados de Responsabilidad de Locales</a></li>
<li><a href="/es/practice-areas/product-liability-lawyers/">Abogados de Responsabilidad de Productos</a></li>
<li><a href="/es/practice-areas/dog-bite-lawyers/">Abogados de Mordeduras de Perro</a></li>
<li><a href="/es/practice-areas/boating-accident-lawyers/">Abogados de Accidentes de Navegación</a></li>
</ul>

<p>¿No ve su tipo de caso? <a href="/es/contact/">Contáctenos</a> — manejamos todo tipo de casos de lesiones personales. Llame al <a href="tel:+18447378587">1-844-RESULTS</a>, atendemos en español las 24 horas.</p>
HTML;

$result = wp_update_post( array(
    'ID'           => $hub[0]->ID,
    'post_content' => $content,
), true );

if ( is_wp_error( $result ) ) {
    WP_CLI::warning( 'Hub update failed: ' . $result->get_error_message() );
} else {
    WP_CLI::success( "Hub page (ID {$hub[0]->ID}) updated with all 22 pillars." );
}

WP_CLI::log( '═══ BATCH 21 DONE ═══' );
