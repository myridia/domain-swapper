<?php
/**
 * Social Settings
 *
 * @package Best_Shop
 */
if( ! function_exists( 'best_shop_customize_register_social_links' ) ) :

function best_shop_customize_register_social_links( $wp_customize ) {
    
    /* NOTE */
     if (!function_exists('best_shop_pro_textdomain')){
          $wp_customize->add_setting( 
              'header_lbl_2', 
              array(
                  'default'           => '',
                  'sanitize_callback' => 'sanitize_text_field'
              ) 
          );
          $wp_customize->add_control( new best_shop_Notice_Control( $wp_customize, 'header_lbl_2', array(
              'label'	    => esc_html__( 'More options in Pro version: 1. Edit top bar background/Text color ', 'best-shop' ),
              'section' => 'header_top',
              'settings' => 'header_lbl_2',
          )));
     }
    
    
    /** Enable top bar */    
    $wp_customize->add_setting( 
        'enable_top_bar', 
        array(
            'default'           => best_shop_default_settings('enable_top_bar'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new best_shop_Toggle_Control( 
			$wp_customize,
			'enable_top_bar',
			array(
				'section'     => 'header_top',
				'label'	      => esc_html__( 'Enable Top Bar', 'best-shop' ),
                'description' => esc_html__( 'Enable to show top bar above header.', 'best-shop' ),
			)
		)
	);
    
    
    // top bar bgcolor
    $wp_customize->add_setting( 
        'topbar_bg_color', 
        array(
            'default'           => best_shop_default_settings('topbar_bg_color'),
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );
    

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'topbar_bg_color', array(
        'label'	    => esc_html__( 'Top bar Background Color', 'best-shop' ),
        'section' => 'header_top',
        'settings' => 'topbar_bg_color',
        'active_callback'   => 'best_shop_pro',
 
    )));
    
    // top bar text color
    $wp_customize->add_setting( 
        'topbar_text_color', 
        array(
            'default'           => best_shop_default_settings('topbar_text_color'),
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );
    

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'topbar_text_color', array(
        'label'	    => esc_html__( 'Top bar Text Color', 'best-shop' ),
        'section' => 'header_top',
        'settings' => 'topbar_text_color',
        'active_callback'   => 'best_shop_pro',
 
    )));


    /*--------------------------
     * SOCIAL LINKS SECTION
     --------------------------*/
    
    $wp_customize->add_section(
        'header_top',
        array(
            'panel'     => 'theme_options',
            'title'     => esc_html__( 'Top Bar/Social', 'best-shop' ),
            'priority'  => 10,
        )
    );
    

    /** 
     * Social Share Repeater 
     * */
    $wp_customize->add_setting( 
        new best_shop_Repeater_Setting( 
            $wp_customize, 
            'social_links', 
            array(
                'default' => best_shop_default_settings('social_links'),
                'sanitize_callback' => array( 'best_shop_Repeater_Setting', 'sanitize_repeater_setting' ),
            ) 
        ) 
    );
    
    $wp_customize->add_control(
		new best_shop_Control_Repeater(
			$wp_customize,
			'social_links',
			array(
				'section' => 'header_top',
				'label'   => esc_html__( 'Social Links', 'best-shop' ),
				'fields'  => array(
                    'best_shop_icon' => array(
                        'type'        => 'select',
                        'label'       => esc_html__( 'Social Media', 'best-shop' ),
                        'choices'     => best_shop_get_svg_icons()
                    ),
                    'best_shop_link' => array(
                        'type'        => 'url',
                        'label'       => esc_html__( 'Link', 'best-shop' ),
                        'description' => esc_html__( 'Example: https://facebook.com', 'best-shop' ),
                    ),
                    'best_shop_checkbox' => array(
                        'type'        => 'checkbox',
                        'label'       => esc_html__( 'Open link in new tab', 'best-shop' ),
                    )
                ),
                'row_label' => array(
                    'type'  => 'field',
                    'value' => esc_html__( 'links', 'best-shop' ),
                    'field' => 'link'
                )                        
			)
		)
	);
    
        
    $wp_customize->selective_refresh->add_partial( 'social_links', array(
	'selector' => '#masthead .social-links',
    ) );

    /*--------------------------
     * SOCIAL LINKS SECTION END
     --------------------------*/
    
    
    
    // Left Content
    $wp_customize->add_setting( 'top_bar_left_content', array(
          'capability' => 'edit_theme_options',
          'default' => best_shop_default_settings('top_bar_left_content'),
          'sanitize_callback' => 'best_shop_sanitize_radio',
    ) );

    $wp_customize->add_control( 'top_bar_left_content', array(
          'type' => 'radio',
          'section' => 'header_top', // Add a default or your own section
          'label' => esc_html__( 'Top Bar Left' ,'best-shop' ),
          'description' => esc_html__( 'Select Top Bar Left Content, You can edit menus from customizer menus section or dashboard. ', 'best-shop' ),
          'choices' => array(
              'none' => esc_html__( 'None' , 'best-shop'),
              'text' => esc_html__( 'Text' , 'best-shop'),
              'menu' => esc_html__( 'Menu (edit menus from customizer menus section )' , 'best-shop'),
              'contacts' => esc_html__( 'Contacts (edit contacts from contacts section )' , 'best-shop'),            
          ),
        
          'active_callback' => 'best_shop_is_top_bar_enabled',   
        
    ) );
    
    $wp_customize->selective_refresh->add_partial( 'top_bar_left_content', array(
	'selector' => '#masthead .left-menu',
    ) );
    
    //check whether top bar enabled
    function best_shop_is_top_bar_enabled( $control ) {
        return ($control->manager->get_setting( 'enable_top_bar' )->value() );
    }     
    
    //check whether the text option active
    function best_shop_is_top_bar_text_enabled( $control ) {
        return ($control->manager->get_setting( 'top_bar_left_content' )->value() == 'text' && $control->manager->get_setting( 'enable_top_bar' )->value() );
    }    
    
    $wp_customize->add_setting( 'top_bar_left_text', array(
          'capability' => 'edit_theme_options',
          'default' => best_shop_default_settings('top_bar_left_text'),
          'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'top_bar_left_text', array(
        'type' => 'text',
        'section' => 'header_top', // Add a default or your own section
        'label' => __( 'Top Bar Left Text' ,'best-shop'),
        'description' => __( 'Add text to display on top bar left.' ,'best-shop'),
        'active_callback' => 'best_shop_is_top_bar_text_enabled',
    ) );
    
    
    
    
    /* 
     * Top bar right content 
     */
    
    $wp_customize->add_setting( 'top_bar_right_content', array(
          'capability' => 'edit_theme_options',
          'default' => best_shop_default_settings('top_bar_right_content'),
          'sanitize_callback' => 'best_shop_sanitize_radio',
    ) );

    $wp_customize->add_control( 'top_bar_right_content', array(
          'type' => 'radio',
          'section' => 'header_top', // Add a default or your own section
          'label' => __( 'Top Bar Right' ,'best-shop' ),
          'description' => __( 'Select Top Bar Right Content. You can edit menus from customizer menus section or dashboard.' ,'best-shop'),
          'choices' => array(
              'none' => __( 'None','best-shop' ),
              'menu' => __( 'Menu (edit menus from customizer menus section)' ,'best-shop'),
              'social' => __( 'Social (add / remove social links above)' ,'best-shop'),
              'menu_social' => __( 'Menu and Social' ,'best-shop' ),
          ),
        
          'active_callback' => 'best_shop_is_top_bar_enabled',
    ) ); 

    
}
endif;
add_action( 'customize_register', 'best_shop_customize_register_social_links' );
