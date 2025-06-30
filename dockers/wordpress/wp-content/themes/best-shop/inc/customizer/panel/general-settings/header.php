<?php
/**
 * Social Settings
 *
 * @package Best_Shop
 */
if( ! function_exists( 'best_shop_customize_register_header' ) ) :

function best_shop_customize_register_header( $wp_customize ) {
    
    /* NOTE */
     if (!function_exists('best_shop_pro_textdomain')){
          $wp_customize->add_setting( 
              'header_lbl_1', 
              array(
                  'default'           => '',
                  'sanitize_callback' => 'sanitize_text_field'
              ) 
          );
          $wp_customize->add_control( new best_shop_Notice_Control( $wp_customize, 'header_lbl_1', array(
              'label'	    => esc_html__( 'More options in Pro version: 1. WooCommerce bar background color/ Title change 2. Edit product category title 3. Disable menu search / cart icon 4. Enable/Disable wishlist,compare, my account icons ', 'best-shop' ),
              'section' => 'social_settings',
              'settings' => 'header_lbl_1',
          )));
     }
    

    /*--------------------------
     * SOCIAL LINKS SECTION
     --------------------------*/
    
    $wp_customize->add_section(
        'social_settings',
        array(
            'panel'     => 'theme_options',
            'title'         => esc_html__( 'Header Settings', 'best-shop' ),
            'priority'  => 11,
        )
    );
    
    /*----------------
     * HEADER STYLE
     -----------------*/ 
    
    $wp_customize->add_setting( 'header_layout', array(
          'capability' => 'edit_theme_options',
          'default' => best_shop_default_settings('header_layout'),
          'sanitize_callback' => 'best_shop_sanitize_radio',
    ) );
    
    
    $wp_customize->add_control( 'header_layout', array(
          'type' => 'radio',
          'section' => 'social_settings', // Add a default or your own section
          'label' => __( 'Header Style' ,'best-shop' ),
          'description' => __( 'Select Header Layout. You can customize each page header by editing each page settings.' , 'best-shop' ),
          'choices' => array(
              'default' => __( 'Default Header' , 'best-shop'),
              'woocommerce-bar' => __( 'WooCommerce Bar' , 'best-shop'),
              'transparent-header' => __( 'Transparent Header' , 'best-shop'),          
          ),
        
    ) );
    
    /*------------
     * WOO BAR COLOR
     ------------*/
    // woocommerce bar text color
    $wp_customize->add_setting( 
        'woo_bar_color', 
        array(
            'default'           => best_shop_default_settings('woo_bar_color'),
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );
    

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'woo_bar_color', array(
        'label'	    => esc_html__( 'WooCommerce Bar Text Color', 'best-shop' ),
        'section' => 'social_settings',
        'settings' => 'woo_bar_color',
    ))); 
    
    // woocommerce bar color
    $wp_customize->add_setting( 
        'woo_bar_bg_color', 
        array(
            'default'           => best_shop_default_settings('woo_bar_bg_color'),
            'sanitize_callback' => 'sanitize_hex_color',
            'active_callback'   => 'best_shop_pro',
        ) 
    );
    

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'woo_bar_bg_color', array(
        'label'	    => esc_html__( 'WooCommerce Bar Background Color', 'best-shop' ),
        'section'   => 'social_settings',
        'settings'  => 'woo_bar_bg_color',
        'active_callback'   => 'best_shop_pro',
    )));
    
    
  

    //ajax search
   //Category title
	$wp_customize->add_setting(
		'woo_ajax_search_code',
		array(
			'default'           => best_shop_default_settings('woo_ajax_search_code'),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'			=> 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		'woo_ajax_search_code',
		array(
			'section'           => 'social_settings',
			'label'             => __( 'WooCommerce AJAX search Shortcode', 'best-shop' ),
			'type'              => 'text',
            'active_callback'   => 'best_shop_pro',
		)
	);    
    

    /** Enable/ Disable WooCommerce search category ist */
    $wp_customize->add_setting( 
        'hide_product_cat_search', 
        array(
            'default'           => best_shop_default_settings('hide_product_cat_search'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox',           
        ) 
    );
    
    $wp_customize->add_control(
        new best_shop_Toggle_Control( 
            $wp_customize,
            'hide_product_cat_search',
            array(
                'section'           => 'social_settings',
                'label'	            => esc_html__( 'Hide Product Categories', 'best-shop' ),
                'description'       => esc_html__( 'Hide product categories in WooCommerce Bar Product search.', 'best-shop' ),
                'active_callback'   => 'best_shop_pro',
            )
        )
    );
    
    
    //Category search text
	$wp_customize->add_setting(
		'woo_search_text',
		array(
			'default'           => best_shop_default_settings('woo_search_text'),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'			=> 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		'woo_search_text',
		array(
			'section'           => 'social_settings',
			'label'             => __( 'WooCommerce Bar Search Text', 'best-shop' ),
			'type'              => 'text',
            'active_callback'   => 'best_shop_pro',
		)
	);
    
    $wp_customize->selective_refresh->add_partial( 'woo_search_text', array(
	'selector' => '.woocommerce-bar .product-search-form',
    ) );  

    
    
    //Category dropdown text
	$wp_customize->add_setting(
		'woo_search_dropdown_title',
		array(
			'default'           => best_shop_default_settings('woo_search_dropdown_title'),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'			=> 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		'woo_search_dropdown_title',
		array(
			'section'           => 'social_settings',
			'label'             => __( 'WooCommerce Bar Search Category Title', 'best-shop' ),
			'type'              => 'text',
            'active_callback'   => 'best_shop_pro',
		)
	);
    
    $wp_customize->selective_refresh->add_partial( 'woo_search_dropdown_title', array(
	'selector' => '.woocommerce-bar .header-search-input',
    ) );  
    
    
    
    //Category title
	$wp_customize->add_setting(
		'woo_category_title',
		array(
			'default'           => best_shop_default_settings('woo_category_title'),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'			=> 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		'woo_category_title',
		array(
			'section'           => 'social_settings',
			'label'             => __( 'WooCommerce Bar Category Menu Title', 'best-shop' ),
			'type'              => 'text',
            'active_callback'   => 'best_shop_pro',
		)
	);
    
    $wp_customize->selective_refresh->add_partial( 'woo_category_title', array(
	'selector' => '#masthead .categories-menu',
    ) );  
    
    
    /** Enable/ Disable WooCommerce search category ist */
    $wp_customize->add_setting( 
        'hide_product_cat_list', 
        array(
            'default'           => best_shop_default_settings('hide_product_cat_list'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox',           
        ) 
    );
    
    $wp_customize->add_control(
        new best_shop_Toggle_Control( 
            $wp_customize,
            'hide_product_cat_list',
            array(
                'section'           => 'social_settings',
                'label'	            => esc_html__( 'Hide Product Category Menu', 'best-shop' ),
                'description'       => esc_html__( 'Hide top product category Menu in WooCommerce options bar.', 'best-shop' ),
                'active_callback'   => 'best_shop_pro',
            )
        )
    );
    
    
    /*----------------
     * MENU STYLE
     -----------------*/ 
    
    $wp_customize->add_setting( 'menu_layout', array(
          'capability' => 'edit_theme_options',
          'default' => best_shop_default_settings('menu_layout'),
          'sanitize_callback' => 'best_shop_sanitize_radio',
    ) );
    
    
    $wp_customize->add_control( 'menu_layout', array(
          'type' => 'radio',
          'section' => 'social_settings', // Add a default or your own section
          'label' => __( 'Menu Style / Layout' ,'best-shop' ),
          'description' => __( 'Select Menu Layout. Change header text color from color section. Full with menu color can be given from below.' , 'best-shop' ),
          'choices' => array(
              'default' => __( 'Default Menu' , 'best-shop'),
              'full_width' => __( 'Full Width Menu & Top Banner' , 'best-shop'),
          ),
        
    ) );
    
    //check whether top bar enabled
    function best_shop_is_fullwidth_menu_enabled( $control ) {
        return ($control->manager->get_setting( 'menu_layout' )->value() === 'full_width' );
    } 
    
    
    // menu text color
    $wp_customize->add_setting( 
        'menu_text_color', 
        array(
            'default'           => best_shop_default_settings('menu_text_color'),
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_text_color', array(
        'label'	    => esc_html__( 'Full Wdith Menu Text Color', 'best-shop' ),
        'section' => 'social_settings',
        'settings' => 'menu_text_color',
        'active_callback' => 'best_shop_is_fullwidth_menu_enabled',
    )));
    
    // menu bg color
    $wp_customize->add_setting( 
        'menu_bg_color', 
        array(
            'default'           => best_shop_default_settings('menu_bg_color'),
            'sanitize_callback' => 'sanitize_hex_color'
        ) 
    );
    

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu_bg_color', array(
        'label'	    => esc_html__( 'Menu Background Color', 'best-shop' ),
        'section' => 'social_settings',
        'settings' => 'menu_bg_color',
        'active_callback' => 'best_shop_is_fullwidth_menu_enabled',
    )));   
    
    
     /*-------------
     * BANNER IMAGE 
     ---------------*/    
    $wp_customize->add_setting( 'header_banner_img', array(
        'capability' => 'edit_theme_options',
        //'default' => get_theme_file_uri('assets/image/logo.jpg'), // Add Default Image URL 
        'sanitize_callback' => 'esc_url_raw'
    ));
 
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_banner_img', array(
        'label' => __( 'Upload/Select Banner' , 'best-shop'),
        'section' => 'social_settings',
        'settings' => 'header_banner_img',
        'button_labels' => array(// All These labels are optional
                    'select' => __( 'Select Banner' , 'best-shop'),
                    'remove' => __( 'Remove Banner' , 'best-shop'),
                    'change' => __( 'Change Banner' , 'best-shop'),
                    ),
        'active_callback' => 'best_shop_is_fullwidth_menu_enabled',
    )));  
    
    
    //header shortcode instead of banner
  $wp_customize->add_setting(
    'header_shortcode',
    array(
      'default' => best_shop_default_settings( 'header_shortcode' ),
      'sanitize_callback' => 'sanitize_text_field',
      'transport' => 'postMessage'
    )
  );

  $wp_customize->add_control(
    'header_shortcode',
    array(
      'label' => esc_html__( 'Add Shortcode', 'best-shop' ),
      'section' => 'social_settings',
      'type' => 'text',
      'active_callback' => 'best_shop_is_fullwidth_menu_enabled',
    )
  );
    
    /** Enable Search */
    $wp_customize->add_setting( 
        'enable_search', 
        array(
            'default'           => best_shop_default_settings('enable_search'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox',
        ) 
    );
    
    $wp_customize->add_control(
        new best_shop_Toggle_Control( 
            $wp_customize,
            'enable_search',
            array(
                'section'     => 'social_settings',
                'label'	      => esc_html__( 'Enable Menu Search Icon', 'best-shop' ),
                'description' => esc_html__( 'Enable to show Search icon in Menu.', 'best-shop' ),
                'active_callback'   => 'best_shop_pro',
            )
        )
    );
    
    /** Enable mobile Search */
    $wp_customize->add_setting( 
        'enable_mobile_search', 
        array(
            'default'           => best_shop_default_settings('enable_mobile_search'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox',
        ) 
    );
    
    $wp_customize->add_control(
        new best_shop_Toggle_Control( 
            $wp_customize,
            'enable_mobile_search',
            array(
                'section'     => 'social_settings',
                'label'	      => esc_html__( 'Enable Search on Mobile', 'best-shop' ),
                'description' => esc_html__( 'Enable to show Search icon in Menu.', 'best-shop' ),
                'active_callback'   => 'best_shop_pro',
            )
        )
    );
    
    
    /** Enable cart */
    $wp_customize->add_setting( 
        'enable_cart_icon', 
        array(
            'default'           => best_shop_default_settings('enable_cart_icon'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox',
        ) 
    );
    
    $wp_customize->add_control(
        new best_shop_Toggle_Control( 
            $wp_customize,
            'enable_cart_icon',
            array(
                'section'     => 'social_settings',
                'label'	      => esc_html__( 'Enable Cart Icon on WooCommerce bar', 'best-shop' ),
                'description' => esc_html__( 'Enable cart icon on WooCommerce options bar.', 'best-shop' ),
                'active_callback'   => 'best_shop_pro',
            )
        )
    );
    
    /** Enable cart in menu */
    $wp_customize->add_setting( 
        'enable_cart_icon_in_menu', 
        array(
            'default'           => best_shop_default_settings('enable_cart_icon_in_menu'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox',
            'active_callback'   => 'best_shop_pro',
            
        ) 
    );
    
    $wp_customize->add_control(
        new best_shop_Toggle_Control( 
            $wp_customize,
            'enable_cart_icon_in_menu',
            array(
                'section'     => 'social_settings',
                'label'	      => esc_html__( 'Enable Cart Icon on Menu', 'best-shop' ),
                'description' => esc_html__( 'Enable cart icon on Menu.', 'best-shop' ),
                'active_callback'   => 'best_shop_pro',
            )
        )
    );    
    
      /** Enable My account */
    $wp_customize->add_setting( 
        'enable_myaccount_icon', 
        array(
            'default'           => best_shop_default_settings('enable_myaccount_icon'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox',
        ) 
    );
    
    $wp_customize->add_control(
        new best_shop_Toggle_Control( 
            $wp_customize,
            'enable_myaccount_icon',
            array(
                'section'     => 'social_settings',
                'label'	      => esc_html__( 'Enable My Account Icon', 'best-shop' ),
                'description' => esc_html__( 'Enable my account on WooCommerce options bar', 'best-shop' ),
                'active_callback'   => 'best_shop_pro',
            )
        )
    );
    
    
      /** Enable wishlist */
    $wp_customize->add_setting( 
        'enable_wishlist_icon', 
        array(
            'default'           => best_shop_default_settings('enable_wishlist_icon'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox',
        ) 
    );
    
    $wp_customize->add_control(
        new best_shop_Toggle_Control( 
            $wp_customize,
            'enable_wishlist_icon',
            array(
                'section'     => 'social_settings',
                'label'	      => esc_html__( 'Enable Wishlist Icon', 'best-shop' ),
                'description' => esc_html__( 'Enable wishlist on WooCommerce options bar', 'best-shop' ),
                'active_callback'   => 'best_shop_pro',
            )
        )
    );
    
    
      /** Enable compare */
    $wp_customize->add_setting( 
        'enable_compare_icon', 
        array(
            'default'           => best_shop_default_settings('enable_compare_icon'),
            'sanitize_callback' => 'best_shop_sanitize_checkbox',
        ) 
    );
    
    $wp_customize->add_control(
        new best_shop_Toggle_Control( 
            $wp_customize,
            'enable_compare_icon',
            array(
                'section'     => 'social_settings',
                'label'	      => esc_html__( 'Enable Compare Icon', 'best-shop' ),
                'description' => esc_html__( 'Enable wishlist on WooCommerce options bar', 'best-shop' ),
                'active_callback'   => 'best_shop_pro',
            )
        )
    );
    
}
endif;
add_action( 'customize_register', 'best_shop_customize_register_header' );
