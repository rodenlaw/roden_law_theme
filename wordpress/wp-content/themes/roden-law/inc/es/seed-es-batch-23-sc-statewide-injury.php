<?php
/**
 * ES Seeder — Batch 23: SC statewide pillars (injury).
 * /es/south-carolina-personal-injury-lawyer/ + /es/south-carolina-workers-compensation-lawyer/
 * Translated from inc/seed-sc-pillar-personal-injury.php + inc/seed-sc-pillar-workers-comp.php.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-23-sc-statewide-injury.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 23 — SC STATEWIDE PILLARS: INJURY ═══' );

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

/* 1. /es/south-carolina-personal-injury-lawyer/ — master statewide PI pillar. */
$en = $roden_es_find_root_page( 'south-carolina-personal-injury-lawyer' );
if ( $en && $es_root ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Lesiones Personales en Carolina del Sur',
        'parent'  => $es_root,
        'excerpt' => 'Abogados de lesiones personales de Roden Law en Carolina del Sur: accidentes de auto, camiones, motocicleta, lesiones laborales y más, en todo el estado. Consulta gratuita — sin honorarios a menos que ganemos.',
        'content' => <<<'HTML'
<p>Cuando el descuido de otra persona lo deja lesionado en Carolina del Sur, usted no debería enfrentar a las aseguradoras solo. Los abogados de lesiones personales de Roden Law representan a personas lesionadas en todo el estado — desde el Lowcountry y el Grand Strand hasta el Midlands, el Upstate y el Pee Dee — desde nuestras oficinas en Charleston, North Charleston, Columbia y Myrtle Beach. Trabajamos con honorarios de contingencia: no paga nada por adelantado ni honorarios legales a menos que ganemos su caso.</p>

<h2>¿Qué tipos de casos manejan nuestros abogados de lesiones personales?</h2>
<p>Las lesiones personales cubren cualquier daño causado por la negligencia de otra parte. Roden Law maneja toda la gama en Carolina del Sur:</p>
<ul>
<li><a href="/es/south-carolina-car-accident-lawyers/">Accidentes de auto</a> — los reclamos por lesiones más comunes en todo el estado.</li>
<li><a href="/es/south-carolina-truck-accident-lawyers/">Accidentes de camiones</a> — casos complejos contra empresas de camiones y sus aseguradoras.</li>
<li><a href="/es/south-carolina-motorcycle-accident-lawyer/">Accidentes de motocicleta</a> — donde los motociclistas enfrentan el prejuicio de las aseguradoras.</li>
<li><a href="/es/south-carolina-workers-compensation-lawyer/">Lesiones en el trabajo</a> — compensación laboral y reclamos contra terceros.</li>
<li><a href="/es/south-carolina-wrongful-death-lawyer/">Muerte por negligencia</a> — cuando la negligencia le quita la vida a un ser querido.</li>
<li>Caídas y propiedades inseguras, productos defectuosos y más.</li>
</ul>

<h2>¿Cuánto tiempo tengo para presentar un reclamo por lesiones en Carolina del Sur?</h2>
<p>Para la mayoría de los reclamos por lesiones personales, el plazo es de <strong>3 años desde la fecha de la lesión</strong> bajo <strong>S.C. Code &sect; 15-3-530</strong>. Algunos reclamos — especialmente contra una entidad de gobierno bajo la Tort Claims Act de Carolina del Sur — tienen plazos más cortos, y la compensación laboral corre con su propio calendario. No espere para conocer su plazo exacto.</p>

<h2>¿Cómo afecta la culpa lo que puedo recuperar en Carolina del Sur?</h2>
<p>Carolina del Sur sigue una regla de <strong>negligencia comparativa modificada</strong>: usted puede recuperar compensación siempre que haya tenido menos del 51% de la culpa, pero su indemnización se reduce según su porcentaje. Las aseguradoras intentan inflar su culpa rutinariamente para pagar menos — nuestros abogados responden.</p>

<h2>¿Qué compensación puedo recuperar en un caso de lesiones en Carolina del Sur?</h2>
<p>Según su caso, puede recuperar daños económicos (facturas médicas, atención médica futura, salarios perdidos y capacidad de ingreso perdida), daños no económicos (dolor y sufrimiento, angustia emocional y pérdida del disfrute de la vida) y, en casos de negligencia grave, daños punitivos. Cuando la parte culpable no tiene seguro o no tiene suficiente, también puede ser posible acumular coberturas UM/UIM para aumentar lo disponible.</p>

<h2>¿Por qué elegir a Roden Law para su caso en Carolina del Sur?</h2>
<p>Roden Law ha recuperado <strong>más de $300 millones</strong> para víctimas de lesiones, ha manejado más de 5,000 casos, y tiene 4 oficinas en Carolina del Sur para que la ayuda nunca quede lejos. Atendemos consultas en español, manejamos cada caso con honorarios de contingencia, y tratamos su caso como si nuestra propia familia estuviera involucrada.</p>

<h2>Hable gratis con un abogado de lesiones personales en Carolina del Sur</h2>
<p>Si la negligencia de otra persona lo lesionó en cualquier parte de Carolina del Sur, un abogado de Roden Law revisará su caso sin costo, le explicará el plazo que aplica y le detallará sus opciones. No hay honorarios a menos que ganemos. <a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita en español.</p>
HTML,
        'meta'    => array(
            '_wp_page_template'        => 'templates/template-pillar-sc-statewide.php',
            '_roden_pillar_practice'   => 'Lesiones Personales',
            '_roden_pillar_practice_l' => 'un accidente',
            '_roden_meta_description'  => 'Abogados de lesiones personales en Carolina del Sur. Más de $300 millones recuperados. Hablamos español. Consulta gratuita — sin honorarios si no ganamos.',
            '_roden_key_takeaways'     => 'Si usted resultó lesionado por la negligencia de otra persona en cualquier parte de Carolina del Sur, generalmente tiene 3 años desde la fecha de la lesión para presentar un reclamo bajo S.C. Code § 15-3-530, y puede recuperar compensación siempre que haya tenido menos del 51% de la culpa. La ley de lesiones personales de Carolina del Sur cubre choques de auto, camión y motocicleta, lesiones en el trabajo, propiedades inseguras, productos defectuosos y muerte por negligencia, y puede permitirle recuperar facturas médicas, salarios perdidos, dolor y sufrimiento y — en casos graves — daños punitivos. Roden Law tiene 4 oficinas en Carolina del Sur — Charleston, North Charleston, Columbia y Myrtle Beach — y representa a personas lesionadas en todo el estado con honorarios de contingencia: no paga nada a menos que ganemos.',
            '_roden_faqs'              => array(
                array( 'question' => '¿Cuánto tiempo tengo para presentar un reclamo por lesiones personales en Carolina del Sur?', 'answer' => 'Para la mayoría de los reclamos, 3 años desde la fecha de la lesión, bajo S.C. Code § 15-3-530. Algunos reclamos — especialmente contra una entidad de gobierno — tienen plazos más cortos, y la compensación laboral corre con su propio calendario, así que confirme su plazo específico con un abogado.' ),
                array( 'question' => '¿Puedo recuperar compensación si tuve parte de la culpa?', 'answer' => 'Sí. Carolina del Sur sigue una regla de negligencia comparativa modificada. Usted puede recuperar compensación siempre que haya tenido menos del 51% de la culpa, aunque su indemnización se reduce según su porcentaje. Las aseguradoras suelen inflar su culpa para pagar menos — nuestros abogados responden.' ),
                array( 'question' => '¿Qué compensación puedo recuperar en un caso de lesiones en Carolina del Sur?', 'answer' => 'Puede recuperar daños económicos (facturas médicas, atención futura, salarios perdidos y capacidad de ingreso perdida), daños no económicos (dolor y sufrimiento, angustia emocional y pérdida del disfrute de la vida) y, en casos de negligencia grave, daños punitivos. Cuando la parte culpable no tiene seguro suficiente, también puede ser posible acumular coberturas UM/UIM.' ),
                array( 'question' => '¿Qué tipos de casos maneja Roden Law en Carolina del Sur?', 'answer' => 'Roden Law maneja accidentes de auto, camiones y motocicleta, lesiones en el trabajo, caídas y propiedades inseguras, productos defectuosos y reclamos por muerte por negligencia en todo Carolina del Sur.' ),
                array( 'question' => '¿Cuánto cuesta un abogado de lesiones personales en Carolina del Sur?', 'answer' => 'Roden Law maneja los casos de lesiones personales con honorarios de contingencia. Usted no paga nada por adelantado y no paga honorarios legales a menos que ganemos. Nuestro honorario es un porcentaje del acuerdo o veredicto que recuperamos para usted.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'south-carolina-personal-injury-lawyer EN page or es root missing.' ); }

/* 2. /es/south-carolina-workers-compensation-lawyer/ */
$en = $roden_es_find_root_page( 'south-carolina-workers-compensation-lawyer' );
if ( $en && $es_root ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Compensación Laboral en Carolina del Sur',
        'parent'  => $es_root,
        'excerpt' => 'Abogados de compensación laboral de Roden Law en Carolina del Sur: le ayudamos a obtener atención médica y beneficios, y peleamos los reclamos negados en todo el estado. Consulta gratuita en español.',
        'content' => <<<'HTML'
<p>Una lesión en el trabajo puede poner en riesgo su salud, su sueldo y su familia al mismo tiempo. El sistema de compensación laboral de Carolina del Sur debe proporcionarle atención médica y beneficios salariales sin importar de quién fue la culpa — pero los empleadores y sus aseguradoras no siempre lo hacen fácil. Los abogados de compensación laboral de Roden Law ayudan a trabajadores lesionados a obtener los beneficios que se les deben y pelean cuando un reclamo es negado o recortado. Servimos a trabajadores en todo el estado desde nuestras oficinas en Charleston, North Charleston, Columbia y Myrtle Beach, con honorarios de contingencia: sin honorarios a menos que ganemos.</p>

<h2>¿Qué beneficios ofrece la compensación laboral de Carolina del Sur?</h2>
<p>Bajo la Ley de Compensación Laboral de Carolina del Sur (S.C. Code Título 42), un trabajador lesionado generalmente tiene derecho a:</p>
<ul>
<li><strong>Tratamiento médico</strong> para la lesión laboral, cubierto por la aseguradora del empleador.</li>
<li><strong>Beneficios de reemplazo salarial</strong> — una porción de su salario semanal promedio mientras no puede trabajar.</li>
<li><strong>Beneficios por incapacidad o deterioro permanente</strong> si la lesión deja efectos duraderos.</li>
<li><strong>Beneficios vocacionales y relacionados</strong> en algunos casos, según la lesión.</li>
</ul>
<p>Importante: la compensación laboral es un sistema sin culpa. Generalmente usted no tiene que demostrar que su empleador hizo algo mal para calificar.</p>

<h2>¿Qué plazos aplican a un reclamo de compensación laboral en Carolina del Sur?</h2>
<p>La compensación laboral corre con su propio calendario, separado del plazo de 3 años de las demandas ordinarias por lesiones. Usted debe <strong>reportar su lesión a su empleador dentro de 90 días</strong> del accidente (S.C. Code &sect; 42-15-20) — por escrito siempre que sea posible — y debe <strong>presentar su reclamo ante la Comisión de Compensación Laboral de Carolina del Sur dentro de 2 años</strong> de la lesión (S.C. Code &sect; 42-15-40). Perder cualquiera de los dos plazos puede costarle sus beneficios: reporte la lesión de inmediato y no espere para presentar el reclamo.</p>

<h2>¿Su estatus migratorio afecta su derecho a beneficios?</h2>
<p>No. Su estatus migratorio no le impide reclamar los beneficios de compensación laboral que la ley le otorga por una lesión en el trabajo en Carolina del Sur. Su consulta con nosotros es siempre confidencial, y atendemos en español. No deje que el miedo le cueste la atención médica y el salario que le corresponden.</p>

<h2>¿Qué hago si mi reclamo de compensación laboral es negado?</h2>
<p>Las negaciones son comunes: las aseguradoras pueden disputar si la lesión está relacionada con el trabajo, si es tan seria como usted dice, o si la reportó a tiempo. Una negación no es el final. Usted tiene derecho a solicitar una audiencia ante la Comisión de Compensación Laboral de Carolina del Sur y a apelar. Un abogado puede reunir la evidencia médica, cumplir los plazos y presentar su caso en la audiencia.</p>

<h2>¿Puedo demandar a un tercero además de mi reclamo de compensación laboral?</h2>
<p>La compensación laboral normalmente le impide demandar a su propio empleador, pero si alguien <em>distinto</em> a su empleador causó su lesión — por ejemplo, un conductor negligente, una máquina defectuosa o un contratista externo — usted puede tener un <strong>reclamo separado por lesiones personales contra ese tercero</strong>. Ese reclamo puede recuperar daños que la compensación laboral no cubre, como la totalidad de los salarios perdidos y el dolor y sufrimiento. Vea nuestros <a href="/es/south-carolina-personal-injury-lawyer/">abogados de lesiones personales en Carolina del Sur</a>.</p>

<h2>Hable gratis con un abogado de compensación laboral en Carolina del Sur</h2>
<p>Si se lesionó en el trabajo en cualquier parte de Carolina del Sur, Roden Law le explicará sus derechos, le ayudará a cumplir los plazos y peleará una negación si llega. Atendemos casos en <a href="/es/workers-compensation-lawyers/charleston-sc/">Charleston</a>, <a href="/es/workers-compensation-lawyers/columbia-sc/">Columbia</a> y <a href="/es/workers-compensation-lawyers/myrtle-beach-sc/">Myrtle Beach</a>, entre otras ciudades. Conozca nuestra <a href="/es/practice-areas/workers-compensation-lawyers/">práctica de compensación laboral</a> o <a href="/es/contact/">contáctenos hoy</a> — la consulta es gratuita y no hay honorarios a menos que ganemos.</p>
HTML,
        'meta'    => array(
            '_wp_page_template'        => 'templates/template-pillar-sc-statewide.php',
            '_roden_pillar_practice'   => 'Compensación Laboral',
            '_roden_pillar_practice_l' => 'una lesión en el trabajo',
            '_roden_meta_description'  => '¿Lesionado en el trabajo en Carolina del Sur? Le ayudamos a obtener atención médica y beneficios de compensación laboral. Hablamos español. Consulta gratuita.',
            '_roden_key_takeaways'     => 'Si usted se lesionó en el trabajo en Carolina del Sur, el sistema de compensación laboral — regido por la Ley de Compensación Laboral de Carolina del Sur (S.C. Code Título 42) — generalmente le da derecho a tratamiento médico y beneficios de reemplazo salarial sin importar de quién fue la culpa. Debe reportar su lesión a su empleador dentro de 90 días (S.C. Code § 42-15-20) y presentar su reclamo ante la Comisión de Compensación Laboral dentro de 2 años de la lesión (S.C. Code § 42-15-40). Su estatus migratorio no le impide reclamar estos beneficios, y su consulta es confidencial. Si su reclamo es negado o sus beneficios son cortados, tiene derecho a apelar. Roden Law tiene 4 oficinas en Carolina del Sur — Charleston, North Charleston, Columbia y Myrtle Beach — y representa a trabajadores lesionados en todo el estado con honorarios de contingencia: no paga nada a menos que ganemos.',
            '_roden_faqs'              => array(
                array( 'question' => '¿Qué beneficios puedo obtener de la compensación laboral de Carolina del Sur?', 'answer' => 'Bajo la Ley de Compensación Laboral de Carolina del Sur (S.C. Code Título 42), un trabajador lesionado generalmente tiene derecho a tratamiento médico cubierto, una porción de los salarios perdidos mientras no puede trabajar, y compensación por deterioro permanente. Es un sistema sin culpa: normalmente no tiene que demostrar que su empleador hizo algo mal.' ),
                array( 'question' => '¿Cuánto tiempo tengo para presentar un reclamo de compensación laboral en Carolina del Sur?', 'answer' => 'La compensación laboral tiene sus propios plazos. Debe reportar su lesión a su empleador dentro de 90 días (S.C. Code § 42-15-20) — por escrito cuando sea posible — y presentar su reclamo ante la Comisión de Compensación Laboral de Carolina del Sur dentro de 2 años de la lesión (S.C. Code § 42-15-40). Confirme sus plazos exactos con un abogado lo antes posible.' ),
                array( 'question' => '¿Puedo reclamar compensación laboral sin importar mi estatus migratorio?', 'answer' => 'Su estatus migratorio no le impide reclamar los beneficios de compensación laboral por una lesión en el trabajo en Carolina del Sur. Su consulta con Roden Law es siempre confidencial y atendemos en español.' ),
                array( 'question' => '¿Qué hago si mi reclamo de compensación laboral es negado?', 'answer' => 'Una negación no es el final. Usted puede solicitar una audiencia ante la Comisión de Compensación Laboral de Carolina del Sur y apelar. Un abogado de compensación laboral puede reunir la evidencia médica, cumplir los plazos y presentar su caso en la audiencia.' ),
                array( 'question' => '¿Puedo demandar a alguien más aparte de mi empleador por una lesión laboral?', 'answer' => 'La compensación laboral normalmente impide demandar a su propio empleador, pero si alguien distinto — como un conductor negligente, una máquina defectuosa o un contratista externo — causó su lesión, puede tener un reclamo separado por lesiones personales que recupera daños que la compensación laboral no cubre, como la totalidad de los salarios perdidos y el dolor y sufrimiento.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'south-carolina-workers-compensation-lawyer EN page or es root missing.' ); }

WP_CLI::log( '═══ BATCH 23 DONE ═══' );
