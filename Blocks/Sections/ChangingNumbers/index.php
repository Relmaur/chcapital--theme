<?php

/**
 * ChangingNumbers Block Template
 *
 * @var string $title The section title.
 * @var array $numbers An array of number/label pairs to display.
 */
?>

<section class="ch-section bg-primary colored">
    <div class="section-container--sm">
        <?php if (!empty($title)) : ?>
            <h2 class="section-title--white text-white left-[50%] -translate-x-1/2 text-center"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        <p class="mb-10 text-center text-white max-w-200 mx-auto">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem voluptatum harum dolorem, ea quae eius nulla sed rem ipsum consequuntur nobis id dolores quis libero atque voluptatem laborum saepe ad.</p>
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