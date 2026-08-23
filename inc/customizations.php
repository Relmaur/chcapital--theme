<?php

/**
 * TAW Theme — Developer Customisations
 *
 * This is your file. It is never touched by `update-theme` — add whatever
 * site-specific hooks belong here. Loaded automatically by
 * TAW\Core\Theme\Theme::bootstrapFullSite() if it exists.
 */

use TAW\Core\Editor\VisualEditor;
use TAW\Core\Form\Form;
use TAW\Support\EmailConfig;

require_once get_template_directory() . '/inc/multimedia-cpts.php';

/**
 * Enable the visual editor.
 */
// VisualEditor::enable();

/**
 * Prints get_the_date() localized to Spanish month/weekday names.
 *
 * The site's active WP locale is en_US even though every piece of copy on
 * this theme is hardcoded Spanish — get_the_date() still asks WordPress
 * core's OWN translations (the 'default' textdomain, via WP_Locale) for
 * month/day names, which only exist per the *active* site locale. Scoped
 * to just this call via switch_to_locale() rather than activating es_MX
 * site-wide, which would also flip the wp-admin UI to Spanish for every
 * user. es_MX's core language pack is already installed on this site.
 */
function taw_theme_the_date_es(): void
{
    switch_to_locale('es_MX');
    echo esc_html(get_the_date());
    restore_previous_locale();
}

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
 * Post Publisher — front-end post submission screen at /publicar/,
 * gated by TAW_POST_PUBLISHER_PASSWORD (see wp-config.php and
 * page-publicar.php, which calls TAW\Core\Auth\PagePassword::protect()
 * before rendering this form). Submissions are always saved as 'pending' —
 * an editor reviews and publishes from wp-admin, this never publishes
 * directly.
 */
add_action('init', static function () {
    $categoryOptions = [];
    foreach (get_categories(['hide_empty' => false]) as $category) {
        $categoryOptions[$category->term_id] = $category->name;
    }

    Form::register([
        'id'           => 'post_publisher',
        'submit_label' => __('Enviar publicación', 'taw-theme'),
        'rate_limit'   => ['max' => 5, 'window' => 300],
        'messages'     => [
            'success' => __('¡Gracias! Tu publicación fue enviada y quedará pendiente de revisión.', 'taw-theme'),
        ],
        'fields' => [
            ['id' => 'post_title', 'label' => __('Título', 'taw-theme'), 'type' => 'text', 'required' => true, 'max_length' => 200],
            ['id' => 'post_content', 'label' => __('Contenido', 'taw-theme'), 'type' => 'wysiwyg', 'required' => true],
            ['id' => 'categories', 'label' => __('Categorías', 'taw-theme'), 'type' => 'checkbox_group', 'options' => $categoryOptions],
        ],
        'on_submit' => static function (array $data): void {
            $admins   = get_users(['role' => 'administrator', 'number' => 1, 'orderby' => 'ID', 'order' => 'ASC']);
            $authorId = !empty($admins) ? (int) $admins[0]->ID : 1;

            $postId = wp_insert_post([
                'post_type'    => 'post',
                'post_status'  => 'pending',
                'post_title'   => $data['post_title'] ?? '',
                'post_content' => $data['post_content'] ?? '',
                'post_author'  => $authorId,
            ], true);

            if (is_wp_error($postId)) {
                throw new RuntimeException(__('No pudimos guardar la publicación. Inténtalo de nuevo.', 'taw-theme'));
            }

            if (!empty($data['categories'])) {
                wp_set_post_categories($postId, array_map('intval', explode(',', (string) $data['categories'])));
            }
        },
    ]);
});

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

/**
 * Async-load two specific render-blocking stylesheets flagged by a live
 * Lighthouse audit (2026-07-31): the main compiled app stylesheet
 * (`theme-app-style`, handle from ViteLoader) and the Form system's CSS
 * (`taw-form`, handle from taw/core's Form::enqueueAssets()). Every
 * per-block Vite stylesheet already uses this media="print" + onload
 * swap pattern (see BaseBlock::enqueueProdAssets()) — these two just
 * happen to be enqueued outside that per-block path, so they were still
 * loading as plain synchronous <link> tags.
 *
 * Runs at a late priority so it operates on the tag AFTER Hummingbird's
 * own style_loader_tag filter has already rewritten the href to its
 * hb.wpmucdn.com CDN URL — reconstructing from the raw $href parameter
 * here would silently discard that rewrite and revert to the origin URL.
 */
add_filter('style_loader_tag', function (string $html, string $handle, string $href, string $media): string {
    if (! in_array($handle, ['theme-app-style', 'taw-form'], true)) {
        return $html;
    }

    $url = preg_match('/href=[\'"]([^\'"]+)[\'"]/', $html, $matches) ? $matches[1] : $href;

    return sprintf(
        '<link rel="stylesheet" id="%1$s-css" href="%2$s" media="print" onload="this.media=\'all\'">' . "\n"
            . '<noscript><link rel="stylesheet" id="%1$s-css" href="%2$s"></noscript>' . "\n",
        esc_attr($handle),
        esc_url($url)
    );
}, 100, 4);

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
