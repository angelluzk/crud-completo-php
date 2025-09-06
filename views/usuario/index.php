<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Usuários</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-3xl font-bold mb-4">Usuários</h1>

    <?php if (!empty($_SESSION['success'])): ?>
      <div class="bg-green-100 text-green-800 p-3 rounded mb-4"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
      <div class="bg-red-100 text-red-800 p-3 rounded mb-4"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <a href="/usuarios/criar" class="inline-block mb-4 px-4 py-2 bg-blue-500 text-white rounded">Criar Usuário</a>

    <table class="w-full border-collapse" aria-describedby="usuarios-table">
      <thead>
        <tr>
          <th class="border p-2 text-left">ID</th>
          <th class="border p-2 text-left">Nome</th>
          <th class="border p-2 text-left">Email</th>
          <th class="border p-2">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($usuarios)): ?>
          <tr><td colspan="4" class="p-4 text-center text-gray-600">Nenhum usuário encontrado.</td></tr>
        <?php else: ?>
          <?php foreach ($usuarios as $usuario): ?>
            <tr class="hover:bg-gray-50">
              <td class="border p-2"><?= htmlspecialchars($usuario['id']); ?></td>
              <td class="border p-2"><?= htmlspecialchars($usuario['nome']); ?></td>
              <td class="border p-2"><?= htmlspecialchars($usuario['email']); ?></td>
              <td class="border p-2">
                <a href="/usuarios/editar/<?= $usuario['id']; ?>" class="px-2 py-1 bg-yellow-500 text-white rounded">Editar</a>
                <form action="/usuarios/<?= $usuario['id']; ?>/deletar" method="POST" class="inline">
                  <?= \App\Core\Csrf::inputField() ?>
                  <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded" onclick="return confirm('Tem certeza que deseja deletar?')">Deletar</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
