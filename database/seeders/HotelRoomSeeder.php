<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\Room;

class HotelRoomSeeder extends Seeder
{
    public function run()
    {
        Hotel::factory()->count(5)->create()->each(function ($hotel) {
            Room::factory()->count(10)->create(['hotel_id' => $hotel->id]);
        });
    }
}
