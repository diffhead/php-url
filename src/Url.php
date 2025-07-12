<?php

declare(strict_types=1);

namespace Diffhead\PHP\Url;

class Url
{
    private string $scheme;
    private string $hostname;
    private string $path;
    private int $port;

    /**
     * @var array<string,string|int|float|bool>
     */
    private array $parameters;

    public static function create(
        string $scheme,
        string $hostname,
        string $path,
        int $port,
        array $parameters
    ): Url {
        return new static($scheme, $hostname, $path, $port, $parameters);
    }

    public function __construct(string $scheme, string $hostname, string $path, int $port, array $parameters)
    {
        $this->scheme = $scheme;
        $this->hostname = $hostname;
        $this->path = $path;
        $this->port = $port;
        $this->parameters = $parameters;
    }

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
