<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\PrayerRequest;
use App\Http\Controllers\Controller;

class PrayerRequestController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $query = PrayerRequest::query();
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        $prayerRequests = $query->get();
        return response()->json(['data' => $prayerRequests], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:20',
            'prayer_request' => 'required|string',
        ]);

        try {
            $prayerRequest = PrayerRequest::create([
                'name' => $request->name,
                'contact' => $request->contact,
                'message' => $request->prayer_request,
            ]);

            return response()->json([
                'message' => 'Prayer request submitted successfully',
                'data' => $prayerRequest
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to submit prayer request'
            ], 500);
        }
    }
}
