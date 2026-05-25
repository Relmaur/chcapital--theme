<?php

/**
 * ContactForm Block Template
 *
 * Two-column layout: contact details (from OptionsPage) on the left,
 * TAW contact form on the right.
 *
 * @var string $heading
 * @var string $subheading
 * @var string $hours       Office hours string
 * @var string $phone       From OptionsPage: company_phone
 * @var string $email       From OptionsPage: company_email
 * @var string $address     From OptionsPage: company_address (HTML/wysiwyg)
 * @var array  $social      Keyed by platform: facebook, instagram, twitter, linkedin, youtube
 */

use TAW\Core\Form\Form;

$social_icons = [
    'facebook'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
    'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
    'twitter'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
    'linkedin'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>',
    'youtube'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="white"/></svg>',
];
?>
<section class="contact-form ch-section">
    <div class="section-container--sm">
        <div class="contact-form__inner">

            <!-- ── Contact Info ──────────────────────────────────── -->
            <div class="contact-form__info">

                <h2 class="contact-form__heading"><?php echo esc_html($heading); ?></h2>

                <?php if ($subheading) : ?>
                    <p class="contact-form__subheading"><?php echo esc_html($subheading); ?></p>
                <?php endif; ?>

                <ul class="contact-form__details">

                    <?php if ($phone) : ?>
                    <li class="contact-form__detail">
                        <span class="contact-form__detail-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.73a16 16 0 0 0 6.29 6.29l.86-.86a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7a2 2 0 0 1 1.72 2.01z"/>
                            </svg>
                        </span>
                        <div>
                            <span class="contact-form__detail-label"><?php esc_html_e('Teléfono', 'taw-theme'); ?></span>
                            <a href="tel:<?php echo esc_attr(preg_replace('/\D/', '', $phone)); ?>" class="contact-form__detail-value">
                                <?php echo esc_html($phone); ?>
                            </a>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if ($email) : ?>
                    <li class="contact-form__detail">
                        <span class="contact-form__detail-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </span>
                        <div>
                            <span class="contact-form__detail-label"><?php esc_html_e('Correo electrónico', 'taw-theme'); ?></span>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-form__detail-value">
                                <?php echo esc_html($email); ?>
                            </a>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if ($address) : ?>
                    <li class="contact-form__detail">
                        <span class="contact-form__detail-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                        </span>
                        <div>
                            <span class="contact-form__detail-label"><?php esc_html_e('Dirección', 'taw-theme'); ?></span>
                            <span class="contact-form__detail-value contact-form__detail-value--address">
                                <?php echo wp_kses_post($address); ?>
                            </span>
                        </div>
                    </li>
                    <?php endif; ?>

                    <?php if ($hours) : ?>
                    <li class="contact-form__detail">
                        <span class="contact-form__detail-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </span>
                        <div>
                            <span class="contact-form__detail-label"><?php esc_html_e('Horario de atención', 'taw-theme'); ?></span>
                            <span class="contact-form__detail-value"><?php echo esc_html($hours); ?></span>
                        </div>
                    </li>
                    <?php endif; ?>

                </ul>

                <?php if (!empty($social)) : ?>
                <div class="contact-form__social">
                    <p class="contact-form__social-label"><?php esc_html_e('Síguenos', 'taw-theme'); ?></p>
                    <div class="contact-form__social-links">
                        <?php foreach ($social as $platform => $url) :
                            if (empty($social_icons[$platform])) continue;
                        ?>
                        <a
                            href="<?php echo esc_url($url); ?>"
                            class="contact-form__social-link"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="<?php echo esc_attr(ucfirst($platform === 'twitter' ? 'X (Twitter)' : $platform)); ?>"
                        >
                            <?php echo $social_icons[$platform]; // phpcs:ignore — inline SVG, safe ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div><!-- /.contact-form__info -->

            <!-- ── Form ──────────────────────────────────────────── -->
            <div class="contact-form__form-wrap">
                <?php Form::display('contact_page_form'); ?>
            </div><!-- /.contact-form__form-wrap -->

        </div><!-- /.contact-form__inner -->
    </div>
</section>
