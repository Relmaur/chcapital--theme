<?php

/**
 * Archive Template: Videos (mm_video)
 *
 * Layout: full-bleed hero → one section per mm_video_type taxonomy term
 * (or a single flat grid if no terms exist). Each card opens a video modal.
 *
 * Assets are loaded by queuing the post_grid--videos variation before get_header().
 * This enqueues PostGrid's style.css and script.js (videoModal Alpine component)
 * without rendering that block's metabox-driven content.
 */

use TAW\Core\Block\BlockRegistry;
use TAW\Helpers\Image;

BlockRegistry::queue('post_grid--videos');

get_header();

$terms = get_terms([
    'taxonomy'   => 'mm_video_type',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
]);
$has_terms = !empty($terms) && !is_wp_error($terms);
?>

<!-- ── Hero ─────────────────────────────────────────────────────────── -->
<section class="hero-standard bg-primary border-b-4 border-white/20">
    <div class="section-container--sm relative z-10 flex flex-col items-center text-center py-20 text-white">
        <nav class="mb-6" aria-label="<?php esc_attr_e('Breadcrumb', 'taw-theme'); ?>">
            <ol class="flex items-center justify-center gap-2 text-sm opacity-70">
                <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:opacity-100 transition-opacity"><?php esc_html_e('Inicio', 'taw-theme'); ?></a></li>
                <li aria-hidden="true">/</li>
                <li><a href="<?php echo esc_url(home_url('/multimedia/')); ?>" class="hover:opacity-100 transition-opacity"><?php esc_html_e('Multimedia', 'taw-theme'); ?></a></li>
                <li aria-hidden="true">/</li>
                <li class="font-semibold opacity-100" aria-current="page"><?php esc_html_e('Videos', 'taw-theme'); ?></li>
            </ol>
        </nav>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
            <?php esc_html_e('Videos', 'taw-theme'); ?>
        </h1>
        <p class="mt-6 text-lg sm:text-xl max-w-2xl leading-relaxed opacity-85">
            <?php esc_html_e('Explora nuestra biblioteca de videos: webinars, casos de éxito y más.', 'taw-theme'); ?>
        </p>
        <div class="mt-10 flex items-center gap-3" aria-hidden="true">
            <span class="h-px w-16 bg-white/50"></span>
            <span class="w-2 h-2 rounded-full bg-white/50"></span>
            <span class="h-px w-16 bg-white/50"></span>
        </div>
    </div>
</section>

<!-- ── Video Grid ────────────────────────────────────────────────────── -->
<div x-data="videoModal">

    <?php if ($has_terms) :
        foreach ($terms as $term) :
            $videos = get_posts([
                'post_type'      => 'mm_video',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'tax_query'      => [[
                    'taxonomy' => 'mm_video_type',
                    'field'    => 'term_id',
                    'terms'    => $term->term_id,
                ]],
            ]);
            if (empty($videos)) continue;
    ?>
    <section class="post-grid ch-section">
        <div class="section-container--sm">
            <h2 class="section-title"><?php echo esc_html($term->name); ?></h2>
            <div class="post-grid__grid">
                <?php foreach ($videos as $video) :
                    $raw_url   = (string) get_post_meta($video->ID, '_taw_video_url', true);
                    $embed_url = multimedia_get_embed_url($raw_url);
                    $thumb_id  = (int) get_post_meta($video->ID, '_taw_video_thumbnail', true);
                    $yt_thumb  = TAW\Blocks\Sections\PostGrid\PostGrid::youtubeThumbUrl($raw_url);
                ?>
                <button
                    class="post-card post-card--video"
                    type="button"
                    x-on:click="openVideo('<?php echo esc_js($embed_url); ?>')"
                    aria-label="<?php echo esc_attr(sprintf(__('Ver video: %s', 'taw-theme'), $video->post_title)); ?>"
                >
                    <div class="post-card__image">
                        <?php if ($thumb_id) :
                            echo Image::render($thumb_id, 'large', esc_attr($video->post_title), ['class' => 'post-card__thumb']);
                        elseif ($yt_thumb) : ?>
                            <img src="<?php echo esc_url($yt_thumb); ?>" alt="<?php echo esc_attr($video->post_title); ?>" class="post-card__thumb" loading="lazy">
                        <?php else : ?>
                            <div class="post-card__thumb-placeholder"></div>
                        <?php endif; ?>
                        <div class="post-card__play" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    </div>
                    <div class="post-card__body">
                        <h3 class="post-card__title"><?php echo esc_html($video->post_title); ?></h3>
                    </div>
                </button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
        endforeach;

    else :
        // No taxonomy terms — single flat grid of all videos
        $all_videos = get_posts([
            'post_type'      => 'mm_video',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);
        if (!empty($all_videos)) :
    ?>
    <section class="post-grid ch-section">
        <div class="section-container--sm">
            <div class="post-grid__grid">
                <?php foreach ($all_videos as $video) :
                    $raw_url   = (string) get_post_meta($video->ID, '_taw_video_url', true);
                    $embed_url = multimedia_get_embed_url($raw_url);
                    $thumb_id  = (int) get_post_meta($video->ID, '_taw_video_thumbnail', true);
                    $yt_thumb  = TAW\Blocks\Sections\PostGrid\PostGrid::youtubeThumbUrl($raw_url);
                ?>
                <button
                    class="post-card post-card--video"
                    type="button"
                    x-on:click="openVideo('<?php echo esc_js($embed_url); ?>')"
                    aria-label="<?php echo esc_attr(sprintf(__('Ver video: %s', 'taw-theme'), $video->post_title)); ?>"
                >
                    <div class="post-card__image">
                        <?php if ($thumb_id) :
                            echo Image::render($thumb_id, 'large', esc_attr($video->post_title), ['class' => 'post-card__thumb']);
                        elseif ($yt_thumb) : ?>
                            <img src="<?php echo esc_url($yt_thumb); ?>" alt="<?php echo esc_attr($video->post_title); ?>" class="post-card__thumb" loading="lazy">
                        <?php else : ?>
                            <div class="post-card__thumb-placeholder"></div>
                        <?php endif; ?>
                        <div class="post-card__play" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    </div>
                    <div class="post-card__body">
                        <h3 class="post-card__title"><?php echo esc_html($video->post_title); ?></h3>
                    </div>
                </button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; endif; ?>

    <!-- Video Modal -->
    <div
        class="video-modal"
        x-show="isOpen"
        x-cloak
        x-on:keydown.escape.window="close()"
        role="dialog"
        aria-modal="true"
        aria-label="<?php esc_attr_e('Reproductor de video', 'taw-theme'); ?>"
    >
        <div class="video-modal__backdrop" x-on:click="close()" aria-hidden="true"></div>
        <div class="video-modal__container">
            <button
                class="video-modal__close"
                type="button"
                x-on:click="close()"
                aria-label="<?php esc_attr_e('Cerrar video', 'taw-theme'); ?>"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true">
                    <path d="M18 6 6 18M6 6l12 12"/>
                </svg>
            </button>
            <div class="video-modal__player">
                <template x-if="isOpen && embedUrl">
                    <iframe
                        :src="embedUrl"
                        frameborder="0"
                        allowfullscreen
                        allow="autoplay; encrypted-media; picture-in-picture"
                        title="<?php esc_attr_e('Video', 'taw-theme'); ?>"
                    ></iframe>
                </template>
            </div>
        </div>
    </div>

</div><!-- /x-data="videoModal" -->

<?php get_footer(); ?>
