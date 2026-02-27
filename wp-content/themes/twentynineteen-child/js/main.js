 
 


	var x = jQuery(".wrap").offset();

	if (jQuery("body").css("direction") == "rtl") {
		jQuery(".padding-left").css("padding-right", x.left);
		jQuery(".row-reverce .padding-left").css( {"padding-right":x.left, "padding-lrft":0});
		jQuery(".padding-left-margin").css("margin-right", x.left);
		jQuery(".padding-right").css("padding-left", x.left);
		jQuery(".padding-right-margin").css("margin-left", x.left);
	} else {
		jQuery(".padding-left").css("padding-left", x.left);
		jQuery(".row-reverce .padding-left").css({"padding-left":x.left, "padding-right":0});
		jQuery(".padding-left-margin").css("margin-left", x.left);
		jQuery(".padding-right").css("padding-right", x.left);
		jQuery(".padding-right-margin").css("margin-right", x.left);
	}
	
	
	jQuery(window).resize(function(){
		var x = jQuery(".wrap").offset();
	
		if (jQuery("body").css("direction") == "rtl") {
			jQuery(".padding-left").css("padding-right", x.left);
			jQuery(".row-reverce .padding-left").css({"padding-right":x.left, "padding-left":0});
			jQuery(".padding-left-margin").css("margin-right", x.left);
			jQuery(".padding-right").css("padding-left", x.left);
			jQuery(".padding-right-margin").css("margin-left", x.left);
		} else {
			jQuery(".padding-left").css("padding-left", x.left);
			jQuery(".row-reverce .padding-left").css({"padding-left":x.left, "padding-right":0});
			jQuery(".padding-left-margin").css("margin-left", x.left);
			jQuery(".padding-right").css("padding-right", x.left);
			jQuery(".padding-right-margin").css("margin-right", x.left);
		}
	
	});




	new Swiper('.product-slider', {
        loop: true,
        // nextButton: '.swiper-button-next',
        // prevButton: '.swiper-button-prev',
		navigation: {
		  	nextEl: ".pro-next",
		  prevEl: ".pro-prev",
		},
        slidesPerView: 2,
        paginationClickable: true,
        spaceBetween: 0,
		speed:1500,
		autoplay: {
					delay: 3000,
			 	  },
        breakpoints: {
            1920: {
                slidesPerView: 4,
                spaceBetween:  0
            },
            1028: {
                slidesPerView: 4,
                spaceBetween: 0
            },
            480: {
                slidesPerView: 3,
                spaceBetween: 0
            }
        }
    });

 

  
jQuery('.animate-it').appear();
jQuery(document.body).on('appear', '.animate-it', function(e, jQueryaffected) {
	var fadeDelayAttr;
	var fadeDelay;
	jQuery(this).each(function(){
		if (jQuery(this).data("delay")) {
			fadeDelayAttr = jQuery(this).data("delay")
			fadeDelay = fadeDelayAttr;				
		} else {
			fadeDelay = 0;
		}			
		jQuery(this).delay(fadeDelay).queue(function(){
			jQuery(this).addClass('animated').clearQueue();
		});			
	})			});


	jQuery( document ).ready(function() {
		window.sr = new scrollReveal({
		  reset: false,
		  move: '50px',
		  mobile: true,
		  over: '1s'
		});
		});

		
		jQuery("header .burger").click(function(){
			jQuery(this).toggleClass("burger--close");
			jQuery('#overlay').toggleClass('open');
			jQuery('body').toggleClass('open-nav');
			jQuery('.main-nav').toggleClass('slidenav');
		  });


		  		
		jQuery(".account-left-navigation-main .burger").click(function(){
			jQuery(this).toggleClass("burger--close");
			jQuery('.woocommerce-MyAccount-navigation ul').slideToggle();
			jQuery('.main-nav').removeClass('slidenav');
		  });





		  jQuery(".main-nav .fl").on('click', function(event) {
			var $fl = jQuery(this);
			jQuery(this).parent().siblings().find('.submenu').slideUp();
			jQuery(this).parent().siblings().find('.fl').addClass('flaticon-plus');
			 jQuery(this).parent(".mega-submenu").find(".megamenu").slideToggle(); // new line       
			if($fl.hasClass('flaticon-plus')){
			  $fl.removeClass('flaticon-plus').addClass('flaticon-minus');
			}else{
			  $fl.removeClass('flaticon-minus').addClass('flaticon-plus');
			}
			 $fl.next(".submenu").slideToggle();

			//jQuery(this).parent().slideToggle();

		  });



// -------------nav-menu----------------

jQuery(".megamenu .parent > a.parent-item").click(function () {
	jQuery(this).parent().find("li").removeClass("change");
	jQuery(this).parent().find("li:first-child").addClass("change");
	jQuery(".megamenu .parent").removeClass("active");
	jQuery(this).parent().toggleClass("active");
});

jQuery(".menu-tabs ul li.children").click(function () {
	jQuery(".menu-tabs ul li.children").removeClass("change");
	jQuery(this).addClass("change");
});



