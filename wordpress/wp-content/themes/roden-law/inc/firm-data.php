<?php
/**
 * Central Firm Data Configuration
 *
 * Single source of truth for all firm data. Every template, schema output,
 * and helper function pulls from roden_firm_data(). Includes offices,
 * attorneys, trust stats, social links, jurisdiction law data, and the
 * canonical list of 18 practice area pillar slugs.
 *
 * @package Roden_Law
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return all firm data as a single associative array.
 *
 * @return array Firm data including offices, attorneys, stats, social, jurisdiction, and practice areas.
 */
function roden_firm_data() {
    $data = array(
        'name'         => 'Roden Law',
        'legal_entity' => 'Roden Law',
        'vanity_phone' => '844-RESULTS',
        'phone_raw'    => '+18447378587',
        'url'          => home_url(),
        'description'  => 'Personal injury law firm serving Georgia and South Carolina with over $300 million recovered for injured clients.',
        'licensed_in'  => array( 'Georgia', 'South Carolina' ),
        'founded'      => '2013',

        /* ==================================================================
           OFFICES — 6 Locations
           ================================================================== */

        'offices' => array(
            'savannah' => array(
                'name'         => 'Roden Law — Savannah',
                'street'       => '333 Commercial Dr.',
                'city'         => 'Savannah',
                'state'        => 'GA',
                'state_full'   => 'Georgia',
                'zip'          => '31406',
                'phone'        => '(912) 303-5850',
                'phone_raw'    => '+19123035850',
                'gbp_url'      => 'https://share.google/pf1cxsIxuXgHTWwl2',
                'yelp_url'     => '',
                'latitude'     => 32.004624,
                'longitude'    => -81.108187,
                'timezone'     => 'America/New_York',
                'court'        => 'Chatham County Superior Court',
                'court_address'=> '133 Montgomery St., Savannah, GA 31401',
                'slug'         => 'savannah-ga',
                'state_slug'   => 'georgia',
                'service_area' => 'Savannah, Pooler, Richmond Hill, Hinesville, Statesboro, Brunswick, and surrounding Southeast Georgia communities.',
                'attorneys'    => array( 'eric-roden', 'tyler-love' ),
                'nearby_communities' => array(
                    'Pooler', 'Richmond Hill', 'Hinesville', 'Garden City',
                    'Port Wentworth', 'Tybee Island', 'Bloomingdale',
                    'Georgetown', 'Thunderbolt', 'Wilmington Island',
                ),
                'directions'   => 'Our Savannah office is located on Commercial Drive, just off Abercorn Street near Oglethorpe Mall. From I-16 East, take Exit 164A onto I-516 E/DeRenne Ave, then turn south on Abercorn St. From I-95, take Exit 94 onto GA-204 E (Abercorn St) toward Savannah. Free client parking is available in our building lot.',
                // Local context essay — rendered as "Filing a Personal Injury Case in {market}"
                // section on every intersection page for this office (template-intersection.php).
                // 150-250 words of court process, local hazards, and state-specific filing notes.
                'local_context' => <<<'EOT'
Filing a personal injury case in Savannah means filing in **Chatham County Superior Court at 133 Montgomery Street**, where civil complaints are submitted electronically through **PeachCourt eFileGA**, Georgia's statewide e-filing system. Georgia law gives an injured person **two years from the crash date** to file under O.C.G.A. § 9-3-33, and Georgia's modified comparative negligence rule (O.C.G.A. § 51-12-33) bars recovery only if the plaintiff is 50% or more at fault.

Local injury patterns reflect Savannah's role as a port city: I-95 through Pooler, I-516 from the Port of Savannah, and the I-16/I-95 interchange concentrate commercial-truck crashes, while DeRenne Avenue, Abercorn Street (SR 204), and the historic downtown grid generate persistent pedestrian and intersection collisions. Seriously injured victims across southeast Georgia are routed to **Memorial Health University Medical Center on Waters Avenue** — the region's only Level I trauma center — frequently arriving by LifeStar helicopter.

Two Georgia rules matter most for Savannah cases: **O.C.G.A. § 33-7-11** allows "added-on" UM/UIM stacking above the at-fault driver's limits, and **O.C.G.A. § 40-1-112** permits direct action against a motor carrier's insurer — a meaningful advantage in port-related truck-crash litigation.
EOT
,
                'local_context_es' => <<<'EOT'
Presentar un caso de lesiones personales en Savannah significa presentarlo ante el **Chatham County Superior Court, ubicado en 133 Montgomery Street**, donde las demandas civiles se presentan electrónicamente a través de **PeachCourt eFileGA**, el sistema estatal de presentación electrónica de Georgia. La ley de Georgia otorga a la persona lesionada **dos años a partir de la fecha del accidente** para presentar la demanda conforme a O.C.G.A. § 9-3-33, y la regla de negligencia comparativa modificada de Georgia (O.C.G.A. § 51-12-33) impide la recuperación únicamente si el demandante tiene un 50% o más de culpa.

Los patrones locales de lesiones reflejan el papel de Savannah como ciudad portuaria: la I-95 a la altura de Pooler, la I-516 desde el Port of Savannah y el intercambiador de la I-16/I-95 concentran los choques de camiones comerciales, mientras que DeRenne Avenue, Abercorn Street (SR 204) y la cuadrícula del centro histórico generan colisiones constantes de peatones y en intersecciones. Las víctimas con lesiones graves de todo el sureste de Georgia son trasladadas al **Memorial Health University Medical Center, en Waters Avenue** — el único centro de trauma de Nivel I de la región — y con frecuencia llegan a bordo del helicóptero LifeStar.

Dos reglas de Georgia son las que más pesan en los casos de Savannah: **O.C.G.A. § 33-7-11** permite la acumulación ("stacking") adicional de cobertura UM/UIM por encima de los límites del conductor culpable, y **O.C.G.A. § 40-1-112** permite demandar directamente a la aseguradora del transportista — una ventaja significativa en litigios de choques de camiones vinculados al puerto.
EOT
,
                // GBP review count — powers per-office AggregateRating schema.
                // VERIFY: pulled from Birdeye/Google Apr 2026. Update quarterly from GBP dashboard.
                'review_count' => 58,
                'review_rating' => '4.9',
            ),
            'darien' => array(
                'name'         => 'Roden Law — Darien',
                'street'       => '1108 North Way',
                'city'         => 'Darien',
                'state'        => 'GA',
                'state_full'   => 'Georgia',
                'zip'          => '31305',
                'phone'        => '(912) 303-5850',
                'phone_raw'    => '+19123035850',
                'gbp_url'      => 'https://share.google/WEJrZTzNzPAtkQ0xw',
                'yelp_url'     => '',
                'latitude'     => 31.378489,
                'longitude'    => -81.433499,
                'timezone'     => 'America/New_York',
                'court'        => 'McIntosh County Superior Court',
                'court_address'=> '310 Northway, Darien, GA 31305',
                'slug'         => 'darien-ga',
                'state_slug'   => 'georgia',
                'service_area' => 'Darien, Brunswick, St. Simons Island, Jekyll Island, Waycross, and surrounding Southeast Georgia coastal communities.',
                'attorneys'    => array( 'joshua-dorminy' ),
                'nearby_communities' => array(
                    'Brunswick', 'St. Simons Island', 'Jekyll Island', 'Waycross',
                    'Jesup', 'Townsend', 'Meridian', 'Eulonia',
                    'South Newport', 'Crescent',
                ),
                'directions'   => 'Our Darien office is on North Way, conveniently located near the I-95/US-17 interchange in McIntosh County. From I-95, take Exit 49 (GA-251) toward Darien and head east on North Way. From Brunswick, take US-17 North approximately 16 miles. The office is easily accessible from the Golden Isles and surrounding coastal communities.',
                'local_context' => <<<'EOT'
Filing a personal injury case in Darien means filing in **McIntosh County Superior Court at 310 Northway** — part of the Brunswick Judicial Circuit and the trial forum for all PI cases above the magistrate-court limit. Civil complaints are submitted through **PeachCourt eFileGA**, Georgia's statewide e-filing system. Georgia gives injured plaintiffs **two years to file under O.C.G.A. § 9-3-33**, and the modified-comparative-negligence rule in O.C.G.A. § 51-12-33 bars recovery if the plaintiff is 50% or more at fault.

McIntosh County's crash profile is dominated by two corridors: roughly 18 miles of **I-95** (Exits 49 and 58 are the principal crash-cluster interchanges) and **US-17 / SR 251**, which carry logging trucks bound for coastal mills and serve as hurricane-evacuation routes. Because McIntosh has no Level I trauma center, seriously injured victims are typically flown by LifeStar to **Memorial Health University Medical Center in Savannah** — the only Level I trauma center in southeast Georgia.

Two Georgia statutes carry outsized weight in this county's truck-heavy docket: **O.C.G.A. § 33-7-11** allows "added-on" UM/UIM stacking above the at-fault driver's limits, and **O.C.G.A. § 40-1-112** permits direct action against a motor carrier's insurer.
EOT
,
                'local_context_es' => <<<'EOT'
Presentar un caso de lesiones personales en Darien significa presentarlo ante el **McIntosh County Superior Court, ubicado en 310 Northway** — parte del Brunswick Judicial Circuit y el foro de juicio para todos los casos de lesiones personales que superan el límite del tribunal de magistrados. Las demandas civiles se presentan a través de **PeachCourt eFileGA**, el sistema estatal de presentación electrónica de Georgia. Georgia otorga a los demandantes lesionados **dos años para presentar la demanda conforme a O.C.G.A. § 9-3-33**, y la regla de negligencia comparativa modificada de O.C.G.A. § 51-12-33 impide la recuperación si el demandante tiene un 50% o más de culpa.

El perfil de accidentes del condado de McIntosh está dominado por dos corredores: aproximadamente 18 millas de la **I-95** (las salidas 49 y 58 son los principales intercambiadores con concentración de choques) y la **US-17 / SR 251**, por donde circulan camiones madereros con destino a los aserraderos costeros y que sirven como rutas de evacuación en caso de huracán. Como el condado de McIntosh no cuenta con un centro de trauma de Nivel I, las víctimas con lesiones graves suelen ser trasladadas en el helicóptero LifeStar al **Memorial Health University Medical Center en Savannah** — el único centro de trauma de Nivel I del sureste de Georgia.

Dos estatutos de Georgia tienen un peso decisivo en la carga judicial de este condado, dominada por casos de camiones: **O.C.G.A. § 33-7-11** permite la acumulación ("stacking") adicional de cobertura UM/UIM por encima de los límites del conductor culpable, y **O.C.G.A. § 40-1-112** permite demandar directamente a la aseguradora del transportista.
EOT
,
                // GBP review count — powers per-office AggregateRating schema.
                // VERIFY: Darien is a smaller satellite office. Update quarterly from GBP dashboard.
                'review_count' => 12,
                'review_rating' => '4.9',
            ),
            'charleston' => array(
                'name'         => 'Roden Law — Charleston',
                'street'       => '127 King Street, Suite 200',
                'city'         => 'Charleston',
                'state'        => 'SC',
                'state_full'   => 'South Carolina',
                'zip'          => '29401',
                'phone'        => '(843) 790-8999',
                'phone_raw'    => '+18437908999',
                'gbp_url'      => 'https://share.google/GfVAAnKPpCR6mdR8C',
                'yelp_url'     => '',
                'latitude'     => 32.777514,
                'longitude'    => -79.932945,
                'timezone'     => 'America/New_York',
                'court'        => 'Charleston County Circuit Court',
                'court_address'=> '100 Broad St., Charleston, SC 29401',
                'slug'         => 'charleston-sc',
                'state_slug'   => 'south-carolina',
                'service_area' => 'Charleston, Mount Pleasant, West Ashley, James Island, Johns Island, Daniel Island, and surrounding Lowcountry communities.',
                'attorneys'    => array( 'graeham-gillin', 'kiley-reidy', 'zach-stohr' ),
                'nearby_communities' => array(
                    'Mount Pleasant', 'West Ashley', 'James Island', 'Johns Island',
                    'Daniel Island', 'Isle of Palms', 'Folly Beach', "Sullivan's Island",
                    'Kiawah Island', 'Wadmalaw Island',
                ),
                'directions'   => 'Our Charleston office is in the heart of downtown on King Street, Suite 200, near the intersection of King and Calhoun streets. From I-26 East, take Exit 221B onto Meeting Street heading south, then turn right on Calhoun and left on King. From Mount Pleasant, cross the Ravenel Bridge and follow US-17 S to the Meeting Street exit. Street and garage parking available nearby.',
                'map_embed'    => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3354.570788089184!2d-79.9329881!3d32.7771216!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88fe7bd134041e93%3A0x2c255a08f0b45377!2sRoden%20Law!5e0!3m2!1sen!2sus!4v1773074802432!5m2!1sen!2sus',
                'local_context' => <<<'EOT'
Filing a personal injury case in downtown Charleston means filing in the **Charleston County Court of Common Pleas at 100 Broad Street**, on the Tyler Odyssey-based South Carolina E-Filing system. Most cases are sent to mandatory mediation under SC ADR rules before reaching the jury trial roster, and a typical contested case takes **18–30 months** from complaint to verdict.

Charleston's peninsula geography concentrates risk on a few well-known corridors: the **Crosstown (US-17 / Septima P. Clark Parkway)**, the **Arthur Ravenel Jr. Bridge** to Mount Pleasant, and the dense tourist grid around **King and Market Streets**, where rideshare drop-offs and carriage tours mix with out-of-state drivers. Charleston County logged **more than 2,500 truck-related crashes in 2023**, and the **I-26/I-526 interchange just west of the peninsula recorded 354 collisions over a five-year period**. Serious-injury patients from peninsula crashes are routed to **MUSC Health (171 Ashley Ave) — the Lowcountry's only Level I trauma center**.

Under South Carolina law, you have **3 years to file under S.C. Code § 15-3-530**, and you can recover only if you are **less than 51% at fault**. Shorter notice deadlines apply if SCDOT or the City of Charleston is a defendant under the SC Tort Claims Act.
EOT
,
                'local_context_es' => <<<'EOT'
Presentar un caso de lesiones personales en el centro de Charleston significa presentarlo ante el **Charleston County Court of Common Pleas, ubicado en 100 Broad Street**, a través del sistema de presentación electrónica de Carolina del Sur basado en Tyler Odyssey. La mayoría de los casos se envían a mediación obligatoria conforme a las reglas de ADR de Carolina del Sur antes de llegar al calendario de juicios con jurado, y un caso disputado típico tarda **de 18 a 30 meses** desde la demanda hasta el veredicto.

La geografía peninsular de Charleston concentra el riesgo en unos pocos corredores bien conocidos: el **Crosstown (US-17 / Septima P. Clark Parkway)**, el puente **Arthur Ravenel Jr. Bridge** hacia Mount Pleasant y la densa zona turística alrededor de **King Street y Market Street**, donde los descensos de pasajeros de rideshare y los paseos en carruaje se mezclan con conductores de otros estados. El condado de Charleston registró **más de 2,500 choques relacionados con camiones en 2023**, y el **intercambiador de la I-26/I-526, justo al oeste de la península, registró 354 colisiones en un período de cinco años**. Los pacientes con lesiones graves por choques en la península son trasladados a **MUSC Health (171 Ashley Ave) — el único centro de trauma de Nivel I del Lowcountry**.

Conforme a la ley de Carolina del Sur, usted tiene **3 años para presentar la demanda conforme a S.C. Code § 15-3-530**, y solo puede recuperar una indemnización si tiene **menos del 51% de culpa**. Se aplican plazos de notificación más cortos si el SCDOT o la Ciudad de Charleston es parte demandada conforme a la SC Tort Claims Act.
EOT
,
                // GBP review count — powers per-office AggregateRating schema.
                // VERIFY: pulled from Birdeye/Google Apr 2026. Update quarterly from GBP dashboard.
                'review_count' => 80,
                'review_rating' => '4.9',
            ),
            'north-charleston' => array(
                'name'         => 'Roden Law — North Charleston',
                'street'       => '2703 Spruill Ave',
                'city'         => 'North Charleston',
                'state'        => 'SC',
                'state_full'   => 'South Carolina',
                'zip'          => '29405',
                'phone'        => '(843) 612-6561',
                'phone_raw'    => '+18436126561',
                'gbp_url'      => 'https://share.google/v7fwlLKOUZVK5PSCd',
                'yelp_url'     => '',
                'latitude'     => 32.847324,
                'longitude'    => -79.961197,
                'timezone'     => 'America/New_York',
                'court'        => 'Charleston County Circuit Court',
                'court_address'=> '100 Broad St., Charleston, SC 29401',
                'slug'         => 'north-charleston-sc',
                'state_slug'   => 'south-carolina',
                'service_area' => 'North Charleston, Goose Creek, Summerville, Hanahan, Ladson, Moncks Corner, and surrounding tri-county communities.',
                'attorneys'    => array( 'graeham-gillin', 'kiley-reidy', 'zach-stohr' ),
                'nearby_communities' => array(
                    'Goose Creek', 'Summerville', 'Hanahan', 'Ladson',
                    'Moncks Corner', 'Park Circle', 'Dorchester',
                    'Lincolnville', 'Jedburg', 'Sangaree',
                    'St. Stephen', 'Walterboro',
                ),
                'directions'   => 'Our North Charleston office is located on Spruill Avenue in the Park Circle area. From I-26, take Exit 213 onto E Montague Ave heading east, then turn left on Spruill Ave. From downtown Charleston, take I-26 W to Exit 213. Free client parking is available on site.',
                'local_context' => <<<'EOT'
North Charleston personal injury cases are filed in the **Charleston County Court of Common Pleas at 100 Broad Street downtown** and submitted through the **South Carolina E-Filing System** on Tyler's Odyssey platform. Common Pleas civil cases are sent to mandatory mediation under SC ADR rules before reaching the trial roster, and a contested truck or industrial case typically takes 18–30 months — longer when FMCSA records, ELD logs, and port chassis-pool inspection histories are in play.

North Charleston's hazard profile is dominated by **port and industrial truck traffic** funneling between the **Hugh Leatherman Terminal** and the **I-26 / I-526 / Rivers Avenue** corridor: SCDOT records **354 collisions over five years at the I-26/I-526 interchange** alone, and Charleston County logged **over 2,500 truck-related crashes in 2023**. Spruill Avenue, North Rhett Avenue, Aviation Avenue, and the **Ashley Phosphate Road / I-26 interchange** are the city's recurring crash corridors. Serious crash victims are routed to **Trident Medical Center (Level II trauma)** at 9330 Medical Plaza Drive, with the most critical patients flown to **MUSC Health (Level I)** downtown.

South Carolina's **3-year statute of limitations (S.C. Code § 15-3-530)** and **51%-bar comparative fault rule** apply, and shorter Tort Claims Act notice deadlines apply when SCDOT or the SC Ports Authority is a defendant.
EOT
,
                'local_context_es' => <<<'EOT'
Los casos de lesiones personales de North Charleston se presentan ante el **Charleston County Court of Common Pleas, ubicado en 100 Broad Street en el centro de Charleston**, y se tramitan a través del **South Carolina E-Filing System** en la plataforma Odyssey de Tyler. Los casos civiles de Common Pleas se envían a mediación obligatoria conforme a las reglas de ADR de Carolina del Sur antes de llegar al calendario de juicios, y un caso disputado de camiones o industrial típicamente tarda de 18 a 30 meses — más tiempo cuando entran en juego los registros de la FMCSA, los registros ELD y los historiales de inspección del parque de chasis portuarios.

El perfil de riesgo de North Charleston está dominado por el **tráfico de camiones portuarios e industriales** que circula entre la **Hugh Leatherman Terminal** y el corredor de la **I-26 / I-526 / Rivers Avenue**: el SCDOT registra **354 colisiones en cinco años solo en el intercambiador de la I-26/I-526**, y el condado de Charleston registró **más de 2,500 choques relacionados con camiones en 2023**. Spruill Avenue, North Rhett Avenue, Aviation Avenue y el **intercambiador de Ashley Phosphate Road / I-26** son los corredores de choques recurrentes de la ciudad. Las víctimas de choques graves son trasladadas al **Trident Medical Center (trauma de Nivel II)**, en 9330 Medical Plaza Drive, y los pacientes más críticos son trasladados en helicóptero a **MUSC Health (Nivel I)** en el centro de la ciudad.

Se aplican el **plazo de prescripción de 3 años de Carolina del Sur (S.C. Code § 15-3-530)** y la **regla de culpa comparativa con barrera del 51%**, y rigen plazos de notificación más cortos bajo la Tort Claims Act cuando el SCDOT o la SC Ports Authority es parte demandada.
EOT
,
                // GBP review count — powers per-office AggregateRating schema.
                // VERIFY: new office, may share Charleston GBP. Update quarterly from GBP dashboard.
                'review_count' => 15,
                'review_rating' => '5.0',
            ),
            'columbia' => array(
                'name'         => 'Roden Law — Columbia',
                'street'       => '1545 Sumter St., Suite B',
                'city'         => 'Columbia',
                'state'        => 'SC',
                'state_full'   => 'South Carolina',
                'zip'          => '29201',
                'phone'        => '(803) 219-2816',
                'phone_raw'    => '+18032192816',
                'gbp_url'      => 'https://share.google/MYa3mQpoPwZjCnrHj',
                'yelp_url'     => '',
                'latitude'     => 34.006782,
                'longitude'    => -81.034492,
                'timezone'     => 'America/New_York',
                'court'        => 'Richland County Circuit Court',
                'court_address'=> '1701 Main St., Columbia, SC 29201',
                'slug'         => 'columbia-sc',
                'state_slug'   => 'south-carolina',
                'service_area' => 'Columbia, Lexington, Irmo, West Columbia, Cayce, Forest Acres, and surrounding Midlands South Carolina communities.',
                'attorneys'    => array( 'graeham-gillin', 'kiley-reidy' ),
                'nearby_communities' => array(
                    'Lexington', 'Irmo', 'West Columbia', 'Cayce',
                    'Forest Acres', 'Blythewood', 'Elgin', 'Chapin',
                    'Dentsville', 'Hopkins',
                ),
                'directions'   => 'Our Columbia office is on Sumter Street in the downtown corridor, near the University of South Carolina campus. From I-26, take Exit 111B onto Elmwood Ave, then turn south on Sumter St. From I-77, take Exit 16A onto I-277 and follow signs to Sumter Street. From I-20, take Exit 74 onto Broad River Rd toward downtown. Street metered parking and nearby garage parking are available.',
                'local_context' => <<<'EOT'
Filing a personal injury case in Columbia means working through the **Richland County Court of Common Pleas at 1701 Main Street**, where civil complaints are submitted electronically through South Carolina's statewide **Tyler Odyssey e-filing system** and placed on a 365-day case-management track under SCRCP Rule 40. Most contested cases are sent to mandatory mediation before trial under SC ADR Rule 3.

Crash victims in the Midlands disproportionately come from one place: the **I-26/I-20/I-77 interchange known as Malfunction Junction**, now in the middle of SCDOT's **$2.08 billion Carolina Crossroads reconstruction** — the largest project in agency history — which will keep active work zones on I-26 between Piney Grove Road and I-77 in flux through roughly 2029. Severe-injury crashes from that corridor, from I-77 north toward Blythewood, and from Two Notch and Broad River Roads are routed to **Prisma Health Richland**, the Midlands' only Level I trauma center.

South Carolina law gives injured plaintiffs **three years to file under S.C. Code § 15-3-530**, applies a **51% modified-comparative-fault bar**, and allows stacking of uninsured and underinsured motorist coverage — a critical lever when a Malfunction Junction pile-up exceeds the at-fault driver's 25/50/25 minimum policy.
EOT
,
                'local_context_es' => <<<'EOT'
Presentar un caso de lesiones personales en Columbia implica tramitarlo ante el **Richland County Court of Common Pleas, ubicado en 1701 Main Street**, donde las demandas civiles se presentan electrónicamente a través del sistema estatal de presentación electrónica **Tyler Odyssey** de Carolina del Sur y se colocan en una vía de gestión de casos de 365 días conforme a la Regla 40 de las SCRCP. La mayoría de los casos disputados se envían a mediación obligatoria antes del juicio conforme a la Regla 3 de ADR de Carolina del Sur.

Las víctimas de accidentes en los Midlands provienen de manera desproporcionada de un solo lugar: el **intercambiador de la I-26/I-20/I-77 conocido como Malfunction Junction**, actualmente en plena reconstrucción bajo el proyecto **Carolina Crossroads de $2.08 mil millones** del SCDOT — el más grande en la historia de la agencia — que mantendrá zonas de obras activas y cambiantes en la I-26 entre Piney Grove Road y la I-77 hasta aproximadamente 2029. Los choques con lesiones graves de ese corredor, de la I-77 hacia el norte rumbo a Blythewood, y de Two Notch Road y Broad River Road son trasladados a **Prisma Health Richland**, el único centro de trauma de Nivel I de los Midlands.

La ley de Carolina del Sur otorga a los demandantes lesionados **tres años para presentar la demanda conforme a S.C. Code § 15-3-530**, aplica una **barrera de culpa comparativa modificada del 51%** y permite la acumulación ("stacking") de coberturas de motorista no asegurado e infrasegurado — una herramienta crítica cuando un choque múltiple en Malfunction Junction supera la póliza mínima 25/50/25 del conductor culpable.
EOT
,
                // GBP review count — powers per-office AggregateRating schema.
                // VERIFY: pulled Apr 2026. Update quarterly from GBP dashboard.
                'review_count' => 18,
                'review_rating' => '4.9',
            ),
            'myrtle-beach' => array(
                'name'         => 'Roden Law — Myrtle Beach',
                'market_name'  => 'Myrtle Beach',
                'street'       => '631 Bellamy Ave., Suite C-B',
                'city'         => 'Murrells Inlet',
                'state'        => 'SC',
                'state_full'   => 'South Carolina',
                'zip'          => '29576',
                'phone'        => '(843) 612-1980',
                'phone_raw'    => '+18436121980',
                'gbp_url'      => 'https://share.google/MqXF349LuG3dKLY1L',
                'yelp_url'     => '',
                'latitude'     => 33.555038,
                'longitude'    => -79.042453,
                'timezone'     => 'America/New_York',
                'court'        => 'Horry County Circuit Court',
                'court_address'=> '1301 2nd Ave., Conway, SC 29526',
                'slug'         => 'myrtle-beach-sc',
                'state_slug'   => 'south-carolina',
                'service_area' => 'Myrtle Beach, Murrells Inlet, Conway, Surfside Beach, Pawleys Island, and surrounding Grand Strand communities.',
                'attorneys'    => array( 'graeham-gillin', 'ivy-montano' ),
                'nearby_communities' => array(
                    'Myrtle Beach', 'Conway', 'Surfside Beach', 'Pawleys Island',
                    'Garden City', 'Litchfield Beach', 'North Myrtle Beach',
                    'Little River', 'Loris', 'Georgetown',
                ),
                'directions'   => 'Our Myrtle Beach area office is on Bellamy Avenue in Murrells Inlet, Suite C-B, just off US-17 Business in the heart of the Grand Strand. From Myrtle Beach, take US-17 S (Kings Highway) approximately 12 miles south. From Georgetown, take US-17 N about 20 miles. From Conway, take US-501 to US-17 S. The office is near Brookgreen Gardens and Huntington Beach State Park.',
                'local_context' => <<<'EOT'
Filing a personal injury case in the Myrtle Beach market means filing in **Horry County Court of Common Pleas at 1301 Second Avenue in Conway**, where civil complaints are submitted through South Carolina's mandatory **Tyler Odyssey e-filing system** and most cases are routed to mediation before trial under SC ADR Rule 3.

The Grand Strand draws roughly 17–20 million visitors a year, and that seasonal surge reshapes the local crash picture: **US-17 Business and Ocean Boulevard** see heavy pedestrian and golf-cart traffic, while drivers choose between the slower, congested **US-501** and the faster but higher-severity **SC-22 Conway Bypass** to reach the beach. Golf carts add a wrinkle unique to coastal SC — under **S.C. Code § 56-2-100**, a permitted cart may only operate in daylight, within four miles of the owner's address, on roads posted 35 mph or less, by a licensed driver. Crashes outside those limits open the door to negligence-per-se and rental-property claims. Severe-injury victims are routed to **Grand Strand Medical Center** in Myrtle Beach or stabilized at **Tidelands Waccamaw** in Murrells Inlet.

South Carolina applies a **three-year statute of limitations under S.C. Code § 15-3-530**, a **51% modified-comparative-fault bar**, and allows stacking of UM/UIM coverage — often the largest recovery source when an out-of-state tourist is hit by a minimum-limits driver.
EOT
,
                'local_context_es' => <<<'EOT'
Presentar un caso de lesiones personales en el mercado de Myrtle Beach significa presentarlo ante el **Horry County Court of Common Pleas, ubicado en 1301 Second Avenue en Conway**, donde las demandas civiles se tramitan a través del sistema obligatorio de presentación electrónica **Tyler Odyssey** de Carolina del Sur y la mayoría de los casos se envían a mediación antes del juicio conforme a la Regla 3 de ADR de Carolina del Sur.

El Grand Strand atrae aproximadamente de 17 a 20 millones de visitantes al año, y ese aumento estacional transforma el panorama local de accidentes: **US-17 Business y Ocean Boulevard** registran un intenso tráfico de peatones y carritos de golf, mientras que los conductores eligen entre la **US-501**, más lenta y congestionada, y la **SC-22 Conway Bypass**, más rápida pero con choques de mayor gravedad, para llegar a la playa. Los carritos de golf añaden una particularidad propia de la costa de Carolina del Sur: conforme a **S.C. Code § 56-2-100**, un carrito con permiso solo puede circular durante el día, dentro de un radio de cuatro millas del domicilio del propietario, en vías con límite de velocidad de 35 mph o menos y conducido por una persona con licencia. Los choques que ocurren fuera de esos límites abren la puerta a reclamos por negligencia per se y contra propiedades de alquiler. Las víctimas con lesiones graves son trasladadas al **Grand Strand Medical Center** en Myrtle Beach o estabilizadas en **Tidelands Waccamaw** en Murrells Inlet.

Carolina del Sur aplica un **plazo de prescripción de tres años conforme a S.C. Code § 15-3-530**, una **barrera de culpa comparativa modificada del 51%** y permite la acumulación ("stacking") de cobertura UM/UIM — a menudo la mayor fuente de recuperación cuando un turista de otro estado es atropellado por un conductor con límites mínimos de póliza.
EOT
,
                // GBP review count — powers per-office AggregateRating schema.
                // VERIFY: pulled Apr 2026. Update quarterly from GBP dashboard.
                'review_count' => 22,
                'review_rating' => '4.9',
            ),
        ),

        /* ==================================================================
           ATTORNEYS — 7 Key Attorneys
           ================================================================== */

        'attorneys' => array(
            'eric-roden' => array(
                'name'           => 'Eric Roden',
                'title'          => 'Founding Partner, CEO',
                'bar_admissions' => array( 'Georgia', 'South Carolina' ),
                'office'         => 'savannah',
            ),
            'tyler-love' => array(
                'name'           => 'Tyler Love',
                'title'          => 'Founding Partner, CTO',
                'bar_admissions' => array( 'Georgia' ),
                'office'         => 'savannah',
            ),
            'joshua-dorminy' => array(
                'name'           => 'Joshua Dorminy',
                'title'          => 'Partner',
                'bar_admissions' => array( 'Georgia', 'South Carolina' ),
                'office'         => 'darien',
                'focus'          => 'Leads trucking litigation',
            ),
            'graeham-gillin' => array(
                'name'           => 'Graeham C. Gillin',
                'title'          => 'Partner, COO',
                'bar_admissions' => array( 'South Carolina' ),
                'office'         => 'charleston',
            ),
            'kiley-reidy' => array(
                'name'           => 'Kiley Reidy',
                'title'          => 'Associate',
                'bar_admissions' => array( 'South Carolina' ),
                'office'         => 'charleston',
            ),
            'zach-stohr' => array(
                'name'           => 'Zach Stohr',
                'title'          => 'Associate',
                'bar_admissions' => array( 'South Carolina' ),
                'office'         => 'charleston',
            ),
            'ivy-montano' => array(
                'name'           => 'Ivy S. Montano',
                'title'          => 'Associate',
                'bar_admissions' => array( 'South Carolina' ),
                'office'         => 'myrtle-beach',
            ),
        ),

        /* ==================================================================
           TRUST STATS
           ================================================================== */

        'trust_stats' => array(
            'recovered'     => '$300M+',
            'rating'        => '4.9',
            'reviews'       => 'Hundreds of 5-Star Reviews', // Non-numeric display copy. Real total is the live per-office GBP sum (~205); see review_count computed in the aliases section below.
            'review_count'  => 0,     // Computed below as the live sum of per-office GBP review_count — feeds schema AggregateRating reviewCount. Never hardcode; keep it honest + auto-updating.
            'cases'         => '5,000+',
            'experience'    => '62',
            'offices'       => '6',
        ),

        /* ==================================================================
           SOCIAL PROFILES
           ================================================================== */

        'social' => array(
            'facebook'  => 'https://www.facebook.com/RodenLaw',
            'instagram' => 'https://www.instagram.com/rodenlaw',
            'linkedin'  => 'https://www.linkedin.com/company/roden-law',
            'youtube'   => 'https://www.youtube.com/@rodenlaw',
            'twitter'   => 'https://x.com/rodenlaw',
        ),

        /* ==================================================================
           FIRM-LEVEL DIRECTORY PROFILES
           Only firm/Organization-scope directories belong here. Lawyer
           directories (Avvo, Justia, Super Lawyers, Martindale, FindLaw,
           Lawyers.com) list individual attorneys, not firms — those go on
           per-attorney post meta (_roden_avvo_url, _roden_linkedin_url,
           _roden_same_as) and feed into roden_schema_person() instead.
           Per-location entities (Google Business Profile, Yelp) live on each
           office in the offices array as `gbp_url`, `yelp_url` — they belong
           on per-office LocalBusiness sameAs, not firm-level Org sameAs.
           Empty strings are filtered out before being added to schema sameAs.
           ================================================================== */

        'legal_directories' => array(
            'bbb'        => '', // https://www.bbb.org/us/.../profile/personal-injury-attorney/...
            'wikidata'   => '', // https://www.wikidata.org/wiki/Q... (only if entry exists)
            'crunchbase' => '', // https://www.crunchbase.com/organization/... (only if profile exists)
        ),

        /* ==================================================================
           JURISDICTION LAW DATA
           ================================================================== */

        'jurisdiction' => array(
            'GA' => array(
                'state_full'       => 'Georgia',
                'statute_years'    => 2,
                'statute_cite'     => 'O.C.G.A. § 9-3-33',
                'comp_fault_rule'  => 'Modified — recover if less than 50% at fault',
                'comp_fault_cite'  => 'O.C.G.A. § 51-12-33',
            ),
            'SC' => array(
                'state_full'       => 'South Carolina',
                'statute_years'    => 3,
                'statute_cite'     => 'S.C. Code § 15-3-530',
                'comp_fault_rule'  => 'Modified — recover if less than 51% at fault',
                'comp_fault_cite'  => '',
            ),
        ),

        /* ==================================================================
           18 PRACTICE AREA PILLAR SLUGS
           ================================================================== */

        'practice_areas' => array(
            'personal-injury-lawyers',
            'car-accident-lawyers',
            'truck-accident-lawyers',
            'slip-and-fall-lawyers',
            'motorcycle-accident-lawyers',
            'medical-malpractice-lawyers',
            'wrongful-death-lawyers',
            'workers-compensation-lawyers',
            'dog-bite-lawyers',
            'brain-injury-lawyers',
            'spinal-cord-injury-lawyers',
            'maritime-injury-lawyers',
            'product-liability-lawyers',
            'boating-accident-lawyers',
            'burn-injury-lawyers',
            'construction-accident-lawyers',
            'nursing-home-abuse-lawyers',
            'premises-liability-lawyers',
            'pedestrian-accident-lawyers',
            'bicycle-accident-lawyers',
            'electric-scooter-accident-lawyers',
            'atv-side-by-side-accident-lawyers',
            'golf-cart-accident-lawyers',
            'e-bike-accident-lawyers',
        ),
    );

    /* ------------------------------------------------------------------
       Convenience aliases — keep templates working without mass rename
       ------------------------------------------------------------------ */

    // Top-level aliases (from vanity_phone + trust_stats)
    $data['phone']         = $data['vanity_phone'];
    $data['phone_e164']    = $data['phone_raw'];
    $data['recovered']     = $data['trust_stats']['recovered'];
    $data['rating']        = $data['trust_stats']['rating'];
    $data['reviews']       = $data['trust_stats']['reviews'];
    $data['cases_handled'] = $data['trust_stats']['cases'];
    $data['experience']    = $data['trust_stats']['experience'] . ' years';

    // Live review count: sum of per-office Google Business Profile review counts.
    // Keeps schema AggregateRating reviewCount honest and auto-updating as the
    // per-office counts in the offices array are maintained — the real verifiable
    // total, not a rounded marketing figure. Display copy stays non-numeric
    // (trust_stats['reviews']); this number is for structured data only.
    $review_total = 0;
    foreach ( $data['offices'] as $office_data ) {
        if ( isset( $office_data['review_count'] ) ) {
            $review_total += intval( $office_data['review_count'] );
        }
    }
    $data['trust_stats']['review_count'] = $review_total;

    // Per-office aliases
    foreach ( $data['offices'] as $key => &$office ) {
        // Market name: display name for headings/nav/SEO (defaults to city).
        // Physical 'city' is kept for mailing address and schema addressLocality.
        if ( ! isset( $office['market_name'] ) ) {
            $office['market_name'] = $office['city'];
        }

        $office['address']     = $office['street'];
        $office['phone_e164']  = $office['phone_raw'];
        $office['lat']         = $office['latitude'];
        $office['lng']         = $office['longitude'];
        // Directions destination uses the full mailing address (not raw
        // lat/lng) so Google geocodes the actual office and shows the business
        // pin. This is robust even if a stored coordinate drifts.
        $office['map_url']     = 'https://www.google.com/maps/dir/?api=1&destination='
                                 . rawurlencode(
                                     $office['street'] . ', ' . $office['city'] . ', '
                                     . $office['state'] . ' ' . $office['zip']
                                 );

        // Jurisdiction-derived fields
        $state_key = $office['state']; // 'GA' or 'SC'
        if ( isset( $data['jurisdiction'][ $state_key ] ) ) {
            $j = $data['jurisdiction'][ $state_key ];
            $office['sol']   = $j['statute_years'] . ' years (' . $j['statute_cite'] . ')';
            $office['fault'] = $j['comp_fault_rule'];
        }
    }
    unset( $office ); // break reference

    return $data;
}

