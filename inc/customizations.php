<?php

/**
 * TAW Theme — Developer Customisations
 *
 * This is your file. It is never touched by `update-theme` — add whatever
 * site-specific hooks belong here. Loaded automatically by
 * TAW\Core\Theme\Theme::bootstrapFullSite() if it exists.
 */

use TAW\Core\Editor\VisualEditor;

require_once get_template_directory() . '/inc/multimedia-cpts.php';

/**
 * Enable the visual editor.
 */
VisualEditor::enable();

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

// Textdomain loading is handled by Theme::bootstrapFullSite() itself, on an
// earlier after_setup_theme priority than the callback above — don't add
// load_theme_textdomain() here, it would just double-load. It used to be
// wired to 'init' here, which ran even later than register_nav_menus()'
// __() calls above and reliably tripped WordPress 6.7+'s
// _load_textdomain_just_in_time doing_it_wrong notice on every request.

// add_action('wp_nav_menu_item_custom_fields', function($item_id) {
//     error_log('wp_nav_menu_item_custom_fields fired for item: ' . $item_id);
// }, 5, 1);

// add_action('wp_nav_menu_item_custom_fields', function($item_id) {
//     echo '<p style="background:yellow;padding:5px">TEST OUTPUT ' . $item_id . '</p>';
// }, 10, 1);
