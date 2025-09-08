<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Best_Shop
 */
get_header();
?>
<div id="primary" class="content-area">
	<div class="container">
		<div class="breadcrumb-wrapper">
			<?php best_shop_breadcrumb(); ?>
		</div>
		<div class="page-grid">
			<div id="main" class="site-main">
				<?php
					while ( have_posts() ) :
						the_post();
                
                        /*
                         * Include the Post Type content-page template
                         */

						get_template_part( 'template-parts/content', 'page' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
				?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php
get_footer();
