<?php
namespace App\Infrastructure\Repositories\Contracts;

use App\Models\Reservation;

interface ReservationRepositoryInterface
{
    public function create(array $data): Reservation;
    public function findExpired(): iterable;
}
