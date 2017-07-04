jQuery(function(){
		jQuery.widget("Navigationmenupro.menugrid", {
		   _create: function() { 
			  this._button = jQuery("<button>"); 
			  this._button.text("My first Menu Button");
			  this._button.width(this.options.width) 
			  this._button.css("background-color", this.options.color);    
			  this._button.css("position", "fixed");   
			  this._button.css("left", "300px");            
			  jQuery(this.element).append(this._button);
		   },
		   _init: function () {
			console.log('init');
			
		},
		_load: function(){
			
		},
	});
	jQuery("#button2").menugrid();
   		
});