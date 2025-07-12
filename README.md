# PHP Url
## Description

A simple library for interacting with URLs using an object-oriented approach.

Provides tools to build, modify, and parse URLs.
Can be used in API client classes or in dependency injection contexts.

Requires PHP 8.2 or higher.

* [Objects API](./docs/OBJECTS.md)

## Components

* **Builder** - URL instance builder
* **Facade** - Facade simplify usage
* **Parser** - Raw string url parser
* **Serializer** - URL instance serializer
* **Url** - URL instance representation
* **Util** - Inner utilities

#### Builders

* **HostRelative** - Builds a url relative to the hostname, setup scheme and port
* **ReplaceAttributes** - Builds new url instance with passed params replacement

#### Serializers

* **RFC3986** - Serializes url instance to RFC3986 string

## Installation

```bash
composer require diffhead/php-url
composer test
```

## Usage

```php
use Diffhead\PHP\Url\Facade;
use Diffhead\PHP\Url\Dto\Replace;

/**
 * @var \Diffhead\PHP\Url\Url $url
 */
$url = Facade::parse('www.google.com');

/**
 * @var string
 */
$string = Facade::toRfc3986String($url);

/**
 * Parameters are optionally.
 * If null passed then will not
 * be replaced.
 */
$dto = new Replace(
    scheme: 'https',
    hostname: 'www.github.com',
    port: 443,
    path: '/',
    parameters: []
);

/** 
 * @var \Diffhead\PHP\Url\Url $replaced
 */
$replaced = Facade::replace($url, $dto);
```

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

class Url
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

class Client
{
    public function __construct(
        private Client $http,
        private Url $url
    ) {}

    public function items(FetchItemsRequest $request): FetchItemsResponse
    {
        $response = $this->http->post(
            $this->url->get('/v1/things'),
            $this->getJsonRequestOptions($request)
        );

        return FetchItemsResponse::fromArray(
            json_decode((string) $response->getBody(), true)
        );
    }
}

/**
 * @var \DI\Container $container
 */
$container->set(Url::class, function (): Url {
    $domain = getenv('API_DOMAIN');
    $scheme = Scheme::Https->value;
    $port = Port::WebSecure->value;

    $builder = new HostRelative($domain, $scheme, $port);
    $serializer = new RFC3986();

    return new Url($builder, $serializer);
});


$container->get(Client::class);
```
