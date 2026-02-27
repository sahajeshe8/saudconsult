jQuery(".burger").click(function () {
	jQuery(this).toggleClass("nav-act");
	jQuery("body").toggleClass("nav-opn");
	jQuery(".demo-accordion::first-child").toggleClass("active");
});

var swiper = new Swiper(".slider-01", {
	pagination: {
		el: ".swiper-pagination",
		dynamicBullets: true,
	},
	slidesPerView: "auto",
	spaceBetween: 15,
	navigation: {
		nextEl: ".swiper-button-next",
		prevEl: ".swiper-button-prev",
	},
	loop: true,
	autoplay: {
		delay: 2000,
	},

	breakpoints: {
		820: { 
			spaceBetween: 26,

		 },
		 1024:{
			slidesPerView: 3,
		 },
		 1200:{
			slidesPerView: 4,
			spaceBetween: 25,
		 }
	},
});

var swiper = new Swiper(".slider-news", {
	pagination: {
		el: ".swiper-pagination",
		dynamicBullets: true,
	},
	slidesPerView: "auto",
	spaceBetween: 15,
	navigation: {
		nextEl: ".swiper-button-next-ns",
		prevEl: ".swiper-button-prev-ns",
	},
	autoplay: {
		delay: 2000,
	},
	loop: true,
	breakpoints: {
		820: { spaceBetween: 20 },
	},
});

var x = jQuery(".container").offset();

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
	var x = jQuery(".container").offset();

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


jQuery(document).load(jQuery(window).bind("load", checkPosition));


function checkPosition() {
    if (window.matchMedia('(max-width: 1000px)').matches) {
		jQuery(document).ready(function($){
			jQuery(".demo-accordion").accordionjs();
		});

	 
		// var height = jQuery(window).height() - jQuery(".header-main").outerHeight()  
		// jQuery('.nav-bar').height(height);
	 


		// jQuery(window).resize(function(){
		// 	var height = jQuery(window).height() - jQuery(".header-main").outerHeight()  
		// 	jQuery('.nav-bar').height(height);
		//  })



		 
		 jQuery(window).resize(); //on page load







    } else {
        jQuery(function () {
			jQuery("nav li").hover(
				function () {
					jQuery(this).find(".megamenu--").first().stop().slideDown(100);
					// 
					// jQuery(this).find(".megamenu").parent("li").removeClass("active");
					jQuery(this).find(".megamenu").parent("li").addClass("active");
					jQuery('body').addClass('meg-act');
					jQuery('body').removeClass('nav-opn');
					jQuery('.burger').removeClass('nav-act');
				},
				function () {
					jQuery(this).find(".megamenu--").stop().delay(400).slideUp(100);
					jQuery(this).find(".megamenu").parent("li").removeClass("active");
					jQuery('body').removeClass('meg-act');
					
				}


			);
		});
		
		jQuery(function () {
			jQuery("nav li").click(function () {
				jQuery(this).find(".megamenu").slideUp(200);
			});
		});
		
		jQuery("nav > li").hover(function () {
			jQuery(".megamenu").toggleClass("active");
		});
		
		jQuery(document).ready(function () {
			jQuery(".dmenu").hover(
				function () {
					jQuery(this).find(".megamenu").first().stop(true, true).slideDown(150);
				},
				function () {
					jQuery(this).find(".megamenu").first().stop(true, true).slideUp(105);
				}
			);
		});
		
		jQuery(".dmenu").hover(function () {
			jQuery("body").toggleClass("active_body");
			jQuery(this).toggleClass("active_dm");
		});
		
		var selector = ".tab-link";
		jQuery(selector).on("mouseover", function () {
			 jQuery(this).siblings().removeClass("active-2");
			// jQuery(this).parent().addClass("active");
			jQuery(this).addClass("active-2");
		});


		jQuery(selector).on("mouseout", function () {
			jQuery(this).siblings().removeClass("active-2");
		   // jQuery(this).parent().addClass("active");
		   jQuery(this).removeClass("active-2");
	   });
		// jQuery("nav li").on("mouseout", function () {
		// 	alert();
		// 	// jQuery(selector).siblings().removeClass("active");
		// 	// jQuery(this).parent().addClass("active");
		// 	// jQuery(this).addClass("active");
		// });
    }
}



jQuery(".tab-link").on("mouseover", function () {
	jQuery(".megamenu ").addClass("menu-h");
});


jQuery(".tab-link").on("mouseout", function () {
 jQuery(".megamenu ").removeClass("menu-h");
});






