<?php

namespace Hexlet\Code\Parsers\parser;

use function Hexlet\Code\Parsers\Types\json\parseJson;
use function Hexlet\Code\Parsers\Types\yaml\parseYaml;

function parseFile($filePath)
{
    if (!file_exists($filePath)) {
        $filePath = WORKING_DIR . '/' . $filePath;
    }

    $type = pathinfo($filePath, PATHINFO_EXTENSION);
    $fileContent = file_get_contents($filePath);

    return match ($type) {
        'json' => parseJson($fileContent),
        'yaml' => parseYaml($fileContent),
    };
}
