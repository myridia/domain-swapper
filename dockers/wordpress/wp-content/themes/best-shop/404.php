<?php
/**
 * The template for displaying 404 pages
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 * @package Best_Shop
 */
  get_header();
?>
      <div class="content-area" id="primary">

          <div class="container">
              
              <div class="breadcrumb-wrapper">
                  <?php best_shop_breadcrumb(); ?>
              </div>

              <div id="main" class="site-main">

                  <section class="error-404 not-found">

                      <header class="page-header">
                          <h2 class="page-title">
                          <span><?php echo esc_html__( '404', 'best-shop' ); ?></span>
                              <?php echo esc_html__( "This page doesn't seem to exist.", 'best-shop' ); ?>
                          </h2>
                          <div class="subtitle">
                              <p><?php echo esc_html__( 'It looks like the link pointing here was faulty. Maybe try searching?', 'best-shop' ); ?></p>
                          </div>
                          <div class="error404-search">
                              <?php get_search_form(); ?>
                          </div>
                      </header>

                  </section>

                  <!-- End of error section -->
                  <div class="additional-post">
                      <?php best_shop_get_posts_list( 'latest' ); ?>
                  </div>

              </div>

          </div>
      </div>

<?php
get_footer();