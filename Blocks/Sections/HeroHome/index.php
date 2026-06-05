<?php

/**
 * Hero Component Template
 *
 * Available variables (from Hero::getData):
 *
 * @var int[]  $slides   WordPress attachment IDs from the metabox repeater
 * @var string $heading
 * @var string $tagline
 */

use TAW\Blocks\Atoms\Button\Button;
use TAW\Helpers\Image;

$button = new Button();

$bg_image_url = 'https://chcapital.local/wp-content/uploads/2026/06/chc-hero-01-scaled.webp';

// $gradient = 'linear-gradient(to bottom right, transparent 0%, rgb(0 0 0 / 86%) 0%, rgb(0 45 121 / 82%) 60%, #001f53 80%, #000810 100%)';
$gradient = 'linear-gradient(180deg, rgb(0 32 66 / 73%) 18%, rgb(0 32 66) 100%)';

// Slide 0: gradient + horse (right-aligned overlay style).
$horse_url  = get_template_directory_uri() . '/resources/static/img/ch-horse.webp';
$all_slides = [['url' => $horse_url, 'full' => false]];

// Subsequent slides: full-bleed background images, no horse.
foreach ($slides as $image_id) {
    $url = Image::background((int) $image_id, 'full', ['url_only' => true]);
    if ($url) {
        $all_slides[] = ['url' => $url, 'full' => true];
    }
}

$is_animated = count($all_slides) > 1;
?>
<section
    class="ch-hero xl:min-h-150 flex items-center pt-(--header-height) sm:pt-0 has-bg pb-20 sm:pb-15 border-b-5 border-b-primary"
    <?php echo taw_editor_section('hero'); ?>>

    <div class="ch-hero__bg"
        <?php if ($is_animated) : ?>
        x-data="{ current: 0, init() { setInterval(() => { this.current = (this.current + 1) % <?php echo count($all_slides); ?> }, 5000) } }"
        <?php endif; ?>>

        <!-- Gradient overlay + background image bleeding in from top-right -->
        <div class="ch-hero__gradient" style="background-image: <?php echo esc_attr($gradient); ?>, url('<?php echo esc_url($bg_image_url); ?>');"></div>

        <?php foreach ($all_slides as $i => $slide) : ?>
            <div class="ch-hero__slide<?php echo $i === 0 ? ' is-active' : ''; ?>"
                <?php if ($is_animated) : ?>
                :class="{ 'is-active': current === <?php echo $i; ?> }"
                <?php endif; ?>>
                <div class="<?php echo $slide['full'] ? 'ch-hero__layer--full' : 'ch-hero__layer'; ?>" style="background-image: url('<?php echo esc_url($slide['url']); ?>');"></div>
            </div>
        <?php endforeach; ?>

    </div>

    <div class="section-container--sm relative z-10">
        <div class="hero__content">

            <p class="hero__tagline text-2xl text-white text-center sm:text-left">En</p>
            <div class="logo max-w-120 mt-4 flex items-center justify-center sm:justify-start">
                <?php echo file_get_contents(get_template_directory() . '/resources/static/svg/ch-logo--white.svg'); ?>
            </div>
            <p class="my-5 text-2xl text-white max-w-150 text-center sm:text-left">Convertimos las ideas de nuestros clientes en<strong> oportunidades de negocio.</strong></p>
            <div class="flex items-center justify-center sm:justify-start mt-8 gap-2">
                <?php $button->render([
                    'text' => __('¡Contáctanos!', 'taw-theme'),
                    'url' => '/contacto',
                ]); ?>
            </div>
        </div>
    </div>

</section>