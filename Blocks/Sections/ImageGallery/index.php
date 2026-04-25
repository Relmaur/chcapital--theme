<?php

/**
 * ImageGallery Block Template
 *
 * Embla carousel (1 / 2 / 3 slides per view on mobile / tablet / desktop)
 * with autoplay and PhotoSwipe lightbox on click.
 *
 * @var string $heading
 * @var string $subheading
 * @var array  $images    Each: image_id, alt, caption, full_url, full_width, full_height
 */

use TAW\Blocks\Atoms\LightboxImage\LightboxImage;

if (empty($images)) return;

$lb = new LightboxImage();
$lb->enqueueAssets();
?>
<section class="image-gallery ch-section">
    <div class="section-container--sm">

        <?php if (!empty($heading)) : ?>
            <h2 class="section-title"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if (!empty($subheading)) : ?>
            <p class="section-subtitle"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>

        <div class="image-gallery__embla mt-10" data-pswp-gallery>

            <div class="image-gallery__viewport">
                <div class="image-gallery__container">
                    <?php foreach ($images as $img) : ?>
                    <div class="image-gallery__slide">
                        <div class="image-gallery__slide-inner">
                            <?php $lb->render([
                                'image_id'        => $img['image_id'],
                                'alt'             => $img['alt'],
                                'caption'         => $img['caption'],
                                'display_size'    => 'large',
                                'full_url'        => $img['full_url'],
                                'full_width'      => $img['full_width'],
                                'full_height'     => $img['full_height'],
                                'is_gallery_item' => true,
                            ]); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="image-gallery__controls">
                <button class="image-gallery__btn image-gallery__btn--prev" type="button" aria-label="<?php esc_attr_e('Anterior', 'taw-theme'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div class="image-gallery__dots" role="tablist" aria-label="<?php esc_attr_e('Galería de imágenes', 'taw-theme'); ?>"></div>

                <button class="image-gallery__btn image-gallery__btn--next" type="button" aria-label="<?php esc_attr_e('Siguiente', 'taw-theme'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

        </div>
    </div>
</section>
