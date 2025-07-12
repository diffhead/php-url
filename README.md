# PHP Url
## Description

A simple library for interact with the
url using object-oriented style. 

It helps you to build and parse urls. 
Nice to using as part of api client classes.

This library requires PHP 8.2 and newer.

## Components

* Builder - URL instance builder
* Serializer - URL instance serializer
* Url - URL instance representation
* Util - Inner utilities

#### Builders

* **HostRelative** - Build url relative hostname, setup scheme and port

#### Serializers

* **RFC3986** - Serializes url instance to RFC3986 string

## Usage example

#### Building OOP API client url
```php
use Diffhead\PHP\Url\Builder;
use Diffhead\PHP\Url\Serializer;

class Url
{
    private Builder $url;
    private Serializer $serializer;

    public function __construct(Builder $builder, Serializer $serializer)
    {
        $this->builder = $builder;
        $this->serializer = $serializer;
    }

    public function get(string $path, array $query = []): string
    {
        return $this->serializer->serialize(
            $this->builder->build($path, $query)
        );
    }
}
```

## Objects API

#### Diffhead\PHP\Url\Parser
```php
namespace Diffhead\PHP\Url;

class Parser
{
    /**
     * @return string
     *
     * @throws \Diffhead\PHP\Url\Exception\UrlNotContainsScheme
     */
    public function getScheme(): string;

    /**
     * @return string
     *
     * @throws \Diffhead\PHP\Url\Exception\UrlNotContainsHostname
     */
    public function getHostname(): string;

    /**
     * @return int
     *
     * @throws \Diffhead\PHP\Url\Exception\UrlNotContainsPort
     */
    public function getPort(): int;

    /**
     * @return string
     *
     * @throws \Diffhead\PHP\Url\Exception\UrlNotContainsPath
     */
    public function getPath(): string;

    /**
     * @return array<string,string>
     *
     * @throws \Diffhead\PHP\Url\Exception\UrlNotContainsQuery
     */
    public function getParameters(): array;
}
```

#### Diffhead\PHP\Url\Builder
```php
namespace Diffhead\PHP\Url;

use Diffhead\PHP\Url\Url;

interface Builder
{
    public function build(string $resource, array $parameters = []): Url;
}
```

#### Diffhead\PHP\Url\Serializer
```php
namespace Diffhead\PHP\Url;

use Diffhead\PHP\Url\Url;

interface Serializer
{
    public function toString(Url $url): string;
}
```
