<?php
/**
 * TwoColumns Block Template
 *
 * @var string $heading
 */

if (empty($heading)) return;
?>

<section class="two_columns">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold">
            <?php echo esc_html($heading); ?>
        </h2>
    </div>
</section>
