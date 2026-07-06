<?php
/**
 * ES Seeder — Batch 03: South Carolina location pages A (Charleston, North Charleston).
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-03-locations-sc-a.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 03 — LOCATIONS SC-A (CHARLESTON, NORTH CHARLESTON) ═══' );

/* 1. Charleston, SC. */
$en = roden_es_seed_find_location( 'charleston' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Lesiones Personales en Charleston, SC',
        'excerpt' => 'Abogados de lesiones personales en Charleston, Carolina del Sur que hablan español. Oficina en 127 King Street. Consulta gratuita: (843) 790-8999.',
        'content' => <<<'HTML'
<p>Un accidente puede poner su vida de cabeza en un instante: facturas médicas, días sin trabajar y una aseguradora que le presiona para aceptar menos de lo que merece. La oficina de Roden Law en Charleston, ubicada en <strong>127 King Street, Suite 200, Charleston, SC 29401</strong>, está aquí para defenderle. Llámenos al <a href="tel:+18437908999">(843) 790-8999</a> — la consulta es gratuita y en español.</p>
<p>Representamos a víctimas de accidentes de auto, accidentes de camiones, lesiones en el trabajo, caídas y otros casos de lesiones personales en Charleston, Mount Pleasant, West Ashley, James Island, Johns Island, Daniel Island y las comunidades del Lowcountry.</p>
<h2>Un aliado para la comunidad hispana del Lowcountry</h2>
<p>En Roden Law usted puede contar su caso en español, hacer preguntas y recibir respuestas claras — sin intermediarios ni confusión. No cobramos honorarios a menos que ganemos su caso, y su estatus migratorio no le impide reclamar una compensación por sus lesiones: su consulta es siempre confidencial. Nuestro bufete ha recuperado más de $300 millones para sus clientes en más de 5,000 casos.</p>
<p>En Carolina del Sur, por lo general usted tiene <strong>3 años</strong> desde la fecha del accidente para presentar una demanda por lesiones personales (S.C. Code § 15-3-530). No espere a que el plazo se venza — <a href="/es/contact/">contáctenos hoy</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de lesiones personales en Charleston, SC. Hablamos español. Consulta gratuita: (843) 790-8999. Sin honorarios a menos que ganemos su caso.',
            '_roden_service_area'     => 'Charleston, Mount Pleasant, West Ashley, James Island, Johns Island, Daniel Island y las comunidades del Lowcountry.',
            '_roden_local_content'    => '<p>Los casos de lesiones personales de nuestros clientes de Charleston se presentan generalmente ante el Charleston County Circuit Court, en el centro de la ciudad. Nuestros abogados litigan con regularidad en los tribunales del condado de Charleston y conocen sus reglas de mediación y sus tiempos.</p><p>Nuestra oficina está en el corazón del centro histórico, en King Street, a pocas cuadras del tribunal. Si sus lesiones le impiden desplazarse, coordinamos su consulta gratuita por teléfono o videollamada, en español.</p>',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto cuesta contratar a un abogado de lesiones personales en Charleston?', 'answer' => 'Nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos si recuperamos dinero para usted. La consulta inicial es gratuita y sin compromiso.' ),
                array( 'question' => '¿Puedo reclamar compensación si no tengo papeles?', 'answer' => 'Sí. Su estatus migratorio no le impide presentar un reclamo por lesiones personales en Carolina del Sur. Todo lo que comparta con nosotros es confidencial.' ),
                array( 'question' => '¿Cuánto tiempo tengo para presentar mi caso en Carolina del Sur?', 'answer' => 'Por lo general, 3 años desde la fecha del accidente (S.C. Code § 15-3-530). Cuando hay entidades del gobierno involucradas los plazos pueden ser más cortos, así que llame cuanto antes.' ),
                array( 'question' => '¿Hablan español en su oficina de Charleston?', 'answer' => 'Sí. Atendemos consultas en español y le mantenemos informado en su idioma durante todo su caso. Llame al (843) 790-8999.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN location charleston not found.' ); }

