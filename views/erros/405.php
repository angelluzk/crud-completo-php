<?php
$titulo = 'Método Não Permitido';
http_response_code(405);
?>

<div class="flex flex-col items-center justify-center py-12">
    <div class="text-center">
        <p class="text-6xl font-bold text-yellow-500">405</p>
        <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">Método não permitido</h1>
        <p class="mt-6 text-base leading-7 text-gray-600">
            <?= $this->e($message ?? 'O método HTTP utilizado não é permitido para este recurso.') ?>
        </p>
        <div class="mt-10">
            <a href="javascript:history.back()" class="px-5 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-md shadow-sm">
                Voltar para a página anterior
            </a>
        </div>
    </div>
</div>