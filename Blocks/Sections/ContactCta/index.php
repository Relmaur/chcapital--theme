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
<section class="contact-cta ch-section" style="--background-url: url('<?php echo get_site_url() ?>/wp-content/uploads/2026/05/ch-contact-us-bg-image.webp')">
    <div class="section-container--sm">
        <div class="contact-cta__inner">

            <div class="contact-cta__headline">
                <?php if ($heading) : ?>
                    <h2 class="section-title--white contact-cta__heading"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>

                <?php if ($subheading) : ?>
                    <p class="contact-cta__sub"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>
            </div>

            <div class="contact-cta__form-wrap">
                <?php if (!empty($shortcode)) : ?>
                    <?php echo do_shortcode($shortcode); ?>
                <?php else : ?>
                    <?php Form::display('contact_inquiry'); ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>