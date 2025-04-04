<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthModel;
use Laravel\Sanctum\HasApiTokens;

class User extends AuthModel
{
    use HasFactory;
    use HasApiTokens;
    use HasUlids;

    protected $table = 'users';

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    protected $appends = [
        'full_name'
    ];

    public function getFullNameAttribute(): string
    {
        return trim(($this->name ?? '') . ' ' . ($this->surname ?? ''));
    }
}
