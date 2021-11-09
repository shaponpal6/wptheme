<?php

function firsttheme_customize_register( $wp_customize ) {

    $wp_customize->get_setting('blogname')->transport = 'postMessage';

    $wp_customize->selective_refresh->add_partial('blogname', array(
        // 'settings' => array('blogname')
        'selector' => '.c-header__blogname',
        'container_inclusive' => false,
        'render_callback' => function() {
            bloginfo( 'name' );
        }
    ));

    /*##################  SINGLE SETTINGS ########################*/

    $wp_customize->add_section('firsttheme_single_blog_options', array(
        'title' => esc_html__( 'Single Blog Options', 'firsttheme' ),
        'description' => esc_html__( 'You can change single blog options from here.', 'firsttheme' ),
        'active_callback' => 'firsttheme_show_single_blog_section'
    ));

    $wp_customize->add_setting('firsttheme_display_author_info', array(
        'default' => true,
        'transport' => 'postMessage',
        'sanitize_callback' => 'firsttheme_sanitize_checkbox'
    ));

    $wp_customize->add_control('firsttheme_display_author_info', array(
        'type' => 'checkbox',
        'label' => esc_html__( 'Show Author Info', 'firsttheme' ),
        'section' => 'firsttheme_single_blog_options'
    ));

    function firsttheme_sanitize_checkbox( $checked ) {
        return (isset($checked) && $checked === true) ? true : false;
    }

    function firsttheme_show_single_blog_section() {
        global $post;
        return is_single() && $post->post_type === 'post';
    }


    /*################## GENERAL SETTINGS ########################*/

    $wp_customize->add_section('firsttheme_general_options', array(
        'title' => esc_html__( 'General Options', 'firsttheme' ),
        'description' => esc_html__( 'You can change general options from here.', 'firsttheme' )
    ));

    $wp_customize->add_setting('firsttheme_accent_colour', array(
        'default' => '#20ddae',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'firsttheme_accent_colour', array(
        'label' => __( 'Accent Color', 'firsttheme' ),
        'section' => 'firsttheme_general_options',
    )));

    $wp_customize->add_setting( 'firsttheme_portfolio_slug', array(
		'default'           => 'portfolio',
		'transport'         => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'firsttheme_portfolio_slug', array(
		'type'    => 'text',
        'label'    => esc_html__( 'Portfolio Slug', 'firsttheme' ),
        'description' => esc_html__( 'Will appear in the archive url', 'firsttheme' ),
		'section'  => 'firsttheme_general_options',
    ));

    /*################## FOOTER SETTINGS ########################*/

    $wp_customize->selective_refresh->add_partial('firsttheme_footer_partial', array(
        'settings' => array('firsttheme_footer_bg', 'firsttheme_footer_layout'),
        'selector' => '#footer',
        'container_inclusive' => false,
        'render_callback' => function() {
            get_template_part( 'template-parts/footer/widgets' );
            get_template_part( 'template-parts/footer/info' );
        }
    ));

    $wp_customize->add_section('firsttheme_footer_options', array(
        'title' => esc_html__( 'Footer Options', 'firsttheme' ),
        'description' => esc_html__( 'You can change footer options from here.', 'firsttheme' )
    ));

    $wp_customize->add_setting('firsttheme_site_info', array(
        'default' => '',
        'sanitize_callback' => 'firsttheme_sanitize_site_info',
        'transport' => 'postMessage'
    ));

    $wp_customize->add_control('firsttheme_site_info', array(
        'type' => 'text',
        'label' => esc_html__( 'Site Info', 'firsttheme' ),
        'section' => 'firsttheme_footer_options'
    ));

    $wp_customize->add_setting('firsttheme_footer_bg', array(
        'default' => 'dark',
        'transport' => 'postMessage',
        'sanitize_callback' => 'firsttheme_sanitize_footer_bg'
    ));

    $wp_customize->add_control('firsttheme_footer_bg', array(
        'type' => 'select',
        'label' => esc_html__( 'Footer Background', 'firsttheme' ),
        'choices' => array(
            'light' => esc_html__( 'Light', 'firsttheme' ),
            'dark' => esc_html__( 'Dark', 'firsttheme' ),
        ),
        'section' => 'firsttheme_footer_options'
    ));

    $wp_customize->add_setting('firsttheme_footer_layout', array(
        'default' => '3,3,3,3',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field',
        'validate_callback' => 'firsttheme_validate_footer_layout'
    ));

    $wp_customize->add_control('firsttheme_footer_layout', array(
        'type' => 'text',
        'label' => esc_html__( 'Footer Layout', 'firsttheme' ),
        'section' => 'firsttheme_footer_options'
    ));
    
}

add_action( 'customize_register', 'firsttheme_customize_register' );

function firsttheme_validate_footer_layout( $validity, $value) {
    if(!preg_match('/^([1-9]|1[012])(,([1-9]|1[012]))*$/', $value)) {
        $validity->add('invalid_footer_layout', esc_html__( 'Footer layout is invalid', 'firsttheme' ));
    }
    return $validity;
}

function firsttheme_sanitize_footer_bg( $input ) {
    $valid = array('light', 'dark');
    if( in_array($input, $valid, true) ) {
        return $input;
    }
    return 'dark';
}

function firsttheme_sanitize_site_info( $input ) {
    $allowed = array('a' => array(
        'href' => array(),
        'title' => array()
    ));
    return wp_kses($input, $allowed);
}