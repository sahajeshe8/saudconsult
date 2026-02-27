jQuery(document).ready(function() {

/*------------wow animation------------*/ 
wow = new WOW(
    {
      animateClass: 'animated',
      offset:       100,
      mobile:       true,
      callback:     function(box) {
        console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
      }
    }
  );
  wow.init();
/*----------Nice select--------*/
jQuery('.lang-area-select select').niceSelect();
jQuery('.dropdown-box-area select').niceSelect();

/*-------Menu------*/
jQuery(".menu-item-has-children > a").after(
  //"<span class='mob-menu-icn'><i class='fa-solid fa-arrow-up'></i></span>"
  "<span class='mob-menu-icn'><i class='fa-solid fa-angle-down'></i></span>"
);
jQuery(".mob-menu-icn").click(function () {
  jQuery(this).parent().siblings().children(".sub-menu").slideUp();
  jQuery(this).nextAll(".sub-menu").slideToggle();
});

  jQuery(".mob-menu-icn").click(function (e) {
    jQuery(this)
      .parent()
      .siblings()
      .children(".mob-menu-icn")
      .removeClass("opn-mob");
    jQuery(this).toggleClass("opn-mob");
  });
jQuery('.menu-button').on('click', function () {
  jQuery('.animated-icon1').toggleClass('open');
  //jQuery(".mob-menu").toggleClass("active");
  jQuery('.mob-menu').slideToggle("slow");
});
jQuery('.openVideo').magnificPopup({
    type: 'inline',
    midClick: true,
    mainClass: 'mfp-fade',
    callbacks: {
      open: function() {
        // Play video on open:
        jQuery(this.content).find('video')[0].play();
        },
      close: function() {
        // Reset video on close:
        jQuery(this.content).find('video')[0].load();
        }
      }
    });
jQuery('.open-popup-link').magnificPopup({
  type:'inline',
  midClick: true
});
jQuery('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
    type: 'iframe'
});
/*------map view-------*/
jQuery('#view-map').on('click', function(e) {
   jQuery('.location-map-wrap').slideToggle("300");
   jQuery('body').toggleClass('scrollbar');
   e.stopPropagation();
});
jQuery('#view-map-txt').on('click', function(e) {
   jQuery('.location-map-wrap').slideToggle("300");
   jQuery('body').toggleClass('scrollbar');
   e.stopPropagation();
});
jQuery('.map-close').on('click',function(e){
  jQuery('.location-map-wrap').slideToggle("100");
  jQuery('body').toggleClass('scrollbar');
  e.stopPropagation();
});

jQuery('.location-map-wrap').on('scroll touchmove mousewheel', function(e){
  e.preventDefault();
  e.stopPropagation();
  return false;
})

jQuery('body').click(function(){
    jQuery('.location-map-wrap').slideUp("100");
    jQuery('body').removeClass('scrollbar');
})

  // container width
  var offset = jQuery(".container").offset();
  jQuery(".padding-left").css("padding-left", offset.left);
  jQuery(".padding-right").css("padding-right", offset.left);

  /*-----faqs----*/
  jQuery(".accordion-panel .accordion__header:first").addClass("active");
  jQuery(".accordion-panel .accordion__body:not(:first)").hide();
  jQuery('.accordion-panel').on('click', '.accordion__header', function() {
    jQuery('.accordion__body').slideUp().removeClass('fadeInUp');
    jQuery('.arrow-view').removeClass('fa-caret-up');
    jQuery(".accordion-panel .accordion__header:first").removeClass("active");
    if(jQuery(this).next().is(':hidden')) {
      jQuery(this).next().slideDown().addClass('fadeInUp');
      jQuery(this).find('.arrow-view').addClass('fa-caret-up');
    } else {
      jQuery(this).next().slideUp();
      jQuery(this).find('.arrow-view').addClass('fa-caret-down');
    }
  });
	
if (jQuery(window).width() < 1181) {
    var checkboxb = document.querySelector('#options-rewind-checkboxb');
	var blogmob = new Glide('#blog-slider-mob', {
	  //type: 'carousel',
	  //perView:1.5,
	  perView:3,
	  gap:10,
	  draggable: true,
	  rewind: checkboxb.checked,
	  breakpoints: {
		1024: {
		  perView:2.5,
		},
		991: {
		  perView:2,
		},
		768: {
		  perView:1.9,
		},
		640: {
		  perView:1.1,
		}
	  }
	});
	checkboxb.addEventListener('change', function () {
  glide.update({
    rewind: checkboxb.checked
  });
});
blogmob.mount();
}
if (jQuery(window).width() < 1181) {
     var checkboxg = document.querySelector('#options-rewind-checkboxg');
  var guideslider = new Glide('#guides-slider-mob', {
    //type: 'carousel',
    //perView:1.5,
    perView:3,
    gap:10,
    draggable: true,
    rewind: checkboxg.checked,
    breakpoints: {
    1024: {
      perView:2.5,
    },
    991: {
      perView:2,
    },
    768: {
      perView:1.9,
    },
    640: {
      perView:1.1,
    }
    }
  });
  checkboxg.addEventListener('change', function () {
  glide.update({
    rewind: checkboxg.checked
  });
});
guideslider.mount();
}	

});

