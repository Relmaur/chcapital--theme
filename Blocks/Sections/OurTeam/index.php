<?php

/**
 * OurTeam Component Template
 *
 * @var string $heading
 * @var string $subheading
 * @var array  $members  [ ['member_image' => int, 'member_name' => '', 'member_position' => '', 'member_bio' => ''] ]
 */

use TAW\Helpers\Image;
?>
<section class="our-team ch-section">
    <div class="section-container--sm">

        <header class="our-team__header">
            <h2 class="section-title"><?php echo esc_html($heading); ?></h2>
            <?php if ($subheading) : ?>
                <p class="our-team__subheading"><?php echo esc_html($subheading); ?></p>
            <?php endif; ?>
        </header>

        <?php if (!empty($members)) : ?>
            <div class="our-team__grid">
                <?php foreach ($members as $member) :
                    $image_id = (int) ($member['member_image'] ?? 0);
                    $name     = $member['member_name'] ?? '';
                    $position = $member['member_position'] ?? '';
                    $bio      = $member['member_bio'] ?? '';
                ?>
                    <article class="our-team__card">
                        <div class="our-team__photo-wrap">
                            <?php if ($image_id) : ?>
                                <?php echo Image::render($image_id, 'medium', esc_attr($name), ['class' => 'our-team__photo']); ?>
                            <?php else : ?>
                                <div class="our-team__photo-placeholder" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="our-team__info">
                            <?php if ($name) : ?>
                                <h3 class="our-team__name"><?php echo esc_html($name); ?></h3>
                            <?php endif; ?>
                            <?php if ($position) : ?>
                                <p class="our-team__position"><?php echo esc_html($position); ?></p>
                            <?php endif; ?>
                            <?php if ($bio) : ?>
                                <p class="our-team__bio"><?php echo esc_html($bio); ?></p>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
