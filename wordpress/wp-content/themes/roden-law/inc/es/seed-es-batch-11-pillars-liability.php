<?php
/**
 * ES Seeder — Batch 11: Pillar practice areas (liability).
 * Pillars: product-liability-lawyers, premises-liability-lawyers.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-11-pillars-liability.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 11 — PILLARS: LIABILITY ═══' );

/* 1. product-liability-lawyers */
$en = roden_es_seed_find_pillar( 'product-liability-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Responsabilidad de Productos',
        'excerpt' => 'Abogados de responsabilidad de productos en Georgia y Carolina del Sur. Si un producto defectuoso lo lesionó, el fabricante debe responder. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Cuando un producto defectuoso causa la lesión</h2>
<p>Los productos que compramos deben ser seguros cuando se usan como se espera. Cuando un vehículo, una herramienta eléctrica, una máquina de trabajo, un medicamento o un producto para niños tiene un defecto y causa una lesión, el fabricante, el distribuidor y el vendedor pueden ser responsables. Los abogados de responsabilidad de productos de Roden Law investigan tres tipos de defecto: de diseño (el producto es peligroso tal como fue concebido), de fabricación (algo salió mal al producirlo) y de advertencia (no le avisaron del riesgo ni le dieron instrucciones adecuadas).</p>
<p>Estos casos se pelean contra corporaciones grandes con equipos legales dedicados a negar todo. La evidencia clave es el producto mismo: consérvelo tal como quedó, junto con el empaque, el recibo y las instrucciones. No lo repare, no lo tire y no lo devuelva — sin el producto, probar el defecto se vuelve mucho más difícil.</p>
<h2>Plazos y culpa comparativa</h2>
<p>El plazo para demandar por lesiones personales es de 2 años (O.C.G.A. § 9-3-33) en Georgia y de 3 años (S.C. Code § 15-3-530) en Carolina del Sur. Ambos estados aplican culpa comparativa: en Georgia usted puede recuperar si su culpa es menor al 50% (O.C.G.A. § 51-12-33); en Carolina del Sur, si es menor al 51%. El fabricante intentará culparlo por "mal uso" del producto — no acepte esa versión sin hablar con un abogado.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita en español o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Si una máquina defectuosa lo lesionó en el trabajo, vea también nuestra página de <a href="/es/practice-areas/workers-compensation-lawyers/">abogados de compensación laboral</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de responsabilidad de productos en Georgia y Carolina del Sur. Productos defectuosos: el fabricante debe responder. Gratis: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de responsabilidad de productos hace responder al fabricante, al distribuidor o al vendedor cuando un producto defectuoso lo lesiona a usted o a su familia. En Roden Law la consulta es gratuita, en español y sin compromiso.',
            '_roden_why_hire'         => '<p>Los casos de productos defectuosos exigen recursos que la mayoría de las firmas no tiene: ingenieros que examinan el producto, expertos que reconstruyen cómo falló y la capacidad de litigar contra corporaciones nacionales que nunca admiten un defecto por las buenas. En Roden Law preservamos el producto como evidencia, contratamos a los expertos correctos e investigamos si el mismo defecto ha lesionado a otras personas — un patrón que puede multiplicar la fuerza de su caso.</p><p>Atendemos a la comunidad hispana de Georgia y Carolina del Sur con consultas en español las 24 horas, confidenciales sin importar su estatus migratorio. Más de $300 millones recuperados, 5,000+ casos, 62 años de experiencia combinada y 6 oficinas — y no cobramos honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Autopartes defectuosas: bolsas de aire, frenos y llantas', 'Herramientas y maquinaria sin protecciones adecuadas', 'Medicamentos y dispositivos médicos peligrosos', 'Electrodomésticos que causan incendios', 'Productos infantiles inseguros: cunas, sillas de auto y juguetes', 'Advertencias e instrucciones inadecuadas' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Quemaduras y lesiones por incendio', 'description' => 'Las baterías, los electrodomésticos y los cables defectuosos provocan incendios y explosiones que causan quemaduras graves con cicatrices permanentes e injertos de piel.' ),
                array( 'name' => 'Laceraciones y amputaciones', 'description' => 'Las herramientas y máquinas sin protecciones adecuadas pueden cortar o atrapar manos y dedos, causando amputaciones que cambian la vida laboral de la víctima.' ),
                array( 'name' => 'Lesiones cerebrales traumáticas', 'description' => 'Los cascos, las sillas de auto y los sistemas de seguridad que fallan en el momento del impacto dejan a las víctimas expuestas a daño cerebral permanente.' ),
                array( 'name' => 'Intoxicaciones y reacciones a medicamentos', 'description' => 'Los medicamentos mal etiquetados o con efectos ocultos pueden causar daño a órganos, hospitalizaciones prolongadas y condiciones médicas crónicas.' ),
                array( 'name' => 'Fracturas por fallas estructurales', 'description' => 'Las escaleras, sillas, andamios y equipos que colapsan por materiales o diseño deficientes causan caídas con fracturas graves y lesiones de columna.' ),
                array( 'name' => 'Asfixia y lesiones infantiles', 'description' => 'Los juguetes con piezas pequeñas, las cunas mal diseñadas y los productos infantiles inseguros causan asfixia y lesiones graves a los niños más pequeños.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => '¿A quién puedo demandar por un producto defectuoso?', 'answer' => 'Potencialmente a toda la cadena de comercio: el fabricante del producto, el fabricante de la pieza defectuosa, el distribuidor y la tienda que lo vendió. Identificar a todos los responsables importa porque aumenta los seguros disponibles para compensarlo.' ),
                array( 'question' => '¿Qué debo hacer con el producto que me lesionó?', 'answer' => 'Consérvelo exactamente como quedó después del accidente, junto con el empaque, las instrucciones y el recibo si los tiene. No lo repare, no lo tire y no lo devuelva a la tienda ni al fabricante. El producto es la evidencia central de su caso.' ),
                array( 'question' => '¿Tengo caso si usé el producto de forma un poco distinta a las instrucciones?', 'answer' => 'Es posible. Los fabricantes deben prever los usos razonablemente previsibles de sus productos, no solo el uso perfecto. Y bajo la culpa comparativa de Georgia y Carolina del Sur, usted puede recuperar aunque tenga parte de la culpa, siempre que no sea la mayor parte.' ),
                array( 'question' => '¿Cuánto tiempo tengo para presentar mi demanda?', 'answer' => 'En Georgia, 2 años desde la fecha de la lesión (O.C.G.A. § 9-3-33); en Carolina del Sur, 3 años (S.C. Code § 15-3-530). Además, algunos estados limitan cuántos años después de la venta del producto se puede demandar, así que consúltenos lo antes posible.' ),
                array( 'question' => '¿Cuánto cuesta contratar a Roden Law?', 'answer' => 'Nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos si recuperamos compensación para usted. La consulta es gratuita, en español y confidencial.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar product-liability-lawyers not found.' ); }

/* 2. premises-liability-lawyers */
$en = roden_es_seed_find_pillar( 'premises-liability-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Responsabilidad de Locales',
        'excerpt' => 'Abogados de responsabilidad de locales en Georgia y Carolina del Sur. Si una propiedad insegura lo lesionó, el propietario debe responder. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>La responsabilidad del propietario por una propiedad insegura</h2>
<p>Los dueños de tiendas, restaurantes, apartamentos, hoteles y estacionamientos tienen el deber legal de mantener sus propiedades razonablemente seguras para quienes las visitan. En Georgia, ese deber está escrito en la ley: el propietario que invita a otros a su local responde por los daños causados por su falta de cuidado ordinario en mantener el lugar seguro (O.C.G.A. § 51-3-1). Carolina del Sur impone deberes similares. Cuando un piso mojado sin señalizar, una escalera rota, una iluminación deficiente o la falta de seguridad causan una lesión, eso no es "mala suerte" — es negligencia del propietario.</p>
<p>Los casos de responsabilidad de locales incluyen mucho más que las caídas: ataques de perros en la propiedad, agresiones por seguridad negligente en apartamentos y estacionamientos, accidentes de piscina, objetos que caen de estanterías y quemaduras por instalaciones defectuosas. La clave es probar que el propietario sabía — o debía saber — del peligro y no lo corrigió ni le advirtió.</p>
<h2>Actúe rápido: la evidencia desaparece</h2>
<p>Los videos de seguridad se borran en días o semanas, los pisos se reparan y los testigos se olvidan. Además corre el plazo legal: 2 años (O.C.G.A. § 9-3-33) en Georgia y 3 años (S.C. Code § 15-3-530) en Carolina del Sur. Bajo la culpa comparativa, usted puede recuperar si su culpa es menor al 50% en Georgia (O.C.G.A. § 51-12-33) y menor al 51% en Carolina del Sur — no deje que el propietario lo convenza de que la culpa fue solo suya.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a> para una consulta gratuita en español. Si sufrió una caída, visite también nuestra página de <a href="/es/practice-areas/slip-and-fall-lawyers/">abogados de resbalones y caídas</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de responsabilidad de locales en Georgia y Carolina del Sur. Propiedades inseguras: el dueño debe responder (O.C.G.A. § 51-3-1). 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de responsabilidad de locales hace responder al propietario cuando una propiedad insegura — piso mojado, escalera rota, seguridad negligente — causa su lesión. En Roden Law la consulta es gratuita, en español y confidencial.',
            '_roden_why_hire'         => '<p>En los casos de responsabilidad de locales, la evidencia desaparece rápido: los videos de seguridad se sobrescriben, el peligro se repara al día siguiente y el reporte del incidente se queda en manos de la tienda. En Roden Law enviamos cartas de preservación de evidencia de inmediato, obtenemos los videos y registros de mantenimiento, y probamos lo que el propietario sabía del peligro y desde cuándo. Ese trabajo temprano es la diferencia entre un caso negado y una compensación completa.</p><p>Atendemos a la comunidad hispana de Georgia y Carolina del Sur con consultas en español las 24 horas, confidenciales sin importar su estatus migratorio. Más de $300 millones recuperados, 5,000+ casos, 62 años de experiencia combinada y 6 oficinas — sin honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Pisos mojados o resbaladizos sin señalización', 'Escaleras rotas y pasamanos sueltos', 'Iluminación deficiente en pasillos y estacionamientos', 'Seguridad negligente en apartamentos y locales', 'Piscinas sin cercas ni supervisión adecuada', 'Objetos y mercancía que caen de estanterías' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Fracturas de cadera y muñeca', 'description' => 'Las caídas sobre superficies duras fracturan caderas, muñecas y tobillos, y en adultos mayores una fractura de cadera puede significar cirugía y pérdida de independencia.' ),
                array( 'name' => 'Lesiones de cabeza y cerebrales', 'description' => 'Golpearse la cabeza contra el piso o un objeto al caer puede causar conmociones y lesiones cerebrales traumáticas con efectos duraderos en la memoria y el ánimo.' ),
                array( 'name' => 'Lesiones de espalda y columna', 'description' => 'Las caídas en escaleras y superficies resbaladizas hernian discos y dañan la columna, causando dolor crónico que limita el trabajo y la vida diaria.' ),
                array( 'name' => 'Desgarros de hombro y rodilla', 'description' => 'Al intentar frenar la caída, muchas víctimas desgarran el manguito rotador o los ligamentos de la rodilla, lesiones que suelen requerir cirugía y meses de terapia.' ),
                array( 'name' => 'Lesiones por agresiones con seguridad negligente', 'description' => 'Cuando un local con historial de crimen no ilumina ni vigila su propiedad, las víctimas de asaltos y agresiones pueden reclamar contra el propietario.' ),
                array( 'name' => 'Ahogamientos y lesiones de piscina', 'description' => 'Las piscinas sin cercas, avisos ni supervisión causan ahogamientos y lesiones cerebrales por falta de oxígeno, especialmente en niños pequeños.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Qué tengo que probar para ganar un caso contra el propietario?', 'answer' => 'Que existía una condición peligrosa en la propiedad, que el propietario sabía o debía saber de ella, que no la corrigió ni le advirtió, y que esa condición causó su lesión. En Georgia, el deber del propietario hacia sus visitantes está establecido en O.C.G.A. § 51-3-1. Los videos, registros de mantenimiento y quejas previas son evidencia clave.' ),
                array( 'question' => '¿Qué debo hacer justo después de lesionarme en un negocio?', 'answer' => 'Reporte el incidente a la gerencia y pida copia del reporte, tome fotos del peligro y de sus lesiones, anote los datos de los testigos y busque atención médica el mismo día. No dé declaraciones grabadas a la aseguradora del negocio antes de hablar con un abogado.' ),
                array( 'question' => 'El negocio dice que la culpa fue mía por no fijarme. ¿Pierdo el caso?', 'answer' => 'No necesariamente. Georgia y Carolina del Sur aplican culpa comparativa: usted puede recuperar compensación si su culpa es menor al 50% en Georgia y menor al 51% en Carolina del Sur, con una reducción proporcional. Culpar a la víctima es la defensa estándar de las aseguradoras — no la acepte sin pelear.' ),
                array( 'question' => '¿Puedo reclamar si me lesioné en un apartamento que rento?', 'answer' => 'Sí. Los dueños de complejos de apartamentos deben mantener las áreas comunes seguras — escaleras, pasillos, iluminación, piscinas — y proveer seguridad razonable si hay historial de crimen. Los inquilinos y sus visitantes lesionados por esas fallas pueden reclamar.' ),
                array( 'question' => '¿Cuánto tiempo tengo para demandar al propietario?', 'answer' => 'En Georgia, 2 años desde la fecha de la lesión (O.C.G.A. § 9-3-33); en Carolina del Sur, 3 años (S.C. Code § 15-3-530). Pero los videos de seguridad se borran en días, así que contáctenos de inmediato aunque el plazo parezca lejano.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar premises-liability-lawyers not found.' ); }

WP_CLI::log( '═══ BATCH 11 DONE ═══' );
