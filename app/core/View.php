<?php
namespace App\Core;

/**
 * View renderer simples.
 * Método de instância (não estático) para permitir injeção e testes.
 */
class View
{
    /**
     * Renderiza a view (extrai $data para variáveis).
     *
     * @param string $view Caminho relativo dentro de views/ (ex: 'usuario/index')
     * @param array $data Dados a serem extraídos
     *
     * @throws \RuntimeException se a view não existir
     */
    public function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $file = __DIR__ . '/../../views/' . $view . '.php';

        if (!file_exists($file)) {
            throw new \RuntimeException("View não encontrada: {$view}");
        }

        require $file;
    }
}
?>