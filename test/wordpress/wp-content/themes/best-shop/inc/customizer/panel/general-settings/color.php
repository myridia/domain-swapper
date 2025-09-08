<?php
/**
 * Color Settings
 *
 * @package Best_Shop
 */
if( ! function_exists( 'best_shop_customize_register_color' ) ) :

function best_shop_customize_register_color( $wp_customize ) {
    
    // primary
    $wp_customize->add_setting( 
        'logo_width', 
        array(
            'default'           => best_shop_default_settings('logo_width'),
            'sanitize_callback' => 'absint'
        ) 
    );
    

    $wp_customize->add_control( 'logo_width', array(
        'label'	    => esc_html__( 'Logo Maximum Width', 'best-shop' ),
        'type' => 'number',
        'section' => 'title_tagline',
        'settings' => 'logo_width',
 
    ));
    
    
    // text
    $wp_customize->add_setting( 
        'text_color', 
        array(
            'default'           => best_shop_default_settings('text_color'),
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );
    

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_color', array(
        'label'	    => esc_html__( 'Site Text Color', 'best-shop' ),
        'section' => 'colors',
        'settings' => 'text_color'
 
    )));
    
    
    
    // primary
    $wp_customize->add_setting( 
        'primary_color', 
        array(
            'default'           => best_shop_default_settings('primary_color'),
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );
    

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'primary_color', array(
        'label'	    => esc_html__( 'Site Primary Color', 'best-shop' ),
        'section' => 'colors',
        'settings' => 'primary_color',
        'active_callback' => 'best_shop_pro', 
    )));
    
    // secondary
    $wp_customize->add_setting( 
        'secondary_color', 
        array(
            'default'           => best_shop_default_settings('secondary_color'),
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );
    

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'secondary_color', array(
        'label'	    => esc_html__( 'Secondary Color', 'best-shop' ),
        'section' => 'colors',
        'settings' => 'secondary_color'
 
    ))); 
    
    
    /** Note */
    $wp_customize->add_setting(
        'color_notice',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new best_shop_Notice_Control( 
            $wp_customize,
            'color_notice',
            array(
                'section'	  => 'colors',
                'label'       => esc_html__( 'Header, Top bar and Footer color can be changed from each sections in Theme Options ', 'best-shop' ),
                'description' => '',
            )
        )
    );
    
    
    
}
endif;
add_action( 'customize_register', 'best_shop_customize_register_color' );