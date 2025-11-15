<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url\Dto;

class Replace
{
    public function __construct(
        private ?string $scheme = null,
        private ?string $hostname = null,
        private ?string $path = null,
        private ?int $port = null,
        private ?array $parameters = null,
    ) {}

    public function scheme(): ?string
    {
        return $this->scheme;
    }

    public function hostname(): ?string
    {
        return $this->hostname;
    }

    public function path(): ?string
    {
        return $this->path;
    }

    public function port(): ?int
    {
        return $this->port;
    }

    public function parameters(): ?array
    {
        return $this->parameters;
    }
}
