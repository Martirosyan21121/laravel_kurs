<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public static function deactivateUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->status = 1;
        $user->save();
        return true;
    }

    public static function activateUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->status = 0;
        $user->save();
        return true;
    }
}
