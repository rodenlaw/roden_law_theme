<?php
/**
 * ES Seeder — Batch 09: Pillar practice areas (serious harm).
 * Pillars: medical-malpractice-lawyers, wrongful-death-lawyers.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-09-pillars-serious.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 09 — PILLARS: SERIOUS ═══' );

/* 1. medical-malpractice-lawyers */
$en = roden_es_seed_find_pillar( 'medical-malpractice-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Negligencia Médica',
        'excerpt' => 'Abogados de negligencia médica en Georgia y Carolina del Sur. Responsabilizamos a médicos y hospitales negligentes. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Cuando un error médico cambia su vida</h2>
<p>Confiamos en los médicos y hospitales en nuestros momentos más vulnerables. La gran mayoría cumple con su deber — pero cuando un profesional de la salud no sigue el estándar de cuidado aceptado y eso causa daño, la ley le permite reclamar. La negligencia médica incluye diagnósticos equivocados o tardíos, errores quirúrgicos, errores de medicación y anestesia, lesiones de parto e infecciones hospitalarias evitables.</p>
<p>Estos casos son de los más complejos del derecho de lesiones personales. No basta con un mal resultado: hay que probar, con testimonio de expertos médicos, que el profesional se apartó del estándar de cuidado y que ese error — no la enfermedad — causó el daño. En Georgia, la demanda debe ir acompañada de una declaración jurada de un experto calificado (O.C.G.A. § 9-11-9.1); Carolina del Sur exige un proceso similar de presentación previa con declaración de experto. Roden Law trabaja con una red de médicos expertos para evaluar y construir su caso.</p>
<h2>Plazos estrictos para reclamar</h2>
<p>En Georgia, usted generalmente tiene 2 años (O.C.G.A. § 9-3-71) desde la fecha del acto negligente para presentar una demanda por negligencia médica, con un límite absoluto de 5 años en la mayoría de los casos. En Carolina del Sur, el plazo general es de 3 años (S.C. Code § 15-3-545). Hay excepciones — por ejemplo, objetos extraños olvidados en el cuerpo o casos de menores — pero son limitadas. No espere para que un abogado revise su situación.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita en español o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Si su ser querido falleció por un error médico, vea nuestra página de <a href="/es/practice-areas/wrongful-death-lawyers/">abogados de muerte por negligencia</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de negligencia médica en Georgia y Carolina del Sur. Errores quirúrgicos, diagnósticos y de parto. Consulta gratis: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de negligencia médica prueba, con expertos médicos, que un doctor u hospital se apartó del estándar de cuidado y le causó daño. Roden Law ha recuperado más de $300 millones para víctimas en Georgia y Carolina del Sur.',
            '_roden_why_hire'         => '<p>Los hospitales y sus aseguradoras defienden los casos de negligencia médica con equipos enteros de abogados y peritos. Para enfrentarlos se necesita un bufete con recursos: en Roden Law obtenemos y analizamos el expediente médico completo, contratamos a médicos expertos en la especialidad correcta para evaluar el estándar de cuidado, y cumplimos los requisitos técnicos — como la declaración jurada de experto que exige Georgia (O.C.G.A. § 9-11-9.1) — que hacen fracasar los casos mal preparados.</p><p>Evaluamos su caso con honestidad: si hubo negligencia, lo peleamos hasta el final; si no la hubo, se lo decimos sin costo. Con 62 años de experiencia combinada, más de 5,000 casos y 6 oficinas en Georgia y Carolina del Sur, atendemos consultas en español las 24 horas y no cobramos honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Diagnóstico equivocado o tardío de cáncer, infarto o derrame', 'Errores quirúrgicos y cirugías en el sitio incorrecto', 'Errores de medicación y de dosis', 'Lesiones de parto que dañan al bebé o a la madre', 'Errores de anestesia', 'Infecciones hospitalarias y altas prematuras' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Daño cerebral por falta de oxígeno', 'description' => 'Los errores de anestesia, de parto o de monitoreo pueden privar al cerebro de oxígeno durante minutos críticos, causando daño neurológico permanente e irreversible.' ),
                array( 'name' => 'Parálisis cerebral y lesiones de parto', 'description' => 'Los errores durante el parto, como la demora en realizar una cesárea necesaria, pueden causar parálisis cerebral y otras lesiones que el niño enfrentará toda su vida.' ),
                array( 'name' => 'Amputaciones innecesarias', 'description' => 'Un diagnóstico tardío de una infección o de problemas circulatorios puede llevar a la pérdida de una extremidad que un tratamiento oportuno habría salvado.' ),
                array( 'name' => 'Daño a órganos internos', 'description' => 'Los errores quirúrgicos, como perforaciones o instrumentos olvidados en el cuerpo, pueden dañar órganos sanos y exigir cirugías correctivas adicionales de emergencia.' ),
                array( 'name' => 'Infecciones graves y sepsis', 'description' => 'La falta de higiene hospitalaria o la demora en reconocer una infección puede permitir que avance hasta la sepsis, un cuadro que pone en peligro la vida.' ),
                array( 'name' => 'Empeoramiento de la enfermedad por diagnóstico tardío', 'description' => 'Cuando un cáncer, un infarto o un derrame no se diagnostica a tiempo, el paciente pierde opciones de tratamiento y su pronóstico puede empeorar de forma irreversible.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Cómo sé si tengo un caso de negligencia médica?', 'answer' => 'Un mal resultado no siempre es negligencia. La pregunta es si el profesional se apartó del estándar de cuidado que un médico razonable habría seguido, y si ese error causó su daño. Solo un experto médico puede responderla — por eso ofrecemos una evaluación gratuita de su expediente.' ),
                array( 'question' => '¿Cuánto tiempo tengo para demandar?', 'answer' => 'En Georgia, generalmente 2 años (O.C.G.A. § 9-3-71) desde el acto negligente, con un límite absoluto de 5 años en la mayoría de los casos. En Carolina del Sur, generalmente 3 años (S.C. Code § 15-3-545). Existen excepciones limitadas, como objetos olvidados en el cuerpo. Consulte pronto: preparar estos casos toma meses.' ),
                array( 'question' => '¿Qué se necesita para presentar la demanda?', 'answer' => 'Además de la evidencia, Georgia exige presentar una declaración jurada de un experto médico calificado junto con la demanda (O.C.G.A. § 9-11-9.1), y Carolina del Sur exige un proceso previo similar con declaración de experto. Sin ese respaldo experto, el caso se desestima. Nosotros nos encargamos de todo el proceso.' ),
                array( 'question' => '¿Puedo demandar al hospital o solo al médico?', 'answer' => 'Depende de quién cometió el error y de la relación laboral. El hospital puede ser responsable por sus empleados — enfermeras, técnicos, personal de emergencias — y en ciertos casos por los médicos que trabajan en él. Investigamos a todas las partes responsables.' ),
                array( 'question' => '¿Cuánto cuesta contratar a Roden Law?', 'answer' => 'Nada por adelantado. Nosotros adelantamos los costos de expertos y peritos, y solo cobramos si recuperamos compensación para usted. La consulta y la evaluación inicial de su caso son gratuitas.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar medical-malpractice-lawyers not found.' ); }

