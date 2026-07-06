<?php
/**
 * ES Seeder — Batch 25: Resources (plazos y reglas legales), part 1 of 2.
 * Resources: south-carolina-statute-of-limitations, south-carolina-comparative-negligence.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-25-res-deadlines.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 25 — RESOURCES: DEADLINES ═══' );

/* 1. south-carolina-statute-of-limitations */
$en = get_page_by_path( 'south-carolina-statute-of-limitations', OBJECT, 'resource' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Plazo Legal para Demandar en Carolina del Sur (Statute of Limitations)',
        'excerpt' => 'En Carolina del Sur generalmente tiene 3 años para presentar una demanda por lesiones personales (S.C. Code § 15-3-530). Algunos plazos son más cortos.',
        'content' => <<<'HTML'
<p>En Carolina del Sur, usted generalmente tiene <strong>3 años desde la fecha de su lesión</strong> para presentar una demanda por lesiones personales, bajo el <strong>S.C. Code &sect; 15-3-530</strong>. Este plazo de 3 años cubre la mayoría de los casos: accidentes de auto y camión, motocicleta, peatones, caídas y la mayoría de los reclamos por negligencia. Pero hay excepciones importantes: los reclamos contra entidades del gobierno tienen un plazo más corto, la negligencia médica se rige por reglas propias, y el reloj puede pausarse cuando la víctima es un menor de edad. Si presenta su demanda después del plazo, el tribunal casi siempre la desestimará — sin importar qué tan fuerte sea su caso.</p>
<p>Si no sabe cuánto tiempo le queda, no adivine: un abogado de Roden Law se lo dirá gratis. Trabajamos con honorarios de contingencia — no paga nada por adelantado y no hay honorarios a menos que ganemos.</p>
<h2>¿Cuánto tiempo tengo para demandar en Carolina del Sur?</h2>
<p>Para la mayoría de los reclamos, el plazo es de <strong>3 años desde la fecha de la lesión</strong> (S.C. Code &sect; 15-3-530): accidentes de auto, camiones y vehículos comerciales, motocicletas, peatones y bicicletas, caídas y responsabilidad de locales, y negligencia en general. Tres años parecen mucho tiempo, pero no lo son: la evidencia desaparece, los videos de vigilancia se borran y los testigos se mudan u olvidan. La aseguradora construye su defensa desde el primer día.</p>
<h2>Plazos por tipo de reclamo</h2>
<table>
<tr><th>Tipo de reclamo</th><th>Plazo en Carolina del Sur</th></tr>
<tr><td>Accidente de auto / camión / motocicleta</td><td>3 años desde el choque (S.C. Code &sect; 15-3-530)</td></tr>
<tr><td>Caídas / responsabilidad de locales</td><td>3 años desde la lesión</td></tr>
<tr><td>Negligencia médica</td><td>3 años desde el descubrimiento, con tope de reposo de 6 años</td></tr>
<tr><td>Muerte por negligencia</td><td>3 años, presentada por el representante personal del patrimonio</td></tr>
<tr><td>Reclamo contra una entidad del gobierno</td><td>2 años bajo la Ley de Reclamos por Agravios de SC (3 años si se presenta un "verified claim")</td></tr>
</table>
<p>El plazo suele cambiar según <em>a quién demanda</em>, no según el tipo de vehículo. Si una ciudad, un condado, el estado o un hospital público puede ser responsable, trate el plazo como mucho más corto y llame a un abogado de inmediato.</p>
<h2>¿Cuándo empieza a correr el reloj? La regla del descubrimiento</h2>
<p>Normalmente, el reloj empieza el día de la lesión. Pero Carolina del Sur reconoce la <strong>regla del descubrimiento</strong>: para ciertas lesiones que no son evidentes de inmediato, el plazo de 3 años puede empezar cuando usted supo — o razonablemente debió saber — que fue lesionado y que la conducta de otra persona pudo causarlo. Las aseguradoras disputan esta regla con frecuencia; no asuma que extiende su plazo sin que un abogado lo confirme.</p>
<h2>¿Y la negligencia médica?</h2>
<p>La negligencia médica tiene sus propias reglas bajo el <strong>S.C. Code &sect; 15-3-545</strong>: debe presentarse dentro de <strong>3 años desde que descubrió (o debió descubrir) la lesión</strong>, pero nunca después del <strong>tope de reposo de 6 años</strong> contado desde el acto negligente. Si un objeto extraño quedó dentro del cuerpo, el reclamo corre <strong>2 años desde el descubrimiento</strong> (y nunca menos de 3 años desde que quedó el objeto). Además, Carolina del Sur exige un aviso previo de intención de demandar y una declaración jurada de un experto bajo el S.C. Code &sect; 15-79-125.</p>
<h2>Reclamos contra el gobierno</h2>
<p>Los reclamos contra entidades públicas caen bajo la <strong>Ley de Reclamos por Agravios de Carolina del Sur</strong> (S.C. Code &sect; 15-78-10 y siguientes) y tienen un plazo de solo <strong>2 años</strong>. Puede extenderse a <strong>3 años</strong> si primero presenta un "verified claim" ante la agencia responsable dentro de 1 año de la pérdida. Ese trámite es opcional, pero compra el año adicional e inicia el proceso de negociación.</p>
<h2>Excepciones que pausan el plazo</h2>
<p>El plazo generalmente se pausa ("tolling") cuando la víctima es un <strong>menor de edad</strong>, y la regla del descubrimiento puede retrasar el inicio del reloj. En casos de <strong>muerte por negligencia</strong>, el reclamo debe presentarlo el <strong>representante personal</strong> del patrimonio (S.C. Code &sect; 15-51-20) y el plazo corre desde la fecha del fallecimiento. Estas excepciones son estrechas y muy disputadas — actúe siempre como si el plazo estándar estuviera corriendo.</p>
<h2>Hable con un abogado antes de que venza su plazo</h2>
<p>Si usted o un ser querido resultó lesionado en Carolina del Sur, averigüe hoy exactamente cuánto tiempo tiene. La consulta es gratuita y en español. <a href="/es/contact/">Contáctenos</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Vea también cómo funciona la <a href="/es/resources/south-carolina-comparative-negligence/">regla de negligencia comparativa de Carolina del Sur</a> y nuestra página de <a href="/es/practice-areas/car-accident-lawyers/">abogados de accidentes de auto</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'En Carolina del Sur generalmente tiene 3 años para demandar por lesiones personales (S.C. Code § 15-3-530). Conozca las excepciones. Consulta gratis en español.',
            '_roden_key_takeaways'    => 'En Carolina del Sur, usted generalmente tiene 3 años desde la fecha de la lesión para presentar una demanda por lesiones personales bajo el S.C. Code § 15-3-530. Algunos reclamos tienen plazos distintos: los reclamos contra entidades del gobierno bajo la Ley de Reclamos por Agravios de Carolina del Sur tienen una ventana más corta (2 años), y la negligencia médica corre 3 años desde el descubrimiento pero con un tope de reposo de 6 años. El reloj puede empezar más tarde bajo la regla del descubrimiento y puede pausarse para menores lesionados. Si deja pasar su plazo, casi con certeza pierde el derecho a recuperar cualquier compensación — por eso es crítico hablar con un abogado cuanto antes.',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto tiempo tengo para presentar un reclamo por lesiones en Carolina del Sur?', 'answer' => 'Generalmente tiene 3 años desde la fecha de su lesión para presentar una demanda por lesiones personales, bajo el S.C. Code § 15-3-530. Esto cubre la mayoría de los accidentes de auto, camión, motocicleta, peatones y caídas. Algunos reclamos — especialmente contra entidades del gobierno — tienen plazos más cortos, así que confirme su plazo con un abogado cuanto antes.' ),
                array( 'question' => '¿Qué pasa si dejo pasar el plazo legal en Carolina del Sur?', 'answer' => 'Si presenta su demanda después del plazo, el tribunal casi siempre la desestimará, sin importar qué tan fuerte sea. Normalmente pierde el derecho a recuperar cualquier compensación. Por eso es crítico actuar mucho antes del vencimiento y no esperar hasta el final.' ),
                array( 'question' => '¿Es diferente el plazo para negligencia médica en Carolina del Sur?', 'answer' => 'Sí. Un reclamo por negligencia médica generalmente debe presentarse dentro de 3 años desde que descubrió, o debió descubrir, la lesión, pero nunca después del tope de reposo de 6 años contado desde el acto negligente (S.C. Code § 15-3-545). Como estas reglas interactúan, es fácil calcular mal el plazo — haga revisar su caso pronto si sospecha un error médico.' ),
                array( 'question' => '¿Hay un plazo más corto para demandar al gobierno en Carolina del Sur?', 'answer' => 'Sí. Los reclamos contra una ciudad, un condado, el estado o un hospital público caen bajo la Ley de Reclamos por Agravios de Carolina del Sur (S.C. Code § 15-78-10 y siguientes) y generalmente deben presentarse dentro de 2 años. Presentar un "verified claim" opcional ante la agencia (dentro de 1 año de la pérdida) puede extender el plazo a 3 años.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN resource south-carolina-statute-of-limitations not found.' ); }

