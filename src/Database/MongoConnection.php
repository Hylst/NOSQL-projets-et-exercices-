<?php

namespace App\Database;

use MongoDB\Client;

/**
 * Singleton pour gérer la connexion MongoDB
 */
class MongoConnection
{
    private static ?self $instance = null;
    private Client $client;

    private function __construct()
    {
        $uri = getenv('MONGODB_URI') ?: 'mongodb://127.0.0.1:27017';
        $this->client = new Client($uri);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getDatabase(string $dbName = null)
    {
        $dbName = $dbName ?? (getenv('MONGODB_DB') ?: 'pizzeria');
        return $this->client->selectDatabase($dbName);
    }

    public function getCollection(string $collectionName, string $dbName = null)
    {
        return $this->getDatabase($dbName)->selectCollection($collectionName);
    }

    private function __clone() {}
    private function __wakeup() {}
}
