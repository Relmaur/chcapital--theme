<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\ContactCta;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class ContactCta extends MetaBlock
{
    protected string $id = 'contact_cta';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'      => 'taw_contact_cta',
            'title'   => __('Contact CTA Section', 'taw-theme'),
            'screens' => ['page-credito-pyme.php', 'page-arrendamiento-puro.php', 'page-fideicomisos.php'],
            'fields'  => [
                [
                    'id'    => 'contact_cta_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '100',
                ],
                [
                    'id'    => 'contact_cta_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 3,
                    'width' => '100',
                ],
                [
                    'id'          => 'contact_cta_shortcode',
                    'label'       => __('Form Shortcode (optional)', 'taw-theme'),
                    'type'        => 'text',
                    'description' => __('Paste a Forminator shortcode here, e.g. [forminator_form id="123"]. Leave empty to use the built-in fallback form.', 'taw-theme'),
                    'width'       => '100',
                ],
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        return [
            'heading'    => $this->getMeta($postId, 'contact_cta_heading') ?: __('Queremos ser parte de tus proyectos', 'taw-theme'),
            'subheading' => $this->getMeta($postId, 'contact_cta_subheading') ?: __('Cuéntanos sobre tu empresa y te ayudaremos a encontrar el financiamiento ideal.', 'taw-theme'),
            'shortcode'  => $this->getMeta($postId, 'contact_cta_shortcode'),
        ];
    }
}
