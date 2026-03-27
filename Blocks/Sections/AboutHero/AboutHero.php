<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\AboutHero;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class AboutHero extends MetaBlock
{
    protected string $id = 'about_hero';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'     => 'taw_about_hero',
            'title'  => __('About Hero Section', 'taw-theme'),
            'screen' => 'page',
            'show_on' => static function (\WP_Post $post): bool {
                return get_page_template_slug($post->ID) === 'page-about-us.php'
                    || in_array($post->post_name, ['nosotros', 'about-us'], true);
            },
            'fields' => [
                [
                    'id'    => 'about_hero_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '100',
                ],
                [
                    'id'    => 'about_hero_subtitle',
                    'label' => __('Subtitle', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 3,
                    'width' => '100',
                ],
                [
                    'id'    => 'about_hero_image',
                    'label' => __('Background Image', 'taw-theme'),
                    'type'  => 'image',
                    'width' => '100',
                ],
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        return [
            'heading'  => $this->getMeta($postId, 'about_hero_heading') ?: __('Conoce CH Capital', 'taw-theme'),
            'subtitle' => $this->getMeta($postId, 'about_hero_subtitle') ?: __('Más de dos décadas construyendo confianza, crecimiento y oportunidades en el sector financiero mexicano.', 'taw-theme'),
            'image_id' => (int) $this->getMeta($postId, 'about_hero_image'),
        ];
    }
}
