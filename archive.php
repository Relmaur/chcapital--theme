<?php

/**
 * archive.php — Category / tag / date / author archive.
 *
 * For category archives this mirrors the home.php layout:
 *  - Filter pill bar (active category highlighted)
 *  - First post: full-width hero card
 *  - Remaining posts: 3-column grid
 *  - Pagination
 */

use TAW\Helpers\Image;

use TAW\Core\Block\BlockRegistry;

/*
BlockRegistry::queue(
    'hero_standard'
);
*/

// Preload the first post's thumbnail for category archives.
$first_thumb_id = null;
if (is_category() && have_posts()) {
    $posts          = $GLOBALS['wp_query']->posts;
    $first_thumb_id = isset($posts[0]) ? get_post_thumbnail_id($posts[0]->ID) : null;
}

if ($first_thumb_id) {
    add_action('wp_head', function () use ($first_thumb_id) {
        echo Image::preload_tag($first_thumb_id, 'large');
    }, 2);
}

get_header();
?>

<?php // BlockRegistry::render('hero_standard'); ?>

<div class="section-container--sm py-16 ch-section">

    <header class="mb-12">
        <?php if (is_category()) : ?>
            <h1 class="text-4xl font-bold section-title">
                <?php single_cat_title(); ?>
            </h1>
            <?php the_archive_description('<p class="mt-3 text-xl text-gray-500">', '</p>'); ?>
        <?php else : ?>
            <h1 class="text-4xl font-bold section-title"><?php the_archive_title(); ?></h1>
            <?php the_archive_description('<p class="mt-3 text-xl text-gray-500">', '</p>'); ?>
        <?php endif; ?>
    </header>

    <?php
    // Show the category pill bar only on category archives.
    if (is_category()) :
        get_template_part('template-parts/blog-filter-bar', null, ['active_cat_id' => get_queried_object_id()]);
    endif;
    ?>

    <?php if (have_posts()) : ?>

        <?php if (is_category()) : ?>

            <?php
            // ── Hero post ──────────────────────────────────────────────────
            the_post();
            $hero_thumb_id = get_post_thumbnail_id();
            $hero_cats     = get_the_category();
            ?>

            <article <?php post_class('mb-14 group'); ?>>
                <a href="<?php the_permalink(); ?>" class="border border-gray-100 grid md:grid-cols-2 gap-0 rounded-2xl overflow-hidden no-underline bg-white hover:shadow-lg transition-shadow">

                    <?php if ($hero_thumb_id) : ?>
                        <div class="overflow-hidden">
                            <?php echo Image::render($hero_thumb_id, 'large', get_the_title(), [
                                'above_fold' => true,
                                'class'      => 'w-full h-72 aspect-640/380 md:h-full object-cover transition-transform group-hover:scale-105',
                                'sizes'      => '(max-width: 768px) 90vw, 50vw',
                            ]); ?>
                        </div>
                    <?php endif; ?>

                    <div class="flex flex-col justify-center p-8 md:p-12">
                        <?php if ($hero_cats) : ?>
                            <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-primary inline-block p-1 bg-primary/10 rounded w-fit">
                                <?php echo esc_html($hero_cats[0]->name); ?>
                            </p>
                        <?php endif; ?>

                        <h2 class="text-2xl md:text-3xl font-bold leading-snug text-gray-900 group-hover:text-primary transition-colors">
                            <?php the_title(); ?>
                        </h2>

                        <p class="mt-4 text-sm text-gray-500 line-clamp-3">
                            <?php echo esc_html(wp_trim_words(get_the_excerpt(), 28, '...')); ?>
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

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                    <?php while (have_posts()) : the_post();
                        $thumb_id = get_post_thumbnail_id();
                        $cats     = get_the_category();
                    ?>

                        <article <?php post_class('group bg-white rounded-xl overflow-hidden flex flex-col hover:shadow-md transition-shadow border border-gray-100'); ?>>

                            <?php if ($thumb_id) : ?>
                                <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" class="block overflow-hidden shrink-0">
                                    <?php echo Image::render($thumb_id, 'medium', get_the_title(), [
                                        'class' => 'w-full h-48 object-cover transition-transform group-hover:scale-105',
                                    ]); ?>
                                </a>
                            <?php endif; ?>

                            <div class="flex flex-col flex-1 p-6">

                                <?php if ($cats) : ?>
                                    <p class="mb-2 text-xs font-semibold uppercase tracking-widest text-primary inline-block p-1 bg-primary/10 rounded w-fit">
                                        <?php echo esc_html($cats[0]->name); ?>
                                    </p>
                                <?php endif; ?>

                                <h2 class="text-base font-semibold leading-snug flex-1">
                                    <a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-primary transition-colors no-underline">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>

                                <p class="mt-3 text-sm text-gray-500 line-clamp-2">
                                    <?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '...')); ?>
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

        <?php else : ?>

            <?php
            // ── Fallback for non-category archives (tags, dates, authors) ──
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <?php while (have_posts()) : the_post(); ?>

                    <article <?php post_class('group bg-white rounded-xl overflow-hidden flex flex-col hover:shadow-md transition-shadow border border-gray-100'); ?>>

                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true" class="block overflow-hidden shrink-0">
                                <?php echo Image::render(get_post_thumbnail_id(), 'medium', get_the_title(), [
                                    'class' => 'w-full h-48 object-cover transition-transform group-hover:scale-105',
                                ]); ?>
                            </a>
                        <?php endif; ?>

                        <div class="flex flex-col flex-1 p-6">
                            <h2 class="text-base font-semibold leading-snug flex-1">
                                <a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-primary transition-colors no-underline">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <p class="mt-3 text-sm text-gray-500 line-clamp-2">
                                <?php echo esc_html(wp_trim_words(get_the_excerpt(), 18, '...')); ?>
                            </p>
                            <p class="mt-4 text-xs text-gray-400">
                                <?php echo esc_html(get_the_date()); ?> &middot; <?php the_author(); ?>
                            </p>
                        </div>

                    </article>

                <?php endwhile; ?>

            </div>

        <?php endif; ?>

        <div class="mt-14">
            <?php the_posts_pagination([
                'prev_text' => __('&larr; Nuevos', 'taw-theme'),
                'next_text' => __('Anteriores &rarr;', 'taw-theme'),
            ]); ?>
        </div>

    <?php else : ?>

        <p class="text-gray-500"><?php esc_html_e('No posts found.', 'taw-theme'); ?></p>

    <?php endif; ?>

</div>

<?php get_footer();
