( function( $ ) {
    $( document ).ready( function() {

        $( '.radio_include' ).on( 'change', function () {
            if ( $( '#posts' ).is( ':checked' ) ) {
                $( '#posts_ids' ).show();
            } else {
                $( '#posts_ids' ).hide();
            }
        } ).trigger( 'change' );

    } );
} )( jQuery );