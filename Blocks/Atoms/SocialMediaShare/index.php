<?php

/**
 * SocialMediaShare Block Template
 *
 * @var string $article_url
 * @var int $post_id
 */

$share_url   = urlencode($article_url);
$share_title = urlencode(get_the_title($post_id));

$share_links = [
    [
        'label' => __('Copiar enlace', 'taw-theme'),
        'attrs' => 'x-data @click="navigator.clipboard.writeText(\'' . esc_js($article_url) . '\'); $el.querySelector(\'span\').textContent = \'' . esc_js(__('¡Copiado!', 'taw-theme')) . '\'; setTimeout(() => $el.querySelector(\'span\').textContent = \'' . esc_js(__('Copiar enlace', 'taw-theme')) . '\', 2000)"',
        'href'  => null,
        'icon'  => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"/></svg>',
    ],
    [
        'label' => 'Facebook',
        'attrs' => 'target="_blank" rel="noopener noreferrer"',
        'href'  => 'https://www.facebook.com/sharer/sharer.php?u=' . $share_url,
        'icon'  => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047v-2.66c0-3.025 1.791-4.697 4.533-4.697 1.313 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.887v2.264h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073Z"/></svg>',
    ],
    [
        'label' => 'X / Twitter',
        'attrs' => 'target="_blank" rel="noopener noreferrer"',
        'href'  => 'https://x.com/intent/tweet?url=' . $share_url . '&text=' . $share_title,
        'icon'  => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
    ],
    [
        'label' => 'LinkedIn',
        'attrs' => 'target="_blank" rel="noopener noreferrer"',
        'href'  => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $share_url,
        'icon'  => '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
    ],
    [
        'label' => __('Correo', 'taw-theme'),
        'attrs' => '',
        'href'  => 'mailto:?subject=' . $share_title . '&body=' . $share_url,
        'icon'  => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>',
    ],
]
?>


<div class="social_media_share flex items-center gap-2 flex-wrap mb-6">
    <span class="text-xs font-semibold uppercase tracking-widest text-gray-400 mr-1"><?php esc_html_e('Compartir', 'taw-theme'); ?></span>
    <?php foreach ($share_links as $link) :
        $tag  = $link['href'] ? 'a' : 'button';
        $href = $link['href'] ? 'href="' . esc_url($link['href']) . '"' : '';
    ?>
        <<?php echo $tag; ?> <?php echo $href; ?> <?php echo $link['attrs']; ?>
            title="<?php echo esc_attr($link['label']); ?>"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-xs font-medium text-gray-600 hover:border-blue-300 hover:text-primary hover:bg-blue-50 transition-all no-underline cursor-pointer">
            <?php echo $link['icon']; ?>
            <span><?php echo esc_html($link['label']); ?></span>
        </<?php echo $tag; ?>>
    <?php endforeach; ?>
</div>