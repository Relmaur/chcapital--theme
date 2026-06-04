<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\OurTeam;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class OurTeam extends MetaBlock
{
    protected string $id = 'our_team';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'     => 'taw_our_team',
            'title'  => __('Section - Our Team', 'taw-theme'),
            'icon' => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screen' => ['page-nosotros.php'],
            'show_on' => static function (\WP_Post $post): bool {
                return get_page_template_slug($post->ID) === 'page-about-us.php'
                    || in_array($post->post_name, ['nosotros', 'about-us'], true);
            },
            'fields' => [
                [
                    'id'    => 'team_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '100',
                ],
                [
                    'id'    => 'team_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 2,
                    'width' => '100',
                ],
                [
                    'id'     => 'featured_member',
                    'label'  => __('Featured Member (CEO)', 'taw-theme'),
                    'type'   => 'group',
                    'fields' => [
                        [
                            'id'    => 'featured_image',
                            'label' => __('Photo', 'taw-theme'),
                            'type'  => 'image',
                            'width' => '30',
                        ],
                        [
                            'id'    => 'featured_name',
                            'label' => __('Name', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '35',
                        ],
                        [
                            'id'    => 'featured_position',
                            'label' => __('Position / Title', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '35',
                        ],
                        [
                            'id'    => 'featured_bio',
                            'label' => __('Bio', 'taw-theme'),
                            'type'  => 'textarea',
                            'rows'  => 4,
                            'width' => '70',
                        ],
                        [
                            'id'    => 'featured_linkedin',
                            'label' => __('LinkedIn URL', 'taw-theme'),
                            'type'  => 'url',
                            'width' => '30',
                        ],
                    ],
                ],
                [
                    'id'     => 'team_members',
                    'label'  => __('Team Members', 'taw-theme'),
                    'type'   => 'repeater',
                    'button' => __('Add Member', 'taw-theme'),
                    'fields' => [
                        [
                            'id'    => 'member_image',
                            'label' => __('Photo', 'taw-theme'),
                            'type'  => 'image',
                            'width' => '30',
                        ],
                        [
                            'id'    => 'member_name',
                            'label' => __('Name', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '35',
                        ],
                        [
                            'id'    => 'member_position',
                            'label' => __('Position', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '35',
                        ],
                        [
                            'id'    => 'member_bio',
                            'label' => __('Bio', 'taw-theme'),
                            'type'  => 'textarea',
                            'rows'  => 3,
                            'width' => '100',
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected function getData(int|false $postId): array
    {
        $default_members = [
            [
                'member_image'    => 0,
                'member_name'     => 'Miguel Pacheco<br />Pérez-Tello',
                'member_position' => __('Director Fiduciario', 'taw-theme'),
                'member_bio'      => __('Con más de 25 años de experiencia en el sector financiero mexicano, Miguel ha liderado CH Capital desde sus inicios con visión, integridad y un profundo compromiso con los clientes.', 'taw-theme'),
            ],
            [
                'member_image'    => 0,
                'member_name'     => 'Volga Del Riego',
                'member_position' => __('Directora Comercial', 'taw-theme'),
                'member_bio'      => __('Especialista en gestión de riesgos y optimización de procesos financieros. Su liderazgo garantiza la excelencia operativa en cada servicio que ofrecemos.', 'taw-theme'),
            ],
            [
                'member_image'    => 0,
                'member_name'     => 'Rocío González',
                'member_position' => __('Directora de Tesorería y oficial de cumplimiento', 'taw-theme'),
                'member_bio'      => __('Abogada financiera con especialización en derecho corporativo y fiduciario. Responsable de estructurar soluciones de fideicomiso a la medida de cada cliente.', 'taw-theme'),
            ],
            [
                'member_image'    => 0,
                'member_name'     => 'Eric Alfaro',
                'member_position' => __('Contraloría', 'taw-theme'),
                'member_bio'      => __('Abogado financiero con especialización en derecho corporativo y fiduciario. Responsable de estructurar soluciones de fideicomiso a la medida de cada cliente.', 'taw-theme'),
            ],
        ];

        $members = Metabox::get_repeater($postId, 'team_members');
        $featured_raw = $this->getMeta($postId, 'featured_member');

        $default_featured = [
            'featured_image'    => 0,
            'featured_name'     => 'Alfredo Chumacero Flores',
            'featured_position' => __('Director General', 'taw-theme'),
            // 'featured_bio'      => __('Con más de 25 años de experiencia en el sector financiero mexicano, Miguel ha liderado CH Capital desde sus inicios con visión, integridad y un profundo compromiso con los clientes.', 'taw-theme'),
            'featured_linkedin' => '',
        ];

        $featured = (!empty($featured_raw) && is_array($featured_raw)) ? $featured_raw : $default_featured;

        return [
            'heading'    => $this->getMeta($postId, 'team_heading') ?: __('Nuestro Equipo', 'taw-theme'),
            'subheading' => $this->getMeta($postId, 'team_subheading') ?: __('Profesionales comprometidos con tu éxito financiero.', 'taw-theme'),
            'featured'   => $featured,
            'members'    => $members ?: $default_members,
        ];
    }
}
