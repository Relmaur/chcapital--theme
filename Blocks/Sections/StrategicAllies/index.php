<?php

/**
 * StrategicAllies Component Template — JS Marquee
 *
 * @var string $heading
 * @var string $subheading
 * @var array  $logos  [ ['ally_logo' => int, 'ally_name' => ''] ]
 */

use TAW\Helpers\Image;

$has_logos = !empty($logos);

$placeholder_names = ['Banamex', 'BBVA', 'Banorte', 'Santander', 'HSBC', 'Inbursa', 'Scotia', 'Afirme'];
?>
<section class="strategic-allies ch-section">
    <div class="section-container--sm">
        <header class="strategic-allies__header">
            <h2 class="section-title text-center"><?php echo esc_html($heading); ?></h2>
            <?php if ($subheading) : ?>
                <p class="strategic-allies__subheading"><?php echo esc_html($subheading); ?></p>
            <?php endif; ?>
        </header>
    </div>

    <!--
        .strategic-allies__marquee  → createMarquee({ element })
        .marquee-wrapper            → the element that gets translateX applied
        Items are cloned by the JS — do NOT duplicate them in PHP.
    -->
    <div class="strategic-allies__marquee" aria-label="<?php echo esc_attr($heading); ?>">
        <div class="marquee-wrapper">

            <?php if ($has_logos) : ?>
                <?php foreach ($logos as $item) :
                    $logo_id = (int) ($item['ally_logo'] ?? 0);
                    $name    = esc_attr($item['ally_name'] ?? '');
                    $url     = esc_url($item['ally_url'] ?? '#');
                    if (!$logo_id) continue;
                ?>
                    <a href="<?php echo $url; ?>" class="strategic-allies__logo" target="_blank" rel="noopener noreferrer">
                        <?php echo Image::render($logo_id, 'medium', $name, ['class' => 'strategic-allies__img']); ?>
                    </a>
                <?php endforeach; ?>
            <?php else : ?>
                <?php foreach ($placeholder_names as $label) : ?>
                    <div class="strategic-allies__logo strategic-allies__logo--placeholder">
                        <span><?php echo esc_html($label); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</section>
