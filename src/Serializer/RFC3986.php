<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url\Serializer;

use Diffhead\PHP\Url\Serializer;
use Diffhead\PHP\Url\Url;
use Diffhead\PHP\Url\Util;

class RFC3986 implements Serializer
{
    public function toString(Url $url): string
    {
        return sprintf(
            '%s://%s%s%s',
            $url->scheme(),
            $this->getHost($url),
            $this->getPath($url),
            $this->getQueryString($url)
        );
    }

    private function getHost(Url $url): string
    {
        switch (true) {
            /**
             * If http protocol with 80 port
             * or https protocol with 443 port
             */
            case Util::isDefaultHttpUrl($url):
            /**
             * If ws protocol with 80 port
             * or wss protocol with 443 port
             */
            case Util::isDefaultWebSocketUrl($url):
                return $url->hostname();

            default:
                return sprintf('%s:%d', $url->hostname(), $url->port());
        }
    }

    private function getPath(Url $url): string
    {
        $pathIsEmpty = empty($url->path());
        $pathStartsWithSlash = str_starts_with($url->path(), '/');

        if ($pathIsEmpty || $pathStartsWithSlash) {
            return $url->path();
        }

        return sprintf('/%s', $url->path());
    }

    private function getQueryString(Url $url): string
    {
        if ($parameters = $url->parameters()) {
            return '?' . http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);
        }

        return '';
    }
}
