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
/*var cip = jQuery(".ifza-tab-body").hover( hoverVideo, hideVideo );

function hoverVideo(e) {  
    jQuery('.video-wrap video', this).get(0).play(); 
}

function hideVideo(e) {
    jQuery('.video-wrap video', this).get(0).pause(); 
}*/

/*---------glide slider---------*/
var checkbox = document.querySelector('#options-rewind-checkbox');
var glide = new Glide('#stock-slider', {
  type: 'carousel',
   perView: 2,
   gap:10,
   draggable: true,
   autoplay: 5000,
  //rewind: checkbox.checked,
  breakpoints: {
    1800: {
      perView:2,
    },
    1366:{
      perView:2,
    },
    1280:{
      gap:5,
      perView:1,
    }
  }
});
checkbox.addEventListener('change', function () {
  glide.update({
    rewind: checkbox.checked
  });
});

glide.mount();

var checkbox2 = document.querySelector('#options-rewind-checkbox2');
var glide2 = new Glide('#news-top', {
  type: 'carousel',
  perView: 3,
  gap:10,
  draggable: true,
  autoplay: 5000,
  //rewind: checkbox2.checked,
  breakpoints: {
    1600: {
      perView: 2,
    },
    1450: {
      perView: 2,
    },
    1366: {
      perView:2,
    },
    1280: {
      perView:1,
    },
    1199: {
      perView:2,
    },
    991: {
      perView:1,
    },
    767: {
      perView:2,
    },
     640: {
      perView:1.6,
    },
     480: {
      perView:1,
    },
    400: {
      perView:1,
    }
  }
});
checkbox2.addEventListener('change', function () {
  glide.update({
    rewind: checkbox2.checked
  });
});
glide2.mount();

if (jQuery(window).width() < 1281) {
    
    var checkboxs = document.querySelector('#options-rewind-checkboxs');
    var glidemob = new Glide('#service-slider', {
    //type: 'carousel',
    perView: 3,
    draggable: true,
    dragThreshold: false,
    gap:30,
    rewind: checkboxs.checked,
    breakpoints: {
      1367: {
        gap:15,
      },
      1050: {
        perView: 2,
        dragThreshold:true,
      },
      700: {
        perView:1.3,
        gap:10,
        dragThreshold:true,
      },
      640: {
        perView:1.1,
        gap:10,
        dragThreshold:true,
      },
      370: {
        perView:1.06,
        gap:8,
        dragThreshold:true,
      }
    }
  });
  checkboxs.addEventListener('change', function () {
  glide.update({
    rewind: checkboxs.checked
  });
});
glidemob.mount();
}

/*var checkboxem = document.querySelector('#options-rewind-checkboxem');

var mobslider = new Glide('#echo-mob-slider', {
  //type: 'carousel',
  //perView:1.05,
  perView:3,
  gap:10,
  draggable: false,
  dragDistance:false,
  touchDistance:false,
   rewind: checkboxem.checked,
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
checkboxs.addEventListener('change', function () {
  glide.update({
    rewind: checkboxem.checked
  });
});

jQuery('.show-echo-slider').on('click', function() {
    jQuery('.echo-mob-slider-wrap').slideToggle("500");
    mobslider.mount();
  });
jQuery('.slider-close').on('click',function(){
  jQuery('.echo-mob-slider-wrap').slideToggle("500");
});*/


jQuery('.echo-mob-slider').slick({
    slidesToShow:3,
    slidesToScroll: 1,
    arrows: false,
    dots:false,
    centerMode: false,
    /*draggable:true,
    swipeToSlide: true,
    swipe: true,
    touchMove: true,*/
    infinite: false,
    responsive: [
    {
      breakpoint: 1130,
      settings: {
        slidesToShow:2.55,
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow:2.1,
      }
    },
    {
      breakpoint: 770,
      settings: {
        slidesToShow:1.8,
      }
    },
    {
      breakpoint: 731,
      settings: {
        slidesToShow:1.7,
      }
    },
    {
      breakpoint: 691,
      settings: {
        slidesToShow:1.5,
      }
    },
    {
      breakpoint: 641,
      settings: {
        slidesToShow:1.4,
      }
    },
    {
      breakpoint: 581,
      settings: {
        slidesToShow:1.35,
      }
    },
    {
      breakpoint: 521,
      settings: {
        slidesToShow:1.2,
      }
    },
    {
      breakpoint: 471,
      settings: {
        slidesToShow:1.1,
      }
    },
    {
      breakpoint: 421,
      settings: {
        slidesToShow:1.02,
      }
    },
    {
      breakpoint: 376,
      settings: {
        slidesToShow:1.01,
      }
    },
    {
      breakpoint: 361,
      settings: {
        slidesToShow:1,
      }
    },
    ]
  });
jQuery('span[data-slide]').click(function(e) {
   e.preventDefault();
   var slideno = jQuery(this).data('slide');
   jQuery('.echo-mob-slider').slick('slickGoTo', slideno - 1);
  });
jQuery('.show-echo-slider').on('click', function() {
    jQuery('.echo-mob-slider-wrap').slideDown("500");
  });


jQuery('.slider-close').on('click',function(){
  jQuery('.echo-mob-slider-wrap').slideUp("500");
});

});