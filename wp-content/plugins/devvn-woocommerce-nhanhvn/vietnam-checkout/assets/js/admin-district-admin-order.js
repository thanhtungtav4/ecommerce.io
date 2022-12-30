/*global wc_users_params */
jQuery( function ( $ ) {

    let city_args = {},
        ward_args = {};

    let VNAddress = (function (){
        let returnOb = {};

        //City
        let namecache = 'cities_' + admin_vncheckout_array.vnaddress_db_version;
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
            if(cities && !$.isEmptyObject( cities[state] ) && cities[state]){
                return cities[state];
            }
            return false;
        });

        //Ward
        let nameWardcache = 'ward_' + admin_vncheckout_array.vnaddress_db_version;
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
            if(wards && !$.isEmptyObject( wards[city] ) && wards[city] ){
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
    let shipping_state_xhr_compare = null;
    let city_xhr_compare = null;
    let shipping_city_xhr_compare = null;

    var wc_users_fields = {

        init: function() {
            $( '.js_field-country' ).on( 'change', function() {
                let wrapper_selectors = '.fieldset-billing,' +
                    '.fieldset-billing,' +
                    '.edit_address';

                let $wrapper = $( this ).closest( wrapper_selectors );

                if ( ! $wrapper.length ) {
                    $wrapper = $( this ).closest('.form-table');
                }
                $wrapper.find( '.js_field-state, .js_field-city, [name="woocommerce_default_country"]' ).trigger( 'change' );
            });

            $( 'a.edit_address' ).on( 'click', function (){
                let wrapper_selectors = '.order_data_column';

                let $wrapper = $( this ).closest( wrapper_selectors );

                if ( ! $wrapper.length ) {
                    $wrapper = $( this ).closest('.form-table');
                }
                $wrapper.find( '.js_field-state, .js_field-city, [name="woocommerce_default_country"]' ).trigger( 'change' );
            } );

            $( document.body ).on( 'change refresh', '#billing_state, #_billing_state, [name="woocommerce_default_country"]', this.change_state_billing );
            $( document.body ).on( 'change refresh', '#shipping_state, #_shipping_state', this.change_state_shipping );

            $( document.body ).on( 'change refresh', '#billing_city, #_billing_city, #woocommerce_store_city', this.change_city_billing );
            $( document.body ).on( 'change refresh', '#shipping_city, #_shipping_city', this.change_city_shipping );

            $( document.body ).on( 'state_to_city_changed', function(btn, country, value, $wrapper) {
                $wrapper.find( '.js_field-city' ).trigger( 'change' );
            });

            if($('#woocommerce_store_city').length > 0){
                $('[name="woocommerce_default_country"]').trigger( 'change' );
            }

        },

        change_state_billing: function() {

            let wrapper_selectors = '.fieldset-billing,' +
                '.fieldset-shipping,' +
                '.edit_address';

            let $wrapper = $( this ).closest( wrapper_selectors );

            if ( ! $wrapper.length ) {
                $wrapper = $( this ).closest('.form-table');
            }

            var $this = $( this ),
                statevalue    = $this.val(),
                $citybox      = $wrapper.find( '#billing_city, #_billing_city, #woocommerce_store_city' ),
                $parent       = $citybox.closest( 'tr, .form-field' ),
                $country      = $this.parents( '.form-table, .edit_address' ).find( ':input.js_field-country' ),
                country       = $country.val(),
                input_name    = $citybox.attr( 'name' ),
                input_id      = $citybox.attr('id'),
                value         = $citybox.val(),
                datavalue     = $citybox.attr('data-value'),
                placeholder   = $citybox.attr( 'placeholder' ) || $citybox.attr( 'data-placeholder' ) || '',
                $newscity;

            if(!value) value = datavalue;

            if(typeof country == 'undefined' && ($('#woocommerce_store_city').length > 0) ){
                if(statevalue) {
                    statevalue = statevalue.split(':');
                    country = statevalue[0];
                    statevalue = statevalue[1];
                }
            }

            if ( country == 'VN') {

                let $defaultOption = $( '<option value=""></option>' ).text( admin_vncheckout_array.placeholder_city_text );

                if ( ! placeholder ) {
                    placeholder = admin_vncheckout_array.placeholder_city_text;
                }

                if ( $citybox.is( 'input' ) ) {
                    $newscity = $( '<select style="width: 25em;"></select>' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .data( 'placeholder', placeholder )
                        .addClass( 'js_field-city' );
                    $citybox.replaceWith( $newscity );
                    $citybox = $wrapper.find( '#billing_city, #_billing_city, #woocommerce_store_city' );
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
                    $citybox.val( value );
                    $citybox.show().selectWoo().hide().trigger( 'change' );
                    $( document.body ).trigger( 'state_to_city_changed', [country, value, $wrapper ] );
                }else if(statevalue){
                    if(xhr_compare) {
                        xhr_compare.abort();
                    }
                    xhr_compare = $.ajax({
                        type : "post",
                        dataType : "json",
                        url : admin_vncheckout_array.get_address,
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
                                $citybox.val( value );
                            }
                            $parent.removeClass('devvn_loading');
                            xhr_compare = null;
                            $citybox.show().selectWoo().hide().trigger( 'change' );
                            $( document.body ).trigger( 'state_to_city_changed', [country, value, $wrapper ] );
                        },
                        error: function( jqXHR, textStatus, errorThrown ){
                            xhr_compare = null;
                            $parent.removeClass('devvn_loading');
                        }
                    });
                }else{
                    xhr_compare = null;
                }

            } else {
                if ( $citybox.is( 'select, input[type="hidden"]' ) ) {
                    $newscity = $( '<input type="text" />' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .prop('placeholder', placeholder)
                        .addClass( 'regular-text js_field-city');
                    $newscity.val(value).attr('value', value);
                    $parent.show().find( '.select2-container' ).remove();
                    $citybox.replaceWith( $newscity );

                    $citybox.show().trigger( 'change' );

                    $( document.body ).trigger( 'state_to_city_changed', [country, value, $wrapper ] );
                }
            }
        },

        change_state_shipping: function() {

            let wrapper_selectors = '.fieldset-billing,' +
                '.fieldset-shipping,' +
                '.edit_address';

            let $wrapper = $( this ).closest( wrapper_selectors );

            if ( ! $wrapper.length ) {
                $wrapper = $( this ).closest('.form-table');
            }

            var $this = $( this ),
                statevalue    = $this.val(),
                $citybox      = $wrapper.find( '#shipping_city, #_shipping_city' ),
                $parent       = $citybox.closest( 'tr, .form-field' ),
                $country      = $this.parents( '.form-table, .edit_address' ).find( ':input.js_field-country' ),
                country       = $country.val(),
                input_name    = $citybox.attr( 'name' ),
                input_id      = $citybox.attr('id'),
                value         = $citybox.val(),
                datavalue     = $citybox.attr('data-value'),
                placeholder   = $citybox.attr( 'placeholder' ) || $citybox.attr( 'data-placeholder' ) || '',
                $newscity;

            if(!value) value = datavalue;

            if(typeof country == 'undefined' && ($('#woocommerce_store_city').length > 0) ){
                if(statevalue) {
                    statevalue = statevalue.split(':');
                    country = statevalue[0];
                    statevalue = statevalue[1];
                }
            }

            if ( country == 'VN') {

                let $defaultOption = $( '<option value=""></option>' ).text( admin_vncheckout_array.placeholder_city_text );

                if ( ! placeholder ) {
                    placeholder = admin_vncheckout_array.placeholder_city_text;
                }

                if ( $citybox.is( 'input' ) ) {
                    $newscity = $( '<select style="width: 25em;"></select>' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .data( 'placeholder', placeholder )
                        .addClass( 'js_field-city' );
                    $citybox.replaceWith( $newscity );
                    $citybox = $wrapper.find( '#shipping_city, #_shipping_city' );
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
                    $citybox.val( value );
                    $citybox.show().selectWoo().hide().trigger( 'change' );
                    $( document.body ).trigger( 'state_to_city_shipping_changed', [country, value, $wrapper ] );
                }else if(statevalue){
                    if(shipping_state_xhr_compare) {
                        shipping_state_xhr_compare.abort();
                    }
                    shipping_state_xhr_compare = $.ajax({
                        type : "post",
                        dataType : "json",
                        url : admin_vncheckout_array.get_address,
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
                                $citybox.val( value );
                            }
                            $parent.removeClass('devvn_loading');
                            shipping_state_xhr_compare = null;
                            $citybox.show().selectWoo().hide().trigger( 'change' );
                            $( document.body ).trigger( 'state_to_city_shipping_changed', [country, value, $wrapper ] );
                        },
                        error: function( jqXHR, textStatus, errorThrown ){
                            shipping_state_xhr_compare = null;
                            $parent.removeClass('devvn_loading');
                        }
                    });
                }else{
                    shipping_state_xhr_compare = null;
                }

            } else {
                if ( $citybox.is( 'select, input[type="hidden"]' ) ) {
                    $newscity = $( '<input type="text" />' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .prop('placeholder', placeholder)
                        .addClass( 'regular-text js_field-city');
                    $newscity.val(value).attr('value', value);
                    $parent.show().find( '.select2-container' ).remove();
                    $citybox.replaceWith( $newscity );

                    $citybox.show().trigger( 'change' );

                    $( document.body ).trigger( 'state_to_city_shipping_changed', [country, value, $wrapper ] );
                }
            }
        },

        change_city_billing: function() {

            let wrapper_selectors = '.fieldset-billing,' +
                '.fieldset-shipping,' +
                '.edit_address';

            let $wrapper = $( this ).closest( wrapper_selectors );

            if ( ! $wrapper.length ) {
                $wrapper = $( this ).closest('.form-table');
            }

            var $this = $( this ),
                cityvalue    = $this.val(),
                $wardbox      = $wrapper.find( '#billing_address_2, #_billing_address_2, #woocommerce_store_address_2' ),
                $parent       = $wardbox.closest( 'tr, .form-field' ),
                $country      = $this.parents( '.form-table, .edit_address' ).find( ':input.js_field-country' ),
                country       = $country.val(),
                input_name    = $wardbox.attr( 'name' ),
                input_id      = $wardbox.attr('id'),
                value         = $wardbox.val(),
                datavalue     = $wardbox.attr('data-value'),
                placeholder   = $wardbox.attr( 'placeholder' ) || $wardbox.attr( 'data-placeholder' ) || '',
                $newscity;

            if(!value) value = datavalue;

            if(typeof country == 'undefined'){
                $country      = $this.parents( '.form-table' ).find( '[name="woocommerce_default_country"]');
                country       = $country.val();
                if(country) {
                    country = country.split(':');
                    country = country[0];
                }
            }

            if ( country == 'VN') {

                let $defaultOption = $( '<option value=""></option>' ).text( admin_vncheckout_array.placeholder_ward_text );

                if ( ! placeholder ) {
                    placeholder = admin_vncheckout_array.placeholder_ward_text;
                }

                if ( $wardbox.is( 'input' ) ) {
                    $newscity = $( '<select style="width: 25em;"></select>' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .data( 'placeholder', placeholder )
                    $wardbox.replaceWith( $newscity );
                    $wardbox = $wrapper.find( '#billing_address_2, #_billing_address_2, #woocommerce_store_address_2' );
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
                    $wardbox.show().selectWoo().hide().trigger( 'change' );
                    $( document.body ).trigger( 'city_to_ward_changed', [country, value, $wrapper ] );
                }else if(cityvalue){
                    if(city_xhr_compare) {
                        city_xhr_compare.abort();
                    }
                    city_xhr_compare = $.ajax({
                        type : "post",
                        dataType : "json",
                        url : admin_vncheckout_array.get_address,
                        data : {action: "load_diagioihanhchinh", maqh : cityvalue},
                        context: this,
                        beforeSend: function(){
                            $parent.addClass('devvn_loading');
                        },
                        success: function(response) {
                            if(response.success) {
                                let listQH = response.data;
                                VNAddress.addWard(cityvalue, listQH);
                                $.each( listQH, function( index,value ) {
                                    let $option = $( '<option></option>' )
                                        .prop( 'value', value.xaid )
                                        .text( value.name );
                                    $wardbox.append( $option );
                                } );
                                $wardbox.val( value ).trigger( 'change' );
                            }
                            $parent.removeClass('devvn_loading');

                            city_xhr_compare = null;

                            $wardbox.show().selectWoo().hide().trigger( 'change' );
                            $( document.body ).trigger( 'city_to_ward_changed', [country, value, $wrapper ] );
                        },
                        error: function( jqXHR, textStatus, errorThrown ){
                            city_xhr_compare = null;
                            $parent.removeClass('devvn_loading');
                        }
                    });
                }else{
                    city_xhr_compare = null;
                }


            } else {
                if ( $wardbox.is( 'select, input[type="hidden"]' ) ) {
                    $newscity = $( '<input type="text" />' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .prop('placeholder', placeholder)
                        .addClass( 'regular-text' );
                    $newscity.val(value).attr('value', value);
                    $parent.show().find( '.select2-container' ).remove();
                    $wardbox.replaceWith( $newscity );

                    $wardbox.show().trigger( 'change' );

                    $( document.body ).trigger( 'city_to_ward_changed', [country, value, $wrapper ] );
                }
            }
        },

        change_city_shipping: function() {

            let wrapper_selectors = '.fieldset-billing,' +
                '.fieldset-shipping,' +
                '.edit_address';

            let $wrapper = $( this ).closest( wrapper_selectors );

            if ( ! $wrapper.length ) {
                $wrapper = $( this ).closest('.form-table');
            }

            var $this = $( this ),
                cityvalue    = $this.val(),
                $wardbox      = $wrapper.find( '#shipping_address_2, #_shipping_address_2' ),
                $parent       = $wardbox.closest( 'tr, .form-field' ),
                $country      = $this.parents( '.form-table, .edit_address' ).find( ':input.js_field-country' ),
                country       = $country.val(),
                input_name    = $wardbox.attr( 'name' ),
                input_id      = $wardbox.attr('id'),
                value         = $wardbox.val(),
                datavalue     = $wardbox.attr('data-value'),
                placeholder   = $wardbox.attr( 'placeholder' ) || $wardbox.attr( 'data-placeholder' ) || '',
                $newscity;

            if(!value) value = datavalue;

            if(typeof country == 'undefined'){
                $country      = $this.parents( '.form-table' ).find( '[name="woocommerce_default_country"]');
                country       = $country.val();
                if(country) {
                    country = country.split(':');
                    country = country[0];
                }
            }

            if ( country == 'VN') {

                let $defaultOption = $( '<option value=""></option>' ).text( admin_vncheckout_array.placeholder_ward_text );

                if ( ! placeholder ) {
                    placeholder = admin_vncheckout_array.placeholder_ward_text;
                }

                if ( $wardbox.is( 'input' ) ) {
                    $newscity = $( '<select style="width: 25em;"></select>' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .data( 'placeholder', placeholder )
                    $wardbox.replaceWith( $newscity );
                    $wardbox = $wrapper.find( '#shipping_address_2, #_shipping_address_2, #woocommerce_store_address_2' );
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
                    $wardbox.show().selectWoo().hide().trigger( 'change' );
                    $( document.body ).trigger( 'city_to_ward_changed', [country, value, $wrapper ] );
                }else if(cityvalue){
                    if(shipping_city_xhr_compare) {
                        shipping_city_xhr_compare.abort();
                    }
                    shipping_city_xhr_compare = $.ajax({
                        type : "post",
                        dataType : "json",
                        url : admin_vncheckout_array.get_address,
                        data : {action: "load_diagioihanhchinh", maqh : cityvalue},
                        context: this,
                        beforeSend: function(){
                            $parent.addClass('devvn_loading');
                        },
                        success: function(response) {
                            if(response.success) {
                                let listQH = response.data;
                                VNAddress.addWard(cityvalue, listQH);
                                $.each( listQH, function( index,value ) {
                                    let $option = $( '<option></option>' )
                                        .prop( 'value', value.xaid )
                                        .text( value.name );
                                    $wardbox.append( $option );
                                } );
                                $wardbox.val( value ).trigger( 'change' );
                            }
                            $parent.removeClass('devvn_loading');

                            shipping_city_xhr_compare = null;

                            $wardbox.show().selectWoo().hide().trigger( 'change' );
                            $( document.body ).trigger( 'city_to_ward_changed', [country, value, $wrapper ] );
                        },
                        error: function( jqXHR, textStatus, errorThrown ){
                            shipping_city_xhr_compare = null;
                            $parent.removeClass('devvn_loading');
                        }
                    });
                }else{
                    shipping_city_xhr_compare = null;
                }


            } else {
                if ( $wardbox.is( 'select, input[type="hidden"]' ) ) {
                    $newscity = $( '<input type="text" />' )
                        .prop( 'id', input_id )
                        .prop( 'name', input_name )
                        .prop('placeholder', placeholder)
                        .addClass( 'regular-text' );
                    $newscity.val(value).attr('value', value);
                    $parent.show().find( '.select2-container' ).remove();
                    $wardbox.replaceWith( $newscity );

                    $wardbox.show().trigger( 'change' );

                    $( document.body ).trigger( 'city_to_ward_changed', [country, value, $wrapper ] );
                }
            }
        },

    };

    wc_users_fields.init();

    //vnAddress
    $(".button_create_tables").on('click', function(){
        let thisBtn = $(this);
        let thisNotice = $(this).closest('.notice');
        let security = $(this).data('nonce');
        let oldText = thisBtn.html();
        $.ajax({
            type : "post",
            dataType : "json",
            url : admin_vncheckout_array.ajaxurl,
            data : {
                action: "vnaddress_create_table",
                security : security,
            },
            context: this,
            beforeSend: function(){
                thisBtn.html('Đang cấu hình...');
            },
            success: function(response) {
                thisBtn.html('Đã xong');
                if(response.success) {
                    thisNotice.remove();
                    alert(response.data);
                }else {
                    alert(response.data);
                }
            },
            error: function( jqXHR, textStatus, errorThrown ){
                alert(textStatus);
            }
        })
        return false;
    });

    //
    var update_country = false;
    $('body').on('click', '.update_country', function (){
        if(update_country) return false;
        var thisParent = $(this).closest('td');
        var mess_sync = $('.ajax_mess', thisParent);
        var _nonce = $(this).data('nonce');
        $.ajax({
            type: "post",
            dataType: "json",
            url: admin_vncheckout_array.ajaxurl,
            data: {
                action: "ghtk_update_country",
                nonce: _nonce
            },
            context: this,
            beforeSend: function () {
                mess_sync.html('Đang chạy...');
                update_country = true;
            },
            success: function (response) {
                if (response.success) {
                    mess_sync.css("color", "green").html(response.data);
                } else {
                    mess_sync.css("color", "red").html(response.data);
                }
                update_country = false;
            },
            error: function (jqXHR, textStatus, errorThrown) {
                mess_sync.css("color", "red").html('Có lỗi xảy ra!');
                update_country = false;
            }
        });

        return false;
    });

    if($('#devvnbillingState').length > 0){
        $('#devvnbillingState').selectWoo();
        $('#devvnbillingCity').selectWoo();
        $( document.body ).on( 'change refresh', '#devvnbillingState', function(e){
            let $citybox = $('#devvnbillingCity');
            let $defaultOption = $( '<option value=""></option>' ).text( admin_vncheckout_array.placeholder_city_text );

            $citybox.empty().append( $defaultOption );
            let matp = e.val;
            if(!matp) matp = $( "#devvnbillingState option:selected" ).val();
            if(matp){

                city_args = VNAddress.getCity(matp);

                if(city_args){
                    $.each( city_args, function( index,value ) {
                        let $option = $( '<option></option>' )
                            .prop( 'value', value.maqh )
                            .text( value.name );
                        $citybox.append( $option );
                    } );
                }else if(matp) {
                    if(xhr_compare) {
                        xhr_compare.abort();
                    }
                    xhr_compare = $.ajax({
                        type : "post",
                        dataType : "json",
                        url : admin_vncheckout_array.get_address,
                        data : {action: "load_diagioihanhchinh", matp : matp},
                        context: this,
                        beforeSend: function(){
                        },
                        success: function(response) {
                            if(response.success) {
                                let listQH = response.data;
                                VNAddress.addCity(matp, listQH);
                                $.each( listQH, function( index,value ) {
                                    let $option = $( '<option></option>' )
                                        .prop( 'value', value.maqh )
                                        .text( value.name );
                                    $citybox.append( $option );
                                } );
                            }
                            xhr_compare = null;
                        },
                        error: function( jqXHR, textStatus, errorThrown ){
                            xhr_compare = null;
                        }
                    });
                }else{
                    xhr_compare = null;
                }
            }
        });
    }

});