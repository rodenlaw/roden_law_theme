<?php
/**
 * ES Seeder — Batch 07: Pillar practice areas (road users).
 * Pillars: motorcycle-accident-lawyers, pedestrian-accident-lawyers.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-07-pillars-road.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 07 — PILLARS: ROAD ═══' );

/* 1. motorcycle-accident-lawyers */
$en = roden_es_seed_find_pillar( 'motorcycle-accident-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Accidentes de Motocicleta',
        'excerpt' => 'Abogados de accidentes de motocicleta en Georgia y Carolina del Sur. Combatimos el prejuicio contra los motociclistas. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Defendemos a los motociclistas lesionados</h2>
<p>Los motociclistas no tienen carrocería, bolsas de aire ni cinturones que los protejan: cuando un conductor negligente los golpea, las lesiones suelen ser graves o permanentes. La causa más común es un conductor que gira a la izquierda frente a la motocicleta o que simplemente "no la vio". Los abogados de accidentes de motocicleta de Roden Law han recuperado más de $300 millones para víctimas de accidentes y sabemos cómo probar la negligencia del conductor.</p>
<p>Las aseguradoras tienen un prejuicio conocido contra los motociclistas: asumen que usted iba a exceso de velocidad o manejaba de forma imprudente, y usan ese estereotipo para reducir o negar su reclamo. Nosotros lo combatimos con evidencia: reconstrucción del accidente, videos, testigos y el informe policial.</p>
<h2>Plazos y culpa comparativa</h2>
<p>En Georgia, usted generalmente tiene 2 años (O.C.G.A. § 9-3-33) para presentar su demanda; en Carolina del Sur, 3 años (S.C. Code § 15-3-530). La culpa compartida no le cierra la puerta: en Georgia puede recuperar compensación si fue menos del 50% culpable (O.C.G.A. § 51-12-33), y en Carolina del Sur si fue menos del 51% — aunque su compensación se reduce según su porcentaje de culpa. Por eso es clave no aceptar la versión de la aseguradora sin pelear.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita en español o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. También representamos a víctimas de <a href="/es/practice-areas/car-accident-lawyers/">accidentes de auto</a> y <a href="/es/practice-areas/pedestrian-accident-lawyers/">accidentes de peatones</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de motocicleta en Georgia y Carolina del Sur. Combatimos el prejuicio de las aseguradoras. Consulta gratis: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de accidentes de motocicleta prueba la negligencia del conductor que lo golpeó y combate el prejuicio de las aseguradoras contra los motociclistas. Roden Law ha recuperado más de $300 millones para víctimas de accidentes en Georgia y Carolina del Sur.',
            '_roden_why_hire'         => '<p>En los casos de motocicleta, la batalla es contra el estereotipo tanto como contra la aseguradora. En Roden Law investigamos a fondo cada choque — reconstrucción del accidente, cámaras de la zona, testigos independientes — para demostrar lo que realmente pasó y quién tuvo la culpa. Nuestra red de expertos médicos documenta la gravedad real de sus lesiones, que en motocicleta suelen incluir fracturas, lesiones cerebrales y daños permanentes que las aseguradoras intentan minimizar.</p><p>Somos un equipo con 62 años de experiencia combinada, más de 5,000 casos manejados y 6 oficinas en Georgia y Carolina del Sur. Atendemos consultas en español las 24 horas y no cobramos honorarios a menos que ganemos su caso. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Conductores que giran a la izquierda frente a la motocicleta', 'Conductores que no ven al motociclista al cambiar de carril', 'Exceso de velocidad y conducción distraída', 'Conductores ebrios o drogados', 'Puertas de autos abiertas sin mirar', 'Pavimento en mal estado, grava o baches' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Lesiones cerebrales traumáticas', 'description' => 'Incluso con casco, el impacto contra el pavimento o el vehículo puede causar daño cerebral que afecta de forma permanente la memoria, el equilibrio y la capacidad de trabajar.' ),
                array( 'name' => 'Fracturas de brazos, piernas y pelvis', 'description' => 'El motociclista recibe el impacto directo o cae contra el pavimento, sufriendo fracturas que requieren cirugía con placas y tornillos y una larga rehabilitación.' ),
                array( 'name' => 'Lesiones de la médula espinal', 'description' => 'El daño a la columna en un choque de motocicleta puede causar pérdida de movilidad o parálisis permanente, con costos médicos que se extienden de por vida.' ),
                array( 'name' => 'Abrasiones graves de piel (road rash)', 'description' => 'El deslizamiento sobre el asfalto arranca capas de piel, causando heridas dolorosas propensas a infección que pueden requerir injertos y dejar cicatrices permanentes.' ),
                array( 'name' => 'Amputaciones', 'description' => 'Las piernas del motociclista pueden quedar atrapadas o aplastadas entre la motocicleta y el vehículo, resultando en amputaciones que cambian la vida para siempre.' ),
                array( 'name' => 'Lesiones internas', 'description' => 'El impacto puede dañar órganos como el hígado, el bazo o los pulmones, causando hemorragias internas que requieren atención médica de emergencia inmediata.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => 'La aseguradora dice que el accidente fue mi culpa. ¿Qué hago?', 'answer' => 'No acepte esa versión ni dé declaraciones grabadas. Las aseguradoras culpan a los motociclistas por rutina para pagar menos. La culpa se determina con evidencia — informe policial, testigos, reconstrucción del accidente — y en Georgia usted puede recuperar compensación si fue menos del 50% culpable; en Carolina del Sur, menos del 51%.' ),
                array( 'question' => '¿Puedo reclamar si no llevaba casco?', 'answer' => 'Posiblemente sí. No llevar casco no le quita el derecho a reclamar por la negligencia del otro conductor, aunque la defensa puede argumentar que agravó ciertas lesiones de cabeza. En Georgia el casco es obligatorio; en Carolina del Sur solo para menores de 21 años. Cada caso depende de sus hechos — consúltenos.' ),
                array( 'question' => '¿Qué compensación puedo recibir?', 'answer' => 'Puede reclamar gastos médicos presentes y futuros, salarios perdidos, pérdida de capacidad de trabajo, daños a su motocicleta y dolor y sufrimiento. El valor depende de la gravedad de sus lesiones y de la evidencia; ningún abogado puede garantizar un resultado.' ),
                array( 'question' => '¿Cuánto tiempo tengo para presentar mi demanda?', 'answer' => 'En Georgia, generalmente 2 años (O.C.G.A. § 9-3-33) desde el accidente; en Carolina del Sur, 3 años (S.C. Code § 15-3-530). Mientras antes empecemos, más evidencia podemos preservar.' ),
                array( 'question' => '¿Cuánto cuesta contratar a Roden Law?', 'answer' => 'Nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos un porcentaje si recuperamos dinero para usted. La consulta inicial es gratuita y en español.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar motorcycle-accident-lawyers not found.' ); }

/* 2. pedestrian-accident-lawyers */
$en = roden_es_seed_find_pillar( 'pedestrian-accident-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Accidentes de Peatones',
        'excerpt' => 'Abogados de accidentes de peatones en Georgia y Carolina del Sur. Representamos a personas atropelladas por conductores negligentes. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Cuando un vehículo atropella a un peatón</h2>
<p>Un peatón no tiene ninguna protección frente a un vehículo de dos toneladas. Los atropellos causan algunas de las lesiones más graves que vemos: lesiones cerebrales, fracturas múltiples, daños a la médula espinal y, con demasiada frecuencia, la muerte. Los conductores tienen el deber legal de manejar con cuidado razonable y ceder el paso a los peatones en los cruces — y cuando no lo hacen, responden por el daño que causan.</p>
<p>Los abogados de accidentes de peatones de Roden Law investigan cada atropello a fondo: videos de cámaras de negocios y semáforos, datos del vehículo, testigos y reconstrucción del accidente. En casos de atropello y fuga (hit and run), trabajamos con los investigadores para identificar al conductor y, si no aparece, buscamos compensación a través de la cobertura de motorista sin seguro.</p>
<h2>Plazos legales y culpa compartida</h2>
<p>En Georgia, usted generalmente tiene 2 años (O.C.G.A. § 9-3-33) para presentar una demanda por lesiones personales; en Carolina del Sur, 3 años (S.C. Code § 15-3-530). Aunque la aseguradora diga que usted cruzó mal, eso no acaba el caso: en Georgia puede recuperar compensación si fue menos del 50% culpable (O.C.G.A. § 51-12-33), y en Carolina del Sur si fue menos del 51%.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita en español o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Si perdió a un ser querido en un atropello, nuestros <a href="/es/practice-areas/wrongful-death-lawyers/">abogados de muerte por negligencia</a> pueden ayudarle.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de peatones en Georgia y Carolina del Sur. Ayudamos a víctimas de atropellos, incluso de fuga. Consulta gratis: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de accidentes de peatones reclama compensación cuando un conductor negligente atropella a una persona a pie, incluso en casos de atropello y fuga. Roden Law ha recuperado más de $300 millones para víctimas de accidentes en Georgia y Carolina del Sur.',
            '_roden_why_hire'         => '<p>En un atropello, la palabra del conductor suele ser la única versión que escucha la policía — y las aseguradoras la aprovechan para culpar al peatón. En Roden Law buscamos la evidencia que cuenta la historia real: cámaras de seguridad de negocios cercanos, datos electrónicos del vehículo, marcas en el pavimento y testigos independientes. Nuestra red de expertos médicos documenta el alcance completo de lesiones que muchas veces requieren tratamiento de por vida.</p><p>Con 62 años de experiencia combinada, más de 5,000 casos y 6 oficinas en Georgia y Carolina del Sur, tenemos los recursos para pelear su caso hasta el final. Consultas en español las 24 horas y sin honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Conductores distraídos con el teléfono', 'No ceder el paso en cruces peatonales', 'Exceso de velocidad en zonas residenciales y escolares', 'Conductores ebrios o drogados', 'Giros sin mirar a los peatones que cruzan', 'Retroceder en estacionamientos sin verificar' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Lesiones cerebrales traumáticas', 'description' => 'El golpe contra el vehículo o el pavimento puede causar daño cerebral grave, con efectos permanentes en la memoria, el lenguaje y la personalidad de la víctima.' ),
                array( 'name' => 'Fracturas de piernas, cadera y pelvis', 'description' => 'El parachoques impacta directamente las piernas y la cadera del peatón, causando fracturas complejas que requieren cirugía y pueden dejar limitaciones permanentes para caminar.' ),
                array( 'name' => 'Lesiones de la médula espinal', 'description' => 'La fuerza del atropello puede fracturar vértebras y dañar la médula espinal, causando pérdida de sensibilidad o parálisis que exige cuidados de por vida.' ),
                array( 'name' => 'Lesiones internas y hemorragias', 'description' => 'El impacto del vehículo puede lacerar órganos internos y causar hemorragias que ponen en riesgo la vida y no siempre presentan síntomas inmediatos.' ),
                array( 'name' => 'Laceraciones y cicatrices permanentes', 'description' => 'El contacto con el vehículo y el pavimento causa cortes profundos que pueden dañar nervios y dejar cicatrices visibles que requieren cirugía reconstructiva.' ),
                array( 'name' => 'Lesiones fatales', 'description' => 'Cuando el atropello causa la muerte, la familia puede presentar una demanda por muerte por negligencia para exigir responsabilidad y proteger su futuro económico.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => 'El conductor dice que yo tuve la culpa. ¿Todavía tengo caso?', 'answer' => 'Es posible. La culpa se determina con evidencia, no con la palabra del conductor. En Georgia usted puede recuperar compensación si fue menos del 50% culpable (O.C.G.A. § 51-12-33); en Carolina del Sur, menos del 51% — su compensación solo se reduce según su porcentaje de culpa.' ),
                array( 'question' => '¿Qué pasa si fue un atropello y fuga?', 'answer' => 'Reporte el accidente a la policía de inmediato. Nosotros ayudamos a buscar cámaras y testigos para identificar al conductor. Si no aparece, la cobertura de motorista sin seguro (UM) de su propia póliza de auto — o la de un familiar en su hogar — puede compensarlo aunque usted iba a pie.' ),
                array( 'question' => '¿Puedo reclamar si crucé fuera del paso peatonal?', 'answer' => 'Cruzar fuera del paso peatonal no elimina automáticamente su caso. Los conductores siempre tienen el deber de manejar con atención y a velocidad prudente. Si el conductor iba distraído, ebrio o a exceso de velocidad, puede seguir siendo el principal responsable.' ),
                array( 'question' => '¿Qué compensación puedo recibir?', 'answer' => 'Gastos médicos presentes y futuros, salarios perdidos, pérdida de capacidad de trabajo y dolor y sufrimiento. En atropellos fatales, la familia puede presentar una demanda por muerte por negligencia. El valor depende de los hechos de cada caso.' ),
                array( 'question' => '¿Cuánto tiempo tengo para demandar?', 'answer' => 'En Georgia, generalmente 2 años (O.C.G.A. § 9-3-33); en Carolina del Sur, 3 años (S.C. Code § 15-3-530). Los videos de cámaras se borran en días o semanas, así que contáctenos lo antes posible.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar pedestrian-accident-lawyers not found.' ); }

WP_CLI::log( '═══ BATCH 07 DONE ═══' );
