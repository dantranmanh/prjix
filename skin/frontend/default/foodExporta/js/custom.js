 jQuery(document).ready(function(){
		  
			jQuery('.mobile-menu-button').click(function(){ 
				console.log(1);
			  jQuery('.category-content-page .col-left').toggleClass('open');
			  jQuery('.category-content-page .over-menu').toggleClass('open');
		  });
		  jQuery(document).on('click','.category-content-page .over-menu', function(){
			  jQuery(this).removeClass('open');
			  jQuery('.category-content-page .col-left').removeClass('open');
		  });
	  });
//jQuery('body').on('click', 'li.parent > a', function(e){
jQuery(document).ready(function(){
/* 	jQuery('.login > a').click(function(e){
		console.log(1234);
		e.preventDefault();
		return false;
	}); */
	/* jQuery('#narrow-by-list li.parent > a').click(function(e){
		console.log(1234);
		e.preventDefault();
		return false;
	}); */
	
});
jQuery(document).on('click', '.login > a', function(e){
	console.log(123);
	e.preventDefault();
	return false;
});

function loadAjax(e){
	console.log('12');
	e.preventDefault();
	var el = jQuery(e);
	var url = el.attr('href');	
	jQuery.ajax({
		url: url,
		dataType: 'html',
		type : 'post',
		success: function(data){ 
			console.log(data);
			
		},
		error: function(){
		  console.log('error');
		}
	});
	return false;
}