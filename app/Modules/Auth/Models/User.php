<?php

namespace App\Modules\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(\App\Modules\TaskTodo\Models\Task::class, 'user_id');
    }

    public function userPositions(): HasMany
    {
        return $this->hasMany(\App\Modules\TaskTodo\Models\UserPosition::class, 'user_id');
    }

    public function positions()
    {
        return $this->hasManyThrough(
            \App\Modules\TaskTodo\Models\Position::class,
            \App\Modules\TaskTodo\Models\UserPosition::class,
            'user_id',
            'id',
            'id',
            'position_id'
        );
    }
}