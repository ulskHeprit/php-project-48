<?php

namespace Hexlet\Code\Formatters\stylish;

function formatStylish(array $diff, int $depth = 0)
{
    $lines = ['{'];
    /** @phpstan-ignore-next-line */
    $depth++;
    /** @phpstan-ignore-next-line */
    foreach ($diff as $key => $data) {
        $type = $data['type'] ?? null;

        switch ($type) {
            case 'not changed':
                $value = $data['oldValue'];
                if (is_array($value)) {
                    /** @phpstan-ignore-next-line */
                    $value = formatStylish($value, $depth);
                }
                /** @phpstan-ignore-next-line */
                $lines[] = sprintf("%s%s: %s", str_repeat(' ', $depth * 4), $key, toString($value));
                break;
            case 'changed':
                if (array_key_exists('value', $data)) {
                    $value = $data['value'];
                    if (is_array($value)) {
                        /** @phpstan-ignore-next-line */
                        $value = formatStylish($value, $depth);
                    }
                    /** @phpstan-ignore-next-line */
                    $lines[] = sprintf("%s%s: %s", str_repeat(' ', $depth * 4), $key, toString($value));
                } else {
                    $oldValue = $data['oldValue'];
                    $newValue = $data['newValue'];

                    if (is_array($oldValue)) {
                        /** @phpstan-ignore-next-line */
                        $oldValue = formatStylish($oldValue, $depth);
                    }
                    if (is_array($newValue)) {
                        /** @phpstan-ignore-next-line */
                        $newValue = formatStylish($newValue, $depth);
                    }
                    /** @phpstan-ignore-next-line */
                    $lines[] = sprintf("%s- %s: %s", str_repeat(' ', $depth * 4 - 2), $key, toString($oldValue));
                    /** @phpstan-ignore-next-line */
                    $lines[] = sprintf("%s+ %s: %s", str_repeat(' ', $depth * 4 - 2), $key, toString($newValue));
                }
                break;
            case 'deleted':
                $value = $data['oldValue'];
                if (is_array($value)) {
                    /** @phpstan-ignore-next-line */
                    $value = formatStylish($value, $depth);
                }
                /** @phpstan-ignore-next-line */
                $lines[] = sprintf("%s- %s: %s", str_repeat(' ', $depth * 4 - 2), $key, toString($value));
                break;
            case 'added':
                $value = $data['newValue'];
                if (is_array($value)) {
                    /** @phpstan-ignore-next-line */
                    $value = formatStylish($value, $depth);
                }
                /** @phpstan-ignore-next-line */
                $lines[] = sprintf("%s+ %s: %s", str_repeat(' ', $depth * 4 - 2), $key, toString($value));
                break;
            default:
                $value = $data;

                if (is_array($value)) {
                    /** @phpstan-ignore-next-line */
                    $value = formatStylish($value, $depth);
                }
                /** @phpstan-ignore-next-line */
                $lines[] = sprintf("%s%s: %s", str_repeat(' ', $depth * 4), $key, toString($value));
        }
    }
    /** @phpstan-ignore-next-line */
    $lines[] = sprintf('%s}', str_repeat(' ', ($depth - 1) * 4));

    return implode(PHP_EOL, $lines);
}

function toString(mixed $value)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_null($value)) {
        return 'null';
    }

    return $value;
}
