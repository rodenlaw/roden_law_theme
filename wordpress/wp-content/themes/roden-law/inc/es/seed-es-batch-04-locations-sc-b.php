<?php
/**
 * ES Seeder — Batch 04: South Carolina location pages B (Columbia, Myrtle Beach).
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-04-locations-sc-b.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 04 — LOCATIONS SC-B (COLUMBIA, MYRTLE BEACH) ═══' );

/* 1. Columbia, SC. */
$en = roden_es_seed_find_location( 'columbia' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Lesiones Personales en Columbia, SC',
        'excerpt' => 'Abogados de lesiones personales en Columbia, Carolina del Sur que hablan español. Oficina en 1545 Sumter St. Consulta gratuita: (803) 219-2816.',
        'content' => <<<'HTML'
<p>Después de un accidente en Columbia, las llamadas de la aseguradora empiezan rápido — y sus ofertas casi siempre son menos de lo que su caso vale. La oficina de Roden Law en Columbia, ubicada en <strong>1545 Sumter St., Suite B, Columbia, SC 29201</strong>, a pocas cuadras del capitolio estatal, está lista para defenderle. Llámenos al <a href="tel:+18032192816">(803) 219-2816</a> — la consulta es gratuita y en español.</p>
<p>Representamos a víctimas de accidentes de auto en la I-20, la I-26 y la I-77, accidentes de camiones, lesiones en el trabajo, caídas y otros casos de lesiones personales en Columbia, Lexington, Irmo, West Columbia, Cayce, Forest Acres y las comunidades del Midlands de Carolina del Sur.</p>
<h2>Ayuda legal en español en el Midlands</h2>
<p>En Roden Law usted no necesita traductor para entender su propio caso: le atendemos en español desde la primera llamada hasta el cierre de su reclamo. No cobramos honorarios a menos que ganemos su caso, y su estatus migratorio no le impide reclamar una compensación por sus lesiones — su consulta es siempre confidencial. Nuestro bufete ha recuperado más de $300 millones para sus clientes en más de 5,000 casos.</p>
<p>En Carolina del Sur, por lo general usted tiene <strong>3 años</strong> desde la fecha del accidente para presentar una demanda por lesiones personales (S.C. Code § 15-3-530). No deje pasar el tiempo — <a href="/es/contact/">contáctenos hoy</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de lesiones personales en Columbia, SC. Hablamos español. Consulta gratuita: (803) 219-2816. Sin honorarios a menos que ganemos su caso.',
            '_roden_service_area'     => 'Columbia, Lexington, Irmo, West Columbia, Cayce, Forest Acres y las comunidades del Midlands de Carolina del Sur.',
            '_roden_local_content'    => '<p>Los casos de lesiones personales de nuestros clientes de Columbia se presentan generalmente ante el Richland County Circuit Court; los casos de Lexington y West Columbia suelen corresponder al condado de Lexington. Nuestros abogados conocen los tribunales del Midlands y sus procedimientos de mediación.</p><p>Nuestra oficina en Sumter Street está en pleno centro de Columbia, cerca del capitolio y de los tribunales. Si sus lesiones le impiden desplazarse, atendemos su consulta gratuita por teléfono o videollamada, en español.</p>',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto cuesta contratar a un abogado de lesiones personales en Columbia?', 'answer' => 'Nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos si recuperamos dinero para usted, como un porcentaje de esa recuperación. La consulta inicial es gratuita.' ),
                array( 'question' => '¿Puedo reclamar compensación si no tengo papeles?', 'answer' => 'Sí. Su estatus migratorio no le impide presentar un reclamo por lesiones personales en Carolina del Sur. Todo lo que nos cuente es confidencial.' ),
                array( 'question' => '¿Cuánto tiempo tengo para presentar mi caso en Carolina del Sur?', 'answer' => 'Por lo general, 3 años desde la fecha del accidente (S.C. Code § 15-3-530). Los plazos pueden ser más cortos cuando hay entidades del gobierno involucradas, así que le conviene llamar cuanto antes.' ),
                array( 'question' => '¿Hablan español en su oficina de Columbia?', 'answer' => 'Sí. Atendemos consultas en español y le mantenemos informado en su idioma durante todo el proceso. Llame al (803) 219-2816.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN location columbia not found.' ); }

