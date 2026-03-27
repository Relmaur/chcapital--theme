<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\Hero;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class Hero extends MetaBlock
{
    protected string $id = 'hero';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'     => 'taw_hero',
            'title'  => __('Hero Section', 'taw-theme'),
            // 'screens' => ['front-page.php'],
            'show_on' => static function (\WP_Post $post): bool {
                return (int) $post->ID === (int) get_option('page_on_front');
            },
            'fields' => [
                [
                    'id'       => 'hero_subtitle',
                    'label'    => __('Subtitle', 'taw-theme'),
                    'type'     => 'text',
                    'required' => true,
                    'editor'   => ['max_length' => 200],
                    'width'    => '100',
                ],
                [
                    'id'     => 'hero_slides',
                    'label'  => __('Background Slides', 'taw-theme'),
                    'type'   => 'repeater',
                    'button' => __('Add Slide', 'taw-theme'),
                    'fields' => [
                        [
                            'id'    => 'slide_image',
                            'label' => __('Image', 'taw-theme'),
                            'type'  => 'image',
                            'width' => '100',
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        $slides_raw = Metabox::get_repeater($postId, 'hero_slides');
        $slides = [];

        foreach ($slides_raw as $row) {
            $id = (int) ($row['slide_image'] ?? 0);
            if ($id) {
                $slides[] = $id;
            }
        }

        return [
            'heading' => $this->getMeta($postId, 'hero_heading'),
            'tagline' => $this->getMeta($postId, 'hero_tagline'),
            'slides'  => $slides,
        ];
    }
}
