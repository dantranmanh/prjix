define([
	"jquery",
	"jquery/ui",
	
	],

function (jQuery) {
	  "use strict";
		jQuery.widget('Navigationmenupro.cwsmenu', { 
		_init: function () {
				var cnt_nav = jQuery(this.element).parent().find("nav").length;
				
				if(jQuery(this.element).parent().hasClass("nav-sections-item-content") && cnt_nav < 2 ){
				//if(jQuery(this.element).parent().hasClass("nav-sections-item-content") && cnt_nav < 2 ){
					this._assignControls()._listen();
					//this._cwstogglemenu();
				}
			this._cwstogglemenu();
			this._cwsactivemenu();
				
        	},
			
			_create: function() {
				var responsive_breakpoint = this.options.responsive_breakpoint;
				var resizeScreen = responsive_breakpoint.replace("px", "");
				var resizeTimer;
				//console.log('_create ::'+resizeScreen);
				jQuery('ul.smart-expand').find("li.active").children().children("span.arw").removeClass("plush").addClass('minus');
				
				//set level number for group options
				jQuery(".cwsMenu .Level0 > .hideTitle").each(function() {
					jQuery(this).find(".Level1 > li.Level2").removeClass("Level2").addClass("Level1");
					jQuery(this).find(".Level2 > li.Level3").removeClass("Level3").addClass("Level2");
					jQuery(this).find(".Level3 > li.Level4").removeClass("Level4").addClass("Level3");
					jQuery(this).find(".Level4 > li.Level5").removeClass("Level5").addClass("Level4");
					//alert(this);
				});
				
				var toplinkHeight = jQuery(".mega-menu.horizontal > li").height();
				jQuery(".mega-menu.horizontal > li > ul.Level0").css("top",toplinkHeight);
				
				//Add padding in lavale 4/5 in expand menu
				var groupId = this.options.group_id;
				var spadding = parseInt(jQuery(groupId+" ul.smart-expand a.Level3").css("padding-left"));
				jQuery(groupId+" ul.smart-expand a.Level4").css("padding-left",spadding+10);
				jQuery(groupId+" ul.smart-expand a.Level5").css("padding-left",spadding+20);
				
				var apadding = parseInt(jQuery(groupId+" ul.always-expand a.Level3").css("padding-left"));
				jQuery(groupId+" ul.always-expand a.Level4").css("padding-left",apadding+10);
				jQuery(groupId+" ul.always-expand a.Level5").css("padding-left",apadding+20);
				
				
				jQuery(window).on('load resize', function() {
					if (jQuery(window).width() > resizeScreen ) {
						jQuery('ul.cwsMenu.mega-menu').find("li > ul").css('display','');
						jQuery('ul.cwsMenu.mega-menu').find("li.active").parents('li').addClass('showSub');
					}
					clearTimeout(resizeTimer);
					resizeTimer = setTimeout(function (e) {
						jQuery(window).trigger('resize', e);
					}, 200);
				});
				
			  },
			
			_assignControls: function () {
				this.controls = {
					toggleBtn: jQuery('[data-action="toggle-nav"]'),
					swipeArea: jQuery('.nav-sections')
				};

           	 return this;
  	   	  },
	
		_listen: function () {
			var controls = this.controls;
			var toggle = this.toggle;

			this._on(controls.toggleBtn, {'click': toggle});
			this._on(controls.swipeArea, {'swipeleft': toggle});
		},

		toggle: function () {
			if (jQuery('html').hasClass('nav-open')) {
				jQuery('html').removeClass('nav-open');

				setTimeout(function () {
					jQuery('html').removeClass('nav-before-open');
				}, 300);
			} else {
				jQuery('html').addClass('nav-before-open');

				setTimeout(function () {
					jQuery('html').addClass('nav-open');
				}, 42);
			}
		},
		_cwstogglemenu: function () {
			var group_id = this.options.group_id;
			//console.log(group_id+" > .cwsMenu li span.arw");
			jQuery(group_id+" > .cwsMenu li span.arw").click(function(e){
				console.log(group_id+" > .cwsMenu li span.arw used");
			//jQuery(".cwsMenu li span.arw").click(function(e){
			//	e.stopPropagation();
				if(jQuery(this).hasClass("plush")) {
					if(jQuery(this).parent().next("ul").find("li").hasClass("hideTitle")) {
						jQuery(this).parent().next("ul").find("li").next("ul").slideDown();
					}
					jQuery(this).parent().next("ul").slideDown();
					jQuery(this).parent().next(".cmsbk").slideDown();
					jQuery(this).removeClass("plush");
					jQuery(this).addClass("minus");
				} else {
					jQuery(this).parent().next("ul").slideUp();
					jQuery(this).parent().next(".cmsbk").slideUp();
					jQuery(this).addClass("plush");
					jQuery(this).removeClass("minus");
				}
				return false;
			});
		},
		_cwsactivemenu: function () {
			var pathname = window.location.pathname; // Returns path only
			var url      = window.location.href; 
			
			if(this.options.menu_type=='list-item'){
				jQuery(".cwsMenu li").removeClass("active");
				jQuery("a[href~='"+url+"']").parents().addClass("active");
				jQuery(this).find("li.active").parents('li').addClass('active');
				jQuery(this).find("li.active").parents('li').addClass('active');
				jQuery(".active").parents(this.options.group_id+" ul > li").addClass('active');
			}else{
				jQuery(".cwsMenu li").removeClass("active");
				jQuery("a[href~='"+url+"']").parents().addClass("active");	
			}
		},
		cwsmobmenu: function () { 
			var responsive_breakpoint = this.options.responsive_breakpoint;
			var resizeScreen = responsive_breakpoint.replace("px", "");
			//console.log('cwsmob ::'+resizeScreen);
			if (jQuery(window).width() > resizeScreen) {
				//jQuery(this).find("li.active").addClass('showSub');
				jQuery(this).find("li.active").children().children("span.arw").removeClass("plush").addClass('minus');
			}
		},
			
	});
 	return jQuery.Navigationmenupro.cwsmenu;
});