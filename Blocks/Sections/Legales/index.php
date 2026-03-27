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
        <h2 class="section-title left-[50%] -translate-x-1/2">
            <?php echo esc_html($heading); // dump($links); 
            ?>
        </h2>
        <div class="links flex flex-col justify-center sm:flex-row items-stretch gap-4 mt-6">
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