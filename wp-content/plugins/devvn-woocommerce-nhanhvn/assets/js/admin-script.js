function selectOnlyThis(id){
    let myCheckbox = document.getElementsByClassName("pick_ismain_onlyone");
    Array.prototype.forEach.call(myCheckbox,function(el){
        el.checked = false;
    });
    id.checked = true;
}
(function ($){
    $(document).ready(function (){
        let update_hub_loading = false;
        $('.sync_depot').on('click', function () {
            if(!update_hub_loading) {
                let box_wrap = $(this).closest('.nhanh_wrap_inline');
                let nonce_update = $("#nhanhvn_update_nonce").val();
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: devvn_nhanhvn_admin.ajax_url,
                    data: {
                        action: "sync_depot",
                        nonce: nonce_update
                    },
                    context: this,
                    beforeSend: function () {
                        $('.spinner', box_wrap).addClass('is-active');
                        update_hub_loading = true;
                    },
                    success: function (response) {
                        //console.log(response);
                        if (response.success) {
                            alert(response.data);
                            location.reload();
                        } else {
                            alert(response.data);
                        }
                        $('.spinner', box_wrap).removeClass('is-active');
                        update_hub_loading = false;
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        $('.spinner', box_wrap).removeClass('is-active');
                        alert(textStatus);
                    }
                })
            }
            return false;
        });

        $('.devvn_checkbox_all').on('click', function () {
            let thisWrap = $(this).closest('table');
            if($('input[type="checkbox"]:checked', thisWrap).length > 0){
                $('input[type="checkbox"]', thisWrap).prop('checked', false);
            }else{
                $('input[type="checkbox"]', thisWrap).prop('checked', true);
            }
            return false;
        });

        $.fn.extend({
            vnformat: function ( type ) {
                var text
                if ( type == 'val' ){
                    text = $(this).val();
                } else {
                    text = $(this).text();
                }
                var text_create = '';
                text_create = text.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "a").replace(/đ|Đ/g, "d").replace(/ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ/g,"y").replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g,"u").replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g,"o").replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "e").replace(/ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ì|Ĩ/g,"i");
                return text_create;
            }
        });
        $.expr[':'].icontains = function(a, i, m) {
            return $(a).vnformat().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
        };
        $('.search_city').on('keyup', function() {
            var search_keyword = $(this).vnformat('val');
            var thisWrap = $(this).closest('.devvn_hubs_table');

            list = $(".nhanhvn_all_state_checkbox_item", thisWrap);
            list.hide();
            var containing_labels = $(".nhanhvn_all_state_checkbox_item label:icontains('" + search_keyword + "')", thisWrap);
            containing_labels.closest(".nhanhvn_all_state_checkbox_item").find(".nhanhvn_all_state_checkbox_item").andSelf().show();
        });

        $('.khuvuc_banhang').on('click', function(){
            let hubID = $(this).data('hubid');
            $.magnificPopup.open({
                items: {
                    src: '#hub_district_' + hubID,
                    type: 'inline'
                },
                showCloseBtn: false
            });
            return false;
        });
        $('.close_popup').on('click', function(){
            $.magnificPopup.close();
            return false;
        });

        //sync carrier
        $('.sync_carrier').on('click', function () {
            if(!update_hub_loading) {
                let box_wrap = $(this).closest('.nhanh_wrap_inline');
                let nonce_update = $("#nhanhvn_update_nonce").val();
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: devvn_nhanhvn_admin.ajax_url,
                    data: {
                        action: "sync_carrier",
                        nonce: nonce_update
                    },
                    context: this,
                    beforeSend: function () {
                        $('.spinner', box_wrap).addClass('is-active');
                        update_hub_loading = true;
                    },
                    success: function (response) {
                        //console.log(response);
                        if (response.success) {
                            alert(response.data);
                            location.reload();
                        } else {
                            alert(response.data);
                        }
                        $('.spinner', box_wrap).removeClass('is-active');
                        update_hub_loading = false;
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        $('.spinner', box_wrap).removeClass('is-active');
                        alert(textStatus);
                    }
                })
            }
            return false;
        });

        //đăng đơn
        $('body').on('click', '.devvn_nhanhvn_popup_button', function () {
            let thisorderID = $(this).data('orderid');
            let nonce = $('#nhanhvn_order_nonce').val();
            $.ajax({
                type : "post",
                dataType : "json",
                url : devvn_nhanhvn_admin.ajax_url,
                data : {
                    action: "nhanhvn_html_creat_order",
                    orderid : thisorderID,
                    nonce : nonce,
                },
                context: this,
                beforeSend: function(){
                    $(this).addClass('devvn_nhanhvn_loading');
                },
                success: function(response) {
                    $(this).removeClass('devvn_nhanhvn_loading');
                    if(response.success) {
                        let html = response.data.html;
                        $.magnificPopup.open({
                            items: {
                                src: html,
                                type: 'inline'
                            },
                            showCloseBtn: false,
                            mainClass: 'nhanhvn_popup_wrap'
                        });

                    }else {
                        alert("Error!");
                    }
                },
                error: function( jqXHR, textStatus, errorThrown ){
                    $(this).removeClass('devvn_nhanhvn_loading');
                    alert("Error!");
                }
            })
        });

        $('body').on('click', '.devvn_nhanhvn_popup_close', function () {
            $.magnificPopup.close();
            return false;
        });

        $('body').on('change', '[name="nhanhvn_depot"], [name="nhanhvn_weight"], [name="nhanhvn_codMoney"], .calc_fee', function (){
            let thisWrap = $(this).closest('#nhanh_create_order_form');
            calc_fee(thisWrap);
        });

        $('body').on('change', '[name="nhanhvn_serviceId"]', function (){
            let carrierid = $('[name="nhanhvn_serviceId"]:checked').data('carrierid');
            $('[name="nhanhvn_carrierId"]').val(carrierid).attr('value', carrierid);
        });

        function calc_fee(thisWrap){
            let thisorderID = $(this).data('orderid');
            let nonce = $('#nhanhvn_order_nonce').val();
            let data = $(thisWrap).serialize();
            $.ajax({
                type : "post",
                dataType : "json",
                url : devvn_nhanhvn_admin.ajax_url,
                data : {
                    action: "nhanhvn_calc_fee_order",
                    data : data,
                    nonce : nonce,
                },
                context: this,
                beforeSend: function(){
                    thisWrap.addClass('devvn_nhanhvn_loading');
                    $('.shipping_order_popup').html('');
                },
                success: function(response) {
                    thisWrap.removeClass('devvn_nhanhvn_loading');
                    if(response.success) {
                        let html = response.data;
                        $('.shipping_order_popup').html(html);

                    }else {
                        alert(response.data);
                    }
                },
                error: function( jqXHR, textStatus, errorThrown ){
                    thisWrap.removeClass('devvn_nhanhvn_loading');
                    alert("Error!");
                }
            })
        }

        $('body').on('click', '.nhanhvn_create_order', function () {
            let form = $(this).closest('#nhanh_create_order_form');
            let nonce = $('#nhanhvn_create_order_nonce', form).val();
            let nhanhvn_serviceId = $('[name="nhanhvn_serviceId"]:checked').val();
            let nhanhvn_carrierId = $('[name="nhanhvn_carrierId"]').val();

            if(!nhanhvn_serviceId || !nhanhvn_carrierId){
                alert('Chưa chọn dịch vụ giao hàng!');
                return false;
            }

            $.ajax({
                type : "post",
                dataType : "json",
                url : devvn_nhanhvn_admin.ajax_url,
                data : {
                    action: "nhanhvn_creat_order",
                    data : form.serialize(),
                    nonce : nonce,
                },
                context: this,
                beforeSend: function(){
                    form.addClass('devvn_nhanhvn_loading');
                },
                success: function(response) {
                    form.removeClass('devvn_nhanhvn_loading');
                    if(response.success) {
                        let fragments = response.data.fragments;
                        $.each( fragments, function( key, value ) {
                            $( key ).html( value );
                        });
                        $( document.body ).trigger( 'nhanhvn_after_create_order' );
                        $.magnificPopup.close();
                    }else {
                        alert(response.data);
                    }
                },
                error: function( jqXHR, textStatus, errorThrown ){
                    form.removeClass('devvn_nhanhvn_loading');
                    alert("Error!");
                }
            });
            return false;
        });

        $('body').on('click', '.nhanhvn_order_cancel', function () {
            let orderid = $(this).data('orderid');
            let status = $(this).data('status');
            let nonce = $('#nhanhvn_order_nonce').val();
            let thisBox = $(this).closest('.nhanhvn_order_info');
            let r = '';
            if(!status) {
                r = confirm("Bạn có chắc chắn muốn HUỶ đơn trên Nhanh.vn không?");
            }
            if (r == true || status) {
                $.ajax({
                    type : "post",
                    dataType : "json",
                    url : devvn_nhanhvn_admin.ajax_url,
                    data : {
                        action: "nhanhvn_order_cancel",
                        orderid : orderid,
                        status : status,
                        nonce : nonce,
                    },
                    context: this,
                    beforeSend: function(){
                        thisBox.addClass('devvn_nhanhvn_loading');
                    },
                    success: function(response) {
                        thisBox.removeClass('devvn_nhanhvn_loading');
                        if(response.success) {
                            let fragments = response.data.fragments;
                            $.each( fragments, function( key, value ) {
                                $( key ).html( value );
                            });
                            $( document.body ).trigger( 'nhanhvn_after_order_cancel' );
                        }else {
                            alert(response.data);
                        }
                    },
                    error: function( jqXHR, textStatus, errorThrown ){
                        thisBox.removeClass('devvn_nhanhvn_loading');
                        alert("Error!");
                    }
                });
            }
            return false;
        });

        function nhanhvn_randomText() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (var i = 0; i < 24; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            return text;
        }

        $('body').on('click', '.change_verify_token', function () {
            let hash = nhanhvn_randomText();
            $('#nhanhvn_verify_token').val(hash).attr('value', hash);
            return false;
        });

        let totalProds = 0;
        function sync_prod(thisBox, paged){
            let nonce = $('#nhanhvn_update_nonce').val();

            $.ajax({
                type : "post",
                dataType : "json",
                url : devvn_nhanhvn_admin.ajax_url,
                data : {
                    action: "get_nhanhvn_prod",
                    nonce: nonce,
                    page: paged
                },
                context: this,
                beforeSend: function(){
                    thisBox.addClass('devvn_nhanhvn_loading');
                },
                success: function(response) {
                    thisBox.removeClass('devvn_nhanhvn_loading');
                    if(response.success) {
                        let nextpage = parseInt(response.data.nextpage);
                        let totalPages = parseInt(response.data.totalPages);
                        let currentPage = parseInt(response.data.currentPage);
                        totalProds += parseInt(response.data.totalProds);
                        let logs_text = 'Đã lấy được '+totalProds+' sản phẩm. ('+currentPage+'/'+totalPages+' trang)';
                        $('.get_nhanhvn_product_logs').html(logs_text);
                        if(nextpage){
                            sync_prod(thisBox, nextpage);
                        }else{
                            alert('Lấy sản phẩm từ Nhanh.vn về website thành công! ' + logs_text);
                            location.reload();
                        }
                    }else {
                        alert(response.data);
                    }
                },
                error: function( jqXHR, textStatus, errorThrown ){
                    thisBox.removeClass('devvn_nhanhvn_loading');
                    alert("Error!");
                }
            });
        }

        $('body').on('click', '.get_nhanhvn_product', function () {

            let thisBox = $(this).closest('.wrap');
            sync_prod(thisBox, 1);

            return false;
        });

        $('body').on('click', '.save_sp_nhanhid', function () {

            let thisBox = $(this).closest('td');
            let idProd = $('.sp_nhanh_id', thisBox).attr('data-id');
            let nonce = $("#nhanhvn_update_nonce").val();
            let sp_nhanh_id = $('[name="sp_nhanh_id"]', thisBox).val();
            let thisBtn = $(this);

            $.ajax({
                type : "post",
                dataType : "json",
                url : devvn_nhanhvn_admin.ajax_url,
                data : {
                    action: "add_sp_nhanhid",
                    idprod: idProd,
                    nhanhid: sp_nhanh_id,
                    nonce: nonce
                },
                context: this,
                beforeSend: function(){
                    thisBox.addClass('devvn_nhanhvn_loading');
                },
                success: function(response) {
                    thisBox.removeClass('devvn_nhanhvn_loading');
                    if(response.success) {
                        thisBtn.html('Đã lưu');
                        setTimeout(function (){
                            thisBtn.html('Lưu');
                        }, 500);
                    }else {
                        alert(response.data);
                    }
                },
                error: function( jqXHR, textStatus, errorThrown ){
                    thisBox.removeClass('devvn_nhanhvn_loading');
                    alert("Error!");
                }
            });

            return false;
        });

    });
})(jQuery);