( function( $ ){
    $( document ).ready( function(){
						
      $( '.best-shop-btn-get-started' ).on( 'click', function( e ) {
          e.preventDefault();
          $( this ).html( 'Processing... Please wait' ).addClass( 'updating-message' );
          $.post( best_shop_ajax_object.ajax_url, { 'action' : 'install_act_plugin' }, function( response ){
              location.href = 'themes.php?page=advanced-import';
          } );
      } );
    } );

}( jQuery ) )