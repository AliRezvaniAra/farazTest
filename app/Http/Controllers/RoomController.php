<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\utilities\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Hotel $hotel): JsonResponse
    {
        // گرفتن لیست اتاق‌های هتل همراه ظرفیت
        $rooms = $hotel->rooms()->select('id', 'name', 'capacity')->get();

        return Response::json([
            'hotel' => [
                'id' => $hotel->id,
                'name' => $hotel->name,
            ],
            'rooms' => $rooms
        ]);
    }
}
