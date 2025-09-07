<?php
namespace App\Core;

use function FastRoute\cachedDispatcher;
use FastRoute\Dispatcher;

class Router
{
    /** @var callable */
    private $routesCallback;
    private ?Dispatcher $dispatcher = null;

    public function __construct(callable $routesCallback)
    {
        $this->routesCallback = $routesCallback;
    }

    public function dispatch(string $httpMethod, string $uri): array
    {
        if ($this->dispatcher === null) {
            $cacheFile = __DIR__ . '/../../storage/cache/route.cache';
            
            $options = [
                'cacheFile'     => $cacheFile,
                'cacheDisabled' => ($_ENV['APP_ENV'] ?? 'production') === 'development',
            ];

            $this->dispatcher = cachedDispatcher($this->routesCallback, $options);
        }

        return $this->dispatcher->dispatch($httpMethod, $uri);
    }
}
?>