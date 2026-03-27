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

<section <?php echo $section_id ? 'id="' . esc_attr($section_id) . '"' : ''; ?> class="ch-section link_list border-b border-b-gray-200">
    <div class="section-container--sm mx-auto px-4">

        <h2 class="section-title left-[50%] -translate-x-1/2">
            <?php echo esc_html($heading); ?>
        </h2>

        <?php if ($links): ?>
            <div class="links flex items-center justify-start gap-3 mt-5 flex-wrap">
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

