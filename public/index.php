<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\View;
use App\Core\Validator;
use App\Config\Database;
use App\Repositories\UsuarioRepository;
use App\Controllers\UsuarioController;
use App\Core\Logger;

session_start();

// Carrega .env (raiz do projeto)
Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

$debugMode = ($_ENV['APP_ENV'] ?? 'production') === 'development';
ini_set('display_errors', $debugMode ? '1' : '0');
ini_set('log_errors', '1');

$view = new View();

try {
    // Conexão e dependências
    $conn = Database::getConnection();
    $validator = new Validator();
    $repository = new UsuarioRepository($conn);
    $controller = new UsuarioController($repository, $validator, $view);

    // Define rotas usando Router wrapper
    $router = new Router(function(\FastRoute\RouteCollector $r) {
        $r->get('/usuarios', [UsuarioController::class, 'index']);
        $r->get('/usuarios/criar', [UsuarioController::class, 'criar']);
        $r->post('/usuarios', [UsuarioController::class, 'armazenar']);
        $r->get('/usuarios/editar/{id:\d+}', [UsuarioController::class, 'editar']);
        $r->post('/usuarios/atualizar/{id:\d+}', [UsuarioController::class, 'atualizar']);
        $r->post('/usuarios/{id:\d+}/deletar', [UsuarioController::class, 'deletar']);
        // rota raiz redireciona para usuários
        $r->get('/', function() {
            header('Location: /usuarios');
            exit;
        });
    });

    $httpMethod = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];
    if (false !== $pos = strpos($uri, '?')) {
        $uri = substr($uri, 0, $pos);
    }
    $uri = rawurldecode($uri);

    $routeInfo = $router->dispatch($httpMethod, $uri);

    switch ($routeInfo[0]) {
        case \FastRoute\Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $vars = $routeInfo[2] ?? [];

            // Se handler é callable (closure), executa diretamente
            if (is_callable($handler)) {
                call_user_func_array($handler, array_values($vars));
                break;
            }

            // Caso handler seja [ControllerClass, 'method']
            [$classOrInstance, $method] = $handler;

            // Converte valores numéricos para int antes de passar ao controller
            $typedVars = array_map(function($v) {
                return ctype_digit($v) ? (int) $v : $v;
            }, array_values($vars));

            call_user_func_array([$controller, $method], $typedVars);
            break;

        case \FastRoute\Dispatcher::NOT_FOUND:
            http_response_code(404);
            $view->render('errors/404', ['message' => 'Página não encontrada']);
            break;

        case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            http_response_code(405);
            $view->render('errors/405', ['message' => 'Método não permitido']);
            break;
    }

} catch (\Throwable $e) {
    Logger::error($e->getMessage() . "\n" . $e->getTraceAsString());
    http_response_code(500);
    $errorMessage = $debugMode
        ? '<pre>' . htmlspecialchars($e->getMessage()) . "\n" . htmlspecialchars($e->getTraceAsString()) . '</pre>'
        : 'Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.';
    // tenta renderizar 500; se a view estiver faltando, exibe mensagem simples
    try {
        $view->render('errors/500', ['message' => $errorMessage]);
    } catch (\Throwable $inner) {
        echo $errorMessage;
    }
}
