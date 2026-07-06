<?php
/**
 * ES Seeder — Batch 06: Pillar practice areas (work injuries).
 * Pillars: workers-compensation-lawyers, construction-accident-lawyers.
 *
 * Run: echo "include get_template_directory() . '/inc/es/es-seed-lib.php'; include get_template_directory() . '/inc/es/seed-es-batch-06-pillars-work.php';" | wp eval-file -
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

WP_CLI::log( '═══ ES BATCH 06 — PILLARS: WORK ═══' );

/* 1. workers-compensation-lawyers */
$en = roden_es_seed_find_pillar( 'workers-compensation-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Compensación Laboral',
        'excerpt' => 'Abogados de compensación laboral en Georgia y Carolina del Sur. Su estatus migratorio no le impide recibir beneficios. Consulta gratuita y confidencial en español.',
        'content' => <<<'HTML'
<h2>Sus derechos si se lesionó en el trabajo</h2>
<p>Si usted se lesionó en el trabajo en Georgia o Carolina del Sur, tiene derecho a beneficios de compensación laboral: atención médica pagada, una parte de sus salarios perdidos y beneficios por incapacidad permanente. Estos beneficios no dependen de quién tuvo la culpa — es un sistema sin culpa. Aun así, los empleadores y sus aseguradoras niegan o reducen reclamos válidos todos los días, y muchos trabajadores no reciben lo que la ley les garantiza.</p>
<p><strong>Importante para trabajadores inmigrantes:</strong> su estatus migratorio NO le impide recibir beneficios de compensación laboral en Georgia ni en Carolina del Sur. La ley protege a todos los trabajadores lesionados, con o sin papeles, y su consulta con nosotros es completamente confidencial. No permita que el miedo lo deje sin la atención médica y los pagos que le corresponden.</p>
<h2>Plazos: actúe rápido o pierde sus beneficios</h2>
<p>Los plazos en estos casos son cortos. En Georgia, debe reportar su lesión a su empleador dentro de 30 días y presentar su reclamo dentro de 1 año (O.C.G.A. § 34-9-82). En Carolina del Sur, debe reportar dentro de 90 días y presentar su reclamo dentro de 2 años (S.C. Code § 42-15-20). Si un tercero ajeno a su empleador causó su lesión — por ejemplo, un subcontratista o el fabricante de una máquina defectuosa — también puede tener una demanda adicional por lesiones personales.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> para una consulta gratuita en español o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Si se lesionó en una obra, visite nuestra página de <a href="/es/practice-areas/construction-accident-lawyers/">abogados de accidentes de construcción</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de compensación laboral en Georgia y Carolina del Sur. Su estatus migratorio no le impide recibir beneficios. Consulta gratis: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de compensación laboral le ayuda a obtener atención médica pagada, salarios perdidos y beneficios por incapacidad después de una lesión en el trabajo. Su estatus migratorio no le impide reclamar, y la consulta con Roden Law es gratuita y confidencial.',
            '_roden_why_hire'         => '<p>Las aseguradoras de compensación laboral buscan cerrar su caso rápido y barato: lo mandan a médicos de la compañía, minimizan sus lesiones y lo presionan para volver a trabajar antes de tiempo. En Roden Law peleamos cada etapa del reclamo — reportes, audiencias y apelaciones — y nos aseguramos de que reciba el tratamiento médico correcto y todos los beneficios que la ley le garantiza. También investigamos si un tercero causó su lesión, lo que puede darle derecho a una compensación adicional mucho mayor.</p><p>Atendemos a la comunidad hispana con consultas en español las 24 horas, y jamás compartimos su información: su consulta es confidencial sin importar su estatus migratorio. Con 62 años de experiencia combinada, más de 5,000 casos y 6 oficinas en Georgia y Carolina del Sur, no cobramos honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Caídas desde escaleras, andamios o alturas', 'Levantamiento de cargas pesadas y sobreesfuerzo', 'Accidentes con maquinaria y equipos', 'Accidentes vehiculares durante el trabajo', 'Golpes por objetos que caen', 'Exposición a sustancias químicas peligrosas' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Lesiones de espalda y hernias de disco', 'description' => 'El levantamiento repetido de cargas pesadas puede herniar los discos de la columna, causando dolor crónico que limita su capacidad de trabajar y a menudo requiere cirugía.' ),
                array( 'name' => 'Fracturas de huesos', 'description' => 'Las caídas y los accidentes con equipos causan fracturas que lo dejan sin trabajar durante semanas o meses, con derecho a atención médica pagada y parte de sus salarios.' ),
                array( 'name' => 'Lesiones por movimientos repetitivos', 'description' => 'Condiciones como el síndrome del túnel carpiano se desarrollan gradualmente por el trabajo repetido y también están cubiertas por la compensación laboral, aunque no haya un accidente único.' ),
                array( 'name' => 'Amputaciones y lesiones por aplastamiento', 'description' => 'La maquinaria industrial sin protecciones puede atrapar y aplastar manos o brazos, causando pérdidas permanentes que dan derecho a beneficios por incapacidad permanente.' ),
                array( 'name' => 'Quemaduras y lesiones químicas', 'description' => 'El contacto con sustancias químicas, superficies calientes o electricidad en el trabajo puede causar quemaduras graves que requieren tratamiento especializado prolongado y dejan cicatrices.' ),
                array( 'name' => 'Lesiones cerebrales y de la médula espinal', 'description' => 'Las caídas desde alturas y los golpes por objetos pueden causar daño cerebral o de la médula espinal, las lesiones laborales más graves y con mayores beneficios de incapacidad.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Me pueden despedir por reclamar compensación laboral?', 'answer' => 'La ley prohíbe que su empleador tome represalias contra usted por presentar un reclamo de compensación laboral de buena fe. Si lo despiden, degradan o amenazan por reclamar, puede tener derechos legales adicionales. Documente todo y consúltenos de inmediato.' ),
                array( 'question' => '¿Puedo recibir beneficios si no tengo papeles?', 'answer' => 'Sí. En Georgia y Carolina del Sur, los trabajadores lesionados tienen derecho a beneficios de compensación laboral sin importar su estatus migratorio. Su consulta con nosotros es confidencial y no compartimos su información con inmigración.' ),
                array( 'question' => '¿Qué beneficios cubre la compensación laboral?', 'answer' => 'Cubre su tratamiento médico completo, una parte de sus salarios perdidos mientras no puede trabajar (generalmente dos tercios de su salario promedio semanal, hasta un límite estatal) y beneficios por incapacidad permanente si no se recupera del todo. En casos de muerte, la familia puede recibir beneficios.' ),
                array( 'question' => 'Mi reclamo fue negado. ¿Qué puedo hacer?', 'answer' => 'Una negación no es el final del caso. Usted puede apelar ante la junta estatal de compensación laboral, y muchos reclamos negados terminan ganándose en audiencia con la evidencia médica correcta. Hay plazos estrictos para apelar, así que contáctenos pronto.' ),
                array( 'question' => '¿Puedo demandar a mi empleador por mi lesión?', 'answer' => 'Generalmente no — la compensación laboral es su remedio exclusivo contra el empleador. Pero si un tercero causó su lesión (un subcontratista, un conductor negligente o el fabricante de un equipo defectuoso), puede presentar una demanda adicional por lesiones personales que cubra el dolor y sufrimiento.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar workers-compensation-lawyers not found.' ); }

