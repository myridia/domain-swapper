<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
	<?php
	/**
	 * Hook: woocommerce_before_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * Hook: woocommerce_before_shop_loop_item_title.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_product_title - 10
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item_title.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * Hook: woocommerce_after_shop_loop_item.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 
	do_action( 'woocommerce_after_shop_loop_item' );
    */
	?>
    <div class="custom-cart-btn">
				<?php
				/**
				 * Hook: best_shop_loop_add_to_cart.
				 *
				 * @hooked woocommerce_template_loop_add_to_cart - 10
				 */
				do_action( 'best_shop_loop_add_to_cart' );
				?>
    </div>
	
    <div class="hover-area">
        <div class="action-buttons">
            <?php
                if( class_exists('YITH_WCWL') && function_exists('best_shop_pro_textdomain') ) {
                    echo do_shortcode( '[yith_wcwl_add_to_wishlist product_id="'.esc_html($product->get_id()).'" label="" browse_wishlist_text="" already_in_wishslist_text="" added_to_wishslist_text="added to wishlist" ]' );
                }
                if( class_exists('YITH_WOOCOMPARE') && function_exists('best_shop_pro_textdomain')) {	
                    echo do_shortcode( '[yith_compare_button product_id=' .esc_html($product->get_id()). ']' );
                }
                if( class_exists('YITH_WCQV')) {	
                    echo do_shortcode( '[yith_quick_view product_id=' .esc_html($product->get_id()). '  type="button" label=""]' );
                }

            ?>
        </div>
    </div>
	
</li>
