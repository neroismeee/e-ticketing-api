<?php

namespace App\Services;

use App\Models\SystemConfiguration;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class SystemConfigurationService
{
    private const CACHE_TTL = 3600;
    private const CACHE_PREFIX = 'sys_config:';

    public function store(array $data): SystemConfiguration
    {
        $config = SystemConfiguration::create([
            'config_key' => $data['config_key'],
            'config_value' => $data['config_value'],
            'description' => $data['description'],
            'updated_by' => Auth::id(),
        ]);

        $this->putCache($config->config_key, $config->config_value);

        return $config->load('updater');
    }

    public function update(SystemConfiguration $config, array $data): SystemConfiguration
    {
        $config->update([
            'config_value' => $data['config_value'],
            'description' => $data['description'],
            'updated_by' => Auth::id()
        ]);

        $this->putCache($config->config_key, $data['config_value']);

        return $config->load('updater');
    }

    public function upsert(string $key, mixed $value, ?string $description = null): SystemConfiguration
    {
        $config = SystemConfiguration::updateOrCreate(
            ['config_key' => $key],
            [
                'config_value' => $value,
                'description' => $description,
                'updated_by' => Auth::id(),
                'updated_at' => now()
            ]
        );

        $this->putCache($config->config_key, $config->config_value);

        return $config->load('updater');
    }

    public function delete(SystemConfiguration $config): void
    {
        $this->forgetCache($config->config_key);

        $config->delete();
    }

    //* Query
    public function getAll(string $search = '', int $perPage = 15): LengthAwarePaginator
    {
        return SystemConfiguration::query()
            ->with('updater:id,name,username')
            ->when(
                ! empty($search),
                fn($q) => $q->where('config_key', 'like', '%' .  $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
            )
            ->orderBy('config_key')
            ->paginate(min($perPage, 50));
    }

    public function getValue(string $key): SystemConfiguration
    {
        $config = SystemConfiguration::where('config_key', $key)
            ->with('updater:id,name,username')
            ->first();

        if (! $config) {
            throw ValidationException::withMessages([
                'config_key' => ["Configuration key '{$key}' not found."]
            ]);
        }

        return $config;
    }

    public function getCachedValue(string $key, mixed $default = null): mixed
    {
        $cacheKey = self::CACHE_PREFIX . $key;

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($key, $default) {
            $config = SystemConfiguration::where('config_key', $key)->first();
            return $config ? $config->config_value : $default;
        });
    }

    public function getMany(array $keys): Collection
    {
        return SystemConfiguration::whereIn('config_key', $keys)
            ->get()
            ->mapWithKeys(fn($config) => [
                $config->config_key => $config->config_value
            ]);
    }

    public function clearCache(): void
    {
        $keys = SystemConfiguration::pluck('config_key');

        foreach ($keys as $key) {
            $this->forgetCache($key);
        }
    }

    // Private - cache helpers
    private function putCache(string $key, mixed $value): void
    {
        Cache::put(self::CACHE_PREFIX . $key, $value, self::CACHE_TTL);
    }

    private function forgetCache(string $key): void
    {
        Cache::forget(self::CACHE_PREFIX . $key);
    }
}
