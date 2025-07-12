<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url;

class Url
{
    public static function create(
        string $scheme,
        string $hostname,
        string $path,
        int $port,
        array $parameters
    ): Url {
        return new static($scheme, $hostname, $path, $port, $parameters);
    }

    /**
     * @param string $scheme
     * @param string $hostname
     * @param string $path
     * @param int $port
     * @param array<string,string|int|float|array> $parameters
     */
    public function __construct(
        private string $scheme,
        private string $hostname,
        private string $path,
        private int $port,
        private array $parameters
    ) {}

    public function scheme(): string
    {
        return $this->scheme;
    }

    public function hostname(): string
    {
        return $this->hostname;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function port(): int
    {
        return $this->port;
    }

    /**
     * @return array<string,string|array>
     */
    public function parameters(): array
    {
        return $this->parameters;
    }
}
