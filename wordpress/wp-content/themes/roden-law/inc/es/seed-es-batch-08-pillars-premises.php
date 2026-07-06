<?php
/**
 * ES Seeder — Batch 08: Pillar practice areas (premises).
 * Pillars: slip-and-fall-lawyers, dog-bite-lawyers.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-08-pillars-premises.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 08 — PILLARS: PREMISES ═══' );

/* 1. slip-and-fall-lawyers */
$en = roden_es_seed_find_pillar( 'slip-and-fall-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Accidentes por Caídas',
        'excerpt' => 'Abogados de accidentes por resbalones y caídas en Georgia y Carolina del Sur. Responsabilizamos a propietarios negligentes. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Cuando una propiedad peligrosa causa su caída</h2>
<p>Un piso mojado sin señalización, un escalón roto, un estacionamiento sin luz, mercancía que bloquea el pasillo: las caídas por resbalones y tropiezos causan fracturas, lesiones de espalda y lesiones cerebrales que cambian vidas. La ley de Georgia y Carolina del Sur exige que los dueños de negocios y propiedades mantengan sus locales razonablemente seguros para sus clientes e invitados. Cuando no lo hacen, responden por las lesiones que causan.</p>
<p>Para ganar un caso de caída hay que probar que existía una condición peligrosa, que el propietario la conocía o debía conocerla, y que no la corrigió ni advirtió a tiempo. Esa evidencia desaparece rápido: los videos de seguridad se borran y los pisos se limpian. Los abogados de Roden Law actúan de inmediato para exigir la preservación de videos, reportes de incidente y registros de mantenimiento.</p>
<h2>Plazos legales y culpa compartida</h2>
<p>En Georgia, usted generalmente tiene 2 años (O.C.G.A. § 9-3-33) para presentar su demanda; en Carolina del Sur, 3 años (S.C. Code § 15-3-530). Los propietarios casi siempre alegan que usted "no miró por dónde caminaba" — pero en Georgia puede recuperar compensación si fue menos del 50% culpable (O.C.G.A. § 51-12-33), y en Carolina del Sur si fue menos del 51%.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita en español o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Si su caída ocurrió en el trabajo, revise también nuestra página de <a href="/es/practice-areas/workers-compensation-lawyers/">compensación laboral</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes por caídas en Georgia y Carolina del Sur. Responsabilizamos a propietarios negligentes. Consulta gratis: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de accidentes por caídas prueba que el propietario conocía la condición peligrosa que causó su lesión y reclama compensación completa. Roden Law ha recuperado más de $300 millones para víctimas de accidentes en Georgia y Carolina del Sur.',
            '_roden_why_hire'         => '<p>Los casos de caídas se ganan o se pierden con la evidencia de los primeros días. En Roden Law enviamos de inmediato cartas de preservación para que el negocio no borre los videos de seguridad, obtenemos el reporte de incidente y los registros de limpieza y mantenimiento, y entrevistamos a los empleados y testigos antes de que las versiones cambien. Nuestra red de expertos médicos documenta lesiones que las aseguradoras suelen descartar como "preexistentes".</p><p>Con 62 años de experiencia combinada, más de 5,000 casos manejados y 6 oficinas en Georgia y Carolina del Sur, sabemos cómo enfrentar a las grandes cadenas de tiendas y sus aseguradoras. Consultas en español las 24 horas y sin honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Pisos mojados o recién trapeados sin señalización', 'Escaleras rotas o sin pasamanos', 'Iluminación deficiente en pasillos y estacionamientos', 'Alfombras sueltas y superficies desniveladas', 'Derrames no limpiados en supermercados', 'Aceras y estacionamientos con huecos o grietas' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Fracturas de cadera, muñeca y tobillo', 'description' => 'Al intentar frenar la caída, el peso del cuerpo fractura la muñeca, el tobillo o la cadera; las fracturas de cadera son especialmente graves en los adultos mayores.' ),
                array( 'name' => 'Lesiones de espalda y hernias de disco', 'description' => 'La caída sobre una superficie dura puede herniar los discos de la columna, causando dolor crónico que limita el trabajo y suele requerir terapia o cirugía.' ),
                array( 'name' => 'Lesiones cerebrales traumáticas por golpes en la cabeza', 'description' => 'Golpearse la cabeza contra el piso o un estante puede causar conmociones o daño cerebral duradero, incluso cuando la víctima no pierde el conocimiento.' ),
                array( 'name' => 'Lesiones de hombro y desgarres de ligamentos', 'description' => 'Caer sobre el brazo extendido puede desgarrar el manguito rotador y los ligamentos del hombro, lesiones dolorosas que a menudo requieren cirugía y rehabilitación prolongada.' ),
                array( 'name' => 'Lesiones de rodilla', 'description' => 'El impacto directo o la torsión durante la caída puede desgarrar los meniscos y ligamentos de la rodilla, dejando dolor persistente y movilidad limitada.' ),
                array( 'name' => 'Cortes y contusiones graves', 'description' => 'El contacto con bordes, esquinas o el piso causa cortes y hematomas profundos que, en personas mayores o que toman anticoagulantes, pueden tener complicaciones serias.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Qué debo probar para ganar un caso de caída?', 'answer' => 'Debe demostrar que existía una condición peligrosa, que el propietario la conocía o debía conocerla con una inspección razonable, y que no la corrigió ni le advirtió. También hay que probar que la caída causó sus lesiones. Por eso las fotos, los videos y el reporte de incidente son tan importantes.' ),
                array( 'question' => 'Me caí en una tienda. ¿Qué debo hacer?', 'answer' => 'Reporte la caída al gerente y pida que hagan un reporte de incidente, tome fotos de lo que causó la caída, obtenga los datos de los testigos y busque atención médica el mismo día. No dé declaraciones grabadas a la aseguradora de la tienda antes de consultar a un abogado.' ),
                array( 'question' => 'El propietario dice que la culpa fue mía. ¿Tengo caso?', 'answer' => 'Posiblemente sí. Que le echen la culpa es la defensa estándar. En Georgia usted puede recuperar compensación si fue menos del 50% culpable (O.C.G.A. § 51-12-33); en Carolina del Sur, menos del 51%. La evidencia decide, no la versión del negocio.' ),
                array( 'question' => '¿Qué compensación puedo recibir?', 'answer' => 'Gastos médicos presentes y futuros, salarios perdidos, pérdida de capacidad de trabajo y dolor y sufrimiento. El valor depende de la gravedad de sus lesiones y de la solidez de la evidencia; ningún abogado puede garantizar un resultado.' ),
                array( 'question' => '¿Cuánto tiempo tengo para demandar?', 'answer' => 'En Georgia, generalmente 2 años (O.C.G.A. § 9-3-33); en Carolina del Sur, 3 años (S.C. Code § 15-3-530). Pero los videos de seguridad pueden borrarse en días — contáctenos lo antes posible.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar slip-and-fall-lawyers not found.' ); }

