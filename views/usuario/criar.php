<?php
$titulo = 'Criar Novo Usuário';
$errors = $errors ?? [];
$old = $old ?? [];
?>

<h1 class="text-3xl font-bold mb-6 text-gray-800">Criar Novo Usuário</h1>

<form action="<?= rtrim($_ENV['APP_URL'], '/') ?>/usuarios" method="POST" class="space-y-6">
    <?= App\Core\Csrf::inputField() ?>

    <div>
        <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
        <div class="mt-1">
            <input type="text" id="nome" name="nome" value="<?= $this->e($old['nome'] ?? '') ?>" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
        </div>
        <?php if (isset($errors['nome'])): ?>
            <p class="mt-2 text-sm text-red-600"><?= $this->e($errors['nome']) ?></p>
        <?php endif; ?>
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
        <div class="mt-1">
            <input type="email" id="email" name="email" value="<?= $this->e($old['email'] ?? '') ?>" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
        </div>
        <?php if (isset($errors['email'])): ?>
            <p class="mt-2 text-sm text-red-600"><?= $this->e($errors['email']) ?></p>
        <?php endif; ?>
    </div>

    <div class="flex items-center space-x-4">
        <button type="submit" class="inline-block px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-md transition-colors">Salvar</button>
        <a href="<?= rtrim($_ENV['APP_URL'], '/') ?>/usuarios" class="inline-block px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold rounded-md transition-colors">Cancelar</a>
    </div>
</form>