
(function ($) {
	'use strict';
	
	/* Preloader */
	var win = $(window);
	win.on('load',function() {
		$('.page-loader').delay(100).fadeOut('slow');
	});	
	
	/* Menu */
	$('#mobile-menu').meanmenu({
		meanMenuContainer: '.mobile-menu-area',
		meanScreenWidth: "767"
	});
	
	/* scrollToTop */
	$(".scroll-to-top").scrollToTop(1000);
	
	/* Top Menu Stick  */
	win.on('scroll',function() {
	if ($(this).scrollTop() > 100){
		$('#sticky-header').removeClass("slideIn animated");
		$('#sticky-header').addClass("sticky slideInDown animated");
		$("#design-two-logo").attr("src","images/logo.png");
	  }
	  else{
		$('#sticky-header').removeClass("sticky slideInDown animated");
		$('#sticky-header').addClass("slideIn animated");
		$("#design-two-logo").attr("src","images/logo-2.png");
	  }
	}); 

	/* // Slider Carousel 
	$('.slider-active').owlCarousel({
		loop: true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		nav: true,
		autoplay: true,
		autoplayTimeout: 7000,
		animateOut: 'fadeOut',
		animateIn: 'fadeIn',
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 1
			},
			991: {
				items: 1
			},
			1200: {
				items: 1
			},
			1920: {
				items: 1
			}
		}
	}); */
	
    // Owl Carousel Animation
    // $('.slider-active').on('translate.owl.carousel', function () {
        // $('.slider-content h2').removeClass('fadeInDown animated').hide();
        // $('.slider-content p').removeClass('fadeInDown animated').hide();
        // $('.slider-content .btn').removeClass('fadeInUp animated').hide();
    // });
    // $('.slider-active').on('translated.owl.carousel', function () {
        // $('.slider-content h2').addClass('fadeInDown animated').show();
        // $('.slider-content p').addClass('fadeInDown animated').show();
        // $('.slider-content .btn').addClass('fadeInUp animated').show();
    // });
	
	/* Testimonial Active Carousel */
	$('.testimonial-active-1').owlCarousel({
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        loop: true,
        nav: true,
        autoplay: true,
        autoplayTimeout: 5000,
        mouseDrag: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
	});
	
	/* Testimonial Active Carousel */
	$('.testimonial-active-2').owlCarousel({
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        loop: true,
        nav: true,
        autoplay: true,
        autoplayTimeout: 5000,
        mouseDrag: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 2
            }
        }
	});
	
	/* Testimonial Active Carousel */
	$('.testimonial-active-3').owlCarousel({
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        loop: true,
        nav: true,
        autoplay: true,
        autoplayTimeout: 5000,
        mouseDrag: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        responsive: {
            0: {
                items: 1
            },
            700: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
	});

	/* Blog Active Carousel */
	$('.blog-active').owlCarousel({
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        loop: true,
		items:3,
        nav: true,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
	}); 
	
	/* Partners Active Carousel */
	$('.partners-active').owlCarousel({
        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        loop: true,
		items:5,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 2
            },
            450: {
                items: 3
            },
            767: {
                items: 4
            },
            1000: {
                items: 5
            }
        }
	}); 
	
	/* Isotope */
    $(window).on('load', function () {
        var isotope_content = $('.portfolio-content');    
        isotope_content.isotope({
            itemSelector: '.portfolio-item',
            percentPosition: true,
            masonry: {
              // use outer width of grid-sizer for columnWidth
              columnWidth: '.portfolio-item'
            }
        })       

        // filter items on button click
        $('.portfolio-nav').on( 'click', 'li', function() {
            $('.portfolio-nav ul li').removeClass('active');
            $(this).addClass('active');
            var filterValue = $(this).attr('data-filter');
            isotope_content.isotope({ filter: filterValue });
        });
    });

	/* Magnific PopUp */
	$('.portfolio-img').magnificPopup({
		type: 'image',
		gallery: {
			enabled: true
		}
	});
	
	$('.flickr-gallery').magnificPopup({
		type: 'image',
		gallery: {
			enabled: true
		}
	});	
	
	$('.w-gallery').magnificPopup({
		type: 'image',
		gallery: {
			enabled: true
		}
	});	

	$('.popup-video').magnificPopup({
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false,
			disableOn: 300
	});
	
	/* counter */
	/* $('.counter').counterUp({
		delay: 10,
		time: 1000
	}); */
	
	/* Search Box */
	$('.search-open').magnificPopup({
		type: 'inline',

		fixedContentPos: false,
		fixedBgPos: true,

		overflowY: 'auto',

		closeBtnInside: true,
		preloader: false,
		
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});
		
}(jQuery));