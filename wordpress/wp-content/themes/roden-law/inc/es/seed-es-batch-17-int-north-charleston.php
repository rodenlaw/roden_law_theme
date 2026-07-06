<?php
/**
 * ES Seeder — Batch 17: Intersections × North Charleston, SC (car, truck, workers-comp, construction).
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-17-int-north-charleston.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 17 — INTERSECCIONES: NORTH CHARLESTON, SC ═══' );

/* 1. car-accident-lawyers × north-charleston-sc */
$en_int    = roden_es_seed_find_intersection( 'car-accident-lawyers', 'north-charleston-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'car-accident-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Accidentes de Auto en North Charleston, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de accidentes de auto en North Charleston, SC que hablan español. Oficina en Spruill Ave. Consulta gratuita: (843) 612-6561.',
        'content' => <<<'HTML'
<p>Rivers Avenue, Ashley Phosphate Road, Aviation Avenue y el intercambio de la I-26 con la I-526 hacen de North Charleston una de las zonas más peligrosas para manejar en Carolina del Sur. Si un conductor negligente lo lesionó en cualquiera de estos corredores, la oficina de Roden Law en <strong>2703 Spruill Ave</strong>, en la zona de Park Circle, está lista para defenderle. Llame al <a href="tel:+18436126561">(843) 612-6561</a> — la consulta es gratuita y en español.</p>
<p>Representamos a víctimas de accidentes en North Charleston, Goose Creek, Summerville, Hanahan, Ladson y Moncks Corner. Su caso se presenta ante el Charleston County Court of Common Pleas, donde nuestros abogados litigan con regularidad.</p>
<p>En Carolina del Sur usted generalmente tiene <strong>3 años</strong> para presentar su demanda (S.C. Code § 15-3-530). Los videos de las cámaras de Rivers Avenue y de los negocios se borran en días — llámenos antes de hablar con la aseguradora.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de auto en North Charleston, SC. Hablamos español. Oficina en Spruill Ave. Consulta gratuita: (843) 612-6561.',
            '_roden_hero_intro'       => 'Si lo lesionaron en Rivers Avenue, la I-26 o Ashley Phosphate, nuestros abogados de accidentes de auto de North Charleston pelean por usted — en su idioma y sin costo por adelantado.',
            '_roden_why_hire'         => '<p>La aseguradora del otro conductor empieza a trabajar contra usted el mismo día del choque. Nosotros nivelamos el terreno: obtenemos el informe policial, rescatamos videos de tráfico y de negocios antes de que se borren, documentamos sus lesiones con expertos médicos y reclamamos el valor completo — facturas, salarios perdidos y dolor y sufrimiento.</p><p>Nuestra oficina de Spruill Avenue atiende a la comunidad hispana de North Charleston en español, con estacionamiento gratuito. Más de $300 millones recuperados y sin honorarios a menos que ganemos. Llame al (843) 612-6561.</p>',
            '_roden_key_takeaways'    => 'Después de un accidente de auto en North Charleston, usted generalmente tiene 3 años para presentar su demanda en Carolina del Sur (S.C. Code § 15-3-530) y puede recuperar compensación siempre que haya sido menos del 51% culpable. Los corredores de la I-26, la I-526, Rivers Avenue y Ashley Phosphate concentran los choques más graves de la zona, y la evidencia en video desaparece en días. La consulta en nuestra oficina de Spruill Avenue es gratuita y en español, y no paga honorarios a menos que ganemos su caso.',
            '_roden_accident_phrase'  => 'un accidente de auto',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto tiempo tengo en Carolina del Sur para demandar después de un choque en North Charleston?', 'answer' => 'Por lo general, 3 años desde la fecha del accidente (S.C. Code § 15-3-530). Si el SCDOT o una entidad pública está involucrada, los plazos de notificación son más cortos. No espere para llamar.' ),
                array( 'question' => '¿Hablan español en su oficina de North Charleston?', 'answer' => 'Sí. Nuestro equipo de Spruill Avenue le atiende en español desde la primera llamada. Marque el (843) 612-6561 — la consulta es gratuita.' ),
                array( 'question' => '¿Cuánto cuesta contratar a un abogado de accidentes?', 'answer' => 'Nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos si recuperamos dinero para usted.' ),
                array( 'question' => '¿Puedo reclamar si no tengo papeles?', 'answer' => 'Sí. Su estatus migratorio no le impide reclamar compensación por un accidente en Carolina del Sur. Su información se mantiene confidencial.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'car-accident-lawyers/north-charleston-sc not found or ES pillar missing.' ); }

/* 2. truck-accident-lawyers × north-charleston-sc */
$en_int    = roden_es_seed_find_intersection( 'truck-accident-lawyers', 'north-charleston-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'truck-accident-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Accidentes de Camiones en North Charleston, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de accidentes de camiones en North Charleston, SC. Corredor industrial y portuario de la I-26/Rivers Ave. Gratis en español: (843) 612-6561.',
        'content' => <<<'HTML'
<p>North Charleston es el corredor de carga de Carolina del Sur: los camiones del Hugh Leatherman Terminal y de las plantas industriales de la zona saturan la I-26, la I-526 y Rivers Avenue a toda hora. Cuando uno de esos camiones lo lesiona, la compañía de transporte manda investigadores a la escena en horas — usted necesita un equipo que actúe igual de rápido.</p>
<p>Desde nuestra oficina en <strong>2703 Spruill Ave</strong>, en Park Circle, enviamos cartas de preservación de evidencia de inmediato: la caja negra, los registros de horas del conductor, los datos de GPS y el historial de inspecciones del chasis del puerto. Llame al <a href="tel:+18436126561">(843) 612-6561</a> — la consulta es gratuita y en español.</p>
<p>El plazo general en Carolina del Sur es de <strong>3 años</strong> (S.C. Code § 15-3-530), pero la evidencia electrónica del camión puede borrarse legalmente en semanas si nadie la exige.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de camiones en North Charleston, SC. Enfrentamos a las transportistas del puerto. Gratis en español: (843) 612-6561.',
            '_roden_hero_intro'       => 'Los camiones del puerto dominan la I-26, la I-526 y Rivers Avenue. Si uno de ellos lo lesionó en North Charleston, preservamos la evidencia y enfrentamos a la transportista — en español.',
            '_roden_why_hire'         => '<p>Los casos de camiones en North Charleston suelen involucrar a varias empresas: el conductor, la transportista, el dueño del chasis y quien cargó el contenedor en el puerto. Conocemos las regulaciones federales de la FMCSA, investigamos violaciones de horas de servicio y mantenimiento, y trabajamos con expertos en reconstrucción de accidentes para probar la culpa.</p><p>Nuestro equipo litiga estos casos ante el Charleston County Court of Common Pleas y le atiende en español en cada etapa. Más de $300 millones recuperados, sin honorarios a menos que ganemos. Llame al (843) 612-6561.</p>',
            '_roden_key_takeaways'    => 'Si un camión lo lesionó en North Charleston, usted generalmente tiene 3 años para demandar en Carolina del Sur (S.C. Code § 15-3-530) y puede recuperar compensación si fue menos del 51% culpable. El corredor portuario de la I-26, la I-526 y Rivers Avenue concentra los choques de camiones más graves del estado, y suelen existir varias empresas responsables además del conductor. La evidencia electrónica se borra en semanas, así que llame de inmediato: la consulta en nuestra oficina de Spruill Avenue es gratuita y en español, sin honorarios a menos que ganemos.',
            '_roden_accident_phrase'  => 'un accidente de camión',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto tiempo tengo en Carolina del Sur para demandar por un accidente de camión?', 'answer' => 'En general, 3 años (S.C. Code § 15-3-530). Pero la caja negra y los registros del conductor pueden borrarse legalmente en semanas — mientras antes actúe un abogado, más evidencia se salva.' ),
                array( 'question' => '¿Qué hace diferente a un caso de camión del puerto?', 'answer' => 'Pueden ser responsables la transportista, el dueño del chasis, la terminal o quien cargó el contenedor, cada uno con su propia aseguradora. Identificar a todas las partes es clave para el valor de su caso.' ),
                array( 'question' => '¿Hablan español en su oficina de North Charleston?', 'answer' => 'Sí. Le atendemos en español desde la consulta gratuita hasta el final de su caso. Llame al (843) 612-6561.' ),
                array( 'question' => '¿Cuánto cuesta contratarlos?', 'answer' => 'Nada por adelantado. Solo cobramos un porcentaje si recuperamos dinero para usted. Si no ganamos, no nos debe honorarios.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'truck-accident-lawyers/north-charleston-sc not found or ES pillar missing.' ); }

/* 3. workers-compensation-lawyers × north-charleston-sc */
$en_int    = roden_es_seed_find_intersection( 'workers-compensation-lawyers', 'north-charleston-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'workers-compensation-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Compensación Laboral en North Charleston, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de compensación laboral en North Charleston, SC. Hablamos español y su estatus migratorio no impide beneficios. Gratis: (843) 612-6561.',
        'content' => <<<'HTML'
<p>North Charleston es la capital industrial del Lowcountry: plantas de manufactura y aeroespaciales, bodegas, talleres y el movimiento constante de carga del puerto. Ese trabajo es físico y peligroso — máquinas, montacargas, cargas pesadas, jornadas largas. Si una lesión en el trabajo lo dejó sin ingresos, la compensación laboral de Carolina del Sur debe pagar su atención médica y parte de su salario, sin importar de quién fue la culpa.</p>
<p>Las aseguradoras cuentan con que el trabajador no conozca sus derechos, y presionan más cuando hay barrera de idioma. En Roden Law usted habla en español con nuestro equipo de <strong>2703 Spruill Ave</strong>, en Park Circle. <strong>Su estatus migratorio no le impide recibir beneficios</strong> y su consulta es confidencial. Llame al <a href="tel:+18436126561">(843) 612-6561</a>.</p>
<p>Actúe pronto: reporte su lesión dentro de <strong>90 días</strong> y presente el reclamo dentro de <strong>2 años</strong> (S.C. Code § 42-15-20).</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de compensación laboral en North Charleston, SC. Hablamos español. Estatus migratorio no impide beneficios. Gratis: (843) 612-6561.',
            '_roden_hero_intro'       => 'Si se lesionó en una planta, bodega u obra de North Charleston, tiene derecho a beneficios de compensación laboral — sin importar su estatus migratorio. Le atendemos en español.',
            '_roden_why_hire'         => '<p>Nosotros presentamos su reclamo correctamente ante la South Carolina Workers’ Compensation Commission, peleamos las negaciones y los recortes, nos aseguramos de que reciba el tratamiento médico completo y calculamos sus beneficios por incapacidad temporal o permanente — incluyendo lo que la aseguradora "olvida" ofrecer.</p><p>Conocemos el miedo a represalias que sienten muchos trabajadores hispanos de las plantas y bodegas de North Charleston. La ley le protege, todo es confidencial y no cobramos honorarios a menos que recuperemos beneficios para usted. Llame al (843) 612-6561.</p>',
            '_roden_key_takeaways'    => 'Si se lesionó trabajando en North Charleston, reporte la lesión a su empleador dentro de 90 días y presente su reclamo dentro de 2 años (S.C. Code § 42-15-20). La compensación laboral de Carolina del Sur no exige probar culpa: cubre su atención médica y cerca de dos tercios de su salario mientras no pueda trabajar, incluso en las plantas y bodegas del corredor industrial. Su estatus migratorio no le impide recibir beneficios y su consulta es confidencial. En nuestra oficina de Spruill Avenue la consulta es gratuita y en español, sin honorarios a menos que ganemos.',
            '_roden_accident_phrase'  => 'una lesión en el trabajo',
            '_roden_faqs'             => array(
                array( 'question' => '¿Puedo recibir compensación laboral si no tengo papeles?', 'answer' => 'Sí. En Carolina del Sur los trabajadores lesionados tienen derecho a beneficios sin importar su estatus migratorio. Su consulta es confidencial y reclamar es su derecho legal.' ),
                array( 'question' => '¿Cuánto tiempo tengo para reportar mi lesión en North Charleston?', 'answer' => 'Reporte a su empleador dentro de 90 días y presente el reclamo formal dentro de 2 años (S.C. Code § 42-15-20). Repórtelo por escrito lo antes posible, aunque el dolor parezca leve.' ),
                array( 'question' => '¿Qué pasa si mi empleador me pide no reportar el accidente?', 'answer' => 'Llámenos primero. No reportar puede costarle todos sus beneficios, y su empleador no puede despedirle legalmente por presentar un reclamo de compensación laboral.' ),
                array( 'question' => '¿Hablan español en su oficina de North Charleston?', 'answer' => 'Sí. Todo su caso se maneja en español. Llame al (843) 612-6561 — la consulta es gratuita.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'workers-compensation-lawyers/north-charleston-sc not found or ES pillar missing.' ); }

/* 4. construction-accident-lawyers × north-charleston-sc */
$en_int    = roden_es_seed_find_intersection( 'construction-accident-lawyers', 'north-charleston-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'construction-accident-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Accidentes de Construcción en North Charleston, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de accidentes de construcción en North Charleston, SC. Hablamos español; su estatus migratorio no impide reclamar. Gratis: (843) 612-6561.',
        'content' => <<<'HTML'
<p>Entre las ampliaciones industriales, las bodegas nuevas junto a la I-26 y las urbanizaciones que crecen hacia Summerville y Goose Creek, North Charleston vive un auge de construcción — levantado en gran parte por trabajadores hispanos. Caídas de altura, zanjas que colapsan, electrocuciones y golpes de equipo pesado dejan cada año a trabajadores sin poder mantener a sus familias.</p>
<p>Después de un accidente en la obra usted puede tener dos reclamos: la compensación laboral de su empleador y, con frecuencia, una demanda contra terceros — el contratista general, otro subcontratista o el fabricante de un equipo defectuoso. Esa demanda adicional puede cubrir el dolor y sufrimiento que la compensación laboral nunca paga. <strong>Su estatus migratorio no le impide reclamar</strong> y su consulta es confidencial.</p>
<p>Llame a nuestra oficina de <strong>2703 Spruill Ave</strong> al <a href="tel:+18436126561">(843) 612-6561</a>. En Carolina del Sur el plazo general para demandar a terceros es de <strong>3 años</strong> (S.C. Code § 15-3-530).</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de construcción en North Charleston, SC. Hablamos español. Estatus migratorio no impide reclamar. Gratis: (843) 612-6561.',
            '_roden_hero_intro'       => 'Si se lesionó en una obra de North Charleston, puede tener derecho a compensación laboral y a una demanda contra terceros responsables. Se lo explicamos en español, sin costo.',
            '_roden_why_hire'         => '<p>En una obra trabajan varias empresas a la vez, y cuando alguien se lesiona todas se culpan entre sí. Nosotros investigamos violaciones de seguridad de OSHA, identificamos a cada contratista responsable y coordinamos su reclamo de compensación laboral con la demanda contra terceros para maximizar su recuperación total.</p><p>Entendemos el temor de muchos trabajadores hispanos a reclamar. La ley le protege sin importar su estatus migratorio, todo es confidencial y no cobramos honorarios a menos que ganemos. Llame a nuestra oficina de Park Circle al (843) 612-6561.</p>',
            '_roden_key_takeaways'    => 'Tras un accidente de construcción en North Charleston, usted generalmente tiene 3 años para demandar a terceros responsables (S.C. Code § 15-3-530) y puede recuperar compensación si fue menos del 51% culpable; su reclamo de compensación laboral corre por separado con plazos más cortos (reporte en 90 días, reclamo en 2 años, S.C. Code § 42-15-20). El contratista general u otro subcontratista pueden deberle mucho más que el seguro de su empleador. Su estatus migratorio no impide ningún reclamo. La consulta en nuestra oficina de Spruill Avenue es gratuita y en español, sin honorarios a menos que ganemos.',
            '_roden_accident_phrase'  => 'un accidente de construcción',
            '_roden_faqs'             => array(
                array( 'question' => '¿Puedo demandar además de recibir compensación laboral?', 'answer' => 'Muchas veces sí. No puede demandar a su propio empleador, pero sí al contratista general, a otros subcontratistas o al fabricante de un equipo defectuoso. Esa demanda puede valer mucho más que la compensación laboral sola.' ),
                array( 'question' => '¿Puedo reclamar si no tengo papeles?', 'answer' => 'Sí. Su estatus migratorio no le impide reclamar compensación laboral ni demandar a terceros en Carolina del Sur. Todo lo que nos cuente es confidencial.' ),
                array( 'question' => '¿Cuánto tiempo tengo para reclamar?', 'answer' => 'La demanda contra terceros: generalmente 3 años (S.C. Code § 15-3-530). La compensación laboral: reporte dentro de 90 días y reclame dentro de 2 años (S.C. Code § 42-15-20).' ),
                array( 'question' => '¿Hablan español en su oficina de North Charleston?', 'answer' => 'Sí. Le atendemos en español en cada etapa de su caso. Llame al (843) 612-6561 — la consulta es gratuita.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'construction-accident-lawyers/north-charleston-sc not found or ES pillar missing.' ); }

WP_CLI::log( '═══ BATCH 17 DONE ═══' );
