<?php

/**
 * Legales Block Template
 *
 * @var string $heading
 * @var array $links
 */

if (empty($heading)) return;
?>

<section class="legales ch-section">
    <div class="section-container--sm">
        <h2 class="section-title">
            <?php echo esc_html($heading); // dump($links); 
            ?>
        </h2>
        <p class="mb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem voluptatum harum dolorem, ea quae eius nulla sed rem ipsum consequuntur nobis id dolores quis libero atque voluptatem laborum saepe ad.</p>
        <div class="links flex flex-col justify-start sm:flex-row items-stretch gap-4 mt-6">
            <?php foreach ($links as $link): (new TAW\Blocks\Atoms\Link\Link())->render([
                    'type' => 'icon',
                    'classes' => 'w-fit',
                    'link' => [
                        'url' => $link['url'] ?? '#',
                        'text' => $link['text'] ?? '',
                        'target' => '_blank',
                    ],
                ]);
            endforeach; ?>
        </div>
    </div>
</section>