<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\Cta;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class Cta extends MetaBlock
{
    protected string $id = 'cta';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'      => 'taw_cta',
            'title'   => __('Section - CTA', 'taw-theme'),
            'icon'    => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screens' => [
                'page-credito-pyme.php',
                'page-arrendamiento-puro.php',
                'page-fideicomisos.php',
                'page-credito-de-nomina.php',
                'page-escrow.php'
            ],
            'fields'  => [
                [
                    'id'    => 'cta_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '50',
                ],
                [
                    'id'    => 'cta_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 3,
                    'width' => '50',
                ],
                [
                    'id'     => 'cta_button',
                    'label'  => __('Button', 'taw-theme'),
                    'type'   => 'group',
                    'fields' => [
                        [
                            'id'    => 'button_text',
                            'label' => __('Text', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '50',
                        ],
                        [
                            'id'    => 'button_url',
                            'label' => __('URL', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '50',
                        ],
                        [
                            'id'    => 'button_new_tab',
                            'label' => __('Open in new tab', 'taw-theme'),
                            'type'  => 'checkbox',
                            'width' => '100',
                        ],
                    ],
                ],
                [
                    'id'      => 'cta_background_type',
                    'label'   => __('Background Type', 'taw-theme'),
                    'type'    => 'select',
                    'options' => [
                        'image'    => __('Image', 'taw-theme'),
                        'gradient' => __('Gradient', 'taw-theme'),
                        'color'    => __('Solid Color', 'taw-theme'),
                    ],
                    'default' => 'image',
                    'width'   => '100',
                ],
                [
                    'id'         => 'cta_background_image',
                    'label'      => __('Background Image', 'taw-theme'),
                    'type'       => 'image',
                    'width'      => '100',
                    'conditions' => [
                        ['field' => 'cta_background_type', 'operator' => '==', 'value' => 'image'],
                    ],
                ],
                [
                    'id'         => 'cta_gradient_start',
                    'label'      => __('Gradient Start Color', 'taw-theme'),
                    'type'       => 'color',
                    'width'      => '50',
                    'conditions' => [
                        ['field' => 'cta_background_type', 'operator' => '==', 'value' => 'gradient'],
                    ],
                ],
                [
                    'id'         => 'cta_gradient_end',
                    'label'      => __('Gradient End Color', 'taw-theme'),
                    'type'       => 'color',
                    'width'      => '50',
                    'conditions' => [
                        ['field' => 'cta_background_type', 'operator' => '==', 'value' => 'gradient'],
                    ],
                ],
                [
                    'id'         => 'cta_background_color',
                    'label'      => __('Background Color', 'taw-theme'),
                    'type'       => 'color',
                    'width'      => '100',
                    'conditions' => [
                        ['field' => 'cta_background_type', 'operator' => '==', 'value' => 'color'],
                    ],
                ],
            ],
        ]);
    }

    protected function getData(int|false $postId): array
    {
        return [
            'heading'          => $this->getMeta($postId, 'cta_heading') ?: null,
            'subheading'       => $this->getMeta($postId, 'cta_subheading') ?: null,
            'button_text'      => $this->getMeta($postId, 'cta_button_button_text') ?: '',
            'button_url'       => $this->getMeta($postId, 'cta_button_button_url') ?: '#',
            'button_new_tab'   => (string) $this->getMeta($postId, 'cta_button_button_new_tab') === '1',
            'background_type'  => $this->getMeta($postId, 'cta_background_type') ?: 'image',
            'image_id'         => (int) $this->getMeta($postId, 'cta_background_image'),
            'gradient_start'   => $this->getMeta($postId, 'cta_gradient_start') ?: '#004a98',
            'gradient_end'     => $this->getMeta($postId, 'cta_gradient_end') ?: '#003d7d',
            'background_color' => $this->getMeta($postId, 'cta_background_color') ?: '#004a98',
        ];
    }
}
