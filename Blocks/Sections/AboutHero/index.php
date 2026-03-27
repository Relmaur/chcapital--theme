<?php

/**
 * AboutHero Component Template
 *
 * @var string $heading
 * @var string $subtitle
 * @var int    $image_id  WordPress attachment ID for background image
 */

use TAW\Helpers\Image;

$bg_url = $image_id ? Image::background($image_id, 'full', ['url_only' => true]) : null;
?>
<section class="about-hero ch-section border-b-5 border-b-primary"
    style="<?php echo $bg_url ? 'background-image: url(' . esc_url($bg_url) . ');' : ''; ?>">

    <div class="about-hero__overlay"></div>

    <div class="section-container--sm relative z-10 flex flex-col items-center text-center">
        <nav class="about-hero__breadcrumb mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2 text-sm">
                <li><a href="/" class="opacity-70 hover:opacity-100 transition-opacity"><?php _e('Inicio', 'taw-theme'); ?></a></li>
                <li class="opacity-40" aria-hidden="true">/</li>
                <li class="font-medium" aria-current="page"><?php echo esc_html($heading); ?></li>
            </ol>
        </nav>

        <h1 class="about-hero__heading text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
            <?php echo esc_html($heading); ?>
        </h1>

        <?php if ($subtitle) : ?>
            <p class="about-hero__subtitle mt-6 text-lg sm:text-xl max-w-2xl leading-relaxed">
                <?php echo esc_html($subtitle); ?>
            </p>
        <?php endif; ?>

        <div class="about-hero__divider mt-10 flex items-center gap-3">
            <span class="h-px w-16 bg-current opacity-30"></span>
            <span class="about-hero__ornament w-2 h-2 rounded-full bg-current opacity-50"></span>
            <span class="h-px w-16 bg-current opacity-30"></span>
        </div>
    </div>

</section>
