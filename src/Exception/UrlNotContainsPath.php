<?php

namespace Diffhead\PHP\Url\Exception;

class UrlNotContainsPath extends UrlRuntimeException
{
    public function __construct(string $url)
    {
        parent::__construct($url, 'not contains path');
    }
}
