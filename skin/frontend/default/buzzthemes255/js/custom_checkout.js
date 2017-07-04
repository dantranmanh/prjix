var CustomCheckout = Class.create();
CustomCheckout.prototype = {

    initialize: function(is_logged_in) {
        if (is_logged_in) {
            var stepProgress = this.steps = [
                {'id':'addressStep', 'action': 'opc-billing'},
                {'id':'addressStep', 'action': 'opc-shipping'},
                {'id':'deliveryStep' , 'action': 'opc-shipping_method'},
                {'id':'paymentStep' , 'action': 'opc-payment'},
                {'id':'reviewStep' , 'action': 'opc-review'}
            ];
        } else {
            var stepProgress = this.steps = [
                {'id':'addressStep', 'action': 'opc-login'},
                {'id':'deliveryStep' , 'action': 'opc-shipping_method'},
                {'id':'paymentStep' , 'action': 'opc-payment'},
                {'id':'reviewStep' , 'action': 'opc-review'}
            ];
        }

        this.steps.each(function(step,index) {
            var step_in_progress_bar = $(step.id);
            step_in_progress_bar.observe('click', function(){
                if (step_in_progress_bar.hasClassName('active')) {
                    checkout.changeSection(step.action);
                    // var currentIndex = index + 1;
                    // var currentSection = $(stepProgress[currentIndex].id);
                    // if (currentSection && stepProgress[currentIndex].id != 'addressStep') {
                    //     currentSection.removeClassName('active');
                    // }
                    // #249 - HungDQ - Fixing progress bar active 
                    if(index == 0 || index == 1){
                        $("deliveryStep").removeClassName('active');
                        $("paymentStep").removeClassName('active');
                        $("reviewStep").removeClassName('active');
                    }
                    if(index == 2){
                        $("paymentStep").removeClassName('active');
                        $("reviewStep").removeClassName('active');
                    }
                    if(index == 3){
                        $("reviewStep").removeClassName('active');
                    }
                    // end #249
                }
                return false;
            })
        });
    },

    active_step: function(step_id) {
        var step_in_progress_bar = $(step_id);
        if (step_in_progress_bar) {
            step_in_progress_bar.addClassName('active');
        }
    },

    remove_step: function(step_id) {
        var step_in_progress_bar = $(step_id);
        if (step_in_progress_bar) {
            step_in_progress_bar.removeClassName('active');
        }
    }

};