/*-------------Header sticky----------*/
/*jQuery(window).scroll(function () {
    if (jQuery(this).scrollTop() > 5) {
        jQuery('header').addClass("sticky");
    } else {
        jQuery('header').removeClass("sticky");
    }
});*/
/*--------Div id base smooth scroll---------*/
jQuery(document).ready(function(){
  jQuery('a[href^="#"].to-section').on('click',function (e) {
      e.preventDefault();
      var target = this.hash;
      var $target = jQuery(target);
      var headerHeight = jQuery('header').outerHeight();
      jQuery('html, body').stop().animate({
          'scrollTop': $target.offset().top - 20
      }, 900, 'swing', function () {
          // window.location.hash = target;
      });
  });
  //comes from other page
  /*jQuery('html,body').animate({
    scrollTop: jQuery(window.location.hash).offset().top - jQuery('header').outerHeight()
  });*/
}); 

/*---------video lazy load-----------*/
 document.addEventListener("DOMContentLoaded", function() {
    var lazyVideos = [].slice.call(document.querySelectorAll("video.lazy"));

    if ("IntersectionObserver" in window) {
      var lazyVideoObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(video) {
          if (video.isIntersecting) {
            for (var source in video.target.children) {
              var videoSource = video.target.children[source];
              if (typeof videoSource.tagName === "string" && videoSource.tagName === "SOURCE") {
                videoSource.src = videoSource.dataset.src;
              }
            }

            video.target.load();
            video.target.classList.remove("lazy");
            lazyVideoObserver.unobserve(video.target);
          }
        });
      });

      lazyVideos.forEach(function(lazyVideo) {
        lazyVideoObserver.observe(lazyVideo);
      });
    }
  }); 

/*-----Onscroll section sticky------*/
jQuery(document).ready(function () {
    var length = jQuery('#fixed-outer').height() - jQuery('#fixed-area').height() + jQuery('#fixed-outer').offset().top;
    jQuery(window).scroll(function () {
        var scroll = jQuery(this).scrollTop();
        var height = jQuery('#fixed-area').height() + 'px';
        if (scroll < jQuery('#fixed-outer').offset().top) {
            jQuery('#fixed-area').removeClass('sidebar-fixed');

        } else if (scroll > length) {
            jQuery('#fixed-area').addClass('sidebar-fixed');
        } else {
            jQuery('#fixed-area').addClass('sidebar-fixed');
        }
    });
});

/*------header sticky on scroll up*/
jQuery(document).ready(function () {
jQuery(function() {
      var $window       = jQuery(window);
      var lastScrollTop = 0;
      var $header       = jQuery('.header');
      var headerHeight  = $header.outerHeight();

      $window.scroll(function() {

          var windowTop  = $window.scrollTop();

          if ( windowTop >= headerHeight ) {
            $header.addClass( 'h-sticky' );
          } else {
            $header.removeClass( 'h-sticky' );
            $header.removeClass( 'h-show' );
          }
        
          if ( $header.hasClass( 'h-sticky' ) ) {
            if ( windowTop < lastScrollTop ) {
              $header.addClass( 'h-show' );
            } else {
              $header.removeClass( 'h-show' );
            }
          }

          lastScrollTop = windowTop;
      } );
    });

});

/*--------Back to top button----*/
jQuery(document).ready(function () {
var btn = jQuery('#back-to-top');
jQuery(window).scroll(function() {
  if (jQuery(window).scrollTop() > 400) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

btn.on('click', function(e) {
  e.preventDefault();
  jQuery('html, body').animate({scrollTop:0}, '300');
});

});

jQuery(document).ready(function () {
    jQuery(window).scroll(function () {
    if (jQuery(this).scrollTop() > 500) {
        jQuery('.parallax-sec').addClass("parallax-sec-view");
    } 
});
});