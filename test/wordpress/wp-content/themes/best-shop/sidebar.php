<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Best_Shop
 */

$sidebar = best_shop_sidebar_layout();

if ( $sidebar == 'full-width' || $sidebar == 'no-sidebar' ){
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary" itemscope itemtype="http://schema.org/WPSideBar">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->