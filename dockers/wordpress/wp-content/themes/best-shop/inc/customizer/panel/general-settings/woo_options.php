<?php
/**
 * SEO Settings
 *
 * @package Best_Shop
 */
if( ! function_exists( 'best_shop_customize_register_woo' ) ) :

function best_shop_customize_register_woo( $wp_customize ) {
    
    /* NOTE */
     if (!function_exists('best_shop_pro_textdomain')){
          $wp_customize->add_setting( 
              'header_lbl_11', 
              array(
                  'default'           => '',
                  'sanitize_callback' => 'sanitize_text_field'
              ) 
          );
          $wp_customize->add_control( new best_shop_Notice_Control( $wp_customize, 'header_lbl_11', array(
              'label'	    => esc_html__( 'More options in Pro version: 1. Disable category prefix in title', 'best-shop' ),
              'section' => 'woo_settings',
              'settings' => 'header_lbl_11',
          )));
     }
    
    /** Scroll Settings */
    $wp_customize->add_section(
        'woo_settings',
        array(
            'title'    => esc_html__( 'WooCommerce', 'best-shop' ),
            'priority' => 50,
            'panel'    => 'theme_options',
        )
    );
    
    $wp_customize->add_setting( 
        'woo_hide_category_prefix', 
        array(
            'default'           => best_shop_default_settings('woo_hide_category_prefix'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new best_shop_Toggle_Control( 
			$wp_customize,
			'woo_hide_category_prefix',
			array(
				'section'     => 'woo_settings',
				'label'	      => esc_html__( 'Disable category prefix in titles.', 'best-shop' ),
                'description' => esc_html__( 'Disable category prefix in titles.', 'best-shop' ),
                'active_callback'   => 'best_shop_pro',
			)
		)
	);
    

    
    
}
endif;

add_action( 'customize_register', 'best_shop_customize_register_woo' );