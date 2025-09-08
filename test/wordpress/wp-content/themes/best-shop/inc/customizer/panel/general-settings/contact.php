<?php

/**
 * Contact Page Theme Option.
 * @package Best_Shop
 */
    
function best_shop_customize_register_contact_details( $wp_customize ) {
    
    
    /** contact Page Settings */
    $wp_customize->add_section( 
        'contact_page_settings',
         array(
            'priority'    => 10,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Contacts', 'best-shop' ),
            'description' => __( 'Customize contact section details', 'best-shop' ),
            'panel'    => 'theme_options',
        ) 
    );
    
    
	$wp_customize->add_setting(
		'address_title',
		array(
			'default'           => best_shop_default_settings('address_title'),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'			=> 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		'address_title',
		array(
			'section'           => 'contact_page_settings',
			'label'             => __( 'Address Title', 'best-shop' ),
			'type'              => 'text',
		)
	);


	$wp_customize->add_setting(
		'address',
		array(
			'default'           => best_shop_default_settings('address'),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'			=> 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		'address',
		array(
			'section'           => 'contact_page_settings',
			'label'             => __( 'Address', 'best-shop' ),
			'type'              => 'text',
		)
	);
    



	$wp_customize->add_setting(
		'mail_title',
		array(
			'default'           =>  best_shop_default_settings('mail_title'),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'			=> 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		'mail_title',
		array(
			'section'           => 'contact_page_settings',
			'label'             => __( 'Mail Title', 'best-shop' ),
			'type'              => 'text',
		)
	);


	$wp_customize->add_setting(
		'mail_description',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
			'transport'			=> 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		'mail_description',
		array(
			'section'           => 'contact_page_settings',
			'label'             => __( 'Email Address(es)', 'best-shop' ),
			'description'		=> __( 'Add multiple emails by seperating it with comma.', 'best-shop' ), 
			'type'              => 'text',
		)
	);

       
	$wp_customize->add_setting(
		'phone_title',
		array(
			'default'           =>  best_shop_default_settings('phone_title'),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'			=> 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		'phone_title',
		array(
			'section'           => 'contact_page_settings',
			'label'             => __( 'Phone Title', 'best-shop' ),
			'type'              => 'text',
		)
	);


	$wp_customize->add_setting(
		'phone_number',
		array(
			'default'           => best_shop_default_settings('phone_number'),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'			=> 'postMessage'
		)
	);
	
	$wp_customize->add_control(
		'phone_number',
		array(
			'section'           => 'contact_page_settings',
			'label'             => __( 'Phone Number(s)', 'best-shop' ),
			'description'       => __( 'Add multiple phone number seperating with comma', 'best-shop' ),
			'type'              => 'text',
		)
	);
    

}

add_action( 'customize_register', 'best_shop_customize_register_contact_details' );


