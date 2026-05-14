<?php

/**
 * PostGrid Block Template
 *
 * Renders a 3-column grid of CPT cards, with a "Ver más" link to the archive.
 * Card design varies by post_type; video cards open an Alpine.js lightbox modal.
 *
 * @var string $section_title Section heading text
 * @var string $post_type     CPT: mm_video | mm_news | mm_gallery | mm_guide
 * @var string $more_url      Archive URL for the "Ver más" button
 * @var array  $items         Array of CPT item arrays (shape varies by post_type)
 */

use TAW\Helpers\Image;
use TAW\Blocks\Atoms\LightboxImage\LightboxImage;

if (empty($items)) return;

if ($post_type === 'mm_gallery') {
    $lb = new LightboxImage();
}
?>
<section
    class="post-grid ch-section"
    <?php if ($post_type === 'mm_video') : ?>x-data="videoModal"<?php endif; ?>
>
    <div class="section-container--sm">

        <?php if ($section_title) : ?>
            <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
        <?php endif; ?>

        <div class="post-grid__grid">

            <?php foreach ($items as $item) : ?>

            <?php if ($post_type === 'mm_video') : ?>
            <!-- Video Card -->
            <button
                class="post-card post-card--video"
                type="button"
                x-on:click="openVideo('<?php echo esc_js($item['embed_url']); ?>')"
                aria-label="<?php echo esc_attr(sprintf(__('Ver video: %s', 'taw-theme'), $item['title'])); ?>"
            >
                <div class="post-card__image">
                    <?php if ($item['thumbnail_id']) : ?>
                        <?php echo Image::render($item['thumbnail_id'], 'large', esc_attr($item['title']), ['class' => 'post-card__thumb']); ?>
                    <?php elseif (!empty($item['thumb_url'])) : ?>
                        <img src="<?php echo esc_url($item['thumb_url']); ?>" alt="<?php echo esc_attr($item['title']); ?>" class="post-card__thumb" loading="lazy">
                    <?php else : ?>
                        <div class="post-card__thumb-placeholder"></div>
                    <?php endif; ?>
                    <div class="post-card__play" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                </div>
                <?php if (!empty($item['terms'])) : ?>
                    <span class="post-card__badge"><?php echo esc_html($item['terms'][0]); ?></span>
                <?php endif; ?>
                <div class="post-card__body">
                    <h3 class="post-card__title"><?php echo esc_html($item['title']); ?></h3>
                </div>
            </button>

            <?php elseif ($post_type === 'mm_news') : ?>
            <!-- News Card -->
            <a
                class="post-card post-card--news"
                href="<?php echo esc_url($item['url']); ?>"
                target="_blank"
                rel="noopener noreferrer"
            >
                <div class="post-card__image">
                    <?php if ($item['thumbnail_id']) : ?>
                        <?php echo Image::render($item['thumbnail_id'], 'large', esc_attr($item['title']), ['class' => 'post-card__thumb']); ?>
                    <?php else : ?>
                        <div class="post-card__thumb-placeholder"></div>
                    <?php endif; ?>
                </div>
                <div class="post-card__body">
                    <h3 class="post-card__title"><?php echo esc_html($item['title']); ?></h3>
                    <span class="post-card__cta"><?php esc_html_e('Leer más', 'taw-theme'); ?> →</span>
                </div>
            </a>

            <?php elseif ($post_type === 'mm_gallery' && !empty($item['images'])) : ?>
            <!-- Gallery Card — each card is its own isolated PhotoSwipe gallery -->
            <div class="post-card post-card--gallery" data-pswp-gallery>
                <?php
                $first = $item['images'][0];
                (new LightboxImage())->render([
                    'image_id'        => $first['image_id'],
                    'alt'             => esc_attr($item['title']),
                    'caption'         => $first['caption'],
                    'display_size'    => 'large',
                    'full_url'        => $first['full_url'],
                    'full_width'      => $first['full_width'],
                    'full_height'     => $first['full_height'],
                    'is_gallery_item' => true,
                ]);
                // Hidden anchors for remaining images — discovered by PhotoSwipe
                foreach (array_slice($item['images'], 1) as $img) : ?>
                    <a
                        href="<?php echo esc_url($img['full_url']); ?>"
                        data-pswp-src="<?php echo esc_url($img['full_url']); ?>"
                        data-pswp-width="<?php echo esc_attr((string) $img['full_width']); ?>"
                        data-pswp-height="<?php echo esc_attr((string) $img['full_height']); ?>"
                        <?php if (!empty($img['caption'])) : ?>data-pswp-caption="<?php echo esc_attr($img['caption']); ?>"<?php endif; ?>
                        style="display:none"
                        aria-hidden="true"
                        tabindex="-1"
                    ></a>
                <?php endforeach; ?>
                <div class="post-card__body">
                    <h3 class="post-card__title"><?php echo esc_html($item['title']); ?></h3>
                    <?php if ($item['count'] > 0) : ?>
                        <span class="post-card__count">
                            <?php echo esc_html(sprintf(
                                _n('%d foto', '%d fotos', $item['count'], 'taw-theme'),
                                $item['count']
                            )); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <?php elseif ($post_type === 'mm_guide') : ?>
            <!-- Guide Card -->
            <div class="post-card post-card--guide">
                <div class="post-card__image">
                    <?php if ($item['thumbnail_id']) : ?>
                        <?php echo Image::render($item['thumbnail_id'], 'large', esc_attr($item['title']), ['class' => 'post-card__thumb']); ?>
                    <?php else : ?>
                        <div class="post-card__thumb-placeholder post-card__thumb-placeholder--guide">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="post-card__body">
                    <h3 class="post-card__title"><?php echo esc_html($item['title']); ?></h3>
                    <?php if ($item['pdf_url']) : ?>
                        <a
                            href="<?php echo esc_url($item['pdf_url']); ?>"
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

            <?php endif; ?>

            <?php endforeach; ?>

        </div><!-- /.post-grid__grid -->

        <?php if ($more_url) : ?>
        <div class="post-grid__footer">
            <a href="<?php echo esc_url($more_url); ?>" class="post-grid__more-btn">
                <?php esc_html_e('Ver más', 'taw-theme'); ?>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h10.638L10.23 5.29a.75.75 0 1 1 1.04-1.08l5.5 5.25a.75.75 0 0 1 0 1.08l-5.5 5.25a.75.75 0 1 1-1.04-1.08l4.158-3.96H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd"/>
                </svg>
            </a>
        </div>
        <?php endif; ?>

    </div><!-- /.section-container--sm -->

    <?php if ($post_type === 'mm_video') : ?>
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
    <?php endif; ?>

</section>
