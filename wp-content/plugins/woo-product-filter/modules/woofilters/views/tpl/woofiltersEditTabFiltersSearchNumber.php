<?php
if ($isPro) {
	DispatcherWpf::doAction('addEditTabFilters', 'partEditTabFiltersSearchNumber', array('attrDisplay' => $attrDisplay));
} else {
	?>
	<div class="row-settings-block col-md-12">
		<a href="https://woobewoo.com/plugins/woocommerce-filter/" target="_blank">
			<img class="wpfProAd" src="<?php echo esc_url($adPath . 'search_number.png'); ?>">
		</a>
	</div>
<?php } ?>
