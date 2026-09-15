<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\ContentBlock;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;
use TAW\Core\OptionsPage\OptionsPage;

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
            'characteristics_pyme',
            'steps',
            'steps_pyme',
            'requirements',
            'cat_info',
            'company_benefits',
            'employee_benefits',
            'escrow_intro',
            'escrow_benefits',
            'escrow_history',
            'escrow_contract',
            'regulacion_cnbv',
            'regulacion_condusef',
            'regulacion_pasos',
            'buro_entidades',
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
        $uneUrl = OptionsPage::get('footer_legal_une_url') ?: 'https://chcapital.mx/wp-content/uploads/2024/09/UNE-nuevo.pdf';

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
                                    <li><strong>Alta productividad</strong> — Podemos diseñar un plan de pagos que se ajuste a tus posibilidades, con plazos cómodos y tasas competitivas que no comprometan la estabilidad financiera de tu negocio.</li>
                                    <li><strong>Agilidad</strong> — Trámites sencillos y rápidos en el proceso de aprobación de tu crédito.</li>
                                    <li><strong>Sin letras chiquitas.</strong> — Condiciones transparentes y claras, sin costos ocultos ni sorpresas desagradables.</li>
                                    <li><strong>Asesoramiento personalizado.</strong> — Para CH Capital, el cliente es la figura central. Si tienes preguntas o requieres información adicional, acércate a nosotros. Nuestros expertos financieros están listos para que puedas tomar decisiones informadas y estratégicas.</li>
                                    <li><strong>Tasas competitivas.</strong> — Cada punto porcentual cuenta por eso nuestras tasas garantizan un financiamiento adecuado que no comprometa la rentabilidad de tu empresa.</li>
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
                    'subheading' => 'Una vez firmado el convenio con CH Capital, tus colaboradores tendrán acceso al siguiente <strong>plan de beneficios</strong>:',
                    'content'    => '<ul>
                                    <li><strong>Montos</strong> De 1 quincena hasta 3 meses.</li>
                                    <li><strong>Plazos de pago</strong> De 6 meses hasta 18 meses.</li>
                                    <li><strong>Aprobación desde 24 horas</strong> (con expediente completo)</li>
                                    <li><strong>Comisión por apertura</strong> Hasta 4%</li>
                                    <li><strong>Tasa</strong>Del 36% anual.</li>
                                    <li><strong>Buró de Crédito</strong>No determinante.</li>
                                    <li>Descuentos via nómina</li>
                                    <li>Atención personalizada</li>
                                    </ul>',
                ],
            ],

            'characteristics_pyme' => [
                'label'          => 'Section — Características del Crédito',
                'screens'        => ['page-credito-pyme.php', 'page-arrendamiento-puro.php', 'page-credito-de-nomina.php'],
                'bg'             => 'bg-lightgray',
                'layout'         => 'single',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => 'Características del Crédito',
                    // 'subheading' => 'Una vez firmado el convenio con CH Capital, tus colaboradores tendrán acceso al siguiente <strong>plan de beneficios</strong>:',
                    'content'    => '<ul>
                                    <li><strong>Montos.</strong> De 1 millón hasta 5 millones.</li>
                                    <li><strong>Comisión por apertura.</strong> 4%</li>
                                    <li><strong>Plazo.</strong> Hasta 48 meses.</li>
                                    <li><strong>Tasa.</strong> Del 28 al 36%</li>
                                    <li><strong>Garantía.</strong> Hipotecaria mínimo 2 a 1 por medio de un fideicomiso, excepto terrenos.</li>
                                    <li><strong>Obligado Solidario.</strong> Puede aplicar.</li>
                                    <li><strong>Antigüedad empresarial.</strong> Mínimo 3 años.</li>
                                    <li><strong>Sin penalización.</strong> Por liquidación anticipada del crédito.</li>
                                    <li><strong>Buró de Crédito.</strong> No determinante.</li>
                                    </ul>',
                ],
            ],

            'steps' => [
                'label'          => 'Section — ¿Cómo obtengo un crédito de nómina?',
                'screens'        => ['page-credito-pyme.php', 'page-arrendamiento-puro.php', 'page-credito-de-nomina.php'],
                'bg'             => '',
                'layout'         => 'single',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => '¿Cómo obtengo un crédito de nómina?',
                    'subheading' => 'Si trabajas en una empresa con convenio con CH Capital, ya puedes acceder a un crédito de nómina mediante un proceso simple, transparente y diseñado para ayudarte a obtener financiamiento de forma rápida y segura.',
                    'content'    => '<ol>
                                    <li><span><strong>Solicitud</strong>— Completa el formulario de contacto o llámanos directamente.</span></li>
                                    <li><span><strong>Análisis</strong>— Evaluamos tu solicitud y, si cumples con los requisitos, tendrás una respuesta en 24 horas.</li>
                                    <li><span><strong>Propuesta</strong>— Si tu crédito ha sido aprobado, te entregaremos la documentación necesaria para continuar con el proceso.</li>
                                    <li><span><strong>Formalización</strong>— Firma del contrato y constitución de la garantía.</span></li>
                                    <li><span><strong>Dispersión</strong>— Depósito del monto aprobado en tu cuenta.</span></li>
                                    </ol>',
                ],
            ],

            'steps_pyme' => [
                'label'          => 'Section — Pasos',
                'screens'        => ['page-credito-pyme.php', 'page-arrendamiento-puro.php', 'page-credito-de-nomina.php'],
                'bg'             => '',
                'layout'         => 'single',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => '¿Cómo solicitarlo?',
                    'subheading' => 'Un proceso sencillo y transparente, diseñado para que obtengas tu financiamiento a tiempo.',
                    'content'    => '<ol>
                                    <li>Solicita tu crédito a través de un asesor.</li>
                                    <li>Si cumples con los requisitos, envía la documentación requerida.</li>
                                    <li>Evaluaremos tu solicitud y tendrás una respuesta en 48 horas.</li>
                                    <li>Una vez aprobado el crédito, firma tu contrato.</li>
                                    <li>Recibe tu crédito. Disfruta de los beneficios.</li>
                                    </ol>',
                    'content_disclaimer' => '<sup>*</sup> Sujeto a aprobación de crédito.'
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
                    'subheading' => 'Para <strong>formalizar un convenio con CH Capital</strong>, tu empresa debe cumplir con la <strong>siguiente documentación</strong>:',
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
                    'subheading' => 'Con nuestro Crédito de Nómina CH, tu empresa puede ofrecer un respaldo seguro y accesible, sin asumir riesgos ni costos.',
                    'content'    => '<ul>
                                    <li>Fortaleces tu paquete de beneficios sin gastar.</li>
                                    <li>Impulsas un ambiente sano y comprometido.</li>
                                    <li>Evitas prestar dinero de forma interna.</li>
                                    <li>Mejoras la retención y atracción de talento.</li>
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
                                    <li>El historial del Buró <strong>NO es determinante</strong> para otorgar el préstamo</li>
                                    <li><strong>Sin penalización</strong> por pago anticipado</li>
                                    <li>Pagos fijos mediante <strong>descuentos vía nómina</strong></li>
                                    <li><strong>Liquidez inmediata</strong> para emergencias</li>
                                    <li>Formación de <strong>historial crediticio</strong></li>
                                    <li><strong>Trámite rápido</strong> y sencillo</li>
                                    <li><strong>Sin aval</strong> ni garantía prendaria</li>
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
                    'heading'    => 'Escrow: Certeza en cada operación, confianza en cada decisión.',
                    'subheading' => '',
                    'content'    => '
                        <p>En CH CAPITAL, el Escrow no es sólo un servicio: es una estructura de control que transforma acuerdos en resultados verificables.<br/><br/>
                        Protege tus recursos y <strong>asegura el cumplimiento de acuerdos</strong> mediante un mecanismo imparcial que sólo libera el dinero cuando las condiciones pactadas se han cumplido.  
                        Un <strong>Escrow</strong> es una solución que permite realizar operaciones con mayor seguridad, especialmente cuando intervienen montos relevantes o partes que requieren certeza en el cumplimiento.<br/><br/>
                        Su funcionamiento es simple y sólido: los recursos asociados a la operación quedan bajo custodia de un tercero imparcial -como CH CAPITAL- quien los administra y los libera únicamente cuando se cumplen las condiciones previamente establecidas en el contrato suscrito por las partes.<br/><br/> 
                        El resultado es claro. Los recursos nunca quedan en manos de las partes, sino bajo control de un tercero imparcial que actúa conforme a reglas definidas, eliminando incertidumbre y reduciendo riesgos.</p>
                    ',
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

            'regulacion_cnbv' => [
                'label'          => 'Section — Regulación CNBV',
                'screens'        => ['page-quien-regula-y-supervisa-a-las-instituciones-financieras.php'],
                'bg'             => '',
                'layout'         => 'single',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => 'Comisión Nacional Bancaria y de Valores (CNBV)',
                    'subheading' => '',
                    'content'    => '<p>La Comisión Nacional Bancaria y de Valores (CNBV) es la entidad pública responsable de supervisar y regular a las instituciones que conforman el sistema financiero mexicano. Su objeto es procurar su correcto funcionamiento y su estabilidad, al tiempo que mantiene y fomenta un sano y equilibrado desarrollo de las actividades financieras que se llevan a cabo en el país.<br/><br/>
                        La CNBV es un órgano desconcentrado de la Secretaría de Hacienda y Crédito Público (SHCP).<br/><br/>
                        La CNBV tiene autonomía técnica y de gestión, además de facultades para sancionar a las instituciones financieras que incurren en faltas a la legislación de la materia, con lo que garantiza la seguridad de los usuarios del sistema financiero mexicano. También está facultada legalmente para establecer programas preventivos orientados a contrarrestar eventuales irregularidades en el sistema, además de emitir la regulación necesaria que permita a las instituciones financieras preservar su liquidez y solvencia.<br/><br/>
                        La CNBV se rige por la ley de su creación y es responsable de la aplicación de otro conjunto de leyes que rigen a las instituciones financieras, entre ellas, la Ley General de Organizaciones y Actividades Auxiliares del Crédito, la Ley General de Títulos y Operaciones de Crédito y la Ley de Instituciones de Crédito.<br/><br/>
                        Cada tres años las instituciones financieras deben obtener un Dictamen Técnico de viabilidad emitido por la CNBV para continuar prestando el servicio fiduciario a los usuarios.<br/><br/>
                        El Dictamen Técnico de CH Capital tiene el número de folio 0695086-2021-101269-NDT, de fecha 1º de diciembre de 2021.</p>',
                ],
            ],

            'regulacion_condusef' => [
                'label'          => 'Section — Regulación CONDUSEF',
                'screens'        => ['page-quien-regula-y-supervisa-a-las-instituciones-financieras.php'],
                'bg'             => 'bg-lightgray',
                'layout'         => 'single',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => 'Comisión Nacional para la Protección y Defensa de los Usuarios de Servicios Financieros (CONDUSEF)',
                    'subheading' => '',
                    'content'    => '<p>La Comisión Nacional para la Protección y Defensa de los Usuarios de Servicios Financieros (CONDUSEF), por su parte, es la entidad pública responsable de asesorar y defender los derechos de las personas que hacen uso de los servicios financieros en México.<br/><br/>
                        La CONDUSEF ofrece a los usuarios una serie de herramientas digitales con las cuales pueden informarse acerca de la legitimidad de las instituciones financieras autorizadas para prestar estos servicios en el país, si se encuentran vigentes, si han sido sancionadas, si cumplen con la legislación que les aplica.<br/><br/>
                        Entre otras herramientas de información se encuentra el Sistema de Registro de Prestadores de Servicios Financieros (SIPRES), en el que están inscritas todas las entidades financieras legalmente autorizadas en México para este propósito, además de informar sobre su situación actual, sea que se encuentren activas y en operación o que ya no operan.</p>',
                ],
            ],

            'regulacion_pasos' => [
                'label'          => 'Section — Pasos para consultar CONDUSEF',
                'screens'        => ['page-quien-regula-y-supervisa-a-las-instituciones-financieras.php'],
                'bg'             => '',
                'layout'         => 'single',
                'image_position' => 'right',
                'defaults'       => [
                    'heading'    => '',
                    'subheading' => '',
                    'content'    => '<ol>
                                    <li>Paso 1</li>
                                    <li>Paso 2</li>
                                    <li>Paso 3</li>
                                    <li>Paso 4</li>
                                    </ol>',
                    'content_disclaimer' => 'Capturas de pantalla del sitio de CONDUSEF pendientes de volver a subir tras la migración — agrégalas en el campo de imagen de cada paso cuando estén disponibles.',
                ],
            ],

            'buro_entidades' => [
                'label'          => 'Section — Buró de Entidades Financieras',
                'screens'        => ['page-buro-de-entidades-financieras.php'],
                'bg'             => '',
                'layout'         => 'two_columns',
                'image_position' => 'left',
                'defaults'       => [
                    'heading'    => 'Buró de Entidades Financieras',
                    'subheading' => '',
                    'content'    => '<p>El artículo 8 Bis de la Ley de Protección y Defensa al Usuario de Servicios Financieros, dispone que “La Comisión Nacional para la Protección y defensa de los Usuarios de Servicios Financieros establecerá y mantendrá un buró de Entidades Financieras”, por lo que se podrá consultar en la página www.buro.gob.mx cualquier información referente a nuestros productos ofertados, comisiones, prácticas, sanciones administrativas, reclamaciones y cualquier información relevante para informar a los Usuarios del desempeño en la prestación de nuestros servicios.</p>
                        <p>EL <strong>BURÓ DE ENTIDADES FINANCIERAS</strong> es una herramienta de consulta y difusión con la que podrás conocer los productos que ofrecen las entidades financieras, sus comisiones y tasas, las reclamaciones de los usuarios, las prácticas no sanas en que incurren, las sanciones administrativas que les han impuesto, las cláusulas abusivas de sus contratos y otra información que resulte relevante para informarte sobre su desempeño.</p>
                        <p>Con el <strong>Buró de Entidades Financieras</strong>, se logrará saber quién es quién en bancos, seguros, sociedades financieras de objeto múltiple, cajas de ahorro, afores, entre otras entidades.</p>
                        <p>Con ello, podrás comparar y evaluar a las entidades financieras, sus productos y servicios y tendrás mayores elementos para elegir lo que más te convenga.</p>
                        <p>Esta información te será útil para elegir un producto financiero y también para conocer y usar mejor los que ya tienes.</p>
                        <p>Este <strong>Buró de Entidades Financieras</strong>, es una herramienta que puede contribuir al crecimiento económico del país, al promover la competencia entre las instituciones financieras; que impulsará la transparencia al revelar información a los usuarios sobre el desempeño de estas y los productos que se ofrecen y que va a facilitar un manejo responsable de los productos y servicios financieros al conocer a detalle sus características.</p>
                        <p>Lo anterior, podrá derivar en un mayor bienestar social, porque al conjuntar en un solo espacio tan diversa información del sistema financiero, el usuario tendrá más elementos para optimizar su presupuesto, para mejorar sus finanzas personales, para utilizar correctamente los créditos que fortalecerán su economía y obtener los seguros que la protejan entre otros aspectos.</p>
                        <p>Para su constitución y operación con carácter de sociedad financiera de objeto múltiple, entidad no regulada, no requieren autorización de la Secretaría de Hacienda y Crédito Público, y únicamente está sujeta a la supervisión de la Comisión Nacional Bancaria y de Valores para efectos del artículo 56 de la ley General de Organizaciones y actividades Auxiliares del Crédito.</p>
                        <p><strong><a href="' . esc_url($uneUrl) . '" target="_blank" rel="noopener noreferrer">Datos de la Unidad Especializada en Atención a Usuarios.</a></strong></p>',
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
                    'width' => '50',
                ],
                [
                    'id'    => $v . '_subheading',
                    'label' => __('Subheading', 'taw-theme'),
                    'type'  => 'textarea',
                    'rows'  => 3,
                    'width' => '50',
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

    protected function getData(int|false $postId): array
    {
        $v = $this->variation;
        $c = self::varConfig($v);
        $d = $c['defaults'];

        return [
            'heading'        => $this->getMeta($postId, $v . '_heading')        ?: $d['heading'],
            'subheading'     => $this->getMeta($postId, $v . '_subheading')     ?: $d['subheading'],
            'content'        => $this->getMeta($postId, $v . '_content')        ?: $d['content'],
            'content_disclaimer' => $this->getMeta($postId, $v . '_content_disclaimer') ?: (isset($d['content_disclaimer']) ? $d['content_disclaimer'] : null), // No default for disclaimer; only shows if set
            'layout'         => $this->getMeta($postId, $v . '_layout')         ?: $c['layout'],
            'image_id'       => (int) $this->getMeta($postId, $v . '_image'),
            'image_position' => $this->getMeta($postId, $v . '_image_position') ?: $c['image_position'],
            'bg'             => $c['bg'],
        ];
    }
}
