<?php

/**
 * Template Name: Post Publisher
 *
 * Password-gated front-end screen for submitting new blog posts.
 * TAW_POST_PUBLISHER_PASSWORD (wp-config.php) gates access via
 * TAW\Core\Auth\PagePassword — this call must run before any output,
 * before get_header(). Submissions land as 'pending' posts (see the
 * 'post_publisher' Form registered in inc/customizations.php) for an
 * editor to review in wp-admin.
 */

use TAW\Core\Auth\PagePassword;
use TAW\Core\Form\Form;

PagePassword::protect([
    'password' => defined('TAW_POST_PUBLISHER_PASSWORD') ? TAW_POST_PUBLISHER_PASSWORD : '',
    'title'    => __('Post Publisher', 'taw-theme'),
]);

// Internal tool, not content — force noindex/nofollow regardless of
// TAW\Core\Seo\SeoMeta's own per-post setting or an active SEO plugin.
// Late priority so this always wins over any earlier wp_robots callback.
add_filter('wp_robots', static function (array $robots): array {
    $robots['noindex']  = true;
    $robots['nofollow'] = true;
    return $robots;
}, 20);

get_header();
?>

<main class="post-publisher-page">
    <div class="post-publisher-page__wrap section-container--xs py-16">
        <h1 class="text-4xl font-bold leading-tight"><?php esc_html_e('Enviar una publicación', 'taw-theme'); ?></h1>
        <p class="mt-3 text-sm text-gray-500"><?php esc_html_e('Completa el formulario para enviar una nueva publicación. Quedará pendiente de revisión hasta que un editor la apruebe.', 'taw-theme'); ?></p>
        <div class="mt-8">
            <?php Form::display('post_publisher'); ?>
        </div>
    </div>
</main>

<?php
get_footer();
