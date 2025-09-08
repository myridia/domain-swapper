<?php
/* 
 * display post slider from given product category
 */

class best_shop_post_slider_widget extends WP_Widget {

function __construct() {		

		parent::__construct(
		  
		// Base ID of your widget
		'best_shop_post_slider_widget', 
		  
		// Widget name will appear in UI
		__('+ Post Slider', 'best-shop'), 
		  
		// Widget description
		array( 'description' => __( 'Display Post Slider.', 'best-shop' ), ) 
		);
}

public function widget( $args, $instance ) {

      $max_items = ( ! empty( $instance['max_items'] ) ) ? absint( $instance['max_items'] ) : 3;
      $category = ( ! empty( $instance['category'] ) ) ? wp_strip_all_tags( $instance['category'] ) : -1;
      $hide_title_price = ( ! empty( $instance['hide_title_price'] ) ) ? true : false;
      $navigation = ( ! empty( $instance['navigation'] ) ) ? true : false;
      $max_height = (!empty($instance['max_height'])) ?  absint($instance['max_height']) : 400;
      $speed = (!empty($instance['speed'])) ? absint($instance['speed']) : 4;
      $button_lbl = ( ! empty( $instance['button_lbl'] ) ) ? wp_strip_all_tags( $instance['button_lbl'] ) : '';
      $excerpt = (!empty($instance['excerpt'])) ?  absint($instance['excerpt']) : 10;
    
      $args = array();
    
      if( $category == -1 ){
          $args = array ( 'post_type' => 'post', 'posts_per_page'=> $max_items );
      } else {
          $args = array ( 'post_type' => 'post',	'posts_per_page'=> $max_items, 'cat' => $category );		
      }



      $loop = new WP_Query($args );

      $i = 1;

      $items = array();

      while( $loop->have_posts() ) : $loop->the_post();
          		  
			$thumb_id = get_post_thumbnail_id(get_the_ID());	
			$url = get_the_post_thumbnail_url(get_the_ID(), 'full');
			
			if(!$url) {
				$url = get_template_directory_uri().'/images/empty.png';
			}
						
			$alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
			$link = get_permalink();
			$title = get_the_title();
    
			$content = wp_trim_words( get_the_content(), $excerpt , '...' );
			
			$item = array ( 'link' => $link , 
							'image_url' => $url , 
							'content' => $content , 
							'title' => $title,
							'alt' => $alt
							);
										
			array_push($items, $item);

			$i++;    
    
      endwhile;
      wp_reset_postdata();

      global $best_shop_uniqueue_id ;
      $best_shop_uniqueue_id += 1;		
      $carousal_id = 'product-carousal-'.$best_shop_uniqueue_id;



      //carousal begin
      echo '<div id="'.esc_attr($carousal_id).'" class="product-slider carousel slide carousel-fade" data-ride="carousel" data-interval="'.esc_attr($speed*1000).'" >';
      echo '<div class="carousel-inner">';

      $active = 'active';
      $item_count = count($items);

      foreach ($items as $slides){
      echo '<div class="item '.esc_attr($active).' ">';
      ?>
    
      <a href="<?php echo esc_url($slides['link']); ?>">
      <div class="static-banner">
          
      <div class="banner-wrapper featured-slider">
      <div class="banner-image-wrapper" style="height:<?php echo absint($max_height); ?>px">
          <div id="wp-custom-header" class="wp-custom-header"><img loading="lazy" src="<?php echo esc_url($slides['image_url']); ?>" alt="Test" ></div>
      </div>
          
      <?php if( $slides['title'] || $slides['content'] || $button_lbl ) { ?> 
        <div class="container">
            <div class="banner-details-wrapper">
                <div class="container">
                    <div class="overlay-details">
                        <?php if( !$hide_title_price ) { ?>
                            <h2 class="item-title">
                                <?php echo esc_html( $slides['title'] ); ?>
                            </h2>
                        <?php } if( !$hide_title_price && $excerpt !='' ) { ?>
                            <span>
                                <?php echo esc_html( $slides['content'] ); ?>
                            </span>                    
                        <?php } if ( $button_lbl !='') { ?>
                            <div class="button-wrap">
                                <a href="<?php echo esc_url( $slides['link']); ?>" class="primary-btn"><?php echo esc_html($button_lbl ); ?></a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
      <?php } ?>
      </div>
      </div>
      </a>

      <?php
      $active = '';
      echo '</div>';	
      }


      //indicators, navigation
      if($item_count>1 ) {	
          
        if($navigation == true) {

        ?><a class="left carousel-control" href="#<?php echo esc_attr($carousal_id);?>" data-slide="prev">
        <span><?php echo best_shop_social_icons_svg_list('arrow-left'); ?></span>
        </a>
        <a class="right carousel-control" href="#<?php echo esc_attr($carousal_id);?>" data-slide="next">
        <span><?php echo best_shop_social_icons_svg_list('arrow-right'); ?></span>
        </a><?php
            
        }

        $active = 'active';		
        echo '<ol class="carousel-indicators">';	
        $s = 0;
        foreach ($items as $slides) {
            echo '<li data-target="#'.esc_attr($carousal_id).'" data-slide-to="'.esc_attr($s).'" class="'.esc_attr($active).'"></li>';
            $active = '';
            $s++;
        }	
        echo '</ol>';

      }//indicators, navigation

      echo '</div>';
      echo '</div>';

}
		
public function form( $instance ) {
		$max_items = ( ! empty( $instance['max_items'] ) ) ? absint( $instance['max_items'] ) : 3;
		$category = ( ! empty( $instance['category'] ) ) ? wp_strip_all_tags( $instance['category'] ) : -1;
		$hide_title_price = ( ! empty( $instance['hide_title_price'] )) ? (bool) $instance['hide_title_price'] : false;
        $navigation = ( ! empty( $instance['navigation'] )) ? (bool) $instance['navigation'] : false;
		$max_height = (!empty($instance['max_height'])) ?  absint($instance['max_height']) : 400;
		$speed = (!empty($instance['animation'])) ? absint($instance['speed']) : 4;
		$button_lbl = ( ! empty( $instance['button_lbl'] ) ) ? wp_strip_all_tags( $instance['button_lbl'] ) : esc_html__('VIEW MORE', 'best-shop');
		$excerpt = (!empty($instance['excerpt'])) ?  absint($instance['excerpt']) : '';
    
        $args = get_categories( array(
                            'orderby' => 'name',
                            'parent'  => 0
                        ));
		 
		$categories = get_categories( $args );
    
		$category_list = '';
    
		
		if(0 == $category){
			$category_list = $category_list.'<option value="-1" Selected=selected>'.esc_html__( 'All','best-shop').'</option>';
		} else{
			$category_list = $category_list.'<option value="-1">'.esc_html__( 'All','best-shop').'</option>';
		}
		
		foreach ( $categories as $cat ) {
			$selected ='';
			if(($cat->term_id)==$category){
				$selected ='Selected=selected';
			}
			$category_list = $category_list.'<option value="'.esc_attr($cat->term_id).'" '.esc_attr($selected).' >'.esc_html($cat->name).'</option>';
		}
		?>
		
		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'category' )); ?>"><?php esc_html_e( 'Select Post Category:','best-shop'  ); ?></label> 
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'category' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'category' )); ?>" type="text">
		<?php echo $category_list; ?>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'max_items' )); ?>"><?php esc_html_e( 'Number of Slides to Show:','best-shop'  ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'max_items' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'max_items' )); ?>" type="number" value="<?php echo esc_attr( $max_items ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('speed')); ?>">
			<?php esc_html_e( 'Slider Speed in seconds:', 'best-shop' ); ?></label><br />
			<input type="text" name="<?php echo esc_attr($this->get_field_name('speed')); ?>" id="<?php echo esc_attr($this->get_field_id('speed')); ?>" value="<?php if ($speed) : echo absint($speed); endif; ?>" class="widefat" />
		</p>


		<p>
			<label for="<?php echo esc_attr($this->get_field_id('button_lbl')); ?>">
			<?php esc_html_e( 'Button Label (Keep empty to hide):', 'best-shop' ); ?></label><br />
			<input type="text" name="<?php echo esc_attr($this->get_field_name('button_lbl')); ?>" id="<?php echo esc_attr($this->get_field_id('button_lbl')); ?>" value="<?php if ($button_lbl) : echo esc_attr($button_lbl); endif; ?>" class="widefat" />
		</p>		
					
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('max_height')); ?>">
			<?php esc_html_e( 'Max Height:', 'best-shop' ); ?></label><br />
			<input type="number" name="<?php echo esc_attr($this->get_field_name('max_height')); ?>" id="<?php echo esc_attr($this->get_field_id('max_height')); ?>" value="<?php echo absint($max_height);?>" class="widefat" />
		</p>
				
		<p>
		<input class="checkbox" type="checkbox" <?php checked( $hide_title_price ); ?>  id="<?php echo esc_attr($this->get_field_id( 'hide_title_price' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'hide_title_price' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'hide_title_price' )); ?>"><?php esc_html_e( 'Hide title and excerpt','best-shop' ); ?></label> 
		</p>

		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'excerpt' )); ?>"><?php esc_html_e( 'Post Excerpt Length (0 = hide excerpt):', 'best-shop'  ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'excerpt' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'excerpt' )); ?>" type="number" value="<?php echo absint( $excerpt ); ?>" />
		</p>
		
		<p>
		<input class="checkbox" type="checkbox" <?php checked( $navigation ); ?>  id="<?php echo esc_attr($this->get_field_id( 'navigation' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'navigation' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'navigation' )); ?>"><?php esc_html_e( 'Show slider navigations','best-shop' ); ?></label> 
		</p>


		
		
		<?php 
		}

public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['max_items'] = ( ! empty( $new_instance['max_items'] ) ) ? absint( $new_instance['max_items'] ) : '';
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? wp_strip_all_tags( $new_instance['category'] ) : '' ;
		$instance['hide_title_price'] = ( ! empty( $new_instance['hide_title_price'] ) ) ? 1 : 0 ;
        $instance['navigation'] = ( ! empty( $new_instance['navigation'] ) ) ? 1 : 0 ;
		$instance['max_height'] = ( ! empty( $new_instance['max_height'] ) ) ? absint( $new_instance['max_height'] ) : '';
		$instance['speed'] = (!empty($new_instance['speed'])) ? absint($new_instance['speed']): '';
		$instance['button_lbl'] = ( ! empty( $new_instance['button_lbl'] ) ) ? wp_strip_all_tags( $new_instance['button_lbl'] ) : '';
		
		return $instance;
	 }
}

function best_shop_post_slider_widget() {
		register_widget( 'best_shop_post_slider_widget' );
}
add_action( 'widgets_init', 'best_shop_post_slider_widget' );