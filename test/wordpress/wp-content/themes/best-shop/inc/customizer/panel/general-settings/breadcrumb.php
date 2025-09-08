<?php
/**
 * SEO Settings
 *
 * @package Best_Shop
 */
if( ! function_exists( 'best_shop_customize_register_general_seo' ) ) :

function best_shop_customize_register_general_seo( $wp_customize ) {
    
    /* NOTE */
     if (!function_exists('best_shop_pro_textdomain')){
          $wp_customize->add_setting( 
              'header_lbl_3', 
              array(
                  'default'           => '',
                  'sanitize_callback' => 'sanitize_text_field'
              ) 
          );
          $wp_customize->add_control( new best_shop_Notice_Control( $wp_customize, 'header_lbl_3', array(
              'label'	    => esc_html__( 'More options in Pro version: 1. Edit breadcrumb home text ', 'best-shop' ),
              'section' => 'seo_settings',
              'settings' => 'header_lbl_3',
          )));
     }
    
    
    /** SEO Settings */
    $wp_customize->add_section(
        'seo_settings',
        array(
            'title'    => esc_html__( 'Breadcrumb Settings', 'best-shop' ),
            'priority' => 40,
            'panel'    => 'theme_options',
        )
    );
    
    $wp_customize->add_setting( 
        'enable_breadcrumb', 
        array(
            'default'           => best_shop_default_settings('enable_breadcrumb'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new best_shop_Toggle_Control( 
			$wp_customize,
			'enable_breadcrumb',
			array(
				'section'     => 'seo_settings',
				'label'	      => esc_html__( 'Enable Breadcrumb', 'best-shop' ),
                'description' => esc_html__( 'Show breadcrumb in inner pages.', 'best-shop' ),
			)
		)
	);
    
    /** Breadcrumb Home Text */
    $wp_customize->add_setting(
        'home_text',
        array(
            'default'           => best_shop_default_settings('home_text'),
            'sanitize_callback' => 'sanitize_text_field' 
        )
    );
    
    $wp_customize->add_control(
        'home_text',
        array(
            'type'    => 'text',
            'section' => 'seo_settings',
            'label'   => esc_html__( 'Breadcrumb Home Text', 'best-shop' ),
            'active_callback'   => 'best_shop_pro',
        )
    );  
    /** SEO Settings Ends */
    
}
endif;
add_action( 'customize_register', 'best_shop_customize_register_general_seo' );