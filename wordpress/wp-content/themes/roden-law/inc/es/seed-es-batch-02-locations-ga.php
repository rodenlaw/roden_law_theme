<?php
/**
 * ES Seeder — Batch 02: Georgia location pages (Savannah, Darien).
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-02-locations-ga.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 02 — LOCATIONS GA (SAVANNAH, DARIEN) ═══' );

/* 1. Savannah, GA. */
$en = roden_es_seed_find_location( 'savannah' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Lesiones Personales en Savannah, GA',
        'excerpt' => 'Abogados de lesiones personales en Savannah, Georgia que hablan español. Oficina en 333 Commercial Dr. Consulta gratuita: (912) 303-5850.',
        'content' => <<<'HTML'
<p>Si usted o un ser querido sufrió una lesión en un accidente en Savannah, no tiene que enfrentar solo a la aseguradora. La oficina de Roden Law en Savannah, ubicada en <strong>333 Commercial Dr., Savannah, GA 31406</strong>, está lista para ayudarle. Llámenos al <a href="tel:+19123035850">(912) 303-5850</a> — atendemos consultas en español y la primera consulta es gratuita.</p>
<p>Nuestro equipo representa a víctimas de accidentes de auto, accidentes de camiones, lesiones en el trabajo, caídas y otros casos de lesiones personales en Savannah, Pooler, Richmond Hill, Hinesville, Statesboro, Brunswick y las comunidades del sureste de Georgia.</p>
<h2>Un bufete en el que la comunidad hispana de Savannah puede confiar</h2>
<p>Sabemos que reclamar una compensación en otro idioma puede sentirse intimidante. En Roden Law usted puede explicar su caso en español, recibir respuestas claras y saber en todo momento cómo avanza su reclamo. No cobramos honorarios a menos que ganemos su caso, y su estatus migratorio no le impide reclamar una compensación por sus lesiones — su consulta es siempre confidencial. Nuestro bufete ha recuperado más de $300 millones para sus clientes en más de 5,000 casos.</p>
<p>Actúe pronto: en Georgia, por lo general usted tiene <strong>2 años</strong> desde la fecha del accidente para presentar una demanda por lesiones personales (O.C.G.A. § 9-3-33). Si deja pasar el plazo, puede perder su derecho a reclamar. <a href="/es/contact/">Contáctenos hoy</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de lesiones personales en Savannah, GA. Hablamos español. Consulta gratuita: (912) 303-5850. Sin honorarios a menos que ganemos su caso.',
            '_roden_service_area'     => 'Savannah, Pooler, Richmond Hill, Hinesville, Statesboro, Brunswick y las comunidades del sureste de Georgia.',
            '_roden_local_content'    => '<p>Los casos de lesiones personales de nuestros clientes de Savannah se presentan generalmente ante el Chatham County Superior Court. Nuestros abogados conocen los tribunales del condado de Chatham, sus jueces y sus procedimientos, lo que nos permite preparar cada caso para el mejor resultado posible.</p><p>Nuestra oficina en 333 Commercial Dr. cuenta con estacionamiento para clientes. Si sus lesiones le impiden desplazarse, coordinamos su consulta gratuita por teléfono o videollamada, en español.</p>',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto cuesta contratar a un abogado de lesiones personales en Savannah?', 'answer' => 'Nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos si recuperamos dinero para usted, como un porcentaje de esa recuperación. La consulta inicial es gratuita y sin compromiso.' ),
                array( 'question' => '¿Puedo reclamar compensación si no tengo papeles?', 'answer' => 'Sí. Su estatus migratorio no le impide presentar un reclamo por lesiones personales en Georgia. Todo lo que nos cuente es confidencial y está protegido por el secreto profesional entre abogado y cliente.' ),
                array( 'question' => '¿Cuánto tiempo tengo para presentar mi caso en Georgia?', 'answer' => 'Por lo general, 2 años desde la fecha del accidente (O.C.G.A. § 9-3-33). Algunos casos tienen plazos más cortos, especialmente cuando hay entidades del gobierno involucradas, así que le recomendamos llamar cuanto antes.' ),
                array( 'question' => '¿Hablan español en su oficina de Savannah?', 'answer' => 'Sí. Atendemos consultas en español y le mantenemos informado en su idioma durante todo el proceso. Llame al (912) 303-5850 para hablar con nuestro equipo.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN location savannah not found.' ); }

