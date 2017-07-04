// Created by HungDQ from HxTech team - 2016

function reloadProductPrice(currentTarget, productId) {
    productType = currentTarget.value;
    new Ajax.Request(
        baseReloadUrl + 'productId/' + productId + '/productType/' + productType + '/',
        {
            method: 'post',
            onSuccess: function (transport) {
                if(transport.status == 200){
                    var responseData = transport.responseText.evalJSON();
                    jQuery('#product-price-' + productId).html(responseData.html);
                    jQuery('.product-unit-' + productId).html(responseData.units);
                    if(responseData.base_price){
                        jQuery('#old-price-' + productId).html(responseData.base_price);
                    }

                    if(jQuery( "input[name^='product']" ).val() == productId){
                        reloadContainerSection(productId);
                    }
                }
            }
        }
    );
}

function reloadClosestPort(countryId, addressId){
    new Ajax.Request(
        baseUrl + 'logistic/supplier/reloadClosestPort/',
        {
            method: 'post',
            parameters: {countryId: countryId, addressId: addressId},
            onSuccess: function (transport) {
                if(transport.status == 200){
                    var responseData = transport.responseText.evalJSON();
                    jQuery('#closestport-wrap').html(responseData.html);
                }
            },
            onCreate: function() {},
            onFailure: function() {}
        }
    );
} 

function findAncestor (el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    return el;
}

function removeLastCharacter(string, lastCharacter){
    if (string.charAt(string.length - 1) == lastCharacter) {
        string = string.substr(0, string.length - 1);
    }
    return string;
}

function reloadCityFieldByCountry(actionUrl, currentTarget) {
    countryCode = currentTarget.value;
    new Ajax.Request(
        actionUrl,
        {
            method: 'post',
            parameters: {countryCode: countryCode},
            onSuccess: function (transport) {
                if(transport.status == 200){
                    var responseData = transport.responseText.evalJSON();
                    $('destination_port').up(0).innerHTML  = responseData['html'];
                }
            },
        }
    );
}

function reloadClosestPortAdminByCountry(countryId, closestPortElement) {
    actionUrl = baseUrl + 'logistic/adminhtml_port/reloadClosestPortAdminByCountry/',
    new Ajax.Request(
        actionUrl,
        {
            method: 'post',
            parameters: {countryId: countryId, currentClosestPort: closestPortElement.value},
            onSuccess: function (transport) {
                if(transport.status == 200){
                    var responseData = transport.responseText.evalJSON();
                    closestPortElement.innerHTML  = responseData['html'];
                }
            },
        }
    );
}

function reloadContainerSection(productId){
    var type = jQuery('.productTypeDdl').first().val();
    var qty = jQuery("#qty").val();
    var palletId = jQuery('#palletDdl').val();
    actionUrl = baseUrl + 'logistic/supplier/reloadContainerSection/',
    new Ajax.Request(
        actionUrl,
        {
            method: 'post',
            parameters: {productId: productId, qty: qty, type: type, palletId: palletId},
            onSuccess: function (transport) {
                if(transport.status == 200){
                    var responseData = transport.responseText.evalJSON();
                    if(responseData['html']){
                        $('container-section').innerHTML  = responseData['html'];
                    }
                }
            },
            onCreate: function() {},
            onFailure: function() {}
        }
    );
}

function validateRegisterBlock(currentBlock) {
    var invalidCount = 0;
    currentBlock.find('input,select,textarea').each(function(){
        Validation.validate(this);
        if(Validation.validate(this) == false){
            invalidCount++;
        }
    });
    if(invalidCount > 0){
        return false;
    }
    return true;
}

function registerBackToStep(step){
    if(step == 'customer-information'){
        jQuery('.register-step').hide();
        jQuery('.customer-information').show();
        jQuery('.icon_customer').removeClass('completed');
        jQuery('.icon_business').removeClass('active');     
    }
    if(step == 'business-address'){
        jQuery('.register-step').hide();
        jQuery('.business-information').show();
        jQuery('.icon_business').removeClass('completed');
        jQuery('.icon_login').removeClass('active');     
    }
    if(step == 'login-information'){
        jQuery('.register-step').hide();
        jQuery('.login-information').show();
        jQuery('.icon_login').removeClass('completed');
        jQuery('.icon_additional').removeClass('active');     
    }
}

function reloadCbmSection(currentTarget){
    var palletId = currentTarget.value;
    if(palletId == ""){
        $('cbm-data').innerHTML = "";
    }
    actionUrl = baseUrl + 'logistic/pallet/reloadCbmSection/',
    new Ajax.Request(
        actionUrl,
        {
            method: 'post',
            parameters: {id: palletId},
            onSuccess: function (transport) {
                if(transport.status == 200){
                    var responseData = transport.responseText.evalJSON();
                    $('cbm-data').innerHTML  = responseData['html'];
                }
            },
            onCreate: function() {},
            onFailure: function() {}
        }
    );
}