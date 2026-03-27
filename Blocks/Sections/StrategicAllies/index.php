<?php

/**
 * StrategicAllies Component Template — Infinite Marquee
 *
 * @var string $heading
 * @var string $subheading
 * @var array  $logos  [ ['ally_logo' => int, 'ally_name' => ''] ]
 */

use TAW\Helpers\Image;

// Need at least 1 logo to render; use placeholder logos if none set
$has_logos = !empty($logos);

// Placeholder items for when no logos are set in the CMS
$placeholder_names = [
    'Banamex', 'BBVA', 'Banorte', 'Santander', 'HSBC', 'Inbursa',
];
?>
<section class="strategic-allies ch-section">
    <div class="section-container--sm">
        <header class="strategic-allies__header">
            <h2 class="section-title"><?php echo esc_html($heading); ?></h2>
            <?php if ($subheading) : ?>
                <p class="strategic-allies__subheading"><?php echo esc_html($subheading); ?></p>
            <?php endif; ?>
        </header>
    </div>

    <div class="strategic-allies__track-wrap" aria-label="<?php echo esc_attr($heading); ?>">
        <div class="strategic-allies__track" aria-hidden="true">

            <?php
            // Render the set twice for the seamless infinite loop
            for ($pass = 0; $pass < 2; $pass++) :
            ?>
                <div class="strategic-allies__strip">
                    <?php if ($has_logos) : ?>
                        <?php foreach ($logos as $item) :
                            $logo_id = (int) ($item['ally_logo'] ?? 0);
                            $name    = esc_attr($item['ally_name'] ?? '');
                            if (!$logo_id) continue;
                        ?>
                            <div class="strategic-allies__logo">
                                <?php echo Image::render($logo_id, 'medium', $name, ['class' => 'strategic-allies__img']); ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <?php foreach ($placeholder_names as $label) : ?>
                            <div class="strategic-allies__logo strategic-allies__logo--placeholder">
                                <span><?php echo esc_html($label); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>

        </div>
    </div>
</section>
