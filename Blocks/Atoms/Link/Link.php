<?php

declare(strict_types=1);

namespace TAW\Blocks\Atoms\Link;

use TAW\Core\Block\Block;

class Link extends Block
{
    protected string $id = 'link';

    protected function defaults(): array
    {
        return [
            'text' => '',
        ];
    }
}
