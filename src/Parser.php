<?php

namespace Diffhead\PHP\Url;

use Diffhead\PHP\Url\Exception\UrlNotContainsHostname;
use Diffhead\PHP\Url\Exception\UrlNotContainsPath;
use Diffhead\PHP\Url\Exception\UrlNotContainsPort;
use Diffhead\PHP\Url\Exception\UrlNotContainsQuery;
use Diffhead\PHP\Url\Exception\UrlNotContainsScheme;

class Parser
{
    private string $url;
    private ?string $scheme = null;
    private ?string $hostname = null;
    private ?int $port = null;
    private ?string $path = null;
    private ?array $parameters = null;

    public function __construct(string $url)
    {
        $this->url = urldecode($url);
    }

    /**
     * @return string
     *
     * @throws \Diffhead\PHP\Url\Exception\UrlNotContainsScheme
     */
    public function getScheme(): string
    {
        if (is_null($this->scheme)) {
            if (! preg_match(Regex::Scheme->value, $this->url, $matches)) {
                throw new UrlNotContainsScheme($this->url);
            }

            $this->scheme = strtolower($matches[1]);
        }

        return $this->scheme;
    }

    /**
     * @return string
     *
     * @throws \Diffhead\PHP\Url\Exception\UrlNotContainsHostname
     */
    public function getHostname(): string
    {
        if (is_null($this->hostname)) {
            $matched = preg_match(Regex::Hostname->value, $this->url, $matches);

            switch (true) {
                case $matched === false:
                case empty($matches[1]):
                case str_starts_with($this->url, sprintf('%s://', $matches[1])):
                    $this->throwUrlNotContainsHostname();
            }

            $this->hostname = $matches[1];
        }

        return $this->hostname;
    }

    /**
     * @return int
     *
     * @throws \Diffhead\PHP\Url\Exception\UrlNotContainsPort
     */
    public function getPort(): int
    {
        if (is_null($this->port)) {
            $matched = preg_match(
                Regex::Port->value,
                $this->url,
                $matches,
                PREG_UNMATCHED_AS_NULL
            );

            if (! $matched) {
                throw new UrlNotContainsPort($this->url);
            }

            $this->port = (int) $matches[2];
        }

        return $this->port;
    }

    /**
     * @return string
     *
     * @throws \Diffhead\PHP\Url\Exception\UrlNotContainsPath
     */
    public function getPath(): string
    {
        if (is_null($this->path)) {
            if (! preg_match(Regex::Path->value, $this->url, $matches)) {
                $this->throwUrlNotContainsPath();
            }

            if (empty($matches[1])) {
                $this->throwUrlNotContainsPath();
            }

            $this->path = $matches[1];
        }

        return $this->path;
    }

    /**
     * @return array<string,string>
     *
     * @throws \Diffhead\PHP\Url\Exception\UrlNotContainsQuery
     */
    public function getParameters(): array
    {
        if (is_null($this->parameters)) {
            if (! preg_match(Regex::Query->value, $this->url, $matches)) {
                throw new UrlNotContainsQuery($this->url);
            }

            /**
             * @var array<int,string> $parameters
             */
            $parametersRaw = explode('&', $matches[1]);
            $parameters = [];

            foreach ($parametersRaw as $parameter) {
                [$key, $value] = explode('=', $parameter);

                if ($this->isNestedKey($key)) {
                    $keys = $this->splitNestedKey($key);

                    $this->setNestedValue($keys, $value, $parameters);
                } else {
                    $this->setFlatValue($key, $value, $parameters);
                }
            }

            $this->parameters = $parameters;
        }

        return $this->parameters;
    }

    private function isNestedKey(string $key): bool
    {
        return is_numeric(strpos($key, '['));
    }

    private function splitNestedKey(string $nestedKey): array
    {
        preg_match_all(Regex::QueryArrayKeys->value, $nestedKey, $matches);

        return array_map(fn (string $key) => $key, $matches[1]);
    }

    /**
     * @param array<int,string> $keys
     * @param string $value
     * @param array<string|int,string|array> $parameters
     *
     * @return void
     */
    private function setNestedValue(array $keys, string $value, array &$parameters): void
    {
        $current = array_shift($keys);

        if (! empty($keys)) {
            $temporary = [];

            $this->setNestedValue($keys, $value, $temporary);

            $persisted = $parameters[$current] ?? [];
            $parameters[$current] = array_merge($persisted, $temporary);
        } else if (empty($current)) {
            $parameters[] = $value;
        } else {
            $parameters[$current] = $value;
        }
    }

    private function setFlatValue(string $key, string $value, array &$parameters): void
    {
        $parameters[$key] = $value;
    }

    private function throwUrlNotContainsHostname(): void
    {
        throw new UrlNotContainsHostname($this->url);
    }

    private function throwUrlNotContainsPath(): void
    {
        throw new UrlNotContainsPath($this->url);
    }
}
