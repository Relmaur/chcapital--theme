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

$gradient = 'linear-gradient(0deg,rgba(168,168,168,1) 1.5%,rgba(255,255,255,1) 100%)';

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

        <!-- Gradient — always visible behind all slides -->
        <div class="ch-hero__gradient" style="background-image: <?php echo esc_attr($gradient); ?>;"></div>

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

            <p class="hero__tagline text-2xl text-primary text-center sm:text-left">En</p>
            <div class="logo max-w-120 mt-4 flex items-center justify-center sm:justify-start">
                <?php echo file_get_contents(get_template_directory() . '/resources/static/svg/ch-logo.svg'); ?>
            </div>
            <p class="my-5 text-2xl text-primary max-w-150 text-center sm:text-left">Convertimos las ideas de nuestros clientes en<strong> oportunidades de negocio.</strong></p>
            <div class="flex items-center justify-center sm:justify-start mt-2 gap-2">
                <?php $button->render(['text' => __('¡Contáctanos!', 'taw-theme'), 'url' => '/contacto']); ?>
            </div>
            <p class="mt-5 text-center sm:text-left w-full">Explora:</p>
            <div class="links mt-5 flex justify-center sm:flex-col gap-2 sm:border-primary">
                <a href="#financiera" class="flex items-center gap-1 py-1 px-2 bg-gray-100/50 rounded w-fit text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                        <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 14.625v-9.75ZM8.25 9.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM18.75 9a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-.008ZM4.5 9.75A.75.75 0 0 1 5.25 9h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V9.75Z" clip-rule="evenodd" />
                        <path d="M2.25 18a.75.75 0 0 0 0 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 0 0-.75-.75H2.25Z" />
                    </svg>
                    Financiera
                </a>
                <a href="#fideicomisos" class="flex items-center gap-1 py-1 px-2 bg-gray-100/50 rounded w-fit text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M11.584 2.376a.75.75 0 0 1 .832 0l9 6a.75.75 0 1 1-.832 1.248L12 3.901 3.416 9.624a.75.75 0 0 1-.832-1.248l9-6Z" />
                        <path fill-rule="evenodd" d="M20.25 10.332v9.918H21a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1 0-1.5h.75v-9.918a.75.75 0 0 1 .634-.74A49.109 49.109 0 0 1 12 9c2.59 0 5.134.202 7.616.592a.75.75 0 0 1 .634.74Zm-7.5 2.418a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Zm3-.75a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0v-6.75a.75.75 0 0 1 .75-.75ZM9 12.75a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Z" clip-rule="evenodd" />
                        <path d="M12 7.875a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" />
                    </svg>
                    Fideicomisos
                </a>
            </div>
        </div>
    </div>

</section>