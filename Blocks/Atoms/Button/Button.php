<?php

namespace TAW\Blocks\Atoms\Button;

use TAW\Core\Block\Block;

class Button extends Block
{
    protected string $id = 'button';

    protected function defaults(): array
    {
        return [
            'text'     => '',
            'url'      => '#',
            'variant'  => 'primary',  // primary | secondary | outline | ghost | white | outline-white
            'target'   => '_self',
            'size'     => 'md',       // sm | md | lg
            'class'    => '',         // additional CSS classes
            'download' => false,      // true = force-download (adds the `download` attribute + a download icon) instead of navigating
        ];
    }
}