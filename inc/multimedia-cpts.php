<?php

declare(strict_types=1);

use TAW\Core\Metabox\Metabox;

// ── Register CPTs & Taxonomy ─────────────────────────────────────────

add_action('init', static function (): void {

    register_post_type('mm_video', [
        'labels' => [
            'name'               => __('Videos', 'taw-theme'),
            'singular_name'      => __('Video', 'taw-theme'),
            'add_new_item'       => __('Add New Video', 'taw-theme'),
            'edit_item'          => __('Edit Video', 'taw-theme'),
            'new_item'           => __('New Video', 'taw-theme'),
            'view_item'          => __('View Video', 'taw-theme'),
            'search_items'       => __('Search Videos', 'taw-theme'),
            'not_found'          => __('No videos found.', 'taw-theme'),
            'not_found_in_trash' => __('No videos in trash.', 'taw-theme'),
        ],
        'public'              => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-video-alt3',
        'menu_position'       => 20,
        'supports'            => ['title'],
        'has_archive'         => 'multimedia/videos',
        'rewrite'             => ['slug' => 'multimedia/videos', 'with_front' => false],
        'exclude_from_search' => false,
    ]);

    register_post_type('mm_news', [
        'labels' => [
            'name'               => __('News', 'taw-theme'),
            'singular_name'      => __('News Item', 'taw-theme'),
            'add_new_item'       => __('Add New News Item', 'taw-theme'),
            'edit_item'          => __('Edit News Item', 'taw-theme'),
            'new_item'           => __('New News Item', 'taw-theme'),
            'not_found'          => __('No news found.', 'taw-theme'),
            'not_found_in_trash' => __('No news in trash.', 'taw-theme'),
        ],
        'public'              => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-media-text',
        'menu_position'       => 21,
        'supports'            => ['title'],
        'has_archive'         => 'multimedia/noticias',
        'rewrite'             => ['slug' => 'multimedia/noticias', 'with_front' => false],
        'exclude_from_search' => false,
    ]);

    register_post_type('mm_gallery', [
        'labels' => [
            'name'               => __('Photo Galleries', 'taw-theme'),
            'singular_name'      => __('Gallery', 'taw-theme'),
            'add_new_item'       => __('Add New Gallery', 'taw-theme'),
            'edit_item'          => __('Edit Gallery', 'taw-theme'),
            'new_item'           => __('New Gallery', 'taw-theme'),
            'not_found'          => __('No galleries found.', 'taw-theme'),
            'not_found_in_trash' => __('No galleries in trash.', 'taw-theme'),
        ],
        'public'              => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-format-gallery',
        'menu_position'       => 22,
        'supports'            => ['title'],
        'has_archive'         => 'multimedia/galerias',
        'rewrite'             => ['slug' => 'multimedia/galerias', 'with_front' => false],
        'exclude_from_search' => false,
    ]);

    register_post_type('mm_guide', [
        'labels' => [
            'name'               => __('Downloadable Guides', 'taw-theme'),
            'singular_name'      => __('Guide', 'taw-theme'),
            'add_new_item'       => __('Add New Guide', 'taw-theme'),
            'edit_item'          => __('Edit Guide', 'taw-theme'),
            'new_item'           => __('New Guide', 'taw-theme'),
            'not_found'          => __('No guides found.', 'taw-theme'),
            'not_found_in_trash' => __('No guides in trash.', 'taw-theme'),
        ],
        'public'              => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-download',
        'menu_position'       => 23,
        'supports'            => ['title'],
        'has_archive'         => 'multimedia/guias',
        'rewrite'             => ['slug' => 'multimedia/guias', 'with_front' => false],
        'exclude_from_search' => false,
    ]);

    register_taxonomy('mm_video_type', 'mm_video', [
        'labels' => [
            'name'          => __('Video Types', 'taw-theme'),
            'singular_name' => __('Type', 'taw-theme'),
            'add_new_item'  => __('Add New Type', 'taw-theme'),
            'edit_item'     => __('Edit Type', 'taw-theme'),
            'search_items'  => __('Search Types', 'taw-theme'),
            'all_items'     => __('All Types', 'taw-theme'),
        ],
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite'           => ['slug' => 'multimedia/videos/tipo', 'with_front' => false],
    ]);
});

