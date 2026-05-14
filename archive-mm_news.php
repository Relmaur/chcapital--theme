<?php

/**
 * Archive Template: Noticias (mm_news)
 *
 * Layout: hero → full grid of all news items (external link cards).
 */

use TAW\Core\Block\BlockRegistry;
use TAW\Helpers\Image;

BlockRegistry::queue('post_grid--noticias');

get_header();

$news_items = get_posts([
    'post_type'      => 'mm_news',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
?>

<!-- ── Hero ─────────────────────────────────────────────────────────── -->
<section class="hero-standard border-b-4 border-white/20" style="background: linear-gradient(to bottom, var(--color-primary) 0%, var(--color-secondary) 100%);">
    <div class="section-container--sm relative z-10 flex flex-col items-center text-center py-20 text-white">
        <nav class="mb-6" aria-label="<?php esc_attr_e('Breadcrumb', 'taw-theme'); ?>">
            <ol class="flex items-center justify-center gap-2 text-sm opacity-70">
                <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:opacity-100 transition-opacity"><?php esc_html_e('Inicio', 'taw-theme'); ?></a></li>
                <li aria-hidden="true">/</li>
                <li><a href="<?php echo esc_url(home_url('/multimedia/')); ?>" class="hover:opacity-100 transition-opacity"><?php esc_html_e('Multimedia', 'taw-theme'); ?></a></li>
                <li aria-hidden="true">/</li>
                <li class="font-semibold opacity-100" aria-current="page"><?php esc_html_e('Noticias', 'taw-theme'); ?></li>
            </ol>
        </nav>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
            <?php esc_html_e('Noticias', 'taw-theme'); ?>
        </h1>
        <p class="mt-6 text-lg sm:text-xl max-w-2xl leading-relaxed opacity-85">
            <?php esc_html_e('Las últimas noticias y artículos sobre CH Capital y el sector financiero.', 'taw-theme'); ?>
        </p>
        <div class="mt-10 flex items-center gap-3" aria-hidden="true">
            <span class="h-px w-16 bg-white/50"></span>
            <span class="w-2 h-2 rounded-full bg-white/50"></span>
            <span class="h-px w-16 bg-white/50"></span>
        </div>
    </div>
</section>

<!-- ── News Grid ─────────────────────────────────────────────────────── -->
<section class="post-grid ch-section">
    <div class="section-container--sm">

        <?php if (!empty($news_items)) : ?>
        <div class="post-grid__grid">
            <?php foreach ($news_items as $item) :
                $thumb_id = (int) get_post_meta($item->ID, '_taw_news_thumbnail', true);
                $url      = (string) get_post_meta($item->ID, '_taw_news_url', true);
            ?>
            <a
                class="post-card post-card--news"
                href="<?php echo esc_url($url); ?>"
                target="_blank"
                rel="noopener noreferrer"
            >
                <div class="post-card__image">
                    <?php if ($thumb_id) :
                        echo Image::render($thumb_id, 'large', esc_attr($item->post_title), ['class' => 'post-card__thumb']);
                    else : ?>
                        <div class="post-card__thumb-placeholder"></div>
                    <?php endif; ?>
                </div>
                <div class="post-card__body">
                    <h2 class="post-card__title"><?php echo esc_html($item->post_title); ?></h2>
                    <span class="post-card__cta"><?php esc_html_e('Leer más', 'taw-theme'); ?> →</span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <?php else : ?>
        <p class="text-gray-500 mt-10 text-center">
            <?php esc_html_e('Próximamente publicaremos nuevas noticias.', 'taw-theme'); ?>
        </p>
        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>
