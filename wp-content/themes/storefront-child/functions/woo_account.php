<?php
  /**
 * @snippet       WooCommerce User Registration Shortcode
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 4.0
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
   
add_shortcode( 'wc_reg_form_bbloomer', 'bbloomer_separate_registration_form' );
    
function bbloomer_separate_registration_form() {
   if ( is_admin() ) return;
   if ( is_user_logged_in() ) return;
   ob_start();
 
   // NOTE: THE FOLLOWING <FORM></FORM> IS COPIED FROM woocommerce\templates\myaccount\form-login.php
   // IF WOOCOMMERCE RELEASES AN UPDATE TO THAT TEMPLATE, YOU MUST CHANGE THIS ACCORDINGLY
 
   do_action( 'woocommerce_before_customer_login_form' );
 
   ?>
      <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
 
         <?php do_action( 'woocommerce_register_form_start' ); ?>
            <h1> <?php _e('ĐĂNG KÝ') ?> 
            <p>Đã có tài khoản? <a href="#">Đăng nhập</a></p>
         <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
 
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
               <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
               <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </p>
 
         <?php endif; ?>
 
         <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
         </p>
 
         <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
 
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
               <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
               <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
            </p>
 
         <?php else : ?>
 
            <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>
 
         <?php endif; ?>
 
         <?php do_action( 'woocommerce_register_form' ); ?>
 
         <p class="woocommerce-FormRow form-row">
            <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
            <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
         </p>
 
         <?php do_action( 'woocommerce_register_form_end' ); ?>
 
      </form>
 
   <?php
     
   return ob_get_clean();
}
/**
 * @snippet       WooCommerce User Login Shortcode
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 4.0
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
  
add_shortcode( 'wc_login_form_bbloomer', 'bbloomer_separate_login_form' );
  
function bbloomer_separate_login_form() {
   if ( is_admin() ) return;
   if ( is_user_logged_in() ) return; 
   ob_start();
   woocommerce_login_form( array( 'redirect' => 'https://custom.url' ) );
   return ob_get_clean();
}