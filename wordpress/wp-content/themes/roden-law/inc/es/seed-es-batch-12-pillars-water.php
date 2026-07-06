<?php
/**
 * ES Seeder — Batch 12: Pillar practice areas (water).
 * Pillars: maritime-injury-lawyers, boating-accident-lawyers.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-12-pillars-water.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 12 — PILLARS: WATER ═══' );

/* 1. maritime-injury-lawyers */
$en = roden_es_seed_find_pillar( 'maritime-injury-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Lesiones Marítimas',
        'excerpt' => 'Abogados de lesiones marítimas en Georgia y Carolina del Sur. Ley Jones, trabajadores portuarios y de embarcaciones: sus derechos son federales. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Lesiones en el mar y en los puertos de la costa</h2>
<p>Los puertos de Savannah, Brunswick y Charleston están entre los más activos del país, y el trabajo marítimo — en barcos, remolcadores, muelles y terminales — está entre los más peligrosos. Si usted se lesionó trabajando en el agua o en el puerto, sus derechos no vienen de la compensación laboral estatal común: vienen de la Ley Jones y el derecho marítimo general, un sistema federal con reglas propias. Los marineros lesionados por la negligencia del empleador o por una embarcación en mal estado pueden reclamar salarios, cuidados médicos ("maintenance and cure") y compensación completa por sus lesiones.</p>
<p>Los abogados de lesiones marítimas de Roden Law conocen ese sistema y a las compañías navieras que lo explotan. Los empleadores marítimos suelen presionar a los trabajadores lesionados para que firmen declaraciones y acepten pagos rápidos antes de que conozcan sus derechos federales. No firme nada antes de hablar con un abogado.</p>
<h2>Plazos bajo el derecho marítimo</h2>
<p>Bajo la Ley Jones y el derecho marítimo general, usted tiene 3 años para la mayoría de reclamos marítimos (46 U.S.C. § 30106). Pero algunos reclamos — contra el gobierno o bajo ciertos contratos de crucero — tienen plazos mucho más cortos, a veces de solo meses. Además, la evidencia a bordo desaparece rápido: los cuadernos de bitácora se completan, los testigos se embarcan de nuevo y las condiciones del buque cambian. Actúe de inmediato.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita en español o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Si su accidente fue en una embarcación recreativa, visite nuestra página de <a href="/es/practice-areas/boating-accident-lawyers/">abogados de accidentes de navegación</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de lesiones marítimas en Georgia y Carolina del Sur. Ley Jones y derecho marítimo: 3 años para la mayoría de reclamos. Gratis: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de lesiones marítimas reclama bajo la Ley Jones y el derecho marítimo general cuando usted se lesiona trabajando en un barco, un muelle o un puerto. En Roden Law, con oficinas en las ciudades portuarias de la costa, la consulta es gratuita y en español.',
            '_roden_why_hire'         => '<p>El derecho marítimo es un sistema federal aparte, y elegir mal la vía legal puede costarle la mayor parte de su compensación. En Roden Law determinamos si usted califica como marinero bajo la Ley Jones, si su reclamo corresponde al derecho marítimo general o a la ley de trabajadores portuarios, y reclamamos todo lo que ese estatus permite: maintenance and cure, salarios perdidos, daños por negligencia del empleador y por la falta de navegabilidad del buque. Nuestras oficinas están en las ciudades portuarias donde estos casos ocurren — Savannah, Brunswick y Charleston son nuestra costa.</p><p>Atendemos a la comunidad hispana con consultas en español las 24 horas, confidenciales sin importar su estatus migratorio. Más de $300 millones recuperados, 5,000+ casos, 62 años de experiencia combinada y 6 oficinas — sin honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Cubiertas resbaladizas y equipos en mal estado', 'Grúas, cabrestantes y cables que fallan', 'Tripulación insuficiente o mal entrenada', 'Accidentes con contenedores en muelles y terminales', 'Caídas por la borda y ahogamientos', 'Fatiga por jornadas excesivas a bordo' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Lesiones de espalda y columna', 'description' => 'Cargar equipo pesado en cubiertas inestables hernia discos y daña la columna, lesiones que pueden terminar para siempre la carrera de un trabajador marítimo.' ),
                array( 'name' => 'Amputaciones por cabos y maquinaria', 'description' => 'Los cabos bajo tensión, los cabrestantes y la maquinaria de cubierta pueden atrapar y amputar dedos, manos o extremidades completas en segundos.' ),
                array( 'name' => 'Lesiones cerebrales traumáticas', 'description' => 'Los golpes con grúas, contenedores y equipos que se balancean causan daño cerebral, agravado cuando el buque está lejos de atención médica adecuada.' ),
                array( 'name' => 'Fracturas y lesiones por aplastamiento', 'description' => 'La carga que se mueve, las escotillas y los equipos pesados aplastan extremidades y fracturan huesos, con rescate y tratamiento a menudo demorados en el mar.' ),
                array( 'name' => 'Hipotermia y lesiones por caídas al agua', 'description' => 'Las caídas por la borda causan ahogamientos, hipotermia y daño cerebral por falta de oxígeno cuando el rescate no llega a tiempo.' ),
                array( 'name' => 'Quemaduras en salas de máquinas', 'description' => 'Los incendios, las tuberías de vapor y los combustibles a bordo causan quemaduras graves en espacios cerrados de los que es difícil escapar.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Qué es la Ley Jones y me protege a mí?', 'answer' => 'La Ley Jones es la ley federal que permite a los marineros — trabajadores que pasan una parte significativa de su tiempo al servicio de una embarcación — demandar a su empleador por negligencia. Si usted trabaja en barcos, remolcadores, dragas o embarcaciones de pesca, es probable que califique. Lo evaluamos gratis.' ),
                array( 'question' => '¿Qué significa "maintenance and cure"?', 'answer' => 'Es el derecho del marinero lesionado o enfermo en servicio a que su empleador pague sus gastos de vida diarios (maintenance) y todo su tratamiento médico (cure) hasta la máxima recuperación posible, sin importar la culpa. Si su empleador se lo niega o lo recorta, puede deber daños adicionales.' ),
                array( 'question' => 'Trabajo en el muelle, no en el barco. ¿Tengo derechos?', 'answer' => 'Sí. Los estibadores y trabajadores portuarios están cubiertos por una ley federal de compensación propia (la LHWCA), que suele pagar más que la compensación laboral estatal. Y si un tercero — como el operador del buque — causó su lesión, también puede demandarlo.' ),
                array( 'question' => '¿Cuánto tiempo tengo para presentar un reclamo marítimo?', 'answer' => 'La regla general bajo la Ley Jones y el derecho marítimo es de 3 años para la mayoría de reclamos marítimos (46 U.S.C. § 30106). Pero hay excepciones importantes con plazos mucho más cortos — por ejemplo, los boletos de crucero suelen exigir aviso en 6 meses y demanda en 1 año — así que consúltenos de inmediato.' ),
                array( 'question' => 'Mi empleador quiere que firme una declaración. ¿Debo hacerlo?', 'answer' => 'No firme nada ni dé declaraciones grabadas antes de hablar con un abogado. Las compañías navieras usan esas declaraciones para negar reclamos después. Su consulta con nosotros es gratuita, en español y confidencial sin importar su estatus migratorio.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar maritime-injury-lawyers not found.' ); }

