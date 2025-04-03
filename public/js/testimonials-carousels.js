(function($) {
	
	"use strict";
	var testimonails_carousels_script_js = function($scope, $) {
		
		// Three Item Carousel
		if ($('.three-item-carousel').length) {
			var slider_attrs = $('.three-item-carousel').data('slider-testi');
			$('.three-item-carousel').owlCarousel({
				loop:slider_attrs.loop,
				margin:slider_attrs.spacebetween,
				nav:true,
				smartSpeed: 500,
				autoplay: 1000,
				responsive:{
					0:{
						items:1
					},
					480:{
						items:1
					},
					600:{
						items:1
					},
					800:{
						items:2
					},			
					1200:{
						items:slider_attrs.slidesperview
					}
	
				}
			});    		
		}
		
		// Single Item Carousel
		if ($('.single-item-carousel').length) {
			var slider_attrs_two = $('.single-item-carousel').data('slider-testi-two');
			$('.single-item-carousel').owlCarousel({
				loop:slider_attrs_two.loop,
				margin:slider_attrs_two.spacebetween,
				nav:true,
				smartSpeed: 500,
				autoplay: 1000,
				navText:[ '<span class="icon-13"></span>', '<span class="icon-13"></span>' ],
				responsive:{
					0:{
						items:1
					},
					480:{
						items:1
					},
					600:{
						items:1
					},
					800:{
						items:1
					},			
					1200:{
						items:slider_attrs_two.slidesperview
					}
				}
			});
		}
		
	};
	$(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction('frontend/element_ready/financer_testimonials_carousel.default', testimonails_carousels_script_js);
    });	

})(window.jQuery);