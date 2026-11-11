<?php
/**
 * Restore the 156 case-result descriptions lost in the theme rebuild, 2026-11-11.
 *
 * The old site showed a one-sentence description on every result (the October
 * 2025 /case-results/ snapshot carries all 156). The rebuilt `case_result` posts
 * were created with amount, type and title only, so `_roden_description` is
 * empty on 152 of them and holds a rewritten placeholder on the 4 seeded by
 * create-case-results.php. The theme already renders the field on every card.
 *
 * Source: the Wayback Machine, table in data/case-results/descriptions-from-archive-2026-11-11.json
 * (per-result old-site page for 134, the old listing for the rest). Text is the
 * firm's own published wording; nothing is written fresh.
 *
 * Guards: each target must be a published case_result with the expected slug and
 * amount, or the run aborts with nothing written. Two $250,000 premises results
 * have identical amount/type/area, so for those (`choose`) the description is the
 * candidate that matches the legacy `case-result` twin's post_content; neither
 * matching aborts. Every row also reports whether the archive text agrees with
 * that legacy body, as an independent check.
 *
 *   ssh $H "wp --path=$P eval-file - [apply]" < bin/restore-case-result-descriptions-2026-11-11.php > docs/backups/case-result-descriptions-2026-11-11.json
 */
$apply = isset( $args[0] ) && 'apply' === $args[0];
$rows  = json_decode( <<<'TABLE'
[
{
"slug": "27000000-settlement-truck-accident",
"post": 3986,
"amount": "$27,000,000",
"legacy_post": 2114,
"desc": "Settlement for the victim of a trucking accident who suffered paralysis."
},
{
"slug": "10860000-verdict-product-liability",
"post": 3987,
"amount": "$10,860,000",
"legacy_post": 2115,
"desc": "Verdict against a major electronics manufacturer for a vape battery that exploded causing significant burns."
},
{
"slug": "9800000-recovery-premises-liability",
"post": 3988,
"amount": "$9,800,000",
"legacy_post": 2116,
"desc": "Recovery for a client who suffered spinal cord injuries resulting from a construction defect."
},
{
"slug": "3350000-verdict-premises-liability",
"post": 3989,
"amount": "$3,350,000",
"legacy_post": 2117,
"desc": "Verdict awarded to client who lost two fingers due to another individual's negligent operation of a forklift."
},
{
"slug": "3000000-settlement-auto-accident",
"post": 3990,
"amount": "$3,000,000",
"legacy_post": 2118,
"desc": "$3m for the surviving wife of a man who died in an auto accident."
},
{
"slug": "2500000-settlement-auto-accident",
"post": 3991,
"amount": "$2,500,000",
"legacy_post": 2119,
"desc": "Settlement for a commercial vehicle operator that was injured when another commercial vehicle merged into his lane causing his vehicle to roll down an embankment resulting in serious injuries."
},
{
"slug": "1700000-settlement-brain-injury",
"post": 3906,
"amount": "$1,700,000",
"legacy_post": 2975,
"desc": "Settlement for a client who suffered a brain injury in a medical transport vehicle."
},
{
"slug": "1675000-recovery-auto-accident",
"post": 3992,
"amount": "$1,675,000",
"legacy_post": 2120,
"desc": "Commercial vehicle operator involved in an accident that resulted in a low back surgery and an arthroscopic knee procedure."
},
{
"slug": "1550000-settlement-auto-accident",
"post": 3993,
"amount": "$1,550,000",
"legacy_post": 2121,
"desc": "Settlement reached for a client who suffered a severe leg injury requiring internal and external fixations, bone grafts, and multiple blood transfusions."
},
{
"slug": "1300000-settlement-auto-accident",
"post": 3994,
"amount": "$1,300,000",
"legacy_post": 2122,
"desc": "Pre-suit settlement obtained on behalf of a family rear ended by a habitual drunk driver."
},
{
"slug": "1250000-settlement-wrongful-death",
"post": 3895,
"amount": "$1,250,000",
"legacy_post": 2986,
"desc": "Settlement for the surviving spouse of a man who died loading vehicles onto a shipping container when the vehicle plunged into the water over a barrier that was not to code."
},
{
"slug": "1000000-recovery-auto-accident",
"post": 3997,
"amount": "$1,000,000",
"legacy_post": 2125,
"desc": "Single commercial vehicle crash where the passenger sustained serious injuries."
},
{
"slug": "1000000-settlement-auto-accident",
"post": 3995,
"amount": "$1,000,000",
"legacy_post": 2123,
"desc": "Settlement for a husband and wife injured in t-bone accident."
},
{
"slug": "1000000-settlement-auto-accident-2",
"post": 3996,
"amount": "$1,000,000",
"legacy_post": 2124,
"desc": "Settlement for a woman who was fatally struck walking along I-95."
},
{
"slug": "950000-recovery-truck-accident",
"post": 3998,
"amount": "$950,000",
"legacy_post": 2126,
"desc": "Recovery for a client injured by an 18 wheeler that required long term care."
},
{
"slug": "900000-settlement-truck-accident",
"post": 4000,
"amount": "$900,000",
"legacy_post": 2128,
"desc": "Recovery obtained on behalf of scooter driver who sustained facial fractures and hand injury when clipped by a box truck."
},
{
"slug": "900000-settlement-workers-compensation",
"post": 3999,
"amount": "$900,000",
"legacy_post": 2127,
"desc": "Settlement for an initially denied workers' compensation claim involving a worker who lost multiple fingers and thumb in a wood chipper."
},
{
"slug": "780000-resolution-truck-accident",
"post": 4001,
"amount": "$780,000",
"legacy_post": 2129,
"desc": "Policy limits tender for a gentleman who underwent a lumbar fusion revision and other surgical procedures after being injured in a tractor trailer accident."
},
{
"slug": "750000-recovery-truck-accident-2",
"post": 3890,
"amount": "$750,000",
"legacy_post": 2991,
"desc": "Recovery for a client who underwent a knee surgery after a collision with a commercial vehicle."
},
{
"slug": "700000-recovery-auto-accident",
"post": 4002,
"amount": "$700,000",
"legacy_post": 2130,
"desc": "Recovery for a client who underwent a fusion and subsequent revision after being rear-ended."
},
{
"slug": "700000-settlement-product-liability",
"post": 4003,
"amount": "$700,000",
"legacy_post": 2131,
"desc": "Settlement for knee injuries resulting from faulty designed gym equipment."
},
{
"slug": "650000-recovery-truck-accident",
"post": 4004,
"amount": "$650,000",
"legacy_post": 2132,
"desc": "Recovery for a client pushed into a guardrail by an 18 wheeler that suffered serious injuries."
},
{
"slug": "650000-recovery-truck-accident-2",
"post": 4005,
"amount": "$650,000",
"legacy_post": 2133,
"desc": "An accident between two semi-trucks resulted in a minimally invasive lumbar procedure for our client."
},
{
"slug": "600000-recovery-truck-accident",
"post": 4007,
"amount": "$600,000",
"legacy_post": 2135,
"desc": "Recovery for client involved in T-bone accident with a commercial vehicle that resulted in a neck surgery."
},
{
"slug": "600000-settlement-auto-accident",
"post": 4008,
"amount": "$600,000",
"legacy_post": 2136,
"desc": "Settlement for young lady that required a cervical fusion after being t-boned by a driver who ran a red light."
},
{
"slug": "600000-settlement-auto-accident-2",
"post": 4009,
"amount": "$600,000",
"legacy_post": 2137,
"desc": "Policy limits settlement for a couple who was killed by a drunk driver in a head-on collision."
},
{
"slug": "600000-settlement-truck-accident",
"post": 4006,
"amount": "$600,000",
"legacy_post": 2134,
"desc": "Recovery obtained for client who had back surgery following an accident with a dump truck."
},
{
"slug": "575000-settlement-auto-accident",
"post": 4012,
"amount": "$575,000",
"legacy_post": 2140,
"desc": "$575k for an MVA where the client underwent a cervical arthroplasty and lumbar decompression."
},
{
"slug": "575000-settlement-truck-accident",
"post": 4011,
"amount": "$575,000",
"legacy_post": 2139,
"desc": "Settlement for a gentleman who required a cervical fusion after a commercial street-sweeper collided with is vehicle."
},
{
"slug": "575000-settlement-workers-compensation",
"post": 4010,
"amount": "$575,000",
"legacy_post": 2138,
"desc": "$575,000 settlement for a restaurant worker with a denied workers' compensation claim who suffered a hand injury and then developed necrotizing fasciitis."
},
{
"slug": "565000-settlement-truck-accident",
"post": 4013,
"amount": "$565,000",
"legacy_post": 2141,
"desc": "$565k for a client who's overturned semi truck was struck by a distracted second semi truck."
},
{
"slug": "525000-recovery-auto-accident",
"post": 4014,
"amount": "$525,000",
"legacy_post": 2142,
"desc": "Recovery for a client with pre-existing lumbar injuries and prior surgery who received a spinal cord stimulator after an accident reaggravated pain symptoms."
},
{
"slug": "525000-settlement-truck-accident",
"post": 4015,
"amount": "$525,000",
"legacy_post": 2143,
"desc": "A settlement with a trucking company for a wreck that caused our client's vehicle to roll over resulting in injuries requiring one of them to have surgery."
},
{
"slug": "515000-settlement-auto-accident",
"post": 4016,
"amount": "$515,000",
"legacy_post": 2144,
"desc": "Settlement for a client who underwent surgery after a collision with a commercial vehicle."
},
{
"slug": "500000-recovery-truck-accident",
"post": 4017,
"amount": "$500,000",
"legacy_post": 2145,
"desc": "Recovery for an 18 wheeler driver who was rear-ended by another 18 wheeler and underwent neck surgery."
},
{
"slug": "500000-resolution-workers-compensation",
"post": 4018,
"amount": "$500,000",
"legacy_post": 2146,
"desc": "Workers comp settlement for cook suffering burns to stomach and legs."
},
{
"slug": "500000-settlement-auto-accident",
"post": 3898,
"amount": "$500,000",
"legacy_post": 2983,
"desc": "Settlement for a motorist who struck a cow that had been improperly penned and wandered into the roadway."
},
{
"slug": "496000-settlement-truck-accident",
"post": 4019,
"amount": "$496,000",
"legacy_post": 2147,
"desc": "Pre-suit settlement reached for client who suffered a neck injury after being rear-ended by a semi-truck resulting in minimal property damage."
},
{
"slug": "465000-recovery-truck-accident",
"post": 4020,
"amount": "$465,000",
"legacy_post": 2148,
"desc": "$465,000 recovered for an injured driver who underwent a back surgery as the result of a collision with a commercial carrier."
},
{
"slug": "405000-settlement-auto-accident",
"post": 4021,
"amount": "$405,000",
"legacy_post": 2149,
"desc": "Settlement for a car accident victim who underwent a cervical fusion."
},
{
"slug": "400000-settlement-auto-accident",
"post": 4022,
"amount": "$400,000",
"legacy_post": 2150,
"desc": "Policy limit recovery for minor with head injury sustained in a 4-wheeler accident."
},
{
"slug": "400000-settlement-auto-accident-2",
"post": 4023,
"amount": "$400,000",
"legacy_post": 2151,
"desc": "Settlement for a commercial truck driver who injured his knee while applying the brakes trying to avoid a vehicle improperly merging into his lane."
},
{
"slug": "400000-settlement-premises-liability",
"post": 3902,
"amount": "$400,000",
"legacy_post": 2979,
"desc": "Premises liability settlement for a client who had a shelf fall on her at a convenience store."
},
{
"slug": "390000-recovery-auto-accident",
"post": 4024,
"amount": "$390,000",
"legacy_post": 2152,
"desc": "A worker/pedestrian directing traffic was injured by another passing work vehicle that hit him at low speed. The injury required a lumbar laminectomy."
},
{
"slug": "385000-recovery-auto-accident",
"post": 4025,
"amount": "$385,000",
"legacy_post": 2153,
"desc": "Rear end collision resulting in a cervical fusion."
},
{
"slug": "355000-settlement-auto-accident",
"post": 3900,
"amount": "$355,000",
"legacy_post": 2981,
"desc": "MVA settlement for a client involved in an auto accident with a county sheriff's deputy."
},
{
"slug": "350000-settlement-auto-accident",
"post": 4026,
"amount": "$350,000",
"legacy_post": 2154,
"desc": "Settlement for a gentleman who underwent neck surgery after being side-swiped. The at-fault driver's insurance company paid 2.5-times their policy limit after putting themselves at risk for bad faith."
},
{
"slug": "350000-settlement-nursing-home-elder-abuse",
"post": 4027,
"amount": "$350,000",
"legacy_post": 2155,
"desc": "Settlement for an elderly lady who sustained multiple injuries due to the negligence of a nursing home facility."
},
{
"slug": "325000-resolution-auto-accident",
"post": 4028,
"amount": "$325,000",
"legacy_post": 2156,
"desc": "Policy limits tender for a lady who suffered neck injuries after minor rear-end vehicle collision."
},
{
"slug": "320000-recovery-workers-compensation",
"post": 4029,
"amount": "$320,000",
"legacy_post": 2157,
"desc": "$320,000 for an employee who suffered crush injuries and underwent multiple surgeries over several years."
},
{
"slug": "318000-settlement-truck-accident",
"post": 3899,
"amount": "$318,000",
"legacy_post": 2982,
"desc": "Settlement for a husband and wife involved in a collision with a USPS truck."
},
{
"slug": "305000-settlement-premises-liability",
"post": 4030,
"amount": "$305,000",
"legacy_post": 2158,
"desc": "Pre-suit settlement for a client who suffered a fractured hip requiring surgery and resulting in ongoing pain as the result of a poorly maintained seat at a major fast food chain."
},
{
"slug": "305000-settlement-premises-liability-2",
"post": 4031,
"amount": "$305,000",
"legacy_post": 2159,
"desc": "Settlement for an elderly lady who suffered significant ankle wounds, followed by infection, after being attacked by a small dog."
},
{
"slug": "300000-recovery-truck-accident",
"post": 4036,
"amount": "$300,000",
"legacy_post": 2164,
"desc": "Client with pre-existing condition requires neck surgery after being side-swiped by logging truck."
},
{
"slug": "300000-resolution-auto-accident",
"post": 4033,
"amount": "$300,000",
"legacy_post": 2161,
"desc": "Policy limits tender for client who underwent a surgery due to a driver's failure to yield."
},
{
"slug": "300000-settlement-auto-accident",
"post": 4032,
"amount": "$300,000",
"legacy_post": 2160,
"desc": "$300,000 settlement for an individual who suffered a fractured femur in an automobile accident."
},
{
"slug": "300000-settlement-auto-accident-2",
"post": 4035,
"amount": "$300,000",
"legacy_post": 2163,
"desc": "Settlement for a lady who suffered a neck injury after a rear end collision."
},
{
"slug": "300000-settlement-auto-accident-3",
"post": 4037,
"amount": "$300,000",
"legacy_post": 2165,
"desc": "Settlement for elderly lady with pre-existing conditions who underwent a cervical fusion after being rear-ended."
},
{
"slug": "300000-settlement-auto-accident-4",
"post": 4038,
"amount": "$300,000",
"legacy_post": 2166,
"desc": "Settlement for an elderly lady who suffered an injury to the soft tissue of her foot. The at-fault driver's insurance company paid 5-times their policy limit for putting themselves at risk for bad faith."
},
{
"slug": "300000-settlement-premises-liability",
"post": 4034,
"amount": "$300,000",
"legacy_post": 2162,
"desc": "Homeowners policy tender for a client who suffered a dog bite resulting in permanent injuries."
},
{
"slug": "300000-settlement-workers-compensation",
"post": 4039,
"amount": "$300,000",
"legacy_post": 2167,
"desc": "Settlement for a gentleman who was injured after he fell from his tractor-trailer and required neck surgery; liability was contested."
},
{
"slug": "300000-recovery-product-liability",
"post": 3894,
"amount": "$300,000",
"legacy_post": 2987,
"desc": "Product liability recovery for a hand injury that resulted from a defective leaf vacuum."
},
{
"slug": "295000-recovery-auto-accident",
"post": 4040,
"amount": "$295,000",
"legacy_post": 2168,
"desc": "Recovery for a t-bone motor vehicle accident that resulted in a cervical operation."
},
{
"slug": "275000-recovery-auto-accident",
"post": 4043,
"amount": "$275,000",
"legacy_post": 2171,
"desc": "Recovery for a client who underwent a discectomy after being rear-ended."
},
{
"slug": "275000-recovery-auto-accident-2",
"post": 4044,
"amount": "$275,000",
"legacy_post": 2172,
"desc": "Recovery for a client who underwent back surgery after a vehicle cut off the garbage truck he was riding."
},
{
"slug": "275000-settlement-auto-accident",
"post": 4041,
"amount": "$275,000",
"legacy_post": 2169,
"desc": "Settlement for a client who suffered a severe shoulder injury while loading a shipping container."
},
{
"slug": "275000-settlement-auto-accident-2",
"post": 4042,
"amount": "$275,000",
"legacy_post": 2170,
"desc": "Policy limits settlement for an older gentleman who was rear-ended while exiting the highway and had to undergo a cervical fusion."
},
{
"slug": "275000-settlement-auto-accident-3",
"post": 4045,
"amount": "$275,000",
"legacy_post": 2173,
"desc": "Settlement for a SCAD student who underwent shoulder surgery after his motorized scooter was struck by a commercial vehicle that failed to stop at a stop sign."
},
{
"slug": "250000-settlement-auto-accident",
"post": 3927,
"amount": "$250,000",
"legacy_post": 2175,
"desc": "Settlement for a lady who suffered lumbar injuries as a passenger in an auto accident."
},
{
"slug": "250000-settlement-auto-accident-2",
"post": 3928,
"amount": "$250,000",
"legacy_post": 2176,
"desc": "Settlement for a gentlemen who suffered neck injuries after minor rear-end vehicle collision."
},
{
"slug": "250000-settlement-auto-accident-3",
"post": 3929,
"amount": "$250,000",
"legacy_post": 2177,
"desc": "Settlement for a woman who sustained a herniated disk and had a recommendation for surgery after being rear-ended."
},
{
"slug": "250000-settlement-auto-accident-4",
"post": 3930,
"amount": "$250,000",
"legacy_post": 2178,
"desc": "Settlement for a lady who underwent a cervical fusion after a head-on collision."
},
{
"slug": "250000-settlement-premises-liability",
"post": 3897,
"amount": "$250,000",
"legacy_post": 2174,
"desc": "Settlement reached for client who reinjured a surgically repaired knee due to improperly secured fitness equipment and negligent instruction at a physical therapy/rehab location."
},
{
"slug": "250000-recovery-wrongful-death",
"post": 3907,
"amount": "$250,000",
"legacy_post": 2974,
"desc": "Disputed liability death claim in Florida."
},
{
"slug": "250000-policy-limits-dui-accident",
"post": 3903,
"amount": "$250,000",
"legacy_post": 2978,
"desc": "Policy limits tender for a client who suffered a broken nose as the result of a DUI accident."
},
{
"slug": "250000-settlement-premises-liability-2",
"post": 3901,
"amount": "$250,000",
"legacy_post": 2980,
"choose": [
"Premises liability settlement for a client who fell through a rotten bathroom floor at their apartment.",
"Settlement for a client who suffered an ankle injury when a pallet was rolled into her leg in a grocery store."
]
},
{
"slug": "250000-settlement-premises-liability-3",
"post": 3926,
"amount": "$250,000",
"legacy_post": 2984,
"choose": [
"Premises liability settlement for a client who fell through a rotten bathroom floor at their apartment.",
"Settlement for a client who suffered an ankle injury when a pallet was rolled into her leg in a grocery store."
]
},
{
"slug": "225000-recovery-auto-accident",
"post": 3932,
"amount": "$225,000",
"legacy_post": 2180,
"desc": "Policy limits recovery for client involved in motor vehicle accident resulting in cervical surgery."
},
{
"slug": "225000-resolution-auto-accident",
"post": 3931,
"amount": "$225,000",
"legacy_post": 2179,
"desc": "Policy limits tender for a client injured in an auto accident who underwent a cervical fusion."
},
{
"slug": "225000-settlement-auto-accident",
"post": 3933,
"amount": "$225,000",
"legacy_post": 2181,
"desc": "Policy limits settlement for a lady who required a cervical fusion after being rear-ended."
},
{
"slug": "210000-recovery-truck-accident",
"post": 3934,
"amount": "$210,000",
"legacy_post": 2182,
"desc": "Client underwent minimally invasive spine surgery after low impact collision with truck."
},
{
"slug": "210000-settlement-auto-accident",
"post": 3935,
"amount": "$210,000",
"legacy_post": 2183,
"desc": "Policy limits settlement for a gentleman who required a cervical fusion after being rear-ended."
},
{
"slug": "205000-resolution-auto-accident",
"post": 3936,
"amount": "$205,000",
"legacy_post": 2184,
"desc": "Policy limits tender for the wrongful death of a woman killed in an auto accident."
},
{
"slug": "205000-settlement-auto-accident",
"post": 3937,
"amount": "$205,000",
"legacy_post": 2185,
"desc": "Policy limits settlement for a father whose daughter was killed after the driver of her vehicle ran a stop sign."
},
{
"slug": "200000-recovery-workers-compensation",
"post": 3938,
"amount": "$200,000",
"legacy_post": 2186,
"desc": "$200,000 for the wife of a deceased laborer who had a minor child."
},
{
"slug": "200000-resolution-auto-accident",
"post": 3941,
"amount": "$200,000",
"legacy_post": 2189,
"desc": "Policy limits recovery for client who had to undergo a neck surgery after being t-boned by a distracted driver."
},
{
"slug": "200000-settlement-auto-accident",
"post": 3939,
"amount": "$200,000",
"legacy_post": 2187,
"desc": "Recovery for client who sustained a foot fracture in an auto accident at a four-way intersection."
},
{
"slug": "200000-settlement-auto-accident-2",
"post": 3940,
"amount": "$200,000",
"legacy_post": 2188,
"desc": "Policy limit recovery for client who had to undergo a neck surgery after another driver failed to obey a stop sign."
},
{
"slug": "200000-settlement-auto-accident-3",
"post": 3942,
"amount": "$200,000",
"legacy_post": 2190,
"desc": "Settlement for elderly lady injured in head-on collision."
},
{
"slug": "200000-settlement-auto-accident-4",
"post": 3943,
"amount": "$200,000",
"legacy_post": 2191,
"desc": "Policy limits settlement for a gentleman who suffered cervical injuries after being side-swiped by another vehicle; he underwent a cervical fusion."
},
{
"slug": "200000-settlement-premises-liability",
"post": 3944,
"amount": "$200,000",
"legacy_post": 2192,
"desc": "Policy limit settlement for a dog bite resulting in serious injuries."
},
{
"slug": "200000-policy-limits-auto-accident",
"post": 3891,
"amount": "$200,000",
"legacy_post": 2990,
"desc": "Policy limits settlement for clients in an accident who endured minor physical injuries but developed severe emotional trauma from witnessing a relative die in the wreck."
},
{
"slug": "190000-settlement-auto-accident",
"post": 3945,
"amount": "$190,000",
"legacy_post": 2193,
"desc": "Pre-suit settlement for a client who sustained a neck injury requiring surgery after being rear-ended resulting in minimal property damage."
},
{
"slug": "180000-settlement-truck-accident",
"post": 3946,
"amount": "$180,000",
"legacy_post": 2194,
"desc": "Settlement for a young man who suffered soft tissue injuries after a collision with a tractor trailer."
},
{
"slug": "175000-recovery-auto-accident",
"post": 3948,
"amount": "$175,000",
"legacy_post": 2196,
"desc": "Recovery for a client who underwent a rotator cuff repair after a vehicle cut off the garbage truck he was riding on."
},
{
"slug": "175000-settlement-auto-accident",
"post": 3947,
"amount": "$175,000",
"legacy_post": 2195,
"desc": "Settlement for a young bicyclist who was hit by a police car. He suffered a broken leg that required an internal fixation and permanent hardware."
},
{
"slug": "172000-settlement-workers-compensation",
"post": 3949,
"amount": "$172,000",
"legacy_post": 2197,
"desc": "Settlement for a painter with a denied worker's compensation claim injured spine in fall off of a ladder."
},
{
"slug": "162500-settlement-premises-liability",
"post": 3951,
"amount": "$162,500",
"legacy_post": 2199,
"desc": "Settlement for a lady who suffered injuries to her ankle and shoulder after tripping, as a result of an uneven city sidewalk."
},
{
"slug": "162500-settlement-truck-accident",
"post": 3950,
"amount": "$162,500",
"legacy_post": 2198,
"desc": "Settlement for a gentleman who sustained a low back injury after being rear-ended by a semi-truck resulting in minimal property damage."
},
{
"slug": "160000-recovery-truck-accident",
"post": 3953,
"amount": "$160,000",
"legacy_post": 2201,
"desc": "Recovery for a client who underwent injections after a head-on collision with a dump truck"
},
{
"slug": "160000-settlement-workers-compensation",
"post": 3952,
"amount": "$160,000",
"legacy_post": 2200,
"desc": "$160,000 settlement for a client who suffered a fractured hip as the result of an on the job injury and had ongoing pain and physical limitations."
},
{
"slug": "155000-settlement-auto-accident",
"post": 3954,
"amount": "$155,000",
"legacy_post": 2202,
"desc": "Disputed liability settlement for a school teacher rear-ended by a tractor-trailer who underwent injections for injuries in her cervical and lumbar spine."
},
{
"slug": "150000-recovery-premises-liability",
"post": 3959,
"amount": "$150,000",
"legacy_post": 2207,
"desc": "Recovery for a parking lot trip fall with questionable liability but significant injuries."
},
{
"slug": "150000-resolution-auto-accident",
"post": 3958,
"amount": "$150,000",
"legacy_post": 2206,
"desc": "Policy limits tender for a gentleman injured in an auto accident who underwent a surgery."
},
{
"slug": "150000-settlement-auto-accident",
"post": 3955,
"amount": "$150,000",
"legacy_post": 2203,
"desc": "$150,000 settlement for an auto accident victim who underwent a surgical repair of a torn meniscus as the result on a rear impact automobile collision."
},
{
"slug": "150000-settlement-auto-accident-2",
"post": 3956,
"amount": "$150,000",
"legacy_post": 2204,
"desc": "$150,000 settlement for a client involved in a rollover accident who required facet injections and physical therapy."
},
{
"slug": "150000-settlement-auto-accident-3",
"post": 3957,
"amount": "$150,000",
"legacy_post": 2205,
"desc": "Policy limit recovery for client injured in a head on accident caused by drunk driver"
},
{
"slug": "150000-settlement-auto-accident-4",
"post": 3960,
"amount": "$150,000",
"legacy_post": 2208,
"desc": "Settlement for a woman who was side-swiped and required multiple cervical injections."
},
{
"slug": "150000-recovery-auto-accident",
"post": 3908,
"amount": "$150,000",
"legacy_post": 2973,
"desc": "Low impact auto accident that resulted in a surgical recommendation."
},
{
"slug": "150000-recovery-truck-accident",
"post": 3904,
"amount": "$150,000",
"legacy_post": 2977,
"desc": "Low impact rear end collision with a semi truck for a client who suffered soft tissue injuries."
},
{
"slug": "142000-recovery-truck-accident",
"post": 3905,
"amount": "$142,000",
"legacy_post": 2976,
"desc": "Low impact rear end collision with a semi truck for a client who suffered soft tissue injuries."
},
{
"slug": "140000-settlement-auto-accident",
"post": 3892,
"amount": "$140,000",
"legacy_post": 2209,
"desc": "Settlement for a shoulder injury resulting in surgery from a car accident."
},
{
"slug": "140000-settlement-auto-accident-2",
"post": 3961,
"amount": "$140,000",
"legacy_post": 2989,
"desc": "Presuit settlement for a client who underwent physical therapy and injections after a rear end collision."
},
{
"slug": "135000-recovery-auto-accident",
"post": 3962,
"amount": "$135,000",
"legacy_post": 2210,
"desc": "$135,000 for a driver who underwent a back surgery following an auto accident."
},
{
"slug": "135000-settlement-premises-liability",
"post": 3964,
"amount": "$135,000",
"legacy_post": 2212,
"desc": "Settlement for a young woman who was injured walking up a flight of stairs due to the property's failure to provide adequate lighting; liability was contested."
},
{
"slug": "135000-resolution-workers-compensation",
"post": 3963,
"amount": "$135,000",
"legacy_post": 2211,
"desc": "Successful resolution for a client who sustained 2nd degree steam burns to his chest and arm."
},
{
"slug": "130000-settlement-auto-accident",
"post": 3966,
"amount": "$130,000",
"legacy_post": 2214,
"desc": "Settlement for a lady who sustained an exacerbation to a pre-existing broken wrist after being side-swiped by a drunk driver. Her husband also received $75,000 for soft-tissue injuries to his neck."
},
{
"slug": "130000-settlement-workers-compensation",
"post": 3965,
"amount": "$130,000",
"legacy_post": 2213,
"desc": "$130,000 settlement for a housekeeping employee at a major hotel chain who underwent cervical and shoulder surgeries as the result of an on-the-job injury."
},
{
"slug": "130000-recovery-animal-attack",
"post": 3909,
"amount": "$130,000",
"legacy_post": 2971,
"desc": "Animal attack on an independent contractor at a preserve."
},
{
"slug": "125000-recovery-auto-accident",
"post": 3969,
"amount": "$125,000",
"legacy_post": 2217,
"desc": "Motorcyclist forced to lay bike down due to failure to yield suffered torn meniscus in knee."
},
{
"slug": "125000-settlement-auto-accident",
"post": 3970,
"amount": "$125,000",
"legacy_post": 2218,
"desc": "Policy limits tender for a client who sustained a low back injury when her work truck was rear-ended by a sleep deprived driver."
},
{
"slug": "125000-settlement-auto-accident-2",
"post": 3971,
"amount": "$125,000",
"legacy_post": 2219,
"desc": "Policy limits tender for a client who suffered a neck injury requiring surgery after a rear-end collision."
},
{
"slug": "125000-settlement-auto-accident-3",
"post": 3972,
"amount": "$125,000",
"legacy_post": 2220,
"desc": "Settlement for an elderly lady with pre-existing conditions who underwent a lumbar micro-decompression surgery after being involved in a minor rear end collision."
},
{
"slug": "125000-settlement-workers-compensation",
"post": 3967,
"amount": "$125,000",
"legacy_post": 2215,
"desc": "$125,000 third-party settlement for a worker injured by a falling stabilization bar while unloading a delivery truck."
},
{
"slug": "125000-resolution-auto-accident",
"post": 3968,
"amount": "$125,000",
"legacy_post": 2216,
"desc": "Policy limits tender for a gentleman who suffered neck injuries after a rear-end collision."
},
{
"slug": "123000-settlement-auto-accident",
"post": 3973,
"amount": "$123,000",
"legacy_post": 2221,
"desc": "Settlement for a passenger who suffered soft-tissue injuries to her back after a moderate rear-end collision."
},
{
"slug": "120000-recovery-auto-accident",
"post": 3976,
"amount": "$120,000",
"legacy_post": 2224,
"desc": "Recovery for a client who underwent neck surgery after a minor rear-end impact collision."
},
{
"slug": "120000-recovery-workers-compensation",
"post": 3974,
"amount": "$120,000",
"legacy_post": 2222,
"desc": "$120,000 for an employee who suffered injuries to both legs as the result of a workplace injury."
},
{
"slug": "120000-settlement-truck-accident",
"post": 3975,
"amount": "$120,000",
"legacy_post": 2223,
"desc": "Pre-suit settlement for a client who underwent a series of injections for a low back injury after being sideswiped by a semi-truck."
},
{
"slug": "117500-recovery-truck-accident",
"post": 3977,
"amount": "$117,500",
"legacy_post": 2225,
"desc": "Settlement for a client who suffered a shoulder injury when his platform lift truck was side swiped by a wide-turning semi."
},
{
"slug": "106000-recovery-workers-compensation",
"post": 3978,
"amount": "$106,000",
"legacy_post": 2226,
"desc": "$106,000 for an employee who suffered a hip injury as the result of a serious fall."
},
{
"slug": "103000-recovery-workers-compensation",
"post": 3979,
"amount": "$103,000",
"legacy_post": 2227,
"desc": "$103,000 for an employee injured in an auto accident who underwent a revision of a previous neck surgery."
},
{
"slug": "100000-policy-limits-auto-accident",
"post": 3893,
"amount": "$100,000",
"legacy_post": 2988,
"desc": "Policy limits recover for a woman who suffered back injuries after a rear end collision."
},
{
"slug": "100000-recovery-auto-accident",
"post": 3911,
"amount": "$100,000",
"legacy_post": 2243,
"desc": "Policy limit recovery for a client who sustained multiple injuries after his motorcycle was struck by a driver who failed to obey a stop sign."
},
{
"slug": "100000-recovery-auto-accident-2",
"post": 3921,
"amount": "$100,000",
"legacy_post": 2245,
"desc": "Policy limit tender for a client who was rear-ended and underwent a minimally invasive back surgery"
},
{
"slug": "100000-recovery-workers-compensation",
"post": 3981,
"amount": "$100,000",
"legacy_post": 2229,
"desc": "$100,000 for an employee who underwent a neck surgery but had good results."
},
{
"slug": "100000-recovery-workers-compensation-2",
"post": 3982,
"amount": "$100,000",
"legacy_post": 2230,
"desc": "Policy limit tender for an on-the-job driver involved in a motor vehicle accident."
},
{
"slug": "100000-resolution-auto-accident",
"post": 3912,
"amount": "$100,000",
"legacy_post": 2231,
"desc": "Policy limits tender for a lady who suffered minor wrist injuries in a DUI auto accident."
},
{
"slug": "100000-resolution-auto-accident-2",
"post": 3913,
"amount": "$100,000",
"legacy_post": 2232,
"desc": "Policy limits tender for a lady who suffered a brain bleed after an auto collision."
},
{
"slug": "100000-resolution-auto-accident-3",
"post": 3914,
"amount": "$100,000",
"legacy_post": 2233,
"desc": "Policy limits tender for a young women who sustained a broken toe after being hit by a vehicle in a mall crosswalk."
},
{
"slug": "100000-resolution-auto-accident-4",
"post": 3983,
"amount": "$100,000",
"legacy_post": 2234,
"desc": "Policy limits tender for a young man in a moderate rear-end collision who suffered soft tissue injuries."
},
{
"slug": "100000-resolution-auto-accident-5",
"post": 3984,
"amount": "$100,000",
"legacy_post": 2235,
"desc": "Policy limits tender for a lady that sustained a fractured wrist from an auto accident."
},
{
"slug": "100000-resolution-auto-accident-6",
"post": 3985,
"amount": "$100,000",
"legacy_post": 2236,
"desc": "Policy limit recovery for SCAD student who sustained a shoulder injury after her motorized scooter was struck by a driver who failed to obey a stop sign."
},
{
"slug": "100000-settlement-auto-accident",
"post": 3915,
"amount": "$100,000",
"legacy_post": 2237,
"desc": "Settlement for gentleman rear-ended while stopped at a stop light."
},
{
"slug": "100000-settlement-auto-accident-2",
"post": 3916,
"amount": "$100,000",
"legacy_post": 2238,
"desc": "Settlement for young woman who suffered a broken toe after being hit as a pedestrian in a parking lot."
},
{
"slug": "100000-settlement-auto-accident-3",
"post": 3917,
"amount": "$100,000",
"legacy_post": 2239,
"desc": "Settlement for a young man who required epidural injections after being rear-ended while at a stop."
},
{
"slug": "100000-settlement-auto-accident-4",
"post": 3918,
"amount": "$100,000",
"legacy_post": 2240,
"desc": "Settlement for a lady who suffered a broken wrist after a vehicle failed to yield while turning left in front of her."
},
{
"slug": "100000-settlement-auto-accident-5",
"post": 3919,
"amount": "$100,000",
"legacy_post": 2241,
"desc": "Policy limits settlement for a woman who suffered a brain bleed after being in a head-on collision."
},
{
"slug": "100000-settlement-auto-accident-6",
"post": 3920,
"amount": "$100,000",
"legacy_post": 2242,
"desc": "Policy limits settlement for young man who was in a head-on collision and suffered soft tissue damage to his knee."
},
{
"slug": "100000-settlement-auto-accident-7",
"post": 3922,
"amount": "$100,000",
"legacy_post": 2244,
"desc": "Policy limits tender for a client who suffered a neck injury requiring surgery after a rear-end collision."
},
{
"slug": "100000-settlement-auto-accident-8",
"post": 3925,
"amount": "$100,000",
"legacy_post": 2247,
"desc": "Policy limit tender for a man with pre-existing conditions who underwent physical therapy and injections after being rear ended at 45 mph by a driver who fell asleep at the wheel."
},
{
"slug": "100000-settlement-workers-compensation",
"post": 3924,
"amount": "$100,000",
"legacy_post": 2228,
"desc": "Workers' compensation settlement for a worker injured while driving to an off-site location that was involved in an auto collision."
},
{
"slug": "100000-settlement-workers-compensation-2",
"post": 3980,
"amount": "$100,000",
"legacy_post": 2246,
"desc": "Settlement for a worker who suffered an injury on the job and had to undergo a back operation."
},
{
"slug": "100000-recovery-auto-accident-3",
"post": 3923,
"amount": "$100,000",
"legacy_post": 2969,
"desc": "Car accident with minimal property damage and soft tissue injuries."
},
{
"slug": "100000-settlement-nursing-home",
"post": 3910,
"amount": "$100,000",
"legacy_post": 2970,
"desc": "Nursing home settlement."
},
{
"slug": "100000-recovery-work-injury",
"post": 3896,
"amount": "$100,000",
"legacy_post": 2985,
"desc": "Recovery for a client who was assaulted at her place of work by a drunk patron from his homeowner's insurance."
}
]
TABLE
, true );
if ( ! is_array( $rows ) || 156 !== count( $rows ) ) { fwrite( STDERR, "ABORT: table did not parse to 156 rows\n" ); exit( 1 ); }

