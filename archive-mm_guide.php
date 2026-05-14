<?php

/**
 * Archive Template: Guías Descargables (mm_guide)
 *
 * Layout: hero → full grid of all downloadable guide cards.
 */

use TAW\Core\Block\BlockRegistry;
use TAW\Helpers\Image;

BlockRegistry::queue('post_grid--guias');

get_header();

$guides = get_posts([
    'post_type'      => 'mm_guide',
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
                <li class="font-semibold opacity-100" aria-current="page"><?php esc_html_e('Guías', 'taw-theme'); ?></li>
            </ol>
        </nav>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
            <?php esc_html_e('Guías Descargables', 'taw-theme'); ?>
        </h1>
        <p class="mt-6 text-lg sm:text-xl max-w-2xl leading-relaxed opacity-85">
            <?php esc_html_e('Descarga nuestros recursos gratuitos: guías, whitepapers y materiales educativos.', 'taw-theme'); ?>
        </p>
        <div class="mt-10 flex items-center gap-3" aria-hidden="true">
            <span class="h-px w-16 bg-white/50"></span>
            <span class="w-2 h-2 rounded-full bg-white/50"></span>
            <span class="h-px w-16 bg-white/50"></span>
        </div>
    </div>
</section>

<!-- ── Guides Grid ───────────────────────────────────────────────────── -->
<section class="post-grid ch-section">
    <div class="section-container--sm">

        <?php if (!empty($guides)) : ?>
        <div class="post-grid__grid">
            <?php foreach ($guides as $guide) :
                $thumb_id = (int) get_post_meta($guide->ID, '_taw_guide_thumbnail', true);
                $pdf_url  = (string) get_post_meta($guide->ID, '_taw_guide_pdf_url', true);
            ?>
            <div class="post-card post-card--guide">
                <div class="post-card__image">
                    <?php if ($thumb_id) :
                        echo Image::render($thumb_id, 'large', esc_attr($guide->post_title), ['class' => 'post-card__thumb']);
                    else : ?>
                        <div class="post-card__thumb-placeholder post-card__thumb-placeholder--guide">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="post-card__body">
                    <h2 class="post-card__title"><?php echo esc_html($guide->post_title); ?></h2>
                    <?php if ($pdf_url) : ?>
                        <a
                            href="<?php echo esc_url($pdf_url); ?>"
                            class="post-card__download"
                            target="_blank"
                            rel="noopener noreferrer"
                            download
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M10.75 2.75a.75.75 0 0 0-1.5 0v8.614L6.295 8.235a.75.75 0 1 0-1.09 1.03l4.25 4.5a.75.75 0 0 0 1.09 0l4.25-4.5a.75.75 0 0 0-1.09-1.03l-2.955 3.129V2.75Z"/>
                                <path d="M3.5 12.75a.75.75 0 0 0-1.5 0v2.5A2.75 2.75 0 0 0 4.75 18h10.5A2.75 2.75 0 0 0 18 15.25v-2.5a.75.75 0 0 0-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5Z"/>
                            </svg>
                            <?php esc_html_e('Descargar guía', 'taw-theme'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php else : ?>
        <p class="text-gray-500 text-center mt-10">
            <?php esc_html_e('Próximamente publicaremos nuevas guías descargables.', 'taw-theme'); ?>
        </p>
        <?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>
