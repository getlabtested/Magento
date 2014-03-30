
var CheckoutFormVerification = new Class.create();
CheckoutFormVerification.prototype = {
    initialize: function(data)
    {
        this.customer_is_logged_in = data['customer_is_logged_in'];
        this.order_type = data['order_type'];
        this.is_prescription = data['is_prescription'];

        this.set_email_onchange_check();

        if (this.is_prescription) {
            this.prescription_form_validation_event();
        }
        else {
            this.non_prescription_form_validation_event();
        }
    },

    set_email_onchange_check: function()
    {
        Event.observe('billing:email', 'change', function() {
            v = document.getElementById('billing:email').value;
            r = Validation.get('IsEmpty').test(v);
            if (r === true) {
                alert('Please enter an email address.');
                error = 'Please enter an email address.';
                return;
            }

            x = /^([a-z0-9,!\#\$%&'\*\+\/=\?\^_`\{\|\}~-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z0-9,!\#\$%&'\*\+\/=\?\^_`\{\|\}~-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*@([a-z0-9-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z0-9-]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*\.(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]){2,})$/i.test(v);
            if (x === false) {
                alert('Please enter a valid email address.');
                error = 'Please enter a valid email address.';
                return;
            }
            error = 0;
        });
    },

    non_prescription_form_validation_event: function()
    {
        Event.observe('onestepcheckout-button-place-order', 'click', function(e) {

            set_credit_card_field_validation();

            var form = new VarienForm('one-step-checkout-form')
            var validator = new Validation(this.form);
            if (!validator.validate()) {
                document.getElementById('onestepcheckout-button-place-order').disabled=false;
                document.getElementById('ajax-loader-gif').style.display = 'none';
            }
            else {
                if (checkValues(this.customer_is_logged_in, this.is_prescription) && validateEmailConfirm(this.customer_is_logged_in) && isOfAge()) {
                    if (document.getElementById('p_method_authorizenet').checked) {
                        if (1 == this.order_type) {
                            if ((document.getElementById('zip_code_form').value == '') || (document.getElementById('lab-selected').value == 0) || (document.getElementById('lab-selected').value == ''))
                            {
                                document.getElementById('onestepcheckout-button-place-order').disabled=false;
                                document.getElementById('ajax-loader-gif').style.display='none';
                                alert('Please select a testing location in your area.');
                                return false;
                            }
                        }
                        else if (2 == this.order_type)
                        {
                            if (document.getElementById('billing:street1').value == '')
                            {
                                document.getElementById('onestepcheckout-button-place-order').disabled=false;
                                document.getElementById('ajax-loader-gif').style.display='none';
                                alert('Please enter your street address.');
                                return false;
                            }
                            else if (document.getElementById('billing:city').value == '')
                            {
                                document.getElementById('onestepcheckout-button-place-order').disabled=false;
                                document.getElementById('ajax-loader-gif').style.display='none';
                                alert('Please enter your city.');
                                return false;
                            }
                            else if (document.getElementById('billing:region_id').value == '')
                            {
                                document.getElementById('onestepcheckout-button-place-order').disabled=false;
                                document.getElementById('ajax-loader-gif').style.display='none';
                                alert('Please select your state.');
                                return false;
                            }
                            else if (document.getElementById('billing:postcode').value == '')
                            {
                                document.getElementById('onestepcheckout-button-place-order').disabled=false;
                                document.getElementById('ajax-loader-gif').style.display='none';
                                alert('Please enter your zip code.');
                                return false;
                            }
                        }
                        if (checkCc())
                        {
                            document.getElementById('one-step-checkout-form').submit();
                        }
                        else
                        {
                            document.getElementById('onestepcheckout-button-place-order').disabled=false;
                            document.getElementById('ajax-loader-gif').style.display='none';
                        }
                    }
                    else if (document.getElementById('p_method_paypal').checked)
                    {
                        // Whatever checks need to exist should go here
                        document.getElementById('one-step-checkout-form').submit();
                    }
                    else
                    {
                        if (1 == this.order_type) {
                            if ((document.getElementById('zip_code_form').value == '') || (document.getElementById('lab-selected').value == 0) || (document.getElementById('lab-selected').value == '')) {
                                document.getElementById('onestepcheckout-button-place-order').disabled=false;
                                document.getElementById('ajax-loader-gif').style.display='none';
                                alert('Please select a testing location in your area.');
                                return false
                            }
                        }
                        if (2 == this.order_type) {
                            if (document.getElementById('billing:street1').value == '') {
                                document.getElementById('onestepcheckout-button-place-order').disabled=false;
                                document.getElementById('ajax-loader-gif').style.display='none';
                                alert('Please enter your street address.');
                                return false;
                            } else if (document.getElementById('billing:city').value == ''){
                                document.getElementById('onestepcheckout-button-place-order').disabled=false;
                                document.getElementById('ajax-loader-gif').style.display='none';
                                alert('Please enter your city.');
                                return false;
                            } else if (document.getElementById('billing:region_id').value == '') {
                                document.getElementById('onestepcheckout-button-place-order').disabled=false;
                                document.getElementById('ajax-loader-gif').style.display='none';
                                alert('Please select your state.');
                                return false;
                            } else  if (document.getElementById('billing:postcode').value == '') {
                                document.getElementById('onestepcheckout-button-place-order').disabled=false;
                                document.getElementById('ajax-loader-gif').style.display='none';
                                alert('Please enter your zip code.');
                                return false;
                            }
                        }

                        if (!document.getElementById('cash').checked) {
                            document.getElementById('onestepcheckout-button-place-order').disabled=false;
                            document.getElementById('ajax-loader-gif').style.display='none';
                            alert('You have selected our Pay With Cash option, please check the checkbox to continue.');
                        } else {
                            document.getElementById('one-step-checkout-form').submit();
                        }
                    }
                }
                else
                {
                    document.getElementById('onestepcheckout-button-place-order').disabled=false;
                    document.getElementById('ajax-loader-gif').style.display = 'none';
                }
            }
        });
    },

    prescription_form_validation_event: function()
    {
        Event.observe('onestepcheckout-button-place-order', 'click', function(e) {

            set_credit_card_field_validation();

            var form = new VarienForm('one-step-checkout-form');
            var validator = new Validation(this.form);
            if (validator.validate()) {
                var element = e.element();
                element.disabled = true;
                $('one-step-checkout-form').submit();
                /*
                // disabled functionality relating to the pay-near-me option
                if(checkpayment()) {
                    disable_payment();
                }
                */
            } else {
                //alert('Error');
            }
        });
    },

    checkAjaxZipCodeConditions: function(ajax_zip_code_data) {
        if (ajax_zip_code_data['ajax_enabled']) {
            this.checkout_nnr_url = ajax_zip_code_data['checkout_nnr_url'];
            this.unallowed_medivo_states = ajax_zip_code_data['unallowed_medivo_states'];
            this.std_testing_options_url = ajax_zip_code_data['std_testing_options_url'];

            // Create hidden input element to hold the url which will be called via ajax
            // in the billing:postcode onchange function
            var hidden_element_html = '<input id="billing_postcode_ajax_check_url" type="hidden" value="'+this.checkout_nnr_url+'" />';
            $('one-step-checkout-form').insert(hidden_element_html);

            Event.observe('billing:postcode', 'change', function() {
                document.getElementById('onestepcheckout-button-place-order').disabled=true;
                if (document.getElementById("zipcode-ajax-loader-gif-co"))
                {
                    document.getElementById("zipcode-ajax-loader-gif-co").style.display = 'block';
                }

                var request = new Ajax.Request(
                    document.getElementById('billing_postcode_ajax_check_url').value,
                    // above url is https://getstdtested.com/onestepcheckout/index/nnr/
                    {
                        method: 'post',
                        onComplete: function(response){

                            document.getElementById('onestepcheckout-button-place-order').disabled=false;
                            if (document.getElementById("zipcode-ajax-loader-gif-co"))
                            {
                                document.getElementById("zipcode-ajax-loader-gif-co").style.display = 'none';
                            }

                            var json_response = jQuery.parseJSON( response.responseText );
                            if (json_response.is_nnr) {
                                alert('Due to state regulations in ' + json_response.nnr_medivo_states + ', at home STD testing for chlamydia, gonorrhea, and trichomoniasis is not currently available. Please select lab testing or call us for products available in your area at 855-287-6195.');
                                location = json_response.std_testing_options_url;
                            }
                            else if(json_response.is_not_allowed)
                            {
                                alert(json_response.unallowed_medivo_states_message);
                            }
                        },
                        parameters: "zip_code="+document.getElementById('billing:postcode').value
                    }
                );
            });
        }
    }
};

function set_credit_card_field_validation()
{
    var form = new VarienForm('one-step-checkout-form');

    var form_form = form.form
    var form_validator = form.validator;
    var validator_form = form_validator.form;

    var credit_card_fields = ["payment[cc_type]", "payment[cc_number]", "payment[cc_cid]", "payment[cc_exp_month]", "payment[cc_exp_year]"];
    var is_credit_card_payment = document.getElementById('p_method_authorizenet').checked;

    for(var i in validator_form) {
        if (credit_card_fields.indexOf(i) >= 0)
        {
            if (is_credit_card_payment)
            {
                validator_form[i].addClassName('required-entry');
                if (i == "payment[cc_number]")
                {
                    validator_form[i].addClassName('validate-cc-type');
                    validator_form[i].addClassName('validate-cc-number');
                }
                if (i == "payment[cc_type]")
                {
                    validator_form[i].addClassName('validate-cc-type-select');
                }
            }
            else
            {
                validator_form[i].removeClassName('required-entry');
                validator_form[i].removeClassName('validate-cc-type-select');
                validator_form[i].removeClassName('validate-cc-number');
                validator_form[i].removeClassName('validate-cc-type');
            }
        }
    }
}

function isOfAge()
{
    var today = new Date();
    var nD = today.getDate();
    var nM = today.getMonth()+1;
    var nY = today.getFullYear() - 18;

    m = document.getElementById('m_select').value;
    d = document.getElementById('d_select').value;
    y = document.getElementById('y_select').value;

    if (y < nY) {
        return true;
    }
    if (y == nY && m < nM){
        return true;
    }
    if ((y == nY) && (m == nM) && (d <= nD)) {
        return true;
    }

    document.getElementById('onestepcheckout-button-place-order').disabled=false;
    document.getElementById('ajax-loader-gif').style.display = 'none';
    alert('You must be over 18.');
    return false;
}

function checkValues(customer_is_logged_in, is_prescription) {
    err = 0;
    if (document.getElementById('billing:firstname').value == '') {
        document.getElementById('onestepcheckout-button-place-order').disabled=false;
        document.getElementById('ajax-loader-gif').style.display='none';
        alert('First Name is required.');
        err = 1;
        return false;
    }
    if (document.getElementById('billing:lastname').value == '') {
        document.getElementById('onestepcheckout-button-place-order').disabled=false;
        document.getElementById('ajax-loader-gif').style.display='none';
        alert('Last Name is required.');
        err = 1;
        return false;
    }

    if (is_prescription) {
        if (document.getElementById('billing:gender').value == '') {
            document.getElementById('onestepcheckout-button-place-order').disabled=false;
            document.getElementById('ajax-loader-gif').style.display='none';
            alert('Gender is required.');
            err = 1;
            return false;
        }
        if (!customer_is_logged_in) {
            if (document.getElementById('billing:email').value == '') {
                document.getElementById('onestepcheckout-button-place-order').disabled=false;
                document.getElementById('ajax-loader-gif').style.display='none';
                alert('Email is required.');
                err = 1;
                return false;
            }
            if (document.getElementById('m_select').value == '' || document.getElementById('d_select').value == '' || document.getElementById('y_select').value == '') {
                document.getElementById('onestepcheckout-button-place-order').disabled=false;
                document.getElementById('ajax-loader-gif').style.display = 'none';
                alert('Date of Birth is required.');
                err = 1;
                return false;
            }
        }
    }

    if (err == 1) {
        return false;
    } else {
        return true;
    }
}

function validateEmailConfirm(customer_is_logged_in)
{
    if (!customer_is_logged_in) {
        if (document.getElementById('billing:email').value != document.getElementById('billing:email-confirm').value) {
            document.getElementById('onestepcheckout-button-place-order').disabled=false;
            document.getElementById('ajax-loader-gif').style.display='none';
            alert('Email Address does not match Confirm Email Address');
            return false;
        }
    }
    return true;
}

function checkCc() {
    if(document.getElementById('authorizenet_cc_type').value == '') {
        document.getElementById('onestepcheckout-button-place-order').disabled=false;
        document.getElementById('ajax-loader-gif').style.display = 'none';
        alert('Please select a credit card type.');
        return false;
    }
    if(document.getElementById('authorizenet_cc_number').value == '')
    {
        document.getElementById('onestepcheckout-button-place-order').disabled=false;
        document.getElementById('ajax-loader-gif').style.display = 'none';
        alert('Please enter a valid credit card number.');
        return false;
    }
    if(document.getElementById('authorizenet_expiration').value == '')
    {
        document.getElementById('onestepcheckout-button-place-order').disabled=false;
        document.getElementById('ajax-loader-gif').style.display = 'none';
        alert('Please select an expiration month.');
        return false;
    }
    if(document.getElementById('authorizenet_expiration_yr').value == '')
    {
        document.getElementById('onestepcheckout-button-place-order').disabled=false;
        document.getElementById('ajax-loader-gif').style.display = 'none';
        alert('Please select an expiration year.');
        return false;
    }
    return true;
}
