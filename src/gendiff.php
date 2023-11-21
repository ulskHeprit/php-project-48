<?php

namespace Hexlet\Code\gendiff;

function gendiff($arr1, $arr2)
{
    $lines = ['{'];
    $uniq = array_unique(array_merge(array_keys($arr1), array_keys($arr2)));
    sort($uniq);
    $keys = array_fill_keys($uniq, '');

    foreach ($keys as $key => $_v) {
        $keyExists1 = array_key_exists($key, $arr1);
        $keyExists2 = array_key_exists($key, $arr2);
        $value1 = null;
        $value2 = null;

        if (
            $keyExists1
            && $keyExists2
            && $arr1[$key] === $arr2[$key]
        ) {
            $keys[$key] = 'not changed';
            $value1 = $arr1[$key];
        } elseif (
            $keyExists1
            && $keyExists2
        ) {
            $keys[$key] = 'changed';
            $value1 = $arr1[$key];
            $value2 = $arr2[$key];
        } elseif ($keyExists1) {
            $keys[$key] = 'deleted';
            $value1 = $arr1[$key];
        } else {
            $keys[$key] = 'added';
            $value2 = $arr2[$key];
        }

        if (is_bool($value1)) {
            $value1 = $value1 ? 'true' : 'false';
        }
        if (is_bool($value2)) {
            $value2 = $value2 ? 'true' : 'false';
        }

        switch ($keys[$key]) {
            case 'not changed':
                $lines[] = sprintf("    %s: %s", $key, $value1);
                break;
            case 'changed':
                $lines[] = sprintf("  - %s: %s", $key, $value1);
                $lines[] = sprintf("  + %s: %s", $key, $value2);
                break;
            case 'deleted':
                $lines[] = sprintf("  - %s: %s", $key, $value1);
                break;
            case 'added':
                $lines[] = sprintf("  + %s: %s", $key, $value2);
                break;
        }
    }

    $lines[] = '}';

    return implode(PHP_EOL, $lines);
}
