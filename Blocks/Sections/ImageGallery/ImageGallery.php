<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\ImageGallery;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class ImageGallery extends MetaBlock
{
    protected string $id = 'image_gallery';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'      => 'taw_image_gallery',
            'title'   => __('Section - Image Gallery', 'taw-theme'),
            'icon' => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screens' => ['page-credito-pyme.php', 'page-arrendamiento-puro.php'],
            'fields'  => [
                [
                    'id'    => 'gallery_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '100',
                ],
                [
                    'id'    => 'gallery_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 2,
                    'width' => '100',
                ],
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
                            'id'          => 'alt',
                            'label'       => __('Alt Text', 'taw-theme'),
                            'type'        => 'text',
                            'description' => __('Leave empty to use the attachment alt text.', 'taw-theme'),
                            'width'       => '50',
                        ],
                        [
                            'id'    => 'caption',
                            'label' => __('Caption', 'taw-theme'),
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
        $rows = $this->getRepeater($postId, 'gallery_images');

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
            'heading'    => $this->getMeta($postId, 'gallery_heading'),
            'subheading' => $this->getMeta($postId, 'gallery_subheading'),
            'images'     => array_filter($images, fn($img) => $img['image_id'] || $img['full_url']),
        ];
    }
}
