<?php

declare(strict_types=1);

namespace TAW\Blocks\Molecules\SummarizeWithAI;

use TAW\Core\Block\Block;

class SummarizeWithAI extends Block
{
    protected string $id = 'summarize_with_a_i';

    protected function defaults(): array
    {
        return [
            'article_url' => '',
            'prompt' => '',
        ];
    }
}
