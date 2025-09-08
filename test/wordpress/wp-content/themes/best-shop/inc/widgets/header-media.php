<?php
/* 
 * display product grid from given product category
 */

class best_shop_header_media_widget extends WP_Widget {

function __construct() {
		
		parent::__construct(
		  
		// Base ID of your widget
		'best_shop_header_media_widget', 
		  
		// Widget name will appear in UI
		__('+ Header Media Banner', 'best-shop'), 
		  
		// Widget description
		array( 'description' => __( 'Display a banner with Header Media (Image or Video)', 'best-shop' ), ) 
		);    
}

public function widget( $args, $instance ) {
    
    
    $banner_title = ( ! empty( $instance['banner_title'] ) ) ? wp_strip_all_tags( $instance['banner_title'] ) : '';
    $banner_desc = ( ! empty( $instance['banner_content'] ) ) ? wp_strip_all_tags( $instance['banner_content'] ) : '';
    $btn_one = ( ! empty( $instance['banner_btn_label'] ) ) ? wp_strip_all_tags( $instance['banner_btn_label'] ) : '';
    $btn_one_url = ( ! empty( $instance['banner_link'] ) ) ? wp_strip_all_tags( $instance['banner_link'] ) : '';
    $btn_two = ( ! empty( $instance['banner_btn_two_label'] ) ) ? wp_strip_all_tags( $instance['banner_btn_two_label'] ) : '';
    $btn_two_url = ( ! empty( $instance['banner_btn_two_link'] ) ) ? wp_strip_all_tags( $instance['banner_btn_two_link'] ) : '';
    


    ?>
        <section id="banner_section" class="site-banner<?php if( has_header_video() ) echo esc_attr( ' video-banner' ); ?>">
            <div class="static-banner header-media">
                <div class="banner-wrapper">
                    <div class="banner-image-wrapper">
                        <?php the_custom_header_markup(); ?>
                    </div>                     
                    <?php if( $banner_title || $banner_desc || $btn_one || $btn_two ) { ?> 
                        <div class="container">
                            <div class="banner-details-wrapper">
                                <div class="container">
                                    <div class="overlay-details">
                                        <?php if( $banner_title ) { ?>
                                            <h2 class="item-title">
                                                <?php echo esc_html( $banner_title ); ?>
                                            </h2>
                                        <?php } if( $banner_desc ) { ?>
                                            <div class="banner-desc">
                                                <?php echo wp_kses_post( wpautop( $banner_desc ) ); ?>
                                            </div>
                                        <?php } if ( $btn_one || $btn_two) { ?>
                                            <div class="button-wrap">
                                                <?php if( $btn_one && $btn_one_url ) { ?>
                                                    <a href="<?php echo esc_url( $btn_one_url ); ?>" class="primary-btn"><?php echo esc_html( $btn_one ); ?></a>
                                                <?php } if( $btn_two && $btn_two_url ) { ?>
                                                    <a href="<?php echo esc_url( $btn_two_url ); ?>" class="primary-btn secondary-btn"><?php echo esc_html( $btn_two ); ?></a>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <!-- section banner ends  -->



<?php

}
		
public function form( $instance ) {
    
    $banner_title = ( ! empty( $instance['banner_title'] ) ) ? wp_strip_all_tags( $instance['banner_title'] ) : '';
    $banner_content = ( ! empty( $instance['banner_content'] ) ) ? wp_strip_all_tags( $instance['banner_content'] ) : '';
    $banner_btn_label = ( ! empty( $instance['banner_btn_label'] ) ) ? wp_strip_all_tags( $instance['banner_btn_label'] ) : '';
    $banner_link = ( ! empty( $instance['banner_link'] ) ) ? wp_strip_all_tags( $instance['banner_link'] ) : '';
    $banner_btn_two_label = ( ! empty( $instance['banner_btn_two_label'] ) ) ? wp_strip_all_tags( $instance['banner_btn_two_label'] ) : '';
    $banner_btn_two_link = ( ! empty( $instance['banner_btn_two_link'] ) ) ? wp_strip_all_tags( $instance['banner_btn_two_link'] ) : '';

    
     ?>

    <p>
        <?php echo esc_html__('Display header media as a banner. Change header image or video Go to:- Appearance -> Customize -> Header Media', 'best-shop'); ?>
    </p>

    <p>
    <label for="<?php echo esc_attr($this->get_field_id( 'banner_title' )); ?>"><?php esc_html_e( 'Banner Title:', 'best-shop'  ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'banner_title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'banner_title' )); ?>" type="text" value="<?php echo esc_attr( $banner_title ); ?>" />
    </p>


    <p>
    <label for="<?php echo esc_attr($this->get_field_id( 'banner_content' )); ?>"><?php esc_html_e( 'Banner Content:', 'best-shop'  ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'banner_content' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'banner_content' )); ?>" type="text" value="<?php echo esc_attr( $banner_content ); ?>" />
    </p>


    <p>
    <label for="<?php echo esc_attr($this->get_field_id( 'banner_btn_label' )); ?>"><?php esc_html_e( 'Button Label:', 'best-shop'  ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'banner_btn_label' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'banner_btn_label' )); ?>" type="text" value="<?php echo esc_attr( $banner_btn_label ); ?>" />
    </p>


    <p>
    <label for="<?php echo esc_attr($this->get_field_id( 'banner_link' )); ?>"><?php esc_html_e( 'Banner Link:', 'best-shop'  ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'banner_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'banner_link' )); ?>" type="text" value="<?php echo esc_attr( $banner_link ); ?>" />
    </p>


    <p>
    <label for="<?php echo esc_attr($this->get_field_id( 'banner_btn_two_label' )); ?>"><?php esc_html_e( 'Button Two Label:', 'best-shop'  ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'banner_btn_two_label' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'banner_btn_two_label' )); ?>" type="text" value="<?php echo esc_attr( $banner_btn_two_label ); ?>" />
    </p>



    <p>
    <label for="<?php echo esc_attr($this->get_field_id( 'banner_btn_two_link' )); ?>"><?php esc_html_e( 'Button Two Link:', 'best-shop'  ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'banner_btn_two_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'banner_btn_two_link' )); ?>" type="text" value="<?php echo esc_attr( $banner_btn_two_link ); ?>" />
    </p>

    <?php 
    }

public function update( $new_instance, $old_instance ) {

		$instance = array();
    
        $instance['banner_title'] = ( ! empty( $new_instance['banner_title'] ) ) ? wp_strip_all_tags( $new_instance['banner_title'] ) : '';
        $instance['banner_content'] = ( ! empty( $new_instance['banner_content'] ) ) ? wp_strip_all_tags( $new_instance['banner_content'] ) : '';
        $instance['banner_btn_label'] = ( ! empty( $new_instance['banner_btn_label'] ) ) ? wp_strip_all_tags( $new_instance['banner_btn_label'] ) : '';
        $instance['banner_link'] = ( ! empty( $new_instance['banner_link'] ) ) ? wp_strip_all_tags( $new_instance['banner_link'] ) : '';
        $instance['banner_btn_two_label'] = ( ! empty( $new_instance['banner_btn_two_label'] ) ) ? wp_strip_all_tags( $new_instance['banner_btn_two_label'] ) : '';
        $instance['banner_btn_two_link'] = ( ! empty( $new_instance['banner_btn_two_link'] ) ) ? wp_strip_all_tags( $new_instance['banner_btn_two_link'] ) : '';
		
		
		return $instance;
	 }
}

function best_shop_header_media_widget() {
		register_widget( 'best_shop_header_media_widget' );
}
add_action( 'widgets_init', 'best_shop_header_media_widget' );