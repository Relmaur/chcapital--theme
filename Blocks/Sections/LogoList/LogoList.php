<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\LogoList;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class LogoList extends MetaBlock
{
    protected string $id = 'logo_list_about';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'     => 'taw_logo_list_about',
            'title'  => __('Logo List Section', 'taw-theme'),
            'screen' => ['page-nosotros.php'],
            'show_on' => static function (\WP_Post $post): bool {
                return get_page_template_slug($post->ID) === 'page-about-us.php'
                    || in_array($post->post_name, ['nosotros', 'about-us'], true);
            },
            'fields' => [
                [
                    'id'    => 'logo_list_about_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '100',
                ],
                [
                    'id'    => 'logo_list_about_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 2,
                    'width' => '100',
                ],
                [
                    'id'     => 'logo_list_about_items',
                    'label'  => __('Logos', 'taw-theme'),
                    'type'   => 'repeater',
                    'button' => __('Add Logo', 'taw-theme'),
                    'fields' => [
                        [
                            'id'    => 'logo_image',
                            'label' => __('Logo', 'taw-theme'),
                            'type'  => 'image',
                            'width' => '40',
                        ],
                        [
                            'id'    => 'logo_name',
                            'label' => __('Name / Alt Text', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '40',
                        ],
                        [
                            'id'    => 'logo_url',
                            'label' => __('Link URL (optional)', 'taw-theme'),
                            'type'  => 'url',
                            'width' => '20',
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        $items = Metabox::get_repeater($postId, 'logo_list_about_items');

        return [
            'heading'    => $this->getMeta($postId, 'logo_list_about_heading') ?: __('Respaldados por los Mejores', 'taw-theme'),
            'subheading' => $this->getMeta($postId, 'logo_list_about_subheading') ?: __('Certificaciones, membresías y organismos que avalan nuestra operación.', 'taw-theme'),
            'items'      => $items ?: [],
        ];
    }
}
