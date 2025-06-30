<?php
/**
 * Newsletter Settings
 * 
 * @package Best_Shop
 */
if( ! function_exists( 'best_shop_newsletter_frontpage_settings' ) ) :

function best_shop_newsletter_frontpage_settings( $wp_customize ){
    
	$wp_customize->add_section( 'best_shop_newsletter', 
	    array(
	        'title'         => esc_html__( 'Newsletter Section', 'best-shop' ),
	        'priority'      => 30,
	        'panel'         => 'frontpage_settings'
	    ) 
	);

    /** Hide Newsletter Section */
    $wp_customize->add_setting( 
        'enable_newsletter_section', 
        array(
            'default'           => best_shop_default_settings('enable_newsletter_section'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox'
        ) 
    );

    $wp_customize->add_control(
        new best_shop_Toggle_Control( 
            $wp_customize,
            'enable_newsletter_section',
            array(
                'section'     => 'best_shop_newsletter',
                'label'	      => esc_html__( 'Hide Newsletter Section', 'best-shop' ),
                'description' => esc_html__( 'Enable to hide newsletter section.', 'best-shop' ),
            )
        )
    );

    $wp_customize->add_setting(
        'newsletter_shortcode',
        array(
            'default'           => best_shop_default_settings('newsletter_shortcode'),
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $wp_customize->add_control(
        'newsletter_shortcode',
        array(
            'label'             => esc_html__( 'Newsletter Shortcode', 'best-shop' ),
            'description'       => esc_html__( 'Please download Blossom Themes Email Newsletter and place the shortcode for newsletter section', 'best-shop' ),
            'type'              => 'text',
            'section'           => 'best_shop_newsletter',
        )
    );
}
endif;
add_action( 'customize_register', 'best_shop_newsletter_frontpage_settings' );