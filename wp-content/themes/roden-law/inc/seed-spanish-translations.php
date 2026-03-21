<?php
/**
 * Seeder: Spanish (ES) Translations via Polylang
 *
 * Creates Spanish translation posts for:
 *   - Homepage (static front page)
 *   - 5 Location pages
 *   - Top pillar practice area pages
 *
 * For each English post, the script:
 *   1. Creates a Spanish clone with translated title/excerpt
 *   2. Copies all meta fields (_roden_* keys)
 *   3. Copies taxonomy terms
 *   4. Links EN ↔ ES via Polylang API
 *
 * Run via WP-CLI:
 *   wp eval-file wp-content/themes/roden-law/inc/seed-spanish-translations.php
 *
 * Idempotent — skips posts that already have a Spanish translation linked.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ------------------------------------------------------------------
   Preflight: Polylang must be active with Spanish configured
   ------------------------------------------------------------------ */

if ( ! function_exists( 'pll_set_post_language' ) ) {
    WP_CLI::error( 'Polylang is not active. Install and activate Polylang first.' );
    return;
}

if ( ! function_exists( 'pll_save_post_translations' ) ) {
    WP_CLI::error( 'Polylang API not available (pll_save_post_translations missing).' );
    return;
}

// Verify Spanish language exists in Polylang
$languages = pll_languages_list( array( 'fields' => 'slug' ) );
if ( ! in_array( 'es', $languages, true ) ) {
    WP_CLI::error( 'Spanish (es) language not found in Polylang. Add it under Settings > Languages first.' );
    return;
}

WP_CLI::log( 'Polylang active. Languages: ' . implode( ', ', $languages ) );

/* ------------------------------------------------------------------
   Translation data: titles, excerpts, and intro content in Spanish
   ------------------------------------------------------------------ */

