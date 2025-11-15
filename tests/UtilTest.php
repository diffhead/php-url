<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url\Tests;

use Diffhead\PHP\Url\Port;
use Diffhead\PHP\Url\Scheme;
use Diffhead\PHP\Url\Url;
use Diffhead\PHP\Url\Util;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Util::class)]
#[CoversMethod(Util::class, 'isDefaultHttpUrl')]
#[CoversMethod(Util::class, 'isDefaultWebSocketUrl')]
class UtilTest extends TestCase
{
    public function testHttpHttpsWithDefaultPortsTesting(): void
    {
        $httpWith80Port = new Url(
            Scheme::Http->value,
            'localhost',
            '/',
            Port::Web->value,
            []
        );

        $httpsWith443Port = new Url(
            Scheme::Https->value,
            'localhost',
            '/',
            Port::WebSecure->value,
            []
        );

        $this->assertTrue(Util::isDefaultHttpUrl($httpWith80Port));
        $this->assertTrue(Util::isDefaultHttpUrl($httpsWith443Port));
    }

    public function testHttpHttpsWithNonDefaultPortsTesting(): void
    {

        $httpWith443Port = new Url(
            Scheme::Http->value,
            'localhost',
            '/',
            Port::WebSecure->value,
            []
        );

        $httpsWith80Port = new Url(
            Scheme::Https->value,
            'localhost',
            '/',
            Port::Web->value,
            []
        );

        $this->assertFalse(Util::isDefaultHttpUrl($httpWith443Port));
        $this->assertFalse(Util::isDefaultHttpUrl($httpsWith80Port));
    }

    public function testWebSocketWithDefaultPortsTesting(): void
    {
        $webSocketWith80Port = new Url(
            Scheme::WebSocket->value,
            'localhost',
            '/',
            Port::Web->value,
            []
        );

        $webSocketSecureWith443Port = new Url(
            Scheme::WebSocketSecure->value,
            'localhost',
            '/',
            Port::WebSecure->value,
            []
        );

        $this->assertTrue(Util::isDefaultWebSocketUrl($webSocketWith80Port));
        $this->assertTrue(Util::isDefaultWebSocketUrl($webSocketSecureWith443Port));
    }

    public function testWebSocketWithNonDefaultPortsTesting(): void
    {
        $webSocketWith443Port = new Url(
            Scheme::WebSocket->value,
            'localhost',
            '/',
            Port::WebSecure->value,
            []
        );

        $webSocketSecureWith80Port = new Url(
            Scheme::WebSocketSecure->value,
            'localhost',
            '/',
            Port::Web->value,
            []
        );

        $this->assertFalse(Util::isDefaultWebSocketUrl($webSocketWith443Port));
        $this->assertFalse(Util::isDefaultWebSocketUrl($webSocketSecureWith80Port));
    }
}
