<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\ContactForm;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Form\Form;
use TAW\Core\Metabox\Metabox;
use TAW\Core\OptionsPage\OptionsPage;

class ContactForm extends MetaBlock
{
    protected string $id = 'contact_form';

    public static function boot(): void
    {
        add_action('init', static function () {
            Form::register([
                'id'           => 'contact_page_form',
                'submit_label' => __('Enviar mensaje', 'taw-theme'),
                'email'        => [
                    'to_self' => [
                        'subject'  => __('Nueva consulta desde Contacto', 'taw-theme'),
                        'template' => 'contact-self',
                    ],
                ],
                'messages' => [
                    'success' => __('¡Gracias! Nos pondremos en contacto contigo pronto.', 'taw-theme'),
                ],
                'fields' => [
                    ['id' => 'name',    'label' => __('Nombre completo', 'taw-theme'),    'type' => 'text',     'required' => true,  'width' => '50'],
                    ['id' => 'company', 'label' => __('Empresa', 'taw-theme'),            'type' => 'text',     'required' => false, 'width' => '50'],
                    ['id' => 'phone',   'label' => __('Teléfono', 'taw-theme'),           'type' => 'tel',      'required' => true,  'width' => '50'],
                    ['id' => 'email',   'label' => __('Correo electrónico', 'taw-theme'), 'type' => 'email',    'required' => true,  'width' => '50'],
                    ['id' => 'message', 'label' => __('¿En qué podemos ayudarte?', 'taw-theme'), 'type' => 'textarea', 'required' => false, 'width' => '100'],
                ],
            ]);
        });
    }

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

    protected function getData(int|false $postId): array
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
