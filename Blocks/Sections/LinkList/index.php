<?php

/**
 * LinkList Block Template
 *
 * @var string $section_id
 * @var string $heading
 * @var array $links
 */

if (empty($heading)) return;
?>

<section <?php echo $section_id ? 'id="' . esc_attr($section_id) . '"' : ''; ?> class="ch-section link_list ">
    <div class="section-container--sm mx-auto px-4">

        <h2 class="section-title">
            <?php echo esc_html($heading); ?>
        </h2>

        <p class="mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem voluptatum harum dolorem, ea quae eius nulla sed rem ipsum consequuntur nobis id dolores quis libero atque voluptatem laborum saepe ad.</p>

        <?php (new TAW\Blocks\Atoms\Button\Button())->render([
            'url' => '#',
            'text' => 'Explora nuestros servicios',
            'target' => '_blank',
        ]) ?>

        <?php if ($links): ?>
            <div class="links flex items-center justify-start gap-3 mt-8 flex-wrap">
                <?php // dump($links) 
                ?>
                <?php foreach ($links as $link): (new TAW\Blocks\Atoms\Link\Link())->render([
                        'type' => 'blurb',
                        'blurb_background' => 'https://placehold.co/600x400?text=Link+Image', // Placeholder image
                        'icon' => $link['icon'] ?? '', // Optional icon
                        'classes' => 'flex-1', // Example classes for layout
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