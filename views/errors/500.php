<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>500 - Erro</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <div class="text-center">
    <h1 class="text-6xl font-bold text-red-600">500</h1>
    <p class="mt-4 text-lg text-gray-700"><?= $message ?? 'Ocorreu um erro inesperado.'; ?></p>
    <a href="/usuarios" class="mt-6 inline-block px-4 py-2 bg-blue-500 text-white rounded">Voltar</a>
  </div>
</body>
</html>
