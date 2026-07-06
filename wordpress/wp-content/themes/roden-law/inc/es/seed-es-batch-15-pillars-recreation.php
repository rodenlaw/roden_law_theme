<?php
/**
 * ES Seeder — Batch 15: Pillar practice areas (recreation vehicles).
 * Pillars: atv-side-by-side-accident-lawyers, golf-cart-accident-lawyers.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-15-pillars-recreation.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 15 — PILLARS: RECREATION ═══' );

/* 1. atv-side-by-side-accident-lawyers */
$en = roden_es_seed_find_pillar( 'atv-side-by-side-accident-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Accidentes de ATV y Side-by-Side',
        'excerpt' => 'Abogados de accidentes de ATV y side-by-side en Georgia y Carolina del Sur. Volcaduras, fallas del vehículo y operadores negligentes. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Accidentes de cuatrimotos y side-by-sides</h2>
<p>Los ATV (cuatrimotos) y los side-by-sides (UTV) son parte de la vida rural y recreativa de Georgia y Carolina del Sur — en fincas, senderos, playas y comunidades costeras del Lowcountry y las islas de Georgia. Pero son vehículos con un centro de gravedad alto que vuelcan con facilidad, y las volcaduras aplastan a conductores y pasajeros. Cuando el accidente lo causa un operador negligente, un propietario que prestó el vehículo a alguien sin experiencia o a un menor, una compañía de tours o alquiler descuidada, o un defecto del propio vehículo, usted tiene derecho a compensación.</p>
<p>Los abogados de accidentes de ATV y side-by-side de Roden Law investigan todas esas vías. Algunos modelos tienen historial de volcaduras y llamados a revisión (recalls) del fabricante — si el diseño del vehículo, el arnés o la estructura antivuelco fallaron, el fabricante puede ser responsable bajo la responsabilidad de productos. Conserve el vehículo sin repararlo: es la evidencia central.</p>
<h2>Plazos en Georgia y Carolina del Sur</h2>
<p>El plazo para demandar por lesiones personales es de 2 años (O.C.G.A. § 9-3-33) en Georgia y de 3 años (S.C. Code § 15-3-530) en Carolina del Sur. Ambos estados aplican culpa comparativa: recuperación con culpa menor al 50% en Georgia (O.C.G.A. § 51-12-33) y menor al 51% en Carolina del Sur. Los accidentes en propiedad ajena también pueden generar reclamos contra el dueño del terreno.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita en español o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Si el vehículo falló, visite nuestra página de <a href="/es/practice-areas/product-liability-lawyers/">abogados de responsabilidad de productos</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de ATV y side-by-side en Georgia y Carolina del Sur. Volcaduras, fallas y operadores negligentes. Gratis: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de accidentes de ATV y side-by-side hace responder al operador negligente, al propietario que prestó el vehículo, a la compañía de alquiler o al fabricante cuando una volcadura o un choque lo lesiona. Consulta gratuita en español con Roden Law.',
            '_roden_why_hire'         => '<p>Los casos de ATV y side-by-side se pelean en varios frentes a la vez, y la mayoría de las víctimas solo ve uno. En Roden Law investigamos al operador y su seguro, al propietario que confió el vehículo a alguien sin experiencia o a un menor (una doctrina llamada "entrustment negligente"), a la compañía de tours o alquiler que no dio instrucción ni equipo de seguridad, y al fabricante cuando el modelo tiene historial de volcaduras o llamados a revisión. También revisamos las pólizas de hogar y sombrilla del responsable, que muchas veces cubren estos accidentes cuando el seguro de auto no aplica.</p><p>Atendemos a la comunidad hispana de Georgia y Carolina del Sur con consultas en español las 24 horas, confidenciales sin importar su estatus migratorio. Más de $300 millones recuperados, 5,000+ casos, 62 años de experiencia combinada y 6 oficinas — sin honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Volcaduras por giros bruscos o terreno inclinado', 'Operadores sin experiencia o menores sin supervisión', 'Exceso de velocidad en senderos y caminos rurales', 'Operar bajo la influencia del alcohol', 'Fallas de diseño, arneses y estructuras antivuelco', 'Compañías de tours y alquiler sin instrucción de seguridad' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Lesiones por aplastamiento en volcaduras', 'description' => 'Cuando el vehículo vuelca, su peso cae sobre conductores y pasajeros, aplastando el pecho, la pelvis y las extremidades con lesiones que amenazan la vida.' ),
                array( 'name' => 'Lesiones cerebrales traumáticas', 'description' => 'Los ocupantes despedidos del vehículo o golpeados durante la volcadura sufren conmociones y daño cerebral, sobre todo cuando no llevaban casco.' ),
                array( 'name' => 'Lesiones de columna y médula espinal', 'description' => 'Las volcaduras y los impactos contra árboles o zanjas fracturan vértebras y dañan la médula, con riesgo de parálisis permanente.' ),
                array( 'name' => 'Fracturas múltiples', 'description' => 'Los brazos y piernas atrapados bajo el vehículo o golpeados en el choque sufren fracturas complejas que requieren cirugías y meses de rehabilitación.' ),
                array( 'name' => 'Quemaduras por incendio del vehículo', 'description' => 'Las fugas de combustible tras una volcadura pueden incendiar el vehículo, causando quemaduras graves a ocupantes atrapados por el arnés o la estructura.' ),
                array( 'name' => 'Lesiones internas', 'description' => 'El golpe del volante, del arnés o del propio vehículo daña órganos internos y causa sangrado que exige atención de emergencia inmediata.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => 'Me lesioné como pasajero en el ATV de un amigo. ¿Puedo reclamar?', 'answer' => 'Sí. Su reclamo se dirige al seguro del operador o del propietario — normalmente la póliza de hogar o una póliza especial del vehículo — no al bolsillo de su amigo. Reclamar es la forma de que sus gastos médicos no queden a cargo de su familia.' ),
                array( 'question' => '¿Quién responde si un menor manejaba el ATV?', 'answer' => 'Los padres o el propietario que permitió que un menor sin edad ni experiencia operara el vehículo pueden ser responsables por "entrustment negligente". Georgia y Carolina del Sur tienen reglas de edad y seguridad para operadores jóvenes, y violarlas es evidencia de negligencia.' ),
                array( 'question' => '¿Qué pasa si el accidente fue en un tour o con un vehículo alquilado?', 'answer' => 'Las compañías de tours y alquiler — comunes en las zonas costeras y de playa — deben dar instrucción de seguridad, equipo adecuado y vehículos bien mantenidos. Si no lo hicieron, pueden ser responsables aunque le hayan hecho firmar una renuncia; esas renuncias no siempre son válidas. Guarde su copia y consúltenos.' ),
                array( 'question' => 'El vehículo volcó sin razón aparente. ¿Puede ser un defecto?', 'answer' => 'Es posible. Varios modelos de ATV y side-by-side tienen historial de volcaduras y llamados a revisión por problemas de estabilidad, arneses y estructuras antivuelco. Conserve el vehículo sin repararlo — nuestros expertos lo examinan para determinar si el fabricante es responsable.' ),
                array( 'question' => '¿Cuánto tiempo tengo para demandar?', 'answer' => 'En Georgia, 2 años desde la fecha de la lesión (O.C.G.A. § 9-3-33); en Carolina del Sur, 3 años (S.C. Code § 15-3-530). La evidencia del terreno y del vehículo se pierde rápido, así que contáctenos de inmediato. La consulta es gratuita y en español.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar atv-side-by-side-accident-lawyers not found.' ); }

/* 2. golf-cart-accident-lawyers */
$en = roden_es_seed_find_pillar( 'golf-cart-accident-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Accidentes de Carritos de Golf',
        'excerpt' => 'Abogados de accidentes de carritos de golf en Georgia y Carolina del Sur. Comunidades costeras, resorts e islas: reclamamos por sus lesiones. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Accidentes de carritos de golf en la costa</h2>
<p>En las comunidades costeras de Carolina del Sur — Myrtle Beach, el Lowcountry, las islas alrededor de Charleston — y en las islas de Georgia como Jekyll y St. Simons, el carrito de golf es un vehículo de uso diario: para ir a la playa, al supermercado o a pasear con la familia. Pero un carrito no protege como un auto: no tiene cinturones adecuados, ni puertas, ni bolsas de aire, y los pasajeros — muchas veces niños — salen despedidos con facilidad en un giro brusco o un choque. Cuando un conductor negligente, un carrito mal mantenido o una vía peligrosa causan sus lesiones, los abogados de accidentes de carritos de golf de Roden Law hacen valer su reclamo.</p>
<p>Los responsables posibles van más allá del conductor: el propietario que prestó el carrito a un menor o a alguien sin licencia, la compañía de alquiler que no lo mantuvo, el resort o la comunidad que permite carritos en vías inseguras, y el conductor del auto que no vio al carrito al cruzarse. Cada estado y municipio tiene reglas propias sobre dónde pueden circular los carritos y quién puede manejarlos — violarlas es evidencia de negligencia.</p>
<h2>Plazos en Georgia y Carolina del Sur</h2>
<p>El plazo para demandar por lesiones personales es de 2 años (O.C.G.A. § 9-3-33) en Georgia y de 3 años (S.C. Code § 15-3-530) en Carolina del Sur, con culpa comparativa: recuperación con culpa menor al 50% en Georgia (O.C.G.A. § 51-12-33) y menor al 51% en Carolina del Sur. Si un auto golpeó su carrito y el conductor no tiene seguro suficiente, su propia cobertura de motorista sin seguro (UM/UIM) puede cubrir la diferencia.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a> para una consulta gratuita en español. Si el accidente fue con un ATV o side-by-side, visite nuestra página de <a href="/es/practice-areas/atv-side-by-side-accident-lawyers/">abogados de accidentes de ATV y side-by-side</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de carritos de golf en Georgia y Carolina del Sur. Myrtle Beach, Lowcountry e islas de Georgia. Gratis: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de accidentes de carritos de golf hace responder al conductor negligente, al propietario, a la compañía de alquiler o al resort cuando un accidente de carrito lo lesiona a usted o a su familia. En Roden Law la consulta es gratuita, en español y confidencial.',
            '_roden_why_hire'         => '<p>Los accidentes de carritos de golf parecen casos simples hasta que la aseguradora pregunta qué póliza aplica: ¿el seguro de auto del conductor? ¿la póliza de hogar del propietario? ¿el seguro comercial del resort o de la compañía de alquiler? En Roden Law resolvemos ese rompecabezas todos los días en las comunidades costeras donde ejercemos — nuestras oficinas de Myrtle Beach, Charleston, Savannah y Brunswick están en el corazón del territorio de los carritos de golf. Investigamos las reglas locales de circulación, el mantenimiento del carrito y la conducta del conductor, y reclamamos contra cada póliza disponible, incluida su cobertura UM si un auto sin seguro golpeó su carrito.</p><p>Atendemos a la comunidad hispana con consultas en español las 24 horas, confidenciales sin importar su estatus migratorio. Más de $300 millones recuperados, 5,000+ casos, 62 años de experiencia combinada y 6 oficinas — sin honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Choques con autos en cruces y vías compartidas', 'Pasajeros despedidos en giros bruscos', 'Menores manejando sin supervisión ni licencia', 'Conductores bajo la influencia del alcohol', 'Carritos de alquiler con frenos o llantas en mal estado', 'Volcaduras en pendientes, curvas y bordes de vía' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Lesiones cerebrales traumáticas', 'description' => 'Los pasajeros despedidos del carrito golpean la cabeza contra el pavimento sin ninguna protección, causando conmociones y daño cerebral duradero, sobre todo en niños.' ),
                array( 'name' => 'Fracturas de brazos y piernas', 'description' => 'Las caídas del carrito y los choques con autos fracturan muñecas, brazos, tobillos y piernas, con cirugías y meses de recuperación.' ),
                array( 'name' => 'Lesiones de cabeza y cara en niños', 'description' => 'Los niños son los pasajeros más vulnerables: salen despedidos con facilidad y sufren lesiones craneales y faciales que exigen atención especializada.' ),
                array( 'name' => 'Lesiones de columna y cuello', 'description' => 'Los impactos y las volcaduras dañan discos y vértebras, causando dolor crónico y limitaciones que se extienden mucho más allá de las vacaciones.' ),
                array( 'name' => 'Lesiones por aplastamiento en volcaduras', 'description' => 'Cuando el carrito vuelca, su estructura cae sobre los ocupantes, causando fracturas de pelvis, lesiones internas y extremidades aplastadas.' ),
                array( 'name' => 'Abrasiones y laceraciones profundas', 'description' => 'Caer del carrito en movimiento sobre asfalto o concreto arranca la piel y causa heridas profundas con riesgo de infección y cicatrices.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Qué seguro cubre un accidente de carrito de golf?', 'answer' => 'Depende del caso: puede ser la póliza de hogar del propietario del carrito, el seguro comercial de la compañía de alquiler o del resort, el seguro de auto del conductor que lo golpeó, o su propia cobertura de motorista sin seguro (UM/UIM). Identificar todas las pólizas es la mitad del caso — lo hacemos gratis en la consulta.' ),
                array( 'question' => 'Mi hijo se cayó de un carrito manejado por otro menor. ¿Hay reclamo?', 'answer' => 'Probablemente sí. El propietario que permitió que un menor sin edad legal manejara puede ser responsable por confiar el vehículo negligentemente, y su póliza de hogar suele cubrir el reclamo. Las reglas de edad y licencia para carritos varían por estado y municipio, y violarlas es evidencia fuerte de negligencia.' ),
                array( 'question' => '¿Puedo reclamar contra la compañía que me alquiló el carrito?', 'answer' => 'Sí, si el carrito tenía fallas de mantenimiento — frenos gastados, llantas lisas, dirección defectuosa — o si la compañía lo alquiló sin verificar requisitos ni dar instrucciones. Las renuncias que firman los clientes no siempre protegen a la compañía cuando hubo negligencia. Guarde su contrato y fotos del carrito.' ),
                array( 'question' => 'El accidente fue durante nuestras vacaciones en Carolina del Sur, pero vivimos en otro estado. ¿Pueden llevar mi caso?', 'answer' => 'Sí. El reclamo se rige por la ley del estado donde ocurrió el accidente, y nosotros ejercemos en Georgia y Carolina del Sur, con oficinas en las zonas costeras donde estos accidentes ocurren. Manejamos su caso mientras usted se recupera en casa.' ),
                array( 'question' => '¿Cuánto tiempo tengo para presentar mi reclamo?', 'answer' => 'En Georgia, 2 años desde la fecha de la lesión (O.C.G.A. § 9-3-33); en Carolina del Sur, 3 años (S.C. Code § 15-3-530). Los videos de resorts y negocios se borran pronto y los testigos de vacaciones se dispersan, así que contáctenos lo antes posible.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar golf-cart-accident-lawyers not found.' ); }

WP_CLI::log( '═══ BATCH 15 DONE ═══' );