$translations = array(

    // ── Homepage (static front page) ──────────────────────────────
    'homepage' => array(
        'title'   => 'Abogados de Lesiones Personales en Georgia y Carolina del Sur',
        'excerpt' => 'Roden Law es un bufete de abogados de lesiones personales con oficinas en Savannah, Charleston, Columbia, Myrtle Beach y Darien. Más de $250 millones recuperados. Consulta gratuita.',
        'content' => <<<'HTML'
<h2>Abogados de Lesiones Personales — Sirviendo Georgia y Carolina del Sur</h2>
<p>En Roden Law, luchamos por los derechos de las víctimas de lesiones personales en todo Georgia y Carolina del Sur. Con más de $250 millones recuperados para nuestros clientes, nuestro equipo de abogados experimentados está listo para ayudarle a obtener la compensación que merece.</p>
<p>No cobramos honorarios a menos que ganemos su caso. Llame hoy para una consulta gratuita: <strong>1-844-RESULTS</strong>.</p>
<p><strong>5 oficinas</strong> para servirle mejor — Savannah, Charleston, Columbia, Myrtle Beach y Darien.</p>
HTML,
    ),

    // ── Location pages ────────────────────────────────────────────
    'locations' => array(
        'savannah-ga' => array(
            'title'   => 'Abogados de Lesiones Personales en Savannah, GA',
            'excerpt' => 'Abogados de lesiones personales en Savannah, Georgia. Oficina en 333 Commercial Dr. Consulta gratuita. Llame al (912) 303-5850.',
            'content' => <<<'HTML'
<h2>Abogados de Lesiones Personales en Savannah</h2>
<p>Nuestra oficina de Savannah sirve a clientes en todo el sureste de Georgia, incluyendo Pooler, Richmond Hill, Hinesville, Statesboro, Brunswick y las comunidades circundantes. Si usted o un ser querido ha sido lesionado en un accidente, nuestros abogados están listos para luchar por la compensación que merece.</p>
<p>Ubicados en 333 Commercial Dr., Savannah, GA 31406. Llámenos al <strong>(912) 303-5850</strong> para una consulta gratuita.</p>
HTML,
        ),
        'darien-ga' => array(
            'title'   => 'Abogados de Lesiones Personales en Darien, GA',
            'excerpt' => 'Abogados de lesiones personales en Darien, Georgia. Oficina en 1108 North Way. Consulta gratuita. Llame al (912) 303-5850.',
            'content' => <<<'HTML'
<h2>Abogados de Lesiones Personales en Darien</h2>
<p>Nuestra oficina de Darien sirve a clientes en la costa sureste de Georgia, incluyendo Brunswick, St. Simons Island, Jekyll Island, Waycross y las comunidades circundantes. Nuestros abogados entienden las leyes locales y están comprometidos a obtener resultados para las víctimas de lesiones.</p>
<p>Ubicados en 1108 North Way, Darien, GA 31305. Llámenos al <strong>(912) 303-5850</strong> para una consulta gratuita.</p>
HTML,
        ),
        'charleston-sc' => array(
            'title'   => 'Abogados de Lesiones Personales en Charleston, SC',
            'excerpt' => 'Abogados de lesiones personales en Charleston, Carolina del Sur. Oficina en 127 King Street. Consulta gratuita. Llame al (843) 790-8999.',
            'content' => <<<'HTML'
<h2>Abogados de Lesiones Personales en Charleston</h2>
<p>Nuestra oficina de Charleston sirve a clientes en todo el Lowcountry, incluyendo North Charleston, Summerville, Mount Pleasant, Goose Creek y las comunidades circundantes. Si ha sufrido una lesión por la negligencia de otra persona, estamos aquí para ayudarle.</p>
<p>Ubicados en 127 King Street, Suite 200, Charleston, SC 29401. Llámenos al <strong>(843) 790-8999</strong> para una consulta gratuita.</p>
HTML,
        ),
        'columbia-sc' => array(
            'title'   => 'Abogados de Lesiones Personales en Columbia, SC',
            'excerpt' => 'Abogados de lesiones personales en Columbia, Carolina del Sur. Oficina en 1545 Sumter St. Consulta gratuita. Llame al (803) 219-2816.',
            'content' => <<<'HTML'
<h2>Abogados de Lesiones Personales en Columbia</h2>
<p>Nuestra oficina de Columbia sirve a clientes en la región central de Carolina del Sur, incluyendo Lexington, Irmo, West Columbia, Cayce, Forest Acres y las comunidades circundantes. Nuestros abogados tienen experiencia con los tribunales locales y luchan agresivamente por sus derechos.</p>
<p>Ubicados en 1545 Sumter St., Suite B, Columbia, SC 29201. Llámenos al <strong>(803) 219-2816</strong> para una consulta gratuita.</p>
HTML,
        ),
        'myrtle-beach-sc' => array(
            'title'   => 'Abogados de Lesiones Personales en Myrtle Beach, SC',
            'excerpt' => 'Abogados de lesiones personales en Myrtle Beach, Carolina del Sur. Oficina en 631 Bellamy Ave. Consulta gratuita. Llame al (843) 612-1980.',
            'content' => <<<'HTML'
<h2>Abogados de Lesiones Personales en Myrtle Beach</h2>
<p>Nuestra oficina de Myrtle Beach sirve a clientes en toda la región de Grand Strand, incluyendo Murrells Inlet, Conway, Surfside Beach, Pawleys Island y las comunidades circundantes. Ya sea un accidente de auto, una caída, o cualquier otra lesión, nuestros abogados están listos para ayudarle.</p>
<p>Ubicados en 631 Bellamy Ave., Suite C-B, Murrells Inlet, SC 29576. Llámenos al <strong>(843) 612-1980</strong> para una consulta gratuita.</p>
HTML,
        ),
    ),

    // ── Top pillar practice area pages ────────────────────────────
    'pillars' => array(
        'car-accident-lawyers' => array(
            'title'   => 'Abogados de Accidentes de Auto',
            'excerpt' => 'Abogados de accidentes de auto en Georgia y Carolina del Sur. Más de $250 millones recuperados. Sin honorarios a menos que ganemos. Consulta gratuita.',
            'content' => <<<'HTML'
<h2>Abogados de Accidentes de Auto en Georgia y Carolina del Sur</h2>
<p>Los accidentes de auto son la causa principal de lesiones personales en Georgia y Carolina del Sur. En Roden Law, nuestros abogados de accidentes automovilísticos han recuperado millones de dólares para víctimas de choques causados por conductores negligentes, distraídos o ebrios.</p>
<p>Si usted o un ser querido ha sido lesionado en un accidente de auto, no espere para buscar ayuda legal. En Georgia, tiene <strong>2 años</strong> para presentar una demanda (O.C.G.A. § 9-3-33). En Carolina del Sur, tiene <strong>3 años</strong> (S.C. Code § 15-3-530). Llame hoy para una consulta gratuita.</p>
HTML,
        ),
        'truck-accident-lawyers' => array(
            'title'   => 'Abogados de Accidentes de Camiones',
            'excerpt' => 'Abogados de accidentes de camiones en Georgia y Carolina del Sur. Luchamos contra las compañías de camiones y sus aseguradoras. Consulta gratuita.',
            'content' => <<<'HTML'
<h2>Abogados de Accidentes de Camiones en Georgia y Carolina del Sur</h2>
<p>Los accidentes con camiones comerciales causan algunas de las lesiones más devastadoras en nuestras carreteras. Estos casos son complejos e involucran regulaciones federales, múltiples partes responsables y compañías de seguros agresivas. Nuestros abogados tienen la experiencia para enfrentar a las grandes compañías de camiones y obtener la compensación que usted merece.</p>
<p>Si ha sido lesionado en un accidente con un camión de 18 ruedas, camión de reparto, o cualquier vehículo comercial, llame a Roden Law para una consulta gratuita.</p>
HTML,
        ),
        'wrongful-death-lawyers' => array(
            'title'   => 'Abogados de Muerte por Negligencia',
            'excerpt' => 'Abogados de muerte por negligencia en Georgia y Carolina del Sur. Ayudamos a familias a obtener justicia y compensación. Consulta gratuita.',
            'content' => <<<'HTML'
<h2>Abogados de Muerte por Negligencia en Georgia y Carolina del Sur</h2>
<p>Perder a un ser querido por la negligencia de otra persona es devastador. Nuestros abogados de muerte por negligencia ayudan a las familias en duelo a obtener justicia y la compensación financiera que necesitan. Manejamos estos casos con compasión y determinación, luchando para responsabilizar a los culpables.</p>
<p>En Georgia, una demanda por muerte por negligencia debe ser presentada dentro de <strong>2 años</strong> (O.C.G.A. § 51-4-1). En Carolina del Sur, el plazo es de <strong>3 años</strong> (S.C. Code § 15-3-530). No espere — contacte a nuestro equipo hoy.</p>
HTML,
        ),
        'workers-compensation-lawyers' => array(
            'title'   => 'Abogados de Compensación Laboral',
            'excerpt' => 'Abogados de compensación laboral (workers comp) en Georgia y Carolina del Sur. Lo ayudamos a obtener sus beneficios. Consulta gratuita.',
            'content' => <<<'HTML'
<h2>Abogados de Compensación Laboral en Georgia y Carolina del Sur</h2>
<p>Si usted se lesionó en el trabajo, tiene derecho a beneficios de compensación laboral (workers' compensation). Nuestros abogados ayudan a trabajadores lesionados en Georgia y Carolina del Sur a obtener cobertura médica, salarios perdidos, y beneficios por incapacidad. No permita que su empleador o su aseguradora le nieguen los beneficios que merece.</p>
<p>En Georgia, debe reportar su lesión dentro de <strong>30 días</strong> y presentar su reclamo dentro de <strong>1 año</strong> (O.C.G.A. § 34-9-82). En Carolina del Sur, tiene <strong>90 días</strong> para reportar y <strong>2 años</strong> para presentar (S.C. Code § 42-15-20). Llame hoy para proteger sus derechos.</p>
HTML,
        ),
        'slip-and-fall-lawyers' => array(
            'title'   => 'Abogados de Accidentes por Caídas',
            'excerpt' => 'Abogados de accidentes por resbalones y caídas en Georgia y Carolina del Sur. Responsabilizamos a propietarios negligentes. Consulta gratuita.',
            'content' => <<<'HTML'
<h2>Abogados de Accidentes por Caídas en Georgia y Carolina del Sur</h2>
<p>Los accidentes por resbalones y caídas pueden causar lesiones graves, incluyendo fracturas de huesos, lesiones de espalda, lesiones cerebrales traumáticas, y más. Cuando un propietario no mantiene su propiedad en condiciones seguras, puede ser responsable de sus lesiones. Nuestros abogados investigan cada caso a fondo para demostrar la negligencia del propietario.</p>
<p>No espere para actuar. Llame a Roden Law para una consulta gratuita y sin compromiso.</p>
HTML,
        ),
        'motorcycle-accident-lawyers' => array(
            'title'   => 'Abogados de Accidentes de Motocicleta',
            'excerpt' => 'Abogados de accidentes de motocicleta en Georgia y Carolina del Sur. Luchamos por los derechos de los motociclistas. Consulta gratuita.',
            'content' => <<<'HTML'
<h2>Abogados de Accidentes de Motocicleta en Georgia y Carolina del Sur</h2>
<p>Los motociclistas enfrentan riesgos únicos en las carreteras. Cuando un conductor negligente causa un accidente con una motocicleta, las lesiones suelen ser devastadoras. Las compañías de seguros frecuentemente intentan culpar al motociclista. Nuestros abogados conocen estas tácticas y saben cómo combatirlas para obtener la compensación justa que usted merece.</p>
<p>Si ha sido lesionado en un accidente de motocicleta, contacte a Roden Law para una consulta gratuita.</p>
HTML,
        ),
        'medical-malpractice-lawyers' => array(
            'title'   => 'Abogados de Negligencia Médica',
            'excerpt' => 'Abogados de negligencia médica (malpractice) en Georgia y Carolina del Sur. Responsabilizamos a doctores y hospitales negligentes. Consulta gratuita.',
            'content' => <<<'HTML'
<h2>Abogados de Negligencia Médica en Georgia y Carolina del Sur</h2>
<p>Cuando un profesional médico no cumple con el estándar de cuidado, los resultados pueden ser catastróficos. Nuestros abogados de negligencia médica manejan casos de errores quirúrgicos, diagnósticos incorrectos, errores de medicación, lesiones de parto, y más. Trabajamos con expertos médicos para construir casos sólidos y obtener la compensación que nuestros clientes merecen.</p>
<p>Los casos de negligencia médica tienen requisitos especiales. En Georgia, debe presentar una declaración jurada de experto con su demanda (O.C.G.A. § 9-11-9.1). Llame hoy para discutir su caso.</p>
HTML,
        ),
        'dog-bite-lawyers' => array(
            'title'   => 'Abogados de Mordeduras de Perro',
            'excerpt' => 'Abogados de mordeduras de perro en Georgia y Carolina del Sur. Obtenemos compensación por ataques de animales. Consulta gratuita.',
            'content' => <<<'HTML'
<h2>Abogados de Mordeduras de Perro en Georgia y Carolina del Sur</h2>
<p>Las mordeduras de perro pueden causar lesiones graves, cicatrices permanentes, infecciones y trauma emocional. Los dueños de perros son responsables cuando sus animales atacan. Nuestros abogados ayudan a las víctimas de mordeduras de perro a obtener compensación por gastos médicos, cirugías reconstructivas, salarios perdidos y dolor y sufrimiento.</p>
<p>En Georgia, la ley de responsabilidad por perros (O.C.G.A. § 51-2-7) responsabiliza a los dueños cuando saben que su perro es peligroso. Contacte a Roden Law para una consulta gratuita.</p>
HTML,
        ),
    ),
);

/* ------------------------------------------------------------------
   Helper: Create a Spanish translation for a given EN post
   ------------------------------------------------------------------ */

function roden_create_es_translation( $en_post_id, $es_data, $post_type = null ) {

    // Check if a Spanish translation already exists
    $existing_es = pll_get_post( $en_post_id, 'es' );
    if ( $existing_es ) {
        WP_CLI::log( "  ⤷ SKIP — Spanish translation already exists (ID {$existing_es})" );
        return $existing_es;
    }

    $en_post = get_post( $en_post_id );
    if ( ! $en_post ) {
        WP_CLI::warning( "  ⤷ EN post ID {$en_post_id} not found." );
        return false;
    }

    $type = $post_type ?: $en_post->post_type;

    // Create the Spanish post
    $es_post_data = array(
        'post_title'   => $es_data['title'],
        'post_name'    => $en_post->post_name, // Same slug — Polylang handles /es/ prefix
        'post_content' => $es_data['content'] ?? $en_post->post_content,
        'post_excerpt' => $es_data['excerpt'] ?? $en_post->post_excerpt,
        'post_status'  => 'publish',
        'post_type'    => $type,
        'post_parent'  => $en_post->post_parent,
        'menu_order'   => $en_post->menu_order,
    );

    $es_post_id = wp_insert_post( $es_post_data, true );

    if ( is_wp_error( $es_post_id ) ) {
        WP_CLI::warning( "  ⤷ FAILED to create ES post: " . $es_post_id->get_error_message() );
        return false;
    }

    // Set language to Spanish
    pll_set_post_language( $es_post_id, 'es' );

    // Ensure EN post is tagged as English (Polylang may not have set this yet)
    pll_set_post_language( $en_post_id, 'en' );

    // Link the two translations together
    pll_save_post_translations( array(
        'en' => $en_post_id,
        'es' => $es_post_id,
    ) );

    // Copy all _roden_* meta fields from EN to ES
    $meta = get_post_meta( $en_post_id );
    foreach ( $meta as $key => $values ) {
        if ( strpos( $key, '_roden_' ) === 0 ) {
            foreach ( $values as $value ) {
                update_post_meta( $es_post_id, $key, maybe_unserialize( $value ) );
            }
        }
    }

    // Copy featured image
    $thumb_id = get_post_thumbnail_id( $en_post_id );
    if ( $thumb_id ) {
        set_post_thumbnail( $es_post_id, $thumb_id );
    }

    // Copy taxonomy terms (practice_category, location_served)
    $taxonomies = array( 'practice_category', 'location_served' );
    foreach ( $taxonomies as $tax ) {
        if ( taxonomy_exists( $tax ) ) {
            $terms = wp_get_object_terms( $en_post_id, $tax, array( 'fields' => 'ids' ) );
            if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
                wp_set_object_terms( $es_post_id, $terms, $tax );
            }
        }
    }

    WP_CLI::success( "  ⤷ Created ES translation: \"{$es_data['title']}\" (ID {$es_post_id})" );
    return $es_post_id;
}

