<?php
/**
 * ES Seeder — Batch 05: Pillar practice areas (auto).
 * Pillars: car-accident-lawyers, truck-accident-lawyers.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-05-pillars-auto.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 05 — PILLARS: AUTO ═══' );

/* 1. car-accident-lawyers */
$en = roden_es_seed_find_pillar( 'car-accident-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Accidentes de Auto',
        'excerpt' => 'Abogados de accidentes de auto en Georgia y Carolina del Sur. Más de $300 millones recuperados para nuestros clientes. Sin honorarios a menos que ganemos. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Representación legal después de un accidente de auto</h2>
<p>Los accidentes de auto son la causa más común de lesiones graves en Georgia y Carolina del Sur. Un choque puede dejarle con facturas médicas, un vehículo destruido y semanas sin poder trabajar — mientras la aseguradora del otro conductor busca pagarle lo menos posible. Los abogados de accidentes de auto de Roden Law han recuperado más de $300 millones para víctimas de accidentes, y estamos listos para luchar por usted en su idioma.</p>
<p>Para ganar su caso hay que demostrar que el otro conductor fue negligente: que manejaba distraído, a exceso de velocidad, bajo la influencia del alcohol o violando las reglas de tránsito. Nuestro equipo reúne el informe policial, declaraciones de testigos, videos de cámaras y expertos en reconstrucción de accidentes para probar quién tuvo la culpa.</p>
<h2>Plazos legales y culpa compartida</h2>
<p>En Georgia, usted generalmente tiene 2 años (O.C.G.A. § 9-3-33) desde la fecha del accidente para presentar una demanda por lesiones personales. En Carolina del Sur, el plazo es de 3 años (S.C. Code § 15-3-530). Ambos estados aplican la regla de culpa comparativa: en Georgia puede recuperar compensación si fue menos del 50% culpable (O.C.G.A. § 51-12-33); en Carolina del Sur, si fue menos del 51% culpable. Por eso las aseguradoras intentan culparlo a usted — no hable con ellas antes de consultar a un abogado.</p>
<p>La consulta es gratuita y en español. <a href="/es/contact/">Contáctenos hoy</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Si su accidente involucró un vehículo comercial, visite nuestra página de <a href="/es/practice-areas/truck-accident-lawyers/">abogados de accidentes de camiones</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de auto en Georgia y Carolina del Sur. Más de $300 millones recuperados. Consulta gratuita en español: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de accidentes de auto le ayuda a recuperar compensación por sus gastos médicos, salarios perdidos y dolor y sufrimiento cuando un conductor negligente causa un choque. En Roden Law hemos recuperado más de $300 millones para víctimas de accidentes en Georgia y Carolina del Sur.',
            '_roden_why_hire'         => '<p>Las aseguradoras tienen equipos de ajustadores y abogados cuyo trabajo es pagarle lo menos posible. Cuando usted contrata a Roden Law, nivelamos el terreno: investigamos el accidente a fondo, preservamos la evidencia antes de que desaparezca, trabajamos con una red de expertos médicos para documentar el alcance real de sus lesiones y calculamos el valor completo de su caso — no solo las facturas de hoy, sino el tratamiento y los ingresos que perderá mañana.</p><p>Nuestro equipo suma 62 años de experiencia combinada y ha manejado más de 5,000 casos desde nuestras 6 oficinas en Georgia y Carolina del Sur. Atendemos consultas en español las 24 horas y no cobramos honorarios a menos que ganemos su caso. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Conductores distraídos o enviando mensajes de texto', 'Exceso de velocidad y conducción agresiva', 'Conducir bajo la influencia del alcohol o drogas', 'No ceder el paso o pasarse una luz roja', 'Seguir demasiado cerca al vehículo de adelante', 'Condiciones peligrosas de la vía o mala señalización' ),
            '_roden_common_injuries'  => array( 'Latigazo cervical y lesiones de cuello y espalda', 'Fracturas de huesos', 'Lesiones cerebrales traumáticas y conmociones', 'Lesiones de la médula espinal', 'Lesiones internas y hemorragias', 'Cortes, laceraciones y cicatrices permanentes' ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Qué debo hacer después de un accidente de auto?', 'answer' => 'Llame al 911 y busque atención médica de inmediato, aunque se sienta bien — algunas lesiones tardan días en manifestarse. Si puede, tome fotos de la escena, obtenga los datos del otro conductor y de los testigos, y no admita culpa. No firme nada de la aseguradora antes de hablar con un abogado.' ),
                array( 'question' => '¿Cuánto vale mi caso de accidente de auto?', 'answer' => 'Cada caso es diferente. El valor depende de sus gastos médicos, salarios perdidos, la gravedad de sus lesiones y el dolor y sufrimiento que ha padecido. Ningún abogado puede garantizarle un resultado, pero en una consulta gratuita podemos evaluar los factores de su caso.' ),
                array( 'question' => '¿Qué pasa si el otro conductor no tiene seguro?', 'answer' => 'Todavía puede tener opciones. Su propia póliza puede incluir cobertura de motorista sin seguro o con seguro insuficiente (UM/UIM), que aplica precisamente en estas situaciones. Nuestros abogados revisan todas las pólizas disponibles para identificar cada fuente de compensación.' ),
                array( 'question' => '¿Cuánto cuesta contratar a Roden Law?', 'answer' => 'Nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos un porcentaje si recuperamos dinero para usted. Si no ganamos, no nos debe honorarios. La consulta inicial es siempre gratuita.' ),
                array( 'question' => '¿Cuánto tiempo tengo para presentar una demanda?', 'answer' => 'En Georgia, el plazo general es de 2 años (O.C.G.A. § 9-3-33) desde la fecha del accidente. En Carolina del Sur es de 3 años (S.C. Code § 15-3-530). Actúe pronto: la evidencia clave puede perderse en semanas.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar car-accident-lawyers not found.' ); }

