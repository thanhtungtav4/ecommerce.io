<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package storefront
 */
get_header(); ?>
	<div id="primary" class="content-area">
		<?php
		if(is_page('dang-ky') || is_page('register')){
			$is_page = "c-login";
		}
		elseif(!is_user_logged_in()){
			if(is_page( 'tai-khoan' ) || is_page( 'my-account' )){
				$is_page = "c-login";
			}
		}
		?>
		<main id="main" class="site-main <?php $is_page ? print $is_page : "" ?>" role="main">

			<div class="l-container">
			<?php
				while ( have_posts() ) :
				the_post();
				do_action( 'storefront_page_before' );
				if(is_page('tai-khoan') || is_page('my-account') || is_page('gio-hang') || is_page('cart') || is_page('thanh-toan') || is_page('checkout') || is_page('register') || is_page('dang-ky') ) {
					get_template_part( 'content', 'page-tool' );
				}
				else{
					get_template_part( 'content', 'page' );
				}
				/**
				 * Functions hooked in to storefront_page_after action
				 *
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );
				endwhile; // End of the loop.
			?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//do_action( 'storefront_sidebar' );
get_footer();
