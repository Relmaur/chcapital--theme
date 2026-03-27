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
            'title'  => __('Misión, Visión y Valores', 'taw-theme'),
            'screen' => 'page',
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

    protected function getData(int $postId): array
    {
        $default_values = [
            ['value_title' => __('Integridad', 'taw-theme'),     'value_text' => __('Actuamos con honestidad y ética en cada decisión y operación financiera.', 'taw-theme')],
            ['value_title' => __('Confianza', 'taw-theme'),      'value_text' => __('Construimos relaciones sólidas basadas en el cumplimiento de nuestros compromisos.', 'taw-theme')],
            ['value_title' => __('Innovación', 'taw-theme'),     'value_text' => __('Desarrollamos soluciones financieras que se adaptan a las necesidades cambiantes del mercado.', 'taw-theme')],
            ['value_title' => __('Compromiso', 'taw-theme'),     'value_text' => __('Ponemos el éxito de nuestros clientes en el centro de todo lo que hacemos.', 'taw-theme')],
        ];

        $values = Metabox::get_repeater($postId, 'mvv_values');

        return [
            'mision_heading' => $this->getMeta($postId, 'mvv_mision_heading') ?: __('Nuestra Misión', 'taw-theme'),
            'mision_text'    => $this->getMeta($postId, 'mvv_mision_text') ?: __('Ofrecer soluciones financieras accesibles, confiables y personalizadas que impulsen el crecimiento de nuestros clientes, generando valor sostenible para todas las partes involucradas.', 'taw-theme'),
            'vision_heading' => $this->getMeta($postId, 'mvv_vision_heading') ?: __('Nuestra Visión', 'taw-theme'),
            'vision_text'    => $this->getMeta($postId, 'mvv_vision_text') ?: __('Ser la institución financiera de referencia en México, reconocida por su solidez, transparencia e impacto positivo en la vida económica de nuestros clientes y comunidades.', 'taw-theme'),
            'values'         => $values ?: $default_values,
        ];
    }
}
