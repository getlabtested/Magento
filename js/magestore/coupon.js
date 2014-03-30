
var CheckoutCoupon = new Class.create();
CheckoutCoupon.prototype = {
    initialize: function(post_url)
    {
        this.post_url = post_url;
    },

    addCoupon: function() {
        document.getElementById('ajax-loader-gif-cu').style.display = 'block';
        var request = new Ajax.Request(
            this.post_url,
            {
                method: 'post',
                onComplete: function(transport){
                    var jsonResponse=transport.responseText;
                    if (jsonResponse != 0) {
                        document.getElementById('ajax-loader-gif-cu').style.display = 'none';
                        document.getElementById('remove_button').style.display = 'block';
                        document.getElementById('apply_button').style.display = 'none';
                        document.getElementById('order_total_dyn').innerHTML = jsonResponse;
                    }
                    else {
                        document.getElementById('ajax-loader-gif-cu').style.display = 'none';
                        alert('We\'re Sorry! The coupon code you attempted to enter is invalid. Please try again.');
                    }
                },
                parameters: "coupon_code="+document.getElementById('coupon_code').value
            }
        );
    },

    removeCoupon: function() {
        document.getElementById('ajax-loader-gif-cu').style.display = 'block';
        var request = new Ajax.Request(
            this.post_url,
            {
                method: 'post',
                onComplete: function(transport){
                    var jsonResponse=transport.responseText;
                    if (jsonResponse != 0) {
                        document.getElementById('ajax-loader-gif-cu').style.display = 'none';
                        document.getElementById('apply_button').style.display = 'block';
                        document.getElementById('remove_button').style.display = 'none';
                        document.getElementById('order_total_dyn').innerHTML = jsonResponse;
                    }
                },
                parameters: "remove=1"
            }
        );
    }
}
