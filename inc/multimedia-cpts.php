<?php

declare(strict_types=1);

use TAW\Core\Metabox\Metabox;

// ── Register CPTs & Taxonomy ─────────────────────────────────────────

add_action('init', static function (): void {

    register_post_type('mm_video', [
        'labels' => [
            'name'               => __('Videos', 'taw-theme'),
            'singular_name'      => __('Video', 'taw-theme'),
            'add_new_item'       => __('Agregar Video', 'taw-theme'),
            'edit_item'          => __('Editar Video', 'taw-theme'),
            'new_item'           => __('Nuevo Video', 'taw-theme'),
            'view_item'          => __('Ver Video', 'taw-theme'),
            'search_items'       => __('Buscar Videos', 'taw-theme'),
            'not_found'          => __('No se encontraron videos.', 'taw-theme'),
            'not_found_in_trash' => __('No hay videos en la papelera.', 'taw-theme'),
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
            'name'               => __('Noticias', 'taw-theme'),
            'singular_name'      => __('Noticia', 'taw-theme'),
            'add_new_item'       => __('Agregar Noticia', 'taw-theme'),
            'edit_item'          => __('Editar Noticia', 'taw-theme'),
            'new_item'           => __('Nueva Noticia', 'taw-theme'),
            'not_found'          => __('No se encontraron noticias.', 'taw-theme'),
            'not_found_in_trash' => __('No hay noticias en la papelera.', 'taw-theme'),
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
            'name'               => __('Galerías de Fotos', 'taw-theme'),
            'singular_name'      => __('Galería', 'taw-theme'),
            'add_new_item'       => __('Agregar Galería', 'taw-theme'),
            'edit_item'          => __('Editar Galería', 'taw-theme'),
            'new_item'           => __('Nueva Galería', 'taw-theme'),
            'not_found'          => __('No se encontraron galerías.', 'taw-theme'),
            'not_found_in_trash' => __('No hay galerías en la papelera.', 'taw-theme'),
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
            'name'               => __('Guías Descargables', 'taw-theme'),
            'singular_name'      => __('Guía', 'taw-theme'),
            'add_new_item'       => __('Agregar Guía', 'taw-theme'),
            'edit_item'          => __('Editar Guía', 'taw-theme'),
            'new_item'           => __('Nueva Guía', 'taw-theme'),
            'not_found'          => __('No se encontraron guías.', 'taw-theme'),
            'not_found_in_trash' => __('No hay guías en la papelera.', 'taw-theme'),
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
            'name'          => __('Tipos de Video', 'taw-theme'),
            'singular_name' => __('Tipo', 'taw-theme'),
            'add_new_item'  => __('Agregar Tipo', 'taw-theme'),
            'edit_item'     => __('Editar Tipo', 'taw-theme'),
            'search_items'  => __('Buscar tipos', 'taw-theme'),
            'all_items'     => __('Todos los tipos', 'taw-theme'),
        ],
        'hierarchical'      => false,
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
        'title'   => __('Detalles del Video', 'taw-theme'),
        'icon'    => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
        'show_on' => static fn(\WP_Post $post): bool => $post->post_type === 'mm_video',
        'fields'  => [
            [
                'id'          => 'video_url',
                'label'       => __('URL del Video', 'taw-theme'),
                'type'        => 'url',
                'width'       => '100',
                'placeholder' => 'https://www.youtube.com/watch?v=...',
                'description' => __('YouTube o Vimeo.', 'taw-theme'),
            ],
            [
                'id'    => 'video_thumbnail',
                'label' => __('Miniatura', 'taw-theme'),
                'type'  => 'image',
                'width' => '100',
            ],
        ],
    ]);

    new Metabox([
        'id'      => 'taw_mm_news_meta',
        'title'   => __('Detalles de la Noticia', 'taw-theme'),
        'icon'    => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
        'show_on' => static fn(\WP_Post $post): bool => $post->post_type === 'mm_news',
        'fields'  => [
            [
                'id'          => 'news_url',
                'label'       => __('URL del Artículo', 'taw-theme'),
                'type'        => 'url',
                'width'       => '100',
                'placeholder' => 'https://...',
            ],
            [
                'id'    => 'news_thumbnail',
                'label' => __('Miniatura', 'taw-theme'),
                'type'  => 'image',
                'width' => '100',
            ],
        ],
    ]);

    new Metabox([
        'id'      => 'taw_mm_gallery_meta',
        'title'   => __('Imágenes de la Galería', 'taw-theme'),
        'icon'    => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
        'show_on' => static fn(\WP_Post $post): bool => $post->post_type === 'mm_gallery',
        'fields'  => [
            [
                'id'     => 'gallery_images',
                'label'  => __('Imágenes', 'taw-theme'),
                'type'   => 'repeater',
                'button' => __('Agregar Imagen', 'taw-theme'),
                'fields' => [
                    [
                        'id'    => 'image',
                        'label' => __('Imagen', 'taw-theme'),
                        'type'  => 'image',
                        'width' => '50',
                    ],
                    [
                        'id'    => 'caption',
                        'label' => __('Descripción', 'taw-theme'),
                        'type'  => 'text',
                        'width' => '50',
                    ],
                ],
            ],
        ],
    ]);

    new Metabox([
        'id'      => 'taw_mm_guide_meta',
        'title'   => __('Detalles de la Guía', 'taw-theme'),
        'icon'    => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
        'show_on' => static fn(\WP_Post $post): bool => $post->post_type === 'mm_guide',
        'fields'  => [
            [
                'id'          => 'guide_pdf_url',
                'label'       => __('URL del PDF', 'taw-theme'),
                'type'        => 'url',
                'width'       => '100',
                'placeholder' => 'https://...',
            ],
            [
                'id'    => 'guide_thumbnail',
                'label' => __('Miniatura', 'taw-theme'),
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
