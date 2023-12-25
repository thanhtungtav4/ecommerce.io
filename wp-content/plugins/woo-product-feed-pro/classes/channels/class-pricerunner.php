<?php
/**
 * Settings for PriceRunner feeds
 */
class WooSEA_pricerunner {
	public $pricerunner;

        public static function get_channel_attributes() {

                $sitename = get_option('blogname');

        	$pricerunner = array(
			"Feed fields" => array(
				"ProductId" => array(
					"name" => "ProductId",
					"feed_name" => "ProductId",
					"format" => "required",
					"woo_suggest" => "id",
				),
				"ProductName" => array(
					"name" => "ProductName",
					"feed_name" => "ProductName",
					"format" => "required",
					"woo_suggest" => "title",
				),
                                "Price" => array(
                                        "name" => "Price",
                                        "feed_name" => "Price",
					"format" => "required",
					"woo_suggest" => "price",
				),
                   		"ShippingCost" => array(
                                        "name" => "ShippingCost",
                                        "feed_name" => "ShippingCost",
					"format" => "required",
					"woo_suggest" => "shipping_price",
				),
                   		"StockStatus" => array(
                                        "name" => "StockStatus",
                                        "feed_name" => "StockStatus",
					"format" => "required",
					"woo_suggest" => "availability",
				),
                   		"LeadTime" => array(
                                        "name" => "LeadTime",
                                        "feed_name" => "LeadTime",
					"format" => "required",
				),
                   		"Brand" => array(
                                        "name" => "Brand",
                                        "feed_name" => "Brand",
					"format" => "required",
				),
                   		"SKU" => array(
                                        "name" => "Msku",
                                        "feed_name" => "Msku",
					"format" => "required",
					"woo_suggest" => "sku",
				),
                   		"EAN / GTIN" => array(
                                        "name" => "EAN",
                                        "feed_name" => "EAN",
					"format" => "required",
				),
                   		"Url" => array(
                                        "name" => "Url",
                                        "feed_name" => "Url",
					"format" => "required",
					"woo_suggest" => "link",
				),
                   		"ImageUrl" => array(
                                        "name" => "ImageUrl",
                                        "feed_name" => "ImageUrl",
					"format" => "required",
					"woo_suggest" => "image",
				),
                   		"Category" => array(
                                        "name" => "Category",
                                        "feed_name" => "Category",
					"format" => "required",
					"woo_suggest" => "category_path_short",
				),
                   		"Description" => array(
                                        "name" => "Description",
                                        "feed_name" => "Description",
					"format" => "required",
					"woo_suggest" => "description",
				),
            			"AdultContent" => array(
                                        "name" => "AdultContent",
                                        "feed_name" => "AdultContent",
					"format" => "optional",
				),
            			"AgeGroup" => array(
                                        "name" => "AgeGroup",
                                        "feed_name" => "AgeGroup",
					"format" => "optional",
				),
            			"Bundled" => array(
                                        "name" => "Bundled",
                                        "feed_name" => "Bundled",
					"format" => "optional",
				),
            			"Color" => array(
                                        "name" => "Color",
                                        "feed_name" => "Color",
					"format" => "optional",
				),
            			"EnergyEfficiencyClass" => array(
                                        "name" => "EnergyEfficiencyClass",
                                        "feed_name" => "EnergyEfficiencyClass",
					"format" => "optional",
				),
            			"Gender" => array(
                                        "name" => "Gender",
                                        "feed_name" => "Gender",
					"format" => "optional",
				),
            			"Condition" => array(
                                        "name" => "Condition",
                                        "feed_name" => "Condition",
					"format" => "optional",
				),
            			"GroupId" => array(
                                        "name" => "GroupId",
                                        "feed_name" => "GroupId",
					"format" => "optional",
				),
            			"Material" => array(
                                        "name" => "Material",
                                        "feed_name" => "Material",
					"format" => "optional",
				),
            			"Multipack" => array(
                                        "name" => "Multipack",
                                        "feed_name" => "Multipack",
					"format" => "optional",
				),
            			"Pattern" => array(
                                        "name" => "Pattern",
                                        "feed_name" => "Pattern",
					"format" => "optional",
				),
            			"Size" => array(
                                        "name" => "Size",
                                        "feed_name" => "Size",
					"format" => "optional",
				),
            			"SizeSystem" => array(
                                        "name" => "SizeSystem",
                                        "feed_name" => "SizeSystem",
					"format" => "optional",
				),
			),
		);
		return $pricerunner;
	}
}
?>
