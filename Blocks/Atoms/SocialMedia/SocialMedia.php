<?php

declare(strict_types=1);

namespace TAW\Blocks\Atoms\SocialMedia;

use TAW\Core\Block\Block;
use TAW\Core\OptionsPage\OptionsPage;

class SocialMedia extends Block
{
    protected string $id = 'social_media';

    protected function defaults(): array
    {

        $socialFb      = OptionsPage::get('social_facebook');
        $socialIg      = OptionsPage::get('social_instagram');
        $socialTw      = OptionsPage::get('social_twitter');
        $socialLi      = OptionsPage::get('social_linkedin');
        $socialYt      = OptionsPage::get('social_youtube');

        $social_media_array = [
            'facebook'  => $socialFb,
            'instagram' => $socialIg,
            'twitter'   => $socialTw,
            'linkedin'  => $socialLi,
            'youtube'   => $socialYt,
        ];

        return [
            'social_media' => $social_media_array,
            'only'         => [], // pass ['facebook', 'twitter'] to limit which icons render
        ];
    }
}
