<?php

/**
 * TAW Theme — Developer Customisations
 *
 * This is your file. It is never touched by `update-theme` — add whatever
 * site-specific hooks belong here. Loaded automatically by
 * TAW\Core\Theme\Theme::bootstrapFullSite() if it exists.
 */

use TAW\Core\Editor\VisualEditor;
use TAW\Support\EmailConfig;

require_once get_template_directory() . '/inc/multimedia-cpts.php';

/**
 * Enable the visual editor.
 */
// VisualEditor::enable();

/**
 * Route all wp_mail() through Emailit for deliverability (SPF/DKIM/DMARC
 * on chcapital.mx, configured in the Emailit dashboard — not here). A
 * true no-op unless EMAILIT_API_KEY is defined in wp-config.php, so this
 * stays safe to leave uncommented across environments that haven't set
 * the constant yet (e.g. before it's added to production wp-config.php).
 */
if (defined('EMAILIT_API_KEY')) {
    EmailConfig::useEmailit(
        apiKey:   EMAILIT_API_KEY,
        from:     defined('EMAILIT_FROM_EMAIL') ? EMAILIT_FROM_EMAIL : get_bloginfo('admin_email'),
        fromName: defined('EMAILIT_FROM_NAME') ? EMAILIT_FROM_NAME : '',
    );
}

// Media Folders is opt-in at the taw/core level, but ships active by
// default on every taw-theme site — remove this line if this site doesn't
// need nestable Media Library folders. Must run before Theme::boot().
TAW\Core\Media\MediaFolders::enable();

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
 * 301 redirect the old /fideicomisos/blog/ URL structure (previous site) to
 * the current /blog/ structure, preserving SEO value from indexed/linked
 * old URLs.
 *
 * /fideicomisos/blog(/page/N)?/  → /blog(/page/N)?/
 * /fideicomisos/{slug}/          → /blog/{slug}/
 */
add_action('template_redirect', function () {
    $path = trim((string) parse_url((string) $_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    if (! str_starts_with($path, 'fideicomisos/')) {
        return;
    }

    $rest = substr($path, strlen('fideicomisos/'));

    if ($rest === 'blog' || str_starts_with($rest, 'blog/')) {
        $destination = home_url('/' . $rest . '/');
    } else {
        $destination = home_url('/blog/' . $rest . '/');
    }

    wp_safe_redirect($destination, 301);
    exit;
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
