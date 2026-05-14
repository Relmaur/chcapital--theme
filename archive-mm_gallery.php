<?php

/**
 * Archive Template: Galerías de Fotos (mm_gallery)
 *
 * Layout: hero → one section per gallery CPT entry.
 * Each section renders its images as an isolated PhotoSwipe gallery group —
 * left/right arrows in the lightbox stay within that entry's photos only.
 */

use TAW\Blocks\Atoms\LightboxImage\LightboxImage;

// Enqueue PhotoSwipe assets early so they land in <head>
add_action('wp_enqueue_scripts', static function (): void {
    (new LightboxImage())->enqueueAssets();
});

get_header();

$galleries = get_posts([
    'post_type'      => 'mm_gallery',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
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
                <li class="font-semibold opacity-100" aria-current="page"><?php esc_html_e('Galerías', 'taw-theme'); ?></li>
            </ol>
        </nav>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
            <?php esc_html_e('Galerías de Fotos', 'taw-theme'); ?>
        </h1>
        <p class="mt-6 text-lg sm:text-xl max-w-2xl leading-relaxed opacity-85">
            <?php esc_html_e('Revive nuestros eventos y momentos más destacados en imágenes.', 'taw-theme'); ?>
        </p>
        <div class="mt-10 flex items-center gap-3" aria-hidden="true">
            <span class="h-px w-16 bg-white/50"></span>
            <span class="w-2 h-2 rounded-full bg-white/50"></span>
            <span class="h-px w-16 bg-white/50"></span>
        </div>
    </div>
</section>

<!-- ── Gallery Sections ──────────────────────────────────────────────── -->
<?php if (!empty($galleries)) :
    $lb = new LightboxImage();
    foreach ($galleries as $gallery) :
        $raw    = get_post_meta($gallery->ID, '_taw_gallery_images', true);
        $rows   = is_string($raw) && !empty($raw)
            ? (json_decode($raw, true) ?: [])
            : (is_array($raw) ? $raw : []);

        if (empty($rows)) continue;
?>
<section class="post-grid ch-section">
    <div class="section-container--sm">

        <h2 class="section-title"><?php echo esc_html($gallery->post_title); ?></h2>

        <!-- data-pswp-gallery scopes PhotoSwipe navigation to this entry only -->
        <div class="post-grid__grid" data-pswp-gallery>
            <?php foreach ($rows as $row) :
                $id = (int) ($row['image'] ?? 0);
                if (!$id) continue;
                $full = wp_get_attachment_image_src($id, 'full');
            ?>
                <?php $lb->render([
                    'image_id'        => $id,
                    'alt'             => '',
                    'caption'         => (string) ($row['caption'] ?? ''),
                    'display_size'    => 'large',
                    'full_url'        => $full ? $full[0] : '',
                    'full_width'      => $full ? (int) $full[1] : 0,
                    'full_height'     => $full ? (int) $full[2] : 0,
                    'is_gallery_item' => true,
                ]); ?>
            <?php endforeach; ?>
        </div>

    </div>
</section>
<?php
    endforeach;
else : ?>
<section class="post-grid ch-section">
    <div class="section-container--sm">
        <p class="text-gray-500 text-center mt-10">
            <?php esc_html_e('Próximamente publicaremos nuevas galerías.', 'taw-theme'); ?>
        </p>
    </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
