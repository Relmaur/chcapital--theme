<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\Testimonials;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class Testimonials extends MetaBlock
{
    protected string $id = 'testimonials';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'      => 'taw_testimonials',
            'title'   => __('Section - Testimonials', 'taw-theme'),
            'icon' => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screens' => ['page-credito-de-nomina.php', 'page-credito-pyme.php'],
            'fields'  => [
                [
                    'id'    => 'testimonials_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '100',
                ],
                [
                    'id'    => 'testimonials_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 2,
                    'width' => '100',
                ],
                [
                    'id'          => 'testimonials_is_slider',
                    'label'       => __('Display as slider', 'taw-theme'),
                    'type'        => 'checkbox',
                    'description' => __('Render testimonials as an Embla carousel instead of a static grid.', 'taw-theme'),
                    'width'       => '100',
                ],
                [
                    'id'     => 'testimonials_items',
                    'label'  => __('Testimonials', 'taw-theme'),
                    'type'   => 'repeater',
                    'layout' => 'tabbed_horizontal',
                    'button' => __('Add Testimonial', 'taw-theme'),
                    'fields' => [
                        [
                            'id'    => 'quote',
                            'label' => __('Quote', 'taw-theme'),
                            'type'  => 'textarea',
                            'rows'  => 4,
                            'width' => '100',
                        ],
                        [
                            'id'    => 'name',
                            'label' => __('Name', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '50',
                        ],
                        [
                            'id'    => 'role',
                            'label' => __('Role / Company', 'taw-theme'),
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
        $default_items = [
            [
                'quote' => __('Durante el tiempo que hemos trabajado en conjunto, hemos encontrado que los servicios que ofrece son claros, accesibles y bien valorados por nuestro personal.', 'taw-theme'),
                'name'  => 'Aline Rodríguez',
                'role'  => '',
            ],
            [
                'quote' => __('El servicio financiero es confiable y transparente desde la oferta del crédito hasta su culminación. Es gratificante que existan empresas así de confiables.', 'taw-theme'),
                'name'  => 'Valentín Hernández',
                'role'  => '',
            ],
            [
                'quote' => __('El servicio en préstamos ha sido muy eficiente y profesional. Definitivamente recomendaría a CH Capital con otras personas que busquen asesoría financiera.', 'taw-theme'),
                'name'  => 'Karen Valenzuela',
                'role'  => '',
            ],
            [
                'quote' => __('El servicio en préstamos ha sido muy eficiente y profesional. Definitivamente recomendaría a CH Capital con otras personas que busquen asesoría financiera.', 'taw-theme'),
                'name'  => 'Karen Valenzuela',
                'role'  => '',
            ],
            [
                'quote' => __('El servicio en préstamos ha sido muy eficiente y profesional. Definitivamente recomendaría a CH Capital con otras personas que busquen asesoría financiera.', 'taw-theme'),
                'name'  => 'Karen Valenzuela',
                'role'  => '',
            ],
        ];

        $items = $this->getRepeater($postId, 'testimonials_items');

        return [
            'heading'   => $this->getMeta($postId, 'testimonials_heading') ?: __('Descubre lo que nuestros clientes piensan de nosotros', 'taw-theme'),
            'subheading' => $this->getMeta($postId, 'testimonials_subheading'),
            'items'     => $items ?: $default_items,
            'is_slider' => $this->getMeta($postId, 'testimonials_is_slider') === '1',
        ];
    }
}
