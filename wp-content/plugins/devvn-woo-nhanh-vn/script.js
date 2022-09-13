jQuery(document).ready(function($) {
    $('button[action="nhanh-woo"]').on('click', function(){
        window.onbeforeunload = function() {
            return 'Bạn có chắc muốn thoát trang không?';
        };
        $('.current-product').html(0);
        devvn_next_page(1);
    });

    function devvn_next_page(page) {
        $.ajax({
            type: 'post',
            url: devvn.ajax_url,
            dataType: 'JSON',
            data: {
                action: 'get_products',
                page: page,
            },
            beforeSend: function () {
                $('button[action="nhanh-woo"]').addClass('loading');
                $('button[action="nhanh-woo"]').html('Đang đồng bộ sản phẩm');
                $('button[action="nhanh-woo"]').removeAttr('action');
            },
            success: function (response) {
                if (response.status == 'ok') {
                    let totalPages = parseInt(response.data.totalPages);
                    let currentPages = parseInt(response.data.currentPage);
                    let data = response.data;
                    console.log(data);
                    $('.current-page').html(currentPages);
                    $('.total-page').html(totalPages);
                    if (page == 1) {
                        devvn_get_product_last_page(totalPages);
                    }
                    devvn_sync_product(data, 0);
                } else {
                    alert(response.message);
                    console.log(response);
                    $('.sync-button button').removeClass('loading');
                    $('.sync-button button').html('Hoàn tất');
                    return false;
                }
            },
        })
    }

    function devvn_get_product_last_page(page) {
        $.ajax({
            type: 'post',
            url: devvn.ajax_url,
            dataType: 'JSON',
            data: {
                action: 'get_products',
                page: page,
            },
            success: function (response) {
                if (response.status == 'ok') {
                    let totalProducts = (parseInt(page) - 1) * 50;
                    totalProducts += Object.keys(response.data.products).length;
                    $('.sync-response').show();
                    $('.total-products').html(totalProducts);
                }
            },
        });
    }

    function devvn_sync_product(data, i) {
        var currentPage = data.currentPage;
        var totalPages = data.totalPages;
        var products = [];
        for (var key in data.products) {
            products.push(data.products[key]);
        }
        var total = products.length;
        if (total === i) {
            if (currentPage == totalPages) {
                alert("Done");
                $('.sync-button button').removeClass('loading');
                $('.sync-button button').html('Hoàn tất');
                return false;
            }else{
                devvn_next_page(++currentPage);
            }
        }else{
            $.ajax({
                type : 'post',
                url: devvn.ajax_url,
                dataType: 'JSON',
                data : {
                    action: 'devvn_add_product',
                    data: products[i],
                },
                beforeSend: function(){
                
                },
                success: function(response) {
                    let done = $('.current-product').html();
                    let totalDone = parseInt(done) + 1;
                    $('.current-product').html(totalDone);
                    $('.import-log').prepend(response);
                    let percent = (totalDone * 100) / (totalPages * 50);
                    $('.import-done').css('width', percent+'%')
                    $('.import-done').html(percent.toFixed(2)+'%')
                    setTimeout(() => {
                        devvn_sync_product(data, ++i);
                    }, 0);

                },
                error: function( jqXHR, textStatus, errorThrown ){
                    console.log( 'The following error occured: ' + textStatus, errorThrown );
                }
            })
            return false;
        }
    }
});