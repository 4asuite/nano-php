<?php
function loadEnvAndDefineConstants(string $path): bool
{
    $envFile = $path . '/.env';
    $ENV_TREE = [];

    if (!file_exists($envFile) || !is_readable($envFile)) {
        trigger_error("Error: .env file not found or not readable at: " . $envFile, E_USER_WARNING);
        return false;
    }

    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        trigger_error("Error: Failed to read the contents of the .env file.", E_USER_WARNING);
        return false;
    }

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

        [$rawKey, $rawValue] = explode('=', $line, 2);
        $key = trim($rawKey);
        $value = trim($rawValue);

        if (strlen($value) > 1 && in_array($value[0], ['"', "'"]) && $value[0] === $value[strlen($value) - 1]) {
            $value = substr($value, 1, -1);
        }

        $segments = explode('.', $key);
        $ref = &$ENV_TREE;
        foreach ($segments as $i => $segment) {
            if ($i === count($segments) - 1) {
                $ref[$segment] = $value;
            } else {
                if (!isset($ref[$segment]) || !is_array($ref[$segment])) {
                    $ref[$segment] = [];
                }
                $ref = &$ref[$segment];
            }
        }
    }

    // Define constants for each root node
    foreach ($ENV_TREE as $constName => $constValue) {
        if (!defined($constName)) {
            define($constName, $constValue);
        }
    }

    return true;
}
