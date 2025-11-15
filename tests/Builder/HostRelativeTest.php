<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url\Tests\Builder;

use Diffhead\PHP\Url\Builder\HostRelative;
use Diffhead\PHP\Url\Port;
use Diffhead\PHP\Url\Scheme;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(HostRelative::class)]
#[CoversMethod(HostRelative::class, 'build')]
class HostRelativeTest extends TestCase
{
    public function testUrlBuilding(): void
    {
        $hostname = 'www.google.com';
        $scheme = Scheme::Https;
        $port = Port::WebSecure;
        $path = '/api/users';
        $query = ['active' => true, 'page' => 2, 'perPage' => 100];

        $builder = new HostRelative($hostname, $scheme->value, $port->value);

        $url = $builder->build($path, $query);

        $this->assertSame($hostname, $url->hostname());
        $this->assertSame($scheme->value, $url->scheme());
        $this->assertSame($port->value, $url->port());
        $this->assertSame($path, $url->path());
        $this->assertEquals($query, $url->parameters());
    }
}
