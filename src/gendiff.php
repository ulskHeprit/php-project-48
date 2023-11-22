<?php

namespace Differ\Differ;

use function Hexlet\Code\Formatters\plain\formatPlain;
use function Hexlet\Code\Formatters\stylish\formatStylish;

function gendiff($arr1, $arr2, $format)
{
    $diff = getDiff($arr1, $arr2);

    $string = match ($format) {
        'stylish' => formatStylish($diff),
        'plain'   => formatPlain($diff),
        'json'    => json_encode($diff, JSON_PRETTY_PRINT),
    };

    return $string;
}

function getDiff($arr1, $arr2)
{
    $uniq = array_unique(array_merge(array_keys($arr1), array_keys($arr2)));
    sort($uniq);
    $keys = array_fill_keys($uniq, '');

    foreach ($keys as $key => $_v) {
        $keyExists1 = array_key_exists($key, $arr1);
        $keyExists2 = array_key_exists($key, $arr2);

        if (
            $keyExists1
            && $keyExists2
            && $arr1[$key] === $arr2[$key]
        ) {
            $keys[$key] = [
                'type'     => 'not changed',
                'oldValue' => $arr1[$key],
            ];
        } elseif (
            $keyExists1
            && $keyExists2
        ) {
            if (is_array($arr1[$key]) && is_array($arr2[$key])) {
                $keys[$key] = [
                    'type'  => 'changed',
                    'value' => getDiff($arr1[$key], $arr2[$key]),
                ];
            } else {
                $keys[$key] = [
                    'type'     => 'changed',
                    'oldValue' => $arr1[$key],
                    'newValue' => $arr2[$key],
                ];
            }
        } elseif ($keyExists1) {
            $keys[$key] = [
                'type'     => 'deleted',
                'oldValue' => $arr1[$key],
            ];
        } else {
            $keys[$key] = [
                'type'     => 'added',
                'newValue' => $arr2[$key],
            ];
        }
    }

    return $keys;
}
