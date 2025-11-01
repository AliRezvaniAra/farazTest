<?php
namespace App\Domain\Entities;

class Room
{
    public int $id;
    public int $hotelId;
    public string $name;
    public int $capacity;

    public function __construct(int $id, int $hotelId, string $name, int $capacity)
    {
        $this->id = $id;
        $this->hotelId = $hotelId;
        $this->name = $name;
        $this->capacity = $capacity;
    }
}
