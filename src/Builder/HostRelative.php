<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url\Builder;

use Diffhead\PHP\Url\Builder;
use Diffhead\PHP\Url\Url;

class HostRelative implements Builder
{
    public function __construct(
        private string $hostname,
        private string $scheme = '',
        private int $port = 0
    ) {}

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
