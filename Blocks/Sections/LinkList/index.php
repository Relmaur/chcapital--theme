<?php

/**
 * LinkList Block Template
 *
 * @var string $section_id
 * @var string $heading
 * @var string $description
 * @var string $cta_text
 * @var string $cta_url
 * @var string $cta_target
 * @var array  $links
 */

if (empty($heading)) return;
?>

<section <?php echo $section_id ? 'id="' . esc_attr($section_id) . '"' : ''; ?> class="ch-section link_list ">
    <div class="section-container--sm mx-auto px-4">

        <h2 class="section-title">
            <?php echo esc_html($heading); ?>
        </h2>

        <?php if ($description) : ?>
            <p class="mb-5"><?php echo wp_kses_post($description); ?></p>
        <?php endif; ?>

        <?php if ($cta_text && $cta_url) : ?>
            <?php (new TAW\Blocks\Atoms\Button\Button())->render([
                'url'    => $cta_url,
                'text'   => $cta_text,
                'target' => $cta_target,
            ]) ?>
        <?php endif; ?>

        <?php if ($links): ?>
            <div class="links flex items-center justify-start gap-3 mt-8 flex-wrap">
                <?php // dump($links) 
                ?>
                <?php foreach ($links as $link):

                    $image = wp_get_attachment_image_src($link['image'] ?? '', 'full')[0] ?? 'https://placehold.co/600x400?text=Link+Image';

                    (new TAW\Blocks\Atoms\Link\Link())->render([
                        'type' => 'blurb',
                        'blurb_background' => $image, // Use the retrieved image or placeholder
                        'icon' => $link['icon'] ?? '', // Optional icon
                        'classes' => 'flex-1 aspect-16/9', // Example classes for layout
                        'link' => [
                            'url'  => $link['url'],
                            'text' => $link['text'],
                            'target' => '_blank', // Add target attribute
                        ]
                    ]);
                endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>