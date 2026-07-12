<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\ContactCta;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Form\Form;
use TAW\Core\Metabox\Metabox;

class ContactCta extends MetaBlock
{
    protected string $id = 'contact_cta';

    public static function boot(): void
    {
        add_action('init', static function () {
            Form::register([
                'id'           => 'contact_inquiry',
                'submit_label' => __('Enviar mensaje', 'taw-theme'),
                'turnstile'    => true,
                'email'        => [
                    'to_self' => [
                        'subject'  => __('Nueva consulta desde el sitio web', 'taw-theme'),
                        'template' => 'contact-self',
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
                    ['id' => 'name',    'label' => __('Nombre', 'taw-theme'),             'type' => 'text',     'required' => true, 'width' => 50],
                    ['id' => 'phone',   'label' => __('Teléfono', 'taw-theme'),           'type' => 'tel',      'required' => true, 'width' => 50],
                    ['id' => 'email',   'label' => __('Correo electrónico', 'taw-theme'), 'type' => 'email',    'required' => true, 'width'],
                    ['id' => 'company', 'label' => __('Empresa', 'taw-theme'),            'type' => 'text',     'required' => false, 'width'],
                    ['id' => 'message', 'label' => __('Mensaje', 'taw-theme'),            'type' => 'textarea', 'required' => false, 'width'],
                ],
            ]);
        });
    }

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'      => 'taw_contact_cta',
            'title'   => __('Section - Contact CTA', 'taw-theme'),
            'icon' => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screens' => ['page-credito-pyme.php', 'page-arrendamiento-puro.php', 'page-fideicomisos.php', 'page-credito-de-nomina.php', 'page-escrow.php'],
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

    protected function getData(int|false $postId): array
    {
        return [
            'heading'    => $this->getMeta($postId, 'contact_cta_heading') ?: __('Queremos ser parte de tus proyectos', 'taw-theme'),
            'subheading' => $this->getMeta($postId, 'contact_cta_subheading') ?: __('Cuéntanos sobre tu empresa y te ayudaremos a encontrar el financiamiento ideal.', 'taw-theme'),
            'shortcode'  => $this->getMeta($postId, 'contact_cta_shortcode'),
        ];
    }
}
