<?php
/**
 * ES Seeder — Batch 14: Pillar practice areas (micromobility).
 * Pillars: bicycle-accident-lawyers, electric-scooter-accident-lawyers.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-14-pillars-micromobility.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 14 — PILLARS: MICROMOBILITY ═══' );

/* 1. bicycle-accident-lawyers */
$en = roden_es_seed_find_pillar( 'bicycle-accident-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Accidentes de Bicicleta',
        'excerpt' => 'Abogados de accidentes de bicicleta en Georgia y Carolina del Sur. Conductores negligentes deben responder — y su propio seguro de auto puede cubrirlo. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Ciclistas contra autos: usted lleva las de perder, la ley no</h2>
<p>En los corredores urbanos de Savannah, Charleston, Columbia y Myrtle Beach, los ciclistas comparten calles con conductores que voltean sin mirar, abren puertas sin revisar el espejo y pasan demasiado cerca. Cuando un auto golpea a un ciclista, el ciclista pone el cuerpo — pero la ley está de su lado: las bicicletas tienen derecho a la vía en Georgia y Carolina del Sur, y los conductores deben cederles el paso y mantener una distancia segura al rebasar. Los abogados de accidentes de bicicleta de Roden Law hacen responder al conductor negligente y a su aseguradora.</p>
<p>La primera reacción de la aseguradora casi siempre es culpar al ciclista: que iba fuera del carril, que no era visible, que no llevaba casco. No acepte esa versión. Los videos de cámaras cercanas, los datos de su GPS o aplicación de ciclismo, los testigos y el reporte policial suelen contar otra historia — y la reconstruimos antes de que la evidencia desaparezca.</p>
<h2>¿Y si el conductor se dio a la fuga o no tiene seguro?</h2>
<p>Muchos ciclistas no saben esto: su propio seguro de auto puede cubrir su accidente de bicicleta. Si el conductor se dio a la fuga o no tiene seguro suficiente, la cobertura de motorista sin seguro o con seguro insuficiente (UM/UIM) de su propia póliza puede pagar sus lesiones — sin que sus primas deban subir por reclamar lo que ya pagó. Los plazos legales: 2 años (O.C.G.A. § 9-3-33) en Georgia y 3 años (S.C. Code § 15-3-530) en Carolina del Sur, con culpa comparativa (menos del 50% en Georgia, O.C.G.A. § 51-12-33; menos del 51% en Carolina del Sur).</p>
<p><a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita en español o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Si el accidente fue caminando, visite nuestra página de <a href="/es/practice-areas/pedestrian-accident-lawyers/">abogados de accidentes de peatones</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de bicicleta en Georgia y Carolina del Sur. El conductor negligente debe responder; su seguro UM también puede cubrirlo. 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de accidentes de bicicleta hace responder al conductor que lo golpeó — y encuentra cobertura incluso si se dio a la fuga o no tiene seguro, a través de su propia póliza de motorista sin seguro. Consulta gratuita en español con Roden Law.',
            '_roden_why_hire'         => '<p>Los casos de bicicleta se pierden cuando la única versión que existe es la del conductor. En Roden Law actuamos rápido: obtenemos videos de cámaras de negocios y viviendas antes de que se borren, los datos de su GPS o aplicación de ciclismo, el reporte policial y los testimonios, y trabajamos con reconstructores de accidentes cuando hace falta. También revisamos todas las pólizas disponibles — la del conductor, la cobertura UM/UIM suya y de su hogar — porque las lesiones de un ciclista suelen superar los límites de una sola póliza.</p><p>Atendemos a la comunidad hispana de Georgia y Carolina del Sur con consultas en español las 24 horas, confidenciales sin importar su estatus migratorio. Más de $300 millones recuperados, 5,000+ casos, 62 años de experiencia combinada y 6 oficinas — sin honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Giros a la izquierda o derecha sin ver al ciclista', 'Rebases sin distancia lateral segura', 'Conductores distraídos con el teléfono', 'Puertas de autos abiertas sin mirar ("dooring")', 'Conductores que no respetan el carril de bicicletas', 'Salidas de estacionamientos y entradas sin precaución' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Lesiones cerebrales traumáticas', 'description' => 'Incluso con casco, el impacto contra el auto o el pavimento puede causar conmociones y daño cerebral con efectos duraderos en la memoria y la concentración.' ),
                array( 'name' => 'Fracturas de clavícula, brazo y muñeca', 'description' => 'Al caer, el ciclista se apoya instintivamente con los brazos, fracturando clavículas y muñecas — lesiones que requieren cirugía y limitan el trabajo por meses.' ),
                array( 'name' => 'Lesiones de columna y médula espinal', 'description' => 'Los impactos a alta velocidad dañan vértebras y médula, con riesgo de dolor crónico o parálisis que cambia la vida del ciclista para siempre.' ),
                array( 'name' => 'Abrasiones profundas ("road rash")', 'description' => 'Deslizarse por el pavimento arranca capas de piel, causando heridas dolorosas que se infectan con facilidad y pueden dejar cicatrices permanentes.' ),
                array( 'name' => 'Lesiones faciales y dentales', 'description' => 'Los impactos de cara contra el vehículo o el suelo fracturan mandíbulas y dientes, exigiendo cirugías reconstructivas y tratamientos dentales prolongados.' ),
                array( 'name' => 'Lesiones internas', 'description' => 'El golpe del vehículo puede dañar órganos internos y causar sangrado que no se nota de inmediato — por eso la evaluación médica urgente es esencial.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => 'El conductor que me golpeó se dio a la fuga. ¿Quién paga mis lesiones?', 'answer' => 'Su propia cobertura de motorista sin seguro (UM) puede pagar, aunque el accidente haya sido en bicicleta — la cobertura lo sigue a usted, no a su auto. También investigamos cámaras y testigos para identificar al conductor. Repórtelo a la policía de inmediato: ese reporte suele ser requisito de la cobertura.' ),
                array( 'question' => 'No llevaba casco. ¿Pierdo mi caso?', 'answer' => 'No. En Georgia y Carolina del Sur, los adultos generalmente no están obligados a usar casco, y la falta de casco no le quita su derecho a compensación por la negligencia del conductor. La aseguradora puede intentar usarlo para reducir el valor — nosotros peleamos ese argumento.' ),
                array( 'question' => '¿Qué debo hacer después de un accidente de bicicleta?', 'answer' => 'Llame a la policía y asegúrese de que hagan un reporte, busque atención médica el mismo día, tome fotos de la escena, del vehículo y de su bicicleta, anote los datos del conductor y de los testigos, y guarde su bicicleta y casco dañados como evidencia. No dé declaraciones grabadas a la aseguradora.' ),
                array( 'question' => 'La aseguradora dice que yo tuve la culpa por ir en la calle. ¿Es cierto?', 'answer' => 'No. Las bicicletas tienen derecho a circular por la calle en ambos estados, y los conductores deben rebasar con distancia segura. Aun si usted tuviera parte de la culpa, puede recuperar compensación si es menor al 50% en Georgia (O.C.G.A. § 51-12-33) y menor al 51% en Carolina del Sur.' ),
                array( 'question' => '¿Cuánto tiempo tengo para reclamar?', 'answer' => 'En Georgia, 2 años desde la fecha de la lesión (O.C.G.A. § 9-3-33); en Carolina del Sur, 3 años (S.C. Code § 15-3-530). Los videos de cámaras se borran en días o semanas, así que llámenos lo antes posible.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar bicycle-accident-lawyers not found.' ); }

/* 2. electric-scooter-accident-lawyers */
$en = roden_es_seed_find_pillar( 'electric-scooter-accident-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Accidentes de Scooter Eléctrico',
        'excerpt' => 'Abogados de accidentes de scooter eléctrico en Georgia y Carolina del Sur. Conductores negligentes, scooters defectuosos y calles en mal estado. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Accidentes de scooter eléctrico en la ciudad</h2>
<p>Los scooters eléctricos — propios o de alquiler — llenaron los corredores urbanos y las zonas turísticas de Georgia y Carolina del Sur, pero las calles no se hicieron para ellos. Sin carrocería, sin cinturón y a menudo sin carril propio, el usuario de scooter queda expuesto a conductores que no lo ven al girar, que lo rebasan demasiado cerca o que salen de estacionamientos sin mirar. También causan accidentes los baches y el pavimento en mal estado, y los scooters de alquiler con frenos o llantas defectuosos por falta de mantenimiento.</p>
<p>Los abogados de accidentes de scooter eléctrico de Roden Law identifican a todos los posibles responsables: el conductor negligente y su aseguradora, la empresa de scooters compartidos si la unidad estaba defectuosa, el fabricante si el diseño falló, y hasta el gobierno local en ciertos casos de vías peligrosas — estos últimos con requisitos de aviso especiales y plazos más cortos.</p>
<h2>El problema del seguro — y una solución que quizá ya tiene</h2>
<p>Aquí está la trampa de estos casos: las aplicaciones de scooter no aseguran sus lesiones, y muchos conductores llevan pólizas mínimas. La salida que muchos desconocen es su propio seguro de auto: la cobertura de motorista sin seguro o con seguro insuficiente (UM/UIM) puede aplicar cuando un conductor lo golpea mientras usa un scooter, incluso si se dio a la fuga. Los plazos: 2 años (O.C.G.A. § 9-3-33) en Georgia y 3 años (S.C. Code § 15-3-530) en Carolina del Sur, con culpa comparativa (menos del 50% en Georgia, O.C.G.A. § 51-12-33; menos del 51% en Carolina del Sur).</p>
<p><a href="/es/contact/">Contáctenos hoy</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a> para una consulta gratuita en español. Si su accidente fue en bicicleta, visite nuestra página de <a href="/es/practice-areas/bicycle-accident-lawyers/">abogados de accidentes de bicicleta</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de scooter eléctrico en Georgia y Carolina del Sur. Conductores negligentes y scooters defectuosos. Gratis: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de accidentes de scooter eléctrico hace responder al conductor que lo golpeó, a la empresa de scooters si la unidad estaba defectuosa — y encuentra cobertura en su propia póliza UM cuando el conductor no tiene seguro. Consulta gratuita en español.',
            '_roden_why_hire'         => '<p>Los casos de scooter son nuevos y las aseguradoras los tratan como casos de segunda: culpan al usuario, señalan las ordenanzas locales y ofrecen poco. En Roden Law los tratamos como lo que son — lesiones graves causadas por negligencia. Obtenemos los videos urbanos antes de que se borren, los datos de la aplicación de alquiler que registran velocidad y recorrido, y los registros de mantenimiento de la unidad. Luego identificamos cada póliza disponible: la del conductor, la cobertura UM/UIM suya, y la responsabilidad de la empresa de scooters o del fabricante cuando la unidad falló.</p><p>Atendemos a la comunidad hispana de Georgia y Carolina del Sur con consultas en español las 24 horas, confidenciales sin importar su estatus migratorio. Más de $300 millones recuperados, 5,000+ casos, 62 años de experiencia combinada y 6 oficinas — sin honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Conductores que giran o cambian de carril sin ver al scooter', 'Salidas de estacionamientos y entradas sin precaución', 'Conductores distraídos con el teléfono', 'Baches y pavimento en mal estado', 'Scooters de alquiler con frenos o llantas defectuosos', 'Puertas de autos abiertas sin mirar' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Lesiones cerebrales y conmociones', 'description' => 'La mayoría de los usuarios de scooters de alquiler no lleva casco, y las caídas de cabeza contra el pavimento causan conmociones y daño cerebral duradero.' ),
                array( 'name' => 'Fracturas de muñeca, brazo y codo', 'description' => 'Al salir despedido del scooter, el usuario cae sobre las manos, fracturando muñecas y codos — lesiones que suelen requerir cirugía y placas.' ),
                array( 'name' => 'Lesiones faciales y dentales', 'description' => 'Las caídas de frente sin protección fracturan mandíbulas, narices y dientes, exigiendo cirugías reconstructivas y dejando cicatrices visibles.' ),
                array( 'name' => 'Fracturas de tibia y tobillo', 'description' => 'El impacto directo del vehículo o la caída con el pie atrapado en la plataforma fractura piernas y tobillos, con meses sin poder trabajar de pie.' ),
                array( 'name' => 'Abrasiones profundas y cicatrices', 'description' => 'Deslizarse por el asfalto sin protección arranca la piel, causando heridas que se infectan con facilidad y dejan cicatrices permanentes.' ),
                array( 'name' => 'Lesiones de columna', 'description' => 'Las caídas violentas y los impactos de vehículos dañan discos y vértebras, causando dolor crónico que limita el trabajo y la vida diaria.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => 'Un auto me golpeó mientras iba en scooter. ¿Quién paga?', 'answer' => 'La aseguradora del conductor negligente es la primera fuente. Si el conductor se dio a la fuga o lleva una póliza mínima, su propia cobertura de motorista sin seguro o con seguro insuficiente (UM/UIM) puede cubrir la diferencia — aunque usted no estuviera en su auto. Revisamos todas las pólizas disponibles gratis.' ),
                array( 'question' => '¿La empresa del scooter de alquiler responde por mis lesiones?', 'answer' => 'Puede responder si la unidad estaba defectuosa — frenos gastados, llantas dañadas, acelerador que falla — por falta de mantenimiento, o si el fabricante diseñó mal el scooter. Los acuerdos de usuario de las aplicaciones intentan limitar los reclamos, pero no siempre lo logran. Reporte la falla en la aplicación y consérvela como evidencia.' ),
                array( 'question' => '¿Qué pasa si me caí por un bache o pavimento en mal estado?', 'answer' => 'Puede haber un reclamo contra el gobierno local o el propietario responsable de esa vía. Ojo: los reclamos contra entidades de gobierno tienen requisitos de aviso previo con plazos mucho más cortos que los normales — a veces de pocos meses — así que consúltenos de inmediato.' ),
                array( 'question' => 'No llevaba casco. ¿Puedo reclamar de todos modos?', 'answer' => 'Sí. La falta de casco no le quita su derecho a reclamar por la negligencia de otro. Bajo la culpa comparativa, usted recupera si su culpa es menor al 50% en Georgia (O.C.G.A. § 51-12-33) y menor al 51% en Carolina del Sur, con reducción proporcional.' ),
                array( 'question' => '¿Cuánto tiempo tengo para presentar mi reclamo?', 'answer' => 'En Georgia, 2 años desde la lesión (O.C.G.A. § 9-3-33); en Carolina del Sur, 3 años (S.C. Code § 15-3-530). Pero los videos urbanos y los datos de la aplicación se pierden rápido, y los reclamos contra el gobierno exigen aviso mucho antes. Llámenos ya.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar electric-scooter-accident-lawyers not found.' ); }

WP_CLI::log( '═══ BATCH 14 DONE ═══' );
