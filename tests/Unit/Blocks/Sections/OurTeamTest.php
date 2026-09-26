<?php

declare(strict_types=1);

namespace TAW\Theme\Tests\Unit\Blocks\Sections;

use TAW\Blocks\Sections\OurTeam\OurTeam;
use TAW\Theme\Tests\TestCase;

/**
 * getData() coverage for the Nosotros page's OurTeam block. The featured
 * member is a `group` field, so its values live under
 * `_taw_featured_member_{sub}` keys — this locks in that the block reads
 * them there and only falls back to the hardcoded defaults when the group
 * is empty.
 */
final class OurTeamTest extends TestCase
{
    /** @var array<string, mixed> */
    private array $meta = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->stubBlockConstructor();
        $this->meta = [];
        \Brain\Monkey\Functions\when('__')->returnArg(1);
        \Brain\Monkey\Functions\when('get_post_meta')->alias(
            fn ($id, $key = '', $single = false) => $this->meta[$key] ?? ''
        );
    }

    public function test_featured_member_falls_back_to_defaults_when_the_group_is_empty(): void
    {
        // What an admin save of an untouched group leaves behind.
        $this->meta = [
            '_taw_featured_member_featured_image' => '0',
            '_taw_featured_member_featured_name'  => '',
        ];

        $data = $this->callMethod(new OurTeam(), 'getData', 42);

        $this->assertSame(5510, $data['featured']['featured_image']);
        $this->assertSame('Alfredo Chumacero Flores', $data['featured']['featured_name']);
        $this->assertSame('Director General', $data['featured']['featured_position']);
    }

    public function test_featured_member_reads_the_group_sub_field_keys(): void
    {
        $this->meta = [
            '_taw_featured_member_featured_image'    => '77',
            '_taw_featured_member_featured_name'     => 'Nombre Editado',
            '_taw_featured_member_featured_position' => 'Cargo Editado',
            // Pre-v1.52 bare keys must be ignored.
            '_taw_featured_name'                     => 'Bare Key',
        ];

        $data = $this->callMethod(new OurTeam(), 'getData', 42);

        $this->assertSame(77, $data['featured']['featured_image']);
        $this->assertSame('Nombre Editado', $data['featured']['featured_name']);
        $this->assertSame('Cargo Editado', $data['featured']['featured_position']);
        $this->assertSame('', $data['featured']['featured_bio']);
    }
}
