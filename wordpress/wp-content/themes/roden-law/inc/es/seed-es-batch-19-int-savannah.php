<?php
/**
 * ES Seeder — Batch 19: Intersections × Savannah, GA (car, truck, workers-comp, construction).
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-19-int-savannah.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 19 — INTERSECCIONES: SAVANNAH, GA ═══' );

/* 1. car-accident-lawyers × savannah-ga */
$en_int    = roden_es_seed_find_intersection( 'car-accident-lawyers', 'savannah-ga' );
$es_parent = roden_es_seed_es_pillar_id( 'car-accident-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Accidentes de Auto en Savannah, GA',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de accidentes de auto en Savannah, GA que hablan español. Oficina en Commercial Drive. Consulta gratuita: (912) 303-5850.',
        'content' => <<<'HTML'
<p>Entre la I-95 en Pooler, la I-16, la I-516 que sale del puerto, DeRenne Avenue, Abercorn Street y la cuadrícula histórica del centro llena de turistas, manejar en Savannah es un riesgo diario. Si un conductor negligente lo lesionó a usted o a un ser querido, la oficina principal de Roden Law en <strong>333 Commercial Dr.</strong>, cerca del Oglethorpe Mall, está lista para defenderle. Llame al <a href="tel:+19123035850">(912) 303-5850</a> — la consulta es gratuita y en español.</p>
<p>Representamos a víctimas de accidentes en Savannah, Pooler, Garden City, Richmond Hill, Hinesville y todo el sureste de Georgia. Su caso se presentaría ante los tribunales del condado de Chatham, donde nuestros abogados litigan con regularidad.</p>
<p>En Georgia usted generalmente tiene <strong>2 años</strong> para presentar su demanda (O.C.G.A. § 9-3-33) — un plazo más corto que en otros estados. Guarde el informe policial, tome fotos y llámenos antes de hablar con la aseguradora.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de auto en Savannah, GA. Hablamos español. Oficina en Commercial Drive. Consulta gratuita: (912) 303-5850.',
            '_roden_hero_intro'       => 'Si un choque en la I-95, DeRenne Avenue o cualquier calle de Savannah cambió su vida, nuestros abogados de accidentes de auto reclaman la compensación completa que le corresponde — en español.',
            '_roden_why_hire'         => '<p>Roden Law nació en Savannah, y aquí está nuestra oficina principal. Investigamos su choque a fondo, preservamos videos y testigos antes de que desaparezcan, documentamos sus lesiones con expertos médicos y usamos ventajas de la ley de Georgia — como el apilamiento de cobertura UM/UIM bajo O.C.G.A. § 33-7-11 — para maximizar su recuperación cuando la póliza del culpable no alcanza.</p><p>Hemos recuperado más de $300 millones para nuestros clientes en más de 5,000 casos. Le atendemos en español y no cobramos honorarios a menos que ganemos. Llame al (912) 303-5850.</p>',
            '_roden_key_takeaways'    => 'Después de un accidente de auto en Savannah, usted generalmente tiene solo 2 años para presentar su demanda en Georgia (O.C.G.A. § 9-3-33) y puede recuperar compensación siempre que haya sido menos del 50% culpable (O.C.G.A. § 51-12-33). Los corredores de la I-95, la I-16 y DeRenne Avenue concentran los choques más graves del condado de Chatham, y Georgia permite apilar cobertura UM/UIM cuando el seguro del culpable no alcanza. La consulta en nuestra oficina de Commercial Drive es gratuita y en español, sin honorarios a menos que ganemos su caso.',
            '_roden_accident_phrase'  => 'un accidente de auto',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto tiempo tengo en Georgia para demandar después de un accidente en Savannah?', 'answer' => 'Por lo general, solo 2 años desde la fecha del choque (O.C.G.A. § 9-3-33). Si una entidad del gobierno está involucrada, los plazos de notificación son aún más cortos. Llame cuanto antes.' ),
                array( 'question' => '¿Hablan español en su oficina de Savannah?', 'answer' => 'Sí. Nuestro equipo de Commercial Drive le atiende en español desde la primera llamada hasta el cierre de su caso. Llame al (912) 303-5850.' ),
                array( 'question' => '¿Qué pasa si yo tuve parte de la culpa del choque?', 'answer' => 'En Georgia puede recuperar compensación siempre que haya sido menos del 50% culpable (O.C.G.A. § 51-12-33); su compensación se reduce según su porcentaje de culpa. No acepte la versión de la aseguradora sin hablar con un abogado.' ),
                array( 'question' => '¿Cuánto cuesta contratarlos?', 'answer' => 'Nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos si recuperamos dinero para usted. La consulta es gratuita.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'car-accident-lawyers/savannah-ga not found or ES pillar missing.' ); }

/* 2. truck-accident-lawyers × savannah-ga */
$en_int    = roden_es_seed_find_intersection( 'truck-accident-lawyers', 'savannah-ga' );
$es_parent = roden_es_seed_es_pillar_id( 'truck-accident-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Accidentes de Camiones en Savannah, GA',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de accidentes de camiones en Savannah, GA. Enfrentamos a las transportistas del puerto de Savannah. Gratis en español: (912) 303-5850.',
        'content' => <<<'HTML'
<p>El puerto de Savannah es uno de los más activos del país, y su carga viaja en camión por la I-516, la I-16 y la I-95, con el intercambio I-16/I-95 como punto crítico de choques comerciales. Cuando un camión de 80,000 libras causa una tragedia, la transportista y su aseguradora despliegan investigadores en horas. Usted necesita la misma velocidad de su lado.</p>
<p>Desde nuestra oficina principal en <strong>333 Commercial Dr.</strong>, los abogados de Roden Law envían cartas de preservación el mismo día — caja negra, registros de horas del conductor, GPS y mantenimiento — e invocan ventajas de la ley de Georgia como la acción directa contra la aseguradora de la transportista bajo O.C.G.A. § 40-1-112. Llame al <a href="tel:+19123035850">(912) 303-5850</a> — la consulta es gratuita y en español.</p>
<p>En Georgia el plazo general es de solo <strong>2 años</strong> (O.C.G.A. § 9-3-33), y la evidencia electrónica del camión puede borrarse legalmente mucho antes. No espere.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de camiones en Savannah, GA. Enfrentamos a las transportistas del puerto. Hablamos español. Gratis: (912) 303-5850.',
            '_roden_hero_intro'       => 'Los camiones del puerto de Savannah dominan la I-16, la I-95 y la I-516. Si uno de ellos lo lesionó, preservamos la evidencia y enfrentamos a la compañía de transporte — en su idioma.',
            '_roden_why_hire'         => '<p>Los casos de camiones en Savannah exigen conocer las regulaciones federales de la FMCSA y las herramientas propias de Georgia: O.C.G.A. § 40-1-112 permite demandar directamente a la aseguradora de la transportista, y O.C.G.A. § 33-7-11 permite apilar cobertura UM/UIM por encima de los límites del culpable. Investigamos al conductor, a la empresa y a quien cargó el contenedor, con expertos en reconstrucción de accidentes.</p><p>Nuestro equipo litiga los casos de camiones del corredor portuario con regularidad. Más de $300 millones recuperados, consultas en español y sin honorarios a menos que ganemos. Llame al (912) 303-5850.</p>',
            '_roden_key_takeaways'    => 'Si un camión lo lesionó en Savannah, usted generalmente tiene solo 2 años para demandar en Georgia (O.C.G.A. § 9-3-33) y puede recuperar compensación si fue menos del 50% culpable (O.C.G.A. § 51-12-33). Los choques del corredor portuario — I-16, I-95 e I-516 — suelen involucrar a varias empresas, y Georgia permite demandar directamente a la aseguradora de la transportista (O.C.G.A. § 40-1-112). La evidencia electrónica se borra en semanas, así que actúe ya: la consulta en nuestra oficina de Commercial Drive es gratuita y en español, sin honorarios a menos que ganemos.',
            '_roden_accident_phrase'  => 'un accidente de camión',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto tiempo tengo en Georgia para demandar por un accidente de camión?', 'answer' => 'En general, solo 2 años (O.C.G.A. § 9-3-33). Pero la caja negra y los registros del conductor pueden borrarse legalmente en semanas si un abogado no exige su preservación de inmediato.' ),
                array( 'question' => '¿Contra quién se reclama en un choque con un camión del puerto de Savannah?', 'answer' => 'Puede haber varias partes: el conductor, la transportista, el dueño del chasis o remolque y quien cargó el contenedor. Georgia además permite demandar directamente a la aseguradora de la transportista (O.C.G.A. § 40-1-112).' ),
                array( 'question' => '¿Hablan español en su oficina de Savannah?', 'answer' => 'Sí. Le atendemos en español desde la consulta gratuita hasta el final de su caso. Llame al (912) 303-5850.' ),
                array( 'question' => '¿Cuánto cuesta contratarlos?', 'answer' => 'Nada por adelantado. Solo cobramos un porcentaje si recuperamos dinero para usted. Si no ganamos, no nos debe honorarios.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'truck-accident-lawyers/savannah-ga not found or ES pillar missing.' ); }

/* 3. workers-compensation-lawyers × savannah-ga */
$en_int    = roden_es_seed_find_intersection( 'workers-compensation-lawyers', 'savannah-ga' );
$es_parent = roden_es_seed_es_pillar_id( 'workers-compensation-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Compensación Laboral en Savannah, GA',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de compensación laboral en Savannah, GA que hablan español. Su estatus migratorio no impide beneficios. Consulta gratuita: (912) 303-5850.',
        'content' => <<<'HTML'
<p>Savannah trabaja duro: las bodegas y terminales del puerto, la construcción que no se detiene en Pooler y el west side, los hoteles y restaurantes del distrito histórico, las plantas de manufactura del condado de Chatham. Si una lesión en el trabajo lo dejó sin poder ganarse la vida, la compensación laboral de Georgia debe cubrir su atención médica y parte de su salario — sin importar de quién fue la culpa.</p>
<p>Las aseguradoras niegan o recortan reclamos válidos todos los días, y presionan más cuando el trabajador no habla inglés. En Roden Law usted cuenta su caso en español en nuestra oficina de <strong>333 Commercial Dr.</strong> <strong>Su estatus migratorio no le impide recibir beneficios de compensación laboral en Georgia</strong>, y su consulta es siempre confidencial. Llame al <a href="tel:+19123035850">(912) 303-5850</a>.</p>
<p>Los plazos de Georgia son de los más cortos: reporte su lesión a su empleador dentro de <strong>30 días</strong> y presente su reclamo dentro de <strong>1 año</strong> (O.C.G.A. § 34-9-82).</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de compensación laboral en Savannah, GA. Hablamos español. Su estatus migratorio no impide beneficios. Gratis: (912) 303-5850.',
            '_roden_hero_intro'       => 'Si se lesionó trabajando en el puerto, una obra, un hotel o una bodega de Savannah, tiene derecho a beneficios de compensación laboral — sin importar su estatus migratorio. Le atendemos en español.',
            '_roden_why_hire'         => '<p>Los plazos de Georgia perdonan poco: 30 días para reportar y 1 año para reclamar. Nosotros presentamos su reclamo correctamente ante la State Board of Workers’ Compensation, peleamos las negaciones, nos aseguramos de que vea a los médicos adecuados y calculamos sus beneficios completos por incapacidad temporal o permanente.</p><p>Conocemos el miedo a represalias que sienten muchos trabajadores hispanos de Savannah. La ley le protege sin importar su estatus, todo es confidencial y no cobramos honorarios a menos que recuperemos beneficios para usted. Llame al (912) 303-5850.</p>',
            '_roden_key_takeaways'    => 'Si se lesionó en el trabajo en Savannah, los plazos de Georgia son cortos: reporte la lesión a su empleador dentro de 30 días y presente su reclamo de compensación laboral dentro de 1 año (O.C.G.A. § 34-9-82). El sistema no exige probar culpa: cubre su atención médica y parte de su salario aunque el accidente haya sido en parte su error, incluidas las lesiones en el puerto, las bodegas y las obras del condado de Chatham. Su estatus migratorio no le impide recibir beneficios y su consulta es confidencial. En nuestra oficina de Commercial Drive la consulta es gratuita y en español, sin honorarios a menos que ganemos.',
            '_roden_accident_phrase'  => 'una lesión en el trabajo',
            '_roden_faqs'             => array(
                array( 'question' => '¿Puedo recibir compensación laboral en Georgia si no tengo papeles?', 'answer' => 'Sí. Los trabajadores lesionados tienen derecho a beneficios de compensación laboral en Georgia sin importar su estatus migratorio. Su consulta es confidencial.' ),
                array( 'question' => '¿Cuánto tiempo tengo para reportar mi lesión en Savannah?', 'answer' => 'Reporte a su empleador dentro de 30 días y presente el reclamo formal dentro de 1 año (O.C.G.A. § 34-9-82). Son plazos muy cortos — repórtelo por escrito de inmediato y llámenos.' ),
                array( 'question' => '¿Qué cubre la compensación laboral de Georgia?', 'answer' => 'La atención médica relacionada con su lesión, aproximadamente dos tercios de su salario semanal mientras no pueda trabajar y beneficios por incapacidad permanente si queda con secuelas.' ),
                array( 'question' => '¿Hablan español en su oficina de Savannah?', 'answer' => 'Sí. Todo su caso se maneja en español, desde la consulta gratuita hasta la audiencia. Llame al (912) 303-5850.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'workers-compensation-lawyers/savannah-ga not found or ES pillar missing.' ); }

/* 4. construction-accident-lawyers × savannah-ga */
$en_int    = roden_es_seed_find_intersection( 'construction-accident-lawyers', 'savannah-ga' );
$es_parent = roden_es_seed_es_pillar_id( 'construction-accident-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Accidentes de Construcción en Savannah, GA',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de accidentes de construcción en Savannah, GA. Hablamos español; su estatus migratorio no impide reclamar. Gratis: (912) 303-5850.',
        'content' => <<<'HTML'
<p>Savannah crece por todos lados: bodegas y centros de distribución alrededor del puerto, plantas industriales camino a Pooler, hoteles en el distrito histórico y urbanizaciones nuevas por toda la región. Gran parte de esa construcción la levantan trabajadores hispanos — y las caídas de altura, los derrumbes de zanjas, las electrocuciones y los golpes de maquinaria pesada cobran víctimas cada año.</p>
<p>Después de un accidente en la obra usted puede tener dos reclamos: la compensación laboral del seguro de su empleador y, con frecuencia, una demanda contra terceros responsables — el contratista general, otro subcontratista o el fabricante de un equipo defectuoso. Esa demanda adicional paga el dolor y sufrimiento que la compensación laboral no cubre. <strong>Su estatus migratorio no le impide reclamar</strong> y su consulta es confidencial.</p>
<p>Llame a nuestra oficina de <strong>333 Commercial Dr.</strong> al <a href="tel:+19123035850">(912) 303-5850</a>. En Georgia el plazo para demandar a terceros es de solo <strong>2 años</strong> (O.C.G.A. § 9-3-33) — actúe pronto.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de construcción en Savannah, GA. Hablamos español. Su estatus migratorio no impide reclamar. Gratis: (912) 303-5850.',
            '_roden_hero_intro'       => 'Si un accidente en una obra de Savannah lo lesionó, puede tener derecho a compensación laboral y a una demanda contra terceros responsables. Le explicamos sus opciones en español, gratis.',
            '_roden_why_hire'         => '<p>La escena de una obra cambia en días y los subcontratistas se dispersan. Nosotros actuamos de inmediato: documentamos la escena, investigamos violaciones de seguridad de OSHA, identificamos a cada empresa responsable y coordinamos su reclamo de compensación laboral con la demanda contra terceros para que un reclamo no reduzca al otro.</p><p>Sabemos que muchos trabajadores hispanos de Savannah temen reclamar por su estatus o por miedo a perder el empleo. La ley le protege, todo es confidencial y no cobramos honorarios a menos que ganemos. Llame al (912) 303-5850.</p>',
            '_roden_key_takeaways'    => 'Tras un accidente de construcción en Savannah, usted generalmente tiene solo 2 años para demandar a terceros responsables en Georgia (O.C.G.A. § 9-3-33) y puede recuperar compensación si fue menos del 50% culpable (O.C.G.A. § 51-12-33); su reclamo de compensación laboral corre por separado con plazos aún más cortos (reporte en 30 días, reclamo en 1 año, O.C.G.A. § 34-9-82). El contratista general u otro subcontratista pueden deberle mucho más que el seguro de su empleador. Su estatus migratorio no impide ningún reclamo. La consulta en nuestra oficina de Commercial Drive es gratuita y en español, sin honorarios a menos que ganemos.',
            '_roden_accident_phrase'  => 'un accidente de construcción',
            '_roden_faqs'             => array(
                array( 'question' => '¿Puedo demandar además de recibir compensación laboral por mi accidente en la obra?', 'answer' => 'Muchas veces sí. No puede demandar a su propio empleador, pero sí al contratista general, a otros subcontratistas o al fabricante de un equipo defectuoso. Esa demanda cubre el dolor y sufrimiento que la compensación laboral no paga.' ),
                array( 'question' => '¿Puedo reclamar si no tengo papeles?', 'answer' => 'Sí. Su estatus migratorio no le impide reclamar compensación laboral ni demandar a terceros en Georgia. Todo lo que nos cuente es confidencial.' ),
                array( 'question' => '¿Cuánto tiempo tengo para reclamar en Georgia?', 'answer' => 'La demanda contra terceros: generalmente 2 años (O.C.G.A. § 9-3-33). La compensación laboral: reporte dentro de 30 días y reclame dentro de 1 año (O.C.G.A. § 34-9-82).' ),
                array( 'question' => '¿Hablan español en su oficina de Savannah?', 'answer' => 'Sí. Le atendemos en español en cada etapa de su caso. Llame al (912) 303-5850 — la consulta es gratuita.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'construction-accident-lawyers/savannah-ga not found or ES pillar missing.' ); }

WP_CLI::log( '═══ BATCH 19 DONE ═══' );
