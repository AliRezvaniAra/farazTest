<?php
namespace App\Infrastructure\Repositories;

use App\Infrastructure\Repositories\Contracts\RoomRepositoryInterface;
use App\Models\Room;

class EloquentRoomRepository implements RoomRepositoryInterface
{
    public function findForUpdate(int $id): ?Room
    {
        return Room::where('id', $id)->lockForUpdate()->first();
    }

//    public function decrementCapacity(int $id, int $amount): void
//    {
//        Room::where('id', $id)->decrement('capacity', $amount);
//    }
}
