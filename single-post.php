<?php

/**
 * single-post.php — Template for individual blog posts.
 *
 * Renders Gutenberg block content with proper styles and a related-posts aside.
 */

use TAW\Helpers\Image;

// Advance the loop before get_header() so we can register the preload
// into wp_head (priority 2 = lands before most other <head> tags).
the_post();

$post_id       = get_the_ID();
$thumbnail_id  = get_post_thumbnail_id($post_id);
$categories    = get_the_category($post_id);

if ($thumbnail_id) {
    add_action('wp_head', function () use ($thumbnail_id) {
        echo Image::preload_tag($thumbnail_id, 'full');
    }, 2);
}

// Related posts query — resolved before get_header() so markup flows top-to-bottom.
$related = null;

if ($categories) {
    $related = new WP_Query([
        'post_type'           => 'post',
        'posts_per_page'      => 3,
        'post__not_in'        => [$post_id],
        'category__in'        => array_column($categories, 'term_id'),
        'orderby'             => 'rand',
        'no_found_rows'       => true,
        'ignore_sticky_posts' => true,
    ]);
}

get_header();
?>

<div class="mx-auto section-container--xs py-12 flex gap-10 items-start">

    <article id="post-<?php the_ID(); ?>" <?php post_class('min-w-0 flex-1'); ?>>

        <header class="mb-7">

            <?php if ($categories) : ?>
                <?php if ($categories[0]->name !== 'Uncategorized') : ?>
                    <p class="mb-4 text-xs font-semibold uppercase tracking-widest text-primary inline-block p-1 bg-primary/10 rounded w-fit">
                        <?php echo esc_html($categories[0]->name); ?>
                    </p>
                <?php endif; ?>
            <?php endif; ?>

            <h1 class="text-4xl md:text-5xl font-bold leading-tight w-full">
                <?php the_title(); ?>
            </h1>

            <p class="mt-6 text-sm text-gray-500 flex items-center gap-2">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                        <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                    </svg>
                    <?php echo esc_html(get_the_date()); ?>
                </span>
                &middot;
                <span class="font-semibold"><?php the_author(); ?></span>
            </p>

        </header>

        <?php (new TAW\Blocks\Molecules\SocialMediaShare\SocialMediaShare())->render([
            'article_url' => get_permalink(),
            'post_id'     => get_the_ID(),
        ]); ?>

        <?php if ($thumbnail_id) : ?>
            <div class="mb-7">
                <?php echo Image::render($thumbnail_id, 'full', get_the_title(), [
                    'above_fold' => true,
                    'class'      => 'w-full rounded-xl object-cover max-h-[480px]',
                    'sizes'      => '(max-width: 1280px) 90vw, 1152px',
                ]); ?>
            </div>
        <?php endif; ?>

        <?php (new TAW\Blocks\Molecules\SummarizeWithAI\SummarizeWithAI())->render([
            'article_url' => get_permalink(),
            'prompt' => __('Por favor sumariza este artículo y resalta los puntos clave', 'taw-theme'),
        ]); ?>

        <div class="entry-content">
            <?php the_content(); ?>
        </div>

        <footer class="mt-8 pt-8 border-t border-gray-100">

            <?php
            $tags = get_the_tags($post_id);
            if ($categories || $tags) : ?>
                <div class="flex flex-wrap gap-2 mb-6">
                    <?php foreach ($categories as $cat) : ?>
                        <?php if ($cat->name !== 'Uncategorized'): ?>
                            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
                                class="inline-flex items-center px-3 py-1 rounded-sm text-xs font-semibold bg-primary/10 text-primary hover:bg-primary/20 transition-colors no-underline">
                                <?php echo esc_html($cat->name); ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if ($tags) : foreach ($tags as $tag) : ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                                class="inline-flex items-center px-3 py-1 rounded-sm text-xs font-medium bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors no-underline">
                                #<?php echo esc_html($tag->name); ?>
                            </a>
                    <?php endforeach;
                    endif; ?>
                </div>
            <?php endif; ?>

            <?php (new TAW\Blocks\Molecules\SocialMediaShare\SocialMediaShare())->render([
                'article_url' => get_permalink(),
                'post_id'     => get_the_ID(),
            ]); ?>

            <nav class="flex justify-between mt-6 text-sm font-medium">
                <span><?php previous_post_link('%link', '&larr; %title'); ?></span>
                <span><?php next_post_link('%link', '%title &rarr;'); ?></span>
            </nav>
        </footer>

    </article>

    <?php if ($related && $related->have_posts()) : ?>

        <aside class="hidden lg:flex flex-col gap-6 w-64 shrink-0 sticky top-[calc(var(--header-height)_+_1.5rem)]">

            <h2 class="text-xs font-semibold uppercase tracking-widest text-gray-400">
                <?php esc_html_e('También te puede interesar', 'taw-theme'); ?>
            </h2>

            <?php while ($related->have_posts()) : $related->the_post(); ?>

                <a href="<?php the_permalink(); ?>" class="group flex flex-col gap-2 no-underline">
                    <?php
                    $rel_thumb_id = get_post_thumbnail_id();
                    if ($rel_thumb_id) : ?>
                        <div class="overflow-hidden rounded-lg">
                            <?php echo Image::render($rel_thumb_id, 'small', get_the_title(), [
                                'class' => 'w-full h-32 object-cover transition-transform group-hover:scale-105',
                            ]); ?>
                        </div>
                    <?php endif; ?>
                    <p class="text-xs text-gray-400"><?php echo esc_html(get_the_date()); ?></p>
                    <p class="text-sm font-semibold leading-snug text-gray-800 group-hover:text-primary transition-colors">
                        <?php the_title(); ?>
                    </p>
                </a>

            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>

        </aside>

    <?php endif; ?>

</div>

<?php get_footer();
