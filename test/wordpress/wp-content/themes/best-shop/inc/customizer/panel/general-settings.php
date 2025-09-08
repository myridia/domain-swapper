<?php
/**
 * General Settings
 * 
 * @package Best_Shop
 */
if( ! function_exists( 'best_shop_customize_register_theme_options' ) ) :
    
function best_shop_customize_register_theme_options( $wp_customize ) {
	
    /** General Settings Settings */
    $wp_customize->add_panel( 
        'theme_options',
            array(
            'priority'    => 6,
            'capability'  => 'edit_theme_options',
            'title'       => esc_html__( 'THEME OPTIONS', 'best-shop' ),
        ) 
    );    
 
}
endif;
add_action( 'customize_register', 'best_shop_customize_register_theme_options' );