<?php
/**
 * Template part for displaying post content in single.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Best_Shop
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-image">
		<?php 
		/**
		 * Post thumbnail
		 */
		best_shop_post_thumbnail(); 
		/**
		 * Entry Header
		 */
		do_action( 'best_shop_post_entry_header' );
		?>		
	</div>
	<div>
		<?php 
		/**
		 * @hooked best_shop_entry_content - 15
		 * @hooked best_shop_entry_footer - 20
		 */
		do_action( 'best_shop_post_entry_content' ) ; 
		?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