var width = jQuery(window).width();
if (width > 1025) {
	jQuery(".menu-tab-right-outer").each(function( index ) {
		var x = jQuery(this).outerHeight();
		jQuery(".menu-tabs").css("height", x + 100);
	});
}

var width = jQuery(window).width();
if (width < 1024) {
	jQuery(".parent > a").after("<i class='fl flaticon-plus'><span class='icon-arrow-menu'></span></i>");
	jQuery(".children > a").after("<i class='fl flaticon-plus'><span class='icon-arrow-menu'></span></i>");

	jQuery(".fl").click(function () {
		jQuery(this).parent().siblings().children(".menu-tabs").slideUp();
		jQuery(this).nextAll(".menu-tabs").slideToggle();
	});

	jQuery(".children .fl").click(function () {
		jQuery(this).parent().siblings().find(".menu-tab-right-outer").slideUp();
		jQuery(this).siblings(".menu-tab-right-outer").slideToggle();
	});
}
// -------------nav-menu----------------


 
//  ---------------mob-menu----------

 
		

		jQuery('.search-icn .icon-icn-03').click(function(){
			jQuery('.search-panel').toggleClass('ex');
			jQuery( ".ExpInput" ).focus();
		  });




		  jQuery('.search-clos').click(function(){
			jQuery('.search-panel').removeClass('ex');
		  });

		  

 

		//   ------------new---------------

		jQuery("form").on("change", ".file-upload-field", function(){ 
			jQuery(this).parent(".file-upload-wrapper").attr("data-text", jQuery(this).val().replace(/.*(\/|\\)/, '') );
		});





		// -------------iso-top------------start




		

		// -------------iso-top------------end




		// ---------------------map-----------------start
		



	// ---------------------sumo-----------------start
	jQuery(document).ready(function () {
		jQuery('.selectBox').SumoSelect();
		  });
	// ---------------------sumo-----------------end




// --------------------related-slider----start---------------------

	// var swiper = new Swiper(".related-slider", {
	// 	slidesPerView: 3,
	// 	spaceBetween: 0,
 	// 	speed: 2000,
	// 	loop: true,
	// 	loopFillGroupWithBlank: true,
	// 	pagination: {
	// 	  el: ".swiper-pagination",
	// 	  clickable: true,
	// 	},
	// 	navigation: {
	// 	  nextEl: ".swiper-button-next",
	// 	  prevEl: ".swiper-button-prev",
	// 	},
	// 		autoplay: {
	// 		delay: 3000,
 	// 	  },

	// 			breakpoints: {
	// 		600: {
	// 			spaceBetween:30,
	// 			slidesPerView: "2",
	// 		},
	// 		  0: {
	// 			spaceBetween: 10,
	// 			slidesPerView: "1",
	// 			navigation:false,
	// 		 },
	// 	}
 	//   });
// --------------------related-slider-----end--------------------



 
	// Swiper: Slider
	new Swiper('.swiper-rel', {
		loop: true,
		 // nextButton: '.rel-next',
		// prevButton: '.rel-prev',

		navigation: {
			nextEl: ".rel-next",
			prevEl: ".rel-prev",
		  },
		  speed: 2000,
		paginationClickable: true,
		spaceBetween: 20,
					  autoplay: {
			delay: 2500,
			speed:2000,
			disableOnInteraction: false,
		  },
		breakpoints: {
			1440: {
				slidesPerView: 3,
				spaceBetween: 0
			},
			700: {
				slidesPerView: 2,
				spaceBetween: 0
			},
			480: {
				slidesPerView: 1,
				spaceBetween: 0
			}
		}
	});
 
	
// -----------------manufacturng----------




new Swiper('.logo-slider', {
	loop: true,
	 // nextButton: '.rel-next',
	// prevButton: '.rel-prev',
 
	navigation: {
		nextEl: ".rel-next-a",
		prevEl: ".rel-prev-a",
	  },
	  speed: 2000,
	paginationClickable: true,
	spaceBetween: 20,
				  autoplay: {
		delay: 2500,
		speed:2000,
		disableOnInteraction: false,
	  },
	breakpoints: {
		1366: {
			slidesPerView: 5,
			spaceBetween: 0
		},
		768: {
			slidesPerView: 4,
			spaceBetween: 0
		},
		600: {
			slidesPerView:3,
			spaceBetween: 0
		},
		400: {
			slidesPerView:1,
			spaceBetween: 0
		}
	}
});









new Swiper('.logo-slider-2', {
	loop: true,
	 // nextButton: '.rel-next',
	// prevButton: '.rel-prev',
 
	navigation: {
		nextEl: ".rel-next-a",
		prevEl: ".rel-prev-a",
	  },
	  speed: 2000,
	paginationClickable: true,
	spaceBetween: 20,
				  autoplay: {
		delay: 2500,
		speed:2000,
		disableOnInteraction: false,
	  },
	breakpoints: {
		1920: {
			slidesPerView:2,
			spaceBetween: 0
		},
		1024: {
			slidesPerView: 2,
			spaceBetween: 0
		},
		700: {
			slidesPerView: 2,
			spaceBetween: 0
		}
	}
});








