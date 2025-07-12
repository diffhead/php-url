<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url;

class Util
{
    public static function isDefaultHttpUrl(Url $url): bool
    {
        return static::httpWithoutTls($url)
            || static::httpWithTls($url);
    }

    public static function isDefaultWebSocketUrl(Url $url): bool
    {
        return static::webSocketWithoutTls($url)
            || static::webSocketWithTls($url);
    }

    private static function httpWithoutTls(Url $url): bool
    {
        return $url->scheme() === Scheme::Http->value
            && static::webOrEmptyPort($url);
    }

    private static function httpWithTls(Url $url): bool
    {
        return $url->scheme() === Scheme::Https->value
            && static::webSecureOrEmptyPort($url);
    }

    private static function webSocketWithoutTls(Url $url): bool
    {
        return $url->scheme() === Scheme::WebSocket->value
            && static::webOrEmptyPort($url);
    }

    private static function webSocketWithTls(Url $url): bool
    {
        return $url->scheme() === Scheme::WebSocketSecure->value
            && static::webSecureOrEmptyPort($url);
    }

    private static function webOrEmptyPort(Url $url): bool
    {
        return $url->port() === Port::Web->value || empty($url->port());
    }

    private static function webSecureOrEmptyPort(Url $url): bool
    {
        return $url->port() === Port::WebSecure->value || empty($url->port());
    }
}
