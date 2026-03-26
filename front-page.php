<?php
// index.php (or front-page.php)

use TAW\Core\Block\BlockRegistry;

// 1. Declare which blocks this page needs (BEFORE get_header)
BlockRegistry::queue('hero', 'changing_numbers');

// Example
// BlockRegistry::queue('hero', 'stats', 'testimonials', 'cta');

// 2. get_header triggers wp_enqueue_scripts → wp_head → styles in <head>
get_header();
?>

<?php // 3. Render blocks (HTML only, assets already handled) 
?>

<?php BlockRegistry::render('hero'); ?>

<section class="ch-section">
    <div class="section-container--sm flex items-start gap-10 md:flex-row flex-col">
        <div class="image flex-1 rounded-lg shadow-(--image-shadow) overflow-hidden aspect-video">
            <img class="rounded-lg object-cover w-full h-full" src="https://placehold.co/1000x1000" alt="">
        </div>
        <div class="content flex-1">
            <h2 class="section-title">Nuestros Valores</h2>
            <p class="text-base leading-relaxed text-gray-700">En CH Capital, nos dedicamos a garantizar la seguridad, claridad y confianza en cada servicio financiero que prestamos. Como Fiduciario, nuestro compromiso es con la integridad y la transparencia, asegurando que cada parte de la operación se sienta completamente respaldada y protegida. Creemos firmemente que el éxito de nuestros clientes es el pilar de nuestro propio éxito.</p>

            <div class="author-and-title mt-3">
                <p class="text-lg text-primary font-semibold">— Alfredo Chumacero</p>
                <p class="text-sm text-gray-500">Fundador</p>
            </div>
        </div>
    </div>
</section>

<?php BlockRegistry::render('changing_numbers'); ?>

<section class="ch-section">
    <div class="section-container--sm">
        <h2 class="section-title left-[50%] translate-x-[-50%]">Legales</h2>
        <?php (new TAW\Blocks\Molecules\Legales\Legales())->render(); ?>
    </div>
</section>

<?php get_footer(); ?>