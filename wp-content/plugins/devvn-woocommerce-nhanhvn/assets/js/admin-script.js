function selectOnlyThis(a){let b=document.getElementsByClassName("pick_ismain_onlyone");Array.prototype.forEach.call(b,function(a){a.checked=!1}),a.checked=!0}!function($){$(document).ready(function(){let a=!1;$(".sync_depot").on("click",function(){if(!a){let c=$(this).closest(".nhanh_wrap_inline"),b=$("#nhanhvn_update_nonce").val();$.ajax({type:"post",dataType:"json",url:devvn_nhanhvn_admin.ajax_url,data:{action:"sync_depot",nonce:b},context:this,beforeSend:function(){$(".spinner",c).addClass("is-active"),a=!0},success:function(b){b.success?(alert(b.data),location.reload()):alert(b.data),$(".spinner",c).removeClass("is-active"),a=!1},error:function(b,a,d){$(".spinner",c).removeClass("is-active"),alert(a)}})}return!1}),$(".devvn_checkbox_all").on("click",function(){let a=$(this).closest("table");return $('input[type="checkbox"]:checked',a).length>0?$('input[type="checkbox"]',a).prop("checked",!1):$('input[type="checkbox"]',a).prop("checked",!0),!1}),$.fn.extend({vnformat:function(a){var b;return(b="val"==a?$(this).val():$(this).text()).replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g,"a").replace(/đ|Đ/g,"d").replace(/ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ/g,"y").replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g,"u").replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g,"o").replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g,"e").replace(/ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ì|Ĩ/g,"i")}}),$.expr[":"].icontains=function(a,c,b){return $(a).vnformat().toUpperCase().indexOf(b[3].toUpperCase())>=0},$(".search_city").on("keyup",function(){var b=$(this).vnformat("val"),a=$(this).closest(".devvn_hubs_table");(list=$(".nhanhvn_all_state_checkbox_item",a)).hide();var c=$(".nhanhvn_all_state_checkbox_item label:icontains('"+b+"')",a);c.closest(".nhanhvn_all_state_checkbox_item").find(".nhanhvn_all_state_checkbox_item").andSelf().show()}),$(".khuvuc_banhang").on("click",function(){let a=$(this).data("hubid");return $.magnificPopup.open({items:{src:"#hub_district_"+a,type:"inline"},showCloseBtn:!1}),!1}),$(".close_popup").on("click",function(){return $.magnificPopup.close(),!1}),$(".sync_carrier").on("click",function(){if(!a){let c=$(this).closest(".nhanh_wrap_inline"),b=$("#nhanhvn_update_nonce").val();$.ajax({type:"post",dataType:"json",url:devvn_nhanhvn_admin.ajax_url,data:{action:"sync_carrier",nonce:b},context:this,beforeSend:function(){$(".spinner",c).addClass("is-active"),a=!0},success:function(b){b.success?(alert(b.data),location.reload()):alert(b.data),$(".spinner",c).removeClass("is-active"),a=!1},error:function(b,a,d){$(".spinner",c).removeClass("is-active"),alert(a)}})}return!1}),$("body").on("click",".devvn_nhanhvn_popup_button",function(){let a=$(this).data("orderid"),b=$("#nhanhvn_order_nonce").val();$.ajax({type:"post",dataType:"json",url:devvn_nhanhvn_admin.ajax_url,data:{action:"nhanhvn_html_creat_order",orderid:a,nonce:b},context:this,beforeSend:function(){$(this).addClass("devvn_nhanhvn_loading")},success:function(a){if($(this).removeClass("devvn_nhanhvn_loading"),a.success){let b=a.data.html;$.magnificPopup.open({items:{src:b,type:"inline"},showCloseBtn:!1,mainClass:"nhanhvn_popup_wrap"})}else alert("Error!")},error:function(a,b,c){$(this).removeClass("devvn_nhanhvn_loading"),alert("Error!")}})}),$("body").on("click",".devvn_nhanhvn_popup_close",function(){return $.magnificPopup.close(),!1}),$("body").on("change",'[name="nhanhvn_depot"], [name="nhanhvn_weight"], [name="nhanhvn_codMoney"], .calc_fee',function(){(function(a){$(this).data("orderid");let b=$("#nhanhvn_order_nonce").val(),c=$(a).serialize();$.ajax({type:"post",dataType:"json",url:devvn_nhanhvn_admin.ajax_url,data:{action:"nhanhvn_calc_fee_order",data:c,nonce:b},context:this,beforeSend:function(){a.addClass("devvn_nhanhvn_loading"),$(".shipping_order_popup").html("")},success:function(b){if(a.removeClass("devvn_nhanhvn_loading"),b.success){let c=b.data;$(".shipping_order_popup").html(c)}else alert(b.data)},error:function(b,c,d){a.removeClass("devvn_nhanhvn_loading"),alert("Error!")}})})($(this).closest("#nhanh_create_order_form"))}),$("body").on("change",'[name="nhanhvn_serviceId"]',function(){let a=$('[name="nhanhvn_serviceId"]:checked').data("carrierid");$('[name="nhanhvn_carrierId"]').val(a).attr("value",a)}),$("body").on("click",".nhanhvn_create_order",function(){let a=$(this).closest("#nhanh_create_order_form"),b=$("#nhanhvn_create_order_nonce",a).val(),c=$('[name="nhanhvn_serviceId"]:checked').val(),d=$('[name="nhanhvn_carrierId"]').val();return c&&d?($.ajax({type:"post",dataType:"json",url:devvn_nhanhvn_admin.ajax_url,data:{action:"nhanhvn_creat_order",data:a.serialize(),nonce:b},context:this,beforeSend:function(){a.addClass("devvn_nhanhvn_loading")},success:function(b){if(a.removeClass("devvn_nhanhvn_loading"),b.success){let c=b.data.fragments;$.each(c,function(a,b){$(a).html(b)}),$(document.body).trigger("nhanhvn_after_create_order"),$.magnificPopup.close()}else alert(b.data)},error:function(b,c,d){a.removeClass("devvn_nhanhvn_loading"),alert("Error!")}}),!1):(alert("Ch\u01B0a ch\u1ECDn d\u1ECBch v\u1EE5 giao h\xe0ng!"),!1)}),$("body").on("click",".nhanhvn_order_cancel",function(){let c=$(this).data("orderid"),a=$(this).data("status"),d=$("#nhanhvn_order_nonce").val(),e=$(this).closest(".nhanhvn_order_info"),b="";return a||(b=confirm("B\u1EA1n c\xf3 ch\u1EAFc ch\u1EAFn mu\u1ED1n HU\u1EF6 \u0111\u01A1n tr\xean Nhanh.vn kh\xf4ng?")),(!0==b||a)&&$.ajax({type:"post",dataType:"json",url:devvn_nhanhvn_admin.ajax_url,data:{action:"nhanhvn_order_cancel",orderid:c,status:a,nonce:d},context:this,beforeSend:function(){e.addClass("devvn_nhanhvn_loading")},success:function(a){if(e.removeClass("devvn_nhanhvn_loading"),a.success){let b=a.data.fragments;$.each(b,function(a,b){$(a).html(b)}),$(document.body).trigger("nhanhvn_after_order_cancel")}else alert(a.data)},error:function(a,b,c){e.removeClass("devvn_nhanhvn_loading"),alert("Error!")}}),!1}),$("body").on("click",".change_verify_token",function(){let a=function(){for(var a="",b="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789",c=0;c<24;c++)a+=b.charAt(Math.floor(Math.random()*b.length));return a}();return $("#nhanhvn_verify_token").val(a).attr("value",a),!1});let b=0;function c(e,a){let d=$("#nhanhvn_update_nonce").val();$.ajax({type:"post",dataType:"json",url:devvn_nhanhvn_admin.ajax_url,data:{action:"get_nhanhvn_prod",nonce:d,page:a},context:this,beforeSend:function(){e.addClass("devvn_nhanhvn_loading")},success:function(a){if(e.removeClass("devvn_nhanhvn_loading"),a.success){let d=a.data.nextpage,g=a.data.totalPages,h=a.data.currentPage;b+=parseInt(a.data.totalProds);let f="\u0110\xe3 l\u1EA5y \u0111\u01B0\u1EE3c "+b+" s\u1EA3n ph\u1EA9m. ("+h+"/"+g+" trang)";$(".get_nhanhvn_product_logs").html(f),d?c(e,d):(alert("L\u1EA5y s\u1EA3n ph\u1EA9m t\u1EEB Nhanh.vn v\u1EC1 website th\xe0nh c\xf4ng! "+f),location.reload())}else alert(a.data)},error:function(a,b,c){e.removeClass("devvn_nhanhvn_loading"),alert("Error!")}})}$("body").on("click",".get_nhanhvn_product",function(){return c($(this).closest(".wrap"),1),!1}),$("body").on("click",".save_sp_nhanhid",function(){let a=$(this).closest("td"),b=$(".sp_nhanh_id",a).attr("data-id"),c=$("#nhanhvn_update_nonce").val(),d=$('[name="sp_nhanh_id"]',a).val(),e=$(this);return $.ajax({type:"post",dataType:"json",url:devvn_nhanhvn_admin.ajax_url,data:{action:"add_sp_nhanhid",idprod:b,nhanhid:d,nonce:c},context:this,beforeSend:function(){a.addClass("devvn_nhanhvn_loading")},success:function(b){a.removeClass("devvn_nhanhvn_loading"),b.success?(e.html("\u0110\xe3 l\u01B0u"),setTimeout(function(){e.html("L\u01B0u")},500)):alert(b.data)},error:function(b,c,d){a.removeClass("devvn_nhanhvn_loading"),alert("Error!")}}),!1})})}(jQuery)