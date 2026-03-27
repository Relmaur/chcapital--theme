<?php

/**
 * FAQs Block Template
 *
 * @var string $section_id
 * @var string $heading
 * @var string $subheading
 * @var array  $items
 */

if (empty($items)) return;
?>

<section <?php echo $section_id ? 'id="' . esc_attr($section_id) . '"' : ''; ?> class="ch-section faqs bg-lightgray">
    <div class="section-container--sm mx-auto px-4">

        <?php if ($heading): ?>
            <h2 class="section-title">
                <?php echo esc_html($heading); ?>
            </h2>
        <?php endif; ?>

        <?php if ($subheading): ?>
            <p class="section-subtitle">
                <?php echo esc_html($subheading); ?>
            </p>
        <?php endif; ?>

        <div class="faqs__list" x-data="{ active: null }">
            <?php foreach ($items as $index => $item): ?>
                <?php if (empty($item['question'])) continue; ?>
                <div
                    class="faqs__item hover:bg-gray-100 px-4 transition"
                    x-data="{ id: <?php echo $index; ?> }"
                >
                    <button
                        class="faqs__trigger"
                        @click="active === id ? active = null : active = id"
                        :aria-expanded="active === id"
                        type="button"
                    >
                        <span><?php echo esc_html($item['question']); ?></span>
                        <svg
                            class="faqs__icon"
                            :class="{ 'rotate-180': active === id }"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>

                    <div
                        class="faqs__body"
                        x-show="active === id"
                        x-collapse
                    >
                        <p class="faqs__answer">
                            <?php echo nl2br(esc_html($item['answer'])); ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
