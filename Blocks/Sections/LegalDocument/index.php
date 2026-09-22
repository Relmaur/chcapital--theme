<?php

/**
 * LegalDocument Block Template
 *
 * Renders a long-form legal text body (privacy notice, terms, etc.) using
 * the same `.entry-content` typography already used for post/page bodies —
 * plain headings/paragraphs/lists, not the card-grid/step styling that
 * ContentBlock applies to its <ul>/<ol> content, which reads wrong for a
 * dense legal document.
 *
 * @var string $content HTML from wysiwyg
 */

if (empty($content)) return;
?>

<section class="legal-document ch-section">
    <div class="section-container--xs">
        <div class="entry-content legal-document__content">
            <?php echo wp_kses_post($content); ?>
        </div>
    </div>
</section>
