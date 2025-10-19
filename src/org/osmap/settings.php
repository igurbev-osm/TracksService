<?php
namespace Org\Osmap;

class Settings {
    public static function load(string $path): array {
        if (!file_exists($path)) {
            throw new \RuntimeException("Settings file not found: $path");
        }
        $json = file_get_contents($path);
        return json_decode($json, true);
    }
}
