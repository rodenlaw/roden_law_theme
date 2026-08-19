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
                'gbp_url'      => 'https://www.google.com/maps/place/?q=place_id:ChIJITbCLWSe-4gRMCR5SgvdFxk',
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
                // Workers' compensation variant — rendered instead of the tort
                // essay above on comp intersection pages. A comp claim is filed
                // with the State Board, not the superior court described above,
                // so the two must never be interchanged.
                'local_context_wc' => <<<'EOT'
A Georgia workers' compensation claim is not filed in court. It goes on **form WC-14 to the State Board of Workers' Compensation**, and Savannah-area claims are handled through the Board's **Savannah field office at 35 Barnard Street**, where the regional trial judges hear disputed cases. Different venue, different procedure, and a different deadline from the personal injury suits filed at the Chatham County courthouse — **one year from the date of injury** under O.C.G.A. § 34-9-82, not two.

The injuries track what Savannah does for a living. Container and equipment work at **Garden City Terminal and the Port of Savannah** produces crush, struck-by, and fall injuries. The warehouse and distribution corridor along **I-16 and Pooler** produces lifting, forklift, and loading-dock injuries. Construction, manufacturing, and hospital work fill out the rest. Seriously injured workers from across southeast Georgia are routed to **Memorial Health University Medical Center on Waters Avenue**, the region's only Level I trauma center.

Two things decide a large share of Savannah claims. Georgia generally requires treatment from the employer's **posted panel of physicians** (O.C.G.A. § 34-9-201), and going off-panel without authorization can cost you coverage. And because so many separate companies operate on a single terminal or job site, a **third-party claim** against a non-employer is often available alongside the comp claim — the only route to the damages workers' compensation never pays.
EOT
,
                // GBP review count — powers per-office AggregateRating schema.
                // VERIFY: live Google Business Profile, Aug 2026. Update quarterly from GBP dashboard.
                'review_count' => 59,
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
                'gbp_url'      => 'https://www.google.com/maps/place/?q=place_id:ChIJXQbDRmsr-4gRjV1Mk7Zh4-k',
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
                // Workers' compensation variant — see the Savannah office note.
                'local_context_wc' => <<<'EOT'
A Georgia workers' compensation claim is not filed in court. It goes on **form WC-14 to the State Board of Workers' Compensation** rather than to McIntosh County Superior Court, and the deadline is **one year from the date of injury** under O.C.G.A. § 34-9-82 — half the two-year window that applies to a personal injury lawsuit.

Coastal Georgia's work is hard on bodies. Commercial fishing and seafood processing produce machinery, deck, and repetitive-motion injuries — and a crew member hurt aboard a vessel may fall under **federal maritime law rather than state workers' compensation**, a distinction that changes the claim entirely. Timber and pulp operations across McIntosh, Wayne, and Long counties remain among the most dangerous work in the state, and the **I-95 corridor** adds warehouse, trucking, and loading-dock injuries. Serious trauma is generally routed to **Memorial Health University Medical Center in Savannah**, the region's only Level I trauma center.

