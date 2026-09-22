<?php

declare(strict_types=1);

namespace TAW\Blocks\Sections\LegalDocument;

use TAW\Core\Block\MetaBlock;
use TAW\Core\Metabox\Metabox;

class LegalDocument extends MetaBlock
{
    protected string $id = 'legal_document';

    protected function registerMetaboxes(): void
    {
        new Metabox([
            'id'      => 'taw_legal_document',
            'title'   => __('Section - Legal Document', 'taw-theme'),
            'icon'    => get_template_directory_uri() . '/resources/static/svg/ch-isotype.svg',
            'screens' => ['page-aviso-de-privacidad.php'],
            'fields'  => [
                [
                    'id'          => 'legal_document_content',
                    'label'       => __('Document Body', 'taw-theme'),
                    'type'        => 'wysiwyg',
                    'width'       => '100',
                    'description' => __('The page heading and intro come from the Standard Hero section above. This is the full legal text below it.', 'taw-theme'),
                ],
            ],
        ]);
    }

    protected function getData(int|false $postId): array
    {
        return [
            'content' => $this->getMeta($postId, 'legal_document_content') ?: self::defaultContent(),
        ];
    }

    /**
     * Full Aviso de Privacidad Integral text, as published September 2026.
     * Lives here (rather than only as a metabox default) so the page keeps
     * showing correct legal copy even before an editor ever opens the
     * metabox. Bump OptionsPage's `privacy_notice.version` whenever this
     * text changes — see inc/options.php.
     */
    private static function defaultContent(): string
    {
        return __(
            '<p>En cumplimiento de los artículos 6, 8, 15, 16, 17, 28, 29, 36 y demás aplicables de la Ley Federal de Protección de Datos Personales en Posesión de los Particulares (&ldquo;LFPDPPP&rdquo;), su Reglamento, los Lineamientos del Aviso de Privacidad del INAI, así como de las obligaciones aplicables al sector financiero derivadas del artículo 95 bis de la Ley General de Organizaciones y Actividades Auxiliares del Crédito, las Disposiciones de Carácter General en materia de PLD/FT aplicables a las SOFOMES y la normatividad emitida por la CONDUSEF, CHUMACERO CAPITAL, S.A.P.I. DE C.V., SOFOM E.N.R. (en adelante, &ldquo;CH Capital&rdquo;), con domicilio en Calle El Risco número 209, Colonia Jardines del Pedregal, Alcaldía Álvaro Obregón, C.P. 01900, Ciudad de México, emite el presente Aviso de Privacidad Integral.</p>

            <p>CH Capital es responsable del tratamiento, uso, protección y resguardo de sus datos personales, y garantiza su manejo mediante estrictas medidas de seguridad técnicas, administrativas y físicas, conforme a los principios de licitud, consentimiento, información, calidad, finalidad, lealtad, proporcionalidad y responsabilidad.</p>

            <h2>1. Datos Personales que Recabamos</h2>
            <p>Para cumplir con nuestras obligaciones legales, regulatorias y contractuales, recabamos las siguientes categorías de datos personales:</p>
            <ul>
                <li><strong>Identificación y contacto:</strong> Nombre completo, identificación oficial con fotografía, CURP, RFC, domicilio, teléfono y correo electrónico.</li>
                <li><strong>Laborales y profesionales:</strong> Ocupación, puesto, antigüedad, ingresos y domicilio laboral.</li>
                <li><strong>Migratorios y legales:</strong> En caso de extranjeros, condición de estancia legal en el país.</li>
                <li><strong>Patrimoniales y financieros:</strong> Historial crediticio, cuentas bancarias, ingresos, egresos y declaraciones de bienes.</li>
                <li><strong>Datos fiscales:</strong> Cédula de Identificación Fiscal y declaraciones ante el SAT.</li>
                <li><strong>Información transaccional:</strong> Comportamiento transaccional y operativo con la entidad.</li>
                <li><strong>Información en medios electrónicos:</strong> Datos de navegación, dirección IP y comportamiento en nuestras plataformas digitales.</li>
                <li><strong>Datos biométricos:</strong> Patrón de reconocimiento facial y/o huella dactilar, recabados exclusivamente para verificar la identidad del titular y mitigar el riesgo de suplantación de identidad, en cumplimiento de la normativa aplicable al sector financiero.</li>
                <li><strong>Datos sensibles:</strong> Solo se recabarán aquellos estrictamente necesarios para la relación jurídica, como información sobre estado de salud en seguros asociados al crédito o declaraciones sobre el origen de recursos. Su tratamiento requerirá consentimiento expreso y por escrito, recabado mediante mecanismos físicos o electrónicos conforme a la LFPDPPP.</li>
            </ul>

            <h2>2. Finalidades del Tratamiento</h2>
            <h3>Finalidades Primarias</h3>
            <p>Con fundamento en la LFPDPPP, el artículo 95 Bis de la LGOAAC y las disposiciones PLD/FT, utilizaremos sus datos personales para las siguientes finalidades necesarias:</p>
            <ul>
                <li>Verificar su identidad y validar la autenticidad de la información proporcionada.</li>
                <li>Integrar los expedientes de identificación de clientes y dar cumplimiento regulatorio.</li>
                <li>Cumplir con las obligaciones de Prevención de Lavado de Dinero y Financiamiento al Terrorismo (PLD/FT), incluyendo la identificación del cliente y del Beneficiario Controlador, la validación en listas de sanciones nacionales e internacionales, el monitoreo transaccional y la conservación de expedientes durante el plazo mínimo legal de 10 años.</li>
                <li>Evaluar, originar, estructurar y administrar los productos y servicios financieros solicitados.</li>
                <li>Realizar análisis de riesgo crediticio, viabilidad financiera y capacidad de pago.</li>
                <li>Cumplir con obligaciones fiscales, regulatorias y contractuales ante las autoridades competentes.</li>
                <li>Llevar a cabo procesos de cobranza judicial y extrajudicial derivados de la relación jurídica.</li>
                <li>Permitir el acceso a nuestras instalaciones y mantener sistemas de seguridad (CCTV).</li>
                <li>Atender quejas, aclaraciones, consultas y solicitudes de servicio a través de la UNE o canales de atención.</li>
            </ul>

            <h3>Finalidades Secundarias (Fines No Necesarios)</h3>
            <ul>
                <li>Inteligencia comercial, mercadotecnia, publicidad, promociones, boletines informativos y análisis estadístico.</li>
                <li>Mejora de la experiencia de usuario en medios electrónicos y desarrollo de nuevos productos.</li>
            </ul>
            <p><strong>Mecanismo para manifestar la negativa para finalidades secundarias:</strong> Si no desea que sus datos personales sean tratados para estas finalidades secundarias, puede manifestarlo desde este momento marcando la casilla correspondiente en el formulario aplicable o enviando un correo electrónico a: <a href="mailto:datospersonales@chcapital.mx">datospersonales@chcapital.mx</a>.</p>
            <p><em>&ldquo;No acepto que mis datos personales sean utilizados para finalidades secundarias de mercadotecnia, publicidad o prospección comercial.&rdquo;</em></p>
            <p>La negativa al uso de sus datos para estas finalidades no será motivo para negarle los servicios o productos financieros que solicite o contrate con nosotros.</p>

            <h2>3. Transferencias de Datos Personales</h2>
            <p>CH Capital podrá transferir sus datos personales sin requerir su consentimiento en los supuestos previstos por el artículo 36 de la LFPDPPP, así como en los siguientes casos obligatorios del sector financiero:</p>
            <ul>
                <li><strong>Autoridades financieras y judiciales</strong> (CNBV, CONDUSEF, SAT, UIF, Banco de México y órganos jurisdiccionales): Para cumplir con leyes vigentes, requerimientos oficiales y reportes regulatorios obligatorios.</li>
                <li><strong>Sociedades de Información Crediticia</strong> (Buró / Círculo de Crédito): Para la evaluación de su historial y comportamiento crediticio.</li>
                <li><strong>Sociedades controladoras, subsidiarias, afiliadas</strong> o empresas del mismo grupo empresarial de CH Capital: Con fines de resguardo centralizado de información, auditorías internas y administración de riesgos.</li>
                <li><strong>Proveedores de servicios y asesores externos</strong> (como despachos de cobranza, auditores externos y proveedores de validación tecnológica de identidad o biometría): Únicamente para cumplir con la relación contractual y las obligaciones legales de la SOFOM.</li>
                <li><strong>Cesionarios o adquirentes de derechos de crédito:</strong> En caso de una cesión de cartera o sustitución de acreedor conforme a los contratos celebrados.</li>
            </ul>
            <p>Para cualquier otra transferencia no prevista en los supuestos anteriores, le solicitaremos su consentimiento previo por el medio elegido.</p>

            <h2>4. Medidas de Seguridad</h2>
            <p>CH Capital implementa y mantiene medidas de seguridad administrativas, técnicas y físicas para proteger sus datos personales contra daño, pérdida, alteración, destrucción, uso, acceso o tratamiento no autorizado:</p>
            <ul>
                <li><strong>Administrativas:</strong> Políticas internas de confidencialidad, controles de acceso restringido a la información, contratos de confidencialidad con el personal y capacitación continua en protección de datos.</li>
                <li><strong>Técnicas:</strong> Cifrado de datos en tránsito y almacenamiento, firewalls, sistemas de detección de intrusos y controles robustos de autenticación de usuarios.</li>
                <li><strong>Físicas:</strong> Resguardo seguro bajo llave de expedientes físicos, áreas de archivo con acceso restringido y sistemas de videovigilancia (CCTV).</li>
            </ul>
            <p>Estas medidas cumplen con lo establecido en los artículos 19 y 20 del Reglamento de la LFPDPPP.</p>

            <h2>5. Derechos ARCO y Revocación del Consentimiento</h2>
            <p>Usted tiene derecho a conocer qué datos personales tenemos sobre usted (Acceso), solicitar su corrección si están desactualizados o son inexactos (Rectificación), pedir su eliminación de nuestros registros cuando considere que no se utilizan adecuadamente (Cancelación) u oponerse a su uso para fines específicos (Oposición). Asimismo, podrá limitar el uso o divulgación de sus datos o revocar el consentimiento otorgado.</p>
            <p>Para ejercer cualquiera de estos derechos, deberá enviar una solicitud por escrito al correo electrónico: <a href="mailto:datospersonales@chcapital.mx">datospersonales@chcapital.mx</a>.</p>
            <h3>Requisitos mínimos de la solicitud (Art. 29 de la LFPDPPP)</h3>
            <ol>
                <li>Nombre completo del titular y su domicilio o correo electrónico para comunicarle la respuesta.</li>
                <li>Copia digitalizada de una identificación oficial vigente que acredite su identidad (INE, Pasaporte, Cédula Profesional) o, en su caso, de los documentos que acrediten la representación legal del titular.</li>
                <li>Descripción clara y precisa de los datos personales respecto de los cuales busca ejercer alguno de los derechos ARCO.</li>
                <li>Cualquier otro elemento o documento que facilite la localización de los datos personales.</li>
            </ol>
            <p><strong>Plazos de respuesta:</strong> CH Capital evaluará y responderá la procedencia de su solicitud en un plazo máximo de 20 (veinte) días hábiles contados a partir de su recepción. Si la solicitud procede, se hará efectiva dentro de los 15 (quince) días hábiles siguientes a la fecha en que se comunique la respuesta. Estos plazos podrán ampliarse una sola vez por un periodo igual cuando el caso lo justifique.</p>

            <h2>6. Conservación de Datos</h2>
            <p>Le informamos que, derivado de las obligaciones regulatorias del sector financiero —incluidas las previstas en el artículo 95 bis de la Ley General de Organizaciones y Actividades Auxiliares del Crédito PLD/FT—, CH Capital conservará los expedientes de identificación, contratos y documentación transaccional de sus clientes por un periodo mínimo de 10 años posteriores a la conclusión de la relación jurídica. Durante dicho periodo, por mandato legal, los derechos de Cancelación u Oposición podrán limitarse de manera justificada conforme al artículo 26 de la LFPDPPP.</p>

            <h2>7. Uso de Cookies y Tecnologías de Rastreo</h2>
            <p>Nuestro sitio web <a href="https://www.chcapital.mx" target="_blank" rel="noopener noreferrer">www.chcapital.mx</a> utiliza cookies, web beacons y tecnologías similares para monitorear su comportamiento como usuario de internet, mejorar su experiencia de navegación y ofrecerle productos conforme a sus preferencias.</p>
            <p>Los datos de navegación que pueden recabarse incluyen dirección IP, tipo de navegador, sistema operativo, páginas web visitadas e historial de búsquedas. Estas tecnologías pueden deshabilitarse desde la configuración de su navegador, salvo aquellas estrictamente necesarias para el funcionamiento técnico de la plataforma.</p>

            <h2>8. Modificaciones al Aviso de Privacidad</h2>
            <p>CH Capital se reserva el derecho de modificar, adicionar o actualizar este Aviso de Privacidad en cualquier momento, ya sea para atender cambios legislativos, políticas internas o nuevos requerimientos relacionados con la oferta de nuestros servicios financieros.</p>
            <p>Cualquier cambio sustancial al presente aviso estará disponible para su consulta y será notificado a través de los siguientes medios:</p>
            <ol>
                <li>Publicación proactiva en nuestro sitio web oficial: <a href="https://www.chcapital.mx" target="_blank" rel="noopener noreferrer">www.chcapital.mx</a>.</li>
                <li>Notificación o aviso enviado al último correo electrónico que nos haya proporcionado.</li>
            </ol>',
            'taw-theme'
        );
    }
}
