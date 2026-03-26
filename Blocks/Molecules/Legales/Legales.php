<?php

declare(strict_types=1);

namespace TAW\Blocks\Molecules\Legales;

use TAW\Core\Block\Block;

class Legales extends Block
{
    protected string $id = 'legales';

    protected function defaults(): array
    {
        return [
            'links' => [
                [
                    'text' => __('¿Quién regula y supervisa a las instituciones financieras?', 'taw-theme'),
                    'url'  => 'https://chcapital.mx/home/quien-regula-y-supervisa-a-las-instituciones-financieras/',
                ],
                [
                    'text' => __('¿Qué es el Buró de Entidades Financieras?', 'taw-theme'),
                    'url'  => 'https://chcapital.mx/home/buro-de-entidades-financieras/'
                ]
            ],
        ];
    }
}
