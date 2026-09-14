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
                'turnstile'    => true,
                'email'        => [
                    'to_self' => [
                        'subject'  => __('Nueva consulta desde Contacto', 'taw-theme'),
                        'template' => 'form-notification',
                    ],
                    'to_client' => [
                        'subject'  => __('Hemos recibido tu mensaje — CH Capital', 'taw-theme'),
                        'template' => 'form-thankyou',
                    ],
                ],
                'messages' => [
                    'success'          => __('¡Gracias! Nos pondremos en contacto contigo pronto.', 'taw-theme'),
                    'turnstile_failed' => __('No pudimos verificar que eres humano. Por favor, inténtalo de nuevo.', 'taw-theme'),
                    'required'         => __('Este campo es requerido.', 'taw-theme'),
                    'email'            => __('Correo electrónico no válido.', 'taw-theme'),
                    'min_length'       => __('%1$s debe tener al menos %2$d caracteres.', 'taw-theme'),
                    'max_length'       => __('%1$s no debe superar los %2$d caracteres.', 'taw-theme'),
                    'pattern'          => __('%s no tiene el formato correcto.', 'taw-theme'),
                    'min'              => __('%1$s debe ser al menos %2$s.', 'taw-theme'),
                    'max'              => __('%1$s no debe superar %2$s.', 'taw-theme'),
                ],
                'fields' => [
                    ['id' => 'name',    'label' => __('Nombre completo', 'taw-theme'),    'type' => 'text',     'required' => true,  'width' => '50'],
                    ['id' => 'company', 'label' => __('Empresa', 'taw-theme'),            'type' => 'text',     'required' => false, 'width' => '50'],
                    ['id' => 'phone',   'label' => __('Teléfono', 'taw-theme'),           'type' => 'tel',      'required' => true,  'width' => '50'],
                    ['id' => 'email',   'label' => __('Correo electrónico', 'taw-theme'), 'type' => 'email',    'required' => true,  'width' => '50'],
                    [
                        'id'       => 'interest',
                        'label'    => __('Interesado en:', 'taw-theme'),
                        'type'     => 'select',
                        'required' => true,
                        'width'    => '100',
                        'options'  => [
                            __('Fideicomiso', 'taw-theme')       => __('Fideicomiso', 'taw-theme'),
                            __('Escrow', 'taw-theme')             => __('Escrow', 'taw-theme'),
                            __('Crédito PYME', 'taw-theme')       => __('Crédito PYME', 'taw-theme'),
                            __('Crédito de Nómina', 'taw-theme')  => __('Crédito de Nómina', 'taw-theme'),
                        ],
                    ],
                    ['id' => 'message', 'label' => __('¿En qué podemos ayudarte?', 'taw-theme'), 'type' => 'textarea', 'required' => false, 'width' => '100'],
                    [
                        'id'               => 'privacy_consent',
                        'label'            => __('He leído el Aviso de Privacidad de CH CAPITAL y consiento el tratamiento de mis datos para atender y dar seguimiento a mi solicitud.', 'taw-theme'),
                        'type'             => 'checkbox',
                        'required'         => true,
                        'required_message' => __('Debes aceptar el Aviso de Privacidad para continuar.', 'taw-theme'),
                        'width'            => '100',
                    ],
                    [
                        'id'       => 'marketing_consent',
                        'label'    => __('Deseo recibir información sobre servicios, contenidos, webinars, eventos y novedades de CH CAPITAL. (Opcional)', 'taw-theme'),
                        'type'     => 'checkbox',
                        'required' => false,
                        'width'    => '100',
                    ],
                ],
                'on_submit' => static function (array $data, int|false $postId = false): void {
                    chcapital_record_consent_evidence($data, $postId);
                },
            ]);
        });
    }

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'      => 'taw_contact_form',
            'title'   => __('Section - Contact Form', 'taw-theme'),
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
            'divisions'  => [
                [
                    'label' => __('División Financiera', 'taw-theme'),
                    'email' => OptionsPage::get('division_financiera_email'),
                    'phone' => OptionsPage::get('division_financiera_phone'),
                ],
                [
                    'label' => __('División Fiduciaria', 'taw-theme'),
                    'email' => OptionsPage::get('division_fiduciaria_email'),
                    'phone' => OptionsPage::get('division_fiduciaria_phone'),
                ],
            ],
            'address'     => OptionsPage::get('company_address'),
            'social'      => $social,
            'privacy_url' => OptionsPage::get('footer_legal_privacy_url') ?: 'https://chcapital.mx/wp-content/uploads/2024/03/aviso.pdf',
        ];
    }
}
