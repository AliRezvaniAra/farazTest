<?php
namespace App\Infrastructure\Repositories;

use App\Infrastructure\Repositories\Contracts\ReservationRepositoryInterface;
use App\Models\Reservation;

class EloquentReservationRepository implements ReservationRepositoryInterface
{
    public function create(array $data): Reservation
    {
        return Reservation::create($data);
    }

    public function findExpired(): iterable
    {
        return Reservation::where('is_active', true)
            ->where('expires_at', '<', now())
            ->get();
    }
}
