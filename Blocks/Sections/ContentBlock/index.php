<?php

/**
 * ContentBlock Template
 *
 * Renders a single content section. Compose multiple variations on a page
 * by rendering content_block--{variation} separately.
 *
 * UL items → card grid  |  OL items → numbered steps with connector line
 *
 * @var string $heading
 * @var string $subheading
 * @var string $content    HTML from wysiwyg
 * @var string $bg         Optional CSS modifier class (e.g. 'bg-lightgray')
 */

if (empty($heading) && empty($content)) return;
?>
<section class="content-block ch-section <?php echo esc_attr($bg ?? ''); ?>">
    <div class="section-container--sm">

        <?php if (!empty($heading)) : ?>
            <h2 class="section-title"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if (!empty($subheading)) : ?>
            <p class="section-subtitle"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>

        <?php if (!empty($content)) : ?>
            <div class="content-block__content">
                <?php echo wp_kses_post($content); ?>
            </div>
        <?php endif; ?>

    </div>
</section>