/* ------------------------------------------------------------------
   1. Translate the Homepage (static front page)
   ------------------------------------------------------------------ */

WP_CLI::log( '' );
WP_CLI::log( '═══ HOMEPAGE ═══' );

$front_page_id = (int) get_option( 'page_on_front' );
if ( $front_page_id ) {
    WP_CLI::log( "EN Homepage: ID {$front_page_id}" );
    roden_create_es_translation( $front_page_id, $translations['homepage'], 'page' );
} else {
    WP_CLI::warning( 'No static front page set (Settings > Reading). Skipping homepage.' );
}

/* ------------------------------------------------------------------
   2. Translate Location pages
   ------------------------------------------------------------------ */

WP_CLI::log( '' );
WP_CLI::log( '═══ LOCATION PAGES ═══' );

foreach ( $translations['locations'] as $slug => $es_data ) {
    // Location slugs may include state path, try both formats
    $en_post = get_page_by_path( $slug, OBJECT, 'location' );

    if ( ! $en_post ) {
        // Try with state prefix: georgia/savannah-ga, south-carolina/charleston-sc
        $state_map = array(
            'savannah-ga'    => 'georgia/savannah-ga',
            'darien-ga'      => 'georgia/darien-ga',
            'charleston-sc'  => 'south-carolina/charleston-sc',
            'columbia-sc'    => 'south-carolina/columbia-sc',
            'myrtle-beach-sc' => 'south-carolina/myrtle-beach-sc',
        );
        if ( isset( $state_map[ $slug ] ) ) {
            $en_post = get_page_by_path( $state_map[ $slug ], OBJECT, 'location' );
        }
    }

    if ( ! $en_post ) {
        WP_CLI::warning( "Location \"{$slug}\" not found. Skipping." );
        continue;
    }

    WP_CLI::log( "EN Location: \"{$en_post->post_title}\" (ID {$en_post->ID})" );
    roden_create_es_translation( $en_post->ID, $es_data );
}

