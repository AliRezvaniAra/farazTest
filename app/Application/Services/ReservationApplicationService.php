<?php
namespace App\Application\Services;

use App\Domain\Events\ReservationCreated;
use App\Infrastructure\Repositories\Contracts\RoomRepositoryInterface;
use App\Infrastructure\Repositories\Contracts\ReservationRepositoryInterface;
use App\Domain\Exceptions\NotEnoughCapacityException;
use App\Domain\Entities\Reservation as DomainReservation;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ReservationApplicationService
{
    public function __construct(
        protected RoomRepositoryInterface $roomRepo,
        protected ReservationRepositoryInterface $reservationRepo
    ){}

    public function reserve(int $roomId, int $amount, int $userId, string $startDate, string $endDate): DomainReservation
    {
        //for prevent lock a room by two or more users in the same time
        $lock = Cache::lock('room_reserve_'.$roomId, 10);

        if (! $lock->get()) {
            throw new \RuntimeException('Could not obtain lock, try again');
        }
        //end here same time prevent

        try {
            return DB::transaction(function () use ($roomId, $amount, $userId, $startDate, $endDate) {
                $room = $this->roomRepo->findForUpdate($roomId);

                if (!$room) {
                    throw new NotEnoughCapacityException('Room not found');
                }

                // compute reserved amount in date range
                $start = Carbon::parse($startDate);
                $end = Carbon::parse($endDate);
                for ($date = $start; $date->lte($end); $date->addDay()) {
                    $reservedAmount = Reservation::where('room_id', $roomId)
                        ->whereDate('start_date', $date)
                        ->sum('amount');
                    $available = $room->capacity - $reservedAmount;
                    if ($available < $amount) {
                        throw new NotEnoughCapacityException('Not enough capacity in selected dates');
                    }
                    $reservedAmount = Reservation::where('room_id', $roomId)
                        ->whereDate('end_date', $date)
                        ->sum('amount');
                    $available = $room->capacity - $reservedAmount;
                    if ($available < $amount) {
                        throw new NotEnoughCapacityException('Not enough capacity in selected dates');
                    }
                }

                $expiresAt = now()->addSeconds(120);

                //is_final_reserve field should add for after final payment situation
                $reservation = $this->reservationRepo->create([
                    'room_id' => $roomId,
                    'user_id' => $userId,
                    'amount' => $amount,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'expires_at' => $expiresAt,
                    'is_active' => true,
                ]);

                $domainReservation = new DomainReservation(
                    $reservation->id,
                    $reservation->room_id,
                    $reservation->user_id,
                    $reservation->amount,
                    $reservation->expires_at,
                    $reservation->start_date,
                    $reservation->end_date
                );


                \App\Jobs\ReleaseReservationJob::dispatch($reservation)->delay($expiresAt);

                return $domainReservation;
            });
        } finally {
            $lock->release();
        }
    }

}
