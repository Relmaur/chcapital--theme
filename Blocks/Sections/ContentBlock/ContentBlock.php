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
        ];
    }

    /**
     * Per-variation configuration: admin label, which page templates show
     * this metabox, background modifier class, and default content.
     */
    private static function varConfig(string $variation): array
    {
        return match ($variation) {
            'benefits' => [
                'label'   => 'Section — Lo que ofrecemos',
                'screens' => ['page-credito-pyme.php'],
                'bg'      => '',
                'defaults' => [
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
                'label'   => 'Section — Características del Crédito',
                'screens' => ['page-credito-pyme.php'],
                'bg'      => 'bg-lightgray',
                'defaults' => [
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
                'label'   => 'Section — ¿Cómo solicitarlo?',
                'screens' => ['page-credito-pyme.php'],
                'bg'      => '',
                'defaults' => [
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

            // Fallback for future variations registered before their config is added
            default => [
                'label'   => 'Content Section',
                'screens' => [],
                'bg'      => '',
                'defaults' => ['heading' => '', 'subheading' => '', 'content' => ''],
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
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        $v = $this->variation;
        $c = self::varConfig($v);
        $d = $c['defaults'];

        return [
            'heading'    => $this->getMeta($postId, $v . '_heading')    ?: $d['heading'],
            'subheading' => $this->getMeta($postId, $v . '_subheading') ?: $d['subheading'],
            'content'    => $this->getMeta($postId, $v . '_content')    ?: $d['content'],
            'bg'         => $c['bg'],
        ];
    }
}
