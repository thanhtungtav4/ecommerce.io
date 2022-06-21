<?php
/*
* Remove thuong_hieu in URL
* Thay thuong_hieu bằng slug hiện tại của bạn. Mặc định là thuong_hieu
*/
add_filter( 'term_link', 'dev_product_thuong_hieu_permalink', 10, 3 );
function dev_product_thuong_hieu_permalink( $url, $term, $taxonomy ){
    switch ($taxonomy):
        case 'thuong-hieu':
              $taxonomy_slug = 'thuong-hieu'; //Thay bằng slug hiện tại của bạn. Mặc định là thuong-hieu
              if(strpos($url, $taxonomy_slug) === FALSE) break;
              $url = str_replace('/' . $taxonomy_slug, '', $url);
              break;
        case 'category':
        $taxonomy_slug = 'category'; //Thay bằng slug hiện tại của bạn. Mặc định là thuong-hieu
        if(strpos($url, $taxonomy_slug) === FALSE) break;
        $url = str_replace('/' . $taxonomy_slug, '', $url);
        break;
    endswitch;
    return $url;
}
// Add our custom thuong-hieu rewrite rules
function dev_thuong_hieu_rewrite_rules($flash = false) {
  $terms = get_terms( array(
      'taxonomy' => 'thuong-hieu',
      'post_type' => 'product',
      'hide_empty' => false,
  ));
  if($terms && !is_wp_error($terms)){
      $siteurl = esc_url(home_url('/'));
      foreach ($terms as $term){
          $term_slug = $term->slug;
          $baseterm = str_replace($siteurl,'',get_term_link($term->term_id,'thuong-hieu'));
          add_rewrite_rule($baseterm.'?$','index.php?thuong-hieu='.$term_slug,'top');
          add_rewrite_rule($baseterm.'page/([0-9]{1,})/?$', 'index.php?thuong-hieu='.$term_slug.'&paged=$matches[1]','top');
          add_rewrite_rule($baseterm.'(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?thuong-hieu='.$term_slug.'&feed=$matches[1]','top');
      }
  }
  if ($flash == true)
      flush_rewrite_rules(false);
}
add_action('init', 'dev_thuong_hieu_rewrite_rules');
// Add our custom category rewrite rules
function dev_category_rewrite_rules($flash = false) {
    $terms = get_terms( array(
        'taxonomy' => 'category',
        'post_type' => 'post',
        'hide_empty' => false,
    ));
    if($terms && !is_wp_error($terms)){
        $siteurl = esc_url(home_url('/'));
        foreach ($terms as $term){
            $term_slug = $term->slug;
            $baseterm = str_replace($siteurl,'',get_term_link($term->term_id,'category'));
            add_rewrite_rule($baseterm.'?$','index.php?category='.$term_slug,'top');
            add_rewrite_rule($baseterm.'page/([0-9]{1,})/?$', 'index.php?category='.$term_slug.'&paged=$matches[1]','top');
            add_rewrite_rule($baseterm.'(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?category='.$term_slug.'&feed=$matches[1]','top');
        }
    }
    if ($flash == true)
        flush_rewrite_rules(false);
  }
add_action('init', 'dev_category_rewrite_rules');
/*Sửa lỗi khi tạo mới taxomony bị 404*/
add_action( 'create_term', 'new_thuong_hieu_cat_edit_success', 10, 2 );
function new_thuong_hieu_cat_edit_success( $term_id, $taxonomy ) {
    dev_thuong_hieu_rewrite_rules(true);
    dev_category_rewrite_rules(true);
}

/*
* ! Remove thuong_hieu in URL
* Thay thuong_hieu bằng slug hiện tại của bạn. Mặc định là thuong_hieu
*/

/***
 * Xóa bỏ product-category và toàn bộ slug của danh mục cha khỏi đường dẫn của Woocommerce
 */
// Add our custom product cat rewrite rules
add_filter('term_link', 'dev_no_term_parents', 1000, 3);
function dev_no_term_parents($url, $term, $taxonomy) {
    if($taxonomy == 'product_cat'){
        $term_nicename = $term->slug;
        $url = trailingslashit(get_option( 'home' )) . user_trailingslashit( $term_nicename, 'category' );
    }
    return $url;
}

