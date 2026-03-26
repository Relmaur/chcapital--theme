<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\Legales;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class Legales extends MetaBlock
{
    protected string $id = 'legales';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'     => 'taw_legales',
            'title'  => __( 'Legales Section', 'taw-theme' ),
            'screen' => 'page',
            'fields' => [
                [
                    'id'    => 'legales_heading',
                    'label' => __( 'Heading', 'taw-theme' ),
                    'type'  => 'text',
                ],
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        return [
            'heading' => $this->getMeta($postId, 'legales_heading'),
        ];
    }
}
