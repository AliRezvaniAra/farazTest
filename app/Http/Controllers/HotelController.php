<?php
namespace App\Http\Controllers;

use App\Models\Hotel;
use App\utilities\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(): JsonResponse
    {
        $hotels = Hotel::withCount('rooms')->get();
        return Response::json($hotels);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate(['name' => 'required', 'address' => 'nullable']);
        $hotel = Hotel::create($data);
        return Response::json($hotel);
    }
}
