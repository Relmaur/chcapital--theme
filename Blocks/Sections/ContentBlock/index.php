<?php

/**
 * ContentBlock Template
 *
 * layout = 'single'      → centred single-column section (original behaviour)
 * layout = 'two_columns' → two-column grid: content on one side, image on the other
 *
 * UL items → card grid  |  OL items → numbered steps with connector line
 *
 * @var string $heading
 * @var string $subheading
 * @var string $content        HTML from wysiwyg
 * @var string|null $content_disclaimer Optional small-print text below content (e.g. for disclaimers)
 * @var string|null $layout         'single' | 'two_columns'
 * @var int    $image_id       Attachment ID (two_columns only; 0 = none)
 * @var string|null $image_position 'left' | 'right' (two_columns only)
 * @var string|null $bg             Optional CSS modifier class (e.g. 'bg-lightgray')
 */

use TAW\Helpers\Image;

if (empty($heading) && empty($content)) return;

$is_two_col = ($layout ?? 'single') === 'two_columns';
$has_image  = $is_two_col && !empty($image_id);
$img_left   = ($image_position ?? 'right') === 'left';
?>
<section class="content-block ch-section <?php echo esc_attr($bg ?? ''); ?>">

    <?php if ($is_two_col) : ?>

        <div class="section-container">
            <div class="content-block__grid<?php echo $img_left ? ' content-block__grid--img-left' : ' content-block__grid--img-right'; ?>">

                <?php if ($has_image && $img_left) : ?>
                    <div class="content-block__image">
                        <?php echo Image::render($image_id, 'large', esc_attr($heading)); ?>
                    </div>
                <?php endif; ?>

                <div class="content-block__text-col">
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
                        <?php if (isset($content_disclaimer) && !empty($content_disclaimer)) : ?>
                            <p class="content-block__disclaimer"><?php echo wp_kses_post($content_disclaimer); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <?php if ($has_image && !$img_left) : ?>
                    <div class="content-block__image">
                        <?php echo Image::render($image_id, 'large', esc_attr($heading)); ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    <?php else : ?>

        <div class="section-container--sm">
            <?php if (!empty($heading)) : ?>
                <h2 class="section-title"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>

            <?php if (!empty($subheading)) : ?>
                <p class="section-subtitle"><?php echo wp_kses_post($subheading); ?></p>
            <?php endif; ?>

            <?php if (!empty($content)) : ?>
                <div class="content-block__content">
                    <?php echo wp_kses_post($content); ?>
                </div>
                <?php if (isset($content_disclaimer) && !empty($content_disclaimer)) : ?>
                    <p class="content-block__disclaimer"><?php echo wp_kses_post($content_disclaimer); ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

    <?php endif; ?>

</section>