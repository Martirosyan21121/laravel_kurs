<?php

namespace App\Models;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    public static function findByUserId($userId)
    {
        return static::where('tokenable_id', $userId)
            ->where('tokenable_type', 'App\\Models\\User')
            ->first();
    }
}
