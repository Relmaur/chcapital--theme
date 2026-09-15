<?php

/**
 * "Image Carousel" — native Gutenberg block, scoped to blog posts (the
 * `post` post type) only. This is deliberately NOT a TAW MetaBlock/Block —
 * those drive page-building templates via BlockRegistry, while post_content
 * itself still uses the standard block editor (see single-post.php), which
 * is the gap this fills.
 *
 * Ported from the sibling ls-mexico theme (same client, same feature
 * request) — renamed from ls-mexico/image-carousel to chcapital/image-
 * carousel and re-pointed at this theme's own brand color token
 * (--color-primary) and text domain (already 'taw-theme' on both sites).
 *
 * Dynamic block: only the `images` attribute is saved to post_content (as
 * JSON in the block comment delimiter, since save() returns null) — all
 * markup is produced by chcapital_render_image_carousel() below, so the
 * carousel's JS/CSS can change later without migrating saved posts. No
 * InnerBlocks/core Gallery — this block owns its own attribute shape.
 *
 * Frontend markup: a horizontally-scrolling (CSS scroll-snap) track plus
 * prev/next arrow buttons, driven by the `chImageCarousel` Alpine component
 * (see resources/js/app.js) — arrows call track.scrollBy() one slide at a
 * time and disable themselves at either end. Styled by style.css in this
 * same folder — plain CSS, not Tailwind utility classes, since this markup
 * lives outside the Vite/Tailwind pipeline (see the `style` registration
 * below) and shouldn't depend on app.css's `@source` PHP scan picking up a
 * new file mid-session or a rebuild to see changes.
 * `.wp-block-chcapital-image-carousel__slide` is the class the Alpine
 * component measures for step width; keep it in sync with style.css if
 * this markup changes. Nothing renders at all when there are no images.
 *
 * `autoplay` and `drag` are editor-side toggles (Inspector panel in
 * editor.js) persisted as boolean attributes and passed to the frontend as
 * `data-autoplay`/`data-drag` on the wrapper — the Alpine component reads
 * them off its own `$el.dataset` in init() rather than via x-bind, since
 * they only ever need to be read once. `autoplay` is additionally skipped
 * client-side when the visitor has `prefers-reduced-motion: reduce` set,
 * regardless of the saved attribute. `drag` only ever engages for
 * `pointerType === 'mouse'` — touch/trackpad already get native scrolling
 * for free from `overflow-x: auto` and must not be hijacked by pointer
 * capture, which would fight the browser's own touch-scroll gesture.
 */

add_action('init', function () {
    $dir = __DIR__;

    wp_register_script(
        'chcapital-image-carousel-editor',
        get_template_directory_uri() . '/inc/blocks/image-carousel/editor.js',
        ['wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n'],
        (string) filemtime($dir . '/editor.js'),
        true
    );

    wp_register_style(
        'chcapital-image-carousel-editor',
        get_template_directory_uri() . '/inc/blocks/image-carousel/editor.css',
        [],
        (string) filemtime($dir . '/editor.css')
    );

    // Frontend styles — registered separately from editor_style above so
    // WordPress only enqueues this on pages that actually render the block
    // (see the `style` arg below), never in wp-admin.
    wp_register_style(
        'chcapital-image-carousel-view',
        get_template_directory_uri() . '/inc/blocks/image-carousel/style.css',
        [],
        (string) filemtime($dir . '/style.css')
    );

    register_block_type('chcapital/image-carousel', [
        'api_version'     => '2',
        'title'           => __('Image Carousel', 'taw-theme'),
        'description'     => __('A swipeable carousel of images for blog post content.', 'taw-theme'),
        'category'        => 'media',
        'icon'            => 'images-alt2',
        'supports'        => [
            'align' => ['wide', 'full'],
        ],
        'attributes'      => [
            'images' => [
                'type'    => 'array',
                'default' => [],
                'items'   => [
                    'type'       => 'object',
                    'properties' => [
                        'id'  => ['type' => 'number'],
                        'url' => ['type' => 'string'],
                        'alt' => ['type' => 'string'],
                    ],
                ],
            ],
            'autoplay' => [
                'type'    => 'boolean',
                'default' => false,
            ],
            'drag' => [
                'type'    => 'boolean',
                'default' => true,
            ],
        ],
        'editor_script'   => 'chcapital-image-carousel-editor',
        'editor_style'    => 'chcapital-image-carousel-editor',
        'style'           => 'chcapital-image-carousel-view',
        'render_callback' => 'chcapital_render_image_carousel',
    ]);
});

