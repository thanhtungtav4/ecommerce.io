(function($){
	$(document).ready(function(){
        $(window).load(function(){
            var $defaultSetting = {
                formatNoMatches: vncheckout_array.formatNoMatches,
            };
            var loading_billing = loading_shipping = false;
            //billing

            //User profile
            $('#billing_state').select2($defaultSetting);
            $('#billing_city').select2($defaultSetting);
            $('#billing_address_2').select2($defaultSetting);

            $('body').on('click', '#add_customer_to_register', function () {
                setTimeout(function () {
                    $('body #billing_state, body #shipping_state').select2();
                    $('body #billing_city,body #billing_address_2').select2();
                    $('body #shipping_city,body #shipping_address_2').select2();
                }, 500)
            });

            $('body').on('change', '#billing_state', function(e){
                $( "body #billing_city option" ).val('');
                var matp = e.val;
                if(!matp) matp = $( "body #billing_state option:selected" ).val();
                if(matp && !loading_billing){
                    loading_billing = true;
                    $.ajax({
                        type : "post",
                        dataType : "json",
                        url : vncheckout_array.get_address,
                        data : {action: "load_diagioihanhchinh", matp : matp},
                        context: this,
                        beforeSend: function(){
                            $('body #billing_city_field').addClass('devvn_loading');
                            $('body #billing_address_2_field').addClass('devvn_loading');
                        },
                        success: function(response) {
                            loading_billing = false;
                            $("body #billing_city,body #billing_address_2").html('').select2();
                            if(response.success) {
                                var listQH = response.data;
                                var newState = new Option('', '');
                                $("body #billing_city").append(newState);
                                $.each(listQH,function(index,value){
                                    var newState = new Option(value.name, value.maqh);
                                    $("body #billing_city").append(newState);
                                });
                            }
                            $('body #billing_city_field').removeClass('devvn_loading');
                            $('body #billing_address_2_field').removeClass('devvn_loading');
                        }
                    });
                }
            });
            $('body').on('change', '#billing_city', function(e){
                var maqh = e.val;
                if(!maqh) maqh = $( "body #billing_city option:selected" ).val();
                if(maqh) {
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: vncheckout_array.get_address,
                        data: {action: "load_diagioihanhchinh", maqh: maqh},
                        context: this,
                        beforeSend: function(){
                            $('body #billing_address_2_field').addClass('devvn_loading');
                        },
                        success: function (response) {
                            $("body #billing_address_2").html('').select2();
                            if (response.success) {
                                var listQH = response.data;
                                var newState = new Option('', '');
                                $("body #billing_address_2").append(newState);
                                $.each(listQH, function (index, value) {
                                    var newState = new Option(value.name, value.xaid);
                                    $("body #billing_address_2").append(newState);
                                });
                            }
                            $('body #billing_address_2_field').removeClass('devvn_loading');
                        }
                    });
                }
            });
            //shipping

            //User profile
            $('#shipping_state').select2($defaultSetting);
            $('#shipping_city').select2($defaultSetting);
            $('#shipping_address_2').select2($defaultSetting);

            $('body').on('change', '#shipping_state', function(e){
                $( "body #shipping_city option" ).val('');
                var matp = e.val;
                if(!matp) matp = $( "body #shipping_state option:selected" ).val();
                if(matp && !loading_shipping){
                    loading_shipping = true;
                    $.ajax({
                        type : "post",
                        dataType : "json",
                        url : vncheckout_array.get_address,
                        data : {action: "load_diagioihanhchinh", matp : matp},
                        context: this,
                        beforeSend: function(){
                            $('body #shipping_city_field').addClass('devvn_loading');
                            $('body #shipping_address_2_field').addClass('devvn_loading');
                        },
                        success: function(response) {
                            loading_shipping = false;
                            $("body #shipping_city,body #shipping_address_2").html('').select2();
                            if(response.success) {
                                var listQH = response.data;
                                var newState = new Option('', '');
                                $("body #shipping_city").append(newState);
                                $.each(listQH,function(index,value){
                                    var newState = new Option(value.name, value.maqh);
                                    $("body #shipping_city").append(newState);
                                });
                            }
                            $('body #shipping_city_field').removeClass('devvn_loading');
                            $('body #shipping_address_2_field').removeClass('devvn_loading');
                        }
                    });
                }
            });
            $('body').on('change', '#shipping_city',function(e){
                var maqh = e.val;
                if(!maqh) maqh = $( "body #shipping_city option:selected" ).val();
                if(maqh) {
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: vncheckout_array.get_address,
                        data: {action: "load_diagioihanhchinh", maqh: maqh},
                        context: this,
                        beforeSend: function(){
                            $('body #shipping_address_2_field').addClass('devvn_loading');
                        },
                        success: function (response) {
                            $("body #shipping_address_2").html('').select2();
                            if (response.success) {
                                var listQH = response.data;
                                var newState = new Option('', '');
                                $("body #shipping_address_2").append(newState);
                                $.each(listQH, function (index, value) {
                                    var newState = new Option(value.name, value.xaid);
                                    $("body #shipping_address_2").append(newState);
                                });
                            }
                            $('body #shipping_address_2_field').removeClass('devvn_loading');
                        }
                    });
                }
            });
        });
	});
})(jQuery);