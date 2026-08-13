<?php

/**
 * TAW Theme — Performance Configuration
 *
 * This is your file. It is never touched by `update-theme`. Returned array
 * is passed to TAW\Core\Theme\Theme::performance() by bootstrapFullSite().
 * See TAW\Support\Performance::configure() (taw/core) for the full option list.
 */

return [
    'preconnect_origins' => [],
    // Only the weight/style combinations actually used above the fold:
    // Regular (body copy), Medium (CTA button), SemiBold (nav links), Bold (hero <strong>).
    'preload_fonts'      => [
        'resources/fonts/Montserrat-Regular.woff2',
        'resources/fonts/Montserrat-Medium.woff2',
        'resources/fonts/Montserrat-SemiBold.woff2',
        'resources/fonts/Montserrat-Bold.woff2',
    ],
    'remove_emoji'       => true,
    'remove_meta_tags'   => true,
    'remove_oembed'      => true,
    'remove_bloat'       => true,
    'preload_hero_image' => true,
];
