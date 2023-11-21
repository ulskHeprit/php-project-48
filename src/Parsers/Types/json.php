<?php

namespace Hexlet\Code\Parsers\Types\json;

function parseJson($string)
{
    return json_decode($string, true);
}
