<?php

/**
 * BlurbsGrid Block Template
 *
 * CSS grid of cards, each with a LightboxImage, an optional absolute-positioned
 * badge, a title, and a subtitle. The entire grid is a single PhotoSwipe gallery.
 *
 * @var string $heading
 * @var string $subheading
 * @var array  $items  Each: image_id, alt, title, subtitle, badge, full_url, full_width, full_height
 */

use TAW\Blocks\Atoms\LightboxImage\LightboxImage;

if (empty($items)) return;

$lb = new LightboxImage();
$lb->enqueueAssets();
?>
<section class="blurbs-grid ch-section">
    <div class="section-container--sm">

        <?php if (!empty($heading)) : ?>
            <h2 class="section-title"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if (!empty($subheading)) : ?>
            <p class="section-subtitle"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>

        <div class="blurbs-grid__grid" data-pswp-gallery>
            <?php foreach ($items as $item) : ?>
            <div class="blurb-card">

                <?php if (!empty($item['badge'])) : ?>
                    <span class="blurb-card__badge"><?php echo esc_html($item['badge']); ?></span>
                <?php endif; ?>

                <?php if ($item['image_id'] || $item['full_url']) : ?>
                <div class="blurb-card__image">
                    <?php $lb->render([
                        'image_id'        => $item['image_id'],
                        'alt'             => $item['alt'],
                        'caption'         => $item['title'],
                        'display_size'    => 'large',
                        'full_url'        => $item['full_url'],
                        'full_width'      => $item['full_width'],
                        'full_height'     => $item['full_height'],
                        'is_gallery_item' => true,
                    ]); ?>
                </div>
                <?php endif; ?>

                <?php if ($item['title'] || $item['subtitle']) : ?>
                <div class="blurb-card__body">
                    <?php /* if ($item['title']) : ?>
                        <h3 class="blurb-card__title"><?php echo esc_html($item['title']); ?></h3>
                    <?php endif; */ ?>
                    <?php if ($item['subtitle']) : ?>
                        <p class="blurb-card__subtitle"><?php echo esc_html($item['subtitle']); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
