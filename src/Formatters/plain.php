<?php

namespace Hexlet\Code\Formatters\plain;

function formatPlain(array $diff, array $keys = [])
{
    /** @phpstan-ignore-next-line */
    foreach ($diff as $key => $data) {
        $name = implode('.', [...$keys, $key]);
        $type = $data['type'] ?? null;

        switch ($type) {
            case 'changed':
                if (array_key_exists('value', $data)) {
                    $value = $data['value'];
                    if (is_array($value)) {
                        /** @phpstan-ignore-next-line */
                        $value = formatPlain($value, [...$keys, $key]);
                    }
                    /** @phpstan-ignore-next-line */
                    $lines[] = $value;
                } else {
                    $oldValue = $data['oldValue'];
                    $newValue = $data['newValue'];
                    /** @phpstan-ignore-next-line */
                    $lines[] = sprintf(
                        "Property '%s' was updated. From %s to %s",
                        $name,
                        toString($oldValue),
                        toString($newValue)
                    );
                }
                break;
            case 'deleted':
                /** @phpstan-ignore-next-line */
                $lines[] = sprintf("Property '%s' was removed", $name);
                break;
            case 'added':
                $value = $data['newValue'];
                /** @phpstan-ignore-next-line */
                $lines[] = sprintf("Property '%s' was added with value: %s", $name, toString($value));
                break;
        }
    }
    /** @phpstan-ignore-next-line */
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
    if (is_string($value)) {
        return "'$value'";
    }
    if (is_array($value)) {
        return '[complex value]';
    }

    return $value;
}