function chcapital_render_image_carousel(array $attributes): string
{
    $images = is_array($attributes['images'] ?? null) ? $attributes['images'] : [];
    $images = array_values(array_filter($images, static function ($image) {
        return is_array($image) && !empty($image['url']);
    }));

    if (empty($images)) {
        return '';
    }

    $slides = '';
    foreach ($images as $image) {
        $slides .= sprintf(
            '<li class="wp-block-chcapital-image-carousel__slide"><img src="%1$s" alt="%2$s" data-image-id="%3$d" loading="lazy" decoding="async"></li>',
            esc_url($image['url']),
            esc_attr($image['alt'] ?? ''),
            (int) ($image['id'] ?? 0)
        );
    }

    if (count($images) === 1) {
        return sprintf(
            '<div class="wp-block-chcapital-image-carousel"><ul class="wp-block-chcapital-image-carousel__slides">%s</ul></div>',
            $slides
        );
    }

    $autoplay = !empty($attributes['autoplay']);
    $drag     = ($attributes['drag'] ?? true) !== false;

    return sprintf(
        '<div class="wp-block-chcapital-image-carousel" data-carousel data-slide-count="%1$d" data-autoplay="%2$s" data-drag="%3$s" x-data="chImageCarousel" x-on:mouseenter="autoplayPaused = true" x-on:mouseleave="autoplayPaused = false" x-on:focusin="autoplayPaused = true" x-on:focusout="autoplayPaused = false">
            <ul class="wp-block-chcapital-image-carousel__slides" x-ref="track" x-bind:class="{ \'is-dragging\': isDragging }" x-on:pointerdown="dragStart($event)" x-on:pointermove="dragMove($event)" x-on:pointerup="dragEnd()" x-on:pointercancel="dragEnd()">%4$s</ul>
            <button type="button" class="wp-block-chcapital-image-carousel__arrow wp-block-chcapital-image-carousel__arrow--prev" x-on:click="prev()" x-bind:disabled="atStart" aria-label="%5$s">&lsaquo;</button>
            <button type="button" class="wp-block-chcapital-image-carousel__arrow wp-block-chcapital-image-carousel__arrow--next" x-on:click="next()" x-bind:disabled="atEnd" aria-label="%6$s">&rsaquo;</button>
        </div>',
        count($images),
        $autoplay ? 'true' : 'false',
        $drag ? 'true' : 'false',
        $slides,
        esc_attr__('Imagen anterior', 'taw-theme'),
        esc_attr__('Siguiente imagen', 'taw-theme')
    );
}

/**
 * Restrict "Image Carousel" to the `post` post type's editor only — it stays
 * out of the inserter everywhere else (pages, other post types, the Site
 * Editor, widgets/nav editors). A block category alone only groups it in
 * the inserter UI, it doesn't prevent insertion, hence this filter.
 */
add_filter('allowed_block_types_all', function ($allowed_block_types, $editor_context) {
    $blockName = 'chcapital/image-carousel';
    $postType  = $editor_context->post->post_type ?? null;

    if ($postType === 'post') {
        return $allowed_block_types;
    }

    if ($allowed_block_types === true) {
        $allowed_block_types = array_keys(WP_Block_Type_Registry::get_instance()->get_all_registered());
    }

    if (is_array($allowed_block_types)) {
        return array_values(array_diff($allowed_block_types, [$blockName]));
    }

    return $allowed_block_types;
}, 10, 2);
