define([
  'jquery',
  'slick'
], function ($, slick) {
jQuery(document).ready(function () {
jQuery('.carousel').slick({
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 4,
    autoplay: true,
    mobileFirst: true,
    pauseOnHover: true,
    pauseOnFocus: true,
    arrows: false,
    responsive: [
    {
      breakpoint: 1024,
      settings: {
      slidesToShow: 4,
      slidesToScroll: 4,
      infinite: true,
      dots: false,
      arrows: false,
      pauseOnHover: true,
      pauseOnFocus: true,
      }
    },
        {
            breakpoint: 640,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: false,
                arrows: false,
                pauseOnHover: true,
                pauseOnFocus: true,
            }
        },
    {
        breakpoint: 420,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            dots: false,
            arrows: false,
            pauseOnHover: true,
            pauseOnFocus: true,
        }
    }
    ]
  });
});
});
