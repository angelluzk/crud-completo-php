<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($titulo ?? 'Meu App CRUD') ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-gray-100">

    <div class="max-w-5xl mx-auto p-6">
        <div class="bg-white p-8 rounded-lg shadow-md">
            
            <header class="mb-8">
                <h1 class="text-4xl font-bold text-gray-800">Projeto CRUD</h1>
                <nav class="mt-2">
                    <a href="<?= url('/usuarios') ?>" class="text-blue-600 hover:underline">Listar Usuários</a>
                    <span class="mx-2 text-gray-300">|</span>
                    <a href="<?= url('/usuarios/criar') ?>" class="text-blue-600 hover:underline">Criar Novo Usuário</a>
                </nav>
            </header>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p><?= $this->e($_SESSION['success']) ?></p>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p><?= $this->e($_SESSION['error']) ?></p>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <main>
                <?= $content ?>
            </main>

        </div>
        <footer class="text-center text-sm text-gray-500 mt-6">
            <p>CRUD Completo em PHP - &copy; <?= date('Y') ?></p>
        </footer>
    </div>

</body>
</html>