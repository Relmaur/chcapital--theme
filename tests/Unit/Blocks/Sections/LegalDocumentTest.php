<?php

declare(strict_types=1);

namespace TAW\Theme\Tests\Unit\Blocks\Sections;

use TAW\Blocks\Sections\LegalDocument\LegalDocument;
use TAW\Theme\Tests\TestCase;

/**
 * getData() coverage for the Aviso de Privacidad page's LegalDocument block
 * (page-aviso-de-privacidad.php). The block ships the full legal text as a
 * hardcoded fallback so the page reads correctly even before an editor ever
 * opens the metabox — this locks in that every required section survives.
 */
final class LegalDocumentTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->stubBlockConstructor();
        \Brain\Monkey\Functions\when('__')->returnArg(1);
        \Brain\Monkey\Functions\when('get_option')->justReturn('');
    }

    public function test_default_content_includes_every_required_section(): void
    {
        $block = new LegalDocument();
        $data  = $this->callMethod($block, 'getData', false);

        $this->assertArrayHasKey('content', $data);

        foreach ([
            '1. Datos Personales que Recabamos',
            '2. Finalidades del Tratamiento',
            '3. Transferencias de Datos Personales',
            '4. Medidas de Seguridad',
            '5. Derechos ARCO y Revocación del Consentimiento',
            '6. Conservación de Datos',
            '7. Uso de Cookies y Tecnologías de Rastreo',
            '8. Modificaciones al Aviso de Privacidad',
            'datospersonales@chcapital.mx',
        ] as $expected) {
            $this->assertStringContainsString($expected, $data['content']);
        }
    }

    public function test_saved_metabox_value_overrides_the_default_content(): void
    {
        \Brain\Monkey\Functions\when('get_post_meta')->justReturn('<p>Texto editado por un administrador.</p>');

        $block = new LegalDocument();
        $data  = $this->callMethod($block, 'getData', 42);

        $this->assertSame('<p>Texto editado por un administrador.</p>', $data['content']);
    }

    public function test_pdf_url_falls_back_to_the_hosted_pdf_when_no_option_is_set(): void
    {
        $block = new LegalDocument();
        $data  = $this->callMethod($block, 'getData', false);

        $this->assertSame(
            'https://chcapital.mx/wp-content/uploads/2026/09/CH-CAPITAL-Aviso-de-Privacidad-SEPT-2026.pdf',
            $data['pdf_url']
        );
    }

    public function test_pdf_url_uses_the_footer_legal_privacy_option_when_set(): void
    {
        \Brain\Monkey\Functions\when('get_option')->justReturn('https://chcapital.mx/custom-aviso.pdf');

        $block = new LegalDocument();
        $data  = $this->callMethod($block, 'getData', false);

        $this->assertSame('https://chcapital.mx/custom-aviso.pdf', $data['pdf_url']);
    }
}