Two things decide a large share of claims here. Georgia generally requires treatment from the employer's **posted panel of physicians** (O.C.G.A. § 34-9-201), and treating off-panel without authorization can leave you holding the bills. And where a company other than your employer contributed — a contractor, a vessel owner, an equipment manufacturer — a **third-party claim** can recover the pain and suffering that workers' compensation never pays.
EOT
,
                // GBP review count — powers per-office AggregateRating schema.
                // VERIFY: live Google Business Profile, Aug 2026. Darien has no reviews yet, so it
                // falls under the AggregateRating emit threshold and no rating is published for
                // this office. Update quarterly from GBP dashboard.
                'review_count' => 0,
                'review_rating' => '0.0',
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
                'gbp_url'      => 'https://www.google.com/maps/place/?q=place_id:ChIJkx4ENNF7_ogRd1O08AhaJSw',
                'yelp_url'     => '',
                'latitude'     => 32.777514,
                'longitude'    => -79.932945,
                'timezone'     => 'America/New_York',
                'court'        => 'Charleston County Circuit Court',
                'court_address'=> '100 Broad St., Charleston, SC 29401',
                'slug'         => 'charleston-sc',
                'state_slug'   => 'south-carolina',
                'service_area' => 'Charleston, Mount Pleasant, West Ashley, James Island, Johns Island, Daniel Island, and surrounding Lowcountry communities.',
                'attorneys'    => array( 'graeham-gillin' ),
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
                // VERIFY: live Google Business Profile, Aug 2026. Update quarterly from GBP dashboard.
                'review_count' => 105,
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
                'gbp_url'      => 'https://www.google.com/maps/place/?q=place_id:ChIJS2CVHEh7_ogRIEA4SfdJ3A8',
                'yelp_url'     => '',
                'latitude'     => 32.847324,
                'longitude'    => -79.961197,
                'timezone'     => 'America/New_York',
                'court'        => 'Charleston County Circuit Court',
                'court_address'=> '100 Broad St., Charleston, SC 29401',
                'slug'         => 'north-charleston-sc',
                'state_slug'   => 'south-carolina',
                'service_area' => 'North Charleston, Goose Creek, Summerville, Hanahan, Ladson, Moncks Corner, and surrounding tri-county communities.',
                'attorneys'    => array( 'graeham-gillin' ),
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
                // VERIFY: live Google Business Profile, Aug 2026 — its own listing, not Charleston's.
                'review_count' => 2,
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
                'gbp_url'      => 'https://www.google.com/maps/place/?q=place_id:ChIJQZdkRQCl-IgRVi202Pu6b1I',
                'yelp_url'     => '',
                'latitude'     => 34.006782,
                'longitude'    => -81.034492,
                'timezone'     => 'America/New_York',
                'court'        => 'Richland County Circuit Court',
                'court_address'=> '1701 Main St., Columbia, SC 29201',
                'slug'         => 'columbia-sc',
                'state_slug'   => 'south-carolina',
                'service_area' => 'Columbia, Lexington, Irmo, West Columbia, Cayce, Forest Acres, and surrounding Midlands South Carolina communities.',
                'attorneys'    => array( 'graeham-gillin' ),
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
                // VERIFY: live Google Business Profile, Aug 2026. Update quarterly from GBP dashboard.
                'review_count' => 2,
                'review_rating' => '5.0',
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
                'gbp_url'      => 'https://www.google.com/maps/place/?q=place_id:ChIJXV6kZKE5AIkRS6GJSoJ0xAA',
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
                // VERIFY: live Google Business Profile, Aug 2026. Update quarterly from GBP dashboard.
                'review_count' => 2,
                'review_rating' => '5.0',
            ),
        ),

        /* ==================================================================
           SERVICE AREAS — towns Roden serves from an office elsewhere

           These are NOT offices and must never be merged into the 'offices'
           array. That array is looped to build the location matrix on every
           intersection page, to emit a LocalBusiness for each office, to
           inject the offices nav, and to compute trust_stats['offices'] — so
           adding a town there would publish "Roden Law has 23 offices" as a
           factual claim. Same failure class as the AggregateRating bug that
           published 4.9 stars over a profile with zero reviews (PR #33).

           A service area carries only its own verifiable geography. Everything
           else — street, phone, GBP, attorneys, reviews — is resolved from
           'parent_office' by roden_market(). A page built on one of these keys
           must emit the PARENT office's LocalBusiness with areaServed naming
           the town, never a synthetic address at the town itself.

           'court' / 'court_address': verified against the SC Judicial Branch
           courthouse directory (sccourts.org), Aug 2026. Where the Common
           Pleas street address could not be verified from a primary source,
           'court_address' is left empty rather than guessed — templates treat
           it as optional. Do not fill these in from memory.

           'trauma_center': verified against the SC DPH designated trauma
           centre list, Aug 2026. Levels are load-bearing — the Georgia side
           published a false "only Level I" claim in 55 places. Re-verify
           against dph.sc.gov before changing one.

           'local_context' is deliberately absent here. It is authored per town
           alongside that town's pages; until then roden_market() falls back to
           the parent office's block rather than rendering an empty section.
           ================================================================== */

        'service_areas' => array(

            /* ---- Charleston / North Charleston (Lowcountry) ------------- */

            'summerville' => array(
                'market_name'   => 'Summerville',
                'parent_office' => 'north-charleston',
                'slug'          => 'summerville-sc',
                'city'          => 'Summerville',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'Dorchester',
                'court'         => 'Dorchester County Court of Common Pleas',
                'court_address' => '5200 E. Jim Bilton Blvd., St. George, SC 29477',
                'trauma_center' => 'Trident Medical Center (Adult Level II)',
                'latitude'      => 33.018497,
                'longitude'     => -80.175560,
                'local_context' => <<<'EOT'
Filing a personal injury case in Summerville means filing in the **{office_court}** — and Dorchester County's courthouse is not in Summerville. Civil complaints go to **{office_court_address}**, about 25 miles down US-78, through South Carolina's mandatory **Tyler Odyssey e-filing system**, with most cases routed to mediation before trial under SC ADR Rule 3. The Troy Knight Judicial Complex on Deming Way in Summerville is closer, but it houses Family Court and does not hear personal injury claims.

Summerville's crash pattern is driven by one thing: **I-26**, the freight artery carrying container traffic between the Port of Charleston and Columbia, Charlotte and the Upstate. Trucks leaving the Hugh Leatherman and Columbus Street terminals for inland destinations pass through here, and that through-traffic meets one of the fastest-growing residential areas in South Carolina on roads never built for the combination. **US-17A (Main Street/Boone Hill Road)**, **Berlin G. Myers Parkway**, **Old Trolley Road**, **Dorchester Road** and **Central Avenue** carry most of the area's serious-injury crashes. Severe injuries are routed to **Trident Medical Center** in North Charleston, the Lowcountry's **Adult Level II** trauma centre, or to **MUSC** in Charleston for Level I and paediatric trauma.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — the modified comparative-fault rule adopted in *Nelson v. Concrete Supply Co.* Stacking of UM/UIM coverage is permitted and is often the largest recovery source when a minimum-limits driver causes a catastrophic crash.
EOT
,
            ),
            'goose-creek' => array(
                'market_name'   => 'Goose Creek',
                'parent_office' => 'north-charleston',
                'slug'          => 'goose-creek-sc',
                'city'          => 'Goose Creek',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'Berkeley',
                'court'         => 'Berkeley County Court of Common Pleas',
                'court_address' => '300-B California Ave., Moncks Corner, SC 29461',
                'trauma_center' => 'Trident Medical Center (Adult Level II)',
                'latitude'      => 32.981000,
                'longitude'     => -80.032600,
                'local_context' => <<<'EOT'
Filing a personal injury case in Goose Creek means filing in the **{office_court}** at **{office_court_address}** — Berkeley County, not Charleston County, even though Goose Creek sits minutes from North Charleston. Complaints go through South Carolina's mandatory **Tyler Odyssey e-filing system**, and most cases are routed to mediation before trial under SC ADR Rule 3. Berkeley County recorded **58 fatal collisions in 2023**, the fifth-highest of any county in South Carolina, according to the SCDPS Traffic Collision Fact Book.

Goose Creek's defining hazard is **US-52**, where heavy truck traffic crosses active railroad grade crossings. The corridor funnels logging trucks out of Berkeley County's timber land and oversized military transports out of **Joint Base Charleston**, and it has produced a documented pattern of train-versus-truck collisions unlike anywhere else in the Lowcountry — including a September 2024 collision in which a train struck a tractor-trailer hauling a military vehicle, and a January 2021 grade-crossing crash near St. James Avenue that sent six people to hospital. Away from the rail line, **US-176 at US-17A (Carnes Crossroads)**, **Red Bank Road** and **Henry E. Brown Jr. Boulevard** carry the bulk of local injury crashes. Severe injuries go to **Trident Medical Center**, the **Adult Level II** trauma centre in North Charleston, or to **MUSC** for Level I and paediatric care.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* Where a railroad or a federally regulated motor carrier is involved, event-recorder and hours-of-service data are frequently decisive and are routinely overwritten unless preserved early.
EOT
,
            ),
            'moncks-corner' => array(
                'market_name'   => 'Moncks Corner',
                'parent_office' => 'north-charleston',
                'slug'          => 'moncks-corner-sc',
                'city'          => 'Moncks Corner',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'Berkeley',
                'court'         => 'Berkeley County Court of Common Pleas',
                'court_address' => '300-B California Ave., Moncks Corner, SC 29461',
                'trauma_center' => 'Trident Medical Center (Adult Level II)',
                'latitude'      => 33.195900,
                'longitude'     => -80.014100,
                'local_context' => <<<'EOT'
Moncks Corner is the Berkeley County seat, which means the **{office_court}** — where every Berkeley County personal injury case is filed — sits in town at **{office_court_address}**. Complaints are submitted through South Carolina's mandatory **Tyler Odyssey e-filing system**, and most cases are routed to mediation before trial under SC ADR Rule 3. Berkeley County recorded **58 fatal collisions in 2023**, fifth-highest in South Carolina per the SCDPS Traffic Collision Fact Book.

The town sits where three kinds of traffic meet. **US-52** carries commercial and logging trucks south toward Goose Creek and the Port of Charleston across active rail crossings. **US-17A** and **SC-6** carry commuter traffic from the fast-growing Cane Bay and Carnes Crossroads developments toward Summerville and North Charleston. And **Lake Moultrie** draws seasonal recreational traffic — boat trailers, out-of-town drivers unfamiliar with two-lane rural roads, and the alcohol-involved crashes that follow a summer weekend on the water. There is no trauma centre in Moncks Corner: severe injuries are transported to **Trident Medical Center** in North Charleston (**Adult Level II**) or to **MUSC** in Charleston for Level I and paediatric trauma.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* Stacking of UM/UIM coverage is permitted, and on rural Berkeley County roads where minimum-limits policies are common it is frequently the largest available source of recovery.
EOT
,
            ),
            'mount-pleasant' => array(
                'market_name'   => 'Mount Pleasant',
                'parent_office' => 'charleston',
                'slug'          => 'mount-pleasant-sc',
                'city'          => 'Mount Pleasant',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'Charleston',
                'court'         => 'Charleston County Court of Common Pleas',
                'court_address' => '100 Broad St., Charleston, SC 29401',
                'trauma_center' => 'MUSC Medical Center (Adult and Pediatric Level I)',
                'latitude'      => 32.832300,
                'longitude'     => -79.828400,
                'local_context' => <<<'EOT'
Filing a personal injury case in Mount Pleasant means filing in the **{office_court}** at **{office_court_address}** — across the Ravenel Bridge in downtown Charleston. Complaints go through South Carolina's mandatory **Tyler Odyssey e-filing system**, with most cases routed to mediation before trial under SC ADR Rule 3. Charleston County recorded **16,118 collisions in 2023**, the second-highest total of any county in South Carolina, including 70 fatal collisions and 75 people killed, per the SCDPS Traffic Collision Fact Book.

**US-17** is the county's single worst roadway, accounting for 1,942 of those collisions on its own. Through Mount Pleasant it runs as **Johnnie Dodds Boulevard** and **Coleman Boulevard**, carrying commuter volume, tourist traffic and port freight through signalised intersections and constant turning movements. The **Arthur Ravenel Jr. Bridge** concentrates every east-bound Charleston commuter into a fixed corridor with no shoulder escape, and the **Isle of Palms Connector** adds seasonal beach traffic. Container trucks serving the **Wando Welch Terminal** — one of the busiest container terminals on the East Coast — move through Mount Pleasant streets to reach I-526. Severe injuries are routed to **MUSC** in Charleston, the state's only **Adult and Paediatric Level I** trauma centre.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* Stacking of UM/UIM coverage is permitted and often matters most when an out-of-state visitor is struck by a minimum-limits driver.
EOT
,
            ),
            'hilton-head' => array(
                'market_name'   => 'Hilton Head Island',
                'parent_office' => 'charleston',
                'slug'          => 'hilton-head-sc',
                'city'          => 'Hilton Head Island',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'Beaufort',
                'court'         => 'Beaufort County Court of Common Pleas',
                'court_address' => '102 Ribaut Rd., Beaufort, SC 29902',
                'trauma_center' => 'MUSC Medical Center (Adult and Pediatric Level I)',
                'latitude'      => 32.216300,
                'longitude'     => -80.752600,
                'local_context' => <<<'EOT'
Filing a personal injury case arising on Hilton Head Island means filing in the **{office_court}** at **{office_court_address}** — roughly 40 miles off-island in Beaufort. Complaints are submitted through South Carolina's mandatory **Tyler Odyssey e-filing system**, and most cases are routed to mediation before trial under SC ADR Rule 3.

Hilton Head's crash profile is unlike anywhere else Roden Law practises, because the island has exactly one road on and off it. **US-278** carries every resident, worker, delivery vehicle and visitor across the bridges at Mackay Creek and Skull Creek, and a single crash on that corridor has no alternate route to absorb it. On-island, **William Hilton Parkway**, **Pope Avenue** and the **Sea Pines Circle** rotary mix unfamiliar seasonal drivers with more than sixty miles of public pathways used by cyclists and pedestrians — a combination that produces a disproportionate share of vulnerable-road-user injuries. There is **no DPH-designated trauma centre on the island**: seriously injured patients are stabilised locally and transported off-island, which lengthens the treatment record and makes early preservation of EMS and transfer documentation important.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* Visitors injured on the island should not assume their home-state policy governs: South Carolina permits stacking of UM/UIM coverage, and that often decides the real value of a claim against a minimum-limits local driver.
EOT
,
            ),

            /* ---- Grand Strand ------------------------------------------ */

            'conway' => array(
                'market_name'   => 'Conway',
                'parent_office' => 'myrtle-beach',
                'slug'          => 'conway-sc',
                'city'          => 'Conway',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'Horry',
                'court'         => 'Horry County Court of Common Pleas',
                'court_address' => '1301 2nd Ave., Conway, SC 29526',
                'trauma_center' => 'Conway Medical Center (Adult Level III)',
                'latitude'      => 33.835900,
                'longitude'     => -79.047800,
                'local_context' => <<<'EOT'
Conway is where Grand Strand personal injury cases are actually filed. The **{office_court}** sits at **{office_court_address}**, which means a Myrtle Beach crash, a Surfside Beach crash and a Conway crash all end up before the same court in this town. Complaints are submitted through South Carolina's mandatory **Tyler Odyssey e-filing system**, and most cases are routed to mediation before trial under SC ADR Rule 3. Horry County recorded **11,109 collisions and 64 fatal collisions in 2023**, the fourth-highest totals in South Carolina per the SCDPS Traffic Collision Fact Book.

Two corridors dominate the local crash picture, and they fail in opposite ways. **SC-22, the Conway Bypass**, is a high-speed limited-access route carrying freight from I-95 to the coast across elevated bridge sections over the Waccamaw River — where a truck striking stopped traffic has nowhere to go, and neither does anyone in front of it. **US-501** between Conway and Myrtle Beach is the reverse: a congested commercial corridor absorbing tourist volume through signalised intersections and constant turning movements. **Conway Medical Center** is the local **Adult Level III** trauma centre; the most severe injuries are transferred to **Grand Strand Medical Center** in Myrtle Beach, an **Adult Level I** centre.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* For visitors injured on the Grand Strand, stacked UM/UIM coverage from an out-of-state policy is frequently the difference between a minimum-limits recovery and a full one.
EOT
,
            ),
            'north-myrtle-beach' => array(
                'market_name'   => 'North Myrtle Beach',
                'parent_office' => 'myrtle-beach',
                'slug'          => 'north-myrtle-beach-sc',
                'city'          => 'North Myrtle Beach',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'Horry',
                'court'         => 'Horry County Court of Common Pleas',
                'court_address' => '1301 2nd Ave., Conway, SC 29526',
                'trauma_center' => 'Grand Strand Medical Center (Adult Level I)',
                'latitude'      => 33.816000,
                'longitude'     => -78.680000,
                'local_context' => <<<'EOT'
Filing a personal injury case in North Myrtle Beach means filing in the **{office_court}** at **{office_court_address}** — inland in Conway, where all Horry County civil cases are heard. Complaints go through South Carolina's mandatory **Tyler Odyssey e-filing system**, with most cases routed to mediation before trial under SC ADR Rule 3. Horry County recorded **11,109 collisions and 64 fatal collisions in 2023**, fourth-highest in the state per the SCDPS Traffic Collision Fact Book.

North Myrtle Beach's crash pattern is seasonal and vehicular-mix driven. **US-17 (Kings Highway)** and **Main Street** carry beach traffic through signalised commercial strips, while **SC-31 (Carolina Bays Parkway)** moves it at highway speed a few miles inland — so the same trip can involve two entirely different risk profiles. Golf carts are a genuine feature of local traffic rather than a novelty: under **S.C. Code § 56-2-100** a permitted cart may operate only in daylight, within four miles of the owner's address, on roads posted 35 mph or less, and only with a licensed driver. Crashes outside those limits open the door to negligence-per-se arguments and to claims against rental operators. Severe injuries are routed to **Grand Strand Medical Center** in Myrtle Beach, the region's **Adult Level I** trauma centre.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* Stacking of UM/UIM coverage is permitted and often decides the outcome when a visitor is hit by a minimum-limits driver.
EOT
,
            ),
            'pawleys-island' => array(
                'market_name'   => 'Pawleys Island',
                'parent_office' => 'myrtle-beach',
                'slug'          => 'pawleys-island-sc',
                'city'          => 'Pawleys Island',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'Georgetown',
                'court'         => 'Georgetown County Court of Common Pleas',
                'court_address' => '401 Cleland St., Georgetown, SC 29440',
                'trauma_center' => 'Tidelands Waccamaw Community Hospital (Adult Level IV)',
                'latitude'      => 33.429300,
                'longitude'     => -79.122000,
                'local_context' => <<<'EOT'
Filing a personal injury case in Pawleys Island means filing in the **{office_court}** at **{office_court_address}** — Georgetown County, not Horry, even though Pawleys Island sits on the Grand Strand and most local traffic flows north toward Murrells Inlet and Myrtle Beach. Complaints are submitted through South Carolina's mandatory **Tyler Odyssey e-filing system**, and most cases are routed to mediation before trial under SC ADR Rule 3.

**US-17 (Ocean Highway)** is effectively the only through route, and along the Waccamaw Neck it narrows from the multi-lane divided highway drivers experience further north into sections with at-grade beach access turns, cyclists, and vehicles slowing for causeways to the island itself. Crashes here often involve a driver travelling at highway speed meeting a turning or stopped vehicle with no dedicated turn lane. The nearest designated trauma centre is **Tidelands Waccamaw Community Hospital** in Murrells Inlet, which carries an **Adult Level IV** designation — the lowest tier, meaning it stabilises and transfers rather than providing definitive trauma care. Severely injured patients are moved on to **Grand Strand Medical Center** in Myrtle Beach (**Adult Level I**), and that transfer chain is a routine feature of serious Pawleys Island cases.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* Stacking of UM/UIM coverage is permitted and is frequently the largest available recovery source in a serious Waccamaw Neck crash.
EOT
,
            ),

            /* ---- Midlands ---------------------------------------------- */

            'orangeburg' => array(
                'market_name'   => 'Orangeburg',
                'parent_office' => 'columbia',
                'slug'          => 'orangeburg-sc',
                'city'          => 'Orangeburg',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'Orangeburg',
                'court'         => 'Orangeburg County Court of Common Pleas',
                'court_address' => '', // Common Pleas street address unverified — do not guess.
                'trauma_center' => 'Regional Medical Center, Orangeburg (Adult Level III)',
                'latitude'      => 33.491800,
                'longitude'     => -80.855600,
                'local_context' => <<<'EOT'
Orangeburg County personal injury cases are filed in the **{office_court}**, in the First Judicial Circuit, through South Carolina's mandatory **Tyler Odyssey e-filing system**, with most cases routed to mediation before trial under SC ADR Rule 3. Roden Law is admitted throughout South Carolina and handles Orangeburg cases from our Columbia office. The county recorded **34 fatal collisions in 2023**, the ninth-highest of any county in the state, per the SCDPS Traffic Collision Fact Book — a striking figure for a county of its population.

That concentration has a structural cause: Orangeburg County sits on the **I-26 / I-95 junction**, where the Charleston-to-Columbia freight corridor crosses the main Northeast-to-Florida interstate. Long-haul traffic with no local destination passes through in volume, and it feeds onto surface routes never designed to receive it — **US-301**, **US-601**, **US-21** and **US-178** carry a mix of interstate overflow, agricultural equipment and local traffic on largely two-lane alignments. **The Regional Medical Center** in Orangeburg is the county's **Adult Level III** trauma centre; the most severe injuries are transferred to **Prisma Health Richland** in Columbia, an **Adult Level I** centre.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* Where an interstate motor carrier is involved, federal hours-of-service and maintenance records under 49 C.F.R. are often decisive, and they are routinely overwritten unless preserved early.
EOT
,
            ),
            'sumter' => array(
                'market_name'   => 'Sumter',
                'parent_office' => 'columbia',
                'slug'          => 'sumter-sc',
                'city'          => 'Sumter',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'Sumter',
                'court'         => 'Sumter County Court of Common Pleas',
                'court_address' => '215 N. Harvin St., Sumter, SC 29150',
                'trauma_center' => 'Prisma Health Richland (Adult Level I)',
                'latitude'      => 33.920400,
                'longitude'     => -80.341400,
                'local_context' => <<<'EOT'
Sumter County personal injury cases are filed in the **{office_court}** at **{office_court_address}**, in the Third Judicial Circuit, through South Carolina's mandatory **Tyler Odyssey e-filing system**, with most cases routed to mediation before trial under SC ADR Rule 3. Roden Law is admitted throughout South Carolina and handles Sumter cases from our Columbia office. The county recorded **30 fatal collisions in 2023**, tenth-highest in the state per the SCDPS Traffic Collision Fact Book.

Sumter's traffic is shaped by **Shaw Air Force Base**, which puts a large, largely young and frequently rotating driving population onto local roads, and by the town's role as a regional hub for the surrounding rural counties. **US-76/US-378**, **US-521**, **US-15** and **SC-441** carry that combined military, commuter and agricultural traffic, much of it on two-lane alignments with unlit shoulders and at-grade field access — the conditions behind South Carolina's persistent pattern of rural fatal crashes. There is no designated trauma centre in Sumter County: seriously injured patients are transported to **Prisma Health Richland** in Columbia, an **Adult Level I** centre, roughly 45 miles away.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* Where an active-duty service member is injured, coordination between military health benefits, TRICARE recovery rights and the civil claim needs to be handled early, because the lien position affects what actually reaches the client.
EOT
,
            ),
            'blythewood' => array(
                'market_name'   => 'Blythewood',
                'parent_office' => 'columbia',
                'slug'          => 'blythewood-sc',
                'city'          => 'Blythewood',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'Richland',
                'court'         => 'Richland County Court of Common Pleas',
                'court_address' => '1701 Main St., Columbia, SC 29201',
                'trauma_center' => 'Prisma Health Richland (Adult Level I)',
                'latitude'      => 34.212900,
                'longitude'     => -80.973000,
                'local_context' => <<<'EOT'
Filing a personal injury case in Blythewood means filing in the **{office_court}** at **{office_court_address}** — Richland County, in downtown Columbia. Complaints go through South Carolina's mandatory **Tyler Odyssey e-filing system**, with most cases routed to mediation before trial under SC ADR Rule 3. Richland County recorded **12,450 collisions and 58 fatal collisions in 2023**, the third-highest collision total in South Carolina per the SCDPS Traffic Collision Fact Book.

Blythewood's exposure is almost entirely **I-77**. The interstate is the freight spine between Columbia and Charlotte, and Blythewood sits on the stretch where long-haul trucks are still at highway speed while local traffic is entering and leaving at **Exit 27 (SC-34)** and **Blythewood Road**. The result is a classic speed-differential corridor: a merging vehicle and an 80,000-pound truck arriving at the same point with a 20 mph gap between them. Rapid residential growth north of Columbia has added commuter volume to interchanges built for a much smaller town. Severe injuries are routed to **Prisma Health Richland** in Columbia, the Midlands' **Adult Level I** trauma centre.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* Where an interstate motor carrier is involved, federal hours-of-service and maintenance records under 49 C.F.R. are often decisive, and they are routinely overwritten unless preserved early.
EOT
,
            ),
            'irmo' => array(
                'market_name'   => 'Irmo',
                'parent_office' => 'columbia',
                'slug'          => 'irmo-sc',
                'city'          => 'Irmo',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'Richland',
                'court'         => 'Richland County Court of Common Pleas',
                'court_address' => '1701 Main St., Columbia, SC 29201',
                'trauma_center' => 'Lexington Medical Center (Adult Level III)',
                'latitude'      => 34.085700,
                'longitude'     => -81.183400,
                'local_context' => <<<'EOT'
Filing a personal injury case in Irmo means filing in the **{office_court}** at **{office_court_address}** in downtown Columbia. Complaints are submitted through South Carolina's mandatory **Tyler Odyssey e-filing system**, and most cases are routed to mediation before trial under SC ADR Rule 3. Richland County recorded **12,450 collisions and 58 fatal collisions in 2023**, the third-highest collision total in the state per the SCDPS Traffic Collision Fact Book.

Irmo's crash pattern is retail-corridor congestion rather than open-road speed. **I-26 at St. Andrews Road** is one of the most crash-prone interchanges in South Carolina, feeding traffic into the **Harbison Boulevard** retail district — a concentration of shopping centres, restaurants and hotels whose access drives produce constant turning and merging conflicts. **Lake Murray Boulevard (SC-60)** and **Broad River Road (US-176)** carry the same volume through signalised commercial strips, and **Lake Murray** adds weekend recreational traffic and boat trailers to the mix. **Lexington Medical Center** is the nearest designated centre at **Adult Level III**; the most severe injuries go to **Prisma Health Richland**, the Midlands' **Adult Level I** trauma centre.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* In low-speed retail-corridor collisions the injury is frequently soft-tissue and the insurer's first move is to argue the impact was too minor to hurt anyone — which makes early, consistent medical documentation decisive.
EOT
,
            ),

            /* ---- Upstate ------------------------------------------------
               No Roden office, no Google Business Profile and no reviews in
               this region. Templates must not render a NAP block implying a
               local address here — the serving office is Columbia and must be
               labelled as such. Built on the firm's statewide SC bar
               admission; the citable facts below are public record.
               ------------------------------------------------------------ */

            'spartanburg' => array(
                'market_name'   => 'Spartanburg',
                'parent_office' => 'columbia',
                'slug'          => 'spartanburg-sc',
                'city'          => 'Spartanburg',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'Spartanburg',
                'court'         => 'Spartanburg County Court of Common Pleas',
                'court_address' => '180 Magnolia St., Spartanburg, SC 29306',
                'trauma_center' => 'Spartanburg Medical Center (Adult Level I)',
                'latitude'      => 34.949600,
                'longitude'     => -81.932000,
                'local_context' => <<<'EOT'
Spartanburg County personal injury cases are filed in the **{office_court}** at **{office_court_address}**, in the Seventh Judicial Circuit, through South Carolina's mandatory **Tyler Odyssey e-filing system**. Roden Law is admitted throughout South Carolina and handles Upstate cases from our Columbia office; we do not maintain a Spartanburg office.

Spartanburg County carries one of the heaviest crash burdens in the state. The **SCDPS 2023 Traffic Collision Fact Book** records **11,002 collisions** in the county that year, including **71 fatal collisions and 84 people killed** — tied with Greenville County for the most fatal collisions of any county in South Carolina. **I-85** alone accounted for 1,311 of those collisions, followed by **US-29** (985), **US-176** (656), **US-221** (509) and **I-26** (464). The interchange of **I-85 and SC-290** was the county's single worst location at 175 collisions. I-85 is the Charlotte-to-Atlanta freight spine, and its interchanges put merging local traffic directly into sustained interstate truck volume. **Spartanburg Medical Center** is the regional **Adult Level I** trauma centre.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* Where an interstate motor carrier is involved, federal hours-of-service and maintenance records under 49 C.F.R. are often decisive, and they are routinely overwritten unless preserved early.
EOT
,
            ),
            'rock-hill' => array(
                'market_name'   => 'Rock Hill',
                'parent_office' => 'columbia',
                'slug'          => 'rock-hill-sc',
                'city'          => 'Rock Hill',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'York',
                'court'         => 'York County Court of Common Pleas',
                'court_address' => 'Moss Justice Center, 1675 York Hwy., York, SC 29745',
                'trauma_center' => 'Piedmont Medical Center (Adult Level III)',
                'latitude'      => 34.924900,
                'longitude'     => -81.025100,
                'local_context' => <<<'EOT'
Rock Hill personal injury cases are filed in the **{office_court}** at **{office_court_address}**, in the Sixteenth Judicial Circuit — the county courthouse is in the town of York, not in Rock Hill. Complaints go through South Carolina's mandatory **Tyler Odyssey e-filing system**, with most cases routed to mediation before trial under SC ADR Rule 3. Roden Law is admitted throughout South Carolina and handles York County cases from our Columbia office. York County recorded **29 fatal collisions in 2023** per the SCDPS Traffic Collision Fact Book.

**I-77** defines the local crash picture. The corridor is the freight and commuter link between Columbia and Charlotte, and the stretch through York County carries long-haul trucks alongside a growing volume of daily commuters heading north into North Carolina. Surface routes absorb the overflow: **Cherry Road (SC-161)**, **Dave Lyle Boulevard** and **US-21** carry retail, commuter and truck traffic through signalised intersections that were built for a smaller Rock Hill. **Piedmont Medical Center** in Rock Hill is the county's designated **Adult Level III** trauma centre — the nearest Level I facilities are across the state line in Charlotte, which routinely puts a South Carolina claim on a North Carolina treatment record.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* Where a crash involves a North Carolina driver or out-of-state treatment, which policy's coverage and which state's law apply are threshold questions worth settling early.
EOT
,
            ),
            'fort-mill' => array(
                'market_name'   => 'Fort Mill',
                'parent_office' => 'columbia',
                'slug'          => 'fort-mill-sc',
                'city'          => 'Fort Mill',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'York',
                'court'         => 'York County Court of Common Pleas',
                'court_address' => 'Moss Justice Center, 1675 York Hwy., York, SC 29745',
                'trauma_center' => 'Piedmont Medical Center (Adult Level III)',
                'latitude'      => 35.007400,
                'longitude'     => -80.945000,
                'local_context' => <<<'EOT'
Fort Mill personal injury cases are filed in the **{office_court}** at **{office_court_address}**, in the Sixteenth Judicial Circuit — roughly 25 miles west in the town of York. Complaints are submitted through South Carolina's mandatory **Tyler Odyssey e-filing system**, and most cases are routed to mediation before trial under SC ADR Rule 3. Roden Law is admitted throughout South Carolina and handles York County cases from our Columbia office. York County recorded **29 fatal collisions in 2023** per the SCDPS Traffic Collision Fact Book.

Fort Mill's traffic is Charlotte's traffic. The town sits directly below the state line, and **I-77** carries a heavy daily commuter flow north into Mecklenburg County and back, mixed with the same long-haul freight that runs the length of the corridor. **SC-160** and **US-21** feed that interstate volume through a road network that has absorbed one of the fastest residential growth rates in South Carolina without a matching expansion in capacity. The practical consequence for an injured person is jurisdictional: the crash is in South Carolina, the at-fault driver frequently lives in North Carolina, and the nearest Level I trauma care is in Charlotte. **Piedmont Medical Center** in Rock Hill is the closest South Carolina designated centre, at **Adult Level III**.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}** — one year longer than North Carolina's, which matters when a claim could plausibly be brought in either state. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* North Carolina, by contrast, still applies pure contributory negligence, under which any fault at all defeats the claim entirely. Where the case is filed can decide whether it exists.
EOT
,
            ),
            'greer' => array(
                'market_name'   => 'Greer',
                'parent_office' => 'columbia',
                'slug'          => 'greer-sc',
                'city'          => 'Greer',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                // Greer straddles the Greenville/Spartanburg county line;
                // Greenville is the larger share and the default venue.
                'county'        => 'Greenville',
                'court'         => 'Greenville County Court of Common Pleas',
                'court_address' => '301 University Ridge, Greenville, SC 29601',
                'trauma_center' => 'Prisma Health Greenville Memorial Hospital (Adult Level I)',
                'latitude'      => 34.938700,
                'longitude'     => -82.227100,
                'local_context' => <<<'EOT'
Greer personal injury cases are filed in the **{office_court}** at **{office_court_address}**, in the Thirteenth Judicial Circuit, through South Carolina's mandatory **Tyler Odyssey e-filing system**, with most cases routed to mediation before trial under SC ADR Rule 3. Roden Law is admitted throughout South Carolina and handles Upstate cases from our Columbia office. Greer straddles the Greenville–Spartanburg county line; Greenville County recorded **16,640 collisions and 71 fatal collisions in 2023** — the most of any county in South Carolina on both measures — per the SCDPS Traffic Collision Fact Book.

Few towns of Greer's size carry as much freight. **Inland Port Greer** moves Port of Charleston containers by rail into the Upstate, where they transfer to trucks; the **BMW Manufacturing plant** and **GSP International Airport** sit either side of town; and **I-85**, the Charlotte-to-Atlanta corridor, runs through the middle of it. The result is a sustained volume of heavy commercial vehicles on roads that also serve ordinary local traffic — **SC-14**, **SC-101** and **Wade Hampton Boulevard (US-29)** carry the mix through signalised intersections and at-grade commercial access. Severe injuries are routed to **Prisma Health Greenville Memorial Hospital**, the Upstate's **Adult Level I** trauma centre.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* Where an interstate motor carrier or an intermodal operator is involved, federal hours-of-service, maintenance and container-weight records are often decisive, and they are routinely overwritten unless preserved early.
EOT
,
            ),
            'simpsonville' => array(
                'market_name'   => 'Simpsonville',
                'parent_office' => 'columbia',
                'slug'          => 'simpsonville-sc',
                'city'          => 'Simpsonville',
                'state'         => 'SC',
                'state_full'    => 'South Carolina',
                'state_slug'    => 'south-carolina',
                'county'        => 'Greenville',
                'court'         => 'Greenville County Court of Common Pleas',
                'court_address' => '301 University Ridge, Greenville, SC 29601',
                'trauma_center' => 'Prisma Health Greenville Memorial Hospital (Adult Level I)',
                'latitude'      => 34.737000,
                'longitude'     => -82.254300,
                'local_context' => <<<'EOT'
Simpsonville personal injury cases are filed in the **{office_court}** at **{office_court_address}**, in the Thirteenth Judicial Circuit, through South Carolina's mandatory **Tyler Odyssey e-filing system**, with most cases routed to mediation before trial under SC ADR Rule 3. Roden Law is admitted throughout South Carolina and handles Upstate cases from our Columbia office. Greenville County recorded **16,640 collisions and 71 fatal collisions in 2023** — the highest of any county in South Carolina on both measures — per the SCDPS Traffic Collision Fact Book.

Simpsonville sits in the Golden Strip, the corridor of rapid suburban growth south of Greenville, and its crash pattern reflects that: commuter volume on infrastructure built for a smaller town. **I-385** is the spine, carrying daily traffic into Greenville and connecting to the **Woodruff Road** district — among the most congested stretches of road in the state and a persistent concentration of collisions. Locally, **SC-14**, **Fairview Road** and **Harrison Bridge Road** carry retail and residential traffic through signalised intersections with heavy turning movements. Severe injuries are routed to **Prisma Health Greenville Memorial Hospital**, the Upstate's **Adult Level I** trauma centre.

South Carolina applies a **{sol_years}-year statute of limitations under {sol_cite}**. Recovery is barred once a plaintiff's own negligence is *greater than* the combined negligence of the defendants — *Nelson v. Concrete Supply Co.* In congested-corridor collisions the insurer's first argument is usually that a low-speed impact could not have caused the injury, which makes early and consistent medical documentation decisive.
EOT
,
            ),
        ),

        /* ==================================================================
           ATTORNEYS — 7 Key Attorneys
           ================================================================== */

        // Departures must be removed from here as well as redirected and drafted.
        // inc/legacy-redirects.php 301s a departed attorney's profile to /about/ and
        // the CPT post is moved to draft, but this array is what llms.txt is built
        // from — Kiley Reidy and Zach Stohr stayed here after leaving and the file
        // went on advertising two South Carolina associates the firm did not employ.
        'attorneys' => array(
            // Georgia only — corrected 2026-08-07 on the firm's confirmation.
            // This array supplements the attorney post's own
            // `_roden_bar_admissions` in schema-helpers.php, so a wrong entry
            // publishes a false credential as structured data. Post 3729's own
            // record already read Georgia only (State Bar of Georgia, Georgia
            // Court of Appeals, Supreme Court of Georgia); this file was the
            // outlier and the source of the SC attribution on `both` pages.
            'eric-roden' => array(
                'name'           => 'Eric Roden',
                'title'          => 'Founding Partner, CEO',
                'bar_admissions' => array( 'Georgia' ),
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
            'reviews'       => '',    // Derived in the aliases section below from the live per-office GBP sum — do not hand-write it.
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
                // South Carolina's comparative-fault rule is judicial, not statutory —
                // adopted in Nelson for causes of action arising on or after 1991-07-01.
                // Georgia's cite is a code section; South Carolina's is the case, and
                // leaving it empty was why the SC rule read as an uncited assertion.
                'comp_fault_cite'  => 'Nelson v. Concrete Supply Co., 303 S.C. 243, 399 S.E.2d 783 (1991)',
            ),
        ),

        /* ==================================================================
           PRACTICE-AREA STATUTE OVERRIDES

           The 'jurisdiction' array above holds each state's TORT statute of
           limitations, which is correct for negligence claims (car accidents,
           premises liability, etc.) but wrong for statutory schemes that carry
           their own filing deadline.

           Workers' compensation is the case that bit us: a GA comp claim must
           be filed within ONE year (O.C.G.A. § 34-9-82), not the two-year tort
           SOL, and SC is TWO years (S.C. Code § 42-15-40), not three. Before
           this override every WC page rendered the tort deadline above the
           fold while its own FAQ cited the correct statute.

           Keyed by practice-area pillar slug, then state key. Anything absent
           here falls back to 'jurisdiction' — see roden_resolve_statute().
           ================================================================== */

        'statute_overrides' => array(
            'workers-compensation-lawyers' => array(
                /*
                 * The prose fields are translatable: they render inside
                 * sentences on the page, so leaving them as bare English was
                 * what forced roden_resolve_statute() to blank them on /es/
                 * rather than emit English mid-Spanish-sentence. roden_firm_data()
                 * is rebuilt per call and the textdomain loads on
                 * after_setup_theme, so __() resolves correctly here.
                 * Statute citations stay untranslated — a code section is a
                 * proper name in both languages.
                 */
                'GA' => array(
                    'statute_years'  => 1,
                    'statute_cite'   => 'O.C.G.A. § 34-9-82',
                    'notice_label'   => __( 'Notify your employer', 'roden-law' ),
                    'notice_detail'  => __( 'within 30 days of the injury (O.C.G.A. § 34-9-80)', 'roden-law' ),
                    'filing_venue'   => __( 'State Board of Workers\' Compensation (form WC-14)', 'roden-law' ),
                ),
                'SC' => array(
                    'statute_years'  => 2,
                    'statute_cite'   => 'S.C. Code § 42-15-40',
                    'notice_label'   => __( 'Notify your employer', 'roden-law' ),
                    'notice_detail'  => __( 'within 90 days of the injury (S.C. Code § 42-15-20)', 'roden-law' ),
                    'filing_venue'   => __( 'S.C. Workers\' Compensation Commission (Form 50)', 'roden-law' ),
                ),
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
    // total, not a rounded marketing figure.
    $review_total = 0;
    foreach ( $data['offices'] as $office_data ) {
        if ( isset( $office_data['review_count'] ) ) {
            $review_total += intval( $office_data['review_count'] );
        }
    }
    $data['trust_stats']['review_count'] = $review_total;

    // Display phrase, derived from the same live sum rather than written by hand.
    // The hand-written value said "Hundreds of 5-Star Reviews" against a real
    // total of 170, and it is substituted into "Rated %1$s stars from %2$s client
    // reviews" — which rendered as "from Hundreds of 5-Star Reviews client
    // reviews" on all 211 location pages. Deriving it keeps the claim true as the
    // counts change and keeps that sentence grammatical.
    $data['trust_stats']['reviews'] = $review_total >= 20
        ? sprintf( '%d+ verified Google', intdiv( $review_total, 10 ) * 10 )
        : 'verified Google';
    $data['reviews'] = $data['trust_stats']['reviews'];

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

/* ==========================================================================
   MARKETS — offices and service areas under one lookup

   A "market" is anywhere the firm publishes a city-scoped page: the 6 real
   offices plus the service-area towns served from them. roden_market() is the
   only supported way to resolve one. Templates must not index
   $firm['offices'][ $key ] directly — that lookup is unguarded, fatals on an
   unknown key, and cannot see service areas.
   ========================================================================== */

/**
 * Resolve a market (office or service area) to a full, render-ready array.
 *
 * An office is returned exactly as roden_firm_data() built it, so existing
 * pages are byte-identical. A service area is the parent office's contact
 * details with the town's own geography laid over the top.
 *
 * Three invariants make a service area safe to publish:
 *
 *  - `review_count` is forced to 0 and `review_rating` to '', so the
 *    AggregateRating gate in schema-helpers.php can never attribute the parent
 *    office's Google reviews to a town with no profile of its own.
 *  - `street`, `zip`, `latitude` and `longitude` stay the PARENT office's, so a
 *    LocalBusiness can never claim an address the firm does not occupy. The
 *    town's own coordinates are exposed separately as `area_lat`/`area_lng`.
 *  - `is_service_area` is true and `parent_office_key` is set, so templates and
 *    schema can branch on "we serve here" rather than "we are here".
 *
 * @param string $key Market key — an office key ('charleston') or a service
 *                    area key ('summerville').
 * @return array|null Market data, or null if the key matches neither.
 */
function roden_market( $key ) {
    if ( ! is_string( $key ) || '' === $key ) {
        return null;
    }

    $firm = roden_firm_data();

    // Offices win: an office key always resolves to the office, untouched.
    if ( isset( $firm['offices'][ $key ] ) ) {
        return $firm['offices'][ $key ];
    }

    if ( ! isset( $firm['service_areas'][ $key ] ) ) {
        return null;
    }

    $area   = $firm['service_areas'][ $key ];
    $parent = isset( $firm['offices'][ $area['parent_office'] ] )
        ? $firm['offices'][ $area['parent_office'] ]
        : null;

    // A service area with a broken parent pointer is a data error, not a page.
    if ( ! $parent ) {
        return null;
    }

    $market = $parent;

    // The town's own geography and venue, laid over the parent office.
    // NOTE: 'city', 'street' and 'zip' are deliberately NOT overridden. They are
    // rendered together as one postal address in the NAP block, so laying the
    // town over the parent's street and ZIP would print a fabricated address —
    // "Spartanburg, SC 29201" against Columbia's street. The town's identity
    // lives in 'market_name' alone; the address always stays whole and true.
    foreach ( array(
        'market_name',
        'state',
        'state_full',
        'state_slug',
        'county',
        'court',
        'court_address',
        'trauma_center',
        'slug',
    ) as $own ) {
        if ( isset( $area[ $own ] ) && '' !== $area[ $own ] ) {
            $market[ $own ] = $area[ $own ];
        }
    }

    // Town coordinates are exposed under their own keys. `latitude`/`longitude`
    // deliberately remain the parent office's so schema geo agrees with the
    // street address it is published alongside.
    $market['area_lat'] = isset( $area['latitude'] ) ? $area['latitude'] : null;
    $market['area_lng'] = isset( $area['longitude'] ) ? $area['longitude'] : null;

    // Never inherit the parent's Google reviews. See invariant above.
    $market['review_count']  = 0;
    $market['review_rating'] = '';

    $market['is_service_area']   = true;
    $market['service_area_key']  = $key;
    $market['parent_office_key'] = $area['parent_office'];
    $market['parent_office_name'] = $parent['market_name'];

    // `local_context` is authored per town. Until a town has its own, fall back
    // to the parent office's block rather than rendering an empty section.
    if ( isset( $area['local_context'] ) && '' !== $area['local_context'] ) {
        $market['local_context'] = $area['local_context'];
    }
    if ( isset( $area['local_context_es'] ) && '' !== $area['local_context_es'] ) {
        $market['local_context_es'] = $area['local_context_es'];
    }

    // Re-derive the aliases roden_firm_data() computes for offices, now that
    // the state may differ from the parent's.
    $state_key = $market['state'];
    if ( isset( $firm['jurisdiction'][ $state_key ] ) ) {
        $j                 = $firm['jurisdiction'][ $state_key ];
        $market['sol']     = $j['statute_years'] . ' years (' . $j['statute_cite'] . ')';
        $market['fault']   = $j['comp_fault_rule'];
    }

    return $market;
}

/**
 * Is this key a service area rather than a real office?
 *
 * @param string $key Market key.
 * @return bool
 */
function roden_is_service_area( $key ) {
    $firm = roden_firm_data();
    return ! isset( $firm['offices'][ $key ] ) && isset( $firm['service_areas'][ $key ] );
}

/**
 * Get all market city-state slugs — offices plus service areas.
 *
 * This is what intersection detection matches a post_name against. Using
 * roden_get_office_slugs() there would silently route every service-area page
 * to the sub-type template instead.
 *
 * @return array Slugs (e.g. 'charleston-sc', 'summerville-sc').
 */
function roden_get_market_slugs() {
    $firm  = roden_firm_data();
    $slugs = roden_get_office_slugs();
    foreach ( $firm['service_areas'] as $area ) {
        if ( ! empty( $area['slug'] ) ) {
            $slugs[] = $area['slug'];
        }
    }
    return $slugs;
}

/**
 * Get the market key matching a city-state slug ('summerville-sc' => 'summerville').
 *
 * Offices are checked first so existing slugs resolve exactly as they always have.
 *
 * @param string $city_slug The city-state slug to look up.
 * @return string|null Market key, or null if no match.
 */
function roden_market_key_from_slug( $city_slug ) {
    $office_key = roden_office_key_from_slug( $city_slug );
    if ( $office_key ) {
        return $office_key;
    }

    $firm = roden_firm_data();
    foreach ( $firm['service_areas'] as $key => $area ) {
        if ( isset( $area['slug'] ) && $area['slug'] === $city_slug ) {
            return $key;
        }
    }
    return null;
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
