<?php
/**
 * ES Seeder — Batch 27: Resources (compensación laboral), part 1 of 2.
 * Resources: how-much-does-south-carolina-workers-comp-pay, south-carolina-workers-comp-claim-denied.
 * Annual figures ($1,189.94 max 2026; 72.5¢/mile as of 2026-01-01) kept verbatim + date-phrased.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-27-res-wc-a.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 27 — RESOURCES: WORKERS COMP A ═══' );

/* 5. how-much-does-south-carolina-workers-comp-pay */
$en = get_page_by_path( 'how-much-does-south-carolina-workers-comp-pay', OBJECT, 'resource' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => '¿Cuánto Paga la Compensación Laboral en Carolina del Sur?',
        'excerpt' => 'La compensación laboral de Carolina del Sur paga dos tercios de su salario semanal promedio, sujeto a un máximo anual y un mínimo de $75. Conozca las tasas, el período de espera y los beneficios.',
        'content' => <<<'HTML'
<p>La compensación laboral de Carolina del Sur le paga una parte de sus salarios perdidos más su atención médica autorizada cuando se lesiona en el trabajo. El beneficio central — la <strong>incapacidad total temporal (TTD)</strong> — paga <strong>dos tercios (66&frac23;%) de su salario semanal promedio (AWW)</strong> mientras la lesión le impide trabajar (S.C. Code &sect; 42-9-10(A)). Estos beneficios de reemplazo salarial <strong>no pagan impuestos</strong>.</p>
<p>Importante para los trabajadores inmigrantes: <strong>su estatus migratorio no le impide recibir beneficios de compensación laboral en Carolina del Sur</strong>. Si se lesionó trabajando, tiene derechos — y su consulta con nosotros es siempre confidencial y en español. Roden Law trabaja con honorarios de contingencia: sin costo por adelantado y sin honorarios a menos que ganemos. Nota: los máximos en dólares y la tarifa de millaje se <strong>actualizan cada año</strong>; confirme siempre la cifra que aplica a su fecha de lesión.</p>
<h2>¿Cuánto paga por semana?</h2>
<p>El beneficio semanal básico es el <strong>66&frac23;% de su salario semanal promedio</strong>, calculado a partir de sus ingresos (típicamente los cuatro trimestres anteriores a la lesión, según el &sect; 42-1-40), con un tope y un piso:</p>
<ul>
<li><strong>Máximo:</strong> se fija cada año según su fecha de lesión. <strong>Para lesiones ocurridas en 2026, el máximo es $1,189.94 por semana</strong> (para lesiones en 2025 fue $1,134.43). La cifra está atada al salario semanal promedio estatal y cambia cada año.</li>
<li><strong>Mínimo:</strong> <strong>$75 por semana</strong>, fijado por estatuto — salvo que su salario semanal promedio sea menor de $75, en cuyo caso recibe su salario completo.</li>
</ul>
<p>Un trabajador con un salario semanal promedio de $900 recibiría alrededor de $600 por semana (66&frac23;% de $900). Quien gana mucho queda limitado al máximo anual sin importar sus salarios.</p>
<h2>¿Hay un período de espera?</h2>
<p>Sí. Bajo el <strong>S.C. Code &sect; 42-9-200</strong>, no se pagan beneficios salariales por los <strong>primeros 7 días calendario</strong> de incapacidad. Pero si su incapacidad dura <strong>más de 14 días</strong>, se le paga <strong>retroactivamente desde el día uno</strong>. El período de espera aplica solo a los beneficios salariales: <strong>los beneficios médicos se pagan desde el primer día</strong>, sin espera.</p>
<h2>Tipos de beneficios por incapacidad</h2>
<ul>
<li><strong>Incapacidad total temporal (TTD):</strong> 66&frac23;% de su AWW mientras no puede trabajar en absoluto y sigue recuperándose.</li>
<li><strong>Incapacidad parcial temporal (TPD):</strong> si puede hacer algún trabajo pero gana menos que antes, recibe el <strong>66&frac23;% de la diferencia</strong> entre su AWW previo y lo que puede ganar ahora, bajo el &sect; 42-9-20. La TPD tiene un <strong>tope de 340 semanas</strong>.</li>
<li><strong>Incapacidad parcial permanente (PPD):</strong> se paga al alcanzar la mejoría médica máxima, según los valores por parte del cuerpo del &sect; 42-9-30 — vea nuestra <a href="/es/resources/south-carolina-workers-comp-body-part-values/">tabla de valores por parte del cuerpo</a>.</li>
<li><strong>Incapacidad total permanente (PTD):</strong> para las lesiones más graves.</li>
</ul>
<h2>¿Cuánto tiempo duran los beneficios?</h2>
<p>Los beneficios por incapacidad total generalmente tienen un <strong>tope de 500 semanas</strong> bajo el &sect; 42-9-10(B). Excepción crítica: la <strong>paraplejia, la cuadriplejia y el daño cerebral físico</strong> <strong>no tienen tope</strong> y pueden pagarse de por vida bajo el &sect; 42-9-10(C).</p>
<h2>¿Paga mis facturas médicas y el millaje?</h2>
<p>Sí. El empleador o su aseguradora debe pagar el <strong>tratamiento médico autorizado</strong> que tienda a reducir su incapacidad, bajo el &sect; 42-15-60. En Carolina del Sur, el empleador generalmente <strong>dirige su atención y elige al médico tratante</strong> — ver a un médico no autorizado por su cuenta puede significar que esas facturas no se cubran. También tiene derecho a <strong>reembolso de millaje</strong> por viajes a citas médicas autorizadas de <strong>más de 5 millas de ida</strong>; la tarifa se fija anualmente y, <strong>desde el 1 de enero de 2026, es de 72.5 centavos por milla</strong>. Lleve un registro de sus viajes médicos.</p>
<h2>Plazos para reportar y presentar</h2>
<p>La compensación laboral de Carolina del Sur es un sistema <strong>sin culpa</strong> — no tiene que probar que su empleador hizo algo mal — pero debe cumplir dos plazos: <strong>reportar la lesión a su empleador dentro de 90 días</strong> (&sect; 42-15-20) y <strong>presentar su reclamo dentro de 2 años</strong> (&sect; 42-15-40). Incumplir cualquiera puede eliminar sus beneficios por completo.</p>
<h2>Hable con un abogado de compensación laboral</h2>
<p>Cuánto reciba depende mucho de cómo se calcula su salario semanal promedio — un número que la aseguradora tiene todo el incentivo de mantener bajo. Un abogado de Roden Law puede verificar su tasa, asegurar cada beneficio y milla que le deben, y buscar una compensación mayor si su lesión es permanente. La revisión es gratuita y en español: <a href="/es/contact/">contáctenos</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Vea también <a href="/es/resources/south-carolina-workers-comp-claim-denied/">qué hacer si niegan su reclamo</a>, <a href="/es/resources/south-carolina-workers-comp-impairment-rating-mmi/">cómo funcionan el MMI y las calificaciones de deterioro</a> y nuestra página de <a href="/es/practice-areas/workers-compensation-lawyers/">abogados de compensación laboral</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'La compensación laboral de Carolina del Sur paga 66⅔% de su salario semanal promedio, con máximo anual y mínimo de $75. Su estatus migratorio no es obstáculo.',
            '_roden_key_takeaways'    => 'La compensación laboral de Carolina del Sur paga beneficios de incapacidad total temporal (TTD) al dos tercios (66⅔%) de su salario semanal promedio mientras no puede trabajar, sujeto a un máximo y un mínimo anuales. El máximo se fija cada año según la fecha de lesión — para lesiones ocurridas en 2026, el máximo es $1,189.94 por semana — y el mínimo es $75 por semana (o su salario completo si es menor). Hay un período de espera de 7 días antes de que empiecen los beneficios salariales (S.C. Code § 42-9-200), pero si su incapacidad dura más de 14 días se le paga retroactivamente desde el día uno. Los beneficios médicos, incluido el tratamiento autorizado y el reembolso de millaje por viajes de más de 5 millas de ida, se pagan desde el primer día sin espera. Los beneficios por incapacidad total generalmente tienen tope de 500 semanas, salvo paraplejia, cuadriplejia o daño cerebral físico, que pueden pagarse de por vida. Estos beneficios salariales no pagan impuestos, y su estatus migratorio no le impide recibirlos.',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuánto paga la compensación laboral de Carolina del Sur por semana?', 'answer' => 'Paga dos tercios (66⅔%) de su salario semanal promedio, sujeto a un máximo y un mínimo anuales. El máximo se fija cada año según la fecha de lesión — para lesiones ocurridas en 2026 es $1,189.94 por semana — y el mínimo es $75 por semana, salvo que su salario promedio sea menor de $75, en cuyo caso recibe su salario completo.' ),
                array( 'question' => '¿Hay un período de espera antes de que paguen los beneficios?', 'answer' => 'Sí. Bajo el S.C. Code § 42-9-200, no se pagan beneficios salariales por los primeros 7 días calendario de incapacidad. Pero si su incapacidad dura más de 14 días, se le paga retroactivamente desde el día uno. La espera aplica solo a los beneficios salariales — los beneficios médicos se pagan desde el primer día.' ),
                array( 'question' => '¿Cuánto tiempo pueden durar los beneficios de compensación laboral?', 'answer' => 'Los beneficios por incapacidad total generalmente tienen un tope de 500 semanas bajo el § 42-9-10(B). La gran excepción es la paraplejia, la cuadriplejia o el daño cerebral físico, que no tienen tope y pueden pagarse de por vida. La incapacidad parcial temporal tiene un tope separado de 340 semanas.' ),
                array( 'question' => '¿Puedo recibir compensación laboral si no tengo papeles?', 'answer' => 'Su estatus migratorio no le impide recibir beneficios de compensación laboral en Carolina del Sur. Si se lesionó trabajando, tiene derecho a reclamar atención médica y reemplazo salarial. Su consulta con un abogado es confidencial, y en Roden Law atendemos en español y no cobramos honorarios a menos que ganemos.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN resource how-much-does-south-carolina-workers-comp-pay not found.' ); }

