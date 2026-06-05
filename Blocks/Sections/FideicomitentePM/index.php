<?php

/**
 * FideicomitentePM Block Template
 *
 * @var string $heading
 * @var string $subheading
 */

use TAW\Core\Form\Form;
?>

<section class="fideicomitente-pm ch-section">
    <div class="section-container--sm">

        <?php if ($heading) : ?>
            <div class="fideicomitente-pm__header">
                <h2 class="fideicomitente-pm__heading"><?php echo esc_html($heading); ?></h2>
                <?php if ($subheading) : ?>
                    <p class="fideicomitente-pm__subheading"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="fideicomitente-pm__form">
            <?php Form::display('fideicomitente_pm'); ?>
        </div>

    </div>
</section>
