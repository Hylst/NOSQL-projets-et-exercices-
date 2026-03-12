<?php

echo "<h1>🔍 DEBUG API</h1>";

echo "<h2>1. Autoloader</h2>";
$autoloader = __DIR__ . '/vendor/autoload.php';
echo "Chemin: $autoloader<br>";
echo "Existe: " . (file_exists($autoloader) ? '✅ OUI' : '❌ NON') . "<br>";

if (file_exists($autoloader)) {
    require $autoloader;
    echo "Chargé: ✅<br>";
}

echo "<h2>2. Classes disponibles</h2>";
echo "App\\Database\\MongoConnection: " . (class_exists('App\Database\MongoConnection') ? '✅' : '❌') . "<br>";
echo "App\\Models\\Pizza: " . (class_exists('App\Models\Pizza') ? '✅' : '❌') . "<br>";
echo "App\\Controllers\\PizzaController: " . (class_exists('App\Controllers\PizzaController') ? '✅' : '❌') . "<br>";

echo "<h2>3. MongoDB Extension</h2>";
echo "Extension MongoDB: " . (extension_loaded('mongodb') ? '✅ Loaded' : '❌ Not loaded') . "<br>";

echo "<h2>4. Test MongoDB Connection</h2>";
try {
    $conn = \App\Database\MongoConnection::getInstance();
    $db = $conn->getDatabase('pizzeria');
    $collections = $db->listCollections();
    echo "Connexion MongoDB: ✅ OK<br>";
    echo "Collections: " . implode(', ', array_map(fn($c) => $c->getName(), iterator_to_array($collections))) . "<br>";
} catch (\Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "<br>";
}

echo "<h2>5. Test API Call</h2>";
try {
    $controller = new \App\Controllers\PizzaController();
    $result = $controller->getAll([]);
    echo "getAll() returned: " . json_encode($result) . "<br>";
} catch (\Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "<br>";
}

echo "<h2>6. Environment</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "OS: " . php_uname() . "<br>";
echo "Memory Limit: " . ini_get('memory_limit') . "<br>";
