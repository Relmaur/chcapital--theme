<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\HighlightsRow;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

/**
 * HighlightsRow — a horizontal row of icon + title + description cards.
 *
 * Reusable on any page that needs a "key benefits / features / promises" strip.
 * Unlike BlurbsGrid (photo cards) or ChangingNumbers (statistics), this block
 * uses a predefined set of inline SVG icons for qualitative highlights.
 */
class HighlightsRow extends MetaBlock
{
    protected string $id = 'highlights_row';

    /** Add new template slugs here to expose the metabox on additional pages. */
    private const SCREENS = [
        'page-contacto.php',
        'page-nosotros.php',
    ];

    /** Predefined icon set available in the admin select field. */
    public static function iconOptions(): array
    {
        return [
            'clock'    => __('Reloj — Respuesta rápida', 'taw-theme'),
            'shield'   => __('Escudo — Seguridad', 'taw-theme'),
            'check'    => __('Paloma — Calidad', 'taw-theme'),
            'users'    => __('Personas — Equipo', 'taw-theme'),
            'star'     => __('Estrella — Excelencia', 'taw-theme'),
            'lock'     => __('Candado — Confidencialidad', 'taw-theme'),
            'chart'    => __('Gráfica — Crecimiento', 'taw-theme'),
            'document' => __('Documento — Proceso', 'taw-theme'),
            'phone'    => __('Teléfono — Contacto', 'taw-theme'),
            'heart'    => __('Corazón — Compromiso', 'taw-theme'),
        ];
    }

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'      => 'taw_highlights_row',
            'title'   => __('Section - Highlights Row', 'taw-theme'),
            'icon'    => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screens' => self::SCREENS,
            'fields'  => [
                [
                    'id'    => 'highlights_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '50',
                ],
                [
                    'id'    => 'highlights_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 2,
                    'width' => '50',
                ],
                [
                    'id'     => 'highlights_items',
                    'label'  => __('Highlights', 'taw-theme'),
                    'type'   => 'repeater',
                    'button' => __('Add Highlight', 'taw-theme'),
                    'layout' => 'tabbed_horizontal',
                    'max'    => 6,
                    'fields' => [
                        [
                            'id'      => 'icon',
                            'label'   => __('Icon', 'taw-theme'),
                            'type'    => 'select',
                            'options' => self::iconOptions(),
                            'width'   => '50',
                        ],
                        [
                            'id'    => 'title',
                            'label' => __('Title', 'taw-theme'),
                            'type'  => 'text',
                            'width' => '50',
                        ],
                        [
                            'id'    => 'description',
                            'label' => __('Description', 'taw-theme'),
                            'type'  => 'textarea',
                            'rows'  => 2,
                            'width' => '100',
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected function getData(int|false $postId): array
    {
        $rows = $this->getRepeater($postId, 'highlights_items');

        $defaults = [
            [
                'icon'        => 'clock',
                'title'       => __('Respuesta en 24 horas', 'taw-theme'),
                'description' => __('Un asesor te contactará dentro de las próximas 24 horas hábiles.', 'taw-theme'),
            ],
            [
                'icon'        => 'shield',
                'title'       => __('Información segura', 'taw-theme'),
                'description' => __('Tus datos están protegidos bajo estrictas políticas de confidencialidad.', 'taw-theme'),
            ],
            [
                'icon'        => 'users',
                'title'       => __('Asesoría personalizada', 'taw-theme'),
                'description' => __('Diseñamos la solución financiera que mejor se adapta a tu empresa.', 'taw-theme'),
            ],
            [
                'icon'        => 'chart',
                'title'       => __('Más de 20 años de experiencia', 'taw-theme'),
                'description' => __('Respaldo y trayectoria en el sector financiero mexicano.', 'taw-theme'),
            ],
        ];

        $items = array_map(static function (array $row): array {
            return [
                'icon'        => $row['icon']        ?? 'check',
                'title'       => $row['title']       ?? '',
                'description' => $row['description'] ?? '',
            ];
        }, $rows ?: $defaults);

        return [
            'heading'    => $this->getMeta($postId, 'highlights_heading'),
            'subheading' => $this->getMeta($postId, 'highlights_subheading'),
            'items'      => array_filter($items, fn($item) => !empty($item['title'])),
        ];
    }
}
