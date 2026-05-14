<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\ChangingNumbers;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class ChangingNumbers extends MetaBlock
{
    protected string $id = 'changing_numbers';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'     => 'taw_changing_numbers',
            'title'  => __('Changing Numbers', 'taw-theme'),
            'icon' => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screen' => 'page',
            'show_on' => static function (\WP_Post $post): bool {
                return (int) $post->ID === (int) get_option('page_on_front');
            },
            'fields' => [
                [
                    'id'       => 'section_title',
                    'label'    => __('Section Title', 'taw-theme'),
                    'type'     => 'text',
                    'required' => true,
                    'width'    => '100',
                ],
                [
                    'id'     => 'changing_numbers_items',
                    'label'  => __('Numbers', 'taw-theme'),
                    'type'   => 'repeater',
                    'button' => __('Add Number', 'taw-theme'),
                    'fields' => [
                        [
                            'id'    => 'prefix',
                            'label' => __('Prefix (e.g. +)', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '20',
                        ],
                        [
                            'id'       => 'number',
                            'label'    => __('Number', 'taw-theme'),
                            'type'     => 'number',
                            'required' => true,
                            'width'    => '30',
                        ],
                        [
                            'id'    => 'suffix',
                            'label' => __('Suffix (e.g. mdp)', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '20',
                        ],
                        [
                            'id'       => 'label',
                            'label'    => __('Label', 'taw-theme'),
                            'type'     => 'text',
                            'required' => true,
                            'width'    => '30',
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        $rows = $this->getRepeater($postId, 'changing_numbers_items');

        if (empty($rows)) {
            $rows = [
                ['number' => '2500', 'prefix' => '+', 'suffix' => 'mdp', 'label' => 'Patrimonio Fideicomitido'],
                ['number' => '500',  'prefix' => '+', 'suffix' => '',    'label' => 'Fideicomisos Constituidos'],
                ['number' => '550',  'prefix' => '+', 'suffix' => 'mdp', 'label' => 'En Créditos Otorgados'],
            ];
        }

        return [
            'title'   => Metabox::get($postId, 'section_title'),
            'numbers' => $rows
        ];
    }
}
