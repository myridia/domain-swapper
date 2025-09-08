<?php
/**
 * Layout Settings
 *
 * @package Best_Shop
 */
if ( ! function_exists( 'best_shop_customize_register_layout' ) ) :

function best_shop_customize_register_layout( $wp_customize ) {
    
    /** Layout Settings */
    $wp_customize->add_section( 
        'layout_settings',
         array(
            'priority'    => 45,
            'capability'  => 'edit_theme_options',
            'title'       => esc_html__( 'Layout Settings', 'best-shop' ),
            'description' => esc_html__( 'Change different page layouts and container width from here.', 'best-shop' ),
            'panel'    => 'theme_options',
        ) 
    );
    
    
     $wp_customize->add_setting( 
        'layout_width', 
        array(
            'default'           => best_shop_default_settings('layout_width'),
            'sanitize_callback' => 'best_shop_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(          
        'layout_width',
        array(
            'section'     => 'layout_settings',
            'label'       => esc_html__( 'Content Width (px)', 'best-shop' ),
            'type'        => 'number',
            'input_attrs'     => array(
                'min'   => 840,
                'max'   => 3600,
                'step'  => 10,
            )                 
        )
    );   
    
   /** Woo Sidebar layout */
    $wp_customize->add_setting( 
        'woo_sidebar_layout', 
        array(
            'default'           => best_shop_default_settings('woo_sidebar_layout'),
            'sanitize_callback' => 'best_shop_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
		new best_shop_Radio_Image_Control(
			$wp_customize,
			'woo_sidebar_layout',
			array(
				'section'	  => 'layout_settings',
				'label'		  => esc_html__( 'WooCommerce Sidebar Layout (General)', 'best-shop' ),
				'description' => esc_html__( 'This is the WooCommerce generl sidebar layout for pages.', 'best-shop' ),
				'choices'	  => array(
					'no-sidebar'    => get_template_directory_uri() . '/images/sidebar/general-full.jpg',
					'left-sidebar'  => get_template_directory_uri() . '/images/sidebar/general-left.jpg',
                    'right-sidebar' => get_template_directory_uri() . '/images/sidebar/general-right.jpg',
				)
			)
		)
	);
    
    
   /** Product Sidebar layout */
    $wp_customize->add_setting( 
        'product_sidebar_layout', 
        array(
            'default'           => best_shop_default_settings('product_sidebar_layout'),
            'sanitize_callback' => 'best_shop_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
		new best_shop_Radio_Image_Control(
			$wp_customize,
			'product_sidebar_layout',
			array(
				'section'	  => 'layout_settings',
				'label'		  => esc_html__( 'WooCommerce Single Product Sidebar Layout', 'best-shop' ),
				'description' => esc_html__( 'This is the WooCommerce single product page layout.', 'best-shop' ),
				'choices'	  => array(
					'no-sidebar'    => get_template_directory_uri() . '/images/sidebar/general-full.jpg',
					'left-sidebar'  => get_template_directory_uri() . '/images/sidebar/general-left.jpg',
                    'right-sidebar' => get_template_directory_uri() . '/images/sidebar/general-right.jpg',
				)
			)
		)
	);
    
    
   /** checkout Sidebar layout */
    $wp_customize->add_setting( 
        'checkout_sidebar_layout', 
        array(
            'default'           => best_shop_default_settings('checkout_sidebar_layout'),
            'sanitize_callback' => 'best_shop_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
		new best_shop_Radio_Image_Control(
			$wp_customize,
			'checkout_sidebar_layout',
			array(
				'section'	  => 'layout_settings',
				'label'		  => esc_html__( 'WooCommerce Checkout Page Sidebar Layout', 'best-shop' ),
				'description' => esc_html__( 'This is the WooCommerce checkout page layout.', 'best-shop' ),
				'choices'	  => array(
					'no-sidebar'    => get_template_directory_uri() . '/images/sidebar/general-full.jpg',
					'left-sidebar'  => get_template_directory_uri() . '/images/sidebar/general-left.jpg',
                    'right-sidebar' => get_template_directory_uri() . '/images/sidebar/general-right.jpg',
				)
			)
		)
	);


    /** Page Sidebar layout */
    $wp_customize->add_setting( 
        'page_sidebar_layout', 
        array(
            'default'           => best_shop_default_settings('page_sidebar_layout'),
            'sanitize_callback' => 'best_shop_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
		new best_shop_Radio_Image_Control(
			$wp_customize,
			'page_sidebar_layout',
			array(
				'section'	  => 'layout_settings',
				'label'		  => esc_html__( 'Page Sidebar Layout', 'best-shop' ),
				'description' => esc_html__( 'This is the general sidebar layout for pages. You can override the sidebar layout in page editor.', 'best-shop' ),
				'choices'	  => array(
					'no-sidebar'    => get_template_directory_uri() . '/images/sidebar/general-full.jpg',
					'left-sidebar'  => get_template_directory_uri() . '/images/sidebar/general-left.jpg',
                    'right-sidebar' => get_template_directory_uri() . '/images/sidebar/general-right.jpg',
				)
			)
		)
	);
    
    /** Post Sidebar layout */
    $wp_customize->add_setting( 
        'post_sidebar_layout', 
        array(
            'default'           => best_shop_default_settings('post_sidebar_layout'),
            'sanitize_callback' => 'best_shop_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
		new best_shop_Radio_Image_Control(
			$wp_customize,
			'post_sidebar_layout',
			array(
				'section'	  => 'layout_settings',
				'label'		  => esc_html__( 'Post Sidebar Layout', 'best-shop' ),
				'description' => esc_html__( 'This is the general sidebar layout for posts & custom post. You can override the sidebar layout in post editor.', 'best-shop' ),
				'choices'	  => array(
					'no-sidebar'    => get_template_directory_uri() . '/images/sidebar/general-full.jpg',
					'left-sidebar'  => get_template_directory_uri() . '/images/sidebar/general-left.jpg',
                    'right-sidebar' => get_template_directory_uri() . '/images/sidebar/general-right.jpg',
				)
			)
		)
	);
    
    /** Post Sidebar layout */
    $wp_customize->add_setting( 
        'layout_style', 
        array(
            'default'           => best_shop_default_settings('layout_style'),
            'sanitize_callback' => 'best_shop_sanitize_radio'
        ) 
    );
    
    $wp_customize->add_control(
		new best_shop_Radio_Image_Control(
			$wp_customize,
			'layout_style',
			array(
				'section'	  => 'layout_settings',
				'label'		  => esc_html__( 'Default / Archive Sidebar Layout', 'best-shop' ),
				'description' => esc_html__( 'This is the general sidebar layout for whole site.', 'best-shop' ),
				'choices'	  => array(
					'no-sidebar'    => get_template_directory_uri() . '/images/sidebar/general-full.jpg',
                    'left-sidebar'  => get_template_directory_uri() . '/images/sidebar/general-left.jpg',
                    'right-sidebar' => get_template_directory_uri() . '/images/sidebar/general-right.jpg',
				)
			)
		)
	);
    

    
}
endif;
add_action( 'customize_register', 'best_shop_customize_register_layout' );