<?php
/**
 * ES Seeder — Batch 10: Pillar practice areas (catastrophic injuries).
 * Pillars: brain-injury-lawyers, spinal-cord-injury-lawyers.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-10-pillars-catastrophic.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 10 — PILLARS: CATASTROPHIC ═══' );

/* 1. brain-injury-lawyers */
$en = roden_es_seed_find_pillar( 'brain-injury-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Lesiones Cerebrales',
        'excerpt' => 'Abogados de lesiones cerebrales en Georgia y Carolina del Sur. Reclamamos el costo real de una lesión cerebral traumática: tratamiento, ingresos y cuidados de por vida. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Cuando una lesión cerebral cambia toda una vida</h2>
<p>Una lesión cerebral traumática no se parece a ninguna otra lesión. Puede cambiar la memoria, el estado de ánimo, la capacidad de trabajar y hasta la personalidad de la persona — y muchas veces los efectos no aparecen completos hasta semanas o meses después del accidente. Los choques de auto y camión, las caídas y los accidentes de trabajo son las causas más comunes. Los abogados de lesiones cerebrales de Roden Law trabajan con neurólogos, neuropsicólogos y planificadores de cuidados para documentar el costo real de la lesión: no solo las facturas de hoy, sino la rehabilitación, los ingresos perdidos y los cuidados que su familia necesitará por años.</p>
<p>Las aseguradoras suelen aprovechar que una lesión cerebral "no se ve" en una radiografía común. Minimizan las conmociones cerebrales, culpan a condiciones previas y ofrecen acuerdos rápidos antes de que usted conozca el alcance completo del daño. Aceptar temprano puede dejar a su familia pagando décadas de tratamiento. Nosotros no dejamos que eso ocurra.</p>
<h2>Plazos legales en Georgia y Carolina del Sur</h2>
<p>El plazo para presentar una demanda por lesiones personales es de 2 años (O.C.G.A. § 9-3-33) en Georgia y de 3 años (S.C. Code § 15-3-530) en Carolina del Sur. Además, ambos estados aplican la culpa comparativa: en Georgia usted puede recuperar compensación si su culpa es menor al 50% (O.C.G.A. § 51-12-33); en Carolina del Sur, si es menor al 51%. La evidencia médica temprana es decisiva en estos casos, así que no espere.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita en español o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Si el accidente también dañó la columna, visite nuestra página de <a href="/es/practice-areas/spinal-cord-injury-lawyers/">abogados de lesiones de la médula espinal</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de lesiones cerebrales en Georgia y Carolina del Sur. Reclamamos tratamiento, ingresos y cuidados de por vida. Consulta gratis: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de lesiones cerebrales reclama la compensación completa que una lesión cerebral traumática exige: tratamiento médico, rehabilitación, ingresos perdidos y cuidados futuros. En Roden Law la consulta es gratuita, en español y sin compromiso.',
            '_roden_why_hire'         => '<p>Los casos de lesión cerebral se ganan con evidencia médica especializada. En Roden Law trabajamos con neurólogos, neuropsicólogos y economistas para demostrar lo que la aseguradora quiere ocultar: que una conmoción "leve" puede dejar problemas de memoria, concentración y estado de ánimo permanentes, y que el costo de por vida de una lesión cerebral grave puede alcanzar millones. Documentamos cada consecuencia — médica, laboral y familiar — antes de negociar, para que ningún acuerdo se quede corto.</p><p>Atendemos a la comunidad hispana de Georgia y Carolina del Sur con consultas en español las 24 horas, siempre confidenciales sin importar su estatus migratorio. Con más de $300 millones recuperados, 5,000+ casos, 62 años de experiencia combinada y 6 oficinas, no cobramos honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Choques de autos y camiones comerciales', 'Caídas en propiedades y lugares de trabajo', 'Accidentes de motocicleta y peatones', 'Golpes por objetos que caen en obras', 'Falta de oxígeno por negligencia médica', 'Accidentes deportivos y recreativos' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Conmoción cerebral y lesión cerebral leve', 'description' => 'Aun sin perder el conocimiento, una conmoción puede dejar dolores de cabeza, mareos y problemas de memoria y concentración que duran meses o se vuelven permanentes.' ),
                array( 'name' => 'Contusión y hemorragia cerebral', 'description' => 'Los golpes fuertes pueden causar sangrado dentro del cráneo que exige cirugía de emergencia y puede dejar daño neurológico permanente si no se trata a tiempo.' ),
                array( 'name' => 'Lesión axonal difusa', 'description' => 'La sacudida violenta del cerebro en un choque desgarra las conexiones nerviosas, causando daño extendido que a menudo no aparece en las tomografías iniciales.' ),
                array( 'name' => 'Daño cognitivo permanente', 'description' => 'Muchas víctimas quedan con dificultades duraderas de memoria, atención y razonamiento que les impiden volver a su trabajo anterior o requieren supervisión constante.' ),
                array( 'name' => 'Cambios de personalidad y estado de ánimo', 'description' => 'El daño a los lóbulos frontales puede causar depresión, irritabilidad e impulsividad, afectando el matrimonio, la familia y las relaciones laborales de la víctima.' ),
                array( 'name' => 'Estado vegetativo y lesiones catastróficas', 'description' => 'Las lesiones cerebrales más graves dejan a la víctima dependiente de cuidados las 24 horas, con costos de por vida que la demanda debe cubrir por completo.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto vale un caso de lesión cerebral?', 'answer' => 'Depende de la gravedad del daño, el tratamiento necesario, los ingresos perdidos y el impacto en su vida diaria. Los casos de lesión cerebral grave suelen valer mucho más de lo que la aseguradora ofrece al inicio, porque deben cubrir cuidados y pérdidas de por vida. Evaluamos su caso gratis antes de que acepte cualquier oferta.' ),
                array( 'question' => 'Los síntomas aparecieron días después del accidente. ¿Todavía tengo caso?', 'answer' => 'Sí. Es muy común que los síntomas de una lesión cerebral — dolores de cabeza, confusión, cambios de ánimo — aparezcan días o semanas después. Busque atención médica en cuanto los note y documente todo. Lo importante es actuar dentro del plazo legal: 2 años en Georgia y 3 años en Carolina del Sur.' ),
                array( 'question' => '¿Qué pasa si la tomografía salió "normal"?', 'answer' => 'Una tomografía normal no descarta una lesión cerebral. Las conmociones y la lesión axonal difusa muchas veces no aparecen en las imágenes iniciales. Las evaluaciones neuropsicológicas y las resonancias especializadas pueden documentar el daño, y trabajamos con los expertos correctos para lograrlo.' ),
                array( 'question' => '¿Puedo reclamar si mi familiar quedó incapacitado y no puede demandar por sí mismo?', 'answer' => 'Sí. Cuando la víctima no puede manejar sus propios asuntos, un familiar o tutor legal puede presentar la demanda en su nombre. Le guiamos en ese proceso y nos aseguramos de que la compensación proteja el futuro de su ser querido.' ),
                array( 'question' => '¿Cuánto cuesta contratar a un abogado de lesiones cerebrales?', 'answer' => 'Nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos si recuperamos compensación para usted. La consulta es gratuita, en español y confidencial.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar brain-injury-lawyers not found.' ); }

