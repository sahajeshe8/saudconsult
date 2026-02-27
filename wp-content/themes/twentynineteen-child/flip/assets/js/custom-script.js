jQuery(document).ready(function() {

  /*--------Tabs---------*/
  jQuery('.ifza-tabs-panel').on('click', '.ifza-tab-header', function() {
    jQuery('.ifza-body').removeClass('ifza-body-show');
    jQuery('.ifza-tab-header').removeClass('ifza-tab-header-first');
    jQuery('.ifza-tabs-panel').removeClass('ifza-tabs-panel-first');
    
    if(jQuery(this).next().is(':hidden')) {
      jQuery(this).next().addClass('ifza-body-show');
    } else {
      jQuery(this).next().addClass('ifza-body-show');
    }
  });


/*------Video play and pause on hover*/
var cip = jQuery(".ifza-tab-body").hover( hoverVideo, hideVideo );

function hoverVideo(e) {  
    jQuery('.video-wrap video', this).get(0).play(); 
}

function hideVideo(e) {
    jQuery('.video-wrap video', this).get(0).pause(); 
}

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


/*---------glide slider---------*/
new Glide('#stock-slider', {
  type: 'carousel',
  perView: 2,
  gap:10,
  draggable: true,
  autoplay: 5000,
  breakpoints: {
    1280: {
      gap:5,
    }
  }
}).mount();

new Glide('#news-top', {
  type: 'carousel',
  perView: 3,
  gap:10,
  draggable: true,
  autoplay: 5000,
  breakpoints: {
    1450: {
      perView: 1,
    }
  }
}).mount();

new Glide('#service-slider', {
  type: 'carousel',
  perView: 3,
  draggable: true,
  gap:30,
  breakpoints: {
    1367: {
      gap:15,
      
    },
    1050: {
      perView: 2,
      
    },
    700: {
      perView:1.3,
      
      gap:10,
    },
    640: {
      perView:1.1,
     
      gap:10,
      
    }
  }
}).mount();

new Glide('#blog-slider-mob', {
  type: 'carousel',
  perView:1.5,
  gap:10,
  draggable: true,
  breakpoints: {
    640: {
      perView:1.1,
    }
  }
}).mount();

var mobslider = new Glide('#echo-mob-slider', {
  type: 'carousel',
  perView:1.05,
  gap:10,
  draggable: false,
  dragDistance:false,
  touchDistance:false,
});



jQuery('.show-echo-slider').on('click', function() {
    jQuery('.echo-mob-slider-wrap').slideToggle("fast");
    mobslider.mount();
  });
jQuery('.slider-close').on('click',function(){
  jQuery('.echo-mob-slider-wrap').slideToggle("fast");
});

/*-------Menu------*/
jQuery(".menu-item-has-children > a").after(
  "<span class='mob-menu-icn'><i class='fa-solid fa-arrow-up'></i></span>"
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


});

/*-------------Header sticky----------*/
jQuery(window).scroll(function () {
    if (jQuery(this).scrollTop() > 5) {
        jQuery('header').addClass("sticky");
    } else {
        jQuery('header').removeClass("sticky");
    }
});
/*--------Div id base smooth scroll---------*/
jQuery(document).ready(function(){
  jQuery('a[href^="#"].to-section').on('click',function (e) {
      e.preventDefault();
      var target = this.hash;
      var $target = jQuery(target);
      var headerHeight = jQuery('header').outerHeight();
      jQuery('html, body').stop().animate({
          'scrollTop': $target.offset().top - headerHeight
      }, 900, 'swing', function () {
          // window.location.hash = target;
      });
  });
  //comes from other page
  /*jQuery('html,body').animate({
    scrollTop: jQuery(window.location.hash).offset().top - jQuery('header').outerHeight()
  });*/
}); 




