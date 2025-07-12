<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url\Builder;

use Diffhead\PHP\Url\Builder;
use Diffhead\PHP\Url\Url;

class ReplaceAttributes implements Builder
{
    public function __construct(
        private Url $url
    ) {}

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
    public function build(string $hostname = '', array $parameters = []): Url
    {
        $scheme = $parameters['scheme'] ?? $this->url->scheme();
        $hostname = $hostname ?: $this->url->hostname();
        $path = $parameters['path'] ?? $this->url->path();
        $port = $parameters['port'] ?? $this->url->port();
        $params = $parameters['parameters'] ?? $this->url->parameters();

        return Url::create($scheme, $hostname, $path, $port, $params);
    }
}
