<?php

namespace App\Services;

use Cog\Laravel\Optimus\Facades\Optimus;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Throwable;
//use App\Utilities\StringHelper;

class HashableService
{

    private static array $hashMap;
    private $model;

    /**
     * Gets hashmap array from config.
     * @return array
     */
    public static function hashMap(): array
    {
        if (isset(self::$hashMap)) {
            return self::$hashMap;
        }

        return self::$hashMap = config('optimusRelationships.hashMap');
    }

    /**
     * Encodes value
     *
     * @param string $hashableConnection
     * @param $value
     *
     * @return null|int
     */
    public static function getHash(?int $value, string $hashableConnection): ?int
    {
        if (is_null($value)) {
            return null;
        }

        try {
            $hash = Optimus::connection($hashableConnection);

            return $hash->encode($value);
        } catch (InvalidArgumentException) {
            $hashMap = self::hashMap();
            $hash = Optimus::connection($hashMap[$hashableConnection]);

            return $hash->encode($value);
        }
    }

    /**
     * Returns id from hashed value.
     *
     * @param int|null    $hashId
     * @param string|null $providedHashableConnection
     *
     * @return null|int
     * @throws Exception
     */
    public static function decodeHash(?int $hashId, string $hashableConnection): ?int
    {
        if (is_null($hashId)) {
            return null;
        }

        try {
            $hash = Optimus::connection($hashableConnection);

            return $hash->decode($hashId);
        } catch (Throwable $e) {
            try {
                $hashMap = self::hashMap();
                $hash = Optimus::connection($hashMap[$hashableConnection]);
                return $hash->decode($hashId);
            } catch (Throwable $e) {
                Log::warning('No Hash for Provided Hash Key Found', ['providedHashKey' => $hashableConnection]);
                return $hashId;
            }
        }
    }

    /**
     * TODO Still need to fix the Collection thing. When transforming it into a collection it's no longer a Model instance
     *
     *  $test = $result->map(function ($item) {
     *      return HashableService::decodeHashedCollection(collect($item), 'Transaction');
     *  });
     * @param Collection $array
     * @param string $baseConnection
     * @return Collection
     */
    public static function decodeHashedCollection(Collection $array, string $baseConnection): Collection
    {
        return $array->map(function ($item, $key) use ($baseConnection) {
            if (Str::endsWith($key, '_id'))
                return self::decodeHash($item, str_replace('_', '', ucwords(Str::of($key)->rtrim('_id'), '_')));

            if ($key == 'id') return self::decodeHash($item, $baseConnection);
            return $item;
        });
    }
}
