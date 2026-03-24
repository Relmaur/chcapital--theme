<?php

declare(strict_types=1);

namespace TAW\Blocks\Molecules\Menu;

use TAW\Core\Block\Block;

class Menu extends Block
{
    protected string $id = 'menu';

    protected function defaults(): array
    {
        return [
            'text' => '',
        ];
    }
}
