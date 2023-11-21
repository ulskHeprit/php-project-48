<?php

namespace Hexlet\Code\Parsers\Types\yaml;

use Symfony\Component\Yaml\Yaml;

function parseYaml($string)
{
    return Yaml::parse($string);//, Yaml::PARSE_OBJECT_FOR_MAP);
}
