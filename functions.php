<?php

use TAW\Core\Theme\Theme;
use TAW\Support\ViteLoader;

/**
 * TAW Theme — Developer Customisations
 *
 * This is your file. Use the hooks below to configure the theme.
 * Core bootstrap lives in inc/init.php — update the theme to get the latest version.
 */

require_once get_template_directory() . '/vendor/autoload.php';

require_once get_template_directory() . '/inc/options.php';

Theme::boot();

// Block script.js files use ES module syntax (import/export).
// BaseBlock::enqueueDevAssets() calls wp_enqueue_script() directly and bypasses
// ViteLoader::enqueueAsset(), so block handles never land in $moduleHandles.
// This late hook repairs that: it runs after all blocks are enqueued and pushes
// every taw-block-* handle into the list that the addModuleType filter reads.
add_action('wp_enqueue_scripts', static function (): void {
    global $wp_scripts;
    foreach ((array) ($wp_scripts->queue ?? []) as $handle) {
        if (str_starts_with($handle, 'taw-block-')) {
            ViteLoader::$moduleHandles[] = $handle;
        }
    }
}, 999);

// Add the necessary hooks to configure the theme. See inc/init.php for available hooks and documentation.
Theme::performance(
    [
        'preconnect_origins' => [
            'https://fonts.googleapis.com',
            'https://fonts.gstatic.com',
        ],
        'preload_fonts'      => [
            'resources/fonts/Montserrat-Regular.woff2',
            'resources/fonts/Montserrat-Bold.woff2',
        ],
        'preconnect_origins' => [],
        'preload_fonts'      => [],
        'remove_emoji'       => true,
        'remove_meta_tags'   => true,
        'remove_oembed'      => true,
        'remove_bloat'       => true,
        'preload_hero_image' => true,
    ]
);

/**
 * CSS Studio — inject tawConfig so app.js can check the toggle.
 * Only emitted when the Vite dev server is active (vite_is_dev()).
 */
add_action('wp_head', function () {
    $is_dev = function_exists('vite_is_dev')
        ? vite_is_dev()
        : (bool) @fsockopen('localhost', 5173, $errno, $errstr, 0.1);

    if (! $is_dev) {
        return;
    }
    $enabled = (bool) \TAW\Core\OptionsPage\OptionsPage::get('css_studio_enabled');
    echo '<script>window.tawConfig = window.tawConfig || {}; window.tawConfig.cssStudioEnabled = ' . ($enabled ? 'true' : 'false') . ';</script>' . PHP_EOL;
}, 1);

/**
 * Route all posts under /blog/.
 *
 * /blog/          → home.php         (WordPress handles this natively via page_for_posts)
 * /blog/page/N/   → home.php         (WordPress handles pagination natively)
 * /blog/{slug}/   → single-post.php  (our custom rule — WP doesn't know about this prefix)
 */
add_action('init', function () {
    add_rewrite_rule('^blog/([^/]+)/?$', 'index.php?name=$matches[1]', 'top');
});

add_filter('post_link', function (string $_permalink, WP_Post $post): string {
    return home_url('/blog/' . $post->post_name . '/');
}, 10, 2);

// WordPress's redirect_canonical() can misfire on the posts page and redirect
// to / when get_permalink(page_for_posts) doesn't resolve as expected.
add_filter('redirect_canonical', function (?string $redirect_url): ?string {
    if (is_home() && ! is_front_page()) {
        return null;
    }
    return $redirect_url;
});

/**
 * Customize here:
 */
add_action('admin_init', function () {
    remove_post_type_support('page', 'editor');
});

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('align-wide');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    register_nav_menus([
        'primary' => __('Primary Menu', 'taw-theme'),
        'footer'  => __('Footer Menu', 'taw-theme'),
    ]);
});

add_action('after_setup_theme', function () {
    load_theme_textdomain('taw-theme', get_template_directory() . '/languages');
}, 1);

// add_action('wp_nav_menu_item_custom_fields', function($item_id) {
//     error_log('wp_nav_menu_item_custom_fields fired for item: ' . $item_id);
// }, 5, 1);

// add_action('wp_nav_menu_item_custom_fields', function($item_id) {
//     echo '<p style="background:yellow;padding:5px">TEST OUTPUT ' . $item_id . '</p>';
// }, 10, 1);