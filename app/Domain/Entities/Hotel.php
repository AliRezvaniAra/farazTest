<?php
namespace App\Domain\Entities;

class Hotel
{
    public int $id;
    public string $name;
    public ?string $address;

    public function __construct(int $id, string $name, ?string $address = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
    }
}
