<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Sample;
use Throwable;
use MongoDB\Client;
class SampleController extends Controller
{
    /** Shared MongoDB client and database name */
    private ?Client $mongoClient = null;
    private string $DB_NAME = 'Sample';

    public function __construct()
    {
        $dsn = (string) config('database.connections.mongodb.dsn');
        $this->DB_NAME = (string) config('database.connections.mongodb.database', 'Sample');

        if (extension_loaded('mongodb') && !empty($dsn)) {
            $this->mongoClient = new Client($dsn);
        }
    }
    /**
     * Health check endpoint (basic).
     */
    public function index(HttpRequest $request): JsonResponse
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
    public function insert(HttpRequest $request): JsonResponse
    {
        $doc = [
            'title' => $request->input('title', 'Test Document'),
            'content' => $request->input('content', 'This is stored in MongoDB!'),
            'created_at' => now()->toIso8601String(),
        ];

        try {
            // Use shared client if available
            if ($this->mongoClient instanceof Client) {
                // Native driver path using DSN
                $result = $this->mongoClient
                    ->selectDatabase($this->DB_NAME)
                    ->selectCollection('samples')
                    ->insertOne($doc);

                $insertedId = method_exists($result, 'getInsertedId') ? (string) $result->getInsertedId() : null;
                if ($insertedId) {
                    $doc['_id'] = $insertedId;
                }
            } else {
                // Fallback to Jenssegers Eloquent path if DSN not present
                $created = Sample::create([
                    'title' => $doc['title'],
                    'content' => $doc['content'],
                    'created_at' => now(),
                ]);
                if (method_exists($created, 'getAttributes')) {
                    $doc = $created->getAttributes();
                }
                
            }

            return response()->json([
                'status' => 'success',
                'data' => $doc,
                'meta' => [
                    'persisted' => true,
                    'storage' => 'mongodb',
                ],
            ], 201);
        } catch (Throwable $e) {
            // Graceful degraded response when storage is unavailable
            return response()->json([
                'status' => 'success',
                'data' => $doc,
                'meta' => [
                    'persisted' => false,
                    'storage' => 'mongodb',
                    'error' => 'storage_unavailable',
                ],
            ], 200);
        }
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
