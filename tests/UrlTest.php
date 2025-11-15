<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url\Tests;

use Diffhead\PHP\Url\Port;
use Diffhead\PHP\Url\Scheme;
use Diffhead\PHP\Url\Url;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Url::class)]
#[CoversMethod(Url::class, 'scheme')]
#[CoversMethod(Url::class, 'hostname')]
#[CoversMethod(Url::class, 'path')]
#[CoversMethod(Url::class, 'port')]
#[CoversMethod(Url::class, 'parameters')]
class UrlTest extends TestCase
{
    public function testInitialization(): void
    {
        $url = new Url(
            Scheme::FileTransferOverSsh->value,
            'file.storage.info',
            '/home/user/Downloads',
            Port::FileTransferOverSsh->value,
            ['file' => 'something.txt']
        );

        $this->assertSame(Scheme::FileTransferOverSsh->value, $url->scheme());
        $this->assertSame('file.storage.info', $url->hostname());
        $this->assertSame('/home/user/Downloads', $url->path());
        $this->assertSame(Port::FileTransferOverSsh->value, $url->port());
        $this->assertEquals(['file' => 'something.txt'], $url->parameters());
    }

    public function testStaticInitialization(): void
    {
        $url = Url::create(
            Scheme::WebSocketSecure->value,
            'localhost',
            '/api/endpoint',
            Port::WebSecure->value,
            ['token' => 'token1234']
        );

        $this->assertSame(Scheme::WebSocketSecure->value, $url->scheme());
        $this->assertSame('localhost', $url->hostname());
        $this->assertSame('/api/endpoint', $url->path());
        $this->assertSame(Port::WebSecure->value, $url->port());
        $this->assertEquals(['token' => 'token1234'], $url->parameters());
    }
}
