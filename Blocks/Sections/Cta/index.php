<?php

/**
 * Cta Block Template
 *
 * @var string|null $heading
 * @var string|null $subheading
 * @var string      $button_text
 * @var string      $button_url
 * @var bool        $button_new_tab
 * @var string      $background_type    image | gradient | color
 * @var int         $image_id
 * @var string      $gradient_start
 * @var string      $gradient_end
 * @var string      $background_color
 */

use TAW\Blocks\Atoms\Button\Button;
use TAW\Helpers\Image;

$style = '';

if ($background_type === 'gradient') {
    $style = sprintf('background-image: linear-gradient(135deg, %s, %s);', esc_attr($gradient_start), esc_attr($gradient_end));
} elseif ($background_type === 'color') {
    $style = sprintf('background-color: %s;', esc_attr($background_color));
}
?>
<section class="cta" style="<?php echo $style; ?>">

    <?php if ($background_type === 'image' && $image_id) : ?>
        <div class="cta__bg" aria-hidden="true">
            <?php echo Image::render($image_id, 'full', '', [
                'class' => 'cta__bg-img',
                'sizes' => '100vw',
            ]); ?>
        </div>
        <div class="cta__overlay"></div>
    <?php endif; ?>

    <div class="section-container--sm cta__inner">

        <?php if ($heading || $subheading) : ?>
            <div class="cta__headline">
                <?php if ($heading) : ?>
                    <h2 class="section-title--white cta__heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>

                <?php if ($subheading) : ?>
                    <p class="cta__sub"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($button_text) : ?>
            <div class="cta__action">
                <?php (new Button())->render([
                    'text'    => $button_text,
                    'url'     => $button_url,
                    'variant' => 'white',
                    'target'  => $button_new_tab ? '_blank' : '_self',
                    'size'    => 'lg',
                ]); ?>
            </div>
        <?php endif; ?>

    </div>

</section>
