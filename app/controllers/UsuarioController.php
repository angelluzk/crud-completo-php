<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Validator;
use App\Core\Csrf;
use App\Repositories\UsuarioRepository;
use Throwable;

/**
 * Controller para CRUD de Usuários.
 * - Usa Validator para validação
 * - Usa Csrf::validate para proteger formulários POST
 */
class UsuarioController
{
    private UsuarioRepository $repository;
    private Validator $validator;
    private View $view;

    public function __construct(UsuarioRepository $repository, Validator $validator, View $view)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->view = $view;
    }

    public function index(): void
    {
        $usuarios = $this->repository->all();
        $this->view->render('usuario/index', ['usuarios' => $usuarios]);
    }

    public function criar(): void
    {
        $this->view->render('usuario/criar');
    }

    public function armazenar(): void
    {
        // valida CSRF
        if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Token CSRF inválido. Tente novamente.';
            header('Location: /usuarios/criar');
            exit;
        }

        $data = [
            'nome' => trim($_POST['nome'] ?? ''),
            'email' => trim($_POST['email'] ?? '')
        ];

        $this->validator->setData($data)->required('nome', 'email')->email('email');
        if (!$this->validator->passed()) {
            $_SESSION['errors'] = $this->validator->errors();
            $_SESSION['old'] = $data;
            header('Location: /usuarios/criar');
            exit;
        }

        $this->repository->create($data);
        $_SESSION['success'] = 'Usuário criado com sucesso!';
        header('Location: /usuarios');
        exit;
    }

    public function editar(int $id): void
    {
        $usuario = $this->repository->find($id);
        if (!$usuario) {
            $_SESSION['error'] = 'Usuário não encontrado.';
            header('Location: /usuarios');
            exit;
        }
        $this->view->render('usuario/editar', ['usuario' => $usuario]);
    }

    public function atualizar(int $id): void
    {
        if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Token CSRF inválido. Tente novamente.';
            header("Location: /usuarios/editar/{$id}");
            exit;
        }

        $data = [
            'nome' => trim($_POST['nome'] ?? ''),
            'email' => trim($_POST['email'] ?? '')
        ];

        $this->validator->setData($data)->required('nome', 'email')->email('email');
        if (!$this->validator->passed()) {
            $_SESSION['errors'] = $this->validator->errors();
            $_SESSION['old'] = $data;
            header("Location: /usuarios/editar/{$id}");
            exit;
        }

        $existing = $this->repository->find($id);
        if (!$existing) {
            $_SESSION['error'] = 'Usuário não encontrado.';
            header('Location: /usuarios');
            exit;
        }

        $this->repository->update($id, $data);
        $_SESSION['success'] = 'Usuário atualizado com sucesso!';
        header('Location: /usuarios');
        exit;
    }

    public function deletar(int $id): void
    {
        if (!Csrf::validate($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Token CSRF inválido. Tente novamente.';
            header('Location: /usuarios');
            exit;
        }

        $this->repository->delete($id);
        $_SESSION['success'] = 'Usuário deletado com sucesso!';
        header('Location: /usuarios');
        exit;
    }
}
?>