<?php
/**
 * ES Seeder — Batch 13: Pillar practice areas (vulnerable victims).
 * Pillars: burn-injury-lawyers, nursing-home-abuse-lawyers.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-13-pillars-vulnerable.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 13 — PILLARS: VULNERABLE ═══' );

/* 1. burn-injury-lawyers */
$en = roden_es_seed_find_pillar( 'burn-injury-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Quemaduras',
        'excerpt' => 'Abogados de quemaduras en Georgia y Carolina del Sur. Incendios, explosiones, químicos y electricidad: reclamamos el costo completo de la recuperación. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Quemaduras graves: dolor, cicatrices y años de tratamiento</h2>
<p>Las quemaduras graves están entre las lesiones más dolorosas y costosas que existen. Los injertos de piel, las cirugías reconstructivas, la terapia para recuperar movilidad y el tratamiento psicológico por la desfiguración pueden extenderse durante años — y las cicatrices permanentes cambian cómo la víctima trabaja, se relaciona y se ve a sí misma. Cuando la quemadura fue causada por un incendio en un apartamento sin detectores, una explosión en el trabajo, un producto defectuoso, un choque vehicular o el contacto con químicos o electricidad, alguien es legalmente responsable de todo ese costo.</p>
<p>Los abogados de quemaduras de Roden Law investigan la causa con expertos en incendios e ingeniería, identifican a cada responsable — propietarios, empleadores, fabricantes, conductores — y documentan el tratamiento completo que su recuperación exigirá, no solo las facturas del hospital de hoy.</p>
<h2>Plazos legales en Georgia y Carolina del Sur</h2>
<p>El plazo para presentar una demanda por lesiones personales es de 2 años (O.C.G.A. § 9-3-33) en Georgia y de 3 años (S.C. Code § 15-3-530) en Carolina del Sur. Ambos estados aplican culpa comparativa: recuperación con culpa menor al 50% en Georgia (O.C.G.A. § 51-12-33) y menor al 51% en Carolina del Sur. La evidencia de un incendio se limpia y se reconstruye rápido — actúe de inmediato.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita en español o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Si la quemadura fue causada por un producto defectuoso, visite nuestra página de <a href="/es/practice-areas/product-liability-lawyers/">abogados de responsabilidad de productos</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de quemaduras en Georgia y Carolina del Sur. Incendios, explosiones, químicos y electricidad: reclamamos el costo completo. 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de quemaduras hace responder al propietario, empleador, fabricante o conductor que causó el incendio, la explosión o el contacto con químicos o electricidad — y reclama el costo completo de años de tratamiento. Consulta gratuita en español con Roden Law.',
            '_roden_why_hire'         => '<p>El valor de un caso de quemaduras está en el futuro: injertos de piel adicionales, cirugías reconstructivas, terapia física y psicológica, y el impacto de las cicatrices en el trabajo y la vida social de la víctima. Las aseguradoras ofrecen acuerdos basados en las facturas de hoy; en Roden Law trabajamos con cirujanos plásticos, especialistas en quemaduras y economistas para probar lo que la recuperación completa costará realmente. También contratamos expertos en causas de incendios para demostrar la responsabilidad — del propietario que no instaló detectores, del empleador que violó normas de seguridad o del fabricante del producto que falló.</p><p>Atendemos a la comunidad hispana de Georgia y Carolina del Sur con consultas en español las 24 horas, confidenciales sin importar su estatus migratorio. Más de $300 millones recuperados, 5,000+ casos, 62 años de experiencia combinada y 6 oficinas — sin honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Incendios en apartamentos sin detectores de humo', 'Explosiones e incendios en el lugar de trabajo', 'Productos y electrodomésticos defectuosos', 'Choques vehiculares con incendio', 'Contacto con químicos industriales', 'Cables eléctricos y instalaciones defectuosas' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Quemaduras de segundo grado', 'description' => 'Dañan las capas profundas de la piel con ampollas y dolor intenso, y pueden dejar cicatrices y cambios de pigmentación permanentes sin el tratamiento adecuado.' ),
                array( 'name' => 'Quemaduras de tercer y cuarto grado', 'description' => 'Destruyen todas las capas de la piel y pueden alcanzar músculo y hueso, exigiendo injertos, múltiples cirugías y hospitalizaciones prolongadas en unidades de quemados.' ),
                array( 'name' => 'Lesiones por inhalación de humo', 'description' => 'El humo y los gases tóxicos queman las vías respiratorias y dañan los pulmones, causando problemas respiratorios que pueden volverse crónicos.' ),
                array( 'name' => 'Quemaduras eléctricas', 'description' => 'La corriente eléctrica quema tejidos internos siguiendo su camino por el cuerpo, con daño a nervios, músculos y al corazón que no siempre se ve por fuera.' ),
                array( 'name' => 'Quemaduras químicas', 'description' => 'Los ácidos y sustancias corrosivas siguen quemando mientras permanecen en la piel, causando daño profundo, cicatrices y lesiones oculares graves.' ),
                array( 'name' => 'Cicatrices, contracturas y desfiguración', 'description' => 'Las cicatrices de quemaduras pueden tensar la piel y limitar el movimiento de articulaciones, además del impacto psicológico permanente de la desfiguración.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto vale un caso de quemaduras graves?', 'answer' => 'Suelen estar entre los casos de mayor valor porque el tratamiento es largo y costoso — injertos, cirugías reconstructivas, terapia — y porque el dolor y la desfiguración permanente pesan mucho ante un jurado. El valor exacto depende de la gravedad, los responsables y los seguros disponibles. Lo evaluamos gratis.' ),
                array( 'question' => 'Me quemé en un incendio en mi apartamento. ¿Puedo demandar al dueño?', 'answer' => 'Es posible. Los propietarios deben mantener detectores de humo funcionando, instalaciones eléctricas seguras y salidas de emergencia despejadas. Si el incendio o sus lesiones se agravaron por esas fallas, el propietario y su seguro pueden ser responsables.' ),
                array( 'question' => '¿Qué pasa si me quemé en el trabajo?', 'answer' => 'Tiene derecho a compensación laboral sin importar la culpa — tratamiento médico pagado y parte de sus salarios. Y si un tercero causó la quemadura (un fabricante de equipo defectuoso, un subcontratista, un proveedor de químicos), también puede presentar una demanda adicional que cubra el dolor y sufrimiento.' ),
                array( 'question' => '¿Qué evidencia necesita mi caso de quemaduras?', 'answer' => 'El reporte de bomberos o del incidente, fotos de la escena y de sus lesiones a lo largo del tiempo, el producto o equipo que falló (consérvelo), sus expedientes médicos y los nombres de los testigos. Nosotros obtenemos el resto: registros de mantenimiento, inspecciones y análisis de expertos en incendios.' ),
                array( 'question' => '¿Cuánto tiempo tengo para demandar?', 'answer' => 'En Georgia, 2 años desde la fecha de la lesión (O.C.G.A. § 9-3-33); en Carolina del Sur, 3 años (S.C. Code § 15-3-530). La escena de un incendio se limpia o reconstruye en semanas, así que contáctenos de inmediato para preservar la evidencia.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar burn-injury-lawyers not found.' ); }