/* 2. Darien, GA. */
$en = roden_es_seed_find_location( 'darien' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Lesiones Personales en Darien, GA',
        'excerpt' => 'Abogados de lesiones personales en Darien, Georgia que hablan español. Oficina en 1108 North Way. Consulta gratuita: (912) 303-5850.',
        'content' => <<<'HTML'
<p>Después de un accidente en la costa de Georgia, usted necesita un abogado que conozca la región y que hable su idioma. La oficina de Roden Law en Darien, ubicada en <strong>1108 North Way, Darien, GA 31305</strong>, atiende a familias trabajadoras de toda la costa. Llámenos al <a href="tel:+19123035850">(912) 303-5850</a> — la consulta es gratuita y en español.</p>
<p>Representamos a víctimas de accidentes de auto y camiones en la I-95, lesiones en el trabajo, caídas y otros casos de lesiones personales en Darien, Brunswick, St. Simons Island, Jekyll Island, Waycross y las comunidades costeras del sureste de Georgia.</p>
<h2>Ayuda legal en español en la costa de Georgia</h2>
<p>Muchos de nuestros vecinos trabajan en la pesca, el turismo, la construcción y el transporte — trabajos duros donde los accidentes ocurren. En Roden Law no cobramos honorarios a menos que ganemos su caso, y su estatus migratorio no le impide reclamar una compensación: su consulta es siempre confidencial. Con más de $300 millones recuperados para nuestros clientes, sabemos cómo hacer que las aseguradoras respondan.</p>
<p>No espere: en Georgia, por lo general usted tiene <strong>2 años</strong> desde la fecha del accidente para presentar su demanda (O.C.G.A. § 9-3-33). <a href="/es/contact/">Contáctenos hoy</a> para proteger sus derechos.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de lesiones personales en Darien, GA. Hablamos español. Consulta gratuita: (912) 303-5850. No paga honorarios a menos que ganemos.',
            '_roden_service_area'     => 'Darien, Brunswick, St. Simons Island, Jekyll Island, Waycross y las comunidades costeras del sureste de Georgia.',
            '_roden_local_content'    => '<p>Los casos de nuestros clientes de Darien se presentan generalmente ante el McIntosh County Superior Court. Nuestros abogados conocen los tribunales locales de la costa de Georgia y manejan casos en los condados de McIntosh, Glynn y sus alrededores.</p><p>La oficina de 1108 North Way está a pasos del centro de Darien y cerca de la I-95, con fácil acceso desde Brunswick y las islas. Si no puede visitarnos, atendemos su consulta gratuita por teléfono o videollamada, en español.</p>',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto cuesta contratar a un abogado de lesiones personales en Darien?', 'answer' => 'No paga nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos un porcentaje si ganamos su caso. La consulta inicial es gratuita.' ),
                array( 'question' => '¿Puedo reclamar compensación si no tengo papeles?', 'answer' => 'Sí. Su estatus migratorio no le impide reclamar una compensación por lesiones en Georgia. Su información se mantiene confidencial durante todo el proceso.' ),
                array( 'question' => '¿Cuánto tiempo tengo para presentar mi caso en Georgia?', 'answer' => 'En general, 2 años desde la fecha del accidente (O.C.G.A. § 9-3-33). Mientras más pronto llame, más fácil será preservar la evidencia y los testimonios de su caso.' ),
                array( 'question' => '¿Hablan español en su oficina de Darien?', 'answer' => 'Sí. Nuestro equipo atiende consultas en español y le explica cada paso de su caso en su idioma. Llame al (912) 303-5850.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN location darien not found.' ); }

WP_CLI::log( '═══ BATCH 02 DONE ═══' );
