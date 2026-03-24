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
        'posts_per_page'      => 4,
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

        <header class="mb-10">

            <?php if ($categories) : ?>
                <p class="mb-4 text-xs font-semibold uppercase tracking-widest text-blue-600">
                    <?php echo esc_html($categories[0]->name); ?>
                </p>
            <?php endif; ?>

            <h1 class="text-4xl md:text-5xl font-semibold leading-tight w-full">
                <?php the_title(); ?>
            </h1>

            <p class="mt-4 text-sm text-gray-500">
                <?php echo esc_html(get_the_date()); ?>
                &middot;
                <?php the_author(); ?>
            </p>

        </header>

        <?php if ($thumbnail_id) : ?>
            <div class="mb-10">
                <?php echo Image::render($thumbnail_id, 'full', get_the_title(), [
                    'above_fold' => true,
                    'class'      => 'w-full rounded-xl object-cover max-h-[480px]',
                    'sizes'      => '(max-width: 1280px) 90vw, 1152px',
                ]); ?>
            </div>
        <?php endif; ?>

        <div class="entry-content">
            <?php the_content(); ?>
        </div>

        <footer class="mt-12 pt-8 border-t border-gray-100">
            <?php the_tags('<p class="text-sm text-gray-400">' . __('Tagged: ', 'taw-theme'), ', ', '</p>'); ?>
            <nav class="flex justify-between mt-6 text-sm font-medium">
                <span><?php previous_post_link('%link', '&larr; %title'); ?></span>
                <span><?php next_post_link('%link', '%title &rarr;'); ?></span>
            </nav>
        </footer>

    </article>

    <?php if ($related && $related->have_posts()) : ?>

        <aside class="hidden lg:flex flex-col gap-6 w-64 shrink-0 sticky top-8">

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
                    <p class="text-sm font-semibold leading-snug text-gray-800 group-hover:text-blue-600 transition-colors">
                        <?php the_title(); ?>
                    </p>
                </a>

            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>

        </aside>

    <?php endif; ?>

</div>

<?php get_footer();
