<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url\Tests\Dto;

use Diffhead\PHP\Url\Dto\Replace;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Replace::class)]
#[CoversMethod(Replace::class, 'scheme')]
#[CoversMethod(Replace::class, 'hostname')]
#[CoversMethod(Replace::class, 'path')]
#[CoversMethod(Replace::class, 'port')]
#[CoversMethod(Replace::class, 'parameters')]
class ReplaceTest extends TestCase
{
    public function testReplaceDtoProperlyInitializes(): void
    {
        $replace = new Replace(
            scheme: 'https',
            hostname: 'example.com',
            path: '/path',
            port: 443,
            parameters: ['param' => 'value'],
        );

        $this->assertSame('https', $replace->scheme());
        $this->assertSame('example.com', $replace->hostname());
        $this->assertSame('/path', $replace->path());
        $this->assertSame(443, $replace->port());
        $this->assertSame(['param' => 'value'], $replace->parameters());
    }
}
