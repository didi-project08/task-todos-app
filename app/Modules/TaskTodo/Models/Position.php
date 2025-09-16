<?php

namespace App\Modules\TaskTodo\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'positions';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'id' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function userPositions(): HasMany
    {
        return $this->hasMany(UserPosition::class, 'position_id');
    }

    public function users()
    {
        return $this->hasManyThrough(
            \App\Models\User::class,
            UserPosition::class,
            'position_id',
            'id',
            'id',
            'user_id'
        );
    }
}