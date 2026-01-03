<?php

// Router simple para FuranchoFinder (sin dependencias externas)

define('APP_PATH', __DIR__ . '/../app/');
define('DATA_PATH', APP_PATH . 'Data/');

// Rutas simples
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_uri = str_replace('/index.php', '', $request_uri);

// CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Rutas
if ($request_uri === '/' || $request_uri === '') {
    // Página principal
    header('Content-Type: text/html; charset=UTF-8');
    include APP_PATH . 'Views/home.php';
} elseif (preg_match('/^\/api\/furanchos$/', $request_uri)) {
    // GET todos los furanchos
    header('Content-Type: application/json');
    $furanchos = json_decode(file_get_contents(DATA_PATH . 'furanchos.json'), true);
    echo json_encode($furanchos);
} elseif (preg_match('/^\/api\/furanchos\/(\d+)$/', $request_uri, $matches)) {
    // GET furancho por ID
    header('Content-Type: application/json');
    $id = (int)$matches[1];
    $furanchos = json_decode(file_get_contents(DATA_PATH . 'furanchos.json'), true);
    foreach ($furanchos as $furancho) {
        if ($furancho['id'] === $id) {
            echo json_encode($furancho);
            exit;
        }
    }
    http_response_code(404);
    echo json_encode(['error' => 'Furancho no encontrado']);
} elseif (preg_match('/^\/api\/users$/', $request_uri)) {
    // GET todos los usuarios (sin contraseñas)
    header('Content-Type: application/json');
    $users = json_decode(file_get_contents(DATA_PATH . 'users.json'), true);
    foreach ($users as &$user) {
        unset($user['password']);
    }
    echo json_encode($users);
} elseif (preg_match('/^\/api\/users\/(\d+)$/', $request_uri, $matches)) {
    // GET usuario por ID (sin contraseña)
    header('Content-Type: application/json');
    $id = (int)$matches[1];
    $users = json_decode(file_get_contents(DATA_PATH . 'users.json'), true);
    foreach ($users as $user) {
        if ($user['id'] === $id) {
            unset($user['password']);
            echo json_encode($user);
            exit;
        }
    }
    http_response_code(404);
    echo json_encode(['error' => 'Usuario no encontrado']);
} elseif ($request_uri === '/api/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Login
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';
    
    $users = json_decode(file_get_contents(DATA_PATH . 'users.json'), true);
    foreach ($users as $user) {
        if ($user['username'] === $username && $password === 'demo123') {
            unset($user['password']);
            echo json_encode(['success' => true, 'user' => $user, 'token' => 'demo_token_' . $user['id']]);
            exit;
        }
    }
    http_response_code(401);
    echo json_encode(['error' => 'Credenciales inválidas']);
} elseif (preg_match('/^\/css\//', $request_uri) || preg_match('/^\/js\//', $request_uri)) {
    // Archivos estáticos
    $file = __DIR__ . $request_uri;
    if (file_exists($file)) {
        if (preg_match('/\.css$/', $file)) {
            header('Content-Type: text/css');
        } elseif (preg_match('/\.js$/', $file)) {
            header('Content-Type: application/javascript');
        }
        readfile($file);
    } else {
        http_response_code(404);
        echo 'Archivo no encontrado';
    }
} else {
    http_response_code(404);
    header('Content-Type: text/html; charset=UTF-8');
    echo '<h1>404 - Página no encontrada</h1>';
}
