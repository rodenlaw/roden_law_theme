<?php
/**
 * ES Seeder — Batch 24: SC statewide pillars (serious).
 * /es/south-carolina-motorcycle-accident-lawyer/ + /es/south-carolina-wrongful-death-lawyer/
 * Translated from inc/seed-sc-pillar-motorcycle.php + inc/seed-sc-pillar-wrongful-death.php.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-24-sc-statewide-serious.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 24 — SC STATEWIDE PILLARS: SERIOUS ═══' );

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

/* 1. /es/south-carolina-motorcycle-accident-lawyer/ */
$en = $roden_es_find_root_page( 'south-carolina-motorcycle-accident-lawyer' );
if ( $en && $es_root ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Accidentes de Motocicleta en Carolina del Sur',
        'parent'  => $es_root,
        'excerpt' => 'Abogados de accidentes de motocicleta de Roden Law en Carolina del Sur: combatimos el prejuicio de las aseguradoras contra los motociclistas en todo el estado. Consulta gratuita — sin honorarios a menos que ganemos.',
        'content' => <<<'HTML'
<p>Los motociclistas que resultan heridos en un choque en Carolina del Sur enfrentan dos peleas a la vez: recuperarse de lesiones graves y superar el prejuicio de que el motociclista siempre tiene la culpa. Los abogados de accidentes de motocicleta de Roden Law saben cómo contrarrestar ese prejuicio, construir la evidencia y enfrentar a la aseguradora del conductor culpable. Servimos a motociclistas lesionados en todo el estado desde nuestras oficinas en Charleston, North Charleston, Columbia y Myrtle Beach, con honorarios de contingencia: no paga nada a menos que ganemos.</p>

<h2>¿Por qué las aseguradoras discriminan a los motociclistas en Carolina del Sur?</h2>
<p>Como la motocicleta casi no ofrece protección física, los motociclistas sufren lesiones catastróficas en choques que a un conductor de auto apenas lo sacudirían. Aun así, las aseguradoras se apoyan en el estereotipo de que los motociclistas son imprudentes o van con exceso de velocidad, con la esperanza de trasladar la culpa y pagar menos. Un abogado contrarresta eso reconstruyendo el choque, asegurando testimonios y cualquier video disponible, y demostrando lo que realmente ocurrió — que casi siempre es que otro conductor no vio o no cedió el paso al motociclista.</p>

<h2>Causas comunes de accidentes de motocicleta en Carolina del Sur</h2>
<ul>
<li><strong>Colisiones en giros a la izquierda</strong> — un conductor cruza el camino del motociclista en una intersección.</li>
<li><strong>Cambios de carril inseguros</strong> — un conductor se mete sobre la motocicleta en un punto ciego.</li>
<li><strong>Seguir demasiado cerca</strong> — impactos por alcance que son devastadores para un motociclista.</li>
<li><strong>Conducción distraída o bajo la influencia</strong> — el conductor nunca ve la motocicleta.</li>
<li><strong>Peligros y defectos en la vía</strong> — baches, escombros o mal diseño de la carretera.</li>
</ul>
<p>Como la mayoría de estos choques los causa otro conductor, suelen involucrar a las mismas aseguradoras y tácticas de defensa que un <a href="/es/south-carolina-car-accident-lawyers/">accidente de auto en Carolina del Sur</a> — con el obstáculo adicional del prejuicio contra el motociclista.</p>

<h2>¿La ley del casco de Carolina del Sur afecta mi reclamo?</h2>
<p>Carolina del Sur solo exige el casco a <strong>motociclistas y pasajeros menores de 21 años</strong> (S.C. Code &sect; 56-5-3660); los mayores de 21 no están obligados por ley a usarlo. Que usted llevara o no casco no decide automáticamente su caso. Carolina del Sur no tiene un estatuto que resuelva directamente cómo el uso del casco afecta un reclamo por lesiones de motocicleta, así que las aseguradoras pueden intentar argumentar que las decisiones del motociclista agravaron las lesiones bajo la regla de negligencia comparativa — un argumento que nuestros abogados están preparados para contrarrestar.</p>

<h2>¿Cuánto tiempo tengo para presentar mi reclamo por accidente de motocicleta?</h2>
<p>En la mayoría de los casos usted tiene <strong>3 años desde la fecha del choque</strong> para presentar una demanda por lesiones personales, bajo <strong>S.C. Code &sect; 15-3-530</strong>. Pueden aplicar plazos más cortos cuando una entidad de gobierno está involucrada. No espere: la evidencia desaparece rápido.</p>

<h2>¿Qué pasa si yo tuve parte de la culpa del choque?</h2>
<p>Carolina del Sur usa una regla de <strong>negligencia comparativa modificada</strong>: usted puede recuperar compensación siempre que haya tenido menos del 51% de la culpa, con su indemnización reducida según su porcentaje. Como las aseguradoras suelen intentar cargarle culpa extra al motociclista, esta regla es un campo de batalla frecuente. Y cuando el conductor culpable no tiene seguro suficiente, pregunte por la acumulación de coberturas UM/UIM.</p>

<h2>Hable gratis con un abogado de accidentes de motocicleta en Carolina del Sur</h2>
<p>Roden Law representa a víctimas de accidentes de motocicleta en todo Carolina del Sur, incluyendo <a href="/es/motorcycle-accident-lawyers/charleston-sc/">Charleston</a>, <a href="/es/motorcycle-accident-lawyers/columbia-sc/">Columbia</a> y <a href="/es/motorcycle-accident-lawyers/myrtle-beach-sc/">Myrtle Beach</a>. Un abogado revisará su caso sin costo, le explicará su plazo y empezará a construir la evidencia para superar el prejuicio de las aseguradoras. No hay honorarios a menos que ganemos. Conozca nuestra <a href="/es/practice-areas/motorcycle-accident-lawyers/">práctica de accidentes de motocicleta</a> o <a href="/es/contact/">contáctenos hoy</a>.</p>
HTML,
        'meta'    => array(
            '_wp_page_template'        => 'templates/template-pillar-sc-statewide.php',
            '_roden_pillar_practice'   => 'Accidente de Motocicleta',
            '_roden_pillar_practice_l' => 'un accidente de motocicleta',
            '_roden_meta_description'  => '¿Lesionado en un accidente de motocicleta en Carolina del Sur? Combatimos el prejuicio de las aseguradoras contra motociclistas. Consulta gratuita en español.',
            '_roden_key_takeaways'     => 'Si usted resultó lesionado en un accidente de motocicleta en cualquier parte de Carolina del Sur, generalmente tiene 3 años desde el choque para presentar su demanda bajo S.C. Code § 15-3-530, y todavía puede recuperar compensación siempre que haya tenido menos del 51% de la culpa. Los motociclistas enfrentan una desventaja incorporada: las aseguradoras y los jurados suelen asumir que el motociclista fue imprudente, incluso cuando el otro conductor causó el choque. Carolina del Sur solo exige el casco a motociclistas y pasajeros menores de 21 años, y las aseguradoras pueden intentar usar las decisiones del motociclista en su contra. Roden Law tiene 4 oficinas en Carolina del Sur — Charleston, North Charleston, Columbia y Myrtle Beach — y representa a víctimas de choques de motocicleta en todo el estado con honorarios de contingencia: no paga nada a menos que ganemos.',
            '_roden_faqs'              => array(
                array( 'question' => '¿Cuánto tiempo tengo para presentar un reclamo por accidente de motocicleta en Carolina del Sur?', 'answer' => 'En la mayoría de los casos, 3 años desde la fecha del choque, bajo S.C. Code § 15-3-530. Pueden aplicar plazos más cortos cuando una entidad de gobierno está involucrada, así que confirme su plazo específico con un abogado cuanto antes.' ),
                array( 'question' => '¿No haber usado casco perjudica mi reclamo por accidente de motocicleta?', 'answer' => 'Carolina del Sur solo exige el casco a motociclistas y pasajeros menores de 21 años, así que los mayores de 21 no infringen la ley al no usarlo. El uso del casco no decide automáticamente su caso, pero las aseguradoras pueden argumentar que las decisiones del motociclista agravaron las lesiones bajo la regla de negligencia comparativa, así que conviene que un abogado evalúe cómo aplica a su situación.' ),
                array( 'question' => '¿Por qué las aseguradoras tratan diferente los reclamos de motocicleta?', 'answer' => 'Las aseguradoras suelen apoyarse en el estereotipo de que los motociclistas son imprudentes o van con exceso de velocidad, buscando trasladar la culpa y pagar menos. Un abogado contrarresta eso reconstruyendo el choque y asegurando testigos y video para demostrar lo que realmente ocurrió — casi siempre que otro conductor no vio o no cedió el paso al motociclista.' ),
                array( 'question' => '¿Puedo recuperar compensación si tuve parte de la culpa del choque de motocicleta?', 'answer' => 'Sí. Bajo la regla de negligencia comparativa modificada de Carolina del Sur, usted puede recuperar compensación siempre que haya tenido menos del 51% de la culpa, aunque su indemnización se reduce según su porcentaje. Como las aseguradoras suelen inflar la culpa del motociclista, este es un punto de disputa frecuente.' ),
                array( 'question' => '¿Cuánto cuesta un abogado de accidentes de motocicleta en Carolina del Sur?', 'answer' => 'Roden Law maneja los casos de accidentes de motocicleta con honorarios de contingencia. Usted no paga nada por adelantado y no paga honorarios legales a menos que ganemos. Nuestro honorario es un porcentaje del acuerdo o veredicto que recuperamos para usted.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'south-carolina-motorcycle-accident-lawyer EN page or es root missing.' ); }

/* 2. /es/south-carolina-wrongful-death-lawyer/ */
$en = $roden_es_find_root_page( 'south-carolina-wrongful-death-lawyer' );
if ( $en && $es_root ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Muerte por Negligencia en Carolina del Sur',
        'parent'  => $es_root,
        'excerpt' => 'Abogados de muerte por negligencia de Roden Law en Carolina del Sur: ayudamos a las familias a buscar justicia y compensación en todo el estado. Consulta gratuita y compasiva, en español.',
        'content' => <<<'HTML'
<p>Perder a un ser querido por el descuido de otra persona es devastador, y ninguna demanda puede deshacerlo. Lo que sí puede hacer un reclamo por muerte por negligencia en Carolina del Sur es responsabilizar a la parte culpable y proveer para el futuro de la familia. Los abogados de muerte por negligencia de Roden Law guían a las familias por este proceso con compasión y determinación, desde nuestras oficinas en Charleston, North Charleston, Columbia y Myrtle Beach, sirviendo a todo el estado. Trabajamos con honorarios de contingencia: no hay honorarios a menos que ganemos.</p>

<h2>¿Quién puede presentar un reclamo por muerte por negligencia en Carolina del Sur?</h2>
<p>En Carolina del Sur, un reclamo por muerte por negligencia debe presentarlo el <strong>representante personal del patrimonio</strong> de la persona fallecida — no los familiares individualmente — bajo <strong>S.C. Code &sect; 15-51-10</strong> y siguientes. La recuperación, sin embargo, es para el beneficio de la familia sobreviviente. Si el patrimonio todavía no tiene representante personal, el tribunal puede nombrar uno. Un abogado puede ayudar a la familia a dar ese primer paso.</p>

<h2>¿Quiénes se benefician de la recuperación en Carolina del Sur?</h2>
<p>La ley de Carolina del Sur (S.C. Code &sect; 15-51-20) dirige la recuperación a los beneficiarios legales de la persona fallecida en un orden fijo: <strong>primero el cónyuge y los hijos sobrevivientes; si no hay cónyuge ni hijos, los padres; y si ninguno de ellos sobrevive, los herederos</strong>. Cuando hay cónyuge e hijos, la recuperación se divide como pasaría el patrimonio bajo las reglas de sucesión de Carolina del Sur: el cónyuge recibe la mitad y los hijos comparten la otra mitad. Estos fondos generalmente pasan directamente a la familia y no se usan para pagar a los acreedores de la persona fallecida.</p>

<h2>¿Qué compensación está disponible en un caso de muerte por negligencia?</h2>
<p>Según los hechos, la recuperación puede incluir la pérdida del sostén económico del ser querido, la pérdida de su compañía, guía y presencia, el dolor y la angustia mental de la familia, y los gastos funerarios y de entierro. Carolina del Sur también reconoce una <strong>acción de supervivencia</strong> separada, presentada por el patrimonio, para recuperar por el dolor consciente, el sufrimiento y los gastos médicos de la persona fallecida entre la lesión y la muerte. Los dos reclamos suelen presentarse juntos.</p>

<h2>¿Cuánto tiempo tenemos para presentar el reclamo?</h2>
<p>Un reclamo por muerte por negligencia en Carolina del Sur generalmente debe presentarse dentro de <strong>3 años desde la fecha del fallecimiento</strong>, conforme a <strong>S.C. Code &sect; 15-3-530</strong>. Cuando una entidad de gobierno está involucrada, puede aplicar un plazo más corto bajo la Tort Claims Act.</p>

<h2>¿Qué tipos de accidentes llevan a reclamos por muerte por negligencia?</h2>
<p>Roden Law presenta reclamos por muerte por negligencia derivados de <a href="/es/south-carolina-car-accident-lawyers/">accidentes de auto</a>, <a href="/es/south-carolina-truck-accident-lawyers/">accidentes de camiones</a>, <a href="/es/south-carolina-motorcycle-accident-lawyer/">choques de motocicleta</a>, negligencia médica, propiedades inseguras y productos defectuosos. Si la negligencia de otra parte causó la muerte de su ser querido, puede haber un reclamo — incluso si la causa no es obvia.</p>

<h2>Hable gratis con un abogado de muerte por negligencia en Carolina del Sur</h2>
<p>Si su familia perdió a alguien por la negligencia de otra persona en Carolina del Sur, Roden Law la escuchará, le explicará sus opciones y manejará el proceso legal para que usted pueda concentrarse en su familia. Un abogado revisará su caso sin costo, y no hay honorarios a menos que ganemos. Conozca nuestra <a href="/es/practice-areas/wrongful-death-lawyers/">práctica de muerte por negligencia</a> o <a href="/es/contact/">contáctenos hoy</a> para una consulta gratuita en español.</p>
HTML,
        'meta'    => array(
            '_wp_page_template'        => 'templates/template-pillar-sc-statewide.php',
            '_roden_pillar_practice'   => 'Muerte por Negligencia',
            '_roden_pillar_practice_l' => 'una muerte por negligencia',
            '_roden_meta_description'  => '¿Perdió a un ser querido por negligencia en Carolina del Sur? Ayudamos a las familias a buscar justicia y compensación en todo el estado. Consulta gratuita.',
            '_roden_key_takeaways'     => 'Un reclamo por muerte por negligencia en Carolina del Sur debe presentarlo el representante personal del patrimonio de la persona fallecida — no los familiares directamente — bajo S.C. Code § 15-51-10 y siguientes, y generalmente debe presentarse dentro de 3 años desde la fecha del fallecimiento conforme a S.C. Code § 15-3-530. La recuperación beneficia primero al cónyuge y los hijos sobrevivientes (y, en algunos casos, a los padres), e incluye la pérdida del sostén, la compañía y la guía del ser querido, además de los gastos funerarios; una acción de supervivencia separada puede recuperar por el dolor que la persona fallecida sufrió antes de morir. Roden Law tiene 4 oficinas en Carolina del Sur — Charleston, North Charleston, Columbia y Myrtle Beach — y maneja estos casos delicados en todo el estado con honorarios de contingencia: no paga nada a menos que ganemos.',
            '_roden_faqs'              => array(
                array( 'question' => '¿Quién puede presentar un reclamo por muerte por negligencia en Carolina del Sur?', 'answer' => 'En Carolina del Sur, el reclamo debe presentarlo el representante personal del patrimonio de la persona fallecida, no los familiares directamente, bajo S.C. Code § 15-51-10 y siguientes. La recuperación es para el beneficio de la familia sobreviviente. Si no hay representante personal, el tribunal puede nombrar uno.' ),
                array( 'question' => '¿Cuánto tiempo tenemos para presentar un reclamo por muerte por negligencia en Carolina del Sur?', 'answer' => 'Generalmente debe presentarse dentro de 3 años desde la fecha del fallecimiento, conforme a S.C. Code § 15-3-530. Puede aplicar un plazo más corto cuando una entidad de gobierno está involucrada, así que confirme su plazo específico con un abogado.' ),
                array( 'question' => '¿Qué compensación está disponible en un caso de muerte por negligencia en Carolina del Sur?', 'answer' => 'Según los hechos, la recuperación puede incluir la pérdida del sostén económico del ser querido, de su compañía y de su guía, el dolor y la angustia mental de la familia, y los gastos funerarios y de entierro. Una acción de supervivencia separada, presentada por el patrimonio, puede recuperar por el dolor y los gastos médicos de la persona fallecida antes de morir.' ),
                array( 'question' => '¿Cuál es la diferencia entre un reclamo por muerte por negligencia y una acción de supervivencia?', 'answer' => 'El reclamo por muerte por negligencia compensa a la familia sobreviviente por sus pérdidas, mientras que la acción de supervivencia compensa al patrimonio por lo que la persona fallecida sufrió — dolor consciente, sufrimiento y gastos médicos — entre la lesión y la muerte. Los dos suelen presentarse juntos.' ),
                array( 'question' => '¿Cuánto cuesta un abogado de muerte por negligencia en Carolina del Sur?', 'answer' => 'Roden Law maneja los casos de muerte por negligencia con honorarios de contingencia. La familia no paga nada por adelantado y no paga honorarios legales a menos que ganemos. Nuestro honorario es un porcentaje de la recuperación que obtenemos.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'south-carolina-wrongful-death-lawyer EN page or es root missing.' ); }

WP_CLI::log( '═══ BATCH 24 DONE ═══' );
