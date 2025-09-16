<?php

namespace Database\Factories;

use App\Modules\TaskTodo\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $endDate = Carbon::parse($startDate)->addDays($this->faker->numberBetween(1, 30));

        return [
            'id' => Str::uuid(),
            'user_id' => User::factory(),
            'todo' => $this->faker->sentence(6),
            'start_date' => $startDate,
            'end_date' => $endDate,
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

    public function withDates($startDate, $endDate)
    {
        return $this->state(function (array $attributes) use ($startDate, $endDate) {
            return [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ];
        });
    }

    public function upcoming()
    {
        return $this->state(function (array $attributes) {
            return [
                'start_date' => now()->addDays(1),
                'end_date' => now()->addDays(10),
            ];
        });
    }

    public function ongoing()
    {
        return $this->state(function (array $attributes) {
            return [
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(5),
            ];
        });
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'start_date' => now()->subDays(10),
                'end_date' => now()->subDays(1),
            ];
        });
    }
}