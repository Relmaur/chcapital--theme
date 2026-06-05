<?php

/**
 * AboutHero Component Template
 *
 * @var string $heading
 * @var string $subtitle
 * @var int    $image_id  WordPress attachment ID for background image
 */

use TAW\Helpers\Image;
?>
<section class="hero-standard border-b-5 border-b-primary">

    <?php if ($image_id) : ?>
        <div class="hero-standard__bg" aria-hidden="true">
            <?php echo Image::render($image_id, 'full', '', [
                'above_fold' => true,
                'class'      => 'hero-standard__bg-img',
                'sizes'      => '100vw',
            ]); ?>
        </div>
    <?php endif; ?>

    <div class="hero-standard__overlay"></div>

    <div class="section-container--sm relative z-10 flex flex-col items-center text-center">
        <nav class="hero-standard__breadcrumb mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2 text-sm">
                <li><a href="/" class="opacity-70 hover:opacity-100 transition-opacity"><?php _e('Inicio', 'taw-theme'); ?></a></li>
                <li class="opacity-40" aria-hidden="true">/</li>
                <li class="font-medium" aria-current="page"><?php echo get_the_title(get_queried_object_id()); ?></li>
            </ol>
        </nav>

        <h1 class="hero-standard__heading text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight text-primary">
            <?php echo esc_html($heading); ?>
        </h1>

        <?php if ($subtitle) : ?>
            <p class="hero-standard__subtitle mt-6 text-lg sm:text-xl max-w-2xl leading-relaxed">
                <?php echo esc_html($subtitle); ?>
            </p>
        <?php endif; ?>

        <div class="hero-standard__divider mt-10 flex items-center gap-3">
            <span class="h-px w-16 bg-white"></span>
            <span class="hero-standard__ornament w-2 h-2 rounded-full bg-white"></span>
            <span class="h-px w-16 bg-white"></span>
        </div>
    </div>

</section>