<?php
$titulo = 'Lista de Usuários';
?>

<h1 class="text-3xl font-bold mb-6 text-gray-800">Usuários</h1>

<div class="mb-6">
    <a href="<?= rtrim($_ENV['APP_URL'], '/') ?>/usuarios/criar" class="inline-block px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition-colors">
        Criar Novo Usuário
    </a>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white border">
        <thead class="bg-gray-200">
            <tr>
                <th class="border p-3 text-left text-sm font-semibold text-gray-700">ID</th>
                <th class="border p-3 text-left text-sm font-semibold text-gray-700">Nome</th>
                <th class="border p-3 text-left text-sm font-semibold text-gray-700">Email</th>
                <th class="border p-3 text-center text-sm font-semibold text-gray-700">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($usuarios)): ?>
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-600">Nenhum usuário encontrado.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr class="hover:bg-gray-50 border-t">
                        <td class="border-b p-3"><?= $this->e($usuario->getId()) ?></td>
                        <td class="border-b p-3"><?= $this->e($usuario->getNome()) ?></td>
                        <td class="border-b p-3"><?= $this->e($usuario->getEmail()) ?></td>
                        <td class="border-b p-3 text-center">
                            <a href="<?= rtrim($_ENV['APP_URL'], '/') ?>/usuarios/editar/<?= $this->e($usuario->getId()) ?>" class="inline-block px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-bold rounded-md transition-colors">Editar</a>
                            
                            <form action="<?= rtrim($_ENV['APP_URL'], '/') ?>/usuarios/deletar/<?= $this->e($usuario->getId()) ?>" method="POST" class="inline-block ml-2" onsubmit="return confirm('Tem certeza que deseja deletar este usuário?');">
                                <?= App\Core\Csrf::inputField() ?>
                                <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-md transition-colors">Deletar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>