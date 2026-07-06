<?php
/**
 * ES Seeder — Batch 18: Intersections × Columbia, SC (car, truck, workers-comp, construction).
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-18-int-columbia.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 18 — INTERSECCIONES: COLUMBIA, SC ═══' );

/* 1. car-accident-lawyers × columbia-sc */
$en_int    = roden_es_seed_find_intersection( 'car-accident-lawyers', 'columbia-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'car-accident-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Accidentes de Auto en Columbia, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de accidentes de auto en Columbia, SC que hablan español. Oficina en Sumter Street, centro de Columbia. Consulta gratuita: (803) 219-2816.',
        'content' => <<<'HTML'
<p>En Columbia se cruzan tres interestatales — la I-20, la I-26 y la I-77 — en el intercambio conocido como "Malfunction Junction", hoy en plena reconstrucción bajo el proyecto Carolina Crossroads, de miles de millones de dólares. Entre las zonas de obra en constante cambio, el tráfico de la capital y corredores como Two Notch Road y Broad River Road, los choques graves son parte de la vida diaria del Midlands. Si uno de ellos cambió la suya, la oficina de Roden Law en <strong>1545 Sumter St., Suite B</strong>, en el centro de Columbia, está lista para ayudarle. Llame al <a href="tel:+18032192816">(803) 219-2816</a> — la consulta es gratuita y en español.</p>
<p>Representamos a víctimas en Columbia, Lexington, Irmo, West Columbia, Cayce y Forest Acres. Su caso se presenta ante el Richland County Court of Common Pleas, a pocas cuadras de nuestra oficina.</p>
<p>En Carolina del Sur usted generalmente tiene <strong>3 años</strong> para demandar (S.C. Code § 15-3-530). No firme nada de la aseguradora antes de hablar con un abogado.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de auto en Columbia, SC. Hablamos español. Oficina en Sumter Street. Consulta gratuita: (803) 219-2816. Sin honorarios si no ganamos.',
            '_roden_hero_intro'       => 'Si un conductor negligente lo lesionó en la I-26, la I-77 o cualquier calle de Columbia, nuestros abogados de accidentes de auto reclaman cada dólar que le corresponde — en español.',
            '_roden_why_hire'         => '<p>Los choques en las zonas de obra de Carolina Crossroads y en Malfunction Junction suelen involucrar a varios vehículos, contratistas viales y aseguradoras que se culpan entre sí. Nosotros investigamos a fondo, preservamos videos y datos antes de que desaparezcan, y usamos la cobertura UM/UIM apilable de Carolina del Sur cuando el conductor culpable lleva solo la póliza mínima.</p><p>Nuestra oficina de Sumter Street está en el centro de Columbia, cerca del tribunal, y le atendemos en español en cada etapa. Más de $300 millones recuperados y sin honorarios a menos que ganemos. Llame al (803) 219-2816.</p>',
            '_roden_key_takeaways'    => 'Después de un accidente de auto en Columbia, usted generalmente tiene 3 años para presentar su demanda en Carolina del Sur (S.C. Code § 15-3-530) y puede recuperar compensación siempre que haya sido menos del 51% culpable. Los choques en Malfunction Junction y las zonas de obra de Carolina Crossroads suelen involucrar a varias partes, y Carolina del Sur permite apilar cobertura UM/UIM cuando la póliza del culpable no alcanza. La consulta en nuestra oficina de Sumter Street es gratuita y en español, y no paga honorarios a menos que ganemos su caso.',
            '_roden_accident_phrase'  => 'un accidente de auto',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto tiempo tengo en Carolina del Sur para demandar después de un accidente en Columbia?', 'answer' => 'Por lo general, 3 años desde la fecha del choque (S.C. Code § 15-3-530). Si el SCDOT o un contratista de Carolina Crossroads está involucrado, aplican plazos de notificación más cortos — llame cuanto antes.' ),
                array( 'question' => '¿Hablan español en su oficina de Columbia?', 'answer' => 'Sí. Nuestro equipo de Sumter Street le atiende en español desde la primera llamada hasta el cierre de su caso. Llame al (803) 219-2816.' ),
                array( 'question' => '¿Qué pasa si el conductor culpable casi no tiene seguro?', 'answer' => 'Carolina del Sur permite apilar su propia cobertura de motorista sin seguro o con seguro insuficiente (UM/UIM). Revisamos todas las pólizas disponibles para encontrar cada fuente de compensación.' ),
                array( 'question' => '¿Cuánto cuesta contratarlos?', 'answer' => 'Nada por adelantado. Solo cobramos un porcentaje si recuperamos dinero para usted. La consulta inicial es gratuita.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'car-accident-lawyers/columbia-sc not found or ES pillar missing.' ); }

/* 2. truck-accident-lawyers × columbia-sc */
$en_int    = roden_es_seed_find_intersection( 'truck-accident-lawyers', 'columbia-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'truck-accident-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Accidentes de Camiones en Columbia, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de accidentes de camiones en Columbia, SC. Choques en la I-20, I-26 e I-77. Consulta gratuita en español: (803) 219-2816.',
        'content' => <<<'HTML'
<p>Toda la carga que cruza Carolina del Sur pasa por Columbia: la I-20, la I-26 y la I-77 convergen en Malfunction Junction, y las zonas de obra del proyecto Carolina Crossroads estrechan carriles y frenan el tráfico frente a camiones de 80,000 libras. Cuando un camión comercial no puede detenerse a tiempo, las lesiones son catastróficas — y la compañía de transporte empieza a defenderse ese mismo día.</p>
<p>Los abogados de Roden Law en <strong>1545 Sumter St., Suite B</strong> actúan de inmediato: cartas de preservación para la caja negra, los registros de horas del conductor, el GPS y el historial de mantenimiento, e investigación de violaciones de las reglas federales de la FMCSA. Llame al <a href="tel:+18032192816">(803) 219-2816</a> — la consulta es gratuita y en español.</p>
<p>En Carolina del Sur el plazo general es de <strong>3 años</strong> (S.C. Code § 15-3-530), pero la evidencia electrónica puede borrarse legalmente en semanas. No espere.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de camiones en Columbia, SC. Choques en I-20, I-26 e I-77. Hablamos español. Consulta gratuita: (803) 219-2816.',
            '_roden_hero_intro'       => 'Si un camión comercial lo lesionó en Malfunction Junction o en cualquier corredor de Columbia, enfrentamos a la compañía de transporte y a sus aseguradoras — en su idioma.',
            '_roden_why_hire'         => '<p>Un caso de camión exige recursos: expertos en reconstrucción, análisis de datos electrónicos y conocimiento de las regulaciones federales. Investigamos si el conductor excedió sus horas de servicio, si la carga iba mal asegurada y si la empresa contrató o supervisó con negligencia — y demandamos a cada parte responsable, no solo al conductor.</p><p>Litigamos ante el Richland County Court of Common Pleas, a pocas cuadras de nuestra oficina de Sumter Street, y le atendemos en español en todo momento. Más de $300 millones recuperados, sin honorarios a menos que ganemos. Llame al (803) 219-2816.</p>',
            '_roden_key_takeaways'    => 'Si un camión lo lesionó en Columbia, usted generalmente tiene 3 años para demandar en Carolina del Sur (S.C. Code § 15-3-530) y puede recuperar compensación si fue menos del 51% culpable. Los choques de camiones en Malfunction Junction y las zonas de obra de Carolina Crossroads suelen involucrar a la transportista, a contratistas viales y a varias aseguradoras, y la evidencia electrónica del camión se borra en semanas si nadie la exige. La consulta en nuestra oficina de Sumter Street es gratuita y en español, sin honorarios a menos que ganemos.',
            '_roden_accident_phrase'  => 'un accidente de camión',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto tiempo tengo en Carolina del Sur para demandar por un accidente de camión?', 'answer' => 'En general, 3 años (S.C. Code § 15-3-530). Pero la caja negra, los registros de horas y el GPS pueden borrarse legalmente en semanas — un abogado debe exigir su preservación de inmediato.' ),
                array( 'question' => '¿Por qué vale más un caso de camión que uno de auto?', 'answer' => 'Los camiones comerciales llevan pólizas mucho mayores y suele haber varias partes responsables: el conductor, la transportista, el dueño del remolque y quien cargó la mercancía. Identificarlas a todas cambia el valor del caso.' ),
                array( 'question' => '¿Hablan español en su oficina de Columbia?', 'answer' => 'Sí. Le atendemos en español desde la consulta gratuita hasta el final. Llame al (803) 219-2816.' ),
                array( 'question' => '¿Cuánto cuesta contratarlos?', 'answer' => 'Nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos si recuperamos dinero para usted.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'truck-accident-lawyers/columbia-sc not found or ES pillar missing.' ); }

/* 3. workers-compensation-lawyers × columbia-sc */
$en_int    = roden_es_seed_find_intersection( 'workers-compensation-lawyers', 'columbia-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'workers-compensation-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Compensación Laboral en Columbia, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de compensación laboral en Columbia, SC que hablan español. Su estatus migratorio no impide beneficios. Consulta gratuita: (803) 219-2816.',
        'content' => <<<'HTML'
<p>Los trabajadores del Midlands sostienen la capital: cocinas y hoteles del Vista, bodegas y plantas a lo largo de la I-77, cuadrillas viales en las obras de Carolina Crossroads, jardinería y construcción en Lexington e Irmo. Cuando una lesión en el trabajo lo deja sin ingresos, la compensación laboral de Carolina del Sur debe cubrir su atención médica y parte de su salario — sin importar de quién fue la culpa.</p>
<p>Pero las aseguradoras niegan reclamos válidos todos los días, y presionan más cuando el trabajador no habla inglés. En Roden Law usted cuenta su caso en español en nuestra oficina de <strong>1545 Sumter St., Suite B</strong>. <strong>Su estatus migratorio no le impide recibir beneficios</strong> y su consulta es confidencial. Llame al <a href="tel:+18032192816">(803) 219-2816</a>.</p>
<p>Los plazos son cortos: reporte su lesión dentro de <strong>90 días</strong> y presente el reclamo dentro de <strong>2 años</strong> (S.C. Code § 42-15-20).</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de compensación laboral en Columbia, SC. Hablamos español. Su estatus migratorio no impide beneficios. Gratis: (803) 219-2816.',
            '_roden_hero_intro'       => 'Si se lesionó trabajando en Columbia — en una obra, bodega, cocina o cuadrilla vial — tiene derecho a beneficios de compensación laboral, sin importar su estatus migratorio. Le atendemos en español.',
            '_roden_why_hire'         => '<p>Presentamos su reclamo correctamente ante la South Carolina Workers’ Compensation Commission, peleamos las negaciones, nos aseguramos de que reciba tratamiento médico completo y calculamos sus beneficios por incapacidad temporal o permanente — incluyendo compensación por lesiones que le dejan secuelas de por vida.</p><p>Sabemos que muchos trabajadores hispanos del Midlands temen reclamar. La ley le protege sin importar su estatus, todo es confidencial y no cobramos honorarios a menos que recuperemos beneficios para usted. Llame a nuestra oficina del centro de Columbia al (803) 219-2816.</p>',
            '_roden_key_takeaways'    => 'Si se lesionó en el trabajo en Columbia, reporte la lesión a su empleador dentro de 90 días y presente su reclamo de compensación laboral dentro de 2 años (S.C. Code § 42-15-20). El sistema de Carolina del Sur no exige probar culpa: cubre su atención médica y cerca de dos tercios de su salario mientras no pueda trabajar. Su estatus migratorio no le impide recibir beneficios y su consulta es confidencial. En nuestra oficina de Sumter Street la consulta es gratuita y en español, y no paga honorarios a menos que ganemos.',
            '_roden_accident_phrase'  => 'una lesión en el trabajo',
            '_roden_faqs'             => array(
                array( 'question' => '¿Puedo recibir compensación laboral en Carolina del Sur si no tengo papeles?', 'answer' => 'Sí. Los trabajadores lesionados tienen derecho a beneficios sin importar su estatus migratorio. Su consulta es confidencial y su empleador no puede tomar represalias legales por reclamar.' ),
                array( 'question' => '¿Cuánto tiempo tengo para reportar mi lesión en Columbia?', 'answer' => 'Reporte a su empleador dentro de 90 días y presente el reclamo formal dentro de 2 años (S.C. Code § 42-15-20). Hágalo por escrito lo antes posible.' ),
                array( 'question' => '¿Qué pasa si la aseguradora niega mi reclamo?', 'answer' => 'Una negación no es el final. Podemos solicitar una audiencia ante la South Carolina Workers’ Compensation Commission y pelear por sus beneficios completos.' ),
                array( 'question' => '¿Hablan español en su oficina de Columbia?', 'answer' => 'Sí. Todo su caso se maneja en español, desde la consulta gratuita hasta la audiencia. Llame al (803) 219-2816.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'workers-compensation-lawyers/columbia-sc not found or ES pillar missing.' ); }

/* 4. construction-accident-lawyers × columbia-sc */
$en_int    = roden_es_seed_find_intersection( 'construction-accident-lawyers', 'columbia-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'construction-accident-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Accidentes de Construcción en Columbia, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de accidentes de construcción en Columbia, SC. Hablamos español; su estatus migratorio no impide reclamar. Gratis: (803) 219-2816.',
        'content' => <<<'HTML'
<p>Columbia construye a un ritmo que el Midlands no había visto: el proyecto vial Carolina Crossroads — descrito por el SCDOT como el más grande de su historia —, apartamentos cerca de la universidad, bodegas junto a la I-77 y urbanizaciones en Lexington y Blythewood. Gran parte de esa obra la levantan trabajadores hispanos, y cada semana alguno paga el precio: caídas de altura, zanjas colapsadas, electrocuciones, golpes de maquinaria.</p>
<p>Después de un accidente de construcción usted puede tener dos reclamos: la compensación laboral del seguro de su empleador y, muchas veces, una demanda contra terceros responsables — el contratista general, otro subcontratista o el fabricante de un equipo defectuoso. Esa demanda adicional paga lo que la compensación laboral no cubre, como el dolor y sufrimiento. <strong>Su estatus migratorio no le impide reclamar</strong> y su consulta es confidencial.</p>
<p>Llame a nuestra oficina de <strong>1545 Sumter St., Suite B</strong> al <a href="tel:+18032192816">(803) 219-2816</a>. El plazo general para demandar a terceros en Carolina del Sur es de <strong>3 años</strong> (S.C. Code § 15-3-530).</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de construcción en Columbia, SC. Hablamos español. Su estatus migratorio no impide reclamar. Gratis: (803) 219-2816.',
            '_roden_hero_intro'       => 'Si se lesionó en una obra de Columbia — incluidas las zonas de trabajo de Carolina Crossroads — puede tener derecho a compensación laboral y a una demanda contra terceros. Se lo explicamos en español, gratis.',
            '_roden_why_hire'         => '<p>Las obras grandes del Midlands mezclan a decenas de contratistas, y cuando un trabajador se lesiona todos se señalan entre sí. Nosotros investigamos violaciones de seguridad de OSHA, identificamos a cada empresa responsable y coordinamos su compensación laboral con la demanda contra terceros para que reciba la recuperación máxima total.</p><p>Entendemos el miedo a represalias o a perder el trabajo que sienten muchos trabajadores hispanos. La ley le protege sin importar su estatus migratorio, todo es confidencial y no cobramos a menos que ganemos. Llame al (803) 219-2816.</p>',
            '_roden_key_takeaways'    => 'Tras un accidente de construcción en Columbia, usted generalmente tiene 3 años para demandar a terceros responsables (S.C. Code § 15-3-530) y puede recuperar compensación si fue menos del 51% culpable; la compensación laboral corre por separado (reporte en 90 días, reclamo en 2 años, S.C. Code § 42-15-20). En obras como Carolina Crossroads suele haber varios contratistas responsables además de su empleador, y esa demanda adicional puede valer mucho más. Su estatus migratorio no impide ningún reclamo. La consulta en nuestra oficina de Sumter Street es gratuita y en español, sin honorarios a menos que ganemos.',
            '_roden_accident_phrase'  => 'un accidente de construcción',
            '_roden_faqs'             => array(
                array( 'question' => '¿Puedo demandar si ya recibo compensación laboral por mi accidente en la obra?', 'answer' => 'Muchas veces sí. No puede demandar a su propio empleador, pero sí al contratista general, a otros subcontratistas o al fabricante de un equipo defectuoso. Esa demanda cubre daños que la compensación laboral no paga.' ),
                array( 'question' => '¿Puedo reclamar si no tengo papeles?', 'answer' => 'Sí. Su estatus migratorio no le impide reclamar compensación laboral ni demandar a terceros en Carolina del Sur. Su consulta es confidencial.' ),
                array( 'question' => '¿Cuánto tiempo tengo para reclamar en Carolina del Sur?', 'answer' => 'La demanda contra terceros: generalmente 3 años (S.C. Code § 15-3-530). La compensación laboral: reporte dentro de 90 días y reclame dentro de 2 años (S.C. Code § 42-15-20).' ),
                array( 'question' => '¿Hablan español en su oficina de Columbia?', 'answer' => 'Sí. Le atendemos en español en cada etapa. Llame al (803) 219-2816 — la consulta es gratuita.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'construction-accident-lawyers/columbia-sc not found or ES pillar missing.' ); }

WP_CLI::log( '═══ BATCH 18 DONE ═══' );
