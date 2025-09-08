<?php
/* 
 * display soial links
 */


class best_shop_social_link_widget extends WP_Widget {

function __construct() {
		parent::__construct(
		  
		// Base ID of your widget
		'best_shop_social_link_widget', 
		  
		// Widget name will appear in UI
		__('+ Social Links', 'best-shop'), 
		  
		// Widget description
		array( 'description' => __( 'Social Links specified in theme options - top bar.', 'best-shop' ), ) 
		);
}

    
public function widget( $args, $instance ) {

    $title = ( ! empty( $instance['title'] ) ) ? wp_strip_all_tags( $instance['title'] ) : '';
		$colums = (!empty($instance['colums'])) ?  wp_strip_all_tags($instance['colums']) : "col-md-6 col-sm-6 col-lg-6 col-xs-6";
            
    
		echo '<div class=" post-widget-container">';
		
		if($title) {
			echo '<div class="mag-sec-title">';
				echo '<h3 class="post-widget-title"><div>'.esc_html($title).'</div></h3>';
			echo '</div>';
		}
		
		echo '</div>';    
    ?>

    <div class="widget-social-contancts"><?php
            $social_links = best_shop_get_setting( 'social_links' );
            
            if($social_links ){ ?>
            <ul class="social-links">
                <?php 
                foreach( $social_links as $link ){
                    $new_tab = isset( $link['best_shop_checkbox'] ) && $link['best_shop_checkbox'] ? '_blank' : '_self';
                    if( isset( $link['best_shop_link'] ) ){ ?>
                    <li class="<?php echo esc_attr($colums); ?>">
                        <div class="social-content">
                          <a href="<?php echo esc_url( $link['best_shop_link'] ); ?>" target="<?php echo esc_attr( $new_tab ); ?>" rel="nofollow noopener">
                              <?php echo wp_kses( best_shop_social_icons_svg_list( $link['best_shop_icon'] ), best_shop_kses_extended_ruleset() ); ?>
                           <div class="icon-name"><?php echo wp_strip_all_tags($link['best_shop_icon']); ?></div>                       
                          </a>
                        </div>
                    </li>	   
                    <?php
                    } 
                } 
                ?>
            </ul>
    </div><?php

    }
}
		
public function form( $instance ) {
		$title = ( ! empty( $instance['title'] ) ) ? wp_strip_all_tags( $instance['title'] ) : '';
		$colums = (!empty($instance['colums'])) ?  wp_strip_all_tags($instance['colums']) : "col-md-6 col-sm-6 col-lg-6 col-xs-6";
     
		//columns
		$product_colums = array(
				"col-md-12 col-sm-12 col-lg-12 col-xs-12" => 1,
				"col-md-6 col-sm-6 col-lg-6 col-xs-12" => 2,
				"col-md-4 col-sm-4 col-lg-4 col-xs-12" => 3,
				"col-md-3 col-sm-3 col-lg-3 col-xs-12" => 4,
				"col-sm-2" => 5,
				"col-md-2 col-sm-2 col-lg-2 col-xs-12" => 6,
				
		);				

        ?>
     
		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','best-shop'  ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'colums' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>		

		<p>
		<label for="<?php echo esc_attr($this->get_field_id('colums')); ?>"><?php esc_html_e('Number of colums:', 'best-shop'); ?></label> 
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id('colums')); ?>" name="<?php echo esc_attr($this->get_field_name('colums')); ?>" type="text">
		<?php
				foreach ($product_colums as $key => $value) {
						if ($key == $colums) {
								echo '<option value="' . esc_attr($key) . '" Selected=selected>' . esc_html($value) . '</option>';
						}
						else {
								echo '<option value="' . esc_attr($key) . '" >' . esc_html($value) . '</option>';
						}
				}
		?>
		</select>
		</p>
		
		<?php 
		}

public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '' ;
		$instance['colums'] = ( ! empty( $new_instance['colums'] ) ) ? wp_strip_all_tags( $new_instance['colums'] ) : '';
		
		return $instance;
	 }
}

function best_shop_social_link_widget() {
		register_widget( 'best_shop_social_link_widget' );
}
add_action( 'widgets_init', 'best_shop_social_link_widget' );