<?php
/**
 * ES Seeder — Batch 28: Resources (compensación laboral), part 2 of 2.
 * Resources: south-carolina-workers-comp-body-part-values, south-carolina-workers-comp-impairment-rating-mmi.
 * § 42-9-30 scheduled-member week table kept verbatim.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-28-res-wc-b.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 28 — RESOURCES: WORKERS COMP B ═══' );

/* 7. south-carolina-workers-comp-body-part-values */
$en = get_page_by_path( 'south-carolina-workers-comp-body-part-values', OBJECT, 'resource' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Tabla de Valores por Parte del Cuerpo: Compensación Laboral en Carolina del Sur',
        'excerpt' => 'La tabla de valores por parte del cuerpo de la compensación laboral de Carolina del Sur bajo el S.C. Code § 42-9-30: cuántas semanas de beneficios vale cada miembro (brazo, mano, espalda, ojo y más).',
        'content' => <<<'HTML'
<p>La ley de compensación laboral de Carolina del Sur asigna un valor específico a la mayoría de las partes del cuerpo. Bajo la <strong>tabla de miembros programados del S.C. Code &sect; 42-9-30</strong>, cada parte del cuerpo recibe un número fijo de semanas de beneficios, y cada semana se paga al <strong>66&frac23;% de su salario semanal promedio (AWW)</strong>. Una lesión permanente a un miembro programado vale: <em>(semanas de esa parte) &times; (porcentaje de deterioro) &times; (66&frac23;% de su AWW)</em>.</p>
<p>Estos beneficios están disponibles sin importar su estatus migratorio, y su consulta es confidencial y en español. Roden Law trabaja con honorarios de contingencia — sin costo por adelantado y sin honorarios a menos que ganemos.</p>
<h2>¿Cuántas semanas vale cada parte del cuerpo?</h2>
<p>Cada parte se paga al 66&frac23;% de su salario semanal promedio por el número de semanas listado (para una pérdida total de uso). Una pérdida <strong>parcial</strong> se paga proporcionalmente — por ejemplo, 50% de pérdida de uso de una mano es 50% &times; 185 = 92.5 semanas.</p>
<table>
<tr><th>Parte del cuerpo (miembro programado)</th><th>Semanas máximas de beneficios</th></tr>
<tr><td>Pulgar</td><td>65</td></tr>
<tr><td>Dedo índice</td><td>40</td></tr>
<tr><td>Segundo dedo</td><td>35</td></tr>
<tr><td>Tercer dedo</td><td>25</td></tr>
<tr><td>Cuarto dedo (meñique)</td><td>20</td></tr>
<tr><td>Dedo gordo del pie</td><td>35</td></tr>
<tr><td>Otro dedo del pie</td><td>10</td></tr>
<tr><td>Mano</td><td>185</td></tr>
<tr><td>Brazo</td><td>220</td></tr>
<tr><td>Hombro</td><td>300</td></tr>
<tr><td>Pie</td><td>140</td></tr>
<tr><td>Pierna</td><td>195</td></tr>
<tr><td>Cadera</td><td>280</td></tr>
<tr><td>Ojo (o pérdida total de la visión)</td><td>140</td></tr>
<tr><td>Audición, un oído</td><td>80</td></tr>
<tr><td>Audición, ambos oídos</td><td>165</td></tr>
<tr><td>Espalda — 49% o menos de pérdida de uso</td><td>300</td></tr>
<tr><td>Espalda — 50% o más de pérdida de uso</td><td>500 (y presunción de incapacidad total y permanente)</td></tr>
<tr><td>Lesión no programada / de "persona completa"</td><td>hasta 500</td></tr>
<tr><td>Desfiguración permanente grave (cara, cabeza, cuello u otra zona expuesta, incluidas cicatrices por quemaduras o queloides)</td><td>hasta 50</td></tr>
</table>
<h2>¿Cómo calculo lo que vale mi lesión?</h2>
<p>Tres números determinan una compensación programada: <strong>las semanas programadas</strong> de la parte lesionada (tabla anterior), <strong>su porcentaje de deterioro / pérdida de uso</strong> (fijado al alcanzar la mejoría médica máxima, MMI) y <strong>su tasa de compensación</strong> (66&frac23;% de su AWW). Multiplíquelos. Ejemplo: un trabajador con 50% de pérdida de uso de una mano tiene 50% &times; 185 semanas = 92.5 semanas de beneficios. Si su tasa de compensación fuera $600 por semana, la compensación sería 92.5 &times; $600 = $55,500.</p>
<h2>¿Por qué la espalda vale más?</h2>
<p>La espalda es el único miembro programado con dos niveles. Una lesión de espalda con <strong>49% o menos de pérdida de uso vale hasta 300 semanas</strong>, pero con <strong>50% o más vale hasta 500 semanas</strong>. Igual de importante: una espalda calificada con <strong>50% o más de pérdida de uso activa una presunción refutable de incapacidad total y permanente</strong>. Por eso la diferencia entre una calificación de 49% y una de 50% puede valer cientos de semanas de beneficios — y por eso se disputa tanto.</p>
<h2>¿Lesión "programada" vs. "no programada"?</h2>
<p>Un <strong>miembro programado</strong> es una parte del cuerpo que aparece en la lista del &sect; 42-9-30: brazo, mano, pierna, ojo, etcétera. Una lesión <strong>no programada</strong> (o de "persona completa") es una que no está en la lista, como una lesión a un órgano interno, y se compensa según la pérdida de capacidad de ganancia, hasta 500 semanas. La desfiguración — cicatrices permanentes graves de la cara, cabeza, cuello u otra zona normalmente expuesta, incluidas cicatrices por quemaduras o queloides — es una categoría separada que vale hasta 50 semanas.</p>
<h2>¿Puedo recuperar más que el monto programado?</h2>
<p>A veces, sí. El valor programado es un <strong>piso, no un techo</strong>. En lugar de la compensación programada, un trabajador lesionado puede buscar un <strong>reclamo por pérdida de capacidad de ganancia bajo el S.C. Code &sect; 42-9-20</strong> o un <strong>reclamo por incapacidad total bajo el &sect; 42-9-10</strong>, que pueden pagar más si la lesión afecta su capacidad de ganarse la vida. Cuál camino paga más depende de sus salarios, sus restricciones laborales y la evidencia médica.</p>
<h2>Hable con un abogado sobre su calificación</h2>
<p>Las semanas que vale su lesión dependen de un porcentaje de pérdida de uso que la aseguradora y sus médicos tienen todo el incentivo de mantener bajo. Un abogado de Roden Law puede revisar su calificación, su cálculo salarial y si un reclamo por pérdida salarial o incapacidad total le pagaría más. La revisión es gratuita y en español: <a href="/es/contact/">contáctenos</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Vea también <a href="/es/resources/south-carolina-workers-comp-impairment-rating-mmi/">cómo funcionan el MMI y las calificaciones de deterioro</a>, <a href="/es/resources/how-much-does-south-carolina-workers-comp-pay/">cuánto paga la compensación laboral</a> y nuestra página de <a href="/es/practice-areas/workers-compensation-lawyers/">abogados de compensación laboral</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Tabla de compensación laboral de Carolina del Sur (S.C. Code § 42-9-30): semanas de beneficios por mano, brazo, pierna, espalda y más. Consulta gratis en español.',
            '_roden_key_takeaways'    => 'La ley de compensación laboral de Carolina del Sur asigna un número fijo de semanas de beneficios a cada parte del cuerpo bajo la tabla de "miembros programados" del S.C. Code § 42-9-30. Cada compensación se paga al dos tercios (66⅔%) de su salario semanal promedio por el número de semanas listado. Por ejemplo, la pérdida de una mano vale 185 semanas, un brazo 220 semanas y una pierna 195 semanas. La espalda es la excepción clave: vale 300 semanas con 49% o menos de pérdida de uso, pero 500 semanas con 50% o más (y una lesión de espalda de 50% o más activa una presunción refutable de incapacidad total y permanente). Una pérdida parcial de uso se paga proporcionalmente — por ejemplo, 50% de pérdida de uso de una mano equivale a 92.5 semanas. Los valores en semanas los fija el estatuto, pero el monto en dólares depende de sus salarios, por lo que importa que su calificación de deterioro y su cálculo salarial se hagan correctamente. Su estatus migratorio no le impide reclamar estos beneficios.',
            '_roden_faqs'             => array(
                array( 'question' => '¿Cuántas semanas de beneficios vale cada parte del cuerpo en Carolina del Sur?', 'answer' => 'El S.C. Code § 42-9-30 fija un número de semanas por cada parte del cuerpo, pagadas al dos tercios (66⅔%) de su salario semanal promedio. Valores clave: mano 185 semanas, brazo 220, pierna 195, pie 140, ojo 140 y hombro 300. La espalda vale 300 semanas con 49% o menos de pérdida de uso y 500 semanas con 50% o más.' ),
                array( 'question' => '¿Cómo se calcula el valor de mi lesión?', 'answer' => 'Multiplique tres números: las semanas programadas de la parte lesionada, su porcentaje de pérdida de uso (fijado en la mejoría médica máxima) y su tasa de compensación (66⅔% de su salario semanal promedio). Por ejemplo, 50% de pérdida de uso de una mano es 50% × 185 = 92.5 semanas, pagadas a su tasa de compensación.' ),
                array( 'question' => '¿Por qué una lesión de espalda vale más en Carolina del Sur?', 'answer' => 'La espalda es el único miembro programado con dos niveles. Con 49% o menos de pérdida de uso vale hasta 300 semanas; con 50% o más vale hasta 500 semanas. Una espalda calificada con 50% o más también activa una presunción refutable de incapacidad total y permanente, por eso la calificación se disputa tanto.' ),
                array( 'question' => '¿Puedo recibir más que el monto programado por mi lesión?', 'answer' => 'A veces. El valor programado es un piso, no un techo. En lugar de la compensación programada, puede buscar un reclamo por pérdida de capacidad de ganancia bajo el S.C. Code § 42-9-20 o por incapacidad total bajo el § 42-9-10, que pueden pagar más si la lesión afecta su capacidad de ganarse la vida.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN resource south-carolina-workers-comp-body-part-values not found.' ); }

/* 8. south-carolina-workers-comp-impairment-rating-mmi */
$en = get_page_by_path( 'south-carolina-workers-comp-impairment-rating-mmi', OBJECT, 'resource' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'MMI y Calificación de Deterioro en la Compensación Laboral de Carolina del Sur',
        'excerpt' => 'Cómo funcionan la mejoría médica máxima (MMI) y las calificaciones de deterioro en la compensación laboral de Carolina del Sur, y cómo se calcula su compensación permanente.',
        'content' => <<<'HTML'
<p>La <strong>mejoría médica máxima (MMI)</strong> es el momento en que su lesión laboral ha sanado todo lo que va a sanar: su condición se ha estabilizado y no se espera que mejore significativamente con más tratamiento. El MMI importa porque Carolina del Sur no evalúa sus beneficios <strong>permanentes</strong> hasta que usted lo alcanza. Hasta ese punto puede recibir beneficios temporales; una vez en MMI, un médico asigna una <strong>calificación de deterioro</strong> que determina su compensación por incapacidad parcial permanente (PPD).</p>
<p>Estos beneficios están disponibles sin importar su estatus migratorio, y su consulta es confidencial y en español. Roden Law trabaja con honorarios de contingencia — sin costo por adelantado y sin honorarios a menos que ganemos.</p>
<h2>¿Qué significa la mejoría médica máxima (MMI)?</h2>
<p>MMI significa que su condición llegó a una meseta: el tratamiento adicional no va a mejorar la lesión de fondo, aunque usted siga con síntomas o necesite cuidados de mantenimiento. Carolina del Sur <strong>no define el MMI por estatuto</strong> — es un concepto médico y de la Comisión que determina su médico tratante. Alcanzar el MMI no significa estar "curado"; significa que su condición está tan estable como va a estar, que es el punto en que puede medirse cualquier deterioro <strong>permanente</strong>.</p>
<h2>¿Cómo se convierte una calificación de deterioro en dinero?</h2>
<p>Para un miembro programado, su compensación por incapacidad parcial permanente se calcula multiplicando tres números:</p>
<p><strong>porcentaje de deterioro &times; semanas programadas (&sect; 42-9-30) &times; tasa de compensación (66&frac23;% del AWW)</strong></p>
<p>Ejemplo: un trabajador con un <strong>50% de deterioro en una mano</strong> tiene derecho a 0.50 &times; 185 semanas = <strong>92.5 semanas</strong> de beneficios, pagadas al 66&frac23;% de su salario semanal promedio. Si la tasa de compensación fuera $600 por semana, serían 92.5 &times; $600 = $55,500. Las semanas de cada parte del cuerpo vienen de la tabla del &sect; 42-9-30 — vea nuestra <a href="/es/resources/south-carolina-workers-comp-body-part-values/">tabla de valores por parte del cuerpo</a>.</p>
<h2>¿Qué edición de las Guías de la AMA usa Carolina del Sur?</h2>
<p>Ninguna es obligatoria. <strong>Carolina del Sur no exige ninguna edición específica de las Guías de la AMA para la Evaluación del Deterioro Permanente.</strong> Una calificación de deterioro es evidencia de opinión médica que la Comisión de Compensación Laboral pondera — no un número automático y vinculante. Por eso dos médicos pueden asignar calificaciones distintas, y la primera calificación que le ofrece el médico de la aseguradora no es necesariamente la que la Comisión adoptará.</p>
<h2>¿Es lo mismo la calificación de deterioro que mi "pérdida de uso"?</h2>
<p>No necesariamente. El <strong>porcentaje de deterioro es una opinión médica</strong> sobre la pérdida física de la parte del cuerpo. El <strong>porcentaje de "pérdida de uso" es una determinación legal</strong> de la Comisión sobre cuánto uso de esa parte ha perdido usted realmente — y puede ser <strong>más alto que el número médico</strong>, porque considera cómo la lesión afecta su capacidad real de usar esa parte del cuerpo en el trabajo. Un trabajador con un 20% de deterioro médico puede recibir una pérdida de uso mucho mayor según la evidencia. Esta brecha es una de las partes más disputadas de un caso de compensación laboral.</p>
<h2>¿Puedo recuperar más que mi calificación programada?</h2>
<p>Sí — la calificación programada es un <strong>piso, no un techo</strong>. En lugar de aceptar la compensación programada, puede buscar un <strong>reclamo por pérdida de capacidad de ganancia bajo el S.C. Code &sect; 42-9-20</strong> o un <strong>reclamo por incapacidad total bajo el &sect; 42-9-10</strong>. Si su lesión limita el tipo de trabajo que puede hacer o lo que puede ganar, uno de estos caminos puede pagar sustancialmente más que las semanas programadas.</p>
<h2>No acepte la primera calificación que le ofrezcan</h2>
<p>Como la calificación de deterioro determina el valor en dólares de su compensación permanente, la aseguradora tiene todo el incentivo de enviarlo a un médico que asigne un número bajo y presionarlo a un acuerdo rápido al llegar al MMI. Un abogado de Roden Law puede revisar su calificación, buscar una segunda opinión cuando corresponda y argumentar la determinación de "pérdida de uso" más alta — o la compensación por pérdida salarial o incapacidad total — que los hechos respalden. La revisión es gratuita y en español: <a href="/es/contact/">contáctenos</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Vea también <a href="/es/resources/how-much-does-south-carolina-workers-comp-pay/">cuánto paga la compensación laboral</a>, <a href="/es/resources/south-carolina-workers-comp-claim-denied/">qué hacer si niegan su reclamo</a> y nuestra página de <a href="/es/practice-areas/workers-compensation-lawyers/">abogados de compensación laboral</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Cómo funcionan el MMI y las calificaciones de deterioro en la compensación laboral de Carolina del Sur, y cómo se calcula su compensación permanente. Consulta gratis.',
            '_roden_key_takeaways'    => 'La mejoría médica máxima (MMI) es el punto en que su lesión laboral se ha estabilizado y no se espera que mejore con más tratamiento. La ley de Carolina del Sur no define el MMI por estatuto — es un concepto médico y de la Comisión — pero su compensación por incapacidad parcial permanente (PPD) no se evalúa hasta que lo alcanza. Una vez en MMI, un médico asigna una calificación de deterioro, y su compensación programada se calcula así: porcentaje de deterioro × las semanas programadas de esa parte del cuerpo (S.C. Code § 42-9-30) × su tasa de compensación (66⅔% de su salario semanal promedio). Por ejemplo, un 50% de deterioro en una mano es 0.50 × 185 = 92.5 semanas de beneficios. Carolina del Sur no exige ninguna edición específica de las Guías de la AMA, por lo que el porcentaje médico de deterioro puede diferir del porcentaje legal de "pérdida de uso" que la Comisión finalmente determina — y la calificación programada es un piso, no un techo, porque un reclamo por pérdida salarial o incapacidad total puede pagar más.',
            '_roden_faqs'             => array(
                array( 'question' => '¿Qué significa la mejoría médica máxima (MMI) en la compensación laboral de Carolina del Sur?', 'answer' => 'El MMI es el punto en que su lesión laboral se ha estabilizado y no se espera que mejore con más tratamiento, aunque siga con síntomas. Carolina del Sur no lo define por estatuto — es un concepto médico y de la Comisión que determina su médico tratante. Su compensación por incapacidad parcial permanente no se evalúa hasta que alcanza el MMI.' ),
                array( 'question' => '¿Cómo se convierte mi calificación de deterioro en una compensación?', 'answer' => 'Para un miembro programado, la compensación es su porcentaje de deterioro × las semanas programadas de esa parte (S.C. Code § 42-9-30) × su tasa de compensación (66⅔% de su salario semanal promedio). Por ejemplo, un 50% de deterioro en una mano equivale a 0.50 × 185 = 92.5 semanas de beneficios, pagadas a su tasa de compensación.' ),
                array( 'question' => '¿Es mi calificación de deterioro lo mismo que mi pérdida de uso?', 'answer' => 'No necesariamente. El porcentaje de deterioro es una opinión médica sobre la pérdida física de la parte del cuerpo. La "pérdida de uso" es una determinación legal de la Comisión sobre cuánto uso ha perdido realmente, y puede ser más alta que el número médico porque considera cómo la lesión afecta su capacidad real de trabajar.' ),
                array( 'question' => '¿Debo aceptar la primera calificación que ofrece la aseguradora?', 'answer' => 'Tenga cuidado. Como la calificación determina el valor de su compensación permanente, la aseguradora tiene incentivo para enviarlo a un médico que asigne un número bajo y presionar un acuerdo rápido al llegar al MMI. Un abogado puede revisar la calificación, buscar una segunda opinión y argumentar una determinación de pérdida de uso más alta o una compensación por pérdida salarial o incapacidad total.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN resource south-carolina-workers-comp-impairment-rating-mmi not found.' ); }

WP_CLI::log( '═══ BATCH 28 DONE ═══' );
