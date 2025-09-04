<?php if(!isset($usuarios)) $usuarios = []; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-bold mb-6 text-center">Usuários Cadastrados</h1>
    <div class="flex justify-end mb-4">
        <a href="/?acao=criar" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition">Adicionar Usuário</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm">
                <tr>
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Nome</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Criado em</th>
                    <th class="py-3 px-6 text-left">Atualizado em</th>
                    <th class="py-3 px-6 text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($usuarios as $usuario): ?>
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-3 px-6"><?= $usuario['id'] ?></td>
                    <td class="py-3 px-6"><?= $usuario['nome'] ?></td>
                    <td class="py-3 px-6"><?= $usuario['email'] ?></td>
                    <td class="py-3 px-6"><?= date('d/m/Y H:i', strtotime($usuario['criado_em'])) ?></td>
                    <td class="py-3 px-6"><?= date('d/m/Y H:i', strtotime($usuario['atualizado_em'])) ?></td>
                    <td class="py-3 px-6 flex space-x-2">
                        <a href="/?acao=editar&id=<?= $usuario['id'] ?>" class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 transition">Editar</a>
                        <a href="/?acao=deletar&id=<?= $usuario['id'] ?>" onclick="return confirm('Deseja realmente excluir?')" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($usuarios)): ?>
                <tr>
                    <td colspan="6" class="py-4 px-6 text-center text-gray-500">Nenhum usuário cadastrado</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