/* 2. construction-accident-lawyers */
$en = roden_es_seed_find_pillar( 'construction-accident-lawyers' );
if ( $en ) {
    roden_es_seed_translation( $en->ID, array(
        'title'   => 'Abogados de Accidentes de Construcción',
        'excerpt' => 'Abogados de accidentes de construcción en Georgia y Carolina del Sur. Protegemos a los trabajadores lesionados en obras, sin importar su estatus migratorio. Consulta gratuita en español.',
        'content' => <<<'HTML'
<h2>Lesiones en obras de construcción</h2>
<p>La construcción es una de las industrias más peligrosas del país, y los trabajadores hispanos sufren una parte desproporcionada de las lesiones graves. Caídas de andamios, electrocuciones, golpes por objetos que caen, zanjas que colapsan, maquinaria sin protecciones — cuando una obra no cumple con las normas de seguridad de OSHA, los trabajadores pagan las consecuencias. Los abogados de accidentes de construcción de Roden Law investigan quién falló y reclaman toda la compensación que la ley permite.</p>
<p><strong>Si usted es trabajador inmigrante, escuche esto:</strong> su estatus migratorio NO le impide recibir beneficios de compensación laboral ni compensación por sus lesiones. La consulta es confidencial. Muchos trabajadores lesionados no reclaman por miedo, y las compañías cuentan con ese silencio. Usted tiene derechos, y nosotros los hacemos valer en su idioma.</p>
<h2>Compensación laboral y demandas contra terceros</h2>
<p>Después de un accidente en la obra, usted normalmente tiene un reclamo de compensación laboral contra su empleador: en Georgia debe reportar la lesión en 30 días y presentar el reclamo en 1 año (O.C.G.A. § 34-9-82); en Carolina del Sur, reportar en 90 días y presentar en 2 años (S.C. Code § 42-15-20). Pero en las obras suele haber más responsables: el contratista general, otros subcontratistas, el dueño del proyecto o el fabricante de un equipo defectuoso. Contra esos terceros puede presentar una demanda por lesiones personales — con plazo de 2 años (O.C.G.A. § 9-3-33) en Georgia y 3 años (S.C. Code § 15-3-530) en Carolina del Sur — que cubre el dolor y sufrimiento que la compensación laboral no paga.</p>
<p><a href="/es/contact/">Contáctenos hoy</a> o llame al <a href="tel:+18447378587">1-844-RESULTS</a>. Conozca también sus derechos de <a href="/es/practice-areas/workers-compensation-lawyers/">compensación laboral</a>.</p>
HTML,
        'meta'    => array(
            '_roden_meta_description' => 'Abogados de accidentes de construcción en Georgia y Carolina del Sur. Su estatus migratorio no le quita sus derechos. Consulta gratis: 1-844-RESULTS.',
            '_roden_hero_intro'       => 'Un abogado de accidentes de construcción reclama compensación laboral y demanda a los contratistas o fabricantes responsables cuando usted se lesiona en una obra. Su estatus migratorio no le impide reclamar — la consulta con Roden Law es gratuita y confidencial.',
            '_roden_why_hire'         => '<p>Los accidentes de construcción casi nunca tienen un solo responsable. En Roden Law investigamos toda la cadena: si el contratista general violó normas de OSHA, si un subcontratista creó el peligro, si el equipo era defectuoso. Esa investigación importa, porque la compensación laboral solo paga una parte de sus salarios — mientras que una demanda contra un tercero puede cubrir el dolor y sufrimiento y la totalidad de sus ingresos perdidos. Trabajamos con expertos en seguridad de obras y una red de expertos médicos para documentar el valor completo de su caso.</p><p>Servimos a la comunidad trabajadora hispana de Georgia y Carolina del Sur con consultas en español las 24 horas, siempre confidenciales sin importar su estatus migratorio. Más de $300 millones recuperados, 5,000+ casos, 6 oficinas — y sin honorarios a menos que ganemos. Llame al 1-844-RESULTS.</p>',
            '_roden_common_causes'    => array( 'Caídas desde andamios, techos y escaleras', 'Zanjas y excavaciones que colapsan', 'Electrocuciones por cables expuestos', 'Golpes por objetos y materiales que caen', 'Maquinaria pesada sin protecciones adecuadas', 'Falta de equipo de seguridad o entrenamiento' ),
            '_roden_common_injuries'  => array(
                array( 'name' => 'Lesiones cerebrales traumáticas', 'description' => 'Las caídas desde alturas y los golpes por materiales que caen pueden causar daño cerebral permanente, incluso cuando el trabajador llevaba puesto el casco de seguridad.' ),
                array( 'name' => 'Fracturas múltiples y lesiones por aplastamiento', 'description' => 'Los colapsos de zanjas y los accidentes con maquinaria pesada pueden aplastar extremidades y fracturar varios huesos a la vez, exigiendo cirugías y meses de recuperación.' ),
                array( 'name' => 'Lesiones de la médula espinal y parálisis', 'description' => 'Una caída desde un andamio o un techo puede dañar la médula espinal y causar parálisis permanente, con necesidad de cuidados y adaptaciones de por vida.' ),
                array( 'name' => 'Amputaciones', 'description' => 'Las sierras, la maquinaria sin protecciones y los equipos pesados de la obra pueden causar la pérdida de dedos, manos o extremidades completas.' ),
                array( 'name' => 'Quemaduras eléctricas y químicas', 'description' => 'El contacto con cables energizados o sustancias corrosivas en la obra causa quemaduras profundas que dañan tejidos internos y suelen requerir injertos de piel.' ),
                array( 'name' => 'Lesiones graves de espalda y hombros', 'description' => 'Cargar materiales pesados y las caídas en la obra provocan desgarros y hernias en la espalda y los hombros que pueden impedirle volver al trabajo de construcción.' ),
            ),
            '_roden_faqs'             => array(
                array( 'question' => '¿Puedo reclamar si no tengo papeles?', 'answer' => 'Sí. En Georgia y Carolina del Sur, su estatus migratorio no le impide recibir beneficios de compensación laboral ni compensación por sus lesiones en una demanda. Su consulta con nosotros es confidencial. No deje que el miedo le cueste la atención médica y el dinero que le corresponden.' ),
                array( 'question' => '¿Quién es responsable de mi accidente en la obra?', 'answer' => 'Depende de quién creó el peligro. Puede ser su empleador (a través de la compensación laboral), el contratista general, otro subcontratista, el dueño del proyecto o el fabricante de un equipo defectuoso. Investigamos a todas las partes porque cada una puede deberle compensación.' ),
                array( 'question' => '¿Qué diferencia hay entre compensación laboral y una demanda?', 'answer' => 'La compensación laboral paga su tratamiento médico y parte de sus salarios sin importar la culpa, pero no paga dolor y sufrimiento. Una demanda contra un tercero responsable puede cubrir la totalidad de sus pérdidas. En muchos casos de construcción se pueden hacer las dos cosas a la vez.' ),
                array( 'question' => '¿Qué debo hacer después de un accidente en la obra?', 'answer' => 'Busque atención médica de inmediato y reporte la lesión a su supervisor por escrito lo antes posible — en Georgia tiene 30 días y en Carolina del Sur 90 días para reportar. Tome fotos del lugar si puede, anote los nombres de los testigos y no firme documentos de la aseguradora antes de hablar con un abogado.' ),
                array( 'question' => '¿Cuánto cuesta contratar a un abogado?', 'answer' => 'Nada por adelantado. Trabajamos con honorarios de contingencia: solo cobramos si recuperamos beneficios o compensación para usted. La consulta es gratuita, en español y sin ningún compromiso.' ),
            ),
        ),
    ) );
} else { WP_CLI::warning( 'EN pillar construction-accident-lawyers not found.' ); }

WP_CLI::log( '═══ BATCH 06 DONE ═══' );