// ── CPT Metaboxes ────────────────────────────────────────────────────
// Registered at priority 20 so Theme::boot() / BlockLoader have already run.

add_action('init', static function (): void {

    new Metabox([
        'id'      => 'taw_mm_video_meta',
        'title'   => __('Video Details', 'taw-theme'),
        'icon'    => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
        'screens' => ['mm_video'],
        'fields'  => [
            [
                'id'          => 'video_url',
                'label'       => __('Video URL', 'taw-theme'),
                'type'        => 'url',
                'width'       => '100',
                'placeholder' => 'https://www.youtube.com/watch?v=...',
                'description' => __('YouTube or Vimeo.', 'taw-theme'),
            ],
            [
                'id' => 'video_description',
                'label' => __('Description', 'taw-theme'),
                'type' => 'wysiwyg',
            ],
            [
                'id'    => 'video_thumbnail',
                'label' => __('Thumbnail', 'taw-theme'),
                'type'  => 'image',
                'width' => '100',
            ],
        ],
    ]);

    new Metabox([
        'id'      => 'taw_mm_news_meta',
        'title'   => __('News Item Details', 'taw-theme'),
        'icon'    => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
        'screens' => ['mm_news'],
        'fields'  => [
            [
                'id'          => 'news_url',
                'label'       => __('Article URL', 'taw-theme'),
                'type'        => 'url',
                'width'       => '100',
                'placeholder' => 'https://...',
            ],
            [
                'id'    => 'news_thumbnail',
                'label' => __('Thumbnail', 'taw-theme'),
                'type'  => 'image',
                'width' => '100',
            ],
        ],
    ]);

    new Metabox([
        'id'      => 'taw_mm_gallery_meta',
        'title'   => __('Gallery Images', 'taw-theme'),
        'icon'    => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
        'screens' => ['mm_gallery'],
        'fields'  => [
            [
                'id'     => 'gallery_images',
                'label'  => __('Images', 'taw-theme'),
                'type'   => 'repeater',
                'layout' => 'tabbed_horizontal',
                'button' => __('Add Image', 'taw-theme'),
                'fields' => [
                    [
                        'id'    => 'image',
                        'label' => __('Image', 'taw-theme'),
                        'type'  => 'image',
                        'width' => '50',
                    ],
                    [
                        'id'    => 'caption',
                        'label' => __('Caption', 'taw-theme'),
                        'type'  => 'text',
                        'width' => '50',
                    ],
                ],
            ],
            [
                'id' => 'gallery_date',
                'label' => __('Event Date', 'taw-theme'),
                'type' => 'datepicker',
            ]
        ],
    ]);

    new Metabox([
        'id'      => 'taw_mm_guide_meta',
        'title'   => __('Guide Details', 'taw-theme'),
        'icon'    => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
        'screens' => ['mm_guide'],
        'fields'  => [
            [
                'id'          => 'guide_pdf_url',
                'label'       => __('PDF URL', 'taw-theme'),
                'type'        => 'url',
                'width'       => '100',
                'placeholder' => 'https://...',
            ],
            [
                'id'    => 'guide_thumbnail',
                'label' => __('Thumbnail', 'taw-theme'),
                'type'  => 'image',
                'width' => '100',
            ],
        ],
    ]);
}, 20);

// ── Noindex individual CPT posts ─────────────────────────────────────

add_action('wp_head', static function (): void {
    if (is_singular(['mm_video', 'mm_news', 'mm_gallery', 'mm_guide'])) {
        echo '<meta name="robots" content="noindex, nofollow">' . PHP_EOL;
    }
});

// ── Embed URL helper ─────────────────────────────────────────────────

if (!function_exists('multimedia_get_embed_url')) {
    function multimedia_get_embed_url(string $url): string
    {
        if (empty($url)) return '';

        // YouTube: watch, embed, shorts, youtu.be
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=1&rel=0';
        }

        // Vimeo
        if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $url, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1] . '?autoplay=1';
        }

        return $url;
    }
}
