<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\StrategicAllies;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class StrategicAllies extends MetaBlock
{
    protected string $id = 'strategic_allies';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'     => 'taw_strategic_allies',
            'title'  => __('Strategic Allies Section', 'taw-theme'),
            'icon' => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screen' => ['page-nosotros.php'],
            'show_on' => static function (\WP_Post $post): bool {
                return get_page_template_slug($post->ID) === 'page-about-us.php'
                    || in_array($post->post_name, ['nosotros', 'about-us'], true);
            },
            'fields' => [
                [
                    'id'    => 'allies_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '100',
                ],
                [
                    'id'    => 'allies_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '100',
                ],
                [
                    'id'     => 'allies_logos',
                    'label'  => __('Ally Logos', 'taw-theme'),
                    'type'   => 'repeater',
                    'button' => __('Add Logo', 'taw-theme'),
                    'fields' => [
                        [
                            'id'    => 'ally_logo',
                            'label' => __('Logo', 'taw-theme'),
                            'type'  => 'image',
                            'width' => '50',
                        ],
                        [
                            'id'    => 'ally_name',
                            'label' => __('Name / Alt Text', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '50',
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected function getData(int|false $postId): array
    {
        $logos = Metabox::get_repeater($postId, 'allies_logos');

        return [
            'heading'    => $this->getMeta($postId, 'allies_heading') ?: __('Aliados Estratégicos', 'taw-theme'),
            'subheading' => $this->getMeta($postId, 'allies_subheading') ?: __('Trabajamos con instituciones líderes que comparten nuestra visión.', 'taw-theme'),
            'logos'      => $logos ?: [],
        ];
    }
}
