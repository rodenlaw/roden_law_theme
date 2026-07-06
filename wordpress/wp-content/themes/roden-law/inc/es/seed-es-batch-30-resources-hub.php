<?php
/**
 * ES Seeder — Batch 30: /es/resources/ hub page (Recursos Legales en Español).
 * Standalone page (EN counterpart is a CPT archive) linking the 9 Spanish
 * resources seeded in batches 25-29. Public /es/resources/{slug}/ URLs keep
 * the EN slug.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-30-resources-hub.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 30 — /es/resources/ HUB ═══' );

$es_root = roden_es_seed_root_page_id();
if ( ! $es_root ) {
    WP_CLI::error( 'ES root page (/es/) missing — run batch 01 first.' );
    return;
}

if ( ! get_posts( array( 'post_type' => 'page', 'name' => 'resources', 'post_parent' => $es_root, 'post_status' => array( 'publish', 'draft' ), 'numberposts' => 1 ) ) ) {
    $hub_id = wp_insert_post( array(
        'post_title'   => 'Recursos Legales en Español',
        'post_name'    => 'resources',
        'post_parent'  => $es_root,
        'post_type'    => 'page',
        'post_status'  => 'draft',
        'post_excerpt' => 'Guías legales en español sobre lesiones personales en Carolina del Sur: plazos para demandar, valor de su caso, compensación laboral y preguntas frecuentes.',
        'post_content' => <<<'HTML'
<p>Conocer sus derechos es el primer paso para proteger su caso. Estas guías, escritas en español por Roden Law, explican en lenguaje sencillo cómo funciona la ley de lesiones personales en Carolina del Sur: cuánto tiempo tiene para demandar, cómo la culpa compartida afecta su compensación, qué paga la compensación laboral y más. La consulta es siempre gratuita y en español — <a href="/es/contact/">contáctenos</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. No cobramos honorarios a menos que ganemos.</p>

<h2>Plazos y reglas legales</h2>
<ul>
<li><a href="/es/resources/south-carolina-statute-of-limitations/">Plazo Legal para Demandar en Carolina del Sur (Statute of Limitations)</a> — generalmente 3 años, con excepciones importantes.</li>
<li><a href="/es/resources/south-carolina-comparative-negligence/">Negligencia Comparativa en Carolina del Sur: La Regla del 51%</a> — cómo la culpa compartida reduce (o elimina) su compensación.</li>
</ul>

<h2>Valor de su caso</h2>
<ul>
<li><a href="/es/resources/south-carolina-car-accident-settlement-value/">¿Cuánto Vale un Caso de Accidente de Auto en Carolina del Sur?</a> — rangos ilustrativos y los factores que determinan el valor.</li>
<li><a href="/es/resources/south-carolina-um-uim-stacking/">Cobertura UM y UIM: Cómo Acumular ("Stacking") Pólizas</a> — qué hacer cuando el conductor culpable no tiene seguro suficiente.</li>
</ul>

<h2>Compensación laboral</h2>
<p>Si se lesionó en el trabajo, tiene derechos — sin importar su estatus migratorio.</p>
<ul>
<li><a href="/es/resources/how-much-does-south-carolina-workers-comp-pay/">¿Cuánto Paga la Compensación Laboral en Carolina del Sur?</a> — tasas, período de espera y duración de los beneficios.</li>
<li><a href="/es/resources/south-carolina-workers-comp-body-part-values/">Tabla de Valores por Parte del Cuerpo</a> — cuántas semanas de beneficios vale cada lesión bajo el S.C. Code § 42-9-30.</li>
<li><a href="/es/resources/south-carolina-workers-comp-impairment-rating-mmi/">MMI y Calificación de Deterioro</a> — cómo se calcula su compensación permanente.</li>
<li><a href="/es/resources/south-carolina-workers-comp-claim-denied/">Reclamo de Compensación Laboral Negado: Qué Hacer</a> — la escalera de apelación y sus plazos.</li>
</ul>

<h2>Preguntas frecuentes</h2>
<ul>
<li><a href="/es/resources/south-carolina-personal-injury-faq/">Preguntas Frecuentes sobre Lesiones Personales en Carolina del Sur</a> — respuestas a las preguntas más comunes sobre plazos, culpa, seguros, honorarios y estatus migratorio.</li>
</ul>

<p>¿No encuentra lo que busca? Vea nuestras <a href="/es/practice-areas/">áreas de práctica en español</a> o <a href="/es/contact/">contáctenos</a> — con gusto respondemos sus preguntas.</p>
HTML,
    ), true );
    if ( ! is_wp_error( $hub_id ) ) {
        update_post_meta( $hub_id, '_roden_locale', 'es' );
        update_post_meta( $hub_id, '_roden_meta_description', 'Guías legales en español de Roden Law: plazos para demandar en Carolina del Sur, valor de su caso, compensación laboral y preguntas frecuentes. Consulta gratuita.' );
        WP_CLI::success( "  Created ES hub «Recursos Legales en Español» (ID {$hub_id})" );
    } else {
        WP_CLI::warning( '  FAILED: ' . $hub_id->get_error_message() );
    }
} else {
    WP_CLI::log( '  SKIP — /es/resources/ hub exists' );
}

WP_CLI::log( '═══ BATCH 30 DONE ═══' );