/* 2. south-carolina-comparative-negligence */
$en = get_page_by_path( 'south-carolina-comparative-negligence', OBJECT, 'resource' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Negligencia Comparativa en Carolina del Sur: La Regla del 51% Explicada',
        'excerpt' => 'Carolina del Sur aplica negligencia comparativa modificada con barrera del 51%: puede recuperar si su culpa es menor al 51%, pero su compensación se reduce según su porcentaje.',
        'content' => <<<'HTML'
<p>Carolina del Sur es un estado de <strong>negligencia comparativa modificada</strong> con una <strong>barrera del 51%</strong>. En términos simples: usted todavía puede recuperar dinero por sus lesiones mientras su culpa sea <strong>menor al 51%</strong> — es decir, 50% o menos — pero lo que recupere se <strong>reduce según su propio porcentaje de culpa</strong>. Si le asignan 51% o más de la culpa, no recupera nada. Si su caso vale $300,000 y usted tiene 20% de culpa, recupera $240,000; con 51% de culpa, recupera $0.</p>
<p>Esta sola regla define el valor de casi todo reclamo por lesiones en Carolina del Sur, porque la aseguradora del conductor culpable luchará por asignarle a usted la mayor culpa posible. Roden Law trabaja con honorarios de contingencia: sin costo por adelantado y sin honorarios a menos que ganemos.</p>
<h2>¿Es Carolina del Sur un estado de negligencia comparativa?</h2>
<p>Sí. Carolina del Sur sigue la <strong>negligencia comparativa modificada</strong>, adoptada por la Corte Suprema de Carolina del Sur en <strong>Nelson v. Concrete Supply Co.</strong>, 303 S.C. 243, 399 S.E.2d 783 (1991), que reemplazó la antigua y más dura regla de "negligencia contributiva" que bloqueaba a cualquier demandante con apenas 1% de culpa. La regla es <strong>jurisprudencia (common law), no un estatuto</strong>, y aplica a reclamos por negligencia surgidos a partir del 1 de julio de 1991. Cuando hay más de un demandado culpable, su porcentaje de culpa se compara contra la culpa <em>combinada</em> de ellos.</p>
<h2>¿Qué es la barrera del 51%?</h2>
<p>Es el corte que decide si usted puede recuperar algo:</p>
<ul>
<li>Con <strong>50% o menos de culpa</strong>, puede recuperar — con la reducción por su porcentaje.</li>
<li>Con <strong>51% o más de culpa</strong>, queda bloqueado y no recupera nada.</li>
</ul>
<p>Un demandante con exactamente 50% de culpa todavía recupera la mitad de sus daños; uno que llega al 51% recupera cero. Esa diferencia de un punto porcentual puede valer cientos de miles de dólares — exactamente por eso la asignación de culpa se pelea tanto.</p>
<h2>Ejemplos con números</h2>
<table>
<tr><th>Valor total del caso</th><th>Su porcentaje de culpa</th><th>Lo que recupera</th></tr>
<tr><td>$300,000</td><td>0% (la otra parte es totalmente culpable)</td><td>$300,000</td></tr>
<tr><td>$300,000</td><td>20%</td><td>$240,000</td></tr>
<tr><td>$300,000</td><td>50%</td><td>$150,000</td></tr>
<tr><td>$300,000</td><td>51% o más</td><td>$0 (bloqueado)</td></tr>
</table>
<p>Con culpa baja, la reducción es modesta. Al 50%, todavía recupera la mitad. Pero al 51%, lo pierde todo — no existe recuperación parcial más allá de la barrera.</p>
<h2>¿Puedo recuperar si fui parcialmente culpable?</h2>
<p>Sí, mientras su culpa quede por debajo del 51%. Muchas personas lesionadas asumen erróneamente que por haber cometido un error — iban un poco rápido, se distrajeron un momento, no llevaban el cinturón — ya no pueden reclamar. Así no funciona la ley de Carolina del Sur: puede ser parcialmente responsable y aún ganar una compensación significativa. No deje que un ajustador le convenza de abandonar un reclamo válido exagerando su papel en el choque.</p>
<h2>Cómo las aseguradoras usan la culpa comparativa en su contra</h2>
<p>Cada punto porcentual de culpa que le transfieren a usted reduce lo que la aseguradora debe pagar — y empujarlo al 51% borra el reclamo por completo. Tácticas comunes: pedirle una <strong>declaración grabada</strong> temprana para usar sus palabras en su contra, argumentar que usted iba <strong>distraído o con exceso de velocidad</strong> con poca evidencia, señalar el <strong>cinturón o el casco</strong> para inflar su parte del daño, y hacer una <strong>oferta rápida y baja</strong> antes de que entienda cómo pueden argumentar la culpa. Un abogado responde con evidencia — el informe policial, la reconstrucción del accidente, testigos, datos del vehículo y registros médicos — para mantener su porcentaje tan bajo como los hechos lo permitan.</p>
<h2>¿Cómo se divide la culpa entre varios demandados?</h2>
<p>Bajo el <strong>S.C. Code &sect; 15-38-15</strong>, un demandado con <strong>menos del 50%</strong> de la culpa generalmente responde solo por su propia parte de los daños, mientras que uno con <strong>50% o más</strong> puede responder por el total. Para usted, varios demandados pueden significar varias pólizas de seguro disponibles — una razón más para identificar temprano a todas las partes responsables.</p>
<h2>Proteja su compensación</h2>
<p>Si la otra parte insinúa que el accidente fue parcialmente su culpa, no acepte su versión ni una oferta baja construida sobre culpa inflada. La consulta es gratuita y en español: <a href="/es/contact/">contáctenos</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Vea también el <a href="/es/resources/south-carolina-statute-of-limitations/">plazo legal para demandar en Carolina del Sur</a> y nuestra página de <a href="/es/practice-areas/truck-accident-lawyers/">abogados de accidentes de camiones</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Carolina del Sur aplica negligencia comparativa con barrera del 51%: recupera si su culpa es menor al 51%, reducido por su porcentaje. Consulta gratis en español.',
            '_roden_key_takeaways'    => 'Carolina del Sur sigue la negligencia comparativa modificada con una barrera del 51%. Usted puede recuperar compensación mientras tenga menos del 51% de la culpa por sus propias lesiones, pero su compensación se reduce según su porcentaje de culpa. Con 51% o más de culpa, no recupera nada. Por ejemplo, en un caso de $300,000, tener 20% de culpa le deja $240,000, mientras que 51% de culpa le deja $0. Las aseguradoras intentan rutinariamente inflar su porcentaje de culpa para recortar o eliminar su pago, por lo que la asignación de culpa tiene un impacto directo en dólares sobre su caso.',
            '_roden_faqs'             => array(
                array( 'question' => '¿Es Carolina del Sur un estado de negligencia comparativa?', 'answer' => 'Sí. Carolina del Sur sigue la negligencia comparativa modificada con barrera del 51%, adoptada en Nelson v. Concrete Supply Co. (1991). Puede recuperar compensación mientras su culpa sea menor al 51%, pero su compensación se reduce según su porcentaje de culpa. Con 51% o más, no recupera nada.' ),
                array( 'question' => '¿Qué es la barrera del 51% en Carolina del Sur?', 'answer' => 'Es el corte para poder recuperar. Con 50% o menos de culpa, puede recuperar daños, reducidos por su porcentaje. Con 51% o más, queda bloqueado de recuperar cualquier cosa. Esa línea de un punto porcentual puede valer cientos de miles de dólares, por eso la culpa se disputa tanto.' ),
                array( 'question' => '¿Puedo recuperar si el accidente fue parcialmente mi culpa en Carolina del Sur?', 'answer' => 'Sí, mientras su parte de la culpa sea menor al 51%. Muchas personas asumen erróneamente que cualquier error anula su reclamo, pero Carolina del Sur solo reduce su compensación en proporción a su culpa. Por ejemplo, en un caso de $200,000 donde usted tiene 25% de culpa, recuperaría $150,000.' ),
                array( 'question' => '¿Cómo usan las aseguradoras la culpa comparativa en mi contra?', 'answer' => 'Intentan inflar su porcentaje de culpa porque cada punto reduce lo que deben pagar, y empujarlo al 51% borra el reclamo por completo. Piden declaraciones grabadas tempranas, argumentan que usted iba distraído o con exceso de velocidad, y hacen ofertas rápidas y bajas. Un abogado responde con evidencia para mantener su porcentaje tan bajo como los hechos lo permitan.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN resource south-carolina-comparative-negligence not found.' ); }

WP_CLI::log( '═══ BATCH 25 DONE ═══' );
