function cancel_update_variations(t) {
	jQuery("tr.new_row_" + t).remove(), jQuery("tr.old_row_" + t).fadeIn(150).fadeTo(150, 1)
}
jQuery(document).on("click", ".WOO_CK_WUVIC_buttom", (function() {
	var t;
	jQuery(this).parent().find("#loder_img").css("display", "block"), (t = jQuery(this).closest("tr")).fadeTo(300, 0);
	var e = jQuery(this).attr("id");
	jQuery.ajax({
		async: !0,
		url: update_variation_params.ajax_url,
		type: "POST",
		dataType: "html",
		data: {
			current_key_value: e,
			action: "get_variation_form"
		},
		success: function(a) {
			 $('.modal').empty().append(a);
			 $.ajax({
				async: !0,
				url: update_variation_params.ajax_url,
				type: "post",
				dataType: "html",
				data: {
					action: "update_product_in_cart",
					old_key: e
				},
				success: function(res) {
					$(".woocommerce-cart-form").load(window.location + " .woocommerce-cart-form");
				}
			});
		}
	}),
	document.getElementById('overlay').classList.add('js-visible');
  document.getElementById('modal').classList.add('js-visible');
}));