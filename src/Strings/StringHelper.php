<?php

namespace Dpeuscher\Util\Strings;

/**
 * @category  util
 * @copyright Copyright (c) 2018 Dominik Peuscher
 */
class StringHelper
{
    public static function trim(string $text, int $limit): string
    {
        if (strlen($text) > $limit) {
            return substr($text, 0, $limit - 3) . '...';
        }
        return $text;
    }

    public static function shortenNameToFirst(string $name): string
    {
        if (preg_match('/^([a-zA-Z0-9]+)(?:\s+[a-zA-Z0-9]+)*\s+([a-zA-Z0-9])[a-zA-Z0-9]*$/', $name, $matches)) {
            return $matches[1] . ' ' . $matches[2];
        }
        return $name;
    }
}
