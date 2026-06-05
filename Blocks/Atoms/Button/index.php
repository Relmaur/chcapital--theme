<?php
/**
 * @var string $text
 * @var string $url
 * @var string $variant  primary | secondary | outline | ghost | white | outline-white
 * @var string $size     sm | md | lg
 * @var string $target
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
    class="btn btn--<?php echo esc_attr($variant); ?> flex justify-center items-center gap-2 <?php echo $size_classes; ?> rounded font-medium w-full sm:w-fit transition-colors <?php echo $variant_classes; ?>"
    target="<?php echo esc_attr($target); ?>">
    <?php echo esc_html($text); ?>
</a>
