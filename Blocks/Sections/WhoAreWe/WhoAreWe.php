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
            'screen' => ['page-nosotros.php'],
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
        $default_services = [
            [
                'name' => 'Crédito PYME',
                'description' => 'Descripción breve del servicio 1 que ofrecemos a nuestros clientes.',
                'url' => '#',
            ],
            [
                'name' => 'Crédito personal',
                'description' => 'Descripción breve del servicio 2 que ofrecemos a nuestros clientes.',
                'url' => '#',
            ],
            [
                'name' => 'Fideicomisos de Garantía',
                'description' => 'Descripción breve del servicio 3 que ofrecemos a nuestros clientes.',
                'url' => '#',
            ],
            [
                'name' => 'Servicio Escrow',
                'description' => 'Descripción breve del servicio 4 que ofrecemos a nuestros clientes.',
                'url' => '#',
            ],
        ];

        return [
            'heading'      => $this->getMeta($postId, 'who_heading') ?: __('¿Quiénes Somos?', 'taw-theme'),
            'content'      => $this->getMeta($postId, 'who_content') ?: __('<p>Somos una <strong>Sociedad Financiera de Objeto Múltiple</strong>, regulada y supervisada por la Comisión Nacional Bancaria y de Valores <strong>(CNBV)</strong>, la Comisión Nacional para la Defensa de los Usuarios de Servicios Financieros <strong>(CONDUSEF)</strong> y el Buró de Entidades Financieras. En <strong>CH Capital</strong> ofrecemos servicios que transforman las ideas de nuestros clientes en oportunidades de negocio. Somos más accesibles, más ágiles y más eficientes en la respuesta que damos a nuestros clientes, y creamos soluciones personalizadas, a la medida de las necesidades que se nos plantean.</p>', 'taw-theme'),
            'image_id'     => (int) $this->getMeta($postId, 'who_image'),
            'author_name'  => $this->getMeta($postId, 'who_author_name') ?: 'Alfredo Chumacero',
            'author_title' => $this->getMeta($postId, 'who_author_title') ?: __('Fundador', 'taw-theme'),
            'author_quote' => $this->getMeta($postId, 'who_author_quote') ?: __('Convertimos las ideas de nuestros clientes en oportunidades de negocio reales y sostenibles.', 'taw-theme'),
            'services'     => $default_services,
        ];
    }
}
