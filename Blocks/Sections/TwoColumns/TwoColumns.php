<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\TwoColumns;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class TwoColumns extends MetaBlock
{
    protected string $id = 'two_columns';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'     => 'taw_two_columns',
            'title'  => __('TwoColumns Section', 'taw-theme'),
            'screen' => [],
            'fields' => [
                [
                    'id'    => 'two_columns_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                ],
                [
                    'id'    => 'two_columns_content',
                    'label' => __('Content', 'taw-theme'),
                    'type'  => 'textarea',
                ],
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        return [
            'heading' => $this->getMeta($postId, 'two_columns_heading'),
            'content' => $this->getMeta($postId, 'two_columns_content'),
        ];
    }
}
