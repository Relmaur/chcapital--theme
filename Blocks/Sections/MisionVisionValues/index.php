<?php

/**
 * MisionVisionValues Component Template
 *
 * @var string $mision_heading
 * @var string $mision_text
 * @var string $vision_heading
 * @var string $vision_text
 * @var array  $values  [ ['value_title' => '', 'value_text' => ''] ]
 */
?>
<section class="mvv ch-section">
    <div class="section-container--sm">

        <div class="mvv__top">

            <!-- Misión -->
            <div class="mvv__card mvv__card--mision">
                <div class="mvv__card-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5ZM18 1.5a.75.75 0 0 1 .728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 0 1 0 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 0 1-1.456 0l-.258-1.036a2.625 2.625 0 0 0-1.91-1.91l-1.036-.258a.75.75 0 0 1 0-1.456l1.036-.258a2.625 2.625 0 0 0 1.91-1.91l.258-1.036A.75.75 0 0 1 18 1.5Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="mvv__card-heading"><?php echo esc_html($mision_heading); ?></h2>
                <p class="mvv__card-text"><?php echo esc_html($mision_text); ?></p>
            </div>

            <!-- Visión -->
            <div class="mvv__card mvv__card--vision">
                <div class="mvv__card-icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                        <path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h2 class="mvv__card-heading"><?php echo esc_html($vision_heading); ?></h2>
                <p class="mvv__card-text"><?php echo esc_html($vision_text); ?></p>
            </div>

        </div>

        <?php if (!empty($values)) : ?>
            <div class="mvv__values">
                <h2 class="mvv__values-heading section-title"><?php _e('Nuestros Valores', 'taw-theme'); ?></h2>
                <div class="mvv__values-grid">
                    <?php foreach ($values as $i => $value) : ?>
                        <div class="mvv__value">
                            <span class="mvv__value-number" aria-hidden="true">
                                <?php echo str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT); ?>
                            </span>
                            <h3 class="mvv__value-title"><?php echo esc_html($value['value_title'] ?? ''); ?></h3>
                            <p class="mvv__value-text"><?php echo esc_html($value['value_text'] ?? ''); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>
