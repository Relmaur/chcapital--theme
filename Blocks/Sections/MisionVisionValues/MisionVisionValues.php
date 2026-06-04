<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\MisionVisionValues;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class MisionVisionValues extends MetaBlock
{
    protected string $id = 'mision_vision_values';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'     => 'taw_mvv',
            'title'  => __('Section - Mission, Vision and Values', 'taw-theme'),
            'icon' => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screen' => ['page-nosotros.php'],
            'show_on' => static function (\WP_Post $post): bool {
                return get_page_template_slug($post->ID) === 'page-about-us.php'
                    || in_array($post->post_name, ['nosotros', 'about-us'], true);
            },
            'fields' => [
                [
                    'id'    => 'mvv_mision_heading',
                    'label' => __('Misión — Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '50',
                ],
                [
                    'id'    => 'mvv_mision_text',
                    'label' => __('Misión — Text', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 4,
                    'width' => '50',
                ],
                [
                    'id'    => 'mvv_vision_heading',
                    'label' => __('Visión — Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '50',
                ],
                [
                    'id'    => 'mvv_vision_text',
                    'label' => __('Visión — Text', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 4,
                    'width' => '50',
                ],
                [
                    'id'     => 'mvv_values',
                    'label'  => __('Valores', 'taw-theme'),
                    'type'   => 'repeater',
                    'button' => __('Add Value', 'taw-theme'),
                    'fields' => [
                        [
                            'id'    => 'value_title',
                            'label' => __('Title', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '50',
                        ],
                        [
                            'id'    => 'value_text',
                            'label' => __('Text', 'taw-theme'),
                            'type'  => 'textarea',
                            'rows'  => 2,
                            'width' => '50',
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected function getData(int|false $postId): array
    {
        $default_values = [
            ['value_title' => __('Colaborativo', 'taw-theme'),     'value_text' => __('Actuamos con honestidad y ética en cada decisión y operación financiera.', 'taw-theme')],
            ['value_title' => __('Asertivo', 'taw-theme'),      'value_text' => __('Construimos relaciones sólidas basadas en el cumplimiento de nuestros compromisos.', 'taw-theme')],
            ['value_title' => __('Perseverante', 'taw-theme'),     'value_text' => __('Desarrollamos soluciones financieras que se adaptan a las necesidades cambiantes del mercado.', 'taw-theme')],
            ['value_title' => __('Integro', 'taw-theme'),     'value_text' => __('Ponemos el éxito de nuestros clientes en el centro de todo lo que hacemos.', 'taw-theme')],
            ['value_title' => __('Trascendente', 'taw-theme'),     'value_text' => __('Ponemos el éxito de nuestros clientes en el centro de todo lo que hacemos.', 'taw-theme')],
            ['value_title' => __('Auténtico', 'taw-theme'),     'value_text' => __('Ponemos el éxito de nuestros clientes en el centro de todo lo que hacemos.', 'taw-theme')],
            ['value_title' => __('Leal', 'taw-theme'),     'value_text' => __('Ponemos el éxito de nuestros clientes en el centro de todo lo que hacemos.', 'taw-theme')],
        ];

        $values = Metabox::get_repeater($postId, 'mvv_values');

        return [
            'mision_heading' => $this->getMeta($postId, 'mvv_mision_heading') ?: __('Nuestra Misión', 'taw-theme'),
            'mision_text'    => $this->getMeta($postId, 'mvv_mision_text') ?: __('Inspirar la creación y promoción de soluciones estratégicas con amplia contribución organizacional, siendo exponencialmente eficientes y sistemáticos, orquestando una propuesta de valor insuperable para nuestros clientes.', 'taw-theme'),
            'vision_heading' => $this->getMeta($postId, 'mvv_vision_heading') ?: __('Nuestra Visión', 'taw-theme'),
            'vision_text'    => $this->getMeta($postId, 'mvv_vision_text') ?: __('Ser un agente de cambio en la vida de las personas y del desarrollo de las empresas, implementando nuestro modelo cooperativo “CAPITAL” fundamental.', 'taw-theme'),
            'values'         => $values ?: $default_values,
        ];
    }
}
