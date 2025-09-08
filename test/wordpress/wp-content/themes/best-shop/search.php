<?php
/**
 * The template for displaying search results pages
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 * @package Best_Shop
 */
get_header();
?>
	<div class="content-area" id="primary">
		<div class="container">
			<div class="page-grid">
				<div id="main" class="site-main">
                    
					<div class="content-wrap-main">
						<?php
							if ( have_posts() ) { 
                                
								/* Start the Loop */
								while ( have_posts() ) {
									the_post();
									/**
									 * Run the loop for the search to output the results.
									 * If you want to overload this in a child theme then include a file
									 * called content-search.php and that will be used instead.
									 */
									get_template_part( 'template-parts/content', 'search' );

								}
                                
							}else{
								get_template_part( 'template-parts/content', 'none' );
							} 
                        ?>
					</div> 
                    
                    <?php 
                      best_shop_nav(); 
                      get_template_part( 'template-parts/pagination' );                       
                    ?>
                    
				</div>
                
				<?php get_sidebar(); ?>
                
			</div>
		</div>
	</div>

<?php
get_footer();