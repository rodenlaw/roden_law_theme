#!/bin/bash
# Batch import images as featured images
# Run on WP Engine server: bash wp-content/themes/roden-law/inc/set-featured-images.sh

cd /nas/content/live/rodenlawdev1 2>/dev/null || cd ~/sites/rodenlawdev1

declare -A IMAGE_MAP
IMAGE_MAP["can-a-police-report-help-prove-liability.png"]="1731|Can a Police Report Help Prove Liability After an Accident?"
IMAGE_MAP["can-insurance-companies-go-against-police-report.png"]="1679|Can an Insurance Company Go Against a Police Report in Georgia or South Carolina?"
IMAGE_MAP["can-someone-sue-me-for-a-car-accident.png"]="1675|Can Someone Sue Me For A Car Accident?"
IMAGE_MAP["car-accident-checklist.png"]="1671|Car Accident Checklist - 8 Steps to Take after your Wreck"
IMAGE_MAP["car-accident-claims-why-you-need-an-attorney.png"]="1688|Car Accident Claims: Why You Need an Attorney for Maximum Compensation"
IMAGE_MAP["concussion-signs-after-car-accident.png"]="1835|Concussion Signs to Watch Out for After a Car Accident"
IMAGE_MAP["determining-fault-after-georgia-car-accident.png"]="1836|Determining Fault After a Georgia Car Accident"
IMAGE_MAP["do-traffic-tickets-play-role-in-claim.png"]="1740|Do Traffic Tickets Play a Role in a Car Accident Claim?"
IMAGE_MAP["does-daylight-saving-time-increase-car-accidents.png"]="1791|Does Daylight Saving Time Increase Car Accidents?"
IMAGE_MAP["filing-a-car-accident-claim-as-passenger.png"]="1804|Filing a Car Accident Claim as a Passenger"
IMAGE_MAP["filing-claim-against-deceased-driver.png"]="1649|Filing a Claim Against a Deceased At-Fault Driver: What to Know"
IMAGE_MAP["filing-claim-for-teen-driver-accident.png"]="1733|Filing a Claim for an Accident Caused by a Teen Driver"
IMAGE_MAP["how-dashcam-footage-can-help.png"]="1779|How Dashcam Footage Can Help Prove Fault for a Car Accident"
IMAGE_MAP["how-social-media-can-hurt-accident-claim.png"]="1776|How Using Social Media Can Hurt an Accident Claim"
IMAGE_MAP["how-to-avoid-blind-spot-accident.png"]="1831|How to Avoid a Blind Spot Accident"
IMAGE_MAP["liability-for-accident-during-heavy-rainfall.png"]="1716|Determining Liability for Accidents During Heavy Rainfall"
IMAGE_MAP["liability-in-rear-end-accident.png"]="1780|Liability in a Rear-End Car Accident"
IMAGE_MAP["types-of-major-injuries-from-minor-accidents.png"]="1763|Types of Major Injuries From Minor Car Accidents"
IMAGE_MAP["what-evidence-is-useful-in-car-accident-claim.png"]="1807|What Evidence is Useful in a Car Accident Claim?"
IMAGE_MAP["what-georgia-law-requires-after-accident.png"]="1766|What Georgia Law Requires Drivers to do After an Accident"
IMAGE_MAP["what-if-at-fault-driver-offers-cash.png"]="2709|What if an At-Fault Driver Offers Cash After a Savannah Car Crash?"
IMAGE_MAP["what-is-difference-fault-no-fault-state.png"]="1749|What is the Difference Between a Fault and No-Fault State for Car Crash Claims?"
IMAGE_MAP["what-makes-car-accident-witness-credible.png"]="1758|What Makes a Car Accident Witness Credible?"
IMAGE_MAP["who-may-be-liable-lane-change-accident.png"]="1734|Who May Be Liable for a Lane-Change Accident?"
IMAGE_MAP["why-fault-complicated-multi-vehicle-crash.png"]="1773|Why Fault Can be Complicated in a Multi-Vehicle Crash"

SUCCESS=0
ERRORS=0

for filename in "${!IMAGE_MAP[@]}"; do
    IFS='|' read -r POST_ID ALT_TEXT <<< "${IMAGE_MAP[$filename]}"
    FILEPATH="wp-content/uploads/${filename}"

    if [ ! -f "$FILEPATH" ]; then
        echo "ERROR: File not found: $FILEPATH"
        ((ERRORS++))
        continue
    fi

    # Import via wp media import
    ATT_ID=$(wp media import "$FILEPATH" --title="$ALT_TEXT" --alt="$ALT_TEXT" --porcelain 2>/dev/null)

    if [ -z "$ATT_ID" ]; then
        echo "ERROR: Failed to import $filename"
        ((ERRORS++))
        continue
    fi

    # Set as featured image
    wp post meta update "$POST_ID" _thumbnail_id "$ATT_ID" --quiet 2>/dev/null

    echo "OK: Post $POST_ID => attachment $ATT_ID ($filename)"
    ((SUCCESS++))

    # Remove source file
    rm -f "$FILEPATH"
done

echo ""
echo "Done. Success: $SUCCESS, Errors: $ERRORS"
