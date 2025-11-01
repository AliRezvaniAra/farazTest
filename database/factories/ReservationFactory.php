<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reservation;
use App\Models\Room;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition()
    {
        $start = $this->faker->dateTimeBetween('+1 days', '+10 days');
        $end = (clone $start)->modify('+2 days');
        return [
            'room_id' => Room::factory(),
            'user_id' => null,
            'amount' => $this->faker->numberBetween(1,2),
            'start_date' => $start->format('Y-m-d'),
            'end_date' => $end->format('Y-m-d'),
            'expires_at' => now()->addMinutes(2),
            'is_active' => true,
        ];
    }
}
