<?php
/**
 * ES Seeder — Batch 26: Resources (seguros y valor del caso), part 2.
 * Resources: south-carolina-um-uim-stacking, south-carolina-car-accident-settlement-value.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-26-res-insurance.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 26 — RESOURCES: INSURANCE + VALUE ═══' );

/* 3. south-carolina-um-uim-stacking */
$en = get_page_by_path( 'south-carolina-um-uim-stacking', OBJECT, 'resource' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Cobertura UM y UIM en Carolina del Sur: Cómo Acumular ("Stacking") Pólizas',
        'excerpt' => 'Carolina del Sur permite acumular ("stack") cobertura de motorista sin seguro (UM) y con seguro insuficiente (UIM) de varios vehículos o pólizas — multiplicando lo que puede recuperar.',
        'content' => <<<'HTML'
<p>Carolina del Sur es uno de los estados que permite <strong>acumular ("stack")</strong> la cobertura de motorista sin seguro (UM) y con seguro insuficiente (UIM) — es decir, combinar los límites de cobertura de más de un vehículo o de más de una póliza para aumentar el dinero total disponible después de un choque. Cuando lo golpea un conductor sin seguro o con poco seguro, el "stacking" puede ser la diferencia entre un pago limitado a una sola póliza pequeña y una recuperación suficiente para cubrir realmente sus facturas médicas, ingresos perdidos y demás pérdidas.</p>
<p>Las reglas de motorista sin seguro y con seguro insuficiente de Carolina del Sur están en el <strong>S.C. Code &sect;&sect; 38-77-140, 38-77-150 y 38-77-160</strong>, y el derecho a acumular ha sido moldeado por décadas de decisiones judiciales. Roden Law trabaja con honorarios de contingencia — sin costo por adelantado y sin honorarios a menos que ganemos.</p>
<h2>¿Qué son las coberturas UM y UIM?</h2>
<p>Son las partes de <em>su propia</em> póliza de auto que lo protegen cuando el conductor culpable no puede pagar:</p>
<ul>
<li><strong>Motorista sin seguro (UM)</strong> paga por sus lesiones cuando el conductor culpable <em>no tiene</em> seguro de responsabilidad, o en atropellos con fuga donde el conductor no puede identificarse.</li>
<li><strong>Motorista con seguro insuficiente (UIM)</strong> paga cuando el conductor culpable <em>sí tiene</em> seguro, pero no el suficiente para cubrir la magnitud real de sus lesiones.</li>
</ul>
<p>Estas coberturas importan porque los límites mínimos exigidos en Carolina del Sur son relativamente bajos. Cuando una persona gravemente lesionada es golpeada por un conductor con solo el mínimo, la póliza del culpable se agota mucho antes que las facturas médicas. UM y UIM — especialmente acumuladas — llenan ese vacío.</p>
<h2>¿Qué significa "acumular" (stack) cobertura?</h2>
<p>Acumular significa combinar límites de UM o UIM de más de una fuente para crear un fondo de cobertura más grande. Hay dos formas comunes:</p>
<ul>
<li><strong>Acumulación dentro de una póliza</strong> — combinar la cobertura de varios vehículos asegurados bajo una misma póliza.</li>
<li><strong>Acumulación entre pólizas</strong> — combinar cobertura de pólizas separadas que puedan aplicarle.</li>
</ul>
<p>Si usted tiene cobertura UIM en dos vehículos de su hogar, la acumulación puede permitirle combinar esos límites en lugar de quedar limitado a uno solo. Que pueda acumular depende en parte de su relación con el titular de la póliza: Carolina del Sur generalmente permite acumular al <strong>asegurado nombrado, su cónyuge y los familiares que residen con él</strong> (asegurados de "clase uno"), mientras que un pasajero o conductor autorizado ("clase dos") suele quedar limitado a la cobertura del vehículo en el que iba. Las reglas también dependen de qué vehículos y pólizas estuvieron involucrados en el choque — exactamente por eso hay que revisar cada póliza potencialmente aplicable.</p>
<h2>Por qué acumular puede aumentar dramáticamente su recuperación</h2>
<p>Suponga que un conductor sin seguro causa un choque que le deja $200,000 en daños, y usted tiene $100,000 de cobertura UM en cada uno de dos vehículos del hogar. Sin acumulación, podría quedar limitado a un solo límite de $100,000. Con acumulación, podría combinarlos hacia sus $200,000 en pérdidas. La misma lógica aplica al UIM cuando la póliza del culpable es demasiado pequeña. Por eso las aseguradoras no se apuran a decirle que la acumulación podría estar disponible — les cuesta más dinero.</p>
<h2>¿Cómo sé si puedo acumular mi cobertura?</h2>
<p>Depende del lenguaje específico de sus pólizas, cómo se compró la cobertura, el número de vehículos y pólizas involucrados, y su relación con los titulares. Como la respuesta depende de detalles fáciles de malinterpretar, lo más seguro es que un abogado obtenga y revise <em>todas</em> las pólizas que puedan cubrirlo: la suya, las de su hogar y a veces otras más. A muchas personas les dicen "esa es toda la cobertura que hay" cuando en realidad existe cobertura acumulable adicional.</p>
<h2>¿Lo golpeó un conductor sin seguro o con poco seguro?</h2>
<p>No significa que se quedó sin opciones. Las reglas de UM/UIM y acumulación de Carolina del Sur existen precisamente para esta situación. Un abogado de Roden Law revisará sus pólizas sin costo e identificará toda la cobertura disponible. <a href="/es/contact/">Contáctenos</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a> — la consulta es gratuita y en español. Vea también el <a href="/es/resources/south-carolina-statute-of-limitations/">plazo legal para demandar</a>, la regla de <a href="/es/resources/south-carolina-comparative-negligence/">negligencia comparativa</a> y nuestra página de <a href="/es/practice-areas/car-accident-lawyers/">abogados de accidentes de auto</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Carolina del Sur permite acumular ("stack") cobertura UM y UIM de varios vehículos o pólizas para aumentar su recuperación. Consulta gratis en español.',
            '_roden_key_takeaways'    => 'Carolina del Sur permite a los conductores lesionados acumular ("stack") la cobertura de motorista sin seguro (UM) y con seguro insuficiente (UIM), lo que significa que puede combinar los límites de cobertura de más de un vehículo o póliza para aumentar lo que puede recuperar tras un choque con un conductor sin seguro o con seguro insuficiente. La acumulación puede elevar dramáticamente el dinero disponible cuando el conductor culpable tiene poco o ningún seguro. Que pueda acumular, y cómo, depende de sus pólizas específicas y de cómo se compró la cobertura, por lo que las pólizas deben revisarse con cuidado. Como las aseguradoras no ofrecen la acumulación por iniciativa propia, que un abogado examine cada póliza disponible suele ser la diferencia entre un pago limitado y una compensación completa.',
            '_roden_faqs'             => array(
                array( 'question' => '¿Se puede acumular la cobertura UM y UIM en Carolina del Sur?', 'answer' => 'Sí. Carolina del Sur permite acumular ("stack") la cobertura de motorista sin seguro (UM) y con seguro insuficiente (UIM) en muchas situaciones, lo que significa que puede combinar límites de cobertura de más de un vehículo o póliza para aumentar lo que puede recuperar. Que pueda acumular depende de sus pólizas específicas, así que cada póliza debe revisarse con cuidado.' ),
                array( 'question' => '¿Cuál es la diferencia entre la cobertura UM y la UIM?', 'answer' => 'La cobertura de motorista sin seguro (UM) paga por sus lesiones cuando el conductor culpable no tiene seguro de responsabilidad, o en casos de fuga donde no puede identificarse. La cobertura de motorista con seguro insuficiente (UIM) paga cuando el conductor culpable tiene seguro pero no el suficiente para cubrir sus lesiones. Ambas lo protegen a través de su propia póliza.' ),
                array( 'question' => '¿Cómo aumenta la acumulación mi recuperación en Carolina del Sur?', 'answer' => 'La acumulación combina límites de cobertura de varios vehículos o pólizas en un fondo más grande. Por ejemplo, si tiene $100,000 de cobertura UM en cada uno de dos vehículos del hogar, la acumulación puede permitirle combinarlos hacia sus pérdidas en lugar de quedar limitado a un solo límite. Esto puede multiplicar el dinero disponible cuando el culpable tiene poco o ningún seguro.' ),
                array( 'question' => '¿Cómo sé si puedo acumular mi cobertura?', 'answer' => 'Depende del lenguaje de su póliza, cómo se compró la cobertura, cuántos vehículos y pólizas hay involucrados, y su relación con los titulares. Como la respuesta depende de detalles fáciles de malinterpretar, lo más seguro es que un abogado revise cada póliza que pueda aplicar — a muchas personas les dicen erróneamente que no existe cobertura adicional.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN resource south-carolina-um-uim-stacking not found.' ); }

/* 4. south-carolina-car-accident-settlement-value */
$en = get_page_by_path( 'south-carolina-car-accident-settlement-value', OBJECT, 'resource' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => '¿Cuánto Vale un Caso de Accidente de Auto en Carolina del Sur?',
        'excerpt'  => 'La mayoría de los acuerdos por accidentes de auto en Carolina del Sur van desde unos miles de dólares hasta varios cientos de miles o más, según las lesiones, la culpa y la cobertura.',
        'content' => <<<'HTML'
<p>La mayoría de los acuerdos por accidentes de auto en Carolina del Sur caen entre unos miles de dólares y varios cientos de miles, mientras que los casos con discapacidad permanente, parálisis o muerte pueden alcanzar <strong>$1,000,000 o más</strong>. Los reclamos menores de tejidos blandos suelen resolverse en el rango de <strong>$3,000 a $25,000</strong>, y los casos con lesiones graves, cirugía y limitaciones duraderas comúnmente quedan en el rango de <strong>$50,000 a $300,000+</strong>. Lo que su caso realmente vale depende de la gravedad de sus lesiones, sus facturas médicas e ingresos perdidos totales, quién tuvo la culpa y cuánta cobertura de seguro hay disponible. No existe un "promedio" que aplique a todos los casos, y estas cifras son ilustraciones educativas — los resultados pasados no garantizan resultados futuros.</p>
<h2>Qué determina el valor de su caso</h2>
<p>El valor lo determinan sus daños totales — las pérdidas financieras medibles más las pérdidas humanas. Los <strong>daños económicos</strong> incluyen facturas médicas pasadas y futuras, salarios perdidos y capacidad de ganancia reducida, daños a la propiedad y gastos de bolsillo. Los <strong>daños no económicos</strong> compensan el daño humano: dolor y sufrimiento, angustia mental y estrés emocional, pérdida del disfrute de la vida, y desfiguración o deterioro permanente. Carolina del Sur <strong>no impone un tope general</strong> a los daños no económicos en casos ordinarios de auto — el tope estatutario aplica solo a la negligencia médica.</p>
<h2>Rangos ilustrativos por gravedad de la lesión</h2>
<table>
<tr><th>Gravedad</th><th>Ejemplos típicos</th><th>Rango ilustrativo</th></tr>
<tr><td>Menor</td><td>Distensiones de tejidos blandos, latigazo leve, recuperación completa</td><td>$3,000 &ndash; $25,000</td></tr>
<tr><td>Moderada</td><td>Fracturas, hernias de disco, una cirugía con recuperación</td><td>$25,000 &ndash; $100,000</td></tr>
<tr><td>Grave</td><td>Varias cirugías, limitaciones permanentes, rehabilitación larga</td><td>$100,000 &ndash; $500,000+</td></tr>
<tr><td>Catastrófica</td><td>Lesión cerebral, lesión medular, parálisis, amputación, muerte por negligencia</td><td>$500,000 &ndash; varios millones+</td></tr>
</table>
<p>Dos casos con el mismo diagnóstico pueden resolverse por montos muy distintos según la culpa, los límites del seguro, la fuerza de la evidencia y cómo la lesión afecta la vida de esa persona. Ningún rango aquí es una promesa ni una predicción.</p>
<h2>Cómo los límites del seguro y la cobertura UM/UIM afectan su pago</h2>
<p>En la práctica, el techo de muchos acuerdos no son sus lesiones sino el seguro disponible. Carolina del Sur exige solo límites mínimos de responsabilidad de <strong>$25,000 por persona, $50,000 por accidente y $25,000 por daños a la propiedad (25/50/25)</strong>. Según el Departamento de Seguros de Carolina del Sur, estos son los límites más bajos que el estado permite, y muchos conductores no llevan más. Cuando una lesión grave excede la póliza de $25,000 del culpable, la cobertura de <strong>motorista sin seguro o con seguro insuficiente (UM/UIM)</strong> de su propia póliza suele ser lo que hace cobrable un reclamo serio — vea nuestra guía sobre <a href="/es/resources/south-carolina-um-uim-stacking/">cómo acumular cobertura UM/UIM</a>.</p>
<h2>Cómo la ley de Carolina del Sur afecta su pago</h2>
<p>Tres reglas clave: (1) generalmente tiene <strong>3 años</strong> desde el choque para demandar bajo el <strong>S.C. Code &sect; 15-3-530</strong> — dejar pasar el plazo normalmente elimina el derecho a recuperar; (2) la <strong>negligencia comparativa modificada</strong> reduce su compensación según su porcentaje de culpa y la elimina al 51% o más — si su caso vale $100,000 y le asignan 20% de culpa, recupera $80,000; y (3) los <strong>daños punitivos</strong> pueden estar disponibles ante conducta imprudente o dolosa (conducir ebrio, carreras callejeras, fuga) y bajo el <strong>S.C. Code &sect; 15-32-530</strong> generalmente se limitan al mayor entre tres veces los daños compensatorios o $500,000, con excepciones estatutarias.</p>
<h2>Cómo se calcula un acuerdo</h2>
<p>Se suman los daños económicos (facturas, salarios, reparaciones — un número duro sacado de los registros) y los no económicos, y luego se ajusta por la culpa y el seguro disponible. Un método informal común es el "multiplicador": el dolor y sufrimiento se estima multiplicando los daños económicos por una cifra (a menudo entre 1.5 y 5) según la gravedad y permanencia de la lesión. El multiplicador es un concepto aproximado de la industria, no una fórmula legal de Carolina del Sur — ningún estatuto lo fija y ningún abogado puede prometer un número.</p>
<h2>La trayectoria de Roden Law</h2>
<p>Roden Law ha recuperado más de <strong>$300 millones</strong> para clientes lesionados en más de <strong>5,000 casos</strong> de todo tipo, con un promedio de <strong>4.9 estrellas</strong> en cientos de reseñas de clientes. Estas cifras reflejan resultados en todo tipo de reclamos, no solo accidentes de auto, y no predicen ningún resultado individual. Si quiere una evaluación honesta de lo que puede valer su reclamo, un abogado lo revisará sin costo y en español. <a href="/es/contact/">Contáctenos</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Vea también nuestras páginas de <a href="/es/practice-areas/car-accident-lawyers/">accidentes de auto</a> y <a href="/es/practice-areas/wrongful-death-lawyers/">muerte por negligencia</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => '¿Cuánto vale un accidente de auto en Carolina del Sur? Desde unos miles hasta cientos de miles de dólares según lesiones, culpa y seguro. Consulta gratis en español.',
            '_roden_key_takeaways'    => 'La mayoría de los acuerdos por accidentes de auto en Carolina del Sur van desde aproximadamente $3,000 por lesiones menores hasta varios cientos de miles de dólares o más por lesiones graves y catastróficas, sin tope general de daños en casos ordinarios de auto. El valor depende de sus facturas médicas, ingresos perdidos, dolor, porcentaje de culpa y el seguro disponible — incluida la cobertura UM/UIM cuando el conductor culpable lleva solo el mínimo estatal de $25,000. Carolina del Sur le da 3 años para demandar (S.C. Code § 15-3-530). Cada caso es único y ningún resultado está garantizado.',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuál es el acuerdo promedio por accidente de auto en Carolina del Sur?', 'answer' => 'No existe un promedio único confiable, porque los acuerdos van desde unos miles de dólares por lesiones menores hasta varios cientos de miles o más por lesiones graves y catastróficas. El valor depende de la gravedad de las lesiones, las facturas médicas, los ingresos perdidos, la culpa y el seguro disponible. Cada caso es único y ningún resultado está garantizado.' ),
                array( 'question' => '¿Cuánto tiempo tengo para reclamar por un accidente de auto en Carolina del Sur?', 'answer' => 'Generalmente tiene 3 años desde la fecha del choque para presentar una demanda bajo el S.C. Code § 15-3-530. Si deja pasar ese plazo, normalmente pierde por completo el derecho a recuperar compensación. Actuar temprano también ayuda a preservar la evidencia y los testimonios que sostienen el valor de su reclamo.' ),
                array( 'question' => '¿Mi propia culpa reduce mi acuerdo en Carolina del Sur?', 'answer' => 'Sí. Carolina del Sur usa la negligencia comparativa modificada: solo puede recuperar si su culpa es menor al 51%, y su compensación se reduce según su porcentaje de culpa. Si su caso vale $100,000 y tiene 20% de culpa, recupera $80,000. Con 51% o más de culpa, no recupera nada.' ),
                array( 'question' => '¿Qué pasa si el conductor culpable solo tiene el seguro mínimo?', 'answer' => 'La cobertura mínima de responsabilidad de Carolina del Sur es de solo $25,000 por persona, lo que a menudo no alcanza para pagar una lesión grave. En ese caso, su propia cobertura de motorista sin seguro o con seguro insuficiente (UM/UIM) puede cubrir la diferencia. Identificar temprano cada póliza disponible es clave para recuperar lo que un caso serio realmente vale.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN resource south-carolina-car-accident-settlement-value not found.' ); }

WP_CLI::log( '═══ BATCH 26 DONE ═══' );
