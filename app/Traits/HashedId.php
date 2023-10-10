<?php

namespace App\Traits;

use App\Services\HashableService;

trait HashedId
{
    public function getIdAttribute($value)
    {
        return HashableService::getHash($value, $this->hashConnection());
    }

    public function hashConnection()
    {
        return HashableService::hashMap()[class_basename($this)] ?? 'main';
    }

    public function decodeHash($value)
    {
        return HashableService::decodeHash($value, $this->hashConnection());
    }

    public function hashedId(): ?int
    {
        return HashableService::getHash($this->getKey(), $this->hashConnection());
    }
}
