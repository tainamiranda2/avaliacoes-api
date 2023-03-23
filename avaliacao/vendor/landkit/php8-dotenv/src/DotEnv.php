<?php

namespace LandKit\DotEnv;

class DotEnv
{
    /**
     * @param string $dir
     * @return bool
     */
    public static function load(string $dir): bool
    {
        if (!$dir || !file_exists("{$dir}/.env") || is_dir("{$dir}/.env")) {
            return false;
        }

        foreach (file("{$dir}/.env") as $line) {
            $line = trim($line);

            if (!$line || str_starts_with($line, '#')) {
                continue;
            }

            putenv($line);
        }

        return true;
    }
}