/* 2. dog-bite-lawyers */
$en = roden_es_seed_find_pillar( 'dog-bite-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Mordeduras de Perro',
        'excerpt' => 'Abogados de mordeduras de perro en Georgia y Carolina del Sur. Compensación por ataques de animales, cicatrices y trauma. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Responsabilidad del dueño por el ataque de su perro</h2>
<p>Una mordedura de perro puede causar heridas profundas, infecciones, cicatrices permanentes y un trauma emocional que dura años — especialmente en los niños, que son las víctimas más frecuentes y suelen ser mordidos en la cara. Los dueños de perros tienen la obligación legal de controlar a sus animales, y cuando no lo hacen, responden por el daño.</p>
<p>La ley es distinta en cada estado. En Georgia, la ley de responsabilidad por animales (O.C.G.A. § 51-2-7) responsabiliza al dueño cuando el perro es peligroso o vicioso y el dueño lo manejó sin cuidado o lo dejó suelto — violar una ordenanza local de correa puede bastar para probarlo. En Carolina del Sur la ley es más favorable a la víctima: la responsabilidad es estricta (S.C. Code § 47-3-110), lo que significa que el dueño responde aunque el perro nunca hubiera mordido antes, siempre que usted estuviera legalmente en el lugar y no hubiera provocado al animal.</p>
<h2>Plazos para presentar su reclamo</h2>
<p>En Georgia, usted generalmente tiene 2 años (O.C.G.A. § 9-3-33) para presentar una demanda por lesiones personales; en Carolina del Sur, 3 años (S.C. Code § 15-3-530). La compensación normalmente la paga el seguro de vivienda del dueño del perro, no el dueño directamente — un dato importante cuando el dueño es un vecino o conocido.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita en español o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Conozca también nuestras otras <a href="/es/practice-areas/">áreas de práctica</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de mordeduras de perro en Georgia y Carolina del Sur. Compensación por ataques, cicatrices y trauma. Consulta gratis: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de mordeduras de perro responsabiliza al dueño del animal y reclama compensación por sus heridas, cicatrices y trauma emocional. Roden Law ha recuperado más de $300 millones para víctimas de accidentes en Georgia y Carolina del Sur.',
            '_roden_why_hire'         => '<p>Los casos de mordeduras dependen de la ley estatal correcta y de la investigación del animal. En Roden Law obtenemos los reportes de control de animales, el historial del perro, las ordenanzas locales de correa y las declaraciones de vecinos y testigos para construir el caso de responsabilidad. Documentamos con expertos médicos el costo real de sus lesiones — incluidas las cirugías reconstructivas futuras que las cicatrices suelen requerir, algo que las aseguradoras nunca ofrecen por su cuenta.</p><p>La compensación casi siempre proviene del seguro de vivienda del dueño, así que reclamar no significa arruinar a un vecino. Con 62 años de experiencia combinada, más de 5,000 casos y 6 oficinas en Georgia y Carolina del Sur, atendemos consultas en español las 24 horas y no cobramos honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Perros sueltos en violación de ordenanzas de correa', 'Dueños que conocían la agresividad previa del animal', 'Cercas o puertas en mal estado que dejan escapar al perro', 'Falta de supervisión del animal cerca de niños', 'Perros de guarda sin advertencias ni control adecuado', 'Paseadores que no pueden controlar al animal' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Heridas punzantes y desgarros profundos', 'description' => 'Los dientes del perro perforan y desgarran la piel y los tejidos, causando heridas profundas que requieren sutura y pueden dañar estructuras debajo de la piel.' ),
                array( 'name' => 'Cicatrices permanentes y desfiguración facial', 'description' => 'Las mordeduras en la cara, frecuentes en los niños, dejan cicatrices visibles y desfiguración que suelen requerir varias cirugías reconstructivas a lo largo de años.' ),
                array( 'name' => 'Infecciones graves', 'description' => 'La boca del perro transmite bacterias que pueden causar infecciones serias, incluidas celulitis y sepsis, que a veces requieren hospitalización y antibióticos intravenosos.' ),
                array( 'name' => 'Daño a nervios, tendones y músculos', 'description' => 'Una mordedura profunda puede seccionar nervios y tendones de las manos o los brazos, causando pérdida de fuerza, sensibilidad o movilidad que puede ser permanente.' ),
                array( 'name' => 'Fracturas por caídas durante el ataque', 'description' => 'Al ser derribada o al intentar escapar del animal, la víctima puede caer y sufrir fracturas de muñeca, cadera u otras lesiones adicionales.' ),
                array( 'name' => 'Trauma emocional y estrés postraumático, especialmente en niños', 'description' => 'El terror del ataque puede dejar pesadillas, ansiedad y un miedo duradero a los animales, un trauma psicológico que forma parte compensable del reclamo.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Qué debo hacer después de una mordedura de perro?', 'answer' => 'Lave la herida y busque atención médica de inmediato — las mordeduras se infectan con facilidad y puede necesitar vacunas. Reporte el ataque a control de animales, identifique al dueño del perro, tome fotos de sus heridas y del lugar, y anote los datos de los testigos antes de hablar con cualquier aseguradora.' ),
                array( 'question' => 'El perro nunca había mordido a nadie. ¿Tengo caso?', 'answer' => 'Depende del estado. En Carolina del Sur sí: la ley (S.C. Code § 47-3-110) impone responsabilidad estricta al dueño aunque sea la primera mordedura. En Georgia (O.C.G.A. § 51-2-7) hay que probar que el dueño manejó al animal sin cuidado o violó una ordenanza de correa — algo que logramos con más frecuencia de lo que la gente cree.' ),
                array( 'question' => 'El dueño del perro es mi vecino. ¿Vale la pena reclamar?', 'answer' => 'La compensación normalmente la paga el seguro de vivienda del dueño, no su bolsillo. Usted puede recuperar sus gastos médicos y compensación por sus cicatrices sin arruinar la relación con su vecino. Manejamos estos casos con discreción.' ),
                array( 'question' => '¿Qué compensación puedo recibir?', 'answer' => 'Gastos médicos (incluidas cirugías reconstructivas futuras), salarios perdidos, dolor y sufrimiento, y compensación por cicatrices permanentes y trauma emocional. En ataques a niños, el trauma psicológico es una parte importante del caso.' ),
                array( 'question' => '¿Cuánto tiempo tengo para presentar mi reclamo?', 'answer' => 'En Georgia, generalmente 2 años (O.C.G.A. § 9-3-33); en Carolina del Sur, 3 años (S.C. Code § 15-3-530). Los reclamos de menores tienen reglas especiales de plazo — consúltenos para revisar su situación.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar dog-bite-lawyers not found.' ); }

WP_CLI::log( '═══ BATCH 08 DONE ═══' );
