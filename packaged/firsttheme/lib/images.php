<?php

if(!isset($content_width)) {
    $content_width = 800;
}

function firsttheme_content_width() {
    global $content_width;
    global $post;

    if(is_single() && $post->post_type === 'post') {
        $layout = firsttheme_meta( $post->ID, '_firsttheme_post_layout', 'full' );
        $sidebar = is_active_sidebar( 'primary-sidebar' );
        if($layout === 'sidebar' && !$sidebar) {
            $layout = 'full';
        }
        $content_width = $layout === 'full' ? 800 : 738;
    }
}
add_action('template_redirect', 'firsttheme_content_width');

function firsttheme_image_sizes( $sizes, $size, $image_src, $image_meta, $attachment_id) {
    $width = $size[0];
    global $content_width;
    global $post;

    $layout = 'full';

    if(is_single() && $post->post_type === 'post') {
        $layout = firsttheme_meta( $post->ID, '_firsttheme_post_layout', 'full' );
        $sidebar = is_active_sidebar( 'primary-sidebar' );
        if($layout === 'sidebar' && !$sidebar) {
            $layout = 'full';
        }
    }

    if( $content_width <= $width) {
        if($layout === 'full') {
            $sizes = '(max-width: 862px) calc(100vw - 1.25rem*2 - 0.625rem*2 - 2px), ' . $content_width . 'px';
        } elseif ($layout === 'sidebar') {
            $sizes = '(max-width: 640px) calc(100vw - 1.25rem*2 - 0.625rem*2 - 2px), (max-width: 1200px) calc(100vw - 33.33333vw - 0.625rem*4 - 1.25rem*2 - 2px), ' . $content_width . 'px';
        }
    } else {
        $sizes = '(max-width: ' . ($width + 62) . 'px) calc(100vw - 1.25rem*2 - 0.625rem*2 - 2px), ' . $width . 'px';
    }

    return $sizes;
}

add_filter('wp_calculate_image_sizes', 'firsttheme_image_sizes', 10, 5);