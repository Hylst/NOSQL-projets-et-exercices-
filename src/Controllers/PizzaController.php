<?php

namespace App\Controllers;

use App\Models\Pizza;

class PizzaController
{
    private Pizza $pizzaModel;

    public function __construct()
    {
        $this->pizzaModel = new Pizza();
    }

    /**
     * POST /api/pizzas - Créer une pizza
     */
    public function create(array $data): array
    {
        if (!$this->validatePizza($data)) {
            return [
                'status' => 400,
                'error' => 'Données invalides. Requis: name, price'
            ];
        }

        $data['created_at'] = new \MongoDB\BSON\UTCDateTime();
        $id = $this->pizzaModel->create($data);

        return [
            'status' => 201,
            'data' => [
                'id' => $id,
                'message' => 'Pizza créée avec succès'
            ]
        ];
    }

    /**
     * GET /api/pizzas - Récupérer toutes les pizzas
     */
    public function getAll(array $query): array
    {
        $limit = isset($query['limit']) ? (int)$query['limit'] : 10;
        $skip = isset($query['skip']) ? (int)$query['skip'] : 0;

        $limit = min($limit, 100);
        $skip = max($skip, 0);

        $pizzas = $this->pizzaModel->getAll($limit, $skip);
        $total = $this->pizzaModel->count();

        return [
            'status' => 200,
            'data' => [
                'pizzas' => $pizzas,
                'pagination' => [
                    'total' => $total,
                    'limit' => $limit,
                    'skip' => $skip,
                    'page' => floor($skip / $limit) + 1
                ]
            ]
        ];
    }

    /**
     * GET /api/pizzas/:id - Récupérer une pizza
     */
    public function getById(string $id): array
    {
        $pizza = $this->pizzaModel->getById($id);

        if (!$pizza) {
            return [
                'status' => 404,
                'error' => 'Pizza non trouvée'
            ];
        }

        return [
            'status' => 200,
            'data' => $pizza
        ];
    }

    /**
     * PUT /api/pizzas/:id - Mettre à jour une pizza
     */
    public function update(string $id, array $data): array
    {
        $pizza = $this->pizzaModel->getById($id);
        if (!$pizza) {
            return [
                'status' => 404,
                'error' => 'Pizza non trouvée'
            ];
        }

        $data['updated_at'] = new \MongoDB\BSON\UTCDateTime();
        $success = $this->pizzaModel->update($id, $data);

        if (!$success) {
            return [
                'status' => 400,
                'error' => 'Impossible de mettre à jour la pizza'
            ];
        }

        return [
            'status' => 200,
            'data' => ['message' => 'Pizza mise à jour avec succès']
        ];
    }

    /**
     * DELETE /api/pizzas/:id - Supprimer une pizza
     */
    public function delete(string $id): array
    {
        $success = $this->pizzaModel->delete($id);

        if (!$success) {
            return [
                'status' => 404,
                'error' => 'Pizza non trouvée'
            ];
        }

        return [
            'status' => 200,
            'data' => ['message' => 'Pizza supprimée avec succès']
        ];
    }

    /**
     * POST /api/pizzas/search - Recherche avancée
     */
    public function search(array $criteria): array
    {
        $pizzas = $this->pizzaModel->search($criteria);

        return [
            'status' => 200,
            'data' => [
                'pizzas' => $pizzas,
                'found' => count($pizzas)
            ]
        ];
    }

    /**
     * Valider les données d'une pizza
     */
    private function validatePizza(array $data): bool
    {
        return isset($data['name']) && 
               isset($data['price']) && 
               is_numeric($data['price']) &&
               $data['price'] > 0;
    }
}