/* 2. nursing-home-abuse-lawyers */
$en = roden_es_seed_find_pillar( 'nursing-home-abuse-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Abuso en Hogares de Ancianos',
        'excerpt' => 'Abogados de abuso en hogares de ancianos en Georgia y Carolina del Sur. Negligencia, escaras, caídas y maltrato: protegemos a su ser querido. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Cuando el hogar de ancianos falla a su ser querido</h2>
<p>Las familias confían sus padres y abuelos a los hogares de ancianos esperando cuidado y dignidad. Pero cuando una corporación opera el hogar con personal insuficiente para aumentar sus ganancias, los residentes pagan el precio: escaras (úlceras por presión) que se infectan, caídas repetidas sin supervisión, desnutrición y deshidratación, errores de medicamentos, y en los peores casos, abuso físico, emocional o financiero. Los abogados de abuso en hogares de ancianos de Roden Law hacen responder a las instalaciones negligentes — y a las corporaciones detrás de ellas.</p>
<p>Las señales de alerta incluyen moretones sin explicación, pérdida rápida de peso, escaras, mala higiene, cambios de ánimo o miedo al personal, y caídas o "incidentes" repetidos. Si algo no se siente bien, confíe en su instinto: documente con fotos, pida los expedientes médicos y anote nombres y fechas.</p>
<h2>Reporte el abuso y conozca los plazos</h2>
<p>Si sospecha abuso o negligencia, repórtelo también a las agencias estatales: en Georgia y Carolina del Sur puede presentar quejas ante el departamento estatal de salud que licencia los hogares de ancianos, los Servicios de Protección de Adultos y el Ombudsman de Cuidados a Largo Plazo de cada estado — y si hay peligro inmediato, llame al 911. Esos reportes protegen a su ser querido y crean un registro oficial. Para la demanda civil, el plazo general es de 2 años (O.C.G.A. § 9-3-33) en Georgia y de 3 años (S.C. Code § 15-3-530) en Carolina del Sur.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a> para una consulta gratuita en español. Si su ser querido falleció por la negligencia del hogar, visite nuestra página de <a href="/es/practice-areas/wrongful-death-lawyers/">abogados de muerte por negligencia</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de abuso en hogares de ancianos en Georgia y Carolina del Sur. Escaras, caídas, maltrato: protegemos a su ser querido. 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de abuso en hogares de ancianos hace responder a la instalación negligente cuando su ser querido sufre escaras, caídas, desnutrición o maltrato. En Roden Law la consulta es gratuita, en español y confidencial.',
            '_roden_why_hire'         => '<p>Los hogares de ancianos negligentes casi siempre tienen el mismo origen: una corporación que recorta personal para aumentar ganancias. En Roden Law obtenemos lo que las familias no pueden ver — los registros de personal, los expedientes médicos completos, el historial de inspecciones y multas estatales, y las quejas previas — para probar que el daño de su ser querido no fue un accidente sino el resultado previsible de esas decisiones. También le ayudamos a reportar ante las agencias estatales para que la instalación quede bajo supervisión oficial.</p><p>Atendemos a las familias hispanas de Georgia y Carolina del Sur con consultas en español las 24 horas, confidenciales y sin compromiso. Más de $300 millones recuperados, 5,000+ casos, 62 años de experiencia combinada y 6 oficinas — sin honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Personal insuficiente y mal entrenado', 'Falta de supervisión de residentes con riesgo de caídas', 'No reposicionar a residentes inmóviles (escaras)', 'Errores y omisiones de medicamentos', 'Desnutrición y deshidratación por descuido', 'Abuso físico, emocional o financiero del personal' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Escaras (úlceras por presión)', 'description' => 'Se forman cuando el personal no reposiciona al residente inmóvil; en etapas avanzadas llegan al hueso, se infectan y pueden causar sepsis y la muerte.' ),
                array( 'name' => 'Fracturas por caídas', 'description' => 'Las caídas repetidas sin supervisión causan fracturas de cadera que, en adultos mayores, suelen significar cirugía, deterioro acelerado y pérdida definitiva de movilidad.' ),
                array( 'name' => 'Desnutrición y deshidratación', 'description' => 'La pérdida rápida de peso y la deshidratación indican que el personal no asiste al residente en sus comidas, y debilitan todo su estado de salud.' ),
                array( 'name' => 'Infecciones y sepsis', 'description' => 'Las escaras desatendidas, la mala higiene y los catéteres mal manejados causan infecciones que se extienden al torrente sanguíneo y ponen en peligro la vida.' ),
                array( 'name' => 'Sobredosis y errores de medicamentos', 'description' => 'Las dosis equivocadas, los medicamentos omitidos y la sedación química para "manejar" a los residentes causan caídas, hospitalizaciones y daño permanente.' ),
                array( 'name' => 'Lesiones por abuso físico', 'description' => 'Los moretones sin explicación, las marcas de sujeción y las lesiones que el personal no puede explicar son señales de maltrato físico que debe investigarse de inmediato.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuáles son las señales de abuso o negligencia en un hogar de ancianos?', 'answer' => 'Moretones o lesiones sin explicación, escaras, pérdida rápida de peso, mala higiene, cambios de ánimo o miedo al personal, sedación excesiva y caídas repetidas. Si nota varias de estas señales, documente con fotos, pida los expedientes médicos y consúltenos.' ),
                array( 'question' => '¿A quién reporto el abuso en Georgia o Carolina del Sur?', 'answer' => 'Reporte a la administración del hogar por escrito y, sobre todo, a las agencias estatales: el departamento estatal de salud que licencia la instalación, los Servicios de Protección de Adultos y el Ombudsman de Cuidados a Largo Plazo del estado. Si hay peligro inmediato, llame al 911. Le ayudamos con cada reporte.' ),
                array( 'question' => '¿Puedo demandar al hogar de ancianos por las escaras de mi familiar?', 'answer' => 'Sí. Las escaras avanzadas casi siempre indican negligencia: se previenen reposicionando al residente y cuidando su piel y nutrición. Los expedientes médicos y los registros de personal suelen probar que la instalación no dio ese cuidado básico.' ),
                array( 'question' => 'Mi familiar falleció en el hogar de ancianos. ¿Qué derechos tiene la familia?', 'answer' => 'Si la negligencia o el abuso causaron o aceleraron el fallecimiento, la familia puede presentar una demanda por muerte por negligencia. Estos casos exigen revisar los expedientes médicos con expertos, y los plazos corren desde el fallecimiento — consúltenos pronto.' ),
                array( 'question' => '¿Cuánto cuesta contratar a un abogado para este caso?', 'answer' => 'Nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos si recuperamos compensación para su familia. La consulta es gratuita, en español y confidencial.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar nursing-home-abuse-lawyers not found.' ); }

WP_CLI::log( '═══ BATCH 13 DONE ═══' );
