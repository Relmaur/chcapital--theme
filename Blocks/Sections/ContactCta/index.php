<?php

/**
 * ContactCta Block Template
 *
 * @var string $heading
 * @var string $subheading
 * @var string $shortcode   Optional form shortcode; falls back to TAW Form
 */

use TAW\Core\Form\Form;
?>
<section class="contact-cta ch-section bg-primary colored">
    <div class="section-container--sm">
        <div class="contact-cta__inner">

            <div class="contact-cta__headline">
                <?php if ($heading) : ?>
                    <h2 class="section-title contact-cta__heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>

                <?php if ($subheading) : ?>
                    <p class="contact-cta__sub"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>

            <div class="contact-cta__form-wrap">
                <?php if (!empty($shortcode)) : ?>
                    <?php echo do_shortcode($shortcode); ?>
                <?php else : ?>
                    <?php
                    (new Form([
                        'id'           => 'contact_inquiry',
                        'submit_label' => __('Enviar mensaje', 'taw-theme'),
                        'email'        => [
                            'to_self' => [
                                'subject'  => __('Nueva consulta desde el sitio web', 'taw-theme'),
                                'template' => 'contact-self',
                            ],
                        ],
                        'messages' => [
                            'success' => __('¡Gracias! Nos pondremos en contacto contigo pronto.', 'taw-theme'),
                        ],
                        'fields' => [
                            ['id' => 'name',    'label' => __('Nombre', 'taw-theme'),             'type' => 'text',     'required' => true],
                            ['id' => 'company', 'label' => __('Empresa', 'taw-theme'),            'type' => 'text',     'required' => false],
                            ['id' => 'phone',   'label' => __('Teléfono', 'taw-theme'),           'type' => 'tel',      'required' => true],
                            ['id' => 'email',   'label' => __('Correo electrónico', 'taw-theme'), 'type' => 'email',    'required' => true],
                            ['id' => 'message', 'label' => __('Mensaje', 'taw-theme'),            'type' => 'textarea', 'required' => false],
                        ],
                    ]))->render();
                    ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
