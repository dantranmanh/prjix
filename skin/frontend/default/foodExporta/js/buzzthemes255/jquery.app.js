jQuery(document).ready(function(){
    /*jQuery('[data-toggle="tooltip"]').tooltip();*/
    if(jQuery.browser.mobile){
      jQuery('.header .col-3 ul li.first').click(function(){
        jQuery('.box-none.box-needhelp').toggle();
      });
      jQuery('.header .col-3 ul li.last.sign-in').click(function(){
        jQuery('.box-none.box-signin').toggle();
      });
    }

    positionMessage();
    
    var skipContents = jQuery('.skip-content');
    var skipLinks = jQuery('.skip-link');

    skipLinks.on('click', function (e) {
        e.preventDefault();

        var self = jQuery(this);
        // Use the data-target-element attribute, if it exists. Fall back to href.
        var target = self.attr('data-target-element') ? self.attr('data-target-element') : self.attr('href');

        // Get target element
        var elem = jQuery(target);

        // Check if stub is open
        var isSkipContentOpen = elem.hasClass('skip-active') ? 1 : 0;

        // Hide all stubs
        skipLinks.removeClass('skip-active');
        skipContents.removeClass('skip-active');

        // Toggle stubs
        if (isSkipContentOpen) {
            self.removeClass('skip-active');
        } else {
            self.addClass('skip-active');
            elem.addClass('skip-active');
        }
    });

});

jQuery(document).load(function(){
 	positionMessage();
});

jQuery(document).resize(function(){
 	positionMessage();
});
window.onresize = function(event) {
    positionMessage();
}

function positionMessage(){
	var widhtWindow =jQuery(window).width();
    var widthMessage =  jQuery('.frm-message .messages.container').outerWidth();
    var widthMain = jQuery('.main.container').outerWidth();
    if(widhtWindow < 1199){
    	var leftPosition = ((widhtWindow - widthMain)/2);
    }else{
    	var leftPosition = ((widhtWindow - widthMain)/2)-40;
    }
    jQuery('.frm-message .messages.container').css('left',leftPosition+'px');
}

function maxLengthCheck(object){
    if(object.value.length > 4){
        object.value = object.value.slice(0, object.maxLength);
        // alert('Max Qty <= 9999');
    }
}

;(function($){

  $.fn.customerPopup = function (e, intWidth, intHeight, blnResize) {
    
    // Prevent default anchor event
    e.preventDefault();
    
    // Set values for window
    intWidth = intWidth || '500';
    intHeight = intHeight || '400';
    strResize = (blnResize ? 'yes' : 'no');

    // Set title and open popup with focus on it
    var strTitle = ((typeof this.attr('title') !== 'undefined') ? this.attr('title') : 'Social Share'),
        strParam = 'width=' + intWidth + ',height=' + intHeight + ',resizable=' + strResize,            
        objWindow = window.open(this.attr('href'), strTitle, strParam).focus();
  }
  
  /* ================================================== */
  
  jQuery(document).ready(function () {
    jQuery('.customer.share').on("click", function(e) {
      jQuery(this).customerPopup(e);
    });
  });
    
}(jQuery));