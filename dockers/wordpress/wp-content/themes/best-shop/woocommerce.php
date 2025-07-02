<?php
/**
 * The template for displaying WooCommerce pages.
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility
 * @license  http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

get_header(); ?>

<div class="woocommerce-page">
    
    <div class="content-area" id="primary">
         <div class="container">
             <div class="page-grid">
                 
                  <div class="site-main">
                      <div class="content-area">

                          <?php woocommerce_content(); ?>

                      </div><!-- .content-area -->
                  </div>

                 <?php 
                 
                 if ( is_active_sidebar( 'woo-sidebar' )) {
                      get_template_part('woo', 'sidebar');
                  } 
                 
                 ?>

            </div>
        </div>
        
    </div>
    
</div>

<?php
get_footer();