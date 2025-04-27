jQuery(document).ready(function(){
	jQuery('.site-navigation').before('<div class="mobile-trigger"><i></i></div>');

	jQuery(".mobile-trigger").click(function(){
		jQuery(this).toggleClass('active');
		jQuery('body').toggleClass('mobile-open');
	});

	jQuery(document).on("click touchstart",function(event){
			if (jQuery(event.target).parents(".header-top").length < 1 && !jQuery(event.target).hasClass("header-top"))
			{
			jQuery("body").removeClass("mobile-open");
			}
	});

	loadServiceImage();
    
    jQuery(".main-service-content p img.alignright").parent().addClass("img-outer-right");
    jQuery(".main-service-content p img.alignleft").parent().addClass("img-outer-left");
    jQuery(".main-service-content p img.aligncenter").parent().addClass("img-outer-center");
    
});

jQuery(window).resize(function(){
    loadServiceImage();
});

function loadServiceImage(){
    var width = jQuery(document).width();
    var banner_background = jQuery("#service_image_src");
    if(width >= 768){
        var image_2 = jQuery(banner_background).attr("data-desktop-img");
        banner_background.attr("src",image_2);
    }
    else{
        var image_2 = jQuery(banner_background).attr("data-mobile-img");
        banner_background.attr("src",image_2);
    }
}


	
	


