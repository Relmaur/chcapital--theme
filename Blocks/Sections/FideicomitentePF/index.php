<?php

/**
 * FideicomitentePF Block Template
 *
 * @var string $heading
 * @var string $subheading
 */

use TAW\Core\Form\Form;
?>

<section class="fideicomitente-pf ch-section">
    <div class="section-container--sm">

        <?php if ($heading) : ?>
            <div class="fideicomitente-pf__header">
                <h2 class="fideicomitente-pf__heading"><?php echo esc_html($heading); ?></h2>
                <?php if ($subheading) : ?>
                    <p class="fideicomitente-pf__subheading"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="fideicomitente-pf__form">
            <?php Form::display('fideicomitente_pf'); ?>
        </div>

    </div>
</section>
