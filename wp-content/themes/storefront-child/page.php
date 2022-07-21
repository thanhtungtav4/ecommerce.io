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
		if(is_page('dang-ky')){
			$is_page = "c-login";
		}
		?>
		<main id="main" class="site-main <?php echo $is_page ?>" role="main">
			
			<div class="l-container">
				<?php while ( have_posts() ) :
					the_post();
					do_action( 'storefront_page_before' );
					get_template_part( 'content', 'page' );
					do_action( 'storefront_page_after' );
				endwhile; // End of the loop.
				?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
