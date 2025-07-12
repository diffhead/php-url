# Objects API

#### Diffhead\PHP\Url\Facade
```php
class Facade
{
    public static function parse(string $url): Url;
    public static function toRfc3986String(Url $url): string;
    public static function replace(Url $url, Replace $replacements): Url;
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

#### Diffhead\PHP\Url\Builder\ReplaceAttributes
```php
namespace Diffhead\PHP\Url\Builder;

use Diffhead\PHP\Url\Url;
use Diffhead\PHP\Url\Builder;

class ReplaceAttributes implements Builder 
{
    public function __construct(Url $url);

    /**
     * Pass the hostname and/or another params
     * to replace it in the URL instance.
     *
     * Empty hostname argument means
     * it will not be replaced.
     *
     * @param string $hostname
     * @param array{scheme?:string,port?:int,path?:string,parameters?:array} $parameters
     */
    public function build(string $hostname = '', array $parameters = []): Url;
}
```

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