/* 2. North Charleston, SC (nueva oficina — no existía en el seeder antiguo). */
$en = roden_es_seed_find_location( 'north-charleston' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Lesiones Personales en North Charleston, SC',
        'excerpt' => 'Abogados de lesiones personales en North Charleston, Carolina del Sur que hablan español. Oficina en 2703 Spruill Ave. Consulta gratuita: (843) 612-6561.',
        'content' => <<<'HTML'
<p>North Charleston es una ciudad de gente trabajadora — y también una de las zonas con más tráfico industrial y de camiones de todo el estado. Si un accidente en la I-26, en Rivers Avenue o en su lugar de trabajo cambió su vida, la oficina de Roden Law en <strong>2703 Spruill Ave, North Charleston, SC 29405</strong> está lista para ayudarle. Llámenos al <a href="tel:+18436126561">(843) 612-6561</a> — la consulta es gratuita y en español.</p>
<p>Representamos a víctimas de accidentes de auto y de camiones, lesiones en la construcción y en el trabajo, caídas y otros casos de lesiones personales en North Charleston, Goose Creek, Summerville, Hanahan, Ladson, Moncks Corner y las comunidades de los tres condados.</p>
<h2>Abogados que hablan español en North Charleston</h2>
<p>Entendemos las preocupaciones de la comunidad hispana después de un accidente: el costo, el idioma y el miedo a represalias. En Roden Law no cobramos honorarios a menos que ganemos su caso, y su estatus migratorio no le impide reclamar una compensación por sus lesiones — su consulta es siempre confidencial. Nuestro bufete ha recuperado más de $300 millones para sus clientes.</p>
<p>En Carolina del Sur, por lo general usted tiene <strong>3 años</strong> desde la fecha del accidente para presentar una demanda por lesiones personales (S.C. Code § 15-3-530). La evidencia desaparece rápido en los casos de camiones y accidentes industriales — <a href="/es/contact/">contáctenos hoy</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de lesiones personales en North Charleston, SC. Hablamos español. Consulta gratuita: (843) 612-6561. Sin honorarios a menos que ganemos.',
            '_roden_service_area'     => 'North Charleston, Goose Creek, Summerville, Hanahan, Ladson, Moncks Corner y las comunidades de los tres condados del Lowcountry.',
            '_roden_local_content'    => '<p>Los casos de lesiones personales de North Charleston se presentan generalmente ante el Charleston County Circuit Court, en el centro de Charleston. Nuestros abogados manejan con regularidad casos de accidentes de camiones y lesiones industriales vinculados al corredor de la I-26, la I-526 y Rivers Avenue.</p><p>Nuestra oficina está en Spruill Avenue, en la zona de Park Circle, con estacionamiento gratuito para clientes. Si no puede visitarnos, atendemos su consulta gratuita por teléfono o videollamada, en español.</p>',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto cuesta contratar a un abogado de lesiones personales en North Charleston?', 'answer' => 'No paga nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos un porcentaje si ganamos su caso. La consulta inicial es gratuita.' ),
                array( 'question' => '¿Puedo reclamar compensación si no tengo papeles?', 'answer' => 'Sí. Su estatus migratorio no le impide reclamar una compensación por un accidente o una lesión en el trabajo en Carolina del Sur. Su información se mantiene confidencial.' ),
                array( 'question' => '¿Cuánto tiempo tengo para presentar mi caso en Carolina del Sur?', 'answer' => 'En general, 3 años desde la fecha del accidente (S.C. Code § 15-3-530). En casos contra entidades del gobierno los plazos de notificación son más cortos, así que no espere para llamar.' ),
                array( 'question' => '¿Hablan español en su oficina de North Charleston?', 'answer' => 'Sí. Nuestro equipo atiende consultas en español y le explica cada paso de su caso en su idioma. Llame al (843) 612-6561.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN location north-charleston not found.' ); }

WP_CLI::log( '═══ BATCH 03 DONE ═══' );
