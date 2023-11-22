<?php

namespace Hexlet\Code\Parsers\Types\json;

function parseJson(string $string)
{
    return json_decode($string, true);
}
