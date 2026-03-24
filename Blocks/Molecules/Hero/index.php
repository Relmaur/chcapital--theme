<?php

/**
 * Hero Component Template
 * 
 * Available variables (from Hero::getData):
 * 
 * @var string $subtitle
 * @var string $image_id
 */

// Guard: don't render if there's no content
// if (empty($tagline)) {
//     return;
// }

use TAW\Blocks\Atoms\Button\Button;
use TAW\Helpers\Image;
use TAW\Helpers\Svg;
use TAW\Support\Performance;


$button = new Button();

$padding = ' py-20'; // default padding

$gradient = 'linear-gradient(0deg,rgba(168, 168, 168, 1) 1.5384615384615385%,rgba(255, 255, 255, 1) 100%);';

$image = 'style="--gradient: ' . $gradient . '; --image: none;"';

Performance::preloadImage((int) $image_id, 'full');

if ($image_id) {

    $image_url = '--image: url(' . Image::background((int) $image_id, 'full', [
        'url_only' => true,
    ]) . ');';

    // dump($image_url); // Testing

    $image_width = Image::getDimension((int) $image_id)['width'] ?? 0;
    $image_height = Image::getDimension((int) $image_id)['height'] ?? 0;

    $image = $image_id ? 'style="--gradient: ' . $gradient . '; ' . $image_url . ' --image-width: ' . $image_width . 'px; --image-height: ' . $image_height . 'px;"' : '';

    $padding = ' py-0';
}
?>

<section class="ch-hero xl:min-h-150 flex items-center<?php echo $padding; ?><?php echo $image_id ? ' overlay-image' : ''; ?> pt-30 sm:pt-10 pb-20 sm:pb-15 border-b-3 border-b-primary" <?php echo taw_editor_section('hero'); ?><?php echo $image; ?>>
    <div class="section-container--sm">
        <div class="hero__content">

            <p class="hero__tagline text-2xl text-primary text-center sm:text-left">En</p>
            <div class="logo max-w-120 mt-4">
                <?php echo file_get_contents(get_template_directory() . '/resources/static/svg/ch-logo.svg') ?>
            </div>
            <p class="my-5 text-2xl text-primary max-w-150 text-center sm:text-left">Convertimos las ideas de nuestros clientes en<strong> oportunidades de negocio.</strong></p>
            <div class="flex items-center justify-center sm:justify-start mt-2 gap-2">
                <?php $button->render(['text' => __('¡Contáctanos!', 'taw-theme'), 'url' => '/contacto']); ?>
            </div>
        </div>

        <?php /* if ($image_url): ?>
            <div class="image w-full max-w-200">
                <?php echo Image::render((int) $image_id, 'full', 'Hero banner', [
                    'above_fold' => true,
                    'sizes'      => '100vw',
                    'class'      => 'hero-image w-full',
                    'attr'       => array_merge(
                        ['style' => 'width: 100%'],
                        taw_editor_attrs_array('hero', 'hero_image_url')
                    ),
                ]); ?>
            </div>
        <?php endif; */ ?>
    </div>
</section>