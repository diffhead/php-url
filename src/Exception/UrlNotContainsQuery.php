<?php

namespace Diffhead\PHP\Url\Exception;

class UrlNotContainsQuery extends UrlRuntimeException
{
    public function __construct(string $url)
    {
        parent::__construct($url, 'not contains query');
    }
}