// jQuery(document).ready(function () {
// 	jQuery(".accordion-item > .accordion-title").on("click", function () {
// 		if (jQuery(this).hasClass("active")) {
// 			jQuery(this).removeClass("active");
// 			jQuery(this).siblings(".accordion-content").slideUp(200);
// 			jQuery(".accordion-item > .accordion-title i")
// 				.removeClass("icon-minus")
// 				.addClass("icon-plus");
// 		} else {
// 			jQuery(".accordion-item > .accordion-title i")
// 				.removeClass("icon-minus")
// 				.addClass("icon-plus");
// 			jQuery(this).find("i").removeClass("icon-plus").addClass("icon-minus");
// 			jQuery(".accordion-item > .accordion-title").removeClass("active");
// 			jQuery(this).addClass("active");
// 			jQuery(".accordion-content").slideUp(200);
// 			jQuery(this).siblings(".accordion-content").slideDown(200);
// 		}
// 	});
// });

// ------menu-script---------








// sticky header
jQuery(window).scroll(function () {
	if (jQuery(this).scrollTop() > 1) {
		jQuery(".header-main").addClass("header-sticky");
	} else {
		jQuery(".header-main").removeClass("header-sticky");
	}
});




// -------home-section-hover----------------


            (function($) {
                //$('.pop').on('hover', function() {
                  jQuery( ".home-hover-ul li" ).hover(function() {
					jQuery('.home-hover-ul li').removeClass('active');
					jQuery(this).addClass('active');
                     jQuery(this).find("img").each(function(n, image){
                        var image = jQuery(image);
                        var thisUrl = jQuery(this).attr("src");
                        jQuery(".hover-change").css("background-image", "url(" + thisUrl + ")");
                        
						// jQuery(".hover-change img").attr("src", thisUrl).fadeIn(1000); 

						// $(selector).attr("src", newUrl);
                    }) ;
                });
            }(jQuery));

			var width = jQuery(window).width();

			if (width > 600) {
				(function($) {
					//$('.pop').on('hover', function() {
					  jQuery( ".wealth-sec .link-box ul li" ).hover(function() {
						 jQuery(this).find("img").each(function(n, image){
							var image = jQuery(image);
							var thisUrl = jQuery(this).attr("src");
							jQuery(".wealth-sec").css("background-image", "url(" + thisUrl + ")");
							
							// jQuery(".hover-change img").attr("src", thisUrl).fadeIn(1000); 
	
							// $(selector).attr("src", newUrl);
						}) ;
					});
				}(jQuery));
			}else{
				(function($) {
					//$('.pop').on('hover', function() {
					  jQuery( ".wealth-sec .link-box ul li" ).click(function() {
						 jQuery(this).find("img").each(function(n, image){
							var image = jQuery(image);
							var thisUrl = jQuery(this).attr("src");
							jQuery(".wealth-sec").css("background-image", "url(" + thisUrl + ")");
							
							// jQuery(".hover-change img").attr("src", thisUrl).fadeIn(1000); 
	
							// $(selector).attr("src", newUrl);
						}) ;
					});
				}(jQuery));
			}
			














// -------home-section-hover----------------
jQuery('.animate-it').appear();
jQuery(document.body).on('appear', '.animate-it', function(e, jQueryaffected) {
	var fadeDelayAttr;
	var fadeDelay;
	jQuery(this).each(function() {
		if (jQuery(this).data("delay")) {
			fadeDelayAttr = jQuery(this).data("delay")
			fadeDelay = fadeDelayAttr;
		} else {
			fadeDelay = 0;
		}
		jQuery(this).delay(fadeDelay).queue(function() {
			jQuery(this).addClass('animated').clearQueue();
		});
	})
});




// -----------------------------menu-mobile------------------------------


// jQuery( ".mob_navbar li" ).has( "ul" ).addClass( "dropdown" );
// jQuery(".dropdown").click(function () {
// 	jQuery(this).siblings().children(".mob_sub_menu").slideUp();
// 	jQuery(this).find("> .mob_sub_menu").slideToggle();
// 	// jQuery(this).nextAll(".sub-parent-menu ul ul .dpd_icon").slideToggle();
// 	jQuery(this).removeClass("search-close");
// 	jQuery("#Exp-serach").slideUp();
// });

// jQuery(".dropdown").click(function () {
// 	jQuery("body").toggleClass("active_body");
// 	jQuery(this).parent().siblings().children("a").removeClass("active_icn");
// 	jQuery(this).toggleClass("active_icn");
// });





