<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\TwoColumns;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class TwoColumns extends MetaBlock
{
    protected string $id = 'two_columns';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'     => 'taw_two_columns',
            'title'  => __('Section - Two Columns', 'taw-theme'),
            'icon' => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screen' => 'page',
            'fields' => [
                [
                    'id'    => 'two_columns_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                ],
                [
                    'id' => 'two_columns_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'text',
                ],
                [
                    'id' => 'two_columns_image',
                    'label' => __('Image', 'taw-theme'),
                    'type'  => 'image',
                ],
                [
                    'id' => 'two_columns_image_description',
                    'label' => __('Image Description', 'taw-theme'),
                    'type'  => 'text',
                ]
            ],
        ]);
    }

    protected function getData(int|false $postId): array
    {
        return [
            'heading' => $this->getMeta($postId, 'two_columns_heading') ?: '¿Dónde ofrecemos nuestros servicios?',
            'subheading' => $this->getMeta($postId, 'two_columns_subheading') ?: 'Actualmente brindamos nuestros servicios en la República Mexicana, con excepción de algunos estados donde por el momento no contamos con cobertura.',
            'image' => (int) $this->getMeta($postId, 'two_columns_image'),
            'image_description' => $this->getMeta($postId, 'two_columns_image_description') ?: '<strong>Estados sin cobertura actualmente:</strong> Michoacán, Sinaloa, Sonora, Tamaulipas, Colima y Guerrero.',
        ];
    }
}
