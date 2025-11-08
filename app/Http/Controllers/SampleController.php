<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Sample;

class SampleController extends Controller
{
    /**
     * Health check endpoint (basic).
     */
    public function index(Request $request): JsonResponse
    {
        $name = $request->query('name');

        return response()->json([
            'message' => $name ? "Hello, $name from Laravel" : 'Hello from Laravel',
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    /**
     * ✅ Insert a demo document into MongoDB
     */
    public function insert(Request $request): JsonResponse
    {
        $sample = Sample::create([
            'title' => $request->input('title', 'Test Document'),
            'content' => $request->input('content', 'This is stored in MongoDB!'),
            'created_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $sample,
        ]);
    }

    /**
     * ✅ Fetch all documents from MongoDB collection
     */
    public function all(): JsonResponse
    {
        $samples = Sample::all();

        return response()->json([
            'count' => $samples->count(),
            'data' => $samples,
        ]);
    }
}
