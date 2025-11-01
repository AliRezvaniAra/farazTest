<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Room;
use App\Models\Hotel;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition()
    {
        return [
            'hotel_id' => Hotel::factory(),
            'name' => 'Room ' . $this->faker->numberBetween(100, 999),
            'capacity' => $this->faker->numberBetween(1, 10),
        ];
    }
}
