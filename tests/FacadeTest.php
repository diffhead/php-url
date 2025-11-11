<?php

declare(strict_types=1);

namespace Diffhead\PHP\Tests;

use Diffhead\PHP\Url\Facade;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Facade::class)]
#[CoversMethod(Facade::class, 'parse')]
#[CoversMethod(Facade::class, 'toRfc3986String')]
class FacadeTest extends TestCase
{
    public function testParsingOnEmptyString(): void
    {
        $url = Facade::parse('');

        $this->assertSame('', $url->scheme());
        $this->assertSame('', $url->hostname());
        $this->assertSame('', $url->path());
        $this->assertSame(0, $url->port());
        $this->assertSame([], $url->parameters());
    }

    public function testParsingOnProperlyWebUrl(): void
    {
        $url = Facade::parse('https://example.com:8080/path/to/resource?param1=value1&param2=value2');

        $this->assertSame('https', $url->scheme());
        $this->assertSame('example.com', $url->hostname());
        $this->assertSame('/path/to/resource', $url->path());
        $this->assertSame(8080, $url->port());
        $this->assertSame(['param1' => 'value1', 'param2' => 'value2'], $url->parameters());
    }

    public function testParsingOnDsn(): void
    {
        $url = Facade::parse('mysql://user:password@localhost:3306/database_name');

        $this->assertSame('mysql', $url->scheme());
        $this->assertSame('localhost', $url->hostname());
        $this->assertSame('/database_name', $url->path());
        $this->assertSame(3306, $url->port());
        $this->assertSame([], $url->parameters());
    }

    public function testStringConversionToRfc3986(): void
    {
        $originUrl = 'https://example.com:8080/path/to/resource?param1=value1&param2=value2';
        $url = Facade::parse($originUrl);
        $convertedUrl = Facade::toRfc3986String($url);

        $this->assertSame($originUrl, $convertedUrl);
    }
}
