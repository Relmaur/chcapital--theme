<?php

/**
 * LogoList Component Template — Static grid
 *
 * @var string $heading
 * @var string $subheading
 * @var array  $items  [ ['logo_image' => int, 'logo_name' => '', 'logo_url' => ''] ]
 */

use TAW\Helpers\Image;

$placeholder_count = 6;
$has_items         = !empty($items);
?>
<section class="logo-list ch-section">
    <div class="section-container--sm">

        <header class="logo-list__header">
            <h2 class="section-title"><?php echo esc_html($heading); ?></h2>
            <?php if ($subheading) : ?>
                <p class="logo-list__subheading"><?php echo esc_html($subheading); ?></p>
            <?php endif; ?>
        </header>

        <div class="logo-list__grid">

            <?php if ($has_items) : ?>
                <?php foreach ($items as $item) :
                    $image_id = (int) ($item['logo_image'] ?? 0);
                    $name     = $item['logo_name'] ?? '';
                    $url      = $item['logo_url'] ?? '';
                    if (!$image_id) continue;
                    $tag = $url ? 'a' : 'div';
                    $attrs = $url ? sprintf('href="%s" target="_blank" rel="noopener noreferrer"', esc_url($url)) : '';
                ?>
                    <<?php echo $tag; ?> class="logo-list__item" <?php echo $attrs; ?>>
                        <?php echo Image::render($image_id, 'medium', esc_attr($name), ['class' => 'logo-list__img']); ?>
                    </<?php echo $tag; ?>>
                <?php endforeach; ?>

            <?php else : ?>
                <?php for ($i = 0; $i < $placeholder_count; $i++) : ?>
                    <div class="logo-list__item logo-list__item--placeholder">
                        <span><?php printf(__('Logo %d', 'taw-theme'), $i + 1); ?></span>
                    </div>
                <?php endfor; ?>
            <?php endif; ?>

        </div>

    </div>
</section>
