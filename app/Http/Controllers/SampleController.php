<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SampleController extends Controller
{
    /**
     * Return a simple JSON payload for health-check or demo.
     */
    public function index(Request $request): JsonResponse
    {
        $name = $request->query('name');
        return response()->json([
            'message' => $name ? "Hello, $name from Laravel" : 'Hello from Laravel',
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
