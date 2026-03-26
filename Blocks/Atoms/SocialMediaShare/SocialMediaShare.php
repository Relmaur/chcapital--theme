<?php

declare(strict_types=1);

namespace TAW\Blocks\Atoms\SocialMediaShare;

use TAW\Core\Block\Block;

class SocialMediaShare extends Block
{
    protected string $id = 'social_media_share';

    protected function defaults(): array
    {
        return [
            'article_url' => '',
            'post_id'     => 0,
        ];
    }
}
