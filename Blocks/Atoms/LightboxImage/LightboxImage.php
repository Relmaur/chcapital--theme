<?php

declare(strict_types=1);

namespace TAW\Blocks\Atoms\LightboxImage;

use TAW\Core\Block\Block;

class LightboxImage extends Block
{
    protected string $id = 'lightbox_image';

    protected function defaults(): array
    {
        return [
            'image_id'        => 0,
            'alt'             => '',
            'caption'         => '',
            'display_size'    => 'large',
            'full_url'        => '',
            'full_width'      => 0,
            'full_height'     => 0,
            'is_gallery_item' => false, // true = skip data-pswp-gallery wrapper (parent handles it)
            'class'           => '',
        ];
    }
}
