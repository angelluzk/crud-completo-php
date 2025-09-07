<?php
declare(strict_types=1);

// 1. BOOTSTRAPPING
require_once __DIR__ . '/../vendor/autoload.php';
session_start();
Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

$debugMode = ($_ENV['APP_ENV'] ?? 'production') === 'development';
ini_set('display_errors', $debugMode ? '1' : '0');
ini_set('log_errors', '1');

use App\Core\Logger;
use App\Core\Router;
use App\Core\View;
use App\Core\Validator;
use App\Config\Database;
use App\Repositories\UsuarioRepository;
use App\Controllers\UsuarioController;

// 2. CONTÊINER DE INJEÇÃO DE DEPENDÊNCIA (DI)
$container = [
    PDO::class => fn() => Database::getConnection(),
    View::class => fn() => new View(),
    Validator::class => fn($c) => new Validator($c[PDO::class]()),
    UsuarioRepository::class => fn($c) => new UsuarioRepository($c[PDO::class]()),
    UsuarioController::class => fn($c) => new UsuarioController(
        $c[UsuarioRepository::class]($c),
        $c[Validator::class]($c),
        $c[View::class]()
    ),
];

// 3. LÓGICA DA APLICAÇÃO
try {
    $router = new Router(function(\FastRoute\RouteCollector $r) {
        $r->get('/', function() { redirect('/usuarios'); });
        
        $r->addGroup('/usuarios', function (\FastRoute\RouteCollector $r) {
            $r->get('', [UsuarioController::class, 'index']);
            $r->get('/criar', [UsuarioController::class, 'criar']);
            $r->post('', [UsuarioController::class, 'armazenar']);
            $r->get('/editar/{id:\d+}', [UsuarioController::class, 'editar']);
            $r->post('/atualizar/{id:\d+}', [UsuarioController::class, 'atualizar']);
            $r->post('/deletar/{id:\d+}', [UsuarioController::class, 'deletar']);
        });
    });

    $httpMethod = $_SERVER['REQUEST_METHOD'];
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $basePath = parse_url($_ENV['APP_URL'], PHP_URL_PATH) ?? '';

    if ($basePath && strpos($uri, $basePath) === 0) {
        $uri = substr($uri, strlen($basePath));
    }
    $uri = rawurldecode($uri ?: '/');

    $routeInfo = $router->dispatch($httpMethod, $uri);

    switch ($routeInfo[0]) {
        case \FastRoute\Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $vars = $routeInfo[2] ?? [];

            if (is_callable($handler)) {
                call_user_func_array($handler, $vars);
                break;
            }

            [$controllerClass, $method] = $handler;
            $controller = $container[$controllerClass]($container);
            $typedVars = array_map(fn($v) => ctype_digit($v) ? (int) $v : $v, $vars);
            call_user_func_array([$controller, $method], $typedVars);
            break;

        case \FastRoute\Dispatcher::NOT_FOUND:
            http_response_code(404);
            $container[View::class]()->render('erros/404');
            break;

        case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            http_response_code(405);
            $container[View::class]()->render('erros/405');
            break;
    }

} catch (\Throwable $e) {
    Logger::error($e->getMessage() . "\n" . $e->getTraceAsString());
    http_response_code(500);
    $errorMessage = $debugMode
        ? '<pre>' . htmlspecialchars($e->getMessage()) . "\n" . htmlspecialchars($e->getTraceAsString()) . '</pre>'
        : 'Ocorreu um erro inesperado.';
    
    try {
        (new View())->render('erros/500', ['message' => $errorMessage]);
    } catch (\Throwable $inner) {
        header('Content-Type: text/html; charset=UTF-8');
        echo $errorMessage;
    }
}
?>