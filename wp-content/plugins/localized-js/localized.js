jQuery( document ).ready( function( $ ) {

	$('#localizedjs_click').on( 'click', function( e ) {
		e.preventDefault();
		$(this).blur();
		ajaxdata = {
			  'action' : 'drawanswer',
			'_wpnonce' : localizedjs_msg.wpnonce,
		};
		$.post( ajaxurl, ajaxdata, function( response ) {
			try {
				data = JSON.parse( response );
				if ( data.answer == 1 ) {
					$('#answer').html( localizedjs_msg.answer_one + data.dt );
				} else if ( data.answer == 2 ) {
					$('#answer').html( localizedjs_msg.answer_two + data.dt );
				} else {
					$('#answer').html( localizedjs_msg.error );
				}
			} catch( e ) {
				alert( localizedjs_msg.error );
			}
		} );
	} );

} );