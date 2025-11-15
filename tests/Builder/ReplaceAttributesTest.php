<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url\Tests\Builder;

use Diffhead\PHP\Url\Builder\ReplaceAttributes;
use Diffhead\PHP\Url\Url;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;
use TypeError;

#[CoversClass(ReplaceAttributes::class)]
#[CoversMethod(ReplaceAttributes::class, 'build')]
class ReplaceAttributesTest extends TestCase
{
    public function testReplacementOnEmptyData(): void
    {
        $origin = Url::create('http', 'example.com', '/path', 80, ['a' => '1']);

        $builder = new ReplaceAttributes($origin);

        $replaced = $builder->build();

        $this->assertSame('http', $replaced->scheme());
        $this->assertSame('example.com', $replaced->hostname());
        $this->assertSame('/path', $replaced->path());
        $this->assertSame(80, $replaced->port());
        $this->assertSame(['a' => '1'], $replaced->parameters());
    }

    public function testPartiallyReplacement(): void
    {
        $origin = Url::create('http', 'example.com', '/path', 80, ['a' => '1']);

        $builder = new ReplaceAttributes($origin);

        $replaced = $builder->build('new-example.com', [
            'scheme' => 'https',
            'port' => 443,
        ]);

        $this->assertSame('https', $replaced->scheme());
        $this->assertSame('new-example.com', $replaced->hostname());
        $this->assertSame('/path', $replaced->path());
        $this->assertSame(443, $replaced->port());
        $this->assertSame(['a' => '1'], $replaced->parameters());
    }

    public function testFullReplacement(): void
    {
        $origin = Url::create('http', 'example.com', '/path', 80, ['a' => '1']);

        $builder = new ReplaceAttributes($origin);

        $replaced = $builder->build('new-example.com', [
            'scheme' => 'https',
            'path' => '/new-path',
            'port' => 443,
            'parameters' => ['b' => '2'],
        ]);

        $this->assertSame('https', $replaced->scheme());
        $this->assertSame('new-example.com', $replaced->hostname());
        $this->assertSame('/new-path', $replaced->path());
        $this->assertSame(443, $replaced->port());
        $this->assertSame(['b' => '2'], $replaced->parameters());
    }

    public function testInvalidParametersTypes(): void
    {
        $this->expectException(TypeError::class);

        $origin = Url::create('http', 'example.com', '/path', 80, ['a' => '1']);

        $builder = new ReplaceAttributes($origin);

        $builder->build('new-example.com', [
            'scheme' => 123,
        ]);
    }
}
