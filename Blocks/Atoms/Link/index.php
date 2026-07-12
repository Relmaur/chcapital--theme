<?php

/**
 * Link Block Template
 *
 * @var string $type The type of link (e.g., 'icon', 'blurb').
 * @var string|null $blurb_background Optional background image URL for 'blurb' type.
 * @var string|null $icon Optional icon HTML for 'blurb' type.
 * @var string $classes Additional CSS classes to apply to the link.
 * @var array $link An associative array containing 'url' and 'text' for the link.
 */

$icon = isset($icon) && !empty($icon) ? $icon : null;
$blurb_background = isset($blurb_background) && !empty($blurb_background) ? $blurb_background : null;
$classes = !empty($classes) ? $classes : '';

?>

<?php switch ($type): ?>
<?php
    case 'icon': ?>
        <a href="<?php echo esc_url($link['url']); ?>" class="flex items-center gap-2 py-2 px-4 border border-gray-300 w-fit rounded-md bg-white transition-colors hover:bg-gray-100<?php echo ' ' . esc_attr($classes); ?>" target="<?php echo esc_attr($link['target']); ?>" rel="noopener">

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-10 min-w-10 text-primary">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 0 1-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 0 1-.837.552c-.676.328-1.028.774-1.028 1.152v.75a.75.75 0 0 1-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584ZM12 18a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
            </svg>
            <?php echo esc_html($link['text']); ?>
        </a>
        <?php break; ?>

    <?php
    case 'blurb': ?>
        <a href="<?php echo esc_url($link['url']); ?>" class="link link--blurb relative flex min-h-50 flex-col justify-end p-4 aspect-3/2 bg-cover bg-center rounded-md group<?php echo ' ' . esc_attr($classes); ?>" <?php echo $blurb_background ? 'style="background-image:url(' . esc_url($blurb_background) . ');"' : ''; ?> target="<?php echo esc_attr($link['target']); ?>" rel="noopener">
            <div class="gradient absolute rounded inset-0 bg-[linear-gradient(0deg,rgba(0,74,152,0.5)_0%,rgba(255,255,255,0)_100%)] z-1"></div>
            <div class="icon-and-text transition-all duration-150 ease-in-out flex items-center gap-2 bg-white/75 px-3 py-2 rounded w-fit relative z-2 group-hover:-translate-y-1">
                <?php if ($icon) : ?>
                    <div class="icon text-primary">
                        <?php echo $icon ?>
                    </div>
                <?php endif; ?>
                <?php echo esc_html($link['text']); ?>
            </div>
        </a>
        <?php break; ?>

    <?php
    default: ?>
        <a href="<?php echo esc_url($link['url']); ?>" class="link<?php echo ' ' . esc_attr($classes); ?>" target="<?php echo esc_attr($link['target']); ?>" rel="noopener">
            <?php echo esc_html($link['text']); ?>
        </a>
<?php endswitch; ?>