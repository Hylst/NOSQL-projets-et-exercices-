<?php

namespace App\Models;

use App\Database\MongoConnection;
use MongoDB\BSON\ObjectId;

class Pizza
{
    private $collection;

    public function __construct()
    {
        $this->collection = MongoConnection::getInstance()->getCollection('pizzas');
    }

    /**
     * Créer une nouvelle pizza
     */
    public function create(array $data): string
    {
        $result = $this->collection->insertOne($data);
        return (string)$result->getInsertedId();
    }

    /**
     * Récupérer toutes les pizzas avec pagination
     */
    public function getAll(int $limit = 10, int $skip = 0): array
    {
        $pizzas = $this->collection->find(
            [],
            [
                'limit' => $limit,
                'skip' => $skip,
                'sort' => ['_id' => -1]
            ]
        )->toArray();

        return array_map(fn($pizza) => $this->formatPizza($pizza), $pizzas);
    }

    /**
     * Récupérer une pizza par ID
     */
    public function getById(string $id): ?array
    {
        try {
            $pizza = $this->collection->findOne(['_id' => new ObjectId($id)]);
            return $pizza ? $this->formatPizza($pizza) : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Mettre à jour une pizza
     */
    public function update(string $id, array $data): bool
    {
        try {
            $result = $this->collection->updateOne(
                ['_id' => new ObjectId($id)],
                ['$set' => $data],
                ['upsert' => false]
            );
            return $result->getModifiedCount() > 0 || $result->getUpsertedCount() > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Supprimer une pizza
     */
    public function delete(string $id): bool
    {
        try {
            $result = $this->collection->deleteOne(['_id' => new ObjectId($id)]);
            return $result->getDeletedCount() > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Compter les documents
     */
    public function count(array $filter = []): int
    {
        return $this->collection->countDocuments($filter);
    }

    /**
     * Recherche avancée
     */
    public function search(array $criteria): array
    {
        $pizzas = $this->collection->find($criteria)->toArray();
        return array_map(fn($pizza) => $this->formatPizza($pizza), $pizzas);
    }

    /**
     * Formater le document MongoDB pour la réponse
     */
    private function formatPizza($pizza): array
    {
        return [
            'id' => (string)$pizza['_id'],
            'name' => $pizza['name'] ?? null,
            'description' => $pizza['description'] ?? null,
            'price' => $pizza['price'] ?? null,
            'ingredients' => $pizza['ingredients'] ?? [],
            'created_at' => isset($pizza['created_at']) ? $pizza['created_at']->toDateTime()->format('Y-m-d H:i:s') : null,
        ];
    }
}
