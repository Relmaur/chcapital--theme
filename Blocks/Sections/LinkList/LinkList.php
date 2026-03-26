<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\LinkList;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class LinkList extends MetaBlock
{
    protected string $id = 'link_list';

    public static function variations(): array
    {
        return ['financiera', 'fideicomisos']; // registers 'link_list--financiera' and 'link_list--fideicomisos'
    }

    protected function registerMetaboxes(): void
    {
        $s = $this->variation ? '_' . $this->variation : '';

        new Metabox([
            'id'     => 'taw_link_list' . $s,
            'title' => 'Link List' . ($s ? ' (' . ucfirst($this->variation) . ')' : ''),
            'screen' => 'page',
            'fields' => [
                [
                    'id'    => 'link_list_heading' . $s,
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                ],
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        $s = $this->variation ? '_' . $this->variation : '';

        return [
            'heading' => $this->getMeta($postId, 'link_list_heading' . $s),
        ];
    }
}
