<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Room;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReservationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_reserve_room()
    {
        $room = Room::factory()->create(['capacity' => 5]);

        $response = $this->postJson('/api/reserve', [
            'room_id' => $room->id,
            'amount' => 2,
            'start_date' => now()->addDays(1)->toDateString(),
            'end_date' => now()->addDays(3)->toDateString(),
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('reservations', [
            'room_id' => $room->id,
            'user_id' =>0,
            'amount' => 2,
        ]);

        $room->refresh();
    }

    public function test_reserve_fails_if_capacity_taken_in_date_range()
    {

        $room = Room::factory()->create(['capacity' => 5]);

        Reservation::factory()->create([
            'room_id' => $room->id,
            'amount' => 3,
            'start_date' => '2025-01-10',
            'end_date' => '2025-01-15',
        ]);

        $response = $this->postJson('/api/reserve', [
            'room_id' => $room->id,
            'amount' => 3,
            'start_date' => '2025-01-12',
            'end_date' => '2025-01-14',
        ]);

        $response->assertStatus(422);
    }
}
