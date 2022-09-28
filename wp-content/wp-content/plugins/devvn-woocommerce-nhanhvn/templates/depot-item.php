<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$full_address = isset($depot['full_address']) ? esc_attr($depot['full_address']) : '';
$maps = isset($depot['maps']) ? esc_url($depot['maps']) : '';
?>
<div class="depot-item">
    <?php echo $depot['name'];?> <?php echo $full_address;?><?php if($maps):?> - <a href="<?php echo $maps;?>" target="_blank" rel="nofollow">Xem bản đồ</a><?php endif;?>
</div>