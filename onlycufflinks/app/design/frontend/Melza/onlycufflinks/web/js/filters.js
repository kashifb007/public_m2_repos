require(['jquery', 'jquery/ui'], function($){

jQuery(function() {

jQuery(".filter-options-item").each(function() {
     jQuery(this).addClass("allow");
     jQuery(this).removeClass("active");
    });

  jQuery( ".filter-options-content" ).each(function() {
     jQuery( this ).hide();
    });

});
});