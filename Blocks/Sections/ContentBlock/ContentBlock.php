<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\ContentBlock;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class ContentBlock extends MetaBlock
{
    protected string $id = 'content_block';

    /**
     * All registered variations. Each string becomes a separate block ID:
     * content_block--benefits, content_block--characteristics, etc.
     *
     * Add a new entry here whenever a page needs a new ContentBlock slot.
     *
     * @return string[]
     */
    public static function variations(): array
    {
        return [
            'benefits',
            'characteristics',
            'steps',
            'requirements',
            'cat_info',
            'company_benefits',
            'employee_benefits',
            'escrow_intro',
            'escrow_benefits',
            'escrow_history',
            'escrow_realestate',
            'escrow_contract',
        ];
    }

    /**
     * Per-variation configuration.
     *
     * Keys:
     *   label          — admin metabox title
     *   screens        — page templates that show this metabox
     *   bg             — optional section CSS modifier class
     *   layout         — default layout: 'single' | 'two_columns'
     *   image_position — default image side: 'right' | 'left'
     *   defaults       — fallback content shown before the editor saves
     */
    private static function varConfig(string $variation): array
    {
        return match ($variation) {
            'benefits' => [
                'label'          => 'Section — Lo que ofrecemos',
                'screens'        => ['page-credito-pyme.php', 'page-arrendamiento-puro.php'],
                'bg'             => '',
                'layout'         => 'single',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => 'Lo que ofrecemos',
                    'subheading' => 'Diseñamos soluciones de financiamiento a la medida de tu negocio.',
                    'content'    => '<ul>
<li><strong>Mayor productividad</strong> — financiamiento que impulsa el crecimiento de tu empresa.</li>
<li><strong>Agilidad en los procesos</strong> — respuesta rápida y sin trámites innecesarios.</li>
<li><strong>Transparencia</strong> — condiciones claras en cada etapa del crédito.</li>
<li><strong>Asesoría personalizada</strong> — un asesor dedicado a tus necesidades.</li>
<li><strong>Tasas competitivas</strong> — financiamiento accesible para empresas de todos los tamaños.</li>
</ul>',
                ],
            ],

            'characteristics' => [
                'label'          => 'Section — Características del Crédito',
                'screens'        => ['page-credito-pyme.php', 'page-arrendamiento-puro.php', 'page-credito-de-nomina.php'],
                'bg'             => 'bg-lightgray',
                'layout'         => 'single',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => 'Características del Crédito',
                    'subheading' => 'Condiciones diseñadas para adaptarse a las necesidades de tu empresa.',
                    'content'    => '<ul>
<li><strong>Monto mínimo:</strong> desde $250,000 MXN</li>
<li><strong>Comisión:</strong> 3 - 5%</li>
<li><strong>Plazo:</strong> 6 a 48 meses</li>
<li><strong>Tasa de interés:</strong> fija anual</li>
<li><strong>Garantía:</strong> hipotecaria o en fideicomiso</li>
<li><strong>Obligado solidario:</strong> opcional</li>
<li><strong>Prepago:</strong> sin penalización por pago anticipado</li>
</ul>',
                ],
            ],

            'steps' => [
                'label'          => 'Section — ¿Cómo solicitarlo?',
                'screens'        => ['page-credito-pyme.php', 'page-arrendamiento-puro.php', 'page-credito-de-nomina.php'],
                'bg'             => '',
                'layout'         => 'single',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => '¿Cómo solicitarlo?',
                    'subheading' => 'Un proceso sencillo y transparente, diseñado para que obtengas tu financiamiento a tiempo.',
                    'content'    => '<ol>
<li><strong>Solicitud</strong> — Completa el formulario de contacto o llámanos directamente.</li>
<li><strong>Análisis</strong> — Nuestro equipo evalúa tu perfil crediticio y las condiciones del crédito.</li>
<li><strong>Propuesta</strong> — Te presentamos una oferta personalizada con los términos y condiciones.</li>
<li><strong>Formalización</strong> — Firma del contrato y constitución de la garantía.</li>
<li><strong>Dispersión</strong> — Depósito del monto aprobado en tu cuenta.</li>
</ol>',
                ],
            ],

            'requirements' => [
                'label'          => 'Section — Requisitos para convenio',
                'screens'        => ['page-credito-de-nomina.php'],
                'bg'             => 'bg-lightgray',
                'layout'         => 'single',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => '¿Qué necesita tu empresa para firmar un convenio con nosotros?',
                    'subheading' => 'Para formalizar un convenio con CH Capital, tu empresa debe cumplir con la siguiente documentación:',
                    'content'    => '<ul>
<li>Acta constitutiva</li>
<li>Poder del representante legal</li>
<li>Identificación del representante legal</li>
<li>Comprobante de domicilio vigente</li>
<li>Constancia de situación fiscal</li>
<li>Convenio firmado</li>
</ul>',
                ],
            ],

            'cat_info' => [
                'label'          => 'Section — ¿Qué es el CAT?',
                'screens'        => ['page-credito-de-nomina.php'],
                'bg'             => '',
                'layout'         => 'single',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => '¿Qué es el CAT?',
                    'subheading' => '',
                    'content'    => '<p>Es una métrica financiera establecida por Banco de México que permite a los consumidores comparar el costo final de cualquier crédito. El CAT considera las tasas de interés y cualquier comisión cobrada por el otorgante.</p>',
                ],
            ],

            'company_benefits' => [
                'label'          => 'Section — ¿Qué obtienes como empresa?',
                'screens'        => ['page-credito-de-nomina.php'],
                'bg'             => '',
                'layout'         => 'two_columns',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => '¿Qué obtienes como empresa?',
                    'subheading' => '',
                    'content'    => '<ul>
<li><strong>Fortaleces tu paquete de beneficios</strong> sin gastar.</li>
<li><strong>Impulsas un ambiente sano y comprometido.</strong></li>
<li><strong>Evitas prestar dinero</strong> de forma interna.</li>
<li><strong>Mejoras la retención y atracción de talento.</strong></li>
</ul>',
                ],
            ],

            'employee_benefits' => [
                'label'          => 'Section — Beneficios para el colaborador',
                'screens'        => ['page-credito-de-nomina.php'],
                'bg'             => 'bg-lightgray',
                'layout'         => 'two_columns',
                'image_position' => 'left',
                'defaults'       => [
                    'heading'    => 'Beneficios para el colaborador con su crédito nómina',
                    'subheading' => '',
                    'content'    => '<ul>
<li>El historial del Buró <strong>NO</strong> es determinante para otorgar el préstamo</li>
<li>Sin penalización por pago anticipado</li>
<li>Pagos fijos mediante descuentos vía nómina</li>
<li>Liquidez inmediata para emergencias</li>
<li>Formación de historial crediticio</li>
<li>Trámite rápido y sencillo</li>
<li>Sin aval ni garantía prendaria</li>
</ul>',
                ],
            ],

            'escrow_intro' => [
                'label'          => 'Section — ¿Qué es el Escrow?',
                'screens'        => ['page-escrow.php'],
                'bg'             => '',
                'layout'         => 'two_columns',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => '¿Qué es el Escrow?',
                    'subheading' => '',
                    'content'    => '<p>El término <em>escrow</em> se traduce como "depósito, garantía, fideicomiso o fianza". En CH Capital, representa <strong>una estructura de control que transforma acuerdos en resultados verificables</strong>: los recursos permanecen en custodia de un tercero imparcial y se liberan únicamente al cumplirse las condiciones pactadas.</p>',
                ],
            ],

            'escrow_benefits' => [
                'label'          => 'Section — Beneficios del Escrow',
                'screens'        => ['page-escrow.php'],
                'bg'             => '',
                'layout'         => 'single',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => 'Beneficios clave del Escrow',
                    'subheading' => 'Una estructura pensada para proteger a todas las partes involucradas.',
                    'content'    => '<ul>
<li><strong>Seguridad financiera</strong> — los recursos permanecen protegidos hasta el cumplimiento de las condiciones.</li>
<li><strong>Control operativo y trazabilidad</strong> — cada movimiento queda documentado y auditado.</li>
<li><strong>Certeza jurídica</strong> — respaldo contractual en cada etapa de la operación.</li>
<li><strong>Imparcialidad</strong> — un tercero neutral custodia los fondos sin favorecer a ninguna parte.</li>
<li><strong>Prevención de conflictos</strong> — elimina la incertidumbre y reduce el riesgo de incumplimiento.</li>
</ul>',
                ],
            ],

            'escrow_history' => [
                'label'          => 'Section — Origen del Escrow',
                'screens'        => ['page-escrow.php'],
                'bg'             => '',
                'layout'         => 'single',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => 'Origen de la figura',
                    'subheading' => '',
                    'content'    => '<p>La figura del Escrow tiene sus raíces en el comercio romano, donde los <em>argentarii</em> actuaban como banqueros neutrales que custodiaban bienes o dinero durante transacciones complejas. En la Edad Media, el derecho anglosajón consolidó el principio de custodia neutral en operaciones inmobiliarias, estableciendo la base del Escrow moderno: un tercero imparcial que garantiza el cumplimiento de las condiciones pactadas antes de liberar los recursos.</p>',
                ],
            ],

            'escrow_realestate' => [
                'label'          => 'Section — Escrow en operaciones inmobiliarias',
                'screens'        => ['page-escrow.php'],
                'bg'             => 'bg-lightgray',
                'layout'         => 'two_columns',
                'image_position' => 'left',
                'defaults'       => [
                    'heading'    => 'El Contrato Escrow en operaciones inmobiliarias',
                    'subheading' => 'Certeza para compradores, vendedores y brokers',
                    'content'    => '<p>El Escrow resuelve la incertidumbre entre las partes vendedora y compradora: los fondos quedan protegidos hasta que se cumplan los plazos y condiciones pactadas, brindando certeza sobre el momento de pago, la firma de la escritura y el pago de comisiones a los intermediarios.</p>',
                ],
            ],

            'escrow_contract' => [
                'label'          => 'Section — Definición del Contrato Escrow',
                'screens'        => ['page-escrow.php'],
                'bg'             => 'bg-lightgray',
                'layout'         => 'single',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => '¿Qué es el Contrato Escrow?',
                    'subheading' => '',
                    'content'    => '<p>El Contrato Escrow es un servicio de intermediación fiduciaria por el cual se mantienen en custodia los recursos vinculados a una operación de compraventa o renta de inmuebles. Los fondos se liberan exclusivamente al verificarse el cumplimiento de las condiciones establecidas, con supervisión de la CNBV y la CONDUSEF.</p>',
                ],
            ],

            // Fallback for future variations registered before their config is added
            default => [
                'label'          => 'Content Section',
                'screens'        => [],
                'bg'             => '',
                'layout'         => 'single',
                'image_position' => 'right',
                'defaults'       => ['heading' => '', 'subheading' => '', 'content' => ''],
            ],
        };
    }

    protected function registerMetaboxes(): void
    {
        $v = $this->variation;
        $c = self::varConfig($v);

        new Metabox([
            'id'      => 'taw_content_block_' . $v,
            'title'   => __($c['label'], 'taw-theme'),
            'icon' => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screens' => $c['screens'],
            'fields'  => [
                [
                    'id'    => $v . '_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '100',
                ],
                [
                    'id'    => $v . '_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 3,
                    'width' => '100',
                ],
                [
                    'id'    => $v . '_content',
                    'label' => __('Content', 'taw-theme'),
                    'type'  => 'wysiwyg',
                    'width' => '100',
                ],
                [
                    'id'      => $v . '_layout',
                    'label'   => __('Layout', 'taw-theme'),
                    'type'    => 'select',
                    'options' => [
                        'single'      => __('Single column', 'taw-theme'),
                        'two_columns' => __('Two columns (with image)', 'taw-theme'),
                    ],
                    'width' => '100',
                ],
                [
                    'id'         => $v . '_image',
                    'label'      => __('Image', 'taw-theme'),
                    'type'       => 'image',
                    'width'      => '50',
                    'conditions' => [
                        ['field' => $v . '_layout', 'operator' => '==', 'value' => 'two_columns'],
                    ],
                ],
                [
                    'id'         => $v . '_image_position',
                    'label'      => __('Image Position', 'taw-theme'),
                    'type'       => 'select',
                    'options'    => [
                        'right' => __('Right', 'taw-theme'),
                        'left'  => __('Left', 'taw-theme'),
                    ],
                    'width'      => '50',
                    'conditions' => [
                        ['field' => $v . '_layout', 'operator' => '==', 'value' => 'two_columns'],
                    ],
                ],
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        $v = $this->variation;
        $c = self::varConfig($v);
        $d = $c['defaults'];

        return [
            'heading'        => $this->getMeta($postId, $v . '_heading')        ?: $d['heading'],
            'subheading'     => $this->getMeta($postId, $v . '_subheading')     ?: $d['subheading'],
            'content'        => $this->getMeta($postId, $v . '_content')        ?: $d['content'],
            'layout'         => $this->getMeta($postId, $v . '_layout')         ?: $c['layout'],
            'image_id'       => (int) $this->getMeta($postId, $v . '_image'),
            'image_position' => $this->getMeta($postId, $v . '_image_position') ?: $c['image_position'],
            'bg'             => $c['bg'],
        ];
    }
}
