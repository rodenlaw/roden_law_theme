<?php
/**
 * ES Seeder — Batch 20: Intersections × Myrtle Beach, SC (car, truck, workers-comp, construction).
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-20-int-myrtle-beach.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 20 — INTERSECCIONES: MYRTLE BEACH, SC ═══' );

/* 1. car-accident-lawyers × myrtle-beach-sc */
$en_int    = roden_es_seed_find_intersection( 'car-accident-lawyers', 'myrtle-beach-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'car-accident-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Accidentes de Auto en Myrtle Beach, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de accidentes de auto en Myrtle Beach, SC que hablan español. Oficina en Murrells Inlet. Consulta gratuita: (843) 612-1980.',
        'content' => <<<'HTML'
<p>El Grand Strand recibe millones de visitantes al año, y esa marea de turistas transforma las carreteras: la US-17 (Kings Highway) y Ocean Boulevard se saturan en temporada alta, la US-501 se congestiona camino a la playa y la SC-22 concentra choques a alta velocidad. Muchos conductores son de otros estados, alquilan autos o no conocen la zona. Si uno de ellos lo lesionó, la oficina de Roden Law en <strong>631 Bellamy Ave., Suite C-B, Murrells Inlet</strong> está lista para defenderle. Llame al <a href="tel:+18436121980">(843) 612-1980</a> — la consulta es gratuita y en español.</p>
<p>Representamos a víctimas en Myrtle Beach, North Myrtle Beach, Murrells Inlet, Conway, Surfside Beach y todo el Grand Strand. Su caso se presenta ante el Horry County Court of Common Pleas en Conway.</p>
<p>En Carolina del Sur usted generalmente tiene <strong>3 años</strong> para demandar (S.C. Code § 15-3-530), pero los testigos turistas se van del estado en días. Llámenos antes de hablar con la aseguradora.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de auto en Myrtle Beach, SC. Hablamos español. Oficina en Murrells Inlet. Consulta gratuita: (843) 612-1980.',
            '_roden_hero_intro'       => 'Si un choque en la US-17, la US-501 o cualquier calle del Grand Strand cambió su vida, nuestros abogados de accidentes de auto reclaman la compensación completa que le corresponde — en español.',
            '_roden_why_hire'         => '<p>Los choques del Grand Strand tienen un problema propio: el conductor culpable muchas veces es un turista de otro estado con póliza mínima, y los testigos se van a casa en días. Actuamos rápido para preservar videos y declaraciones, y usamos el apilamiento de cobertura UM/UIM de Carolina del Sur — con frecuencia la mayor fuente de recuperación cuando el culpable lleva límites de 25/50/25.</p><p>Nuestra oficina de Murrells Inlet, junto a la US-17, atiende a la comunidad hispana de todo el Grand Strand en español. Más de $300 millones recuperados y sin honorarios a menos que ganemos. Llame al (843) 612-1980.</p>',
            '_roden_key_takeaways'    => 'Después de un accidente de auto en Myrtle Beach, usted generalmente tiene 3 años para presentar su demanda en Carolina del Sur (S.C. Code § 15-3-530) y puede recuperar compensación siempre que haya sido menos del 51% culpable. En el Grand Strand los choques suelen involucrar a turistas de otros estados con pólizas mínimas, y Carolina del Sur permite apilar cobertura UM/UIM para cerrar esa brecha — pero los testigos se dispersan en días. La consulta en nuestra oficina de Murrells Inlet es gratuita y en español, sin honorarios a menos que ganemos su caso.',
            '_roden_accident_phrase'  => 'un accidente de auto',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto tiempo tengo en Carolina del Sur para demandar después de un choque en Myrtle Beach?', 'answer' => 'Por lo general, 3 años desde la fecha del accidente (S.C. Code § 15-3-530). Pero en una ciudad turística la evidencia y los testigos desaparecen en días — llame lo antes posible.' ),
                array( 'question' => '¿Qué pasa si me chocó un turista de otro estado?', 'answer' => 'Todavía puede reclamar aquí. Presentamos el caso en el Horry County Court of Common Pleas, perseguimos a su aseguradora y, si la póliza es mínima, apilamos su propia cobertura UM/UIM para cubrir la diferencia.' ),
                array( 'question' => '¿Hablan español en su oficina de Myrtle Beach?', 'answer' => 'Sí. Nuestro equipo de Murrells Inlet le atiende en español desde la primera llamada. Marque el (843) 612-1980 — la consulta es gratuita.' ),
                array( 'question' => '¿Cuánto cuesta contratarlos?', 'answer' => 'Nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos si recuperamos dinero para usted.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'car-accident-lawyers/myrtle-beach-sc not found or ES pillar missing.' ); }

/* 2. truck-accident-lawyers × myrtle-beach-sc */
$en_int    = roden_es_seed_find_intersection( 'truck-accident-lawyers', 'myrtle-beach-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'truck-accident-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Accidentes de Camiones en Myrtle Beach, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de accidentes de camiones en Myrtle Beach, SC. Choques en la US-17, US-501 y SC-22. Consulta gratuita en español: (843) 612-1980.',
        'content' => <<<'HTML'
<p>Todo lo que consume el Grand Strand — comida para los restaurantes, materiales para los hoteles en construcción, mercancía para las tiendas de la playa — llega en camión por la US-501, la SC-22 y la US-17. En temporada alta, esos camiones comparten la vía con millones de turistas, y los choques en los semáforos de Kings Highway o a alta velocidad en el Conway Bypass dejan lesiones catastróficas.</p>
<p>Los abogados de Roden Law en <strong>631 Bellamy Ave., Suite C-B, Murrells Inlet</strong> actúan de inmediato: cartas de preservación para la caja negra, los registros de horas del conductor y el mantenimiento del camión, e investigación de las regulaciones federales de la FMCSA. Llame al <a href="tel:+18436121980">(843) 612-1980</a> — la consulta es gratuita y en español.</p>
<p>En Carolina del Sur el plazo general es de <strong>3 años</strong> (S.C. Code § 15-3-530), pero la evidencia electrónica del camión puede borrarse legalmente en semanas si nadie exige su preservación.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de camiones en Myrtle Beach, SC. Choques en US-17, US-501 y SC-22. Hablamos español. Gratis: (843) 612-1980.',
            '_roden_hero_intro'       => 'Si un camión comercial lo lesionó en la US-501, la SC-22 o la US-17, enfrentamos a la compañía de transporte y a sus aseguradoras — en su idioma y sin costo por adelantado.',
            '_roden_why_hire'         => '<p>Un caso de camión no es un choque de autos más grande: hay regulaciones federales, varias aseguradoras y evidencia electrónica que desaparece rápido. Investigamos si el conductor excedió sus horas de servicio, si los frenos estaban mal mantenidos y si la carga iba mal asegurada, y demandamos a cada parte responsable — el conductor, la transportista y el dueño del remolque.</p><p>Litigamos ante el Horry County Court of Common Pleas en Conway y le atendemos en español en cada etapa. Más de $300 millones recuperados, sin honorarios a menos que ganemos. Llame al (843) 612-1980.</p>',
            '_roden_key_takeaways'    => 'Si un camión lo lesionó en el área de Myrtle Beach, usted generalmente tiene 3 años para demandar en Carolina del Sur (S.C. Code § 15-3-530) y puede recuperar compensación si fue menos del 51% culpable. Los corredores de carga del Grand Strand — US-501, SC-22 y US-17 — mezclan camiones comerciales con tráfico turístico, y la caja negra y los registros del conductor pueden borrarse en semanas si nadie los exige. La consulta en nuestra oficina de Murrells Inlet es gratuita y en español, sin honorarios a menos que ganemos.',
            '_roden_accident_phrase'  => 'un accidente de camión',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto tiempo tengo en Carolina del Sur para demandar por un accidente de camión?', 'answer' => 'En general, 3 años (S.C. Code § 15-3-530). Pero la evidencia electrónica del camión puede borrarse legalmente en semanas — un abogado debe exigir su preservación de inmediato.' ),
                array( 'question' => '¿Dónde se presenta mi caso si el choque fue en Myrtle Beach?', 'answer' => 'Ante el Horry County Court of Common Pleas, en Conway. Nuestros abogados litigan allí con regularidad y manejan todo el proceso por usted.' ),
                array( 'question' => '¿Hablan español en su oficina de Myrtle Beach?', 'answer' => 'Sí. Le atendemos en español desde la consulta gratuita hasta el cierre de su caso. Llame al (843) 612-1980.' ),
                array( 'question' => '¿Cuánto cuesta contratarlos?', 'answer' => 'Nada por adelantado. Solo cobramos un porcentaje si recuperamos dinero para usted. Si no ganamos, no nos debe honorarios.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'truck-accident-lawyers/myrtle-beach-sc not found or ES pillar missing.' ); }

/* 3. workers-compensation-lawyers × myrtle-beach-sc */
$en_int    = roden_es_seed_find_intersection( 'workers-compensation-lawyers', 'myrtle-beach-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'workers-compensation-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Compensación Laboral en Myrtle Beach, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de compensación laboral en Myrtle Beach, SC. Hablamos español; su estatus migratorio no impide beneficios. Gratis: (843) 612-1980.',
        'content' => <<<'HTML'
<p>La economía turística del Grand Strand se sostiene sobre trabajadores hispanos: cocinas de restaurantes, limpieza de hoteles y condominios, mantenimiento de campos de golf, construcción de nuevos resorts. Es trabajo físico, de temporada alta agotadora — y cuando llega una lesión, muchas familias pierden su único ingreso de la noche a la mañana.</p>
<p>La compensación laboral de Carolina del Sur debe cubrir su atención médica y parte de su salario sin importar de quién fue la culpa. Y no importa si su trabajo es de temporada o si le pagan en efectivo: <strong>su estatus migratorio no le impide recibir beneficios</strong> y su consulta es confidencial. Llame a nuestra oficina de <strong>631 Bellamy Ave., Suite C-B, Murrells Inlet</strong> al <a href="tel:+18436121980">(843) 612-1980</a> — le atendemos en español.</p>
<p>Actúe pronto: reporte su lesión dentro de <strong>90 días</strong> y presente el reclamo dentro de <strong>2 años</strong> (S.C. Code § 42-15-20).</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de compensación laboral en Myrtle Beach, SC. Hablamos español. Su estatus migratorio no impide beneficios. Gratis: (843) 612-1980.',
            '_roden_hero_intro'       => 'Si se lesionó trabajando en un hotel, restaurante, campo de golf u obra del Grand Strand, tiene derecho a beneficios de compensación laboral — sin importar su estatus migratorio. Le atendemos en español.',
            '_roden_why_hire'         => '<p>Los empleadores de temporada del Grand Strand a veces niegan que el trabajador sea empleado, alegan que la lesión "no pasó en el trabajo" o presionan para no reportar. Nosotros presentamos su reclamo correctamente ante la South Carolina Workers’ Compensation Commission, peleamos las negaciones y calculamos sus beneficios completos por incapacidad temporal o permanente.</p><p>Entendemos el miedo a represalias de muchos trabajadores hispanos del sector turístico. La ley le protege sin importar su estatus, todo es confidencial y no cobramos honorarios a menos que recuperemos beneficios para usted. Llame al (843) 612-1980.</p>',
            '_roden_key_takeaways'    => 'Si se lesionó trabajando en Myrtle Beach o en cualquier punto del Grand Strand, reporte la lesión a su empleador dentro de 90 días y presente su reclamo de compensación laboral dentro de 2 años (S.C. Code § 42-15-20). El sistema de Carolina del Sur no exige probar culpa: cubre su atención médica y cerca de dos tercios de su salario mientras no pueda trabajar, incluso en empleos de temporada de hoteles y restaurantes. Su estatus migratorio no le impide recibir beneficios y su consulta es confidencial. En nuestra oficina de Murrells Inlet la consulta es gratuita y en español, sin honorarios a menos que ganemos.',
            '_roden_accident_phrase'  => 'una lesión en el trabajo',
            '_roden_faqs'             => array(
                array( 'question' => '¿Puedo recibir compensación laboral si no tengo papeles?', 'answer' => 'Sí. En Carolina del Sur los trabajadores lesionados tienen derecho a beneficios sin importar su estatus migratorio. Su consulta es confidencial y reclamar es su derecho.' ),
                array( 'question' => '¿Cuento con beneficios si mi trabajo es de temporada o me pagan en efectivo?', 'answer' => 'Con frecuencia sí. El pago en efectivo o la falta de contrato no eliminan sus derechos; muchos empleadores clasifican mal a sus trabajadores para evitar el seguro. Revisamos su situación gratis.' ),
                array( 'question' => '¿Cuánto tiempo tengo para reportar mi lesión en Myrtle Beach?', 'answer' => 'Reporte a su empleador dentro de 90 días y presente el reclamo formal dentro de 2 años (S.C. Code § 42-15-20). Hágalo por escrito lo antes posible.' ),
                array( 'question' => '¿Hablan español en su oficina de Myrtle Beach?', 'answer' => 'Sí. Todo su caso se maneja en español desde nuestra oficina de Murrells Inlet. Llame al (843) 612-1980 — la consulta es gratuita.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'workers-compensation-lawyers/myrtle-beach-sc not found or ES pillar missing.' ); }

/* 4. construction-accident-lawyers × myrtle-beach-sc */
$en_int    = roden_es_seed_find_intersection( 'construction-accident-lawyers', 'myrtle-beach-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'construction-accident-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Accidentes de Construcción en Myrtle Beach, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de accidentes de construcción en Myrtle Beach, SC. Hablamos español; su estatus migratorio no impide reclamar. Gratis: (843) 612-1980.',
        'content' => <<<'HTML'
<p>El Grand Strand no deja de construir: torres de condominios frente al mar, hoteles nuevos en Ocean Boulevard, urbanizaciones enteras en Carolina Forest y Conway. Esa construcción — hecha en gran parte por trabajadores hispanos — es de las más peligrosas del estado: caídas desde andamios y techos en edificios de gran altura, zanjas colapsadas, electrocuciones y golpes de grúas y maquinaria pesada.</p>
<p>Después de un accidente en la obra usted puede tener dos reclamos: la compensación laboral del seguro de su empleador y, muchas veces, una demanda contra terceros responsables — el contratista general, el dueño del proyecto, otro subcontratista o el fabricante de un equipo defectuoso. Esa demanda paga el dolor y sufrimiento que la compensación laboral nunca cubre. <strong>Su estatus migratorio no le impide reclamar</strong> y su consulta es confidencial.</p>
<p>Llame a nuestra oficina de <strong>631 Bellamy Ave., Suite C-B, Murrells Inlet</strong> al <a href="tel:+18436121980">(843) 612-1980</a>. El plazo general para demandar a terceros en Carolina del Sur es de <strong>3 años</strong> (S.C. Code § 15-3-530).</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de construcción en Myrtle Beach, SC. Hablamos español. Su estatus migratorio no impide reclamar. Gratis: (843) 612-1980.',
            '_roden_hero_intro'       => 'Si se lesionó construyendo un hotel, condominio o urbanización del Grand Strand, puede tener derecho a compensación laboral y a una demanda contra terceros. Se lo explicamos en español, sin costo.',
            '_roden_why_hire'         => '<p>En las torres y resorts del Grand Strand trabajan decenas de subcontratistas a la vez, y tras un accidente todos se culpan entre sí. Nosotros investigamos violaciones de seguridad de OSHA, identificamos a cada empresa responsable — incluido el contratista general y el dueño del proyecto — y coordinamos su compensación laboral con la demanda contra terceros para maximizar su recuperación total.</p><p>Sabemos que muchos trabajadores hispanos temen reclamar por su estatus o su empleo. La ley le protege, todo es confidencial y no cobramos a menos que ganemos. Llame a nuestra oficina de Murrells Inlet al (843) 612-1980.</p>',
            '_roden_key_takeaways'    => 'Tras un accidente de construcción en el área de Myrtle Beach, usted generalmente tiene 3 años para demandar a terceros responsables (S.C. Code § 15-3-530) y puede recuperar compensación si fue menos del 51% culpable; la compensación laboral corre por separado con plazos más cortos (reporte en 90 días, reclamo en 2 años, S.C. Code § 42-15-20). En las torres y resorts del Grand Strand el contratista general u otro subcontratista pueden deberle mucho más que el seguro de su empleador. Su estatus migratorio no impide ningún reclamo. La consulta en nuestra oficina de Murrells Inlet es gratuita y en español, sin honorarios a menos que ganemos.',
            '_roden_accident_phrase'  => 'un accidente de construcción',
            '_roden_faqs'             => array(
                array( 'question' => '¿Puedo demandar si ya recibo compensación laboral por mi accidente en la obra?', 'answer' => 'Muchas veces sí. No puede demandar a su propio empleador, pero sí al contratista general, al dueño del proyecto, a otros subcontratistas o al fabricante de un equipo defectuoso. Esa demanda cubre daños que la compensación laboral no paga.' ),
                array( 'question' => '¿Puedo reclamar si no tengo papeles?', 'answer' => 'Sí. Su estatus migratorio no le impide reclamar compensación laboral ni demandar a terceros en Carolina del Sur. Todo lo que nos cuente es confidencial.' ),
                array( 'question' => '¿Cuánto tiempo tengo para reclamar en Carolina del Sur?', 'answer' => 'La demanda contra terceros: generalmente 3 años (S.C. Code § 15-3-530). La compensación laboral: reporte dentro de 90 días y reclame dentro de 2 años (S.C. Code § 42-15-20).' ),
                array( 'question' => '¿Hablan español en su oficina de Myrtle Beach?', 'answer' => 'Sí. Le atendemos en español en cada etapa de su caso desde Murrells Inlet. Llame al (843) 612-1980 — la consulta es gratuita.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'construction-accident-lawyers/myrtle-beach-sc not found or ES pillar missing.' ); }

WP_CLI::log( '═══ BATCH 20 DONE ═══' );
