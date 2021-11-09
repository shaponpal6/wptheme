<?php


add_filter('register_post_type_args', 'firsttheme_filter_portfolio', 10, 2);
function firsttheme_filter_portfolio($args, $post_type) {
    if($post_type === 'firsttheme_portfolio') {
        $args['rewrite']['slug'] = get_theme_mod('firsttheme_portfolio_slug', 'portfolio');
    }
    return $args;
}

add_action('customize_save_after', 'firsttheme_customize_save_after');

add_action('init', 'firsttheme_flush_rewrite', 99999);

function firsttheme_flush_rewrite() {
    if(get_theme_mod('firsttheme_flush_flag', false)) {
        flush_rewrite_rules();
        set_theme_mod('firsttheme_flush_flag', false);
    }
}

function firsttheme_customize_save_after() {
    $old = get_post_type_object('firsttheme_portfolio')->rewrite['slug'];
    $new = get_theme_mod('firsttheme_portfolio_slug', 'portfolio');
    if($old !== $new) {
        set_theme_mod('firsttheme_flush_flag', true);
    }
}
