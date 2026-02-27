/**
 * Roden Law — Admin Meta Box JS
 *
 * Handles repeater field add/remove for:
 *   - FAQs (question + answer)
 *   - Education (degree + institution)
 *   - Awards (award + year)
 *
 * @package Roden_Law
 */
( function( $ ) {
    'use strict';

    /* ── FAQ Repeater ──────────────────────────────────────────── */

    $( '#roden-add-faq' ).on( 'click', function() {
        var container = $( '#roden-faq-container' );
        var n = container.find( '.roden-repeater-row' ).length;
        var html =
            '<div class="roden-repeater-row" style="margin-bottom:15px;padding:10px;background:#f9f9f9;border:1px solid #ddd;position:relative;">' +
                '<span class="roden-remove-row" style="position:absolute;top:5px;right:8px;cursor:pointer;color:#a00;font-size:18px;" title="Remove">&times;</span>' +
                '<p><label><strong>Question ' + ( n + 1 ) + ':</strong></label><br>' +
                '<input type="text" name="_roden_faqs[' + n + '][question]" value="" style="width:100%;"></p>' +
                '<p><label><strong>Answer:</strong></label><br>' +
                '<textarea name="_roden_faqs[' + n + '][answer]" rows="3" style="width:100%;"></textarea></p>' +
            '</div>';
        container.append( html );
    } );

    /* ── Education Repeater ────────────────────────────────────── */

    $( '#roden-add-education' ).on( 'click', function() {
        var container = $( '#roden-education-container' );
        var n = container.find( '.roden-repeater-row' ).length;
        var html =
            '<div class="roden-repeater-row" style="margin-bottom:10px;padding:10px;background:#f9f9f9;border:1px solid #ddd;display:flex;gap:10px;align-items:flex-start;position:relative;">' +
                '<span class="roden-remove-row" style="position:absolute;top:5px;right:8px;cursor:pointer;color:#a00;font-size:18px;" title="Remove">&times;</span>' +
                '<div style="flex:1;"><label>Degree:</label><br>' +
                '<input type="text" name="_roden_education[' + n + '][degree]" value="" style="width:100%;" placeholder="J.D."></div>' +
                '<div style="flex:1;"><label>Institution:</label><br>' +
                '<input type="text" name="_roden_education[' + n + '][institution]" value="" style="width:100%;" placeholder="University of Georgia School of Law"></div>' +
            '</div>';
        container.append( html );
    } );

    /* ── Awards Repeater ───────────────────────────────────────── */

    $( '#roden-add-award' ).on( 'click', function() {
        var container = $( '#roden-awards-container' );
        var n = container.find( '.roden-repeater-row' ).length;
        var html =
            '<div class="roden-repeater-row" style="margin-bottom:10px;padding:10px;background:#f9f9f9;border:1px solid #ddd;display:flex;gap:10px;align-items:flex-start;position:relative;">' +
                '<span class="roden-remove-row" style="position:absolute;top:5px;right:8px;cursor:pointer;color:#a00;font-size:18px;" title="Remove">&times;</span>' +
                '<div style="flex:2;"><label>Award:</label><br>' +
                '<input type="text" name="_roden_awards[' + n + '][award]" value="" style="width:100%;" placeholder="Super Lawyers Rising Star"></div>' +
                '<div style="flex:1;max-width:100px;"><label>Year:</label><br>' +
                '<input type="text" name="_roden_awards[' + n + '][year]" value="" style="width:100%;" placeholder="2024"></div>' +
            '</div>';
        container.append( html );
    } );

    /* ── Remove Row (delegated — works for dynamically added rows) */

    $( document ).on( 'click', '.roden-remove-row', function() {
        var row = $( this ).closest( '.roden-repeater-row' );
        var container = row.parent();

        // Don't remove the last row — just clear its fields
        if ( container.find( '.roden-repeater-row' ).length <= 1 ) {
            row.find( 'input, textarea' ).val( '' );
            return;
        }

        row.fadeOut( 200, function() {
            $( this ).remove();
        } );
    } );

} )( jQuery );
