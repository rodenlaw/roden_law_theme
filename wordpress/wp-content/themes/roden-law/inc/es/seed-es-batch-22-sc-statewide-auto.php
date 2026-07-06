<?php
/**
 * ES Seeder — Batch 22: SC statewide pillars (auto).
 * /es/south-carolina-car-accident-lawyers/ + /es/south-carolina-truck-accident-lawyers/
 * Translated from inc/seed-sc-pillar-car-accident.php + inc/seed-sc-pillar-truck.php.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-22-sc-statewide-auto.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 22 — SC STATEWIDE PILLARS: AUTO ═══' );

$es_root = roden_es_seed_root_page_id();

// EN statewide pillars ship as drafts — get_page_by_path misses drafts, so fall back to a direct query.
$roden_es_find_root_page = static function ( $slug ) {
    $page = get_page_by_path( $slug );
    if ( ! $page ) {
        $q    = get_posts( array( 'post_type' => 'page', 'name' => $slug, 'post_status' => array( 'publish', 'draft' ), 'post_parent' => 0, 'numberposts' => 1 ) );
        $page = $q ? $q[0] : null;
    }
    return $page;
};

/* 1. /es/south-carolina-car-accident-lawyers/ */
$en = $roden_es_find_root_page( 'south-carolina-car-accident-lawyers' );
if ( $en && $es_root ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Accidentes de Auto en Carolina del Sur',
        'parent'  => $es_root,
        'excerpt' => 'Abogados de accidentes de auto de Roden Law en Carolina del Sur: representamos a víctimas de choques en todo el estado. Consulta gratuita — sin honorarios a menos que ganemos.',
        'content' => <<<'HTML'
<p>Un accidente de auto puede cambiar su vida en segundos: facturas médicas, ingresos perdidos, un vehículo destrozado y una aseguradora que ya está trabajando para pagarle lo menos posible. Los abogados de accidentes de auto de Roden Law en Carolina del Sur nivelan esa pelea. Reunimos la evidencia, tratamos con los ajustadores y perseguimos el valor completo de su reclamo, sirviendo a conductores lesionados en todo el estado desde nuestras oficinas en Charleston, North Charleston, Columbia y Myrtle Beach. Trabajamos con honorarios de contingencia: usted no paga nada a menos que ganemos.</p>

<h2>¿Quién paga después de un accidente de auto en Carolina del Sur?</h2>
<p>Carolina del Sur es un estado de <strong>culpa (tort)</strong>. Eso significa que el conductor que causó el choque es responsable del daño, y usted generalmente reclama contra el seguro de responsabilidad de ese conductor. Carolina del Sur exige que todo conductor tenga al menos <strong>25/50/25</strong> en cobertura de responsabilidad — $25,000 por persona lesionada, $50,000 por accidente y $25,000 por daños a la propiedad — además de cobertura obligatoria de <strong>motorista sin seguro (UM)</strong>, bajo S.C. Code &sect; 38-77-140 y siguientes. Un abogado identifica cada póliza y cada parte que pueda deberle compensación.</p>

<h2>¿Cuánto tiempo tengo para presentar mi reclamo en Carolina del Sur?</h2>
<p>En la mayoría de los casos usted tiene <strong>3 años desde la fecha del choque</strong> para presentar una demanda por lesiones personales, bajo <strong>S.C. Code &sect; 15-3-530</strong>. Pueden aplicar plazos más cortos cuando una entidad de gobierno — como SCDOT o una ciudad — está involucrada, bajo la Ley de Reclamos por Agravios de Carolina del Sur (Tort Claims Act). La evidencia desaparece rápido: no espere.</p>

<h2>¿Qué pasa si yo tuve parte de la culpa del choque?</h2>
<p>Carolina del Sur usa una regla de <strong>negligencia comparativa modificada</strong>: usted todavía puede recuperar compensación siempre que haya tenido <strong>menos del 51% de la culpa</strong>, con su indemnización reducida según su porcentaje de responsabilidad. Las aseguradoras intentan asignarle más culpa de la real para pagar menos — cómo se asigna la culpa suele decidir todo el caso.</p>

<h2>¿Qué pasa si el otro conductor no tenía seguro o tenía muy poco?</h2>
<p>Carolina del Sur exige cobertura UM y permite <strong>acumular (stacking)</strong> coberturas de motorista sin seguro y con seguro insuficiente (UM/UIM) en muchas situaciones, lo que puede multiplicar la cobertura disponible cuando el conductor culpable no tiene seguro o solo lleva la póliza mínima. Es una de las partes más valiosas — y más ignoradas — de un reclamo por accidente de auto en Carolina del Sur.</p>

<h2>¿Qué compensación puedo recuperar después de un accidente de auto?</h2>
<p>Según los hechos, la recuperación puede incluir sus facturas médicas (pasadas y futuras), salarios perdidos y capacidad de ingreso perdida, la reparación o el reemplazo de su vehículo, y el dolor y sufrimiento. En casos de conducta especialmente imprudente — como un conductor ebrio — también pueden estar disponibles daños punitivos. Documentamos la magnitud completa de sus pérdidas para que la aseguradora no las minimice.</p>

<h2>Causas comunes de accidentes de auto en Carolina del Sur</h2>
<ul>
<li><strong>Conducción distraída</strong> — mensajes de texto y uso del teléfono al volante.</li>
<li><strong>Exceso de velocidad y conducción agresiva</strong> — especialmente en interestatales como la I-26, la I-20 y la I-95.</li>
<li><strong>Conducción bajo la influencia</strong> — alcohol o drogas.</li>
<li><strong>Pasarse la luz roja y no ceder el paso</strong> — colisiones en intersecciones.</li>
<li><strong>Choques por alcance y al incorporarse</strong> — en corredores congestionados.</li>
</ul>
<p>Si lo lesionó un camión comercial o iba en motocicleta, vea nuestras páginas de <a href="/es/south-carolina-truck-accident-lawyers/">abogados de accidentes de camiones en Carolina del Sur</a> y <a href="/es/south-carolina-motorcycle-accident-lawyer/">abogados de accidentes de motocicleta en Carolina del Sur</a>.</p>

<h2>Hable gratis con un abogado de accidentes de auto en Carolina del Sur</h2>
<p>Roden Law representa a víctimas de accidentes de auto en todo Carolina del Sur, incluyendo <a href="/es/car-accident-lawyers/charleston-sc/">Charleston</a>, <a href="/es/car-accident-lawyers/columbia-sc/">Columbia</a> y <a href="/es/car-accident-lawyers/myrtle-beach-sc/">Myrtle Beach</a>. Un abogado revisará su caso sin costo, le explicará el plazo que aplica y empezará a proteger su evidencia de inmediato. No hay honorarios a menos que ganemos. Conozca nuestra <a href="/es/practice-areas/car-accident-lawyers/">práctica de accidentes de auto</a> o <a href="/es/contact/">contáctenos hoy</a>.</p>
HTML,
        'meta'    => array(
            '_wp_page_template'        => 'templates/template-pillar-sc-statewide.php',
            '_roden_pillar_practice'   => 'Accidente de Auto',
            '_roden_pillar_practice_l' => 'un accidente de auto',
            '_roden_meta_description'  => '¿Lesionado en un accidente de auto en Carolina del Sur? Roden Law lucha por su compensación en todo el estado. Consulta gratis, sin honorarios si no ganamos.',
            '_roden_key_takeaways'     => 'Carolina del Sur es un estado de culpa (tort): el conductor que causó el choque — y su aseguradora — responde por las lesiones. Usted generalmente tiene 3 años desde la fecha del choque para presentar una demanda bajo S.C. Code § 15-3-530, y puede recuperar compensación siempre que haya tenido menos del 51% de la culpa, con su indemnización reducida según su porcentaje. Carolina del Sur exige cobertura mínima de responsabilidad de 25/50/25 y cobertura obligatoria de motorista sin seguro (UM) (S.C. Code § 38-77-140 y siguientes), y permite acumular coberturas UM/UIM cuando el conductor culpable no tiene seguro suficiente. Roden Law tiene 4 oficinas en Carolina del Sur — Charleston, North Charleston, Columbia y Myrtle Beach — y maneja accidentes de auto en todo el estado con honorarios de contingencia: no paga nada a menos que ganemos.',
            '_roden_faqs'              => array(
                array( 'question' => '¿Carolina del Sur es un estado de culpa o de no-culpa para accidentes de auto?', 'answer' => 'Carolina del Sur es un estado de culpa (tort). El conductor que causó el choque, y su aseguradora, responde por las lesiones y pérdidas resultantes, así que usted reclama contra la cobertura de responsabilidad del conductor culpable, no contra beneficios propios de no-culpa.' ),
                array( 'question' => '¿Cuánto tiempo tengo para demandar por un accidente de auto en Carolina del Sur?', 'answer' => 'En la mayoría de los casos, 3 años desde la fecha del choque, bajo S.C. Code § 15-3-530. Pueden aplicar plazos más cortos cuando una entidad de gobierno está involucrada bajo la Tort Claims Act de Carolina del Sur, así que confirme su plazo específico con un abogado.' ),
                array( 'question' => '¿Qué pasa si yo tuve parte de la culpa del accidente?', 'answer' => 'Carolina del Sur sigue una regla de negligencia comparativa modificada. Usted puede recuperar compensación siempre que haya tenido menos del 51% de la culpa, pero su indemnización se reduce según su porcentaje. Las aseguradoras suelen intentar asignarle culpa extra para pagar menos.' ),
                array( 'question' => '¿Qué pasa si el conductor que me chocó no tenía seguro o no tenía suficiente?', 'answer' => 'Carolina del Sur exige cobertura de motorista sin seguro (UM) y permite acumular coberturas UM y UIM en muchas situaciones. Esa acumulación puede aumentar significativamente la cobertura disponible cuando el conductor culpable no tiene seguro o solo lleva una póliza mínima.' ),
                array( 'question' => '¿Cuánto cuesta un abogado de accidentes de auto en Carolina del Sur?', 'answer' => 'Roden Law maneja los casos de accidentes de auto con honorarios de contingencia. Usted no paga nada por adelantado y no paga honorarios legales a menos que ganemos. Nuestro honorario es un porcentaje de la recuperación que obtenemos para usted.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'south-carolina-car-accident-lawyers EN page or es root missing.' ); }

/* 2. /es/south-carolina-truck-accident-lawyers/ */
$en = $roden_es_find_root_page( 'south-carolina-truck-accident-lawyers' );
if ( $en && $es_root ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Accidentes de Camiones en Carolina del Sur',
        'parent'  => $es_root,
        'excerpt' => 'Abogados de accidentes de camiones de Roden Law en Carolina del Sur: enfrentamos a las empresas de camiones y sus aseguradoras en todo el estado. Consulta gratuita — sin honorarios a menos que ganemos.',
        'content' => <<<'HTML'
<p>Si usted o un ser querido resultó lesionado en un accidente de camión en Carolina del Sur, enfrenta un caso muy diferente a un <a href="/es/south-carolina-car-accident-lawyers/">choque de auto</a> común. Los camiones comerciales están regidos por reglas federales de seguridad, respaldados por grandes aseguradoras, y a menudo involucran a varias empresas que pueden compartir la culpa. Los abogados de accidentes de camiones de Roden Law en Carolina del Sur enfrentan a esas empresas y a sus aseguradoras desde nuestras oficinas en Charleston, North Charleston, Columbia y Myrtle Beach, sirviendo a personas lesionadas en todo el estado. Trabajamos con honorarios de contingencia: no paga nada por adelantado ni honorarios legales a menos que ganemos su caso.</p>

<h2>¿Por qué los casos de accidentes de camiones son diferentes a los de autos?</h2>
<p>Un tractocamión completamente cargado puede pesar de 20 a 30 veces más que un auto de pasajeros, así que las lesiones suelen ser mucho más graves. Pero la mayor diferencia es legal. El transporte comercial está regulado por la Administración Federal de Seguridad de Autotransportes (FMCSA), que fija reglas sobre horas del conductor, inspección del vehículo, mantenimiento y carga. Cuando una empresa de camiones rompe esas reglas, puede ser evidencia poderosa de negligencia — pero solo si su abogado sabe buscarla y actúa antes de que los registros desaparezcan. Las empresas de camiones suelen enviar investigadores a la escena en cuestión de horas; cuanto antes empiece su abogado a preservar evidencia, más fuerte será su caso.</p>

<h2>¿Quién puede ser responsable de un accidente de camión en Carolina del Sur?</h2>
<ul>
<li><strong>El conductor del camión</strong> — por conducción insegura, fatiga, distracción o intoxicación.</li>
<li><strong>La empresa de camiones (transportista)</strong> — por contratación negligente, entrenamiento inadecuado, horarios ilegales o mal mantenimiento.</li>
<li><strong>El cargador o el embarcador</strong> — cuando una carga mal asegurada o excesiva causa el choque.</li>
<li><strong>Un contratista de mantenimiento o un fabricante de piezas</strong> — por fallas de frenos, llantas o equipo.</li>
<li><strong>Un intermediario (broker) u otra parte</strong> — según cómo se organizó la carga.</li>
</ul>
<p>Identificar a cada responsable importa, porque cada uno puede tener un seguro separado — y las lesiones graves de un accidente de camión a menudo superan una sola póliza.</p>

<h2>¿Qué evidencia importa más en un reclamo por accidente de camión?</h2>
<p>Estos casos dependen de evidencia que el transportista controla y no está obligado a conservar por mucho tiempo. Bajo las reglas federales, el transportista debe conservar los registros de horas de servicio del conductor solo <strong>6 meses</strong>, los reportes de inspección del vehículo apenas <strong>3 meses</strong>, y los registros de mantenimiento alrededor de un año — mientras que los datos del módulo electrónico del camión (la &laquo;caja negra&raquo;) no tienen ningún período de retención obligatorio y pueden sobrescribirse en días. Parte de la evidencia más importante puede desaparecer mucho antes del plazo de 3 años. Por eso una <strong>carta de preservación de evidencia</strong> enviada temprano suele ser el primer paso más importante del caso.</p>

<h2>¿Cuánto tiempo tengo para presentar mi reclamo por accidente de camión?</h2>
<p>En la mayoría de los casos usted tiene <strong>3 años desde la fecha del choque</strong> para presentar una demanda por lesiones personales en Carolina del Sur, bajo <strong>S.C. Code &sect; 15-3-530</strong>. Los reclamos contra una entidad de gobierno pueden tener un plazo mucho más corto bajo la Tort Claims Act. Como la evidencia de estos casos desaparece rápido, no debe esperar.</p>

<h2>¿Qué pasa si yo tuve parte de la culpa del accidente?</h2>
<p>Carolina del Sur sigue una regla de <strong>negligencia comparativa modificada</strong>. Usted todavía puede recuperar compensación siempre que haya tenido menos del 51% de la culpa, aunque su indemnización se reduce según su porcentaje. Las aseguradoras intentan trasladar la culpa al conductor lesionado para pagar menos — nuestros abogados no lo permiten.</p>

<h2>Hable gratis con un abogado de accidentes de camiones en Carolina del Sur</h2>
<p>Roden Law representa a víctimas de accidentes de camiones en todo Carolina del Sur, incluyendo <a href="/es/truck-accident-lawyers/charleston-sc/">Charleston</a>, <a href="/es/truck-accident-lawyers/columbia-sc/">Columbia</a> y <a href="/es/truck-accident-lawyers/myrtle-beach-sc/">Myrtle Beach</a>. Un abogado revisará su caso sin costo, le explicará su plazo y empezará a proteger su evidencia de inmediato. No hay honorarios a menos que ganemos. Conozca nuestra <a href="/es/practice-areas/truck-accident-lawyers/">práctica de accidentes de camiones</a> o <a href="/es/contact/">contáctenos hoy</a>.</p>
HTML,
        'meta'    => array(
            '_wp_page_template'        => 'templates/template-pillar-sc-statewide.php',
            '_roden_pillar_practice'   => 'Accidente de Camión',
            '_roden_pillar_practice_l' => 'un accidente de camión',
            '_roden_meta_description'  => '¿Lesionado en un accidente de camión en Carolina del Sur? Enfrentamos a las empresas de camiones y aseguradoras. Consulta gratis, sin honorarios si no ganamos.',
            '_roden_key_takeaways'     => 'Si usted resultó lesionado en un accidente de camión en cualquier parte de Carolina del Sur, generalmente tiene 3 años desde el choque para presentar un reclamo bajo S.C. Code § 15-3-530, y todavía puede recuperar compensación siempre que haya tenido menos del 51% de la culpa. Los casos de camiones son distintos a los de autos: aplican regulaciones federales de transporte, varias partes (el conductor, el transportista, el intermediario y otros) pueden ser responsables, y la evidencia crítica — los registros del conductor, los datos electrónicos del camión y los archivos del transportista — puede desaparecer rápido. Roden Law tiene 4 oficinas en Carolina del Sur — Charleston, North Charleston, Columbia y Myrtle Beach — y representa a víctimas de accidentes de camiones en todo el estado con honorarios de contingencia: no paga nada a menos que ganemos.',
            '_roden_faqs'              => array(
                array( 'question' => '¿Cuánto tiempo tengo para presentar un reclamo por accidente de camión en Carolina del Sur?', 'answer' => 'En la mayoría de los casos, 3 años desde la fecha del choque, bajo S.C. Code § 15-3-530. Los reclamos que involucran a una entidad de gobierno pueden tener un plazo mucho más corto bajo la Tort Claims Act de Carolina del Sur, así que conviene confirmar su plazo específico con un abogado cuanto antes.' ),
                array( 'question' => '¿Quién puede ser responsable de un accidente de camión en Carolina del Sur?', 'answer' => 'No solo el conductor. Según los hechos, la empresa de camiones, el cargador o embarcador, un contratista de mantenimiento, un fabricante de piezas o un intermediario de carga pueden compartir la responsabilidad. Cada uno puede tener un seguro separado, lo cual importa porque las lesiones graves suelen superar una sola póliza.' ),
                array( 'question' => '¿Qué hace que los casos de camiones sean más difíciles que los de autos?', 'answer' => 'Los camiones comerciales se rigen por las reglas federales de seguridad de la FMCSA, y la evidencia clave — los registros del conductor, los datos electrónicos del camión y los archivos de mantenimiento y personal del transportista — está bajo control de la empresa de camiones y puede sobrescribirse o destruirse rápido. Actuar de inmediato para preservar esa evidencia es crítico.' ),
                array( 'question' => '¿Puedo recuperar compensación si tuve parte de la culpa del accidente de camión?', 'answer' => 'Sí. Bajo la regla de negligencia comparativa modificada de Carolina del Sur, usted puede recuperar compensación siempre que haya tenido menos del 51% de la culpa, aunque su indemnización se reduce según su porcentaje. Las aseguradoras suelen inflar su culpa para pagar menos — nuestros abogados responden.' ),
                array( 'question' => '¿Cuánto cuesta un abogado de accidentes de camiones en Carolina del Sur?', 'answer' => 'Roden Law maneja los casos de accidentes de camiones con honorarios de contingencia. Usted no paga nada por adelantado y no paga honorarios legales a menos que ganemos. Nuestro honorario es un porcentaje del acuerdo o veredicto que recuperamos para usted.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'south-carolina-truck-accident-lawyers EN page or es root missing.' ); }

WP_CLI::log( '═══ BATCH 22 DONE ═══' );
