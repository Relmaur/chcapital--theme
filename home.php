<?php

/**
 * home.php — Blog posts index.
 *
 * Used by WordPress when a static front page is set and a Posts Page is
 * assigned in Settings → Reading. Also serves as the fallback index.
 *
 * Layout:
 *  - First post: full-width hero card (above-the-fold, preloaded thumbnail)
 *  - Remaining posts: 3-column responsive grid (lazy-loaded thumbnails)
 *  - Pagination at the bottom
 */

use TAW\Helpers\Image;

// Peek at the first post so we can register its preload before wp_head().
$first_thumb_id = null;

if (have_posts()) {
    $posts        = $GLOBALS['wp_query']->posts;
    $first_post   = $posts[0] ?? null;
    $first_thumb_id = $first_post ? get_post_thumbnail_id($first_post->ID) : null;
}

if ($first_thumb_id) {
    add_action('wp_head', function () use ($first_thumb_id) {
        echo Image::preload_tag($first_thumb_id, 'large');
    }, 2);
}

get_header();
?>

<div class="section-container--sm py-16">

    <header class="mb-12">
        <h1 class="text-4xl font-semibold">Artículos y Perspectivas.</h1>
        <p class="mt-3 text-xl">Conocimiento financiero para fundamentar cada decisión.</p>
    </header>

    <?php if (have_posts()) : ?>

        <?php
        // ── Hero post ──────────────────────────────────────────────────────
        the_post();
        $hero_thumb_id = get_post_thumbnail_id();
        $hero_cats     = get_the_category();
        ?>

        <article <?php post_class('mb-14 group'); ?>>
            <a href="<?php the_permalink(); ?>" class="grid md:grid-cols-2 gap-0 rounded-2xl overflow-hidden shadow-md no-underline bg-white hover:shadow-lg transition-shadow">

                <?php if ($hero_thumb_id) : ?>
                    <div class="overflow-hidden">
                        <?php echo Image::render($hero_thumb_id, 'large', get_the_title(), [
                            'above_fold' => true,
                            'class'      => 'w-full h-72 aspect-640/480 md:h-full object-cover transition-transform group-hover:scale-105',
                            'sizes'      => '(max-width: 768px) 90vw, 50vw',
                        ]); ?>
                    </div>
                <?php endif; ?>

                <div class="flex flex-col justify-center p-8 md:p-12">
                    <?php if ($hero_cats) : ?>
                        <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-accent">
                            <?php echo esc_html($hero_cats[0]->name); ?>
                        </p>
                    <?php endif; ?>

                    <h2 class="text-2xl md:text-3xl font-bold leading-snug text-gray-900 group-hover:text-primary transition-colors">
                        <?php the_title(); ?>
                    </h2>

                    <p class="mt-4 text-sm text-gray-500 line-clamp-3">
                        <?php the_excerpt(); ?>
                    </p>

                    <p class="mt-6 text-xs text-gray-400">
                        <?php echo esc_html(get_the_date()); ?>
                        &middot;
                        <?php the_author(); ?>
                    </p>
                </div>

            </a>
        </article>

        <?php if (have_posts()) : ?>

            <?php
            // ── Remaining posts grid ───────────────────────────────────────
            ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                <?php while (have_posts()) : the_post();
                    $thumb_id = get_post_thumbnail_id();
                    $cats     = get_the_category();
                ?>

                    <article <?php post_class('group bg-white rounded-xl shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-shadow'); ?>>

                        <?php if ($thumb_id) : ?>
                            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" class="block overflow-hidden shrink-0">
                                <?php echo Image::render($thumb_id, 'medium', get_the_title(), [
                                    'class' => 'w-full h-48 object-cover transition-transform group-hover:scale-105',
                                ]); ?>
                            </a>
                        <?php endif; ?>

                        <div class="flex flex-col flex-1 p-6">

                            <?php if ($cats) : ?>
                                <p class="mb-2 text-xs font-semibold uppercase tracking-widest text-accent">
                                    <?php echo esc_html($cats[0]->name); ?>
                                </p>
                            <?php endif; ?>

                            <h2 class="text-base font-semibold leading-snug flex-1">
                                <a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-primary transition-colors no-underline">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <p class="mt-3 text-sm text-gray-500 line-clamp-2">
                                <?php the_excerpt(); ?>
                            </p>

                            <p class="mt-4 text-xs text-gray-400">
                                <?php echo esc_html(get_the_date()); ?>
                                &middot;
                                <?php the_author(); ?>
                            </p>

                        </div>

                    </article>

                <?php endwhile; ?>

            </div>

        <?php endif; ?>

        <div class="mt-14">
            <?php the_posts_pagination([
                'prev_text' => __('&larr; Newer', 'taw-theme'),
                'next_text' => __('Older &rarr;', 'taw-theme'),
            ]); ?>
        </div>

    <?php else : ?>

        <p class="text-gray-500"><?php esc_html_e('No posts found.', 'taw-theme'); ?></p>

    <?php endif; ?>

</div>

<?php get_footer();
