<?php

namespace Hexlet\Code\Parsers\parser;

use function Hexlet\Code\Parsers\Types\json\parseJson;
use function Hexlet\Code\Parsers\Types\yaml\parseYaml;

function parseFile(string $filePath)
{
    if (!file_exists($filePath)) {
        /** @phpstan-ignore-next-line */
        $filePath = __DIR__ . '/../../' . $filePath;
    }

    $type = pathinfo($filePath, PATHINFO_EXTENSION);
    $fileContent = file_get_contents($filePath);
    /** @phpstan-ignore-next-line */
    return match ($type) {
        /** @phpstan-ignore-next-line */
        'json' => parseJson($fileContent),
        /** @phpstan-ignore-next-line */
        'yaml' => parseYaml($fileContent),
    };
}
