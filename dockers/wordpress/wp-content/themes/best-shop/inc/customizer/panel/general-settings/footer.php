<?php
/**
 * Footer Setting
 *
 * @package Best_Shop
 */
if( ! function_exists( 'best_shop_customize_register_footer' ) ) :

function best_shop_customize_register_footer( $wp_customize ) {
    
    /* NOTE */
     if (!function_exists('best_shop_pro_textdomain')){
          $wp_customize->add_setting( 
              'header_lbl_6', 
              array(
                  'default'           => '',
                  'sanitize_callback' => 'sanitize_text_field'
              ) 
          );
          $wp_customize->add_control( new best_shop_Notice_Control( $wp_customize, 'header_lbl_6', array(
              'label'	    => esc_html__( 'More options in Pro version: 1. Remove footer link', 'best-shop' ),
              'section' => 'footer_settings',
              'settings' => 'header_lbl_6',
          )));
     }
    
    $wp_customize->add_section(
        'footer_settings',
        array(
            'title'      => esc_html__( 'Footer Settings', 'best-shop' ),
            'priority'   => 199,
            'capability' => 'edit_theme_options',
            'panel'    => 'theme_options',

        )
    );
    
    /** Footer Copyright */
    $wp_customize->add_setting(
        'footer_copyright',
        array(
            'default'           => best_shop_default_settings('footer_copyright'),
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'footer_copyright',
        array(
            'label'       => esc_html__( 'Footer Copyright Text', 'best-shop' ),
            'section'     => 'footer_settings',
            'type'        => 'textarea',
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'footer_copyright', array(
        'selector'        => '.footer-bottom .site-info .copy-right',
        'render_callback' => 'best_shop_get_footer_copyright',
    ) );
    
    
    //Link
    
    $wp_customize->add_setting(
        'footer_link',
        array(
            'default'           => best_shop_default_settings('footer_link'),
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
    'footer_link',
    array(
        'label'       => esc_html__( 'Footer Link', 'best-shop' ),
        'section'     => 'footer_settings',
        'type'        => 'url',
        'active_callback' => 'best_shop_pro',
    )
    );

    $wp_customize->selective_refresh->add_partial( 'footer_link', array(
    'selector'        => '.footer-bottom .site-info .link',
    'render_callback' => 'best_shop_get_footer_copyright',
    
    ) );
    
    
    // Footer    
    $wp_customize->add_setting(
        'footer_color',
        array(
            'default'     => best_shop_default_settings('footer_color'),
            'transport'   => 'refresh',				
            'sanitize_callback' => 'best_shop_sanitize_rgba_color',
        )
    );

    $wp_customize->add_control(
        new Best_Shop_Alpha_Color_Control(
            $wp_customize,
            'footer_color',
            array(
                'label'         =>  __('Footer Background','best-shop' ),
                'section'       => 'footer_settings',					
                'settings'      => 'footer_color',
                'description'   =>  __('Drag alpha slider for transparency.', 'best-shop'),
                'show_opacity'  => true,
            )
        )
    );		

    
     
    // Footer text
    $wp_customize->add_setting( 
        'footer_text_color', 
        array(
            'default'           => best_shop_default_settings('footer_text_color'),
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );
    

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_text_color', array(
        'label'	    => esc_html__( 'Footer Text Color', 'best-shop' ),
        'section' => 'footer_settings',
        'settings' => 'footer_text_color'
 
    )));   
    
    

     /*-------------
     * BG IMAGE 
     ---------------*/    
    $wp_customize->add_setting( 'footer_img', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw'
    ));
 
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_img', array(
        'label' => __( 'Add Background Image' , 'best-shop'),
        'section' => 'footer_settings',
        'settings' => 'footer_img',
        'button_labels' => array(// All These labels are optional
                    'select' => __( 'Select Image' , 'best-shop'),
                    'remove' => __( 'Remove Image' , 'best-shop'),
                    'change' => __( 'Change Image' , 'best-shop'),
                    )
    )));
    
    
  /** Footer colums */
  $wp_customize->add_setting(
      'footer_num_of_colums',
      array(
          'default'           => best_shop_default_settings('footer_num_of_colums'),
          'sanitize_callback' => 'absint',
          'transport'         => 'postMessage'
      )
  );

  $wp_customize->add_control(
      'footer_num_of_colums',
      array(
          'label'       => esc_html__( 'Number of Colums in Footer', 'best-shop' ),
          'description' => __( 'Delete widgets from right to left/bottom to top in order to hide extra colums.' , 'best-shop' ),
          'section'     => 'footer_settings',
          'type'        => 'number',
          'input_attrs' => array(
            'min' => 1,
            'max' => 4
          )
      )
  );

    

        
}
endif;
add_action( 'customize_register', 'best_shop_customize_register_footer' );



