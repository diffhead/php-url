<?php

namespace Diffhead\PHP\Url;

interface Serializer
{
    public function toString(Url $url): string;
}
