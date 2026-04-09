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
                    // dump($member);
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
                                <h3 class="our-team__name"><?php echo wp_kses_post($name); ?></h3>
                            <?php endif; ?>
                            <?php if ($position) : ?>
                                <p class="our-team__position"><?php echo wp_kses_post($position); ?></p>
                            <?php endif; ?>
                            <?php if ($bio) : ?>
                                <p class="our-team__bio inline-block mb-2!"><?php echo wp_kses_post($bio); ?></p>
                            <?php endif; ?>
                            <div class="our-team__linkedin mt-auto">
                                <a href="<?php echo esc_url($social_media['linkedin']); ?>" class="social_media__link flex transition-al hover:-translate-y-0.5 <?php echo esc_attr($icon_color ?? 'text-white/65 hover:text-white'); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-primary">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>