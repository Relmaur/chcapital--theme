<?php

declare(strict_types=1);

namespace TAW\Blocks\Molecules\Partners;

use TAW\Core\Block\Block;

class Partners extends Block
{
    protected string $id = 'partners';

    protected function defaults(): array
    {
        return [
            'text' => '',
        ];
    }
}
