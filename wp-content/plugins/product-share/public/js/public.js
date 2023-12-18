( function ( $ ) {

    var publicObj = public_js_object,
        clicks = 0;

    // Copy Product URL
    $( 'a[id=psfw-copy-link]' ).on( 'click', function( e ){

        e.preventDefault();

        var product_url;

        product_url = $( 'a[id=psfw-copy-link]' ).attr('data-url');

        // Callback function for copy product URL
        if(navigator.clipboard) {

            navigator.clipboard.writeText(product_url);

            $( '.psfw-clipboard' ).removeClass('fa-clipboard').addClass('fa-clipboard-check');
            $( '.psfw-clipboard-text' ).text(publicObj.copied_to_clipboard_text);

            setTimeout(function(){
                $( '.psfw-clipboard' ).removeClass('fa-clipboard-check').addClass('fa-clipboard');
                $( '.psfw-clipboard-text' ).text(publicObj.copy_to_clipboard_text);
            }, 800);

        }

        else{

            alert('Please make sure you have a secure connection. For example: https://example.com ');

        }

    } );

    // All Icon Button
    $( 'a[id=psfw-all-icon]' ).on( 'click', function( e ){

        e.preventDefault();

        if (clicks == 0) {
            $( '.psfw-popup-container' ).addClass( 'open' );
            clicks++;
        }
        else{
            $( '.psfw-popup-container' ).removeClass( 'open' );
            clicks--;
        }
    } );
    // Closing popup if clicking on outside of the popup
      $('.psfw-popup-container').on('click', function( e ){

        var target = $(e.target);
        if(target.is('.psfw-popup-container') && !target.is('.psfw-all-icon')) {
          $( '.psfw-popup-container' ).removeClass( 'open' );
          clicks--;
        }
        
      });
    
} )( jQuery );