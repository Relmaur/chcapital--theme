<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\LinkList;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class LinkList extends MetaBlock
{
    protected string $id = 'link_list';

    public static function variations(): array
    {
        return ['financiera', 'fideicomisos']; // registers 'link_list--financiera' and 'link_list--fideicomisos'
    }

    protected function registerMetaboxes(): void
    {
        $s = $this->variation ? '_' . $this->variation : '';

        new Metabox([
            'id'     => 'taw_link_list' . $s,
            'title' => 'Link List' . ($s ? ' (' . ucfirst($this->variation) . ')' : ''),
            'icon' => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screen' => 'page',
            'show_on' => static function (\WP_Post $post): bool {
                return (int) $post->ID === (int) get_option('page_on_front');
            },
            'fields' => [
                [
                    'id'    => 'link_list_section_id' . $s,
                    'label' => __('Section ID', 'taw-theme'),
                    'type'  => 'text',
                    'description' => __('Optional unique ID for this section (without #). Useful for anchor links and styling.', 'taw-theme'),
                    'width' => '100',
                ],
                [
                    'id'    => 'link_list_heading' . $s,
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                ],
                [
                    'id'    => 'link_list_link_type' . $s,
                    'label' => __('Link Type', 'taw-theme'),
                    'type'  => 'select',
                    'options' => [
                        'icon' => __('Icon', 'taw-theme'),
                        'blurb' => __('Blurb', 'taw-theme'),
                    ],
                ],
                [
                    'id'     => 'link_list' . $s,
                    'label'  => __('Links', 'taw-theme'),
                    'type'   => 'repeater',
                    'button' => __('Add Link', 'taw-theme'),
                    'fields' => [
                        [
                            'id'    => 'text',
                            'label' => __('Link Text', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '50',
                        ],
                        [
                            'id'    => 'url',
                            'label' => __('Link URL', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '50',
                        ],
                        [
                            'id'          => 'icon',
                            'type'        => 'textarea',
                            'label'       => 'SVG Icon',
                            'description' => 'Paste the full SVG markup for this menu item\'s icon.',
                            'placeholder' => '<svg xmlns="http://www.w3.org/2000/svg" ...>...</svg>',
                            'sanitize'    => 'code',
                            'rows'        => 4,
                        ],
                    ],
                ]
            ],
        ]);
    }

    protected function getData(int|false $postId): array
    {
        $s = $this->variation ? '_' . $this->variation : '';

        // dump($this->variation);

        $default_icon = <<<'SVG'
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
            <path fill-rule="evenodd" d="M15.75 2.25H21a.75.75 0 0 1 .75.75v5.25a.75.75 0 0 1-1.5 0V4.81L8.03 17.03a.75.75 0 0 1-1.06-1.06L19.19 3.75h-3.44a.75.75 0 0 1 0-1.5Zm-10.5 4.5a1.5 1.5 0 0 0-1.5 1.5v10.5a1.5 1.5 0 0 0 1.5 1.5h10.5a1.5 1.5 0 0 0 1.5-1.5V10.5a.75.75 0 0 1 1.5 0v8.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V8.25a3 3 0 0 1 3-3h8.25a.75.75 0 0 1 0 1.5H5.25Z" clip-rule="evenodd" />
        </svg>
        SVG;

        $default_links = [
            [
                'text' => __('Crédito PYME', 'taw-theme'),
                'url'  => '#',
                'icon' => $default_icon,
            ],
            [
                'text' => __('Arrendamiento Puro', 'taw-theme'),
                'url'  => '#',
                'icon' => $default_icon,
            ],
            [
                'text' => __('Crédito Personal', 'taw-theme'),
                'url'  => '#',
                'icon' => $default_icon,
            ]
        ];

        $links = Metabox::get_repeater($postId, 'link_list' . $s);

        return [
            'section_id' => Metabox::get($postId, 'link_list_section_id' . $s),
            'heading' => $this->getMeta($postId, 'link_list_heading' . $s),
            'links' => $links ?: $default_links,
        ];
    }
}
