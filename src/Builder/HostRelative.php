<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url\Builder;

use Diffhead\PHP\Url\Builder;
use Diffhead\PHP\Url\Url;

class HostRelative implements Builder
{
    private string $hostname;
    private string $scheme;
    private int $port;

    public function __construct(string $hostname, string $scheme = '', int $port = 0)
    {
        $this->hostname = $hostname;
        $this->scheme = $scheme;
        $this->port = $port;
    }

    public function build(string $path, array $parameters = []): Url
    {
        return new Url(
            $this->scheme,
            $this->hostname,
            $path,
            $this->port,
            $parameters
        );
    }
}
