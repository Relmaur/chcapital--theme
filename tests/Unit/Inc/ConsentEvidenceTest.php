<?php

declare(strict_types=1);

namespace TAW\Theme\Tests\Unit\Inc;

use Brain\Monkey\Functions;
use TAW\Theme\Tests\TestCase;

/**
 * Regression coverage for chcapital_record_consent_evidence(): a prior
 * compliance memo (reports/consentimiento-chcapital-2026-09-14.html) told
 * CH Capital's legal counsel that the literal checkbox wording shown to each
 * submitter is snapshotted per submission — but the function never actually
 * did that; it only stored a manually-maintained version/hash code. This
 * suite locks in the fix: the exact label text passed in by the caller must
 * be persisted verbatim, independent of whatever OptionsPage's version/hash
 * fields currently hold.
 */
final class ConsentEvidenceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        require_once __DIR__ . '/../../../inc/consent-log.php';

        Functions\when('wp_generate_uuid4')->justReturn('11111111-1111-1111-1111-111111111111');
        Functions\when('get_option')->justReturn('');
    }

    public function test_stores_the_exact_text_passed_in_verbatim(): void
    {
        $captured = [];
        Functions\when('update_post_meta')->alias(function (int $postId, string $key, mixed $value) use (&$captured) {
            $captured[$key] = $value;
            return true;
        });

        chcapital_record_consent_evidence(
            ['privacy_consent' => '1', 'marketing_consent' => '0'],
            42,
            'Texto exacto de la casilla de privacidad tal como se mostró hoy.',
            'Texto exacto de la casilla de marketing tal como se mostró hoy.'
        );

        $this->assertSame(
            'Texto exacto de la casilla de privacidad tal como se mostró hoy.',
            $captured['_taw_consent_text_primary']
        );
        $this->assertSame(
            'Texto exacto de la casilla de marketing tal como se mostró hoy.',
            $captured['_taw_consent_text_marketing']
        );
    }

    public function test_does_nothing_without_a_post_id(): void
    {
        $called = false;
        Functions\when('update_post_meta')->alias(function () use (&$called) {
            $called = true;
            return true;
        });

        chcapital_record_consent_evidence(
            ['privacy_consent' => '1'],
            false,
            'Some text',
            'Other text'
        );

        $this->assertFalse($called);
    }
}
