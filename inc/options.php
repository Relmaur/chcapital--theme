<?php

use TAW\Core\OptionsPage\OptionsPage;

new OptionsPage([
    'id'         => 'theme_settings',
    'title'      => __('Theme Settings', 'taw-theme'),
    'menu_title' => __('Theme Settings', 'taw-theme'),
    'icon'       => 'dashicons-screenoptions',
    'position'   => 2,
    'fields'     => [
        [
            'id' => 'general_contact',
            'label' => __('General', 'taw-theme'),
            'type' => 'group',
            'fields' => [
                ['id' => 'email', 'label' => __('Email', 'taw-theme'), 'type' => 'text', 'width' => '50'],
                ['id' => 'phone', 'label' => __('Phone', 'taw-theme'), 'type' => 'text', 'width' => '50'],
            ],
        ],
        [
            'id' => 'division_financiera',
            'label' => __('División Financiera', 'taw-theme'),
            'type' => 'group',
            'fields' => [
                ['id' => 'email', 'label' => __('Email', 'taw-theme'), 'type' => 'text', 'width' => '50'],
                ['id' => 'phone', 'label' => __('Phone', 'taw-theme'), 'type' => 'text', 'width' => '50'],
            ],
        ],
        [
            'id' => 'division_fiduciaria',
            'label' => __('División Fiduciaria', 'taw-theme'),
            'type' => 'group',
            'fields' => [
                ['id' => 'email', 'label' => __('Email', 'taw-theme'), 'type' => 'text', 'width' => '50'],
                ['id' => 'phone', 'label' => __('Phone', 'taw-theme'), 'type' => 'text', 'width' => '50'],
            ],
        ],
        [
            'id' => 'company_name',
            'label' => __('Company Name', 'taw-theme'),
            'type' => 'text',
            'width' => '100',
        ],
        [
            'id' => 'brand_primary_color',
            'label' => __('Brand Primary Color', 'taw-theme'),
            'type' => 'color',
            'width' => '33.33',
            'default' => '#004a98',
            'description' => __('Used as the accent color for generated reports (memo-report, ficha-tecnica).', 'taw-theme'),
        ],
        [
            'id' => 'company_address',
            'label' => __('Address', 'taw-theme'),
            'type' => 'wysiwyg',
            'width' => '100',
        ],
        [
            'id' => 'footer_text',
            'label' => __('Footer Copyright', 'taw-theme'),
            'type' => 'textarea'
        ],
        [
            'id' => 'social_facebook',
            'label' => __('Facebook URL', 'taw-theme'),
            'type' => 'url'
        ],
        [
            'id' => 'social_instagram',
            'label' => __('Instagram URL', 'taw-theme'),
            'type' => 'url'
        ],
        [
            'id' => 'social_twitter',
            'label' => __('X (Twitter) URL', 'taw-theme'),
            'type' => 'url'
        ],
        [
            'id' => 'social_linkedin',
            'label' => __('LinkedIn URL', 'taw-theme'),
            'type' => 'url'
        ],
        [
            'id' => 'social_youtube',
            'label' => __('YouTube URL', 'taw-theme'),
            'type' => 'url'
        ],
        [
            'id' => 'social_whatsapp',
            'label' => __('WhatsApp URL', 'taw-theme'),
            'type' => 'url',
            'default' => 'https://wa.me/5526726073',
        ],
        [
            'id' => 'footer_legal_une',
            'label' => __('UNE Link', 'taw-theme'),
            'type' => 'group',
            'fields' => [
                ['id' => 'label', 'label' => __('Label', 'taw-theme'), 'type' => 'text', 'width' => '50', 'default' => __('UNE Unidad Especializada de Atención de Clientes', 'taw-theme')],
                ['id' => 'url', 'label' => __('URL', 'taw-theme'), 'type' => 'url', 'width' => '50', 'default' => 'https://chcapital.mx/wp-content/uploads/2024/09/UNE-nuevo.pdf'],
            ],
        ],
        [
            'id' => 'footer_legal_privacy',
            'label' => __('Aviso de Privacidad Link', 'taw-theme'),
            'type' => 'group',
            'fields' => [
                ['id' => 'label', 'label' => __('Label', 'taw-theme'), 'type' => 'text', 'width' => '50', 'default' => __('Aviso de Privacidad', 'taw-theme')],
                ['id' => 'url', 'label' => __('URL', 'taw-theme'), 'type' => 'url', 'width' => '50', 'default' => 'https://chcapital.mx/wp-content/uploads/2026/09/CH-CAPITAL-Aviso-de-Privacidad-SEPT-2026.pdf'],
            ],
        ],
        [
            'id' => 'privacy_notice',
            'label' => __('Privacy Notice Version', 'taw-theme'),
            'type' => 'group',
            'fields' => [
                ['id' => 'version', 'label' => __('Version code', 'taw-theme'), 'type' => 'text', 'width' => '50', 'default' => 'AP-CHC-2026-01', 'description' => __('Bump this whenever a new Aviso de Privacidad is published. Snapshotted onto every consent record at submit time — past submissions keep the version that was live when they consented.', 'taw-theme')],
                ['id' => 'hash', 'label' => __('SHA-256 hash (optional)', 'taw-theme'), 'type' => 'text', 'width' => '50', 'description' => __('Optional fingerprint of the published PDF/HTML, for stronger evidence.', 'taw-theme')],
            ],
        ],
        [
            'id' => 'contact_form_privacy_tooltip',
            'label' => __('Contact Form — Privacy Consent Tooltip', 'taw-theme'),
            'type' => 'textarea',
            'rows' => 12,
            'width' => '100',
            'description' => __('Shown in the info popup next to the privacy consent checkbox on the Contact form. Plain text only — blank lines become paragraph breaks.', 'taw-theme'),
            'default' => __(
                "Chumacero Capital, S.A.P.I. de C.V., SOFOM, E.N.R. (\"CH CAPITAL\"), con domicilio en Risco 209, colonia Jardines del Pedregal, Alcaldía Álvaro Obregón, C.P. 01900, Ciudad de México, es responsable del tratamiento de sus datos personales.\n\nLos datos que proporcione serán utilizados para identificarle, atender y dar seguimiento a su solicitud, contactarle, evaluar y, en su caso, formalizar y administrar los productos o servicios que solicite, cumplir obligaciones legales y regulatorias, y proteger los derechos e intereses de CH CAPITAL y de las partes relacionadas con la operación. Cuando el formulario recabe datos financieros o patrimoniales, éstos serán tratados conforme al régimen de consentimiento aplicable.\n\nDe manera adicional y sólo cuando usted lo autorice, podremos utilizar sus datos de contacto para enviarle información comercial, contenidos, invitaciones a webinars o eventos y novedades de CH CAPITAL. Negarse a esta finalidad no afecta la atención de su solicitud.\n\nPuede limitar el uso o divulgación de sus datos escribiendo a datospersonales@chcapital.mx. Consulte el Aviso de Privacidad Integral en el enlace junto a este formulario.",
                'taw-theme'
            ),
        ],
        [
            'id' => 'css_studio_enabled',
            'label' => __('Enable CSS Studio', 'taw-theme'),
            'type' => 'checkbox'
        ],
    ],
    'tabs' => [
        [
            'id' => 'general',
            'label' => __('General', 'taw-theme'),
            'fields' => ['company_name', 'brand_primary_color', 'company_address', 'general_contact', 'division_financiera', 'division_fiduciaria']
        ],
        [
            'id' => 'footer',
            'label' => __('Footer', 'taw-theme'),
            'fields' => ['footer_text', 'footer_legal_une', 'footer_legal_privacy', 'privacy_notice', 'contact_form_privacy_tooltip']
        ],
        [
            'id' => 'social',
            'label' => __('Social', 'taw-theme'),
            'fields' => ['social_facebook', 'social_instagram', 'social_twitter', 'social_linkedin', 'social_youtube', 'social_whatsapp']
        ],
        [
            'id' => 'devtools',
            'label' => __('Developer Tools', 'taw-theme'),
            'fields' => ['css_studio_enabled']
        ],
    ],
]);
