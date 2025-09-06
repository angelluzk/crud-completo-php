<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Editar Usuário</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Editar Usuário</h1>

    <?php if (!empty($_SESSION['errors'])): ?>
      <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
        <?php foreach ($_SESSION['errors'] as $err): ?>
          <div><?= htmlspecialchars($err) ?></div>
        <?php endforeach; unset($_SESSION['errors']); ?>
      </div>
    <?php endif; ?>

    <form action="/usuarios/atualizar/<?= htmlspecialchars($usuario['id']); ?>" method="POST" class="space-y-4" novalidate>
      <?= \App\Core\Csrf::inputField() ?>
      <div>
        <label for="nome" class="block mb-1 font-semibold">Nome</label>
        <input id="nome" type="text" name="nome" value="<?= htmlspecialchars($_SESSION['old']['nome'] ?? $usuario['nome']) ?>" class="w-full border p-2 rounded" required>
      </div>
      <div>
        <label for="email" class="block mb-1 font-semibold">Email</label>
        <input id="email" type="email" name="email" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? $usuario['email']) ?>" class="w-full border p-2 rounded" required>
      </div>
      <div>
        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded">Atualizar</button>
        <a href="/usuarios" class="ml-2 text-sm text-gray-600">Cancelar</a>
      </div>
    </form>
  </div>
</body>
</html>
