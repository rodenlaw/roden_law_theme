<?php
/**
 * Intake Webhook — forward every Gravity Forms lead to the intake system.
 *
 * Covers BOTH submission paths used on this site:
 *   1. Native Gravity Forms front-end submissions  → gform_after_submission
 *   2. The custom AJAX sidebar/landing-page handler → roden_sidebar_form_handler()
 *      (creates entries via GFAPI::add_entry(), which does NOT fire the normal
 *       gform_after_submission lifecycle, so it calls the sender explicitly).
 *
 * Payload: a normalized JSON lead object (see roden_intake_payload_from_entry).
 * Auth:    the per-source secret token is embedded in the endpoint path.
 *
 * The URL can be overridden without editing code via either:
 *   - define( 'RODEN_INTAKE_WEBHOOK_URL', '...' ) in wp-config.php, or
 *   - the 'roden_intake_webhook_url' filter.
 *
 * @package Roden_Law
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default intake endpoint. Override via the RODEN_INTAKE_WEBHOOK_URL constant
 * (wp-config.php) to keep the secret token out of version control if desired.
 */
if ( ! defined( 'RODEN_INTAKE_WEBHOOK_URL' ) ) {
	define( 'RODEN_INTAKE_WEBHOOK_URL', 'https://intrial-server-prod.up.railway.app/webhooks/intake/733ecf5454985acdc9920a9bd3566c3b0f90cd4f4b6d0b15a5190a464e334880' );
}

/**
 * Resolve the intake webhook URL (filterable).
 *
 * @return string
 */
function roden_intake_webhook_url() {
	return (string) apply_filters( 'roden_intake_webhook_url', RODEN_INTAKE_WEBHOOK_URL );
}

/**
 * Native Gravity Forms submissions: forward to intake after the entry is saved.
 * No form-ID suffix on the hook → fires for ALL forms.
 *
 * @param array $entry GF entry.
 * @param array $form  GF form.
 */
add_action( 'gform_after_submission', 'roden_intake_after_submission', 10, 2 );
function roden_intake_after_submission( $entry, $form ) {
	roden_send_lead_to_intake( $entry, $form );
}

/**
 * Build the normalized lead payload and POST it to the intake system.
 *
 * @param array $entry GF entry (or entry-shaped array).
 * @param array $form  GF form definition (may be empty if unavailable).
 * @return bool True on a 2xx response, false otherwise.
 */
function roden_send_lead_to_intake( $entry, $form = array() ) {
	$payload = roden_intake_payload_from_entry( $entry, $form );
	return roden_intake_post( $payload );
}

/**
 * Normalize a Gravity Forms entry + form into a flat lead payload.
 *
 * Detects fields by type so it works for any form, not just form 1:
 *   name → first_name/last_name, email → email, phone → phone, etc.
 * Also includes a raw_fields map (field id → value) and the labeled
 * answers so nothing is lost if the intake side needs an unmapped field.
 *
 * @param array $entry GF entry.
 * @param array $form  GF form definition.
 * @return array
 */
