<?php
require_once __DIR__ . '/../app/controllers/UsuarioController.php';

$controller = new UsuarioController();
$acao = $_GET['acao'] ?? 'index';
$id = $_GET['id'] ?? null;

switch($acao) {
    case 'index':
        $controller->index();
        break;
    case 'criar':
        $controller->criar();
        break;
    case 'armazenar':
        $controller->armazenar($_POST);
        break;
    case 'editar':
        $controller->editar($id);
        break;
    case 'atualizar':
        $controller->atualizar($id, $_POST);
        break;
    case 'deletar':
        $controller->deletar($id);
        break;
    default:
        echo "Página não encontrada!";
}
?>