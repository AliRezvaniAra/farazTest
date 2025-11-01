<?php
namespace App\Jobs;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ReleaseReservationJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels,Dispatchable;

    public Reservation $reservationModel;

    public function __construct(Reservation $reservation)
    {
        $this->reservationModel = $reservation;
    }

    public function handle(): void
    {
        DB::transaction(function () {
            //@todo here should add condition if final_reserve not active if is active still must be is_active be true
            $reservation = Reservation::lockForUpdate()->find($this->reservationModel->id);
            if (!$reservation || !$reservation->is_active) return;
            $reservation->is_active = false;
            $reservation->save();
        });
    }
}
