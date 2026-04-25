<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\BlurbsGrid;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class BlurbsGrid extends MetaBlock
{
    protected string $id = 'blurbs_grid';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'      => 'taw_blurbs_grid',
            'title'   => __('Blurbs Grid Section', 'taw-theme'),
            'screens' => ['page'],
            'fields'  => [
                [
                    'id'    => 'blurbs_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '100',
                ],
                [
                    'id'    => 'blurbs_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 2,
                    'width' => '100',
                ],
                [
                    'id'     => 'blurbs_items',
                    'label'  => __('Blurbs', 'taw-theme'),
                    'type'   => 'repeater',
                    'button' => __('Add Blurb', 'taw-theme'),
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
                            'id'    => 'title',
                            'label' => __('Title', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '50',
                        ],
                        [
                            'id'    => 'subtitle',
                            'label' => __('Subtitle', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '50',
                        ],
                        [
                            'id'          => 'badge',
                            'label'       => __('Badge', 'taw-theme'),
                            'type'        => 'text',
                            'description' => __('Short label shown over the image (optional).', 'taw-theme'),
                            'width'       => '100',
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        $rows = $this->getRepeater($postId, 'blurbs_items');

        $items = array_map(function (array $row): array {
            $id   = (int) ($row['image'] ?? 0);
            $full = $id ? wp_get_attachment_image_src($id, 'full') : null;

            return [
                'image_id'    => $id,
                'alt'         => ($row['alt'] ?? '') ?: ($id ? get_post_meta($id, '_wp_attachment_image_alt', true) : ''),
                'title'       => $row['title']    ?? '',
                'subtitle'    => $row['subtitle'] ?? '',
                'badge'       => $row['badge']    ?? '',
                'full_url'    => $full ? $full[0] : '',
                'full_width'  => $full ? (int) $full[1] : 0,
                'full_height' => $full ? (int) $full[2] : 0,
            ];
        }, $rows ?: []);

        return [
            'heading'    => $this->getMeta($postId, 'blurbs_heading'),
            'subheading' => $this->getMeta($postId, 'blurbs_subheading'),
            'items'      => array_filter($items, fn($item) => $item['image_id'] || $item['title']),
        ];
    }
}
