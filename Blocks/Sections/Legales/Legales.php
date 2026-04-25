<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\Legales;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class Legales extends MetaBlock
{
    protected string $id = 'legales';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'     => 'taw_legales',
            'title'  => __('Legales Section', 'taw-theme'),
            'screen' => 'page',
            'show_on' => static function (\WP_Post $post): bool {
                return (int) $post->ID === (int) get_option('page_on_front')
                    || get_page_template_slug($post->ID) === 'page-credito-pyme.php';
            },
            'fields' => [
                [
                    'id'    => 'legales_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                ],
                [
                    'id'     => 'legales_links',
                    'label'  => __('Links', 'taw-theme'),
                    'type'   => 'repeater',
                    'button' => __('Add Link', 'taw-theme'),
                    'fields' => [
                        [
                            'id'    => 'text',
                            'label' => __('Link Text', 'taw-theme'),
                            'type'  => 'text',
                        ],
                        [
                            'id'    => 'url',
                            'label' => __('Link URL', 'taw-theme'),
                            'type'  => 'text',
                        ],
                    ],
                ]
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        $links = Metabox::get_repeater($postId, 'legales_links');

        $default_links = [
            [
                'text' => __('¿Quién regula y supervisa a las instituciones financieras?', 'taw-theme'),
                'url'  => 'https://chcapital.mx/home/quien-regula-y-supervisa-a-las-instituciones-financieras/',
            ],
            [
                'text' => __('¿Qué es el Buró de Entidades Financieras?', 'taw-theme'),
                'url'  => 'https://chcapital.mx/home/buro-de-entidades-financieras/'
            ]
        ];

        return [
            'heading' => $this->getMeta($postId, 'legales_heading') ?: 'Legales',
            'links'   => $links ?: $default_links,
        ];
    }
}
