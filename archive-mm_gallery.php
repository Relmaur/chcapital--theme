<?php

/**
 * Archive Template: Galerías de Fotos (mm_gallery)
 *
 * Layout: hero → one section per gallery CPT entry.
 * Each section renders its images as an isolated PhotoSwipe gallery group —
 * left/right arrows in the lightbox stay within that entry's photos only.
 */

use TAW\Blocks\Atoms\LightboxImage\LightboxImage;
use TAW\Core\Block\BlockRegistry;
use TAW\Core\Metabox\Metabox;

// Queue PostGrid assets (CSS/JS) and PhotoSwipe before <head> closes
BlockRegistry::queue('post_grid--galerias');
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
        $raw    = Metabox::get($gallery->ID, 'gallery_images');
        $rows   = is_string($raw) && !empty($raw)
            ? (json_decode($raw, true) ?: [])
            : (is_array($raw) ? $raw : []);

        if (empty($rows)) continue;
?>
        <section class="post-grid ch-section">
            <div class="section-container--sm">

                <h2 class="section-title"><?php echo esc_html($gallery->post_title); ?></h2>
                <?php if ($date = Metabox::get($gallery->ID, 'gallery_date')) : ?>
                    <?php
                    $dt = new \DateTime($date);
                    $timezone = wp_timezone_string();
                    if ($timezone === '' || preg_match('/^[+-]\d{2}:\d{2}$/', $timezone)) {
                        $timezone = 'UTC';
                    }

                    $formatter = new \IntlDateFormatter(
                        'es_MX',
                        \IntlDateFormatter::NONE,
                        \IntlDateFormatter::NONE,
                        $timezone,
                        \IntlDateFormatter::GREGORIAN,
                        'LLLL, yyyy'
                    );
                    $formatted = $formatter->format($dt);
                    if ($formatted === false) {
                        $formatted = wp_date('F, Y', $dt->getTimestamp(), wp_timezone());
                    }
                    ?>
                    <div class="date flex items-center gap-2 mt-2 text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                            <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                        </svg>

                        <p class="text-gray-500"><?php echo esc_html(mb_convert_case((string) $formatted, MB_CASE_TITLE, 'UTF-8')); ?></p>
                    </div>
                <?php endif; ?>

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
                            'class' => 'relative post-card--gallery ratio-16-9'
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