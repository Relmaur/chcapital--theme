<?php

/**
 * WhoAreWe Component Template
 *
 * @var string $heading
 * @var string $content       HTML content (from wysiwyg)
 * @var int    $image_id      WordPress attachment ID
 * @var string $author_name
 * @var string $author_title
 * @var string $author_quote
 */

use TAW\Helpers\Image;
?>
<section class="who-are-we ch-section">
    <div class="section-container--sm">
        <div class="who-are-we__grid">

            <!-- Image column -->
            <div class="who-are-we__media">
                <div class="who-are-we__image-wrap">
                    <?php if ($image_id) : ?>
                        <?php echo Image::render($image_id, 'large', esc_attr($heading), ['class' => 'who-are-we__img']); ?>
                    <?php else : ?>
                        <img class="who-are-we__img" src="https://placehold.co/680x520/004a98/ffffff?text=CH+Capital" alt="<?php echo esc_attr($heading); ?>">
                    <?php endif; ?>
                </div>

                <?php if ($author_quote) : ?>
                    <blockquote class="who-are-we__quote">
                        <p class="who-are-we__quote-text">"<?php echo esc_html($author_quote); ?>"</p>
                        <footer class="who-are-we__quote-footer">
                            <?php if ($author_name) : ?>
                                <cite class="who-are-we__author-name">— <?php echo esc_html($author_name); ?></cite>
                            <?php endif; ?>
                            <?php if ($author_title) : ?>
                                <span class="who-are-we__author-title"><?php echo esc_html($author_title); ?></span>
                            <?php endif; ?>
                        </footer>
                    </blockquote>
                <?php endif; ?>
            </div>

            <!-- Content column -->
            <div class="who-are-we__content">
                <h2 class="section-title"><?php echo esc_html($heading); ?></h2>
                <div class="who-are-we__body prose">
                    <?php echo wp_kses_post($content); ?>
                </div>
            </div>

        </div>
    </div>
</section>
