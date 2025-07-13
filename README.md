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
* Parser - Raw string url parser

#### Builders

* **HostRelative** - Builds a url relative to the hostname, setup scheme and port

#### Serializers

* **RFC3986** - Serializes url instance to RFC3986 string

## Installation and testing

```bash
# Install package
composer require diffhead/php-url
# Run tests
php vendor/bin/phpunit
```

## Usage example

#### Parsing URL
```php
use Diffhead\PHP\Url\Parser;
use Diffhead\PHP\Url\Exception\UrlNotContainsPort;

$parser = new Parser('ftp://localhost/some/entity?public=1');

/**
 * @var string $scheme
 */
$scheme = $parser->getScheme();

/**
 * @var string $hostname
 */
$hostname = $parser->getHostname();

/**
 * @var int $port
 */
try {
    $port = $parser->getPort();
} catch (UrlNotContainsPort $e) {
    $port = 0;
}

/**
 * @var string $path
 */
$path = $parser->getPath();

/**
 * @var array{public:string}
 */
$query = $parser->getParameters();
```

#### Using with the DI container
```php
use Diffhead\PHP\Url\Builder;
use Diffhead\PHP\Url\Builder\HostRelative;
use Diffhead\PHP\Url\Port;
use Diffhead\PHP\Url\Scheme;
use Diffhead\PHP\Url\Serializer;
use Diffhead\PHP\Url\Serializer\RFC3986;
use GuzzleHttp\Client;

class ApiUrl
{
    public function __construct(
        private Builder $builder,
        private Serializer $serializer
    ) {}

    public function get(string $path, array $query = []): string
    {
        return $this->serializer->serialize(
            $this->builder->build($path, $query)
        );
    }
}

class ApiClient
{
    public function __construct(
        private Client $http,
        private ServiceApiUrl $url
    ) {}

    public function fetchThings(FetchThingsRequest $request): FetchThingsResponse
    {
        $response = $this->http->post(
            $this->url->get('/v1/things'),
            $this->getJsonRequestOptions($request)
        );

        return FetchThingsResponse::fromArray(
            json_decode((string) $response->getBody(), true)
        );
    }

    private function getJsonRequestOptions(Arrayable $request): array
    {
        //
    }
}

/**
 * @var \DI\Container $container
 */
$container->set(ApiUrl::class, function (): ApiUrl {
    $builder = new HostRelative(
        'api.domain.info', 
        Scheme::Http->value, 
        Port::Web->value
    );

    $serializer = new RFC3986();

    return new ApiUrl($builder, $serializer);
});

/**
 * @var \ApiClient $api
 */
$api = $container->get(ApiClient::class);
```

## Objects API

#### Diffhead\PHP\Url\Parser
```php
namespace Diffhead\PHP\Url;

class Parser
{
    public function __construct(string $url);

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

#### Diffhead\PHP\Url\Builder\HostRelative
```php
namespace Diffhead\PHP\Url\Builder;

use Diffhead\PHP\Url\Url;
use Diffhead\PHP\Url\Builder;

class HostRelative implements Builder 
{
    public function __construct(string $hostname, string $scheme, int $port);
    public function build(string $path, array $query = []): Url;
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

#### Diffhead\PHP\Url\Serializer\RFC3986
```php
namespace Diffhead\PHP\Url;

use Diffhead\PHP\Url\Serializer;
use Diffhead\PHP\Url\Url;

class RFC3986 implements Serializer
{
    public function toString(Url $url): string;
}
```

#### Diffhead\PHP\Url\Url
```php
class Url
{
    public function __construct(
        string $scheme, 
        string $hostname, 
        string $path, 
        int $port, 
        array $parameters
    );

    public function scheme(): string;
    public function hostname(): string;
    public function path(): string;
    public function port(): int;
    public function parameters(): array;
}
```
