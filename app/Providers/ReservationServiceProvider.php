<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Repositories\EloquentRoomRepository;
use App\Infrastructure\Repositories\EloquentReservationRepository;
use App\Infrastructure\Repositories\Contracts\RoomRepositoryInterface;
use App\Infrastructure\Repositories\Contracts\ReservationRepositoryInterface;
use App\Application\Services\ReservationApplicationService;

class ReservationServiceProvider extends ServiceProvider
{

    public $bindings = [
        RoomRepositoryInterface::class => EloquentRoomRepository::class,
        ReservationRepositoryInterface::class => EloquentReservationRepository::class,
    ];
    public function register(): void
    {
        $this->app->bind(RoomRepositoryInterface::class, EloquentRoomRepository::class);
        $this->app->bind(ReservationRepositoryInterface::class, EloquentReservationRepository::class);

    }

    public function boot()
    {
    }
}
