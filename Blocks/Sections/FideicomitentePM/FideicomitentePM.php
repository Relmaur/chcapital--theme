<?php

declare(strict_types=1);

namespace TAW\Blocks\sections\FideicomitentePM;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Form\Form;
use TAW\Core\Metabox\Metabox;

class FideicomitentePM extends MetaBlock
{
    protected string $id = 'fideicomitente_p_m';

    public static function boot(): void
    {
        add_action('init', static function () {
            Form::register([
                'id'           => 'fideicomitente_pm',
                'submit_label' => __('Enviar formulario', 'taw-theme'),
                'next_label'   => __('Continuar', 'taw-theme'),
                'prev_label'   => __('Regresar', 'taw-theme'),
                'turnstile'    => true,
                'email'        => [
                    'to_self' => [
                        'subject' => __('Nuevo Fideicomitente PM — CH Capital', 'taw-theme'),
                    ],
                ],
                'messages' => [
                    'success'          => __('¡Gracias! Tu formulario ha sido recibido. Nos pondremos en contacto contigo a la brevedad.', 'taw-theme'),
                    'turnstile_failed' => __('No pudimos verificar que eres humano. Por favor, inténtalo de nuevo.', 'taw-theme'),
                    'required'         => __('Este campo es requerido.', 'taw-theme'),
                    'email'            => __('Correo electrónico no válido.', 'taw-theme'),
                    'min_length'       => __('%1$s debe tener al menos %2$d caracteres.', 'taw-theme'),
                    'max_length'       => __('%1$s no debe superar los %2$d caracteres.', 'taw-theme'),
                    'pattern'          => __('%s no tiene el formato correcto.', 'taw-theme'),
                    'min'              => __('%1$s debe ser al menos %2$s.', 'taw-theme'),
                    'max'              => __('%1$s no debe superar %2$s.', 'taw-theme'),
                ],
                'steps' => [

                    // ── STEP 1: Identificación de la Persona Moral ────────
                    [
                        'title'  => __('Identificación', 'taw-theme'),
                        'fields' => [
                            ['type' => 'heading', 'label' => '1. Identificación de la Persona Moral', 'subtitle' => 'Legal Entity Identification'],
                            [
                                'id' => 'nacionalidad_pm',
                                'label' => 'Nacionalidad de la Persona Moral',
                                'type' => 'radio',
                                'required' => true,
                                'width' => 100,
                                'options' => ['mexicana' => 'Mexicana', 'extranjera' => 'Extranjera'],
                                'layout'  => 'horizontal',
                            ],
                            [
                                'id' => 'pais_extranjera',
                                'label' => 'País (si extranjera)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 100,
                                'conditions' => [['field' => 'nacionalidad_pm', 'operator' => '==', 'value' => 'extranjera']],
                            ],
                            ['id' => 'razon_social',      'label' => 'Denominación o Razón Social Completa', 'type' => 'text',     'required' => true,  'width' => 100],
                            ['id' => 'fecha_constitucion', 'label' => 'Fecha de Constitución',                'type' => 'date',     'required' => true,  'width' => 50],
                            ['id' => 'numero_acta',       'label' => 'Número del Acta Constitutiva',         'type' => 'text',     'required' => false, 'width' => 50],
                            ['id' => 'folio_mercantil',   'label' => 'Folio Mercantil',                      'type' => 'text',     'required' => false, 'width' => 50, 'placeholder' => 'Si en trámite, adjuntar carta notarial'],
                            ['id' => 'objeto_social',     'label' => 'Objeto Social Principal',              'type' => 'textarea', 'required' => true,  'width' => 50, 'rows' => 3],
                            ['id' => 'rfc_pm',            'label' => 'RFC (Personas Morales mexicanas)',     'type' => 'text',     'required' => false, 'width' => 50, 'placeholder' => '13 posiciones'],
                            ['id' => 'regimen_fiscal',    'label' => 'Régimen Fiscal (Personas Morales mexicanas)', 'type' => 'text', 'required' => false, 'width' => 50],
                            [
                                'id' => 'no_id_fiscal_ext',
                                'label' => 'Número de Identificación Fiscal (entidades extranjeras)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 100,
                                'conditions' => [['field' => 'nacionalidad_pm', 'operator' => '==', 'value' => 'extranjera']],
                            ],
                        ],
                    ],

                    // ── STEP 2: Domicilios y Contacto ─────────────────────
                    [
                        'title'  => __('Domicilio y Contacto', 'taw-theme'),
                        'fields' => [
                            ['type' => 'heading', 'label' => '2. Domicilio Fiscal de la Persona Moral', 'subtitle' => 'Legal Entity\'s Tax / Registered Address'],
                            ['id' => 'fiscal_calle',   'label' => 'Calle, Número Exterior e Interior', 'type' => 'text', 'required' => true,  'width' => 67],
                            ['id' => 'fiscal_colonia', 'label' => 'Colonia',                            'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'fiscal_ciudad',  'label' => 'Ciudad o Municipio',                'type' => 'text', 'required' => true,  'width' => 33],
                            ['id' => 'fiscal_estado',  'label' => 'Estado o Provincia',                'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'fiscal_cp',      'label' => 'Código Postal',                     'type' => 'text', 'required' => false, 'width' => 17],
                            ['id' => 'fiscal_pais',    'label' => 'País',                              'type' => 'text', 'required' => true,  'width' => 17],

                            ['type' => 'heading', 'label' => '3. Domicilio Operativo', 'subtitle' => 'Operational Address (if different from tax address)'],
                            ['id' => 'op_calle',   'label' => 'Calle, Número Exterior e Interior', 'type' => 'text', 'required' => false, 'width' => 67],
                            ['id' => 'op_colonia', 'label' => 'Colonia',                            'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'op_ciudad',  'label' => 'Ciudad',                            'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'op_estado',  'label' => 'Estado o Provincia',                'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'op_cp',      'label' => 'Código Postal',                     'type' => 'text', 'required' => false, 'width' => 17],
                            ['id' => 'op_pais',    'label' => 'País',                              'type' => 'text', 'required' => false, 'width' => 17],

                            ['type' => 'heading', 'label' => '4. Datos de Contacto de la Persona Moral', 'subtitle' => 'Legal Entity Contact Details'],
                            ['id' => 'correo_institucional', 'label' => 'Correo Electrónico Institucional', 'type' => 'email', 'required' => true,  'width' => 67],
                            ['id' => 'sitio_web',             'label' => 'Sitio Web',                       'type' => 'url',   'required' => false, 'width' => 33, 'placeholder' => 'Opcional'],
                            ['id' => 'tel_principal',         'label' => 'Tel. Principal',                  'type' => 'tel',   'required' => true,  'width' => 25],
                            ['id' => 'tel_secundario',        'label' => 'Tel. Secundario',                 'type' => 'tel',   'required' => false, 'width' => 25],
                            ['id' => 'persona_contacto',      'label' => 'Persona de Contacto',             'type' => 'text',  'required' => false, 'width' => 25],
                            ['id' => 'cargo_contacto',        'label' => 'Cargo',                           'type' => 'text',  'required' => false, 'width' => 25],
                        ],
                    ],

                    // ── STEP 3: Fideicomiso y PLD ─────────────────────────
                    [
                        'title'  => __('Fideicomiso y PLD', 'taw-theme'),
                        'fields' => [
                            ['type' => 'heading', 'label' => '5. Calidad y Participación en el Fideicomiso', 'subtitle' => 'Role & Participation in the Trust'],
                            [
                                'id' => 'calidad_fideicomiso',
                                'label' => 'Calidad en el Fideicomiso',
                                'type' => 'radio',
                                'required' => true,
                                'width' => 100,
                                'options' => [
                                    'fideicomitente' => 'Fideicomitente',
                                    'fideicomisario' => 'Fideicomisario',
                                    'ambos'          => 'Fideicomitente y Fideicomisario',
                                ],
                                'layout' => 'horizontal',
                            ],
                            [
                                'id' => 'tipo_participacion',
                                'label' => 'Tipo de Participación o Control',
                                'type' => 'radio',
                                'required' => true,
                                'width' => 100,
                                'options' => ['directa' => 'Directa', 'indirecta' => 'Indirecta', 'ambas' => 'Ambas'],
                                'layout'  => 'horizontal',
                            ],
                            ['id' => 'porcentaje_participacion', 'label' => '% Participación en el Fideicomiso', 'type' => 'number', 'required' => false, 'width' => 50],
                            ['id' => 'numero_fideicomiso',       'label' => 'Número o Clave del Fideicomiso',     'type' => 'text',   'required' => false, 'width' => 50, 'placeholder' => 'Si se conoce'],
                            ['id' => 'descripcion_participacion', 'label' => 'Descripción de la Participación o Control', 'type' => 'textarea', 'required' => false, 'width' => 100, 'rows' => 3],

                            ['type' => 'heading', 'label' => '6. Información para Prevención de Lavado de Dinero (PLD)', 'subtitle' => 'AML Information — Ley Federal PLD'],
                            [
                                'id' => 'actividad_economica',
                                'label' => 'Actividad Económica Principal',
                                'type' => 'radio',
                                'required' => true,
                                'width' => 100,
                                'options' => [
                                    'inmobiliaria' => 'Inmobiliaria',
                                    'financiera'   => 'Financiera',
                                    'comercial'    => 'Comercial',
                                    'industrial'   => 'Industrial',
                                    'servicios'    => 'Servicios',
                                    'otra'         => 'Otra',
                                ],
                                'layout' => 'horizontal',
                            ],
                            [
                                'id' => 'descripcion_actividad',
                                'label' => 'Descripción de Actividad (si Otra)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 100,
                                'conditions' => [['field' => 'actividad_economica', 'operator' => '==', 'value' => 'otra']],
                            ],
                            [
                                'id' => 'descripcion_origen_recursos',
                                'label' => 'Descripción del Origen Lícito de los Recursos',
                                'type' => 'textarea',
                                'required' => true,
                                'width' => 100,
                                'rows' => 3,
                                'placeholder' => 'Aportaciones de socios, ingresos por actividad, venta de activos, financiamiento, etc.',
                            ],
                            ['id' => 'ingresos_anuales',  'label' => 'Ingresos Anuales Estimados (MXN)',  'type' => 'number', 'required' => false, 'width' => 50],
                            ['id' => 'capital_contable',  'label' => 'Capital Contable Aproximado (MXN)', 'type' => 'number', 'required' => false, 'width' => 50],
                            ['id' => 'grupo_empresarial', 'label' => 'Grupo Empresarial al que Pertenece', 'type' => 'text',   'required' => false, 'width' => 100, 'placeholder' => 'Si aplica'],
                            [
                                'id' => 'tiene_pep',
                                'label' => '¿Algún socio, accionista o funcionario de la PM es Persona Políticamente Expuesta (PEP)?',
                                'type' => 'radio',
                                'required' => true,
                                'width' => 100,
                                'options' => ['si' => 'Sí', 'no' => 'No'],
                                'layout'  => 'horizontal',
                            ],
                            [
                                'id' => 'nombre_pep',
                                'label' => 'Nombre e Identificación del PEP',
                                'type' => 'text',
                                'required' => false,
                                'width' => 100,
                                'conditions' => [['field' => 'tiene_pep', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'actua_tercero',
                                'label' => '¿La PM actúa por cuenta de un tercero?',
                                'type' => 'radio',
                                'required' => true,
                                'width' => 100,
                                'options' => ['si' => 'Sí', 'no' => 'No'],
                                'layout'  => 'horizontal',
                            ],
                            [
                                'id' => 'nombre_tercero',
                                'label' => 'Nombre e Identificación del Tercero',
                                'type' => 'text',
                                'required' => false,
                                'width' => 100,
                                'conditions' => [['field' => 'actua_tercero', 'operator' => '==', 'value' => 'si']],
                            ],
                        ],
                    ],

                    // ── STEP 4: Beneficiario Controlador — Datos Personales
                    [
                        'title'  => __('Beneficiario Controlador', 'taw-theme'),
                        'fields' => [
                            ['type' => 'heading', 'label' => '7. Beneficiario Controlador', 'subtitle' => 'Beneficial Owner / Controlling Beneficiary — CFF Art. 32-B Ter & 32-B Quinquies'],
                            ['type' => 'html', 'content' => '<p class="text-sm text-gray-500 mb-2">Persona(s) física(s) que directa o indirectamente ejerce(n) control, posee(n) ≥25% del capital o derechos de voto, o en cuyo nombre se realiza la operación.</p>'],

                            ['type' => 'heading', 'label' => '7.1 Datos Personales del Beneficiario Controlador', 'subtitle' => 'Personal Data of the Beneficial Owner'],
                            ['id' => 'bc_nombres',   'label' => 'Nombre(s)',        'type' => 'text', 'required' => true,  'width' => 33],
                            ['id' => 'bc_apellido1', 'label' => 'Primer Apellido',  'type' => 'text', 'required' => true,  'width' => 33],
                            ['id' => 'bc_apellido2', 'label' => 'Segundo Apellido', 'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_alias',        'label' => 'Alias',        'type' => 'text', 'required' => false, 'width' => 50, 'placeholder' => 'Si aplica'],
                            ['id' => 'bc_nacionalidad', 'label' => 'Nacionalidad', 'type' => 'text', 'required' => true,  'width' => 50],
                            ['id' => 'bc_fecha_nacimiento',  'label' => 'Fecha de Nacimiento',         'type' => 'date', 'required' => true,  'width' => 33],
                            ['id' => 'bc_nacimiento_estado', 'label' => 'Lugar de Nacimiento — Estado', 'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_nacimiento_pais',   'label' => 'Lugar de Nacimiento — País',   'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_curp', 'label' => 'CURP', 'type' => 'text', 'required' => false, 'width' => 50, 'placeholder' => '18 posiciones — mexicanos y residentes'],
                            ['id' => 'bc_rfc',  'label' => 'RFC',  'type' => 'text', 'required' => false, 'width' => 50, 'placeholder' => '13 posiciones — mexicanos y residentes'],
                            ['id' => 'bc_no_id', 'label' => 'No. Seguridad Social o ID Gubernamental (extranjeros)', 'type' => 'text', 'required' => false, 'width' => 100],
                            [
                                'id' => 'bc_estado_civil',
                                'label' => 'Estado Civil',
                                'type' => 'radio',
                                'required' => false,
                                'width' => 100,
                                'options' => [
                                    'soltero'     => 'Soltero(a)',
                                    'casado'      => 'Casado(a)',
                                    'concubinato' => 'Concubinato',
                                    'divorciado'  => 'Divorciado(a)',
                                    'viudo'       => 'Viudo(a)',
                                ],
                                'layout' => 'horizontal',
                            ],
                            [
                                'id' => 'bc_regimen_matrimonial',
                                'label' => 'Régimen Matrimonial',
                                'type' => 'radio',
                                'required' => false,
                                'width' => 100,
                                'options' => [
                                    'sociedad_conyugal' => 'Sociedad Conyugal',
                                    'separacion_bienes' => 'Separación de Bienes',
                                ],
                                'layout'     => 'horizontal',
                                'conditions' => [
                                    'relation' => 'any',
                                    'rules'    => [
                                        ['field' => 'bc_estado_civil', 'operator' => '==', 'value' => 'casado'],
                                        ['field' => 'bc_estado_civil', 'operator' => '==', 'value' => 'concubinato'],
                                    ],
                                ],
                            ],
                            [
                                'id' => 'bc_nombre_conyuge',
                                'label' => 'Nombre del Cónyuge o Concubino(a)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 100,
                                'conditions' => [
                                    'relation' => 'any',
                                    'rules'    => [
                                        ['field' => 'bc_estado_civil', 'operator' => '==', 'value' => 'casado'],
                                        ['field' => 'bc_estado_civil', 'operator' => '==', 'value' => 'concubinato'],
                                    ],
                                ],
                            ],
                        ],
                    ],

                    // ── STEP 5: BC — Domicilio, Contacto y Participación ──
                    [
                        'title'  => __('Domicilio BC y Participación', 'taw-theme'),
                        'fields' => [
                            ['type' => 'heading', 'label' => '7.2 Domicilio del Beneficiario Controlador', 'subtitle' => 'Beneficial Owner\'s Address'],
                            ['id' => 'bc_entidad_estancia', 'label' => 'Entidad Federativa de Legal Estancia (Residentes)', 'type' => 'text', 'required' => false, 'width' => 50],
                            ['id' => 'bc_pais_residencia',  'label' => 'País de Residencia',                                'type' => 'text', 'required' => false, 'width' => 50],
                            ['id' => 'bc_dom_mx_calle',   'label' => 'Domicilio en México — Calle, Número Ext. e Int.', 'type' => 'text', 'required' => false, 'width' => 67],
                            ['id' => 'bc_dom_mx_colonia', 'label' => 'Colonia',           'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_dom_mx_ciudad',  'label' => 'Ciudad o Municipio', 'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_dom_mx_estado',  'label' => 'Entidad Federativa', 'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_dom_mx_cp',      'label' => 'Código Postal',     'type' => 'text', 'required' => false, 'width' => 17],
                            ['id' => 'bc_dom_mx_ant',     'label' => 'Antigüedad',        'type' => 'text', 'required' => false, 'width' => 17],
                            ['id' => 'bc_fiscal_calle',   'label' => 'Domicilio Fiscal en México (si difiere) — Calle, Número', 'type' => 'text', 'required' => false, 'width' => 67],
                            ['id' => 'bc_fiscal_colonia', 'label' => 'Colonia',           'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_fiscal_ciudad',  'label' => 'Ciudad',            'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_fiscal_estado',  'label' => 'Entidad Federativa', 'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_fiscal_cp',      'label' => 'Código Postal',     'type' => 'text', 'required' => false, 'width' => 17],
                            ['id' => 'bc_fiscal_ant',     'label' => 'Antigüedad',        'type' => 'text', 'required' => false, 'width' => 17],
                            ['id' => 'bc_ext_calle',   'label' => 'Domicilio Fuera de México — Calle, Número', 'type' => 'text', 'required' => false, 'width' => 67],
                            ['id' => 'bc_ext_colonia', 'label' => 'Colonia',        'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_ext_ciudad',  'label' => 'Ciudad',         'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_ext_estado',  'label' => 'Estado',         'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_ext_cp',      'label' => 'Código Postal',  'type' => 'text', 'required' => false, 'width' => 17],
                            ['id' => 'bc_ext_pais',    'label' => 'País',           'type' => 'text', 'required' => false, 'width' => 17],

                            ['type' => 'heading', 'label' => '7.3 Contacto del Beneficiario Controlador', 'subtitle' => 'Beneficial Owner\'s Contact'],
                            ['id' => 'bc_tel_movil',     'label' => 'Tel. Móvil',     'type' => 'tel',   'required' => false, 'width' => 25],
                            ['id' => 'bc_tel_particular', 'label' => 'Tel. Particular', 'type' => 'tel',   'required' => false, 'width' => 25],
                            ['id' => 'bc_tel_oficina',   'label' => 'Tel. Oficina',   'type' => 'tel',   'required' => false, 'width' => 25],
                            ['id' => 'bc_correo',        'label' => 'Correo Electrónico', 'type' => 'email', 'required' => false, 'width' => 25],

                            ['type' => 'heading', 'label' => '7.4 Participación del Beneficiario Controlador en la PM', 'subtitle' => 'BC\'s Participation in the Legal Entity'],
                            ['id' => 'bc_tipo_part_pm', 'label' => 'Tipo / Naturaleza de Participación en la PM',  'type' => 'text', 'required' => false, 'width' => 67],
                            ['id' => 'bc_grado_part',   'label' => 'Grado de Participación (% o fracción)',         'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_no_acciones',  'label' => 'No. de Acciones o Partes Sociales',             'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_serie',        'label' => 'Serie',                                         'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_clase',        'label' => 'Clase',                                         'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'bc_valor_nominal',  'label' => 'Valor Nominal de las Acciones',                               'type' => 'text', 'required' => false, 'width' => 100],
                            ['id' => 'bc_lugar_deposito', 'label' => 'Lugar donde se Encuentran Depositadas o en Custodia las Acciones', 'type' => 'text', 'required' => false, 'width' => 100],

                            ['type' => 'heading', 'label' => '7.5 Participación en el Fideicomiso y Fecha de Adquisición', 'subtitle' => 'Trust Participation & Acquisition Date'],
                            [
                                'id' => 'bc_forma_part_fid',
                                'label' => 'Forma de Participación o Control en el Fideicomiso',
                                'type' => 'radio',
                                'required' => false,
                                'width' => 100,
                                'options' => ['directa' => 'Directa', 'indirecta' => 'Indirecta', 'ambas' => 'Ambas'],
                                'layout'  => 'horizontal',
                            ],
                            ['id' => 'bc_fecha_adquisicion',   'label' => 'Fecha en que Adquirió la Calidad de Beneficiario Controlador', 'type' => 'date',     'required' => false, 'width' => 50],
                            ['id' => 'bc_descripcion_control', 'label' => 'Descripción del Mecanismo de Control',                         'type' => 'textarea', 'required' => false, 'width' => 100, 'rows' => 3],
                        ],
                    ],

                    // ── STEP 6: Representante Legal ───────────────────────
                    [
                        'title'  => __('Representante Legal', 'taw-theme'),
                        'fields' => [
                            ['type' => 'heading', 'label' => '8. Representante Legal de la Persona Moral', 'subtitle' => 'Legal Representative of the Legal Entity'],
                            ['id' => 'rl_nombres',   'label' => 'Nombre(s)',        'type' => 'text', 'required' => true,  'width' => 33],
                            ['id' => 'rl_apellido1', 'label' => 'Primer Apellido',  'type' => 'text', 'required' => true,  'width' => 33],
                            ['id' => 'rl_apellido2', 'label' => 'Segundo Apellido', 'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'rl_fecha_nacimiento', 'label' => 'Fecha de Nacimiento',       'type' => 'date', 'required' => false, 'width' => 33],
                            ['id' => 'rl_nacimiento_pais',  'label' => 'Lugar de Nacimiento — País', 'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'rl_nacionalidad',     'label' => 'Nacionalidad',               'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'rl_curp',  'label' => 'CURP', 'type' => 'text', 'required' => false, 'width' => 50, 'placeholder' => '18 posiciones — mexicanos y residentes'],
                            ['id' => 'rl_rfc',   'label' => 'RFC',  'type' => 'text', 'required' => false, 'width' => 50, 'placeholder' => '13 posiciones — mexicanos y residentes'],
                            ['id' => 'rl_no_id', 'label' => 'No. Seguridad Social o ID Gubernamental (extranjeros)', 'type' => 'text', 'required' => false, 'width' => 100],
                            ['id' => 'rl_entidad_estancia', 'label' => 'Entidad Federativa de Legal Estancia (Residentes)', 'type' => 'text', 'required' => false, 'width' => 50],
                            ['id' => 'rl_pais_residencia',  'label' => 'País de Residencia',                                'type' => 'text', 'required' => false, 'width' => 50],
                            ['id' => 'rl_tel_movil',     'label' => 'Tel. Móvil',     'type' => 'tel',   'required' => false, 'width' => 25],
                            ['id' => 'rl_tel_particular', 'label' => 'Tel. Particular', 'type' => 'tel',   'required' => false, 'width' => 25],
                            ['id' => 'rl_tel_oficina',   'label' => 'Tel. Oficina',   'type' => 'tel',   'required' => false, 'width' => 25],
                            ['id' => 'rl_correo',        'label' => 'Correo Electrónico', 'type' => 'email', 'required' => true,  'width' => 25],
                            ['id' => 'rl_dom_mx_calle',   'label' => 'Domicilio en México — Calle, Número', 'type' => 'text', 'required' => false, 'width' => 67],
                            ['id' => 'rl_dom_mx_colonia', 'label' => 'Colonia',           'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'rl_dom_mx_ciudad',  'label' => 'Ciudad',            'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'rl_dom_mx_estado',  'label' => 'Entidad Federativa', 'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'rl_dom_mx_cp',      'label' => 'Código Postal',     'type' => 'text', 'required' => false, 'width' => 17],
                            ['id' => 'rl_dom_mx_pais',    'label' => 'País',              'type' => 'text', 'required' => false, 'width' => 17],
                            ['id' => 'rl_ext_calle',   'label' => 'Domicilio Fuera de México — Calle, Número', 'type' => 'text', 'required' => false, 'width' => 67],
                            ['id' => 'rl_ext_colonia', 'label' => 'Colonia',        'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'rl_ext_ciudad',  'label' => 'Ciudad',         'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'rl_ext_estado',  'label' => 'Estado',         'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'rl_ext_cp',      'label' => 'Código Postal',  'type' => 'text', 'required' => false, 'width' => 17],
                            ['id' => 'rl_ext_pais',    'label' => 'País',           'type' => 'text', 'required' => false, 'width' => 17],

                            ['type' => 'heading', 'label' => '8.1 Instrumento Notarial e Identificación del Rep. Legal', 'subtitle' => 'Notarial Instrument & ID'],
                            ['id' => 'rl_instrumento_notarial', 'label' => 'Instrumento Notarial del Poder (Número, Fecha, Notario)', 'type' => 'text', 'required' => false, 'width' => 100],
                            [
                                'id' => 'rl_tipo_documento',
                                'label' => 'Tipo de Documento de Identificación',
                                'type' => 'radio',
                                'required' => false,
                                'width' => 100,
                                'options' => [
                                    'pasaporte'  => 'Pasaporte',
                                    'ine'        => 'Credencial para Votar (INE/IFE)',
                                    'migratorio' => 'Documento Migratorio',
                                    'licencia'   => 'Licencia de Conducir',
                                ],
                                'layout' => 'horizontal',
                            ],
                            ['id' => 'rl_numero_documento', 'label' => 'Número del Documento', 'type' => 'text', 'required' => false, 'width' => 33],
                            [
                                'id' => 'rl_clave_elector',
                                'label' => 'Clave de Elector (INE)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'rl_tipo_documento', 'operator' => '==', 'value' => 'ine']],
                            ],
                            ['id' => 'rl_entidad_emisora',  'label' => 'Entidad Emisora',        'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'rl_fecha_emision',    'label' => 'Fecha de Emisión',       'type' => 'date', 'required' => false, 'width' => 50],
                            ['id' => 'rl_fecha_expiracion', 'label' => 'Fecha de Expiración',    'type' => 'date', 'required' => false, 'width' => 50],
                        ],
                    ],

                    // ── STEP 7: Documentos y Declaración ─────────────────
                    [
                        'title'  => __('Documentos y Declaración', 'taw-theme'),
                        'fields' => [
                            ['type' => 'heading', 'label' => '9. Documentos a Acompañar al Formulario', 'subtitle' => 'Documents to be Attached to this Form'],
                            ['type' => 'html', 'content' => '
                                <ul class="space-y-1 text-sm mb-4">
                                    <li><strong>PM-1</strong> Acta constitutiva con boleta de inscripción (o carta notarial si está en trámite).</li>
                                    <li><strong>PM-2</strong> Constancia de Situación Fiscal / RFC (personas morales mexicanas), no mayor a 3 meses.</li>
                                    <li><strong>PM-3</strong> Comprobante de domicilio de la PM, no mayor a 3 meses.</li>
                                    <li><strong>PM-4</strong> Testimonio notarial de poderes del Representante Legal (si no constan en el acta constitutiva).</li>
                                    <li><strong>PM-5</strong> Acta de matrimonio del Beneficiario Controlador (si aplica).</li>
                                    <li><strong>PM-6</strong> Identificación oficial vigente del cónyuge del Beneficiario Controlador (si aplica).</li>
                                    <li><strong>PM-7</strong> Identificación oficial vigente del Beneficiario Controlador con foto, firma y domicilio.</li>
                                    <li><strong>RL-1</strong> Identificación oficial vigente del Representante Legal con foto, firma y domicilio.</li>
                                    <li><strong>RL-2</strong> CURP del Representante Legal (mexicanos y residentes), no mayor a 3 meses.</li>
                                    <li><strong>RL-3</strong> Cédula de Identificación Fiscal del Representante Legal (mexicanos y residentes).</li>
                                    <li><strong>RL-4</strong> Comprobante de domicilio del Representante Legal (si difiere del de su ID), 3 meses.</li>
                                    <li><strong>RL-5</strong> Forma migratoria (Representante Legal extranjero visitante).</li>
                                </ul>
                                <p class="text-sm text-amber-700 bg-amber-50 border border-amber-200 rounded p-3 mb-2">
                                    <strong>Nota:</strong> Todos los documentos deben estar vigentes y con antigüedad no mayor a tres meses. CH Capital se reserva el derecho de verificar la información proporcionada en distintas plataformas.
                                </p>
                            '],

                            ['type' => 'heading', 'label' => '10. Declaración, Fecha y Firma', 'subtitle' => 'Declaration, Date & Signature'],
                            ['type' => 'html', 'content' => '
                                <div class="text-sm border border-gray-200 rounded p-3 mb-2">
                                    <p>DECLARO, BAJO PROTESTA DE DECIR VERDAD, QUE TODA LA INFORMACIÓN CONSIGNADA Y FIRMADA EN EL PRESENTE DOCUMENTO, ASÍ COMO LA DOCUMENTACIÓN ADJUNTA, ES VERDADERA Y CORRECTA.</p>
                                    <p class="italic text-gray-500 mt-1">I declare, under penalty of perjury, that all the information given in this document, as well as the attached documentation, is true and correct.</p>
                                </div>
                            '],
                            ['id' => 'declaracion_verdad', 'label' => 'Confirmo que toda la información proporcionada es verdadera y correcta', 'type' => 'checkbox', 'required' => true, 'width' => 100],
                        ],
                    ],

                ],
            ]);
        });
    }

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'      => 'taw_fideicomitente_p_m',
            'title'   => __('Section — Fideicomitente PM', 'taw-theme'),
            'screens' => ['page-forms-test.php'],
            'fields'  => [
                ['id' => 'heading',    'label' => __('Heading',    'taw-theme'), 'type' => 'text',     'width' => 100],
                ['id' => 'subheading', 'label' => __('Subheading', 'taw-theme'), 'type' => 'textarea', 'width' => 100, 'rows' => 2],
            ],
        ]);
    }

    protected function getData(int|false $postId): array
    {
        return [
            'heading'    => $this->getMeta($postId, 'heading')    ?: __('Formulario Fideicomitente Persona Moral', 'taw-theme'),
            'subheading' => $this->getMeta($postId, 'subheading') ?: '',
        ];
    }
}
