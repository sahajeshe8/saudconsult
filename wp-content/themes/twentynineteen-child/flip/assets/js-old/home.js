jQuery(document).ready(function() {

  /*--------Tabs---------*/
  jQuery('.ifza-tabs-panel').on('click', '.ifza-tab-header', function() {
    jQuery('.ifza-body').removeClass('ifza-body-show');
    jQuery('.active').removeClass('active');
    jQuery(this).addClass('active');

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

/*---------glide slider---------*/
new Glide('#stock-slider', {
  type: 'carousel',
  perView: 2,
  gap:10,
  draggable: true,
  autoplay: 5000,
  breakpoints: {
    1800: {
      perView:1.5,
    },
    1366:{
      perView:1.3,
    },
    1280:{
      gap:5,
      perView:1,
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
    1600: {
      perView: 2,
    },
    1450: {
      perView: 1.5,
    },
    1366: {
      perView: 1.3,
    },
    1200: {
      perView: 1.8,
    },
    992: {
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

var mobslider = new Glide('#echo-mob-slider', {
  type: 'carousel',
  //perView:1.05,
  perView:3,
  gap:10,
  draggable: false,
  dragDistance:false,
  touchDistance:false,
  breakpoints: {
    1130: {
      perView:2.6,
    },
    991: {
      perView:2.1,
    },
    768: {
      perView:1.9,
    },
     730: {
      perView:1.8,
    },
    690: {
      perView:1.6,
    },
    640: {
      perView:1.5,
    },
    580: {
      perView:1.35,
    },
    520: {
      perView:1.2,
    },
    470: {
      perView:1.1,
    },
    420:{
      perView:1.05,
    },
    375:{
      perView:1.04,
    },
    360:{
      perView:1,
    }
  }
});


jQuery('.show-echo-slider').on('click', function() {
    jQuery('.echo-mob-slider-wrap').slideToggle("500");
    mobslider.mount();
  });
jQuery('.slider-close').on('click',function(){
  jQuery('.echo-mob-slider-wrap').slideToggle("500");
});

});