/* ==========================================================================
   HELPER FUNCTIONS
   ========================================================================== */

/**
 * Get a single office's data by key.
 *
 * @param string $key Office key (e.g., 'savannah', 'charleston').
 * @return array|null Office data array, or null if key not found.
 */
function roden_get_office( $key ) {
    $firm = roden_firm_data();
    return $firm['offices'][ $key ] ?? null;
}

/**
 * Get the office key that matches a city slug (e.g., 'savannah-ga' => 'savannah').
 *
 * @param string $city_slug The city-state slug to look up.
 * @return string|null Office key, or null if no match.
 */
function roden_office_key_from_slug( $city_slug ) {
    $firm = roden_firm_data();
    foreach ( $firm['offices'] as $key => $office ) {
        if ( $office['slug'] === $city_slug ) {
            return $key;
        }
    }
    return null;
}

/**
 * Get all office city-state slugs.
 *
 * @return array Array of city-state slugs (e.g., 'savannah-ga', 'charleston-sc').
 */
function roden_get_office_slugs() {
    $firm  = roden_firm_data();
    $slugs = array();
    foreach ( $firm['offices'] as $office ) {
        $slugs[] = $office['slug'];
    }
    return $slugs;
}

/**
 * Get jurisdiction data (statute of limitations, comparative fault) for a post.
 * Auto-detects from _roden_jurisdiction or _roden_office_key meta.
 *
 * @param int|null $post_id Post ID (defaults to current post).
 * @return array|null Jurisdiction data array or null if not set.
 */
function roden_get_jurisdiction( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $firm  = roden_firm_data();
    $state = get_post_meta( $post_id, '_roden_jurisdiction', true );

    // Fall back to office key to determine state
    if ( ! $state ) {
        $office_key = get_post_meta( $post_id, '_roden_office_key', true );
        if ( $office_key && isset( $firm['offices'][ $office_key ] ) ) {
            $state = $firm['offices'][ $office_key ]['state'];
        }
    }

    if ( $state && isset( $firm['jurisdiction'][ $state ] ) ) {
        return $firm['jurisdiction'][ $state ];
    }

    return null;
}

/**
 * Get all jurisdiction data (both GA and SC).
 *
 * @return array Associative array keyed by state abbreviation.
 */
function roden_get_all_jurisdictions() {
    $firm = roden_firm_data();
    return $firm['jurisdiction'];
}

/**
 * Get the canonical list of 18 practice area pillar slugs.
 *
 * @return array Indexed array of slug strings.
 */
function roden_get_practice_area_slugs() {
    $firm = roden_firm_data();
    return $firm['practice_areas'];
}
