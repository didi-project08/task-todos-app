<?php

namespace Database\Factories;

use App\Modules\TaskTodo\Models\UserPosition;
use App\Models\User;
use App\Modules\TaskTodo\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserPositionFactory extends Factory
{
    protected $model = UserPosition::class;

    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'user_id' => User::factory(),
            'position_id' => Position::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function forUser(User $user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }

    public function forPosition(Position $position)
    {
        return $this->state(function (array $attributes) use ($position) {
            return [
                'position_id' => $position->id,
            ];
        });
    }
}