/* 2. wrongful-death-lawyers */
$en = roden_es_seed_find_pillar( 'wrongful-death-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Muerte por Negligencia',
        'excerpt' => 'Abogados de muerte por negligencia en Georgia y Carolina del Sur. Ayudamos a las familias a obtener justicia por la pérdida de un ser querido. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Justicia para las familias que perdieron a un ser querido</h2>
<p>Ninguna compensación devuelve a un ser querido. Pero cuando una muerte fue causada por la negligencia de otro — un conductor ebrio, una compañía de camiones que violó las reglas, un negocio que ignoró un peligro, un error médico — la ley le da a la familia el derecho de exigir responsabilidad y asegurar su futuro económico. Los abogados de muerte por negligencia de Roden Law manejan estos casos con compasión por la familia y firmeza contra los responsables.</p>
<p>Cada estado define quién puede demandar. En Georgia, la demanda corresponde primero al cónyuge sobreviviente (que también representa a los hijos menores), y en su ausencia a los hijos o padres del fallecido; la ley mide la pérdida como el "valor completo de la vida" de la víctima. En Carolina del Sur, la demanda la presenta el representante personal del patrimonio en beneficio del cónyuge, los hijos o los herederos. Además puede existir un reclamo del patrimonio por el sufrimiento de la víctima antes de morir y los gastos médicos y funerarios.</p>
<h2>Plazos para presentar la demanda</h2>
<p>En Georgia, la familia generalmente tiene 2 años (O.C.G.A. § 51-4-1) desde la fecha del fallecimiento para presentar la demanda; en Carolina del Sur, el plazo general es de 3 años (S.C. Code § 15-3-530). Algunos hechos pueden acortar o pausar estos plazos — por ejemplo, si hay un proceso penal relacionado — así que es importante consultar pronto.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita y confidencial en español, o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Manejamos muertes causadas por <a href="/es/practice-areas/car-accident-lawyers/">accidentes de auto</a>, <a href="/es/practice-areas/truck-accident-lawyers/">accidentes de camiones</a> y <a href="/es/practice-areas/medical-malpractice-lawyers/">negligencia médica</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de muerte por negligencia en Georgia y Carolina del Sur. Justicia y compensación para su familia. Consulta gratuita: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de muerte por negligencia ayuda a la familia a exigir responsabilidad y compensación cuando un ser querido fallece por la negligencia de otro. Roden Law ha recuperado más de $300 millones para familias y víctimas en Georgia y Carolina del Sur.',
            '_roden_why_hire'         => '<p>Mientras su familia atraviesa el duelo, la aseguradora del responsable ya está trabajando para pagar lo menos posible. En Roden Law cargamos con todo el peso legal: investigamos la causa de la muerte con expertos, identificamos a todos los responsables y todas las pólizas de seguro, calculamos el valor completo de la vida de su ser querido — ingresos futuros, cuidado de los hijos, compañía — y peleamos el caso en negociación o en juicio. Usted se concentra en su familia; nosotros nos encargamos del resto.</p><p>Tratamos cada caso con la discreción y el respeto que su familia merece, con consultas en español las 24 horas. Con 62 años de experiencia combinada, más de 5,000 casos y 6 oficinas en Georgia y Carolina del Sur, no cobramos honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Accidentes de auto y de camiones comerciales', 'Conductores ebrios o drogados', 'Negligencia médica y errores hospitalarios', 'Accidentes de trabajo y de construcción', 'Productos defectuosos', 'Negligencia en asilos de ancianos' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Pérdida de ingresos y beneficios futuros de la familia', 'description' => 'La demanda reclama los salarios, beneficios y aportes económicos que su ser querido habría proporcionado a la familia durante el resto de su vida laboral.' ),
                array( 'name' => 'Gastos médicos de la última enfermedad o lesión', 'description' => 'El patrimonio puede recuperar los costos del tratamiento médico que la víctima recibió entre el accidente y su fallecimiento, incluidos la hospitalización y los cuidados intensivos.' ),
                array( 'name' => 'Gastos funerarios y de entierro', 'description' => 'La familia puede reclamar los costos razonables del funeral y del entierro, para que estos gastos inesperados no agraven la carga económica del duelo.' ),
                array( 'name' => 'Pérdida de compañía, cuidado y guía para los hijos', 'description' => 'La ley reconoce el valor de la compañía, el consejo y la crianza que el fallecido brindaba a su cónyuge y a sus hijos, una pérdida compensable en la demanda.' ),
                array( 'name' => 'Sufrimiento de la víctima antes de fallecer', 'description' => 'Cuando la víctima sobrevivió un tiempo tras el accidente, el patrimonio puede reclamar compensación por el dolor y el sufrimiento consciente que padeció antes de morir.' ),
                array( 'name' => 'Pérdida del valor completo de la vida del ser querido', 'description' => 'En Georgia, la ley mide la pérdida como el valor completo de la vida del fallecido, incluyendo tanto su valor económico como el valor intangible de vivirla.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Quién puede presentar una demanda por muerte por negligencia?', 'answer' => 'En Georgia, primero el cónyuge sobreviviente (que también representa a los hijos menores); si no hay cónyuge, los hijos, y luego los padres o el patrimonio. En Carolina del Sur, la presenta el representante personal del patrimonio en beneficio del cónyuge, los hijos o los herederos. Le ayudamos a determinar quién debe presentarla en su caso.' ),
                array( 'question' => '¿Qué compensación puede recibir la familia?', 'answer' => 'Puede incluir los ingresos y beneficios que la víctima habría aportado, los gastos médicos y funerarios, el sufrimiento de la víctima antes de morir, y la pérdida de compañía y cuidado para la familia. En Georgia, la ley mide el "valor completo de la vida" del fallecido. Cada caso es distinto y ningún resultado puede garantizarse.' ),
                array( 'question' => '¿Cuánto tiempo tenemos para demandar?', 'answer' => 'En Georgia, generalmente 2 años (O.C.G.A. § 51-4-1) desde el fallecimiento; en Carolina del Sur, 3 años (S.C. Code § 15-3-530). Ciertos hechos pueden modificar el plazo, como un proceso penal pendiente contra el responsable. Consulte lo antes posible.' ),
                array( 'question' => '¿Qué pasa si también hay un caso penal contra el responsable?', 'answer' => 'El caso penal y la demanda civil son procesos separados. El penal busca castigar al responsable; la demanda civil busca compensar a su familia, y tiene un estándar de prueba más bajo. Puede haber demanda civil aunque no haya condena penal, y viceversa.' ),
                array( 'question' => '¿Cuánto cuesta contratar a Roden Law?', 'answer' => 'Nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos si recuperamos compensación para su familia. La consulta es gratuita, confidencial y en español.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar wrongful-death-lawyers not found.' ); }

WP_CLI::log( '═══ BATCH 09 DONE ═══' );
