<?php

namespace App\Http\Controllers;

use App\utilities\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Application\Services\ReservationApplicationService;

class ReservationController extends Controller
{
    public function store(Request $request, ReservationApplicationService $service): JsonResponse
    {

        $data = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'amount' => 'required|integer|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $userId = auth()->id() ?? $request->user_id ?? 0;

        $reservation = $service->reserve($data['room_id'], $data['amount'], $userId, $data['start_date'], $data['end_date']);
        //@todo payment logics should add here (using payment repository should be here)
        return Response::json([
            'message' => 'Reserved',
            'reservation' => $reservation
        ]);
    }
}
