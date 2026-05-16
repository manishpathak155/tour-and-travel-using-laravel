<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Manage application settings stored in the database.
 */
class SettingService
{
    /**
     * @var string
     */
    protected string $cacheKey = 'settings.cache';

    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::remember(
            $this->cacheKey,
            now()->addHours(24),
            fn () => Setting::query()->pluck('value', 'key')->toArray()
        );

        return $settings[$key] ?? $default;
    }

    /**
     * Set a setting value by key.
     *
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, mixed $value): void
    {
        Setting::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        $this->flush();
    }

    /**
     * Clear the settings cache.
     */
    public function flush(): void
    {
        Cache::forget($this->cacheKey);
    }
}
