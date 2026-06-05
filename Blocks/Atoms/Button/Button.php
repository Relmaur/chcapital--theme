<?php

namespace TAW\Blocks\Atoms\Button;

use TAW\Core\Block\Block;

class Button extends Block
{
    protected string $id = 'button';

    protected function defaults(): array
    {
        return [
            'text'    => '',
            'url'     => '#',
            'variant' => 'primary',  // primary | secondary | outline | ghost | white | outline-white
            'target'  => '_self',
            'size'    => 'md',       // sm | md | lg
        ];
    }
}