// Add our custom product cat rewrite rules
function dev_no_product_cat_parents_rewrite_rules($flash = false) {
    $terms = get_terms( array(
        'taxonomy' => 'product_cat',
        'post_type' => 'product',
        'hide_empty' => false,
    ));
    if($terms && !is_wp_error($terms)){
        foreach ($terms as $term){
            $term_slug = $term->slug;
            add_rewrite_rule($term_slug.'/?$', 'index.php?product_cat='.$term_slug,'top');
            add_rewrite_rule($term_slug.'/page/([0-9]{1,})/?$', 'index.php?product_cat='.$term_slug.'&paged=$matches[1]','top');
            add_rewrite_rule($term_slug.'/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?product_cat='.$term_slug.'&feed=$matches[1]','top');
        }
    }
    if ($flash == true)
        flush_rewrite_rules(false);
}
add_action('init', 'dev_no_product_cat_parents_rewrite_rules');

/*Sửa lỗi khi tạo mới taxomony bị 404*/
add_action( 'create_term', 'dev_new_product_cat_edit_success', 10);
add_action( 'edit_terms', 'dev_new_product_cat_edit_success', 10);
add_action( 'delete_term', 'dev_new_product_cat_edit_success', 10);
function dev_new_product_cat_edit_success( ) {
    dev_no_product_cat_parents_rewrite_rules(true);
}
/***
 * Xóa bỏ product-category và toàn bộ slug của danh mục cha khỏi đường dẫn của Woocommerce
 */

/*
* Code Bỏ /product/ hoặc /cua-hang/ hoặc /shop/ ... có hỗ trợ dạng %product_cat%
* Thay /cua-hang/ bằng slug hiện tại của bạn
*/
function dev_remove_slug( $post_link, $post ) {
  if ( !in_array( get_post_type($post), array( 'product' ) ) || 'publish' != $post->post_status ) {
      return $post_link;
  }
  if('product' == $post->post_type){
      $post_link = str_replace( '/cua-hang/', '/', $post_link ); //Thay cua-hang bằng slug hiện tại của bạn
  }else{
      $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
  }
  return $post_link;
}
add_filter( 'post_type_link', 'dev_remove_slug', 10, 2 );
/*Sửa lỗi 404 sau khi đã remove slug product hoặc cua-hang*/
function dev_woo_product_rewrite_rules($flash = false) {
  global $wp_post_types, $wpdb;
  $siteLink = esc_url(home_url('/'));
  foreach ($wp_post_types as $type=>$custom_post) {
      if($type == 'product'){
          if ($custom_post->_builtin == false) {
              $querystr = "SELECT {$wpdb->posts}.post_name, {$wpdb->posts}.ID
                          FROM {$wpdb->posts}
                          WHERE {$wpdb->posts}.post_status = 'publish'
                          AND {$wpdb->posts}.post_type = '{$type}'";
              $posts = $wpdb->get_results($querystr, OBJECT);
              foreach ($posts as $post) {
                  $current_slug = get_permalink($post->ID);
                  $base_product = str_replace($siteLink,'',$current_slug);
                  add_rewrite_rule($base_product.'?$', "index.php?{$custom_post->query_var}={$post->post_name}", 'top');
                  add_rewrite_rule($base_product.'comment-page-([0-9]{1,})/?$', 'index.php?'.$custom_post->query_var.'='.$post->post_name.'&cpage=$matches[1]', 'top');
                  add_rewrite_rule($base_product.'(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?'.$custom_post->query_var.'='.$post->post_name.'&feed=$matches[1]','top');
              }
          }
      }
  }
  if ($flash == true)
      flush_rewrite_rules(false);
}
add_action('init', 'dev_woo_product_rewrite_rules');
/*Fix lỗi khi tạo sản phẩm mới bị 404*/
function dev_woo_new_product_post_save($post_id){
  global $wp_post_types;
  $post_type = get_post_type($post_id);
  foreach ($wp_post_types as $type=>$custom_post) {
      if ($custom_post->_builtin == false && $type == $post_type) {
          dev_woo_product_rewrite_rules(true);
      }
  }
}
add_action('wp_insert_post', 'dev_woo_new_product_post_save');