<?php
/**
 * ES one-off fixer — enrich `_roden_common_injuries` descriptions on the 10 ES pillars.
 *
 * The live ES pillar posts currently hold array( 'name' => …, 'description' => '' )
 * after the emergency shape repair; this script re-sets the meta with the full
 * Spanish descriptions (same data as seed-es-batch-05…09). Idempotent — safe to re-run.
 *
 * Run: echo "include get_template_directory() . '/inc/es/fix-es-injury-descriptions.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES FIX — INJURY DESCRIPTIONS ═══' );

$roden_es_injury_fix = array(
    'es-car-accident-lawyers' => array(
        array( 'name' => 'Latigazo cervical y lesiones de cuello y espalda', 'description' => 'Causado por el movimiento brusco de la cabeza durante el impacto, el latigazo cervical puede provocar dolor crónico, rigidez y limitaciones que persisten meses después del choque.' ),
        array( 'name' => 'Fracturas de huesos', 'description' => 'Las fuerzas del impacto pueden fracturar brazos, piernas, costillas o clavículas, y muchas fracturas requieren cirugía, fijación con placas y meses de rehabilitación.' ),
        array( 'name' => 'Lesiones cerebrales traumáticas y conmociones', 'description' => 'Un golpe de la cabeza contra el volante o la ventana puede causar desde conmociones hasta daño cerebral permanente que afecta la memoria, la concentración y el estado de ánimo.' ),
        array( 'name' => 'Lesiones de la médula espinal', 'description' => 'El daño a la médula espinal puede causar pérdida de sensibilidad o parálisis parcial o total, con necesidades de atención médica y cuidados que se extienden de por vida.' ),
        array( 'name' => 'Lesiones internas y hemorragias', 'description' => 'El impacto o el cinturón de seguridad pueden dañar órganos internos y causar hemorragias sin síntomas inmediatos, por lo que la evaluación médica urgente es esencial.' ),
        array( 'name' => 'Cortes, laceraciones y cicatrices permanentes', 'description' => 'Los vidrios rotos y el metal deformado causan cortes profundos que pueden dañar nervios y dejar cicatrices permanentes que requieren cirugía reconstructiva.' ),
    ),
    'es-truck-accident-lawyers' => array(
        array( 'name' => 'Lesiones cerebrales traumáticas', 'description' => 'La violencia de un impacto con un camión comercial puede causar daño cerebral que altera de forma permanente la memoria, el habla, la personalidad y la capacidad de trabajar.' ),
        array( 'name' => 'Lesiones de la médula espinal y parálisis', 'description' => 'El daño a la médula espinal en choques con camiones puede resultar en paraplejia o cuadriplejia, con costos de cuidado que alcanzan millones de dólares de por vida.' ),
        array( 'name' => 'Fracturas múltiples y lesiones por aplastamiento', 'description' => 'El peso de un camión puede aplastar el habitáculo del vehículo, causando fracturas múltiples y daño a tejidos que requieren varias cirugías y una larga rehabilitación.' ),
        array( 'name' => 'Quemaduras graves', 'description' => 'Los incendios y derrames de combustible tras un choque con camión pueden causar quemaduras de segundo y tercer grado que dejan cicatrices permanentes y exigen injertos de piel.' ),
        array( 'name' => 'Amputaciones', 'description' => 'Las extremidades atrapadas o aplastadas en el choque pueden requerir amputación, una pérdida permanente que exige prótesis, rehabilitación y adaptación de por vida.' ),
        array( 'name' => 'Lesiones internas que requieren cirugía', 'description' => 'La fuerza brutal del impacto puede lacerar el hígado, el bazo o los pulmones, lesiones que ponen en riesgo la vida y exigen cirugía de emergencia.' ),
    ),
    'es-workers-compensation-lawyers' => array(
        array( 'name' => 'Lesiones de espalda y hernias de disco', 'description' => 'El levantamiento repetido de cargas pesadas puede herniar los discos de la columna, causando dolor crónico que limita su capacidad de trabajar y a menudo requiere cirugía.' ),
        array( 'name' => 'Fracturas de huesos', 'description' => 'Las caídas y los accidentes con equipos causan fracturas que lo dejan sin trabajar durante semanas o meses, con derecho a atención médica pagada y parte de sus salarios.' ),
        array( 'name' => 'Lesiones por movimientos repetitivos', 'description' => 'Condiciones como el síndrome del túnel carpiano se desarrollan gradualmente por el trabajo repetido y también están cubiertas por la compensación laboral, aunque no haya un accidente único.' ),
        array( 'name' => 'Amputaciones y lesiones por aplastamiento', 'description' => 'La maquinaria industrial sin protecciones puede atrapar y aplastar manos o brazos, causando pérdidas permanentes que dan derecho a beneficios por incapacidad permanente.' ),
        array( 'name' => 'Quemaduras y lesiones químicas', 'description' => 'El contacto con sustancias químicas, superficies calientes o electricidad en el trabajo puede causar quemaduras graves que requieren tratamiento especializado prolongado y dejan cicatrices.' ),
        array( 'name' => 'Lesiones cerebrales y de la médula espinal', 'description' => 'Las caídas desde alturas y los golpes por objetos pueden causar daño cerebral o de la médula espinal, las lesiones laborales más graves y con mayores beneficios de incapacidad.' ),
    ),
    'es-construction-accident-lawyers' => array(
        array( 'name' => 'Lesiones cerebrales traumáticas', 'description' => 'Las caídas desde alturas y los golpes por materiales que caen pueden causar daño cerebral permanente, incluso cuando el trabajador llevaba puesto el casco de seguridad.' ),
        array( 'name' => 'Fracturas múltiples y lesiones por aplastamiento', 'description' => 'Los colapsos de zanjas y los accidentes con maquinaria pesada pueden aplastar extremidades y fracturar varios huesos a la vez, exigiendo cirugías y meses de recuperación.' ),
        array( 'name' => 'Lesiones de la médula espinal y parálisis', 'description' => 'Una caída desde un andamio o un techo puede dañar la médula espinal y causar parálisis permanente, con necesidad de cuidados y adaptaciones de por vida.' ),
        array( 'name' => 'Amputaciones', 'description' => 'Las sierras, la maquinaria sin protecciones y los equipos pesados de la obra pueden causar la pérdida de dedos, manos o extremidades completas.' ),
        array( 'name' => 'Quemaduras eléctricas y químicas', 'description' => 'El contacto con cables energizados o sustancias corrosivas en la obra causa quemaduras profundas que dañan tejidos internos y suelen requerir injertos de piel.' ),
        array( 'name' => 'Lesiones graves de espalda y hombros', 'description' => 'Cargar materiales pesados y las caídas en la obra provocan desgarros y hernias en la espalda y los hombros que pueden impedirle volver al trabajo de construcción.' ),
    ),
    'es-motorcycle-accident-lawyers' => array(
        array( 'name' => 'Lesiones cerebrales traumáticas', 'description' => 'Incluso con casco, el impacto contra el pavimento o el vehículo puede causar daño cerebral que afecta de forma permanente la memoria, el equilibrio y la capacidad de trabajar.' ),
        array( 'name' => 'Fracturas de brazos, piernas y pelvis', 'description' => 'El motociclista recibe el impacto directo o cae contra el pavimento, sufriendo fracturas que requieren cirugía con placas y tornillos y una larga rehabilitación.' ),
        array( 'name' => 'Lesiones de la médula espinal', 'description' => 'El daño a la columna en un choque de motocicleta puede causar pérdida de movilidad o parálisis permanente, con costos médicos que se extienden de por vida.' ),
        array( 'name' => 'Abrasiones graves de piel (road rash)', 'description' => 'El deslizamiento sobre el asfalto arranca capas de piel, causando heridas dolorosas propensas a infección que pueden requerir injertos y dejar cicatrices permanentes.' ),
        array( 'name' => 'Amputaciones', 'description' => 'Las piernas del motociclista pueden quedar atrapadas o aplastadas entre la motocicleta y el vehículo, resultando en amputaciones que cambian la vida para siempre.' ),
        array( 'name' => 'Lesiones internas', 'description' => 'El impacto puede dañar órganos como el hígado, el bazo o los pulmones, causando hemorragias internas que requieren atención médica de emergencia inmediata.' ),
    ),
    'es-pedestrian-accident-lawyers' => array(
        array( 'name' => 'Lesiones cerebrales traumáticas', 'description' => 'El golpe contra el vehículo o el pavimento puede causar daño cerebral grave, con efectos permanentes en la memoria, el lenguaje y la personalidad de la víctima.' ),
        array( 'name' => 'Fracturas de piernas, cadera y pelvis', 'description' => 'El parachoques impacta directamente las piernas y la cadera del peatón, causando fracturas complejas que requieren cirugía y pueden dejar limitaciones permanentes para caminar.' ),
        array( 'name' => 'Lesiones de la médula espinal', 'description' => 'La fuerza del atropello puede fracturar vértebras y dañar la médula espinal, causando pérdida de sensibilidad o parálisis que exige cuidados de por vida.' ),
        array( 'name' => 'Lesiones internas y hemorragias', 'description' => 'El impacto del vehículo puede lacerar órganos internos y causar hemorragias que ponen en riesgo la vida y no siempre presentan síntomas inmediatos.' ),
        array( 'name' => 'Laceraciones y cicatrices permanentes', 'description' => 'El contacto con el vehículo y el pavimento causa cortes profundos que pueden dañar nervios y dejar cicatrices visibles que requieren cirugía reconstructiva.' ),
        array( 'name' => 'Lesiones fatales', 'description' => 'Cuando el atropello causa la muerte, la familia puede presentar una demanda por muerte por negligencia para exigir responsabilidad y proteger su futuro económico.' ),
    ),
    'es-slip-and-fall-lawyers' => array(
        array( 'name' => 'Fracturas de cadera, muñeca y tobillo', 'description' => 'Al intentar frenar la caída, el peso del cuerpo fractura la muñeca, el tobillo o la cadera; las fracturas de cadera son especialmente graves en los adultos mayores.' ),
        array( 'name' => 'Lesiones de espalda y hernias de disco', 'description' => 'La caída sobre una superficie dura puede herniar los discos de la columna, causando dolor crónico que limita el trabajo y suele requerir terapia o cirugía.' ),
        array( 'name' => 'Lesiones cerebrales traumáticas por golpes en la cabeza', 'description' => 'Golpearse la cabeza contra el piso o un estante puede causar conmociones o daño cerebral duradero, incluso cuando la víctima no pierde el conocimiento.' ),
        array( 'name' => 'Lesiones de hombro y desgarres de ligamentos', 'description' => 'Caer sobre el brazo extendido puede desgarrar el manguito rotador y los ligamentos del hombro, lesiones dolorosas que a menudo requieren cirugía y rehabilitación prolongada.' ),
        array( 'name' => 'Lesiones de rodilla', 'description' => 'El impacto directo o la torsión durante la caída puede desgarrar los meniscos y ligamentos de la rodilla, dejando dolor persistente y movilidad limitada.' ),
        array( 'name' => 'Cortes y contusiones graves', 'description' => 'El contacto con bordes, esquinas o el piso causa cortes y hematomas profundos que, en personas mayores o que toman anticoagulantes, pueden tener complicaciones serias.' ),
    ),
    'es-dog-bite-lawyers' => array(
        array( 'name' => 'Heridas punzantes y desgarros profundos', 'description' => 'Los dientes del perro perforan y desgarran la piel y los tejidos, causando heridas profundas que requieren sutura y pueden dañar estructuras debajo de la piel.' ),
        array( 'name' => 'Cicatrices permanentes y desfiguración facial', 'description' => 'Las mordeduras en la cara, frecuentes en los niños, dejan cicatrices visibles y desfiguración que suelen requerir varias cirugías reconstructivas a lo largo de años.' ),
        array( 'name' => 'Infecciones graves', 'description' => 'La boca del perro transmite bacterias que pueden causar infecciones serias, incluidas celulitis y sepsis, que a veces requieren hospitalización y antibióticos intravenosos.' ),
        array( 'name' => 'Daño a nervios, tendones y músculos', 'description' => 'Una mordedura profunda puede seccionar nervios y tendones de las manos o los brazos, causando pérdida de fuerza, sensibilidad o movilidad que puede ser permanente.' ),
        array( 'name' => 'Fracturas por caídas durante el ataque', 'description' => 'Al ser derribada o al intentar escapar del animal, la víctima puede caer y sufrir fracturas de muñeca, cadera u otras lesiones adicionales.' ),
        array( 'name' => 'Trauma emocional y estrés postraumático, especialmente en niños', 'description' => 'El terror del ataque puede dejar pesadillas, ansiedad y un miedo duradero a los animales, un trauma psicológico que forma parte compensable del reclamo.' ),
    ),
    'es-medical-malpractice-lawyers' => array(
        array( 'name' => 'Daño cerebral por falta de oxígeno', 'description' => 'Los errores de anestesia, de parto o de monitoreo pueden privar al cerebro de oxígeno durante minutos críticos, causando daño neurológico permanente e irreversible.' ),
        array( 'name' => 'Parálisis cerebral y lesiones de parto', 'description' => 'Los errores durante el parto, como la demora en realizar una cesárea necesaria, pueden causar parálisis cerebral y otras lesiones que el niño enfrentará toda su vida.' ),
        array( 'name' => 'Amputaciones innecesarias', 'description' => 'Un diagnóstico tardío de una infección o de problemas circulatorios puede llevar a la pérdida de una extremidad que un tratamiento oportuno habría salvado.' ),
        array( 'name' => 'Daño a órganos internos', 'description' => 'Los errores quirúrgicos, como perforaciones o instrumentos olvidados en el cuerpo, pueden dañar órganos sanos y exigir cirugías correctivas adicionales de emergencia.' ),
        array( 'name' => 'Infecciones graves y sepsis', 'description' => 'La falta de higiene hospitalaria o la demora en reconocer una infección puede permitir que avance hasta la sepsis, un cuadro que pone en peligro la vida.' ),
        array( 'name' => 'Empeoramiento de la enfermedad por diagnóstico tardío', 'description' => 'Cuando un cáncer, un infarto o un derrame no se diagnostica a tiempo, el paciente pierde opciones de tratamiento y su pronóstico puede empeorar de forma irreversible.' ),
    ),
    'es-wrongful-death-lawyers' => array(
        array( 'name' => 'Pérdida de ingresos y beneficios futuros de la familia', 'description' => 'La demanda reclama los salarios, beneficios y aportes económicos que su ser querido habría proporcionado a la familia durante el resto de su vida laboral.' ),
        array( 'name' => 'Gastos médicos de la última enfermedad o lesión', 'description' => 'El patrimonio puede recuperar los costos del tratamiento médico que la víctima recibió entre el accidente y su fallecimiento, incluidos la hospitalización y los cuidados intensivos.' ),
        array( 'name' => 'Gastos funerarios y de entierro', 'description' => 'La familia puede reclamar los costos razonables del funeral y del entierro, para que estos gastos inesperados no agraven la carga económica del duelo.' ),
        array( 'name' => 'Pérdida de compañía, cuidado y guía para los hijos', 'description' => 'La ley reconoce el valor de la compañía, el consejo y la crianza que el fallecido brindaba a su cónyuge y a sus hijos, una pérdida compensable en la demanda.' ),
        array( 'name' => 'Sufrimiento de la víctima antes de fallecer', 'description' => 'Cuando la víctima sobrevivió un tiempo tras el accidente, el patrimonio puede reclamar compensación por el dolor y el sufrimiento consciente que padeció antes de morir.' ),
        array( 'name' => 'Pérdida del valor completo de la vida del ser querido', 'description' => 'En Georgia, la ley mide la pérdida como el valor completo de la vida del fallecido, incluyendo tanto su valor económico como el valor intangible de vivirla.' ),
    ),
);

foreach ( $roden_es_injury_fix as $slug => $injuries ) {
    $posts = get_posts( array(
        'name'        => $slug,
        'post_type'   => 'practice_area',
        'post_status' => 'any',
        'numberposts' => 1,
    ) );
    if ( empty( $posts ) ) {
        WP_CLI::warning( "ES pillar {$slug} not found — skipped." );
        continue;
    }
    $post = $posts[0];
    if ( 'es' !== get_post_meta( $post->ID, '_roden_locale', true ) ) {
        WP_CLI::warning( "{$slug} (ID {$post->ID}) is not _roden_locale=es — skipped." );
        continue;
    }
    update_post_meta( $post->ID, '_roden_common_injuries', $injuries );
    WP_CLI::log( sprintf( '✓ %s (ID %d) — %d injury descriptions set.', $slug, $post->ID, count( $injuries ) ) );
}

WP_CLI::success( 'ES injury descriptions fix complete.' );