/* 2. boating-accident-lawyers */
$en = roden_es_seed_find_pillar( 'boating-accident-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Accidentes de Navegación',
        'excerpt' => 'Abogados de accidentes de navegación en Georgia y Carolina del Sur. Choques de lanchas, operadores ebrios y motos acuáticas en la costa. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Accidentes de lanchas y embarcaciones en la costa</h2>
<p>Desde los ríos y marismas de Savannah hasta el puerto de Charleston y la costa de Myrtle Beach, las aguas de Georgia y Carolina del Sur se llenan de lanchas, motos acuáticas y botes de pesca cada temporada. Y con ellos llegan los accidentes: operadores que navegan ebrios o distraídos, exceso de velocidad en canales congestionados, botes alquilados a personas sin experiencia y embarcaciones sin el equipo de seguridad exigido. Los abogados de accidentes de navegación de Roden Law investigan quién operaba con negligencia y reclaman la compensación completa por sus lesiones.</p>
<p>Los casos de navegación tienen capas propias: el reporte del accidente ante el DNR estatal o la Guardia Costera, las reglas de navegación que determinan la culpa, el seguro de la embarcación y la posible responsabilidad de la compañía que la alquiló. Igual que en la carretera, operar un bote bajo la influencia del alcohol es un delito en ambos estados — y una base fuerte para su reclamo.</p>
<h2>Plazos en Georgia y Carolina del Sur</h2>
<p>Para la mayoría de los accidentes en aguas estatales, aplica el plazo de lesiones personales: 2 años (O.C.G.A. § 9-3-33) en Georgia y 3 años (S.C. Code § 15-3-530) en Carolina del Sur. Ambos estados aplican culpa comparativa — recuperación con culpa menor al 50% en Georgia (O.C.G.A. § 51-12-33) y menor al 51% en Carolina del Sur. Si el accidente ocurrió en aguas navegables, el derecho marítimo federal puede aplicar plazos distintos, así que consúltenos pronto.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a> para una consulta gratuita en español. Si se lesionó trabajando en el agua, visite nuestra página de <a href="/es/practice-areas/maritime-injury-lawyers/">abogados de lesiones marítimas</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de navegación en Georgia y Carolina del Sur. Lanchas, motos acuáticas y operadores ebrios en la costa. Gratis: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de accidentes de navegación investiga al operador negligente, a la compañía de alquiler y a los seguros disponibles cuando un accidente de lancha o moto acuática lo lesiona. En Roden Law la consulta es gratuita, en español y confidencial.',
            '_roden_why_hire'         => '<p>Los accidentes de navegación no se investigan solos: muchas veces no hay cámaras, la "escena" desaparece con la corriente y el operador culpable cuenta su propia versión. En Roden Law obtenemos el reporte del DNR o de la Guardia Costera, los registros de alquiler y mantenimiento de la embarcación, los datos de GPS y los testimonios de otros navegantes para reconstruir lo que pasó. Nuestras oficinas están justo donde ocurren estos casos — Savannah, Brunswick, Charleston y Myrtle Beach — y conocemos sus aguas y sus tribunales.</p><p>Atendemos a la comunidad hispana con consultas en español las 24 horas, confidenciales sin importar su estatus migratorio. Más de $300 millones recuperados, 5,000+ casos, 62 años de experiencia combinada y 6 oficinas — sin honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Operadores bajo la influencia del alcohol', 'Exceso de velocidad en canales y zonas de estela', 'Operadores inexpertos con botes alquilados', 'Falta de vigía y distracciones a bordo', 'Fallas mecánicas y falta de mantenimiento', 'Falta de chalecos y equipo de seguridad exigido' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Ahogamiento y lesiones por inmersión', 'description' => 'Las caídas al agua tras un choque causan ahogamientos y daño cerebral por falta de oxígeno, sobre todo cuando no había chalecos salvavidas a bordo.' ),
                array( 'name' => 'Lesiones por hélice', 'description' => 'El contacto con una hélice en movimiento causa laceraciones profundas, amputaciones y lesiones desfigurantes que requieren múltiples cirugías reconstructivas.' ),
                array( 'name' => 'Lesiones cerebrales traumáticas', 'description' => 'Los golpes contra el casco, la consola o el agua a alta velocidad causan conmociones y daño cerebral con efectos duraderos en la memoria y el ánimo.' ),
                array( 'name' => 'Fracturas de columna y compresión vertebral', 'description' => 'Los golpes de la embarcación contra las olas a alta velocidad comprimen y fracturan vértebras, una lesión común en pasajeros de lanchas y motos acuáticas.' ),
                array( 'name' => 'Quemaduras por incendios y explosiones', 'description' => 'Las fugas de combustible y las fallas eléctricas provocan incendios y explosiones a bordo, con quemaduras graves y pocas vías de escape en el agua.' ),
                array( 'name' => 'Hipotermia y lesiones por rescate demorado', 'description' => 'Lejos de la costa, el rescate tarda: la exposición prolongada al agua agrava las lesiones y puede causar hipotermia y daños adicionales.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Qué debo hacer después de un accidente de lancha?', 'answer' => 'Busque atención médica de inmediato, asegúrese de que el accidente se reporte al DNR estatal o a la Guardia Costera (es obligatorio cuando hay lesiones), tome fotos si puede, anote los datos del operador y de la embarcación, y no dé declaraciones a la aseguradora antes de hablar con un abogado.' ),
                array( 'question' => 'El operador del bote iba tomando alcohol. ¿Cómo afecta mi caso?', 'answer' => 'Lo fortalece. Operar una embarcación bajo la influencia es un delito tanto en Georgia como en Carolina del Sur, y esa violación es evidencia poderosa de negligencia. En algunos casos también permite reclamar daños punitivos contra el operador ebrio.' ),
                array( 'question' => '¿Puedo reclamar si me lesioné como pasajero del bote?', 'answer' => 'Sí. Los pasajeros lesionados pueden reclamar contra el operador negligente — incluso si es un conocido, porque el reclamo lo paga su seguro — y contra cualquier otra embarcación o compañía de alquiler responsable del accidente.' ),
                array( 'question' => '¿Quién responde si el bote era alquilado?', 'answer' => 'Puede responder la compañía de alquiler si entregó la embarcación a un operador sin la edad o formación exigida, si no dio la instrucción de seguridad requerida o si el bote tenía fallas de mantenimiento. También responde el operador negligente y su seguro.' ),
                array( 'question' => '¿Cuánto tiempo tengo para demandar?', 'answer' => 'Como regla general, 2 años en Georgia (O.C.G.A. § 9-3-33) y 3 años en Carolina del Sur (S.C. Code § 15-3-530). Si el accidente ocurrió en aguas navegables, el derecho marítimo federal puede cambiar el plazo, así que consúltenos lo antes posible.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar boating-accident-lawyers not found.' ); }

WP_CLI::log( '═══ BATCH 12 DONE ═══' );
