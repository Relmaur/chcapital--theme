<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\ContactForm;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;
use TAW\Core\OptionsPage\OptionsPage;

class ContactForm extends MetaBlock
{
    protected string $id = 'contact_form';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'      => 'taw_contact_form',
            'title'   => __('Contact Form Section', 'taw-theme'),
            'icon'    => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screens' => ['page-contacto.php'],
            'fields'  => [
                [
                    'id'    => 'contact_form_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '100',
                ],
                [
                    'id'    => 'contact_form_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 3,
                    'width' => '100',
                ],
                [
                    'id'          => 'contact_form_hours',
                    'label'       => __('Office Hours', 'taw-theme'),
                    'type'        => 'text',
                    'width'       => '100',
                    'placeholder' => 'Lun–Vie: 9:00 – 18:00',
                ],
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        $social_keys = ['facebook', 'instagram', 'twitter', 'linkedin', 'youtube'];
        $social      = [];
        foreach ($social_keys as $key) {
            $url = OptionsPage::get('social_' . $key);
            if (!empty($url)) {
                $social[$key] = $url;
            }
        }

        return [
            'heading'    => $this->getMeta($postId, 'contact_form_heading')    ?: __('Hablemos', 'taw-theme'),
            'subheading' => $this->getMeta($postId, 'contact_form_subheading') ?: __('Cuéntanos sobre tu empresa y un asesor te contactará a la brevedad para ayudarte a encontrar la solución financiera ideal.', 'taw-theme'),
            'hours'      => $this->getMeta($postId, 'contact_form_hours')      ?: __('Lun–Vie: 9:00 – 18:00', 'taw-theme'),
            'phone'      => OptionsPage::get('company_phone'),
            'email'      => OptionsPage::get('company_email'),
            'address'    => OptionsPage::get('company_address'),
            'social'     => $social,
        ];
    }
}
