<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\HeroStandard;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;
use TAW\Helpers\Image;

class HeroStandard extends MetaBlock
{
    protected string $id = 'hero_standard';

    protected function registerMetaboxes(): void
    {
        // Inject preload tag into <head> for LCP — runs before wp_head fires
        // because blocks are queued before get_header().
        if (!is_admin()) {
            add_action('wp_head', function () {
                $image_id = (int) $this->getMeta(get_the_ID(), 'hero_standard_image');
                if ($image_id) {
                    echo Image::preload_tag($image_id, 'full'); // phpcs:ignore
                }
            }, 2);
        }

        new Metabox([
            'id'     => 'taw_hero_standard',
            'title'  => __('Section - Standard Hero', 'taw-theme'),
            'icon' => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screens' => ['page-nosotros.php', 'page-credito-pyme.php', 'page-fideicomisos.php', 'page-arrendamiento-puro.php', 'page-credito-de-nomina.php', 'page-escrow.php', 'page-multimedia.php', 'page-contacto.php', 'home.php', 'page-quien-regula-y-supervisa-a-las-instituciones-financieras.php', 'page-buro-de-entidades-financieras.php'], // only show on specific templates
            // 'show_on' => static function (\WP_Post $post): bool {
            //     return get_page_template_slug($post->ID) === 'page-nosotros.php'
            //         || in_array($post->post_name, ['nosotros', 'about-us'], true);
            // },
            'fields' => [
                [
                    'id'    => 'hero_standard_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '50',
                ],
                [
                    'id'    => 'hero_standard_subtitle',
                    'label' => __('Subtitle', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 3,
                    'width' => '50',
                ],
                [
                    'id'    => 'hero_standard_image',
                    'label' => __('Background Image', 'taw-theme'),
                    'type'  => 'image',
                    'width' => '100',
                ],
                [
                    'id'          => 'hero_standard_cta',
                    'label'       => __('CTA Button (optional)', 'taw-theme'),
                    'type'        => 'group',
                    'description' => __('Optional button shown below the title. Leave the label empty to hide it.', 'taw-theme'),
                    'fields'      => [
                        ['id' => 'label',    'label' => __('Label', 'taw-theme'),           'type' => 'text', 'width' => '50'],
                        ['id' => 'url',      'label' => __('URL', 'taw-theme'),             'type' => 'text',  'width' => '50'],
                        [
                            'id'      => 'new_tab',
                            'label'   => __('Open in new tab', 'taw-theme'),
                            'type'    => 'checkbox',
                            'width'   => '50',
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected function getData(int|false $postId): array
    {
        // Group sub-fields are stored as flat, individually-prefixed meta keys
        // (_taw_hero_standard_cta_label, …), not as an array under the group id.
        $ctaLabel = (string) $this->getMeta($postId, 'hero_standard_cta_label');
        $ctaUrl   = (string) $this->getMeta($postId, 'hero_standard_cta_url');
        $cta_variant = (string) $this->getMeta($postId, 'hero_standard_cta_variant');

        $ctaData = null;
        if ($ctaLabel !== '' && $ctaUrl !== '') {
            $ctaData = [
                'label'  => $ctaLabel,
                'url'    => $ctaUrl,
                'target' => $this->getMeta($postId, 'hero_standard_cta_new_tab') === '1' ? '_blank' : '_self',
                'variant' => $cta_variant ?: 'white',
            ];
        }

        return [
            'heading'  => $this->getMeta($postId, 'hero_standard_heading') ?: null,
            'subtitle' => $this->getMeta($postId, 'hero_standard_subtitle') ?: null,
            'image_id' => (int) $this->getMeta($postId, 'hero_standard_image'),
            'cta'      => $ctaData,
        ];
    }
}
