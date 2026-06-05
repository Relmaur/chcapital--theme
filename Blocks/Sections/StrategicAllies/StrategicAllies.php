<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\StrategicAllies;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class StrategicAllies extends MetaBlock
{
    protected string $id = 'strategic_allies';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'     => 'taw_strategic_allies',
            'title'  => __('Section - Strategic Allies', 'taw-theme'),
            'icon' => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screen' => ['page-nosotros.php'],
            'show_on' => static function (\WP_Post $post): bool {
                return get_page_template_slug($post->ID) === 'page-about-us.php'
                    || in_array($post->post_name, ['nosotros', 'about-us'], true);
            },
            'fields' => [
                [
                    'id'    => 'allies_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '50',
                ],
                [
                    'id'    => 'allies_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '50',
                ],
                [
                    'id'     => 'allies_logos',
                    'label'  => __('Ally Logos', 'taw-theme'),
                    'type'   => 'repeater',
                    'button' => __('Add Logo', 'taw-theme'),
                    'fields' => [
                        [
                            'id'    => 'ally_logo',
                            'label' => __('Logo', 'taw-theme'),
                            'type'  => 'image',
                            'width' => '33',
                        ],
                        [
                            'id'    => 'ally_name',
                            'label' => __('Name / Alt Text', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '33',
                        ],
                        [
                            'id'    => 'ally_url',
                            'label' => __('URL', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '34',
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected function getData(int|false $postId): array
    {
        $logos = Metabox::get_repeater($postId, 'allies_logos');

        $default_logos = [
            [
                'ally_logo' => 5495,
                'ally_name' => 'Ilexlu',
                'ally_url'  => 'https://ilexlu.mx/',
            ],
            [
                'ally_logo' => 5496,
                'ally_name' => 'Legal Solutions 1',
                'ally_url'  => 'https://legalsolutions1.com.mx/',
            ],
            [
                'ally_logo' => 5497,
                'ally_name' => 'Abogadomex',
                'ally_url'  => 'https://abogadomex.com/',
            ],
            [
                'ally_logo' => 5498,
                'ally_name' => 'Ruiz Consultores',
                'ally_url'  => 'https://ruizconsultores.com.mx/',
            ],
            [
                'ally_logo' => 5499,
                'ally_name' => 'Face Advisors',
                'ally_url'  => 'https://faceadvisors.com/',
            ],
            [
                'ally_logo' => 5500,
                'ally_name' => 'KBB Marketing',
                'ally_url'  => 'https://kbb.com.mx/',
            ],
            [
                'ally_logo' => 5501,
                'ally_name' => 'Bechapra',
                'ally_url'  => 'https://bechapra.com/',
            ],
            [
                'ally_logo' => 5502,
                'ally_name' => 'Hegewisch',
                'ally_url'  => 'https://hegewisch.com.mx/',
            ],
            [
                'ally_logo' => 5503,
                'ally_name' => 'Scotiabank',
                'ally_url'  => 'https://www.scotiabank.com.mx/',
            ],
            [
                'ally_logo' => 5504,
                'ally_name' => 'Bonsaif',
                'ally_url'  => 'https://www.bonsaif.online/',
            ],
            [
                'ally_logo' => 5505,
                'ally_name' => 'SBS Consultoria',
                'ally_url'  => 'https://www.sbsconsultoria.mx/',
            ],
            [
                'ally_logo' => 5506,
                'ally_name' => 'Consultores OC',
                'ally_url'  => 'https://consultoresoc.com.mx/',
            ],
            [
                'ally_logo' => 5507,
                'ally_name' => 'Algorithia',
                'ally_url'  => 'https://www.algorithia.com/',
            ],
        ];

        return [
            'heading'    => $this->getMeta($postId, 'allies_heading') ?: __('Aliados estratégicos', 'taw-theme'),
            'subheading' => $this->getMeta($postId, 'allies_subheading') ?: null,
            'logos'      => $logos ?: $default_logos,
        ];
    }
}
