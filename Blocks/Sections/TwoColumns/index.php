<?php

/**
 * TwoColumns Block Template
 *
 * @var string $heading
 */

if (empty($heading)) return;

use TAW\Helpers\Image;
?>

<section class="two_columns ch-section colored bg-lightgray">
    <div class="section-container--sm mx-auto px-4">
        <div class="two_columns__grid">
            <div class="two_columns__text">
                <h2 class="section-title two_columns__heading">
                    <?php echo esc_html($heading); ?>
                </h2>
                <?php if (!empty($subheading)) : ?>
                    <p class="two_columns__subheading">
                        <?php echo esc_html($subheading); ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php if (!empty($image)) : ?>
                <div class="two_columns__image">
                    <?php echo Image::render($image, 'full', get_the_title(), [
                        'class' => 'two_columns__image-img',
                    ]); ?>
                    <?php if (!empty($image_description)) : ?>
                        <p class="two_columns__image-description">
                            <?php echo wp_kses_post($image_description); ?>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>