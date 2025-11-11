<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url;

use Closure;
use Diffhead\PHP\Url\Exception\UrlRuntimeException;
use Diffhead\PHP\Url\Serializer\RFC3986;

class Facade
{
    public static function parse(string $url): Url
    {
        $parser = new Parser($url);

        return new Url(
            self::valueOrDefault(fn () => $parser->getScheme(), ''),
            self::valueOrDefault(fn () => $parser->getHostname(), ''),
            self::valueOrDefault(fn () => $parser->getPath(), ''),
            self::valueOrDefault(fn () => $parser->getPort(), 0),
            self::valueOrDefault(fn () => $parser->getParameters(), []),
        );
    }

    public static function toRfc3986String(Url $url): string
    {
        $serializer = new RFC3986();
        return $serializer->toString($url);
    }

    /**
     * @param Closure():mixed $getter
     * @param mixed $default
     *
     * @return mixed
     */
    private static function valueOrDefault(Closure $getter, mixed $default = null): mixed
    {
        try {
            return $getter();
        } catch (UrlRuntimeException $exception) {
            return $default;
        }
    }
}
