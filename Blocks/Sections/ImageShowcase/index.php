<?php

/**
 * ImageShowcase Block Template
 *
 * Static grid of lightbox-enabled images — no carousel, just a heading and
 * N image cards that open PhotoSwipe on click.
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
<section class="image-showcase ch-section">
    <div class="section-container--sm">

        <?php if (!empty($heading)) : ?>
            <h2 class="section-title text-center flex justify-center w-full!">
                <?php echo esc_html($heading); ?>
            </h2>
        <?php endif; ?>

        <?php if (!empty($subheading)) : ?>
            <p class="section-subtitle text-center"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>

        <div class="image-showcase__grid mt-10" data-pswp-gallery>
            <?php foreach ($images as $img) : ?>
                <div class="image-showcase__item">
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
            <?php endforeach; ?>
        </div>

    </div>
</section>