/* ------------------------------------------------------------------
   3. Translate top pillar Practice Area pages
   ------------------------------------------------------------------ */

WP_CLI::log( '' );
WP_CLI::log( '═══ PILLAR PRACTICE AREA PAGES ═══' );

// Determine post type slug
$pa_post_type = post_type_exists( 'practice_area' ) ? 'practice_area' : 'practice-area';
if ( ! post_type_exists( $pa_post_type ) ) {
    WP_CLI::error( 'Practice area post type not registered.' );
    return;
}

foreach ( $translations['pillars'] as $slug => $es_data ) {
    $en_post = get_page_by_path( $slug, OBJECT, $pa_post_type );

    if ( ! $en_post ) {
        WP_CLI::warning( "Pillar \"{$slug}\" not found. Skipping." );
        continue;
    }

    WP_CLI::log( "EN Pillar: \"{$en_post->post_title}\" (ID {$en_post->ID})" );
    roden_create_es_translation( $en_post->ID, $es_data );
}

/* ------------------------------------------------------------------
   Summary
   ------------------------------------------------------------------ */

WP_CLI::log( '' );
WP_CLI::log( '═══ DONE ═══' );
WP_CLI::log( 'Spanish translations seeded. Next steps:' );
WP_CLI::log( '  1. Verify pages in WP Admin — each EN post should show an ES flag link' );
WP_CLI::log( '  2. Review/refine Spanish content in the editor' );
WP_CLI::log( '  3. Flush permalinks: wp rewrite flush' );
WP_CLI::log( '  4. Test the EN/ES toggle in the header' );
