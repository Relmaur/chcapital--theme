<?php

/**
 * ChangingNumbers Block Template
 *
 * @var string $title The section title.
 * @var array $numbers An array of number/label pairs to display.
 */
?>

<section class="ch-section bg-primary">
    <div class="section-container--sm">
        <?php if (!empty($title)) : ?>
            <h2 class="section-title text-white left-[50%] -translate-x-1/2"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        <div class="changing_numbers flex flex-wrap items-center gap-15 justify-center">
            <?php foreach ($numbers as $item) : ?>
                <div class="changing_number flex flex-col items-center">
                    <span
                        class="number text-5xl font-semibold text-white"
                        data-target="<?php echo esc_attr($item['number']); ?>"
                        data-prefix="<?php echo esc_attr($item['prefix'] ?? ''); ?>"
                        data-suffix="<?php echo esc_attr($item['suffix'] ?? ''); ?>">
                        <?php echo esc_html($item['prefix'] ?? '') . '0' . esc_html($item['suffix'] ?? ''); ?>
                    </span>
                    <span class="label text-white"><?php echo esc_html($item['label']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>