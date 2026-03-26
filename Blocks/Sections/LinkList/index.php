<?php

/**
 * LinkList Block Template
 *
 * @var string $heading
 */

if (empty($heading)) return;
?>

<section class="link_list">
    <div class="container mx-auto px-4">
        <h2 class="section-title left-[50%] -translate-x-1/2">
            <?php echo esc_html($heading); ?>
        </h2>
    </div>
</section>