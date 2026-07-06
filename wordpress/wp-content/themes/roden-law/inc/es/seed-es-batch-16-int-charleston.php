<?php
/**
 * ES Seeder — Batch 16: Intersections × Charleston, SC (car, truck, workers-comp, construction).
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-16-int-charleston.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 16 — INTERSECCIONES: CHARLESTON, SC ═══' );

/* 1. car-accident-lawyers × charleston-sc */
$en_int    = roden_es_seed_find_intersection( 'car-accident-lawyers', 'charleston-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'car-accident-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Accidentes de Auto en Charleston, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de accidentes de auto en Charleston, SC que hablan español. Oficina en King Street. Consulta gratuita: (843) 790-8999. Sin honorarios a menos que ganemos.',
        'content' => <<<'HTML'
<p>El tráfico de Charleston castiga a los conductores todos los días: la I-26 y la I-526 al oeste de la península, el Crosstown (US-17), el puente Ravenel hacia Mount Pleasant y el laberinto turístico de King y Market Street, donde conductores de otros estados, rideshare y coches de caballos comparten calles angostas. Si un choque en cualquiera de estos corredores cambió su vida, la oficina de Roden Law en <strong>127 King Street, Suite 200</strong> está a pocas cuadras del tribunal. Llame al <a href="tel:+18437908999">(843) 790-8999</a> — la consulta es gratuita y en español.</p>
<p>Representamos a víctimas de accidentes de auto en Charleston, Mount Pleasant, West Ashley, James Island, Johns Island y todo el Lowcountry. Su caso se presentaría ante el Charleston County Court of Common Pleas, en 100 Broad Street, donde nuestros abogados litigan con regularidad.</p>
<p>En Carolina del Sur usted generalmente tiene <strong>3 años</strong> para presentar su demanda (S.C. Code § 15-3-530), pero la evidencia — videos de cámaras, testigos, datos del vehículo — desaparece en semanas. No hable con la aseguradora del otro conductor antes de hablar con nosotros.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de auto en Charleston, SC. Hablamos español. Oficina en King Street. Consulta gratuita: (843) 790-8999. Sin honorarios si no ganamos.',
            '_roden_hero_intro'       => 'Si un conductor negligente lo lesionó en la I-26, el Crosstown o cualquier calle de Charleston, nuestros abogados de accidentes de auto pelean por cada dólar que le corresponde — en su idioma.',
            '_roden_why_hire'         => '<p>Las aseguradoras saben qué víctimas están representadas y cuáles no. Cuando Roden Law toma su caso, investigamos el choque a fondo, obtenemos el informe policial y los videos de tráfico, documentamos sus lesiones con una red de expertos médicos y calculamos el valor completo de su reclamo: facturas médicas, salarios perdidos, dolor y sufrimiento.</p><p>Nuestra oficina de Charleston está en el corazón del centro, en King Street, y nuestro equipo atiende en español de principio a fin. Hemos recuperado más de $300 millones para nuestros clientes y no cobramos honorarios a menos que ganemos. Llame al (843) 790-8999.</p>',
            '_roden_key_takeaways'    => 'Si sufrió un accidente de auto en Charleston, en Carolina del Sur usted generalmente tiene 3 años desde la fecha del choque para presentar su demanda (S.C. Code § 15-3-530). Puede recuperar compensación siempre que haya sido menos del 51% culpable, incluso si compartió parte de la culpa. Los choques en la I-26, la I-526 y el Crosstown suelen involucrar a varias partes y aseguradoras, así que la investigación temprana es clave. La consulta con nuestra oficina de King Street es gratuita y en español, y no paga honorarios a menos que ganemos su caso.',
            '_roden_accident_phrase'  => 'un accidente de auto',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto tiempo tengo en Carolina del Sur para demandar después de un accidente de auto en Charleston?', 'answer' => 'Por lo general, 3 años desde la fecha del choque (S.C. Code § 15-3-530). Si el SCDOT o la Ciudad de Charleston están involucrados, los plazos de notificación son más cortos. Llame cuanto antes: la evidencia desaparece rápido.' ),
                array( 'question' => '¿Hablan español en su oficina de Charleston?', 'answer' => 'Sí. Nuestro equipo de King Street atiende consultas en español y le explica cada paso de su caso en su idioma. Llame al (843) 790-8999.' ),
                array( 'question' => '¿Cuánto cuesta contratar a un abogado de accidentes en Charleston?', 'answer' => 'Nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos un porcentaje si recuperamos dinero para usted. La consulta inicial es gratuita.' ),
                array( 'question' => '¿Puedo reclamar si no tengo papeles?', 'answer' => 'Sí. Su estatus migratorio no le impide reclamar compensación por un accidente en Carolina del Sur, y todo lo que comparta con nosotros es confidencial.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'car-accident-lawyers/charleston-sc not found or ES pillar missing.' ); }

/* 2. truck-accident-lawyers × charleston-sc */
$en_int    = roden_es_seed_find_intersection( 'truck-accident-lawyers', 'charleston-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'truck-accident-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Accidentes de Camiones en Charleston, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de accidentes de camiones en Charleston, SC. Enfrentamos a las compañías de transporte del puerto. Consulta gratuita en español: (843) 790-8999.',
        'content' => <<<'HTML'
<p>El puerto de Charleston mueve miles de contenedores al día, y cada uno viaja en camión por la I-26, la I-526 y las avenidas del área metropolitana. Los corredores de la I-26 y la I-526 concentran algunos de los choques de camiones más graves del estado. Cuando uno de esos camiones lo lesiona a usted o a su familia, necesita un equipo que actúe más rápido que los investigadores de la compañía de transporte.</p>
<p>Desde nuestra oficina en <strong>127 King Street, Suite 200</strong>, los abogados de Roden Law envían cartas de preservación de evidencia el mismo día: la caja negra del camión, los registros de horas del conductor, el historial de inspecciones del chasis portuario. Llame al <a href="tel:+18437908999">(843) 790-8999</a> — la consulta es gratuita y en español.</p>
<p>En Carolina del Sur el plazo general para demandar es de <strong>3 años</strong> (S.C. Code § 15-3-530), pero los datos electrónicos del camión pueden borrarse legalmente en semanas si nadie exige su preservación.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de camiones en Charleston, SC. Hablamos español y enfrentamos a las transportistas del puerto. Gratis: (843) 790-8999.',
            '_roden_hero_intro'       => 'Los camiones del puerto de Charleston dominan la I-26 y la I-526. Si uno de ellos lo lesionó, nuestros abogados preservan la evidencia y enfrentan a la compañía de transporte — en español.',
            '_roden_why_hire'         => '<p>Un caso de camión no es un caso de auto más grande: hay regulaciones federales de la FMCSA, varias aseguradoras y evidencia electrónica que desaparece rápido. Investigamos al conductor, a la compañía, al dueño del remolque y a quien cargó el contenedor, y trabajamos con expertos en reconstrucción para probar la culpa.</p><p>Nuestro equipo de Charleston conoce los corredores del puerto y litiga en el Charleston County Court of Common Pleas. Más de $300 millones recuperados, consultas en español y sin honorarios a menos que ganemos. Llame al (843) 790-8999.</p>',
            '_roden_key_takeaways'    => 'Después de un accidente de camión en Charleston, usted generalmente tiene 3 años para presentar su demanda en Carolina del Sur (S.C. Code § 15-3-530) y puede recuperar compensación si fue menos del 51% culpable. Los casos vinculados al puerto y al corredor de la I-26/I-526 suelen involucrar a varias empresas y aseguradoras, y la evidencia electrónica del camión puede borrarse en semanas, así que actúe de inmediato. La consulta con nuestra oficina de King Street es gratuita y en español, y no cobramos honorarios a menos que ganemos.',
            '_roden_accident_phrase'  => 'un accidente de camión',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto tiempo tengo en Carolina del Sur para demandar por un accidente de camión?', 'answer' => 'En general, 3 años (S.C. Code § 15-3-530). Pero no espere: la caja negra y los registros del conductor pueden borrarse legalmente si un abogado no exige su preservación de inmediato.' ),
                array( 'question' => '¿Contra quién se reclama en un choque con un camión del puerto?', 'answer' => 'Puede haber varias partes responsables: el conductor, la compañía de transporte, el dueño del chasis o remolque y quien cargó el contenedor. Investigamos a todas para maximizar su compensación.' ),
                array( 'question' => '¿Hablan español en su oficina de Charleston?', 'answer' => 'Sí. Le atendemos en español desde la primera llamada hasta el cierre de su caso. Llame al (843) 790-8999 — la consulta es gratuita.' ),
                array( 'question' => '¿Cuánto cuesta contratarlos?', 'answer' => 'Nada por adelantado. Solo cobramos un porcentaje si ganamos su caso. Si no recuperamos dinero para usted, no nos debe honorarios.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'truck-accident-lawyers/charleston-sc not found or ES pillar missing.' ); }

/* 3. workers-compensation-lawyers × charleston-sc */
$en_int    = roden_es_seed_find_intersection( 'workers-compensation-lawyers', 'charleston-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'workers-compensation-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Compensación Laboral en Charleston, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de compensación laboral en Charleston, SC que hablan español. Su estatus migratorio no impide sus beneficios. Consulta gratuita: (843) 790-8999.',
        'content' => <<<'HTML'
<p>Charleston vive del trabajo duro: hoteles y restaurantes del centro, obras de construcción por toda la península, bodegas y muelles del puerto. Cuando una lesión en el trabajo lo deja sin poder ganarse la vida, la compensación laboral de Carolina del Sur debe cubrir su atención médica y parte de su salario — pero las aseguradoras niegan o recortan reclamos válidos todos los días, especialmente cuando el trabajador no habla inglés.</p>
<p>En Roden Law usted cuenta su caso en español y nosotros nos encargamos del resto. <strong>Su estatus migratorio no le impide recibir beneficios de compensación laboral en Carolina del Sur</strong>, y su consulta es siempre confidencial. Nuestra oficina está en <strong>127 King Street, Suite 200</strong>; llame al <a href="tel:+18437908999">(843) 790-8999</a>.</p>
<p>Los plazos son cortos: reporte su lesión a su empleador dentro de <strong>90 días</strong> y presente su reclamo dentro de <strong>2 años</strong> (S.C. Code § 42-15-20). Si su empleador le dice que "no pasa nada" o le pide no reportar, llámenos primero.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de compensación laboral en Charleston, SC. Hablamos español. Su estatus migratorio no impide beneficios. Gratis: (843) 790-8999.',
            '_roden_hero_intro'       => 'Si se lesionó trabajando en un hotel, una obra o el puerto de Charleston, tiene derecho a beneficios de compensación laboral — sin importar su estatus migratorio. Le atendemos en español.',
            '_roden_why_hire'         => '<p>La aseguradora de su empleador no trabaja para usted. Nosotros sí. Presentamos su reclamo correctamente, peleamos las negaciones ante la South Carolina Workers’ Compensation Commission, nos aseguramos de que vea a los médicos correctos y calculamos los beneficios completos por incapacidad temporal o permanente.</p><p>Entendemos el miedo a represalias que sienten muchos trabajadores hispanos de Charleston. La ley le protege, su consulta es confidencial y no cobramos honorarios a menos que recuperemos beneficios para usted. Llame al (843) 790-8999.</p>',
            '_roden_key_takeaways'    => 'Si se lesionó en el trabajo en Charleston, reporte la lesión a su empleador dentro de 90 días y presente su reclamo de compensación laboral dentro de 2 años (S.C. Code § 42-15-20). La compensación laboral en Carolina del Sur no exige probar culpa: cubre su atención médica y parte de su salario aunque el accidente haya sido en parte su error. Su estatus migratorio no le impide recibir beneficios y su consulta es confidencial. En nuestra oficina de King Street la consulta es gratuita y en español, y no paga honorarios a menos que ganemos.',
            '_roden_accident_phrase'  => 'una lesión en el trabajo',
            '_roden_faqs'             => array(
                array( 'question' => '¿Puedo recibir compensación laboral en Carolina del Sur si no tengo papeles?', 'answer' => 'Sí. Los trabajadores lesionados tienen derecho a beneficios de compensación laboral sin importar su estatus migratorio. Todo lo que nos cuente es confidencial y su empleador no puede tomar represalias legales por reclamar.' ),
                array( 'question' => '¿Cuánto tiempo tengo para reportar mi lesión en Charleston?', 'answer' => 'Reporte la lesión a su empleador dentro de 90 días y presente el reclamo formal dentro de 2 años (S.C. Code § 42-15-20). Mientras antes reporte, más fuerte será su caso.' ),
                array( 'question' => '¿Qué cubre la compensación laboral?', 'answer' => 'La atención médica relacionada con su lesión, aproximadamente dos tercios de su salario semanal mientras no pueda trabajar y beneficios por incapacidad permanente si no se recupera por completo.' ),
                array( 'question' => '¿Hablan español en su oficina de Charleston?', 'answer' => 'Sí. Todo su caso se maneja en español, desde la consulta gratuita hasta la audiencia. Llame al (843) 790-8999.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'workers-compensation-lawyers/charleston-sc not found or ES pillar missing.' ); }

/* 4. construction-accident-lawyers × charleston-sc */
$en_int    = roden_es_seed_find_intersection( 'construction-accident-lawyers', 'charleston-sc' );
$es_parent = roden_es_seed_es_pillar_id( 'construction-accident-lawyers' );
if ( $en_int && $es_parent ) {
    roden_es_seed_translation( $en_int->ID, array(
        'title'   => 'Abogados de Accidentes de Construcción en Charleston, SC',
        'parent'  => $es_parent,
        'excerpt' => 'Abogados de accidentes de construcción en Charleston, SC. Hablamos español y su estatus migratorio no impide su reclamo. Gratis: (843) 790-8999.',
        'content' => <<<'HTML'
<p>Charleston está en plena construcción: hoteles y condominios en la península, urbanizaciones en Johns Island y Mount Pleasant, obras industriales a lo largo de la I-526. Gran parte de ese trabajo lo hacen manos hispanas — y cuando un andamio falla, una zanja colapsa o un equipo pesado golpea a un trabajador, las consecuencias son devastadoras.</p>
<p>Después de un accidente de construcción usted puede tener dos reclamos: el de compensación laboral contra el seguro de su empleador y, muchas veces, una demanda adicional contra terceros responsables — el contratista general, otro subcontratista o el fabricante de un equipo defectuoso. Esa segunda vía puede valer mucho más, y la mayoría de los trabajadores no sabe que existe. <strong>Su estatus migratorio no le impide reclamar</strong> y su consulta es confidencial.</p>
<p>Llame a nuestra oficina de <strong>127 King Street, Suite 200</strong> al <a href="tel:+18437908999">(843) 790-8999</a>. En Carolina del Sur el plazo general para demandar a terceros es de <strong>3 años</strong> (S.C. Code § 15-3-530); no lo deje pasar.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de construcción en Charleston, SC. Hablamos español. Su estatus migratorio no impide reclamar. Gratis: (843) 790-8999.',
            '_roden_hero_intro'       => 'Si un accidente en una obra de Charleston lo lesionó, puede tener derecho a compensación laboral y a una demanda contra terceros responsables. Le explicamos sus opciones en español, gratis.',
            '_roden_why_hire'         => '<p>Los casos de construcción exigen moverse rápido: la escena de la obra cambia en días, los testigos se dispersan entre subcontratistas y las empresas cierran filas. Investigamos violaciones de seguridad de OSHA, identificamos a cada empresa responsable y coordinamos su reclamo de compensación laboral con la demanda contra terceros para que un reclamo no perjudique al otro.</p><p>Sabemos que muchos trabajadores hispanos de Charleston temen perder su empleo o llamar la atención sobre su estatus. La ley le protege, todo es confidencial y no cobramos a menos que ganemos. Llame al (843) 790-8999.</p>',
            '_roden_key_takeaways'    => 'Tras un accidente de construcción en Charleston, usted generalmente tiene 3 años para demandar a terceros responsables en Carolina del Sur (S.C. Code § 15-3-530) y puede recuperar compensación si fue menos del 51% culpable; su reclamo de compensación laboral corre por separado, con plazos más cortos. Además del seguro de su empleador, el contratista general u otro subcontratista pueden deberle una compensación mucho mayor. Su estatus migratorio no impide ninguno de los dos reclamos. La consulta en nuestra oficina de King Street es gratuita y en español, sin honorarios a menos que ganemos.',
            '_roden_accident_phrase'  => 'un accidente de construcción',
            '_roden_faqs'             => array(
                array( 'question' => '¿Puedo demandar si ya recibo compensación laboral por mi accidente en la obra?', 'answer' => 'Muchas veces sí. La compensación laboral le impide demandar a su propio empleador, pero no al contratista general, a otros subcontratistas ni al fabricante de un equipo defectuoso. Esa demanda adicional puede cubrir el dolor y sufrimiento que la compensación laboral no paga.' ),
                array( 'question' => '¿Puedo reclamar si no tengo papeles?', 'answer' => 'Sí. Su estatus migratorio no le impide reclamar compensación laboral ni demandar a terceros en Carolina del Sur. Su consulta es confidencial.' ),
                array( 'question' => '¿Cuánto tiempo tengo para reclamar en Carolina del Sur?', 'answer' => 'La demanda contra terceros generalmente debe presentarse dentro de 3 años (S.C. Code § 15-3-530). Para la compensación laboral, reporte dentro de 90 días y reclame dentro de 2 años (S.C. Code § 42-15-20).' ),
                array( 'question' => '¿Hablan español en su oficina de Charleston?', 'answer' => 'Sí. Le atendemos en español en cada etapa del caso. Llame al (843) 790-8999 — la consulta es gratuita.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'construction-accident-lawyers/charleston-sc not found or ES pillar missing.' ); }

WP_CLI::log( '═══ BATCH 16 DONE ═══' );
