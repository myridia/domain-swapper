<?php
/**
 * The template for displaying comments
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Best_Shop
 */

/*
 * Check If the current post is protected by a password
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
    
		<h2 class="comments-title">
			<?php
			$best_shop_comment_count = get_comments_number();
			if ( '1' === $best_shop_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'Comments on: %s', 'best-shop' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
                printf(
                    /* translators: 1: comment count number, 2: post title. */
                    esc_html(
                        _nx(
                            '%1$s Comment on %2$s',
                            '%1$s Comments on %2$s',
                            $best_shop_comment_count,
                            'comments title',
                            'best-shop'
                        )
                    ),
                    number_format_i18n( $best_shop_comment_count ), // Formats the comment count
                    '<span>' . wp_kses_post( get_the_title() ) . '</span>'
                );
			}
			?>
            
		</h2><!-- .comments-title -->

		<ol class="comments-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'callback'   => 'best_shop_comment',
                    'avatar_size' => 95,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'best-shop' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form();
	?>

</div><!-- #comments -->
