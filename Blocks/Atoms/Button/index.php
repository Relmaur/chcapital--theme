<?php
/**
 * @var string $text
 * @var string $url
 * @var string $variant  primary | secondary | outline | ghost | white | outline-white
 * @var string $size     sm | md | lg
 * @var string $target
 * @var string $class    Additional CSS classes for the button
 * @var bool   $download True = force-download (adds the `download` attribute + a download icon) instead of navigating
 */

if (empty($text)) return;

$variant_classes = match ($variant) {
    'secondary'     => 'bg-gray-100 text-primary hover:bg-gray-200',
    'outline'       => 'border-1 border-primary text-primary hover:bg-primary hover:text-white',
    'ghost'         => 'text-primary hover:bg-primary/10',
    'white'         => 'bg-white text-primary hover:bg-gray-100',
    'outline-white' => 'border-1 border-white text-white hover:bg-white hover:text-primary',
    default         => 'bg-primary text-white hover:bg-secondary',
};

$size_classes = match ($size) {
    'sm'  => 'px-3 py-1.5 text-sm',
    'lg'  => 'px-7 py-4 text-lg',
    default => 'px-4 py-2.5 text-md',
};
?>

<a href="<?php echo esc_url($url); ?>"
    class="btn btn--<?php echo esc_attr($variant); ?> flex justify-center items-center gap-2 <?php echo $size_classes; ?> rounded font-medium w-full sm:w-fit transition-colors <?php echo $variant_classes; ?> <?php echo esc_attr($class); ?>"
    target="<?php echo esc_attr($target); ?>"
    <?php echo $target === '_blank' ? 'rel="noopener"' : ''; ?>
    <?php echo !empty($download) ? 'download' : ''; ?>>
    <?php if (!empty($download)) : ?>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 shrink-0">
            <path d="M10.75 2.75a.75.75 0 0 0-1.5 0v8.614L6.295 8.235a.75.75 0 1 0-1.09 1.03l4.25 4.5a.75.75 0 0 0 1.09 0l4.25-4.5a.75.75 0 0 0-1.09-1.03l-2.955 3.129V2.75Z" />
            <path d="M3.5 12.75a.75.75 0 0 0-1.5 0v2.5A2.75 2.75 0 0 0 4.75 18h10.5A2.75 2.75 0 0 0 18 15.25v-2.5a.75.75 0 0 0-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5Z" />
        </svg>
    <?php endif; ?>
    <?php echo esc_html($text); ?>
</a>
