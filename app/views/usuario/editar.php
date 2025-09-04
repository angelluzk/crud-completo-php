<?php if(!isset($usuario)) exit('Usuário não encontrado'); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
<div class="container mx-auto mt-10 max-w-lg">
    <h1 class="text-3xl font-bold mb-6 text-center">Editar Usuário</h1>
    <form action="/?acao=atualizar&id=<?= $usuario['id'] ?>" method="POST" class="bg-white p-6 rounded shadow-md">
        <div class="mb-4">
            <label for="nome" class="block text-gray-700 font-semibold mb-2">Nome:</label>
            <input type="text" name="nome" id="nome" required value="<?= htmlspecialchars($usuario['nome']) ?>" class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold mb-2">Email:</label>
            <input type="email" name="email" id="email" required value="<?= htmlspecialchars($usuario['email']) ?>" class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500">
        </div>
        <div class="flex justify-between">
            <a href="/?acao=index" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 transition">Cancelar</a>
            <button type="submit" class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500 transition">Atualizar</button>
        </div>
    </form>
</div>
</body>
</html>
