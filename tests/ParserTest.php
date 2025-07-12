<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url\Tests;

use Diffhead\PHP\Url\Exception\UrlNotContainsHostname;
use Diffhead\PHP\Url\Exception\UrlNotContainsPath;
use Diffhead\PHP\Url\Exception\UrlNotContainsPort;
use Diffhead\PHP\Url\Exception\UrlNotContainsQuery;
use Diffhead\PHP\Url\Exception\UrlNotContainsScheme;
use Diffhead\PHP\Url\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[CoversMethod(Parser::class, 'getScheme')]
#[CoversMethod(Parser::class, 'getHostname')]
#[CoversMethod(Parser::class, 'getPath')]
#[CoversMethod(Parser::class, 'getPort')]
#[CoversMethod(Parser::class, 'getParameters')]
class ParserTest extends TestCase
{
    public function testExistingSchemeParsing(): void
    {
        $this->assertSame('http', $this->getParser('http://example.info')->getScheme());
        $this->assertSame('https', $this->getParser('https://example.info')->getScheme());
    }

    public function testEmptySchemeParsing(): void
    {
        $this->expectException(UrlNotContainsScheme::class);
        $this->getParser('example.info')->getScheme();
    }

    public function testExistingHostnameParsing(): void
    {
        $this->assertSame('example.info', $this->getParser('example.info')->getHostname());
        $this->assertSame('example.info', $this->getParser('https://example.info')->getHostname());
    }

    public function testEmptyHostnameParsing(): void
    {
        $this->expectException(UrlNotContainsHostname::class);
        $this->getParser('https:///api/webhooks/event')->getHostname();
    }

    public function testExistingPortParsing(): void
    {
        $this->assertSame(80, $this->getParser('localhost:80')->getPort());
        $this->assertSame(443, $this->getParser('https://google.com:443/index')->getPort());
    }

    public function testEmptyPortParsing(): void
    {
        $this->expectException(UrlNotContainsPort::class);
        $this->getParser('localhost')->getPort();
    }

    public function testExistingPathParsing(): void
    {
        $this->assertSame('/', $this->getParser('https://google.com/')->getPath());
        $this->assertSame('/api/endpoint', $this->getParser('https://something.org/api/endpoint')->getPath());
        $this->assertSame('/api/endpoint', $this->getParser('something.org:1234/api/endpoint')->getPath());
    }

    public function testEmptyPathParsing(): void
    {
        $this->expectException(UrlNotContainsPath::class);
        $this->getParser('https://google.com')->getPath();
    }

    public function testExistingFlatParametersParsing(): void
    {
        $url = 'https://example.com?parameter=value&secondParameter=secondValue&a=100';
        $parser = $this->getParser($url);

        $urlParameters = [
            'parameter' => 'value',
            'secondParameter' => 'secondValue',
            'a' => '100'
        ];

        $this->assertEquals($urlParameters, $parser->getParameters());
    }

    public function testExistingNestedParametersParsing(): void
    {
        $url = 'https://example.com/search?query=book&filters%5Bprice%5D%5Bmin%5D=10&filters%5Bprice%5D%5Bmax%5D=100&filters%5Bcategories%5D%5B%5D=fiction&filters%5Bcategories%5D%5B%5D=history';
        $parser = $this->getParser($url);

        $urlParameters = [
            'query' => 'book',
            'price' => [
                'min' => '10',
                'max' => '100'
            ],
            'categories' => [
                'fiction',
                'history'
            ]
        ];

        $this->assertEquals($urlParameters, $parser->getParameters());
    }

    public function testNonExistingParametersParsing(): void
    {
        $this->expectException(UrlNotContainsQuery::class);
        $this->getParser('https://google.com')->getParameters();
    }

    private function getParser(string $url): Parser
    {
        return new Parser($url);
    }
}
