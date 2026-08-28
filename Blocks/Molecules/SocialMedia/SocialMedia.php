<?php

declare(strict_types=1);

namespace TAW\Blocks\Molecules\SocialMedia;

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
        $socialWa      = OptionsPage::get('social_whatsapp');

        $social_media_array = [
            'facebook'  => $socialFb,
            'instagram' => $socialIg,
            'twitter'   => $socialTw,
            'linkedin'  => $socialLi,
            'youtube'   => $socialYt,
            'whatsapp'  => $socialWa,
        ];

        return [
            'social_media' => $social_media_array,
            'only'         => [], // pass ['facebook', 'twitter'] to limit which icons render
        ];
    }
}
