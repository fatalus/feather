<?php

declare(strict_types=1);

namespace Feather;

class Cache
{
    private const string CACHE_DIR = FEATHER_ROOT . "/cache/";

    public static function ensureCacheDir(): void
    {
        if (!file_exists(self::CACHE_DIR) && !is_dir(self::CACHE_DIR)) {
            mkdir(self::CACHE_DIR, 0777, true);
        }
    }

    public static function cacheData(string $name, string $data): bool
    {
        // ensure the Cache directory actually exists
        self::ensureCacheDir();
        $fp = self::CACHE_DIR . $name . '.cache';

        $result = file_put_contents($fp, $data);
        return (bool) $result === true ? true : false;
    }

    public static function getCacheData(string $name)
    {
        $data = '';
        $fp = self::CACHE_DIR . $name . '.cache';

        if (file_exists($fp) && is_readable($fp)) {
            $data = file_get_contents($fp);
        }

        return $data;
    }
}

