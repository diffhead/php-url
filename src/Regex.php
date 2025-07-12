<?php

namespace Diffhead\PHP\Url;

enum Regex: string
{
    case Scheme = '/^(\w+):\/\//';
    case Hostname = '/^(?:[a-z]+:\/\/)?(?:www\.)?([^\/:\s]+)/';
    case Port = '/^(\w+:\/\/){0,1}[\w\d]+[\w\d\.-_]{0,}?:?(\d+)[\/]?/';
    case Path = '/^(?:[a-z][a-z0-9+\-.]*:\/\/)?[^\/\?#]+(?:\:\d+)?(\/[^?\#]*)?/';
    case Query = '/\?(.*?)?(?=#|$)/';
    case QueryArrayKeys = '/\[([^\]]*)\]/';
}
