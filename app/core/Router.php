<?php
namespace App\Core;

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

/**
 * Router wrapper para registrar rotas de forma limpa e despachar.
 */
class Router
{
    private $routesCallback;

    public function __construct(callable $routesCallback)
    {
        $this->routesCallback = $routesCallback;
    }

    /**
     * @return array Resultado do dispatch do FastRoute
     */
    public function dispatch(string $httpMethod, string $uri): array
    {
        $dispatcher = simpleDispatcher($this->routesCallback);
        return $dispatcher->dispatch($httpMethod, $uri);
    }
}
?>