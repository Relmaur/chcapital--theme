<?php

use TAW\Core\OptionsPage\OptionsPage;

new OptionsPage([
    'id'         => 'taw_settings',
    'title'      => __('TAW Settings', 'taw-theme'),
    'menu_title' => __('TAW Settings', 'taw-theme'),
    'icon'       => 'dashicons-screenoptions',
    'position'   => 2,
    'fields'     => [
        ['id' => 'company_name',  'label' => __('Company Name', 'taw-theme'),      'type' => 'text', 'width' => '50'],
        ['id' => 'company_phone', 'label' => __('Phone Number', 'taw-theme'),      'type' => 'text', 'width' => '50'],
        ['id' => 'company_email', 'label' => __('Email Address', 'taw-theme'),     'type' => 'text', 'width' => '50'],
        ['id' => 'company_address', 'label' => __('Address', 'taw-theme'),        'type' => 'wysiwyg', 'width' => '50'],
        ['id' => 'footer_text',   'label' => __('Footer Copyright', 'taw-theme'),  'type' => 'textarea'],
        ['id' => 'social_facebook',  'label' => __('Facebook URL', 'taw-theme'),   'type' => 'url'],
        ['id' => 'social_instagram', 'label' => __('Instagram URL', 'taw-theme'),  'type' => 'url'],
        ['id' => 'social_twitter',   'label' => __('X (Twitter) URL', 'taw-theme'), 'type' => 'url'],
        ['id' => 'social_linkedin',  'label' => __('LinkedIn URL', 'taw-theme'),   'type' => 'url'],
        ['id' => 'social_youtube',   'label' => __('YouTube URL', 'taw-theme'),    'type' => 'url'],
    ],
    'tabs' => [
        ['id' => 'general', 'label' => __('General', 'taw-theme'), 'fields' => ['company_name', 'company_phone', 'company_email', 'company_address']],
        ['id' => 'footer',  'label' => __('Footer', 'taw-theme'),  'fields' => ['footer_text']],
        ['id' => 'social',  'label' => __('Social', 'taw-theme'),  'fields' => ['social_facebook', 'social_instagram', 'social_twitter', 'social_linkedin', 'social_youtube']],
    ],
]);