new Swiper('.logo-slider-3', {
	loop: true,
	 // nextButton: '.rel-next',
	// prevButton: '.rel-prev',
 
	navigation: {
		nextEl: ".rel-next-b",
		prevEl: ".rel-prev-b",
	  },
	  speed: 2000,
	paginationClickable: true,
	spaceBetween: 20,
				  autoplay: {
		delay: 2500,
		speed:2000,
		disableOnInteraction: false,
	  },
	breakpoints: {
		1920: {
			slidesPerView: 3,
			spaceBetween: 0
		},
		1024: {
			slidesPerView: 3,
			spaceBetween: 0
		},
		700: {
			slidesPerView: 2,
			spaceBetween: 0
		}
	}
});




new Swiper('.logo-slider-4', {
	loop: true,
	 // nextButton: '.rel-next',
	// prevButton: '.rel-prev',
 
	navigation: {
		nextEl: ".rel-next-a",
		prevEl: ".rel-prev-a",
	  },
	  speed: 2000,
	paginationClickable: true,
	spaceBetween: 20,
				  autoplay: {
		delay: 2500,
		speed:2000,
		disableOnInteraction: false,
	  },
	breakpoints: {
		1366: {
			slidesPerView: 4,
			spaceBetween: 0
		},
		700: {
			slidesPerView: 2,
			spaceBetween: 0
		},
		600: {
			slidesPerView: 1,
			spaceBetween: 0
		}
	}
});






new Swiper('.logo-slider-5', {
	loop: true,
	 // nextButton: '.rel-next',
	// prevButton: '.rel-prev',
 
	navigation: {
		nextEl: ".rel-next-c",
		prevEl: ".rel-prev-c",
	  },
	  speed: 2000,
	paginationClickable: true,
	spaceBetween: 20,
				  autoplay: {
		delay: 2500,
		speed:2000,
		disableOnInteraction: false,
	  },
	breakpoints: {
		1366: {
			slidesPerView: 4,
			spaceBetween: 0
		},
		700: {
			slidesPerView: 2,
			spaceBetween: 0
		},
		600: {
			slidesPerView: 1,
			spaceBetween: 0
		}
	}
});









jQuery(document).ready(function($){
	jQuery(".demo-accordion").accordionjs();
});



// ----------------------nav-new-------------------


jQuery(document).ready(function() {
	//Horizontal Tab
	jQuery('#parentHorizontalTab').easyResponsiveTabs({
		type: 'default', //Types: default, vertical, accordion
		width: 'auto', //auto or any width like 600px
		fit: true, // 100% fit in a container
		tabidentify: 'horaa_1', // The tab groups identifier
		activate: function(event) { // Callback function if tab is switched
			var $tab = $(this);
			var $info = $('#nested-tabInfo');
			var $name = $('span', $info);
			$name.text($tab.text());
			$info.show();
		}
	});

	// Child Tab
	jQuery('.ChildVerticalTab_1').easyResponsiveTabs({
		type: 'vertical',
		width: 'auto',
		fit: true,
		tabidentify: 'ver_1', // The tab groups identifier
		activetab_bg: '#fff', // background color for active tabs in this group
		inactive_bg: '#F5F5F5', // background color for inactive tabs in this group
		active_border_color: '#c1c1c1', // border color for active tabs heads in this group
		active_content_border_color: '#5AB1D0' // border color for active tabs contect in this group so that it matches the tab head border
	});

	//Vertical Tab
	jQuery('#parentVerticalTab').easyResponsiveTabs({
		type: 'vertical', //Types: default, vertical, accordion
		width: 'auto', //auto or any width like 600px
		fit: true, // 100% fit in a container
		closed: 'accordion', // Start closed if in accordion view
		tabidentify: 'hor_1', // The tab groups identifier
		activate: function(event) { // Callback function if tab is switched
			var $tab = $(this);
			var $info = $('#nested-tabInfo2');
			var $name = $('span', $info);
			$name.text($tab.text());
			$info.show();
		}
	});
});


// --------nav-new------------


jQuery(".fl").click(function(){
	jQuery(this).parent().find('.menu-mobile').slideToggle();
	 
  });



//   -----------stiky-hed--------------

jQuery(window).scroll(function () {
	if (jQuery(this).scrollTop() > 1) {
		jQuery(".header-main").addClass("header-sticky");
		jQuery("body").addClass("body-sticky");
	} else {
		jQuery(".header-main").removeClass("header-sticky");
		jQuery("body").removeClass("body-sticky");
	}
});



// jQuery(document).ready(function(){
// 	jQuery('.main-nav ul li').click(function(){
// 	//   jQuery('.main-nav > ul > li').removeClass("active");
// 	  jQuery(this).addClass("active");
//   });
//   });



jQuery(".expand-but").click(function(){
	// jQuery('.moretext').slideToggle();
	jQuery(this).parent().find('.moretext').slideToggle();
 });



 jQuery(document).ready(function(){
	jQuery('.main-nav > ul > li').click(function(){
	  jQuery('.main-nav > ul > li').removeClass("active");
	  jQuery(this).addClass("active");
  });
  });