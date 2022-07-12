<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();
        return BookingResource::collection($bookings);
    }

    public function store(BookingRequest $request, Room $room)
    {
        $validated = $request->validated();
        // $available_volume = $room->blocks()->available()->sum('volume');

        // $validated = $request->validate([
        //     'days' => 'required|numeric|gte:1|lte:24',
        //     'volume' => 'required|numeric|gte:1|lte:10',
        // ]);

        $booking = $room->bookings()->create([
            'days' => $validated['days'],
            'volume' => $validated['volume'],
            'user_id' => 1,
            'location_id' => $room->location_id,
        ]);


        $volume = $booking->volume;
        $reserved_blocks = $room->blocks()->available()->take(ceil($volume / 2))->update(['booking_id' => $booking->id]);

        if ($room->blocks()->available()->count() <= 0) {
            $room->update([
                'is_available' => false,
            ]);
        }

        return new BookingResource($booking);

    }
}