$norm = function ( $s ) {
	$s = html_entity_decode( wp_strip_all_tags( (string) $s ), ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	$s = str_replace( array( "\u{2019}", "\u{2018}", "\u{201C}", "\u{201D}", "\u{00A0}" ), array( "'", "'", '"', '"', ' ' ), $s );
	$s = strtolower( preg_replace( '/\s+/', ' ', $s ) );
	return trim( preg_replace( '/[^a-z0-9 ]/', '', $s ) );
};

$fail = 0; $plan = array(); $agree = array( 'match' => 0, 'differs' => 0, 'no legacy body' => 0 );
foreach ( $rows as $r ) {
	$p = get_post( $r['post'] );
	if ( ! $p || 'case_result' !== $p->post_type || 'publish' !== $p->post_status || $p->post_name !== $r['slug'] ) {
		fwrite( STDERR, "MISMATCH {$r['post']}: not the published case_result {$r['slug']}\n" ); $fail++; continue;
	}
	$amount = preg_replace( '/\D/', '', (string) get_post_meta( $p->ID, '_roden_case_amount', true ) );
	if ( $amount !== preg_replace( '/\D/', '', $r['amount'] ) ) {
		fwrite( STDERR, "MISMATCH {$r['slug']}: amount on post is '$amount', table says {$r['amount']}\n" ); $fail++; continue;
	}
	$legacy = get_post( $r['legacy_post'] );
	$lbody  = ( $legacy && 'case-result' === $legacy->post_type ) ? $norm( $legacy->post_content ) : '';

	if ( isset( $r['choose'] ) ) {
		$hit = array_values( array_filter( $r['choose'], function ( $c ) use ( $norm, $lbody ) { return '' !== $lbody && $norm( $c ) === $lbody; } ) );
		if ( 1 !== count( $hit ) ) { fwrite( STDERR, "AMBIGUOUS {$r['slug']}: legacy {$r['legacy_post']} body matches " . count( $hit ) . " candidates: '$lbody'\n" ); $fail++; continue; }
		$desc = $hit[0];
	} else {
		$desc = $r['desc'];
	}
	$check = '' === $lbody ? 'no legacy body' : ( $norm( $desc ) === $lbody ? 'match' : 'differs' );
	$agree[ $check ]++;
	if ( 'differs' === $check ) { fwrite( STDERR, "NOTE {$r['slug']}: legacy body differs: '$lbody'\n" ); }

	$before = get_post_meta( $p->ID, '_roden_description', true );
	$plan[] = array( 'post' => $p->ID, 'slug' => $r['slug'], 'before' => $before, 'after' => $desc, 'legacy_check' => $check, 'changed' => $before !== $desc );
}
if ( $fail ) { fwrite( STDERR, "ABORT: $fail problems, nothing written\n" ); exit( 1 ); }

$changes = array_filter( $plan, function ( $x ) { return $x['changed']; } );
$replaced = array_filter( $changes, function ( $x ) { return '' !== (string) $x['before']; } );
fwrite( STDERR, sprintf( "%s %d of %d (%d replace an existing value); legacy body: %d match, %d differ, %d absent\n",
	$apply ? 'writing' : 'would write', count( $changes ), count( $plan ), count( $replaced ), $agree['match'], $agree['differs'], $agree['no legacy body'] ) );
foreach ( $replaced as $x ) { fwrite( STDERR, "  replace {$x['slug']}: '{$x['before']}' -> '{$x['after']}'\n" ); }

if ( $apply ) {
	global $wpdb;
	foreach ( $changes as $x ) {
		update_post_meta( $x['post'], '_roden_description', wp_slash( $x['after'] ) );
		wp_cache_delete( $x['post'], 'post_meta' );
		$back = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = '_roden_description'", $x['post'] ) );
		if ( $back !== $x['after'] ) { fwrite( STDERR, "FAILED read-back {$x['post']}\n" ); exit( 1 ); }
	}
	fwrite( STDERR, "read-back OK for " . count( $changes ) . " posts\n" );
}
echo wp_json_encode( array( 'generated' => gmdate( 'c' ), 'mode' => $apply ? 'apply' : 'dry-run', 'rows' => $plan ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
