<?php

declare(strict_types=1);

namespace TAW\Blocks\Molecules\Menu;

use TAW\Core\Block\Block;
use TAW\Core\Metabox\Metabox;

class Menu extends Block
{
    protected string $id = 'menu';

    public static function boot(): void
    {
        error_log('Menu::boot() called');
        new Metabox([
            'id'    => 'menu_item_icon',
            'title' => 'Menu Item Icon',
            'type'  => 'nav_menu',
            'fields' => [
                [
                    'id'          => 'menu_item_icon',
                    'type'        => 'textarea',
                    'label'       => 'SVG Icon',
                    'description' => 'Paste the full SVG markup for this menu item\'s icon.',
                    'placeholder' => '<svg xmlns="http://www.w3.org/2000/svg" ...>...</svg>',
                    'sanitize'    => 'code',
                    'rows'        => 4,
                ],
            ],
        ]);
    }

    // constructor no longer needed (or keep it if you have other render-time setup)

    protected function defaults(): array
    {
        return ['text' => ''];
    }
}
