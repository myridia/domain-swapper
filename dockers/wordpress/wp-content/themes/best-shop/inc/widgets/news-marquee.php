<?php
/* 
 * display breaking / popular / latest / trending / custom category widget
 */

class best_shop_news_marquee_widget extends WP_Widget {


function __construct() {
		parent::__construct(
		  
		// Base ID of your widget
		'best_shop_news_marquee_widget', 
		  
		// Widget name will appear in UI
		__('+ News: Marquee', 'best-shop'), 
		  
		// Widget description
		array( 'description' => __( 'Display Marquee of Post Categories.', 'best-shop' ), ) 
		);
}

public function widget( $args, $instance ) {

		$max_items = ( ! empty( $instance['max_items'] ) ) ? absint( $instance['max_items'] ) : 6;
		$title = ( ! empty( $instance['title'] ) ) ? wp_strip_all_tags( $instance['title'] ) : '';
		$category = ( ! empty( $instance['category'] ) ) ? wp_strip_all_tags( $instance['category'] ) : 0;
    
		$args = array();
		
		if( $category == -1 ){
			$args = array ( 'post_type' => 'post', 'posts_per_page'=> $max_items, 'post_status' => 'publish' );
			
		} else if ($category == -2) {	
			$args = array ('post_type' => 'post', 'posts_per_page' => $max_items , 'meta_key' => 'my_post_viewed', 'orderby' => 'meta_value_num', 'order' => 'DESC' , 'post_status' => 'publish' );
		
		} else if ($category == -3) {	
			$args = array ('post_type' => 'post', 'posts_per_page'=> $max_items, 'order' => 'DESC', 'post_status' => 'publish' );
		
		} else {
			$args = array ( 'post_type' => 'post',	'posts_per_page'=> $max_items, 'cat' => $category );		
		
		}
    
        $loop = new WP_Query($args );

?>

            <div class="banner-exclusive-posts-wrapper">

                <?php
                $darknews_number_of_posts = $max_items;
                $darknews_em_ticker_news_title = $title;

                $darknews_show_trending = true;
                $darknews_count = 1;
    
                $darknews_em_ticker_news_mode = 'aft-flash-slide left';
                $darknews_dir = 'left';
    
                if(is_rtl()){
                    $darknews_em_ticker_news_mode = 'aft-flash-slide right';
                    $darknews_dir = 'right';
                }
    
                ?>

                <div class="container-wrapper">
                    <div class="exclusive-posts">
                        <div class="exclusive-now primary-color">
                            <div class="aft-ripple">
                                <div></div>
                                <div></div>
                            </div>
                            <?php if (!empty($darknews_em_ticker_news_title)): ?>
                                <span><?php echo esc_html($darknews_em_ticker_news_title); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="exclusive-slides" dir="ltr">
                            <?php
                            if ($loop->have_posts()) : ?>
                            <div class='marquee <?php echo esc_attr($darknews_em_ticker_news_mode); ?>' data-speed='80000'
                                 data-gap='0' data-duplicated='true' data-direction="<?php echo esc_attr($darknews_dir); ?>" >
                                <?php
                                while ($loop->have_posts()) : $loop->the_post();
                                    global $post;
    
    					            $thumb_id = get_post_thumbnail_id($post->ID);
                                    $darknews_img_url =get_the_post_thumbnail_url($post->ID, 'thumbnail');
                                    $darknews_img_thumb_id = get_post_thumbnail_id($post->ID);
                                    $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
                                    ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if ($darknews_show_trending == true): ?>

                                        <?php endif; ?>

                                        <span class="circle-marq">
                                            <span class="trending-no">
                                                <?php echo esc_html( $darknews_count); ?>
                                            </span>
                                            <?php if ($darknews_img_url) { ?>
                                                <img src="<?php echo esc_url($darknews_img_url); ?>"
                                                     alt="<?php echo esc_attr($alt); ?>">
                                            <?php } ?>
                                    </span>
                                        <?php the_title(); ?>
                                    </a>
                                    <?php
                                    $darknews_count++;
                                endwhile;
                                endif;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Excluive line END -->



<?php

}
		
public function form( $instance ) {

		$max_items = ( ! empty( $instance['max_items'] ) ) ? absint( $instance['max_items'] ) : '6';
		$title = ( ! empty( $instance['title'] ) ) ? wp_strip_all_tags( $instance['title'] ) : '';
		$category = ( ! empty( $instance['category'] ) ) ? wp_strip_all_tags( $instance['category'] ) : -1;
        

		//category
		$args = get_categories( array(
									'orderby' => 'name',
									'parent'  => 0
								));
		 
		$categories = get_categories( $args );
		$category_list = '';
		
		$item = new best_shop_cat();
		$item->term_id = '-1';
		$item->name = '-- All Categories --';		
		array_unshift($categories , $item);
		
		
		$item = new best_shop_cat();
		$item->term_id = '-2';
		$item->name = 'Popular Posts';
		array_unshift($categories , $item);
		
		$item = new best_shop_cat();
		$item->term_id = '-3';
		$item->name = 'Latest Posts';
		array_unshift($categories , $item);			
			

		foreach ( $categories as $cat ) {
			$selected ='';
			if(($cat->term_id) == $category){
				$selected ='Selected=selected';
			}
			$category_list = $category_list.'<option value="'.esc_attr($cat->term_id).'" '.esc_attr($selected).' >'.esc_html($cat->name).'</option>';
		}

?>

		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','best-shop'  ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_html( $title ); ?>" />
		</p>

		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'max_items' )); ?>"><?php esc_html_e( 'Number of Posts to Show:','best-shop'  ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'max_items' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'max_items' )); ?>" type="number" value="<?php echo absint( $max_items ); ?>" />
		</p>

				
		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'category' )); ?>"><?php esc_html_e( 'Select Post type / Category:','best-shop'  ); ?></label> 
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'category' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'category' )); ?>" type="text">
		<?php echo $category_list; ?>
		</select>
		</p>
				
			
		<?php
		}

public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['max_items'] = ( ! empty( $new_instance['max_items'] ) ) ? absint( $new_instance['max_items'] ) : '';
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '' ;
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? wp_strip_all_tags( $new_instance['category'] ) : '' ;

        return $instance;
	 }
}

function best_shop_news_marquee_widget() {
		register_widget( 'best_shop_news_marquee_widget' );
}
add_action( 'widgets_init', 'best_shop_news_marquee_widget' );

