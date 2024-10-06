<?php

namespace FalconBaseServices\Services;

class CustomPostType
{
    public function register()
    {
        add_action('init', function () {
            register_post_type('book', [
                'labels' => [
                    'name' => __('Books'),
                    'singular_name' => __('Book'),
                ],
                'public' => true,
                'has_archive' => true,
                'supports' => ['title', 'editor', 'thumbnail'],
            ]);

            register_taxonomy('publisher', 'book', [
                'labels' => [
                    'name' => __('Publishers'),
                    'singular_name' => __('Publisher'),
                ],
                'public' => true,
                'hierarchical' => true,
            ]);

            register_taxonomy('author', 'book', [
                'labels' => [
                    'name' => __('Authors'),
                    'singular_name' => __('Author'),
                ],
                'public' => true,
                'hierarchical' => false,
            ]);
        });
    }
}