/* 2. Myrtle Beach, SC (oficina en Murrells Inlet). */
$en = roden_es_seed_find_location( 'myrtle-beach' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Lesiones Personales en Myrtle Beach, SC',
        'excerpt' => 'Abogados de lesiones personales en Myrtle Beach, Carolina del Sur que hablan español. Oficina en 631 Bellamy Ave., Murrells Inlet. Consulta gratuita: (843) 612-1980.',
        'content' => <<<'HTML'
<p>Entre el tráfico del Highway 17, el Highway 501 y los millones de visitantes que recibe cada año, el Grand Strand registra accidentes graves todos los días. Si usted resultó lesionado, la oficina de Roden Law que sirve a Myrtle Beach, ubicada en <strong>631 Bellamy Ave., Suite C-B, Murrells Inlet, SC 29576</strong>, está lista para ayudarle. Llámenos al <a href="tel:+18436121980">(843) 612-1980</a> — la consulta es gratuita y en español.</p>
<p>Representamos a víctimas de accidentes de auto y motocicleta, accidentes de camiones, lesiones en el trabajo, caídas en hoteles y negocios, y otros casos de lesiones personales en Myrtle Beach, Murrells Inlet, Conway, Surfside Beach, Pawleys Island y las comunidades del Grand Strand.</p>
<h2>Abogados que hablan español en el Grand Strand</h2>
<p>Miles de familias hispanas trabajan en los hoteles, restaurantes y obras de construcción de la costa. Si un accidente le dejó sin poder trabajar, en Roden Law no cobramos honorarios a menos que ganemos su caso, y su estatus migratorio no le impide reclamar una compensación por sus lesiones — su consulta es siempre confidencial. Nuestro bufete ha recuperado más de $300 millones para sus clientes.</p>
<p>En Carolina del Sur, por lo general usted tiene <strong>3 años</strong> desde la fecha del accidente para presentar una demanda por lesiones personales (S.C. Code § 15-3-530). Mientras más pronto actúe, más fuerte será su caso — <a href="/es/contact/">contáctenos hoy</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de lesiones personales en Myrtle Beach, SC. Hablamos español. Consulta gratuita: (843) 612-1980. Sin honorarios a menos que ganemos.',
            '_roden_service_area'     => 'Myrtle Beach, Murrells Inlet, Conway, Surfside Beach, Pawleys Island y las comunidades del Grand Strand.',
            '_roden_local_content'    => '<p>Los casos de lesiones personales del área de Myrtle Beach se presentan generalmente ante el Horry County Circuit Court, en Conway; los casos de Murrells Inlet y Pawleys Island pueden corresponder al condado de Georgetown. Nuestros abogados litigan con regularidad en los tribunales del Grand Strand.</p><p>Nuestra oficina en Bellamy Avenue, en Murrells Inlet, tiene fácil acceso desde el Highway 17 para clientes de toda la costa. Si no puede visitarnos, atendemos su consulta gratuita por teléfono o videollamada, en español.</p>',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto cuesta contratar a un abogado de lesiones personales en Myrtle Beach?', 'answer' => 'No paga nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos un porcentaje si ganamos su caso. La consulta inicial es gratuita y sin compromiso.' ),
                array( 'question' => '¿Puedo reclamar compensación si no tengo papeles?', 'answer' => 'Sí. Su estatus migratorio no le impide reclamar una compensación por un accidente o una lesión en el trabajo en Carolina del Sur. Su información se mantiene confidencial.' ),
                array( 'question' => '¿Cuánto tiempo tengo para presentar mi caso en Carolina del Sur?', 'answer' => 'En general, 3 años desde la fecha del accidente (S.C. Code § 15-3-530). En reclamos contra entidades del gobierno los plazos son más cortos, así que no espere para llamar.' ),
                array( 'question' => '¿Hablan español en su oficina de Myrtle Beach?', 'answer' => 'Sí. Nuestro equipo atiende consultas en español y le acompaña en su idioma durante todo su caso. Llame al (843) 612-1980.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN location myrtle-beach not found.' ); }

WP_CLI::log( '═══ BATCH 04 DONE ═══' );
