jQuery(function( $ ){

	jQuery(document).ready(function(){
    	var height = jQuery(window).height() - 58;
    	jQuery('.home-widget').css({"height": height+"px"});

    	jQuery( '.mobile_menu button' ).click(function(){
            if( jQuery('body').hasClass( 'mobile_nav_enable' ) ){
                jQuery('body').removeClass('mobile_nav_enable');
            }else{
                jQuery('body').addClass('mobile_nav_enable');    
            }
       });


		// Newsletter modal close
		jQuery('.sign_up_close').click(function(){
			jQuery('.sign_up').hide();
		});
		jQuery( '.wfs_hero_label a.wfs_button' ).click(function(e){
			e.preventDefault();
			jQuery('.sign_up').show();
		});
    });

    jQuery(window).resize(function(){
    	var height = jQuery(window).height() - 58;
    	jQuery('.home-widget').css({"height": height+"px"});
    });
});