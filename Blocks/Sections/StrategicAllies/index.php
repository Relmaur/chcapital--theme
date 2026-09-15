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
                    $logo_ref  = $item['ally_logo'] ?? '';
                    $name      = esc_attr($item['ally_name'] ?? '');
                    $url       = esc_url($item['ally_url'] ?? '#');
                    // ally_logo is normally a Media Library attachment ID (int),
                    // but some allies' logos are only available as a hotlinked
                    // or theme-relative URL string — is_numeric() lets a literal
                    // "0"/0 still fall through to the "no logo" skip below, same
                    // as the old (int) cast did, while any other string (absolute
                    // or relative — esc_url() passes both through unchanged) is
                    // rendered as a plain <img> instead of going through
                    // Image::render(), which only accepts attachment IDs.
                    $is_attachment_id = is_numeric($logo_ref) && (int) $logo_ref > 0;
                    if (empty($logo_ref)) continue;
                ?>
                    <a href="<?php echo $url; ?>" class="strategic-allies__logo" target="_blank" rel="noopener noreferrer">
                        <?php if ($is_attachment_id) : ?>
                            <?php echo Image::render((int) $logo_ref, 'medium', $name, ['class' => 'strategic-allies__img']); ?>
                        <?php else : ?>
                            <img src="<?php echo esc_url($logo_ref); ?>" alt="<?php echo $name; ?>" class="strategic-allies__img" loading="lazy" decoding="async">
                        <?php endif; ?>
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