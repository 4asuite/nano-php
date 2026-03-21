<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Lang – translation manager.
 *
 * Accepts an array ['HEADER_SLOGAN' => 'Welcome']
 * and defines PHP constants.
 *
 * Use the __() function to retrieve translations.
 */
final class Lang
{
    /**
     * @param array<string, string> $translations ['KEY' => 'translation']
     */
    public static function load(array $translations): void
    {
        foreach ($translations as $key => $value) {
            $const = strtoupper((string)$key);
            if (!defined($const)) {
                define($const, (string)$value);
            }
        }
    }

    /**
     * @param mixed ...$args Arguments for sprintf (if the translation contains %s, %d, ...)
     */
    public static function get(string $key, mixed ...$args): string
    {
        $key = strtoupper($key);
        $text = defined($key) ? (string)constant($key) : $key;

        return $args ? sprintf($text, ...$args) : $text;
    }
}