function roden_intake_payload_from_entry( $entry, $form = array() ) {
	$first_name = '';
	$last_name  = '';
	$email      = '';
	$phone      = '';
	$case_type  = '';
	$message    = '';
	$labeled    = array();
	$raw_fields = array();

	$fields = ( is_array( $form ) && ! empty( $form['fields'] ) ) ? $form['fields'] : array();

	foreach ( $fields as $field ) {
		$id    = isset( $field->id ) ? $field->id : ( is_array( $field ) ? rgar( $field, 'id' ) : '' );
		$type  = isset( $field->type ) ? $field->type : ( is_array( $field ) ? rgar( $field, 'type' ) : '' );
		$label = isset( $field->label ) ? $field->label : ( is_array( $field ) ? rgar( $field, 'label' ) : '' );

		if ( '' === $id || in_array( $type, array( 'html', 'section', 'page', 'captcha' ), true ) ) {
			continue;
		}

		switch ( $type ) {
			case 'name':
				$first_name = trim( (string) rgar( $entry, $id . '.3' ) );
				$last_name  = trim( (string) rgar( $entry, $id . '.6' ) );
				$value      = trim( $first_name . ' ' . $last_name );
				break;

			case 'email':
				$email = trim( (string) rgar( $entry, $id ) );
				$value = $email;
				break;

			case 'phone':
				$phone = trim( (string) rgar( $entry, $id ) );
				$value = $phone;
				break;

			default:
				// Multi-input fields (checkbox, etc.) flatten via GF's own helper.
				$value = function_exists( 'rgar' ) ? (string) rgar( $entry, $id ) : '';
				if ( '' === $value && function_exists( 'GFFormsModel' ) ) {
					$value = (string) GFFormsModel::get_lead_field_value( $entry, $field );
				}
				// Heuristic mapping for common labels when types are generic.
				$llabel = strtolower( (string) $label );
				if ( '' === $case_type && ( false !== strpos( $llabel, 'case' ) || false !== strpos( $llabel, 'practice' ) || false !== strpos( $llabel, 'matter' ) ) ) {
					$case_type = $value;
				}
				if ( '' === $message && ( 'textarea' === $type || false !== strpos( $llabel, 'message' ) || false !== strpos( $llabel, 'detail' ) || false !== strpos( $llabel, 'describe' ) ) ) {
					$message = $value;
				}
				break;
		}

		if ( '' !== $value ) {
			$labeled[ (string) $label ] = $value;
		}
	}

	// Raw field map (id → value) for anything the loop above didn't surface.
	foreach ( (array) $entry as $key => $val ) {
		if ( is_numeric( $key ) && '' !== (string) $val ) {
			$raw_fields[ (string) $key ] = (string) $val;
		}
	}

	$form_id    = (string) rgar( $entry, 'form_id' );
	$entry_id   = (string) rgar( $entry, 'id' );
	$source_url = (string) rgar( $entry, 'source_url' );

	// gclid / hl_variant / lead_language are stored as entry meta by the AJAX handler.
	$gclid      = $entry_id && function_exists( 'gform_get_meta' ) ? (string) gform_get_meta( $entry_id, 'gclid' ) : '';
	$hl_variant = $entry_id && function_exists( 'gform_get_meta' ) ? (string) gform_get_meta( $entry_id, 'hl_variant' ) : '';
	$language   = $entry_id && function_exists( 'gform_get_meta' ) ? (string) gform_get_meta( $entry_id, 'lead_language' ) : '';

	// Fallback: infer Spanish from the submitting page URL (/es/…).
	if ( ! $language ) {
		$src_path = (string) wp_parse_url( (string) rgar( $entry, 'source_url' ), PHP_URL_PATH );
		$language = preg_match( '#^/es(/|$)#', $src_path ) ? 'es' : 'en';
	}

	$payload = array(
		'event_id'     => function_exists( 'wp_generate_uuid4' ) ? wp_generate_uuid4() : md5( $entry_id . $source_url . $phone ),
		'source'       => 'wordpress-gravity-forms',
		'site'         => home_url(),
		'submitted_at' => rgar( $entry, 'date_created' ) ? mysql2date( 'c', rgar( $entry, 'date_created' ) ) : current_time( 'c' ),
		'first_name'   => $first_name,
		'last_name'    => $last_name,
		'email'        => $email,
		'phone'        => $phone,
		'case_type'    => $case_type,
		'message'      => $message,
		'form_id'      => $form_id,
		'form_title'   => is_array( $form ) ? (string) rgar( $form, 'title' ) : '',
		'entry_id'     => $entry_id,
		'source_url'   => $source_url,
		'gclid'        => $gclid,
		'hl_variant'   => $hl_variant,
		'language'     => $language,
		'ip'           => (string) rgar( $entry, 'ip' ),
		'user_agent'   => (string) rgar( $entry, 'user_agent' ),
		'labeled'      => $labeled,
		'raw_fields'   => $raw_fields,
	);

	// Pull utm_* out of the source URL query string when present.
	$payload = array_merge( $payload, roden_intake_utm_from_url( $source_url ) );

	/**
	 * Filter the outgoing intake payload (final say before send).
	 *
	 * @param array $payload Normalized lead payload.
	 * @param array $entry   GF entry.
	 * @param array $form    GF form.
	 */
	return apply_filters( 'roden_intake_payload', $payload, $entry, $form );
}

/**
 * Extract utm_* parameters from a URL's query string.
 *
 * @param string $url
 * @return array Associative array of utm_* keys (only those present).
 */
function roden_intake_utm_from_url( $url ) {
	$out = array();
	if ( ! $url ) {
		return $out;
	}
	$query = (string) wp_parse_url( $url, PHP_URL_QUERY );
	if ( '' === $query ) {
		return $out;
	}
	parse_str( $query, $params );
	foreach ( array( 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content' ) as $k ) {
		if ( ! empty( $params[ $k ] ) ) {
			$out[ $k ] = sanitize_text_field( wp_unslash( $params[ $k ] ) );
		}
	}
	return $out;
}

/**
 * POST a payload to the intake endpoint. Logs failures; never throws.
 *
 * @param array $payload
 * @return bool True on 2xx, false otherwise.
 */
function roden_intake_post( array $payload ) {
	$url = roden_intake_webhook_url();
	if ( ! $url ) {
		return false;
	}

	$response = wp_remote_post(
		$url,
		array(
			'timeout'  => 12,
			'blocking' => true,
			'headers'  => array(
				'Content-Type'     => 'application/json',
				'Accept'           => 'application/json',
				'X-Webhook-Source' => 'rodenlaw-wp',
			),
			'body'     => wp_json_encode( $payload ),
		)
	);

	if ( is_wp_error( $response ) ) {
		error_log( '[roden-intake] webhook error: ' . $response->get_error_message() . ' | entry ' . ( $payload['entry_id'] ?? '?' ) );
		return false;
	}

	$code = (int) wp_remote_retrieve_response_code( $response );
	if ( $code < 200 || $code >= 300 ) {
		error_log( '[roden-intake] webhook non-2xx (' . $code . '): ' . wp_remote_retrieve_body( $response ) . ' | entry ' . ( $payload['entry_id'] ?? '?' ) );
		return false;
	}

	return true;
}
