<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Best_Shop
 */

$best_shop_sidebar = best_shop_sidebar_layout();


if ( $best_shop_sidebar == 'full-width' || $best_shop_sidebar == 'no-sidebar'){
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
	<?php dynamic_sidebar( 'woo-sidebar' ); ?>
</aside><!-- #secondary -->