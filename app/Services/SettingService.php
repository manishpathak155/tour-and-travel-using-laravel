<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

/**
 * Manage application settings stored in the database.
 */
class SettingService
{
    /**
     * @var bool|null
     */
    private static ?bool $settingsAvailable = null;

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
        if (! $this->settingsAvailable()) {
            return $default;
        }

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
        if (! $this->settingsAvailable()) {
            return;
        }

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

    /**
     * Determine if the settings table is available, with request-level memoization.
     */
    private function settingsAvailable(): bool
    {
        if (self::$settingsAvailable !== null) {
            return self::$settingsAvailable;
        }

        self::$settingsAvailable = Schema::hasTable('settings')
            && Schema::hasColumn('settings', 'value');

        return self::$settingsAvailable;
    }
}
