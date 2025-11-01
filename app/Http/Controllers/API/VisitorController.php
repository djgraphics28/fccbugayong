<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisitorController extends Controller
{
    /**
     * Display a listing of visitors.
     */
    public function index(): JsonResponse
    {
        try {
            $visitors = Visitor::whereDate('created_at', today())->get();
            return response()->json(['data' => $visitors], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch visitors'], 500);
        }
    }

    /**
     * Store a newly created visitor.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'ext_name' => 'nullable|string|max:10',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $visitor = Visitor::create($validator->validated());
            return response()->json([
                'message' => 'Visitor created successfully',
                'data' => $visitor
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create visitor'
            ], 500);
        }
    }

    /**
     * Update the specified visitor.
     */
    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:visitors,id',
            'first_name' => 'sometimes|required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'ext_name' => 'nullable|string|max:10',
            'birth_date' => 'sometimes|required|date',
            'address' => 'sometimes|required|string',
            'contact_number' => 'sometimes|required|string|max:20',
            'invited_by' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $validated = $validator->validated();
            $id = $validated['id'];
            unset($validated['id']);

            $visitor = Visitor::findOrFail($id);
            $visitor->update($validated);

            return response()->json([
                'message' => 'Visitor updated successfully',
                'data' => $visitor
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update visitor'
            ], 500);
        }
    }
}
