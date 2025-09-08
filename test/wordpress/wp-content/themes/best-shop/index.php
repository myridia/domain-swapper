<?php
/**
 * The main template file
 *
 * This is the most generic template file (required) in a WordPress theme
 * The only files needed for a WordPress theme to work out of the box are an index.php file 
 * to display your list of posts and a style.css file to style the content.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Best_Shop
 */
get_header();
?>
  <div class="content-area" id="primary">
      <div class="container">
          <div class="page-grid">

              <main id="main" class="site-main">
                  <div class="content-wrap-main">
                  <?php
                      if ( have_posts() ) :

                          /* Start the Loop */
                          while ( have_posts() ) :
                              the_post();

                                /*
                                 * Include the Post Type specific template for the content by get_post_type() fuction
                                 */

                              get_template_part( 'template-parts/content', get_post_type() );

                          endwhile;

                      else :

                          get_template_part( 'template-parts/content', 'none' );

                      endif;
                  ?>

                  </div>

                  <?php 
                  
                  best_shop_nav(); 
                  
                  get_template_part( 'template-parts/pagination' ); 
                  
                  ?>

              </main><!-- #main -->

              <?php get_sidebar(); ?>

          </div>
      </div>
  </div>
<?php
get_footer();
