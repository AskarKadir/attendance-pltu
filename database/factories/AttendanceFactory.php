<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'    => User::inRandomOrder()->first()->id,
            'status'     => Arr::random(['hadir', 'sakit', 'izin', 'absen']),
            'created_at' => Carbon::now()->month(8)->hour(rand(7, 8))->minute(rand(0, 59))->second(rand(0, 59)),
        ];
    }
}