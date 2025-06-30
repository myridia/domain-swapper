<?php
/**
 * SEO Settings
 *
 * @package Best_Shop
 */
if( ! function_exists( 'best_shop_customize_register_scroll' ) ) :

function best_shop_customize_register_scroll( $wp_customize ) {
    
    /* NOTE */
     if (!function_exists('best_shop_pro_textdomain')){
          $wp_customize->add_setting( 
              'header_lbl_5', 
              array(
                  'default'           => '',
                  'sanitize_callback' => 'sanitize_text_field'
              ) 
          );
          $wp_customize->add_control( new best_shop_Notice_Control( $wp_customize, 'header_lbl_5', array(
              'label'	    => esc_html__( 'More options in Pro version: 1. Sticky menu 2. Pop-up add to cart button', 'best-shop' ),
              'section' => 'scroll_settings',
              'settings' => 'header_lbl_5',
          )));
     }
    
    /** Scroll Settings */
    $wp_customize->add_section(
        'scroll_settings',
        array(
            'title'    => esc_html__( 'Scroll', 'best-shop' ),
            'priority' => 60,
            'panel'    => 'theme_options',
        )
    );
    
    $wp_customize->add_setting( 
        'enable_sticky_menu', 
        array(
            'default'           => best_shop_default_settings('enable_sticky_menu'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new best_shop_Toggle_Control( 
			$wp_customize,
			'enable_sticky_menu',
			array(
				'section'     => 'scroll_settings',
				'label'	      => esc_html__( 'Enable Sticky Menu', 'best-shop' ),
                'description' => esc_html__( 'Show Sticky Meny.', 'best-shop' ),
                'active_callback'   => 'best_shop_pro',
			)
		)
	);
    
    // Back to top
    $wp_customize->add_setting( 
        'enable_back_to_top', 
        array(
            'default'           => best_shop_default_settings('enable_back_to_top'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new best_shop_Toggle_Control( 
			$wp_customize,
			'enable_back_to_top',
			array(
				'section'     => 'scroll_settings',
				'label'	      => esc_html__( 'Enable Back to Top Button', 'best-shop' ),
                'description' => esc_html__( 'Display back to top button while scroll to bottom.', 'best-shop' ),
			)
		)
	);
    
    // Popup Cart
    $wp_customize->add_setting( 
        'enable_popup_cart', 
        array(
            'default'           => best_shop_default_settings('enable_popup_cart'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new best_shop_Toggle_Control( 
			$wp_customize,
			'enable_popup_cart',
			array(
				'section'     => 'scroll_settings',
				'label'	      => esc_html__( 'Enable Popup Add to cart', 'best-shop' ),
                'description' => esc_html__( 'Display add to cart button at the end of the product page.', 'best-shop' ),
                'active_callback'   => 'best_shop_pro',
			)
		)
	);    
    
    
}
endif;
add_action( 'customize_register', 'best_shop_customize_register_scroll' );