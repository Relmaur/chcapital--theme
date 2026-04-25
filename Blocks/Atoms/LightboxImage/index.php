<?php

/**
 * LightboxImage Atom Template
 *
 * @var int    $image_id         WP attachment ID
 * @var string $alt              Alt text (falls back to WP attachment alt)
 * @var string $caption          Caption shown in lightbox
 * @var string $display_size     WP image size for the visible thumbnail
 * @var string $full_url         Full-size URL for PhotoSwipe (resolved if empty)
 * @var int    $full_width       Full-size width in px
 * @var int    $full_height      Full-size height in px
 * @var bool   $is_gallery_item  When true, skip data-pswp-gallery wrapper (parent manages the gallery)
 * @var string $class            Extra classes on the <a> element
 */

use TAW\Helpers\Image;

if (!$image_id && !$full_url) return;

// Resolve full-size data if not pre-supplied (avoids extra DB hits when parent already has it)
if (empty($full_url) && $image_id) {
    $full_src    = wp_get_attachment_image_src($image_id, 'full') ?: [];
    $full_url    = $full_src[0] ?? '';
    $full_width  = (int) ($full_src[1] ?? 0);
    $full_height = (int) ($full_src[2] ?? 0);
}

// Alt fallback to WP attachment alt
if (empty($alt) && $image_id) {
    $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: '';
}

$extra_class = $class ? ' ' . esc_attr($class) : '';
?>
<?php if (!$is_gallery_item) : ?>
<figure class="lightbox-image-wrap" data-pswp-gallery>
<?php endif; ?>

    <a
        href="<?php echo esc_url($full_url); ?>"
        class="lightbox-image<?php echo $extra_class; ?>"
        data-pswp-src="<?php echo esc_url($full_url); ?>"
        data-pswp-width="<?php echo esc_attr((string) $full_width); ?>"
        data-pswp-height="<?php echo esc_attr((string) $full_height); ?>"
        <?php if (!empty($caption)) : ?>data-pswp-caption="<?php echo esc_attr($caption); ?>"<?php endif; ?>
    >
        <?php if ($image_id) : ?>
            <?php echo Image::render($image_id, $display_size, $alt); ?>
        <?php else : ?>
            <img src="<?php echo esc_url($full_url); ?>" alt="<?php echo esc_attr($alt); ?>" loading="lazy">
        <?php endif; ?>
    </a>

<?php if (!$is_gallery_item && !empty($caption)) : ?>
    <figcaption class="lightbox-image-wrap__caption"><?php echo esc_html($caption); ?></figcaption>
<?php endif; ?>

<?php if (!$is_gallery_item) : ?>
</figure>
<?php endif; ?>
