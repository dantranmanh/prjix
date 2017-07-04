document.observe("dom:loaded", function() {
    var targetElements = 'a.alert-price, a.link-wishlist, a.link-share';
    if('undefined' != typeof(amQuickviewIsRedirect) && amQuickviewIsRedirect == '1') {
        targetElements += ',#product_addtocart_form';
        $('product_addtocart_form').insert("<input type='hidden' name='in_cart' value='1'>");
    }
    $$(targetElements).each(function(link){
        link.writeAttribute('target','_parent');
        link.writeAttribute('onclick','');
        link.onclick = "";
        jQuery(link).removeAttr("onclick");
	});
});