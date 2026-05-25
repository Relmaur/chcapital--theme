<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\PostGrid;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class PostGrid extends MetaBlock
{
    protected string $id = 'post_grid';

    /**
     * All registered variations — each becomes its own block ID:
     * post_grid--videos, post_grid--noticias, etc.
     *
     * @return string[]
     */
    public static function variations(): array
    {
        return ['videos', 'noticias', 'galerias', 'guias'];
    }

    private static function varConfig(string $variation): array
    {
        return match ($variation) {
            'videos' => [
                'label'     => 'Multimedia — Videos',
                'post_type' => 'mm_video',
                'defaults'  => ['title' => 'Videos'],
            ],
            'noticias' => [
                'label'     => 'Multimedia — Noticias',
                'post_type' => 'mm_news',
                'defaults'  => ['title' => 'Noticias'],
            ],
            'galerias' => [
                'label'     => 'Multimedia — Galerías',
                'post_type' => 'mm_gallery',
                'defaults'  => ['title' => 'Galerías de Fotos'],
            ],
            'guias' => [
                'label'     => 'Multimedia — Guías Descargables',
                'post_type' => 'mm_guide',
                'defaults'  => ['title' => 'Guías Descargables'],
            ],
            default => [
                'label'     => 'Post Grid',
                'post_type' => 'post',
                'defaults'  => ['title' => ''],
            ],
        };
    }

    protected function registerMetaboxes(): void
    {
        $v = $this->variation;
        $c = self::varConfig($v);

        new Metabox([
            'id'      => 'taw_post_grid_' . $v,
            'title'   => __($c['label'], 'taw-theme'),
            'icon'    => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screens' => ['page-multimedia.php'],
            'fields'  => [
                [
                    'id'    => 'post_grid_' . $v . '_title',
                    'label' => __('Título de la sección', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '100',
                ],
            ],
        ]);
    }

    protected function getData(int|false $postId): array
    {
        $v = $this->variation;
        $c = self::varConfig($v);

        $posts = get_posts([
            'post_type'      => $c['post_type'],
            'posts_per_page' => 3,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);

        $items = array_map(
            fn(\WP_Post $post): array => $this->buildItem($post, $c['post_type']),
            $posts
        );

        return [
            'section_title' => $this->getMeta($postId, 'post_grid_' . $v . '_title') ?: $c['defaults']['title'],
            'post_type'     => $c['post_type'],
            'more_url'      => get_post_type_archive_link($c['post_type']) ?: '',
            'items'         => array_values($items),
        ];
    }

    private function buildItem(\WP_Post $post, string $postType): array
    {
        $base = [
            'id'    => $post->ID,
            'title' => $post->post_title,
        ];

        switch ($postType) {
            case 'mm_video':
                $raw_url = (string) get_post_meta($post->ID, '_taw_video_url', true);
                $terms   = wp_get_post_terms($post->ID, 'mm_video_type', ['fields' => 'names']);
                return $base + [
                    'thumbnail_id' => (int) get_post_meta($post->ID, '_taw_video_thumbnail', true),
                    'thumb_url'    => self::youtubeThumbUrl($raw_url),
                    'embed_url'    => \multimedia_get_embed_url($raw_url),
                    'terms'        => is_array($terms) ? $terms : [],
                ];

            case 'mm_news':
                return $base + [
                    'thumbnail_id' => (int) get_post_meta($post->ID, '_taw_news_thumbnail', true),
                    'url'          => (string) get_post_meta($post->ID, '_taw_news_url', true),
                ];

            case 'mm_gallery':
                $images = $this->parseGalleryImages($post->ID);
                return $base + [
                    'thumbnail_id' => (int) ($images[0]['image_id'] ?? 0),
                    'images'       => $images,
                    'count'        => count($images),
                ];

            case 'mm_guide':
                return $base + [
                    'thumbnail_id' => (int) get_post_meta($post->ID, '_taw_guide_thumbnail', true),
                    'pdf_url'      => (string) get_post_meta($post->ID, '_taw_guide_pdf_url', true),
                ];

            default:
                return $base;
        }
    }

    public static function youtubeThumbUrl(string $url): string
    {
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/', $url, $m)) {
            return 'https://img.youtube.com/vi/' . $m[1] . '/hqdefault.jpg';
        }
        return '';
    }

    private function parseGalleryImages(int $postId): array
    {
        $raw  = get_post_meta($postId, '_taw_gallery_images', true);
        $rows = is_string($raw) && !empty($raw) ? (json_decode($raw, true) ?: []) : (is_array($raw) ? $raw : []);

        $images = [];
        foreach ($rows as $row) {
            $id = (int) ($row['image'] ?? 0);
            if (!$id) continue;
            $full     = wp_get_attachment_image_src($id, 'full');
            $images[] = [
                'image_id'    => $id,
                'caption'     => (string) ($row['caption'] ?? ''),
                'full_url'    => $full ? $full[0] : '',
                'full_width'  => $full ? (int) $full[1] : 0,
                'full_height' => $full ? (int) $full[2] : 0,
            ];
        }
        return $images;
    }
}
