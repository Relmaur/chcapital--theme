<?php

/**
 * Legales Block Template
 *
 * @var array $links
 */
?>

<div class="legales flex items-stretch gap-10 justify-center text-sm">
    <?php if (empty($links)) : ?>
        <p><?php echo __('No hay enlaces legales disponibles.', 'taw-theme'); ?></p>
    <?php else : ?>
        <?php foreach ($links as $link) : ?>
            <a href="<?php echo esc_url($link['url']); ?>" class="flex-1 text-2xl flex items-center gap-4 py-3 px-2 border border-gray-300 w-fit  rounded-md" target="_blank" rel="noopener">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-10 min-w-10 text-primary">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 0 1-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 0 1-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 0 1-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584ZM12 18a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                </svg>
                <?php echo esc_html($link['text']); ?>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>