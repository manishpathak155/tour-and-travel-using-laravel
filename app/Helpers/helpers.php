<?php

use App\Services\SettingService;

if (! function_exists('setting')) {
    /**
     * Resolve a setting value from the database.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return app(SettingService::class)->get($key, $default);
    }
}
