<?php

// Headers CORS EN PREMIER (avant toute sortie)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');

// Gestion des erreurs - retourner JSON au lieu de HTML
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    global $response;
    $response = [
        'status' => 500,
        'error' => 'Erreur interne',
        'message' => "$errstr (in $errfile:$errline)"
    ];
    http_response_code(500);
    echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
});

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Charger l'autoloader
if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    http_response_code(500);
    echo json_encode([
        'status' => 500,
        'error' => 'Composer autoloader non trouvé',
        'message' => 'Exécutez: composer install'
    ]);
    exit;
}

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\PizzaController;

// Parser l'URL
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_uri = str_replace('/api', '', $request_uri);
$method = $_SERVER['REQUEST_METHOD'];

// Router
$controller = new PizzaController();
$response = null;

try {
    // GET /pizzas
    if ($method === 'GET' && $request_uri === '/pizzas') {
        $response = $controller->getAll($_GET);
    }
    // GET /pizzas/{id}
    elseif ($method === 'GET' && preg_match('/^\/pizzas\/([a-f0-9]{24})$/i', $request_uri, $matches)) {
        $response = $controller->getById($matches[1]);
    }
    // POST /pizzas
    elseif ($method === 'POST' && $request_uri === '/pizzas') {
        $data = json_decode(file_get_contents('php://input'), true);
        $response = $controller->create($data ?? []);
    }
    // POST /pizzas/search
    elseif ($method === 'POST' && $request_uri === '/pizzas/search') {
        $data = json_decode(file_get_contents('php://input'), true);
        $response = $controller->search($data ?? []);
    }
    // PUT /pizzas/{id}
    elseif ($method === 'PUT' && preg_match('/^\/pizzas\/([a-f0-9]{24})$/i', $request_uri, $matches)) {
        $data = json_decode(file_get_contents('php://input'), true);
        $response = $controller->update($matches[1], $data ?? []);
    }
    // DELETE /pizzas/{id}
    elseif ($method === 'DELETE' && preg_match('/^\/pizzas\/([a-f0-9]{24})$/i', $request_uri, $matches)) {
        $response = $controller->delete($matches[1]);
    }
    else {
        $response = ['status' => 404, 'error' => 'Endpoint non trouvé'];
    }
} catch (\Exception $e) {
    $response = [
        'status' => 500,
        'error' => 'Erreur serveur',
        'message' => $e->getMessage()
    ];
}

// Envoyer la réponse
http_response_code($response['status'] ?? 500);
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
