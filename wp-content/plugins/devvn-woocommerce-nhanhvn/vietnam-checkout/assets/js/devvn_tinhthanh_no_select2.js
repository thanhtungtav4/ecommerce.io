function copyToClipboard(element) {
    var $temp = jQuery("<input>");
    jQuery("body").append($temp);
    jQuery(element).addClass('copying');
    setTimeout(function() {
        jQuery(element).removeClass('copying');
    }, 300);
    $temp.val(jQuery(element).html()).select();
    document.execCommand("copy");
    $temp.remove();
}

(function($) {
    'use strict';
    $(document).ready(function () {

        let city_args = {},
            ward_args = {};

        let VNAddress = (function (){
            let returnOb = {};

            //City
            let namecache = 'cities_' + vncheckout_array.vnaddress_db_version;
            localStorage.setItem(namecache, (localStorage.getItem(namecache)) ? localStorage.getItem(namecache) : {});

            let setAllCities = function (cities) {
                localStorage.setItem(namecache, JSON.stringify(cities));
            };

            let getAllCity = (function (){
                try {
                    let cities = JSON.parse(localStorage.getItem(namecache));
                    return cities;
                } catch (e) {
                    return {};
                }
            });
            let addCity = (function (state, city){
                let cities = getAllCity();
                cities[state] = city;
                setAllCities(cities);
                return true;
            });
            let getCity = (function (state){
                let cities = getAllCity();
                if(cities && typeof cities[state] != 'undefined' && !$.isEmptyObject( cities[state] ) && cities[state] ){
                    return cities[state];
                }
                return false;
            });

            //Ward
            let nameWardcache = 'ward_' + vncheckout_array.vnaddress_db_version;
            localStorage.setItem(nameWardcache, (localStorage.getItem(nameWardcache)) ? localStorage.getItem(nameWardcache) : {});

            let setAllWard = function (wards) {
                localStorage.setItem(nameWardcache, JSON.stringify(wards));
            };

            let getAllWard = (function (){
                try {
                    let wards = JSON.parse(localStorage.getItem(nameWardcache));
                    return wards;
                } catch (e) {
                    return {};
                }
            });
            let addWard = (function (city, ward){
                let wards = getAllWard();
                wards[city] = ward;
                setAllWard(wards);
                return true;
            });
            let getWard = (function (city){
                let wards = getAllWard();
                if(wards && typeof wards[city] != 'undefined' && !$.isEmptyObject( wards[city] ) && wards[city] ){
                    return wards[city];
                }
                return false;
            });

            returnOb.getAllCity = getAllCity;
            returnOb.addCity = addCity;
            returnOb.getCity = getCity;

            returnOb.getAllWard = getAllWard;
            returnOb.addWard = addWard;
            returnOb.getWard = getWard;

            return returnOb;
        }());

        let xhr_compare = null;
        let billing_city_xhr_compare = null;
        let shipping_xhr_compare = null;
        let shipping_city_xhr_compare = null;

        $( document.body ).on( 'country_to_state_changing', function(btn, country, $wrapper) {
            $wrapper.find( '#billing_state, #shipping_state, #calc_shipping_state, #billing_city, #shipping_city, #calc_shipping_city' ).trigger( 'change' );
        });

        $( document.body ).on( 'state_to_city_changed', function(btn, country, value, $wrapper) {
            $wrapper.find( '#billing_city' ).trigger( 'change' );
        });

        $( document.body ).on( 'state_to_city_shipping_changed', function(btn, country, value, $wrapper) {
            $wrapper.find( '#shipping_city' ).trigger( 'change' );
        });

        $( document.body ).on( 'change refresh', '#billing_state, #calc_shipping_state', function() {

            let wrapper_selectors = '.woocommerce-billing-fields,' +
                '.woocommerce-shipping-fields,' +
                '.woocommerce-address-fields,' +
                '.woocommerce-shipping-calculator';

            let $wrapper = $( this ).closest( wrapper_selectors );

            if ( ! $wrapper.length ) {
                $wrapper = $( this ).closest('.form-row').parent();
            }

            let country     = $wrapper.find('.country_to_state').val(),
                $statebox     = $wrapper.find( '#billing_state, #calc_shipping_state' ),
                statevalue    = $statebox.val(),
                $citybox      = $wrapper.find( '#billing_city, #calc_shipping_city' ),
                $parent       = $citybox.closest( '.form-row' ),
                input_name    = $citybox.attr( 'name' ),
                input_id      = $citybox.attr('id'),
                value         = $citybox.val(),
                datavalue     = $citybox.attr('data-value'),
                placeholder   = $citybox.attr( 'placeholder' ) || $citybox.attr( 'data-placeholder' ) || '',
                $newscity;

            if(!value) value = datavalue;

            if ( country == 'VN') {

                let $defaultOption = $( '<option value=""></option>' ).text( vncheckout_array.placeholder_city_text );

                if ( ! placeholder ) {
                    placeholder = vncheckout_array.placeholder_city_text;
                }

                if ( $citybox.is( 'input' ) ) {
                    $newscity = $( '<select></select>' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .data( 'placeholder', placeholder )
                        .addClass( 'state_select' );
                    $citybox.replaceWith( $newscity );
                    $citybox = $wrapper.find( '#billing_city, #calc_shipping_city' );
                }

                $citybox.attr( 'data-value', value );

                $citybox.empty().append( $defaultOption );

                city_args = VNAddress.getCity(statevalue);

                if(city_args){
                    $.each( city_args, function( index,value ) {
                        let $option = $( '<option></option>' )
                            .prop( 'value', value.maqh )
                            .text( value.name );
                        $citybox.append( $option );
                    } );

                    $citybox.val( value ).trigger( 'change' );

                }else if(statevalue){
                    if(xhr_compare) {
                        xhr_compare.abort();
                    }
                    xhr_compare = $.ajax({
                        type : "post",
                        dataType : "json",
                        url : vncheckout_array.get_address,
                        data : {action: "load_diagioihanhchinh", matp : statevalue},
                        context: this,
                        beforeSend: function(){
                            $parent.addClass('devvn_loading');
                        },
                        success: function(response) {
                            if(response.success) {
                                let listQH = response.data;
                                VNAddress.addCity(statevalue, listQH);
                                $.each( listQH, function( index,value ) {
                                    let $option = $( '<option></option>' )
                                        .prop( 'value', value.maqh )
                                        .text( value.name );
                                    $citybox.append( $option );
                                } );
                                $citybox.val( value ).trigger( 'change' );
                            }
                            $parent.removeClass('devvn_loading');
                            xhr_compare = null;
                        },
                        error: function( jqXHR, textStatus, errorThrown ){
                            xhr_compare = null;
                            $parent.removeClass('devvn_loading');
                        }
                    });
                }else{
                    xhr_compare = null;
                }

                $( document.body ).trigger( 'state_to_city_changed', [country, value, $wrapper ] );

            } else {
                if ( $citybox.is( 'select, input[type="hidden"]' ) ) {
                    $newscity = $( '<input type="text" />' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .prop('placeholder', placeholder)
                        .prop('value', value)
                        .addClass( 'input-text' );
                    $parent.show().find( '.select2-container' ).remove();
                    $newscity.val( value );
                    $citybox.replaceWith( $newscity );

                    $( document.body ).trigger( 'state_to_city_changed', [country, value, $wrapper ] );
                }
            }

            $( document.body ).trigger( 'state_to_city_changing', [country, value, $wrapper ] );

        });

        $( document.body ).on( 'change refresh', '#shipping_state', function() {

            let wrapper_selectors = '.woocommerce-billing-fields,' +
                '.woocommerce-shipping-fields,' +
                '.woocommerce-address-fields,' +
                '.woocommerce-shipping-calculator';

            let $wrapper = $( this ).closest( wrapper_selectors );

            if ( ! $wrapper.length ) {
                $wrapper = $( this ).closest('.form-row').parent();
            }

            let country     = $wrapper.find('.country_to_state').val(),
                $statebox     = $wrapper.find( '#shipping_state' ),
                statevalue    = $statebox.val(),
                $citybox      = $wrapper.find( '#shipping_city' ),
                $parent       = $citybox.closest( '.form-row' ),
                input_name    = $citybox.attr( 'name' ),
                input_id      = $citybox.attr('id'),
                value         = $citybox.val(),
                datavalue     = $citybox.attr('data-value'),
                placeholder   = $citybox.attr( 'placeholder' ) || $citybox.attr( 'data-placeholder' ) || '',
                $newscity;

            if(!value) value = datavalue;

            if ( country == 'VN') {

                let $defaultOption = $( '<option value=""></option>' ).text( vncheckout_array.placeholder_city_text );

                if ( ! placeholder ) {
                    placeholder = vncheckout_array.placeholder_city_text;
                }

                if ( $citybox.is( 'input' ) ) {
                    $newscity = $( '<select></select>' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .data( 'placeholder', placeholder )
                        .addClass( 'state_select' );
                    $citybox.replaceWith( $newscity );
                    $citybox = $wrapper.find( '#shipping_city' );
                }

                $citybox.attr( 'data-value', value );

                $citybox.empty().append( $defaultOption );

                city_args = VNAddress.getCity(statevalue);

                if(city_args){
                    $.each( city_args, function( index,value ) {
                        let $option = $( '<option></option>' )
                            .prop( 'value', value.maqh )
                            .text( value.name );
                        $citybox.append( $option );
                    } );

                    $citybox.val( value ).trigger( 'change' );

                }else if(statevalue){
                    if(shipping_xhr_compare) {
                        shipping_xhr_compare.abort();
                    }
                    shipping_xhr_compare = $.ajax({
                        type : "post",
                        dataType : "json",
                        url : vncheckout_array.get_address,
                        data : {action: "load_diagioihanhchinh", matp : statevalue},
                        context: this,
                        beforeSend: function(){
                            $parent.addClass('devvn_loading');
                        },
                        success: function(response) {
                            if(response.success) {
                                let listQH = response.data;
                                VNAddress.addCity(statevalue, listQH);
                                $.each( listQH, function( index,value ) {
                                    let $option = $( '<option></option>' )
                                        .prop( 'value', value.maqh )
                                        .text( value.name );
                                    $citybox.append( $option );
                                } );
                                $citybox.val( value ).trigger( 'change' );
                            }
                            $parent.removeClass('devvn_loading');
                            shipping_xhr_compare = null;
                        },
                        error: function( jqXHR, textStatus, errorThrown ){
                            shipping_xhr_compare = null;
                            $parent.removeClass('devvn_loading');
                        }
                    });
                }else{
                    shipping_xhr_compare = null;
                }

                $( document.body ).trigger( 'state_to_city_shipping_changed', [country, value, $wrapper ] );

            } else {
                if ( $citybox.is( 'select, input[type="hidden"]' ) ) {
                    $newscity = $( '<input type="text" />' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .prop('placeholder', placeholder)
                        .prop('value', value)
                        .addClass( 'input-text' );
                    $parent.show().find( '.select2-container' ).remove();
                    $newscity.val( value );
                    $citybox.replaceWith( $newscity );

                    $( document.body ).trigger( 'state_to_city_shipping_changed', [country, value, $wrapper ] );
                }
            }

            $( document.body ).trigger( 'state_to_city_shipping_changing', [country, value, $wrapper ] );

        });

        $( document.body ).on( 'change refresh', '#billing_city', function() {

            let wrapper_selectors = '.woocommerce-billing-fields,' +
                '.woocommerce-shipping-fields,' +
                '.woocommerce-address-fields,' +
                '.woocommerce-shipping-calculator';

            let $wrapper = $( this ).closest( wrapper_selectors );

            if ( ! $wrapper.length ) {
                $wrapper = $( this ).closest('.form-row').parent();
            }

            let country     = $wrapper.find('.country_to_state').val(),
                $citybox     = $wrapper.find( '#billing_city' ),
                cityvalue    = $citybox.val(),
                $wardbox      = $wrapper.find( '#billing_address_2' ),
                $parent       = $wardbox.closest( '.form-row' ),
                input_name    = $wardbox.attr( 'name' ),
                input_id      = $wardbox.attr('id'),
                value         = $wardbox.val(),
                datavalue     = $wardbox.attr('data-value'),
                placeholder   = $wardbox.attr( 'placeholder' ) || $wardbox.attr( 'data-placeholder' ) || '',
                $newsward;

            if(!value) value = datavalue;

            if ( country == 'VN') {

                let $defaultOption = $( '<option value=""></option>' ).text( vncheckout_array.placeholder_ward_text );

                if ( ! placeholder ) {
                    placeholder = vncheckout_array.placeholder_ward_text;
                }

                if ( $wardbox.is( 'input' ) ) {
                    $newsward = $( '<select></select>' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .data( 'placeholder', placeholder )
                        .addClass( 'state_select' );
                    $wardbox.replaceWith( $newsward );
                    $wardbox = $wrapper.find( '#billing_address_2' );
                }
                $wardbox.attr( 'data-value', value );

                $wardbox.empty().append( $defaultOption );

                ward_args = VNAddress.getWard(cityvalue);

                if(ward_args){
                    $.each( ward_args, function( index,value ) {
                        let $option = $( '<option></option>' )
                            .prop( 'value', value.xaid )
                            .text( value.name );
                        $wardbox.append( $option );
                    } );

                    $wardbox.val( value ).trigger( 'change' );

                }else if(cityvalue){
                    if(billing_city_xhr_compare) {
                        billing_city_xhr_compare.abort();
                    }

                    billing_city_xhr_compare = $.ajax({
                        type : "post",
                        dataType : "json",
                        url : vncheckout_array.get_address,
                        data : {action: "load_diagioihanhchinh", maqh: cityvalue},
                        context: this,
                        beforeSend: function(){
                            $parent.addClass('devvn_loading');
                        },
                        success: function(response) {
                            if(response.success) {
                                let listWard = response.data;
                                VNAddress.addWard(cityvalue, listWard);
                                $.each( listWard, function( index,value ) {
                                    let $option = $( '<option></option>' )
                                        .prop( 'value', value.xaid )
                                        .text( value.name );
                                    $wardbox.append( $option );
                                } );
                                $wardbox.val( value ).trigger( 'change' );
                            }
                            $parent.removeClass('devvn_loading');
                            billing_city_xhr_compare = null;
                        },
                        error: function( jqXHR, textStatus, errorThrown ){
                            billing_city_xhr_compare = null;
                            $parent.removeClass('devvn_loading');
                        }
                    });
                }else{
                    billing_city_xhr_compare = null;
                }

                $( document.body ).trigger( 'city_to_ward_changed', [country, cityvalue, value, $wrapper ] );

            } else {
                if ( $wardbox.is( 'select, input[type="hidden"]' ) ) {
                    $newsward = $( '<input type="text" />' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .prop('placeholder', placeholder)
                        .prop('value', value)
                        .addClass( 'input-text' );
                    $parent.show().find( '.select2-container' ).remove();
                    $newsward.val( value );
                    $wardbox.replaceWith( $newsward );

                    $( document.body ).trigger( 'city_to_ward_changed', [country, cityvalue, value, $wrapper ] );
                }
            }

            $( document.body ).trigger( 'city_to_ward_changing', [country, cityvalue, value, $wrapper ] );

        });

        $( document.body ).on( 'change refresh', '#shipping_city', function() {

            let wrapper_selectors = '.woocommerce-billing-fields,' +
                '.woocommerce-shipping-fields,' +
                '.woocommerce-address-fields,' +
                '.woocommerce-shipping-calculator';

            let $wrapper = $( this ).closest( wrapper_selectors );

            if ( ! $wrapper.length ) {
                $wrapper = $( this ).closest('.form-row').parent();
            }

            let country     = $wrapper.find('.country_to_state').val(),
                $citybox     = $wrapper.find( '#shipping_city' ),
                cityvalue    = $citybox.val(),
                $wardbox      = $wrapper.find( '#shipping_address_2' ),
                $parent       = $wardbox.closest( '.form-row' ),
                input_name    = $wardbox.attr( 'name' ),
                input_id      = $wardbox.attr('id'),
                value         = $wardbox.val(),
                datavalue     = $wardbox.attr('data-value'),
                placeholder   = $wardbox.attr( 'placeholder' ) || $wardbox.attr( 'data-placeholder' ) || '',
                $newsward;

            if(!value) value = datavalue;

            if ( country == 'VN') {

                let $defaultOption = $( '<option value=""></option>' ).text( vncheckout_array.placeholder_ward_text );

                if ( ! placeholder ) {
                    placeholder = vncheckout_array.placeholder_ward_text;
                }

                if ( $wardbox.is( 'input' ) ) {
                    $newsward = $( '<select></select>' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .data( 'placeholder', placeholder )
                        .addClass( 'state_select' );
                    $wardbox.replaceWith( $newsward );
                    $wardbox = $wrapper.find( '#shipping_address_2' );
                }
                $wardbox.attr( 'data-value', value );

                $wardbox.empty().append( $defaultOption );

                ward_args = VNAddress.getWard(cityvalue);

                if(ward_args){
                    $.each( ward_args, function( index,value ) {
                        let $option = $( '<option></option>' )
                            .prop( 'value', value.xaid )
                            .text( value.name );
                        $wardbox.append( $option );
                    } );

                    $wardbox.val( value ).trigger( 'change' );

                }else if(cityvalue){
                    if(shipping_city_xhr_compare) {
                        shipping_city_xhr_compare.abort();
                    }

                    shipping_city_xhr_compare = $.ajax({
                        type : "post",
                        dataType : "json",
                        url : vncheckout_array.get_address,
                        data : {action: "load_diagioihanhchinh", maqh: cityvalue},
                        context: this,
                        beforeSend: function(){
                            $parent.addClass('devvn_loading');
                        },
                        success: function(response) {
                            if(response.success) {
                                let listWard = response.data;
                                VNAddress.addWard(cityvalue, listWard);
                                $.each( listWard, function( index,value ) {
                                    let $option = $( '<option></option>' )
                                        .prop( 'value', value.xaid )
                                        .text( value.name );
                                    $wardbox.append( $option );
                                } );
                                $wardbox.val( value ).trigger( 'change' );
                            }
                            $parent.removeClass('devvn_loading');
                            shipping_city_xhr_compare = null;
                        },
                        error: function( jqXHR, textStatus, errorThrown ){
                            shipping_city_xhr_compare = null;
                            $parent.removeClass('devvn_loading');
                        }
                    });
                }else{
                    shipping_city_xhr_compare = null;
                }

                $( document.body ).trigger( 'city_to_ward_shipping_changed', [country, cityvalue, value, $wrapper ] );

            } else {
                if ( $wardbox.is( 'select, input[type="hidden"]' ) ) {
                    $newsward = $( '<input type="text" />' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .prop('placeholder', placeholder)
                        .prop('value', value)
                        .addClass( 'input-text' );
                    $parent.show().find( '.select2-container' ).remove();
                    $newsward.val( value );
                    $wardbox.replaceWith( $newsward );

                    $( document.body ).trigger( 'city_to_ward_shipping_changed', [country, cityvalue, value, $wrapper ] );
                }
            }

            $( document.body ).trigger( 'city_to_ward_shipping_changing', [country, cityvalue, value, $wrapper ] );

        });

        $('#devvn_ghtk_tracking').on('submit', function () {
            var formData = $(this).serialize();
            var thisWrap = $(this).closest('.devvn_ghtk_tracking_form');
            $.ajax({
                type : "post",
                dataType : "json",
                url : vncheckout_array.admin_ajax,
                data : {action: "ghtk_tracking", data: formData},
                context: this,
                beforeSend: function(){
                    thisWrap.addClass('devvn_loading');
                },
                success: function(response) {
                    var data = response.data;
                    if(data) {
                        $.each(data.fragments, function (key, value) {
                            $(key, thisWrap).html(value);
                        });
                    }
                    thisWrap.removeClass('devvn_loading');
                },
                error: function( jqXHR, textStatus, errorThrown ){
                    thisWrap.removeClass('devvn_loading');
                }
            });
            return false;
        });

        //
        $('body').on( 'change', 'input[name=payment_method]', function() {
            if(vncheckout_array.enabled_free_shipping) {
                $('form.checkout').trigger("update_checkout");
            }
        });

        if(typeof magnificPopup != undefined && $('.get_address_byphone').length > 0) {
            $('.get_address_byphone').magnificPopup({
                type: 'inline',
                midClick: true,
                showCloseBtn: false
            });

            var loading_get_address = false;
            $('body').on('click', '.btn_get_address', function () {
                if (loading_get_address) return false;
                var oldThis = $(this);
                var thisParent = $(this).closest('#get_address_content');
                var phone = $('#sdt_get_address', thisParent).val();
                var mess = $('.get_address_content_mess', thisParent);
                var g_recaptcha = '';

                if (!phone || !/^0+(\d{9,10})$/.test(phone)) {
                    mess.html(vncheckout_array.phone_error);
                    return false;
                } else {
                    mess.html('');
                    if ($('#g-recaptcha-response', thisParent).length > 0) {
                        g_recaptcha = $('#g-recaptcha-response', thisParent).val();
                        if (!g_recaptcha) {
                            mess.html('Vui lòng nhập mã xác thực.');
                            return false;
                        }
                    }
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        url: vncheckout_array.admin_ajax,
                        data: {action: "get_address_byphone", phone: phone, 'g-recaptcha-response': g_recaptcha},
                        context: this,
                        beforeSend: function () {
                            mess.html(vncheckout_array.loading_text);
                            oldThis.addClass('devvn_loading');
                            loading_get_address = true;
                        },
                        success: function (response) {
                            if (response.success) {
                                $.each(response.data.billing, function (index, thisVal) {
                                    if ($('#' + index).is("select")) {
                                        $('#' + index).val(thisVal).attr('data-value', thisVal);
                                    } else {
                                        $('#' + index).val(thisVal).attr('value', thisVal);
                                    }
                                });
                                $.each(response.data.shipping, function (index, thisVal) {
                                    if ($('#' + index).is("select")) {
                                        $('#' + index).val(thisVal).attr('data-value', thisVal);
                                    } else {
                                        $('#' + index).val(thisVal).attr('value', thisVal);
                                    }
                                });
                                mess.html('');
                                $( '#billing_state, #shipping_state, #billing_city, #shipping_city' ).trigger( 'change' );
                                $.magnificPopup.close();
                            } else {
                                mess.html(vncheckout_array.loadaddress_error);
                            }
                            oldThis.removeClass('devvn_loading');
                            loading_get_address = false;
                        },
                        error: function( jqXHR, textStatus, errorThrown ){
                            oldThis.removeClass('devvn_loading');
                            alert(textStatus);
                        }
                    });
                }
                return false;
            });
            $('body').on('click', '.btn_cancel', function () {
                var thisParent = $(this).closest('#get_address_content');
                var mess = $('.get_address_content_mess', thisParent);
                thisParent.removeClass('get_address_error');
                $.magnificPopup.close();
                loading_get_address = false;
                mess.html('');
                if ($('#billing_first_name').length > 0) {
                    $('#billing_first_name').focus();
                } else {
                    $('#billing_last_name').focus();
                }
                return false;
            });
        }

        $('body').on( 'change', 'input[name=payment_method]', function() {
            if(vncheckout_array.has_vtp) {
                $('form.checkout').trigger("update_checkout");
            }
        });

    });
})(jQuery);