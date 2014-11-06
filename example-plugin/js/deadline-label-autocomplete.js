jQuery( document ).ready( function( $ ){

	$( '#event_date_deadline_label' ).autocomplete( {
		source: ajaxurl + '?action=event_deadline_label',
		minLength: 2
	} );

} );
