define([
  'jquery',
  'slick'
], function ($, slick) {
jQuery(document).ready(function () {
	jQuery('.autoplay').slick({
	  slidesToShow: 1,
	  fade: true,
	  cssEase: 'linear',
	  infinite: true,
	  autoplay: true,
	  autoplaySpeed: 2500,
	  adaptiveHeight: true,
	  prevArrow: false,
    nextArrow: false,
    mobileFirst: true,
    pauseOnHover: false,
    pauseOnFocus: false
	});

jQuery('.products.list.items.product-items-related').slick({
    infinite: true,
    slidesToShow: 2,
    slidesToScroll: 1,
    autoplay: false,
    mobileFirst: true,
    pauseOnHover: false,
    pauseOnFocus: false,
    arrows: true,
    responsive: [
    {
      breakpoint: 1024,
      settings: {
      slidesToShow: 6,
      slidesToScroll: 1,
      infinite: true,
      dots: false,
      arrows: true,
      }
    },
    {
      breakpoint: 640,
      settings: {
      slidesToShow: 4,
      slidesToScroll: 1,
      infinite: true,
      dots: false,
      arrows: true,
      }
    }
    ]
  });

});

// jQuery(".filter-options-item").each(function() {
//      jQuery(this).addClass("allow");
//      jQuery(this).removeClass("active");
//     });

//   jQuery( ".filter-options-content" ).each(function() {
//      jQuery( this ).hide();
//     });

  //jQuery( ".filter-options-item" ).each(function() {
     
  //  });

require(['jquery', 'jquery/ui'], function($){

var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
if (isMobile) {
  jQuery( function() {
    jQuery( "#accordion" ).accordion({
        animate: 200,
        active: false,
        collapsible: true
      });
  } );
}

jQuery(function() {

  // jQuery("a").on("click touchend", function(e) {
  //   var el = jQuery(this);
  //   var link = el.attr("href");
  //   window.location = link;
  // });

	var opacitydiv = 'li.level-top.parent, li.level-top.parent > a, .mx-megamenu .navigation > ul';

    jQuery('.menu-opacity').hide();
    
    jQuery(opacitydiv).on('mouseover', function() {
        jQuery('.menu-opacity').show();
    });

    jQuery(opacitydiv).on('mouseout', function() {
        jQuery('.menu-opacity').hide();
    });

    // var div_mega = jQuery('div.megamenu');
    // var header = jQuery('header.content');

   // div_mega.hide();
    // div_mega.on('mouseover', function(){
    //     div_mega.show();
    // });

    // header.on('mouseover', function(){
    //     div_mega.hide();
    // });

    // div_mega.on('mouseout', function(){
    //     div_mega.hide();
    // });

});
});
});