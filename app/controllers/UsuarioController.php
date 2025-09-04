<?php
require_once __DIR__ . '/../models/Usuario.php';

class UsuarioController {
    private $model;

    public function __construct() {
        $this->model = new Usuario();
    }

    public function index() {
        $usuarios = $this->model->listar();
        require __DIR__ . '/../views/usuario/index.php';
    }

    public function criar() {
        require __DIR__ . '/../views/usuario/criar.php';
    }

    public function armazenar($dados) {
        $this->model->criar($dados);
        header('Location: /');
    }

    public function editar($id) {
        $usuario = $this->model->buscarPorId($id);
        require __DIR__ . '/../views/usuario/editar.php';
    }

    public function atualizar($id, $dados) {
        $this->model->atualizar($id, $dados);
        header('Location: /');
    }

    public function deletar($id) {
        $this->model->deletar($id);
        header('Location: /');
    }
}
?>