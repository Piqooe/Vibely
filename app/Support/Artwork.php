<?php

namespace App\Support;

class Artwork
{
    public const PALETTES = [
        'blue' => ['#0B2E6B', '#00BFFF'],
        'red' => ['#5B1430', '#FF6B6B'],
        'amber' => ['#B4400C', '#F7B32B'],
        'violet' => ['#1E1B4B', '#8B5CF6'],
        'green' => ['#053B30', '#10B981'],
        'pink' => ['#3B0D4F', '#EC4899'],
        'teal' => ['#0F4C5C', '#22D3EE'],
        'rose' => ['#1F2433', '#F43F5E'],
        'lime' => ['#2F4A12', '#A3E635'],
        'orange' => ['#6B2210', '#FB923C'],
        'indigo' => ['#2A2766', '#60A5FA'],
        'fuchsia' => ['#5B1660', '#E879F9'],
    ];

    public const PATTERNS = ['orb', 'bands', 'rings', 'horizon'];

    public static function resolve(array|object|null $art, string $seed = ''): array
    {
        $art = (array) ($art ?? []);
        $hash = crc32($seed ?: 'vibely');
        $names = array_keys(self::PALETTES);

        $pattern = $art['pattern'] ?? self::PATTERNS[$hash % count(self::PATTERNS)];
        $palette = $art['palette'] ?? $names[intdiv($hash, 7) % count($names)];
        [$dark, $accent] = self::PALETTES[$palette] ?? self::PALETTES['blue'];

        return compact('pattern', 'dark', 'accent');
    }
}
