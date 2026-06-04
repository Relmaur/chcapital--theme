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
 * @var array  $services
 */

use TAW\Helpers\Image;
?>
<section class="who-are-we ch-section">
    <div class="section-container--sm">
        <h2 class="section-title"><?php echo esc_html($heading); ?></h2>

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
            </div>

            <!-- Content column -->
            <div class="who-are-we__content">
                <div class="who-are-we__body prose">
                    <?php echo wp_kses_post($content); ?>
                </div>

                <?php if ($services): ?>
                    <p class="text-xl mt-3 font-semibold">Nuestros servicios</p>
                    <div class="services flex flex-col gap-3 mt-4">
                        <?php foreach ($services as $i => $service): ?>
                            <a href="<?php echo esc_url($service['url']); ?>" class="service group flex items-center justify-between p-1 hover:bg-gray-100 transition-all rounded-sm" target="_self">
                                <div class="icon-and-text flex items-center gap-2 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-primary">
                                        <path fill-rule="evenodd" d="M9.638 1.093a.75.75 0 0 1 .724 0l2 1.104a.75.75 0 1 1-.724 1.313L10 2.607l-1.638.903a.75.75 0 1 1-.724-1.313l2-1.104ZM5.403 4.287a.75.75 0 0 1-.295 1.019l-.805.444.805.444a.75.75 0 0 1-.724 1.314L3.5 7.02v.73a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .388-.657l1.996-1.1a.75.75 0 0 1 1.019.294Zm9.194 0a.75.75 0 0 1 1.02-.295l1.995 1.101A.75.75 0 0 1 18 5.75v2a.75.75 0 0 1-1.5 0v-.73l-.884.488a.75.75 0 1 1-.724-1.314l.806-.444-.806-.444a.75.75 0 0 1-.295-1.02ZM7.343 8.284a.75.75 0 0 1 1.02-.294L10 8.893l1.638-.903a.75.75 0 1 1 .724 1.313l-1.612.89v1.557a.75.75 0 0 1-1.5 0v-1.557l-1.612-.89a.75.75 0 0 1-.295-1.019ZM2.75 11.5a.75.75 0 0 1 .75.75v1.557l1.608.887a.75.75 0 0 1-.724 1.314l-1.996-1.101A.75.75 0 0 1 2 14.25v-2a.75.75 0 0 1 .75-.75Zm14.5 0a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-.388.657l-1.996 1.1a.75.75 0 1 1-.724-1.313l1.608-.887V12.25a.75.75 0 0 1 .75-.75Zm-7.25 4a.75.75 0 0 1 .75.75v.73l.888-.49a.75.75 0 0 1 .724 1.313l-2 1.104a.75.75 0 0 1-.724 0l-2-1.104a.75.75 0 1 1 .724-1.313l.888.49v-.73a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                                    </svg>
                                    <p class="service__name"><?php echo esc_html($service['name']); ?></p>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 group-hover:block hidden">
                                    <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 0 0-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 0 0 .75-.75v-4a.75.75 0 0 1 1.5 0v4A2.25 2.25 0 0 1 12.75 17h-8.5A2.25 2.25 0 0 1 2 14.75v-8.5A2.25 2.25 0 0 1 4.25 4h5a.75.75 0 0 1 0 1.5h-5Z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 0 0 1.06.053L16.5 4.44v2.81a.75.75 0 0 0 1.5 0v-4.5a.75.75 0 0 0-.75-.75h-4.5a.75.75 0 0 0 0 1.5h2.553l-9.056 8.194a.75.75 0 0 0-.053 1.06Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- <?php if ($author_quote) : ?>
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
                <?php endif; ?> -->
            </div>

        </div>
    </div>
</section>