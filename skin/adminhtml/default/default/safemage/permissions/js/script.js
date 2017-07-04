var SafeMageCategoryTreeUpdater = Class.create({

    initialize: function (config) {
        this.config = config;
        //this.elementToUpdate = $(this.config.idToUpdate);
        this.idToUpdate = this.config.idToUpdate;
        this.storeMultiselect = $(this.config.idStoreMultiselect);
        //Event.observe(document, 'dom:loaded', this.onReady.bind(this));

        Event.observe(this.storeMultiselect, 'blur', this.onStoresChange.bind(this));
    },

    onStoresChange: function() {
        this.config.parameters[ this.config.storeIdsVarName ]= this.storeMultiselect.getValue();
        this.update();
    },

    onReady: function () {
        //this.bindElements();
    },

    update: function () {
        new Ajax.Request(this.config.url, {
            method: 'post',
            parameters: this.config.parameters,
            onCreate: function(){

            },
            onComplete:function(){

            },
            onSuccess: this.onSubmitSuccess.bind(this)
        });
    },

    onSubmitSuccess: function (transport) {
        var response = {};
        if (transport && transport.responseText) {
            var content = transport.responseText;

            if (this.idToUpdate) {
                var elementToUpdate = $(this.idToUpdate);
                if (elementToUpdate) {
                    elementToUpdate.replace(content);
                }
            }
        }
    }
});

var SafeMageSelectedProductsUpdater = Class.create({

    initialize: function (config) {
        this.config = config;
        this.storeMultiselect = $(this.config.idStoreMultiselect);

        Event.observe(this.storeMultiselect, 'blur', this.onStoresChange.bind(this));
    },

    _enableDisabledElements: function() {
        $$('#' + this.config.productsGridId + ' th [disabled]').each(function(e){
            e.disabled = false;
        });
    },

    onStoresChange: function() {
        var storeIds = this.storeMultiselect.getValue();
        var sStoreIds = storeIds.toString();

        var hiddenStores = $(this.config.storesSelector1) ? $(this.config.storesSelector1) : $(this.config.storesSelector2);
        hiddenStores.setValue(sStoreIds);
        var productsGrid = window[this.config.productsGridVarName];  // selectedProductsGridJsObject



        // first should enable all disabled inputs
        this._enableDisabledElements();

        /*
         selectedProductsGrid_massactionJsObject.getCheckedValues();
         selectedProductsGrid_massactionJsObject.setCheckedValues('3,2');
         selectedProductsGrid_massactionJsObject.updateCount();
        */

        /*
        selectedProductsGridJsObject.massaction.getCheckedValues();
        selectedProductsGridJsObject.massaction.setCheckedValues('4,3');
         selectedProductsGridJsObject.massaction.updateCount();
        */

        //productsGrid.doFilter();

        this.config.parameters[ this.config.storeIdsVarName ]= this.storeMultiselect.getValue();
        this.update();
    },

    update: function () {
        new Ajax.Request(this.config.url, {
            method: 'post',
            parameters: this.config.parameters,
            onCreate: function(){

            },
            onComplete:function(){

            },
            onSuccess: this.onSubmitSuccess.bind(this)
        });
    },

    onSubmitSuccess: function (transport) {
        var response = {};
        if (transport && transport.responseText) {
            var content = transport.responseText;

            if (this.config.idToUpdate) {
                var elementToUpdate = $(this.config.idToUpdate);
                if (elementToUpdate) {
                    elementToUpdate.replace(content);
                }
            }
        }
    }
});

var SafeMageAttributeRadio = Class.create({
    initialize: function (config) {
        this.config = config;
    },

    massCheckRadios: function(selector, hiddenIdsStr) {
        var self = this;
        $$(selector).each(function(i){
            i.checked = true;

            self.checkRadio(i, hiddenIdsStr);
        });
    },

    _decodeHiddenRadios: function(s) {
        var a = (s.length) ? s.split( this.config.DELIMITER2 ) : {};
        var a2 = {};
        for (var i = 0; i < a.length; i++) {
            var parts = a[i].split( this.config.DELIMITER1 );
            var attr = parts[0];
            var perm = parts[1];
            a2[attr]= perm;
        }
        return a2;
    },

    _encodeHiddenRadios: function(a2) {
        var a = [];
        for (var i in a2) {
            var value = i + this.config.DELIMITER1 + a2[i];
            a.push(value);
        }
        var s = a.join(this.config.DELIMITER2);
        return s;
    },

    _findExistingHidden: function(hiddenIdsStr) {
        var hiddenIds = hiddenIdsStr.split(',');
        var hiddenRadios;
        for(var i = 0; i < hiddenIds.length; i++) {
            var id = hiddenIds[i];
            if ($(id)) {
                hiddenRadios = $(id);
            }
        }
        return hiddenRadios;
    },

    checkRadio: function(radio, hiddenIdsStr) {
        var hiddenRadios = this._findExistingHidden(hiddenIdsStr);
        var s = hiddenRadios.getValue();
        var a = this._decodeHiddenRadios(s);

        // Update hidden radios
        var name = radio.getAttribute('name');
        //var attrId = parseInt(name.replace(/\D/g,''));
		var matches = name.match(/[^\[\]]+/g)
		var attrId = matches.pop();
		
        var permission = radio.getValue();

        a[attrId]= permission;

        s = this._encodeHiddenRadios(a);
        hiddenRadios.setValue(s);
    }
});
var safeMageAttributeRadio = new SafeMageAttributeRadio({DELIMITER1: '|', DELIMITER2: ','});

function safemageSetReadonlyFieldsetChildren(configId) {
    var selector = 'fieldset#' + configId + ' input, fieldset#' + configId + ' select, fieldset#' + configId + ' textarea';
    $$(selector).each(function(i){
        i.setAttribute('readonly', 1);
        i.setAttribute('disabled', 'disabled');
    });
}


