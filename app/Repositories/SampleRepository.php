<?php

namespace App\Repositories;

use App\Models\Sample;
use Throwable;
use Illuminate\Support\Facades\Log;
use MongoDB\Client;

class SampleRepository
{
    /**
     * Insert a new Sample document.
     *
     * @param array $data
     * @return Sample
     */
    public function insert(array $data): Sample
    {
        // First try Eloquent (Jenssegers) create
        try {
            return Sample::create($data);
        } catch (Throwable $e) {
            Log::warning('Eloquent create failed; attempting native driver', [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
            ]);

            // Fallback: native MongoDB driver using DSN from config
            $dsn = config('database.connections.mongodb.dsn');
            $dbName = config('database.connections.mongodb.database', 'admin');

            if (!extension_loaded('mongodb') || empty($dsn)) {
                // Re-throw to let controller degrade gracefully
                throw $e;
            }

            try {
                $client = new Client($dsn);
                $result = $client
                    ->selectDatabase($dbName)
                    ->selectCollection('samples')
                    ->insertOne($data);

                // Return a plain array including the inserted _id for controller to serialize
                $insertedId = method_exists($result, 'getInsertedId') ? (string) $result->getInsertedId() : null;
                // @phpstan-ignore-next-line
                return new class($data, $insertedId) {
                    public function __construct(private array $data, private ?string $id) {}
                    public function toArray(): array {
                        return $this->id ? array_merge($this->data, ['_id' => $this->id]) : $this->data;
                    }
                };
            } catch (Throwable $e2) {
                Log::error('Native MongoDB insert failed', [
                    'exception' => get_class($e2),
                    'message' => $e2->getMessage(),
                ]);
                throw $e2;
            }
        }
    }
}