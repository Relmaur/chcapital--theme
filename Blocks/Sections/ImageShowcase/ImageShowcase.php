<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\ImageShowcase;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class ImageShowcase extends MetaBlock
{
    protected string $id = 'image_showcase';

    /**
     * All registered variations. Each string becomes a separate block ID:
     * image_showcase--escrow_realestate, etc.
     *
     * @return string[]
     */
    public static function variations(): array
    {
        return ['escrow_realestate'];
    }

    /**
     * Per-variation configuration.
     *
     * Keys:
     *   label    — admin metabox title
     *   screens  — page templates that show this metabox
     *   defaults — fallback heading/subheading shown before the editor saves
     */
    private static function varConfig(string $variation): array
    {
        return match ($variation) {
            'escrow_realestate' => [
                'label'    => 'Section — Escrow en operaciones inmobiliarias (Imágenes)',
                'screens'  => ['page-escrow.php'],
                'defaults' => [
                    'heading'    => 'El Contrato Escrow en operaciones inmobiliarias',
                    'subheading' => 'Certeza para compradores, vendedores y brokers',
                ],
            ],

            // Fallback for future variations registered before their config is added
            default => [
                'label'    => 'Image Showcase Section',
                'screens'  => [],
                'defaults' => ['heading' => '', 'subheading' => ''],
            ],
        };
    }

    protected function registerMetaboxes(): void
    {
        $v = $this->variation;
        $c = self::varConfig($v);

        new Metabox([
            'id'      => 'taw_image_showcase_' . $v,
            'title'   => __($c['label'], 'taw-theme'),
            'icon'    => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screens' => $c['screens'],
            'fields'  => [
                [
                    'id'    => $v . '_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '50',
                ],
                [
                    'id'    => $v . '_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 2,
                    'width' => '50',
                ],
                [
                    'id'     => $v . '_images',
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
                            'id'          => 'alt',
                            'label'       => __('Alt Text', 'taw-theme'),
                            'type'        => 'text',
                            'description' => __('Leave empty to use the attachment alt text.', 'taw-theme'),
                            'width'       => '50',
                        ],
                        [
                            'id'    => 'caption',
                            'label' => __('Caption (optional, shown in lightbox)', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '100',
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected function getData(int|false $postId): array
    {
        $v = $this->variation;
        $c = self::varConfig($v);
        $d = $c['defaults'];

        $rows = $this->getRepeater($postId, $v . '_images');

        $images = array_map(function (array $row): array {
            $id   = (int) ($row['image'] ?? 0);
            $full = $id ? wp_get_attachment_image_src($id, 'full') : null;

            return [
                'image_id'    => $id,
                'alt'         => ($row['alt'] ?? '') ?: ($id ? get_post_meta($id, '_wp_attachment_image_alt', true) : ''),
                'caption'     => $row['caption'] ?? '',
                'full_url'    => $full ? $full[0] : '',
                'full_width'  => $full ? (int) $full[1] : 0,
                'full_height' => $full ? (int) $full[2] : 0,
            ];
        }, $rows ?: []);

        return [
            'heading'    => $this->getMeta($postId, $v . '_heading')    ?: $d['heading'],
            'subheading' => $this->getMeta($postId, $v . '_subheading') ?: $d['subheading'],
            'images'     => array_filter($images, fn($img) => $img['image_id'] || $img['full_url']),
        ];
    }
}
