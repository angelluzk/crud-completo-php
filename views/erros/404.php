<?php
// Define o título da página para o layout
$titulo = 'Página Não Encontrada';

// Define o código de status HTTP correto, essencial para SEO e APIs
http_response_code(404);
?>

<div class="flex flex-col items-center justify-center py-12">
    <div class="text-center">
        <p class="text-6xl font-bold text-blue-600">404</p>
        <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">Página não encontrada</h1>
        <p class="mt-6 text-base leading-7 text-gray-600">
            <?= $this->e($message ?? 'Desculpe, não conseguimos encontrar a página que você está procurando.') ?>
        </p>
        <div class="mt-10">
            <a href="/" class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-sm">
                Voltar para a página inicial
            </a>
        </div>
    </div>
</div>