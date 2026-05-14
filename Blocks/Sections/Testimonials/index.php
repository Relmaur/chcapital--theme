<?php

/**
 * Testimonials Block Template
 *
 * Renders a static card grid or an Embla carousel depending on $is_slider.
 *
 * @var string $heading
 * @var string $subheading
 * @var array  $items      Each: quote, name, role
 * @var bool   $is_slider
 */

if (empty($items)) return;
?>
<section class="testimonials ch-section bg-lightgray">
    <div class="section-container--sm">

        <?php if (!empty($heading)) : ?>
            <h2 class="section-title"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if (!empty($subheading)) : ?>
            <p class="section-subtitle"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>

        <?php if (!empty($is_slider)) : ?>

        <div class="testimonials__embla">
            <div class="testimonials__viewport">
                <div class="testimonials__container">
                    <?php foreach ($items as $item) : ?>
                    <div class="testimonials__slide">
                        <?php /* card shared partial */ ?>
                        <blockquote class="testimonial-card">
                            <p class="testimonial-card__quote"><?php echo esc_html($item['quote']); ?></p>
                            <footer class="testimonial-card__footer">
                                <cite class="testimonial-card__name"><?php echo esc_html($item['name']); ?></cite>
                                <?php if (!empty($item['role'])) : ?>
                                    <span class="testimonial-card__role"><?php echo esc_html($item['role']); ?></span>
                                <?php endif; ?>
                            </footer>
                        </blockquote>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="testimonials__controls">
                <button class="testimonials__btn testimonials__btn--prev" type="button" aria-label="<?php esc_attr_e('Anterior', 'taw-theme'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div class="testimonials__dots" role="tablist" aria-label="<?php esc_attr_e('Testimonios', 'taw-theme'); ?>"></div>

                <button class="testimonials__btn testimonials__btn--next" type="button" aria-label="<?php esc_attr_e('Siguiente', 'taw-theme'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>

        <?php else : ?>

        <div class="testimonials__grid">
            <?php foreach ($items as $item) : ?>
            <blockquote class="testimonial-card">
                <p class="testimonial-card__quote"><?php echo esc_html($item['quote']); ?></p>
                <footer class="testimonial-card__footer">
                    <cite class="testimonial-card__name"><?php echo esc_html($item['name']); ?></cite>
                    <?php if (!empty($item['role'])) : ?>
                        <span class="testimonial-card__role"><?php echo esc_html($item['role']); ?></span>
                    <?php endif; ?>
                </footer>
            </blockquote>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>

    </div>
</section>
