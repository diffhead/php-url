<?php

namespace Diffhead\PHP\Url\Exception;

use RuntimeException;

class UrlRuntimeException extends RuntimeException
{
    public function __construct(string $url, string $description)
    {
        parent::__construct(sprintf('"%s" %s', $url, $description));
    }
}
