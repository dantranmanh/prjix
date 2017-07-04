/* IMPORTANT: jQuery must be include before prototype.js */
/************ Fix hide function from prototype */
(function() {
    var isBootstrapEvent = false;
    if (window.jQuery) {
        var all = jQuery('*');
        jQuery.each(['hide.bs.dropdown', 
            'hide.bs.collapse', 
            'hide.bs.modal', 
            'hide.bs.tooltip',
            'hide.bs.popover'], function(index, eventName) {
            all.on(eventName, function( event ) {
                isBootstrapEvent = true;
            });
        });
    }
    var originalHide = Element.hide;
    Element.addMethods({
        hide: function(element) {
            if(isBootstrapEvent) {
                isBootstrapEvent = false;
                return element;
            }
            return originalHide(element);
        }
    });
})();

/***************** Script to show/hide sub menu */
jQuery(document).ready(function () {
	jQuery('.nav-mobile .dropdown-toggle').click(function(){
	
	if (!jQuery(this).hasClass('active')){				  
		jQuery('.nav-mobile .dropdown-menu').slideToggle();
		jQuery('.nav-mobile .dropdown-toggle').addClass('active');
	}
	else if (jQuery(this).hasClass('active')) {
		jQuery('.nav-mobile .dropdown-menu').slideToggle();
		jQuery('.nav-mobile .dropdown-toggle').removeClass('active');
	}
	});
	//level 0
	jQuery( ".nav-mobile .dropdown-menu > li.level0.parent" ).append( "<a class='right show-cat' href='javascript://'>&nbsp;</a>" );
	
	jQuery('.nav-mobile .dropdown-menu > li > a.show-cat').click(function(){
	jQuery('.nav-mobile .dropdown-menu > li ul.level0').slideUp();
	if (!jQuery(this).hasClass('active')){				  
		jQuery(this).prev().slideToggle();
		jQuery('.nav-mobile .dropdown-menu li a.show-cat').removeClass('active');
		jQuery(this).addClass('active');
	}
	else if (jQuery(this).hasClass('active')) {
		jQuery(this).removeClass('active');
	}
	});
	//level 1
	jQuery( ".nav-mobile .dropdown-menu li.level1.parent" ).append( "<a class='right show-cat' href='javascript://'>&nbsp;</a>" );
	
	jQuery('.nav-mobile .dropdown-menu li.level1.parent > a.show-cat').click(function(){
	jQuery('.nav-mobile .dropdown-menu li.level1.parent ul.level1').slideUp();
	if (!jQuery(this).hasClass('active')){				  
		jQuery(this).prev().slideToggle();
		jQuery('.nav-mobile .dropdown-menu li.level1.parent > a.show-cat').removeClass('active');
		jQuery(this).addClass('active');
	}
	else if (jQuery(this).hasClass('active')) {
		jQuery(this).removeClass('active');
	}
	});
});