/* 2. spinal-cord-injury-lawyers */
$en = roden_es_seed_find_pillar( 'spinal-cord-injury-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Lesiones de la Médula Espinal',
        'excerpt' => 'Abogados de lesiones de la médula espinal en Georgia y Carolina del Sur. Parálisis, cirugías y cuidados de por vida: reclamamos el valor completo de su caso. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Lesiones de la médula espinal: el costo de por vida</h2>
<p>Una lesión de la médula espinal está entre las más devastadoras que una persona puede sufrir. La parálisis parcial o total cambia dónde puede vivir, si puede trabajar y cuánta ayuda necesitará cada día por el resto de su vida. Los choques de auto y camión, las caídas desde alturas y los accidentes de trabajo y de piscina son las causas más frecuentes. Los abogados de lesiones de la médula espinal de Roden Law construyen el caso alrededor de una realidad que las aseguradoras prefieren ignorar: el costo de por vida de una parálisis puede superar varios millones de dólares en cirugías, equipos, adaptaciones del hogar y cuidados de enfermería.</p>
<p>Por eso estos casos no se pueden negociar como un reclamo común. Trabajamos con médicos especialistas, planificadores de cuidados de vida y economistas para calcular cada gasto futuro — y no aceptamos acuerdos que dejen a su familia cargando con esos costos.</p>
<h2>Sus plazos en Georgia y Carolina del Sur</h2>
<p>Usted tiene 2 años (O.C.G.A. § 9-3-33) en Georgia y 3 años (S.C. Code § 15-3-530) en Carolina del Sur para presentar una demanda por lesiones personales. Ambos estados aplican culpa comparativa: en Georgia puede recuperar si su culpa es menor al 50% (O.C.G.A. § 51-12-33); en Carolina del Sur, si es menor al 51%. Cuanto antes empecemos, mejor podremos preservar la evidencia del accidente.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a> para una consulta gratuita en español. Si el accidente también causó daño cerebral, conozca a nuestros <a href="/es/practice-areas/brain-injury-lawyers/">abogados de lesiones cerebrales</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de lesiones de la médula espinal en Georgia y Carolina del Sur. Parálisis y cuidados de por vida: reclamamos el valor completo. 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de lesiones de la médula espinal reclama la compensación que una parálisis realmente exige: cirugías, equipos médicos, adaptaciones del hogar, ingresos perdidos y cuidados de por vida. En Roden Law la consulta es gratuita y en español.',
            '_roden_why_hire'         => '<p>El error más costoso en un caso de médula espinal es aceptar un acuerdo calculado para las facturas de hoy. Una parálisis genera gastos durante décadas: sillas de ruedas que se reemplazan, complicaciones médicas, cuidados de enfermería y un hogar que hay que adaptar. En Roden Law trabajamos con planificadores de cuidados de vida y economistas para proyectar cada uno de esos costos, y con ingenieros y reconstructores de accidentes para probar la responsabilidad. Ese trabajo es lo que separa un acuerdo insuficiente de uno que protege a su familia de verdad.</p><p>Servimos a la comunidad hispana de Georgia y Carolina del Sur con consultas en español las 24 horas, confidenciales sin importar su estatus migratorio. Más de $300 millones recuperados, 5,000+ casos, 62 años de experiencia combinada y 6 oficinas — sin honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Choques de autos y camiones a alta velocidad', 'Caídas desde escaleras, andamios y techos', 'Accidentes de motocicleta', 'Accidentes de piscina y clavados en agua poco profunda', 'Accidentes con maquinaria en el trabajo', 'Errores médicos y quirúrgicos' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Paraplejia', 'description' => 'El daño a la médula en la zona torácica o lumbar causa parálisis de las piernas, exigiendo silla de ruedas, adaptaciones del hogar y terapia continua de por vida.' ),
                array( 'name' => 'Cuadriplejia (tetraplejia)', 'description' => 'Las lesiones cervicales altas paralizan brazos y piernas, y suelen requerir cuidados de enfermería las 24 horas y equipos médicos especializados durante toda la vida.' ),
                array( 'name' => 'Lesión medular incompleta', 'description' => 'Cuando la médula se daña parcialmente, la víctima conserva algo de movimiento o sensibilidad, pero enfrenta dolor crónico, debilidad y años de rehabilitación intensiva.' ),
                array( 'name' => 'Fracturas y luxaciones vertebrales', 'description' => 'Las vértebras fracturadas pueden comprimir la médula y exigen cirugías de fusión espinal que limitan la movilidad y la capacidad de trabajo de forma permanente.' ),
                array( 'name' => 'Hernias de disco traumáticas', 'description' => 'El impacto de un choque puede herniar discos que presionan los nervios espinales, causando dolor irradiado, entumecimiento y en muchos casos cirugía correctiva.' ),
                array( 'name' => 'Síndrome de cauda equina', 'description' => 'La compresión de los nervios en la base de la columna es una emergencia quirúrgica que puede dejar incontinencia y parálisis parcial si no se opera de inmediato.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto vale un caso de lesión de la médula espinal?', 'answer' => 'Los casos de parálisis suelen estar entre los de mayor valor en lesiones personales, porque deben cubrir cuidados médicos de por vida, equipos, adaptaciones del hogar, ingresos perdidos y dolor y sufrimiento. El valor exacto depende de su lesión y de los seguros disponibles — lo evaluamos gratis y sin compromiso.' ),
                array( 'question' => '¿Qué gastos futuros puede cubrir la compensación?', 'answer' => 'Cirugías y hospitalizaciones futuras, rehabilitación, sillas de ruedas y su reemplazo periódico, adaptaciones del hogar y del vehículo, cuidados de enfermería, medicamentos y los ingresos que ya no podrá ganar. Un plan de cuidados de vida elaborado por expertos documenta cada partida.' ),
                array( 'question' => '¿Qué pasa si yo tuve parte de la culpa en el accidente?', 'answer' => 'Todavía puede recuperar compensación. Georgia permite recuperar si su culpa es menor al 50% (O.C.G.A. § 51-12-33) y Carolina del Sur si es menor al 51%; su compensación se reduce según su porcentaje de culpa. No acepte la versión de la aseguradora sobre quién tuvo la culpa — investigamos nosotros mismos.' ),
                array( 'question' => '¿Cuánto tiempo tengo para demandar?', 'answer' => 'En Georgia, 2 años desde la fecha de la lesión (O.C.G.A. § 9-3-33); en Carolina del Sur, 3 años (S.C. Code § 15-3-530). En estos casos la evidencia médica y del accidente se debe preservar de inmediato, así que le conviene llamar mucho antes del plazo.' ),
                array( 'question' => '¿Cobran algo por adelantado?', 'answer' => 'No. Trabajamos con honorarios de contingencia: solo cobramos si recuperamos compensación para usted. La consulta es gratuita, en español y confidencial sin importar su estatus migratorio.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar spinal-cord-injury-lawyers not found.' ); }

WP_CLI::log( '═══ BATCH 10 DONE ═══' );
