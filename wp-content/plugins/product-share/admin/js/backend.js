(function ($) {

    $(document).ready(function(){

      // Toggle for all icons

      $('.more-icons').on('click', function(e){

        var link = $(this);

        e.preventDefault();
        $('.all-icons').slideToggle('slow', function(){
          if ($(this).is(':visible')) {
            link.addClass('close');
          }
          else {
            link.removeClass('close');                
          }   
        });

      });

      // Push Social Icons to display on click

      $( "#base-list li input[type='checkbox']" ).on( "click", function(){
        var icon = $(this).closest("li").attr( "id" );

        if($(this).prop("checked") == true){
           if( icon === 'envelope' ){
              $( "#sortable" ).append('<li id="list_item_'+icon+'"><label><input type="hidden" value="'+icon+'" name="product_share_option[buttons]['+icon+']"><span><i class="fa-solid fa-'+icon+'"></i> Email</span></label></li>');
           }
           else if( icon === 'pocket' ){
              $( "#sortable" ).append('<li id="list_item_'+icon+'"><label><input type="hidden" value="'+icon+'" name="product_share_option[buttons]['+icon+']"><span><i class="fa-brands fa-get-'+icon+'"></i> '+icon+'</span></label></li>');     
           }
           else{

              $( "#sortable" ).append('<li id="list_item_'+icon+'"><label><input type="hidden" value="'+icon+'" name="product_share_option[buttons]['+icon+']"><span><i class="fa-brands fa-'+icon+'"></i> '+icon+'</span></label></li>');     
           }
        }
        else if($(this).prop("checked") == false){
             $( "#sortable li#list_item_"+icon ).remove();
         }
      } );


    	// Sortable table header
	
        $('.sortable').sortable({
          items: 'li',
          cursor: 'move',
          scrollSensitivity: 100,
          helper: function( event, ui ) {
            ui.children().each( function() {
              $( this ).width( $( this ).width() );
            });
            return ui;
          },
        });

        // Color Picker
        $('.color-field').wpColorPicker();


    });

}(jQuery));