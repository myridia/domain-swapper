<?php
/**
 * Front Page Settings
 * 
 * @package Best_Shop
 */
if ( ! function_exists( 'best_shop_customize_register_frontpage' ) ) :

function best_shop_customize_register_frontpage( $wp_customize ) {
	
    /** Front Page Settings */
    $wp_customize->add_panel( 
        'frontpage_settings',
         array(
            'priority'    => 40,
            'capability'  => 'edit_theme_options',
            'title'       => esc_html__( 'Front Page Settings', 'best-shop' ),
            'description' => esc_html__( 'Static Home Page settings.', 'best-shop' ),
        )
    );    
      
}
endif;
add_action( 'customize_register', 'best_shop_customize_register_frontpage' );