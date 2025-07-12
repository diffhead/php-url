<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url\Tests\Serializer;

use Diffhead\PHP\Url\Port;
use Diffhead\PHP\Url\Scheme;
use Diffhead\PHP\Url\Serializer\RFC3986;
use Diffhead\PHP\Url\Url;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(RFC3986::class)]
#[CoversMethod(RFC3986::class, 'toString')]
class RFC3986Test extends TestCase
{
    public function testSerializeHttpUrlWithDefaultPort(): void
    {
        $url = new Url(
            Scheme::Http->value,
            'localhost',
            '/api/endpoint',
            Port::Web->value,
            [
                'isActive' => true,
                'page' => 1,
                'perPage' => 100
            ]
        );

        $this->assertSame(
            'http://localhost/api/endpoint?isActive=1&page=1&perPage=100',
            $this->getSerializer()->toString($url)
        );
    }

    public function serializeHttpUrlWithNonDefaultPort(): void
    {
        $url = new Url(
            Scheme::Http->value,
            'localhost',
            '/api/endpoint',
            Port::WebSecure->value,
            [
                'isActive' => true,
                'page' => 1,
                'perPage' => 100
            ]
        );

        $this->assertSame(
            'http://localhost:443/api/endpoint?isActive=1&page=1&perPage=100',
            $this->getSerializer()->toString($url)
        );
    }

    public function serializeHttpsUrlWithDefaultPort(): void
    {
        $url = new Url(
            Scheme::Https->value,
            'localhost',
            '/api/endpoint',
            Port::WebSecure->value,
            [
                'isActive' => true,
                'page' => 1,
                'perPage' => 100
            ]
        );

        $this->assertSame(
            'https://localhost/api/endpoint?isActive=1&page=1&perPage=100',
            $this->getSerializer()->toString($url)
        );
    }

    public function serializeHttpsUrlWithNonDefaultPort(): void
    {
        $url = new Url(
            Scheme::Https->value,
            'localhost',
            '/api/endpoint',
            Port::MySql->value,
            [
                'isActive' => true,
                'page' => 1,
                'perPage' => 100
            ]
        );

        $this->assertSame(
            'https://localhost:3306/api/endpoint?isActive=1&page=1&perPage=100',
            $this->getSerializer()->toString($url)
        );
    }

    public function testSerializeWebSocketUrlWithDefaultPort(): void
    {
        $url = new Url(
            Scheme::WebSocket->value,
            'localhost',
            '/api/endpoint',
            Port::Web->value,
            [
                'isActive' => true,
                'page' => 1,
                'perPage' => 100
            ]
        );

        $this->assertSame(
            'ws://localhost/api/endpoint?isActive=1&page=1&perPage=100',
            $this->getSerializer()->toString($url)
        );
    }

    public function serializeWebSocketUrlWithNonDefaultPort(): void
    {
        $url = new Url(
            Scheme::Http->value,
            'localhost',
            '/api/endpoint',
            Port::WebSecure->value,
            [
                'isActive' => true,
                'page' => 1,
                'perPage' => 100
            ]
        );

        $this->assertSame(
            'ws://localhost:443/api/endpoint?isActive=1&page=1&perPage=100',
            $this->getSerializer()->toString($url)
        );
    }

    public function serializeWebSocketSecureUrlWithDefaultPort(): void
    {
        $url = new Url(
            Scheme::WebSocketSecure->value,
            'localhost',
            '/api/endpoint',
            Port::WebSecure->value,
            [
                'isActive' => true,
                'page' => 1,
                'perPage' => 100
            ]
        );

        $this->assertSame(
            'wss://localhost/api/endpoint?isActive=1&page=1&perPage=100',
            $this->getSerializer()->toString($url)
        );
    }

    public function serializeWebSocketSecureUrlWithNonDefaultPort(): void
    {
        $url = new Url(
            Scheme::WebSocketSecure->value,
            'localhost',
            '/api/endpoint',
            Port::Web->value,
            [
                'isActive' => true,
                'page' => 1,
                'perPage' => 100
            ]
        );

        $this->assertSame(
            'wss://localhost:80/api/endpoint?isActive=1&page=1&perPage=100',
            $this->getSerializer()->toString($url)
        );
    }

    private function getSerializer(): RFC3986
    {
        return new RFC3986();
    }
}