/* 6. south-carolina-workers-comp-claim-denied */
$en = get_page_by_path( 'south-carolina-workers-comp-claim-denied', OBJECT, 'resource' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Reclamo de Compensación Laboral Negado en Carolina del Sur: Qué Hacer',
        'excerpt' => 'Un reclamo de compensación laboral negado en Carolina del Sur no es el final. Conozca la escalera de apelación, los plazos (14 días, 30 días) y los formularios para pelear la negación.',
        'content' => <<<'HTML'
<p>Que nieguen su reclamo de compensación laboral en Carolina del Sur es frustrante, pero <strong>no es el final de su caso</strong>. La Comisión de Compensación Laboral de Carolina del Sur tiene una escalera de apelación definida, y muchas negaciones se revierten cuando el reclamo se presenta correctamente con la evidencia adecuada. El problema: cada paso tiene un <strong>plazo corto y estricto</strong> — si deja pasar uno, puede perder su derecho a apelar por completo.</p>
<p>Y si usted es un trabajador inmigrante, sepa esto: <strong>su estatus migratorio no le impide recibir beneficios de compensación laboral</strong>, y su consulta con nosotros es confidencial y en español. Roden Law trabaja con honorarios de contingencia — sin costo por adelantado y sin honorarios a menos que ganemos.</p>
<h2>¿Por qué negaron mi reclamo?</h2>
<p>Las aseguradoras niegan reclamos por varias razones, muchas de ellas disputables:</p>
<ul>
<li><strong>Disputa sobre si la lesión es laboral</strong> — la aseguradora argumenta que la lesión no surgió de su empleo ni en el curso del mismo.</li>
<li><strong>Plazos incumplidos</strong> — alegan que no reportó la lesión dentro de 90 días (&sect; 42-15-20) o no presentó el reclamo dentro de 2 años (&sect; 42-15-40).</li>
<li><strong>Condiciones preexistentes</strong> — culpan a una lesión anterior o una condición degenerativa en lugar del accidente laboral.</li>
<li><strong>Clasificación como contratista independiente</strong> — la empresa argumenta que usted era contratista, no empleado, y por tanto no está cubierto.</li>
</ul>
<p>Muchas de estas defensas se superan con evidencia médica, declaraciones de testigos y una lectura correcta de su relación laboral — para eso existe el proceso de apelación.</p>
<h2>La escalera de apelación en Carolina del Sur</h2>
<ul>
<li><strong>Paso 1 — Solicitar una audiencia (Formulario 50).</strong> Presente un <strong>Form 50</strong> (o <strong>Form 52</strong> si el reclamo es por fallecimiento) para pedir una audiencia ante un <strong>Comisionado individual</strong> de la Comisión de Compensación Laboral, quien celebra la audiencia y emite una orden.</li>
<li><strong>Paso 2 — Apelar al Panel de Apelaciones dentro de 14 días.</strong> Para impugnar la orden del Comisionado, presente un <strong>Form 30</strong> ("Request for Commission Review") dentro de <strong>14 días</strong> bajo el &sect; 42-17-50. Aplica una <strong>tarifa de $150</strong>. La Comisión en pleno, como <strong>Panel de Apelaciones</strong>, revisa la decisión.</li>
<li><strong>Paso 3 — Apelar a la Corte de Apelaciones de SC dentro de 30 días.</strong> Si el Panel falla en su contra, puede apelar a la <strong>Corte de Apelaciones de Carolina del Sur</strong> dentro de <strong>30 días</strong> bajo el &sect; 42-17-60. Esta vía directa aplica a lesiones ocurridas <strong>a partir del 1 de julio de 2007</strong>.</li>
<li><strong>Paso 4 — Pedir revisión a la Corte Suprema de SC.</strong> Finalmente puede pedir revisión a la <strong>Corte Suprema de Carolina del Sur</strong>, aunque esa revisión es <strong>discrecional</strong>: la Corte decide si toma el caso.</li>
</ul>
<h2>Los plazos para apelar</h2>
<table>
<tr><th>Paso de apelación</th><th>Plazo</th><th>Autoridad / formulario</th></tr>
<tr><td>Orden del Comisionado individual al Panel de Apelaciones</td><td>14 días</td><td>&sect; 42-17-50 (Form 30, tarifa de $150)</td></tr>
<tr><td>Panel de Apelaciones a la Corte de Apelaciones de SC</td><td>30 días</td><td>&sect; 42-17-60</td></tr>
<tr><td>Corte de Apelaciones a la Corte Suprema de SC</td><td>Revisión discrecional</td><td>Corte Suprema de SC</td></tr>
</table>
<p>Como el primer plazo de apelación es de apenas <strong>14 días</strong>, no espere para actuar después de una negación. Incumplir un plazo en cualquier nivel puede terminar su caso sin importar qué tan fuerte sea el reclamo.</p>
<h2>¿Debo contratar a un abogado para pelear la negación?</h2>
<p>Es muy recomendable. Cuando niegan un reclamo, la aseguradora ya decidió pelear contra usted, y el proceso de apelación es adversarial y regido por plazos. Un abogado reúne la evidencia médica y laboral que supera la negación, presenta los formularios correctos a tiempo y defiende su caso en la audiencia y en la apelación. En Carolina del Sur, los abogados de compensación laboral trabajan por contingencia y sus honorarios están sujetos a la aprobación de la Comisión, así que puede apelar sin pagar de su bolsillo.</p>
<h2>El reloj ya está corriendo</h2>
<p>Un abogado de Roden Law puede revisar su carta de negación, identificar qué defensa está usando la aseguradora y construir el caso para revertirla — protegiendo cada plazo de apelación. La revisión es gratuita y en español: <a href="/es/contact/">contáctenos</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Vea también <a href="/es/resources/how-much-does-south-carolina-workers-comp-pay/">cuánto paga la compensación laboral</a>, la <a href="/es/resources/south-carolina-workers-comp-body-part-values/">tabla de valores por parte del cuerpo</a> y nuestra página de <a href="/es/practice-areas/workers-compensation-lawyers/">abogados de compensación laboral</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => '¿Negaron su reclamo de compensación laboral en Carolina del Sur? Conozca la escalera de apelación y los plazos de 14 y 30 días. Consulta gratis en español.',
            '_roden_key_takeaways'    => 'Un reclamo de compensación laboral negado en Carolina del Sur no es el final de su caso: existe una escalera de apelación definida, pero los plazos son cortos e implacables. Se empieza solicitando una audiencia con el Formulario 50 (Formulario 52 si el reclamo es por fallecimiento) ante un Comisionado individual de la Comisión de Compensación Laboral. Si pierde, apela al Panel de Apelaciones (la Comisión en pleno) dentro de 14 días con el Formulario 30 (aplica una tarifa de $150). Desde ahí puede apelar a la Corte de Apelaciones de Carolina del Sur dentro de 30 días — vía disponible para lesiones ocurridas a partir del 1 de julio de 2007 — y finalmente pedir revisión discrecional a la Corte Suprema de Carolina del Sur. Las razones comunes de negación incluyen disputas sobre si la lesión es laboral, plazos incumplidos, argumentos de condiciones preexistentes y la clasificación errónea como contratista independiente. Su estatus migratorio no le impide recibir beneficios, y como cada plazo de apelación es firme, involucrar a un abogado rápido tras la negación es crítico.',
            '_roden_faqs'             => array(
                array( 'question' => '¿Qué hago si niegan mi reclamo de compensación laboral en Carolina del Sur?', 'answer' => 'Una negación no es el final de su caso. Solicite una audiencia ante un Comisionado individual de la Comisión de Compensación Laboral con el Formulario 50 (Formulario 52 si es por fallecimiento). Si pierde, puede apelar por una escalera definida con plazos cortos. Como el primer plazo de apelación es de solo 14 días, actúe rápido y considere involucrar a un abogado.' ),
                array( 'question' => '¿Cuánto tiempo tengo para apelar una negación en Carolina del Sur?', 'answer' => 'Tiene 14 días para apelar la orden de un Comisionado individual al Panel de Apelaciones (la Comisión en pleno) bajo el § 42-17-50, usando el Formulario 30 con una tarifa de $150. Después tiene 30 días para apelar a la Corte de Apelaciones de Carolina del Sur bajo el § 42-17-60. El último paso, la Corte Suprema, es de revisión discrecional.' ),
                array( 'question' => '¿Por qué niegan los reclamos de compensación laboral en Carolina del Sur?', 'answer' => 'Las razones comunes incluyen disputas sobre si la lesión es laboral, alegaciones de que incumplió el plazo de reporte de 90 días o el de presentación de 2 años, argumentos de condiciones preexistentes que culpan a una lesión anterior, y la clasificación como contratista independiente para alegar que no era un empleado cubierto. Muchas de estas defensas se superan con la evidencia adecuada.' ),
                array( 'question' => '¿Pueden negarme los beneficios por mi estatus migratorio?', 'answer' => 'Su estatus migratorio no le impide recibir beneficios de compensación laboral en Carolina del Sur. Si se lesionó trabajando, tiene derechos sin importar sus papeles, y su consulta con un abogado es confidencial. En Roden Law atendemos en español y no cobramos honorarios a menos que ganemos.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN resource south-carolina-workers-comp-claim-denied not found.' ); }

WP_CLI::log( '═══ BATCH 27 DONE ═══' );
