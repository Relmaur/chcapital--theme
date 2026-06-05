<?php

/**
 * template-parts/blog-filter-bar.php
 *
 * Category filter pill bar for the blog index and category archives.
 *
 * Expected args (passed as third param to get_template_part()):
 *   active_cat_id  int|null  — term_id of the active category, or null for "All".
 */

$active_cat_id = $args['active_cat_id'] ?? null;
$blog_url      = get_permalink(get_option('page_for_posts')) ?: home_url('/blog/');
$categories    = get_terms([
    'taxonomy'   => 'category',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC',
]);

if (is_wp_error($categories) || empty($categories)) return;

$pill_base  = 'inline-block px-4 py-1.5 rounded-full text-sm font-medium transition-colors';
$pill_active = 'bg-primary text-white';
$pill_idle   = 'bg-gray-100 text-gray-600 hover:bg-primary/10 hover:text-primary';
?>

<nav aria-label="<?php esc_attr_e('Filtrar por categoría', 'taw-theme'); ?>" class="mb-10 flex flex-wrap gap-2">

    <a href="<?php echo esc_url($blog_url); ?>"
        class="<?php echo $pill_base . ' ' . (is_null($active_cat_id) ? $pill_active : $pill_idle); ?>">
        <?php esc_html_e('Todos', 'taw-theme'); ?>
    </a>

    <?php foreach ($categories as $cat) : ?>
        <?php if ($cat->name !== 'Uncategorized'): ?>
            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
                class="<?php echo $pill_base . ' ' . ($active_cat_id === $cat->term_id ? $pill_active : $pill_idle); ?>">
                <?php echo esc_html($cat->name); ?>
            </a>
        <?php endif; ?>
    <?php endforeach; ?>

</nav>