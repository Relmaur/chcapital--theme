<?php

declare(strict_types=1);

namespace TAW\Blocks\sections\FideicomitentePF;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Form\Form;
use TAW\Core\Metabox\Metabox;

class FideicomitentePF extends MetaBlock
{
    protected string $id = 'fideicomitente_p_f';

    public static function boot(): void
    {
        add_action('init', static function () {
            Form::register([
                'id'           => 'fideicomitente_pf',
                'submit_label' => __('Enviar formulario', 'taw-theme'),
                'next_label'   => __('Continuar', 'taw-theme'),
                'prev_label'   => __('Regresar', 'taw-theme'),
                'turnstile'    => true,
                'email'        => [
                    'to_self' => [
                        'subject' => __('Nuevo Fideicomitente PF — CH Capital', 'taw-theme'),
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

                    // ── STEP 1: Identificación Personal ──────────────────
                    [
                        'title'  => __('Identificación', 'taw-theme'),
                        'fields' => [
                            ['type' => 'heading', 'label' => '1. Datos Generales de Identificación', 'subtitle' => 'General Identification Data'],
                            ['id' => 'nombre',                  'label' => 'Nombre(s)',                   'type' => 'text',  'required' => true,  'width' => 33],
                            ['id' => 'apellido1',               'label' => 'Primer Apellido',             'type' => 'text',  'required' => true,  'width' => 33],
                            ['id' => 'apellido2',               'label' => 'Segundo Apellido',            'type' => 'text',  'required' => false, 'width' => 33],
                            ['id' => 'alias',                   'label' => 'Alias',                       'type' => 'text',  'required' => false, 'width' => 50, 'placeholder' => 'Si aplica'],
                            ['id' => 'nacionalidad',            'label' => 'Nacionalidad',                'type' => 'text',  'required' => true,  'width' => 50],
                            ['id' => 'fecha_nacimiento',        'label' => 'Fecha de Nacimiento',         'type' => 'date',  'required' => true,  'width' => 33],
                            ['id' => 'nacimiento_estado',       'label' => 'Lugar de Nacimiento — Estado', 'type' => 'text',  'required' => false, 'width' => 33],
                            ['id' => 'nacimiento_pais',         'label' => 'Lugar de Nacimiento — País',  'type' => 'text',  'required' => true,  'width' => 33],
                            ['id' => 'pais_residencia',         'label' => 'País de Residencia',          'type' => 'text',  'required' => true,  'width' => 100],
                        ],
                    ],

                    // ── STEP 2: Datos Fiscales y Estado Civil ─────────────
                    [
                        'title'  => __('Fiscal y Estado Civil', 'taw-theme'),
                        'fields' => [
                            ['type' => 'heading', 'label' => '2. Identificación Fiscal y Registros Oficiales', 'subtitle' => 'Tax Identification & Official Registration'],
                            ['id' => 'curp',               'label' => 'CURP',                          'type' => 'text', 'required' => false, 'width' => 33, 'placeholder' => '18 posiciones — mexicanos y residentes'],
                            ['id' => 'rfc',                'label' => 'RFC',                           'type' => 'text', 'required' => false, 'width' => 33, 'placeholder' => '13 posiciones — mexicanos y residentes'],
                            ['id' => 'no_seguridad_social', 'label' => 'No. Seguridad Social / ID Gubernamental', 'type' => 'text', 'required' => false, 'width' => 33, 'placeholder' => 'Extranjeros'],

                            ['type' => 'heading', 'label' => '3. Estado Civil y Régimen Patrimonial', 'subtitle' => 'Marital Status & Property Regime'],
                            [
                                'id' => 'estado_civil',
                                'label' => 'Estado Civil',
                                'type' => 'radio',
                                'required' => true,
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
                                'id' => 'regimen_matrimonial',
                                'label' => 'Régimen Matrimonial',
                                'type' => 'radio',
                                'required' => false,
                                'width' => 100,
                                'options' => [
                                    'sociedad_conyugal'   => 'Sociedad Conyugal',
                                    'separacion_bienes'   => 'Separación de Bienes',
                                ],
                                'layout'     => 'horizontal',
                                'conditions' => [
                                    'relation' => 'any',
                                    'rules'    => [
                                        ['field' => 'estado_civil', 'operator' => '==', 'value' => 'casado'],
                                        ['field' => 'estado_civil', 'operator' => '==', 'value' => 'concubinato'],
                                    ],
                                ],
                            ],
                            [
                                'id' => 'nombre_conyuge',
                                'label' => 'Nombre del Cónyuge o Concubino(a)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 100,
                                'conditions' => [
                                    'relation' => 'any',
                                    'rules'    => [
                                        ['field' => 'estado_civil', 'operator' => '==', 'value' => 'casado'],
                                        ['field' => 'estado_civil', 'operator' => '==', 'value' => 'concubinato'],
                                    ],
                                ],
                            ],
                        ],
                    ],

                    // ── STEP 3: Domicilio y Contacto en México ────────────
                    [
                        'title'  => __('Domicilio', 'taw-theme'),
                        'fields' => [
                            ['type' => 'heading', 'label' => '4. Domicilio y Contacto en México', 'subtitle' => 'Address & Contact in Mexico'],
                            ['id' => 'calle_numero',         'label' => 'Calle, Número Exterior e Interior', 'type' => 'text', 'required' => true,  'width' => 67],
                            ['id' => 'colonia',              'label' => 'Colonia',                            'type' => 'text', 'required' => true,  'width' => 33],
                            ['id' => 'ciudad',               'label' => 'Ciudad o Municipio',                'type' => 'text', 'required' => true,  'width' => 33],
                            ['id' => 'entidad_federativa',   'label' => 'Entidad Federativa',                'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'codigo_postal',        'label' => 'Código Postal',                     'type' => 'text', 'required' => false, 'width' => 17],
                            ['id' => 'pais_domicilio',       'label' => 'País',                              'type' => 'text', 'required' => true,  'width' => 17],
                            ['id' => 'antiguedad_domicilio', 'label' => 'Antigüedad en el Domicilio',        'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'entidad_estancia',     'label' => 'Entidad Federativa — Legal Estancia (Residentes)', 'type' => 'text', 'required' => false, 'width' => 50],
                            ['id' => 'pais_residencia_dom',  'label' => 'País de Residencia',                'type' => 'text', 'required' => false, 'width' => 50],
                            ['id' => 'telefono_movil',       'label' => 'Teléfono Móvil',                    'type' => 'tel',  'required' => true,  'width' => 33, 'placeholder' => 'Clave internacional + nacional'],
                            ['id' => 'telefono_particular',  'label' => 'Teléfono Particular',               'type' => 'tel',  'required' => false, 'width' => 33, 'placeholder' => 'Clave internacional + nacional'],
                            ['id' => 'telefono_oficina',     'label' => 'Teléfono Oficina',                  'type' => 'tel',  'required' => false, 'width' => 33, 'placeholder' => 'Clave internacional + nacional'],
                            ['id' => 'correo_electronico',   'label' => 'Correo Electrónico',                'type' => 'email', 'required' => true,  'width' => 67],
                            ['id' => 'sitio_web',            'label' => 'Sitio Web o Perfil Profesional',    'type' => 'url',  'required' => false, 'width' => 33, 'placeholder' => 'Opcional'],
                        ],
                    ],

                    // ── STEP 4: Domicilios Adicionales ───────────────────
                    [
                        'title'  => __('Otros Domicilios', 'taw-theme'),
                        'fields' => [
                            ['type' => 'heading', 'label' => '5. Domicilio Fiscal en México', 'subtitle' => 'Tax Address in Mexico (if different from personal address)'],
                            ['id' => 'fiscal_calle',      'label' => 'Calle, Número Exterior e Interior', 'type' => 'text', 'required' => false, 'width' => 67],
                            ['id' => 'fiscal_colonia',    'label' => 'Colonia',                            'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'fiscal_ciudad',     'label' => 'Ciudad o Municipio',                'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'fiscal_entidad',    'label' => 'Entidad Federativa',                'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'fiscal_cp',         'label' => 'Código Postal',                     'type' => 'text', 'required' => false, 'width' => 17],
                            ['id' => 'fiscal_antiguedad', 'label' => 'Antigüedad',                        'type' => 'text', 'required' => false, 'width' => 17],

                            ['type' => 'heading', 'label' => '6. Domicilio Fuera de México', 'subtitle' => 'Address Outside Mexico (if applicable)'],
                            ['id' => 'ext_calle',          'label' => 'Calle, Número Exterior e Interior', 'type' => 'text', 'required' => false, 'width' => 67],
                            ['id' => 'ext_colonia',        'label' => 'Colonia o Localidad',               'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'ext_ciudad',         'label' => 'Ciudad',                            'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'ext_estado',         'label' => 'Estado o Provincia',                'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'ext_cp',             'label' => 'Código Postal',                     'type' => 'text', 'required' => false, 'width' => 17],
                            ['id' => 'ext_pais',           'label' => 'País',                              'type' => 'text', 'required' => false, 'width' => 17],
                        ],
                    ],

                    // ── STEP 5: Fideicomiso y PEP ─────────────────────────
                    [
                        'title'  => __('Fideicomiso y PEP', 'taw-theme'),
                        'fields' => [
                            ['type' => 'heading', 'label' => '7. Calidad y Participación en el Fideicomiso', 'subtitle' => 'Role & Participation in the Trust'],
                            [
                                'id' => 'calidad_fideicomiso',
                                'label' => 'Calidad en el Fideicomiso',
                                'type' => 'radio',
                                'required' => true,
                                'width' => 100,
                                'options' => [
                                    'fideicomitente'   => 'Fideicomitente',
                                    'fideicomisario'   => 'Fideicomisario',
                                    'ambos'            => 'Fideicomitente y Fideicomisario',
                                ],
                                'layout' => 'horizontal',
                            ],
                            [
                                'id' => 'tipo_participacion',
                                'label' => 'Tipo de Participación o Control',
                                'type' => 'radio',
                                'required' => true,
                                'width' => 100,
                                'options' => ['directa' => 'Directa', 'indirecta' => 'Indirecta'],
                                'layout'  => 'horizontal',
                            ],
                            ['id' => 'porcentaje_participacion', 'label' => 'Porcentaje de Participación en el Fideicomiso (%)', 'type' => 'number', 'required' => false, 'width' => 50],
                            ['id' => 'descripcion_participacion', 'label' => 'Descripción de la Participación o Control',         'type' => 'textarea', 'required' => false, 'width' => 100, 'rows' => 3],

                            ['type' => 'heading', 'label' => '8. Persona Políticamente Expuesta (PEP)', 'subtitle' => 'Politically Exposed Person — Ley Federal PLD, Art. 17 fracc. VII'],
                            ['type' => 'html', 'content' => '<p class="text-sm text-gray-500 mb-2">Persona que desempeña o ha desempeñado funciones públicas de alto nivel en México o en el extranjero, o que tiene vínculos familiares o de negocios con tales personas.</p>'],
                            [
                                'id' => 'es_pep',
                                'label' => '¿Es usted o algún familiar cercano una Persona Políticamente Expuesta?',
                                'type' => 'radio',
                                'required' => true,
                                'width' => 100,
                                'options' => ['si' => 'Sí', 'no' => 'No'],
                                'layout'  => 'horizontal',
                            ],
                            [
                                'id' => 'pep_cargo',
                                'label' => 'Cargo o Función Pública',
                                'type' => 'text',
                                'required' => false,
                                'width' => 50,
                                'conditions' => [['field' => 'es_pep', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'pep_institucion',
                                'label' => 'Institución o Dependencia',
                                'type' => 'text',
                                'required' => false,
                                'width' => 50,
                                'conditions' => [['field' => 'es_pep', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'actua_tercero',
                                'label' => '¿Actúa por cuenta de un tercero?',
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

                    // ── STEP 6: Identificación Oficial y Actividad Económica
                    [
                        'title'  => __('ID Oficial y Actividad', 'taw-theme'),
                        'fields' => [
                            ['type' => 'heading', 'label' => '9. Documento de Identificación Oficial', 'subtitle' => 'Official Identification Document'],
                            [
                                'id' => 'tipo_documento',
                                'label' => 'Tipo de Documento',
                                'type' => 'radio',
                                'required' => true,
                                'width' => 100,
                                'options' => [
                                    'pasaporte'  => 'Pasaporte',
                                    'ine'        => 'Credencial para Votar (INE/IFE)',
                                    'migratorio' => 'Documento Migratorio',
                                    'licencia'   => 'Licencia de Conducir',
                                ],
                                'layout' => 'horizontal',
                            ],
                            ['id' => 'numero_documento', 'label' => 'Número del Documento', 'type' => 'text', 'required' => true,  'width' => 33],
                            [
                                'id' => 'clave_elector',
                                'label' => 'Clave de Elector (INE/IFE)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'tipo_documento', 'operator' => '==', 'value' => 'ine']],
                            ],
                            ['id' => 'entidad_emisora',   'label' => 'Entidad Emisora',           'type' => 'text', 'required' => false, 'width' => 33],
                            ['id' => 'fecha_emision',     'label' => 'Fecha de Emisión',           'type' => 'date', 'required' => false, 'width' => 50],
                            ['id' => 'fecha_expiracion',  'label' => 'Fecha de Expiración',        'type' => 'date', 'required' => false, 'width' => 50],

                            ['type' => 'heading', 'label' => '10. Actividad Económica y Origen de Recursos', 'subtitle' => 'Economic Activity & Source of Funds — Ley Federal PLD'],
                            [
                                'id' => 'ocupacion',
                                'label' => 'Ocupación o Actividad Económica Principal',
                                'type' => 'radio',
                                'required' => true,
                                'width' => 100,
                                'options' => [
                                    'empleado'    => 'Empleado',
                                    'empresario'  => 'Empresario',
                                    'profesionista' => 'Profesionista',
                                    'pensionado'  => 'Pensionado/Jubilado',
                                    'otro'        => 'Otro',
                                ],
                                'layout' => 'horizontal',
                            ],
                            ['id' => 'empresa_organizacion',       'label' => 'Empresa u Organización',  'type' => 'text',    'required' => false, 'width' => 50],
                            ['id' => 'cargo_puesto',               'label' => 'Cargo o Puesto',          'type' => 'text',    'required' => false, 'width' => 50],
                            [
                                'id' => 'descripcion_origen_recursos',
                                'label' => 'Descripción del Origen Lícito de Recursos',
                                'type' => 'textarea',
                                'required' => true,
                                'width' => 100,
                                'rows' => 3,
                                'placeholder' => 'Salario, honorarios, arrendamiento, venta de activos, herencia, etc.',
                            ],
                            ['id' => 'ingresos_mensuales', 'label' => 'Ingresos Mensuales Estimados (MXN)', 'type' => 'number', 'required' => false, 'width' => 50],
                            ['id' => 'patrimonio_total',   'label' => 'Patrimonio Total Aproximado (MXN)',  'type' => 'number', 'required' => false, 'width' => 50],
                        ],
                    ],

                    // ── STEP 7: Beneficiario Controlador y Representante Legal
                    [
                        'title'  => __('Beneficiario y Rep. Legal', 'taw-theme'),
                        'fields' => [
                            ['type' => 'heading', 'label' => '11. Beneficiario Controlador', 'subtitle' => 'Beneficial Owner / Controlling Beneficiary — CFF Art. 32-B Ter & 32-B Quinquies'],
                            ['type' => 'html', 'content' => '<p class="text-sm text-gray-500 mb-2">Persona(s) física(s) que directa o indirectamente ejerce(n) control sobre el fideicomiso, posee(n) el 25% o más de los derechos de beneficio, o en cuyo nombre se realiza la operación.</p>'],
                            [
                                'id' => 'es_beneficiario_controlador',
                                'label' => '¿Es usted el Beneficiario Controlador del fideicomiso?',
                                'type' => 'radio',
                                'required' => true,
                                'width' => 100,
                                'options' => ['si' => 'Sí, soy el Beneficiario Controlador', 'no' => 'No'],
                                'layout'  => 'horizontal',
                            ],
                            [
                                'id' => 'bc_nombres',
                                'label' => 'Nombre(s)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'es_beneficiario_controlador', 'operator' => '==', 'value' => 'no']],
                            ],
                            [
                                'id' => 'bc_apellido1',
                                'label' => 'Primer Apellido',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'es_beneficiario_controlador', 'operator' => '==', 'value' => 'no']],
                            ],
                            [
                                'id' => 'bc_apellido2',
                                'label' => 'Segundo Apellido',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'es_beneficiario_controlador', 'operator' => '==', 'value' => 'no']],
                            ],
                            [
                                'id' => 'bc_curp',
                                'label' => 'CURP',
                                'type' => 'text',
                                'required' => false,
                                'width' => 50,
                                'conditions' => [['field' => 'es_beneficiario_controlador', 'operator' => '==', 'value' => 'no']],
                            ],
                            [
                                'id' => 'bc_rfc',
                                'label' => 'RFC',
                                'type' => 'text',
                                'required' => false,
                                'width' => 50,
                                'conditions' => [['field' => 'es_beneficiario_controlador', 'operator' => '==', 'value' => 'no']],
                            ],
                            [
                                'id' => 'bc_fecha_nacimiento',
                                'label' => 'Fecha de Nacimiento',
                                'type' => 'date',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'es_beneficiario_controlador', 'operator' => '==', 'value' => 'no']],
                            ],
                            [
                                'id' => 'bc_nacimiento_pais',
                                'label' => 'Lugar de Nacimiento — País',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'es_beneficiario_controlador', 'operator' => '==', 'value' => 'no']],
                            ],
                            [
                                'id' => 'bc_nacionalidad',
                                'label' => 'Nacionalidad',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'es_beneficiario_controlador', 'operator' => '==', 'value' => 'no']],
                            ],
                            [
                                'id' => 'bc_pais_residencia',
                                'label' => 'País de Residencia',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'es_beneficiario_controlador', 'operator' => '==', 'value' => 'no']],
                            ],
                            [
                                'id' => 'bc_domicilio',
                                'label' => 'Domicilio (Calle, Número, Colonia, Ciudad)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 67,
                                'conditions' => [['field' => 'es_beneficiario_controlador', 'operator' => '==', 'value' => 'no']],
                            ],
                            [
                                'id' => 'bc_pais_domicilio',
                                'label' => 'País',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'es_beneficiario_controlador', 'operator' => '==', 'value' => 'no']],
                            ],
                            [
                                'id' => 'bc_porcentaje',
                                'label' => '% de Participación en el Fideicomiso',
                                'type' => 'number',
                                'required' => false,
                                'width' => 50,
                                'conditions' => [['field' => 'es_beneficiario_controlador', 'operator' => '==', 'value' => 'no']],
                            ],
                            [
                                'id' => 'bc_no_id',
                                'label' => 'No. ID Gubernamental (extranjeros)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 50,
                                'conditions' => [['field' => 'es_beneficiario_controlador', 'operator' => '==', 'value' => 'no']],
                            ],
                            [
                                'id' => 'bc_tipo_control',
                                'label' => 'Tipo de Control',
                                'type' => 'radio',
                                'required' => false,
                                'width' => 100,
                                'options' => ['directo' => 'Directo', 'indirecto' => 'Indirecto'],
                                'layout'  => 'horizontal',
                                'conditions' => [['field' => 'es_beneficiario_controlador', 'operator' => '==', 'value' => 'no']],
                            ],
                            [
                                'id' => 'bc_descripcion_control',
                                'label' => 'Descripción del Mecanismo de Control',
                                'type' => 'textarea',
                                'required' => false,
                                'width' => 100,
                                'rows' => 3,
                                'conditions' => [['field' => 'es_beneficiario_controlador', 'operator' => '==', 'value' => 'no']],
                            ],

                            ['type' => 'heading', 'label' => '12. Representante Legal', 'subtitle' => 'Legal Representative (if the Settlor acts through a legal representative)'],
                            [
                                'id' => 'actua_representante',
                                'label' => '¿Actúa a través de Representante Legal?',
                                'type' => 'radio',
                                'required' => true,
                                'width' => 100,
                                'options' => ['si' => 'Sí', 'no' => 'No'],
                                'layout'  => 'horizontal',
                            ],
                            [
                                'id' => 'rl_nombres',
                                'label' => 'Nombre(s)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_apellido1',
                                'label' => 'Primer Apellido',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_apellido2',
                                'label' => 'Segundo Apellido',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_curp',
                                'label' => 'CURP',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_rfc',
                                'label' => 'RFC',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_no_id',
                                'label' => 'No. ID Gubernamental (extranjeros)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_nacionalidad',
                                'label' => 'Nacionalidad',
                                'type' => 'text',
                                'required' => false,
                                'width' => 50,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_pais_residencia',
                                'label' => 'País de Residencia',
                                'type' => 'text',
                                'required' => false,
                                'width' => 50,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_fecha_nacimiento',
                                'label' => 'Fecha de Nacimiento del Rep. Legal',
                                'type' => 'date',
                                'required' => false,
                                'width' => 50,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_lugar_nacimiento',
                                'label' => 'Lugar de Nacimiento (País)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 50,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_instrumento_notarial',
                                'label' => 'Instrumento Notarial del Poder (No., Fecha, Notario)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 100,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_tipo_documento',
                                'label' => 'Tipo de Documento del Rep. Legal',
                                'type' => 'radio',
                                'required' => false,
                                'width' => 100,
                                'options' => [
                                    'pasaporte'  => 'Pasaporte',
                                    'ine'        => 'Credencial para Votar (INE/IFE)',
                                    'migratorio' => 'Documento Migratorio',
                                    'licencia'   => 'Licencia de Conducir',
                                ],
                                'layout'     => 'horizontal',
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_numero_documento',
                                'label' => 'Número del Documento',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_clave_elector',
                                'label' => 'Clave de Elector (INE/IFE)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [
                                    ['field' => 'actua_representante', 'operator' => '==', 'value' => 'si'],
                                    ['field' => 'rl_tipo_documento',   'operator' => '==', 'value' => 'ine'],
                                ],
                            ],
                            [
                                'id' => 'rl_entidad_emisora',
                                'label' => 'Entidad Emisora',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_fecha_emision',
                                'label' => 'Fecha de Emisión',
                                'type' => 'date',
                                'required' => false,
                                'width' => 50,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_fecha_expiracion',
                                'label' => 'Fecha de Expiración',
                                'type' => 'date',
                                'required' => false,
                                'width' => 50,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_domicilio',
                                'label' => 'Domicilio del Rep. Legal (Calle, Número, Colonia)',
                                'type' => 'text',
                                'required' => false,
                                'width' => 67,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                            [
                                'id' => 'rl_pais_domicilio',
                                'label' => 'País de Residencia',
                                'type' => 'text',
                                'required' => false,
                                'width' => 33,
                                'conditions' => [['field' => 'actua_representante', 'operator' => '==', 'value' => 'si']],
                            ],
                        ],
                    ],

                    // ── STEP 8: Documentos y Declaración ─────────────────
                    [
                        'title'  => __('Documentos y Declaración', 'taw-theme'),
                        'fields' => [
                            ['type' => 'heading', 'label' => '13. Documentos a Acompañar al Formulario', 'subtitle' => 'Documents to be Attached to this Form'],
                            ['type' => 'html', 'content' => '
                                <ol class="list-decimal list-inside space-y-1 text-sm mb-4">
                                    <li>Identificación oficial vigente con foto, firma y domicilio (titular y/o representante legal).</li>
                                    <li>Constancia CURP (mexicanos y residentes), antigüedad no mayor a 3 meses.</li>
                                    <li>Cédula de Identificación Fiscal (mexicanos y residentes), no mayor a 3 meses.</li>
                                    <li>Comprobante de domicilio en México (si difiere del de la ID), no mayor a 3 meses.</li>
                                    <li>Acta de matrimonio (si aplica).</li>
                                    <li>Identificación oficial vigente del cónyuge (si aplica).</li>
                                    <li>Testimonio del poder notarial (si actúa a través de representante legal).</li>
                                    <li>Forma migratoria (extranjeros visitantes).</li>
                                    <li>Comprobante de domicilio fuera de México (mexicanos o extranjeros no residentes), 3 meses.</li>
                                    <li>Identificación oficial del Beneficiario Controlador (si es persona distinta al fideicomitente).</li>
                                </ol>
                                <p class="text-sm text-amber-700 bg-amber-50 border border-amber-200 rounded p-3 mb-2">
                                    <strong>Nota:</strong> Todos los documentos deben estar vigentes y con una antigüedad no mayor a tres meses. CH Capital, SAPI de CV, SOFOM, ENR, puede verificar la información proporcionada mediante búsquedas y cruces en distintas plataformas.
                                </p>
                            '],

                            ['type' => 'heading', 'label' => '14. Declaración', 'subtitle' => 'Declaration, Date & Signature'],
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
            'id'      => 'taw_fideicomitente_p_f',
            'title'   => __('Section — Fideicomitente PF', 'taw-theme'),
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
            'heading'    => $this->getMeta($postId, 'heading')    ?: __('Formulario Fideicomitente Persona Física', 'taw-theme'),
            'subheading' => $this->getMeta($postId, 'subheading') ?: '',
        ];
    }
}
