<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\FAQs;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class FAQs extends MetaBlock
{
    protected string $id = 'faqs';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'     => 'taw_faqs',
            'title'  => 'FAQs',
            'screen' => 'page',
            'show_on' => static function (\WP_Post $post): bool {
                return (int) $post->ID === (int) get_option('page_on_front');
            },
            'fields' => [
                [
                    'id'          => 'faqs_section_id',
                    'label'       => __('Section ID', 'taw-theme'),
                    'type'        => 'text',
                    'description' => __('Optional unique ID for this section (without #). Useful for anchor links.', 'taw-theme'),
                    'width'       => '100',
                ],
                [
                    'id'    => 'faqs_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                ],
                [
                    'id'    => 'faqs_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 3,
                ],
                [
                    'id'     => 'faqs_items',
                    'label'  => __('FAQ Items', 'taw-theme'),
                    'type'   => 'repeater',
                    'button' => __('Add FAQ', 'taw-theme'),
                    'fields' => [
                        [
                            'id'    => 'question',
                            'label' => __('Question', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '100',
                        ],
                        [
                            'id'    => 'answer',
                            'label' => __('Answer', 'taw-theme'),
                            'type'  => 'textarea',
                            'rows'  => 4,
                            'width' => '100',
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        $default_faqs = [
            [
                'question' => __('¿Cuál es el plazo máximo para un crédito?', 'taw-theme'),
                'answer'   => __('Los plazos varían según el tipo de producto. Contáctanos para obtener información personalizada según tus necesidades.', 'taw-theme'),
            ],
            [
                'question' => __('¿Qué documentos necesito para solicitar un financiamiento?', 'taw-theme'),
                'answer'   => __('Los requisitos dependen del tipo de financiamiento. En general solicitamos identificación oficial, comprobante de domicilio y estados de cuenta recientes.', 'taw-theme'),
            ],
            [
                'question' => __('¿Cómo puedo saber qué producto es el adecuado para mí?', 'taw-theme'),
                'answer'   => __('Nuestros asesores están listos para orientarte. Puedes contactarnos por teléfono, correo o visitando cualquiera de nuestras sucursales.', 'taw-theme'),
            ],
        ];

        $items = Metabox::get_repeater($postId, 'faqs_items');

        return [
            'section_id'  => Metabox::get($postId, 'faqs_section_id'),
            'heading'     => $this->getMeta($postId, 'faqs_heading'),
            'subheading'  => $this->getMeta($postId, 'faqs_subheading'),
            'items'       => $items ?: $default_faqs,
        ];
    }
}
