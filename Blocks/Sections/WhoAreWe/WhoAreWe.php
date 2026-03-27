<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\WhoAreWe;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class WhoAreWe extends MetaBlock
{
    protected string $id = 'who_are_we';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'     => 'taw_who_are_we',
            'title'  => __('Who Are We Section', 'taw-theme'),
            'screen' => 'page',
            'show_on' => static function (\WP_Post $post): bool {
                return get_page_template_slug($post->ID) === 'page-about-us.php'
                    || in_array($post->post_name, ['nosotros', 'about-us'], true);
            },
            'fields' => [
                [
                    'id'    => 'who_heading',
                    'label' => __('Heading', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '100',
                ],
                [
                    'id'    => 'who_content',
                    'label' => __('Content', 'taw-theme'),
                    'type'  => 'wysiwyg',
                    'width' => '100',
                ],
                [
                    'id'    => 'who_image',
                    'label' => __('Image', 'taw-theme'),
                    'type'  => 'image',
                    'width' => '50',
                ],
                [
                    'id'    => 'who_author_name',
                    'label' => __('Author Name', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '50',
                ],
                [
                    'id'    => 'who_author_title',
                    'label' => __('Author Title', 'taw-theme'),
                    'type'  => 'text',
                    'width' => '50',
                ],
                [
                    'id'    => 'who_author_quote',
                    'label' => __('Author Quote', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 3,
                    'width' => '100',
                ],
            ],
        ]);
    }

    protected function getData(int $postId): array
    {
        return [
            'heading'      => $this->getMeta($postId, 'who_heading') ?: __('¿Quiénes Somos?', 'taw-theme'),
            'content'      => $this->getMeta($postId, 'who_content') ?: __('<p>En CH Capital somos una institución financiera mexicana con más de dos décadas de experiencia. Nos especializamos en brindar soluciones de crédito, arrendamiento y servicios fiduciarios a empresas y personas que buscan hacer realidad sus proyectos con respaldo sólido y asesoría cercana.</p><p>Nuestra filosofía se basa en tres pilares: transparencia, confianza y resultados. Cada producto financiero que ofrecemos está diseñado con el cliente en el centro, garantizando claridad en cada etapa del proceso.</p>', 'taw-theme'),
            'image_id'     => (int) $this->getMeta($postId, 'who_image'),
            'author_name'  => $this->getMeta($postId, 'who_author_name') ?: 'Alfredo Chumacero',
            'author_title' => $this->getMeta($postId, 'who_author_title') ?: __('Fundador', 'taw-theme'),
            'author_quote' => $this->getMeta($postId, 'who_author_quote') ?: __('Convertimos las ideas de nuestros clientes en oportunidades de negocio reales y sostenibles.', 'taw-theme'),
        ];
    }
}