/* 2. truck-accident-lawyers */
$en = roden_es_seed_find_pillar( 'truck-accident-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Accidentes de Camiones',
        'excerpt' => 'Abogados de accidentes de camiones en Georgia y Carolina del Sur. Enfrentamos a las compañías de transporte y sus aseguradoras. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Casos de accidentes con camiones comerciales</h2>
<p>Un camión de 18 ruedas completamente cargado puede pesar 40 veces más que un auto de pasajeros. Cuando ocurre un choque, las lesiones suelen ser catastróficas — y el caso legal es mucho más complejo que un accidente de auto común. Los abogados de accidentes de camiones de Roden Law conocen las regulaciones federales de la FMCSA y saben cómo enfrentar a las grandes compañías de transporte y sus aseguradoras.</p>
<p>En estos casos puede haber varias partes responsables: el conductor, la compañía de transporte, el dueño del remolque, la empresa que cargó la mercancía o el taller de mantenimiento. Las compañías de camiones envían investigadores a la escena en cuestión de horas. Nosotros actuamos con la misma rapidez: enviamos cartas de preservación de evidencia para proteger la caja negra del camión, los registros de horas de servicio del conductor y el historial de mantenimiento.</p>
<h2>Plazos para presentar su demanda</h2>
<p>En Georgia, usted generalmente tiene 2 años (O.C.G.A. § 9-3-33) para presentar una demanda por lesiones personales; en Carolina del Sur, 3 años (S.C. Code § 15-3-530). En Georgia puede recuperar compensación si fue menos del 50% culpable (O.C.G.A. § 51-12-33); en Carolina del Sur, si fue menos del 51%. No espere: la evidencia electrónica del camión puede borrarse legalmente en poco tiempo si nadie exige su preservación.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita en español, o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. También manejamos <a href="/es/practice-areas/car-accident-lawyers/">accidentes de auto</a> y <a href="/es/practice-areas/wrongful-death-lawyers/">casos de muerte por negligencia</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de camiones en Georgia y Carolina del Sur. Enfrentamos a las compañías de transporte. Consulta gratuita en español: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de accidentes de camiones investiga a la compañía de transporte, preserva la evidencia de la caja negra y reclama compensación completa por lesiones causadas por camiones comerciales. Roden Law ha recuperado más de $300 millones para víctimas de accidentes en Georgia y Carolina del Sur.',
            '_roden_why_hire'         => '<p>Los casos de camiones no son casos de auto más grandes: involucran regulaciones federales, múltiples aseguradoras y evidencia electrónica que desaparece rápido. En Roden Law actuamos de inmediato para preservar la caja negra, los registros del conductor y los datos de GPS, e investigamos si la compañía violó las reglas de horas de servicio, mantenimiento o contratación. Trabajamos con expertos en reconstrucción de accidentes y una red de expertos médicos para documentar el valor completo de sus lesiones.</p><p>Con 62 años de experiencia combinada, más de 5,000 casos manejados y 6 oficinas en Georgia y Carolina del Sur, tenemos los recursos para enfrentar a cualquier compañía de transporte. Consultas en español las 24 horas y sin honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Conductores fatigados que exceden las horas de servicio', 'Frenos o llantas mal mantenidos', 'Carga mal asegurada o sobrepeso', 'Exceso de velocidad y distracción al volante', 'Conductores sin entrenamiento o contratación negligente', 'Puntos ciegos y giros amplios mal ejecutados' ),
            '_roden_common_injuries'  => array( 'Lesiones cerebrales traumáticas', 'Lesiones de la médula espinal y parálisis', 'Fracturas múltiples y lesiones por aplastamiento', 'Quemaduras graves', 'Amputaciones', 'Lesiones internas que requieren cirugía' ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Quién es responsable en un accidente de camión?', 'answer' => 'Puede haber varias partes responsables: el conductor, la compañía de transporte, el dueño del remolque, la empresa que cargó la mercancía o el taller de mantenimiento. Identificar a todas las partes es clave, porque cada una puede tener una póliza de seguro distinta.' ),
                array( 'question' => '¿En qué se diferencia de un accidente de auto?', 'answer' => 'Los camiones comerciales están sujetos a regulaciones federales de la FMCSA sobre horas de servicio, mantenimiento e inspecciones. Además, las pólizas de seguro son mucho más grandes y las aseguradoras defienden estos casos con más agresividad. Se necesita un abogado con experiencia específica en camiones.' ),
                array( 'question' => '¿Qué evidencia es importante en mi caso?', 'answer' => 'La caja negra del camión, los registros de horas del conductor, los datos de GPS, el historial de mantenimiento, el informe policial y los videos de cámaras. Gran parte de esta evidencia está en manos de la compañía de transporte y puede borrarse si un abogado no exige su preservación de inmediato.' ),
                array( 'question' => 'La aseguradora ya me ofreció dinero. ¿Debo aceptar?', 'answer' => 'No firme nada antes de consultar a un abogado. Las primeras ofertas casi siempre son mucho menores que el valor real del caso, y al aceptar usted renuncia a reclamar más — incluso si sus lesiones resultan más graves de lo que pensaba. La consulta con nosotros es gratuita.' ),
                array( 'question' => '¿Cuánto tiempo tengo para demandar?', 'answer' => 'En Georgia, generalmente 2 años (O.C.G.A. § 9-3-33); en Carolina del Sur, 3 años (S.C. Code § 15-3-530). Pero en casos de camiones conviene actuar en días, no meses, para preservar la evidencia electrónica.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar truck-accident-lawyers not found.' ); }

WP_CLI::log( '═══ BATCH 05 DONE ═══' );
