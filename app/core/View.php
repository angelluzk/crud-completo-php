<?php
namespace App\Core;

class View
{
    protected string $layout = 'app';

    public function setLayout(string $layout): self
    {
        $this->layout = $layout;
        return $this;
    }

    public function render(string $view, array $data = []): void
    {
        $viewFile = __DIR__ . '/../../views/' . $view . '.php';
        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View não encontrada: {$view}");
        }

        $layoutFile = __DIR__ . '/../../views/layout/' . $this->layout . '.php';
        if (!file_exists($layoutFile)) {
            throw new \RuntimeException("Layout não encontrado: {$this->layout}");
        }
        
        ob_start();
        extract($data, EXTR_SKIP);
        require $viewFile;
        $content = ob_get_clean();

        require $layoutFile;
    }

    public function e(?string $data): string
    {
        return htmlspecialchars($data ?? '', ENT_QUOTES, 'UTF-8');
    }
}
?>