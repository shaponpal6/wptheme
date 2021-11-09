<?php

require_once get_template_directory() . '/lib/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'firsttheme_register_required_plugins' );

function firsttheme_register_required_plugins() {
    $plugins = array(
        array(
            'name' => 'firsttheme metaboxes',
            'slug' => 'firsttheme-metaboxes',
            'source' => get_template_directory_uri() . '/lib/plugins/firsttheme-metaboxes.zip',
            'required' => true,
            'version' => '1.0.0',
            'force_activation' => false,
            'force_deactivation' => false,
        ),
        array(
            'name' => 'firsttheme shortcodes',
            'slug' => 'firsttheme-shortcodes',
            'source' => get_template_directory_uri() . '/lib/plugins/firsttheme-shortcodes.zip',
            'required' => true,
            'version' => '1.0.0',
            'force_activation' => false,
            'force_deactivation' => false,
        ),
        array(
            'name' => 'firsttheme post types',
            'slug' => 'firsttheme-post-types',
            'source' => get_template_directory_uri() . '/lib/plugins/firsttheme-post-types.zip',
            'required' => true,
            'version' => '1.0.0',
            'force_activation' => false,
            'force_deactivation' => false,
        )
    );

    $config = array(
        
    );

    tgmpa( $plugins, $config);
}