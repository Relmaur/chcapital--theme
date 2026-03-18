<?php

declare(strict_types=1);

namespace TAW\Blocks\Molecules\Hero;

use TAW\Core\MetaBlock;
use TAW\Core\Metabox\Metabox;

class Hero extends MetaBlock
{
    protected string $id = 'hero';

    protected function registerMetaboxes(): void
    {

        new Metabox([
            'id'     => 'taw_hero',
            'title'  => __('Hero Section', 'taw-theme'),
            'screen' => 'page',
            'show_on' => static function (\WP_Post $post): bool {
                return (int) $post->ID === (int) get_option('page_on_front');
            },
            'fields' => [
                [
                    'id'       => 'hero_subtitle',
                    'label'    => __('Subtitle', 'taw-theme'),
                    'type'     => 'text',
                    'width'    => '100',
                    'required' => true,
                    'editor'   => [      // ← Editable with settings
                        'max_length' => 200,
                    ],
                    'width' => '80'
                ],
                [
                    'id'    => 'hero_image_url',
                    'label' => __('Hero Image', 'taw-theme'),
                    'type'  => 'image',
                    'width' => '100',
                    'editor' => [      // ← Editable with settings
                        'preview_size' => 'medium',
                    ],
                    'width' => '20'
                ]
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        $image_url = $this->getMeta($postId, 'hero_image_url') ? $this->getMeta($postId, 'hero_image_url') : '';

        return [
            'heading' => $this->getMeta($postId, 'hero_heading'),
            'tagline' => $this->getMeta($postId, 'hero_tagline'),
            'image_id' => $image_url
        ];
    }
}
