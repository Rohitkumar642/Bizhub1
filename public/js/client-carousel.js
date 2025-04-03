(function($) {
	
	"use strict";
	var client_carousels_script_js = function($scope, $) {
		
		// Five Item Carousel
		if ($('.five-item-carousel').length) {
			var slider_attr = $('.five-item-carousel').data('client-slider');
			$('.five-item-carousel').owlCarousel({
				loop:slider_attr.loop,
				margin:slider_attr.spacebetween,
				nav:true,
				smartSpeed: 500,
				autoplay: 1000,
				responsive:{
					0:{
						items:1
					},
					480:{
						items:2
					},
					600:{
						items:3
					},
					800:{
						items:4
					},			
					1200:{
						items:slider_attr.slidesperview,
					}
				}
			});    		
		}
						
	};
	$(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction('frontend/element_ready/financer_clients_carousel.default', client_carousels_script_js);
    });	

})(window.jQuery);