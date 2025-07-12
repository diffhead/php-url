<?php

namespace Diffhead\PHP\Url;

interface Builder
{
    public function build(string $resource, array $parameters = []): Url;
}
