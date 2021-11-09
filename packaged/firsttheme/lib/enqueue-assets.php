<?php

function firsttheme_assets() {
    wp_enqueue_style( 'firsttheme-stylesheet', get_template_directory_uri() . '/dist/assets/css/bundle.css', array(), '1.0.0', 'all' );

    include(get_template_directory() . '/lib/inline-css.php');
    wp_add_inline_style( 'firsttheme-stylesheet', $inline_styles );

    wp_enqueue_script( 'firsttheme-scripts', get_template_directory_uri() . '/dist/assets/js/bundle.js', array('jquery'), '1.0.0', true );

    if( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

add_action('wp_enqueue_scripts', 'firsttheme_assets');

function firsttheme_block_editor_assets() {
    wp_enqueue_style( 'firsttheme-block-editor-styles', get_template_directory_uri() . '/dist/assets/css/editor.css', array(), '1.0.0', 'all' );
}

add_action( 'enqueue_block_editor_assets', 'firsttheme_block_editor_assets' );


function firsttheme_admin_assets() {
    wp_enqueue_style( 'firsttheme-admin-stylesheet', get_template_directory_uri() . '/dist/assets/css/admin.css', array(), '1.0.0', 'all' );

    wp_enqueue_script( 'firsttheme-admin-scripts', get_template_directory_uri() . '/dist/assets/js/admin.js', array(), '1.0.0', true );
}

add_action('admin_enqueue_scripts', 'firsttheme_admin_assets');

function firsttheme_customize_preview_js () {
    wp_enqueue_script( 'firsttheme-cutomize-preview', get_template_directory_uri() . '/dist/assets/js/customize-preview.js', array('customize-preview', 'jquery'), '1.0.0' , true );

    include(get_template_directory() . '/lib/inline-css.php');
    wp_localize_script( 'firsttheme-cutomize-preview', 'firsttheme', array('inline-css' => $inline_styles_selectors) );
}

add_action( 'customize_preview_init', 'firsttheme_customize_preview_js' );