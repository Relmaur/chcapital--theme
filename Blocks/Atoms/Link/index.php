<?php

/**
 * Link Block Template
 *
 * @var string $type The type of link (e.g., 'icon', 'blurb').
 * @var array $link An associative array containing 'url' and 'text' for the link.
 */

$icon = isset($link['icon']) && $link['icon'] ? $link['icon'] : null;
$blurb_background = isset($link['blurb_background']) && $link['blurb_background'] ? $link['blurb_background'] : null;

?>

<?php switch ($type): ?>
<?php
    case 'icon': ?>
        <a href="<?php echo esc_url($link['url']); ?>" class="flex-1 text-2xl flex items-center gap-4 py-3 px-2 border border-gray-300 w-fit  rounded-md" target="<?php echo esc_attr($link['target']); ?>" rel="noopener">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-10 min-w-10 text-primary">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 0 1-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 0 1-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 0 1-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584ZM12 18a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
            </svg>
            <?php echo esc_html($link['text']); ?>
        </a>
        <?php break; ?>
    <?php
    case 'blurb': ?>
        <a href="<?php echo esc_url($link['url']); ?>" class="link flex flex-col justify-end link--blurb" <?php echo $blurb_background ? 'style="background-color:' . esc_attr($blurb_background) . ';"' : ''; ?> target="<?php echo esc_attr($link['target']); ?>" rel="noopener">
            <div class="icon-and-text">
                <?php if ($icon) : ?>
                    <div class="icon size-8 text-primary">
                        <?php echo file_get_contents(get_template_directory() . '/resources/static/svg/' . $icon . '.svg'); ?>
                    </div>
                <?php endif; ?>
                <?php echo esc_html($link['text']); ?>
            </div>
        </a>
        <?php break; ?>
    <?php
    default: ?>
        <a href="<?php echo esc_url($link['url']); ?>" class="link" target="<?php echo esc_attr($link['target']); ?>" rel="noopener">
            <?php echo esc_html($link['text']); ?>
        </a>
<?php endswitch; ?>