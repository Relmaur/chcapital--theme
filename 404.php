<?php
/**
 * 404.php — Template for page-not-found responses.
 */

get_header();
?>

<div class="mx-auto max-w-360 w-[90%] py-24 text-center">

    <p class="text-9xl font-bold text-gray-100 select-none">404</p>

    <h1 class="mt-4 text-3xl font-bold"><?php esc_html_e('No se encontró la página', 'taw-theme'); ?></h1>
    <p class="mt-3 text-gray-500 max-w-md mx-auto">
        <?php esc_html_e("La página que estás buscando no existe o puede haber sido movida.", 'taw-theme'); ?>
    </p>

    <a href="<?php echo esc_url(home_url('/')); ?>"
       class="mt-8 inline-block px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
        <?php esc_html_e('Volver al inicio', 'taw-theme'); ?>
    </a>

</div>

<?php get_footer();
