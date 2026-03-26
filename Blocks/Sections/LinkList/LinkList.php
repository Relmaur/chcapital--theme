<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\LinkList;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class LinkList extends MetaBlock
{
    protected string $id = 'link_list';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'     => 'taw_link_list',
            'title'  => __( 'LinkList Section', 'taw-theme' ),
            'screen' => 'page',
            'fields' => [
                [
                    'id'    => 'link_list_heading',
                    'label' => __( 'Heading', 'taw-theme' ),
                    'type'  => 'text',
                ],
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        return [
            'heading' => $this->getMeta($postId, 'link_list_heading'),
        ];
    }
}
