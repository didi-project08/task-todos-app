<?php

namespace Database\Factories;

use App\Modules\TaskTodo\Models\Position;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PositionFactory extends Factory
{
    protected $model = Position::class;

    public function definition()
    {
        return [
            'id' => Str::uuid(),
            'name' => $this->faker->unique()->jobTitle(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}