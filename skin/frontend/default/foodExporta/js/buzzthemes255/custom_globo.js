jQuery(document).ready(function($){
    //$('#checkout-review-table tfoot .a-right').attr('colspan',10)
    $(window).scroll(function(){
        var top = $(this).scrollTop();
        if(top > 150){
            $('body').addClass('stiky_');
        }else {
            $('body').removeClass('stiky_');
        }
    })
    minHeight('.products-grid li.item','>div');
})


jQuery(document).ready(function() {
 
  jQuery("#owl-demo").owlCarousel({
    items : 2,
    navigation : true,
    navigationText : ['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
  });

jQuery('.search-top').click(function(){
   if(jQuery('.container.search-in-top').css('display') == 'block'){
        jQuery('.container.search-in-top').hide();
    }
    else{
        jQuery('.container.search-in-top').show();
    } 
})

jQuery("#click-bottom").click(function() {
    jQuery('html, body').animate({
        scrollTop: jQuery("#top-header2").offset().top
    }, 700);
});
jQuery(".bactotop").click(function() {
    
        jQuery('html, body').animate({
        scrollTop: 0
    }, 700);
   
    });
});


// ====== Creat function height div ======

var shouldStop = false;
function height_div (object,object_child){
  var height_div = 0;
  jQuery(object).each(function(){
    // console.log("Object: ", jQuery(this));

    var h_begin_div = jQuery(this).find(object_child).outerHeight();
    if(height_div < h_begin_div){
      height_div = h_begin_div + 1;
    }
  });
  jQuery(object).find(object_child).css('min-height',height_div);
  // Padding for center image
  /*var a = jQuery(object).find('.amlabel-div').height();
  var b = jQuery(object).find('.product-image').outerHeight();
  var c = (parseInt(a) - parseInt(b))/2;
  jQuery(object).find('.product-image').css('padding-top',c);*/
  // #Padding for center image
};
function removeMinHeight(object, object_2){
  jQuery(object).each(function(){
  	jQuery(this).find(object_2).removeAttr('style');
  });
  height_div(object,object_2);
}
function minHeight (o1, o2){
  var shouldStop = false;
    jQuery(window).load(function(){
        height_div(o1,o2);
        jQuery(window).resize(function(){
          shouldStop = true;
          if (!shouldStop) {
            removeMinHeight(o1,o2);
          };
            
        })
    })
}