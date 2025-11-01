<?php
namespace App\Domain\Entities;

use Carbon\Carbon;

class Reservation
{
    public int $id;
    public int $roomId;
    public int $userId;
    public int $amount;
    public Carbon $expiresAt;
    public string $startDate;
    public string $endDate;

    public function __construct(int $id, int $roomId, int $userId, int $amount, Carbon $expiresAt, string $startDate = '', string $endDate = '')
    {
        $this->id = $id;
        $this->roomId = $roomId;
        $this->userId = $userId;
        $this->amount = $amount;
        $this->expiresAt = $expiresAt;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
}
