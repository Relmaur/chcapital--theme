<?php
/**
 * @var string $text
 * @var string $url
 * @var string $variant
 * @var string $target
 */

if (empty($text)) return;
?>

<a href="<?php echo esc_url($url); ?>"
    class="btn btn--<?php echo esc_attr($variant); ?> flex justify-center items-center gap-2 px-4 py-2.5 rounded bg-primary text-white text-md font-medium w-full sm:w-fit hover:bg-secondary transition-colors"
    target="<?php echo esc_attr($target); ?>">
    <?php echo esc_html($text); ?>
</a>